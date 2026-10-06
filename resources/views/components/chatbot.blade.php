<!-- BOTÓN FLOTANTE DEL CHATBOT -->
<div id="lmgp-chatbot-container" class="fixed bottom-6 right-6 z-50 font-sans">
    
    <!-- Mensaje de bienvenida flotante (tooltip) -->
    <div id="chatbot-tooltip" class="hidden sm:flex items-center gap-2 bg-white px-3 py-2 rounded-full shadow-lg border border-slate-200 mb-2 cursor-pointer transition-all hover:scale-105">
        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
        <span class="text-xs font-bold text-lmgp-blue">¡Hola! ¿Dudas sobre inscripción o trámites?</span>
    </div>

    <!-- Botón con el Avatar del Cadete -->
    <button id="chatbot-toggle-btn" type="button" class="relative group p-1 bg-gradient-to-tr from-lmgp-blue to-lmgp-blueDark rounded-full shadow-2xl border-2 border-lmgp-gold focus:outline-none transition-transform hover:scale-105">
        <img src="{{ asset('images/avatar-bot.png') }}" alt="Cadete Paz - Asistente Virtual LMGP" class="h-14 w-14 rounded-full object-cover bg-white/20">
        <span class="absolute bottom-1 right-1 w-3.5 h-3.5 bg-emerald-500 border-2 border-white rounded-full"></span>
    </button>

    <!-- VENTANA DEL CHAT -->
    <div id="chatbot-window" class="hidden fixed bottom-20 right-4 sm:right-6 w-[92vw] sm:w-96 max-w-sm h-[520px] bg-white rounded-2xl shadow-2xl border border-slate-200 flex flex-col overflow-hidden z-50">
        
        <!-- CABECERA -->
        <div class="bg-gradient-to-r from-lmgp-blue to-lmgp-blueDark text-white p-4 border-b-2 border-lmgp-gold flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <img src="{{ asset('images/avatar-bot.png') }}" class="h-10 w-10 rounded-full border border-lmgp-gold object-cover bg-white/10" alt="Cadete">
                    <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-400 rounded-full border border-white"></span>
                </div>
                <div>
                    <h3 class="font-bold text-sm leading-tight text-white flex items-center gap-1.5">
                        <span>Cadete Paz</span>
                        <span class="text-[10px] bg-lmgp-granate text-white px-1.5 py-0.2 rounded font-semibold uppercase">Asistente</span>
                    </h3>
                    <p class="text-[11px] text-lmgp-goldLight">Secretaría y Consultas LMGP</p>
                </div>
            </div>
            <button id="chatbot-close-btn" class="text-slate-300 hover:text-white text-lg p-1">
                ✕
            </button>
        </div>

        <!-- CUERPO DE MENSAJES (Scroll) -->
        <div id="chatbot-messages" class="flex-1 p-4 overflow-y-auto space-y-3 bg-slate-50 text-xs text-slate-800">
            <!-- Mensaje inicial del Bot -->
            <div class="flex items-start gap-2">
                <img src="{{ asset('images/avatar-bot.png') }}" class="h-7 w-7 rounded-full object-cover border border-slate-200 mt-0.5" alt="Bot">
                <div class="bg-white p-3 rounded-2xl rounded-tl-sm shadow-sm border border-slate-100 max-w-[85%] space-y-1.5 leading-relaxed">
                    <p class="font-bold text-lmgp-blue">¡Hola! Soy el Cadete Paz, asistente virtual del Liceo Militar General Paz.</p>
                    <p class="text-slate-600">Puedo informarte sobre la documentación requerida para inscripciones, horarios de atención de Secretaría o turnos presenciales. Elegí un tema o escribime tu consulta:</p>
                </div>
            </div>

            <!-- CHIPS / BOTONES DE ACCIÓN RÁPIDA -->
            <div id="quick-chips" class="pt-2 flex flex-wrap gap-1.5">
                <button onclick="sendOption('documentacion')" class="px-2.5 py-1.5 bg-white hover:bg-lmgp-blue hover:text-white text-lmgp-blue rounded-full border border-lmgp-blue/30 text-[11px] font-semibold transition-colors shadow-2xs">
                    📄 Documentación para Inscripción
                </button>
                <button onclick="sendOption('drive')" class="px-2.5 py-1.5 bg-white hover:bg-emerald-700 hover:text-white text-emerald-800 rounded-full border border-emerald-300 text-[11px] font-semibold transition-colors shadow-2xs flex items-center gap-1">
                    <span>📂 Descargar Formularios (Drive)</span>
                </button>
                <button onclick="sendOption('horarios')" class="px-2.5 py-1.5 bg-white hover:bg-slate-800 hover:text-white text-slate-700 rounded-full border border-slate-300 text-[11px] font-semibold transition-colors shadow-2xs">
                    🕒 Horarios de Secretaría
                </button>
                <button onclick="sendOption('niveles')" class="px-2.5 py-1.5 bg-white hover:bg-lmgp-blue hover:text-white text-lmgp-blue rounded-full border border-lmgp-blue/30 text-[11px] font-semibold transition-colors shadow-2xs">
                    🏫 Niveles Educativos
                </button>
                <button onclick="sendOption('turnero')" class="px-2.5 py-1.5 bg-amber-50 hover:bg-amber-600 hover:text-white text-amber-900 rounded-full border border-amber-300 text-[11px] font-bold transition-colors shadow-2xs flex items-center gap-1">
                    <span>📅 Solicitar Turno Presencial</span>
                </button>
            </div>
        </div>

        <!-- INPUT DE ESCRITURA -->
        <form id="chatbot-form" class="p-3 bg-white border-t border-slate-200 flex items-center gap-2">
            <input 
                type="text" 
                id="chatbot-input" 
                placeholder="Escribí tu consulta aquí..." 
                class="flex-1 px-3 py-2 text-xs border border-slate-300 rounded-full focus:outline-none focus:border-lmgp-blue"
            >
            <button type="submit" class="p-2 bg-lmgp-blue text-white rounded-full hover:bg-lmgp-blueDark transition-colors">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </form>

    </div>
</div>

<!-- LÓGICA JAVASCRIPT DEL CHATBOT -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('chatbot-toggle-btn');
    const tooltip = document.getElementById('chatbot-tooltip');
    const chatWindow = document.getElementById('chatbot-window');
    const closeBtn = document.getElementById('chatbot-close-btn');
    const form = document.getElementById('chatbot-form');
    const input = document.getElementById('chatbot-input');
    const messages = document.getElementById('chatbot-messages');

    // Enlace oficial de Drive para descargas (parametrizable)
    const DRIVE_URL = "{{ config('services.drive.formularios_url', 'https://drive.google.com') }}";

    toggleBtn.addEventListener('click', () => {
        chatWindow.classList.toggle('hidden');
        if (tooltip) tooltip.classList.add('hidden');
    });

    if (tooltip) {
        tooltip.addEventListener('click', () => {
            chatWindow.classList.remove('hidden');
            tooltip.classList.add('hidden');
        });
    }

    closeBtn.addEventListener('click', () => chatWindow.classList.add('hidden'));

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const text = input.value.trim();
        if (!text) return;

        appendUserMessage(text);
        input.value = '';
        setTimeout(() => processResponse(text.toLowerCase()), 400);
    });

    window.sendOption = function(option) {
        let label = '';
        if (option === 'documentacion') label = '¿Qué documentación se presenta para la inscripción?';
        else if (option === 'drive') label = 'Quiero descargar los formularios oficiales en Drive';
        else if (option === 'horarios') label = '¿Cuáles son los horarios de atención de Secretaría?';
        else if (option === 'niveles') label = '¿Cuáles son los niveles educativos del Instituto?';
        else if (option === 'turnero') label = 'Quiero solicitar un turno presencial en Secretaría';

        appendUserMessage(label);
        setTimeout(() => executeOption(option), 400);
    };

    function appendUserMessage(text) {
        const div = document.createElement('div');
        div.className = 'flex justify-end';
        div.innerHTML = `<div class="bg-lmgp-blue text-white p-2.5 rounded-2xl rounded-tr-sm max-w-[85%] text-xs shadow-sm">${text}</div>`;
        messages.appendChild(div);
        messages.scrollTop = messages.scrollHeight;
    }

    function appendBotMessage(html) {
        const div = document.createElement('div');
        div.className = 'flex items-start gap-2';
        div.innerHTML = `
            <img src="{{ asset('images/avatar-bot.png') }}" class="h-7 w-7 rounded-full object-cover border border-slate-200 mt-0.5">
            <div class="bg-white p-3 rounded-2xl rounded-tl-sm shadow-sm border border-slate-100 max-w-[85%] text-xs leading-relaxed space-y-1.5">
                ${html}
            </div>
        `;
        messages.appendChild(div);
        messages.scrollTop = messages.scrollHeight;
    }

    function executeOption(option) {
        if (option === 'documentacion') {
            appendBotMessage(`
                <strong class="text-lmgp-blue block">📋 Documentación Obligatoria para Inscripción:</strong>
                <ul class="list-disc pl-4 space-y-1 text-slate-700">
                    <li><strong>DNI del aspirante y tutores</strong> (original y fotocopia).</li>
                    <li><strong>Partida de Nacimiento</strong> actualizada y legalizada.</li>
                    <li><strong>Certificado Único de Salud (CUS)</strong> y ficha médica oficial de aptitud física.</li>
                    <li><strong>Carnet de Vacunación</strong> completo según calendario nacional.</li>
                    <li><strong>Constancia de estudios:</strong> Sala de 5 (para Primario), 6to Grado o Analítico Parcial (para Secundario).</li>
                    <li>4 fotografías 4x4 tipo carnet (fondo blanco).</li>
                </ul>
                <div class="pt-2">
                    <a href="${DRIVE_URL}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded font-bold text-[11px] shadow-sm transition">
                        <span>📂 Descargar Fichas y Anexos en Drive</span>
                    </a>
                </div>
            `);
        } else if (option === 'drive') {
            appendBotMessage(`
                <strong class="text-emerald-800 block">📁 Carpeta Oficial de Descargas:</strong>
                <p class="text-slate-600">En nuestro repositorio institucional de Google Drive encontrarás las fichas médicas (CUS), formularios de matriculación y anexos de autorización listos para imprimir:</p>
                <div class="pt-1.5">
                    <a href="${DRIVE_URL}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded font-bold text-[11px] shadow-sm transition">
                        <span>Acceder al Google Drive Oficial ↗</span>
                    </a>
                </div>
            `);
        } else if (option === 'horarios') {
            appendBotMessage(`
                <strong class="text-lmgp-blue block">🕒 Atención de Secretaría y Dirección:</strong>
                <p><strong>Lunes a Viernes:</strong> de 08:00 a 12:30 hs.</p>
                <p><strong>Ubicación:</strong> 1er Piso del Edificio Central, Av. Juan B. Justo 5858, Córdoba.</p>
                <p><strong>Contacto telefónico:</strong> +54 9 351 4920720</p>
                <p><strong>Consultas por WhatsApp:</strong> 351 679-2330</p>
            `);
        } else if (option === 'niveles') {
            appendBotMessage(`
                <strong class="text-lmgp-blue block">🏫 Oferta Educativa del LMGP:</strong>
                <p>• <strong>Nivel Inicial:</strong> "Semillitas del Paz" (Salas de 4 y 5 años).</p>
                <p>• <strong>Nivel Primario:</strong> Formación integral con inmersión temprana en inglés.</p>
                <p>• <strong>Nivel Secundario:</strong> Bachiller en Ciencias Naturales o en Economía y Administración, egresando con el grado de <em>Subteniente de Reserva del Arma de Artillería</em>.</p>
            `);
        } else if (option === 'turnero') {
    appendBotMessage(`
        <strong class="text-amber-900 block">📅 Solicitud de Turnos Presenciales:</strong>
        <p class="text-slate-600">Para una atención ordenada sin esperas en Secretaría (Inscripciones, Entrega de Papeles)...</p>
        <div class="pt-1.5">
            @if (Route::has('turnos.create'))
                <a href="{{ route('turnos.create') }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-lmgp-blue text-white rounded-md text-sm">
                    <span>Ir al Turnero Digital ➔</span>
                </a>
            @else
                <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-200 text-slate-500 rounded-md text-sm cursor-not-allowed">
                    <span>Turnero Digital (Próximamente)</span>
                </span>
            @endif
        </div>
            `);
        }
    }

    function processResponse(query) {
        if (query.includes('document') || query.includes('requisito') || query.includes('papel') || query.includes('inscri')) {
            executeOption('documentacion');
        } else if (query.includes('drive') || query.includes('descarga') || query.includes('formulario') || query.includes('ficha')) {
            executeOption('drive');
        } else if (query.includes('hora') || query.includes('donde') || query.includes('telefono') || query.includes('ubica') || query.includes('contacto')) {
            executeOption('horarios');
        } else if (query.includes('nivel') || query.includes('primari') || query.includes('secundari') || query.includes('inicial') || query.includes('cadete')) {
            executeOption('niveles');
        } else if (query.includes('turno') || query.includes('cita') || query.includes('atencion')) {
            executeOption('turnero');
        } else {
            appendBotMessage(`
                <p>No estoy seguro de comprender esa consulta específica. Podés consultar las opciones principales o dirigirte a Secretaría:</p>
                <div class="flex flex-col gap-1 pt-1">
                    <button onclick="sendOption('documentacion')" class="text-left text-lmgp-blue underline font-bold">• Ver documentación para inscripción</button>
                    <button onclick="sendOption('drive')" class="text-left text-emerald-700 underline font-bold">• Descargar formularios en Google Drive</button>
                    <button onclick="sendOption('horarios')" class="text-left text-slate-700 underline font-bold">• Conocer horarios de atención</button>
                </div>
            `);
        }
    }
});
</script>