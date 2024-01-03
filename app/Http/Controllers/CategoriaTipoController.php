<?php

namespace App\Http\Controllers;

use App\Models\CategoriaTipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Image;

/**
 * Class CategoriaTipoController
 * @package App\Http\Controllers
 */
class CategoriaTipoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categoriaTipos = CategoriaTipo::paginate(10);
        
        foreach ($categoriaTipos as $cat) {
            if ( $cat->icon != "img/slides/slide-prueba2.jpg") {
                $cat->icon = Storage::disk('supercategorias')->url($cat->icon);
            }
        }
       

        $collection = collect([
            ['active_id' => '1', 'name' => 'Activado'],
            ['active_id' => '0', 'name' => 'Desactivado'],
        ]);
        $active = $collection->pluck('name', 'active_id');

        return view('admin.categoria-tipo.index', compact('categoriaTipos','active'))
            ->with('i', (request()->input('page', 1) - 1) * $categoriaTipos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoriaTipo = new CategoriaTipo();
        $categoriaTipos = CategoriaTipo::paginate(10);
        $collection = collect([
            ['active_id' => '1', 'name' => 'Activado'],
            ['active_id' => '0', 'name' => 'Desactivado'],
        ]);
        $active = $collection->pluck('name', 'active_id');

        return view('admin.categoria-tipo.create', compact('categoriaTipo', 'active'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(CategoriaTipo::$rules);
        if ($categoriaTipo = CategoriaTipo::create($request->all())) {
            /*
            $carpetas = Storage::disk('supercategorias')->directories();
            $directorio_existe = false;
            foreach($carpetas as $carpeta){
                if($carpeta == $categoriaTipo->id){   
                    $directorio_existe = true;
                }
            }
            if($directorio_existe == false){
                $resultado = Storage::disk('supercategorias')->makeDirectory($categoriaTipo->id, 0777, true);
            }

            $image = $request->file('icon');
            $input['imagename'] = time().'.'.$image->extension();
            $destinationPath = Storage::disk('supercategorias')->path($categoriaTipo->id);
            $img = Image::make($image->path());
            $img->resize(1200, 800, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['imagename']);

            
            $path = $categoriaTipo->id.'/'.$input['imagename'];
            
            $categoriaTipo->icon = $path;
            $categoriaTipo->save(['icon']);
            */
            return redirect()->route('categoria-tipos.index')
            ->with('success', 'La super categoría se creo con éxito.');
        } else {
            return redirect()->route('categoria-tipos.index')
            ->with('error', 'UPs! No se pudo crear la super categoria, vuelva a intentarlo.');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categoriaTipo = CategoriaTipo::find($id);
        
        if ( $categoriaTipo->icon != "img/slides/slide-prueba2.jpg") {
            $categoriaTipo->icon = Storage::disk('supercategorias')->url($categoriaTipo->icon);
        }
        
        $collection = collect([
            ['active_id' => '1', 'name' => 'Activado'],
            ['active_id' => '0', 'name' => 'Desactivado'],
        ]);
        $active = $collection->pluck('name', 'active_id');
        return view('admin.categoria-tipo.show', compact('categoriaTipo', 'active'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoriaTipo = CategoriaTipo::find($id);
        if ( $categoriaTipo->icon != "img/slides/slide-prueba2.jpg") {
            $categoriaTipo->icon = Storage::disk('supercategorias')->url($categoriaTipo->icon);
        }
        
        $collection = collect([
            ['active_id' => '1', 'name' => 'Activado'],
            ['active_id' => '0', 'name' => 'Desactivado'],
        ]);
        $active = $collection->pluck('name', 'active_id');
        return view('admin.categoria-tipo.edit', compact('categoriaTipo', 'active'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  CategoriaTipo $categoriaTipo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CategoriaTipo $categoriaTipo)
    {
        request()->validate(CategoriaTipo::$rules);
            
        if ($categoriaTipo->update($request->all())) {
           /*
            $carpetas = Storage::disk('supercategorias')->directories();
            $directorio_existe = false;
            foreach($carpetas as $carpeta){
                if($carpeta == $categoriaTipo->id){   
                    $directorio_existe = true;
                }
            }
            if($directorio_existe == false){
                $resultado = Storage::disk('supercategorias')->makeDirectory($categoriaTipo->id, 0777, true);
            }

            $image = $request->file('icon');
            $input['imagename'] = time().'.'.$image->extension();
            $destinationPath = Storage::disk('supercategorias')->path($categoriaTipo->id);
            $img = Image::make($image->path());
            $img->resize(1200, 800, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['imagename']);

            
            $path = $categoriaTipo->id.'/'.$input['imagename'];
            
            $categoriaTipo->icon = $path;
            $categoriaTipo->save(['icon']);
            */
            return redirect()->route('categoria-tipos.index')
            ->with('success', 'Se actulizo la super categoría con éxito');
        } else {
            return redirect()->route('categoria-tipos.index')
            ->with('error', 'UPs! No se pudo actualizar la super categoria, vuelva a intentarlo.');
        }
        
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        if ($categoriaTipo = CategoriaTipo::find($id)->delete()) {
            return redirect()->route('categoria-tipos.index')
            ->with('success', 'Se eliminó con éxito');
        } else {
            return redirect()->route('categoria-tipos.index')
            ->with('error', 'UPs! No se pudo eliminar, vuelva a intentarlo.');
        }
    }
}
