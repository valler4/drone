<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class CustomServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->ratelimit();
    }

    public function ratelimit(): void
    {
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(10)
                ->by($request->input('email').$request->ip())
                ->response(function () {
                    return back()->withErrors(['error' => 'you have made too many attempts please try again later']);
                });
        });
        RateLimiter::for('AuthView', function (Request $request) {
            return Limit::perMinute(30)
                ->by($request->ip())
                ->response(function () {
                    return back()->withErrors(['error' => 'you have made too many attempts please try again later']);
                });
        });
        RateLimiter::for('view', function (Request $request) {
            return Limit::perMinute(60)
                ->by($request->user()->id.$request->ip())
                ->response(function () {
                    return back()->withErrors(['error' => 'you have made too many attempts please try again later']);
                });
        });
        RateLimiter::for('logout', function (Request $request) {
            return Limit::perMinute(10)
                ->by($request->user()->id.$request->ip())
                ->response(function () {
                    return back()->withErrors(['error' => 'you have made too many attempts please try again later']);
                });
        });
        RateLimiter::for('register', function (Request $request) {
            return Limit::perMinute(10)
                ->by($request->input('email').$request->ip())
                ->response(function () {
                    return back()->withErrors(['error' => 'you have made too many attempts please try again later']);
                });
        });
        RateLimiter::for('email', function (Request $request) {
            return Limit::perMinute(10)
                ->by($request->user()->id.$request->ip())
                ->response(function () {
                    return back()->withErrors(['otp' => 'you have made too many attempts please try again later']);
                });
        });
        RateLimiter::for('resend-email-otp', function (Request $request) {
            return Limit::perMinute(10)
                ->by($request->user()->id.$request->ip())
                ->response(function () {
                    return back()->withErrors(['otp' => 'you have made too many attempts please try again later']);
                });
        });
        RateLimiter::for('confirm-email', function (Request $request) {
            return Limit::perMinute(10)
                ->by($request->user()->id.$request->ip())
                ->response(function () {
                    return back()->withErrors(['otp' => 'you have made too many attempts please try again later']);
                });
        });
        RateLimiter::for('profile', function (Request $request) {
            return Limit::perMinute(10)
                ->by($request->user()->id.$request->ip())
                ->response(function () {
                    return back()->withErrors(['error' => 'you have made too many attempts please try again later']);
                });
        });
        RateLimiter::for('phone', function (Request $request) {
            return Limit::perMinute(10)
                ->by($request->user()->id.$request->ip())
                ->response(function () {
                    return back()->withErrors(['otp' => 'you have made too many attempts please try again later']);
                });
        });
        RateLimiter::for('confirm-phone', function (Request $request) {
            return Limit::perMinute(10)
                ->by($request->user()->id.$request->ip())
                ->response(function () {
                    return back()->withErrors(['otp' => 'you have made too many attempts please try again later']);
                });
        });
        RateLimiter::for('password', function (Request $request) {
            return Limit::perMinute(10)
                ->by($request->user()->id.$request->ip())
                ->response(function () {
                    return back()->withErrors(['error' => 'you have made too many attempts please try again later']);
                });
        });
        RateLimiter::for('pin-code', function (Request $request) {
            return Limit::perMinute(10)
                ->by($request->user()->id.$request->ip())
                ->response(function () {
                    return back()->withErrors(['error' => 'you have made too many attempts please try again later']);
                });
        });
        RateLimiter::for('delete-account', function (Request $request) {
            return Limit::perMinute(10)
                ->by($request->user()->id.$request->ip())
                ->response(function () {
                    return back()->withErrors(['error' => 'you have made too many attempts please try again later']);
                });
        });
        RateLimiter::for('tickets', function (Request $request) {
            return Limit::perMinute(10)
                ->by($request->user()->id.$request->user()->id.$request->ip())
                ->response(function () {
                    return back()->withErrors(['error' => 'you have made too many attempts please try again later']);
                });
        });
        RateLimiter::for('products', function (Request $request) {
            return Limit::perMinute(10)
                ->by($request->user()->id.$request->ip())
                ->response(function () {
                    return back()->withErrors(['error' => 'you have made too many attempts please try again later']);
                });
        });
        RateLimiter::for('transfer', function (Request $request) {
            return Limit::perMinute(10)
                ->by($request->user()->id.$request->ip())
                ->response(function () {
                    return back()->withErrors(['error' => 'you have made too many attempts please try again later']);
                });
        });
        RateLimiter::for('payment', function (Request $request) {
            return Limit::perMinute(10)
                ->by($request->user()->id.$request->ip())
                ->response(function () {
                    return back()->withErrors(['error' => 'you have made too many attempts please try again later']);
                });
        });
        RateLimiter::for('admin', function (Request $request) {
            return Limit::perMinute(100)
                ->by($request->user()->id.$request->ip())
                ->response(function () {
                    return back()->withErrors(['error' => 'you have made too many attempts please try again later']);
                });
        });
    }
}
