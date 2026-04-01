<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use App\Models\ZoneEvent; // Asegúrate de incluir la importación del nuevo modelo
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    /**
     * Obtiene la información de una zona específica junto con sus animales, 
     * experiencias y EVENTOS activos.
     */
    public function getZoneInfo($type)
    {
        // Cargamos animals, experiences y filtramos solo los eventos ACTIVOS
        // Usamos 'events' que es el nombre del método de relación en el modelo Zone
        $zona = Zone::where('type', $type)
            ->with([
                'animals',
                'experiences',
                'events' => function ($query) {
                    $query->where('active', true)
                        ->orderBy('created_at', 'desc');
                }
            ])
            ->first();

        if (!$zona) {
            return response()->json(['error' => 'Zona no encontrada'], 404);
        }

        return response()->json([
            'type' => $zona->type,
            'description' => $zona->description,
            'dimensions_m2' => $zona->dimensions_m2,

            // Mapeamos los animales (usando el nombre común de tu tabla)
            'animals' => $zona->animals->map(fn($a) => [
                'name' => $a->common_name
            ]),

            // Mapeamos las experiencias VIP
            'experiences' => $zona->experiences->map(fn($e) => [
                'name' => $e->name,
                'price' => $e->price,
                'duration' => $e->duration_min
            ]),

            // Mapeamos los eventos/alertas gestionados por los empleados
            'events' => $zona->events->map(fn($ev) => [
                'title' => $ev->title,
                'message' => $ev->message,
                'level' => $ev->level // Esto devolverá 'aviso', 'alerta' o 'peligro'
            ])
        ]);
    }
}
