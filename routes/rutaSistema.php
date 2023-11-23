<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TipoAccesoController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\MenuRoleController;
use App\Http\Controllers\Api\PermisoController;
use App\Http\Controllers\Api\PermisoRoleController;

Route::group(['middleware' > ['auth:sanctum']],function(){
    //USUARIOS
    Route::get('usuarios-habilitados',[UserController::class,'habilitados']);
    Route::get('usuarios-eliminados',[UserController::class,'eliminados']);
    Route::get('usuarios-todos',[UserController::class,'todos']);
    //TIPO ACCESOS
    Route::get('tipo-accesos-habilitados',[TipoAccesoController::class,'habilitados']);
    Route::get('tipo-accesos-eliminados',[TipoAccesoController::class,'eliminados']);
    Route::get('tipo-accesos-todos',[TipoAccesoController::class,'todos']);
    Route::get('tipo-accesos-mostrar',[TipoAccesoController::class,'show']);
    Route::get('tipo-accesos-listar',[TipoAccesoController::class,'listar']);
    Route::post('tipo-accesos-actualizar',[TipoAccesoController::class,'update']);
    Route::post('tipo-accesos-eliminar',[TipoAccesoController::class,'destroy']);
    Route::post('tipo-accesos-eliminar-permanente',[TipoAccesoController::class,'eliminarPermanente']);
    Route::post('tipo-accesos-restaurar',[TipoAccesoController::class,'restaurar']);
    //ROLES
    Route::get('roles-habilitados',[RoleController::class,'habilitados']);
    Route::get('roles-eliminados',[RoleController::class,'eliminados']);
    Route::get('roles-todos',[RoleController::class,'todos']);
    Route::get('roles-mostrar',[RoleController::class,'show']);
    Route::post('roles-actualizar',[RoleController::class,'update']);
    Route::post('roles-eliminar',[RoleController::class,'destroy']);
    Route::post('roles-eliminar-permanente',[RoleController::class,'eliminarPermanente']);
    Route::post('roles-restaurar',[RoleController::class,'restaurar']);
    Route::get('roles-listar',[RoleController::class,'listar']);
    //MENÚS
    Route::get('menus-padres',[MenuController::class,'obtenerPadres']);
    Route::get('menus-habilitados',[MenuController::class,'habilitados']);
    Route::get('menus-eliminados',[MenuController::class,'eliminados']);
    Route::get('menus-todos',[MenuController::class,'todos']);
    Route::get('menus-mostrar',[MenuController::class,'show']);
    Route::post('menus-actualizar',[MenuController::class,'update']);
    Route::post('menus-eliminar',[MenuController::class,'destroy']);
    Route::get('menus-verificar-enrol',[MenuController::class,'verificarEnRol']);
    Route::post('menus-eliminar-permanente',[MenuController::class,'eliminarPermanente']);
    Route::post('menus-restaurar',[MenuController::class,'restaurar']);

    //MENUS-ROLES
    Route::get('obtener-menus',[MenuRoleController::class,'obtenerMenus']);
    Route::get('menu-roles',[MenuRoleController::class,'obtenerMenuRoles']);
    Route::post('menu-role-guardar',[MenuRoleController::class,'guardarMenuRole']);

    //PERMISOS
    Route::get('permisos-habilitados',[PermisoController::class,'habilitados']);
    Route::get('permisos-eliminados',[PermisoController::class,'eliminados']);
    Route::get('permisos-todos',[PermisoController::class,'todos']);
    Route::get('permisos-listar',[PermisoController::class,'listar']);
    Route::get('permisos-mostrar',[PermisoController::class,'show']);
    Route::post('permisos-actualizar',[PermisoController::class,'update']);
    Route::post('permisos-eliminar',[PermisoController::class,'destroy']);
    Route::post('permisos-eliminar-permanente',[PermisoController::class,'eliminarPermanente']);
    Route::post('permisos-restaurar',[PermisoController::class,'restaurar']);

    //PERMISOS_ROLE
    Route::get('mostrar-modelos',[PermisoRoleController::class,'mostrarModelos']);
    Route::get('permiso-roles',[PermisoRoleController::class,'mostrarRolePermisos']);
    Route::get('mostrar-permisos-modelo',[PermisoRoleController::class, 'mostrarPermisos']);
    Route::post('permiso-role-guardar',[PermisoRoleController::class, 'guardarRolePermission']);
});
