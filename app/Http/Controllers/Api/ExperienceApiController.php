<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Models\Ticket;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExperienceApiController extends Controller
{
    public function index()
    {
        $experiencias = Experience::withCount(['reservations' => function ($q) {
                $q->where('status', 'paid');
            }])
            ->get()
            ->map(function ($exp) {
                $exp->available_spots = max(0, $exp->capacity - $exp->reservations_count);
                return $exp;
            })
            ->sortByDesc('reservations_count')
            ->values();

        return response()->json(['data' => $experiencias]);
    }

    public function misTickets(Request $request)
    {
        $email = $request->query('email');

        if (!$email) {
            return response()->json([]);
        }

        $tickets = Ticket::where('email', $email)
            ->where('status', 'paid')
            ->where('visit_day', '>=', now()->format('Y-m-d'))
            ->get()
            ->map(fn($t) => [
                'id'                  => $t->id,
                'cod_ticket'          => $t->cod_ticket,
                'visit_day'           => $t->visit_day->format('Y-m-d'),
                'visit_day_formatted' => $t->visit_day->format('d/m/Y'),
                'visit_day_short'     => $t->visit_day->format('D'),
            ]);

        return response()->json($tickets);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'experiencia_id' => 'required|integer|exists:experiences,id',
            'ticket_id'      => 'required|integer|exists:tickets,id',
            'fecha'          => 'required|date',
            'email'          => 'nullable|email',
        ]);

        session(['payment_return_url' => $request->return_url ?? url()->previous()]);

        $email = Auth::check() ? Auth::user()->email : $request->email;

        if (!$email) {
            return response()->json(['error' => 'Introduce un email para continuar.'], 422);
        }

        $experiencia = Experience::findOrFail($request->experiencia_id);

        if ($experiencia->available_spots <= 0) {
            return response()->json(['error' => 'No quedan plazas disponibles para esta experiencia.'], 422);
        }

        try {
            $stripe  = new StripeService();
            $session = $stripe->createCheckoutSession([
                'email'    => $email,
                'amount'   => $experiencia->price,
                'concepto' => "Reserva: {$experiencia->name}",
                'tipo'     => 'experiencia',
                'meta'     => [
                    'experiencia_id' => $request->experiencia_id,
                    'ticket_id'      => $request->ticket_id,
                    'fecha'          => $request->fecha,
                ],
                'return_url' => route('VistaExperiencias'),
            ]);

            return response()->json(['url' => $session->url]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function MostrarInfo(Request $request, $slug)
    {
        $experiencias = Experience::where('slug', $slug)->firstOrFail();
        return view('experienciasInfo', compact('experiencias'));
    }

    public function guideData(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'guide' => $request->user(),
                'experiencias' => Experience::with('zone')->get(),
                'zones' => \App\Models\Zone::all(),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'zone_id' => 'required|exists:zones,id',
            'name' => 'required|string',
            'slug' => 'required|string',
            'description' => 'nullable|string',
            'details' => 'nullable|string',
            'duration_min' => 'required|integer',
            'price' => 'required|numeric',
            'capacity' => 'required|integer',
            'image' => 'nullable|string',
        ]);

        $experience = Experience::create($validated);

        return response()->json([
            'success' => true,
            'experience' => $experience
        ]);
    }

    public function update(Request $request, $id)
    {
        $experience = Experience::find($id);

        if (!$experience) {
            return response()->json(['error' => 'No encontrada'], 404);
        }

        $validated = $request->validate([
            'zone_id' => 'required|exists:zones,id',
            'name' => 'required|string',
            'slug' => 'required|string',
            'description' => 'nullable|string',
            'details' => 'nullable|string',
            'duration_min' => 'required|integer',
            'price' => 'required|numeric',
            'capacity' => 'required|integer',
            'image' => 'nullable|string',
        ]);

        $experience->update($validated);

        return response()->json([
            'success' => true,
            'experience' => $experience
        ]);
    }

    public function destroy($id)
    {
        $experience = Experience::find($id);

        if (!$experience) {
            return response()->json(['error' => 'No encontrada'], 404);
        }

        $experience->delete();

        return response()->json([
            'success' => true,
            'message' => 'Experiencia eliminada'
        ]);
    }
}