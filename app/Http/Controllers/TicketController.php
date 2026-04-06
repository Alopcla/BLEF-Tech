<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketController extends Controller
{
    /**
     * Responde a la petición AJAX del JavaScript (Fetch)
     */
    public function checkAvailability(Request $request)
    {
        $fecha = $request->query('date');

        // Usamos el método estático que creaste en el Modelo Ticket
        $disponibles = Ticket::availableForDate($fecha);

        return response()->json([
            'available' => (int) $disponibles // Forzamos a que sea un número
        ]);
    }

    /**
     * Muestra la vista inicial del formulario
     */
    public function showTickets()
    {
        $fecha = now()->addDay()->format('Y-m-d');

        // Es mejor usar el modelo aquí también para que la lógica de 
        // "solo contar los pagados" sea la misma en todas partes.
        $disponibles = Ticket::availableForDate($fecha);

        return view('payment.form', [
            'fecha' => $fecha,
            'disponibles' => $disponibles
        ]);
    }
}