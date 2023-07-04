<?php

namespace App\Http\Controllers;

use App\Models\User;
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
            ]);
            $cat->save();
            Session::flash('message', 'Ingreso exitoso');
            return redirect()->route('admin_categoryTools');   
            }

        
    }

    public function categoryTool_delete($id){
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();
         
        if($user->permisos->name == "Administrador"){
            CategoryToolsModel::where('id',$id)->delete();
            Session::flash('message', 'Se elimino con exito');
            return redirect()->route('admin_categoryTools'); 
        }else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }
    }
}
