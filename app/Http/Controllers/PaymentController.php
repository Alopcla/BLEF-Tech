<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketMail;
use App\Services\StripeService;
use Stripe\Stripe;
use Stripe\Refund;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; // Necesario para generar códigos únicos

class PaymentController extends Controller
{
    public function showForm()
    {
        $fecha = now()->format('Y-m-d');
        return view('payment.form', compact('fecha'));
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'concepto' => 'required|string',
            'tipo'     => 'required|string',
            'meta'     => 'nullable|array',
        ]);

        if ($request->tipo === 'ticket') {
            $fecha    = $request->meta['dia'];
            $cantidad = (int) $request->meta['cantidad'];

            $vendidos    = DB::table('tickets')
                ->where('visit_day', $fecha)
                ->where('status', 'paid')
                ->count();

            $disponibles = max(0, 100 - $vendidos);

            if ($cantidad > $disponibles) {
                return back()->with('error', 'No hay entradas suficientes para esta fecha.');
            }
        }

        $email = Auth::check() ? Auth::user()->email : $request->email;

        switch ($request->tipo) {
            case 'ticket':
                $cantidad = (int) ($request->meta['cantidad'] ?? 1);
                $amount   = $cantidad * 15.00;
                break;

            case 'experiencia':
                $experiencia = DB::table('experiences')
                    ->where('id', $request->meta['experiencia_id'])
                    ->firstOrFail();
                $amount = (float) $experiencia->price;
                break;

            case 'shop':
                $items  = $request->meta['items'] ?? [];
                $amount = 0;
                foreach ($items as $item) {
                    $product = DB::table('products')->where('id', $item['id'])->firstOrFail();
                    $amount += $product->price * $item['quantity'];
                }
                break;

            default:
                return back()->with('error', 'Tipo de pago no válido.');
        }

        try {
            $stripe  = new StripeService();
            $session = $stripe->createCheckoutSession([
                'email'      => $email,
                'amount'     => $amount,
                'concepto'   => $request->concepto,
                'description'=> null,
                'tipo'       => $request->tipo,
                'meta'       => $request->meta ?? [],
                'return_url' => route('payment.show') ,
            ]);

            return redirect()->away($session->url);

        } catch (\Exception $e) {
            return back()->with('error', 'Error al conectar con Stripe: ' . $e->getMessage());
        }
    }

    public function paymentSuccess(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $session  = Session::retrieve($request->query('session_id'));
            $metadata = $session->metadata;
            $email    = $metadata->email;
            $tipo     = $metadata->tipo;
            $meta     = json_decode($metadata->meta, true);
            $amount   = $session->amount_total / 100;
            $sessionId = $session->id;

            $ticketsParaEmail = [];
            $experiencia = null;

            switch ($tipo) {
                case 'ticket':
                    $yaProcesadoTicket = DB::table('tickets')
                        ->where('stripe_session_id', $sessionId)
                        ->exists();

                    if (!$yaProcesadoTicket) {
                        $cantidad = (int) $meta['cantidad'];
                        $precioIndividual = $amount / $cantidad;

                        // CREACIÓN DE TICKETS INDIVIDUALES
                        for ($i = 0; $i < $cantidad; $i++) {
                            $codTicket = 'ZOO-' . strtoupper(Str::random(8));

                            $nuevoId = DB::table('tickets')->insertGetId([
                                'user_id'            => auth()->id() ?? null,
                                'email'              => $email,
                                'cod_ticket'         => $codTicket,
                                'visit_day'          => $meta['dia'],
                                'price'              => $precioIndividual,
                                'total_order_amount' => $amount,
                                'stripe_session_id'  => $sessionId,
                                'status'             => 'paid',
                                'created_at'         => now(),
                                'updated_at'         => now(),
                            ]);

                            $ticketsParaEmail[] = [
                                'id'       => $nuevoId,
                                'cod'      => $codTicket,
                                'date'     => now()->format('d/m/Y H:i'),
                                'day_used' => date('d/m/Y', strtotime($meta['dia'])),
                                'price'    => $precioIndividual,
                            ];
                        }
                    }
                    Mail::to($email)->send(new TicketMail($ticketsParaEmail));
                    break;

                case 'experiencia':
                    $yaProcesadoExp = DB::table('reserve_experiences')
                        ->where('stripe_session_id', $sessionId)
                        ->exists();

                    if (!$yaProcesadoExp) {
                        DB::table('reserve_experiences')->insert([
                            'experience_id'    => $meta['experiencia_id'],
                            'ticket_id'        => $meta['ticket_id'], // GUARDAMOS EL ID DEL TICKET SELECCIONADO
                            'email'            => $email,
                            'reservation_date' => $meta['fecha'] ?? now(),
                            'price'            => $amount,
                            'stripe_session_id'=> $sessionId,
                            'status'           => 'paid',
                            'created_at'       => now(),
                            'updated_at'       => now(),
                        ]);
                    }

                    $experiencia = DB::table('experiences')->where('id', $meta['experiencia_id'])->first();
                    break;
                case 'shop':
                    $yaProcesado = DB::table('orders')
                        ->where('stripe_session_id', $sessionId)
                        ->exists();

                    if (!$yaProcesado) {
                        $items = $meta['items'] ?? [];

                        $orderId = DB::table('orders')->insertGetId([
                            'user_id'           => auth()->id() ?? null,
                            'email'             => $email,
                            'stripe_session_id' => $sessionId,
                            'total'             => $amount,
                            'status'            => 'paid',
                            'created_at'        => now(),
                            'updated_at'        => now(),
                        ]);

                        foreach ($items as $item) {
                            $product = DB::table('products')->where('id', $item['id'])->first();
                            DB::table('order_items')->insert([
                                'order_id'   => $orderId,
                                'product_id' => $item['id'],
                                'quantity'   => $item['quantity'],
                                'unit_price' => $product->price,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                            // Descontar stock
                            DB::table('products')
                                ->where('id', $item['id'])
                                ->decrement('stock', $item['quantity']);
                        }
                    }

                    $order = DB::table('orders')->where('stripe_session_id', $sessionId)->first();
                    $orderItems = DB::table('order_items')
                        ->join('products', 'order_items.product_id', '=', 'products.id')
                        ->where('order_items.order_id', $order->id)
                        ->select('products.name', 'products.image', 'order_items.quantity', 'order_items.unit_price')
                        ->get();
                    break;
            }

            return view('payment.success', [
                'email'       => $email,
                'tipo'        => $tipo,
                'meta'        => $meta,
                'amount'      => $amount,
                'tickets'     => $ticketsParaEmail,
                'experiencia' => $experiencia,
                'order'      => $order ?? null,
                'orderItems' => $orderItems ?? [],
            ]);

        } catch (\Exception $e) {
            return redirect()->route('payment.show')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function paymentError(Request $request)
    {
        $returnUrl = $request->query('return', route('payment.show'));
        return redirect($returnUrl)->with('error', 'El pago ha sido cancelado.');
    }

    // --- MÉTODOS DE ADMINISTRACIÓN---

    public function buscarTickets(Request $request)
    {
        $request->validate(['email' => 'required|email', 'fecha' => 'required|date']);

        $tickets = DB::table('tickets')
            ->where('email', $request->email)
            ->where('visit_day', $request->fecha)
            ->orderBy('stripe_session_id')
            ->get()
            ->groupBy('stripe_session_id');

        return view('admin.reclamaciones', [
            'tickets' => $tickets,
            'email'   => $request->email,
            'fecha'   => $request->fecha,
        ]);
    }

    public function cancelarPedido(Request $request)
    {
        // 1. Obtener y validar el ID de sesión
        $session = $request->input('session_id');

        if (!$session) {
            return back()->with('error', 'ID de sesión no proporcionado.');
        }

        // 2. Buscar tickets y verificar si ya están cancelados
        $tickets = DB::table('tickets')
            ->where('stripe_session_id', $session)
            ->get();

        if ($tickets->isEmpty()) {
            return back()->with('error', 'No se encontró ningún ticket asociado a este pedido.');
        }

        // Si el primer ticket ya está cancelado, detenemos el proceso
        if ($tickets->first()->status === 'cancelled') {
            return back()->with('error', 'Este pedido ya ha sido cancelado y reembolsado anteriormente.');
        }

        // 3. Configurar Stripe
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            // 4. Iniciar transacción para asegurar consistencia de datos
            return DB::transaction(function () use ($session) {
                
                // Recuperar la sesión de Stripe
                $stripeSession = Session::retrieve($session);

                // 5. Procesar Reembolso si existe un pago
                if (!empty($stripeSession->payment_intent)) {
                    Refund::create([
                        'payment_intent' => $stripeSession->payment_intent,
                    ]);
                }

                // 6. Actualizar estado en la Base de Datos
                DB::table('tickets')
                    ->where('stripe_session_id', $session)
                    ->update([
                        'status' => 'cancelled',
                        'updated_at' => now(),
                    ]);

                return back()->with('success', 'Éxito: El dinero ha sido devuelto y los tickets marcados como cancelados.');
            });

        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Error específico de la API de Stripe
            return back()->with('error', 'Error de Stripe: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Error general de Laravel o Base de Datos
            return back()->with('error', 'Error en el sistema: ' . $e->getMessage());
        }
    }

    public function reenviarTickets(Request $request)
    {
        $tickets = DB::table('tickets')
            ->where('email', $request->email)
            ->get()
            ->map(fn($t) => [
                'id'       => $t->id,
                'cod'      => $t->cod_ticket,
                'date'     => $t->created_at,
                'day_used' => $t->visit_day, // Corregido
                'price'    => $t->price,
            ])->toArray();

        if (count($tickets) > 0) {
            Mail::to($request->email)->send(new TicketMail($tickets));
            return back()->with('success', 'Tickets reenviados.');
        }

        return back()->with('error', 'No se encontraron tickets.');
    }

    /**
     * Muestra la vista inicial del panel de reclamaciones (Tickets)
     */
    public function reclamacionesIndex()
    {
        // Retornamos la vista vacía con 'tickets' como null
        // para que el formulario se muestre limpio al principio
        return view('admin.reclamaciones', [
            'tickets' => null,
            'email'   => null,
            'fecha'   => null
        ]);
    }
}
