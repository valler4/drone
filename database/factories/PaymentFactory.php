<?php

namespace Database\Factories;

use App\Services\Paymob_service;
use App\Services\paypal_service;
use App\Services\Stripe_Service;

class PaymentFactory
{
    public static function make($Data)
    {
        return match ($Data) {
            'paypal' => new paypal_service,
            'stripe' => new Stripe_Service,
            // 'paymob' => new Paymob_service,
            // default => new paypal_service,
                default => throw new \InvalidArgumentException("Unsupported payment method: $Data"),
        };
    }
}
