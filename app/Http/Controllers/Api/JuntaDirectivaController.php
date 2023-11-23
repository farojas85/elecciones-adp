<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\JuntaDirectiva\StoreJuntaDirectivaRequest;
use App\Http\Requests\JuntaDirectiva\UpdateJuntaDirectivaRequest;
use App\Http\Traits\JuntaDirectivaTrait;
use App\Models\JuntaDirectiva;
use Illuminate\Http\Request;

class JuntaDirectivaController extends Controller
{
    use JuntaDirectivaTrait;
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
    public function store(StoreJuntaDirectivaRequest $request)
    {
        $request->validated();
        // $grado_ministerial = new GradoMinisterial;
        // $grado_ministerial->nombre = $request->nombre;
        // $grado_ministerial->save();
        $junta_directiva = JuntaDirectiva::create([
            'nombre' => $request->nombre,
            'es_activo' => 1
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'La Junta Directiva ha sido registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JuntaDirectiva  $juntaDirectiva
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return JuntaDirectiva::select('id','nombre','es_activo')
                ->where('id', $request->id)
                ->first()
        ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JuntaDirectiva  $juntaDirectiva
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJuntaDirectivaRequest $request)
    {
        $request->validated();

        $junta_directiva = JuntaDirectiva::find($request->id);
        $junta_directiva->nombre = $request->nombre;
        $junta_directiva->es_activo = ($request->es_activo ==true) ? 1 : 0;
        $junta_directiva->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'La Junta Directiva seleccionada ha sido modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JuntaDirectiva  $juntaDirectiva
     * @return \Illuminate\Http\Response
     */
    public function destroy(JuntaDirectiva $juntaDirectiva)
    {
        //
    }

    public function habilitar(Request $request)
    {
        $junta_directiva = JuntaDirectiva::find($request->id);
        $junta_directiva->es_activo = 1;
        $junta_directiva->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Junta Directiva habilitada satisfactoriamente'
        ],200);
    }

    public function inhabilitar(Request $request)
    {
        $junta_directiva = JuntaDirectiva::find($request->id);
        $junta_directiva->es_activo = 0;
        $junta_directiva->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Junta Directiva inhabilitada satisfactoriamente'
        ],200);
    }

    public function listar()
    {
        return JuntaDirectiva::select('id','nombre')->where('es_activo',1)
            ->orderBy('id','desc')->get();
    }
}
