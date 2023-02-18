<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

    Route::group(['middleware' => 'auth:sanctum'], function() {
      Route::get('logout', [AuthController::class, 'logout']);
      Route::get('user', [AuthController::class, 'user']);
    });
});

Route::post('inventario/cargar-excel', [InventarioController::class, 'cargar_excel'])->name('inventario.cargar-excel');

Route::get('holamundo', function () {
    return 'Hola Mundo';
});