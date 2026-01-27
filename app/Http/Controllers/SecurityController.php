<?php

namespace App\Http\Controllers;

use App\Http\Requests\passwordRequest;
use App\Http\Requests\PinCodeRequest;
use App\Traits\Logs;
use Illuminate\Support\Facades\Auth;

class SecurityController extends Controller
{
    use Logs;

    public function updatePassword(passwordRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        $user->update([
            'password' => $request->new_password,
        ]);

        // $this->logActivity('update password', 'password updated successfully', "id: {$user->id} user {$user->user_name} updated password");

        auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/home')->with('success', 'Password updated successfully, please log in again');
    }

    public function updatePinCode(PinCodeRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        $user->update([
            'pin_code' => bcrypt($request->pin_code),
        ]);

        return redirect('/home')->with('success', 'pin code updated successfully');
    }
}
