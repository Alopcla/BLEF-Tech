<?php

namespace App\Http\Controllers;
use App\Models\Experience;
use App\Models\Ticket;
use App\Models\ReserveExperience;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ExperienciaController extends Controller
{
    public function index()
    {
    // 1. Cargamos las experiencias contando las reservas en una SOLA consulta
        $experiencias = Experience::withCount(['reservations' => function ($query) {
                $query->where('status', 'paid');
            }])
            ->get()
            ->map(function ($exp) {
                // Calculamos las plazas en memoria, no en la DB
                $exp->available_spots = max(0, $exp->capacity - $exp->reservations_count);
                return $exp;
            });

        // 2. Ordenamos por popularidad
        $experiencias = $experiencias->sortByDesc('reservations_count');
        $popular = $experiencias->first();

        // En lugar de true/false, traemos los objetos de los tickets directamente
        $ticketvalidation = collect(); 
        if (Auth::check()) {
            // Traemos todos los tickets pagados del usuario que sean para hoy o futuro
            $ticketvalidation = Ticket::where('email', Auth::user()->email)
                ->where('status', 'paid')
                ->where('visit_day', '>=', now()->format('Y-m-d'))
                ->get(); // Esto devuelve una colección (lista), que es "contable"
        }

        return view('experiencias', compact('experiencias', 'popular', 'ticketvalidation'));
    }

    public function MostrarInfo(Request $request, $slug)
    {
        $experiencias = Experience::where('slug', $slug)->firstOrFail();

        // 1. Buscamos el email (de la URL o del usuario logueado)
        $email = $request->get('email', auth()->user()->email ?? null);

        // 2. INICIALIZAMOS la variable como una colección vacía 
        // para que compact() siempre la encuentre.
        $misTickets = collect();

        // 3. Solo si hay un email, llenamos la colección
        if ($email) {
            $misTickets = Ticket::where('email', $email)
                ->where('status', 'paid')
                ->where('visit_day', '>=', now()->toDateString())
                ->get();
        }

        return view('experienciasInfo', compact('experiencias', 'misTickets'));
    }


}