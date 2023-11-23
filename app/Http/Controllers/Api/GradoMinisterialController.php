<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GradoMinisterial\StoreGradoMinisterialRequest;
use App\Http\Requests\GradoMinisterial\UpdateGradoMinisterialRequest;
use App\Http\Traits\GradoMinisterialTrait;
use App\Models\GradoMinisterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class GradoMinisterialController extends Controller
{
    use GradoMinisterialTrait;
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
    public function store(StoreGradoMinisterialRequest $request)
    {
        $request->validated();
        // $grado_ministerial = new GradoMinisterial;
        // $grado_ministerial->nombre = $request->nombre;
        // $grado_ministerial->save();
        $grado_ministerial = GradoMinisterial::create([
            'nombre' => $request->nombre,
            'es_activo' => 1
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'El Grado Ministerial ha sido registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GradoMinisterial  $gradoMinisterial
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return GradoMinisterial::select('id','nombre','es_activo')
                ->where('id', $request->id)
                ->first()
        ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GradoMinisterial  $gradoMinisterial
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGradoMinisterialRequest $request)
    {
        $request->validated();

        $grado_ministerial = GradoMinisterial::find($request->id);
        $grado_ministerial->nombre = $request->nombre;
        $grado_ministerial->es_activo = ($request->es_activo ==true) ? 1 : 0;
        $grado_ministerial->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'El Grado Ministerial ha sido modificado satisfactoriamente'
        ],200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GradoMinisterial  $gradoMinisterial
     * @return \Illuminate\Http\Response
     */
    public function destroy(GradoMinisterial $gradoMinisterial)
    {
        //
    }

    public function habilitar(Request $request)
    {
        $grado_ministerial = GradoMinisterial::find($request->id);
        $grado_ministerial->es_activo = 1;
        $grado_ministerial->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Grado Ministerial habilitado satisfactoriamente'
        ],200);
    }

    public function inhabilitar(Request $request)
    {
        $grado_ministerial = GradoMinisterial::find($request->id);
        $grado_ministerial->es_activo = 0;
        $grado_ministerial->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Grado Ministerial inhabilitado satisfactoriamente'
        ],200);
    }

    public function listar()
    {
        return GradoMinisterial::select('id','nombre')->where('es_activo',1)->get();
    }
}
