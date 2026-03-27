<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    //use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        /** De esta forma llamamos a los archivos externos y podemos introducir todos los Seeders aqui. */
        $this->call([
                // 1. ESTRUCTURA ESTÁTICA
            EcosystemSeeder::class,
            ZoneSeeder::class,
            ExperienceSeeder::class,

                // Seeder del Equipo Administrador (Beiroa, Alejandro, Gonzalo y Othman)
            CoreTeamSeeder::class,

                // 2. LUEGO LOS DATOS FALSOS QUE DEPENDEN DE ESA ESTRUCTURA
            EmployeeSeeder::class,
            EmployeeTelephoneSeeder::class,
            AnimalSeeder::class,
            SuppliersSeeder::class,
            ProductsSeeder::class,
        ]);
    }
}
