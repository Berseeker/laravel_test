<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\Auth\VerifyMailController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Auth\LoginController;

use App\Http\Controllers\API\Empleados\EmpleadoController;
use App\Http\Controllers\API\Empresas\EmpresaController;


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

Route::post('login',[LoginController::class,'index']);
Route::post('register',[RegisterController::class,'store']);
Route::post('verify-mail',[VerifyMailController::class,'index']);


//verified.email
Route::middleware(['auth:sanctum'])->group(function (){

    Route::middleware(['isAdmin'])->group(function()
    {
        // RUTAS PARA EL ROL DE ADMIN
        Route::get('/empresas',[EmpresaController::class,'index']);
        Route::get('/empresa/{id}',[EmpresaController::class,'show']);
        Route::post('/empresa',[EmpresaController::class,'store']);
        Route::post('/empresa/{id}',[EmpresaController::class,'update']);
        Route::delete('/empresa',[EmpresaController::class,'delete']);

        Route::get('/empleados',[EmpleadoController::class,'index']);
        Route::get('/empleados/{id}',[EmpleadoController::class,'byCompany']);
        Route::post('/empleado',[EmpleadoController::class,'store']);
        Route::post('/empleado/{id}',[EmpleadoController::class,'update']);
        Route::delete('/empleado/{id}',[EmpleadoController::class,'delete']);


    });


    Route::get('logout',[LoginController::class,'logout']);

});
