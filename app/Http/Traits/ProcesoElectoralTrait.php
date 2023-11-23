<?php
namespace App\Http\Traits;

use App\Http\Requests\ProcesoElectoral\StoreProcesoElectoralRequest;
use App\Http\Requests\ProcesoElectoral\UpdateProcesoElectoralRequest;
use App\Models\CargoDirectivo;
use App\Models\EleccionJunta;
use App\Models\JuntaDirectiva;
use App\Models\PeriodoJunta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProcesoElectoral;
use App\Models\VueltaProceso;
use Exception;
use PhpParser\Node\Stmt\TryCatch;

trait ProcesoElectoralTrait
{
    public function todos(Request $request)
    {
        $paginacion = $request->paginacion;

        return ProcesoElectoral::leftJoin('vuelta_procesos as vp','vp.id','=','proceso_electorals.vuelta_proceso_id')
                            ->leftJoin('cargo_directivo_eleccion_junta as cdej','cdej.id','=','proceso_electorals.cargo_directivo_eleccion_junta_id')
                            ->leftJoin('cargo_directivos as cd','cd.id','=','cdej.cargo_directivo_id')
                            ->leftJoin('eleccion_juntas as ej','ej.id','=','cdej.eleccion_junta_id')
                            ->leftJoin('periodo_juntas as pj','pj.id','=','ej.periodo_junta_id')
                            ->leftJoin('junta_directivas as jd','jd.id','=','ej.junta_directiva_id')
                            ->select(
                                'proceso_electorals.id','jd.nombre as junta_directiva',
                                DB::Raw("concat(pj.anio_inicio,' - ',pj.anio_fin) as periodo"),
                                'cd.nombre as cargo_directivo', 'vp.nombre as vuelta_nombre',
                                'vp.abreviatura as vuelta_abreviatura',
                                'proceso_electorals.fecha','proceso_electorals.hora',
                                'proceso_electorals.es_activo', 'proceso_electorals.finalizado'

                            )
                            ->orderBy('proceso_electorals.id','asc')
                            ->paginate($paginacion)
        ;
    }


    public function activos(Request $request)
    {
        $paginacion = $request->paginacion;

        return ProcesoElectoral::select(
            'id','anio_inicio', 'anio_fin','es_activo'
            )
            ->where('periodo_juntas.es_activo',1)
            ->orderBy('periodo_juntas.id','desc')
            ->paginate($paginacion)
        ;
    }

    public function obtenerPeriodoElectoralesActivos()
    {
        return EleccionJunta::with([
            'periodo_junta:id,anio_inicio,anio_fin',
            'junta_directiva:id,nombre'
        ])->where('es_activo',1)
        ->orderBy('created_at','desc')
        ->first();
    }

    public function obtenerDatosIniciales()
    {
        $periodo_juntas = PeriodoJunta::select('id','anio_inicio','anio_fin')->get();

        $junta_directivas = JuntaDirectiva::select('id','nombre')->get();

        $cargo_directivos = CargoDirectivo::select('id','nombre')->get();

        $vuelta_procesos = VueltaProceso::select('id','nombre','abreviatura')->get();

        return response()->json([
            'periodo_juntas' => $periodo_juntas,
            'junta_directivas' => $junta_directivas,
            'cargo_directivos' => $cargo_directivos,
            'vuelta_procesos' => $vuelta_procesos
        ]);
    }

    public function storeData(StoreProcesoElectoralRequest $request): array
    {
        try {



            $eleccion_junta = EleccionJunta::select('id')->where('periodo_junta_id',$request->periodo_junta_id)
                                ->where('junta_directiva_id',$request->junta_directiva_id)
                                ->first()
            ;

            $cargo_eleccion_junta = DB::table('cargo_directivo_eleccion_junta')
                                        ->where('cargo_directivo_id',$request->cargo_directivo_id)
                                        ->where('eleccion_junta_id',$eleccion_junta->id)
                                        ->select('cargo_directivo_eleccion_junta.id')
                                        ->first()
            ;

            $proceso_electoral = new ProcesoElectoral();
            $proceso_electoral->cargo_directivo_eleccion_junta_id = $cargo_eleccion_junta->id;
            $proceso_electoral->vuelta_proceso_id = $request->vuelta_proceso_id;
            $proceso_electoral->fecha = Date('Y-m-d');
            $proceso_electoral->hora = Date('H:i:s');
            $proceso_electoral->save();

            return [
                'ok' => 1,
                'mensaje' => 'Proceso Electoral registrado satisfactoriamente',
                'data' => null
            ];

        } catch (Exception $ex) {
            return [
                'ok' => $ex->getCode(),
                'mensaje' => $ex->getMessage(),
                'data' => null
            ];
        }
    }

    public function obtenerProcesoElectoral(Request $request)
    {
        return $proceso_electoral = ProcesoElectoral::leftJoin('cargo_directivo_eleccion_junta as cdej','cdej.id','=','proceso_electorals.cargo_directivo_eleccion_junta_id')
                                ->leftJoin('cargo_directivos as cd','cd.id','=','cdej.cargo_directivo_id')
                                ->leftJoin('eleccion_juntas as ej','ej.id','=','cdej.eleccion_junta_id')
                                ->leftjoin('periodo_juntas as pj','pj.id','=','ej.periodo_junta_id')
                                ->leftJoin('junta_directivas as jd','jd.id','=','ej.junta_directiva_id')
                                ->leftJoin('vuelta_procesos as vp','vp.id','=','proceso_electorals.vuelta_proceso_id')
                                ->select(
                                    'proceso_electorals.id','periodo_junta_id','junta_directiva_id','eleccion_junta_id',
                                    'cargo_directivo_id','vuelta_proceso_id','proceso_electorals.es_activo',
                                    'proceso_electorals.finalizado'
                                )
                                ->where('proceso_electorals.id',$request->id)
                                ->first()
        ;
    }

    public function updateData(UpdateProcesoElectoralRequest $request): array
    {
        try {



            $eleccion_junta = EleccionJunta::select('id')->where('periodo_junta_id',$request->periodo_junta_id)
                                ->where('junta_directiva_id',$request->junta_directiva_id)
                                ->first()
            ;

            $cargo_eleccion_junta = DB::table('cargo_directivo_eleccion_junta')
                                        ->where('cargo_directivo_id',$request->cargo_directivo_id)
                                        ->where('eleccion_junta_id',$eleccion_junta->id)
                                        ->select('cargo_directivo_eleccion_junta.id')
                                        ->first()
            ;

            $proceso_electoral = ProcesoElectoral::find($request->id);
            $proceso_electoral->cargo_directivo_eleccion_junta_id = $cargo_eleccion_junta->id;
            $proceso_electoral->vuelta_proceso_id = $request->vuelta_proceso_id;
            $proceso_electoral->es_activo = $request->es_activo === true ? 1 : 0;
            $proceso_electoral->finalizado = $request->finalizado === true ? 1 : 0;
            // $proceso_electoral->fecha = Date('Y-m-d');
            // $proceso_electoral->hora = Date('H:i:s');
            $proceso_electoral->save();

            return [
                'ok' => 1,
                'mensaje' => 'Proceso Electoral ha sido modificado satisfactoriamente',
                'data' => null
            ];

        } catch (Exception $ex) {
            return [
                'ok' => $ex->getCode(),
                'mensaje' => $ex->getMessage(),
                'data' => null
            ];
        }
    }

    public function obtenerProcesoElectoralActivo()
    {

        return ProcesoElectoral::join('cargo_directivo_eleccion_junta as cdej','cdej.id','=','proceso_electorals.cargo_directivo_eleccion_junta_id')
                ->join('cargo_directivos as cd','cd.id','=','cdej.cargo_directivo_id')
                ->join('eleccion_juntas as ej','ej.id','=','cdej.eleccion_junta_id')
                ->join('periodo_juntas as pj','pj.id','=','ej.periodo_junta_id')
                ->join('junta_directivas as jd','jd.id','=','ej.junta_directiva_id')
                ->join('vuelta_procesos as vp','vp.id','=','proceso_electorals.vuelta_proceso_id')
                ->select(
                    'proceso_electorals.id', 'jd.nombre as junta_directiva',
                    DB::Raw("concat(pj.anio_inicio,' - ',pj.anio_fin) as periodo"),
                    'cd.nombre as cargo_directivo', 'vp.nombre as vuelta_proceso'
                )
                ->where('proceso_electorals.es_activo',1)->where('proceso_electorals.finalizado',0)->orderBy('id','desc')
                ->first()
        ;
    }

}
