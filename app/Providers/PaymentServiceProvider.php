<?php

namespace App\Providers;

use App\Interfaces\PaymentGatewayInterface;
use Database\Factories\PaymentFactory;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PaymentGatewayInterface::class, function ($app) {
            $Data = request()->input('payment_Data');

            return PaymentFactory::make($Data);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
