<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Experience;
use Illuminate\Support\Str;

class ExperienceSeeder extends Seeder
{
    public function run(): void
    {
        $experiences = [
            // ==========================================
            // ZONA 1: SABANA PLANICIE (ID: 1)
            // ==========================================
            [
                'zone_id' => 1,
                'name' => 'Safari de León',
                'slug' => Str::slug('Safari de León'),
                'description' => 'Recorrido guiado para observar leones en su hábitat natural.',
                'details' => 'Embárcate en una expedición única por la llanura africana. Acompañado por nuestros expertos cuidadores, viajarás en un vehículo acondicionado para observar de cerca a nuestra manada de leones. Aprenderás sobre sus técnicas de caza, la jerarquía social del grupo y los proyectos de conservación en los que participamos para proteger a esta especie vulnerable en libertad.',
                'duration_min' => 60,
                'price' => 25.50,
                'ability' => 20,
                'image' => 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=500'
            ],
            [
                'zone_id' => 1,
                'name' => 'Encuentro con Elefantes',
                'slug' => Str::slug('Encuentro con Elefantes'),
                'description' => 'Alimenta y aprende sobre elefantes asiáticos.',
                'details' => 'Una experiencia conmovedora donde podrás conocer la inteligencia y sensibilidad de los gigantes de Asia. Durante este encuentro, participarás en una sesión de alimentación dirigida y conocerás la historia de cada ejemplar. Nuestros biólogos te explicarán cómo realizamos sus chequeos veterinarios diarios y la importancia de los santuarios en la preservación del elefante asiático.',
                'duration_min' => 45,
                'price' => 30.00,
                'ability' => 15,
                'image' => 'https://images.unsplash.com/photo-1557050543-4d5f4e07ef46?w=500'
            ],
            [
                'zone_id' => 1,
                'name' => 'Paseo de Jirafas',
                'slug' => Str::slug('Paseo de Jirafas'),
                'description' => 'Caminata cercana con jirafas y explicación educativa.',
                'details' => 'Camina por las pasarelas elevadas diseñadas para encontrarte cara a cara con los animales más altos del mundo. En esta actividad, tendrás la oportunidad de ofrecerles sus ramas favoritas y observar su curiosa lengua prensil. Es el momento perfecto para descubrir curiosidades sobre su sistema circulatorio único y cómo duermen de pie en la naturaleza.',
                'duration_min' => 50,
                'price' => 20.00,
                'ability' => 10,
                'image' => 'https://images.unsplash.com/photo-1577114995803-d8ce0e2b4aa9?w=500'
            ],

            // ==========================================
            // ZONA 2: SABANA ACUÁTICA (ID: 2)
            // ==========================================
            [
                'zone_id' => 2,
                'name' => 'Charca de Hipopótamos',
                'slug' => Str::slug('Charca de Hipopótamos'),
                'description' => 'Observa hipopótamos y cocodrilos en la gran charca.',
                'details' => 'Explora los misterios de los ecosistemas fluviales de África. Desde nuestra zona de visión subacuática, verás la sorprendente agilidad de los hipopótamos bajo el agua y la paciencia de los cocodrilos del Nilo. La charla incluye detalles fascinantes sobre la coexistencia de estos depredadores y su papel vital en la fertilización de los ríos africanos.',
                'duration_min' => 40,
                'price' => 18.00,
                'ability' => 25,
                'image' => 'https://images.unsplash.com/photo-1604454112929-42dedc7c8424?w=500'
            ],
            [
                'zone_id' => 2,
                'name' => 'Vuelo de Flamencos',
                'slug' => Str::slug('Vuelo de Flamencos'),
                'description' => 'Camina entre flamencos y aprende sobre su comportamiento.',
                'details' => 'Sumérgete en un mar de color rosa. En esta experiencia interactiva, cruzarás el humedal de los flamencos mientras nuestro personal explica el origen de su coloración y sus curiosos rituales de cortejo. Es una actividad ideal para fotógrafos y amantes de la ornitología que buscan una perspectiva cercana y sin barreras visuales.',
                'duration_min' => 30,
                'price' => 15.00,
                'ability' => 30,
                'image' => 'https://images.unsplash.com/photo-1497206365907-f5e630693df0?w=500'
            ],

            // ==========================================
            // ZONA 3: JUNGLA AVIARIO Y TREPADORES (ID: 3)
            // ==========================================
            [
                'zone_id' => 3,
                'name' => 'Aventura con Primates',
                'slug' => Str::slug('Aventura con Primates'),
                'description' => 'Explora el aviario y zona de primates con guía especializada.',
                'details' => 'Descubre la increíble biodiversidad de las selvas tropicales. Esta ruta guiada te llevará por las instalaciones de lémures y chimpancés, donde observarás su complejo lenguaje corporal y sus habilidades para resolver acertijos. Aprenderás sobre las amenazas de la deforestación y cómo el zoo trabaja para reintroducir especies en peligro en sus selvas de origen.',
                'duration_min' => 60,
                'price' => 28.00,
                'ability' => 12,
                'image' => 'https://images.unsplash.com/photo-1742729322173-19b4ed114ac2?w=500'
            ],
            [
                'zone_id' => 3,
                'name' => 'Tucanes y Guacamayos',
                'slug' => Str::slug('Tucanes y Guacamayos'),
                'description' => 'Aprende sobre aves exóticas y su alimentación.',
                'details' => 'Entra en nuestro aviario de vuelo libre donde el cielo se llena de colores vibrantes. Verás de cerca el vuelo de los guacamayos y el peculiar pico de los tucanes mientras participan en sus sesiones de enriquecimiento. Los guías te enseñarán a identificar las distintas llamadas de las aves y la importancia de las semillas en la regeneración de los bosques tropicales.',
                'duration_min' => 45,
                'price' => 22.00,
                'ability' => 15,
                'image' => 'https://images.unsplash.com/photo-1549480662-8e10080644dd?w=500'
            ],

            // ==========================================
            // ZONA 4: JUNGLA REPTILARIO (ID: 4)
            // ==========================================
            [
                'zone_id' => 4,
                'name' => 'Reptiles del Mundo',
                'slug' => Str::slug('Reptiles del Mundo'),
                'description' => 'Explora serpientes, iguanas y dragones de Komodo.',
                'details' => 'Un viaje al mundo de la sangre fría. Esta experiencia te permite conocer de cerca a los reptiles más impresionantes, desde la majestuosidad de la pitón hasta la imponente presencia del dragón de Komodo. Desmentiremos mitos comunes sobre estos animales y descubriremos su asombrosa capacidad de adaptación y supervivencia en condiciones extremas.',
                'duration_min' => 50,
                'price' => 24.00,
                'ability' => 20,
                'image' => 'https://images.unsplash.com/photo-1563234979-58ec78995a97?w=500'
            ],
            [
                'zone_id' => 4,
                'name' => 'Anfibios y Serpientes',
                'slug' => Str::slug('Anfibios y Serpientes'),
                'description' => 'Muestra educativa sobre ranas venenosas y víboras.',
                'details' => 'Aprende sobre el fascinante mundo de los pequeños pero peligrosos. En nuestro laboratorio de anfibios, verás ranas de colores brillantes que ocultan potentes toxinas y serpientes venenosas de todo el mundo. Te explicaremos cómo se extrae el veneno para fines médicos y por qué los anfibios son los mejores indicadores de la salud ambiental de nuestro planeta.',
                'duration_min' => 35,
                'price' => 18.50,
                'ability' => 25,
                'image' => 'https://images.unsplash.com/photo-1579895240409-f1fb525f0a71?w=500'
            ]
        ];

        foreach ($experiences as $experience) {
            Experience::create($experience);
        }
    }
}