<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Models\Zone;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /** En esta clase (Controlador), se leera los datos reales
     * para que se envie a los Componentes.
     */
    public function index() {
        // Recuperamos todos los empleados de la BD
        $employees = Employee::with('telephones')->get();

        // Recuperar todas las zonas para el desplegable en el Dashboard
        $zones = Zone::all();

        // Enviamos los datos a la vista 'employees' que creamos antes
        return view('employees', compact('employees', 'zones'));
    }

    public function store(Request $request) {
        // 1. Añadimos el zone_id a la validación y ponemos dni en minúscula
        $request->validate([
            'dni' => 'required|unique:employees,dni', // Minúsculas
            'name' => 'required|max:255',
            'surname' => 'required',
            'email' => 'required|email|unique:employees,email|unique:users,email',
            'birth_date' => 'required|date',
            'address' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'number' => 'required|string',
            'position' => 'required|string',
            'zone_id' => 'required|integer|exists:zones,id', // Validamos que la zona exista
        ]);

        DB::transaction(function () use ($request) {

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->dni), // Minúsculas
            ]);

            // 2. Mapeamos exactamente igual que en tu imagen de Supabase
            $employee = Employee::create([
                'dni' => $request->dni, // Minúsculas
                'zone_id' => $request->zone_id, // Añadido el campo de la foránea
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'birth_date' => $request->birth_date,
                'address' => $request->address,
                'province' => $request->province,
                'position' => $request->position
            ]);

            $employee->telephones()->create([
                'telephone' => $request->number
            ]);

        });

        return back()->with('success', '¡Empleado registrado correctamente! Su contraseña de acceso es su DNI.');
    }
}
