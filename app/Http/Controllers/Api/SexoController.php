<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sexo;
use Illuminate\Http\Request;

class SexoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sexo  $sexo
     * @return \Illuminate\Http\Response
     */
    public function show(Sexo $sexo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sexo  $sexo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sexo $sexo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sexo  $sexo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sexo $sexo)
    {
        //
    }

    public function listar()
    {
        return Sexo::select('id','nombre')->get();
    }
}
