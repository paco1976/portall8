<?php

namespace App\Http\Controllers;

use App\Models\User_Cfp;
use App\Models\User_type;
use App\Models\User;
use App\Models\User_Profile;
use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $user = User::find(Auth::user()->id);
        $user->type = $user->user_type()->first();
       
        $miszonas = $user->zonas()->get();
        $user_profile = User_Profile::where('user_id',$user->id)->first();
        $user_type_all = User_type::all();
        $user_cfp_all = User_Cfp::all();
        return view('perfil', compact('user', 'user_type_all','user_cfp_all', 'user_profile', 'miszonas'));
    }
    
}
