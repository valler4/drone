<?php

namespace App\Services;

use App\Interfaces\PaymentGatewayInterface;

class StripeService implements PaymentGatewayInterface
{
    public function createPayment($amount) {}

    public function capturePayment($token) {}
}
