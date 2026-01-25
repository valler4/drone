<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhoneRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\Logs;

class phoneController extends Controller
{
    use Logs;
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
                'otp_sent_at' => now(),
                'can_send_again' => now()->addSeconds(10),
            ]);
            $expiresat = session(',ail_otp_expires_at');

            $this->logActivity('send otp phone', "id: {$user->id} user {$user->user_name} is sending phone code from: {$user->phone} to {$phone} otp {$otp} expires at {$expiresat}");

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

            $this->logActivity('updated phone', "id: {$user->id} user {$user->user_name} updated his phone from: {$user->phone} to {$tempphone}");

            return redirect()->route('profile')->with('success', 'phone updated successfully');
        }
        return back()->withErrors(['otp' => 'Invalid OTP']);
    }

    public function resendphone(Request $request)
    {
        if (session('can_send_again') && now()->devinseconds(session('can_send_again')) < 10) {
            return back()->withErrors(['error' => 'Please wait before sending another code.']);
        }
        $resendphone = session('temp_phone');
        if (!$resendphone) {
            return back()->withErrors(['error' => 'Session expired, please try again.']);
        } else {
            if (user::where('phone', $request->phone)->exists()) {
                return back()->withErrors('phone', 'phone already exists');
            } else {
                $phone = $resendphone;
                $user = $request->user();
                $phone_otp = rand(100000, 999999);

                session([
                    'phone_otp' => $phone_otp,
                    'temp_phone' => $resendphone,
                    'phone_otp_expires_at' => now()->addMinutes(10),
                    'otp_sent_at' => now(),
                    'can_send_again' => now()->addSeconds(10),
                ]);
                $expiresat = session('phone_otp_expires_at');

                $this->logActivity('resend otp phone', "id: {$user->id} user {$user->user_name} is resending phone code to update from: {$user->phone} to {$phone} otp {$phone_otp} expires at {$expiresat}");

                return redirect()->route('confirm-phone')->with('success', 'code sent successfully');
            }
        }
    }
}
