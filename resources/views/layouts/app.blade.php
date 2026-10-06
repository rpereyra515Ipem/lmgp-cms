<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Liceo Militar General Paz') }} - @yield('title', 'Portal Institucional')</title>
    <!-- Favicon Oficial: Escudo del Liceo Militar General Paz -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-lmgp.png') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2">
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
                            granate: '#7B1123',
                            granateDark: '#5E0C1A',
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
    <div class="bg-lmgp-blueDark text-white text-xs py-2 px-4 border-b-2 border-lmgp-granate">
        <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center gap-2">
            <div class="flex items-center space-x-3">
                <span class="font-bold tracking-wider text-lmgp-gold">EJÉRCITO ARGENTINO</span>
                <span class="text-slate-500">•</span>
                <span class="font-semibold text-slate-200">Liceo Militar "General Paz"</span>
                <span class="hidden md:inline text-slate-500">•</span>
                <span
                    class="hidden md:inline bg-lmgp-granate text-white font-bold px-2 py-0.5 rounded text-[10px] tracking-wide uppercase shadow-sm">
                    Arma de Artillería
                </span>
                <span class="hidden md:inline text-slate-500">•</span>
                <span class="hidden md:inline italic text-slate-300">"Verdad - Justicia - Equidad"</span>
            </div>

            <!-- Ecosistema Digital y Acceso Rápido -->
            <div class="flex items-center space-x-4 text-xs">
                <a href="https://classroom.google.com" target="_blank" rel="noopener noreferrer"
                    class="text-slate-300 hover:text-lmgp-gold transition flex items-center gap-1">
                    <i class="fa-solid fa-chalkboard-user text-emerald-400"></i> Classroom
                </a>
                <a href="{{ config('services.moodle.url', '#') }}" target="_blank" rel="noopener noreferrer"
                    class="text-slate-300 hover:text-lmgp-gold transition flex items-center gap-1">
                    <i class="fa-solid fa-graduation-cap text-amber-400"></i> Moodle
                </a>
                <a href="https://mail.google.com" target="_blank" rel="noopener noreferrer"
                    class="text-slate-300 hover:text-lmgp-gold transition flex items-center gap-1">
                    <i class="fa-solid fa-envelope text-red-400"></i> Correo
                </a>
                <span class="text-slate-600 hidden sm:inline">|</span>
                @guest
                    <a href="{{ route('login') }}"
                        class="text-lmgp-gold hover:text-white font-bold transition flex items-center gap-1">
                        <i class="fa-solid fa-key"></i> Ingreso Personal
                    </a>
                @else
                    <a href="{{ route('admin.dashboard') }}"
                        class="text-lmgp-goldLight hover:text-white font-bold transition flex items-center gap-1">
                        <img src="{{ asset('images/logo-lmgp.png') }}"
                            class="h-3.5 w-auto inline mr-1 filter brightness-125" alt="LMGP"> Panel
                        ({{ Auth::user()->role === 'master_admin' ? 'Admin' : 'Secretaría' }})
                    </a>
                @endguest
            </div>
        </div>
    </div>

    <!-- Navegación Principal -->
    <header class="bg-white shadow-md sticky top-0 z-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logotipo Oficial con Cañones Cruzados -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <img src="{{ asset('images/logo-lmgp.png') }}"
                        alt="Escudo Oficial Liceo Militar General Paz - Cañones de Artillería"
                        class="h-11 w-auto object-contain py-1 group-hover:scale-105 transition transform">
                    <div>
                        <div
                            class="text-lg font-black text-lmgp-blue uppercase tracking-tight group-hover:text-lmgp-gold transition leading-none">
                            Liceo Militar
                        </div>
                        <div class="text-xs font-bold tracking-widest text-slate-500 uppercase mt-1">
                            "General Paz"
                        </div>
                    </div>
                </a>

                <!-- Enlaces de Navegación -->
                <nav class="hidden lg:flex items-center space-x-4 text-sm font-semibold text-slate-700">
                    <a href="{{ route('home') }}"
                        class="hover:text-lmgp-blue transition py-2 {{ request()->routeIs('home') ? 'text-lmgp-blue font-bold' : '' }}">Inicio</a>

                    <!-- Pestaña Actividades añadida -->
                    <a href="{{ route('actividades.index') }}"
                        class="hover:text-lmgp-blue transition py-2 flex items-center gap-1.5 {{ request()->routeIs('actividades.*') ? 'text-lmgp-blue font-bold border-b-2 border-lmgp-gold' : '' }}">
                        <i class="fa-solid fa-camera-retro text-lmgp-gold text-xs"></i>
                        <span>Actividades</span>
                    </a>

                    <a href="{{ route('docentes.index') }}"
                        class="hover:text-lmgp-blue transition py-2 {{ request()->routeIs('docentes.*') ? 'text-lmgp-blue font-bold' : '' }}">Docentes</a>
                    <a href="{{ route('home', ['nivel' => 'nivel-inicial']) }}#comunicados"
                        class="hover:text-lmgp-blue transition py-2">Nivel Inicial</a>
                    <a href="{{ route('home', ['nivel' => 'nivel-primario']) }}#comunicados"
                        class="hover:text-lmgp-blue transition py-2">Nivel Primario</a>
                    <a href="{{ route('home', ['nivel' => 'nivel-secundario']) }}#comunicados"
                        class="hover:text-lmgp-blue transition py-2">Nivel Secundario</a>
                    <a href="{{ route('home', ['nivel' => 'educacion-militar']) }}#comunicados"
                        class="hover:text-lmgp-granate text-slate-800 transition py-2 flex items-center gap-1">
                        <i class="fa-solid fa-crosshairs text-lmgp-granate text-xs"></i> Cuerpo de Cadetes
                    </a>
                    <a href="#servicios-digitales"
                        class="hover:text-lmgp-blue transition py-2 text-lmgp-blue font-bold flex items-center gap-1">
                        <i class="fa-solid fa-laptop-code text-lmgp-gold"></i> Campus
                    </a>
                    <a href="{{ route('home', ['categoria' => 'admisiones']) }}#comunicados"
                        class="bg-lmgp-gold hover:bg-lmgp-goldLight text-lmgp-blueDark px-3.5 py-2 rounded font-bold shadow-sm transition">
                        <i class="fa-solid fa-user-plus mr-1"></i> Admisiones
                    </a>

                    <!-- BOTÓN DE LOGIN / PANEL SEGÚN ESTADO DE SESIÓN -->
                    @guest
                        <a href="{{ route('login') }}"
                            class="border border-slate-300 hover:border-lmgp-blue hover:text-lmgp-blue text-slate-700 text-xs font-bold px-3 py-2 rounded transition flex items-center gap-1.5">
                            <i class="fa-solid fa-lock text-lmgp-gold"></i> Ingresar
                        </a>
                    @else
                        <div class="flex items-center space-x-1 pl-2 border-l border-slate-200">
                            <a href="{{ route('admin.dashboard') }}"
                                class="bg-lmgp-blue hover:bg-lmgp-blueDark text-white text-xs font-bold px-3 py-2 rounded shadow transition flex items-center gap-1.5">
                                <img src="{{ asset('images/logo-lmgp.png') }}" class="h-4 w-auto inline mr-1.5"
                                    alt="LMGP"> Mi Panel
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-3 py-2 rounded shadow transition flex items-center gap-1.5"
                                    title="Cerrar Sesión Segura">
                                    <i class="fa-solid fa-power-off"></i>
                                    <span>Cerrar Sesión</span>
                                </button>
                            </form>
                        </div>
                    @endguest
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8 mb-8 text-sm">
            <div class="md:col-span-1">
                <div class="flex items-center space-x-2 mb-3">
                    <img src="{{ asset('images/logo-lmgp.png') }}" alt="LMGP"
                        class="h-10 w-auto brightness-200">
                    <div>
                        <h3 class="text-lmgp-gold font-bold uppercase tracking-wider text-sm leading-tight">Liceo
                            Militar</h3>
                        <span class="text-xs text-slate-300 font-semibold uppercase">General Paz</span>
                    </div>
                </div>
                <p class="text-slate-300 leading-relaxed mb-3 text-xs">
                    Unidad educativa preuniversitaria formadora de ciudadanos comprometidos con los valores éticos,
                    republicanos y el amor a la Patria.
                </p>
                <div class="text-[11px] text-lmgp-goldLight border-l-2 border-lmgp-granate pl-2 font-medium">
                    Especialidad: Subtenientes de Reserva del Arma de Artillería.
                </div>
            </div>
            <div>
                <h3 class="text-lmgp-gold font-bold uppercase tracking-wider text-base mb-3">Ecosistema Digital</h3>
                <ul class="space-y-2 text-xs text-slate-300">
                    <li><a href="https://classroom.google.com" target="_blank" class="hover:text-lmgp-gold"><i
                                class="fa-solid fa-chalkboard text-emerald-400 mr-2"></i> Google Classroom</a></li>
                    <li><a href="{{ config('services.moodle.url', '#') }}" target="_blank"
                            class="hover:text-lmgp-gold"><i
                                class="fa-solid fa-graduation-cap text-amber-400 mr-2"></i> Campus Virtual Moodle</a>
                    </li>
                    <li><a href="https://mail.google.com" target="_blank" class="hover:text-lmgp-gold"><i
                                class="fa-solid fa-envelope text-red-400 mr-2"></i> Correo @liceopaz.edu.ar</a></li>
                    <li><a href="https://mail.google.com" target="_blank" class="hover:text-lmgp-gold"><i
                                class="fa-solid fa-user-graduate text-blue-400 mr-2"></i> Correo
                            @alumnos.liceopaz.edu.ar</a></li>
                    <li><a href="{{ config('services.koha.url', '#') }}" class="hover:text-lmgp-gold"><i
                                class="fa-solid fa-book-bookmark text-indigo-400 mr-2"></i> Biblioteca Koha (OPAC)</a>
                    </li>
                </ul>
            </div>
            <div>
                <h3 class="text-lmgp-gold font-bold uppercase tracking-wider text-base mb-3">Contacto Oficial</h3>
                <ul class="space-y-2 text-xs text-slate-300">
                    <li><i class="fa-solid fa-map-location-dot text-lmgp-gold mr-2"></i> Av. Juan B. Justo 5858,
                        Córdoba</li>
                    <li><i class="fa-solid fa-envelope text-lmgp-gold mr-2"></i> lmgp.rrpp@liceopaz.edu.ar</li>
                    <li><i class="fa-solid fa-phone text-lmgp-gold mr-2"></i> +54 9 351 4920720</li>
                    <li><i class="fa-brands fa-whatsapp text-lmgp-gold mr-2"></i> 351 679-2330 (Consultas)</li>
                </ul>
            </div>
            <div>
                <h3 class="text-lmgp-gold font-bold uppercase tracking-wider text-base mb-3">Seguridad y Normativa</h3>
                <p class="text-slate-300 text-xs leading-relaxed mb-4">
                    Plataforma institucional desarrollada conforme a directivas OWASP Top 10, estándares IRAM-ISO 27001
                    y pautas del Comando Conjunto de Ciberdefensa.
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

    @auth
        <!-- Detector de Inactividad de Sesión (OWASP A07 / ISO 27001) -->
        <script>
            (function() {
                var idleTime = 0;
                var maxIdleMinutes = 30;

                function resetTimer() {
                    idleTime = 0;
                }

                window.onload = resetTimer;
                window.onmousemove = resetTimer;
                window.onmousedown = resetTimer;
                window.ontouchstart = resetTimer;
                window.onclick = resetTimer;
                window.onkeypress = resetTimer;
                window.addEventListener("scroll", resetTimer, true);

                setInterval(function() {
                    idleTime++;
                    if (idleTime >= maxIdleMinutes) {
                        alert("Su sesión ha expirado por inactividad (30 minutos) por razones de seguridad.");
                        var logoutForm = document.getElementById("logout-form");
                        if (logoutForm) {
                            logoutForm.submit();
                        } else {
                            window.location.href = "{{ route('login') }}";
                        }
                    }
                }, 60000);
            })
            ();
        </script>
    @endauth
    <!-- WIDGET DEL ASISTENTE VIRTUAL CADETE PAZ -->
    @include('components.chatbot')
</body>

</html>
