<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\securityRequest;
use App\Traits\Logs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SecurityController extends Controller
{
    use Logs;

    public function updatePassword(securityRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        $user->update([
            'password' => bcrypt($request->new_password),
        ]);

        auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        auth::login($user);

        return redirect('/home')->with('success', 'Password updated successfully');
    }

    public function updatePinCode(securityRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        $user->update([
            'pin_code' => bcrypt($request->pin_code),
        ]);

        return redirect('/home')->with('success', 'pin code updated successfully');
    }
}
