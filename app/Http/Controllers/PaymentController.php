<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Mail\TicketMail;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function showForm()
    {
        return view('payment.form');
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'dia'      => 'required|date',
            'metod'    => 'required',
            'tarjeta'  => 'required|numeric',
            'nombre'   => 'required',
            'cvv'      => 'required|numeric',
            'cantidad' => 'required|integer|min:1|max:10',
        ]);

        try {
            $fechaVisita = $request->dia;
            $cantidadPedida = (int)$request->cantidad;

            $vendidos = DB::table('tickets')->where('day_used', $fechaVisita)->count();
            $maximo = 10;
            $disponibles = $maximo - $vendidos;

            if ($vendidos >= $maximo) {
                return back()->with('error', "Cupo completo.")->withInput();
            }

            if ($cantidadPedida > $disponibles) {
                return back()->with('error', "Solo quedan $disponibles entradas.")->withInput();
            }

            $ticketsParaEmail = [];

            DB::transaction(function () use ($request, &$ticketsParaEmail) {
                $id_usuario = Auth::check() ? Auth::id() : null;
                $cantidad = $request->input('cantidad');

                for ($i = 0; $i < $cantidad; $i++) {
                    $nuevoId = DB::table('tickets')->insertGetId([
                        'date'       => now(),
                        'day_used'   => $request->dia,
                        'price'      => 15.00,
                        'type'       => $request->metod,
                        'email'      => $request->email, // <--- AHORA SE GUARDA EL EMAIL
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $ticketsParaEmail[] = [
                        'id'       => $nuevoId,
                        'date'     => now()->format('d/m/Y H:i'),
                        'day_used' => date('d/m/Y', strtotime($request->dia)),
                        'price'    => 15.00
                    ];
                }

                if (Auth::check() && $request->has('save')) {
                    DB::table('InfoPago')->updateOrInsert(
                        ['numCliente' => $id_usuario],
                        [
                            'tipo'            => $request->metod,
                            'numTarjeta'      => $request->tarjeta,
                            'mCaducidad'      => $request->mes,
                            'aCaducidad'      => $request->anio,
                            'codigoSeguridad' => $request->cvv
                        ]
                    );
                }
            });

            Mail::to($request->email)->send(new TicketMail($ticketsParaEmail));

            return back()->with('success', '¡Compra realizada con éxito! Revisa tu email.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    /** * MÉTODO PARA AJAX: Comprueba disponibilidad en tiempo real 
     */
    public function checkAvailability(Request $request)
    {
        $fecha = $request->query('date');

        $vendidos = DB::table('tickets')
            ->where('day_used', $fecha)
            ->count();

        $disponibles = 10 - $vendidos;

        return response()->json([
            'available' => $disponibles < 0 ? 0 : $disponibles
        ]);
    }

    //Bloque de reclamaciones
    public function reclamacionesIndex()
    {
        return view('admin.reclamaciones', ['tickets' => null]);
    }

    public function buscarTickets(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'fecha' => 'required|date'
        ]);

        // Buscamos los tickets que coincidan con ambos campos
        $tickets = DB::table('tickets')
            ->where('email', $request->email)
            ->where('day_used', $request->fecha)
            ->get();

        return view('admin.reclamaciones', [
            'tickets' => $tickets,
            'email'   => $request->email,
            'fecha'   => $request->fecha
        ]);
    }

    public function cancelarCompra($fecha, $email)
    {
        // Borramos solo los tickets de ese usuario para ese día
        DB::table('tickets')
            ->where('email', $email)
            ->where('day_used', $fecha)
            ->delete();

        return redirect()->route('reclamaciones.index')->with('success', 'Compra cancelada correctamente.');
    }

    public function reenviarTickets(Request $request)
    {
        // Buscamos los tickets de nuevo para enviarlos
        $tickets = DB::table('tickets')
            ->where('email', $request->email)
            ->get()
            ->map(function ($t) {
                return [
                    'id' => $t->id,
                    'date' => $t->date,
                    'day_used' => $t->day_used,
                    'price' => $t->price
                ];
            })->toArray();

        if (count($tickets) > 0) {
            Mail::to($request->email)->send(new TicketMail($tickets));
            return back()->with('success', 'Tickets reenviados a ' . $request->email);
        }

        return back()->with('error', 'No se encontraron tickets para reenviar.');
    }
}
