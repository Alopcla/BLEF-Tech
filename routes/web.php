<?php

use App\Http\Controllers\EmployeeController;
use App\Models\Employee;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/** Ruta para LOGIN (Formulario de entrada)*/
Route::get('/login', function () {
    return view('logins.loginv2');
})->name('login');

/** Direccion de ruta para ir a la Pagina principal (index.html) */
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/** Ruta para dirigirnos en Localhost y que se muestre en pantalla el Blade.
 * El segundo parametro trata del Controlador, la funcion que se llama index()
 */
Route::get('/prueba', [EmployeeController::class, 'index'])->name('employees.index');

/** Ruta para dirigirnos a REGISTRAR UN EMPLEADO (Formulario de registro)*/
Route::post('/registrar-nuevo-empleado', [EmployeeController::class, 'store'])->name('employees.store');

/** Ruta para RECUPERAR CONTRASEÑA */
Route::get('/recover-password', function () {
    return view('auth.recuperarpassv3');
});

/** Ruta para  REGISTRO (Formulario de registro)*/
Route::get('/register', function () {
    return view('auth.register');
});

require __DIR__ . '/auth.php';
//Ruta del formulario de pago de entradas
use App\Http\Controllers\PaymentController;

// Cuando el usuario entra a /pago (GET), mostramos el formulario
Route::get('/pago', [PaymentController::class, 'showForm'])->name('payment.show');

// Cuando el usuario pulsa el botón "Pagar" (POST), procesamos los datos
Route::post('/pago', [PaymentController::class, 'processPayment'])->name('payment.process');
