<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Importante importar el Modelo de Animal, para comunicarse con la base de datos
use App\Models\Animal;

class AnimalController extends Controller
{
    /**
     * Summary of getRandomAnimal: Funcion para obtener un animal aleatorio
     * de la base de datos. Devuelve un JSON especifico del animal elegido.
     * @return void
     */
    public function getRandomAnimal() {

        /* Primero realizamos una consulta a la base de datos,
        *   trayendo, aleatoriamente, un animal.
        */
        $animal = Animal::inRandomOrder()->first();

        // Se comprueba si la tabla no existe ningun dato.
        if(!$animal) {
            return response()->json(['message' => 'No hay animales disponibles'], 404);
        }

        // Devuelve el animal elegido en formato JSON.
        return response()->json($animal);
    }
}
