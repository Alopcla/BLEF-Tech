<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\EmployeeTelephone;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Forzamos el registro del evento desde el Provider del TFG
        EmployeeTelephone::creating(function ($telephone) {
            $ultimoOrden = EmployeeTelephone::where('employee_dni', $telephone->employee_dni)->max('order');
            $telephone->order = ($ultimoOrden ?? 0) + 1;
        });

        /**PRUEBAS */

        /*if (app()->environment('local')) {
            Auth::loginUsingId(1);
        }*/
    }
}
