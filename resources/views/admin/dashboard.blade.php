@extends('layouts.app')
@section('title', 'Panel de Control')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Barra Superior del Panel -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-slate-200 gap-4 mb-8">
            <div>
                <div class="flex items-center gap-2">
                    <h1 class="text-2xl font-black text-lmgp-blue uppercase tracking-tight">Panel de Gestión</h1>
                    <span
                        class="text-xs font-bold px-2 py-0.5 rounded {{ $user->role === 'master_admin' ? 'bg-lmgp-granate text-white' : 'bg-lmgp-blue text-white' }}">
                        {{ strtoupper(str_replace('_', ' ', $user->role)) }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">
                    Sesión activa como: <strong class="text-slate-800">{{ $user->name }}</strong> ({{ $user->email }})
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.posts.create') }}"
                    class="bg-lmgp-gold hover:bg-lmgp-goldLight text-lmgp-blueDark font-bold px-4 py-2 rounded text-xs shadow transition flex items-center gap-1.5">
                    <i class="fa-solid fa-plus"></i> Redactar Novedad
                </a>

                <!-- CENTRO DE RESPALDOS CON MENÚ DESPLEGABLE (NATIVO HTML, SIN DEPENDER DE JS) -->
                <details class="relative inline-block text-left group">
                    <summary
                        class="inline-flex items-center gap-2 px-3.5 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded shadow transition border border-slate-700 cursor-pointer list-none select-none [&::-webkit-details-marker]:hidden">
                        <svg class="h-4 w-4 text-[#C5A059]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span>Respaldar Sistema</span>
                        <svg class="h-3 w-3 text-slate-400 group-open:rotate-180 transition-transform" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>

                    <!-- MENÚ FLOTANTE DE 3 OPCIONES -->
                    <div
                        class="absolute right-0 mt-2 w-72 origin-top-right bg-white rounded-lg shadow-xl ring-1 ring-black ring-opacity-5 divide-y divide-slate-100 z-50 overflow-hidden">
                        <div class="p-3 bg-slate-50 border-b border-slate-100">
                            <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-500">
                                Seleccione el tipo de respaldo
                            </span>
                        </div>
                        <div class="py-1">
                            <!-- 1. Base de datos -->
                            <a href="{{ route('admin.backup.download', ['tipo' => 'db']) }}"
                                class="flex items-start gap-3 px-4 py-3 hover:bg-slate-50 transition-colors group">
                                <span class="p-2 bg-blue-50 text-[#0F2942] rounded-md group-hover:bg-blue-100">💾</span>
                                <div>
                                    <strong class="block text-xs font-bold text-slate-800">Solo Base de Datos
                                        (.sql)</strong>
                                    <span class="text-[11px] text-slate-500">Publicaciones, usuarios, niveles y auditoría.
                                        Ultrarrápido.</span>
                                </div>
                            </a>
                            <!-- 2. Archivos y Adjuntos -->
                            <a href="{{ route('admin.backup.download', ['tipo' => 'files']) }}"
                                class="flex items-start gap-3 px-4 py-3 hover:bg-slate-50 transition-colors group">
                                <span class="p-2 bg-amber-50 text-[#C5A059] rounded-md group-hover:bg-amber-100">📁</span>
                                <div>
                                    <strong class="block text-xs font-bold text-slate-800">Solo Archivos y Fotos
                                        (.zip)</strong>
                                    <span class="text-[11px] text-slate-500">Resoluciones PDF, programas de estudio y fotos
                                        subidas.</span>
                                </div>
                            </a>
                            <!-- 3. Respaldo Integral -->
                            <a href="{{ route('admin.backup.download', ['tipo' => 'full']) }}"
                                class="flex items-start gap-3 px-4 py-3 hover:bg-slate-50 transition-colors group">
                                <span
                                    class="p-2 bg-emerald-50 text-emerald-700 rounded-md group-hover:bg-emerald-100">📦</span>
                                <div>
                                    <strong class="block text-xs font-bold text-slate-800">Respaldo Integral Completo
                                        (.zip)</strong>
                                    <span class="text-[11px] text-slate-500">Base de datos completa + Todos los adjuntos
                                        juntos.</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </details>

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-bold px-4 py-2 rounded text-xs shadow transition flex items-center gap-1.5"
                        title="Cerrar Sesión">
                        <i class="fa-solid fa-power-off"></i>
                        <span>Cerrar Sesión</span>
                    </button>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div
                class="mb-6 bg-emerald-50 border-l-4 border-emerald-600 p-4 text-xs font-semibold text-emerald-800 rounded-r shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- SECCIÓN EXCLUSIVA MASTER ADMIN: Bandeja de Visto Bueno / Aprobación -->
        @if ($user->role === 'master_admin')
            <section class="mb-10 bg-amber-50/60 border-2 border-amber-300 rounded-xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base font-black text-amber-900 uppercase tracking-tight flex items-center gap-2">
                        <i class="fa-solid fa-stamp text-amber-700 text-lg"></i>
                        Bandeja de Aprobaciones Pendientes (Visto Bueno Requerido)
                    </h2>
                    <span class="bg-amber-600 text-white font-bold text-xs px-2.5 py-0.5 rounded-full">
                        {{ $pendingPosts->count() }} pendiente(s)
                    </span>
                </div>
                @if ($pendingPosts->count() > 0)
                    <div class="space-y-3">
                        @foreach ($pendingPosts as $pending)
                            <div
                                class="bg-white p-4 rounded-lg border border-amber-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div>
                                    <div class="flex items-center gap-2 text-xs mb-1">
                                        <span class="font-bold text-lmgp-blue">{{ $pending->category->name }}</span>
                                        <span class="text-slate-400">•</span>
                                        <span class="text-slate-500">Autor: <strong>{{ $pending->user->name }}</strong>
                                            (Secretaría)
                                        </span>
                                        <span class="text-slate-400">•</span>
                                        <span class="text-slate-400">{{ $pending->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <h3 class="font-bold text-slate-900 text-sm">{{ $pending->title }}</h3>
                                    <p class="text-xs text-slate-600 mt-1 line-clamp-1">{{ $pending->excerpt }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <form action="{{ route('admin.posts.approve', $pending->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-2 rounded shadow transition flex items-center gap-1">
                                            <i class="fa-solid fa-check"></i> Dar Visto Bueno y Publicar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-amber-800 italic">No hay publicaciones pendientes de revisión. Todos los
                        contenidos del sitio cuentan con Visto Bueno.</p>
                @endif
            </section>
        @endif

        <!-- Tabla de Publicaciones del Sistema -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-5 border-b border-slate-200 bg-slate-50 flex items-center justify-between">
                <h3 class="font-bold text-slate-800 text-sm uppercase">Listado de Comunicados y Novedades</h3>
                <span class="text-xs text-slate-400">Total registradas: {{ $myPosts->total() }}</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead
                        class="bg-slate-100 text-slate-700 uppercase font-semibold text-[11px] border-b border-slate-200">
                        <tr>
                            <th class="p-3.5">Título</th>
                            <th class="p-3.5">Categoría</th>
                            <th class="p-3.5">Autor</th>
                            <th class="p-3.5">Estado</th>
                            <th class="p-3.5">Fecha</th>
                            <th class="p-3.5">Vigencia</th>
                            <th class="p-3.5 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($myPosts as $p)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-3.5">
                                    {{-- Botón que abre el modal al hacer clic en el título --}}
                                    <button type="button"
                                        onclick="document.getElementById('modal-post-{{ $p->id }}').showModal()"
                                        class="font-bold text-slate-800 hover:text-blue-700 hover:underline text-left inline-flex items-center gap-1.5 group cursor-pointer"
                                        title="Clic para ver vista rápida">
                                        <span>{{ $p->title }}</span>
                                        <span class="text-slate-400 group-hover:text-blue-600 text-xs">👁️</span>
                                    </button>

                                    {{-- MODAL NATIVO HTML5 (<dialog>) --}}
                                    <dialog id="modal-post-{{ $p->id }}"
                                        onclick="if (event.target === this) this.close();"
                                        class="rounded-2xl shadow-2xl p-0 max-w-2xl w-full backdrop:bg-slate-900/60 backdrop:backdrop-blur-sm border border-slate-200 overflow-hidden">
                                        <div class="bg-white flex flex-col max-h-[85vh]">

                                            {{-- Cabecera --}}
                                            <div
                                                class="p-4 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
                                                <div class="flex items-center gap-2">
                                                    <span
                                                        class="text-[10px] font-bold uppercase tracking-wider text-blue-800 bg-blue-100 px-2 py-0.5 rounded">
                                                        {{ $p->category->name }}
                                                    </span>
                                                    <span class="text-xs text-slate-500">Por: <strong
                                                            class="text-slate-700">{{ $p->user->name ?? 'LMGP' }}</strong></span>
                                                </div>
                                                <button type="button"
                                                    onclick="document.getElementById('modal-post-{{ $p->id }}').close()"
                                                    class="text-slate-400 hover:text-slate-700 text-lg font-bold px-2 py-0.5 rounded hover:bg-slate-100 transition cursor-pointer">
                                                    ✕
                                                </button>
                                            </div>

                                            {{-- Cuerpo con Scroll --}}
                                            <div class="p-6 overflow-y-auto space-y-4">
                                                <h2 class="text-lg sm:text-xl font-black text-slate-900 leading-snug">
                                                    {{ $p->title }}
                                                </h2>

                                                {{-- Imagen con carga diferida (lazy) para no consumir recursos anticipados --}}
                                                @if ($p->featured_image)
                                                    <img src="{{ asset($p->featured_image) }}"
                                                        alt="Portada de {{ $p->title }}" loading="lazy"
                                                        class="w-full max-h-60 object-cover rounded-xl border border-slate-200 shadow-sm">
                                                @endif

                                                @if ($p->excerpt)
                                                    <div
                                                        class="p-3 bg-slate-50 border-l-4 border-lmgp-blue rounded-r text-xs text-slate-700 italic">
                                                        {{ $p->excerpt }}
                                                    </div>
                                                @endif

                                                <div class="text-xs text-slate-700 leading-relaxed whitespace-pre-line">
                                                    {{ $p->body }}
                                                </div>

                                                {{-- Adjuntos descargables --}}
                                                @if ($p->attachments && $p->attachments->count() > 0)
                                                    <div class="pt-3 border-t border-slate-100">
                                                        <span
                                                            class="text-[11px] font-bold text-slate-500 uppercase block mb-1.5">Documentos
                                                            Adjuntos:</span>
                                                        <div class="flex flex-wrap gap-2">
                                                            @foreach ($p->attachments as $att)
                                                                <a href="{{ route('attachments.download', $att->id) }}"
                                                                    class="inline-flex items-center gap-1.5 text-xs text-blue-700 hover:underline bg-blue-50 px-2.5 py-1 rounded border border-blue-200">
                                                                    📄 <span
                                                                        class="font-medium">{{ $att->title }}</span>
                                                                    <span
                                                                        class="text-slate-400">({{ round($att->file_size / 1024, 1) }}
                                                                        KB)</span>
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            {{-- Pie del modal --}}
                                            <div
                                                class="p-3.5 bg-slate-50 border-t border-slate-200 flex items-center justify-between">
                                                <a href="{{ route('posts.show', $p->slug) }}" target="_blank"
                                                    class="text-xs font-semibold text-blue-700 hover:underline flex items-center gap-1">
                                                    Abrir en portada pública ↗
                                                </a>
                                                <button type="button"
                                                    onclick="document.getElementById('modal-post-{{ $p->id }}').close()"
                                                    class="px-3.5 py-1.5 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold rounded transition cursor-pointer">
                                                    Cerrar (Esc)
                                                </button>
                                            </div>
                                        </div>
                                    </dialog>
                                </td>
                                <td class="p-3.5">{{ $p->category->name }}</td>
                                <td class="p-3.5">{{ $p->user->name ?? 'LMGP' }}</td>
                                <td class="p-3.5">
                                    @if ($p->status === 'published')
                                        <span
                                            class="bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded font-bold">Publicado</span>
                                    @elseif($p->status === 'pending_approval')
                                        <span class="bg-amber-100 text-amber-800 px-2 py-0.5 rounded font-bold">Esperando
                                            Visto Bueno</span>
                                    @elseif($p->status === 'archived')
                                        <span
                                            class="bg-slate-200 text-slate-700 px-2 py-0.5 rounded font-bold">Archivado</span>
                                    @else
                                        <span
                                            class="bg-slate-200 text-slate-700 px-2 py-0.5 rounded font-bold">Borrador</span>
                                    @endif
                                </td>
                                <td class="p-3.5 text-slate-400">
                                    {{ $p->published_at ? $p->published_at->format('d/m/Y') : $p->created_at->format('d/m/Y') }}
                                </td>
                                <!-- SEMÁFORO DE VIGENCIA -->
                                <td class="p-3.5 whitespace-nowrap">
                                    @if (!empty($p->is_permanent))
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-purple-50 text-purple-700 border border-purple-200">
                                            <i class="fa-solid fa-infinity text-[10px]"></i> Permanente
                                        </span>
                                    @elseif($p->status === 'archived' || (!empty($p->expires_at) && \Carbon\Carbon::parse($p->expires_at)->isPast()))
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-600 border border-slate-300">
                                            🔴 Archivado / Vencido
                                        </span>
                                    @elseif(!empty($p->expires_at))
                                        @php
                                            $fechaVence = \Carbon\Carbon::parse($p->expires_at);
                                            $diasRestantes = (int) now()->diffInDays($fechaVence, false);
                                        @endphp
                                        @if ($diasRestantes <= 5)
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-800 border border-amber-300 animate-pulse">
                                                🟡 Vence en {{ max(1, $diasRestantes) }} d
                                                ({{ $fechaVence->format('d/m') }})
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-300">
                                                🟢 Vigente ({{ $diasRestantes }} d)
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-slate-400 text-[11px]">-</span>
                                    @endif
                                </td>
                                <!-- ACCIONES: GESTIÓN COMPLETA (MODIFICAR, ARCHIVAR, BAJA Y PRÓRROGA) -->
                                <td class="p-3.5 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5 justify-end">

                                        {{-- 1. BOTÓN MODIFICAR / EDITAR --}}
                                        @if ($user->role === 'master_admin' || $p->user_id === $user->id)
                                            <a href="{{ route('admin.posts.edit', $p->id) }}"
                                                class="p-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded border border-blue-200 shadow-sm transition flex items-center justify-center text-xs w-7 h-7"
                                                title="Modificar comunicado">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        @endif

                                        {{-- 2. BOTÓN ARCHIVAR (Si está publicado) --}}
                                        @if ($p->status === 'published' && ($user->role === 'master_admin' || $p->user_id === $user->id))
                                            <form action="{{ route('admin.posts.archive', $p->id) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('¿Deseas archivar esta publicación? Se retirará de la portada pública.');">
                                                @csrf
                                                <button type="submit"
                                                    class="p-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded border border-amber-200 shadow-sm transition flex items-center justify-center text-xs w-7 h-7"
                                                    title="Archivar (Retirar de portada)">
                                                    <i class="fa-solid fa-box-archive"></i>
                                                </button>
                                            </form>
                                        @endif

                                        {{-- 3. BOTÓN DAR DE BAJA / ELIMINAR --}}
                                        @if ($user->role === 'master_admin' || $p->user_id === $user->id)
                                            <form action="{{ route('admin.posts.destroy', $p->id) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('¿Confirmas la baja definitiva de este comunicado? Esta acción no se puede deshacer.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded border border-rose-200 shadow-sm transition flex items-center justify-center text-xs w-7 h-7"
                                                    title="Dar de baja / Eliminar">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        @endif

                                        {{-- 4. BOTÓN REPUBLICAR (Si está archivada o vencida) --}}
                                        @if (
                                            $user->role === 'master_admin' &&
                                                ($p->status === 'archived' || (!empty($p->expires_at) && \Carbon\Carbon::parse($p->expires_at)->isPast())))
                                            <form action="{{ route('admin.posts.republish', $p->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="px-2.5 py-1 bg-lmgp-blue hover:bg-lmgp-blueDark text-white text-xs font-bold rounded shadow-sm transition flex items-center gap-1.5"
                                                    title="Republicar por 30 días">
                                                    <i class="fa-solid fa-rotate-right text-lmgp-gold"></i>
                                                    <span>Republicar</span>
                                                </button>
                                            </form>
                                        @endif

                                        {{-- 5. BOTONERA DE PRÓRROGA RÁPIDA (+10d, +15d, +30d) --}}
                                        @if ($p->status === 'published' && empty($p->is_permanent))
                                            <div
                                                class="inline-flex items-center rounded-lg bg-slate-100 p-0.5 border border-slate-200 shadow-inner ml-1">
                                                <span
                                                    class="text-[9px] font-bold text-slate-400 px-1 uppercase select-none">Prorrogar:</span>
                                                <form action="{{ route('admin.posts.extend', $p->id) }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    <input type="hidden" name="dias" value="10">
                                                    <button type="submit"
                                                        class="px-1.5 py-0.5 text-[10px] font-bold rounded bg-white hover:bg-slate-200 text-slate-700 shadow-sm transition mr-0.5"
                                                        title="Extender 10 días">
                                                        +10d
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.posts.extend', $p->id) }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    <input type="hidden" name="dias" value="15">
                                                    <button type="submit"
                                                        class="px-1.5 py-0.5 text-[10px] font-bold rounded bg-white hover:bg-slate-200 text-slate-700 shadow-sm transition mr-0.5"
                                                        title="Extender 15 días">
                                                        +15d
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.posts.extend', $p->id) }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    <input type="hidden" name="dias" value="30">
                                                    <button type="submit"
                                                        class="px-1.5 py-0.5 text-[10px] font-bold rounded bg-lmgp-blue hover:bg-lmgp-blueDark text-white shadow-sm transition"
                                                        title="Extender 30 días">
                                                        +30d
                                                    </button>
                                                </form>
                                            </div>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if ($myPosts->hasPages())
                <div class="p-4 border-t border-slate-200 bg-slate-50">
                    {{ $myPosts->links() }}
                </div>
            @endif
        </div>
    </div>

    <script>
        // Cierra el menú desplegable si el usuario hace clic afuera de él
        document.addEventListener('click', function(e) {
            document.querySelectorAll('details.group').forEach(function(detail) {
                if (!detail.contains(e.target)) {
                    detail.removeAttribute('open');
                }
            });
        });
    </script>
@endsection
