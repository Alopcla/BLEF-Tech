<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Zone;

class ZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Zonas de la Sabana (ecosystem_id = 1)
        Zone::create([
            'ecosystem_id' => 1,
            'type' => 'Terrestre',
            'dimensions_m2' => 5000,
            'description' => 'Gran planicie para felinos y herbívoros'
        ]);

        Zone::create([
            'ecosystem_id' => 1,
            'type' => 'Acuático',
            'dimensions_m2' => 2000,
            'description' => 'Charca principal para hipopótamos y cocodrilos'
        ]);

        // Zonas de la Jungla (ecosystem_id = 2)
        Zone::create([
            'ecosystem_id' => 2,
            'type' => 'Aviario',
            'dimensions_m2' => 3500,
            'description' => 'Cúpula cerrada para aves exóticas'
        ]);

        Zone::create([
            'ecosystem_id' => 2,
            'type' => 'Reptilario',
            'dimensions_m2' => 1500,
            'description' => 'Terrarios climatizados'
        ]);
    }
}
