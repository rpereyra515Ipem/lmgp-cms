@extends('layouts.app')

@section('title', 'Actividades Institucionales - LMGP')

@section('content')
<!-- HERO PROMOCIONAL -->
<div class="bg-lmgp-blue text-white py-12 px-4 sm:px-6 lg:px-8 border-b-4 border-lmgp-gold">
    <div class="max-w-6xl mx-auto text-center">
        <span class="inline-block text-xs font-bold uppercase tracking-widest text-lmgp-goldLight bg-white/10 px-3 py-1 rounded-full mb-3">
            Comunidad y Vida Académica
        </span>
        <h1 class="text-3xl sm:text-4xl font-black uppercase tracking-tight">
            Actividades del Instituto
        </h1>
        <p class="mt-2 text-sm sm:text-base text-slate-300 max-w-2xl mx-auto">
            Descubra las experiencias formativas, deportivas, académicas y protocolares que protagonizan nuestros alumnos y cadetes en cada nivel educativo.
        </p>
    </div>
</div>

<!-- CONTENEDOR PRINCIPAL -->
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- FILTROS POR NIVEL EDUCATIVO (UX PILLS) -->
    <div class="flex flex-wrap items-center justify-center gap-2 mb-10">
        <a href="{{ route('actividades.index', ['nivel' => 'todos']) }}"
           class="px-4 py-2 rounded-full text-xs font-bold transition-all {{ empty($selectedLevel) || $selectedLevel === 'todos' ? 'bg-lmgp-blue text-white shadow-md' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            Todas las Actividades
        </a>
        @foreach($levels as $lvl)
            <a href="{{ route('actividades.index', ['nivel' => $lvl->slug]) }}"
               class="px-4 py-2 rounded-full text-xs font-bold transition-all {{ $selectedLevel === $lvl->slug ? 'bg-lmgp-blue text-white shadow-md' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                {{ $lvl->name }}
            </a>
        @endforeach
    </div>

    <!-- GRILLA DE TARJETAS (CARDS) -->
    @if($activities->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($activities as $item)
                <article class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden flex flex-col hover:-translate-y-1 hover:shadow-lg transition-all duration-200">
                    <!-- FOTO DE PORTADA -->
                    <div class="relative h-48 w-full bg-slate-100 overflow-hidden">
                        @if($item->featured_image)
                            <img src="{{ $item->featured_image }}" 
                                 alt="{{ $item->title }}" 
                                 class="w-full h-full object-cover transition-transform duration-300 hover:scale-105"
                                 loading="lazy">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center bg-slate-100 text-slate-400">
                                <img src="{{ asset('images/logo-lmgp.png') }}" class="h-14 opacity-30 mb-2" alt="LMGP">
                                <span class="text-[11px] font-semibold tracking-wider uppercase text-slate-400">Liceo Militar General Paz</span>
                            </div>
                        @endif

                        <!-- BADGE DE NIVEL -->
                        @if($item->educationalLevel)
                            <span class="absolute top-3 left-3 bg-lmgp-blue/90 backdrop-blur-sm text-white text-[11px] font-bold px-2.5 py-1 rounded shadow-sm">
                                {{ $item->educationalLevel->name }}
                            </span>
                        @endif
                    </div>

                    <!-- CONTENIDO DE LA TARJETA -->
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <!-- FECHA PROTOCOLAR -->
                            <div class="flex items-center gap-1.5 text-xs text-slate-500 mb-2">
                                <svg class="h-4 w-4 text-lmgp-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <time datetime="{{ $item->published_at }}">
                                    {{ \Carbon\Carbon::parse($item->published_at)->locale('es')->isoFormat('D [de] MMMM, YYYY') }}
                                </time>
                            </div>

                            <!-- TÍTULO -->
                            <h2 class="text-base font-bold text-slate-900 leading-snug line-clamp-2 hover:text-lmgp-blue transition-colors">
                                {{ $item->title }}
                            </h2>

                            <!-- EXTRACTO -->
                            <p class="mt-2 text-xs sm:text-sm text-slate-600 line-clamp-3 leading-relaxed">
                                {{ $item->excerpt }}
                            </p>
                        </div>

                        <!-- ENLACE DE LECTURA -->
                        <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between">
                            <a href="{{ url('/comunicados/' . $item->slug) }}" 
                               class="inline-flex items-center gap-1 text-xs font-bold text-lmgp-blue hover:text-lmgp-granate transition-colors">
                                <span>Leer crónica completa</span>
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <!-- PAGINACIÓN -->
        <div class="mt-10">
            {{ $activities->links() }}
        </div>
    @else
        <!-- ESTADO VACÍO -->
        <div class="text-center py-16 bg-white rounded-xl border border-dashed border-slate-300">
            <svg class="h-12 w-12 text-slate-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
            </svg>
            <h3 class="text-sm font-bold text-slate-700">No hay publicaciones disponibles en este nivel</h3>
            <p class="text-xs text-slate-500 mt-1">Pruebe seleccionando otra sección o regrese a "Todas las Actividades".</p>
            <a href="{{ route('actividades.index', ['nivel' => 'todos']) }}" class="inline-block mt-4 text-xs font-bold text-lmgp-blue underline">
                Ver todas las actividades
            </a>
        </div>
    @endif

</div>
@endsection