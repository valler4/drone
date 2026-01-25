<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\Logs;

class logout extends Controller
{
    use Logs;
    public function __invoke(Request $request)
    {
        $user = $request->user();

        $this->logActivity('logout', "id: {$user->id} user {$user->user_name} logged out");

        auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/home')->with('success', 'You are logged out successfully');
    }
}
