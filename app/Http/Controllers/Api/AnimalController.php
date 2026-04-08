<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Animal;
use Illuminate\Support\Facades\Validator;

class AnimalController extends Controller
{
    public function index()
    {
        $animals = Animal::with('zone.ecosystem')->get();

        return response()->json([
            'status' => 'success',
            'data' => $animals
        ]);
    }

    /**
     * Registra un nuevo animal con validación de fecha.
     */
    public function store(Request $request)
    {
        // 1. Añadimos TODOS los campos a la validación
        $validator = \Validator::make($request->all(), [
            'zone_id' => 'required|exists:zones,id',
            'common_name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'birth_date' => 'required|date|before_or_equal:' . date('Y-m-d'),
            'diet' => 'required|in:Carnívoro,Herbívoro,Omnívoro,Insectívoro,Piscívoro',

            // CAMPOS QUE FALTABAN:
            'food_ration' => 'required|string|max:255', // Ahora sí se validará y guardará
            'curiosity' => 'nullable|string',         // Marcado como nullable para que no sea obligatorio
            'image' => 'nullable|string',
        ]);

        // 2. SI FALLA: Devolvemos error 422
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error en los datos enviados.',
                'errors' => $validator->errors()
            ], 422);
        }

        // 3. SI PASA: Registramos
        try {
            // Ahora $validator->validated() incluirá food_ration y curiosity
            $animal = Animal::create($validator->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Animal registrado correctamente',
                'data' => $animal
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Fallo en la base de datos: ' . $e->getMessage()
            ], 500);
        }
    }
}
