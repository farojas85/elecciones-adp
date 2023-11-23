<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\MenuTrait;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Requests\Menu\StoreMenuRequest;
use App\Http\Requests\Menu\UpdateMenuRequest;

class MenuController extends Controller
{
    use MenuTrait;
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
    public function store(StoreMenuRequest $request)
    {
        $request->validated();

        $orden = ($request->padre_id ) ? Menu::maximoHijoId($request->padre_id)
                : Menu::maximoPadreId()
        ;

        $menu = Menu::firstOrCreate([
            'nombre' => $request->nombre,
            'slug' => $request->slug,
            'icono' => $request->icono,
            'padre_id' => $request->padre_id,
            'orden' => $orden,
            'es_activo' => $request->es_activo
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Menú registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $menu = Menu::where('id',$request->id)->first();
        return $menu;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMenuRequest $request)
    {
        $request->validated();

        $menu = Menu::where('id',$request->id)->first();
        $menu->nombre = $request->nombre;
        $menu->slug = $request->slug;
        $menu->icono = $request->icono;
        $menu->padre_id = $request->padre_id;

        $orden = ($request->padre_id ) ? Menu::maximoHijoId($request->padre_id)
                : Menu::maximoPadreId()
        ;

        if($menu->padre_id != $request->padre_id)
        {
            $menu->orden = $orden;
        }

        $menu->es_activo = ($request->es_activo ==true) ? 1 : 0;
        $menu->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Menú modificado satisfactoriamente'
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
        $menu = Menu::where('id', $request->id)
                    ->withTrashed()
                    ->first()
        ;

        $menu->es_activo = 0;
        $menu->save();


        $menu->delete();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Menú enviado a papelera satisfactoriamente'
        ],200);
    }

    public function restaurar(Request $request){
        $menu = Menu::where('id', $request->id)
                    ->withTrashed()
                    ->first()
        ;
        $menu->restore();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Rol restaurado satisfactoriamente'
        ],200);
    }

    public function verificarEnRol(Request $request)
    {
        $menu = Menu::withCount('roles','menus')->where('id',$request->id)->withTrashed()->first();

        return response([
            'roles_count' => $menu->roles_count,
            'menus_count' => $menu->menus_count
        ]);
    }

    public function eliminarPermanente(Request $request)
    {
        $menu = Menu::where('id', $request->id)
                    ->withTrashed()
                    ->first()
        ;

        $menu->forceDelete();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Rol Eliminado Permanentemente'
        ],200);
    }

    public function obtenerPadres()
    {
        return Menu::whereNull('padre_id')
                    ->where('es_activo',1)
                    ->select('id','nombre')
                    ->orderBy('orden','asc')
                    ->get()
        ;
    }
}
