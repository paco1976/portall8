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

    public function toolsList(Request $request){
        $user = User::find(Auth::user()->id);
        // $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();

        $categories = CategoryToolsModel::all();
        $tools = ToolModel::query();
        
        $categoryId = "";
        // if($user->permisos->name == "Administrador"){
            $tools = $tools 
            ->join('categorytools AS c', 'c.id', '=', 'tools.categoryTool_id');

            if ($request->get("categoryId")) { //Filtro de estado
                $categoryId = $request->get("categoryId");             
                    $tools = $tools->where('tools.categoryTool_id', $categoryId);
            }
            //dd($request->get("categoryId"));
            $tools = $tools
            ->select(
                'tools.id as id',
                'tools.name as name',
                'tools.description as description',
                'tools.nameImage as nameImage',
                'tools.active as active',
                'tools.categoryTool_id as category',
                'c.name as categoryName'
               ) 
            ->paginate(15);
            return view('admin.tools', compact('user', 'tools', 'categories', 'categoryId'));

        // }else{
        //     session::flash('message', 'No está autorizado para esta acción');
        //     return redirect('/');
        // }
    }

    public function tool_new_form(){
       
        $user = User::find(Auth::user()->id);
        // $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();
        $categories = CategoryToolsModel::where('active', 1)->get();

        // $categories = CategoryToolsModel::all();
        $tool=null;
        return view('/admin.tool_new', compact('user', 'categories', 'tool'));
    }

    public function tool_edit_form($id){
        $user = User::find(Auth::user()->id);
        // $user->avatar = Storage::disk('avatares')->url($user->avatar);
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
                'tools.nameImage as nameImage',
                'c.name as categoryName',
                'c.id as categoryId',
            )           
            ->get();             
            $tool=$tool[0];

            $toolHasImage = !empty($tool->nameImage);

            return view('/admin.tool_new', compact('user', 'categories', 'tool', 'toolHasImage'));
    }

    public function tool_save(Request $request){
        $user = User::find(Auth::user()->id);
        $user->permisos = $user->user_type()->first();
         if($user->permisos->name == "Administrador"){
            $data = request()->validate([
                'categoryId' => 'required',
                'name' => 'required',
                'description' => 'required',
                'nameImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ],[
                'categoryId.required' =>'Debe seleccionar una categoría',
                'name.required' =>'Debe ingresar un nombre',
                'description.required' => 'Debe colocar una descripción sobre la herramienta',
            ]);           
        
            if($request['toolId']){
                ToolModel::where('id',$request['toolId'])->update([
                    'name'=>$data['name'],
                    'description'=>$data['description'],
                    'categoryTool_id'=>$data['categoryId']                    
                 ]);
                 
                 $tool = ToolModel::find($request['toolId']);
                 if(!$tool->nameImage){
                     if ($request->hasFile('nameImage')){
                        $file = $request->file('nameImage');
                        $filename = $file->getClientOriginalName(); // Get the original filename
                        $path = Storage::disk('tools')->putFileAs($tool->id, $file, $filename); // Save the file with the original filename
                        $tool->nameImage = $path;
                        $tool->save();
                    }   
                 }

                 Session::flash('message', 'Edición exitosa');
                 return redirect()->route('admin_tool_edit', $tool->id);  

                }else{

                $tool = ToolModel::create([
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'categoryTool_id' => $data['categoryId'],
                    'active'=> 1,                  
                ]);
                $tool->save();

                    if ($request->hasFile('nameImage')){
                        $file = $request->file('nameImage');
                        $filename = $file->getClientOriginalName(); // Get the original filename
                        $path = Storage::disk('tools')->putFileAs($tool->id, $file, $filename); // Save the file with the original filename
                        $tool->nameImage = $path;
                        $tool->save();
                    }            
                

                Session::flash('message', 'Ingreso exitoso');
                return redirect()->route('admin_tool_new');   
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
         if($user->permisos->name == "Administrador"){

                if($tool[0]->active==1){

                    Session::flash('message', 'Se deshabilito la herramienta');
                    ToolModel::where('id',$id)->update([
                        'active'=> 0,                  
                     ]);
                }else{

                    //Solo si, La categoria adjudicada esta habilitada.
                    $tools = DB::table('tools')->select('tools.id')
                    ->join('categorytools AS c', 'c.id', '=', 'tools.categoryTool_id')
                    ->where('tools.id', $id)
                    ->where('c.active', 1)
                    ->first();

                    //dd($tools);
                    if($tools==null){
                        Session::flash('message', 'Habilite la categoria de la herramienta para poder darla de alta.');
                    }else{
                        Session::flash('message', 'Se habilito la herramienta');
                        ToolModel::where('id',$id)->update([
                            'active'=> 1,                  
                         ]);
                    }
                    
                }
                
                 return redirect()->route('toolsList');  

        }else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }
    }
    
    public function deleteToolImage($id) {
        $tool = ToolModel::find($id);    
        
        if ($tool->nameImage) {
            Storage::disk('tools')->delete($tool->nameImage);
            $tool->nameImage = '';
            $tool->save();
        }
    
        return redirect()->route('admin_tool_edit', ['id' => $id])->with('message', 'Imagen eliminada exitosamente');
    }
    
}
