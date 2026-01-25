<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\MailEmail;
use Illuminate\Support\Facades\Mail;
use App\Traits\Logs;

class EmailController extends Controller
{
    use Logs;
    public function sendEmailotp(EmailRequest $request)
    {
        if (user::where('email', $request->email)->exists()) {
            return back()->withErrors('email', 'Email already exists');
        } else {
            $email = $request->email;
            $user = $request->user();
            $mail_otp = rand(100000, 999999);

            session([
                'mail_otp' => $mail_otp,
                'temp_email' => $request->email,
                'mail_otp_expires_at' => now()->addMinutes(10),
                'otp_sent_at' => now(),
                'can_send_again' => now()->addSeconds(10),
            ]);
            $expiresat = session('mail_otp_expires_at');

            mail::to($email)->send(new MailEmail(session('mail_otp')));

            $this->logActivity('send otp email', "id: {$user->id} user {$user->user_name} is sending email code from: {$user->email} to {$email} otp {$mail_otp} expires in {$expiresat}");

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

            $this->logActivity('updated email', "id: {$user->id} user {$user->user_name} updated his email from: {$user->email} to {$tempEmail}");

            return redirect()->route('profile')->with('success', 'Email updated successfully');
        }
        return back()->withErrors(['otp' => 'Invalid OTP']);
    }

    public function resendmail(Request $request)
    {
        $resendemail = session('temp_email');
        if (!$resendemail) {
            return back()->withErrors(['error' => 'Session expired, please try again.']);
        } else {
            if (user::where('email', $request->email)->exists()) {
                return back()->withErrors('email', 'Email already exists');
            } else {
                $email = $resendemail;
                $user = $request->user();
                $mail_otp = rand(100000, 999999);

                session([
                    'mail_otp' => $mail_otp,
                    'temp_email' => $resendemail,
                    'mail_otp_expires_at' => now()->addMinutes(10),
                    'otp_sent_at' => now(),
                    'can_send_again' => now()->addSeconds(10),
                ]);
                $expiresat = session('mail_otp_expires_at');

                mail::to($email)->send(new MailEmail(session('mail_otp')));

                $this->logActivity('resend otp email', "id: {$user->id} user {$user->user_name} is resending email code from: {$user->email} to {$email} otp {$mail_otp} expires at {$expiresat}");

                return redirect()->route('confirm-email')->with('success', 'code sent successfully');
            }
        }
    }
}
