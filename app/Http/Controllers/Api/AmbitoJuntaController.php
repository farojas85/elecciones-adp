<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AmbitoJunta\StoreAmbitoJuntaRequest;
use App\Http\Requests\AmbitoJunta\UpdateAmbitoJuntaRequest;
use App\Http\Traits\AmbitoJuntaTrait;
use App\Models\AmbitoJunta;
use Illuminate\Http\Request;

class AmbitoJuntaController extends Controller
{
    use AmbitoJuntaTrait;
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
    public function store(StoreAmbitoJuntaRequest $request)
    {
        $request->validated();
        // $grado_ministerial = new GradoMinisterial;
        // $grado_ministerial->nombre = $request->nombre;
        // $grado_ministerial->save();
        $ambito_junta = AmbitoJunta::create([
            'nombre' => $request->nombre,
            'es_activo' => 1
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => ' El Ámbito Junta ha sido registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AmbitoJunta  $AmbitoJunta
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return AmbitoJunta::select('id','nombre','es_activo')
                ->where('id', $request->id)
                ->first()
        ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AmbitoJunta  $AmbitoJunta
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAmbitoJuntaRequest $request)
    {
        $request->validated();

        $ambito_junta = AmbitoJunta::find($request->id);
        $ambito_junta->nombre = $request->nombre;
        $ambito_junta->es_activo = ($request->es_activo ==true) ? 1 : 0;
        $ambito_junta->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => ' El Ámbito Junta seleccionada ha sido modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AmbitoJunta  $AmbitoJunta
     * @return \Illuminate\Http\Response
     */
    public function destroy(AmbitoJunta $AmbitoJunta)
    {
        //
    }

    public function habilitar(Request $request)
    {
        $ambito_junta = AmbitoJunta::find($request->id);
        $ambito_junta->es_activo = 1;
        $ambito_junta->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Ámbito Junta habilitado satisfactoriamente'
        ],200);
    }

    public function inhabilitar(Request $request)
    {
        $ambito_junta = AmbitoJunta::find($request->id);
        $ambito_junta->es_activo = 0;
        $ambito_junta->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Ámbito Junta inhabilitado satisfactoriamente'
        ],200);
    }

    public function listar()
    {
        return AmbitoJunta::select('id','nombre')->where('es_activo',1)->get();
    }
}
