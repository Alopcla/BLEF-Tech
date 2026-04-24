<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index()
    {
        return view('experience.experiencias');
    }

    public function MostrarInfo($slug)
    {
        $experiencias = Experience::where('slug', $slug)->firstOrFail();
        return view('experience.experienciasInfo', compact('experiencias'));
    }
}