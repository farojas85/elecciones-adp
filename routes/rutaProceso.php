<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ProcesoElectoralController;

Route::group(['middleware' => ['auth:sanctum']],function(){
    //ELECCIONES LIVE
    // Route::get('eleccion-live-eleccion-junta-listar',[ProcesoElectoralController::class,'obtenerPeriodoElectoralesActivos']);
    // Route::get('periodo-juntas-inactivos',[ProcesoElectoralController::class,'inactivos']);
    // Route::get('periodo-juntas-todos',[ProcesoElectoralController::class,'todos']);
    // Route::get('periodo-juntas-mostrar',[ProcesoElectoralController::class,'show']);
    // Route::get('periodo-juntas-listar',[ProcesoElectoralController::class,'listar']);
    // Route::post('periodo-juntas-actualizar',[ProcesoElectoralController::class,'update']);
    // Route::post('periodo-juntas-inhabilitar',[ProcesoElectoralController::class,'inhabilitar']);
    // Route::post('periodo-juntas-habilitar',[ProcesoElectoralController::class,'habilitar']);
    // Route::get('periodo-juntas-ministros',[ProcesoElectoralController::class,'buscarMinistro']);
    // Route::post('periodo-juntas-agregar-candidato',[ProcesoElectoralController::class,'agregarCandidato']);
    // Route::post('periodo-juntas-eliminar-candidato',[ProcesoElectoralController::class,'eliminarCandidato']);

    //PROCESOS ELECTORALES
    Route::get('proceso-electorales-datos-iniciales',[ProcesoElectoralController::class,'obtenerDatosIniciales']);
    Route::get('proceso-electorales-todos',[ProcesoElectoralController::class,'todos']);
    Route::get('proceso-electorales-mostrar',[ProcesoElectoralController::class,'show']);
    Route::post('proceso-electorales-actualizar',[ProcesoElectoralController::class,'update']);
    Route::get('proceso-electorales-activo',[ProcesoElectoralController::class,'obtenerProcesoElectoralActivo']);
    Route::post('proceso-electorales-inhabilitar',[ProcesoElectoralController::class,'inhabilitar']);
    Route::post('proceso-electorales-habilitar',[ProcesoElectoralController::class,'habilitar']);
    Route::post('proceso-electorales-registrar-candidato-proceso',[ProcesoElectoralController::class,'registrarCandidatosEnProceso']);
    Route::get('proceso-electorales-votacion-en-proceso',[ProcesoElectoralController::class,'votacionEnProceso']);
    Route::post('proceso-electorales-registro-votacion',[ProcesoElectoralController::class,'registrarVotacion']);
    Route::post('proceso-electorales-siguiente-votacion',[ProcesoElectoralController::class,'pasarSiguienteVotacion']);

    // Route::post('proceso-electorales-store',[ProcesoElectoralController::class,'store']);
});
