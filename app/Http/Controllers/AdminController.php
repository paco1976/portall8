<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\User_Cfp;
use App\Models\User_type;
use App\Models\User_Profile;
use App\Models\Publicacion;
use App\Models\Publicacion_image;
use App\Models\Publicacion_Visita;
use App\Models\Publicacion_Whatsapp;
use App\Models\Zonas;
use App\Models\Categoria;
use App\Models\Categoria_Tipo;
use App\Models\Titulo;
use App\Models\Interactionhead;
use App\Models\Interactionimage;
use App\Models\Interactionmessage;
use App\Models\Interactionsubjet;
use App\Models\Survey;
Use App\Mail\ContactHome;
Use App\Mail\Interaction_notificacion_referente;
Use App\Mail\Interaction_notificacion_cliente;
Use App\Mail\Interaction_notificacion_profesional;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Image;
use Mail;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function register_profesional(){
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user_type_all = User_type::where('active', 1)->get();
        $user_cfp_all = User_Cfp::where('active', 1)->get();
        return view('/admin.prof_reg', compact('user_type_all', 'user_cfp_all','user'));
    }

    public function create_profesional(){
        $data = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'mobile'=> ['required'],
            'dni' => ['required', 'string', 'max:255'],
            'avatar' => ['required','image','max:2048'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'user_type' => ['required'],
            'user_cfp' => ['required'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'dni' => $data['dni'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'type_id' => $data['user_type'],
            'cfp_id' => $data['user_cfp'],
        ]);

        $user->hash = md5($user->id);
        $user->save();
        
        //creo la carpeta con el numero de id
        $resultado = Storage::disk('avatares')->makeDirectory($user->id, 0777);
        //subo el archivo y guardo el path
        $path = Storage::disk('avatares')->putFILE($user->id, request()->file('avatar'));
        //actualizo el path del avatar
        $user->avatar = $path;
        //guardo el path del avatar
        $user->save(['avatar']);
        //dd($user->avatar);

        User_Profile::create([
            'user_id' => $user->id,
            'mobile' => $data['mobile'],
        ]);
       
        Session::flash('message', 'El usuario se creó con éxito');
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user_type_all = User_type::where('active', 1)->get();
        $user_cfp_all = User_Cfp::where('active', 1)->get();
        return view('/admin.prof_reg', compact('user_type_all', 'user_cfp_all','user'));
       
    }

    public function pass_prof($id_prof){
        $user_type_all = User_type::all();
        $user_cfp_all = User_Cfp::all();
        if (Auth::user()) {
            $user = User::find(Auth::user()->id);
            $user_prof = User::where("id", $id_prof)->first();
            $user_prof->avatar = Storage::disk('avatares')->url($user_prof->avatar);
            $user->avatar = Storage::disk('avatares')->url($user->avatar);
            $user_profile = User_Profile::where('user_id',$user->id)->first();
            //$public_path = public_path();
            //$url = Storage::url($user_profile->photo);
            //$user_profile->photo=$url;
            return view('/admin.prof_pass', compact('user', 'user_type_all', 'user_cfp_all', 'user_profile', 'user_prof'));
        }else {
            return view('/admin.prof_pass', compact('user_type_all', 'user_cfp_all'));
        }
    }

    public function prof_perfil($user_hash){
        //$user = User::find(Auth::user()->id);

        $user = User::where("hash", $user_hash)->first();

        if($user->avatar == '/img/team/perfil_default.jpg'){
            //no convierte la url
        }else{
            $user->avatar = Storage::disk('avatares')->url($user->avatar);
        }

        $miszonas = $user->zonas()->get();
        $user_profile = $user->user_profile()->first();
        $user_cfp = User_Cfp::where('id',$user->cfp_id)->first();
        $user->type = $user->user_type()->first();
        $user->profile = $user->user_profile()->first();
        $user->cfp = $user->user_cfp()->first();
        //dd($user);
               
        return view('admin.prof_perfil', compact('user','user_profile', 'user_cfp', 'miszonas'));
        
    }

    public function updatepass_prof(){
        $data = request()->validate([
            'email' => '',
            'password' => 'required|string|min:8|confirmed',
        ],[
            'password.required'=>'La confirmación de clave no es igual',
        ]);
        $user = User::where('email', $data['email'])->first();
        $user->password = Hash::make($data['password']);
        //dd($user->password );
        
        if($user->save(['password']))
        {
            Session::flash('message', 'La clave se a cambiado con éxito');
        }else{
            Session::flash('error', 'La clave se a cambiado con éxito');
        }
        
        return back();
    }

    public function avatardelete($hash_user){
        //$user = User::find(Auth::user()->id);
        $user = User::where("hash", $hash_user)->first();
        // storage/
        //$user->avatar = substr($user->avatar, 8);
        
        //dd($user->avatar);
        //Storage::delete([$user->avatar]);
        Storage::disk('avatares')->delete($user->avatar);
       
        $user->avatar ='/img/team/perfil_default.jpg';
        $user->save(['avatar']);

        //$user->save(['user_cfp']);

        //$user_profile->save(['mobile', 'phone', 'twitter', 'facebook', 'instagram', 'linkedin']);

        Session::flash('message', 'La imagen se a eliminado con éxito');
        
        return back();
    }

    public function avatarupload($hash_user){
        //$user = User::find(Auth::user()->id);
        $user = User::where("hash", $hash_user)->first();
        //subir archivo

        $carpetas = Storage::disk('avatares')->directories();
        $directorio_existe = false;
        foreach($carpetas as $carpeta){
            if($carpeta == $user->id){   
                $directorio_existe = true;
            }
        }
        if($directorio_existe == false){
            //$resultado = Storage::makeDirectory('publicaciones/'. $publicacion->id, 0755, true);
            $resultado = Storage::disk('avatares')->makeDirectory($user->id, 0777, true);
        }
    
        $path = Storage::disk('avatares')->putFILE($user->id, request()->file('avatar'));
        
        
        $user->avatar = $path;
        $user->save(['avatar']);
        //dd($path);
        Session::flash('message', 'La imagen se a actualizo con éxito');
        return back();
    }
    
    public function prof_publicaciones($hash_user){
        $user = User::where("hash", $hash_user)->first();
        //$user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        //$publicacion_all = $user->publicaciones();
        //dd($publicacion_all);
        //$publicacion_all = Publicacion::all();
        $mispublicaciones = $user->publicaciones()->get();
        //$titulo = $publicacion->titulo()->get('description');
        foreach($mispublicaciones as $publicacion) {
            $publicacion->categoria =  $publicacion->categoria()->first();
            $publicacion->titulo = $publicacion->titulo()->first();
            $publicacion->cant_consultas = $publicacion->interactions()->count();
            $publicacion->cant_visitas = $publicacion->visita()->count();
            $publicacion->rating = $publicacion->rating();
            $publicacion->surveys_taken = $publicacion->surveys_accepted();
            $publicacion->contacts_registered = $publicacion->getClientsRegistered();            
        }
       
        return view('/admin.prof_publicacion', compact('mispublicaciones', 'user'));
    }

    public function prof_edit($hash_user){
        $user = User::where("hash", $hash_user)->first();
        $user->profile = $user->profile()->first();
        if($user->avatar == '/img/team/perfil_default.jpg'){
            //no convierte la url
        }else{
            $user->avatar = Storage::disk('avatares')->url($user->avatar);
            //disk('avatares')
        }
        //$user_profile = User_Profile::where('user_id',$user->id)->first();
        $user_cfp = User_Cfp::where('id',$user->cfp_id)->first();
        $user_cfp_all = User_Cfp::all();

        //no esta en uso
        //$user->profiles = User::find(1)->user_profile();
        //$user->cfp = User::find(1)->user_cfp();
        $zonas_all = Zonas::all();
        $miszonas = $user->zonas()->get();
        //{{ route('publicacion', ['id'=> $user->id]) }}    
        
        return view('admin.prof_perfil_edit', compact('user', 'user_cfp', 'user_cfp_all', 'miszonas', 'zonas_all'));
        
         //return redirect()->route('perfil');
    }

    public function prof_update($hash_user){
        //$user = User::find($id);
        $user = User::where("hash", $hash_user)->first();
        
            $profile = User_Profile::where('user_id',$user->id)->first();
            if ($user->email == request()->input('email')) {
                $data = request()->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'last_name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255'],
                    'mobile'=> ['required'],
                    'dni' => ['required', 'string', 'max:255'],
                    'avatar' => ['image','max:2048'],
                    'phone'=> '',
                    'facebook' => '',
                    'instagram' => '',
                    'user_cfp'=>'',
                ],[
                    'mobile.required'=>'El campo celular es obligatorio',
                    'name' => 'El campo Nombre es obligatorio',
                    'last_name' => 'El campo Apellido es obligatorio',
                    'mobile'=> 'El campo celular es obligatorio',
                    'dni' => 'El campo DNI es obligatorio'                
                ]);
            }
            else{
                $data = request()->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'last_name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'mobile'=> ['required'],
                    'dni' => ['required', 'string', 'max:255'],
                    'avatar' => ['image','max:2048'],
                    'phone'=> '',
                    'facebook' => '',
                    'instagram' => '',
                    'user_cfp'=>'',
                ],[
                    'mobile.required'=>'El campo celular es obligatorio',
                    'name' => 'El campo Nombre es obligatorio',
                    'last_name' => 'El campo Apellido es obligatorio',
                    'mobile'=> 'El campo celular es obligatorio',
                    'dni' => 'El campo DNI es obligatorio'                
                ]);
            }
            $user->name = $data['name'];
            $user->last_name = $data['last_name'];
            $user->dni = $data['dni'];
            $user->email = $data['email'];
            $user->cfp_id = $data['user_cfp'];

            if ($user->save(['name','last_name','dni','email','cfp_id'])) {
                $profile->mobile= $data['mobile'];
                $profile->phone= $data['phone'];
                $profile->facebook= $data['facebook'];
                $profile->instagram= $data['instagram'];
                $profile->save(['mobile', 'phone','facebook','instagram']);
    
                if (request()->hasfile('avatar')) {
                    $carpetas = Storage::disk('avatares')->directories();
                    $directorio_existe = false;
                    foreach($carpetas as $carpeta){
                        if($carpeta == $user->id){   
                            $directorio_existe = true;
                        }
                    }
                    if($directorio_existe == false){
                        $resultado = Storage::disk('avatares')->makeDirectory($user->id, 0777, true);
                    }
    
                    $image = request()->file('avatar');
                    $input['imagename'] = time().'.'.$image->extension();
                    $destinationPath = Storage::disk('avatares')->path($user->id);
                    $img = Image::make($image->path());
                    $img->resize(300, 300, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationPath.'/'.$input['imagename']);
                    $path = $user->id.'/'.$input['imagename'];
                    $user->avatar = $path;
                    $user->save(['avatar']);
                }

                $zonas_all = Zonas::all();
                $zonas_new = request('zonas');

                if(is_array($zonas_new)){
                    foreach($zonas_all as $zona) {
                        $user->zonas()->detach(Zonas::where('name', $zona)->first());
                    }
                    foreach($zonas_new as $zona) {
                        $user->zonas()->attach(Zonas::where('name', $zona)->first());
                    }
                }
            
                Session::flash('message', 'El perfil se ha actualizado con éxito');
                return back();
            } else {
                Session::flash('error', 'El perfil no se pudo actualizar, revise los datos');
                return back();
            }
    }

    //tengo que seguir de acá!
    public function prof_publicacion_edit($publicacion_hash, $hash_user){
        $publicacion = Publicacion::where('hash', $publicacion_hash)->first();
        $publicacion->categoria = Categoria::where('id', $publicacion->categoria_id)->first();
        //$user = User::find(Auth::user()->id);
        $user = User::where("hash", $hash_user)->first();
        $publicacion->user = $publicacion->users()->first();
        $publicacion->user->avatar = Storage::disk('avatares')->url($publicacion->user->avatar);
        $titulos_asociados = Titulo::where('categoria_id', $publicacion->categoria->id)->orderBy('name', 'DESC')->get();
        $publicacion->imagenes = $publicacion->imagenes()->get();
        $publicacion->cant_images = 0 ;
                
        foreach($publicacion->imagenes as $imagen){
            $imagen->url = Storage::disk('publicaciones')->url($imagen->url);
            $publicacion->cant_images = $publicacion->cant_images + 1 ;
        }
        
        //ascendente
        //$titulo_all = Titulo::all()->sortBy('name');
        
        return view('/admin.prof_publicacion_edit', compact('publicacion','user','titulos_asociados'));
    }

    public function prof_publicacion_update($hash_user){
        $user = User::where("hash", $hash_user)->first();
                
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
       
        //return redirect()->route('publicacion');
        return back();
    }


    public function prof_publicacion_new($hash_user){
        $user = User::where("hash", $hash_user)->first();
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $categoria_all = Categoria::all();
        //ascendente
        $titulo_all = Titulo::all()->sortBy('name');
       
        return view('/admin.prof_publicacion_new', compact('categoria_all', 'user','titulo_all'));
    }

    public function prof_publicacion_save($hash_user){
        //esta funcion guarda las publicaciones nuevas
        
        //$user = User::find($id);
        $user = User::where("hash", $hash_user)->first();
                
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
        $publicacion_all = $user->publicaciones()->get();
        
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
                Session::flash('error', 'Usted ya posee una publicación en esta categoría');
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

        Session::flash('message', 'La publicación se creó con éxito');
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

    public function admin_profesionales(Request $request){
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        //$user_all = User::where('type_id',1);
        /* BORRAR ESTO CUANDO ESTÉ LISTO*/
        /*
        $publicacion_all = Publicacion::all();
        foreach($publicacion_all as $publi){
            $publi->hash = md5($publi->id);
            $publi->save(['hash']);
        }

        foreach($user_all as $usr){
                $usr->hash = md5($usr->id);
                $usr->save(['hash']);
        }
        
        $consulta_all = Interactionhead::all();
        foreach($consulta_all as $consulta){
                $consulta->hash = md5($consulta->id);
                $consulta->save(['hash']);
        }

        $mensajes_all = Interactionmessage::all();
        foreach($mensajes_all as $mensaje){
                $mensaje->hash = md5($mensaje->id);
                $mensaje->save(['hash']);
        }
        
        */


        $user->permisos = $user->user_type()->first();
        if($user->permisos->name == "Administrador"){
            $user_all = User::Buscador($request->name)->where( 'type_id', 1)->paginate(10);
            //$user_all = User::where('cfp_id', $user->cfp_id)->where( 'type_id', 1)->where('active', 1)->paginate(10);
            foreach($user_all as $usr){
                $usr->profile = $usr->user_profile()->first();
                $usr->publicaciones = $usr->publicaciones()->get();
                $usr->cant_publicaciones = $usr->publicaciones()->count();
                $usr->publi_sin_aprobar = $usr->publicaciones()->where('aprobado', 0)->count();
                $cant_head = 0;

                $usr->menssage = 0;
                $usr->menssage_not_read = 0;
                $usr->menssage_total = 0;
                $usr->contacts_registered = 0;
                $usr->surveys = $usr->surveys()->count();

                $ratings_sum = 0;
                foreach($usr->publicaciones as $publicacion){
                    if($publicacion){
                        $consultas = $publicacion->interactions()->get();
                        $publicacion->not_active = $publicacion->not_active + 1;
                        foreach($consultas as $consulta){
                            $usr->menssage_not_read = $usr->menssage_not_read + $consulta->messages()->where('read', false)->count();
                            $usr->menssage_total = $usr->menssage_total + $consulta->messages()->count();
                        }
                            $usr->contacts_registered += $publicacion->getClientsRegistered();
                            $ratings_sum += $publicacion->rating();
                    }                   
                }
                //dd($ratings_sum. " " .  count($usr->publicaciones));
                if (count($usr->publicaciones)>0) {
                    $usr->rating = round($ratings_sum / count($usr->publicaciones), 1);
                }else{
                    $usr->rating = round($ratings_sum, 1);
                }
                          
                
            }
            return view('/admin.profesionales', compact('user', 'user_all'));
        }
        else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }

    }

    public function admin_publicaciones(Request $request){

        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();
        if($user->permisos->name == "Administrador"){
            //todas las publicaciones del cfp del admin que está conectado
            $publicaciones = Publicacion::Buscador_admin($request->name)->paginate(10);
            //$publicaciones = Publicacion::where('active', 1)->paginate(10);
            /*
            $publicaciones = DB::table('publicacion')
            ->join('publicacion_user', 'publicacion.id', '=', 'publicacion_user.publicacion_id')
            ->join('users', 'users.id', '=', 'publicacion_user.user_id')
            ->where('users.cfp_id', $user->cfp_id)
            ->paginate(10);
            */
            //dd($publicaciones);
            foreach($publicaciones as $publicacion){
                //dd($publicacion->aprobado);
                $publicacion->user = $publicacion->users()->first();
                $publicacion->cfp = $publicacion->user->cfp()->first();
                $publicacion->titulo = Titulo::where('id', $publicacion->titulo_id)->first();
                $publicacion->categoria = Categoria::where('id', $publicacion->categoria_id)->first();
                $publicacion->cant_consultas = $publicacion->interactions()->count();
                $publicacion->cant_visitas = $publicacion->visita()->count();
                $publicacion->cant_whatsapp = $publicacion->whatsapp()->count();
                $consultas = Interactionhead::where('publicacion_id',$publicacion->id);
                $publicacion->menssage_not_read = 0;
                $publicacion->menssage_total = 0;
                foreach($publicacion->consultas as $consulta){
                    $publicacion->menssage_not_read = $publicacion->menssage_not_read + $consulta->messages()->where('read', false)->count();
                    $publicacion->menssage_total = $publicacion->menssage_total +$consulta->messages()->count();
                }
            }
                       
            return view('/admin.publicaciones', compact('user', 'publicaciones'));
        }else{
            return redirect('/');
        }
    }

    public function prof_publicacion_imagen_delete($imagen_id){
        $publicacion_image = Publicacion_image::where('id', $imagen_id)->first();
        $publicacion = Publicacion::where('id',$publicacion_image->publicacion_id)->first();
        Storage::disk('publicaciones')->delete($publicacion_image->url);
        $publicacion_image->delete();
        Session::flash('message', 'La imagen se ha eliminado con éxito');
        //return redirect()->route('publicacion_edit', ['head' => $publicacion->hash ]);
        return back();
    }

    Public function admin_publicaciones_user($user_hash){
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user_publicacion = User::where('hash', $user_hash)->first();
        $user->permisos = $user->user_type()->first();
        if($user->permisos->name == "Administrador"){
            $user_publicacion->profile = $user_publicacion->user_profile()->first();
            $user_publicacion->publicaciones = $user_publicacion->publicaciones()->paginate(10);
            $user_publicacion->cant_publicaciones = $user_publicacion->publicaciones()->count();
            $cant_head = 0;
            $user_publicacion->menssage = 0;
            foreach($user_publicacion->publicaciones as $publicacion){
                if($publicacion){
                    $publicacion->consultas = $publicacion->interactions()->get();
                    $publicacion->cant_consultas = $publicacion->interactions()->count();
                    $publicacion->categoria = $publicacion->categoria()->first();
                    $publicacion->titulo = $publicacion->titulo()->first();
                    $publicacion->menssage_not_read = 0;
                    $publicacion->menssage_total = 0;
                    foreach($publicacion->consultas as $consulta){
                        $publicacion->menssage_not_read = $publicacion->menssage_not_read + $consulta->messages()->where('read', false)->count();
                        $publicacion->menssage_total = $publicacion->menssage_total +$consulta->messages()->count();
                    }
                    $publicacion->clients_registered = $publicacion->getClientsRegistered();
                    $publicacion->surveys_accepted = $publicacion->surveys_accepted();
                    $publicacion->surveys_sent = $publicacion->surveys_sent();
                    $publicacion->rating = $publicacion->rating();
                }
                
            }
            //session::flash('message', 'No está autorizado para esta acción');
            return view('/admin.publicaciones_user', compact('user_publicacion', 'user'));
            //return view('/admin.publicaciones_user', compact('user', 'publicaciones'));
            //return view('homeprofesional', compact('user_type_all','user_cfp_all', 'publicacion','categoria', 'titulo', 'user', 'user_profile', 'zonas', 'subjets'));
        }
        else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }

    }

    Public function admin_publicacion_user($publicacion_hash, $origen){
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();

        $publicacion = Publicacion::where('hash', $publicacion_hash)->first();
        
        $publicacion->user = $publicacion->user()->first();

        if($user->permisos->name == "Administrador"){
            //imagenes y profile
            $publicacion->user->profile = $publicacion->user->user_profile()->first();
            $publicacion->imagenes = $publicacion->imagenes()->get();
            $publicacion->cant_imagenes = $publicacion->imagenes()->count();
            //dd($publicacion->cant_imagenes);
            foreach($publicacion->imagenes as $imagen){
                $imagen->url = Storage::disk('publicaciones')->url($imagen->url);
                //$publicacion->cant_images = $publicacion->cant_images + 1 ;
            }
            if($publicacion->user->avatar == '/img/team/perfil_default.jpg'){
                //no convierte la url
            }else{
                $publicacion->user->avatar = Storage::disk('avatares')->url($publicacion->user->avatar);
                //disk('avatares')
            }
            $publicacion->titulos_asociados = $publicacion->titulos_asociados()->get();
            $publicacion->categoria = $publicacion->categoria()->first();
            $publicacion->titulo = $publicacion->titulo()->first();
            $publicacion->zonas = $publicacion->user->zonas()->get();
            
            //session::flash('message', 'No está autorizado para esta acción');
            return view('/admin.publicacion_user', compact('publicacion', 'user', 'origen'));
        }
        else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }

    }

    public function admin_publicaciones_aprobar_desaprobar($publicacion_hash, $origen){
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();

        $publicacion = Publicacion::where('hash', $publicacion_hash)->first();
        $publicacion_user = $publicacion->user()->first();

        if($user->permisos->name == "Administrador"){

            if($publicacion->aprobado == 0){
                session::flash('message', 'La publicación se activó con éxito');
                $publicacion->aprobado = 1;
                $publicacion->save(['aprobado']);
            }else{
                session::flash('message', 'La publicación se desactivó con éxito');
                $publicacion->aprobado = 0;
                $publicacion->save(['aprobado']);
            }

            return back();
            /*
            if($origen == 'publicaciones'){
                return redirect()->route('admin_publicaciones');    
            }else{
                return redirect()->route('admin_publicaciones_user', ['user_hash' => $publicacion_user->hash]);
            }
            */
            
            //return redirect()->route('homeprofesional', ['id' => $id]);
        }
        else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }

    }

    public function admin_publicaciones_show_rating($publicacion_hash){
        $user = User::find(Auth::user()->id);
        $user->permisos = $user->user_type()->first();

        $publicacion = Publicacion::where('hash', $publicacion_hash)->first();

        if($user->permisos->name == "Administrador"){

            if($publicacion->show_rating == 0){
                session::flash('message', 'El rating se hizo visible');
                $publicacion->show_rating = 1;
                $publicacion->save(['show_rating']);
            }else{
                session::flash('message', 'El rating se ocultó');
                $publicacion->show_rating = 0;
                $publicacion->save(['show_rating']);
            }

            return back();
        }
        else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }

    }



    public function admin_publicacion($hash){
        $user = User::find(Auth::user()->id);
                if($user->avatar == '/img/team/perfil_default.jpg'){
            //no convierte la url
        }else{
            $user->avatar = Storage::disk('avatares')->url($user->avatar);
        }
        $user->permisos = $user->user_type()->first();
        if($user->permisos->name == "Administrador"){
            
            $publicacion = Publicacion::where('hash', $hash)->first();
            //dd($publicacion);
            //no se usa esta función???
            $publicacion->imagenes = $publicacion->imagenes()->get();
            $user_publicacion = $publicacion->user_publicacion()->first();
            
            $publicacion->titulos_asociados = $publicacion->titulos_asociados()->get();
            $subjets = Interactionsubjet::get();
            
            foreach($publicacion->imagenes as $imagen){
                $imagen->url = Storage::disk('publicaciones')->url($imagen->url);
                $publicacion->cant_images = $publicacion->cant_images + 1 ;
            }
            $categoria = $publicacion->categoria()->first();
            $titulo = $publicacion->titulo()->first();
            //$user = $publicacion->users()->first();
            //dd($user);
            
            $user_profile = $user_publicacion->user_profile()->first();
            $zonas = $user_publicacion->zonas()->get();
            

            $categoria_servicios_all = Categoria::where(['categoria_tipo_id' => 1,'active' => 1])->get();
            $categoria_productos_all = Categoria::where(['categoria_tipo_id' => 2,'active' => 1])->get();

            $user_type_all = User_type::all();
            $user_cfp_all = User_Cfp::all();

            
            return view('admin.publicacion', compact('categoria_servicios_all', 'categoria_productos_all',  'user_type_all','user_cfp_all', 'publicacion','categoria', 'titulo', 'user_publicacion', 'user_profile', 'zonas', 'subjets', 'user'));
        }else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }
        

    }

    public function admin_publicacion_delete($publicacion_hash, $origen){
        $user = User::find(Auth::user()->id);
        $publicacion = Publicacion::where('hash',$publicacion_hash)->first();
        $user_publicacion = $publicacion->user()->first();
        //dd($user_publicacion);
        $user->permisos = $user->user_type()->first();
        if($user->permisos->name == "Administrador"){
            $imagenes_all = $publicacion->imagenes()->get();
            //borrados de imagenes de la publicacoin
            if($imagenes_all){
                foreach($imagenes_all as $imagen){
                    Storage::disk('publicaciones')->delete($imagen->url);
                    $imagen->delete();
                }
            }
            // Acá busco las consultas y trato de borrar todo lo asociado 
            //a las consultas, mensajes e imagenes
            //$consultas_all = $publicacion->consultas()->get;
            $consultas_all = Interactionhead::where('publicacion_id', $publicacion->id)->get();
            if($consultas_all){
                foreach($consultas_all as $consulta){
                    $mensajes_all = $consulta->mensajes()->get();
                    if($mensajes_all){
                        foreach($mensajes_all as $mensaje){
                            $imagenes_all = $mensaje->imagenes()->get();
                            if($imagenes_all){
                                foreach($imagenes_all as $imagen){
                                    Storage::disk('interaction')->delete($imagen->url);
                                    $imagen->delete();
                                }
                            }
                            //acá ya puedo borrar los mensajes
                            $mensaje->delete();
                        }
                    }
                    $consulta->delete();
                }
            }
            //desatachado de los títulos asociados
            $publicacion->titulos_asociados()->detach();
            //$evento->artistas()->detach(Artista::where('id', $artista->id)->first());
            //desatachado de usuario
            $publicacion->users()->detach();
            $publicacion->delete();

            Session::flash('message', 'La publiación se borró con éxito');
            return back();
            /*
            if($origen == 'publicaciones'){
                return redirect()->route('admin_publicaciones');    
            }else{
                return redirect()->route('admin_profesionales');
            }
            */
            
        }else{
            Session::flash('message', 'Usuario no autorizado');
            return back();
            /*
            if($origen == 'publicaciones'){
                return redirect()->route('admin_publicaciones');    
            }else{
                return redirect()->route('admin_profesionales');
            }
            */
        }

    }

    public function admin_user_aprobar_desaprobar($user_hash, $origen){
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();
       
        //$publicacion = Publicacion::where('hash', $publicacion_hash)->first();
        $profesional_user = User::where('hash', $user_hash)->first();

        if($user->permisos->name == "Administrador" ){

            if($profesional_user->active == 0){
                session::flash('message', 'El usuario se activo con éxito');
                $profesional_user->active = 1;
                $profesional_user->save(['active']);
            }else{
                session::flash('message', 'El usuario se desactivo con éxito');
                $profesional_user->active = 0;
                $profesional_user->save(['active']);
            }

            //return redirect()->route('admin_profesionales');
            //return redirect()->route('homeprofesional', ['id' => $id]);
            return back();
            /*
            if($origen == "profesionales"){
                return redirect()->route('admin_profesionales');
            }else{
                return redirect()->route('admin_publicaciones');
            }
            */
        }
        else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }

    }

    public function admin_user_delete($user_hash, $origen){
        $user = User::find(Auth::user()->id);
        $user->permisos = $user->user_type()->first();
        //1-Borar las iamgenes si es que las tiene
            //2-Borrar los mensajes y las imágenes de las consultas si es que las hay
            //3-borrar las consultas
            //4-desatachar los titulos
            //5-desatachar los usuarios de las publicaciones
            //6-Borrar las publicaciones
            //7-Borrar el avatar
            //8-Borrar el usuario

        if($user->permisos->name == "Administrador"){
            $user_publicacion = User::where('hash', $user_hash)->first();
            $publicaciones_all = $user_publicacion->publicaciones()->get();
            if($publicaciones_all){
                foreach($publicaciones_all as $publicacion){
                    //1-borrados de imagenes

                    $imagenes_all = $publicacion->imagenes()->get();
                    if($imagenes_all){
                        foreach($imagenes_all as $imagen){
                            Storage::disk('publicaciones')->delete($imagen->url);
                            $imagen->delete();
                        }
                    }
                    $consultas_all = Interactionhead::where('publicacion_id', $publicacion->id)->get();
                    if($consultas_all){
                        foreach($consultas_all as $consulta){
                            $mensajes_all = $consulta->mensajes()->get();
                            if($mensajes_all){
                                foreach($mensajes_all as $mensaje){
                                    $imagenes_all = $mensaje->imagenes()->get();
                                    //2- Borra imagenes de los mensajes
                                    if($imagenes_all){
                                        foreach($imagenes_all as $imagen){
                                            Storage::disk('interaction')->delete($imagen->url);
                                            $imagen->delete();
                                        }
                                    }
                                    //2- acá ya puedo borrar los mensajes
                                    $mensaje->delete();
                                }
                            }
                            //3- Borra las consultas
                            $consulta->delete();
                        }
                    }
                    //4-desatachado de los títulos asociados
                    $publicacion->titulos_asociados()->detach();
                    //5-desatachado de usuario
                    $publicacion->users()->detach();
                    //6-borrado de la publicacion
                    $publicacion->delete();
                }
            }

            //7-borra el avatar
            Storage::disk('avatares')->delete($user_publicacion->avatar);
            //8-Borra el usuario
            $user_publicacion->delete();

            Session::flash('message','El usuario y todos sus datos se borraron con éxito');
            return back();
            /*
            if($origen == "profesionales"){
                return redirect()->route('admin_profesionales');
            }else{
                return redirect()->route('admin_publicaciones');
            }
            */
            
        }else{
            Session::flash('message', 'Usuario no autorizado');
            return back();
            /*
            if($origen == "profesionales"){
                return redirect()->route('admin_profesionales');
            }else{
                return redirect()->route('admin_publicaciones');
            }
            */
        }

    }

    public function admin_consultas($publicacion_hash){
        //dd($publicacion_hash);
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $publicacion = Publicacion::where('hash', $publicacion_hash)->first();
        $publicacion->user = $publicacion->user()->first();
        $publicacion->user->avatar = Storage::disk('avatares')->url($publicacion->user->avatar);
        $user->permisos = $user->user_type()->first();
        if($user->permisos->name == "Administrador" ){
            //$evento_all = Evento::where('fecha_evento', '<=',$date)->orderby('fecha_evento')->paginate(10);
            $interactionhead_all = Interactionhead::where('publicacion_id', $publicacion->id)->orderby('date', 'DESC')->paginate(10);

            foreach($interactionhead_all as $interactionhead){
                $interactionhead->subjet = $interactionhead->subjet()->first();
                $interactionhead->message_not_read = $interactionhead->messages()->where('read', false)->count();
                $interactionhead->menssage_total = $interactionhead->messages()->count();
            }
                        
            return view('admin.consultas', compact('publicacion', 'interactionhead_all','user'));
            
        }
        else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }
    }

    // Devuelve todas las consultas y mensajes por profesional
    public function admin_consultas_all($user_hash){
        $user = User::where("hash", $user_hash)->first();
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $publicaciones = $user->publicaciones()->get();
        foreach($publicaciones as $publicacion) {
            $publicacion->categoria =  $publicacion->categoria()->first();
            $publicacion->cant_consultas = $publicacion->interactions()->count();
            $publicacion->messages_not_read = 0;
            $publicacion->messages_total = 0;

            $mensajes = $publicacion->interactions()->get();
            $publicacion->not_active = $publicacion->not_active + 1;
            foreach($mensajes as $mensaje){
                $publicacion->messages_not_read = $publicacion->messages_not_read + $mensaje->messages()->where('read', false)->count();
                $publicacion->messages_total = $publicacion->messages_total + $mensaje->messages()->count();
            }
        }
       
        return view('/admin.consultas_all', compact('publicaciones', 'user'));
    }

    public function admin_visitas($publicacion_hash){
        //dd($publicacion_hash);
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $publicacion = Publicacion::where('hash', $publicacion_hash)->first();
        $publicacion->titulo = Titulo::where('id', $publicacion->titulo_id)->first();
        $publicacion->categoria = Categoria::where('id', $publicacion->categoria_id)->first();
        $publicacion->user = $publicacion->user()->first();
        $publicacion->user->avatar = Storage::disk('avatares')->url($publicacion->user->avatar);
        $publicacion->visitas_all = $publicacion->visita()->get();
        $user->permisos = $user->user_type()->first();
        if($user->permisos->name == "Administrador" ){
            //$evento_all = Evento::where('fecha_evento', '<=',$date)->orderby('fecha_evento')->paginate(10);
            $visitas_all = Publicacion_Visita::where('publicacion_id', $publicacion->id)->orderby('id', 'DESC')->paginate(10);
                        
            return view('admin.visitas', compact('publicacion', 'visitas_all','user'));
            
        }
        else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }
    }

    public function admin_whatsapp($publicacion_hash){
        //dd($publicacion_hash);
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $publicacion = Publicacion::where('hash', $publicacion_hash)->first();
        $publicacion->titulo = Titulo::where('id', $publicacion->titulo_id)->first();
        $publicacion->categoria = Categoria::where('id', $publicacion->categoria_id)->first();
        $publicacion->user = $publicacion->user()->first();
        $publicacion->user->avatar = Storage::disk('avatares')->url($publicacion->user->avatar);
        $publicacion->whatsapp_all = $publicacion->visita()->get();
        $user->permisos = $user->user_type()->first();
        if($user->permisos->name == "Administrador" ){
            //$evento_all = Evento::where('fecha_evento', '<=',$date)->orderby('fecha_evento')->paginate(10);
            $whatsapp_all = Publicacion_Whatsapp::where('publicacion_id', $publicacion->id)->orderby('id', 'DESC')->paginate(10);
                        
            return view('admin.whatsapp', compact('publicacion', 'whatsapp_all','user'));
            
        }
        else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }
    }

    public function admin_mensajes($hash){
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();
        if($user->permisos->name == "Administrador"){
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
            return view('/admin.mensajes', compact('interactionhead', 'mensajes_all', 'publicacion', 'user'));
        }else{
            return redirect('/');
        }

    }

    public function admin_categorias(){
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();
        $categoria_all = Categoria::where(['categoria_tipo_id' => 1])->orderby('name', 'ASC')->paginate(10);
        if($user->permisos->name == "Administrador"){
            foreach($categoria_all as $categoria){
                $categoria->icon = Storage::disk('categorias')->url($categoria->icon);
            }

            return view('/admin.categorias', compact('categoria_all', 'user'));
        }else{
            session::flash('message', 'No está autorizado');
            return redirect('/');
        }
    }    

    public function admin_categoria_activar_desactivar($id){
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();
        $categoria = Categoria::where('id', $id)->first();
        if($user->permisos->name == "Administrador"){
            if($categoria->active==1){
                $categoria->active=0;
                $categoria->save();
                session::flash('message', 'La categoría se desactivo con éxito');
            }else{
                $categoria->active=1;
                $categoria->save();
                session::flash('message', 'La categoría se activo con éxito');
            }
            return back();
        }else{
            session::flash('message', 'No está autorizado');
            return redirect('/');
        }
    }
    
    public function admin_categoria_icon(){
        $user = User::find(Auth::user()->id);
        $user->permisos = $user->user_type()->first();
        $data = request()->validate([
            'categoria_id' => '',
            'file' => ['required','image','max:2048'],
        ],[
            'file.required' =>'Debe subir una imagen válida',
        ]);
        
        if($user->permisos->name == "Administrador"){
            $categoria = Categoria::where('id', $data['categoria_id'])->first();
            //borro la imagen actual
            
            Storage::disk('categorias')->delete($categoria->icon);

            $carpetas = Storage::disk('categorias')->directories();
            $directorio_existe = false;
            foreach($carpetas as $carpeta){
                if($carpeta == $categoria->id){   
                    $directorio_existe = true;
                }
            }
            if($directorio_existe == false){
                //$resultado = Storage::makeDirectory('publicaciones/'. $publicacion->id, 0755, true);
                $resultado = Storage::disk('categorias')->makeDirectory($categoria->id, 0777, true);
            }
        
            $path = Storage::disk('categorias')->putFILE($categoria->id, request()->file('file'));
            $categoria->icon = $path;
            $categoria->save(['icon']);

            session::flash('message', 'La imagen se cambió con éxito');
            return back();
        }else{
            session::flash('message', 'No está autorizado');
            return redirect('/');
        }
    }

    public function admin_surveys($survey_id){
        $user = User::find(Auth::user()->id);
       
        $user->permisos = $user->user_type()->first();
        if($user->permisos->name == "Administrador" ){
            $survey = Survey::find($survey_id);         
            $publicacion = $survey->publicacion;
            $user = $survey->user;   
                             
            return view('admin.surveys', compact('publicacion', 'survey', 'user'));
            
        }
        else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }
    }
  
   
    public function admin_profesional_detalle($user_hash){
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        
        $user->permisos = $user->user_type()->first();
        if($user->permisos->name == "Administrador"){

            $user = User::where("hash", $user_hash)->first();
            $user->profile = $user->user_profile()->first();
            $user->avatar = Storage::disk('avatares')->url($user->avatar);
            
            return view('/admin.profesional_detalle', compact('user'));
        }
        else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }

    }

    public function admin_prof_contacts($publicacion_hash){
        $userAdmin = User::find(Auth::user()->id);
        $userAdmin->avatar = Storage::disk('avatares')->url($userAdmin->avatar);
        $publicacion = Publicacion::where('hash', $publicacion_hash)->first();

        $publicacion->user = $publicacion->user()->first();
        $publicacion->user->avatar = Storage::disk('avatares')->url($publicacion->user->avatar);
        $userAdmin->permisos = $userAdmin->user_type()->first();
        
        if($userAdmin->permisos->name == "Administrador" ){
            $publicacion->contacts = $publicacion->surveys()->orderBy('created_at', 'desc')->paginate(10);
            $publicacion->positive_words = $publicacion->most_used_positive_words();
            $publicacion->negative_words = $publicacion->most_used_negative_words();
            $publicacion->reason_no_agree = $publicacion->most_used_reasons_no_agree();
            $publicacion->rating = $publicacion->rating();
            $survey_prof = [];
                        
            return view('admin.prof_contacts', compact('publicacion', 'survey_prof'));
            
        }
        else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }   
       
    }
}
