<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CoreTeamSeeder extends Seeder
{
    /**
     * Run the database seeds. Datos del equipo principal del proyecto.
     * Con permisos de Administrador para la aplicacion.
     */
    public function run(): void
    {
        DB::transaction(function () {

            /*****************************************
             *      DATOS DE ALEJANDRO LOPEZ       *
             *****************************************/
            $user1 = User::create([
                'name' => 'Alejandro',
                'email' => 'alopcla297@g.educaand.es',
                'password' => Hash::make('12345678')
            ]);

            $emp1 = Employee::create([
                'dni' => '12345678A',
                'zone_id' => 1,
                'name' => 'Alejandro',
                'surname' => 'López Claro',
                'birth_date' => '1994-01-16',
                'email' => 'alopcla297@g.educaand.es',
                'address' => 'Sede Principal',
                'province' => 'Sevilla',
                'position' => 'Administrador',
            ]);

            $emp1->telephones()->create([
                'telephone' => '676767676'
            ]);

            /*****************************************
             *      DATOS DE ALEJANDRO BEIROA       *
             *****************************************/
            $user2 = User::create([
                'name' => 'Alejandro',
                'email' => 'abeiper042@g.educaand.es',
                'password' => Hash::make('12345678')
            ]);

            $emp2 = Employee::create([
                'dni' => '87654321B',
                'zone_id' => 1,
                'name' => 'Alejandro',
                'surname' => 'Beiroa Pérez',
                'birth_date' => '1992-03-30',
                'email' => 'abeiper042@g.educaand.es',
                'address' => 'Sede Principal',
                'province' => 'Sevilla',
                'position' => 'Administrador',
            ]);

            $emp2->telephones()->create([
                'telephone' => '121212121'
            ]);

            /*****************************************
             *      DATOS DE GONZALO FALCON      *
             *****************************************/
            $user3 = User::create([
                'name' => 'Gonzalo',
                'email' => 'gfalbas005@g.educaand.es',
                'password' => Hash::make('12345678')
            ]);

            $emp3 = Employee::create([
                'dni' => '01234567C',
                'zone_id' => 1,
                'name' => 'Gonzalo',
                'surname' => 'Falcón Bascón',
                'birth_date' => '2005-05-05',
                'email' => 'gfalbas005@g.educaand.es',
                'address' => 'Sede Principal',
                'province' => 'Sevilla',
                'position' => 'Administrador',
            ]);

            $emp3->telephones()->create([
                'telephone' => '696969696'
            ]);

            /*****************************************
             *      DATOS DE OTHMANE RASFI      *
             *****************************************/
            $user4 = User::create([
                'name' => 'Othmane',
                'email' => 'oraselq824@g.educaand.es',
                'password' => Hash::make('12345678')
            ]);

            $emp4 = Employee::create([
                'dni' => '7654321D',
                'zone_id' => 1,
                'name' => 'Othmane',
                'surname' => 'Rasfi el Qabiti',
                'birth_date' => '2005-01-01',
                'email' => 'oraselq824@g.educaand.es',
                'address' => 'Sede Principal',
                'province' => 'Sevilla',
                'position' => 'Administrador',
            ]);

            $emp4->telephones()->create([
                'telephone' => '012345678'
            ]);
        });
    }
}
