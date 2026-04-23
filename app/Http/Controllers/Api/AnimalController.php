<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Animal;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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
            'diet' => 'required|string',
            'food_ration' => 'required|string|max:255',
            'curiosity' => 'nullable|string',
            // Permitimos tanto archivo como string (por si viene una URL de fallback)
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            $data = $validator->validated();

            // Manejo de la subida de imagen
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('animals', 'public');
                $data['image'] = $path;
            }

            $animal = Animal::create($data);

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
