<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\User_Profile;
use App\Models\ToolModel;
use App\Models\LoanModel;

use Barryvdh\Debugbar\Facade as Debugbar;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Intervention\Image\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class ToolController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
 
    public function index(){

        return view('admin.tools');
    }

    public function admin_toolsList(Request $request){

        // $user = User::find(Auth::user()->id);
        // $user->avatar = Storage::disk('avatares')->url($user->avatar);
        // $user->permisos = $user->user_type()->first();
        // if($user->permisos->name == "Administrador"){
        //     // ->join('articles', 'entries.id', '=', 'articles.entryID')
        //     // ->orderBy('articles.created_at', 'desc')

        //             $tools= DB::table('tools AS t')
        //             ->leftjoin('states AS e', 'e.id', '=', 't.state_id')
        //             ->select(
        //                 't.id as toolId',
        //                 't.name as toolName',
        //                 't.description as description',
        //                 'e.name as estado',
        //                ) 
        //             ->paginate(15);
         
        //     Debugbar::info($loans);
        //         //dd($loans);
        //     return view('/admin_tool', compact('user', 'tools'));
        // }else{
        //     return redirect('/');
        // }
    }

    public function tool_new(Request $request){
        //dd($hash_user);
        $user = User::find(Auth::user()->id);
        // $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();
        // $user = User::where("hash", $hash_user)->first();
        //dd($user);
        return view('/admin.tool_new', compact('user'));
    }

    public function tool_save(Request $request){

        // $user = User::where("hash", $hash_user)->first();
        $user = User::find(Auth::user()->id);
        $user->permisos = $user->user_type()->first();

         if($user->permisos->name == "Administrador"){

            //dd($user);

            $data = request()->validate([
                // 'category_id' => 'required',
                'name' => 'required',
                'description' => 'required',
            ],[
                // 'category_id.required' =>'Debe seleccionar una categoria',
                'name.required' =>'Debe ingresar un nombre',
                'description.required' => 'Debe colocar una descripción sobre la herramienta',
            ]);
                           
            $tool = ToolModel::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'state_id' => 1,
                // 'category_id' => $category->category_id,
            ]);
            
        
            $tool->save();
       
            Session::flash('message', 'Ingreso exitoso');
            return back();
        }else{
            return redirect('/');
        }

    }
    
}
