@extends('layouts.app')

@section('title', 'Nueva Publicación o Actividad - LMGP')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
        <!-- CABECERA -->
        <div class="p-6 bg-slate-50 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-black text-lmgp-blue uppercase tracking-tight">
                    Nueva Publicación / Actividad
                </h1>
                <p class="text-xs text-emerald-700 font-semibold mt-1 flex items-center gap-1.5">
                    <i class="fa-solid fa-shield-check"></i>
                    <span>Modo Master Administrator: Publicación directa y oficial.</span>
                </p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold text-slate-500 hover:text-lmgp-blue transition flex items-center gap-1">
                ← Cancelar y Volver
            </a>
        </div>

        <!-- FORMULARIO -->
        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
            @csrf

            <!-- TÍTULO -->
            <div>
                <label for="title" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                    Título de la Publicación o Actividad <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="{{ old('title') }}" 
                    required 
                    placeholder="Ej: El LMGP en los Interliceos 2026 / Circular N° 05 - Horarios de Examen"
                    class="w-full px-3.5 py-2.5 border border-slate-300 rounded text-sm text-slate-900 focus:outline-none focus:border-lmgp-blue"
                >
                @error('title')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- CATEGORÍA Y NIVEL EDUCATIVO -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="category_id" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Categoría <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="category_id" 
                        name="category_id" 
                        required 
                        class="w-full px-3 py-2 border border-slate-300 rounded text-sm text-slate-800 focus:outline-none focus:border-lmgp-blue"
                    >
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="educational_level_id" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Nivel Educativo (Para segmentar en la web)
                    </label>
                    <select 
                        id="educational_level_id" 
                        name="educational_level_id" 
                        class="w-full px-3 py-2 border border-slate-300 rounded text-sm text-slate-800 focus:outline-none focus:border-lmgp-blue"
                    >
                        <option value="">-- Toda la Comunidad / General --</option>
                        @foreach($levels as $level)
                            <option value="{{ $level->id }}" {{ old('educational_level_id') == $level->id ? 'selected' : '' }}>
                                {{ $level->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- CASILLA DE PUBLICACIÓN PERMANENTE -->
            <div class="flex items-center gap-2.5 p-3.5 bg-slate-50 border border-slate-200 rounded-lg">
                <input 
                    type="checkbox" 
                    id="is_permanent" 
                    name="is_permanent" 
                    value="1" 
                    {{ old('is_permanent') ? 'checked' : '' }}
                    class="h-4 w-4 text-lmgp-blue rounded border-slate-300 focus:ring-lmgp-blue cursor-pointer"
                >
                <label for="is_permanent" class="text-xs font-bold text-slate-700 cursor-pointer select-none">
                    📌 Publicación Permanente / Sin Vencimiento
                    <span class="block text-[11px] font-normal text-slate-500">
                        Marcar para reglamentos, normativas o actividades institucionales que deban permanecer siempre visibles sin caducar a los 30 días.
                    </span>
                </label>
            </div>

            <!-- FOTOGRAFÍA DE PORTADA (PARA ACTIVIDADES) Y ADJUNTO PDF (PARA CIRCULARES) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 p-4 bg-slate-50 border border-slate-200 rounded-lg">
                <!-- FOTO DE PORTADA -->
                <div>
                    <label for="featured_image" class="block text-xs font-bold text-lmgp-blue uppercase mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-camera text-lmgp-gold"></i>
                        <span>Foto de Portada (Para Actividades)</span>
                    </label>
                    <input 
                        type="file" 
                        id="featured_image" 
                        name="featured_image" 
                        accept="image/png, image/jpeg, image/jpg, image/webp"
                        class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-lmgp-blue file:text-white hover:file:bg-lmgp-blueDark cursor-pointer"
                    >
                    <span class="block text-[11px] text-slate-500 mt-1">
                        Se muestra como imagen principal en la tarjeta de actividades (JPG, PNG, WebP).
                    </span>
                    @error('featured_image')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- ADJUNTO DOCUMENTAL -->
                <div>
                    <label for="document" class="block text-xs font-bold text-slate-700 uppercase mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-file-pdf text-red-500"></i>
                        <span>Adjunto Documental (Para Circulares)</span>
                    </label>
                    <input 
                        type="file" 
                        id="document" 
                        name="document" 
                        accept=".pdf,.doc,.docx"
                        class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-slate-700 file:text-white hover:file:bg-slate-800 cursor-pointer"
                    >
                    <span class="block text-[11px] text-slate-500 mt-1">
                        Documento oficial descargable (PDF, Word hasta 10MB).
                    </span>
                    @error('document')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- EXTRACTO O BAJADA -->
            <div>
                <label for="excerpt" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                    Extracto / Resumen Corto
                </label>
                <textarea 
                    id="excerpt" 
                    name="excerpt" 
                    rows="2" 
                    placeholder="Breve resumen visible en las tarjetas de actividades y comunicados..."
                    class="w-full px-3 py-2 border border-slate-300 rounded text-sm text-slate-900 focus:outline-none focus:border-lmgp-blue"
                >{{ old('excerpt') }}</textarea>
            </div>

            <!-- CUERPO COMPLETO -->
            <div>
                <label for="body" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                    Cuerpo Completo del Comunicado o Noticia <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="body" 
                    name="body" 
                    rows="8" 
                    required 
                    placeholder="Escriba aquí la crónica de la actividad o el texto institucional completo..."
                    class="w-full px-3 py-2 border border-slate-300 rounded text-sm text-slate-900 focus:outline-none focus:border-lmgp-blue leading-relaxed font-sans"
                >{{ old('body') }}</textarea>
                @error('body')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- BOTONES DE ACCIÓN -->
            <div class="pt-4 border-t border-slate-200 flex items-center justify-end gap-3">
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-xs font-bold text-slate-600 hover:text-slate-800">
                    Cancelar
                </a>
                <button 
                    type="submit" 
                    class="px-5 py-2.5 bg-lmgp-blue hover:bg-lmgp-blueDark text-white text-xs font-bold uppercase tracking-wider rounded shadow transition flex items-center gap-2"
                >
                    <i class="fa-solid fa-paper-plane text-lmgp-gold"></i>
                    <span>Publicar Oficialmente</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection