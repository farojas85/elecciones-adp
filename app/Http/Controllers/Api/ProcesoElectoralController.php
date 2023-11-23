<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProcesoElectoral\StoreProcesoElectoralRequest;
use App\Http\Requests\ProcesoElectoral\UpdateProcesoElectoralRequest;
use App\Http\Traits\ProcesoElectoralTrait;
use App\Models\ProcesoElectoral;
use Illuminate\Http\Request;

class ProcesoElectoralController extends Controller
{
    use ProcesoElectoralTrait;
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
    public function store(StoreProcesoElectoralRequest $request)
    {
        $request->validated();

        $proceso_electoral = $this->storeData($request);

        return response()->json($proceso_electoral,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProcesoElectoral  $procesoElectoral
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $proceso_electoral = $this->obtenerProcesoElectoral($request);

        return response()->json($proceso_electoral,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProcesoElectoral  $procesoElectoral
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProcesoElectoralRequest $request)
    {
        $request->validated();

        $proceso_electoral = $this->updateData($request);

        return response()->json($proceso_electoral,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProcesoElectoral  $procesoElectoral
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProcesoElectoral $procesoElectoral)
    {
        //
    }
}
