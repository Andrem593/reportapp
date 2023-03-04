<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\TiendasController;
use App\Http\Controllers\InventarioController;

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

Route::group(['prefix' => 'auth'], function () {
  Route::post('login', [AuthController::class, 'login']);
  Route::post('register', [AuthController::class, 'register']);

  Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
  });
});

Route::group(['middleware' => 'auth:sanctum'], function () {
  //Rutas con TiendasController
  Route::apiResource('tienda', 'TiendasController');
  Route::get('tienda-ciudades', [TiendasController::class, 'get_ciudades']);

  Route::post('inventario/carga', [InventarioController::class, 'carga_data']);  
  Route::get('get-inventario', [InventarioController::class, 'get_inventario']);  

  //Rutas con VentaController
  Route::get('get-punto-operacion', [VentaController::class, 'get_punto_operacion']);
  Route::post('venta/carga', [VentaController::class, 'carga_data']); 
  Route::post('venta/reporte-ventas-marca', [VentaController::class, 'get_reporte_ventas_marca']);
  Route::post('venta/reporte-ventas-operacion', [VentaController::class, 'get_reporte_ventas_operacion']);
  Route::post('venta/reporte-ventas-clasificacion', [VentaController::class, 'get_reporte_ventas_clasificacion']);
});

Route::post('inventario/cargar-excel', [InventarioController::class, 'cargar_excel'])->name('inventario.cargar-excel');