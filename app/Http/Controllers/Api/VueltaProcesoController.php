<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VueltaProceso\StoreVueltaProcesoRequest;
use App\Http\Requests\VueltaProceso\UpdateVueltaProcesoRequest;
use App\Http\Traits\VueltaProcesoTrait;
use App\Models\VueltaProceso;
use Illuminate\Http\Request;

class VueltaProcesoController extends Controller
{
    use VueltaProcesoTrait;
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
    public function store(StoreVueltaProcesoRequest $request)
    {
        $request->validated();

        $vuelta = VueltaProceso::create([
            'nombre' => $request->nombre,
            'abreviatura' => $request->abreviatura
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Vuelta Proceso registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VueltaProceso  $vueltaProceso
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return VueltaProceso::find($request->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VueltaProceso  $vueltaProceso
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVueltaProcesoRequest $request)
    {
        $request->validated();

        $vuelta = VueltaProceso::find($request->id);
        $vuelta->nombre = $request->nombre;
        $vuelta->abreviatura = $request->abreviatura;
        $vuelta->es_activo = ($request->es_activo==true) ? 1 : 0;
        $vuelta->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Vuelta Proceso modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VueltaProceso  $vueltaProceso
     * @return \Illuminate\Http\Response
     */
    public function destroy(VueltaProceso $vueltaProceso)
    {
        //
    }

    public function habilitar(Request $request)
    {
        $vuelta_proceso = VueltaProceso::find($request->id);
        $vuelta_proceso->es_activo = 1;
        $vuelta_proceso->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Vuelta Proceso habilitado satisfactoriamente'
        ],200);
    }

    public function inhabilitar(Request $request)
    {
        $vuelta_proceso = VueltaProceso::find($request->id);
        $vuelta_proceso->es_activo = 0;
        $vuelta_proceso->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Vuelta Proceso inhabilitado satisfactoriamente'
        ],200);
    }
}
