<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PeriodoJunta\StorePeriodoJuntaRequest;
use App\Http\Traits\PeriodoJuntaTrait;
use App\Models\Ministro;
use App\Models\PeriodoJunta;
use Illuminate\Http\Request;

class PeriodoJuntaController extends Controller
{
    use PeriodoJuntaTrait;
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
    public function store(StorePeriodoJuntaRequest $request)
    {
        $request->validated();

        $periodo_junta = PeriodoJunta::create([
            'anio_inicio' => $request->anio_inicio,
            'anio_fin' => $request->anio_fin,
            'es_activo' => 1
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'El Periodo ha sido registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PeriodoJunta  $periodoJunta
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return PeriodoJunta::where('id',$request->id)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PeriodoJunta  $periodoJunta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $periodo_junta = PeriodoJunta::where('id',$request->id)->first();

        $periodo_junta->anio_inicio = $request->anio_inicio;
        $periodo_junta->anio_fin = $request->anio_fin;
        $periodo_junta->es_activo = $request->es_activo == true ? 1 : 0;
        $periodo_junta->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'El Periodo ha sido modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PeriodoJunta  $periodoJunta
     * @return \Illuminate\Http\Response
     */
    public function destroy(PeriodoJunta $periodoJunta)
    {
        //
    }

    public function habilitar(Request $request)
    {
        $periodo_junta = PeriodoJunta::find($request->id);
        $periodo_junta->es_activo = 1;
        $periodo_junta->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Perido Junta habilitado satisfactoriamente'
        ],200);
    }

    public function inhabilitar(Request $request)
    {
        $periodo_junta = PeriodoJunta::find($request->id);
        $periodo_junta->es_activo = 0;
        $periodo_junta->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Perido Junta inhabilitado satisfactoriamente'
        ],200);
    }

    public function listar()
    {
        return PeriodoJunta::select(
            'id','anio_inicio','anio_fin'
        )->where('es_activo',1)
        ->orderBy('id','desc')->get();
    }
}
