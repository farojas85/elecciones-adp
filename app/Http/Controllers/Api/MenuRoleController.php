<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MenuRole\MostrarMenuRoleRequest;
use App\Models\Menu;
use App\Models\Role;
class MenuRoleController extends Controller
{
    public function obtenerMenus()
    {
        return Menu::with('menus')
                    ->select('id','nombre','slug','icono')
                    ->whereNull('padre_id')
                    ->orderBy('orden','asc')
                    ->get();
    }

    public function obtenerMenuRoles(MostrarMenuRoleRequest $request)
    {
        $request->validated();

        $role = Role::with('menus')->where('id',$request->role_id)->first();

        return response()->json([
            'role' => $role
        ]);
    }

    public function guardarMenuRole(Request $request)
    {
        $role = Role::where('id',$request->role_id)->first();

        $role->asignarMenus($request->menu_id);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Menús asignados satisfactoriamente'
        ]);
    }
}
