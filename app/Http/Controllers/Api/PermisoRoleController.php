<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permiso;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermisoRoleController extends Controller
{
    public function mostrarModelos()
    {
        return  Permiso::select(DB::Raw("DISTINCT( SUBSTRING_INDEX(SUBSTRING_INDEX(slug, '.', 1), '.', -1)) as nombre"))
        ->orderBy('nombre')->get();
    }

    public function mostrarRolePermisos(Request $request)
    {
        //Definimos las reglas de Validación
        $reglas = [
            'role_id' => 'required'
        ];
        //Agregamos Mensajes para las reglas
        $mensajes = [
            'required' => '* Dato Obligatorio'
        ];
        //procesamos la validación
        $this->validate($request,$reglas,$mensajes);
        $modelo = $request->modelo;

        $role = Role::with(['permisos' => function ($query) use($modelo){
            $query->where('slug','like',$modelo.'%');
        }])->where('id',$request->role_id)
        ->first();

        return response()->json([
            'role'          => $role,
            'role_permisos' => $role->permisos
        ]);

    }
    public function mostrarPermisos(Request $request) {
        $request->modelo = $request->modelo.'%';
        return Permiso::select('id','nombre','slug')
                        ->where('slug','like',$request->modelo)
                        ->get();
    }
    public function guardarRolePermission(Request $request)
    {
        $role = Role::where('id',$request->role_id)->first();

        $role->asignarPermisos($request->permiso_id);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Permisos Asignados Satisfactoriamente'
        ],200);
    }
}
