<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

/**
 * Class LinkController
 * @package App\Http\Controllers
 */
class LinkController extends Controller
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
        $links = Link::paginate();

        return view('admin.link.index', compact('links'))
            ->with('i', (request()->input('page', 1) - 1) * $links->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $link = new Link();
        return view('admin.link.create', compact('link'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Link::$rules);

        $link = Link::create($request->all());

        return redirect()->route('links.index')
            ->with('success', 'Enlase creado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $link = Link::find($id);

        return view('admin.link.show', compact('link'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $link = Link::find($id);

        return view('admin.link.edit', compact('link'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Link $link
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Link $link)
    {
        request()->validate(Link::$rules);

        $link->update($request->all());

        return redirect()->route('links.index')
            ->with('success', 'Enlase actualizado');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $link = Link::find($id)->delete();

        return redirect()->route('links.index')
            ->with('success', 'Enlase borrado');
    }
}
