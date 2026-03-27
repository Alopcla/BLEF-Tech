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

    $employee = Auth::user();

    if($employee->position === 'Administrador')
        return redirect()->route('employees.index');

    elseif($employee->position === 'Médico')
        return redirect()->route('medico.dashboard');

    elseif($employee->position === 'Guía')
        return redirect()->route('guia.dashboard');

    elseif($employee->position === 'Mantenimiento')
        return redirect()->route('mantenimiento.dashboard');

    elseif($employee->position === 'Cuidador')
        return redirect()->route('cuidador.dashboard');

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/** Rutas de Perfil (requieren autenticación) */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/**
 * *********************************************************
 *  NUEVAS RUTAS PROTEGIDAS POR PUESTO
 * *********************************************************/
Route::middleware(['auth'])->group(function () {

    // PANEL DEL ADMINISTRADOR
    Route::middleware(['position:Administrador'])->group(function () {
        // Ruta para dirigirnos al panel de Administador, donde veremos a todos los empleados
        // y podemos realizar CRUD.
        Route::get('/empleados', [EmployeeController::class, 'index'])->name('employees.index');
        // Ruta para registrar un nuevo empleado
        Route::post('/registrar-nuevo-empleado', [EmployeeController::class, 'store'])->name('employees.store');
        // Ruta para borrar un empleado
        Route::delete('/empleados/{encrypted_dni}', [
            App\Http\Controllers\EmployeeController::class, 'destroy'])->name('employees.destroy');
        // Ruta para poder editar a un empleado ya creado
        Route::get('/empleados/{encrypted_dni}/editar', [
            App\Http\Controllers\EmployeeController::class, 'edit'])->name('employees.edit');
        // Ruta PUT para actualizar los datos del empleado
        Route::put('/empleados/{encrypted_dni}', [
            App\Http\Controllers\EmployeeController::class, 'update'])->name('employees.update');
    });

    // PANEL DEL MEDICO
    Route::middleware(['position:Médico'])->group(function () {
        Route::get('/panel-medico', function () {
            return view('panels.doctor');
        })->name('medico.dashboard');
    });

    // PANEL DE GUIA
    Route::middleware(['position:Guía'])->group(function () {
        Route::get('/panel-guia', function () {
            return view('panels.guide');
        })->name('guia.dashboard');
    });

    // PANEL DE MANTENIMIENTO
    Route::middleware(['position:Mantenimiento'])->group(function () {
        Route::get('panel-mantenimiento', function () {
            return view('panels.maintenance');
        })->name('mantenimiento.dashboard');
    });

    // PANEL DEL CUIDADOR
    Route::middleware(['position:Cuidador'])->group(function () {
        Route::get('/panel-cuidador', function () {
            return view('panels.keeper');
        })->name('cuidador.dashboard');
    });
});

/**
 * *****************************************************
 *  FIN DE LAS RUTAS A LA HORA DE LOGUEARSE SEGUN PUESTO
 * *****************************************************/

/** Rutas de Pago */
Route::get('/pago', [PaymentController::class, 'showForm'])->name('payment.show');
Route::post('/pago', [PaymentController::class, 'processPayment'])->name('payment.process');
//Validar cantidad disponible de entradas en tiempo real
Route::get('/check-availability', [App\Http\Controllers\PaymentController::class, 'checkAvailability'])->name('check.availability');

/** Rutas de la vista Experiencias */
Route::get('/experiencias', [ExperienciaController::class, 'index'])->name('VistaExperiencias');
Route::get('/experiencias/{slug}', [ExperienciaController::class, 'MostrarInfo'])->name('experienciasInfo');

/**Ruta para la tienda */
Route::get('/tienda', function () {
    return view('tienda');
})->name('tienda');

/** Ruta para los animales */
Route::get('/animales', function () {
    return view('animales');
})->name('animales');

/** Ruta para el Login */
require __DIR__ . '/auth.php';

