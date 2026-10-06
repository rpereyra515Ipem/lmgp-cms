<?php

@mkdir(__DIR__ . '/resources/views/layouts', 0755, true);

// 1. Plantilla Maestra layouts/app.blade.php
file_put_contents(__DIR__ . '/resources/views/layouts/app.blade.php', <<<'BLADE'
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Liceo Militar General Paz') }} - @yield('title', 'Portal Institucional')</title>
    <!-- Tailwind CSS CDN para renderizado ágil e instantáneo -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        lmgp: {
                            blue: '#0F2942',
                            blueDark: '#0A1C2E',
                            gold: '#C5A059',
                            goldLight: '#DFBE7C',
                            grayLight: '#F4F6F9'
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-lmgp-grayLight text-slate-800 flex flex-col min-h-screen font-sans antialiased">

    <!-- Barra Superior Institucional -->
    <div class="bg-lmgp-blueDark text-white text-xs py-2 px-4 border-b border-lmgp-gold/30">
        <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center gap-2">
            <div class="flex items-center space-x-3">
                <span class="font-semibold tracking-wider text-lmgp-gold">EJÉRCITO ARGENTINO</span>
                <span>•</span>
                <span>Liceo Militar "General Paz"</span>
                <span class="hidden md:inline">•</span>
                <span class="hidden md:inline italic text-slate-300">"Verdad - Justicia - Equidad"</span>
            </div>
            <div class="flex items-center space-x-4 text-slate-300">
                <span><i class="fa-solid fa-phone mr-1 text-lmgp-gold"></i> +54 9 351 4920720</span>
                <span><i class="fa-solid fa-location-dot mr-1 text-lmgp-gold"></i> Córdoba, Argentina</span>
            </div>
        </div>
    </div>

    <!-- Navegación Principal -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logotipo / Escudo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="w-12 h-12 bg-lmgp-blue rounded-full flex items-center justify-center text-lmgp-gold shadow-md border-2 border-lmgp-gold">
                        <i class="fa-solid fa-shield-halved text-2xl"></i>
                    </div>
                    <div>
                        <div class="text-lg font-black text-lmgp-blue uppercase tracking-tight group-hover:text-lmgp-gold transition">
                            Liceo Militar
                        </div>
                        <div class="text-xs font-bold tracking-widest text-slate-500 uppercase">
                            "General Paz"
                        </div>
                    </div>
                </a>

                <!-- Enlaces de Navegación -->
                <nav class="hidden lg:flex items-center space-x-6 text-sm font-semibold text-slate-700">
                    <a href="{{ route('home') }}" class="hover:text-lmgp-blue transition py-2 border-b-2 border-transparent hover:border-lmgp-gold">Inicio</a>
                    <a href="{{ route('home', ['nivel' => 'nivel-inicial']) }}" class="hover:text-lmgp-blue transition py-2">Nivel Inicial</a>
                    <a href="{{ route('home', ['nivel' => 'nivel-primario']) }}" class="hover:text-lmgp-blue transition py-2">Nivel Primario</a>
                    <a href="{{ route('home', ['nivel' => 'nivel-secundario']) }}" class="hover:text-lmgp-blue transition py-2">Nivel Secundario</a>
                    <a href="{{ route('home', ['nivel' => 'educacion-militar']) }}" class="hover:text-lmgp-blue transition py-2">Cuerpo de Cadetes</a>
                    <a href="{{ route('home', ['categoria' => 'admisiones']) }}" class="bg-lmgp-gold hover:bg-lmgp-goldLight text-lmgp-blueDark px-4 py-2 rounded font-bold shadow-sm transition">
                        <i class="fa-solid fa-user-plus mr-1"></i> Admisiones
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Pie de Página Institucional -->
    <footer class="bg-lmgp-blueDark text-white border-t-4 border-lmgp-gold mt-16 pt-12 pb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8 mb-8 text-sm">
            <div>
                <h3 class="text-lmgp-gold font-bold uppercase tracking-wider text-base mb-3">Liceo Militar General Paz</h3>
                <p class="text-slate-300 leading-relaxed mb-4">
                    Unidad educativa preuniversitaria formadora de ciudadanos comprometidos con los valores éticos, republicanos y el amor a la Patria.
                </p>
                <div class="text-xs text-slate-400">
                    Régimen Externo y Régimen de Cadetes (Arma de Artillería).
                </div>
            </div>
            <div>
                <h3 class="text-lmgp-gold font-bold uppercase tracking-wider text-base mb-3">Contacto Oficial</h3>
                <ul class="space-y-2 text-slate-300">
                    <li><i class="fa-solid fa-map-location-dot text-lmgp-gold mr-2"></i> Av. Juan B. Justo 5858, Córdoba</li>
                    <li><i class="fa-solid fa-envelope text-lmgp-gold mr-2"></i> lmgp.rrpp@liceopaz.edu.ar</li>
                    <li><i class="fa-solid fa-phone text-lmgp-gold mr-2"></i> +54 9 351 4920720</li>
                    <li><i class="fa-brands fa-whatsapp text-lmgp-gold mr-2"></i> 351 679-2330 (Consultas)</li>
                </ul>
            </div>
            <div>
                <h3 class="text-lmgp-gold font-bold uppercase tracking-wider text-base mb-3">Seguridad y Normativa</h3>
                <p class="text-slate-300 text-xs leading-relaxed mb-4">
                    Plataforma institucional desarrollada conforme a las directivas de seguridad OWASP Top 10, estándares IRAM-ISO 27001 y pautas de Ciberdefensa.
                </p>
                <div class="text-xs text-slate-400">
                    División Informática - LMGP © {{ date('Y') }}
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 text-center text-xs text-slate-500 border-t border-slate-700/50 pt-4">
            Sitio Web Oficial • República Argentina
        </div>
    </footer>

</body>
</html>
BLADE);

// 2. Vista Principal resources/views/home.blade.php
file_put_contents(__DIR__ . '/resources/views/home.blade.php', <<<'BLADE'
@extends('layouts.app')

@section('title', 'Inicio')

@section('content')

    <!-- Hero Banner Institucional -->
    <section class="bg-gradient-to-r from-lmgp-blueDark via-lmgp-blue to-slate-900 text-white py-16 px-4 sm:px-6 lg:px-8 border-b-4 border-lmgp-gold shadow-lg">
        <div class="max-w-7xl mx-auto text-center">
            <span class="inline-block bg-lmgp-gold/20 text-lmgp-goldLight font-bold text-xs uppercase tracking-widest px-3 py-1 rounded-full mb-4 border border-lmgp-gold/40">
                82 Años de Tradición y Formación Integral
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight mb-4 uppercase">
                Educación en Valores y Excelencia Académica
            </h1>
            <p class="text-base sm:text-lg text-slate-300 max-w-3xl mx-auto font-light leading-relaxed mb-8">
                Formación integral en los tres niveles de la educación formal y formación militar de oficiales de reserva para la Nación.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('home', ['categoria' => 'admisiones']) }}" class="bg-lmgp-gold hover:bg-lmgp-goldLight text-lmgp-blueDark font-bold px-6 py-3 rounded shadow transition">
                    <i class="fa-solid fa-graduation-cap mr-2"></i> Admisiones e Ingreso
                </a>
                <a href="{{ route('home', ['categoria' => 'comunicados-oficiales']) }}" class="bg-white/10 hover:bg-white/20 text-white border border-white/30 font-semibold px-6 py-3 rounded backdrop-blur transition">
                    <i class="fa-solid fa-bullhorn mr-2 text-lmgp-gold"></i> Comunicados a Familias
                </a>
            </div>
        </div>
    </section>

    <!-- Tarjetas de Niveles Educativos -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-20">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($levels->where('slug', '!=', 'general') as $level)
                <a href="{{ route('home', ['nivel' => $level->slug]) }}" class="bg-white rounded-lg shadow-md p-5 border-t-4 border-lmgp-gold hover:shadow-xl transition transform hover:-translate-y-1 block">
                    <div class="text-lmgp-blue text-2xl mb-2">
                        @if($level->slug == 'nivel-inicial')
                            <i class="fa-solid fa-seedling text-emerald-600"></i>
                        @elseif($level->slug == 'nivel-primario')
                            <i class="fa-solid fa-book-open-reader text-blue-600"></i>
                        @elseif($level->slug == 'nivel-secundario')
                            <i class="fa-solid fa-award text-indigo-700"></i>
                        @else
                            <i class="fa-solid fa-person-military-pointing text-amber-700"></i>
                        @endif
                    </div>
                    <h3 class="font-bold text-slate-900 text-base mb-1">{{ $level->name }}</h3>
                    <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">{{ $level->description }}</p>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Sección de Novedades y Comunicados con Filtros -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between pb-4 border-b border-slate-200 gap-4">
            <div>
                <h2 class="text-2xl font-black text-lmgp-blue uppercase tracking-tight">Comunicados y Novedades</h2>
                <p class="text-xs text-slate-500 mt-1">Información oficial actualizada para alumnos, cadetes y familias.</p>
            </div>

            <!-- Filtros Rápidos -->
            <div class="flex flex-wrap gap-2 text-xs">
                <a href="{{ route('home') }}" class="px-3 py-1.5 rounded-full font-semibold {{ !request('nivel') && !request('categoria') ? 'bg-lmgp-blue text-white' : 'bg-white text-slate-600 hover:bg-slate-200' }} shadow-sm transition">
                    Todos
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('home', ['categoria' => $cat->slug]) }}" class="px-3 py-1.5 rounded-full font-semibold {{ request('categoria') == $cat->slug ? 'bg-lmgp-gold text-lmgp-blueDark' : 'bg-white text-slate-600 hover:bg-slate-200' }} shadow-sm transition">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Grilla de Publicaciones -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
            @forelse($posts as $post)
                <article class="bg-white rounded-lg shadow-sm hover:shadow-md transition border border-slate-200 overflow-hidden flex flex-col">
                    <div class="p-5 flex-grow">
                        <div class="flex items-center justify-between text-xs mb-3">
                            <span class="bg-lmgp-blue/10 text-lmgp-blue font-bold px-2 py-0.5 rounded">
                                {{ $post->category->name }}
                            </span>
                            <span class="text-slate-400">
                                <i class="fa-regular fa-calendar-days mr-1"></i>
                                {{ $post->published_at ? $post->published_at->format('d/m/Y') : $post->created_at->format('d/m/Y') }}
                            </span>
                        </div>
                        <h3 class="font-bold text-slate-900 text-lg mb-2 leading-snug hover:text-lmgp-blue transition">
                            {{ $post->title }}
                        </h3>
                        <p class="text-slate-600 text-sm leading-relaxed mb-4">
                            {{ $post->excerpt }}
                        </p>
                    </div>
                    @if($post->educationalLevel)
                        <div class="px-5 py-2.5 bg-slate-50 border-t border-slate-100 text-xs text-slate-500 font-medium flex items-center justify-between">
                            <span><i class="fa-solid fa-layer-group text-lmgp-gold mr-1"></i> {{ $post->educationalLevel->name }}</span>
                            <span class="text-lmgp-blue font-semibold">Ver detalle &rarr;</span>
                        </div>
                    @endif
                </article>
            @empty
                <div class="col-span-3 text-center py-12 bg-white rounded-lg border border-dashed border-slate-300">
                    <i class="fa-regular fa-newspaper text-slate-300 text-4xl mb-3"></i>
                    <p class="text-slate-500 font-medium">No se encontraron publicaciones con los filtros seleccionados.</p>
                </div>
            @endforelse
        </div>

        <!-- Paginación -->
        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    </section>

@endsection
BLADE);

// 3. Crear 3 publicaciones iniciales de muestra acordes al Liceo
use App\Models\Category;
use App\Models\EducationalLevel;
use App\Models\Post;
use App\Models\User;

$user = User::first();
$catAdmisiones = Category::where('slug', 'admisiones')->first();
$catComunicados = Category::where('slug', 'comunicados-oficiales')->first();
$catActividades = Category::where('slug', 'actividades')->first();

$secundario = EducationalLevel::where('slug', 'nivel-secundario')->first();
$militar = EducationalLevel::where('slug', 'educacion-militar')->first();
$general = EducationalLevel::where('slug', 'general')->first();

if ($user && $catAdmisiones) {
    Post::updateOrCreate(
        ['slug' => 'apertura-proceso-admisiones-2027'],
        [
            'user_id' => $user->id,
            'category_id' => $catAdmisiones->id,
            'educational_level_id' => $general->id ?? null,
            'title' => 'Apertura del Proceso de Admisiones e Inscripciones 2027',
            'excerpt' => 'Se informa a las familias interesadas en formar parte de nuestra propuesta que se encuentran abiertos los canales de orientación y recepción de solicitudes.',
            'body' => 'El Liceo Militar General Paz informa los requisitos y fechas para las admisiones del próximo ciclo lectivo...',
            'is_published' => true,
            'published_at' => now(),
            'is_pinned' => true
        ]
    );
}

if ($user && $catActividades && $militar) {
    Post::updateOrCreate(
        ['slug' => 'semana-operacional-cuerpo-cadetes'],
        [
            'user_id' => $user->id,
            'category_id' => $catActividades->id,
            'educational_level_id' => $militar->id,
            'title' => 'Semana Operacional del Cuerpo de Cadetes en Terreno',
            'excerpt' => 'Cadetes de los cursos superiores completaron con éxito las maniobras de instrucción militar y destrezas de campaña.',
            'body' => 'En el marco de la formación del Arma de Artillería, se llevaron a cabo los ejercicios anuales de instrucción...',
            'is_published' => true,
            'published_at' => now()->subDays(2),
            'is_pinned' => false
        ]
    );
}

if ($user && $catComunicados && $secundario) {
    Post::updateOrCreate(
        ['slug' => 'cronograma-mesas-de-examen-noviembre'],
        [
            'user_id' => $user->id,
            'category_id' => $catComunicados->id,
            'educational_level_id' => $secundario->id,
            'title' => 'Publicación de Fechas y Tribunales para Mesas de Examen',
            'excerpt' => 'Regencia de Estudios publica el cronograma oficial de materias previas y libres para el Nivel Secundario.',
            'body' => 'Se encuentran a disposición los días y horarios correspondientes a las instancias de evaluación...',
            'is_published' => true,
            'published_at' => now()->subDays(5),
            'is_pinned' => false
        ]
    );
}

echo "Vistas y datos de muestra generados exitosamente.\n";
