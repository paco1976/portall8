<?php

namespace App\Http\Controllers;

use App\Models\User_type;
use App\Models\Publicacion;
use App\Models\Publicacion_Whatsapp;
use App\Models\Publicacion_Visita;
use App\Models\User_Cfp;
use App\Models\User_Profile;
use App\Models\User;
use App\Models\Categoria;
use App\Models\Categoria_Tipo;
use App\Models\Interactionhead;
use App\Models\Interactionimage;
use App\Models\Interactionmessage;
use App\Models\Interactionsubjet;
Use App\Mail\ContactHome;
Use App\Mail\Interaction_notificacion_referente;
Use App\Mail\Interaction_notificacion_cliente;
Use App\Mail\Interaction_notificacion_profesional;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\TagRequest;
use Illuminate\Http\File;
use Intervention\Image\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Mail;

class PublicController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index(){
        //->orderby('fecha_evento')
        $categoria_servicios_all = Categoria::where(['categoria_tipo_id' => 1,'active' => 1])->get();
        //$categoria_servicios_all = Categoria::where(['categoria_tipo_id' => 1,'active' => 1])->orderby('name', 'ASC')->get();
        foreach($categoria_servicios_all as $categoria){
            $categoria->icon = Storage::disk('categorias')->url($categoria->icon);
            //dd($categoria);
        }

        $categoria_productos_all = Categoria::where(['categoria_tipo_id' => 2,'active' => 1])->get();
        //dd($categoria_productos_all);
        return view('welcome', compact('categoria_servicios_all', 'categoria_productos_all'));
    }


    public function publicaciones($id){
        
        $categoria = Categoria::where('id', $id)->first();
        
        $publicaciones_all = Publicacion::where(['categoria_id'=> $id, 'aprobado' => 1, 'active' => 1])->get();
        
        $publicacion_count = 0;
        foreach($publicaciones_all as $publicacion){
            $publicacion->users = $publicacion->users()->first();
            //$truncated = Str::limit('The quick brown fox jumps over the lazy dog', 20);
            //$limit = 5;
            $publicacion->description = Str::limit($publicacion->description, 30, ' ...');
            //dd($publicacion);
            if($publicacion->users->avatar == '/img/team/perfil_default.jpg'){
                //no convierte la url
            }else{
                $publicacion->users->avatar = Storage::disk('avatares')->url($publicacion->users->avatar);
                //disk('avatares')
            }
            
            $publicacion_count = $publicacion_count + 1;
        }
        //dd($publicaciones_all);
        $categoria_servicios_all = Categoria::where(['categoria_tipo_id' => 1,'active' => 1])->get();
        $categoria_productos_all = Categoria::where(['categoria_tipo_id' => 2,'active' => 1])->get();
        
        $user_type_all = User_type::all();
        $user_cfp_all = User_Cfp::all();
        

        return view('homepublicaciones', compact('categoria_servicios_all', 'categoria_productos_all',  'user_type_all','user_cfp_all', 'categoria', 'publicaciones_all', 'publicacion_count'));
    }

    public function publicacion_buscar(Request $request){
        $publicacion_count = 0;
        //buscador de description de publicaciones
        $publicaciones_all = Publicacion::Buscador($request->data)->get();
        if($publicaciones_all->count()>0){
        foreach($publicaciones_all as $publicacion){
            $publicacion->users = $publicacion->users()->first();
            $publicacion->description = Str::limit($publicacion->description, 30, ' ...');
            //dd($publicacion);
            if($publicacion->users->avatar == '/img/team/perfil_default.jpg'){
                //no convierte la url
            }else{
                $publicacion->users->avatar = Storage::disk('avatares')->url($publicacion->users->avatar);
                //disk('avatares')
            }
            
            $publicacion_count = $publicacion_count + 1;
        }
        //dd($publicaciones_all);
        $categoria_servicios_all = Categoria::where(['categoria_tipo_id' => 1,'active' => 1])->get();
        $categoria_productos_all = Categoria::where(['categoria_tipo_id' => 2,'active' => 1])->get();
        $user_type_all = User_type::all();
        $user_cfp_all = User_Cfp::all();
        return view('homepublicaciones_resultado', compact('categoria_servicios_all', 'categoria_productos_all',  'user_type_all','user_cfp_all', 'publicaciones_all', 'publicacion_count'));    
        }

        //buscador de nombre de categoría
        $categoria = Categoria::buscador($request->description)->first();
        if($categoria){
            $publicaciones_all = Publicacion::where(['categoria_id'=> $categoria->id, 'aprobado' => 1, 'active' => 1])->get();
            if($publicaciones_all->count()>0){
            foreach($publicaciones_all as $publicacion){
                $publicacion->users = $publicacion->users()->first();
                $publicacion->description = Str::limit($publicacion->description, 30, ' ...');
                //dd($publicacion);
                if($publicacion->users->avatar == '/img/team/perfil_default.jpg'){
                    //no convierte la url
                }else{
                    $publicacion->users->avatar = Storage::disk('avatares')->url($publicacion->users->avatar);
                    //disk('avatares')
                }
                
                $publicacion_count = $publicacion_count + 1;
            }
            //dd($publicaciones_all);
            $categoria_servicios_all = Categoria::where(['categoria_tipo_id' => 1,'active' => 1])->get();
            $categoria_productos_all = Categoria::where(['categoria_tipo_id' => 2,'active' => 1])->get();
            $user_type_all = User_type::all();
            $user_cfp_all = User_Cfp::all();
            return view('homepublicaciones_resultado', compact('categoria_servicios_all', 'categoria_productos_all',  'user_type_all','user_cfp_all', 'publicaciones_all', 'publicacion_count'));    
            }
        }
        //si no encuentra nada devuelvo esto
        $categoria_servicios_all = Categoria::where(['categoria_tipo_id' => 1,'active' => 1])->get();
        $categoria_productos_all = Categoria::where(['categoria_tipo_id' => 2,'active' => 1])->get();
        $user_type_all = User_type::all();
        $user_cfp_all = User_Cfp::all();
        return view('homepublicaciones_resultado', compact('categoria_servicios_all', 'categoria_productos_all',  'user_type_all','user_cfp_all', 'publicaciones_all', 'publicacion_count'));    

    }
    
    public function publicacion_profesional($id, Request $request){
        
        //FALTA QUE SUME UN VISTO CUANDO SE ACCEDE A LA PUBLICACIÓN

        $publicacion = Publicacion::where('id', $id)->first();
        $publicacion->view = $publicacion->view + 1;
        $publicacion->save(['view']);
        $visita = new Publicacion_Visita;
        $visita->publicacion_id = $publicacion->id;
        $visita->save();
        $publicacion->imagenes = $publicacion->imagenes()->get();
        $publicacion->cant_images = 0 ;
        $publicacion->titulos_asociados = $publicacion->titulos_asociados()->get();
        $subjets = Interactionsubjet::get();
        
        foreach($publicacion->imagenes as $imagen){
            $imagen->url = Storage::disk('publicaciones')->url($imagen->url);
            $publicacion->cant_images = $publicacion->cant_images + 1 ;
        }
        //dd($publicacion);
        $categoria = $publicacion->categoria()->first();
        $titulo = $publicacion->titulo()->first();
        $user = $publicacion->users()->first();
        //dd($user);
        if($user->avatar == '/img/team/perfil_default.jpg'){
            //no convierte la url
        }else{
            $user->avatar = Storage::disk('avatares')->url($user->avatar);
            //disk('avatares')
        }
        $user_profile = $user->user_profile()->first();
        $zonas = $user->zonas()->get();
        
        $categoria_servicios_all = Categoria::where(['categoria_tipo_id' => 1,'active' => 1])->get();
        $categoria_productos_all = Categoria::where(['categoria_tipo_id' => 2,'active' => 1])->get();

        $user_type_all = User_type::all();
        $user_cfp_all = User_Cfp::all();

        $info = $request->query('info', false);

        $whatsapp_url = "https://wa.me/549". $user_profile->mobile . "?text=Hola!%20Te%20contacto%20a%20través%20de%20CEFEPERES%20y%20te%20quería%20hacer%20una%20consulta!";
 
        $rating = $publicacion->rating();
        $show_rating = $publicacion->show_rating;
        $words = $publicacion->most_used_positive_words();

        return view('homeprofesional', compact('categoria_servicios_all', 'categoria_productos_all',  'user_type_all','user_cfp_all', 'publicacion','categoria', 'titulo', 'user', 'user_profile', 'zonas', 'subjets', 'info', 'whatsapp_url', 'rating', 'show_rating', 'words'));

    }

    public function publicacion_whatsapp($hash){

        $publicacion = Publicacion::where('hash', $hash)->first();
        $publicacion->view = $publicacion->view + 1;
        $publicacion->save(['view']);
        $visita = new Publicacion_Visita;
        $visita->publicacion_id = $publicacion->id;
        $visita->save();
        $publicacion->imagenes = $publicacion->imagenes()->get();
        $publicacion->cant_images = 0 ;
        $publicacion->titulos_asociados = $publicacion->titulos_asociados()->get();
        
        foreach($publicacion->imagenes as $imagen){
            $imagen->url = Storage::disk('publicaciones')->url($imagen->url);
            $publicacion->cant_images = $publicacion->cant_images + 1 ;
        }
        
        $categoria = $publicacion->categoria()->first();
        $titulo = $publicacion->titulo()->first();
        $user = $publicacion->users()->first();
        //dd($user);
        if($user->avatar == '/img/team/perfil_default.jpg'){
            
        }else{
            $user->avatar = Storage::disk('avatares')->url($user->avatar);
            
        }
        $user_profile = $user->user_profile()->first();
        $zonas = $user->zonas()->get();

        $user_type_all = User_type::all();
        $user_cfp_all = User_Cfp::all();

        return view('publicacion_whatsapp', compact('user_type_all','user_cfp_all', 'publicacion','categoria', 'titulo', 'user', 'user_profile', 'zonas'));

    }
    public function publicacion_whatsapp_save(){
        
        $data = request()->validate([
            'publicacion_hash' => 'required',
            'celular' => 'required',

        ],[
            'publicacion_hash.required' => 'Publicacion',
            'celular.required' =>'Debe escribir su celular',
        ]);

        $publicacion = Publicacion::where('hash', $data['publicacion_hash'])->first();
        $user = $publicacion->users()->first();
        $user_profile = $user->user_profile()->first();

        $whatsapp = new Publicacion_Whatsapp;
        $whatsapp->publicacion_id = $publicacion->id;
        $whatsapp->celular = $data['celular'];
        $whatsapp->save();

        $user_profile = $user->user_profile()->first();
        $url = "https://wa.me/549". $user_profile->mobile . "?text=Hola!%20Te%20Contacto%20de%20CEFEPERES%20y%20queria%20hacerte%20una%20consulta!";
        
        return redirect($url);

    }

    public function homeinteraction($hash){
        $interactionhead = Interactionhead::where('hash', $hash)->first();
        $mensajes_all = Interactionmessage::where('head_id', $interactionhead->id)->get();
        $publicacion = Publicacion::where('id', $interactionhead->publicacion_id)->first();
        //dd($publicacion);
        $publicacion->user = $publicacion->users()->first();
        $categoria = Categoria::where('id', $publicacion->categoria_id)->first();
        
        foreach($mensajes_all as $mensaje){
            $mensaje->imagenes = Interactionimage::where('message_id', $mensaje->id)->get();
            $mensaje->date = str_replace('/','-',  $mensaje->date );
            $mensaje->date = date('d-m-Y H:i:s', strtotime($mensaje->date));
            foreach($mensaje->imagenes as $imagen){
                $imagen->url = Storage::disk('interaction')->url($imagen->url);
            }
        }
        $categoria_servicios_all = Categoria::where(['categoria_tipo_id' => 1,'active' => 1])->get();
        $categoria_productos_all = Categoria::where(['categoria_tipo_id' => 2,'active' => 1])->get();

        return view('/homeinteraction', compact('interactionhead', 'mensajes_all', 'publicacion','categoria_servicios_all', 'categoria_productos_all'));

    }

    Public function interaction_publicacion($id){
        
        $data = request()->validate([
            'name' => 'required',
            'last_name' => 'required',
            'mobile' => 'required',
            'email' => 'required',
            'subjet' => 'required',
            'message' => 'required',
        ],[
            'name.required' =>'Debe escribir su nombre',
            'last_name.required' => 'Debe esecribir su apellido',
            'mobile.required' =>'Debe escribir su celular, ej: 11566778899',
            'email.required' =>'Debe completar el campo mail',
            'subjet.required' =>'Debe elegir un asunto',
            'message.required' =>'Por favor escriba el mensaje',
        ]);
        
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha = date("Y-m-d H:i:s");
        //creo el encabezao de la interaccion
        $interactionhead = Interactionhead::create([
            'publicacion_id' => $id,
            'subjet_id' => $data['subjet'],
            'date' => $fecha,
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
        ]);
        $interactionhead->hash = md5($interactionhead->id);
        $interactionhead->save(['hash']);


        //creo el mensaje de la interaccion
        $interactionmessage = Interactionmessage::create([
            'head_id' => $interactionhead->id,
            'date' => $fecha,
            'message' => $data['message'],
            'read' => false,
            'is_reply' => false,
        ]);

        $interactionmessage->hash = md5($interactionmessage->id);
        $interactionmessage->save(['hash']);

        //COMIENZA EL MANEJO DE LOS ARCHIVOS SI ES QUE SUBIERON ARCHIVOS
        if(request('file')){
            //dd(request('file'));
            //recupero todas las carpetas dentro de la ruta  publicaciones
            $carpetas = Storage::disk('interaction')->directories();
            //dd($carpetas);
            //pongo una vandera falsa
            $directorio_existe = false;
            //Ahora voy busco entre todas las carpeta si existe la de esta publicación
            //y pongo la bandera en true para avisar si exite
            foreach($carpetas as $carpeta){
                if($carpeta == $interactionmessage->id){   
                    $directorio_existe = true;
                }
            }
            
            // si no se encoentro el directorio id se crea y se sube ahí los achivos
            if($directorio_existe == false){
                //$resultado = Storage::makeDirectory('publicaciones/'. $publicacion->id, 0755, true);
                $resultado = Storage::disk('interaction')->makeDirectory($interactionmessage->id, 0777);
            }

            $extensiones=['jpg','png','bmp','svg','jpeg'];
            foreach(request('file') as $archivo) {

                $extension = $archivo->extension();
                $check = false;

                foreach($extensiones as $ext){
                    if($ext == $extension){
                        $check=true;

                    }
                }
                
                if($check==true){
                    $path = Storage::disk('interaction')->putFILE($interactionmessage->id, $archivo);
                    $size = Storage::disk('interaction')->size($path);
                    $name = $archivo->getClientOriginalName();
                    $interactionimage = interactionimage::create([
                        'message_id' => $interactionmessage->id,
                        'name' => $name,
                        'extension' => $extension,
                        'size' => $size,
                        'url' => $path,
                    ]);
                }

            }
        }

        //que necesito para el mail? 
        //1-la publicación id y categoría
        //2-la url de la interaccion
        //3-el profesional nombre y apellido
        //4-los datos quien envía!
        

        $publicacion = Publicacion::where('id', $id)->first();
        $user = $publicacion->users()->first();
        $cfp = $user->user_cfp()->first();
        $categoria = $publicacion->categoria()->first();
        $profesional = $publicacion->users()->first();

        $interactionhead->prof_name = $profesional->name;
        $interactionhead->prof_last_name = $profesional->last_name;
        $interactionhead->categoria = $categoria->name;
        $interactionhead->url = url('publicacion_mensajes/' . $interactionhead->hash);
        //$interactionhead->url = url('publicacion_mensajes/' . $interactionhead->id);

        
        //notificar al profesional
        Mail::to($user->email)->send(new Interaction_notificacion_profesional($interactionhead));
        // prueba de mail return new NewInteraction($interactionhead);

        
        //Referente - el referente tiene una url diferente
        $interactionhead->url = url('mensajes/' . $interactionhead->hash);

        Mail::to($cfp->email)->send(new Interaction_notificacion_referente($interactionhead));

        Session::flash('message', 'El mensaje se envió con éxito');
        
        return redirect()->route('homeprofesional', ['id' => $id]);
    }

    public function interaction_publicacion_respuesta(){
        
        $data = request()->validate([
            'interactionhead_id' => '',
            'respuesta' => '',

        ],[
            'respuesta.required' =>'Debe escribir un mensaje',
        ]);
        
        $interactionhead = Interactionhead::where('id', $data['interactionhead_id'])->first();
        /*
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        */
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha = date("Y-m-d H:i:s");
        $interactionmessage = Interactionmessage::create([
            'head_id' => $interactionhead->id,
            'date' => $fecha,
            'message' => $data['respuesta'],
            'read' => false,
            'is_reply' => false,
        ]);

        $interactionmessage->hash = md5($interactionmessage->id);
        $interactionmessage->save(['hash']);
        
        
         //COMIENZA EL MANEJO DE LOS ARCHIVOS SI ES QUE SUBIERON ARCHIVOS
         
         if(request('file')){
            $extensiones=['jpg','png','bmp','svg','jpeg'];
            //dd(request('file'));
            //recupero todas las carpetas dentro de la ruta  publicaciones
            $carpetas = Storage::disk('interaction')->directories();
            //dd($carpetas);
            //pongo una vandera falsa
            $directorio_existe = false;
            //Ahora voy busco entre todas las carpeta si existe la de esta publicación
            //y pongo la bandera en true para avisar si exite
            foreach($carpetas as $carpeta){
                if($carpeta == $interactionmessage->id){   
                    $directorio_existe = true;
                }
            }
            
            // si no se encoentro el directorio id se crea y se sube ahí los achivos
            if($directorio_existe == false){
                //$resultado = Storage::makeDirectory('publicaciones/'. $publicacion->id, 0755, true);
                $resultado = Storage::disk('interaction')->makeDirectory($interactionmessage->id, 0777);
            }
           
            foreach(request('file') as $archivo) {
                $extension = $archivo->extension();
                
                $check = false;

                foreach($extensiones as $ext){
                    if($ext == $extension){
                        $check=true;
                    }
                }

                if($check==true){
                    $path = Storage::disk('interaction')->putFILE($interactionmessage->id, $archivo);
                    $size = Storage::disk('interaction')->size($path);
                    //$name = Storage::disk('publicaciones')->name($path);
                    
                    $name = $archivo->getClientOriginalName();
                    //$name = "notiene";
                    
                    $interactionimage = interactionimage::create([
                        'message_id' => $interactionmessage->id,
                        'name' => $name,
                        'extension' => $extension,
                        'size' => $size,
                        'url' => $path,
                    ]);
                }
                
            }
        }
        /* ######### Fin de carga de archivos  ###################### */
        
        Session::flash('message', 'El mensaje se envió con éxito');
        
        //Datos para el mensaje
        $publicacion = Publicacion::where('id', $interactionhead->publicacion_id)->first();
        $categoria = $publicacion->categoria()->first();
        $profesional = $publicacion->users()->first();

        $interactionhead->prof_name = $profesional->name;
        $interactionhead->prof_last_name = $profesional->last_name;
        $interactionhead->categoria = $categoria->name;
        $interactionhead->url = url('publicacion_mensajes/' . $interactionhead->hash);

        //notificar al cliente
        Mail::to($profesional->email)->send(new Interaction_notificacion_profesional($interactionhead));

        //aviso al referente
        //falta cambiar la url para el referente
        $cfp = $profesional->user_cfp()->first();
        //Referente - el referente tiene una url diferente
        $interactionhead->url = url('mensajes/' . $interactionhead->hash);
        Mail::to($cfp->email)->send(new Interaction_notificacion_referente($interactionhead));

        return redirect()->route('homeinteraction', ['hash' => $interactionhead->hash ]);
    }

    public function contact_send(){

        $data = request()->validate([
            'name'=> 'required',
            'email'=> 'required',
            'asunto'=>'required',
            'mensaje'=>'required',
        ],[
            'name.required'=> 'Debe escribir su nombre',
            'email.required'=> 'Debe escribir su mail',
            'asunto.required'=>'Debe escribir un asunto',
            'mensaje.required'=>'Debe escribir el mensaje',
        ]);
        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->asunto = $data['asunto'];
        $user->mensaje = $data['mensaje'];
        //dd($user->mensaje);
         /* ######### se manda contacto de la web al referente #####   */
         //Mail::to($user->email)->send(new ContactHome($user)); 
        Mail::to('cefeperes@cfp24.com.ar')->send(new ContactHome($user));
                
         // prueba de mail return new ContactHome($user);
         Session::flash('message', 'El mensaje se envió con éxito');

        return redirect('contacto');
    }

}
