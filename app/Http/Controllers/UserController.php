<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Titulo;
use App\Models\Categoria;
use App\Models\User_Cfp;
use App\Models\User_type;
use App\Models\User_Profile;
use App\Models\Zonas;
use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\File;
use Intervention\Image\Image;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //redirigue dependiendo el tipo de usuario
    public function index(){
        $user = User::find(Auth::user()->id);
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
        
        if($user->type->name == "Profesional"){
            return view('perfil', compact('user', 'user_profile', 'user_cfp', 'miszonas'));
        }elseif(($user->type->name == "Referente")){
            return view('referente.perfil', compact('user'));
        }elseif(($user->type->name == "Administrador")){
            $publicaciones_all = Publicacion::all();
            $visitas = 0;
            $categorias = Categoria::get()->count();
            $publicaciones = $publicaciones_all->count();
            $mensajes = 0;
            $whatsapp = 0;

            foreach($publicaciones_all as $publicacion) {
            $mensajes = $mensajes + $publicacion->interactions()->count();
            $visitas = $visitas + $publicacion->visita()->count();
            $whatsapp= $whatsapp + $publicacion->whatsapp()->count();
            }
            return view('admin.perfil', compact('user', 'categorias', 'publicaciones', 'visitas','mensajes', 'whatsapp'));
        }else{
            return redirect('/');
        }
       
    }

    public function avatardelete(){
        $user = User::find(Auth::user()->id);
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
        
        return redirect('perfil');
    }

    public function avatarupload(){
        $user = User::find(Auth::user()->id);
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
        return redirect('perfil');
    }
 
    public function updatepassword(){
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
        
        return redirect('clave');
    }
}
