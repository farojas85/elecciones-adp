<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\EleccionJuntaCandidatoTrait;
use App\Models\EleccionJuntaCandidato;
use Illuminate\Http\Request;

class EleccionJuntaCandidatoController extends Controller
{
    use EleccionJuntaCandidatoTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(EleccionJuntaCandidato $eleccionJuntaCandidato)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EleccionJuntaCandidato $eleccionJuntaCandidato)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EleccionJuntaCandidato $eleccionJuntaCandidato)
    {
        //
    }
}
