<?php

namespace App\Interfaces;

interface PaymentGatewayInterface
{
    public function createPayment($paymentAmount);

    public function capturePayment($request);
}
