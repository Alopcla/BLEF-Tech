<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Importante para usar la base de datos

class PaymentController extends Controller
{
    // Esta función mostrará el formulario
    public function showForm()
    {
        return view('payment.form');
    }

    // Esta función procesará los datos del formulario (tu antigua función registrarCompra)
    public function processPayment(Request $request)
    {
        // 1. VALIDACIÓN (Sustituye a tus if empty...)
        $request->validate([
            'dia'     => 'required',
            'metod'   => 'required',
            'tarjeta' => 'required|numeric',
            'nombre'  => 'required',
            'cvv'     => 'required|numeric',
        ]);

        try {
            // Usamos una transacción para que si algo falla, no se guarde nada a medias
            DB::transaction(function () use ($request) {

                // DETERMINAR CLIENTE (En Laravel se usa auth()->id())
                $id_cliente = 1; // De momento lo dejamos en 1 como en tu código

                // INSERCIÓN EN 'Entrada'
                DB::table('Entrada')->insert([
                    'numCliente' => $id_cliente,
                    'tipo'       => $request->metod,
                    'DiaVisita'  => $request->dia
                ]);

                // INSERCIÓN EN 'InfoPago' (Si marcó el checkbox 'save')
                if ($request->has('save')) {
                    DB::table('InfoPago')->insert([
                        'numCliente'      => $id_cliente,
                        'tipo'            => $request->metod,
                        'numTarjeta'      => $request->tarjeta,
                        'mCaducidad'      => $request->mes,
                        'aCaducidad'      => $request->anio,
                        'codigoSeguridad' => $request->cvv
                    ]);
                }
            });

            // Si todo sale bien, volvemos atrás con un mensaje de éxito
            return back()->with('success', '¡Pago procesado con éxito!');
        } catch (\Exception $e) {
            // Si hay un error (ej. la base de datos no conecta), volvemos con el error
            return back()->with('error', 'Error al registrar la entrada: ' . $e->getMessage());
        }
    }
}
