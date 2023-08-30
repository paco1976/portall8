<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\User_Cfp;
use App\Models\User_type;
use App\Models\User_Profile;
use App\Models\Publicacion;
use App\Models\Publicacion_image;
use App\Models\Zonas;
use App\Models\Categoria;
use App\Models\Titulo;
use App\Models\Interactionhead;
use App\Models\Interactionimage;
use App\Models\Interactionmessage;
use App\Models\Interactionsubjet;
Use App\Mail\ContactHome;
Use App\Mail\Interaction_notificacion_referente;
Use App\Mail\Interaction_notificacion_cliente;
Use App\Mail\Interaction_notificacion_profesional;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Intervention\Image\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Mail;


class PublicacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    
    //listado de cabeceras
    public function publicacion_consultas($publicacion_hash){
        //dd($publicacion_hash);
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $publicacion = Publicacion::where('hash', $publicacion_hash)->first();
        
        //$evento_all = Evento::where('fecha_evento', '<=',$date)->orderby('fecha_evento')->paginate(10);
        $interactionhead_all = Interactionhead::where('publicacion_id', $publicacion->id)->orderby('date', 'DESC')->paginate(10);
        foreach($interactionhead_all as $interactionhead){
            $interactionhead->subjet = $interactionhead->subjet()->first();
        }
        //$publicacion = Publicacion::where('id', $id)->first();
        
        $user2 = $publicacion->users()->first();

        if($user2->id == $user->id){
            //{{ route('publicacion', ['id'=> $user->id]) }}
            return view('/publicacion_consultas', compact('publicacion', 'interactionhead_all','user'));
        }else{
            return redirect()->route('publicacion');
        }

        
    }
    //listado de mensajes

    public function publicacion_mensajes($head_hash){
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        //$evento_all = Evento::where('fecha_evento', '<=',$date)->orderby('fecha_evento')->paginate(10);
        $interactionhead = Interactionhead::where('hash', $head_hash)->first();
        $mensajes_all = Interactionmessage::where('head_id', $interactionhead->id)->get();
        $publicacion = Publicacion::where('id', $interactionhead->publicacion_id)->first();
        
        foreach($mensajes_all as $mensaje){
            $mensaje->read = true;
            $mensaje->save(['read']);
            $mensaje->date = str_replace('/','-',  $mensaje->date );
            $mensaje->date = date('d-m-Y H:i:s', strtotime($mensaje->date));
            $mensaje->imagenes = Interactionimage::where('message_id', $mensaje->id)->get();
            foreach($mensaje->imagenes as $imagen){
                $imagen->url = Storage::disk('interaction')->url($imagen->url);
            }
        }
        
        $user2 = $publicacion->users()->first();

        if($user2->id == $user->id){
            //{{ route('publicacion', ['id'=> $user->id]) }}
            return view('/publicacion_mensajes', compact( 'publicacion','interactionhead', 'mensajes_all','user'));
        }else{
            return redirect()->route('publicacion');
        }

    }

    //respuesta del profesional

    public function publicacion_mensaje_respuesta(){
        $user = User::find(Auth::user()->id);
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
            'read' => true,
            'is_reply' => true,
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
        
        Session::flash('message', 'La respuesta se envió con éxito');
        
        //mensaje para el cliente
        $publicacion = Publicacion::where('id', $interactionhead->publicacion_id)->first();
        $categoria = $publicacion->categoria()->first();
        $profesional = $publicacion->users()->first();

        $interactionhead->prof_name = $profesional->name;
        $interactionhead->prof_last_name = $profesional->last_name;
        $interactionhead->categoria = $categoria->name;
        $interactionhead->url = url('homeinteraction/' . $interactionhead->hash);

        //notificar al cliente
        Mail::to($interactionhead->email)->send(new Interaction_notificacion_cliente($interactionhead));

        //aviso al referente
        $cfp = $user->user_cfp()->first();
        $interactionhead->url = url('mensajes/' . $interactionhead->hash);
        Mail::to($cfp->email)->send(new Interaction_notificacion_referente($interactionhead));

        return redirect()->route('publicacion_mensajes', ['head_hash' => $interactionhead->hash ]);
    }

    public function mispublicaciones(){
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $mispublicaciones = $user->publicaciones()->get();
        foreach($mispublicaciones as $publicacion) {
            $publicacion->categoria =  $publicacion->categoria()->first();
            $publicacion->titulo = $publicacion->titulo()->first();
            $publicacion->cant_consultas = $publicacion->interactions()->count();
        }
        return view('/publicacion', compact('mispublicaciones', 'user'));
    }

    public function publicacion_edit($publicacion_hash){
        $publicacion = Publicacion::where('hash', $publicacion_hash)->first();
        $publicacion->categoria = Categoria::where('id', $publicacion->categoria_id)->first();
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $publicacion->user = $publicacion->users()->first();
        $titulos_asociados = Titulo::where('categoria_id', $publicacion->categoria->id)->orderBy('name', 'DESC')->get();
        $publicacion->imagenes = $publicacion->imagenes()->get();
        $publicacion->cant_images = 0 ;
                
        foreach($publicacion->imagenes as $imagen){
            $imagen->url = Storage::disk('publicaciones')->url($imagen->url);
            $publicacion->cant_images = $publicacion->cant_images + 1 ;
        }
        
        //ascendente
        //$titulo_all = Titulo::all()->sortBy('name');
        if ($publicacion->user->id == $user->id){
            return view('/publicacion_edit', compact('publicacion','user','titulos_asociados'));
        }else{
            return redirect()->route('publicacion');
        }
        
    }

    //"{{ route('avatardelete') }}"

    public function imagen_delete($id){
        $publicacion_image = Publicacion_image::where('id', $id)->first();
        $publicacion = Publicacion::where('id',$publicacion_image->publicacion_id)->first();
        Storage::disk('publicaciones')->delete($publicacion_image->url);
        $publicacion_image->delete();
        Session::flash('message', 'La imagen se a eliminado con éxito');
        return redirect()->route('publicacion_edit', ['publicacion_hash' => $publicacion->hash ]);
    }

    public function publicacion_delete($publicacion_hash){
        $user_login = User::find(Auth::user()->id);
        $publicacion = Publicacion::where('hash',$publicacion_hash)->first();
        $user_publicacion = $publicacion->users()->first();
        //dd($user_publicacion);

        if($user_login->id == $user_publicacion->id){
            $imagenes_all = $publicacion->imagenes()->get();
            //borrados de imagenes
            if($imagenes_all){
                foreach($imagenes_all as $imagen){
                    Storage::disk('publicaciones')->delete($imagen->url);
                    $imagen->delete();
                }
            }
            //desatachado de los títulos asociados
            $publicacion->titulos_asociados()->detach();
            //$evento->artistas()->detach(Artista::where('id', $artista->id)->first());
            //desatachado de usuario
            $publicacion->users()->detach();
            //borrado de la publicacion
            $publicacion->delete();

            Session::flash('message', 'La publiación se borró con éxito');
            return redirect()->route('publicacion');
        }else{
            Session::flash('message', 'Usuario no autorizado');
            return redirect()->route('publicacion');
        }

    }

    public function publicacion_update(){
        $user = User::find(Auth::user()->id);
                
        $data = request()->validate([
            'publicacion_hash' =>'',
            'description' => 'required',
            'titulos[]' => '',
        ],[
            'description.required' => 'Debe colocar una descripción sobre su trabajo',
        ]);

        
        $publicacion = Publicacion::where('hash', $data['publicacion_hash'])->first();
        $publicacion->description = $data['description'];
        $publicacion->save(['description']);
        $titulos_all = titulo::all();

        
        
        if(is_array(request('titulos'))){
            foreach($titulos_all as $titulo) {
                $publicacion->titulos_asociados()->detach(titulo::where('name', $titulo->name)->first());
            }
            foreach(request('titulos') as $titulo_name) {
                $publicacion->titulos_asociados()->attach(titulo::where('name', $titulo_name)->first());
            }
        }

        //$publicacion->categoria = Categoria::where('id', $publicacion->categoria_id)->first();
        //$user = User::find(Auth::user()->id);
        //$publicacion->user = $publicacion->user()->first();
        

        //***************** SUDIDA DE ARCHIVOS *********** */
        if(request('file')){
            
            //recupero todas las carpetas dentro de la ruta  publicaciones
            $carpetas = Storage::disk('publicaciones')->directories();
            //pongo una vandera falsa
            $directorio_existe = false;
            //Ahora voy busco entre todas las carpeta si existe la de esta publicación
            //y pongo la bandera en true para avisar si exite
            foreach($carpetas as $carpeta){
                if($carpeta == $publicacion->id){   
                    $directorio_existe = true;
                }
            }
            
            // si no se encoentro el directorio id se crea y se sube ahí los achivos
            if($directorio_existe == false){
                //$resultado = Storage::makeDirectory('publicaciones/'. $publicacion->id, 0755, true);
                $resultado = Storage::disk('publicaciones')->makeDirectory($publicacion->id, 0777);
            }
            
            $extensiones=['jpg','png','bmp','svg','jpeg'];
            
            //cargo los achivos si es que hay
            foreach(request('file') as $archivo) {
                $extension = $archivo->extension();
                $check = false;
                //dd($extension);

                foreach($extensiones as $ext){
                    if($ext == $extension){
                        $check=true;

                    }
                }

                //$archivo = $archivo->resize(200, 200);
                //dd($extension);
                //$filename = $archivo->getClientOriginalName();
                //$extension = $archivo->getClientOriginalExtension();
                //$check=in_array($extension,$allowedfileExtension);
                //$extension = $archivo->getClientOriginalName();
                //$path = $archivo->store($archivo,'publicaciones');
                //$path = Storage::disk('publicaciones)->url($path); esto es para ver la imagen
                //$path = 'storage/' . $path;
                //acá guardo los datos de la imagen si es que tiene una extensión permitida
                if($check==true){
                    //aca lo sube 
                    $path = Storage::disk('publicaciones')->putFILE($publicacion->id, $archivo);
                    $size = Storage::disk('publicaciones')->size($path);
                    $imagen = new Publicacion_image;
                    $imagen->publicacion_id=$publicacion->id;
                    $imagen->extension = $extension;
                    $imagen->size=$size;
                    $imagen->url=$path;
                    $imagen->save();
                }else{
                    Session::flash('error', 'Uno de los archivos no es una imagen. La publicación se guardo sin ese archivo');
                    return back();
                    //->with('error', 'Uno de los archivos no es una imagen. La publicación se guardo sin ese archivo');
                }
                
            }

        }
        //***************** FIN SUDIDA DE ARCHIVOS *********** */

        Session::flash('message', 'La publicación se actualizó con éxito');

        $publicacion_all = $user->publicaciones();
        $mispublicaciones = $user->publicaciones()->get();
       
        return redirect()->route('publicacion');
    }


    public function publicacion_new(){
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $categoria_all = Categoria::all();
        //ascendente
        $titulo_all = Titulo::all()->sortBy('name');
       
        return view('/publicacion_new', compact('categoria_all', 'user','titulo_all'));
    }

    public function publicacion_save(){
        //esta funcion guarda las publicaciones nuevas
        
        //$user = User::find($id);
        $user = User::find(Auth::user()->id);
                
        $data = request()->validate([
            'titulo_id' => 'required',
            'description' => 'required',
        ],[
            'titulo_id.required' =>'Debe seleccionar un título',
            'description.required' => 'Debe colocar una descripción sobre su trabajo',
        ]);
        
        
        //'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //['image','max:2048']
        
        $titulo = titulo::where('id', $data['titulo_id'])->first();
        
        //chequeo de publicaciones de la misma categoría
        //busco las publicaciones del usuario
        $publicacion_all = $user->publicaciones()->get();
        //dd($publicacion_all);
        $repetido = false;
        foreach($publicacion_all as $publicacion){
            if($publicacion->categoria_id == $titulo->categoria_id){
                $repetido = true;
                $categoria = Categoria::where('id', $publicacion->categoria_id)->first();
                Session::flash('error', 'No se puede dar de alta la publicación porque ya tenes una publicación en la categoría ' .$categoria->name );
                //si es repetido me voy de subir archivo y aviso al usuario
                $publicacion_all = $user->publicaciones();
                $mispublicaciones = $user->publicaciones()->get();
                
                foreach($mispublicaciones as $publicacion) {
                    $publicacion->categoria =  $publicacion->categoria()->get();
                    $publicacion->titulo = $publicacion->titulo()->get();
                    //dd($publicacion->titulo);
                }

                //return view('/publicacion', compact('publicacion_all', 'user', 'mispublicaciones'));
                return back();
                //dd($categoria->name);
            }
        }
        
        $publicacion = Publicacion::create([
            'description' => $data['description'],
            'titulo_id' => $data['titulo_id'],
            'categoria_id' => $titulo->categoria_id,
            'view'=> 0,
            'aprobado'=>0,
            'activo'=>1,
        ]);
        
        //dd($publicacion);
               
        $user->publicaciones()->attach(Publicacion::where('id', $publicacion->id)->first());
        //subida de archivos si los hay

        $publicacion->hash = md5($publicacion->id);
        $publicacion->save(['hash']);

        //***************** SUDIDA DE ARCHIVOS *********** */
        if(request('file')){
            
            //recupero todas las carpetas dentro de la ruta  publicaciones
            $carpetas = Storage::disk('publicaciones')->directories();
            //pongo una vandera falsa
            $directorio_existe = false;
            //Ahora voy busco entre todas las carpeta si existe la de esta publicación
            //y pongo la bandera en true para avisar si exite
            foreach($carpetas as $carpeta){
                if($carpeta == $publicacion->id){   
                    $directorio_existe = true;
                }
            }
            
            // si no se encoentro el directorio id se crea y se sube ahí los achivos
            if($directorio_existe == false){
                //$resultado = Storage::makeDirectory('publicaciones/'. $publicacion->id, 0755, true);
                $resultado = Storage::disk('publicaciones')->makeDirectory($publicacion->id, 0777);
            }
            
            $extensiones=['jpg','png','bmp','svg','jpeg'];
            
            //cargo los achivos si es que hay
            foreach(request('file') as $archivo) {
                $extension = $archivo->extension();
                $check = false;
                //dd($extension);

                foreach($extensiones as $ext){
                    if($ext == $extension){
                        $check=true;

                    }
                }
                //$archivo = $archivo->resize(200, 200);
                //dd($extension);
                //$filename = $archivo->getClientOriginalName();
                //$extension = $archivo->getClientOriginalExtension();
                //$check=in_array($extension,$allowedfileExtension);
                //$extension = $archivo->getClientOriginalName();
                //$path = $archivo->store($archivo,'publicaciones');
                //$path = Storage::disk('publicaciones)->url($path); esto es para ver la imagen
                //$path = 'storage/' . $path;
                //acá guardo los datos de la imagen si es que tiene una extensión permitida
                if($check==true){
                    //aca lo sube 
                    $path = Storage::disk('publicaciones')->putFILE($publicacion->id, $archivo);
                    $size = Storage::disk('publicaciones')->size($path);
                    $imagen = new Publicacion_image;
                    $imagen->publicacion_id=$publicacion->id;
                    $imagen->extension = $extension;
                    $imagen->size=$size;
                    $imagen->url=$path;
                    $imagen->save();
                }else{
                    Session::flash('error', 'Uno de los archivos no es una imagen. La publicación se guardo sin ese archivo');
                    return back();
                    //->with('error', 'Uno de los archivos no es una imagen. La publicación se guardo sin ese archivo');
                }
                
            }

        }
        //***************** FIN SUDIDA DE ARCHIVOS *********** */

        Session::flash('message', 'La publicación se creo con éxito');
        //$this->mispublicaciones($id);
        $publicacion_all = $user->publicaciones();
        $mispublicaciones = $user->publicaciones()->get();
        
        foreach($mispublicaciones as $publicacion) {
            $publicacion->categoria =  $publicacion->categoria()->first();
            $publicacion->titulo = $publicacion->titulo()->first();
            $publicacion->cant_consultas = $publicacion->interactions()->count();
            //dd($publicacion->titulo);
        }
        //return view('/publicacion', compact('publicacion_all', 'user', 'mispublicaciones'));
        return back();
    }

}
