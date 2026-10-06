@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    {{-- Encabezado y volver --}}
    <div class="flex items-center justify-between mb-6 border-b border-slate-200 pb-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Modificar Publicación</h1>
            <p class="text-sm text-slate-500">Editando comunicado institucional: <span class="font-medium text-slate-700">"{{ $post->title }}"</span></p>
        </div>
        <a href="{{ route('admin.dashboard') }}" 
           class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition shadow-sm">
            ← Volver al Panel
        </a>
    </div>

    {{-- Errores de Validación --}}
    @if ($errors->any())
        <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-lg">
            <div class="flex">
                <div class="text-rose-700">
                    <p class="font-semibold text-sm">Por favor corrige los siguientes errores:</p>
                    <ul class="mt-2 list-disc list-inside text-xs space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- Formulario de Edición --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 sm:p-8">
        <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Título --}}
            <div>
                <label for="title" class="block text-sm font-semibold text-slate-700 mb-1">
                    Título del Comunicado o Novedad <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="title" id="title" required
                       value="{{ old('title', $post->title) }}"
                       class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-3 py-2 border">
            </div>

            {{-- Categoría y Nivel Educativo --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="category_id" class="block text-sm font-semibold text-slate-700 mb-1">
                        Categoría <span class="text-rose-500">*</span>
                    </label>
                    <select name="category_id" id="category_id" required
                            class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-3 py-2 border bg-white">
                        <option value="">Selecciona una categoría...</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="educational_level_id" class="block text-sm font-semibold text-slate-700 mb-1">
                        Nivel Educativo (Opcional)
                    </label>
                    <select name="educational_level_id" id="educational_level_id"
                            class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-3 py-2 border bg-white">
                        <option value="">Todos / Institucional General</option>
                        @foreach ($levels as $level)
                            <option value="{{ $level->id }}" {{ old('educational_level_id', $post->educational_level_id) == $level->id ? 'selected' : '' }}>
                                {{ $level->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Copete / Bajada (Excerpt) --}}
            <div>
                <label for="excerpt" class="block text-sm font-semibold text-slate-700 mb-1">
                    Copete / Resumen breve
                </label>
                <textarea name="excerpt" id="excerpt" rows="2" maxlength="500"
                          class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-3 py-2 border"
                          placeholder="Breve resumen que aparece en las tarjetas de la portada...">{{ old('excerpt', $post->excerpt) }}</textarea>
                <p class="text-xs text-slate-400 mt-1">Máximo 500 caracteres.</p>
            </div>

            {{-- Cuerpo de la Noticia --}}
            <div>
                <label for="body" class="block text-sm font-semibold text-slate-700 mb-1">
                    Contenido Completo <span class="text-rose-500">*</span>
                </label>
                <textarea name="body" id="body" rows="8" required
                          class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-3 py-2 border"
                          placeholder="Escribe aquí el cuerpo del comunicado...">{{ old('body', $post->body) }}</textarea>
            </div>

            {{-- Imagen de Portada --}}
            <div class="p-4 bg-slate-50 border border-slate-200 rounded-lg">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Foto de Portada / Actividad</label>
                @if ($post->featured_image)
                    <div class="mb-3 flex items-center gap-4">
                        <img src="{{ asset($post->featured_image) }}" alt="Portada actual" class="h-20 w-32 object-cover rounded-md border border-slate-300 shadow-sm">
                        <span class="text-xs text-slate-500">Imagen actual. Si seleccionas una nueva a continuación, la reemplazará.</span>
                    </div>
                @endif
                <input type="file" name="featured_image" id="featured_image" accept="image/jpeg,image/png,image/webp"
                       class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="text-xs text-slate-400 mt-1">Formatos admitidos: JPG, PNG o WebP (máx. 5 MB).</p>
            </div>

            {{-- Documento Adjunto (PDF o Word) --}}
            <div class="p-4 bg-slate-50 border border-slate-200 rounded-lg">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Documento Oficial / Circular Adjunta</label>
                @if ($post->attachments && $post->attachments->count() > 0)
                    <div class="mb-3">
                        <p class="text-xs font-semibold text-slate-600 mb-1">Adjuntos registrados actualmente:</p>
                        <ul class="text-xs text-slate-500 space-y-1">
                            @foreach ($post->attachments as $att)
                                <li class="flex items-center gap-1.5">
                                    📄 <span class="font-medium text-slate-700">{{ $att->title }}</span> ({{ round($att->file_size / 1024, 1) }} KB)
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <input type="file" name="document" id="document" accept=".pdf,.doc,.docx"
                       class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="text-xs text-slate-400 mt-1">Sube un nuevo archivo solo si deseas adjuntar otro documento (PDF o DOC, máx. 10 MB).</p>
            </div>

            {{-- Casilla de Publicación Permanente --}}
            <div class="pt-2">
                <label class="relative flex items-start gap-3">
                    <input type="checkbox" name="is_permanent" value="1" 
                           {{ old('is_permanent', $post->is_permanent) ? 'checked' : '' }}
                           class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 h-4 w-4 mt-0.5">
                    <span class="text-sm">
                        <span class="font-medium text-slate-800">Publicación Permanente</span>
                        <span class="block text-xs text-slate-500">Si está marcado, no vencerá automáticamente a los 30 días ni requerirá prórroga.</span>
                    </span>
                </label>
            </div>

            {{-- Botones de Acción al pie --}}
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-200">
                <a href="{{ route('admin.dashboard') }}" 
                   class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-5 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition shadow-sm">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection