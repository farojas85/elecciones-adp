<?php

use App\Http\Controllers\Api\EleccionJuntaCandidatoController;
use App\Http\Controllers\Api\EleccionJuntaController;
use App\Http\Controllers\Api\MinistroController;
use App\Http\Controllers\Api\PeriodoJuntaCandidatoController;
use App\Http\Controllers\Api\PeriodoJuntaController;
use App\Http\Controllers\Api\VueltaProcesoController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum']],function(){
    //GRADOS MINISTERIALES
    Route::get('periodo-juntas-activos',[PeriodoJuntaController::class,'activos']);
    Route::get('periodo-juntas-inactivos',[PeriodoJuntaController::class,'inactivos']);
    Route::get('periodo-juntas-todos',[PeriodoJuntaController::class,'todos']);
    Route::get('periodo-juntas-mostrar',[PeriodoJuntaController::class,'show']);
    Route::get('periodo-juntas-listar',[PeriodoJuntaController::class,'listar']);
    Route::post('periodo-juntas-actualizar',[PeriodoJuntaController::class,'update']);
    Route::post('periodo-juntas-inhabilitar',[PeriodoJuntaController::class,'inhabilitar']);
    Route::post('periodo-juntas-habilitar',[PeriodoJuntaController::class,'habilitar']);
    Route::get('periodo-juntas-ministros',[PeriodoJuntaController::class,'buscarMinistro']);
    Route::post('periodo-juntas-agregar-candidato',[PeriodoJuntaController::class,'agregarCandidato']);
    Route::post('periodo-juntas-eliminar-candidato',[PeriodoJuntaController::class,'eliminarCandidato']);

    //MINISTROS
    Route::get('ministros-activos',[MinistroController::class,'activos']);
    Route::get('ministros-inactivos',[MinistroController::class,'inactivos']);
    Route::get('ministros-todos',[MinistroController::class,'todos']);
    Route::get('ministros-mostrar',[MinistroController::class,'show']);
    Route::get('ministros-listar',[MinistroController::class,'listar']);
    Route::post('ministros-actualizar',[MinistroController::class,'update']);
    Route::post('ministros-inhabilitar',[MinistroController::class,'inhabilitar']);
    Route::post('ministros-habilitar',[MinistroController::class,'habilitar']);
    Route::get('ministros-buscar',[MinistroController::class,'buscarMinistro']);

    //ELECCIÓN JUNTAS
    Route::get('eleccion-juntas-activos',[EleccionJuntaController::class,'activos']);
    Route::get('eleccion-juntas-inactivos',[EleccionJuntaController::class,'inactivos']);
    Route::get('eleccion-juntas-todos',[EleccionJuntaController::class,'todos']);
    Route::get('eleccion-juntas-mostrar',[EleccionJuntaController::class,'show']);
    Route::get('eleccion-juntas-listar',[EleccionJuntaController::class,'listar']);
    Route::post('eleccion-juntas-actualizar',[EleccionJuntaController::class,'update']);
    Route::post('eleccion-juntas-inhabilitar',[EleccionJuntaController::class,'inhabilitar']);
    Route::post('eleccion-juntas-habilitar',[EleccionJuntaController::class,'habilitar']);
    Route::post('eleccion-juntas-agregar-cargo-directivo',[EleccionJuntaController::class,'agregarCargoDirectivo']);
    Route::post('eleccion-juntas-eliminar-cargo-directivo',[EleccionJuntaController::class,'eliminarCargoDirectivo']);
    Route::post('eleccion-juntas-agregar-candidato',[EleccionJuntaController::class,'agregarCandidato']);
    Route::post('eleccion-justas-eliminar-candidato',[EleccionJuntaController::class,'eliminarCandidato']);
    Route::get('eleccion-juntas-candidatos',[EleccionJuntaCandidatoController::class,'obtenerCandidatosJunta']);
    Route::get('eleccion-juntas-actual-elejidos',[EleccionJuntaController::class,'obtenerEleccionJuntaActual']);

    //VUELTA PROCESOS
    Route::get('vuelta-procesos-activos',[VueltaProcesoController::class,'activos']);
    Route::get('vuelta-procesos-inactivos',[VueltaProcesoController::class,'inactivos']);
    Route::get('vuelta-procesos-todos',[VueltaProcesoController::class,'todos']);
    Route::get('vuelta-procesos-mostrar',[VueltaProcesoController::class,'show']);
    Route::get('vuelta-procesos-listar',[VueltaProcesoController::class,'listar']);
    Route::post('vuelta-procesos-actualizar',[VueltaProcesoController::class,'update']);
    Route::post('vuelta-procesos-inhabilitar',[VueltaProcesoController::class,'inhabilitar']);
    Route::post('vuelta-procesos-habilitar',[VueltaProcesoController::class,'habilitar']);
});
