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
        // 1. VALIDACIÓN
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
            // --- LÓGICA DE CONTROL DE CUPO ---
            $fechaVisita = $request->dia;
            $cantidadPedida = (int)$request->cantidad;

            $vendidos = DB::table('tickets')
                ->where('day_used', $fechaVisita)
                ->count();

            $maximo = 10;
            $disponibles = $maximo - $vendidos;

            // Si el cupo está lleno, volvemos con los datos previos
            if ($vendidos >= $maximo) {
                return back()
                    ->with('error', "Lo sentimos, el cupo para el día " . date('d/m/Y', strtotime($fechaVisita)) . " está completo.")
                    ->withInput();
            }

            // Si piden más de lo que queda, volvemos con los datos previos
            if ($cantidadPedida > $disponibles) {
                return back()
                    ->with('error', "Solo quedan $disponibles entradas disponibles. Por favor, ajusta la cantidad.")
                    ->withInput();
            }
            // ---------------------------------

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
            // Si hay un error inesperado, también mantenemos los inputs
            return back()
                ->with('error', 'Error en el proceso: ' . $e->getMessage())
                ->withInput();
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
}
