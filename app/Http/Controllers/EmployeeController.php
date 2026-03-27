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
     * Summary of index: Funcion que carga la vista principal del Dashboard con todos los empleados
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Recuperamos todos los empleados de la BD
        $employees = Employee::with('telephones')->get();
        // Recuperar todas las zonas para el desplegable en el Dashboard
        $zones = Zone::all();
        // Enviamos los datos a la vista 'employees' que creamos antes
        return view('employees', compact('employees', 'zones'));
    }

    /**
     * Summary of store: Funcion que sirve para recibir, validar y persistir nuevos datos
     * en la base de datos, proveniente de un formulario.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
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

    /**
     * Summary of destroy: Funcion para eliminar por completo a un empleado y sus credenciales en Users
     * @param string $encrypted_dni
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($encrypted_dni)
    {
        // Desencriptamos el DNI y buscamos al empleado
        $dni = decrypt($encrypted_dni);
        $employee = Employee::where('dni', $dni)->firstOrFail();

        DB::transaction(function () use ($employee) {
            // Primero borramos sus telefonos asociados (hay que borrar primero sus foraneas)
            $employee->telephones()->delete();

            /* Despues eliminamos los datos del empleados en la tabla Users.
             * Recordar que la tabla Users es la llave para poder hacer Login al dashboard
             * Identificamos en Users al empleado mediante el email **/
            $user = User::where('email', $employee->email)->first();

            if ($user) {
                $user->delete();
            }

            // Y por ultimo, borramos al empleado
            $employee->delete();
        });

        return back()->with('success', '¡Empleado eliminado correctamente!');
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
    public function update(Request $request, $encrypted_dni)
    {
        // Desencriptamos el DNI y buscamos al empleado
        $dni = decrypt($encrypted_dni);
        $employee = Employee::where('dni', $dni)->firstOrFail();

        // 1. Validamos los datos básicos
        $request->validate([
            'name' => 'required|max:255',
            'surname' => 'required',
            'address' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'position' => 'required|string',
            'zone_id' => 'required|integer|exists:zones,id',
            'telephones' => 'nullable|array',
            'telephones.*' => 'required|string', // Si dejas la cajita, no puede estar vacía
            'new_telephones' => 'nullable|array',
            'new_telephones.*' => 'nullable|string',
        ]);

        // 2. VALIDACIÓN ESTRICTA DE MÍNIMO 1 TELÉFONO
        // Contamos cuántos teléfonos viejos nos envían y cuántos nuevos (ignorando los vacíos)
        $oldPhonesCount = count($request->telephones ?? []);
        $newPhonesCount = count(array_filter($request->new_telephones ?? []));

        if (($oldPhonesCount + $newPhonesCount) === 0) {
            // Si la suma es 0, lo devolvemos con un mensaje de error a la vista
            return back()->withErrors(['telephones' => '¡Atención! El empleado debe tener al menos un número de teléfono registrado.'])->withInput();
        }

        // 3. Transacción de base de datos
        DB::transaction(function () use ($request, $employee) {

            // A) Actualizamos empleado
            $employee->update([
                'name' => $request->name,
                'surname' => $request->surname,
                'address' => $request->address,
                'province' => $request->province,
                'position' => $request->position,
                'zone_id' => $request->zone_id,
            ]);

            // B) Actualizamos usuario
            $user = User::where('email', $employee->email)->first();
            if ($user) {
                $user->update(['name' => $request->name]);
            }

            // C) ELIMINAR TELÉFONOS BORRADOS EN EL HTML
            // Cogemos los IDs de los teléfonos que SÍ han llegado en el formulario
            $telefonosEnviados = array_keys($request->telephones ?? []);
            // Le decimos a la BD: Borra todos los teléfonos de este empleado que NO estén en esa lista
            $employee->telephones()->whereNotIn('id', $telefonosEnviados)->delete();

            // D) ACTUALIZAR los teléfonos viejos que se quedaron
            if ($request->has('telephones')) {
                foreach ($request->telephones as $id => $number) {
                    $employee->telephones()->where('id', $id)->update(['telephone' => $number]);
                }
            }

            // E) CREAR teléfonos nuevos
            if ($request->has('new_telephones')) {
                foreach ($request->new_telephones as $number) {
                    if (!empty($number)) {
                        $employee->telephones()->create(['telephone' => $number]);
                    }
                }
            }
        });

        return redirect()->route('employees.index')->with('success', '¡Ficha de empleado actualizada correctamente!');
    }
}
