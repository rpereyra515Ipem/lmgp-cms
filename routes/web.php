<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocentesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas Públicas Institucionales
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/actividades', [ActivityController::class, 'index'])->name('actividades.index');
Route::get('/docentes', [DocentesController::class, 'index'])->middleware('auth')->name('docentes.index');
Route::get('/comunicados/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/adjuntos/{id}/descargar', [PostController::class, 'downloadAttachment'])->name('attachments.download');

/*
|--------------------------------------------------------------------------
| Autenticación con Rate Limiting Estricto (5 intentos por minuto)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Panel de Administración (Protegido con Roles y Auditoría)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminPostController::class, 'dashboard'])->name('dashboard');
    Route::get('/posts/create', [AdminPostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [AdminPostController::class, 'store'])->name('posts.store');
    Route::post('/posts/{id}/approve', [AdminPostController::class, 'approve'])->name('posts.approve');

    // PRÓRROGA DE VIGENCIA (+10, +15, +30 DÍAS)
    Route::post('/posts/{id}/extend', [AdminPostController::class, 'extend'])->name('posts.extend');

    // MODIFICACIÓN (EDICIÓN Y ACTUALIZACIÓN)
    Route::get('/posts/{id}/edit', [AdminPostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{id}', [AdminPostController::class, 'update'])->name('posts.update');

    // ARCHIVAR / REPUBLICAR
    Route::post('/posts/{id}/archive', [AdminPostController::class, 'archive'])->name('posts.archive');
    Route::post('/posts/{id}/republish', [AdminPostController::class, 'republish'])->name('posts.republish');

    // BAJA / ELIMINACIÓN
    Route::delete('/posts/{id}', [AdminPostController::class, 'destroy'])->name('posts.destroy');

    // Centro de Descargas de Respaldos
    Route::get('/backup/download', [BackupController::class, 'download'])->name('backup.download');
});

/*
|--------------------------------------------------------------------------
| Honeypot Señuelo para Escaneos de WordPress Heredado (OWASP A09 / Ciberdefensa)
|--------------------------------------------------------------------------
*/
Route::any('/{legacy_path}', function (Request $request, $legacy_path) {
    AuditLog::create([
        'user_id' => null,
        'action' => 'HONEYPOT_ATTACK_DETECTED',
        'entity_type' => 'SUSPICIOUS_PROBE',
        'entity_id' => null,
        'ip_address' => $request->ip(),
        'user_agent' => $request->userAgent(),
        'old_values' => json_encode(['requested_path' => $legacy_path, 'method' => $request->method()]),
        'new_values' => json_encode(['defense_action' => 'IP_FLAGGED_SILENT_404']),
        'created_at' => now(),
    ]);

    abort(404);
})->where('legacy_path', 'wp-login\.php|xmlrpc\.php|wp-admin.*|wp-content.*|wp-includes.*');
