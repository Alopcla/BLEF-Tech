<?php

/** Archivo especifico para las rutas de APIS.
 * Este archivo no se crea de forma predeterminada,
 * por lo que para crearlo se necesita el comando 'php artisan install:api'
 */

use App\Http\Controllers\Api\AnimalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ExperienceApiController;
use App\Http\Controllers\Api\OrdersApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Ruta para obtener todos los animales con su ecosistema y zona
Route::get('/animales', [AnimalController::class, 'index']);

Route::get('/products', [ProductController::class, 'index']);

Route::get('/products/{id}', [ProductController::class, 'show']);

Route::post('/shop/checkout', [ProductController::class, 'checkout']);

// Rutas 
Route::get('/experiencias',          [ExperienceApiController::class, 'index']);
Route::get('/experiencias/tickets',  [ExperienceApiController::class, 'misTickets']);
Route::post('/experiencias/checkout',[ExperienceApiController::class, 'checkout']);


Route::get('/tickets-by-email', function (Request $request) {

    $tickets = \App\Models\Ticket::where('email', $request->query('email'))
        ->where('status', 'paid')
        ->whereDate('visit_day', '>=', now()->toDateString())
        ->get()
        ->map(fn($t) => [
            'id' => $t->id,
            'cod_ticket' => $t->cod_ticket,
            'visit_day' => $t->visit_day->format('Y-m-d'),
            'visit_day_formatted' => $t->visit_day->format('d/m/Y'),
        ]);

    return response()->json(['tickets' => $tickets]);
});


//Ruta para trabajar el mapa
use App\Http\Controllers\Api\ZoneController;

Route::get('/zones/tipo/{type}', [ZoneController::class, 'getZoneInfo']);

// Ruta de compras
Route::get('/mis-compras', [OrdersApiController::class, 'index']);
