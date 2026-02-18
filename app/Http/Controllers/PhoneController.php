<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhoneRequest;
use App\Models\User;
use App\Traits\Logs;
use Illuminate\Http\Request;

class phoneController extends Controller
{
    use Logs;

    public function editphone()
    {
        $user = request()->user();
        return view('edits.edit-phone.edit-phone', compact('user'));
    }
    public function confirmphone()
    {
        $user = request()->user();
        $newphone = session('temp_phone');
        return view('edits.edit-phone.confirm-phone', compact('user', 'newphone'));
    }

    public function sendphone(PhoneRequest $request)
    {
        if (user::where('phone', $request->phone)->exists()) {
            return back()->withErrors('phone', 'phone already exists');
        } else {
            $phone = $request->phone;
            $user = $request->user();
            $otp = rand(100000, 999999);

            session([
                'phone_otp' => $otp,
                'temp_phone' => $request->phone,
                'phone_otp_expires_at' => now()->addMinutes(10),
            ]);
            $expiresat = session('phone_otp_expires_at');

            $this->logActivity('send phone code', 'phone code sent successfully', "id: {$user->id} user {$user->user_name} changing phone from: {$user->phone} to {$phone} otp {$otp} expires at {$expiresat}");

            return redirect()->route('confirm-phone')->with('success', 'OTP sent successfully');
        }
    }

    public function updatephone(Request $request)
    {
        $user = $request->user();
        $expiresat = session('phone_otp_expires_at');
        $userotp = $request->input('otp');
        $sessionotp = session('phone_otp');
        $tempphone = session('temp_phone');

        if ($expiresat < now()) {
            return redirect()->route('edit-phone')->withErrors(['otp' => 'code has expired please send a new one']);
        }

        if ($userotp == $sessionotp) {
            $user->phone = $tempphone;
            $user->save();

            session()->forget(['phone_otp', 'temp_phone']);

            return redirect()->route('settings')->with('success', 'phone updated successfully');
        }

        return back()->withErrors(['otp' => 'Invalid OTP']);
    }
}
