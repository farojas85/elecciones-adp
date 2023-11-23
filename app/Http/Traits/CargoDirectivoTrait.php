<?php
namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CargoDirectivo;

trait CargoDirectivoTrait
{
    public function activos(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;

        return CargoDirectivo::select('id','nombre', 'es_activo')
                ->where('es_activo',1)
                ->where(DB::Raw("upper(nombre)"),'like','%'.$buscar.'%')
                ->orderBy('id','asc')
                ->paginate($paginacion);
    }

    public function inactivos(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;

        return CargoDirectivo::select('id','nombre', 'es_activo')
                ->where('es_activo',0)
                ->where(DB::Raw("upper(nombre)"),'like','%'.$buscar.'%')
                ->orderBy('id','asc')
                ->paginate($paginacion);
    }

    public function todos(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;

        return CargoDirectivo::select('id','nombre', 'es_activo')
                ->where(DB::Raw("upper(nombre)"),'like','%'.$buscar.'%')
                ->orderBy('id','asc')
                ->paginate($paginacion);
    }
}
