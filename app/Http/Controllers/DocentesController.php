<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocentesController extends Controller
{
    public function index(Request $request)
    {
        // Si no tiene sesión iniciada, salta directo al selector de cuentas de Google
        if (! Auth::check()) {
            return redirect()->route('auth.google');
        }

        $query = Post::where('is_published', true)
            ->where('status', 'published')
            ->with(['attachments', 'user', 'category'])
            ->latest('published_at');

        // Filtrar por categoría si se pasa por la URL
        if ($request->filled('categoria')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->categoria);
            });
        }

        $posts = $query->paginate(12);
        $categories = Category::all();

        return view('docentes.index', compact('posts', 'categories'));
    }
}
