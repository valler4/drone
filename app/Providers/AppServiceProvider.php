<?php

namespace App\Providers;

use App\Models\Deposit;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\User;
use App\Observers\DepositObserver;
use App\Observers\ProductObserver;
use App\Observers\PurchaseObserver;
use App\Observers\TicketObserver;
use App\Observers\TransactionObserver;
use App\Observers\UserObserver;
use App\Policies\ProductPolicy;
use App\Policies\TicketPolicy;
use App\Policies\TransactionPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Ticket::class => TicketPolicy::class,
        Transaction::class => TransactionPolicy::class,
        Product::class => ProductPolicy::class,
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->registerPolicies();
        User::observe(UserObserver::class);
        Ticket::observe(TicketObserver::class);
        Transaction::observe(TransactionObserver::class);
        Deposit::observe(DepositObserver::class);
        Product::observe(ProductObserver::class);
        Purchase::observe(PurchaseObserver::class);

        Ratelimiter::for('api', function (Request $request) {
            return $request->user()
                ? Limit::perMinute(60)->by($request->user()->id)
                : Limit::perMinute(30)->by($request->ip());
        });
    }

    public function registerPolicies(): void
    {
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }
}
