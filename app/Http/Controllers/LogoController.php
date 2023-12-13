<?php

namespace App\Http\Controllers;

use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Image;

/**
 * Class LogoController
 * @package App\Http\Controllers
 */
class LogoController extends Controller
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
        $logos = Logo::paginate();
        foreach ($logos as $logo) {
           $logo->image = Storage::disk('logo')->url($logo->image);
        }

        return view('admin.logo.index', compact('logos'))
            ->with('i', (request()->input('page', 1) - 1) * $logos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $logo = new Logo();
        return view('admin.logo.create', compact('logo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        request()->validate(Logo::$rules);

        if ($logo = Logo::create($request->all())) {
        
            $carpetas = Storage::disk('logo')->directories();
            $directorio_existe = false;
            foreach($carpetas as $carpeta){
                if($carpeta == $logo->id){   
                    $directorio_existe = true;
                }
            }
            if($directorio_existe == false){
                $resultado = Storage::disk('logo')->makeDirectory($logo->id, 0777, true);
            }

            $image = $request->file('image');
            $input['imagename'] = time().'.'.$image->extension();
            $destinationPath = Storage::disk('logo')->path($logo->id);
            $img = Image::make($image->path());
            $img->resize(240, 140, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['imagename']);

            
            $path = $logo->id.'/'.$input['imagename'];
            
            $logo->image = $path;
            $logo->save(['image']);
            return redirect()->route('logo.index')
        ->with('success', 'Logo created successfully.');
        } else {
            return redirect()->route('logo.index')
            ->with('error', 'UPs! No se pudo guardar el logo, vuelva a intentarlo.');
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
        $logo = Logo::find($id);
        $logo->image = Storage::disk('logo')->url($logo->image);
        return view('admin.logo.show', compact('logo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $logo = Logo::find($id);
        $logo->image = Storage::disk('logo')->url($logo->image);
        return view('admin.logo.edit', compact('logo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Logo $logo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Logo $logo)
    {
        request()->validate(Logo::$rules);
        ;
        
        if ($logo->update($request->all())) {
        
            $carpetas = Storage::disk('logo')->directories();
            $directorio_existe = false;
            foreach($carpetas as $carpeta){
                if($carpeta == $logo->id){   
                    $directorio_existe = true;
                }
            }
            if($directorio_existe == false){
                $resultado = Storage::disk('logo')->makeDirectory($logo->id, 0777, true);
            }

            $image = $request->file('image');
            $input['imagename'] = time().'.'.$image->extension();
            $destinationPath = Storage::disk('logo')->path($logo->id);
            $img = Image::make($image->path());
            $img->resize(240, 140, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['imagename']);

            
            $path = $logo->id.'/'.$input['imagename'];
            
            $logo->image = $path;
            $logo->save(['image']);

            return redirect()->route('logo.index')
            ->with('success', 'Logo updated successfully');
        } else {
            return redirect()->route('logo.index')
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
        $logo = Logo::find($id)->delete();

        return redirect()->route('logo.index')
            ->with('success', 'Logo deleted successfully');
    }
}
