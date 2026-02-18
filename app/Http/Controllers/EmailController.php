<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailRequest;
use App\Mail\MailEmail;
use App\Models\User;
use App\Traits\Logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    use Logs;
    public function editemail()
    {
        $user = request()->user();
        return view('edits.edit-email.edit-email', compact('user'));
    }

    public function confirmemail()
    {
        $user = request()->user();
        $newemail = session('temp_email');
        return view('edits.edit-email.confirm-email', compact('user', 'newemail'));
    }


    public function sendEmailotp(EmailRequest $request)
    {
        if (user::where('email', $request->email)->exists()) {
            return back()->withErrors('otp', 'Email already exists');
        } else {
            $email = $request->email;
            $user = $request->user();
            $mail_otp = rand(100000, 999999);

            session([
                'mail_otp' => $mail_otp,
                'temp_email' => $request->email,
                'mail_otp_expires_at' => now()->addMinutes(10),
            ]);
            $expiresat = session('mail_otp_expires_at');

            mail::to($email)->send(new MailEmail(session('mail_otp')));

            $this->logActivity('send email code', 'email code sent', "id: {$user->id} changing email from: {$user->email} to {$email} otp {$mail_otp} expires at {$expiresat}");

            return redirect()->route('confirm-email')->with('success', 'code sent successfully');
        }
    }

    public function updateEmail(Request $request)
    {
        $user = $request->user();
        $expiresat = session('mail_otp_expires_at');
        $userotp = $request->input('otp');
        $sessionotp = session('mail_otp');
        $tempEmail = session('temp_email');

        if ($expiresat < now()) {
            return redirect()->route('edit-email')->withErrors(['otp' => 'code has expired please send a new one']);
        }

        if ($userotp == $sessionotp) {
            $user->email = $tempEmail;
            $user->save();

            session()->forget(['mail_otp', 'temp_email']);

            return redirect()->route('settings')->with('success', 'Email updated successfully');
        }

        return back()->withErrors(['otp' => 'Invalid OTP']);
    }

}
