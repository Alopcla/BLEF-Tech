<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketMail;
use App\Services\StripeService;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function showForm()
    {
        return view('payment.form');
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'amount'   => 'required|numeric|min:0.01',
            'concepto' => 'required|string',
            'tipo'     => 'required|string',
            'meta'     => 'nullable|array',
        ]);

        $email = auth()->user()->email;

        try {
            $stripe  = new StripeService();
            $session = $stripe->createCheckoutSession([
                'email'       => $email,
                'amount'      => $request->amount,
                'concepto'    => $request->concepto,
                'description' => null,
                'tipo'        => $request->tipo,
                'meta'        => $request->meta ?? [],
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

            /** PARA EVITAR DUPLICADOS */
            $sessionId = $session->id;

            $yaProcesado = DB::table('reserve_experiences')
                ->where('stripe_session_id', $sessionId)
                ->exists();

            if ($yaProcesado) {
                $experiencia = DB::table('experiences')
                    ->where('id', $meta['experiencia_id'] ?? null)
                    ->first();

                return view('payment.success', [
                    'email'       => $email,
                    'tipo'        => $tipo,
                    'meta'        => $meta,
                    'amount'      => $amount,
                    'tickets'     => [],
                    'experiencia' => $experiencia,
                ]);
            }


            $ticketsParaEmail = [];
            $experiencia = null;

            switch ($tipo) {

                case 'ticket':
                    DB::transaction(function () use ($email, $meta, &$ticketsParaEmail) {
                        for ($i = 0; $i < $meta['cantidad']; $i++) {
                            $nuevoId = DB::table('tickets')->insertGetId([
                                'date'       => now(),
                                'day_used'   => $meta['dia'],
                                'price'      => 15.00,
                                'type'       => 'stripe',
                                'email'      => $email,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                            $ticketsParaEmail[] = [
                                'id'       => $nuevoId,
                                'date'     => now()->format('d/m/Y H:i'),
                                'day_used' => date('d/m/Y', strtotime($meta['dia'])),
                                'price'    => 15.00,
                            ];
                        }
                    });
                    Mail::to($email)->send(new TicketMail($ticketsParaEmail));
                    break;

                case 'experiencia':
                    DB::table('reserve_experiences')->insert([
                        'experience_id'       => $meta['experiencia_id'],
                        'email'               => $email,
                        'reservation_date'    => $meta['fecha'] ?? now(),
                        'price'               => $amount,
                        'stripe_session_id'   => $sessionId,
                        'status'              => 'paid',
                        'created_at'          => now(),
                        'updated_at'          => now(),
                    ]);
                    $experiencia = DB::table('experiences')
                        ->where('id', $meta['experiencia_id'])
                        ->first();
                    break;
            }

            return view('payment.success', [
                'email'       => $email,
                'tipo'        => $tipo,
                'meta'        => $meta,
                'amount'      => $amount,
                'tickets'     => $ticketsParaEmail,
                'experiencia' => $experiencia,
            ]);

        } catch (\Exception $e) {
            return redirect()->route('payment.show')
                ->with('error', 'Error al confirmar el pago: ' . $e->getMessage());
        }
    }

    public function paymentError()
    {
        return redirect()->route('payment.show')
            ->with('error', 'El pago ha sido cancelado. Inténtalo de nuevo.');
    }

    public function checkAvailability(Request $request)
    {
        $fecha       = $request->query('date');
        $vendidos    = DB::table('tickets')->where('day_used', $fecha)->count();
        $disponibles = 10 - $vendidos;

        return response()->json(['available' => max(0, $disponibles)]);
    }

    public function reclamacionesIndex()
    {
        return view('admin.reclamaciones', ['tickets' => null]);
    }

    public function buscarTickets(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'fecha' => 'required|date',
        ]);

        $tickets = DB::table('tickets')
            ->where('email', $request->email)
            ->where('day_used', $request->fecha)
            ->get();

        return view('admin.reclamaciones', [
            'tickets' => $tickets,
            'email'   => $request->email,
            'fecha'   => $request->fecha,
        ]);
    }

    public function cancelarCompra($fecha, $email)
    {
        DB::table('tickets')
            ->where('email', $email)
            ->where('day_used', $fecha)
            ->delete();

        return redirect()->route('reclamaciones.index')
            ->with('success', 'Compra cancelada correctamente.');
    }

    public function reenviarTickets(Request $request)
    {
        $tickets = DB::table('tickets')
            ->where('email', $request->email)
            ->get()
            ->map(fn($t) => [
                'id'       => $t->id,
                'date'     => $t->date,
                'day_used' => $t->day_used,
                'price'    => $t->price,
            ])->toArray();

        if (count($tickets) > 0) {
            Mail::to($request->email)->send(new TicketMail($tickets));
            return back()->with('success', 'Tickets reenviados a ' . $request->email);
        }

        return back()->with('error', 'No se encontraron tickets para reenviar.');
    }
}