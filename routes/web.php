<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\KeeperController;
use App\Http\Controllers\Api\AlertController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\VerifyCodeController;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\TicketMail;


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
Route::get('/experiencias', [ExperienceController::class, 'index'])->name('VistaExperiencias');
Route::get('/experiencias/{slug}', [ExperienceController::class, 'MostrarInfo'])->name('experienciasInfo');


Route::get('/mapa', function () {
    return view('mapa');
})->name('mapa.index');

Route::get('/contacto', function () {
    return view('contact');
})->name('contacto');

// Autenticación Google
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');

Route::get('/compras', function () {
    return view('myorders');
});

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (USUARIOS LOGUEADOS)
|--------------------------------------------------------------------------
*/
// ── CLIENTES ──────────────────────────────────────────
Route::middleware(['auth:web'])->group(function () {
    Route::get('/compras', function () {
        return view('myorders');
    })->name('compras');

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

// ── EMPLEADOS (todos los puestos) ─────────────────────
Route::middleware(['auth:employee'])->group(function () {

    Route::get('/dashboard', function () {
        $employee = Auth::guard('employee')->user();
        return match ($employee->position) {
            'Administrador' => redirect()->route('employees.index'),
            'Médico'        => redirect()->route('medico.dashboard'),
            'Guía'          => redirect()->route('guia.dashboard'),
            'Cuidador'      => redirect()->route('cuidador.dashboard'),
            default         => view('dashboard'),
        };
    })->name('dashboard');

    Route::post('verify-code', [VerifyCodeController::class, 'store'])
        ->name('verification.code');

    // PANEL ADMINISTRADOR
    Route::middleware(['position:Administrador'])->group(function () {
        Route::get('/empleados', fn() => view('admin-react'))->name('employees.index');
        Route::get('/api/empleados', [EmployeeController::class, 'index']);
        Route::post('/registrar-nuevo-empleado', [EmployeeController::class, 'store'])->name('employees.store');
        Route::get('/empleados/{encrypted_dni}/editar', [EmployeeController::class, 'edit'])->name('employees.edit');
        Route::put('/empleados/{encrypted_dni}', [EmployeeController::class, 'update'])->name('employees.update');
        Route::delete('/empleados/{dni}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

        Route::prefix('admin/reclamaciones')->name('reclamaciones.')->group(function () {
            Route::get('/', [PaymentController::class, 'reclamacionesIndex'])->name('index');
            Route::get('/buscar', [PaymentController::class, 'buscarTickets'])->name('buscar');
            Route::post('/reenviar', [PaymentController::class, 'reenviarTickets'])->name('reenviar');
            Route::delete('/cancelar/{fecha}/{email}', [PaymentController::class, 'cancelarCompra'])->name('cancelar');
            Route::delete('/cancelar-pedido', [PaymentController::class, 'cancelarPedido'])->name('cancelar.pedido');
        });
    });

    // PANEL MÉDICO
    Route::middleware(['position:Médico,Administrador'])->group(function () {
        Route::get('/medico/dashboard', fn() => view('medico-react'))->name('medico.dashboard');
        Route::get('/api/medico/datos', [MedicalRecordController::class, 'getDoctorData']);
        Route::post('/api/medico/historial', [MedicalRecordController::class, 'storeRecord']);
        Route::post('/api/medico/animal', [\App\Http\Controllers\Api\AnimalController::class, 'store']);
        Route::delete('/api/medico/animal/{id}', [MedicalRecordController::class, 'destroyAnimal']);
    });

    // PANEL CUIDADOR
    Route::middleware(['position:Cuidador,Administrador'])->group(function () {
        Route::get('/cuidador/dashboard', fn() => view('keeper-react'))->name('cuidador.dashboard');
        Route::get('/api/keeper/data', [KeeperController::class, 'getKeeperData']);
        Route::post('/api/keeper/feed', [KeeperController::class, 'feedAnimal']);
    });

    // PANEL GUÍA
    Route::middleware(['position:Guía,Administrador'])->group(function () {
        Route::get('/guia/dashboard', fn() => view('guide-react'))->name('guia.dashboard');
        Route::get('/api/guide/data', [App\Http\Controllers\GuideController::class, 'getGuideData']);
        Route::post('/api/guide/complete', [App\Http\Controllers\GuideController::class, 'completeExperience']);
    });

    // ALERTAS
    Route::get('/alerts', [AlertController::class, 'index'])->name('alerts.index');
    Route::post('/alerts', [AlertController::class, 'store'])->name('alerts.store');
    Route::delete('/alerts/{id}', [AlertController::class, 'destroy'])->name('alerts.destroy');
});

/*
|--------------------------------------------------------------------------
| TICKETS Y PAGOS
|--------------------------------------------------------------------------
*/

// 1. Rutas de Tickets (Gestión de disponibilidad y vista de reserva)
Route::controller(TicketController::class)->group(function () {
    Route::get('/tickets', 'showTickets')->name('tickets.show');
    Route::get('/check-availability', 'checkAvailability')->name('check.availability');
});

Route::controller(PaymentController::class)->group(function () {
    Route::get('/pago', 'showForm')->name('payment.show');
    Route::post('/pago', 'processPayment')->name('payment.process');
});

Route::get('/pago/success', [PaymentController::class, 'paymentSuccess'])
    ->name('payment.success');

Route::get('/pago/error', [PaymentController::class, 'paymentError'])
    ->name('payment.error');

Route::get('/paypal/success', function () {
    return redirect()->route('payment.show')->with('success', '¡Pago realizado con éxito!');
})->name('paypal.success');

Route::post('/pago/shop', [PaymentController::class, 'processPayment'])->name('payment.shop');
