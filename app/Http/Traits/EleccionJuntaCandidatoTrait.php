<?php
namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\EleccionJunta;
use App\Models\EleccionJuntaCandidato;

trait EleccionJuntaCandidatoTrait
{
    public function obtenerCandidatosJunta(Request $request)
    {

        return EleccionJuntaCandidato::join('ministros as mini','mini.id' ,'=','eleccion_junta_candidatos.ministro_id')
                ->join('personas as per','per.id','=','mini.persona_id')
                ->select(
                    'eleccion_junta_candidatos.id',
                    'eleccion_junta_candidatos.ministro_id',
                    DB::Raw("concat(upper(per.apellido_paterno),' ',upper(per.apellido_materno),', ',upper(per.nombres)) as candidato"),
                    'eleccion_junta_candidatos.numero_candidato'
                )
                ->where('eleccion_junta_id',$request->id)
                ->orderBy('eleccion_junta_candidatos.numero_candidato','asc')
                ->get()
        ;
    }
}
