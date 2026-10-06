@extends('layouts.app')

@section('title', 'Inicio')

@section('content')

    <!-- Hero Banner Institucional con Fachada Histórica -->
    <section
        class="relative bg-lmgp-blueDark text-white pt-20 pb-24 px-4 sm:px-6 lg:px-8 border-b-4 border-lmgp-granate shadow-2xl overflow-hidden">
        {{-- Foto del edificio histórico de fondo con opacidad y filtro --}}
        <img src="{{ asset('images/fachada-lmgp.jpg') }}" alt="Fachada Histórica del Liceo Militar General Paz"
            class="absolute inset-0 w-full h-full object-cover object-center opacity-30 filter brightness-95">

        {{-- Gradiente institucional para garantizar contraste y lectura perfecta --}}
        <div class="absolute inset-0 bg-gradient-to-t from-lmgp-blueDark via-lmgp-blueDark/75 to-lmgp-blueDark/60"></div>

        {{-- Marca de agua sutil del escudo en la esquina --}}
        <div class="absolute -right-10 -bottom-10 opacity-5 pointer-events-none z-10">
            <img src="{{ asset('images/logo-lmgp.png') }}" class="w-96 h-auto filter grayscale" alt="LMGP">
        </div>

        {{-- Contenido Protocolar y Títulos --}}
        <div class="max-w-7xl mx-auto text-center relative z-20">

            {{-- Distintivo de Unidad Preuniversitaria y Artillería --}}
            <div
                class="inline-flex items-center gap-2 bg-lmgp-granate/90 text-white font-bold text-xs uppercase tracking-widest px-3.5 py-1.5 rounded-full mb-5 border border-lmgp-granateDark shadow-md">
                <span>Ejército Argentino</span>
                <span>•</span>
                <span class="text-lmgp-goldLight font-semibold">Arma de Artillería</span>
                <span>•</span>
                <span>82 Años</span>
            </div>

            {{-- Nombre Oficial del Instituto --}}
            <h1 class="text-3xl sm:text-6xl font-black tracking-tight mb-2 uppercase drop-shadow-lg leading-tight">
                Liceo Militar <span class="text-lmgp-gold">"General Paz"</span>
            </h1>

            {{-- Lema Histórico Oficial --}}
            <p class="text-sm sm:text-base font-bold tracking-[0.25em] text-slate-200 uppercase mb-4 drop-shadow">
                Verdad • Justicia • Equidad
            </p>

            {{-- Bajada Institucional --}}
            <p class="text-sm sm:text-base text-slate-300 max-w-3xl mx-auto font-light leading-relaxed mb-8">
                Formación integral en los tres niveles de la educación formal y capacitación de los futuros oficiales de
                reserva de Artillería para la Nación.
            </p>

            {{-- Botones de Acción (CTA) --}}
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('home', ['categoria' => 'admisiones']) }}#comunicados"
                    class="bg-lmgp-gold hover:bg-lmgp-goldLight text-lmgp-blueDark font-black px-6 py-3 rounded-lg shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 text-xs sm:text-sm uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-graduation-cap"></i> Admisiones e Ingreso
                </a>
                <a href="{{ route('home', ['categoria' => 'comunicados-oficiales']) }}#comunicados"
                    class="bg-white/10 hover:bg-white/20 text-white border border-white/30 font-bold px-6 py-3 rounded-lg backdrop-blur-sm shadow-md transition transform hover:-translate-y-0.5 text-xs sm:text-sm uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-bullhorn text-lmgp-gold"></i> Comunicados a Familias
                </a>
            </div>
        </div>
    </section>

    <!-- Tarjetas de Niveles Educativos (Solapadas sobre el Hero) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 relative z-30">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($levels->where('slug', '!=', 'general') as $level)
                @php
                    $isArtillery = $level->slug == 'educacion-militar';
                @endphp
                <a href="{{ route('home', ['nivel' => $level->slug]) }}#comunicados"
                    class="bg-white rounded-xl shadow-lg p-5 border-t-4 {{ $isArtillery ? 'border-lmgp-granate ring-1 ring-lmgp-granate/20 bg-gradient-to-b from-red-950/5 to-white' : 'border-lmgp-gold' }} hover:shadow-2xl transition transform hover:-translate-y-1 block">
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-2xl">
                            @if ($level->slug == 'nivel-inicial')
                                <i class="fa-solid fa-seedling text-emerald-600"></i>
                            @elseif($level->slug == 'nivel-primario')
                                <i class="fa-solid fa-book-open-reader text-blue-600"></i>
                            @elseif($level->slug == 'nivel-secundario')
                                <i class="fa-solid fa-award text-indigo-700"></i>
                            @else
                                <i class="fa-solid fa-crosshairs text-lmgp-granate"></i>
                            @endif
                        </div>
                        @if ($isArtillery)
                            <span
                                class="text-[10px] bg-lmgp-granate text-white font-bold px-2 py-0.5 rounded tracking-wider uppercase">
                                Artillería
                            </span>
                        @endif
                    </div>
                    <h3 class="font-bold text-slate-900 text-base mb-1">{{ $level->name }}</h3>
                    <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">{{ $level->description }}</p>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Campus y Ecosistema Digital -->
    <section id="servicios-digitales" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-14">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pb-6 border-b border-slate-100 gap-2">
                <div>
                    <h2 class="text-xl font-black text-lmgp-blue uppercase tracking-tight flex items-center gap-2">
                        <i class="fa-solid fa-network-wired text-lmgp-gold"></i> Campus y Ecosistema Digital
                    </h2>
                    <p class="text-xs text-slate-500 mt-1">Plataformas y servicios pedagógicos de la comunidad del Liceo
                        Militar.</p>
                </div>
                <span class="text-xs bg-slate-100 text-slate-600 font-semibold px-3 py-1 rounded-full w-fit">
                    Google Workspace for Education
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
                <!-- Google Classroom -->
                <a href="https://classroom.google.com" target="_blank" rel="noopener noreferrer"
                    class="p-4 rounded-lg border border-slate-200 hover:border-emerald-500 hover:shadow-md transition group bg-slate-50">
                    <div class="flex items-center space-x-3 mb-2">
                        <div
                            class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-slate-900 group-hover:text-emerald-700 transition">Classroom
                            </h4>
                            <span class="text-[10px] text-slate-500 uppercase font-semibold">Aulas Virtuales</span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-600 leading-snug">Tareas, material de estudio y seguimiento pedagógico por
                        curso.</p>
                </a>

                <!-- Campus Moodle -->
                <a href="{{ config('services.moodle.url', '#') }}" target="_blank" rel="noopener noreferrer"
                    class="p-4 rounded-lg border border-slate-200 hover:border-amber-500 hover:shadow-md transition group bg-slate-50">
                    <div class="flex items-center space-x-3 mb-2">
                        <div
                            class="w-10 h-10 rounded-lg bg-amber-100 text-amber-800 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-slate-900 group-hover:text-amber-700 transition">Campus Moodle
                            </h4>
                            <span class="text-[10px] text-slate-500 uppercase font-semibold">Servidor Interno</span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-600 leading-snug">Plataforma institucional de exámenes, formación y
                        recursos.</p>
                </a>

                <!-- Correo Institucional -->
                <a href="https://mail.google.com" target="_blank" rel="noopener noreferrer"
                    class="p-4 rounded-lg border border-slate-200 hover:border-blue-500 hover:shadow-md transition group bg-slate-50">
                    <div class="flex items-center space-x-3 mb-2">
                        <div
                            class="w-10 h-10 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-envelope-open-text"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-slate-900 group-hover:text-blue-700 transition">Correo Oficial
                            </h4>
                            <span class="text-[10px] text-slate-500 uppercase font-semibold">Gmail Institucional</span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-600 leading-snug">Cuentas @liceopaz.edu.ar (docentes/militares) y
                        @alumnos.liceopaz.edu.ar.</p>
                </a>

                <!-- Biblioteca Koha -->
                <a href="{{ config('services.koha.url', '#') }}"
                    class="p-4 rounded-lg border border-slate-200 hover:border-indigo-500 hover:shadow-md transition group bg-slate-50">
                    <div class="flex items-center space-x-3 mb-2">
                        <div
                            class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-book-bookmark"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-slate-900 group-hover:text-indigo-700 transition">Biblioteca
                                Koha</h4>
                            <span class="text-[10px] text-slate-500 uppercase font-semibold">Catálogo OPAC</span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-600 leading-snug">Consulta de libros, reglamentos, tratados históricos y
                        préstamos.</p>
                </a>
            </div>
        </div>
    </section>

    <!-- Sección de Novedades y Comunicados -->
    <section id="comunicados" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-14">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between pb-4 border-b border-slate-200 gap-4">
            <div>
                <h2 class="text-2xl font-black text-lmgp-blue uppercase tracking-tight">Comunicados y Novedades</h2>
                <p class="text-xs text-slate-500 mt-1">Información oficial actualizada para alumnos, cadetes y familias.</p>
            </div>

            <!-- Filtros por Categoría -->
            <div class="flex flex-wrap gap-2 text-xs">
                <a href="{{ route('home') }}#comunicados"
                    class="px-3 py-1.5 rounded-full font-semibold {{ !request('nivel') && !request('categoria') ? 'bg-lmgp-blue text-white' : 'bg-white text-slate-600 hover:bg-slate-200' }} shadow-sm transition">
                    Todos
                </a>
                @foreach ($categories as $cat)
                    <a href="{{ route('home', ['categoria' => $cat->slug]) }}#comunicados"
                        class="px-3 py-1.5 rounded-full font-semibold {{ request('categoria') == $cat->slug ? 'bg-lmgp-gold text-lmgp-blueDark font-bold' : 'bg-white text-slate-600 hover:bg-slate-200' }} shadow-sm transition">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Grilla de Tarjetas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
            @forelse($posts as $post)
                <article
                    class="bg-white rounded-lg shadow-sm hover:shadow-md transition border border-slate-200 overflow-hidden flex flex-col justify-between">
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
                            <a href="{{ url('/comunicados/' . ($post->slug ?? $post->id)) }}">
                                {{ $post->title }}
                            </a>
                        </h3>
                        <p class="text-slate-600 text-sm leading-relaxed mb-4">
                            {{ $post->excerpt }}
                        </p>
                    </div>

                    <!-- PIE DE TARJETA SIEMPRE VISIBLE CON LOS TRES NIVELES -->
                    <div
                        class="px-5 py-3 bg-slate-50 border-t border-slate-100 text-xs text-slate-500 font-medium flex items-center justify-between">
                        <span class="flex items-center gap-1.5 font-semibold text-slate-700">
                            <i class="fa-solid fa-layer-group text-lmgp-gold"></i>
                            @if ($post->category->slug === 'concursos-y-suplencias' || !$post->educationalLevel)
                                Nivel Inicial, Primario y Secundario
                            @else
                                {{ $post->educationalLevel->name }}
                            @endif
                        </span>
                        <a href="{{ url('/comunicados/' . ($post->slug ?? $post->id)) }}"
                            class="text-lmgp-blue hover:text-lmgp-gold font-bold transition flex items-center gap-1">
                            Ver comunicado &rarr;
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center py-12 bg-white rounded-lg border border-dashed border-slate-300">
                    <i class="fa-regular fa-newspaper text-slate-300 text-4xl mb-3"></i>
                    <p class="text-slate-500 font-medium">No se encontraron publicaciones con los filtros seleccionados.
                    </p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    </section>

@endsection
