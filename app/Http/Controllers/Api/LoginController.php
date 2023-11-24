<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $request->validated();

        $credenciales = [
            'name' => $request->name, 'password' => $request->password,
            'es_activo' => 1
        ];

        $user = User::where('name',$request->name)->first();

        if($user)
        {
            if(Hash::check($request->password,$user->password))
            {
                if(Auth::attempt($credenciales))
                {
                    $usuario = User::with(['persona:id,nombres,apellido_paterno,apellido_materno','roles'])
                                    ->where('id',$user->id)->first();

                    $success['token'] = $usuario->createToken('token-api')->plainTextToken;
                    $success['user'] = $usuario;
                    $success['user']['roles'] = $user->roles;

                    $permiso = [];
                    $menu = [];

                    if($usuario->roles->count()==0){
                        return response()->json([
                            'errors' => ['name' => 'No tiene rol(es) asignado(s)']
                        ],422);
                    }
                    foreach($usuario->roles as $role)
                    {
                        // $permisos = $usuario->obtenerPermisos($role->id)->toArray();
                        // array_merge($permisos,$permiso);
                        $menus = $role->obtenerMenus($role->id)->toArray();
                        array_merge($menus,$menu);
                    }

                    //$success['user']['permisos'] = $permisos;
                    $success['user']['menus'] = $menus;

                    return response()->json($success,200);
                }
                else {
                    return response()->json([
                        'errors' => ['name' => 'Usuario Suspendido']
                    ],422);
                }
            }
            else {
                return response()->json([
                    'errors' => ['password' => 'Contraseña Incorrecta']
                ],422);
            }
        }
        else {
            return response([
                'errors' => [ 'name' => 'Usuario no registrado']
            ], 422);
        }

    }

    public function logout(Request $request)
    {
        $personal_access_tokens = DB::table('personal_access_tokens')
                ->where('tokenable_id',$request->id)
                ->delete();
        // Auth::user()->tokens->each(function($token,$key){
        //     $token->delete()  ;
        // });

        return response()->json([
            'ok' => 1,
            'mensaje' =>'Sessión cerrada Satisfactoriamiente'
        ], 200);
    }
}
