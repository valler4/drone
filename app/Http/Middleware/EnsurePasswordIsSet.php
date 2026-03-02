<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsurePasswordIsSet
{
public function handle($request, Closure $next) {
    if (auth::check() && is_null(auth::user()->password) && !$request->is('set-password*')) {
        return redirect()->route('password.set');
    }
    return $next($request);
}
}
