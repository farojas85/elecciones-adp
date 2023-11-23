<?php
namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\TipoDocumento;
use Peru\Jne\DniFactory;

trait UsuarioTrait
{
    public function habilitados(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;

        return User::with('persona:id,numero_documento,apellido_paterno,apellido_materno,nombres')
        ->where(function($query) use($buscar) {
            $query->where(DB::Raw("upper(name)"),'like','%'.$buscar.'%')
                ->orWhere(DB::Raw("upper(email)"),'like','%'.$buscar.'%')
                ->orWhereHas('persona',function($q) use($buscar){
                    $q->where(DB::Raw('upper(numero_documento)'),'like','%'.$buscar.'%')
                    ->orWhere(DB::Raw("upper(concat(apellido_paterno,' ',apellido_materno))")
                                ,'like','%'.$buscar.'%')
                    ->orWhere(DB::Raw("upper(nombres)")
                                ,'like','%'.$buscar.'%');
                });
        })->paginate($paginacion)
        ;
    }

    public function eliminados(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;

        return User::with('persona:id,numero_documento,apellido_paterno,apellido_materno,nombres')
        ->where(function($query) use($buscar) {
            $query->where(DB::Raw("upper(name)"),'like','%'.$buscar.'%')
                ->orWhere(DB::Raw("upper(email)"),'like','%'.$buscar.'%')
                ->orWhereHas('persona',function($q) use($buscar){
                    $q->where(DB::Raw('upper(numero_documento)'),'like','%'.$buscar.'%')
                    ->orWhere(DB::Raw("upper(concat(apellido_paterno,' ',apellido_materno))")
                                ,'like','%'.$buscar.'%')
                    ->orWhere(DB::Raw("upper(nombres)")
                                ,'like','%'.$buscar.'%');
                });
        })
        ->onlyTrashed()
        ->paginate($paginacion)
        ;
    }
    public function todos(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;

        return User::with('persona:id,numero_documento,apellido_paterno,apellido_materno,nombres')
        ->where(function($query) use($buscar) {
            $query->where(DB::Raw("upper(name)"),'like','%'.$buscar.'%')
                ->orWhere(DB::Raw("upper(email)"),'like','%'.$buscar.'%')
                ->orWhereHas('persona',function($q) use($buscar){
                    $q->where(DB::Raw('upper(numero_documento)'),'like','%'.$buscar.'%')
                    ->orWhere(DB::Raw("upper(concat(apellido_paterno,' ',apellido_materno))")
                                ,'like','%'.$buscar.'%')
                    ->orWhere(DB::Raw("upper(nombres)")
                                ,'like','%'.$buscar.'%');
                });
        })
        ->withTrashed()
        ->paginate($paginacion)
        ;
    }
}
