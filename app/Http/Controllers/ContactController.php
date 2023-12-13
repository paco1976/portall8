<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

/**
 * Class ContactController
 * @package App\Http\Controllers
 */
class ContactController extends Controller
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
        $contacts = Contact::paginate();
        $collection = collect([
            ['active_id' => '1', 'name' => 'Activado'],
            ['active_id' => '0', 'name' => 'Desactivado'],
        ]);
        $active = $collection->pluck('name', 'active_id');
        return view('admin.contact.index', compact('contacts','active'))
            ->with('i', (request()->input('page', 1) - 1) * $contacts->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $contact = new Contact();
        $collection = collect([
            ['active_id' => '1', 'name' => 'Activado'],
            ['active_id' => '0', 'name' => 'Desactivado'],
        ]);
        $active = $collection->pluck('name', 'active_id');
        return view('admin.contact.create', compact('contact', 'active'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Contact::$rules);

        $contact = Contact::create($request->all());

        return redirect()->route('contacts.index')
            ->with('success', 'Contact created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contact = Contact::find($id);
        $collection = collect([
            ['active_id' => '1', 'name' => 'Activado'],
            ['active_id' => '0', 'name' => 'Desactivado'],
        ]);
        $active = $collection->pluck('name', 'active_id');
        return view('admin.contact.show', compact('contact','active'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contact = Contact::find($id);
        $collection = collect([
            ['active_id' => '1', 'name' => 'Activado'],
            ['active_id' => '0', 'name' => 'Desactivado'],
        ]);
        $active = $collection->pluck('name', 'active_id');
        return view('admin.contact.edit', compact('contact', 'active'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        request()->validate(Contact::$rules);

        $contact->update($request->all());

        return redirect()->route('contacts.index')
            ->with('success', 'Contact updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $contact = Contact::find($id)->delete();

        return redirect()->route('contacts.index')
            ->with('success', 'Contact deleted successfully');
    }
}
