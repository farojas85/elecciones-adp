<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\TipoAccesoTrait;
use App\Models\TipoAcceso;
use App\Http\Requests\TipoAcceso\StoreTipoAccesoRequest;
use App\Http\Requests\TipoAcceso\UpdateTipoAccesoRequest;

class TipoAccesoController extends Controller
{
    use TipoAccesoTrait;
    public function listar()
    {
        return TipoAcceso::select('id','nombre')->where('es_activo',1)->get();
    }
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
    public function store(StoreTipoAccesoRequest $request)
    {
        $request->validated();

        $tipoAcceso = TipoAcceso::firstOrCreate([
            'nombre' => $request->nombre,
            'slug' => $request->slug
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Tipo Acceso registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipoAcceso  $tipoAcceso
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $tipoacceso = TipoAcceso::where('id',$request->id)->first();
        return $tipoacceso;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TipoAcceso  $tipoAcceso
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTipoAccesoRequest $request)
    {
        $request->validated();

        $tipoAcceso = TipoAcceso::where('id',$request->id)->first();
        $tipoAcceso->nombre = $request->nombre;
        $tipoAcceso->slug = $request->slug;
        $tipoAcceso->es_activo = ($request->es_activo ==true) ? 1 : 0;
        $tipoAcceso->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Tipo Acceso modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipoAcceso  $tipoAcceso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $tipoAcceso = TipoAcceso::where('id', $request->id)
                    ->withTrashed()
                    ->first()
        ;

        $tipoAcceso->es_activo = 0;
        $tipoAcceso->save();


        $tipoAcceso->delete();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Tipo de Acceso enviado a papelera satisfactoriamente'
        ],200);
    }

    public function restaurar(Request $request){
        $tipoacceso = TipoAcceso::where('id', $request->id)
                    ->withTrashed()
                    ->first()
        ;
        $tipoacceso->restore();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Tipo Acceso restaurado satisfactoriamente'
        ],200);
    }

    public function eliminarPermanente(Request $request)
    {
        $tipoAcceso = TipoAcceso::where('id', $request->id)
                    ->withTrashed()
                    ->first()
        ;

        $tipoAcceso->forceDelete();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Tipo Acceso Eliminado Permanentemente'
        ],200);
    }
}
