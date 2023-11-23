<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Traits\RoleTrait;


class RoleController extends Controller
{
    use RoleTrait;
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
    public function store(StoreRoleRequest $request )
    {
        $request->validated();

        $role = Role::firstOrCreate([
            'nombre' => $request->nombre,
            'slug' => $request->slug,
            'tipo_acceso_id' => $request->tipo_acceso_id
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Rol registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $role = Role::where('id',$request->id)->first();
        return $role;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request)
    {
        $request->validated();

        $role = Role::where('id',$request->id)->first();
        $role->nombre = $request->nombre;
        $role->slug = $request->slug;
        $role->tipo_acceso_id = $request->tipo_acceso_id;
        $role->es_activo = ($request->es_activo ==true) ? 1 : 0;
        $role->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Tipo Acceso modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $role = Role::where('id', $request->id)
                    ->withTrashed()
                    ->first()
        ;

        $role->es_activo = 0;
        $role->save();


        $role->delete();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Rol enviado a papelera satisfactoriamente'
        ],200);
    }

    public function restaurar(Request $request){
        $role = Role::where('id', $request->id)
                    ->withTrashed()
                    ->first()
        ;
        $role->restore();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Rol restaurado satisfactoriamente'
        ],200);
    }

    public function eliminarPermanente(Request $request)
    {
        $role = Role::where('id', $request->id)
                    ->withTrashed()
                    ->first()
        ;

        $role->forceDelete();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Rol Eliminado Permanentemente'
        ],200);
    }

    public function listar()
    {
        return Role::select('id','nombre')->get();
    }
}
