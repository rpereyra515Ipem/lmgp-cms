<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\EducationalLevel;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $levels = EducationalLevel::where('is_active', true)->orderBy('id')->get();
        $categories = Category::all();

        // Consulta principal: solo publicaciones activas y vigentes, ordenadas de más nueva a más antigua
        $query = Post::where('is_published', true)
            ->where(function ($q) {
                $q->where('is_permanent', true)
                  ->orWhereNull('expires_at')
                  ->orWhere('expires_at', '>=', now());
            })
            ->with(['educationalLevel', 'category', 'user'])
            ->latest('published_at');

        // Filtro opcional por nivel educativo
        if ($request->filled('nivel')) {
            $query->whereHas('educationalLevel', function ($q) use ($request) {
                $q->where('slug', $request->nivel);
            });
        }

        // Filtro opcional por categoría
        if ($request->filled('categoria')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->categoria);
            });
        }

        $posts = $query->paginate(9)->withQueryString();

        return view('home', compact('levels', 'categories', 'posts'));
    }
}