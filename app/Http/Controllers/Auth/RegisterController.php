<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\User_Profile;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Image;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'mobile'=> ['required'],
            'dni' => ['required', 'string', 'max:255'],
            'avatar' => ['required','image','max:2048'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'user_type' => ['required'],
            'phone' => '',
            'facebook' => '',
            'instagram' => '',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        /*
        return User::create([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        */
        $user = User::create([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'dni' => $data['dni'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'type_id' => $data['user_type'],
            'cfp_id' => 13,
        ]);
        //'cfp_id' => $data['user_cfp'],
        $user->hash = md5($user->id);
        $user->save();
        
         //subir foto nuevo metodo
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
                
        User_Profile::create([
            'user_id' => $user->id,
            'mobile' => $data['mobile'],
            'phone' => $data['phone'],
            'facebook' => $data['facebook'],
            'instagram' => $data['instagram'],
        ]);

        return  $user;

    }
}
