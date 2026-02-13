<?php

namespace App\Services;

use App\Interfaces\PaymentGatewayInterface;

class CLASSNAME extends Base_Payment_Service implements PaymentGatewayInterface
{
    public function __construct() {}

    public function createPayment($amount) {}

    public function capturePayment($token) {}
}
