<?php

use Illuminate\Support\Facades\Schedule;

// Auditoría y Respaldo automático diario a las 03:00 AM
Schedule::command('lmgp:security-audit')->dailyAt('03:00');

// Informe Semanal Consolidado los lunes a las 04:00 AM
Schedule::command('lmgp:security-weekly')->weeklyOn(1, '04:00');
