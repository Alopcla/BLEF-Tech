<?php

namespace Database\Seeders;

use App\Models\Employee;
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

        /** Crearemos 15 telefonos, asignandose aleatoriamente a los IDs de los empleados.
         * Habra empleados que tenga 0, 1, 2 o 3 telefonos, debido al random().
         * fn() es denominado Arrow Function (Funcion flecha), por lo que es una funcion anonima.
         *
         */
        $employees = Employee::all();

        foreach ($employees as $employee) {
            // Creamos aleatoriamente de 0 a 1 teléfono para cada empleado para asegurar
            // que el incremento funcione

            $numeroDeTelefonos = rand(0, 1);

            EmployeeTelephone::factory($numeroDeTelefonos)->create([
                'employee_dni' => $employee->dni
            ]);
        }
    }
}
