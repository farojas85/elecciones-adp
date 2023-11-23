<?php

namespace App\Http\Traits;
use App\Models\User;

trait HelperTrait
{
    public function rolUsuario(int $usuario): string
    {
        $user = User::with('roles')->where('id',$usuario)->first();
        $rol = "";
        foreach($user->roles as $role)
        {
            $rol = $role->slug;
            break;
        }
        return $rol;
    }
}
