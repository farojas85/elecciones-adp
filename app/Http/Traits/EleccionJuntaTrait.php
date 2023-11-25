<?php
namespace App\Http\Traits;

use App\Models\CargoDirectivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\EleccionJunta;
use App\Models\EleccionJuntaCandidato;
use Exception;
use Illuminate\Support\Facades\Date;

trait EleccionJuntaTrait
{
    public function activos(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;

        return DB::table('eleccion_juntas as ej')
                    ->join('periodo_juntas as pj','pj.id','=','ej.periodo_junta_id')
                    ->join('junta_directivas as jd','jd.id','=','ej.junta_directiva_id')
                    ->select(
                        'ej.id',
                        DB::Raw("concat(pj.anio_inicio,' - ',pj.anio_fin) as periodo"),
                        'jd.nombre as junta_directiva',
                        "ej.fecha as fecha_eleccion",
                        'ej.es_activo'
                    )
                    ->where('ej.es_activo',1)
                    ->where('pj.es_activo',1)
                    ->where(DB::Raw("upper(jd.nombre)"),'like','%'.$buscar.'%')
                    ->orderBy('ej.id','desc')
                    ->paginate($paginacion);
    }

    public function inactivos(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;

        return DB::table('eleccion_juntas as ej')
                    ->join('periodo_juntas as pj','pj.id','=','ej.periodo_junta_id')
                    ->join('junta_directivas as jd','jd.id','=','ej.junta_directiva_id')
                    ->select(
                        'ej.id',
                        DB::Raw("concat(pj.anio_inicio,' - ',pj.anio_fin) as periodo"),
                        'jd.nombre as junta_directiva',
                        "ej.fecha as fecha_eleccion",
                        'ej.es_activo'
                    )
                    ->where('ej.es_activo',0)
                    ->where('pj.es_activo',1)
                    ->where(DB::Raw("upper(jd.nombre)"),'like','%'.$buscar.'%')
                    ->orderBy('ej.id','desc')
                    ->paginate($paginacion);
    }

    public function todos(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;

        return DB::table('eleccion_juntas as ej')
                    ->join('periodo_juntas as pj','pj.id','=','ej.periodo_junta_id')
                    ->join('junta_directivas as jd','jd.id','=','ej.junta_directiva_id')
                    ->select(
                        'ej.id',
                        DB::Raw("concat(pj.anio_inicio,' - ',pj.anio_fin) as periodo"),
                        'jd.nombre as junta_directiva',
                        "ej.fecha as fecha_eleccion",
                        'ej.es_activo'
                    )
                    ->where('pj.es_activo',1)
                    ->where(DB::Raw("upper(jd.nombre)"),'like','%'.$buscar.'%')
                    ->orderBy('ej.id','desc')
                    ->paginate($paginacion);
    }

    public function agregarCargoDirectivo(Request $request)
    {
        $eleccion_junta = EleccionJunta::with('cargo_directivos')->where('id', $request->id)->first();

        $cargo = $request->cargo_directivo_id;

        $registrado = EleccionJunta::with('cargo_directivos')
            ->whereHas('cargo_directivos', function($q) use($cargo) {
            $q->where('cargo_directivos.id',$cargo);
        })
        ->where('eleccion_juntas.id', $request->id)->count();

        if($registrado==0)
        {
            $eleccion_junta->cargo_directivos()->attach($cargo);

            return response()->json([
                'ok' => 1,
                'mensaje' => 'El cargo directivo ha sido añadido satisfactoriamente a la Elección Junta'
            ]);
        }

        if($registrado > 0)
        {
            return response()->json([
                'ok' => 2,
                'mensaje' => 'El cargo directivo ya es encuentra registrado cen la Elección Junta'
            ]);
        }

    }

    public function obtenerEleccionJuntaActual() {
        $eleccion_junta = EleccionJunta::join('periodo_juntas as pj','pj.id','=','eleccion_juntas.periodo_junta_id')
                                ->join('junta_directivas as jd','jd.id','=','eleccion_juntas.junta_directiva_id')
                                ->select(
                                    'eleccion_juntas.id','periodo_junta_id','junta_directiva_id',
                                    DB::Raw("concat(pj.anio_inicio,' - ',pj.anio_fin) as periodo"),
                                    'jd.nombre as junta_directiva'
                                )
                                ->whereYear('fecha',date('Y'))
                                ->first()
        ;

        $cargo_directivos = CargoDirectivo::join('cargo_directivo_eleccion_junta as cdej','cdej.cargo_directivo_id','=','cargo_directivos.id')
                                ->select(
                                    'cdej.id','cdej.cargo_directivo_id','cargo_directivos.nombre as cargo_directivo',
                                    DB::Raw("(
                                        select  concat(ps.apellido_paterno, ' ', ps.apellido_materno, ', ',ps.nombres) as candidato
                                        from proceso_electorals as pe
                                        inner join proceso_electoral_votos as pev on pev.proceso_electoral_id = pe.id
                                        inner join ministros as mi on mi.id = pev.ministro_id
                                        inner join personas as ps on ps.id = mi.persona_id
                                        where pe.cargo_directivo_eleccion_junta_id = cdej.id and  pev.es_ganador =1
                                    ) as candidato")
                                )->where('cdej.eleccion_junta_id',$eleccion_junta->id)
                                ->get();
        $eleccion_junta['cargo_directivos'] = [];

        if($cargo_directivos)
        {
            $eleccion_junta['cargo_directivos'] = $cargo_directivos;
        }


        return response()->json($eleccion_junta,200);


    }
    public function eliminarCargoDirectivo(Request $request)
    {
        $eleccion_junta = EleccionJunta::with('cargo_directivos')->where('id', $request->id)->first();

        //Eliminamos al ministro de candidatos
        $eleccion_junta->cargo_directivos()->detach($request->cargo_directivo_id);


        return response()->json([
            'ok' => 1,
            'mensaje' => 'El cargo directivo ha sido eliminado satisfactoriamente de la Elección Junta'
        ]);
    }

    public function agregarCandidato(Request $request)
    {
        try {
            $eleccion_junta_candidato  = EleccionJuntaCandidato::where('eleccion_junta_id', $request->id)
                                            ->where('ministro_id',$request->ministro)
                                            ->first()
            ;

            if(!$eleccion_junta_candidato)
            {
                $eleccion_junta_candidato = new EleccionJuntaCandidato();
                $eleccion_junta_candidato->eleccion_junta_id = $request->id;
                $eleccion_junta_candidato->ministro_id = $request->ministro;
                $eleccion_junta_candidato->numero_candidato = EleccionJuntaCandidato::generarNumeroCandidato($request->id);
                $eleccion_junta_candidato->save();

                return response()->json([
                    'ok' => 1,
                    'mensaje' => 'El candidato ha sido añadido satisfactoriamente a la Elección Junta',
                    'data' => $eleccion_junta_candidato
                ]);
            }

            if($eleccion_junta_candidato)
            {
                return response()->json([
                    'ok' => 0,
                    'mensaje' => 'El Candidato ya es encuentra registrado cen la Elección Junta',
                    'data' => $eleccion_junta_candidato
                ]);
            }
        } catch (Exception $ex) {
            return response()->json([
                'ok' => $ex->getCode(),
                'mensaje' => $ex->getMessage(),
                'data' => null
            ]);
        }
    }

    public function eliminarCandidato(Request $request)
    {
        try {
            $eleccion_junta_candidato  = EleccionJuntaCandidato::where('elecciona_junta_id', $request->id)
                                            ->where('ministro_id',$request->ministro)
                                            ->first()
            ;
            if($eleccion_junta_candidato)
            {
                $maxNumero = EleccionJuntaCandidato::where('elecciona_junta_id', $request->id)->max('numero_documento');
                $numero_candidato = $eleccion_junta_candidato->numero_candidato;
                $eleccion_junta_candidato->delete();
                if($eleccion_junta_candidato->numero_candidato < $maxNumero)
                {


                    $actualizas = EleccionJuntaCandidato::where('elecciona_junta_id', $request->id)
                            ->where('numero_documento',$numero_candidato+1)
                            ->orderBy('numero_documento','asc')
                            ->get();


                    foreach($actualizas as $actualiza)
                    {
                        $actualiza->numero_documento = $numero_candidato;
                        $actualiza->save();
                        $numero_candidato+=1;
                    }

                }
                return response()->json([
                    'ok' => 1,
                    'mensaje' => 'El Candidato ha sido eliminado de la Elección Junta',
                    'data' => $eleccion_junta_candidato
                ]);
            }
        } catch (Exception $ex) {
            return response()->json([
                'ok' => $ex->getCode(),
                'mensaje' => $ex->getMessage(),
                'data' => null
            ]);
        }
    }
}
