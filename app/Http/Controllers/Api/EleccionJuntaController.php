<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EleccionJunta\StoreEleccionJuntaRequest;
use App\Http\Traits\EleccionJuntaTrait;
use App\Models\EleccionJunta;
use Illuminate\Http\Request;

class EleccionJuntaController extends Controller
{
    use EleccionJuntaTrait;
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
    public function store(StoreEleccionJuntaRequest $request)
    {
        $request->validated();

        $eleccion_junta = EleccionJunta::create([
            'periodo_junta_id' => $request->periodo_junta_id,
            'junta_directiva_id' => $request->junta_directiva_id,
            'fecha' => $request->fecha ?? null ,
            'hora' => $request->hora ?? null,
            'es_activo' => 1
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => ' La Elección Junta ha sido registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EleccionJunta  $eleccionJunta
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return EleccionJunta::with([
            'periodo_junta:id,anio_inicio,anio_fin',
            'junta_directiva:id,nombre',
            'cargo_directivos:id,nombre'
        ])->where('id',$request->id)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EleccionJunta  $eleccionJunta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $eleccion_junta = EleccionJunta::where('id',$request->id)->first();

        $eleccion_junta->periodo_junta_id = $request->periodo_junta_id;
        $eleccion_junta->junta_directiva_id = $request->junta_directiva_id;
        $eleccion_junta->fecha = $request->fecha ?? null;
        $eleccion_junta->hora = $request->hora ?? null;
        $eleccion_junta->es_activo = $request->es_activo == true? 1 : 0;
        $eleccion_junta->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => ' La Elección Junta ha sido modificado satisfactoriamente'
        ],200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EleccionJunta  $eleccionJunta
     * @return \Illuminate\Http\Response
     */
    public function destroy(EleccionJunta $eleccionJunta)
    {
        //
    }

    public function habilitar(Request $request)
    {
        $eleccion_junta = EleccionJunta::find($request->id);
        $eleccion_junta->es_activo = 1;
        $eleccion_junta->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Elección Junta habilitada satisfactoriamente'
        ],200);
    }

    public function inhabilitar(Request $request)
    {
        $eleccion_junta = EleccionJunta::find($request->id);
        $eleccion_junta->es_activo = 0;
        $eleccion_junta->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Elección Junta inhabilitada satisfactoriamente'
        ],200);
    }
}
