<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\User_Profile;
use App\Models\ToolModel;
use App\Models\CategoryToolsModel;

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
 
    // public function index(){

    //     return view('admin.tools');
    // }

    public function admin_toolsList(Request $request){
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();

        $categories = CategoryToolsModel::all();
        $tools = ToolModel::query();

        if($user->permisos->name == "Administrador"){
            $tools = $tools 
            ->join('categoryTools AS c', 'c.id', '=', 'Tools.categoryTool_id');

            if ($request->get("categoryId")) { //Filtro de estado
                $categoryId = $request->get("categoryId");             
                    $tools = $tools->where('Tools.categoryTool_id', $categoryId);
            }
            //dd($request->get("categoryId"));
            $tools = $tools
            ->select(
                'Tools.id as id',
                'Tools.name as name',
                'Tools.description as description',
                'Tools.active as active',
                'Tools.categoryTool_id as category',
                'c.name as categoryName'
               ) 
            ->paginate(15);
            return view('admin.tools', compact('user', 'tools', 'categories'));

        }else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }
    }

    public function tool_new_form(){
       
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();
        $categories = CategoryToolsModel::all();
        $tool=null;
        return view('/admin.tool_new', compact('user', 'categories','tool'));
    }

    public function tool_edit_form( $id){
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();
        $categories = CategoryToolsModel::all();
        $tool=null;
            $tool = ToolModel::query();
            $tool = $tool 
            ->join('categorytools AS c', 'c.id', '=', 'tools.categoryTool_id');
            $tool = $tool
            ->where('tools.id', '=', $id);
            $tool = $tool
            ->select(
                'tools.id as id',
                'tools.name as name',
                'tools.description as description',
                'c.name as categoryName',
                'c.id as categoryId',
            )           
            ->get();             
            $tool=$tool[0];
            return view('/admin.tool_new', compact('user', 'categories', 'tool'));
    }

    public function tool_save(Request $request){
        $user = User::find(Auth::user()->id);
        $user->permisos = $user->user_type()->first();
         if($user->permisos->name == "Administrador"){
            $data = request()->validate([
                'categoryId' => 'required',
                'name' => 'required',
                'description' => 'required',
            ],[
                'categoryId.required' =>'Debe seleccionar una categoria',
                'name.required' =>'Debe ingresar un nombre',
                'description.required' => 'Debe colocar una descripción sobre la herramienta',
            ]);

            if($request['toolId']){
                            //dd($request);
                ToolModel::where('id',$request['toolId'])->update([
                    'name'=>$data['name'],
                    'description'=>$data['description'],
                    'categoryTool_id'=>$data['categoryId']                    
                 ]);
                 Session::flash('message', 'Edicion exitosa');
                 return redirect()->route('admin_tool');  

                }else{
                    //dd($request);

                $tool = ToolModel::create([
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'categoryTool_id' => $data['categoryId'],
                    'active'=> 1,                  
                ]);
                $tool->save();
                Session::flash('message', 'Ingreso exitoso');
                return redirect()->route('admin_tool');   
            }
            
        }else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }

    }

    public function admin_tool_enable($id){ 

        $user = User::find(Auth::user()->id);
        $user->permisos = $user->user_type()->first();
        $tool = ToolModel::where('id', $id)->get();
        // dd($tool[0]->state_id);
         if($user->permisos->name == "Administrador"){

                if($tool[0]->state_id==1){
                    Session::flash('message', 'Se deshabilito la herramienta');
                    ToolModel::where('id',$id)->update([
                        'active'=> 0,                  
                     ]);
                }else{
                    Session::flash('message', 'Se habilito la herramienta');
                    ToolModel::where('id',$id)->update([
                        'active'=> 1,                  
                     ]);
                }
                
                 return redirect()->route('admin_tool');  

        }else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }
    }
    
}
