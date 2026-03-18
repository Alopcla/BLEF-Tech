<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SuppliersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('suppliers')->truncate();

        $now = Carbon::now();

        $suppliers = [
            // 🧸 Merchandising y Ropa
            [
                'namespace'  => 'Zoologic Merch S.L.',
                'address'    => 'Calle Safari, 12',
                'province'   => 'Madrid',
                'country'    => 'España',
                'email'      => 'merch@zoologic.es',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'namespace'  => 'TextilNature S.A.',
                'address'    => 'Avenida de la Fauna, 34',
                'province'   => 'Barcelona',
                'country'    => 'España',
                'email'      => 'ventas@textilnature.es',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'namespace'  => 'Safari Kids Fashion',
                'address'    => 'Calle Selva, 7',
                'province'   => 'Valencia',
                'country'    => 'España',
                'email'      => 'info@safarikids.es',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // 🍦 Alimentación y Bebidas
            [
                'namespace'  => 'Wild Foods S.A.',
                'address'    => 'Avenida Jungla, 45',
                'province'   => 'Sevilla',
                'country'    => 'España',
                'email'      => 'ventas@wildfoods.es',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'namespace'  => 'NaturSnack S.L.',
                'address'    => 'Polígono Industrial Los Pinos, Nave 3',
                'province'   => 'Zaragoza',
                'country'    => 'España',
                'email'      => 'pedidos@natursnack.es',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'namespace'  => 'FrescoBebidas S.L.',
                'address'    => 'Calle Palmera, 19',
                'province'   => 'Málaga',
                'country'    => 'España',
                'email'      => 'contacto@frescobebidas.es',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // 📚 Educativos y Libros
            [
                'namespace'  => 'EduNature Editorial S.L.',
                'address'    => 'Plaza Ecosistema, 3',
                'province'   => 'Sevilla',
                'country'    => 'España',
                'email'      => 'info@edunature.es',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'namespace'  => 'JuegoSabio S.A.',
                'address'    => 'Calle Enseñanza, 88',
                'province'   => 'Bilbao',
                'country'    => 'España',
                'email'      => 'ventas@juegosabio.es',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // 🏺 Souvenirs
            [
                'namespace'  => 'RecuerdoZoo S.L.',
                'address'    => 'Calle Colección, 5',
                'province'   => 'Toledo',
                'country'    => 'España',
                'email'      => 'pedidos@recuerdozoo.es',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'namespace'  => 'Artesanía Fauna S.A.',
                'address'    => 'Calle Artesanos, 22',
                'province'   => 'Granada',
                'country'    => 'España',
                'email'      => 'contacto@artesaniafauna.es',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // 🎨 Actividades y Óptica
            [
                'namespace'  => 'ÓpticaNatura S.L.',
                'address'    => 'Avenida Observatorio, 14',
                'province'   => 'Pamplona',
                'country'    => 'España',
                'email'      => 'info@opticanatura.es',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'namespace'  => 'CreActiva Kids S.A.',
                'address'    => 'Calle Pincel, 9',
                'province'   => 'Murcia',
                'country'    => 'España',
                'email'      => 'ventas@creactivakids.es',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('suppliers')->insert($suppliers);
    }
}