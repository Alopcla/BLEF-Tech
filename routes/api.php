<?php

/** Archivo especifico para las rutas de APIS.
 * Este archivo no se crea de forma predeterminada,
 * por lo que para crearlo se necesita el comando 'php artisan install:api'
 */

use App\Http\Controllers\Api\AnimalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/animal-aleatorio', [AnimalController::class, 'getRandomAnimal']);
