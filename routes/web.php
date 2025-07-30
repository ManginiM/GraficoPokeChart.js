<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\PosteoController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\PaginaController;


Route::middleware(['auth'])->group(function () {
    Route::post('/posteo', [PosteoController::class, 'store'])->name('posteo.store');
    Route::post('/comentario', [ComentarioController::class, 'store'])->name('comentario.store');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('login');  // si tu vista se llama login.blade.php
});
Route::get('/pagina/{id}', [PaginaController::class, 'mostrar'])->name('pagina.mostrar');

Route::get('/pagina/{id}', [PaginaController::class, 'mostrar']);


Route::get('/pokemon', function () {
    return view('pokemon');
});
