@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <!-- Cabecera de Navegación / Breadcrumbs -->
    <div class="bg-white border-b border-slate-200 py-4 px-4 sm:px-6 lg:px-8 shadow-sm">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-3 text-xs">
            <nav class="flex items-center space-x-2 text-slate-500">
                <a href="{{ route('home') }}" class="hover:text-lmgp-blue font-semibold flex items-center gap-1">
                    <i class="fa-solid fa-house"></i> Inicio
                </a>
                <span>/</span>
                <a href="{{ route('home', ['categoria' => $post->category->slug]) }}" class="hover:text-lmgp-blue font-semibold">
                    {{ $post->category->name }}
                </a>
                <span>/</span>
                <span class="text-slate-800 font-bold truncate max-w-xs sm:max-w-md">{{ $post->title }}</span>
            </nav>
            <a href="{{ route('home') }}" class="text-lmgp-blue hover:text-lmgp-gold font-bold inline-flex items-center gap-1 transition">
                <i class="fa-solid fa-arrow-left"></i> Volver a Novedades
            </a>
        </div>
    </div>

    <!-- Contenido del Artículo -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            <!-- Columna Principal -->
            <article class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-200 p-6 sm:p-10">
                
                <!-- Metadatos de Cabecera -->
                <div class="flex flex-wrap items-center gap-2 mb-4 text-xs">
                    <span class="bg-lmgp-blue text-white font-bold px-3 py-1 rounded shadow-sm">
                        {{ $post->category->name }}
                    </span>
                    <span class="bg-slate-100 text-slate-700 font-semibold px-3 py-1 rounded border border-slate-200">
    <i class="fa-solid fa-layer-group text-lmgp-gold mr-1"></i>
    @if($post->category->slug === 'concursos-y-suplencias' || !$post->educationalLevel)
        Nivel Inicial, Primario y Secundario
    @else
        {{ $post->educationalLevel->name }}
    @endif
</span>
                    @if($post->educationalLevel && $post->educationalLevel->slug == 'educacion-militar')
                        <span class="bg-lmgp-granate text-white font-bold px-3 py-1 rounded shadow-sm">
                            Arma de Artillería
                        </span>
                    @endif
                    <span class="text-slate-400 ml-auto flex items-center gap-1 font-medium">
                        <i class="fa-regular fa-calendar-days text-lmgp-gold"></i>
                        {{ $post->published_at ? $post->published_at->format('d/m/Y') : $post->created_at->format('d/m/Y') }}
                    </span>
                </div>

                <!-- Título -->
                <h1 class="text-2xl sm:text-4xl font-extrabold text-lmgp-blue tracking-tight leading-tight mb-4">
                    {{ $post->title }}
                </h1>

                <!-- Ficha del Emisor -->
                <div class="flex items-center space-x-3 pb-6 mb-8 border-b border-slate-200 text-xs text-slate-500">
                    <div class="w-8 h-8 rounded-full bg-lmgp-blueDark text-lmgp-gold flex items-center justify-center font-bold">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <div>
                        <div class="font-bold text-slate-800">{{ $post->user->name ?? 'Comando y Dirección' }}</div>
                        <div>Liceo Militar General Paz • Publicación Oficial</div>
                    </div>
                </div>

                <!-- Copete / Extracto -->
                @if($post->excerpt)
                    <div class="bg-lmgp-grayLight border-l-4 border-lmgp-gold p-4 mb-8 rounded-r text-slate-700 font-medium text-base sm:text-lg leading-relaxed italic">
                        {{ $post->excerpt }}
                    </div>
                @endif

                <!-- Cuerpo de la Publicación -->
                <div class="text-slate-800 leading-relaxed text-base space-y-4 font-normal">
                    {!! nl2br(e($post->body)) !!}
                </div>

                <!-- Sección de Archivos Adjuntos Oficiales -->
                @if($post->attachments->count() > 0)
                    <div class="mt-12 pt-8 border-t border-slate-200">
                        <h3 class="text-lg font-black text-lmgp-blue uppercase tracking-tight flex items-center gap-2 mb-4">
                            <i class="fa-solid fa-paperclip text-lmgp-gold"></i> Documentación y Archivos Adjuntos
                        </h3>
                        <div class="space-y-3">
                            @foreach($post->attachments as $attachment)
                                <div class="flex items-center justify-between p-4 rounded-lg bg-slate-50 border border-slate-200 hover:border-lmgp-gold transition">
                                    <div class="flex items-center space-x-3">
                                        <i class="fa-solid fa-file-pdf text-red-600 text-2xl"></i>
                                        <div>
                                            <div class="font-bold text-sm text-slate-900">{{ $attachment->title }}</div>
                                            <div class="text-[11px] text-slate-400">
                                                Formato: {{ strtoupper($attachment->mime_type) }} • {{ round($attachment->file_size / 1024, 1) }} KB
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('attachments.download', $attachment->id) }}" class="bg-lmgp-blue hover:bg-lmgp-blueDark text-white text-xs font-bold px-4 py-2 rounded shadow-sm transition flex items-center gap-1.5">
                                        <i class="fa-solid fa-download text-lmgp-gold"></i> Descargar
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Pie del Comunicado -->
                <div class="mt-12 pt-6 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                    <span>Identificador: LMGP-DOC-{{ str_pad($post->id, 5, '0', STR_PAD_LEFT) }}</span>
                    <span>Validez Institucional Verificada</span>
                </div>
            </article>

            <!-- Barra Lateral -->
            <aside class="space-y-6">
                <!-- Accesos Rápidos al Campus -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-sm font-bold text-lmgp-blue uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                        <i class="fa-solid fa-laptop-code text-lmgp-gold"></i> Campus y Servicios
                    </h3>
                    <ul class="space-y-2.5 text-xs font-semibold">
                        <li>
                            <a href="{{ config('services.moodle.url', '#') }}" target="_blank" class="flex items-center justify-between p-2.5 rounded bg-slate-50 hover:bg-amber-50 text-slate-700 hover:text-amber-800 transition border border-slate-100">
                                <span class="flex items-center gap-2"><i class="fa-solid fa-graduation-cap text-amber-500"></i> Campus Moodle</span>
                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-slate-400"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://classroom.google.com" target="_blank" class="flex items-center justify-between p-2.5 rounded bg-slate-50 hover:bg-emerald-50 text-slate-700 hover:text-emerald-800 transition border border-slate-100">
                                <span class="flex items-center gap-2"><i class="fa-solid fa-chalkboard-user text-emerald-500"></i> Google Classroom</span>
                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-slate-400"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://mail.google.com" target="_blank" class="flex items-center justify-between p-2.5 rounded bg-slate-50 hover:bg-blue-50 text-slate-700 hover:text-blue-800 transition border border-slate-100">
                                <span class="flex items-center gap-2"><i class="fa-solid fa-envelope text-blue-500"></i> Correo Oficial</span>
                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-slate-400"></i>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Otras Novedades Recientes -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-sm font-bold text-lmgp-blue uppercase tracking-wider mb-4 pb-2 border-b border-slate-100">
                        Otros Comunicados
                    </h3>
                    <div class="space-y-4">
                        @foreach($recentPosts as $recent)
                            <a href="{{ route('posts.show', $recent->slug) }}" class="block group">
                                <div class="text-[10px] text-lmgp-gold font-bold uppercase tracking-wider mb-0.5">
                                    {{ $recent->category->name }}
                                </div>
                                <h4 class="text-xs font-bold text-slate-800 group-hover:text-lmgp-blue transition leading-snug line-clamp-2">
                                    {{ $recent->title }}
                                </h4>
                                <span class="text-[10px] text-slate-400">
                                    {{ $recent->published_at ? $recent->published_at->format('d/m/Y') : $recent->created_at->format('d/m/Y') }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </aside>

        </div>
    </div>
@endsection