<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Order;
use App\Models\ReserveExperience;

class OrdersApiController extends Controller
{
    public function index(Request $request)
    {
        $email = $request->query('email');

        if (!$email) {
            return response()->json(['tickets' => [], 'experiencias' => [], 'orders' => []]);
        }

        // Si el usuario no está autenticado, exigimos el access_token verificado
        
        if (!auth()->guard('web')->check()) {
            $token = $request->query('access_token');
            if (!$token) {
                return response()->json(['error' => 'No autorizado'], 401);
            }
            try {
                // El token es "email|timestamp_expiracion"
                $decrypted = decrypt($token);
                [$tokenEmail, $expiresAt] = explode('|', $decrypted);

                if ($tokenEmail !== $email || now()->timestamp > (int) $expiresAt) {
                    return response()->json(['error' => 'Token inválido o expirado'], 401);
                }
            } catch (\Exception $e) {
                return response()->json(['error' => 'Token inválido'], 401);
            }
        }

        // TICKETS
        $tickets = Ticket::where('email', $email)
            ->where('status', 'paid')
            ->get();

        // EXPERIENCIAS

        $experiencias = ReserveExperience::with(['experience', 'ticket'])
            ->where('email', $email)
            ->get();

        // ORDERS
        $orders = Order::with('items.product')
            ->where('email', $email)
            ->where('status', 'paid')
            ->get();

        return response()->json([
            'tickets' => $tickets,
            'experiencias' => $experiencias,
            'orders' => $orders,
        ]);
    }
}