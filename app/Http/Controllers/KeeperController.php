<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class KeeperController extends Controller
{
    public function getKeeperData()
    {
        $user = Auth::user();
        $employee = Employee::where('email', $user->email)->first();

        if (!$employee) {
            return response()->json(['keeper' => null, 'animals' => []]);
        }

        // CONTROL DE PERMISOS: Admin ve todo, Keeper ve su zona
        if ($employee->position === 'Administrador') {
            $animals = Animal::all();
        } else {
            $animals = Animal::where('zone_id', $employee->zone_id)->get();
        }

        return response()->json([
            'keeper' => $employee,
            'animals' => $animals
        ]);
    }

    public function feedAnimal(Request $request)
    {
        $request->validate([
            'animal_id' => 'required|exists:animals,id'
        ]);

        $user = Auth::user();
        $employee = Employee::where('email', $user->email)->first();

        $animal = Animal::findOrFail($request->animal_id);

        $animal->update([
            'last_fed_date' => now()->toDateString(),
            'last_fed_by' => $employee->dni
        ]);

        return response()->json(['success' => true, 'message' => 'Animal fed successfully']);
    }
}
