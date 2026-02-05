<?php

namespace Database\Seeders;

use App\Models\EmployeeTelephone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeTelephoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * @var mixed: De esta forma obtenemos todos los id's de los empleados.
         * Mediante pluck(), te trae especificamente una Collection de la columna asignada en el parametro.
         * En este caso puck() devuelve una coleccion con los ids de los empleados.
         */
        $employeeIds = \App\Models\Employee::pluck('id');

        /** Crearemos 15 telefonos, asignandose aleatoriamente a los IDs de los empleados.
         * Habra empleados que tenga 0, 1, 2 o 3 telefonos, debido al random().
         * fn() es denominado Arrow Function (Funcion flecha), por lo que es una funcion anonima.
         *
         */
        $employees = \App\Models\Employee::all();
        foreach ($employees as $employee) {
        // Creamos 3 teléfonos para cada empleado para asegurar que el incremento funcione
        for ($i = 0; $i < 3; $i++) {
            $telephone = new \App\Models\EmployeeTelephone();
            $telephone->employee_id = $employee->id;
            $telephone->number = fake()->phoneNumber();
            // Forzamos el cálculo aquí mismo si el evento falla
            $ultimo = \App\Models\EmployeeTelephone::where('employee_id', $employee->id)->max('order');
            $telephone->order = ($ultimo ?? 0) + 1;
            $telephone->save();
        }
    }

        /** EmployeeTelephone::factory()->count(15)->create([
         *   'employee_id' => fn() => $employeeIds->random()
         * ]);*/

    }
}
