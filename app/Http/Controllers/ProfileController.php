<?php

namespace App\Http\Controllers;

use App\Models\User_Cfp;
use App\Models\User_Profile;
use App\Models\User;
use App\Models\Zonas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Image;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function nuevo(){
        $user = User::find(Auth::user()->id);
        if($user->avatar == '/img/team/perfil_default.jpg'){
            //no convierte la url
        }else{
            $user->avatar = Storage::disk('avatares')->url($user->avatar);
            //disk('avatares')
        }
        $user_cfp = User_Cfp::where('id',$user->cfp_id)->first();
        //$user_profile = User_Profile::find($user->_id);
        $user_cfp_all = User_Cfp::all();
        $user_profile ="";
        $zonas_all = Zonas::all();
        //$user_profile = User_Profile::find($id);
        //dd($zonas_all);

        return view('perfil_new', compact('user', 'user_cfp','user_cfp_all', 'user_profile', 'zonas_all'));

    }

    public function store(){
        $user = User::find(Auth::user()->id);
        //dd($user->id);
        $data = request()->validate([
            'mobile'=> 'required',
            'user_cfp'=> 'required',
            'phono'=> '',
            'twitter' => '',
            'facebook' => '',
            'instagram' => '',
            'linkedin' => '',
            'zonas[]'=>'',

        ],[
            'mobile.required'=>'El campo celular es obligatorio',
            'user_cfp.required'=> 'CFP es obligatorio',
        ]);
        
        $user->save(['user_cfp']);
        $zonas_new = request('zonas');

        if(is_array($zonas_new)){
            foreach($zonas_new as $zona) {
                $user->zonas()->attach(Zonas::where('name', $zona)->first());
            }
        }
        
        /*
        foreach(request('zonas') as $zona) {
            $user->zonas()->attach(Zonas::where('name', $zona)->first());
        }
        */

        User_Profile::create([
            'user_id' => $user->id,
            'mobile' => $data['mobile'],
            'phone' => $data['phono'],
            'twitter' => $data['twitter'],
            'facebook' => $data['facebook'],
            'instagram' => $data['instagram'],
            'linkedin' => $data['linkedin'],
        ]);

        Session::flash('message', 'El perfil se actualizado con éxito');
        return redirect('perfil');
    }

    public function edit(){
        
        $user = User::find(Auth::user()->id);
        if($user->avatar == '/img/team/perfil_default.jpg'){
            //no convierte la url
        }else{
            $user->avatar = Storage::disk('avatares')->url($user->avatar);
            //disk('avatares')
        }
        $user_profile = User_Profile::where('user_id',$user->id)->first();
        $user_cfp = User_Cfp::where('id',$user->cfp_id)->first();
        $user_cfp_all = User_Cfp::all();
        //dd($user->profile()->first()->mobile);
        //no esta en uso
        //$user->profiles = User::find(1)->user_profile();
        //$user->cfp = User::find(1)->user_cfp();
        $zonas_all = Zonas::all();
        $miszonas = $user->zonas()->get();
            //{{ route('publicacion', ['id'=> $user->id]) }}
        return view('perfil_edit', compact('user', 'user_cfp', 'user_profile', 'user_cfp_all', 'miszonas', 'zonas_all'));
        
         //return redirect()->route('perfil');
    }

    public function update(){
        //$user = User::find($id);
        $user = User::find(Auth::user()->id);
        $profile = User_Profile::where('user_id',$user->id)->first();
        //dd(request('zonas'));
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
                'zonas[]'=>'sometimes|required',
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
                'zonas[]'=>'sometimes|required',
            ],[
                'mobile.required'=>'El campo celular es obligatorio',
                'name' => 'El campo Nombre es obligatorio',
                'last_name' => 'El campo Apellido es obligatorio',
                'mobile'=> 'El campo celular es obligatorio',
                'dni' => 'El campo DNI es obligatorio'                
            ]);
        }

        //$user->cfp_id = 15;
        $user->name = $data['name'];
        $user->last_name = $data['last_name'];
        $user->dni = $data['dni'];
        $user->email = $data['email'];
        
        if ($user->save(['name','last_name','dni','email'])) {
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
            //dd($zonas_new);
            if(is_array($zonas_new)){
                //dd('entro a las zonas');
                foreach($zonas_all as $zona) {
                    $user->zonas()->detach(Zonas::where('name', $zona)->first());
                }
                foreach($zonas_new as $zona) {
                    $user->zonas()->attach(Zonas::where('name', $zona)->first());
                }
            }

            Session::flash('message', 'El perfil se actualizado con éxito');
            return back();
        } else {
            Session::flash('error', 'El perfil no se pudo actualizar, revise los datos');
            return back();
        }  

            
           /*
            $user->cfp_id = $data['user_cfp'];

            $user_profile->user_id=$user->id;
            $user_profile->mobile= $data['mobile'];
            $user_profile->phone= $data['phono'];
            $user_profile->twitter= $data['twitter'];
            $user_profile->facebook= $data['facebook'];
            $user_profile->instagram= $data['instagram'];
            $user_profile->linkedin= $data['linkedin'];
            $user->save(['user_cfp']);

            $user_profile->save(['mobile', 'phone', 'twitter', 'facebook', 'instagram', 'linkedin']);
           
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
                        
            
            Session::flash('message', 'El perfil se actualizado con éxito');
            return redirect('perfil');
            */
            //return redirect()->route('perfil');
        
    }

}
