<?php

namespace App\Http\Controllers;

use App\Models\Experiencias;

class ExperienciaController extends Controller
{
    public function index()
    {
        $experiencias = Experiencias::all();

        return view('experiencias', compact('experiencias'));
    }
}