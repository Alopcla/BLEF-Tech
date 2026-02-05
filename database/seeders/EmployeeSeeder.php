<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Ejecuta los seeds de la base de datos.
     */
    public function run(): void
    {
        /** Aqui crearemos el numero de empleados a introducir en la base de datos. */
        Employee::factory()->count(10)->create();
    }
}
