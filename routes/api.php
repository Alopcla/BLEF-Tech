<?php

/** Archivo especifico para las rutas de APIS.
 * Este archivo no se crea de forma predeterminada,
 * por lo que para crearlo se necesita el comando 'php artisan install:api'
 */

use App\Http\Controllers\Api\AnimalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Ruta para obtener todos los animales con su ecosistema y zona
Route::get('/animales', [AnimalController::class, 'index']);

Route::get('/products', [ProductController::class, 'index']);
