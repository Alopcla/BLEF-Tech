<?php

namespace App\Http\Controllers;

use App\Models\Experience;

class ExperienciaController extends Controller
{
    public function index()
    {
        $experiencias = Experience::all();

        return view('experiencias', compact('experiencias'));
    }

    public function MostrarInfo($slug){
        // Si no la encuentra, devolverá un error 404 (Página no encontrada)
        $experiencias = Experience::where('slug',$slug)->firstOrFail();

        return view('experienciasInfo', compact('experiencias'));
    }
}