<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CitasController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ServiciosController;
use App\Http\Middleware\TokenVerify;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Rutas para los controladores
Route::post('Registro',[AuthController::class,'registrar']);
Route::post('Autenticar',[AuthController::class,'autenticar']);
Route::get('Servicios',[ServiciosController::class,'all']);
Route::get('Productos',[ProductosController::class,'all']);

//Rutas protegidas
Route::middleware([TokenVerify::class])->group(function () {
    Route::get('/Users', function(){
        $users = User::all();
        return response()->json([
            'usuarios' => $users
        ]);
    });
    Route::get('Citas',[CitasController::class,'all']); //Admin
    Route::get('Cita',[CitasController::class,'citas']);

    Route::post('NewServicio',[ServiciosController::class,'store']);
    Route::post('NewProducto',[ProductosController::class,'store']);
    
});
