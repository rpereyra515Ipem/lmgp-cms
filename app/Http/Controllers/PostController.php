<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PostController extends Controller
{
    public function show(string $slug): View
    {
        $post = Post::where('slug', $slug)
            ->where('is_published', true)
            ->with(['educationalLevel', 'category', 'user', 'attachments'])
            ->firstOrFail();

        $recentPosts = Post::where('is_published', true)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('posts.show', compact('post', 'recentPosts'));
    }

    public function downloadAttachment(int $id)
    {
        $attachment = Attachment::findOrFail($id);
        $attachment->increment('download_count');

        $filePath = storage_path('app/' . $attachment->file_path);

        if (file_exists($filePath)) {
            return response()->download($filePath, $attachment->title);
        }

        // Si es archivo de muestra simulado
        return back()->with('info', 'Descargando documento institucional: ' . $attachment->title);
    }
}