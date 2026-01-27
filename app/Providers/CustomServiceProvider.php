<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;


class CustomServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
            $this->ratelimit();
    }

    public function ratelimit(): void
    {
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5,1)
            ->by($request->ip())
            ->response(function(){
                return back()->withErrors(['error' => 'you have made too many attempts please try again later']);
            });
        });
        RateLimiter::for('register', function (Request $request) {
            return Limit::perHour(24243)
            ->by($request->ip())
            ->response(function(){
                return back()->withErrors(['error' => 'you have made too many attempts please try again later']);
            });
        });
        RateLimiter::for('email', function (Request $request) {
            return Limit::perMinute(444)
            ->by($request->ip())
            ->response(function(){
                return back()->withErrors(['otp' => 'you have made too many attempts please try again later']);
            });
        });
        RateLimiter::for('resend-email-otp', function (Request $request) {
            return Limit::perMinute(4)
            ->by($request->ip())
            ->response(function(){
                return back()->withErrors(['otp' => 'you have made too many attempts please try again later']);
            });
        });
        RateLimiter::for('confirm-email', function (Request $request) {
            return Limit::perMinute(4)
            ->by($request->ip())
            ->response(function(){
                return back()->withErrors(['otp' => 'you have made too many attempts please try again later']);
            });
        });
        RateLimiter::for('profile', function (Request $request) {
            return Limit::perMinute(5)
            ->by($request->ip())
            ->response(function(){
                return back()->withErrors(['error' => 'you have made too many attempts please try again later']);
            });
        });
        RateLimiter::for('phone', function (Request $request) {
            return Limit::perMinute(50)
            ->by($request->ip())
            ->response(function(){
                return back()->withErrors(['otp' => 'you have made too many attempts please try again later']);
            });
        });
        RateLimiter::for('confirm-phone', function (Request $request) {
            return Limit::perMinute(89)
            ->by($request->ip())
            ->response(function(){
                return back()->withErrors(['otp' => 'you have made too many attempts please try again later']);
            });
        });
        RateLimiter::for('password', function (Request $request) {
            return Limit::perMinute(5)
            ->by($request->ip())
            ->response(function(){
                return back()->withErrors(['error' => 'you have made too many attempts please try again later']);
            });
        });
        RateLimiter::for('pin-code', function (Request $request) {
            return Limit::perMinute(5)
            ->by($request->ip())
            ->response(function(){
                return back()->withErrors(['error' => 'you have made too many attempts please try again later']);
            });
        });
        RateLimiter::for('pin-code', function (Request $request) {
            return Limit::perMinute(3)
            ->by($request->ip())
            ->response(function(){
                return back()->withErrors(['error' => 'you have made too many attempts please try again later']);
            });
        });
        RateLimiter::for('delete-account', function (Request $request) {
            return Limit::perMinute(3)
            ->by($request->ip())
            ->response(function(){
                return back()->withErrors(['error' => 'you have made too many attempts please try again later']);
            });
        });
        RateLimiter::for('tickets', function (Request $request) {
            return Limit::perMinute(3889)
            ->by($request->ip())
            ->response(function(){
                return back()->withErrors(['error' => 'you have made too many attempts please try again later']);
            });
        });
    }
}
