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
            return response()->json([
                'tickets' => [],
                'experiencias' => [],
                'orders' => [],
            ]);
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