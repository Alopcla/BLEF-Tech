<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExperienciaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AlertController;

/** --- PÁGINA PRINCIPAL Y SECCIONES --- **/
Route::get('/', function () {
    return view('welcome');
});

Route::get('/animales', function () {
    return view('animales');
})->name('animales');

Route::get('/tienda', function () {
    return view('tienda');
})->name('tienda');

/** --- AUTENTICACIÓN Y GOOGLE --- **/
Route::get('/auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'callback'])->name('auth.google.callback');

require __DIR__ . '/auth.php';

/** --- DASHBOARD (Punto de entrada tras login) --- **/
Route::get('/dashboard', [EmployeeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/** --- GESTIÓN DE EMPLEADOS --- **/
Route::get('/empleados', [EmployeeController::class, 'index'])->name('employees.index');
// Nota: store suele ser POST para creación
Route::post('/registrar-nuevo-empleado', [EmployeeController::class, 'store'])->name('employees.store');
Route::get('/empleados/{dni}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
Route::delete('/empleados/{dni}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

/** --- PANELES ESPECÍFICOS --- **/
Route::get('/medico/dashboard', function () {
    return "Panel Médico";
})->name('medico.dashboard');
Route::get('/guia/dashboard', function () {
    return "Panel Guía";
})->name('guia.dashboard');
Route::get('/mantenimiento/dashboard', function () {
    return "Panel Mantenimiento";
})->name('mantenimiento.dashboard');
Route::get('/cuidador/dashboard', function () {
    return "Panel Cuidador";
})->name('cuidador.dashboard');

/** --- TICKETS Y PAGOS --- **/
Route::get('/pago', [PaymentController::class, 'showForm'])->name('payment.show');
Route::post('/pago', [PaymentController::class, 'processPayment'])->name('payment.process');
Route::get('/check-availability', [PaymentController::class, 'checkAvailability'])->name('check.availability');
Route::get('/paypal/success', function () {
    return redirect()->route('payment.show')->with('success', '¡Pago realizado con éxito!');
})->name('paypal.success');

/** --- EXPERIENCIAS --- **/
Route::get('/experiencias', [ExperienciaController::class, 'index'])->name('VistaExperiencias');

/** --- GESTIÓN DE RECLAMACIONES --- **/
Route::prefix('admin/reclamaciones')->group(function () {
    Route::get('/', [PaymentController::class, 'reclamacionesIndex'])->name('reclamaciones.index');

    // CAMBIO IMPORTANTE: Cambiado de POST a GET para permitir el "back()" sin error 405
    Route::get('/buscar', [PaymentController::class, 'buscarTickets'])->name('reclamaciones.buscar');

    Route::post('/reenviar', [PaymentController::class, 'reenviarTickets'])->name('reclamaciones.reenviar');
    Route::delete('/cancelar/{fecha}/{email}', [PaymentController::class, 'cancelarCompra'])->name('reclamaciones.cancelar');
});

/** --- MAPA --- **/
Route::get('/mapa', function () {
    return view('mapa'); // Asegúrate de que el nombre coincida con tu .blade.php
})->name('mapa.index');

/** --- ALERTAS MAPA --- */
Route::get('/alerts', [AlertController::class, 'index'])->name('alerts.index');
Route::post('/alerts', [AlertController::class, 'store'])->name('alerts.store');
Route::delete('/alerts/{id}', [AlertController::class, 'destroy'])->name('alerts.destroy');
