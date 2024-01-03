<?php

namespace App\Http\Controllers;

use App\Models\Carrusel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Image;

/**
 * Class CarruselController
 * @package App\Http\Controllers
 */
class CarruselController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carrusels = Carrusel::paginate(10);

        foreach ($carrusels as $carrusel) {
            if ( $carrusel->image != "img/slides/slide-prueba2.jpg") {
                $carrusel->image = Storage::disk('carrusel')->url($carrusel->image);
            }
        }

        $collection = collect([
            ['active_id' => '1', 'name' => 'Activado'],
            ['active_id' => '0', 'name' => 'Desactivado'],
        ]);
        $active = $collection->pluck('name', 'active_id');

        return view('admin.carrusel.index', compact('carrusels','active'))
            ->with('i', (request()->input('page', 1) - 1) * $carrusels->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $carrusel = new Carrusel();
        $collection = collect([
            ['active_id' => '1', 'name' => 'Activado'],
            ['active_id' => '0', 'name' => 'Desactivado'],
        ]);
        $active = $collection->pluck('name', 'active_id');

        return view('admin.carrusel.create', compact('carrusel', 'active'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Carrusel::$rules);
       
        if ($carrusel = Carrusel::create($request->all())) {
            
            $carpetas = Storage::disk('carrusel')->directories();
            $directorio_existe = false;
            foreach($carpetas as $carpeta){
                if($carpeta == $carrusel->id){   
                    $directorio_existe = true;
                }
            }
            if($directorio_existe == false){
                $resultado = Storage::disk('carrusel')->makeDirectory($carrusel->id, 0777, true);
            }

            $image = $request->file('image');
            $input['imagename'] = time().'.'.$image->extension();
            $destinationPath = Storage::disk('carrusel')->path($carrusel->id);
            $img = Image::make($image->path());
            $img->resize(1920, 667, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['imagename']);

            
            $path = $carrusel->id.'/'.$input['imagename'];
            
            $carrusel->image = $path;
            $carrusel->save(['image']);

            return redirect()->route('carrusel.index')
            ->with('success', 'Se creó con éxito.');
        } else {
            return redirect()->route('carrusel.index')
            ->with('error', 'Ups! No se pudo crear el Carrusel, vuelva a intentarlo.');
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
        $carrusel = Carrusel::find($id);
        $collection = collect([
            ['active_id' => '1', 'name' => 'Activado'],
            ['active_id' => '0', 'name' => 'Desactivado'],
        ]);
        $active = $collection->pluck('name', 'active_id');
        $carrusel->image = Storage::disk('carrusel')->url($carrusel->image);
        return view('admin.carrusel.show', compact('carrusel', 'active'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $carrusel = Carrusel::find($id);
        $collection = collect([
            ['active_id' => '1', 'name' => 'Activado'],
            ['active_id' => '0', 'name' => 'Desactivado'],
        ]);
        $active = $collection->pluck('name', 'active_id');
        $carrusel->image = Storage::disk('carrusel')->url($carrusel->image);
        return view('admin.carrusel.edit', compact('carrusel', 'active'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Carrusel $carrusel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Carrusel $carrusel)
    {
        //request()->validate(Carrusel::$rules);
        
        $data = request()->validate([
            'active' => ['required'],
        ],[
            'active.required' =>'Debe activar o desactiva la categoría',
        ]);
        //dd($request->input('text1'));
        //dd($request->hasfile('image'));  //devuelve un boolean sobre el campo image
        
        $carrusel->active = $data['active'];
        
        if ($carrusel->save(['active'])) {
            $carrusel->text1 = $request->input('text1');
            $carrusel->save(['text1']);
           
            $carrusel->text2 = $request->input('text2');
            $carrusel->save(['text2']);
           
            $carrusel->link = $request->input('link');
            $carrusel->save(['link']);

            if ($request->hasfile('image')) {
                $carpetas = Storage::disk('carrusel')->directories();
                $directorio_existe = false;
                foreach($carpetas as $carpeta){
                    if($carpeta == $carrusel->id){   
                        $directorio_existe = true;
                    }
                }
                if($directorio_existe == false){
                    $resultado = Storage::disk('carrusel')->makeDirectory($carrusel->id, 0777, true);
                }
    
                $image = $request->file('image');
                $input['imagename'] = time().'.'.$image->extension();
                $destinationPath = Storage::disk('carrusel')->path($carrusel->id);
                $img = Image::make($image->path());
                $img->resize(1920, 667, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$input['imagename']);
                $path = $carrusel->id.'/'.$input['imagename'];
                $carrusel->image = $path;
                $carrusel->save(['image']);
            }

            return redirect()->route('carrusel.index')
            ->with('success', 'Se actualizó con éxito');
        } else {
            return redirect()->route('carrusel.index')
            ->with('error', 'Ups! Hubo un problema y no se pudo actualizar, intentelo de nuevo');
        }
        
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        //$carrusel_image = Carrusel::where('id', $id)->first();
        if ($carrusel = Carrusel::find($id)->delete()) {
            //Storage::disk('carrusel')->delete($carrusel_image->image);
            return redirect()->route('carrusel.index')
            ->with('success', 'Se borró con éxito');
        } else {
            return redirect()->route('carrusel.index')
            ->with('success', 'Ups! Nos se pudo borrar, intentelo de nuevo');
        }
    }
}
