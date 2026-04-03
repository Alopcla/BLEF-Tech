<?php

namespace App\Http\Controllers;
use App\Models\Experience;
use App\Models\ReserveExperience;
use Illuminate\Support\Facades\Auth;

class ExperienciaController extends Controller
{
    public function index()
    {
        $experiencias = Experience::all();
        $popular = Experience::popular()->first();

        return view('experiencias', compact('experiencias', 'popular'));
    }

    public function MostrarInfo($slug){
        // Si no la encuentra, devolverá un error 404 (Página no encontrada)
        $experiencias = Experience::where('slug',$slug)->firstOrFail();

        return view('experienciasInfo', compact('experiencias'));
    }
}