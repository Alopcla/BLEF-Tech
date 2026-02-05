<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /** En esta clase (Controlador), se leera los datos reales
     * para que se envie a los Componentes.
     */
    public function index() {
        // Recuperamos todos los empleados de la BD
        $employees = Employee::with('telephones')->get();

        // Enviamos los datos a la vista 'employees' que creamos antes
        return view('employees', compact('employees'));
    }

    public function store(Request $request) {
        // Validacion para que el nombre sea obligatorio
        $request->validate([
            'DNI' => 'required|unique:employees,DNI',
            'name' => 'required|max:255',
            'surname' => 'required',
            'email' => 'required|email|unique:employees,email',
            'birth_date' => 'required|date',
            'address' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'number' => 'required|string',

        ]);

        // Creamos al empleado con todos los campos del formulario
        $employee = Employee::create([
            'DNI' => $request->DNI,
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'province' => $request->province
        ]);

        /**  Aqui se asigna el numero de telefono junto al order automatico.
        * Se debe al Model Event que se creo en el Modelo EmployeeTelephone
        * y a su vez se implemento en el Modelo Employee */
        $employee->telephones()->create([
            'number' => $request->number
        ]);

        return back()->with('success', 'Empleado registrado correctamente!');
    }
}
