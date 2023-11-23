<?php
namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\JuntaDirectiva;

trait JuntaDirectivaTrait
{
    public function activos(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;

        return JuntaDirectiva::leftJoin('ambito_juntas as aj','aj.id','=','junta_directivas.ambito_junta_id')
                ->leftJoin('departamentos as dep','junta_directivas.ubigeo','=','dep.codigo')
                ->leftJoin('provincias as prov','junta_directivas.ubigeo','=','prov.codigo')
                ->leftJoin('distritos as dist','junta_directivas.ubigeo','=','dist.codigo')
                ->select(
                    'junta_directivas.id','junta_directivas.nombre', 'junta_directivas.es_activo',
                    'aj.nombre as ambito_junta',
                    DB::Raw("
                        CASE
                            WHEN LENGTH(junta_directivas.ubigeo) = 2 THEN dep.nombre
                            WHEN LENGTH(junta_directivas.ubigeo) = 4 THEN concat(dep.nombre,' | ',prov.nombre)
                            WHEN LENGTH(junta_directivas.ubigeo) = 6 THEN concat(dep.nombre,' | ',prov.nombre,' | ',dist.nombre)
                        END as ubigeo
                    ")
                )
                ->where('junta_directivas.es_activo',1)
                ->where( function($query) use($buscar) {
                    $query->where(DB::Raw("upper(junta_directivas.nombre)"),'like','%'.$buscar.'%')
                        ->orWhere(DB::Raw("upper(aj.nombre)"), 'like', '%'.$buscar
                    );
                }

                )
                ->orderBy('junta_directivas.id','desc')
                ->paginate($paginacion);
    }

    public function inactivos(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;

        return JuntaDirectiva::leftJoin('ambito_juntas as aj','aj.id','=','junta_directivas.ambito_junta_id')
                ->select(
                    'junta_directivas.id','junta_directivas.nombre', 'junta_directivas.es_activo',
                    'aj.nombre as ambito_junta'
                )
                ->where('junta_directivas.es_activo',0)
                ->where( function($query) use($buscar) {
                    $query->where(DB::Raw("upper(junta_directivas.nombre)"),'like','%'.$buscar.'%')
                        ->orWhere(DB::Raw("upper(aj.nombre)"), 'like', '%'.$buscar
                    );
                }

                )
                ->orderBy('junta_directivas.id','desc')
                ->paginate($paginacion);
    }

    public function todos(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;

        return JuntaDirectiva::leftJoin('ambito_juntas as aj','aj.id','=','junta_directivas.ambito_junta_id')
                ->select(
                    'junta_directivas.id','junta_directivas.nombre', 'junta_directivas.es_activo',
                    'aj.nombre as ambito_junta'
                )
                ->where( function($query) use($buscar) {
                    $query->where(DB::Raw("upper(junta_directivas.nombre)"),'like','%'.$buscar.'%')
                        ->orWhere(DB::Raw("upper(aj.nombre)"), 'like', '%'.$buscar
                    );
                }

                )
                ->orderBy('junta_directivas.id','desc')
                ->paginate($paginacion);
    }
}
