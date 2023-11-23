<?php
namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Permiso;


trait PermisoFacadeTrait
{
    public function obtenerPermisos($roles)
    {
        return Permiso::join('permiso_role as pr','permisos.id','=','pr.permiso_id')
                        ->select('permisos.id','permisos.nombre','permisos.slug')
                        ->where('pr.role_id',$roles)->get();
    }

    public function asignarPermisos($permisos)
    {
        if(is_array($permisos))
        {
            $this->permisos()->sync($permisos);
        } else{
            if(count($this->permisos) == 0){
                $this->permisos()->attach($permisos);
            } else {
                foreach($this->permisos as $permiso)
                {
                    if($permiso->id != $permisos)
                    {
                        $this->permisos()->attach($permisos);
                    }
                }
            }
        }
    }
}

