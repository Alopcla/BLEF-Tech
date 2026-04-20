<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function createCheckoutSession(array $data): Session
    {
        return Session::create([
            'payment_method_types' => ['card'],
            'mode'                 => 'payment',
            'customer_email'       => $data['email'],
            'success_url'          => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'           => route('payment.error') . '?return=' . urlencode($data['return_url'] ?? route('payment.show')),
            'metadata'             => [
                'tipo'  => $data['tipo'],
                'meta'  => json_encode($data['meta'] ?? []),
                'email' => $data['email'],
            ],
            'line_items' => [[
                'quantity'   => 1,
                'price_data' => [
                    'currency'    => 'eur',
                    'unit_amount' => (int) round($data['amount'] * 100),
                    'product_data' => [
                        'name'        => $data['concepto'],
                        'description' => $data['description'] ?? null,
                    ],
                ],
            ]],
        ]);
    }
}