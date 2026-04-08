<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\MedicalRecord;
use App\Models\Employee;
use App\Models\Zone;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController extends Controller
{

    public function getDoctorData()
    {
        $user = Auth::user();
        $doctor = Employee::where('email', $user->email)->first();

        if (!$doctor) {
            return response()->json(['doctor' => null, 'animals' => []]);
        }

        // LA LLAVE MAESTRA: Comprobamos si es Administrador
        if ($doctor->position === 'Administrador') {
            // El Admin ve TODOS los animales de TODAS las zonas
            $animals = Animal::with([
                'medicalRecords' => function ($query) {
                    $query->orderBy('date', 'desc');
                }
            ])->get();
        } else {
            // El Médico normal ve SOLO los de su zona asignada
            $animals = Animal::where('zone_id', $doctor->zone_id)
                ->with([
                    'medicalRecords' => function ($query) {
                        $query->orderBy('date', 'desc');
                    }
                ])->get();
        }

        return response()->json([
            'doctor' => $doctor,
            'animals' => $animals,
            'zones' => Zone::all()
        ]);
    }

    public function storeRecord(Request $request)
    {
        $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
        ]);

        $user = Auth::user();
        $doctor = Employee::where('email', $user->email)->first();

        if (!$doctor) {
            return response()->json(['error' => 'No se encontró la ficha del empleado'], 404);
        }

        MedicalRecord::create([
            'animal_id' => $request->animal_id,
            'employee_dni' => $doctor->dni,
            'date' => now()->toDateTimeString(),
            'diagnosis' => $request->diagnosis,
            'treatment' => $request->treatment
        ]);

        return response()->json(['success' => true, 'message' => 'Historial guardado']);
    }

    public function storeAnimal(Request $request)
    {
        $validated = $request->validate([
            'zone_id' => 'required|exists:zones,id',
            'common_name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'image' => 'nullable|string',
            'curiosity' => 'nullable|string',
            'diet' => 'nullable|string',
        ]);

        Animal::create($validated);

        return response()->json(['success' => true, 'message' => 'Animal creado']);
    }

    public function destroyAnimal($id)
    {
        $animal = Animal::find($id);

        if (!$animal) {
            return response()->json(['error' => 'Animal no encontrado'], 404);
        }

        $animal->delete();

        return response()->json(['success' => true, 'message' => 'Animal eliminado correctamente']);
    }
}
