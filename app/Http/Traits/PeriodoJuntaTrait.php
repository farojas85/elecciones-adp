<?php
namespace App\Http\Traits;

use App\Models\Ministro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PeriodoJunta;

trait PeriodoJuntaTrait
{
    public function activos(Request $request)
    {
        $paginacion = $request->paginacion;

        return PeriodoJunta::select(
                   'id','anio_inicio', 'anio_fin','es_activo'
                )
                ->where('periodo_juntas.es_activo',1)
                ->orderBy('periodo_juntas.id','desc')
                ->paginate($paginacion);
    }

    public function inactivos(Request $request)
    {
        $paginacion = $request->paginacion;

        return PeriodoJunta::select(
                'id','anio_inicio', 'anio_fin','es_activo'
            )
            ->where('periodo_juntas.es_activo',0)
            ->orderBy('periodo_juntas.id','desc')
            ->paginate($paginacion)
        ;
    }

    public function todos(Request $request)
    {
        $paginacion = $request->paginacion;

        return PeriodoJunta::select(
            'id','anio_inicio', 'anio_fin','es_activo'
         )
         ->orderBy('periodo_juntas.id','desc')
         ->paginate($paginacion);
    }

    public function buscarMinistro(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);

        return Ministro::with('persona:id,nombres,apellido_paterno,apellido_materno')
                    ->whereHas('persona', function($q) use($buscar){
                        $q->where(DB::Raw("upper(concat(apellido_paterno,' ',apellido_materno))"),
                                    'like', '%'.$buscar.'%')
                            ->orWhere(DB::Raw("upper(nombres)"),'like','%'.$buscar.'%');
                    })->get();
    }

    public function agregarCandidato(Request $request)
    {
        $periodo_junta = PeriodoJunta::with('ministros')->where('id', $request->id)->first();

        $ministro = $request->ministro_id;

        $registrado = PeriodoJunta::with('ministros')
            ->whereHas('ministros', function($q) use($ministro) {
            $q->where('ministros.id',$ministro);
        })
        ->where('periodo_juntas.id', $request->id)->count();

        if($registrado==0)
        {
            $periodo_junta->ministros()->attach($ministro,['orden' => PeriodoJunta::maxOrdenMinistro($request->id)]);

            return response()->json([
                'ok' => 1,
                'mensaje' => 'El ministro ha sido añadido satisfactoriamente como candidato para el Periodo '.
                            $periodo_junta->anio_inicio.' - '.$periodo_junta->anio_fin
            ]);
        }

        if($registrado > 0)
        {
            return response()->json([
                'ok' => 2,
                'mensaje' => 'El ministro ya es encuentra registrado como candidato en el periodo '.
                            $periodo_junta->anio_inicio.' - '.$periodo_junta->anio_fin
            ]);
        }

    }

    public function eliminarCandidato(Request $request)
    {
        $periodo_junta = PeriodoJunta::with('ministros')->where('id', $request->id)->first();

        //Actualizamos el Orden
        PeriodoJunta::modificarOrden($request->id,$request->ministro_id);
        //Eliminamos al ministro de candidatos
        $periodo_junta->ministros()->detach($request->ministro_id);


        return response()->json([
            'ok' => 1,
            'mensaje' => 'El ministro ha sido eliminado satisfactoriamente como candidato del Periodo '.
                        $periodo_junta->anio_inicio.' - '.$periodo_junta->anio_fin
        ]);
    }
}
