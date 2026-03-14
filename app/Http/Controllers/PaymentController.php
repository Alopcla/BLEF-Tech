<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // Necesario para identificar al usuario
use App\Mail\TicketMail;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function showForm()
    {
        // Asegúrate de que tu vista esté en resources/views/payment/form.blade.php
        return view('payment.form');
    }
    public function processPayment(Request $request)
    {
        // 1. VALIDACIÓN (Añadimos 'email' y 'cantidad')
        $request->validate([
            'email'    => 'required|email',
            'dia'      => 'required',
            'metod'    => 'required',
            'tarjeta'  => 'required|numeric',
            'nombre'   => 'required',
            'cvv'      => 'required|numeric',
            'cantidad' => 'required|integer|min:1|max:10',
        ]);

        try {
            // Creamos un array vacío para guardar los datos que irán al email
            $ticketsParaEmail = [];

            DB::transaction(function () use ($request, &$ticketsParaEmail) {
                $id_usuario = Auth::check() ? Auth::id() : null;
                $cantidad = $request->input('cantidad');

                // 2. BUCLE DE INSERCIÓN
                for ($i = 0; $i < $cantidad; $i++) {
                    // insertGetId realiza la inserción y nos devuelve el ID (ej: 45, 46...)
                    $nuevoId = DB::table('tickets')->insertGetId([
                        'date'       => now(),
                        'price'      => 15.00,
                        'type'       => $request->metod,
                        'created_at' => now(),
                        'updated_at' => now(),
                        // 'user_id' => $id_usuario 
                    ]);

                    // Guardamos los datos de este ticket específico en nuestro array
                    $ticketsParaEmail[] = [
                        'id'    => $nuevoId,
                        'date'  => now()->format('d/m/Y H:i'),
                        'price' => 15.00
                    ];
                }

                // 3. GUARDAR INFO DE PAGO (Si el usuario lo pidió)
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

            // 4. ENVIAR EL CORREO (Fuera de la transacción para evitar lentitud)
            // Le pasamos el array $ticketsParaEmail al constructor de TicketMail
            Mail::to($request->email)->send(new TicketMail($ticketsParaEmail));

            return back()->with('success', '¡Compra realizada con éxito! Se han enviado las entradas a ' . $request->email);
        } catch (\Exception $e) {
            return back()->with('error', 'Error en el proceso: ' . $e->getMessage());
        }
    }
}
