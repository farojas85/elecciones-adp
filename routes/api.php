<?php

use App\Http\Controllers\Api\AmbitoJuntaController;
use App\Http\Controllers\Api\CargoDirectivoController;
use App\Http\Controllers\Api\EleccionJuntaController;
use App\Http\Controllers\Api\GradoMinisterialController;
use App\Http\Controllers\Api\JuntaDirectivaController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\MinistroController;
use App\Http\Controllers\Api\PeriodoJuntaController;
use App\Http\Controllers\Api\PermisoController;
use App\Http\Controllers\Api\ProcesoElectoralController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\SexoController;
use App\Http\Controllers\Api\TipoAccesoController;
use App\Http\Controllers\Api\TipoDocumentoController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VueltaProcesoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login',[LoginController::class,'login']);

Route::group(['middleware' => ['auth:sanctum']],function(){

    Route::post('logout',[LoginController::class,'logout']);
    Route::apiResource('usuarios', UserController::class);
    Route::apiResource('tipo-accesos',TipoAccesoController::class);
    Route::apiResource('roles',RoleController::class);
    Route::apiResource('menus',MenuController::class);
    Route::apiResource('permisos',PermisoController::class);
    Route::apiResource('tipo-documentos',TipoDocumentoController::class);
    Route::apiResource('sexos',SexoController::class);
    Route::apiResource('grado-ministeriales',GradoMinisterialController::class);
    Route::apiResource('ambito-juntas',AmbitoJuntaController::class);
    Route::apiResource('junta-directivas',JuntaDirectivaController::class);
    Route::apiResource('cargo-directivos',CargoDirectivoController::class);
    Route::apiResource('periodo-juntas', PeriodoJuntaController::class);
    Route::apiResource('ministros',MinistroController::class);
    Route::apiResource('eleccion-juntas',EleccionJuntaController::class);
    Route::apiResource('vuelta-procesos',VueltaProcesoController::class);
    Route::apiResource('proceso-electorales',ProcesoElectoralController::class);
    // Route::apiResource('eleccion-live',ProcesoElectoralController::class);

    require __DIR__.'/rutaSistema.php';
    require __DIR__.'/rutaConfiguracion.php';
    require __DIR__.'/rutaEleccion.php';
    require __DIR__.'/rutaProceso.php';
});

Route::get('hola',function(){
    return "Hola";
});
