<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use ZipArchive;

class BackupController extends Controller
{
    public function download(Request $request)
    {
        $type = $request->query('tipo', 'db'); // 'db', 'files' o 'full'

        // Registro de Auditoría (ISO 27001 / OWASP A09)
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'BACKUP_DOWNLOAD_' . strtoupper($type),
            'entity_type' => 'SYSTEM_BACKUP',
            'entity_id' => null,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
        ]);

        $timestamp = now()->format('Y_m_d_His');
        $dbHost = config('database.connections.mysql.host', '127.0.0.1');
        $dbPort = config('database.connections.mysql.port', '3306');
        $dbName = config('database.connections.mysql.database', 'lmgp_cms');
        $dbUser = config('database.connections.mysql.username', 'lmgp_user');
        $dbPass = config('database.connections.mysql.password', '');

        // 1. SOLO BASE DE DATOS (.sql)
        if ($type === 'db') {
            $fileName = "lmgp_backup_db_{$timestamp}.sql";

            return response()->streamDownload(function () use ($dbHost, $dbPort, $dbName, $dbUser, $dbPass) {
                $cmd = sprintf(
                    'mysqldump --no-tablespaces --host=%s --port=%s --user=%s --password=%s %s',
                    escapeshellarg($dbHost),
                    escapeshellarg($dbPort),
                    escapeshellarg($dbUser),
                    escapeshellarg($dbPass),
                    escapeshellarg($dbName)
                );
                passthru($cmd);
            }, $fileName, ['Content-Type' => 'application/x-sql']);
        }

        // 2. SOLO ARCHIVOS Y ADJUNTOS (.zip)
        if ($type === 'files') {
            $zipFileName = "lmgp_archivos_{$timestamp}.zip";
            $zipPath = storage_path("app/{$zipFileName}");

            $zip = new ZipArchive;
            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                $storagePublic = storage_path('app/public');
                if (file_exists($storagePublic)) {
                    $files = new \RecursiveIteratorIterator(
                        new \RecursiveDirectoryIterator($storagePublic, \RecursiveDirectoryIterator::SKIP_DOTS),
                        \RecursiveIteratorIterator::LEAVES_ONLY
                    );

                    foreach ($files as $file) {
                        if (!$file->isDir()) {
                            $filePath = $file->getRealPath();
                            $relativePath = substr($filePath, strlen($storagePublic) + 1);
                            $zip->addFile($filePath, "archivos/" . $relativePath);
                        }
                    }
                }
                $zip->close();
            }

            return response()->download($zipPath)->deleteFileAfterSend(true);
        }

        // 3. RESPALDO INTEGRAL COMPLETO (BD + ARCHIVOS EN UN ZIP)
        if ($type === 'full') {
            $zipFileName = "lmgp_backup_completo_{$timestamp}.zip";
            $zipPath = storage_path("app/{$zipFileName}");
            $sqlTemp = storage_path("app/temp_db_{$timestamp}.sql");

            $cmd = sprintf(
                'mysqldump --no-tablespaces --host=%s --port=%s --user=%s --password=%s %s > %s',
                escapeshellarg($dbHost),
                escapeshellarg($dbPort),
                escapeshellarg($dbUser),
                escapeshellarg($dbPass),
                escapeshellarg($dbName),
                escapeshellarg($sqlTemp)
            );
            exec($cmd);

            $zip = new ZipArchive;
            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                if (file_exists($sqlTemp)) {
                    $zip->addFile($sqlTemp, "base_de_datos.sql");
                }

                $storagePublic = storage_path('app/public');
                if (file_exists($storagePublic)) {
                    $files = new \RecursiveIteratorIterator(
                        new \RecursiveDirectoryIterator($storagePublic, \RecursiveDirectoryIterator::SKIP_DOTS),
                        \RecursiveIteratorIterator::LEAVES_ONLY
                    );

                    foreach ($files as $file) {
                        if (!$file->isDir()) {
                            $filePath = $file->getRealPath();
                            $relativePath = substr($filePath, strlen($storagePublic) + 1);
                            $zip->addFile($filePath, "adjuntos/" . $relativePath);
                        }
                    }
                }
                $zip->close();
            }

            if (file_exists($sqlTemp)) {
                unlink($sqlTemp);
            }

            return response()->download($zipPath)->deleteFileAfterSend(true);
        }
    }
}