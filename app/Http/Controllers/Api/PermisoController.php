<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\PermisoTrait;
use App\Models\Permiso;
use App\Http\Requests\Permiso\StorePermisoRequest;
use App\Http\Requests\Permiso\UpdatePermisoRequest;
use Illuminate\Http\Request;

class PermisoController extends Controller
{
    use PermisoTrait;
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
    public function store(StorePermisoRequest $request)
    {
        $request->validated();

        $permiso = Permiso::firstOrCreate([
            'nombre'    => $request->nombre,
            'slug'      => $request->slug
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Permiso registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permiso  $permiso
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return Permiso::where('id',$request->id)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permiso  $permiso
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermisoRequest $request)
    {
        $request->validated();

        $permiso = Permiso::where('id',$request->id)->first();

        $permiso->nombre = $request->nombre;
        $permiso->slug = $request->slug;
        $permiso->es_activo = $request->es_activo;
        $permiso->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Permiso modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permiso  $permiso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $permiso = Permiso::where('id', $request->id)
                    ->withTrashed()
                    ->first()
        ;

        $permiso->es_activo = 0;
        $permiso->save();


        $permiso->delete();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Permiso enviado a papelera satisfactoriamente'
        ],200);
    }

    public function listar(){
        return Permiso::select('id','nombre')->get();
    }

    public function restaurar(Request $request){
        $permiso = Permiso::where('id', $request->id)
                    ->withTrashed()
                    ->first()
        ;
        $permiso->restore();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Permiso restaurado satisfactoriamente'
        ],200);
    }
    public function eliminarPermanente(Request $request){
        $permiso = Permiso::where('id', $request->id)
                    ->withTrashed()
                    ->first()
        ;
        $permiso->forceDelete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Permiso Eliminado Permanentemente'
        ],200);
    }


}
