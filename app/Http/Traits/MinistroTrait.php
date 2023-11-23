<?php
namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Ministro;
use App\Models\Persona;
use App\Models\TipoDocumento;
use Peru\Jne\DniFactory;
use Peru\Sunat\RucFactory;

trait MinistroTrait
{
    public function activos(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;

        return Ministro::with([
            'persona:id,numero_documento,apellido_paterno,apellido_materno,nombres',
            'grado_ministerial:id,nombre'
        ])
        ->where('ministros.es_activo',1)
        ->whereHas('persona',function($q) use($buscar){
            $q->where(DB::Raw("upper(concat(apellido_paterno,' ',apellido_materno))")
                        ,'like','%'.$buscar.'%')
            ->orWhere(DB::Raw("upper(nombres)")
                        ,'like','%'.$buscar.'%');
        })
        ->paginate($paginacion)
        ;
    }

    public function inactivos(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;

        return Ministro::with([
            'persona:id,numero_documento,apellido_paterno,apellido_materno,nombres',
            'grado_ministerial:id,nombre'
        ])
        ->where('es_activo',0)
        ->orWhereHas('persona',function($q) use($buscar){
            $q->where(DB::Raw('upper(numero_documento)'),'like','%'.$buscar.'%')
            ->orWhere(DB::Raw("upper(concat(apellido_paterno,' ',apellido_materno))")
                        ,'like','%'.$buscar.'%')
            ->orWhere(DB::Raw("upper(nombres)")
                        ,'like','%'.$buscar.'%');
        })
        ->paginate($paginacion)
        ;
    }
    public function todos(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;

        return Ministro::with([
            'persona:id,numero_documento,apellido_paterno,apellido_materno,nombres',
            'grado_ministerial:id,nombre'
        ])
        ->whereHas('persona',function($q) use($buscar){
            $q->where(DB::Raw('upper(numero_documento)'),'like','%'.$buscar.'%')
            ->orWhere(DB::Raw("upper(concat(apellido_paterno,' ',apellido_materno))")
                        ,'like','%'.$buscar.'%')
            ->orWhere(DB::Raw("upper(nombres)")
                        ,'like','%'.$buscar.'%');
        })
        ->paginate($paginacion)
        ;
    }

    public function buscarMinistro(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);

        return Ministro::join('personas as per','per.id','=','ministros.persona_id')
                    ->select(
                        'ministros.id',
                        DB::Raw("concat(upper(per.apellido_paterno),' ',upper(per.apellido_materno),', ',upper(per.nombres)) as apellidos_nombres")
                    )
                    ->where(function($query) use($buscar){
                        $query->where(DB::Raw("upper(per.numero_documento)"),'like',$buscar)
                            ->orWhere(DB::Raw("concat(upper(per.apellido_paterno),' ',upper(per.apellido_materno))"),'like',$buscar)
                            ->orWhere(DB::Raw("upper(per.nombres)"),'like',$buscar);

                    })
                    ->get();
    }

    public function verificarNumeroDocumento(Request $request)
    {
        //VALIDAMOS EL TIPO DE DOCUMENTO
        $regla = [ 'tipo_documento_id' => 'required'];
        $mensaje = [ 'required' => '* Dato Obligatorio'];

        $this->validate($request,$regla,$mensaje);

        //VALIDAMOS EL NUMERO DE DOCUMENTO POR LONGITUD
        $tipoDocumento = TipoDocumento::select('longitud')
                                    ->where('id',$request->tipo_documento_id)->first();
        $digitos =$tipoDocumento->longitud;

        $regla = [
            'tipo_documento_id' => 'required',
            'numero_documento' => 'digits:'.$digitos
        ];
        $mensaje = [ 'required' => '* Dato Obligatorio',
                    'digits' => 'Ingrese '.$digitos.' dígitos'];
        $this->validate($request,$regla,$mensaje);


        $persona = Persona::select(
            'tipo_documento_id','numero_documento', 'nombres', 'apellido_paterno',
            'apellido_materno', 'sexo_id', 'telefono', 'direccion'
        )->where('dni', $request->numero_documento)
        ->first();


        // if(!$persona)
        // {
        //     if($digitos == 8)
        //     {
        //         $factory = new DniFactory();
        //         $cs = $factory->create();

        //         $persona = $cs->get($request->numero_documento);

        //         if(!$persona) {
        //             return null;
        //         }
        //         if($persona)
        //         {
        //             $persona->tipo = 1;
        //         }
        //     }
        //     else if($digitos == 11) {

        //         $factory = new RucFactory();
        //         $cs = $factory->create();

        //         $persona = $cs->get($request->numero_documento);

        //         if(!$persona) {
        //             return null;
        //         }

        //         if($persona)
        //         {
        //             $persona->tipo = 2;
        //         }
        //     }
        // }

        if($persona)
        {
            $persona['tipo'] = 0;
        }


        return  json_encode($persona);
    }
}
