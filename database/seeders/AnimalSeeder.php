<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Animal;

class AnimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Array donde contendra los datos (que queramos) de los animales.
     */
    public function run(): void
    {
        $animals = [
            [
                'species' => 'León (Panthera leo)',
                'location' => 'África subsahariana (Tanzania, Kenia, Sudáfrica).',
                'curiosity' => 'Su impresionante rugido puede escucharse hasta 9 kilómetros de distancia para marcar territorio.',
                'imagen' => 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=500'
            ],
            [
                'species' => 'Elefante asiático (Elephas maximus)',
                'location' => 'India, Sri Lanka, Bangladés y Sumatra.',
                'curiosity' => 'Son capaces de sentir emociones profundas y reconocerse en espejos, demostrando autoconciencia.',
                'imagen' => 'https://images.unsplash.com/photo-1557050543-4d5f4e07ef46?w=500'
            ],
            [
                'species' => 'Cocodrilo (Crocodylidae)',
                'location' => 'Regiones tropicales y subtropicales de África, América, Asia y Australia.',
                'curiosity' => '¿Sabías lo que es capaz de su mordida? Su mordida contiene 3.500 kg de presión. Lo que equivale a ¡¡27 veces la fuerza humana!!.',
                'imagen' => 'https://images.unsplash.com/photo-1595433409683-943ded8e7b1d?q=80&w=1061&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
            ],
            [
                'species' => 'Chimpancé (Pan troglodytes)',
                'location' => 'África central y occidental (Senegal, Uganda y Tanzania).',
                'curiosity' => 'Son nuestros parientes no humanos más cercanos. ¡Comparten el 98% de nuestro ADN!.',
                'imagen' => 'https://images.unsplash.com/photo-1742729322173-19b4ed114ac2?q=80&w=386&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
            ],
            [
                'species' => 'Jirafa (Giraffa camelopardalis)',
                'location' => 'Sabanas, pastizales y bosques abiertos del África subsahariana.',
                'curiosity' => 'Tienen una lengua azul oscuro de 50 cm la cual pueden comer espinas sin dañarse.',
                'imagen' => 'https://images.unsplash.com/photo-1577114995803-d8ce0e2b4aa9?q=80&w=873&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
            ],
            [
                'species' => 'Hipopótamo (Hippopotamus amphibius)',
                'location' => 'Ríos, lagos y pantanos del África subsahariana (Río Nilo)',
                'curiosity' => 'Segregan un líquido misterioso de color rojo...¿Para qué sirve? Con ello, que es una secreción natural, se protege del sol y de infecciones bacterianas.',
                'imagen' => 'https://images.unsplash.com/photo-1604454112929-42dedc7c8424?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
            ],
            [
                'species' => 'Víbora (Viperinae)',
                'location' => 'Climas cálidos y templados en África, Eurasia y América.',
                'curiosity' => 'Su olfato es... ¡LA LENGUA! Usan su lengua bífida para recolectar partículas del aire y llevarlas al Órgano de Jacobson en el paladar, permitiéndoles "oler".',
                'imagen' => 'https://images.unsplash.com/photo-1605051538177-72c289389de5?q=80&w=802&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
            ],
            [
                'species' => 'Mono capuchino (Cebus)',
                'location' => 'Bosques tropicales, subtropicales y sabanas de Centro y Sudámerica.',
                'curiosity' => 'Utiliza su cola como quinta mano, ayudándose para columpiarse y desplazarse. Y lo mejor de todo es que ellos también se echan sus siestas... ¿No te recuerda a una raza parecida que haga lo mismo?.',
                'imagen' => 'https://images.unsplash.com/photo-1721329501836-5e7e2d055f64?q=80&w=641&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
            ],
        ];

        // Recorremos el array para introducirlo en la base de datos
        foreach ($animals as $animal) {
            Animal::create($animal);
        }
    }
}
