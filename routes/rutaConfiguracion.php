<?php

use App\Http\Controllers\Api\AmbitoJuntaController;
use App\Http\Controllers\Api\ApiGradoMinisterialController;
use App\Http\Controllers\Api\CargoDirectivoController;
use App\Http\Controllers\Api\GradoMinisterialController;
use App\Http\Controllers\Api\JuntaDirectivaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TipoDocumentoController;
use App\Http\Controllers\Api\SexoController;

Route::group(['middleware' => ['auth:sanctum']],function(){
    //TIPO DOCUMENTOS
    Route::get('tipo-documentos-habilitados',[TipoDocumentoController::class,'habilitados']);
    Route::get('tipo-documentos-eliminados',[TipoDocumentoController::class,'eliminados']);
    Route::get('tipo-documentos-todos',[TipoDocumentoController::class,'todos']);
    Route::get('tipo-documentos-mostrar',[TipoDocumentoController::class,'show']);
    Route::get('tipo-documentos-listar',[TipoDocumentoController::class,'listar']);
    Route::post('tipo-documentos-actualizar',[TipoDocumentoController::class,'update']);
    Route::post('tipo-documentos-eliminar',[TipoDocumentoController::class,'destroy']);
    Route::post('tipo-documentos-eliminar-permanente',[TipoDocumentoController::class,'eliminarPermanente']);
    Route::post('tipo-documentos-restaurar',[TipoDocumentoController::class,'restaurar']);

    //SEXOS
    Route::get('sexos-habilitados',[SexoController::class,'habilitados']);
    Route::get('sexos-eliminados',[SexoController::class,'eliminados']);
    Route::get('sexos-todos',[SexoController::class,'todos']);
    Route::get('sexos-mostrar',[SexoController::class,'show']);
    Route::get('sexos-listar',[SexoController::class,'listar']);
    Route::post('sexos-actualizar',[SexoController::class,'update']);
    Route::post('sexos-eliminar',[SexoController::class,'destroy']);
    Route::post('sexos-eliminar-permanente',[SexoController::class,'eliminarPermanente']);
    Route::post('sexos-restaurar',[SexoController::class,'restaurar']);

    //GRADOS MINISTERIALES
    Route::get('grado-ministeriales-activos',[GradoMinisterialController::class,'activos']);
    Route::get('grado-ministeriales-inactivos',[GradoMinisterialController::class,'inactivos']);
    Route::get('grado-ministeriales-todos',[GradoMinisterialController::class,'todos']);
    Route::get('grado-ministeriales-mostrar',[GradoMinisterialController::class,'show']);
    Route::get('grado-ministeriales-listar',[GradoMinisterialController::class,'listar']);
    Route::post('grado-ministeriales-actualizar',[GradoMinisterialController::class,'update']);
    Route::post('grado-ministeriales-inhabilitar',[GradoMinisterialController::class,'inhabilitar']);
    Route::post('grado-ministeriales-habilitar',[GradoMinisterialController::class,'habilitar']);

    //ÁMBITO JUNTAS
    Route::get('ambito-juntas-activos',[AmbitoJuntaController::class,'activos']);
    Route::get('ambito-juntas-inactivos',[AmbitoJuntaController::class,'inactivos']);
    Route::get('ambito-juntas-todos',[AmbitoJuntaController::class,'todos']);
    Route::get('ambito-juntas-mostrar',[AmbitoJuntaController::class,'show']);
    Route::get('ambito-juntas-listar',[AmbitoJuntaController::class,'listar']);
    Route::post('ambito-juntas-actualizar',[AmbitoJuntaController::class,'update']);
    Route::post('ambito-juntas-inhabilitar',[AmbitoJuntaController::class,'inhabilitar']);
    Route::post('ambito-juntas-habilitar',[AmbitoJuntaController::class,'habilitar']);

    //CARGOS DIRECTIVOS
    Route::get('cargo-directivos-activos',[CargoDirectivoController::class,'activos']);
    Route::get('cargo-directivos-inactivos',[CargoDirectivoController::class,'inactivos']);
    Route::get('cargo-directivos-todos',[CargoDirectivoController::class,'todos']);
    Route::get('cargo-directivos-mostrar',[CargoDirectivoController::class,'show']);
    Route::get('cargo-directivos-listar',[CargoDirectivoController::class,'listar']);
    Route::post('cargo-directivos-actualizar',[CargoDirectivoController::class,'update']);
    Route::post('cargo-directivos-inhabilitar',[CargoDirectivoController::class,'inhabilitar']);
    Route::post('cargo-directivos-habilitar',[CargoDirectivoController::class,'habilitar']);

    //JUNTAS DIRECTIVAS
    Route::get('junta-directivas-activos',[JuntaDirectivaController::class,'activos']);
    Route::get('junta-directivas-inactivos',[JuntaDirectivaController::class,'inactivos']);
    Route::get('junta-directivas-todos',[JuntaDirectivaController::class,'todos']);
    Route::get('junta-directivas-mostrar',[JuntaDirectivaController::class,'show']);
    Route::get('junta-directivas-listar',[JuntaDirectivaController::class,'listar']);
    Route::post('junta-directivas-actualizar',[JuntaDirectivaController::class,'update']);
    Route::post('junta-directivas-inhabilitar',[JuntaDirectivaController::class,'inhabilitar']);
    Route::post('junta-directivas-habilitar',[JuntaDirectivaController::class,'habilitar']);
});
