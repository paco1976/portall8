<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\CategoriaTipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Mail;
//use Intervention\Image\Facades\Image as Image;
//use Intervention\Image\Image;
use Image;

class CategoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function admin_categorias(Request $request){
        //$publicaciones = Publicacion::Buscador_admin($request->name)->paginate(10);
        
        $categoria_all = Categoria::Buscador_admin_cat($request->name)->orderby('name', 'ASC')->paginate(10);
        if(Auth::user()->user_type()->first()->name == "Administrador"){
            foreach($categoria_all as $categoria){
                $categoria->icon = Storage::disk('categorias')->url($categoria->icon);
            }

            return view('/admin.categoria.index', compact('categoria_all'));
        }else{
            session::flash('message', 'No está autorizado');
            return redirect('/');
        }
    }    

    public function admin_categoria_activar_desactivar($id){
        $categoria = Categoria::where('id', $id)->first();
        if(Auth::user()->user_type()->first()->name== "Administrador"){
            if($categoria->active==1){
                $categoria->active=0;
                $categoria->save();
                session::flash('message', 'La categoría se desactivo con éxito');
            }else{
                $categoria->active=1;
                $categoria->save();
                session::flash('message', 'La categoría se activo con éxito');
            }
            return back();
        }else{
            session::flash('message', 'No está autorizado');
            return redirect('/');
        }
    }
    
    public function admin_categoria_icon(Request $request){
        $data = request()->validate([
            'categoria_id' => '',
            'file' => ['required','image','max:2048'],
        ],[
            'file.required' =>'Debe subir una imagen válida',
        ]);
        
        $categoria = Categoria::where('id', $data['categoria_id'])->first();
       
        
        //$destinationPath = public_path('/images');
        //$image->move($destinationPath, $input['imagename']);
        
        if(Auth::user()->user_type()->first()->name == "Administrador"){
            //$categoria = Categoria::where('id', $data['categoria_id'])->first();
            //borro la imagen actual
            
            Storage::disk('categorias')->delete($categoria->icon);

            $carpetas = Storage::disk('categorias')->directories();
            $directorio_existe = false;
            foreach($carpetas as $carpeta){
                if($carpeta == $categoria->id){   
                    $directorio_existe = true;
                }
            }
            if($directorio_existe == false){
                //$resultado = Storage::makeDirectory('publicaciones/'. $publicacion->id, 0755, true);
                $resultado = Storage::disk('categorias')->makeDirectory($categoria->id, 0777, true);
            }
            
            $image = $request->file('file');
            $input['imagename'] = time().'.'.$image->extension();
        
            $destinationPath = Storage::disk('categorias')->path($categoria->id);
            $img = Image::make($image->path());
            $img->resize(447, 447, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['imagename']);

            //$path = Storage::disk('categorias')->putFILE($categoria->id, request()->file('file'));
            $path = $categoria->id.'/'.$input['imagename'];
            //dd($path);
            $categoria->icon = $path;
            $categoria->save(['icon']);

            session::flash('message', 'La imagen se cambió con éxito');
            return back();
        }else{
            session::flash('message', 'No está autorizado');
            return redirect('/');
        }
    }

    public function admin_categoria_new(Request $request){
        $categoria_tipo_all = CategoriaTipo::all();
        if(Auth::user()->user_type()->first()->name  == "Administrador"){
            return view('/admin.categoria.new', compact('categoria_tipo_all'));
        }else{
            session::flash('message', 'No está autorizado');
            return redirect('/');
        }
    }
    
    public function admin_categoria_save(Request $request){
        $data = request()->validate([
            'categoria_tipo_id' => '',
            'name' => ['required', 'string', 'max:255'],
            'icono' => ['required','image','max:2048'],
        ],[
            'name.required' => 'Debe colocar un nombre de categoría',
            'icono.required' =>'Debe subir una imagen válida',
        ]);
        $categoria = Categoria::create([
            'name' => $data['name'],
            'categoria_tipo_id' => $data['categoria_tipo_id'],
        ]);
        
        if(Auth::user()->user_type()->first()->name  == "Administrador"){
            $carpetas = Storage::disk('categorias')->directories();
            $directorio_existe = false;
            foreach($carpetas as $carpeta){
                if($carpeta == $categoria->id){   
                    $directorio_existe = true;
                }
            }
            if($directorio_existe == false){
                //$resultado = Storage::makeDirectory('publicaciones/'. $publicacion->id, 0755, true);
                $resultado = Storage::disk('categorias')->makeDirectory($categoria->id, 0777, true);
            }
            
            $image = $request->file('icono');
            $input['imagename'] = time().'.'.$image->extension();
        
            $destinationPath = Storage::disk('categorias')->path($categoria->id);
            $img = Image::make($image->path());
            $img->resize(447, 447, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['imagename']);
            $path = $categoria->id.'/'.$input['imagename'];
            $categoria->icon = $path;
            $categoria->save(['icon']);

            //$path = Storage::disk('categorias')->putFILE($categoria->id, request()->file('icono'));
            //$categoria->icon = $path;
            //$categoria->save(['icon']);

            session::flash('message', 'La se ha creado con éxito');
            return redirect()->route('admin_categorias');
        }else{
            session::flash('error', 'ups! hubo un problema y no se pudo crear la categoría');
            return back();
        }
    }
    
    public function admin_categoria_delete($id){
        $categoria = Categoria::where('id',$id)->first();
        $cat_publicaciones = $categoria->publicaciones()->get();
        //dd($cat_publicaciones->count());
        if ($cat_publicaciones->count() > 0) {
            session::flash('error', 'ups! No se puede borrar esta categoría porque tiene ' . $cat_publicaciones->count() . ' publicaciones. Debe borar las publicaciones para poder borrar la categoria');
            return redirect()->route('admin_categorias');
        } else {
            $categoria->delete();
            session::flash('message', 'La categoría se ha eliminado con éxito');
            return back();
        }
        

    }
  
    public function admin_categoria_edit($id){
        $categoria = Categoria::where('id', $id)->first();
        if(Auth::user()->user_type()->first()->name  == "Administrador"){
            $supercategoria_all = CategoriaTipo::where('active','1')->pluck('name', 'id');
            return view('/admin.categoria.edit', compact('categoria', 'supercategoria_all'));
        }else{
            session::flash('message', 'No está autorizado');
            return redirect('/');
        }
    }
    
    public function admin_categoria_update(Request $request){
        $data = request()->validate([
            'id' =>'',
            'categoria_tipo_id' => 'required',
            'name' => ['required', 'string', 'max:255'],
        ],[
            'name.required' => 'Debe colocar un nombre de categoría',
        ]);
        
        
        if(Auth::user()->user_type()->first()->name  == "Administrador"){
            $categoria = Categoria::where('id', $data['id']);
            $categoria->name = $data['name'];
            $categoria->categoria_tipo_id = $data['categoria_tipo_id'];
            $categoria->update([
                'name' => $data['name'], 
                'categoria_tipo_id' => $data['categoria_tipo_id']
            ]);
            session::flash('message', 'La categoría se ha creado con éxito');
            return redirect()->route('admin_categorias');
        }else{
            session::flash('error', 'ups! hubo un problema, no tiene premisos para esta acción');
            return back();
        }
    }
}
