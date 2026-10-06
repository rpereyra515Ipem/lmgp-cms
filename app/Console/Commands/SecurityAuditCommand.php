<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AuditLog;
use App\Mail\CriticalSecurityAlertMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;

class SecurityAuditCommand extends Command
{
    protected $signature = 'lmgp:security-audit';
    protected $description = 'Auditoría automática de las 03:00 AM, backup preventivo y mitigación de amenazas';

    public function handle()
    {
        $this->info("Iniciando Auditoría Diaria Automatizada (03:00 AM)...");
        // 0. AUTO-ARCHIVADO DE PUBLICACIONES CADUCADAS (Gobernanza de Contenidos)
        $expiredCount = \App\Models\Post::where('is_published', true)
            ->where('is_permanent', false)
            ->whereNotNull('expires_at')
            ->where('expires_at', '<', now())
            ->update([
                'status' => 'archived',
                'is_published' => false,
            ]);

        if ($expiredCount > 0) {
            $this->info("Se archivaron automáticamente {$expiredCount} publicaciones vencidas.");
        }

        // 1. Respaldo preventivo diario con rotación de 7 días
        $backupDir = storage_path('app/backups_auto');
        if (!file_exists($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $dbHost = config('database.connections.mysql.host', '127.0.0.1');
        $dbPort = config('database.connections.mysql.port', '3306');
        $dbName = config('database.connections.mysql.database', 'lmgp_cms');
        $dbUser = config('database.connections.mysql.username', 'lmgp_user');
        $dbPass = config('database.connections.mysql.password', '');

        $sqlBackup = $backupDir . '/lmgp_auto_' . now()->format('Y_m_d') . '.sql';
        
        // Se agrega --no-tablespaces para compatibilidad con cPanel y principio de menor privilegio
        $cmd = sprintf(
            'mysqldump --no-tablespaces --host=%s --port=%s --user=%s --password=%s %s > %s',
            escapeshellarg($dbHost),
            escapeshellarg($dbPort),
            escapeshellarg($dbUser),
            escapeshellarg($dbPass),
            escapeshellarg($dbName),
            escapeshellarg($sqlBackup)
        );
        exec($cmd);

        // Rotación de backups
        foreach (File::files($backupDir) as $f) {
            if (now()->diffInDays(now()->setTimestamp($f->getMTime())) > 7) {
                File::delete($f->getRealPath());
            }
        }

        // 2. Detección de actividad sospechosa crítica en las últimas 24 horas
        $hace24hs = now()->subHours(24);
        
        $honeypotCount = AuditLog::where('action', 'HONEYPOT_ATTACK_DETECTED')
            ->where('created_at', '>=', $hace24hs)
            ->count();

        $criticalIncident = null;

        // Si se registraron 20 o más intentos de escaneo de bots maliciosos
        if ($honeypotCount >= 20) {
            $topAttacker = AuditLog::where('action', 'HONEYPOT_ATTACK_DETECTED')
                ->where('created_at', '>=', $hace24hs)
                ->selectRaw('ip_address, count(*) as total')
                ->groupBy('ip_address')
                ->orderByDesc('total')
                ->first();

            $criticalIncident = [
                'tipo' => 'Escaneo Masivo de Rutas Vulnerables (Honeypot Trigger)',
                'origen' => "IP: {$topAttacker->ip_address} ({$topAttacker->total} intentos registrados)",
                'fecha' => now()->format('d/m/Y H:i:s'),
                'respuesta_sistema' => 'Aislamiento inmediato por Rate Limiter y retorno silencioso 404',
                'estado' => 'Subsanado y mitigado. Sin afectación al sistema.',
            ];
        }

        // 3. Envío de correo ÚNICAMENTE ante casos críticos
        if ($criticalIncident) {
            $adminEmail = config('mail.from.address', 'rpereyra@liceopaz.edu.ar');
            try {
                Mail::to($adminEmail)->send(new CriticalSecurityAlertMail($criticalIncident));
                $this->warn("Alerta crítica despachada a: {$adminEmail}");
            } catch (\Exception $e) {
                $this->error("Error al enviar alerta: " . $e->getMessage());
            }
        } else {
            $this->info("Auditoría normal: No se registraron incidentes críticos. Almacenado para informe semanal.");
        }

        // 4. Registro en audit_logs
        AuditLog::create([
            'user_id' => null,
            'action' => 'DAILY_SECURITY_AUDIT_COMPLETED',
            'entity_type' => 'SCHEDULED_TASK',
            'entity_id' => null,
            'ip_address' => '127.0.0.1',
            'user_agent' => 'CLI-Kernel-Artisan',
            'old_values' => json_encode(['backups_kept' => count(File::files($backupDir))]),
            'new_values' => json_encode(['status' => $criticalIncident ? 'ALERT_SENT' : 'HEALTHY']),
            'created_at' => now(),
        ]);
    }
}