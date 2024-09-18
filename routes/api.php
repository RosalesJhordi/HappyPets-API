<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CitaNotificaciones;
use App\Http\Controllers\CitasController;
use App\Http\Controllers\ComprasController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ServiciosController;
use App\Http\Middleware\TokenVerify;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// EndPoint para registrar usuarios (dni,tel,pwd)
Route::post('Registro',[AuthController::class,'registrar']);

// EndPoint para autenticar usuarios (dni,pwd)
Route::post('Autenticar',[AuthController::class,'autenticar']);

// EndPoint para mostrar servicios
Route::get('MostrarServicios',[ServiciosController::class,'all']);

// EndPoint para mostrar productos
Route::get('MostrarProductos',[ProductosController::class,'all']);

//Filtrar servicio por categoria 
Route::post('FiltrarServicio',[ServiciosController::class,'filtro']);

//Rutas protegidas
Route::middleware([TokenVerify::class])->group(function () {

    // EndPoint Reservar cita (fecha,hora,id_cliente,id_servicio,nm_mascota,estado,observaciones)
    Route::post('ReservarCita',[CitasController::class,'store']);

    // EndPoint para cancelar cita (id_cita)
    Route::post('CancelarCita');

    // EndPoint para mostrar citas - admin
    Route::get('AllCitas',[CitasController::class,'all']);

    // EndPoint para mostrar citas de un usuario (id_cliente)
    Route::get('UserCita',[CitasController::class,'citas']);

    // EndPoint para realizar una compra (id_cliente,id_producto,cantidad)
    Route::post('NewCompra',[ComprasController::class,'store']);

    // EndPoint para mostrar las compras de un cliente (id_cliente)
    Route::post('UserCompra',[ComprasController::class,'compra']);

    // EndPoint para cancelar compra (id_compra)
    Route::post('DelCompra',[ComprasController::class,'delcompra']);

    // EndPoint para agregar productos (nmproducto,descripcion,categoria,precio,stock,imagen)
    Route::post('AddProducto',[ProductosController::class,'store']);

    // EndPoint para mostrar todos loss productos
    Route::get('AllProducto',[ProductosController::class,'all']);
    
    // EndPoint para eliminar producto
    Route::post('DelProducto',[ProductosController::class,'delete']);

    // EndPoint para editar producto (id_producto, datos producto)
    Route::post('EditProducto',[ProductosController::class,'edit']);

    // EndPoint para agregar servicios (nmbservicio,duracion_aprox,descripcion,precio,imagen)
    Route::post('NewServicio',[ServiciosController::class,'store']);

    // EndPoint para mostrar todos los servicios
    Route::get('AllServicio',[ServiciosController::class,'all']);

    // EndPoint para obtener datos de usuario con token
    Route::get('DatosUsuario',[AuthController::class,'datos']);

    Route::get('Notificaciones/{id}',CitaNotificaciones::class);

    Route::get('ShowServicio/{id}',[ServiciosController::class,'show']);
});
