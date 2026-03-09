<?php

namespace App\Interfaces;

interface PaymentGatewayInterface
{
    public function createPayment($paymentAmount, $returnUrl = null);

    public function capturePayment($request);
}
