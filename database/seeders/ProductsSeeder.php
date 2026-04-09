<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->truncate();

        $now = Carbon::now();

        $supplierId = DB::table('suppliers')->value('id') ?? 1;

        $products = [
            // PELUCHES
            ['supplier_id' => $supplierId, 'name' => 'Peluche León',           'description' => 'Peluche suave del rey de la sabana, 30 cm. Ideal para niños.',                  'price' => 14.99, 'stock' => 80,  'category' => 'Peluches', 'image' => '/img/productos/peluche_leon.png',             'spline_url' => null, 'order_date' => '2025-01-10', 'created_at' => $now, 'updated_at' => $now],
            ['supplier_id' => $supplierId, 'name' => 'Peluche Jirafa',         'description' => 'Peluche de jirafa con cuello largo, 40 cm. Material antialérgico.',             'price' => 16.99, 'stock' => 65,  'category' => 'Peluches', 'image' => '/img/productos/peluche_jirafa.png',           'spline_url' => null, 'order_date' => '2025-01-10', 'created_at' => $now, 'updated_at' => $now],
            ['supplier_id' => $supplierId, 'name' => 'Peluche Elefante',       'description' => 'Peluche gigante de elefante africano, 50 cm. Edición especial Zoologico.',       'price' => 19.99, 'stock' => 50,  'category' => 'Peluches', 'image' => '/img/productos/peluche_elefante.png',         'spline_url' => null, 'order_date' => '2025-01-15', 'created_at' => $now, 'updated_at' => $now],
            ['supplier_id' => $supplierId, 'name' => 'Peluche Pingüino',       'description' => 'Peluche de pingüino con bufanda del zoo, 25 cm.',                                'price' => 12.99, 'stock' => 90,  'category' => 'Peluches', 'image' => '/img/productos/peluche_pinguino.png',         'spline_url' => null, 'order_date' => '2025-01-15', 'created_at' => $now, 'updated_at' => $now],
            ['supplier_id' => $supplierId, 'name' => 'Peluche Oso Panda',      'description' => 'Peluche de oso panda en bambú, 35 cm. Perfecto como recuerdo.',                  'price' => 17.99, 'stock' => 70,  'category' => 'Peluches', 'image' => '/img/productos/peluche_osopanda.png',         'spline_url' => null, 'order_date' => '2025-01-20', 'created_at' => $now, 'updated_at' => $now],
            ['supplier_id' => $supplierId, 'name' => 'Peluche Cocodrilo',      'description' => 'Peluche de cocodrilo articulado, 45 cm. Boca que se abre y cierra.',             'price' => 15.99, 'stock' => 40,  'category' => 'Peluches', 'image' => '/img/productos/peluche_cocodrilo.png',        'spline_url' => null, 'order_date' => '2025-01-20', 'created_at' => $now, 'updated_at' => $now],
            ['supplier_id' => $supplierId, 'name' => 'Set Animales Miniatura', 'description' => 'Colección de 12 figuras de animales de plástico resistente. Educativo.',         'price' =>  9.99, 'stock' => 120, 'category' => 'Peluches', 'image' => '/img/productos/coleccion_animales.png',       'spline_url' => null, 'order_date' => '2025-01-25', 'created_at' => $now, 'updated_at' => $now],

            // ROPA
            ['supplier_id' => $supplierId, 'name' => 'Camiseta Zoologico Niño',   'description' => 'Camiseta 100% algodón con logo de Zoologico y animales. Tallas 2-12 años.',   'price' => 12.99, 'stock' => 100, 'category' => 'Ropa', 'image' => '/img/productos/camiseta_ninio.png',           'spline_url' => null, 'order_date' => '2025-02-01', 'created_at' => $now, 'updated_at' => $now],
            ['supplier_id' => $supplierId, 'name' => 'Camiseta Zoologico Adulto', 'description' => 'Camiseta 100% algodón con diseño de animales salvajes. Tallas S-XXL.',        'price' => 15.99, 'stock' => 100, 'category' => 'Ropa', 'image' => '/img/productos/camiseta_hombre_adulto.png',   'spline_url' => 'https://prod.spline.design/EsYGvTc8LJHw2crp/scene.splinecode', 'order_date' => '2025-02-01', 'created_at' => $now, 'updated_at' => $now],
            ['supplier_id' => $supplierId, 'name' => 'Sudadera Zoologico',        'description' => 'Sudadera con capucha y estampado de logo.',                                   'price' => 29.99, 'stock' => 50,  'category' => 'Ropa', 'image' => '/img/productos/sudadera_zoo.png',             'spline_url' => 'https://prod.spline.design/kaoHCpNUIJHNTCw1/scene.splinecode', 'order_date' => '2025-02-05', 'created_at' => $now, 'updated_at' => $now],
            ['supplier_id' => $supplierId, 'name' => 'Gorra Zoologico',           'description' => 'Gorra ajustable con bordado del logo del zoo. Protección UV50+.',             'price' => 10.99, 'stock' => 75,  'category' => 'Ropa', 'image' => '/img/productos/gorra_zoo.png',                'spline_url' => 'https://prod.spline.design/XN5dHwoZps1w6TFd/scene.splinecode', 'order_date' => '2025-02-05', 'created_at' => $now, 'updated_at' => $now],
            ['supplier_id' => $supplierId, 'name' => 'Mochila Zoologico',         'description' => 'Mochila infantil con forma de koala, 10L. Correas acolchadas.',               'price' => 22.99, 'stock' => 45,  'category' => 'Ropa', 'image' => '/img/productos/mochila_koala.png',            'spline_url' => null, 'order_date' => '2025-02-10', 'created_at' => $now, 'updated_at' => $now],
            ['supplier_id' => $supplierId, 'name' => 'Paraguas Animales',         'description' => 'Paraguas automático con estampado de animales. Diámetro 100 cm.',             'price' => 14.99, 'stock' => 35,  'category' => 'Ropa', 'image' => '/img/productos/paraguas_zoo.png',             'spline_url' => null, 'order_date' => '2025-02-10', 'created_at' => $now, 'updated_at' => $now],

            // LIBROS
            ['supplier_id' => $supplierId, 'name' => 'Libro Animales del Mundo', 'description' => 'Enciclopedia ilustrada de 200 páginas sobre fauna mundial. Para todas las edades.', 'price' => 18.99, 'stock' => 40, 'category' => 'Libros', 'image' => '/img/productos/libro_animales.png', 'spline_url' => null, 'order_date' => '2025-02-15', 'created_at' => $now, 'updated_at' => $now],
            ['supplier_id' => $supplierId, 'name' => 'Guía Interactiva del Zoo', 'description' => 'Guía oficial del Zoologico con mapa, datos y curiosidades de cada animal. A4.',      'price' =>  7.99, 'stock' => 90, 'category' => 'Libros', 'image' => '/img/productos/guia_mapa.png',      'spline_url' => null, 'order_date' => '2025-02-15', 'created_at' => $now, 'updated_at' => $now],
            
            // JUGUETES 
            ['supplier_id' => $supplierId, 'name' => 'Puzzle Sabana 500 pz',     'description' => 'Puzzle de 500 piezas con panorámica de la sabana africana. 60x40 cm.',               'price' => 13.99, 'stock' => 55, 'category' => 'Juguetes', 'image' => '/img/productos/puzzle_sabana.png',  'spline_url' => null, 'order_date' => '2025-02-20', 'created_at' => $now, 'updated_at' => $now],
            ['supplier_id' => $supplierId, 'name' => 'Puzzle Océano 1000 pz',    'description' => 'Puzzle de 1000 piezas con fondo marino lleno de vida. 70x50 cm.',                    'price' => 17.99, 'stock' => 30, 'category' => 'Juguetes', 'image' => '/img/productos/puzzle_oceano.png',  'spline_url' => null, 'order_date' => '2025-02-20', 'created_at' => $now, 'updated_at' => $now],
            ['supplier_id' => $supplierId, 'name' => 'Cartas Educativas Fauna',  'description' => 'Baraja de 54 cartas con datos y fotografías de animales. +6 años.',                  'price' =>  8.99, 'stock' => 85, 'category' => 'Juguetes', 'image' => '/img/productos/baraja_cartas.png',  'spline_url' => null, 'order_date' => '2025-02-25', 'created_at' => $now, 'updated_at' => $now],
            ['supplier_id' => $supplierId, 'name' => 'Telescopio Infantil',      'description' => 'Telescopio para niños x40 aumento. Ideal para observar animales. Con trípode.',      'price' => 34.99, 'stock' => 20, 'category' => 'Juguetes', 'image' => '/img/productos/telescopio_infantil.png',  'spline_url' => null, 'order_date' => '2025-02-25', 'created_at' => $now, 'updated_at' => $now],

            // ACCESORIOS
            ['supplier_id' => $supplierId, 'name' => 'Llavero Animal 3D',       'description' => 'Llavero de resina con figura 3D de animal a elegir. Resistente y ligero.',    'price' =>  4.99, 'stock' => 200, 'category' => 'Accesorios', 'image' => '/img/productos/llavero_zoo.png', 'spline_url' => null, 'order_date' => '2025-01-05', 'created_at' => $now, 'updated_at' => $now],
            ['supplier_id' => $supplierId, 'name' => 'Imán Nevera Zoologico',   'description' => 'Imán decorativo con diseño del zoo. Perfecto como recuerdo. 6x8 cm.',         'price' =>  3.99, 'stock' => 250, 'category' => 'Accesorios', 'image' => '/img/productos/iman_zoo.png', 'spline_url' => null, 'order_date' => '2025-01-05', 'created_at' => $now, 'updated_at' => $now],
            ['supplier_id' => $supplierId, 'name' => 'Taza Zoologico',          'description' => 'Taza de cerámica de 350ml con animales del zoo. Apta para lavavajillas.',     'price' => 11.99, 'stock' => 70,  'category' => 'Accesorios', 'image' => '/img/productos/taza_zoo.png', 'spline_url' => null, 'order_date' => '2025-01-08', 'created_at' => $now, 'updated_at' => $now],
            ['supplier_id' => $supplierId, 'name' => 'Bolsa Tela Reutilizable', 'description' => 'Bolsa de tela orgánica con ilustración de animales. Resistente. 38x42 cm.',   'price' =>  6.99, 'stock' => 110, 'category' => 'Accesorios', 'image' => '/img/productos/bolsa_tela.png', 'spline_url' => null, 'order_date' => '2025-01-08', 'created_at' => $now, 'updated_at' => $now],
            ['supplier_id' => $supplierId, 'name' => 'Postal Fotográfica',      'description' => 'Set de 6 postales fotográficas de los animales del zoo. Papel mate premium.', 'price' =>  4.50, 'stock' => 180, 'category' => 'Accesorios', 'image' => '/img/productos/postal_fotos.png', 'spline_url' => null, 'order_date' => '2025-01-12', 'created_at' => $now, 'updated_at' => $now],
            ['supplier_id' => $supplierId, 'name' => 'Marco de Fotos Zoo',      'description' => 'Marco de madera natural con grabado de Zoologico. Para foto 10x15 cm.',       'price' =>  9.99, 'stock' => 55,  'category' => 'Accesorios', 'image' => '/img/productos/marco_foto.png', 'spline_url' => null, 'order_date' => '2025-01-12', 'created_at' => $now, 'updated_at' => $now],
            ['supplier_id' => $supplierId, 'name' => 'Pin Coleccionable',       'description' => 'Pin esmaltado de animales del zoo. Edición coleccionable limitada.',          'price' =>  5.99, 'stock' => 160, 'category' => 'Accesorios', 'image' => '/img/productos/pin_coleccionable.png', 'spline_url' => null, 'order_date' => '2025-01-18', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('products')->insert($products);
    }
}