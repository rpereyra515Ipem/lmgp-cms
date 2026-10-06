<?php

namespace Database\Seeders;

use App\Models\EducationalLevel;
use Illuminate\Database\Seeder;

class EducationalLevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            ['name' => 'Nivel Inicial "Semillitas del Paz"', 'slug' => 'nivel-inicial', 'description' => 'Salas de 4 y 5 años con formación integral en valores.', 'sort_order' => 1],
            ['name' => 'Nivel Primario', 'slug' => 'nivel-primario', 'description' => '1ro a 6to grado con énfasis en ciencias, arte, deporte e inglés.', 'sort_order' => 2],
            ['name' => 'Nivel Secundario', 'slug' => 'nivel-secundario', 'description' => 'Bachillerato en Ciencias Naturales y Economía y Gestión de las Organizaciones.', 'sort_order' => 3],
            ['name' => 'Educación Militar', 'slug' => 'educacion-militar', 'description' => 'Cuerpo de Cadetes, instrucción básica militar y egreso como Subteniente de Reserva.', 'sort_order' => 4],
            ['name' => 'Comunidad y General', 'slug' => 'general', 'description' => 'Comunicados institucionales dirigidos a toda la comunidad educativa y familias.', 'sort_order' => 5],
        ];

        foreach ($levels as $level) {
            EducationalLevel::updateOrCreate(['slug' => $level['slug']], $level);
        }
    }
}