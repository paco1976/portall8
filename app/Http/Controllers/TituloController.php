<?php

namespace App\Http\Controllers;

use App\Models\Titulo;
use App\Models\Categoria;
use Illuminate\Http\Request;

/**
 * Class TituloController
 * @package App\Http\Controllers
 */
class TituloController extends Controller
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
        $titulos = Titulo::paginate();

        foreach ($titulos as $titulo) {
            $titulo->categoria = $titulo->categoria()->first();
        }

        return view('admin.titulo.index', compact('titulos'))
            ->with('i', (request()->input('page', 1) - 1) * $titulos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $titulo = new Titulo();
        $categorias = Categoria::where('active','1')->pluck('name', 'id');
        return view('admin.titulo.create', compact('titulo','categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Titulo::$rules);

        $titulo = Titulo::create($request->all());

        return redirect()->route('titulos.index')
            ->with('success', 'Titulo created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $titulo = Titulo::find($id);
        $titulo->categoria = $titulo->categoria()->first();
        $categorias = Categoria::where('active','1')->pluck('name', 'id');
        return view('admin.titulo.show', compact('titulo','categorias'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $titulo = Titulo::find($id);
        $categorias = Categoria::where('active','1')->pluck('name', 'id');
        return view('admin.titulo.edit', compact('titulo','categorias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Titulo $titulo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Titulo $titulo)
    {
        request()->validate(Titulo::$rules);

        $titulo->update($request->all());

        return redirect()->route('titulos.index')
            ->with('success', 'Titulo updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $titulo = Titulo::find($id)->delete();

        return redirect()->route('titulos.index')
            ->with('success', 'Titulo deleted successfully');
    }
}
