<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\ticket;
use App\Models\transaction;
use App\Observers\UserObserver;
use App\Observers\ticketObserver;
use App\Observers\transactionObserver;
use App\Policies\ticketpolicy;
use App\Policies\transactionpolicy;
use App\Models\User;
use App\Models\deposit;
use App\Observers\depositObserver;
use App\Policies\productpolicy;
use App\Models\product;
use App\Models\purchase;
use App\Observers\productObserver;
use App\Observers\purchaseObserver;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        ticket::class => ticketpolicy::class,
        transaction::class => transactionpolicy::class,
        product::class => productpolicy::class
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->registerPolicies();
        User::observe(UserObserver::class);
        ticket::observe(ticketObserver::class);
        transaction::observe(transactionObserver::class);
        deposit::observe(depositObserver::class);
        product::observe(productObserver::class);
        purchase::observe(purchaseObserver::class);
    }

    public function registerPolicies(): void
    {
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }
}
