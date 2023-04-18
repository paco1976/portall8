<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Intervention\Image\Image;
use Mail;

class ReferenteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profesionales(Request $request){
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        
        /* BORRAR ESTO CUANDO ESTÉ LISTO*/
        /*
        $publicacion_all = Publicacion::all();
        foreach($publicacion_all as $publi){
            $publi->hash = md5($publi->id);
            $publi->save(['hash']);
        }
        $user_all = User::all();
        foreach($user_all as $usr){
            $usr->hash = md5($usr->id);
            $usr->save();
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
        $user->cfp = $user->cfp()->first();
        if($user->permisos->name == "Referente"){

            $user_all = User::Buscador($request->name)->where('cfp_id', $user->cfp_id)->where( 'type_id', 1)->paginate(10);
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
                foreach($usr->publicaciones as $publicacion){
                    if($publicacion){
                        $consultas = $publicacion->interactions()->get();
                        $publicacion->not_active = $publicacion->not_active + 1;
                        foreach($consultas as $consulta){
                            $usr->menssage_not_read = $usr->menssage_not_read  + $consulta->messages()->where('read', false)->count();
                            $usr->menssage_total = $usr->menssage_total + $consulta->messages()->count();
                        }
                    }
                    
                }
                
            }
            return view('/referente.profesionales', compact('user', 'user_all'));
        }
        else{
            return redirect('/');
        }

    }


    Public function publicaciones_user($user_hash){
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user_publicacion = User::where('hash', $user_hash)->first();
        $user->permisos = $user->user_type()->first();
        if($user->permisos->name == "Referente" && $user_publicacion->cfp_id == $user->cfp_id){
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
                        $publicacion->menssage_total = $publicacion->menssage_total + $consulta->messages()->count();
                    }
                }
                
            }
            //session::flash('message', 'No está autorizado para esta acción');
            return view('/referente.publicaciones_user', compact('user_publicacion', 'user'));
            //return view('/referente.publicaciones_user', compact('user', 'publicaciones'));
            //return view('homeprofesional', compact('user_type_all','user_cfp_all', 'publicacion','categoria', 'titulo', 'user', 'user_profile', 'zonas', 'subjets'));
        }
        else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }

    }

    Public function publicacion_user($publicacion_hash){
        //dd($publicacion_hash);
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();

        $publicacion = Publicacion::where('hash', $publicacion_hash)->first();
        
        $publicacion->user = $publicacion->user()->first();
        
        if($user->permisos->name == "Referente" && $publicacion->user->cfp_id == $user->cfp_id){
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
            return view('/referente.publicacion_user', compact('publicacion', 'user'));
            //return back();
        }
        else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }

    }

    public function publicaciones_aprobar_desaprobar($publicacion_hash){
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();

        $publicacion = Publicacion::where('hash', $publicacion_hash)->first();
        $publicacion_user = $publicacion->user()->first();

        if($user->permisos->name == "Referente" && $publicacion_user->cfp_id == $user->cfp_id){

            if($publicacion->aprobado == 0){
                session::flash('message', 'La publicación se activo con éxito');
                $publicacion->aprobado = 1;
                $publicacion->save(['aprobado']);
            }else{
                session::flash('message', 'La publicación se desactivo con éxito');
                $publicacion->aprobado = 0;
                $publicacion->save(['aprobado']);
            }

            //return redirect()->route('publicaciones_user', ['user_hash' => $publicacion_user->hash]);
            return back();
            //return redirect()->route('homeprofesional', ['id' => $id]);
        }
        else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }

    }

    public function publicaciones(){
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();
        if($user->permisos->name == "Referente"){
            //todas las publicaciones del cfp del referente que está conectado
            $publicaciones = DB::table('publicacion')
            ->join('publicacion_user', 'publicacion.id', '=', 'publicacion_user.publicacion_id')
            ->join('users', 'users.id', '=', 'publicacion_user.user_id')
            ->select('publicacion.*')
            ->where('users.cfp_id', $user->cfp_id)
            ->paginate(10);
            
            // ->select('publicacion.*','users.name','users.last_name','users.dni','users.avatar','users.email','users.type_id','users.cfp_id','users.name','users.active')
            foreach($publicaciones as $publicacion){
                $publi_individual = Publicacion::where('hash', $publicacion->hash)->first();
                $publicacion->user = $publi_individual->user()->first();
                //dd($publicacion);
                $publicacion->titulo = Titulo::where('id', $publicacion->titulo_id)->first();
                $publicacion->categoria = Categoria::where('id', $publicacion->categoria_id)->first();
                //$consultas = $publicacion->interactions()->get();
                
                $consultas = Interactionhead::where('publicacion_id',$publicacion->id);
                $publicacion->cant_not_read = 0;
                $publicacion->cant_consultas = 0;
                    foreach($consultas as $consulta){
                        $publicacion->cant_not_read = $publicacion->cant_not_read + $consulta->messages()->where('read', false)->count();
                        $publicacion->cant_consultas = $publicacion->cant_consultas + $consulta->messages()->count();
                    }
            }
            return view('/referente.publicaciones', compact('user', 'publicaciones'));
        }else{
            return redirect('/');
        }

        /*  
        $users = DB::table('users')
            ->join('contacts', 'users.id', '=', 'contacts.user_id')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->select('users.*', 'contacts.phone', 'orders.price')
            ->get();

        */
    }

    public function publicacion($hash){
        $user = User::find(Auth::user()->id);
                if($user->avatar == '/img/team/perfil_default.jpg'){
            //no convierte la url
        }else{
            $user->avatar = Storage::disk('avatares')->url($user->avatar);
        }
        $user->permisos = $user->user_type()->first();
        if($user->permisos->name == "Referente"){
            
            $publicacion = Publicacion::where('hash', $hash)->first();
            dd($publicacion);
            $publicacion->imagenes = $publicacion->imagenes()->get();
            $user_publicacion = $publiacion->user_publicacion()->first();
            
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

            
            return view('referente.publicacion', compact('categoria_servicios_all', 'categoria_productos_all',  'user_type_all','user_cfp_all', 'publicacion','categoria', 'titulo', 'user_publicacion', 'user_profile', 'zonas', 'subjets', 'user'));
        }else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }
        

    }

    public function consultas($publicacion_hash){
        //dd($publicacion_hash);
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $publicacion = Publicacion::where('hash', $publicacion_hash)->first();
        $publicacion->user = $publicacion->user()->first();
        $user->permisos = $user->user_type()->first();
        if($user->permisos->name == "Referente" && $publicacion->user->cfp_id == $user->cfp_id){
            //$evento_all = Evento::where('fecha_evento', '<=',$date)->orderby('fecha_evento')->paginate(10);
            $interactionhead_all = Interactionhead::where('publicacion_id', $publicacion->id)->orderby('date', 'DESC')->paginate(10);

            foreach($interactionhead_all as $interactionhead){
                $interactionhead->subjet = $interactionhead->subjet()->first();
                $interactionhead->message_not_read = $interactionhead->messages()->where('read', false)->count();
                $interactionhead->menssage_total = $interactionhead->messages()->count();
            }
                        
            return view('referente.consultas', compact('publicacion', 'interactionhead_all','user'));
            //return redirect()->route('publicaciones_user', ['user_hash' => $publicacion_user->hash]);
            //return redirect()->route('homeprofesional', ['id' => $id]);
        }
        else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }

        
    }

    public function mensajes($hash){
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
            return view('/referente.mensajes', compact('interactionhead', 'mensajes_all', 'publicacion', 'user'));
        }else{
            return redirect('/');
        }

    }

    public function user_aprobar_desaprobar($user_hash){
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();

        //$publicacion = Publicacion::where('hash', $publicacion_hash)->first();
        $profesional_user = User::where('hash', $user_hash)->first();

        if($user->permisos->name == "Referente" && $profesional_user->cfp_id == $user->cfp_id){

            if($profesional_user->active == 0){
                session::flash('message', 'El usuario se activo con éxito');
                $profesional_user->active = 1;
                $profesional_user->save(['active']);
            }else{
                session::flash('message', 'El usuario se desactivo con éxito');
                $profesional_user->active = 0;
                $profesional_user->save(['active']);
            }

            return redirect()->route('profesionales');
            //return redirect()->route('homeprofesional', ['id' => $id]);
        }
        else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }

    }

    
  

}
