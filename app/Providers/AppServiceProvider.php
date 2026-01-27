<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\ticket;
use App\Observers\UserObserver;
use App\Observers\ticketObserver;
use App\Policies\ticketpolicy;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        ticket::class => ticketpolicy::class,
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
    }

    public function registerPolicies(): void
    {
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }
}
