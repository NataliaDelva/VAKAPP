<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFincaRequest;
use App\Http\Requests\UpdateFincaRequest;
use Illuminate\Http\Request;
use App\Models\Finca;
use Inertia\Inertia;
use DB;

class FincasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fincas = Finca::paginate(10);

        return Inertia::render('Fincas/Index', ['fincas' => $fincas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFincaRequest $request)
    {
        Finca::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFincaRequest $request, string $id)
    {

        $finca = Finca::findOrFail($id);

        $finca->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Finca::find($id)->delete();
    }

    public function filter(){
        dd("Filtro");
    }
}
