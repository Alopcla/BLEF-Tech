<?php

use App\Http\Controllers\EmployeeController;
use App\Models\Employee;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

/** Ruta para dirigirnos a*/
Route::post('/registrar-nuevo-empleado', [EmployeeController::class, 'store'])->name('employees.store');

require __DIR__ . '/auth.php';
?>
