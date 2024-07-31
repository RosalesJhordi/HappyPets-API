<?php

use App\Http\Controllers\AuthController;
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

Route::middleware([TokenVerify::class])->group(function () {
    Route::get('/Users', function(){
        $users = User::all();
        return response()->json([
            'usuarios' => $users
        ]);
    });
    // Otras rutas protegidas
});
