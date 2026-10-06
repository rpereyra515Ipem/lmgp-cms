@extends('layouts.app')
@section('title', 'Información para Docentes')
@section('content')

    <div
        class="bg-gradient-to-r from-lmgp-blueDark via-lmgp-blue to-slate-900 text-white py-12 px-4 sm:px-6 lg:px-8 border-b-4 border-lmgp-gold">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-lmgp-goldLight flex items-center gap-1.5">
                    <i class="fa-solid fa-chalkboard-user"></i> Espacio Institucional • Regencia y Secretaría
                </span>
                <h1 class="text-2xl sm:text-4xl font-extrabold uppercase mt-1">Información para Docentes</h1>
                <p class="text-xs sm:text-sm text-slate-300 max-w-2xl mt-1">
                    Convocatorias a suplencias, concursos oficiales, circulares normativas y documentación de cátedra.
                </p>
            </div>
            <a href="{{ route('home') }}"
                class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white border border-white/20 text-xs font-bold px-4 py-2 rounded transition w-fit">
                <i class="fa-solid fa-arrow-left text-lmgp-gold"></i> Volver a Portada
            </a>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <!-- BANNERS DESTACADOS -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
            <a href="{{ route('docentes.index', ['categoria' => 'concursos-y-suplencias']) }}#listado"
                class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-lmgp-blueDark via-lmgp-blue to-slate-900 text-white p-6 sm:p-8 border-2 border-lmgp-gold shadow-md hover:shadow-xl transition transform hover:-translate-y-1 group">
                <div class="relative z-10 flex items-center justify-between">
                    <div>
                        <span
                            class="text-[11px] font-bold uppercase tracking-wider text-lmgp-goldLight bg-white/10 px-2.5 py-1 rounded">
                            Actos Públicos y Padrón
                        </span>
                        <h2
                            class="text-2xl sm:text-3xl font-black tracking-tight uppercase mt-3 mb-1 text-white group-hover:text-lmgp-gold transition leading-tight">
                            Convocatorias<br>Suplencias
                        </h2>
                        <p class="text-xs text-slate-300 mt-2">Horarios de toma de horas vacantes y llamados según
                            normativa.</p>
                    </div>
                    <div
                        class="w-14 h-14 rounded-full bg-lmgp-gold text-lmgp-blueDark flex items-center justify-center text-2xl shadow-lg group-hover:bg-white transition flex-shrink-0 ml-4">
                        <i class="fa-solid fa-hand-holding-hand"></i>
                    </div>
                </div>
            </a>

            <a href="{{ route('docentes.index', ['categoria' => 'concursos-y-suplencias']) }}#listado"
                class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-slate-900 via-lmgp-blueDark to-lmgp-blue text-white p-6 sm:p-8 border-2 border-lmgp-gold shadow-md hover:shadow-xl transition transform hover:-translate-y-1 group">
                <div class="relative z-10 flex items-center justify-between">
                    <div>
                        <span
                            class="text-[11px] font-bold uppercase tracking-wider text-lmgp-goldLight bg-white/10 px-2.5 py-1 rounded">
                            Títulos y Antecedentes
                        </span>
                        <h2
                            class="text-2xl sm:text-3xl font-black tracking-tight uppercase mt-3 mb-1 text-white group-hover:text-lmgp-gold transition leading-tight">
                            Concursos<br>Docentes
                        </h2>
                        <p class="text-xs text-slate-300 mt-2">Bases, condiciones y requisitos para cobertura de cargos.</p>
                    </div>
                    <div
                        class="w-14 h-14 rounded-full bg-lmgp-gold text-lmgp-blueDark flex items-center justify-center text-2xl shadow-lg group-hover:bg-white transition flex-shrink-0 ml-4">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- LISTADO DE PUBLICACIONES -->
        <div id="listado"
            class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 mb-8 border-b border-slate-200 gap-4">
            <div>
                <h3 class="text-lg font-black text-lmgp-blue uppercase tracking-tight">Publicaciones y Resoluciones</h3>
                <p class="text-xs text-slate-500">Documentos oficiales con Visto Bueno de la Dirección.</p>
            </div>

            <div class="flex flex-wrap gap-2 text-xs">
                <a href="{{ route('docentes.index') }}#listado"
                    class="px-3 py-1.5 rounded-full font-semibold {{ !request('categoria') ? 'bg-lmgp-blue text-white' : 'bg-white text-slate-600 hover:bg-slate-200 border border-slate-200' }} shadow-sm transition">
                    Todas
                </a>
                <a href="{{ route('docentes.index', ['categoria' => 'concursos-y-suplencias']) }}#listado"
                    class="px-3 py-1.5 rounded-full font-semibold {{ request('categoria') === 'concursos-y-suplencias' ? 'bg-lmgp-granate text-white' : 'bg-white text-slate-600 hover:bg-slate-200 border border-slate-200' }} shadow-sm transition">
                    <i class="fa-solid fa-bullhorn mr-1 text-lmgp-gold"></i> Concursos y Suplencias
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($posts as $post)
                <div
                    class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex flex-col justify-between hover:shadow-md hover:border-lmgp-gold transition">
                    <div>
                        <div class="flex items-center justify-between text-xs mb-3">
                            <span class="bg-lmgp-blue/10 text-lmgp-blue font-bold px-2.5 py-0.5 rounded text-[11px]">
                                {{ $post->category->name }}
                            </span>
                            <span class="text-slate-400">
                                {{ $post->published_at ? $post->published_at->format('d/m/Y') : $post->created_at->format('d/m/Y') }}
                            </span>
                        </div>
                        <h4 class="font-bold text-slate-900 text-base mb-2 hover:text-lmgp-blue transition leading-snug">
                            <a href="{{ route('posts.show', $post->slug ?? $post->id) }}">
                                {{ $post->title }}
                            </a>
                        </h4>
                        <p class="text-xs text-slate-600 leading-relaxed line-clamp-3 mb-4">
                            {{ $post->excerpt }}
                        </p>
                    </div>
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold">
                        <span class="text-slate-400 flex items-center gap-1">
                            <i class="fa-solid fa-paperclip text-lmgp-gold"></i>
                            {{ $post->attachments ? $post->attachments->count() : 0 }} adjunto(s)
                        </span>
                        <a href="{{ route('posts.show', $post->slug ?? $post->id) }}"
                            class="text-lmgp-blue hover:text-lmgp-gold font-bold transition">
                            Leer y Descargar Bases &rarr;
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 bg-white rounded-lg border border-dashed border-slate-300">
                    <p class="text-slate-500 font-medium text-sm">No se encontraron publicaciones con el filtro actual.</p>
                </div>
            @endforelse
        </div>

        <!-- Paginación -->
        <div class="mt-8">
            {{ $posts->links() }}
        </div>

    </div>
@endsection
