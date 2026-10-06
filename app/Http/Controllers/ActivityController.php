<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\EducationalLevel;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $selectedLevel = $request->query('nivel');

        // Niveles institucionales ordenados por ID
        $levels = EducationalLevel::orderBy('id', 'asc')->get();

        // Consulta de actividades publicadas
        $query = Post::with('educationalLevel')
            ->where('is_published', true)
            ->latest('published_at');

        // Filtrar por nivel si se selecciona uno en las pestañas
        if ($selectedLevel && $selectedLevel !== 'todos') {
            $query->whereHas('educationalLevel', function ($q) use ($selectedLevel) {
                $q->where('slug', $selectedLevel);
            });
        }

        $activities = $query->paginate(9)->withQueryString();

        return view('actividades.index', compact('activities', 'levels', 'selectedLevel'));
    }
}