<?php

namespace App\Http\Controllers;

use App\Models\Skin;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Image;

/**
 * Class SkinController
 * @package App\Http\Controllers
 */
class SkinController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
    {
        $skins = Skin::paginate();
        foreach ($skins as $skin) {
            if ($skin->urlskin) {
                $skin->urlskin = Storage::disk('skin')->url($skin->urlskin);
            }
            if ($skin->urlimage) {
                $skin->urlimage = Storage::disk('skin')->url($skin->urlimage);
            }
        }
        $collection = collect([
            ['active_id' => '1', 'name' => 'Activado'],
            ['active_id' => '0', 'name' => 'Desactivado'],
        ]);
        $active = $collection->pluck('name', 'active_id');
        return view('admin.skin.index', compact('skins','active'))
            ->with('i', (request()->input('page', 1) - 1) * $skins->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $skin = new Skin();
        $collection = collect([
            ['active_id' => '1', 'name' => 'Activado'],
            ['active_id' => '0', 'name' => 'Desactivado'],
        ]);
        
        $active = $collection->pluck('name', 'active_id');
        return view('admin.skin.create', compact('skin','active'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Skin::$rules);
        //dd($request->file('urlimage'));
        if ($skin = Skin::create($request->all())) {

            //++++ Chequeo si existe la carpeta y si no existe la crea++++++++++
            $carpetas = Storage::disk('skin')->directories();
            $directorio_existe = false;
            foreach($carpetas as $carpeta){
                if($carpeta == $skin->id){   
                    $directorio_existe = true;
                }
            }
            if($directorio_existe == false){
                $resultado = Storage::disk('skin')->makeDirectory($skin->id, 0777, true);
            }
            //+++++++++++++++++SUBIDA DE IMAGEN DE MUESTRA ++++++++++++++
            if($request->hasfile('urlimage')){
                
                $image = $request->file('urlimage');
                //$input['imagename'] = time().'.'.$image->extension();
                //lepongo nombre y extensión al archivo el nombre $skin->color (lo que se carga en esta variable del formulario)
                $input['imagename'] = $skin->color.'.'.$image->extension();
                $destinationPath = Storage::disk('skin')->path($skin->id);
                $img = Image::make($image->path());
                $img->resize(400, 200, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$input['imagename']);

                
                $path = $skin->id.'/'.$input['imagename'];
                
                $skin->urlimage = $path;
                $skin->save(['urlimage']);
            }
            //+++++++++++++++++FIN SUBIDA DE IMAGEN DE MUESTRA++++++++++++++
            //+++++++++++++++++SUBIDA DE SKIN ++++++++++++++
        if ($request->hasfile('urlskin')) {
            $carpetas = Storage::disk('skin')->directories();
            $directorio_existe = false;
            foreach($carpetas as $carpeta){
                if($carpeta == $skin->id){   
                    $directorio_existe = true;
                }
            }
            if($directorio_existe == false){
                $resultado = Storage::disk('skin')->makeDirectory($skin->id, 0777, true);
            }

           // $path = Storage::disk('skin')->putFILE($skin->id, request()->file('urlskin'));
            //$skin->urlskin = $path;
            //$skin->save(['urlskin']);

            $file = $request->file('urlskin');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('skin', $fileName);
            //If you want to specify the disk, you can pass that as the third parameter.
            $file->storeAs($skin->id, $fileName, 'skin');
            $path2 = $skin->id. "/" .$fileName;
            $skin->urlskin = $path2;
            $skin->save(['urlskin']);


            }
        //++++++++++++++++FIN DE SUBIDA DE SKIN +++++++++


            return redirect()->route('skins.index')
            ->with('success', 'Creado con éxito.');
        } else {
            return redirect()->route('skins.index')
            ->with('error', 'Ups, algo falló, volve a intentarlo');
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
        $skin = Skin::find($id);
        $collection = collect([
            ['active_id' => '1', 'name' => 'Activado'],
            ['active_id' => '0', 'name' => 'Desactivado'],
        ]);
        $active = $collection->pluck('name', 'active_id');
        if ($skin->urlskin) {
            $skin->urlskin = Storage::disk('skin')->url($skin->urlskin);
        }
        if ($skin->urlimage) {
            $skin->urlimage = Storage::disk('skin')->url($skin->urlimage);
        }
        return view('admin.skin.show', compact('skin','active'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $skin = Skin::find($id);
        $collection = collect([
            ['active_id' => '1', 'name' => 'Activado'],
            ['active_id' => '0', 'name' => 'Desactivado'],
        ]);
        $active = $collection->pluck('name', 'active_id');
        if ($skin->urlskin) {
            $skin->urlskin = Storage::disk('skin')->url($skin->urlskin);
        }
        if ($skin->urlimage) {
            $skin->urlimage = Storage::disk('skin')->url($skin->urlimage);
            }
        return view('admin.skin.edit', compact('skin','active'));
    }

    /**
     * 
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Skin $skin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Skin $skin)
    {
        request()->validate(Skin::$rules);

        //$skin->update($request->all());
        
        if ($skin->update($request->all())) {

            //++++ Chequeo si existe la carpeta y si no existe la crea++++++++++
            $carpetas = Storage::disk('skin')->directories();
            $directorio_existe = false;
            foreach($carpetas as $carpeta){
                if($carpeta == $skin->id){   
                    $directorio_existe = true;
                }
            }
            if($directorio_existe == false){
                $resultado = Storage::disk('skin')->makeDirectory($skin->id, 0777, true);
            }
            //+++++++++++++++++SUBIDA DE IMAGEN DE MUESTRA ++++++++++++++
            if($request->hasfile('urlimage')){
                
                $image = $request->file('urlimage');
                //$input['imagename'] = time().'.'.$image->extension();
                //lepongo nombre y extensión al archivo el nombre $skin->color (lo que se carga en esta variable del formulario)
                $input['imagename'] = $skin->color.'.'.$image->extension();
                $destinationPath = Storage::disk('skin')->path($skin->id);
                $img = Image::make($image->path());
                $img->resize(400, 200, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$input['imagename']);

                
                $path = $skin->id.'/'.$input['imagename'];
                
                $skin->urlimage = $path;
                $skin->save(['urlimage']);
            }
            //+++++++++++++++++FIN SUBIDA DE IMAGEN DE MUESTRA++++++++++++++
            //+++++++++++++++++SUBIDA DE SKIN ++++++++++++++
        if ($request->hasfile('urlskin')) {
            $carpetas = Storage::disk('skin')->directories();
            $directorio_existe = false;
            foreach($carpetas as $carpeta){
                if($carpeta == $skin->id){   
                    $directorio_existe = true;
                }
            }
            if($directorio_existe == false){
                $resultado = Storage::disk('skin')->makeDirectory($skin->id, 0777, true);
            }

           // $path = Storage::disk('skin')->putFILE($skin->id, request()->file('urlskin'));
            //$skin->urlskin = $path;
            //$skin->save(['urlskin']);

            $file = $request->file('urlskin');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('skin', $fileName);
            //If you want to specify the disk, you can pass that as the third parameter.
            $file->storeAs($skin->id, $fileName, 'skin');
            $path2 = $skin->id. "/" .$fileName;
            $skin->urlskin = $path2;
            $skin->save(['urlskin']);


            }
             //++++++++++++++++FIN DE SUBIDA DE SKIN +++++++++

            return redirect()->route('skins.index')
            ->with('success', 'Actualizado con éxito');
        } else {
            return redirect()->route('skins.index')
            ->with('error', 'Ups, algo falló, volve a intentarlo');
        }
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        
        if ($skin = Skin::find($id)->delete()) {
            return redirect()->route('skins.index')
            ->with('success', 'Borrado con éxito');
        } else {
            return redirect()->route('skins.index')
            ->with('error', 'Ups, algo falló, volve a intentarlo');
        }
        
    }

    public function select($id){
        //desactivo el actual
        $sk = Skin::where('active',1)->first();
        $sk->active = false;
        $sk->save(['active']);
        
        //activo el seleccionado
        $skin = Skin::where('id', $id)->first();
        $skin->active = true;
        $skin->save(['active']);

        $logo = Logo::first();
        if ($skin->color == 'Azul') {
            $logo->image = "azul.png";
            $logo->save(['image']);
        }
        if ($skin->color == 'Naranja') {
            $logo->image = "naranja.png";
            $logo->save(['image']);
        }
        if ($skin->color == 'Rojo') {
            $logo->image = "rojo.png";
            $logo->save(['image']);
        }
        if ($skin->color == 'Verde') {
            $logo->image = "verde.png";
            $logo->save(['image']);
        }

        return redirect()->route('skins.index')
        ->with('success', 'Actualizado con éxito');
    }
}
