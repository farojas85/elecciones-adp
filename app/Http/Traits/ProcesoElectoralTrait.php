<?php
namespace App\Http\Traits;

use App\Http\Requests\ProcesoElectoral\StoreProcesoElectoralRequest;
use App\Http\Requests\ProcesoElectoral\UpdateProcesoElectoralRequest;
use App\Models\CargoDirectivo;
use App\Models\EleccionJunta;
use App\Models\EleccionJuntaCandidato;
use App\Models\JuntaDirectiva;
use App\Models\PeriodoJunta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProcesoElectoral;
use App\Models\ProcesoElectoralVoto;
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

        $proceso_electoral = ProcesoElectoral::join('cargo_directivo_eleccion_junta as cdej','cdej.id','=','proceso_electorals.cargo_directivo_eleccion_junta_id')
                ->join('cargo_directivos as cd','cd.id','=','cdej.cargo_directivo_id')
                ->join('eleccion_juntas as ej','ej.id','=','cdej.eleccion_junta_id')
                ->join('periodo_juntas as pj','pj.id','=','ej.periodo_junta_id')
                ->join('junta_directivas as jd','jd.id','=','ej.junta_directiva_id')
                ->join('vuelta_procesos as vp','vp.id','=','proceso_electorals.vuelta_proceso_id')
                ->select(
                    'proceso_electorals.id', 'jd.nombre as junta_directiva',
                    DB::Raw("concat(pj.anio_inicio,' - ',pj.anio_fin) as periodo"),
                    'cd.nombre as cargo_directivo', 'vp.nombre as vuelta_proceso',
                    'cdej.eleccion_junta_id','votos_validos','votos_emitidos','votos_blancos',
                    DB::Raw("(
                        SELECT COUNT(pev.ministro_id) FROM proceso_electoral_votos as pev
                        WHERE pev.proceso_electoral_id = proceso_electorals.id
                    ) as cantidad_candidatos")
                )
                ->where('proceso_electorals.es_activo',1)
                ->where('proceso_electorals.finalizado',0)->orderBy('id','desc')
                ->first()
        ;

        $proceso_electoral['candidatos'] = [];
        $vuelta_proceso =  $proceso_electoral->vuelta_proceso;
        $eleccion_junta = $proceso_electoral->eleccion_junta_id;
        if($proceso_electoral->cantidad_candidatos == 0) {

            $candidatos = EleccionJuntaCandidato::join('ministros as mi','mi.id','eleccion_junta_candidatos.ministro_id')
                            ->join('personas as per','per.id','=','mi.persona_id')
                            ->select(
                                'eleccion_junta_id','ministro_id','numero_candidato',
                                DB::Raw("concat(upper(per.apellido_paterno),' ',upper(per.apellido_materno),', ',upper(per.nombres)) as candidato"),
                                DB::Raw('false as aceptado')
                            )
                            ->where('eleccion_junta_candidatos.eleccion_junta_id',$eleccion_junta)
                            ->where(function($query) use($vuelta_proceso,$eleccion_junta) {
                                if($vuelta_proceso == 'Primera Votación') {
                                    $query->whereNotIn('ministro_id', function($query){
                                        $query->select('pev.ministro_id')
                                            ->from('proceso_electoral_votos as pev')
                                            ->join('proceso_electorals  as pel','pel.id','=','pev.proceso_electoral_id')
                                            ->join('cargo_directivo_eleccion_junta as cdej','cdej.id','=','pel.cargo_directivo_eleccion_junta_id')
                                            ->join('eleccion_juntas as ej','ej.id','=','cdej.eleccion_junta_id')
                                            ->where('ej.id','=','eleccion_junta_candidatos.eleccion_junta_id')
                                            ->where(function($query) {
                                                $query->where('pev.no_continua',1)
                                                    ->orWhere('pev.es_ganador',1);
                                            });
                                    });
                                }
                                else if($vuelta_proceso == 'Segunda Votación') {
                                    $query->whereIn('eleccion_junta_candidatos.ministro_id', function($query) use($eleccion_junta) {
                                        $query->select('pev2.ministro_id')
                                        ->from('proceso_electoral_votos as pev2')
                                        ->join('proceso_electorals  as pel2','pel2.id','=','pev2.proceso_electoral_id')
                                        ->join('cargo_directivo_eleccion_junta as cdej2','cdej2.id','=','pel2.cargo_directivo_eleccion_junta_id')
                                        ->join('eleccion_juntas as ej2','ej2.id','=','cdej2.eleccion_junta_id')
                                        ->join('vuelta_procesos as vp2','vp2.id','=','pel2.vuelta_proceso_id')
                                        ->where('ej2.id','=',$eleccion_junta)
                                        ->where('vp2.nombre','=','Primera Votación')
                                        ->where('pev2.pasa_vuelta',1);
                                    });
                                }
                                else if($vuelta_proceso == 'Tercera Votación') {
                                    $query->whereIn('eleccion_junta_candidatos.ministro_id', function($query) use($eleccion_junta) {
                                        $query->select('pev2.ministro_id')
                                        ->from('proceso_electoral_votos as pev2')
                                        ->join('proceso_electorals  as pel2','pel2.id','=','pev2.proceso_electoral_id')
                                        ->join('cargo_directivo_eleccion_junta as cdej2','cdej2.id','=','pel2.cargo_directivo_eleccion_junta_id')
                                        ->join('eleccion_juntas as ej2','ej2.id','=','cdej2.eleccion_junta_id')
                                        ->join('vuelta_procesos as vp2','vp2.id','=','pel2.vuelta_proceso_id')
                                        ->where('ej2.id','=',$eleccion_junta)
                                        ->where('vp2.nombre','=','Segunda Votación')
                                        ->where('pev2.pasa_vuelta',1);
                                    });
                                }
                            })
                            ->orderBy('numero_candidato','asc')
                            ->get();
            if($candidatos){
                $proceso_electoral['candidatos'] = $candidatos;
            }
        }
        if($proceso_electoral->cantidad_candidatos > 0)
        {

            $candidatos = ProcesoElectoralVoto::join('proceso_electorals as pre','pre.id','=','proceso_electoral_votos.proceso_electoral_id')
                                    ->join('cargo_directivo_eleccion_junta as cdej','cdej.id','=','pre.cargo_directivo_eleccion_junta_id')
                                    ->join('cargo_directivos as cd','cd.id','=','cdej.cargo_directivo_id')
                                    ->join('eleccion_juntas as ej','ej.id','=','cdej.eleccion_junta_id')
                                    ->join('eleccion_junta_candidatos as ejc','ejc.eleccion_junta_id','=','ej.id')
                                    ->join('ministros as mi',function($join){
                                        $join->on('mi.id','=','proceso_electoral_votos.ministro_id')
                                            ->on('mi.id','=','ejc.ministro_id');
                                    })
                                    ->join('personas as per','per.id','=','mi.persona_id')
                                    ->select(
                                        'proceso_electoral_votos.id','proceso_electoral_votos.ministro_id',
                                        'ejc.numero_candidato',
                                        DB::Raw(
                                            "concat(upper(per.apellido_paterno),' ',upper(per.apellido_materno),', ',upper(per.nombres)) as candidato"
                                        ),
                                        'proceso_electoral_votos.cantidad_votos'

                                    )
                                    ->where('proceso_electoral_votos.proceso_electoral_id',$proceso_electoral->id)
                                    ->where('pre.es_activo',1)
                                    ->where(function($query) {
                                        $query->where('no_continua',0)
                                            ->Where('es_ganador',0);
                                    })
                                    ->whereIn('pasa_vuelta',[0,1])
                                    ->orderBy('proceso_electoral_votos.cantidad_votos','desc')
                                    ->orderBy('per.apellido_paterno','asc')
                                    ->orderBy('per.apellido_materno','asc')
                                    ->orderBy('per.nombres')
                                    ->get()
            ;

            if($candidatos){
                $proceso_electoral['candidatos'] = $candidatos;
            }

        }

        return response()->json($proceso_electoral,200);

    }

    public function registrarCandidatosEnProceso(Request $request)
    {
        try {

            $proceso_electoral = $request;

            $cantidad_candidatos = count($proceso_electoral->candidatos);
            $contar_candidatos = 0;
            foreach($proceso_electoral->candidatos as $candidato) {
                $proceso_electoral_voto = ProcesoElectoralVoto::where('proceso_electoral_id',$proceso_electoral->id)
                                                ->where('ministro_id',$candidato['ministro_id'])
                                                ->first()
                ;
                if(!$proceso_electoral_voto) {

                    $proceso_electoral_voto = new ProcesoElectoralVoto();
                    $proceso_electoral_voto->proceso_electoral_id = $proceso_electoral->id;
                    $proceso_electoral_voto->ministro_id = $candidato['ministro_id'];
                    $proceso_electoral_voto->cantidad_votos = 0;
                    $proceso_electoral_voto->no_continua = (in_array($candidato['aceptado'],[false,0]) ? 1 : 0);
                    $proceso_electoral_voto->save();
                    $contar_candidatos +=1;
                }
            }

            $contar_proceso_votos = ProcesoElectoralVoto::where('proceso_electoral_id',$proceso_electoral->id)->count('ministro_id');

            if($cantidad_candidatos == $contar_candidatos) {
                return response()->json([
                    'ok'=> 1,
                    'mensaje' => 'Candidatos registrados satisfactoriamente',
                    'contar_candidatos' => $contar_proceso_votos
                ]);
            }
        } catch (Exception $exc) {
            return response()->json([
                'ok'=> $exc->getCode(),
                'mensaje' => $exc->getMessage(),
                'contar_candidatos' => 0
            ]);
        }
    }

    public function votacionEnProceso(Request $request)
    {

        $proceso_electoral = ProcesoElectoral::join('cargo_directivo_eleccion_junta as cdej','cdej.id','=','proceso_electorals.cargo_directivo_eleccion_junta_id')
                ->join('cargo_directivos as cd','cd.id','=','cdej.cargo_directivo_id')
                ->join('eleccion_juntas as ej','ej.id','=','cdej.eleccion_junta_id')
                ->join('periodo_juntas as pj','pj.id','=','ej.periodo_junta_id')
                ->join('junta_directivas as jd','jd.id','=','ej.junta_directiva_id')
                ->join('vuelta_procesos as vp','vp.id','=','proceso_electorals.vuelta_proceso_id')
                ->select(
                    'proceso_electorals.id', 'jd.nombre as junta_directiva',
                    DB::Raw("concat(pj.anio_inicio,' - ',pj.anio_fin) as periodo"),
                    'cd.nombre as cargo_directivo', 'vp.nombre as vuelta_proceso',
                    'cdej.eleccion_junta_id', 'proceso_electorals.votos_validos','
                    proceso_electorals.votos_emitidos','proceso_electorals.votos_blancos',
                    DB::Raw("(
                        SELECT COUNT(pev.id) FROM proceso_electoral_votos as pev
                        WHERE pev.proceso_electoral_id = proceso_electorals.id
                    ) as cantidad_candidatos")
                )
                ->where('id', $request->id)
                ->where('proceso_electorals.es_activo',1)
                ->where('proceso_electorals.finalizado',0)
                ->orderBy('id','desc')
                ->first()
        ;

        //$proceso_electoral = ProcesoElectoral::where('id',$request->id)->where('es_activo',1)->first();

        $proceso_electoral['candidatos'] = [];

        $proceso_electoral_voto = ProcesoElectoralVoto::join('proceso_electorals as pre','pre.id','=','proceso_electoral_votos.proceso_electoral_id')
                                    ->join('cargo_directivo_eleccion_junta as cdej','cdej.id','=','proceso_electorals.cargo_directivo_eleccion_junta_id')
                                    ->join('cargo_directivos as cd','cd.id','=','cdej.cargo_directivo_id')
                                    ->join('eleccion_juntas as ej','ej.id','=','cdej.eleccion_junta_id')
                                    ->join('eleccion_junta_candidatos as ejc','ejc.eleccion_junta_id','=','ej.id')
                                    ->join('ministros as mi',function($join){
                                        $join->on('mi.id','=','proceso_electoral_votos.ministro_id')
                                            ->on('mi.id','=','ejc.ministro_id');
                                    })
                                    ->join('personas as per','per.id','=','mi.persona_id')
                                    ->select(
                                        'proceso_electoral_votos.id','proceso_electoral_votos.ministro_id',
                                        'ejc.numero_candidato',
                                        DB::Raw(
                                            "concat(upper(per.apellido_paterno),' ',upper(per.apellido_materno),', ',upper(per.nombres)) as candidato"
                                        ),
                                        'proceso_electoral_votos.cantidad_votos'

                                    )
                                    ->where('proceso_electoral_id',$request->id)
                                        ->where(function($query) {
                                            $query->where('no_continua',0)
                                                ->orWhere('es_ganador',0);
                                        })
                                    ->whereIn('pasa_vuelta',[0,1])
                                    ->orderBy('proceso_electoral_votos.cantidad_votos','desc')
                                    ->orderBy('per.apellido_paterno','asc')
                                    ->orderBy('per.apellido_materno','asc')
                                    ->orderBy('per.nombres')
                                    ->get()
        ;

        if($proceso_electoral_voto)
        {
            $proceso_electoral['canidatos'] = $proceso_electoral_voto;
        }

        return response()->json($proceso_electoral,200);
    }

    public function registrarVotacion(Request $request) {

        if($request->numero_candidato == '' || $request->numero_candidato == null)
        {
            return response([
                'errors' => [ 'numero_candidato' => 'ingrese número de candidato']
            ], 422);
        }

        $eleccion_junta_candidato = EleccionJuntaCandidato::where('eleccion_junta_id','=',$request->eleccion_junta_id)
                                        ->select('ministro_id')
                                        ->where('numero_candidato',$request->numero_candidato)
                                        ->first();

        if(!$eleccion_junta_candidato) {
            if($request->numero_candidato == 0) {
                $proceso_electoral = ProcesoElectoral::where('id',$request->id)->first();
                if($proceso_electoral)
                {
                    $proceso_electoral->votos_blancos = ($proceso_electoral->votos_blancos==null || $proceso_electoral->votos_blancos=='')
                                                        ? 1 : $proceso_electoral->votos_blancos + 1
                    ;

                    $proceso_electoral->save();
                }
                $proceso_electoral->votos_validos = $proceso_electoral->votos_validos + 1;
                $proceso_electoral->votos_emitidos = $proceso_electoral->votos_emitidos + 1;

                return response()->json([
                    'ok' => 1,
                    'mensaje' => 'Voto registrado saisfactoriamente'
                ]);
            }
            else {
                return response([
                    'errors' => [ 'numero_candidato' => 'Número candiato no válido']
                ], 422);
            }
        }

        if($eleccion_junta_candidato){

            $proceso_electoral_voto = ProcesoElectoralVoto::where('proceso_electoral_id',$request->id)
                                        ->where('ministro_id',$eleccion_junta_candidato->ministro_id)
                                        ->where('no_continua',0)
                                        ->first()
            ;

            if(!$proceso_electoral_voto) {
                return response([
                    'errors' => [ 'numero_candidato' => 'Número candiato no válido y/o no aceptó elección']
                ], 422);
            }
            else if($proceso_electoral_voto) {
                $proceso_electoral_voto->cantidad_votos = $proceso_electoral_voto->cantidad_votos  + 1;
                $proceso_electoral_voto->save();

                $proceso_electoral = ProcesoElectoral::where('id',$request->id)->first();
                $proceso_electoral->votos_validos = $proceso_electoral->votos_validos + 1;
                $proceso_electoral->votos_emitidos = $proceso_electoral->votos_emitidos + 1;
                $proceso_electoral->save();

                return response()->json([
                    'ok' => 1,
                    'mensaje' => 'Voto registrado saisfactoriamente'
                ]);

            }

        }

    }

    public function pasarSiguienteVotacion(Request $request)
    {

        if($request->vuelta_proceso == 'Primera Votación')
        {
            $candidatos = $request->candidatos;

            $cantidad_votos = array_column($candidatos, 'cantidad_votos');

            array_multisort($cantidad_votos,SORT_DESC,$candidatos);

            $x=0;
            foreach($candidatos as $candidato){
                $x+=1;
                if($x<=3) {
                    $proceso_electoral_voto = ProcesoElectoralVoto::where('proceso_electoral_id',$request->id)
                                                ->where('ministro_id',$candidato['ministro_id'])
                                                ->first();
                    $proceso_electoral_voto->pasa_vuelta = 1;
                    $proceso_electoral_voto->save();
                }
            }
            return response()->json([
                'ok' => 1,
                'mensaje' => 'Pasa a la Segunda votación'
            ]);
        }
        if($request->vuelta_proceso == 'Segunda Votación')
        {
            $candidatos = $request->candidatos;

            $cantidad_votos = array_column($candidatos, 'cantidad_votos');

            array_multisort($cantidad_votos,SORT_DESC,$candidatos);

            $x=0;
            foreach($candidatos as $candidato){
                $x+=1;
                if($x<=2) {
                    $proceso_electoral_voto = ProcesoElectoralVoto::where('proceso_electoral_id',$request->id)
                                                ->where('ministro_id',$candidato['ministro_id'])
                                                ->first();
                    $proceso_electoral_voto->pasa_vuelta = 1;
                    $proceso_electoral_voto->save();
                }
            }
            return response()->json([
                'ok' => 1,
                'mensaje' => 'Pasa a la Tercera votación'
            ]);
        }
    }

}
