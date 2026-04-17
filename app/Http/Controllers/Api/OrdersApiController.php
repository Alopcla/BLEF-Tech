<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\ReserveExperience;
use App\Models\Order;

class OrdersApiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('sanctum')->user(); // Aseguramos detectar el usuario vía API
        $email = $request->query('email');

        if ($user) {
            // --- USUARIO AUTENTICADO ---
            $userId = $user->id;
            $userEmail = $user->email;

            // Buscamos tickets por ID o por su email (por si compró algo antes de registrarse)
            $tickets = Ticket::where('user_id', $userId)
                ->orWhere('email', $userEmail)
                ->get();

            // Experiencias: Buscamos las vinculadas a sus tickets O las vinculadas a su email
            $experiencias = ReserveExperience::with('experience')
                ->whereHas('ticket', fn($q) => $q->where('user_id', $userId))
                ->orWhere('email', $userEmail)
                ->get();

            // Pedidos de tienda: Solo los pagados
            $orders = Order::with('items.product')
                ->paid() // Tu scope del modelo
                ->where(function($q) use ($userId, $userEmail) {
                    $q->where('user_id', $userId)->orWhere('email', $userEmail);
                })
                ->latest()
                ->get();

        } else {
            // --- MODO INVITADO ---
            $request->validate([
                'email' => 'required|email'
            ]);

            $tickets = Ticket::where('email', $email)->get();
            
            $experiencias = ReserveExperience::with(['experience', 'ticket'])
                ->where('email', $email)
                ->get();

            $orders = Order::with('items.product')
                ->paid()
                ->where('email', $email)
                ->latest()
                ->get();
        }

        return response()->json([
            'tickets' => $tickets,
            'experiencias' => $experiencias,
            'orders' => $orders,
        ]);
    }
}