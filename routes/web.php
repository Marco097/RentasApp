<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\AutoController;
use App\Http\Controllers\AlquilerController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Route::resource('marcas', MarcaController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/admin',[HomeController::class,'dash'])->name('admin.dash')->middleware('auth.admin');
Route::resource('marcas', MarcaController::class)->middleware('auth.admin');
Route::resource('modelos', ModeloController::class)->middleware('auth.admin');
Route::resource('autos', AutoController::class)->middleware('auth.admin');
Route::get('/autos-reservas', [AutoController::class, 'index']);
Route::resource('alquileres', AlquilerController::class);
Route::put('/alquileres/change',[AlquilerController::class,'changeState']);
Route::get('/alquileres/state',[AlquilerController::class,'showByState']);
