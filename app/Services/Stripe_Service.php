<?php

namespace App\Services;

use App\Interfaces\PaymentGatewayInterface;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class Stripe_Service extends Base_Payment_Service implements PaymentGatewayInterface
{
    public function __construct()
    {
        Stripe::setApiKey(config('payment.stripe.secret'));
    }

    public function createPayment($amount)
    {
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Stripe Payment',
                    ],
                    'unit_amount' => $amount * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.capture', ['payment_Data' => 'stripe', 'amount' => $amount]) . '&session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('deposit'),
        ]);
        $result = [
            'success' => true,
            'url' => $session->url,
            'id' => $session->id
        ];

        return $result;
    }

    public function capturePayment($request)
    {

        $sessionID = $request->get('session_id');
        $session = Session::retrieve($sessionID);

        if ($session->payment_status == 'paid') {
            return [
                'status' => 'COMPLETED',
                'id' => $session->payment_intent,
                'amount' => $session->amount_total / 100,
                'currency' => $session->currency,
                'success' => true,
            ];
        }
        return ['status' => 'FAILED'];
    }
}
