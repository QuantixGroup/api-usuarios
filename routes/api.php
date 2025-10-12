<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SocioController;
use App\Http\Controllers\AuthController;



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

Route::post('/iniciar-sesion', [AuthController::class, 'login']);

Route::post('/socios', [SocioController::class, 'insertar']);

Route::middleware('auth:api')->group(function () {

    Route::get('/socios', [SocioController::class, 'index']);
    Route::get('/socios/{id}', [SocioController::class, 'mostrar']);
    Route::put('/socios/{id}', [SocioController::class, 'actualizar']);
    Route::delete('/socios/{id}', [SocioController::class, 'eliminar']);

    Route::post('/cerrar-sesion', [AuthController::class, 'logout']);

    Route::get('/perfil', [UserController::class, 'verMiPerfil']);
    Route::put('/perfil', [UserController::class, 'actualizarMiPerfil']);
    Route::put('/perfil/contrasena', [UserController::class, 'cambiarMiContrasena']);
    Route::delete('/perfil', [UserController::class, 'eliminarMiCuenta']);



});

Route::get('/validate', [UserController::class, "ValidateToken"]);



