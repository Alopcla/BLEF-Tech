<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExperienciaController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\KeeperController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AlertController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/animales', function () {
    return view('animales');
})->name('animales');
Route::get('/tienda', function () {
    return view('tienda');
})->name('tienda');
Route::get('/experiencias', [ExperienciaController::class, 'index'])->name('VistaExperiencias');
Route::get('/mapa', function () {
    return view('mapa'); })->name('mapa.index');

// Autenticación Google
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (USUARIOS LOGUEADOS)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // 1. Redirección inicial según puesto
    Route::get('/dashboard', function () {
        $employee = Auth::user();
        return match ($employee->position) {
            'Administrador' => redirect()->route('employees.index'),
            'Médico' => redirect()->route('medico.dashboard'),
            'Guía' => redirect()->route('guia.dashboard'),
            'Mantenimiento' => redirect()->route('mantenimiento.dashboard'),
            'Cuidador' => redirect()->route('cuidador.dashboard'),
            default => view('dashboard'),
        };
    })->name('dashboard');

    // 2. Perfil de usuario
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    // ----------------------------------------------------
    // PANEL ADMINISTRADOR (Gestión de RRHH)
    // ----------------------------------------------------
    Route::middleware(['position:Administrador'])->group(function () {
        // Vista principal de React
        Route::get('/empleados', function () {
            return view('admin-react');
        })->name('employees.index');

        // API de datos para React
        Route::get('/api/empleados', [EmployeeController::class, 'index']);
        Route::post('/registrar-nuevo-empleado', [EmployeeController::class, 'store'])->name('employees.store');
        Route::get('/empleados/{encrypted_dni}/editar', [EmployeeController::class, 'edit'])->name('employees.edit');
        Route::put('/empleados/{encrypted_dni}', [EmployeeController::class, 'update'])->name('employees.update');
        Route::delete('/empleados/{dni}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

        // GESTIÓN DE RECLAMACIONES
        Route::prefix('admin/reclamaciones')->name('reclamaciones.')->group(function () {
            Route::get('/', [PaymentController::class, 'reclamacionesIndex'])->name('index');
            Route::get('/buscar', [PaymentController::class, 'buscarTickets'])->name('buscar');
            Route::post('/reenviar', [PaymentController::class, 'reenviarTickets'])->name('reenviar');
            Route::delete('/cancelar/{fecha}/{email}', [PaymentController::class, 'cancelarCompra'])->name('cancelar');
        });
    });

    /* --- PANELES ESPECÍFICOS --- */
    Route::get('/medico/dashboard', function () {
        return "Panel Médico";
    })->name('medico.dashboard')->middleware('position:Médico');
    Route::get('/guia/dashboard', function () {
        return "Panel Guía";
    })->name('guia.dashboard')->middleware('position:Guía');
    Route::get('/mantenimiento/dashboard', function () {
        return "Panel Mantenimiento";
    })->name('mantenimiento.dashboard')->middleware('position:Mantenimiento');
    Route::get('/cuidador/dashboard', function () {
        return "Panel Cuidador";
    })->name('cuidador.dashboard')->middleware('position:Cuidador');
    /* --- PANEL MÉDICO (REACT) --- */
    // Agrupamos todo lo del médico bajo su propio middleware para mayor seguridad y limpieza
    Route::middleware(['position:Médico'])->group(function () {
        // Vista principal
        Route::get('/medico/dashboard', function () {
            return view('medico-react'); })->name('medico.dashboard');

        // ----------------------------------------------------
        // PANEL CUIDADOR (Alimentación y Dietas)
        // ----------------------------------------------------
        // URLs en español para la vista, peticiones API en inglés apuntando a KeeperController.
        Route::get('/cuidador/dashboard', function () {
            return view('keeper-react'); })->name('cuidador.dashboard');
        Route::get('/api/keeper/data', [KeeperController::class, 'getKeeperData']);
        Route::post('/api/keeper/feed', [KeeperController::class, 'feedAnimal']);

        // ----------------------------------------------------
        // OTROS PANELES (Pendientes de implementar React)
        // ----------------------------------------------------
        Route::get('/guia/dashboard', function () {
            return "Panel Guía"; })->name('guia.dashboard')->middleware('position:Guía');
        Route::get('/mantenimiento/dashboard', function () {
            return "Panel Mantenimiento"; })->name('mantenimiento.dashboard')->middleware('position:Mantenimiento');

    });

    /*
    |--------------------------------------------------------------------------
    | TICKETS Y PAGOS
    |--------------------------------------------------------------------------
    */
    Route::controller(PaymentController::class)->group(function () {
        Route::get('/pago', 'showForm')->name('payment.show');
        Route::post('/pago', 'processPayment')->name('payment.process');
        Route::get('/check-availability', 'checkAvailability')->name('check.availability');
    });

    /** --- MAPA --- **/
    Route::get('/mapa', function () {
        return view('mapa'); // Asegúrate de que el nombre coincida con tu .blade.php
    })->name('mapa.index');

    /** --- ALERTAS MAPA --- */
    Route::get('/alerts', [AlertController::class, 'index'])->name('alerts.index');
    Route::post('/alerts', [AlertController::class, 'store'])->name('alerts.store');
    Route::delete('/alerts/{id}', [AlertController::class, 'destroy'])->name('alerts.destroy');
    Route::get('/paypal/success', function () {
        return redirect()->route('payment.show')->with('success', '¡Pago realizado con éxito!');
    })->name('paypal.success');

});
?>
