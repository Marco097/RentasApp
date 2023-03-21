<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\AutoController;
use App\Http\Controllers\AlquilerController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::resource('marcas', MarcaController::class);
Route::resource('autos', AutoController::class);
Route::resource('modelos', ModeloController::class);
Route::resource('alquileres', AlquilerController::class);
Route::put('/alquileres/change',[AlquilerController::class,'changeState']);

