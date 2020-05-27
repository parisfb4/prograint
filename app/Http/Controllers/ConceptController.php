<?php

namespace App\Http\Controllers;

use App\Models\Concept;
use Illuminate\Http\Request;

class ConceptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('concepts.concepts');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $concept = new Concept();
        $concept->concept = $request->concept;
        $concept->reference = $request->reference;
        $concept->agreement = $request->agreement;
        $concept->clabe = $request->clabe;
        $concept->cost = $request->cost;
        $concept->save();
        return $concept;
    }

    public function showAll()
    {
        return Concept::all();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Concept  $concept
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $concept = Concept::findOrFail($id);
        $data = ['concept'=>$concept];
        return view('concepts.details', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Concept  $concept
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $concept = Concept::findOrFail($id);
        $data = ['concept'=>$concept];
        return view('concepts/create_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Concept  $concept
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Concept $concept)
    {

        $concept->concept = $request->concept;
        $concept->reference = $request->reference;
        $concept->agreement = $request->agreement;
        $concept->clabe = $request->clabe;
        $concept->cost = $request->cost;
        $concept->save();
        return $concept;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Concept  $concept
     * @return \Illuminate\Http\Response
     */
    public function destroy(Concept $concept)
    {
        $concept->delete();
    }
}
