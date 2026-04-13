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
    /**
     * Devuelve los empleados y zonas en formato JSON para React
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $employees = Employee::with(['zone', 'telephones'])->get();
            $zones = Zone::all();

            return response()->json([
                'employees' => $employees,
                'zones' => $zones,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fallo en la base de datos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * CREAR: Función que recibe, valida y persiste nuevos datos
     * @param Request $request
     */
    public function store(Request $request)
    {
        // Calculamos la fecha exacta de hace 18 años
        $fechaLimite = now()->subYears(18)->toDateString();

        // 1. Validación estricta con mensajes personalizados
        $validated = $request->validate([
            'dni' => [
                'required',
                'unique:employees,dni',
                'regex:/^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKE]$/i'
            ],
            'name' => 'required|max:255',
            'surname' => 'required',
            'email' => 'required|email|unique:employees,email|unique:users,email',

            // CANDADO AL CREAR
            'birth_date' => 'required|date|before_or_equal:' . $fechaLimite,

            'address' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'telephone' => [
                'required',
                'string',
                'regex:/^[6789][0-9]{8}$/',
            ],
            'position' => 'required|string',
            'zone_id' => 'required|integer|exists:zones,id',
        ], [
            // MENSAJE DE ERROR QUE VERÁ REACT
            'dni.regex' => 'El formato del DNI es incorrecto (ej: 12345678A)',
            'birth_date.before_or_equal' => 'El empleado debe tener al menos 18 años para poder ser registrado.',
            'birth_date.required' => 'La fecha de nacimiento es obligatoria.'
        ]);

        try {
            return DB::transaction(function () use ($request, $validated) {
                // Crear Usuario
                User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->dni),
                ]);

                // Crear Empleado
                $employeeData = $request->except('telephone');
                $employee = Employee::create($employeeData);

                // Crear Teléfono
                $employee->telephones()->create([
                    'telephone' => $request->telephone
                ]);

                return response()->json(['message' => '¡Registrado!'], 201);
            });
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * ELIMINAR: Función para eliminar por completo a un empleado
     * @param string $dni
     */
    public function destroy($dni)
    {
        $employee = Employee::where('dni', $dni)->first();

        if ($employee) {
            try {
                return DB::transaction(function () use ($employee) {
                    $user = User::where('email', $employee->email)->first();

                    $employee->telephones()->delete();

                    if ($user) {
                        $user->delete();
                    }

                    $employee->delete();

                    return response()->json(['status' => 'ok', 'message' => 'Empleado eliminado correctamente']);
                });
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al eliminar: ' . $e->getMessage()], 500);
            }
        }

        return response()->json(['error' => 'Empleado no encontrado'], 404);
    }

    /**
     * EDITAR: Función para cargar la vista
     * @param string $encrypted_dni
     */
    public function edit($encrypted_dni)
    {
        $dni = decrypt($encrypted_dni);
        $employee = Employee::where('dni', $dni)->firstOrFail();
        $zones = Zone::all();

        return view('employees-edit', compact('employee', 'zones'));
    }

    /**
     * ACTUALIZAR: Función para actualizar los datos de un empleado
     * @param Request $request
     * @param string $dni
     */
    public function update(Request $request, $dni)
    {
        $employee = Employee::where('dni', $dni)->firstOrFail();

        // Calculamos de nuevo la fecha de hace 18 años para la edición
        $fechaLimite = now()->subYears(18)->toDateString();

        // 1. Validación Corregida (¡Faltaba la fecha de nacimiento aquí!)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string',

            // CANDADO AL EDITAR
            'birth_date' => 'required|date|before_or_equal:' . $fechaLimite,

            'address' => 'required|string',
            'province' => 'required|string',
            'position' => 'required|string',
            'zone_id' => 'nullable|integer|exists:zones,id',
            'telephones' => 'array',
        ], [
            // MENSAJE DE ERROR QUE VERÁ REACT AL EDITAR
            'birth_date.before_or_equal' => 'El empleado debe tener al menos 18 años. Revisa la fecha.',
            'birth_date.required' => 'La fecha de nacimiento no puede quedar en blanco.'
        ]);

        try {
            DB::transaction(function () use ($request, $employee) {
                // A) Actualizar datos básicos del empleado (Añadido 'birth_date')
                $employee->update($request->only(['name', 'surname', 'birth_date', 'address', 'province', 'position', 'zone_id']));

                // B) Sincronizar nombre en la tabla Users
                $user = User::where('email', $employee->email)->first();
                if ($user) {
                    $user->update(['name' => $request->name]);
                }

                // C) Sincronizar Teléfonos
                if ($request->has('telephones')) {
                    $employee->telephones()->delete();
                    foreach ($request->telephones as $tel) {
                        if (!empty($tel['telephone'])) {
                            $employee->telephones()->create(['telephone' => $tel['telephone']]);
                        }
                    }
                }
            });

            return response()->json(['message' => 'Actualizado con éxito', 'success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
