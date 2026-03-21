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

}
