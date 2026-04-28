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
}