<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Animal;

class AnimalController extends Controller
{
    /**
     * Obtiene TODOS los animales con sus zonas y ecosistemas.
    */
    public function index()
    {
        // Traemos todos los animales e incluimos su zona, y el ecosistema de esa zona
        $animals = Animal::with('zone.ecosystem')->get();

        return response()->json([
            'status' => 'success',
            'data' => $animals
        ]);
    }

    /**
     * Obtiene un animal aleatorio de la base de datos local.
     */
    public function getRandomAnimal()
    {
        // Añadimos también las relaciones aquí por si quieres mostrar
        // de qué ecosistema es este animal aleatorio.
        $animal = Animal::with('zone.ecosystem')->inRandomOrder()->first();

        if (!$animal) {
            return response()->json([
                'status' => 'error',
                'message' => 'No se encontraron animales en la base de datos'
            ], 404);
        }

        // Lo devolvemos en el mismo formato estructurado
        return response()->json([
            'status' => 'success',
            'data' => $animal
        ]);
    }
}
