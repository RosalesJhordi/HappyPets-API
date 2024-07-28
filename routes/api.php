<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Rutas para los controladores
Route::post('Registro',[AuthController::class,'registrar']);
Route::post('Autenticar',[AuthController::class,'autenticar']);
