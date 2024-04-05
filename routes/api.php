<?php

use App\Http\Controllers\API\PacienteController;
use App\Http\Controllers\AutenticarController;
use App\Http\Resources\PacienteResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/* Route::get('pacientes',[PacienteController::class,'index']);
Route::get('pacientes/{paciente}',[PacienteController::class,'show']);
Route::post('pacientes',[PacienteController::class,'store']);
Route::put('pacientes/{paciente}',[PacienteController::class,'update']);
Route::delete('pacientes/{paciente}',[PacienteController::class,'destroy']); */
 
Route::post('registro',[AutenticarController::class, 'registro']);
Route::post('login',[AutenticarController::class, 'acceso']);

Route::group(['middleware' => ['auth:sanctum']], function (){
    Route::post('logout',[AutenticarController::class, 'cerrarSesion']);
    Route::apiResource('pacientes', PacienteController::class);
});
