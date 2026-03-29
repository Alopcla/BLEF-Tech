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
        // ==========================================
        // ECOSISTEMA 1: EMPRESA
        // ==========================================
        Zone::create([
            'ecosystem_id' => 1,
            'type' => 'Edificio',
            'dimensions_m2' => 100,
            'description' => 'Ubicación de la empresa de BLEF-Tech'
        ]);


        // ==========================================
        // ECOSISTEMA 1: SABANA
        // ==========================================

        // ZONA ID: 2
        Zone::create([
            'ecosystem_id' => 2,
            'type' => 'Terrestre',
            'dimensions_m2' => 5000,
            'description' => 'Gran planicie para felinos y herbívoros'
        ]);

        // ZONA ID: 2
        Zone::create([
            'ecosystem_id' => 2,
            'type' => 'Acuático',
            'dimensions_m2' => 2000,
            'description' => 'Charca principal para hipopótamos y cocodrilos'
        ]);

        // ==========================================
        // ECOSISTEMA 2: JUNGLA
        // ==========================================

        // ZONA ID: 3
        Zone::create([
            'ecosystem_id' => 3,
            'type' => 'Aviario',
            'dimensions_m2' => 3500,
            'description' => 'Cúpula cerrada para aves exóticas'
        ]);

        // ZONA ID: 4
        Zone::create([
            'ecosystem_id' => 3,
            'type' => 'Reptilario',
            'dimensions_m2' => 1500,
            'description' => 'Terrarios climatizados'
        ]);

        // ZONA ID: 5 (¡LA NUEVA!)
        Zone::create([
            'ecosystem_id' => 3,
            'type' => 'Trepadores y Terrestres',
            'dimensions_m2' => 4500,
            'description' => 'Zona de densa vegetación para primates y grandes felinos selváticos'
        ]);
    }
}
