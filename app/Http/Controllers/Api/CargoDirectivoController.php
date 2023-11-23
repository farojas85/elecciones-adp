<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CargoDirectivo\StoreCargoDirectivoRequest;
use App\Http\Requests\CargoDirectivo\UpdateCargoDirectivoRequest;
use App\Http\Traits\CargoDirectivoTrait;
use App\Models\CargoDirectivo;
use Illuminate\Http\Request;

class CargoDirectivoController extends Controller
{
    use CargoDirectivoTrait;
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
    public function store(StoreCargoDirectivoRequest $request)
    {
        $request->validated();
        // $grado_ministerial = new GradoMinisterial;
        // $grado_ministerial->nombre = $request->nombre;
        // $grado_ministerial->save();
        $cargo_directivo = CargoDirectivo::create([
            'nombre' => $request->nombre,
            'es_activo' => 1
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'El Cargo Directivo ha sido registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CargoDirectivo  $cargoDirectivo
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return CargoDirectivo::select('id','nombre','es_activo')
                ->where('id', $request->id)
                ->first()
        ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CargoDirectivo  $cargoDirectivo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCargoDirectivoRequest $request)
    {
        $request->validated();

        $cargo_directivo = CargoDirectivo::find($request->id);
        $cargo_directivo->nombre = $request->nombre;
        $cargo_directivo->es_activo = ($request->es_activo ==true) ? 1 : 0;
        $cargo_directivo->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'El Cargo Directivo ha sido modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CargoDirectivo  $cargoDirectivo
     * @return \Illuminate\Http\Response
     */
    public function destroy(CargoDirectivo $cargoDirectivo)
    {
        //
    }

    public function habilitar(Request $request)
    {
        $cargo_directivo = CargoDirectivo::find($request->id);
        $cargo_directivo->es_activo = 1;
        $cargo_directivo->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Cargo Directivo habilitado satisfactoriamente'
        ],200);
    }

    public function inhabilitar(Request $request)
    {
        $cargo_directivo = CargoDirectivo::find($request->id);
        $cargo_directivo->es_activo = 0;
        $cargo_directivo->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Cargo Directivo inhabilitado satisfactoriamente'
        ],200);
    }

    public function listar()
    {
        return CargoDirectivo::select('id','nombre')->where('es_activo',1)->get();
    }
}
