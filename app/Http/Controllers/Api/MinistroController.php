<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ministro\StoreMinistroRequest;
use App\Http\Requests\Ministro\UpdateMinistroRequest;
use App\Http\Traits\MinistroTrait;
use App\Models\Ministro;
use App\Models\Persona;
use Illuminate\Http\Request;

class MinistroController extends Controller
{
    use MinistroTrait;
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
    public function store(StoreMinistroRequest $request)
    {
        $request->validated();

        $persona = new Persona();
        $persona->numero_documento = $request->numero_documento ?? null;
        $persona->nombres = $request->nombres;
        $persona->apellido_paterno = $request->apellido_paterno;
        $persona->apellido_materno = $request->apellido_materno;
        $persona->sexo_id = $request->sexo_id;
        $persona->telefono = $request->telefono ?? null;
        $persona->direccion = $request->direccion ?? null;

        $persona->save();

        $ministro = Ministro::create([
            'persona_id' => $persona->id,
            'es_activo' => 1
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Ministro  registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ministro  $ministro
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return Ministro::with('persona')->where('id',$request->id)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ministro  $ministro
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMinistroRequest $request)
    {

        $request->validated();

        $ministro = Ministro::findOrFail($request->id);

        $persona = Persona::findOrFail($ministro->persona_id);

        $persona->numero_documento = $request->numero_documento ?? null;
        $persona->nombres = $request->nombres;
        $persona->apellido_paterno = $request->apellido_paterno;
        $persona->apellido_materno = $request->apellido_materno;
        $persona->sexo_id = $request->sexo_id;
        $persona->telefono = $request->telefono ?? null;
        $persona->direccion = $request->direccion ?? null;

        $persona->save();

        $ministro->es_activo = ($request->es_activo == true) ? 1 : 0;
        $ministro->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Ministro modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ministro  $ministro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ministro $ministro)
    {
        //
    }

    public function habilitar(Request $request)
    {
        $ministro = Ministro::find($request->id);
        $ministro->es_activo = 1;
        $ministro->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Ministro habilitado satisfactoriamente'
        ],200);
    }

    public function inhabilitar(Request $request)
    {
        $ministro = Ministro::find($request->id);
        $ministro->es_activo = 0;
        $ministro->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Ministro inhabilitado satisfactoriamente'
        ],200);
    }
}
