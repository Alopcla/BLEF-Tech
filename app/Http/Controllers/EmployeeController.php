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

    /**
     * Summary of index: Devuelve los empleados y zonas en formato JSON para React
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            // 1. Traemos los empleados con sus relaciones
            $employees = Employee::with(['zone', 'telephones'])->get();

            // 2. Traemos TODAS las zonas de la tabla zonas para el desplegable de React
            $zones = Zone::all();

            // 3. Enviamos AMBOS en la respuesta JSON
            return response()->json([
                'employees' => $employees,
                'zones' => $zones, // <--- ESTO ES LO QUE LE FALTA A REACT
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fallo en la base de datos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Summary of store: Funcion que sirve para recibir, validar y persistir nuevos datos
     * en la base de datos, proveniente de un formulario.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 1. Validación estricta
        $validated = $request->validate([
            // Validacion del DNI, cuyo formato sea de 9 cifras y 1 letra.
            'dni' => [
                'required',
                'unique:employees,dni',
                'regex:/^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKE]$/i'
            ],
            'name' => 'required|max:255',
            'surname' => 'required',
            'email' => 'required|email|unique:employees,email|unique:users,email',
            'birth_date' => 'required|date',
            'address' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            // Validacion de numero de telefono, siendo de 9 digitos (aunque sea un string)
            'telephone' => [
                'required',
                'string',
                'regex:/^[6789][0-9]{8}$/',
            ],
            'position' => 'required|string',
            'zone_id' => 'required|integer|exists:zones,id',
        ]);

        try {
            return DB::transaction(function () use ($request, $validated) {
                // Crear Usuario
                User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->dni),
                ]);

                // Crear Empleado (Usamos solo los datos del empleado, excluyendo el teléfono)
                $employeeData = $request->except('telephone');
                $employee = Employee::create($employeeData);

                // Crear Teléfono (Usamos el campo 'telephone' que viene de React)
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
     * Summary of destroy: Funcion para eliminar por completo a un empleado y sus credenciales en Users
     * @param string $encrypted_dni
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($dni)
    {
        // 1. Buscamos al empleado por su DNI
        $employee = Employee::where('dni', $dni)->first();

        if ($employee) {
            try {
                return DB::transaction(function () use ($employee) {
                    // 2. Buscamos al usuario vinculado por el email ANTES de borrar al empleado
                    $user = User::where('email', $employee->email)->first();

                    // 3. Borramos los teléfonos (relación hija)
                    $employee->telephones()->delete();

                    // 4. Borramos al usuario de la tabla 'users'
                    if ($user) {
                        $user->delete();
                    }

                    // 5. Borramos al empleado de la tabla 'employees'
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
     * Summary of edit: Funcion para cargar la vista donde editaremos a un empleado existente
     * @param Employee $employee
     * @return void
     */
    public function edit($encrypted_dni)
    {
        // Desencriptamos el DNI y buscamos al empleado
        $dni = decrypt($encrypted_dni);
        $employee = Employee::where('dni', $dni)->firstOrFail();


        $zones = Zone::all();

        return view('employees-edit', compact('employee', 'zones'));
    }

    /**
     * Summary of update: Funcion para actualizar los datos de un empleado
     * @param Request $request
     * @param Employee $employee
     * @return void
     */
    public function update(Request $request, $dni)
    {
        $employee = Employee::where('dni', $dni)->firstOrFail();

        // 1. Validación Corregida
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string',
            'address' => 'required|string',
            'province' => 'required|string',
            'position' => 'required|string',
            'zone_id' => 'nullable|integer|exists:zones,id', // <-- AHORA PERMITE NULOS
            'telephones' => 'array', // <-- RECONOCE EL ARRAY DE REACT
        ]);

        try {
            \DB::transaction(function () use ($request, $employee) {
                // A) Actualizar datos básicos del empleado
                $employee->update($request->only(['name', 'surname', 'address', 'province', 'position', 'zone_id']));

                // B) Sincronizar nombre en la tabla Users
                $user = User::where('email', $employee->email)->first();
                if ($user) {
                    $user->update(['name' => $request->name]);
                }

                // C) Sincronizar Teléfonos (Borra los viejos y crea los nuevos)
                if ($request->has('telephones')) {
                    $employee->telephones()->delete();
                    foreach ($request->telephones as $tel) {
                        // Solo guardamos si el input no está vacío
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
