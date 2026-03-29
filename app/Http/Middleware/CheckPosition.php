<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Summary of CheckPosition: Este archivo es un Middleware, actua como una capa de seguridad
 * que se ejecuta entre la peticion HTTP del usuario y la respuesta de la aplicacion.
 * Su funcion principal es interceptar la navegacion del empleado una vez que ha iniciado sesion,
 * para poder validar su nivel de autorizacion mediante el campo ´Cargo´ de la tabla Employees.
 */
class CheckPosition
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Se verifica si hay alguien que haya iniciado sesion
        if (!Auth::check()) {
            return redirect('\login');
        }

        // Obtenemos el empleado que ha iniciacio sesion
        $employee = Auth::user();

        // En caso de que el usuario sea Administrador, darle carta libre a todas las rutas
        if ($employee->position === 'Administrador') {
            return $next($request);
        }

        // Se compara el rol del empleado con el rol que exige la ruta
        if ($employee->position !== $role) {
            abort(403, 'Acceso denegado. Tu puesto de '.$employee->postition.' no tiene permisos para esta área del zoológico.');
        }

        // Si todo esta correcto, se le abre la puerta para que continue
        return $next($request);

    }
}
