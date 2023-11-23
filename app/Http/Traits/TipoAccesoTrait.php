<?php
namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TipoAcceso;

trait TipoAccesoTrait
{
    public function habilitados(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;

        return TipoAcceso::select('id','nombre','slug','es_activo','deleted_at')
            ->where(function($query) use($buscar){
                $query->where(DB::Raw("upper(nombre)",'like','%'.$buscar.'%'))
                    ->orWhere(DB::Raw("upper(slug)"),'like','%'.$buscar.'%');
            })
            ->paginate($paginacion)
        ;
    }

    public function todos(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;

        return TipoAcceso::select('id','nombre','slug','es_activo','deleted_at')
            ->where(function($query) use($buscar){
                $query->where(DB::Raw("upper(nombre)",'like','%'.$buscar.'%'))
                    ->orWhere(DB::Raw("upper(slug)"),'like','%'.$buscar.'%');
            })->withTrashed()
            ->paginate($paginacion)
        ;
    }

    public function eliminados(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;

        return TipoAcceso::select('id','nombre','slug','es_activo','deleted_at')
            ->where(function($query) use($buscar){
                $query->where(DB::Raw("upper(nombre)",'like','%'.$buscar.'%'))
                    ->orWhere(DB::Raw("upper(slug)"),'like','%'.$buscar.'%');
            })->onlyTrashed()
            ->paginate($paginacion)
        ;
    }

    public function activos(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;

        return TipoAcceso::select('id','nombre','slug','es_activo','deleted_at')
            ->where(function($query) use($buscar){
                $query->where(DB::Raw("upper(nombre)",'like','%'.$buscar.'%'))
                    ->orWhere(DB::Raw("upper(slug)"),'like','%'.$buscar.'%');
            })
            ->paginate($paginacion)
        ;
    }

    public function inactivos(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;

        return TipoAcceso::select('id','nombre','slug','es_activo','deleted_at')
            ->where(function($query) use($buscar){
                $query->where(DB::Raw("upper(nombre)",'like','%'.$buscar.'%'))
                    ->orWhere(DB::Raw("upper(slug)"),'like','%'.$buscar.'%');
            })
            ->paginate($paginacion)
        ;
    }
}
