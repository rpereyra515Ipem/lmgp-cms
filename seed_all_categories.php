<?php

use App\Models\Category;
use App\Models\EducationalLevel;
use App\Models\Post;
use App\Models\User;
use App\Models\Attachment;

$user = User::first();
$secundario = EducationalLevel::where('slug', 'nivel-secundario')->first();
$militar = EducationalLevel::where('slug', 'educacion-militar')->first();
$primario = EducationalLevel::where('slug', 'nivel-primario')->first();
$general = EducationalLevel::where('slug', 'general')->first();

$catMesas = Category::where('slug', 'mesas-de-examen')->first();
$catComunicados = Category::where('slug', 'comunicados-oficiales')->first();
$catAranceles = Category::where('slug', 'aranceles')->first();
$catAdmisiones = Category::where('slug', 'admisiones')->first();
$catActividades = Category::where('slug', 'actividades')->first();
$catReglamentos = Category::where('slug', 'reglamentos')->first();

// 1. Mesas de Examen
if ($catMesas) {
    $p = Post::updateOrCreate(
        ['slug' => 'cronograma-mesas-de-examen-noviembre'],
        [
            'user_id' => $user->id,
            'category_id' => $catMesas->id,
            'educational_level_id' => $secundario->id,
            'title' => 'Cronograma Oficial de Mesas de Examen - Período Noviembre',
            'excerpt' => 'Regencia de Estudios publica los días, horarios y tribunales examinadores para alumnos con materias previas y libres del Nivel Secundario.',
            'body' => "Se informa a la comunidad educativa y a los cadetes del Nivel Secundario que se encuentran fijadas las fechas correspondientes al turno de exámenes de noviembre.\n\nLos exámenes se llevarán a cabo en las instalaciones del Instituto en los horarios detallados en la documentación adjunta. Es requisito presentarse con uniforme reglamentario y libreta de calificaciones.",
            'is_published' => true,
            'published_at' => now()->subDays(1),
            'is_pinned' => true
        ]
    );

    Attachment::updateOrCreate(
        ['post_id' => $p->id, 'title' => 'Cronograma_Mesas_Examen_Noviembre_2026.pdf'],
        [
            'file_path' => 'documents/cronograma_noviembre_2026.pdf',
            'file_size' => 245760,
            'mime_type' => 'pdf',
            'download_count' => 28
        ]
    );
}

// 2. Comunicados Oficiales
if ($catComunicados) {
    Post::updateOrCreate(
        ['slug' => 'comunicado-oficial-cierre-trimestre'],
        [
            'user_id' => $user->id,
            'category_id' => $catComunicados->id,
            'educational_level_id' => $general->id,
            'title' => 'Comunicado N° 14: Cierre del Trimestre y Actividades Institucionales',
            'excerpt' => 'Dirección del Instituto emite directivas relativas a la finalización del período lectivo y fechas de entrega de informes pedagógicos a familias.',
            'body' => "La Dirección del Liceo Militar General Paz hace llegar a los señores padres y tutores el cronograma de cierre del trimestre pedagógico.\n\nSe recuerda la importancia del seguimiento académico continuo a través de las plataformas digitales institucionales.",
            'is_published' => true,
            'published_at' => now()->subDays(2),
            'is_pinned' => false
        ]
    );
}

// 3. Aranceles y Administración
if ($catAranceles) {
    $pArancel = Post::updateOrCreate(
        ['slug' => 'informacion-arancelaria-cierre-financiero'],
        [
            'user_id' => $user->id,
            'category_id' => $catAranceles->id,
            'educational_level_id' => $general->id,
            'title' => 'Régimen Arancelario y Modalidades de Pago Institucionales',
            'excerpt' => 'Información de Tesorería relativa a los vencimientos de cuotas, matrícula anual y canales habilitados para el pago electrónico.',
            'body' => "Se informa a los señores padres y tutores los canales oficiales de recaudación y las fechas límites fijadas para el presente ciclo.\n\nLos comprobantes pueden ser remitidos a la oficina de finanzas o validados a través de los canales institucionales.",
            'is_published' => true,
            'published_at' => now()->subDays(3),
            'is_pinned' => false
        ]
    );

    Attachment::updateOrCreate(
        ['post_id' => $pArancel->id, 'title' => 'Instructivo_Pagos_Aranceles_2026.pdf'],
        [
            'file_path' => 'documents/aranceles_2026.pdf',
            'file_size' => 184320,
            'mime_type' => 'pdf',
            'download_count' => 15
        ]
    );
}

// 4. Admisiones
if ($catAdmisiones) {
    Post::updateOrCreate(
        ['slug' => 'apertura-proceso-admisiones-2027'],
        [
            'user_id' => $user->id,
            'category_id' => $catAdmisiones->id,
            'educational_level_id' => $general->id,
            'title' => 'Apertura del Proceso de Admisiones e Incorporación 2027',
            'excerpt' => 'Se invita a las familias a conocer la propuesta educativa integral para los niveles Inicial, Primario y Secundario.',
            'body' => "El Liceo Militar General Paz abre sus puertas para las inscripciones del ciclo venidero. Se requiere la presentación de documentación académica y aptitud psicofísica según la reglamentación vigente.",
            'is_published' => true,
            'published_at' => now()->subDays(4),
            'is_pinned' => true
        ]
    );
}

// 5. Actividades
if ($catActividades) {
    Post::updateOrCreate(
        ['slug' => 'semana-operacional-cuerpo-cadetes'],
        [
            'user_id' => $user->id,
            'category_id' => $catActividades->id,
            'educational_level_id' => $militar->id,
            'title' => 'Semana Operacional del Cuerpo de Cadetes: Maniobras de Artillería',
            'excerpt' => 'Cadetes de Vto y VIto año completaron las jornadas de instrucción en el terreno y tiro de campaña.',
            'body' => "En el marco de la formación del Arma de Artillería, los cadetes desarrollaron actividades operacionales orientadas al fortalecimiento del liderazgo, la disciplina y las destrezas militares de campaña.",
            'is_published' => true,
            'published_at' => now()->subDays(5),
            'is_pinned' => false
        ]
    );
}

// 6. Reglamentos
if ($catReglamentos) {
    $pReg = Post::updateOrCreate(
        ['slug' => 'reglamento-de-convivencia-escolar'],
        [
            'user_id' => $user->id,
            'category_id' => $catReglamentos->id,
            'educational_level_id' => $secundario->id,
            'title' => 'Reglamento de Convivencia y Régimen del Cuerpo de Cadetes',
            'excerpt' => 'Pautas disciplinarias, código de honor sanmartiniano y normativas pedagógicas vigentes para toda la comunidad.',
            'body' => "Se publica el texto ordenado del Reglamento General de los Liceos Militares y las pautas de convivencia escolar aprobadas para el presente período lectivo.",
            'is_published' => true,
            'published_at' => now()->subDays(6),
            'is_pinned' => false
        ]
    );

    Attachment::updateOrCreate(
        ['post_id' => $pReg->id, 'title' => 'Reglamento_Convivencia_LMGP.pdf'],
        [
            'file_path' => 'documents/reglamento_convivencia.pdf',
            'file_size' => 450560,
            'mime_type' => 'pdf',
            'download_count' => 42
        ]
    );
}

// 7. Modificar los enlaces de filtros en home.blade.php para que lleven el ancla #comunicados
$homeFile = __DIR__ . '/resources/views/home.blade.php';
$c = file_get_contents($homeFile);
$c = str_replace(
    '<a href="{{ route(\'home\') }}" class="px-3 py-1.5',
    '<a href="{{ route(\'home\') }}#comunicados" class="px-3 py-1.5',
    $c
);
$c = str_replace(
    '<a href="{{ route(\'home\', [\'categoria\' => $cat->slug]) }}" class="px-3 py-1.5',
    '<a href="{{ route(\'home\', [\'categoria\' => $cat->slug]) }}#comunicados" class="px-3 py-1.5',
    $c
);
$c = str_replace(
    '<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-14">',
    '<section id="comunicados" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-14">',
    $c
);
file_put_contents($homeFile, $c);

echo "Base de datos poblada para todas las categorías y anclas de navegación configuradas.\n";
