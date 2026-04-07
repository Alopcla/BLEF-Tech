<?php

namespace App\Http\Controllers;
use App\Models\Experience;
use App\Models\Ticket;
use App\Models\ReserveExperience;
use Illuminate\Support\Facades\Auth;

class ExperienciaController extends Controller
{
    public function index()
    {
        $experiencias = Experience::all();
        $popular = Experience::popular()->first();

    // Validamos usando el método estático del modelo Ticket
    $ticketvalidation = false;
    if (Auth::check()) {
        $ticketvalidation = Ticket::hasticket(Auth::user()->email);
    }

        return view('experiencias', compact('experiencias', 'popular', 'ticketvalidation'));
    }

    public function MostrarInfo($slug){
        // Si no la encuentra, devolverá un error 404 (Página no encontrada)
        $experiencias = Experience::where('slug',$slug)->firstOrFail();

        return view('experienciasInfo', compact('experiencias'));
    }
}