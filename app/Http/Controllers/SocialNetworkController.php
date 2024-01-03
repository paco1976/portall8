<?php

namespace App\Http\Controllers;

use App\Models\SocialNetwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class SocialNetworkController
 * @package App\Http\Controllers
 */
class SocialNetworkController extends Controller
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
        $socialNetworks = SocialNetwork::paginate(10);
        $collection = collect([
            ['active_id' => '1', 'name' => 'Activado'],
            ['active_id' => '0', 'name' => 'Desactivado'],
        ]);
        $active = $collection->pluck('name', 'active_id');
        return view('admin.socialnetworks.index', compact('socialNetworks','active'))
            ->with('i', (request()->input('page', 1) - 1) * $socialNetworks->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $socialNetwork = new SocialNetwork();
        $collection = collect([
            ['active_id' => '1', 'name' => 'Activado'],
            ['active_id' => '0', 'name' => 'Desactivado'],
        ]);
        $active = $collection->pluck('name', 'active_id');
        return view('admin.socialnetworks.create', compact('socialNetwork','active'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(SocialNetwork::$rules);

        $socialNetwork = SocialNetwork::create($request->all());

        return redirect()->route('SocialNetworks.index')
            ->with('success', 'Red Social Creada.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $socialNetwork = SocialNetwork::find($id);
        $collection = collect([
            ['active_id' => '1', 'name' => 'Activado'],
            ['active_id' => '0', 'name' => 'Desactivado'],
        ]);
        $active = $collection->pluck('name', 'active_id');
        return view('admin.socialnetworks.show', compact('socialNetwork', 'active'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $socialNetwork = SocialNetwork::find($id);
        $collection = collect([
            ['active_id' => '1', 'name' => 'Activado'],
            ['active_id' => '0', 'name' => 'Desactivado'],
        ]);
        $active = $collection->pluck('name', 'active_id');
        return view('admin.socialnetworks.edit', compact('socialNetwork','active'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  SocialNetwork $socialNetwork
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SocialNetwork $socialNetwork)
    {
        request()->validate(SocialNetwork::$rules);
        $socialNetwork = SocialNetwork::where('id', $request['id'])->first();
        //$socialNetwork->update($request->all());
        /*
        $socialNetwork->name = $request['name'];
        $socialNetwork->link = $request['link'];
        $socialNetwork->link = $request['active'];
        $socialNetwork->save(['name', 'link','active']);
        */
        if($socialNetwork->update($request->all())) {
            return redirect()->route('SocialNetworks.index')
            ->with('success', 'Red Social actualizada');
        }else{
            return redirect()->route('SocialNetworks.index')
            ->with('error', 'UPs! No se pudo actualizar, vuelva a intentarlo');
        }
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        if ($socialNetwork = SocialNetwork::find($id)->delete()) {
            //Storage::disk('carrusel')->delete($carrusel_image->image);
            return redirect()->route('SocialNetworks.index')
            ->with('success', 'Red Social Borrada');
        } else {
            return redirect()->route('SocialNetworks.index')
            ->with('success', 'Ups! Nos se pudo borrar, intentelo de nuevo');
        }
    }
}
