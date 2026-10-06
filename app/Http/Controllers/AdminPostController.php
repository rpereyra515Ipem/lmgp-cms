<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Attachment;
use App\Models\Category;
use App\Models\EducationalLevel;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminPostController extends Controller
{
    public function dashboard(): View
    {
        $user = Auth::user();

        // Orden cronológico estricto: de la más nueva a la más antigua
        if ($user->role === 'master_admin') {
            $pendingPosts = Post::where('status', 'pending_approval')
                ->with(['user', 'category', 'educationalLevel'])
                ->latest('created_at')
                ->get();
            $posts = Post::with(['user', 'category', 'educationalLevel'])
                ->latest('created_at')
                ->paginate(15);
        } else {
            $pendingPosts = collect();
            $posts = Post::where('user_id', $user->id)
                ->with(['category', 'educationalLevel'])
                ->latest('created_at')
                ->paginate(15);
        }

        $myPosts = $posts;

        $auditLogs = ($user->role === 'master_admin')
            ? AuditLog::with('user')->latest('created_at')->take(8)->get()
            : collect();

        return view('admin.dashboard', compact('user', 'pendingPosts', 'posts', 'myPosts', 'auditLogs'));
    }

    public function create(): View
    {
        $levels = EducationalLevel::all();
        $categories = Category::all();
        return view('admin.create', compact('levels', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'educational_level_id' => 'nullable|exists:educational_levels,id',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'required|string',
            'is_permanent' => 'nullable|boolean',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $user = Auth::user();
        $isMaster = ($user->role === 'master_admin');
        $status = $isMaster ? 'published' : 'pending_approval';
        $isPublished = $isMaster;

        // Procesar Foto de Portada para la actividad
        $featuredImageUrl = null;
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('posts', 'public');
            $featuredImageUrl = '/storage/' . $path;
        }

        // Lógica de Vigencia: 30 días por defecto, o permanente si se tilda la casilla
        $isPermanent = $request->boolean('is_permanent');
        $publishedAt = $isPublished ? now() : null;
        $expiresAt = ($isPermanent || !$isPublished) ? null : now()->addDays(30);

        $post = Post::create([
            'user_id' => $user->id,
            'category_id' => $validated['category_id'],
            'educational_level_id' => $validated['educational_level_id'] ?? null,
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']) . '-' . rand(100, 999),
            'excerpt' => $validated['excerpt'],
            'body' => $validated['body'],
            'featured_image' => $featuredImageUrl,
            'status' => $status,
            'is_published' => $isPublished,
            'published_at' => $publishedAt,
            'expires_at' => $expiresAt,
            'is_permanent' => $isPermanent,
            'approved_by' => $isMaster ? $user->id : null,
            'approved_at' => $isMaster ? now() : null,
        ]);

        // Procesar Adjunto Documental (PDF de circulares)
        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $path = $file->store('documents', 'public');

            Attachment::create([
                'post_id' => $post->id,
                'title' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getClientOriginalExtension(),
                'download_count' => 0,
            ]);
        }

        AuditLog::create([
            'user_id' => $user->id,
            'action' => $isMaster ? 'POST_CREATED_PUBLISHED' : 'POST_SUBMITTED_FOR_APPROVAL',
            'entity_type' => 'Post',
            'entity_id' => $post->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'new_values' => [
                'title' => $post->title,
                'status' => $status,
                'is_permanent' => $isPermanent,
                'expires_at' => $expiresAt?->format('Y-m-d H:i:s'),
                'has_image' => !is_null($featuredImageUrl),
            ],
            'created_at' => now(),
        ]);

        $msg = $isMaster
            ? 'Publicación emitida y publicada con vigencia oficial.'
            : 'Publicación guardada exitosamente. Queda pendiente del Visto Bueno del Master Administrator.';

        return redirect()->route('admin.dashboard')->with('success', $msg);
    }

    public function edit(int $id): View
    {
        $user = Auth::user();
        $post = Post::with(['category', 'educationalLevel'])->findOrFail($id);

        if ($user->role !== 'master_admin' && $post->user_id !== $user->id) {
            abort(403, 'Acceso denegado: no tienes permiso para editar esta publicación.');
        }

        $levels = EducationalLevel::all();
        $categories = Category::all();

        return view('admin.edit', compact('post', 'levels', 'categories'));
    }

    public function update(int $id, Request $request)
    {
        $user = Auth::user();
        $post = Post::findOrFail($id);

        if ($user->role !== 'master_admin' && $post->user_id !== $user->id) {
            abort(403, 'Acceso denegado: no tienes permiso para modificar esta publicación.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'educational_level_id' => 'nullable|exists:educational_levels,id',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'required|string',
            'is_permanent' => 'nullable|boolean',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $isPermanent = $request->boolean('is_permanent');
        $oldValues = [
            'title' => $post->title,
            'category_id' => $post->category_id,
            'is_permanent' => $post->is_permanent,
            'status' => $post->status,
        ];

        // Procesar nueva foto de portada si se envía
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('posts', 'public');
            $post->featured_image = '/storage/' . $path;
        }

        // Si cambió el estado de permanencia
        if ($isPermanent !== (bool)$post->is_permanent) {
            $post->is_permanent = $isPermanent;
            $post->expires_at = $isPermanent ? null : now()->addDays(30);
        }

        $post->title = $validated['title'];
        $post->category_id = $validated['category_id'];
        $post->educational_level_id = $validated['educational_level_id'] ?? null;
        $post->excerpt = $validated['excerpt'];
        $post->body = $validated['body'];
        $post->save();

        // Procesar nuevo documento adjunto si se envía
        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $path = $file->store('documents', 'public');

            Attachment::create([
                'post_id' => $post->id,
                'title' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getClientOriginalExtension(),
                'download_count' => 0,
            ]);
        }

        AuditLog::create([
            'user_id' => $user->id,
            'action' => 'POST_UPDATED',
            'entity_type' => 'Post',
            'entity_id' => $post->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'old_values' => $oldValues,
            'new_values' => [
                'title' => $post->title,
                'category_id' => $post->category_id,
                'is_permanent' => $post->is_permanent,
            ],
            'created_at' => now(),
        ]);

        return redirect()->route('admin.dashboard')->with('success', "Publicación \"{$post->title}\" actualizada correctamente.");
    }

    public function archive(int $id, Request $request)
    {
        $user = Auth::user();
        $post = Post::findOrFail($id);

        if ($user->role !== 'master_admin' && $post->user_id !== $user->id) {
            abort(403, 'Acceso denegado: no tienes permiso para archivar esta publicación.');
        }

        $oldStatus = $post->status;

        $post->update([
            'status' => 'archived',
            'is_published' => false,
        ]);

        AuditLog::create([
            'user_id' => $user->id,
            'action' => 'POST_ARCHIVED',
            'entity_type' => 'Post',
            'entity_id' => $post->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'old_values' => ['status' => $oldStatus, 'is_published' => true],
            'new_values' => ['status' => 'archived', 'is_published' => false],
            'created_at' => now(),
        ]);

        return back()->with('success', "La publicación \"{$post->title}\" fue archivada y retirada de la portada.");
    }

    public function destroy(int $id, Request $request)
    {
        $user = Auth::user();
        $post = Post::findOrFail($id);

        if ($user->role !== 'master_admin' && $post->user_id !== $user->id) {
            abort(403, 'Acceso denegado: no tienes permiso para eliminar esta publicación.');
        }

        AuditLog::create([
            'user_id' => $user->id,
            'action' => 'POST_DELETED',
            'entity_type' => 'Post',
            'entity_id' => $post->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'old_values' => [
                'title' => $post->title,
                'status' => $post->status,
                'category_id' => $post->category_id,
                'user_id' => $post->user_id,
            ],
            'new_values' => null,
            'created_at' => now(),
        ]);

        $postTitle = $post->title;
        $post->delete();

        return redirect()->route('admin.dashboard')->with('success', "La publicación \"{$postTitle}\" ha sido dada de baja.");
    }

    public function approve(int $id, Request $request)
    {
        if (Auth::user()->role !== 'master_admin') {
            abort(403, 'Acceso denegado: solo el Master Administrator puede otorgar el Visto Bueno.');
        }

        $post = Post::findOrFail($id);
        $expiresAt = $post->is_permanent ? null : now()->addDays(30);

        $post->update([
            'status' => 'published',
            'is_published' => true,
            'published_at' => now(),
            'expires_at' => $expiresAt,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'rejection_reason' => null,
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'POST_APPROVED_VISTO_BUENO',
            'entity_type' => 'Post',
            'entity_id' => $post->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
        ]);

        return back()->with('success', "Se otorgó el Visto Bueno oficial a: \"{$post->title}\". Vigencia asignada: 30 días.");
    }

    // PRÓRROGA RÁPIDA (+10, +15, +30 DÍAS)
    public function extend(int $id, Request $request)
    {
        $days = (int) $request->input('dias', 30);
        if ($days != 10 && $days != 15 && $days != 30) {
            $days = 30;
        }

        $post = Post::findOrFail($id);

        $baseDate = ($post->expires_at && $post->expires_at->isFuture()) 
            ? $post->expires_at 
            : now();

        $newExpiresAt = $baseDate->copy()->addDays($days);

        $post->update([
            'expires_at' => $newExpiresAt,
            'status' => 'published',
            'is_published' => true,
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'POST_EXPIRATION_EXTENDED',
            'entity_type' => 'Post',
            'entity_id' => $post->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'new_values' => [
                'dias_sumados' => $days,
                'nueva_vigencia' => $newExpiresAt->format('d/m/Y H:i:s'),
            ],
            'created_at' => now(),
        ]);

        return back()->with('success', "Vigencia de \"{$post->title}\" prorrogada por +{$days} días (vigente hasta el {$newExpiresAt->format('d/m/Y')}).");
    }

    // REPUBLICAR COMUNICADO ARCHIVADO
    public function republish(int $id, Request $request)
    {
        if (Auth::user()->role !== 'master_admin') {
            abort(403, 'Acceso denegado: solo el Master Administrator puede republicar comunicados archivados.');
        }

        $post = Post::findOrFail($id);
        $newExpiresAt = $post->is_permanent ? null : now()->addDays(30);

        $post->update([
            'status' => 'published',
            'is_published' => true,
            'published_at' => now(),
            'expires_at' => $newExpiresAt,
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'POST_REPUBLISHED_BY_ADMIN',
            'entity_type' => 'Post',
            'entity_id' => $post->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
        ]);

        return back()->with('success', "La publicación \"{$post->title}\" fue republicada exitosamente por 30 días y regresó al tope de la portada.");
    }
}