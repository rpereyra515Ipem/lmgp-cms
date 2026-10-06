<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Comunicados Oficiales', 'slug' => 'comunicados-oficiales', 'description' => 'Circulares y avisos oficiales de Dirección y Regencia.'],
            ['name' => 'Mesas de Examen y Cronogramas', 'slug' => 'mesas-de-examen', 'description' => 'Fechas, tribunales examinadores y cronogramas de evaluación.'],
            ['name' => 'Aranceles y Administración', 'slug' => 'aranceles', 'description' => 'Información sobre cuotas, matrículas y cierre financiero institucional.'],
            ['name' => 'Admisiones e Inscripciones', 'slug' => 'admisiones', 'description' => 'Requisitos, convocatorias de ingreso y formularios para aspirantes.'],
            ['name' => 'Actividades y Novedades', 'slug' => 'actividades', 'description' => 'Eventos pedagógicos, actos patrios, competencias y salidas de campo.'],
            ['name' => 'Reglamentos y Normativas', 'slug' => 'reglamentos', 'description' => 'Régimen de convivencia, reglamento de liceos militares y PEI.'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}