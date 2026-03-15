<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Animal;

class AnimalController extends Controller
{
    /**
     * Obtiene un animal aleatorio de la base de datos local.
     */
    public function getRandomAnimal()
    {
        // Consulta un registro aleatorio en la tabla local de animales
        $animal = Animal::inRandomOrder()->first();

        if (!$animal) {
            return response()->json([
                'status' => 'error',
                'message' => 'No se encontraron animales en la base de datos'
            ], 404);
        }

        return response()->json($animal);
    }
}
