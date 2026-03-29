<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ecosystem;

class EcosystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ecosystem::create([
            'name' => 'Empresa',
            'climate' => 'Fresco',
            'region' => 'España'
        ]);

        Ecosystem::create([
            'name' => 'Sabana Africana',
            'climate' => 'Árido/Seco',
            'region' => 'África'
        ]);

        Ecosystem::create([
            'name' => 'Jungla Tropical',
            'climate' => 'Húmedo',
            'region' => 'Amazonas'
        ]);
    }
}
