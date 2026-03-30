<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    /**
     * Obtiene la información de una zona específica junto con sus animales.
     */
    public function getZoneInfo($type)
    {
        // Cargamos tanto 'animals' como 'experiences'
        $zona = Zone::where('type', $type)->with(['animals', 'experiences'])->first();

        if (!$zona) {
            return response()->json(['error' => 'Zona no encontrada'], 404);
        }

        return response()->json([
            'type' => $zona->type,
            'description' => $zona->description,
            'dimensions_m2' => $zona->dimensions_m2,
            // Mapeamos los animales
            'animals' => $zona->animals->map(fn($a) => ['name' => $a->common_name]),
            // Mapeamos las experiencias
            'experiences' => $zona->experiences->map(fn($e) => [
                'name' => $e->name,
                'price' => $e->price,
                'duration' => $e->duration_min
            ])
        ]);
    }
}
