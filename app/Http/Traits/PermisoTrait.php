<?php
namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Permiso;


trait PermisoTrait{
    public function habilitados(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Permiso::where(function($query) use($buscar) {
            $query->where(DB::Raw("upper(nombre)"),'like','%'.$buscar.'%')
            ->orWhere(DB::Raw("upper(slug)"),'like','%'.$buscar.'%');
        })->paginate($paginacion)
        ;
    }
    public function eliminados(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Permiso::where(function($query) use($buscar) {
            $query->where(DB::Raw("upper(nombre)"),'like','%'.$buscar.'%')
            ->orWhere(DB::Raw("upper(slug)"),'like','%'.$buscar.'%');
        })->onlyTrashed()
        ->paginate($paginacion)
        ;
    }
    public function todos(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Permiso::where(function($query) use($buscar) {
            $query->where(DB::Raw("upper(nombre)"),'like','%'.$buscar.'%')
            ->orWhere(DB::Raw("upper(slug)"),'like','%'.$buscar.'%');
        })->withTrashed()
        ->paginate($paginacion)
        ;
    }


    public function validarUpdate(Request $request)
    {
        $regla =  [
            'nombre'     => 'required|max:25',
            'slug'       => 'required|max:25'
        ];

        $mensaje  = [
            'required'  => '* Dato Obligatorio',
            'max'       => '* Ingrese Máximo :max caracteres',
            'string'    => '* Ingrese caracteres alfanuméricos',
            'number'    => '* Ingrese solo numeros'
        ];

        return $request->validate($regla);

    }

}
