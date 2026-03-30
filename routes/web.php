<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExperienciaController;
use Illuminate\Support\Facades\Route;

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

/** Dashboard (requiere autenticación) */
Route::get('/dashboard', function () {

    $employee = Auth::user();

    if ($employee->position === 'Administrador')
        return redirect()->route('employees.index');
    elseif ($employee->position === 'Médico')
        return redirect()->route('medico.dashboard');
    elseif ($employee->position === 'Guía')
        return redirect()->route('guia.dashboard');
    elseif ($employee->position === 'Mantenimiento')
        return redirect()->route('mantenimiento.dashboard');
    elseif ($employee->position === 'Cuidador')
        return redirect()->route('cuidador.dashboard');

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/** Rutas de Perfil (requieren autenticación) */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/** --- GESTIÓN DE EMPLEADOS ---
* Route::get('/empleados', [EmployeeController::class, 'index'])->name('employees.index');
* // Nota: store suele ser POST para creación
* Route::post('/registrar-nuevo-empleado', [EmployeeController::class, 'store'])->name('employees.store');
* Route::get('/empleados/{dni}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
* Route::delete('/empleados/{dni}', [EmployeeController::class, 'destroy'])->name('employees.destroy'); **/

    // PANEL DEL ADMINISTRADOR
    Route::middleware(['position:Administrador'])->group(function () {

        // 1. RUTA VISUAL (React)
        Route::get('/empleados', function () {
            return view('admin-react');
        })->name('employees.index');

        // 2. RUTA DE DATOS (JSON API)
        Route::get('/api/empleados', [EmployeeController::class, 'index']);

        // 3. RUTAS DE ACCIÓN (CRUD)
        Route::post('/registrar-nuevo-empleado', [EmployeeController::class, 'store'])->name('employees.store');
        Route::delete('/empleados/{encrypted_dni}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
        Route::get('/empleados/{encrypted_dni}/editar', [EmployeeController::class, 'edit'])->name('employees.edit');
        Route::put('/empleados/{encrypted_dni}', [EmployeeController::class, 'update'])->name('employees.update');

    });
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

/** Ruta para los animales */
Route::get('/animales', function () {
    return view('animales');
})->name('animales');

/** --- GESTIÓN DE RECLAMACIONES --- **/
Route::prefix('admin/reclamaciones')->group(function () {
    Route::get('/', [PaymentController::class, 'reclamacionesIndex'])->name('reclamaciones.index');

    // CAMBIO IMPORTANTE: Cambiado de POST a GET para permitir el "back()" sin error 405
    Route::get('/buscar', [PaymentController::class, 'buscarTickets'])->name('reclamaciones.buscar');

    Route::post('/reenviar', [PaymentController::class, 'reenviarTickets'])->name('reclamaciones.reenviar');
    Route::delete('/cancelar/{fecha}/{email}', [PaymentController::class, 'cancelarCompra'])->name('reclamaciones.cancelar');
});

/** Ruta para el Login */
require __DIR__ . '/auth.php';
    // CAMBIO IMPORTANTE: Cambiado de POST a GET para permitir el "back()" sin error 405
    Route::get('/buscar', [PaymentController::class, 'buscarTickets'])->name('reclamaciones.buscar');

    Route::post('/reenviar', [PaymentController::class, 'reenviarTickets'])->name('reclamaciones.reenviar');
    Route::delete('/cancelar/{fecha}/{email}', [PaymentController::class, 'cancelarCompra'])->name('reclamaciones.cancelar');
});
