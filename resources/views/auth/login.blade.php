@extends('layouts.app')

@section('title', 'Acceso al Panel de Gestión')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white rounded-xl shadow-md border border-slate-200 p-8">
        <div class="text-center mb-6">
            <img src="{{ asset('images/logo-lmgp.png') }}" class="h-16 mx-auto mb-3" alt="LMGP">
            <h2 class="text-xl font-black text-lmgp-blue uppercase tracking-tight">Panel Institucional LMGP</h2>
            <p class="text-xs text-slate-500 mt-1">Acceso restringido para Dirección, Secretaría y Docentes.</p>
        </div>

        @if($errors->any())
            <div class="mb-4 bg-red-50 border-l-4 border-red-600 p-3 text-xs text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" id="loginForm" class="space-y-4">
            @csrf

            <!-- CORREO INSTITUCIONAL CON SUFIJO FIJO -->
            <div>
                <label for="username" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                    Correo Institucional
                </label>
                <div class="relative flex items-stretch rounded border border-slate-300 focus-within:border-lmgp-blue overflow-hidden">
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        value="{{ old('username') }}" 
                        required 
                        autofocus
                        autocomplete="username"
                        placeholder="usuario"
                        class="w-full px-3 py-2 text-sm text-slate-800 border-0 focus:ring-0 focus:outline-none"
                    >
                    <span class="inline-flex items-center px-3 bg-slate-100 text-slate-500 text-xs sm:text-sm font-medium border-l border-slate-300 select-none">
                        @liceopaz.edu.ar
                    </span>
                </div>
                <!-- Campo oculto que envía el correo completo -->
                <input type="hidden" name="email" id="full_email">
            </div>

            <!-- CONTRASEÑA CON VISOR (OJITO) -->
            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                    Contraseña
                </label>
                <div class="relative rounded border border-slate-300 focus-within:border-lmgp-blue">
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required 
                        autocomplete="current-password"
                        placeholder="••••••••••••"
                        class="w-full px-3 py-2 pr-10 text-sm text-slate-800 rounded border-0 focus:ring-0 focus:outline-none"
                    >
                    <button 
                        type="button" 
                        id="togglePassword" 
                        tabindex="-1"
                        aria-label="Mostrar u ocultar contraseña"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-lmgp-blue focus:outline-none transition-colors"
                    >
                        <!-- Ojo visible -->
                        <svg id="eyeIcon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <!-- Ojo tachado -->
                        <svg id="eyeSlashIcon" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- BOTÓN INICIAR SESIÓN -->
            <button 
                type="submit" 
                class="w-full flex justify-center items-center gap-2 py-2.5 px-4 rounded text-sm font-bold text-white bg-lmgp-blue hover:opacity-90 focus:outline-none transition-opacity shadow-sm"
            >
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <span>Iniciar Sesión</span>
            </button>
        </form>

        <p class="text-center text-[11px] text-slate-400 mt-6">
            Seguridad conforme a estándares OWASP Top 10 e ISO 27001.
        </p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Mantener presionado para ver la contraseña
    const passwordInput = document.getElementById('password');
    const toggleButton = document.getElementById('togglePassword');
    const eyeIcon = document.getElementById('eyeIcon');
    const eyeSlashIcon = document.getElementById('eyeSlashIcon');

    if (toggleButton && passwordInput) {
        const showPassword = () => {
            passwordInput.setAttribute('type', 'text');
            eyeIcon.classList.add('hidden');
            eyeSlashIcon.classList.remove('hidden');
        };

        const hidePassword = () => {
            passwordInput.setAttribute('type', 'password');
            eyeIcon.classList.remove('hidden');
            eyeSlashIcon.classList.add('hidden');
        };

        // Eventos con el mouse (computadora / laptop)
        toggleButton.addEventListener('mousedown', (e) => {
            e.preventDefault(); // Evita perder el foco del campo
            showPassword();
        });
        toggleButton.addEventListener('mouseup', hidePassword);
        toggleButton.addEventListener('mouseleave', hidePassword); // Si arrastra el cursor fuera del botón

        // Eventos táctiles (celulares / tablets)
        toggleButton.addEventListener('touchstart', (e) => {
            e.preventDefault();
            showPassword();
        });
        toggleButton.addEventListener('touchend', hidePassword);
        toggleButton.addEventListener('touchcancel', hidePassword);

        // Accesibilidad por teclado (mantener presionado Espacio o Enter)
        toggleButton.addEventListener('keydown', (e) => {
            if (e.key === ' ' || e.key === 'Enter') {
                e.preventDefault();
                showPassword();
            }
        });
        toggleButton.addEventListener('keyup', hidePassword);
    }

    // 2. Concatenar @liceopaz.edu.ar al enviar el formulario
    const loginForm = document.getElementById('loginForm');
    const usernameInput = document.getElementById('username');
    const fullEmailInput = document.getElementById('full_email');
    const domain = '@liceopaz.edu.ar';

    if (loginForm && usernameInput && fullEmailInput) {
        loginForm.addEventListener('submit', () => {
            let val = usernameInput.value.trim().toLowerCase();
            if (val.endsWith(domain)) {
                val = val.replace(domain, '');
            }
            fullEmailInput.value = val + domain;
        });
    }
});
</script>
@endsection