<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocioController;

Route::get('/socios', [SocioController::class, 'index']);
Route::post('/socios', [SocioController::class, 'insertar']);
