<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CategoryToolsModel;
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


class CategoryToolController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function getCategoryFiltered(Request $request){
        //dd($request);
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);

            $categories = CategoryToolsModel::query();

            if ($request->get("name")) { //Filtro de nombre
                $name = $request->get("name");
                $categories=$categories->where('name', 'like', "%{$name}%");
            }



            $categories = $categories
            ->select(
                'id',
                'name',
                'active',
               ) 
            ->paginate(15);


            return view('/admin.categoryTools', compact('user', 'categories'));

    }
    
    public function category_edit_form($id){
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();
        $cat=null;
        $cat = CategoryToolsModel::where('id',$id)->first();

        return view('/admin.categoryTool_new', compact('user', 'cat'));
    }


    public function category_existInLoans($id){
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();

        $tools = DB::table('tools')->select('tools.id')
        ->join('categoryTools AS c', 'c.id', '=', 'tools.categoryTool_id')
        ->where('tools.active', 1)
        ->where('c.id', $id)
        ->first();

        return $tools;
    }

    public function categoryTool_new(){
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();
        $cat=null;

        return view('/admin.categoryTool_new', compact('user', 'cat'));
    }
   
    public function admin_catSave(Request $request){
        $dataForm = request()->validate([
            'name' => 'required',
        ],[
            'name.required' => 'Debe ingresar nombre',
        ]);

        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);

        if($request['id']){
            //dd($request);
            CategoryToolsModel::where('id',$request['id'])->update([
                'name'=>$dataForm['name'],  
            ]);
            Session::flash('message', 'Edicion exitosa');
            return redirect()->route('admin_categoryTools');  

            }else{
                //dd($request);

            $cat = CategoryToolsModel::create([
                'name' => $dataForm['name'],
                'active' => 1,               
               
            ]);
            $cat->save();
            Session::flash('message', 'Ingreso exitoso');
            return redirect()->route('admin_categoryTools');   
            }

        
    }

    public function categoryTool_active($id){
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();
         
        if($user->permisos->name == "Administrador"){
            $cat = CategoryToolsModel::where('id',$id)->first();
            $state=null;

            if($cat->active==1){
                $result=$this->category_existInLoans($id);
                //dd($result);
                if($result==null){
                    Session::flash('message', 'Se edito el estado con exito');
                    $state=0;
                }else{
                    $state=1;
                    Session::flash('message', 'La Categoria esta en uso,  no se puede editar el estado');
                }
            }else{
                Session::flash('message', 'Se edito el estado con exito');
                $state=1;
            }

            CategoryToolsModel::where('id',$id)->update([
                'active'=>$state,  
            ]);

            return redirect()->route('admin_categoryTools'); 

        }else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }
    }
}
