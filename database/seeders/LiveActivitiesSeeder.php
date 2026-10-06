<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\EducationalLevel;
use App\Models\Category;
use Illuminate\Support\Str;

class LiveActivitiesSeeder extends Seeder
{
    public function run(): void
    {
        $inicial = EducationalLevel::where('slug', 'nivel-inicial')->value('id');
        $primario = EducationalLevel::where('slug', 'nivel-primario')->value('id');
        $secundario = EducationalLevel::where('slug', 'nivel-secundario')->value('id');
        $militar = EducationalLevel::where('slug', 'educacion-militar')->value('id') ?? $secundario;
        $general = EducationalLevel::where('slug', 'general')->value('id') ?? 1;
        $actividades = Category::where('slug', 'actividades')->value('id') ?? 1;

        $noticias = [
            // NIVEL SECUNDARIO / CADETES
            [
                'title' => 'El LMGP presente en los "Interliceos 2026"',
                'level_id' => $secundario,
                'featured_image' => 'https://liceopaz.edu.ar/wp-content/uploads/2026/09/interliceos26_100.jpeg',
                'published_at' => '2026-09-10 10:00:00',
                'excerpt' => 'Entre los días 31 de agosto y 3 de septiembre de 2026, cadetes del Liceo participaron de los Juegos Deportivos y Culturales Interliceos 2026 en San Miguel de Tucumán.',
                'body' => '<p>Entre los días 31 de agosto y 3 de septiembre de 2026, cadetes del Liceo Militar General Paz participaron de los Juegos Deportivos y Culturales “Interliceos 2026”, realizados en el Liceo Militar General Aráoz de Lamadrid, en la ciudad de San Miguel de Tucumán.</p><p>El encuentro reunió a delegaciones de los Liceos Militares, Naval y Aeronáutico de todo el país, quienes participaron en diversas disciplinas deportivas y culturales, en un marco signado por el honor deportivo, el respeto y la camaradería.</p>',
            ],
            // GENERAL / INSPECTORÍA
            [
                'title' => 'Inspectoría General del Ejército en el LMGP',
                'level_id' => $general,
                'featured_image' => 'https://liceopaz.edu.ar/wp-content/uploads/2026/09/ige26_portada.jpg',
                'published_at' => '2026-09-10 09:00:00',
                'excerpt' => 'Entre los días 24 de agosto y 4 de septiembre de 2026, el Instituto fue inspeccionado por la Inspectoría General del Ejército para supervisar directivas y procedimientos.',
                'body' => '<p>Entre los días 24 de agosto y 4 de septiembre de 2026, el Instituto fue inspeccionado por la Inspectoría General del Ejército, con el propósito de supervisar y verificar el cumplimiento de las órdenes, directivas y procedimientos vigentes.</p><p>La actividad contó con la participación del IGE, General de Brigada Pablo Francisco Depalo, y del Inspector del Arma de Artillería, Coronel José Carlos Taffarel.</p>',
            ],
            // GENERAL / ANIVERSARIO INSTITUCIONAL
            [
                'title' => 'Celebración del 82º Aniversario del Liceo Militar "GENERAL PAZ"',
                'level_id' => $general,
                'featured_image' => 'https://liceopaz.edu.ar/wp-content/uploads/2026/09/ige26_portada.jpg',
                'published_at' => '2026-09-01 08:00:00',
                'excerpt' => 'El pasado 25 de agosto, el Liceo Militar General Paz celebró 82 años de vida institucional al servicio de la educación y de la Patria.',
                'body' => '<p>El pasado 25 de agosto, el Liceo Militar “GENERAL PAZ” celebró 82 años de vida institucional formando ciudadanos y líderes comprometidos con la República, con la presencia de directivos, docentes, cadetes y familias.</p>',
            ],
            // NIVEL INICIAL
            [
                'title' => '30° Aniversario del Nivel Inicial "Semillitas del Paz"',
                'level_id' => $inicial,
                'featured_image' => null,
                'published_at' => '2026-08-31 09:00:00',
                'excerpt' => 'El jardín del Liceo Militar General Paz celebró con gran orgullo y alegría sus 30 años de labor pedagógica y comunitaria.',
                'body' => '<p>Celebramos con gran alegría y orgullo el 30° aniversario del Nivel Inicial “Semillitas del Paz”, compartiendo actividades lúdicas, formativas y recreativas junto a nuestros pequeños alumnos y sus familias.</p>',
            ],
            // NIVEL PRIMARIO
            [
                'title' => 'Promesa de Fidelidad a la Bandera Nacional por los alumnos de 4to Grado',
                'level_id' => $primario,
                'featured_image' => null,
                'published_at' => '2026-06-20 11:00:00',
                'excerpt' => 'Alumnos de 4to Grado del Nivel Primario realizaron su emotiva Promesa de Fidelidad a la Bandera Nacional en la Plaza de Armas del Instituto.',
                'body' => '<p>En una solemne ceremonia realizada en la Plaza de Armas del Instituto, los alumnos de 4to Grado del Nivel Primario realizaron su Promesa de Fidelidad a la Bandera Nacional, acompañados por sus docentes y familiares en una jornada inolvidable.</p>',
            ],
            // CUERPO DE CADETES / MILITAR
            [
                'title' => 'Semana Operacional del Cuerpo de Cadetes – 2da Etapa',
                'level_id' => $militar,
                'featured_image' => null,
                'published_at' => '2026-08-19 10:00:00',
                'excerpt' => 'Los Cadetes del Liceo Militar General Paz completaron con éxito las ejercitaciones en el terreno de la segunda etapa operacional.',
                'body' => '<p>Los Cadetes del Liceo Militar General Paz desarrollaron con éxito las actividades de instrucción en el terreno correspondientes a la 2da Etapa de la Semana Operacional, fortaleciendo el espíritu de cuerpo y las destrezas de Artillería.</p>',
            ],
        ];

        foreach ($noticias as $noticia) {
            Post::updateOrCreate(
                ['slug' => Str::slug($noticia['title'])],
                [
                    'user_id' => 1,
                    'educational_level_id' => $noticia['level_id'],
                    'category_id' => $actividades,
                    'title' => $noticia['title'],
                    'excerpt' => $noticia['excerpt'],
                    'body' => $noticia['body'],
                    'featured_image' => $noticia['featured_image'],
                    'is_published' => true,
                    'published_at' => $noticia['published_at'],
                ]
            );
        }
    }
}