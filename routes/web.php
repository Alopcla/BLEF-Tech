<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExperienciaController;
use Illuminate\Support\Facades\Route;


/** Ruta para la Página principal */
Route::get('/', function () {
    return view('welcome');
});

// Rutas de Google OAuth (Socialite)
Route::get('/auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'callback'])->name('auth.google.callback');


/** Dashboard (requiere autenticación) */
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/** Rutas de Perfil (requieren autenticación) */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/** Rutas de Empleados */
Route::get('/empleados', [EmployeeController::class, 'index'])->name('employees.index');
Route::post('/registrar-nuevo-empleado', [EmployeeController::class, 'store'])->name('employees.store');

/** Rutas de Pago */
Route::get('/pago', [PaymentController::class, 'showForm'])->name('payment.show');
Route::post('/pago', [PaymentController::class, 'processPayment'])->name('payment.process');
//Validar cantidad disponioble de entradas en tiempo real
Route::get('/check-availability', [App\Http\Controllers\PaymentController::class, 'checkAvailability'])->name('check.availability');

/** Rutas de la vista Experiencias */
Route::get('/experiencias', [ExperienciaController::class, 'index'])->name('VistaExperiencias');
Route::get('/experiencias/{slug}', [ExperienciaController::class, 'MostrarInfo'])->name('experienciasInfo');

/**Ruta para la tienda */
Route::get('/tienda', function () {return view('tienda');})->name('tienda');

/** Ruta para el Login */
require __DIR__ . '/auth.php';

