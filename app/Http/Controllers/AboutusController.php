<?php

namespace App\Http\Controllers;

use App\Models\Aboutus;
use Illuminate\Http\Request;

/**
 * Class AboutuController
 * @package App\Http\Controllers
 */
class AboutusController extends Controller
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
        $aboutus_all = Aboutus::paginate(5);

        return view('admin.aboutus.index', compact('aboutus_all'))
            ->with('i', (request()->input('page', 1) - 1) * $aboutus_all->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aboutu = new Aboutus();
        return view('admin.aboutus.create', compact('aboutu'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Aboutus::$rules);

        $aboutus = Aboutus::create($request->all());

        return redirect()->route('aboutus.index')
            ->with('success', 'Se creó con éxito.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $aboutus = Aboutus::find($id);

        return view('admin.aboutus.show', compact('aboutus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aboutu = Aboutus::find($id);
       
        return view('admin.aboutus.edit', compact('aboutu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Aboutu $aboutu
     * @return \Illuminate\Http\Response
     */
    
    public function update(Request $request, Aboutus $aboutu)
    {
        //request()->validate(Aboutus::$rules);
        //dd($aboutus->id);
        //$aboutus->update($request->all());
        if ($aboutu->update($request->all())) {
            return redirect()->route('aboutus.index')
            ->with('success', 'Actualizado correctamente');
        } else {
            return redirect()->route('aboutus.index')
            ->with('error', 'UPs! No se pudo actualizar el registro');
        }
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $aboutus = Aboutus::find($id)->delete();

        return redirect()->route('aboutus.index')
            ->with('success', 'Se borró con éxito');
    }
}
