<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\MailEmail;
use App\Traits\Logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class userController extends Controller
{
    use Logs;

    public function deleteAccount(Request $request)
    {
        $user = $request->user();

        // If OTP present, verify and delete account
        if ($request->has('otp')) {
            $expiresAt = session('delete_otp_expires_at');
            $userOtp = $request->input('otp');
            $sessionOtp = session('delete_otp');

            if ($expiresAt < now()) {
                return redirect()->route('settings')->withErrors(['otp' => 'Code has expired, please try again']);
            }

            if ($userOtp == $sessionOtp) {
                $this->logActivity('delete account', '1', "id: {$user->id} user {$user->user_name} deleted account");
                session()->forget(['delete_otp', 'delete_otp_expires_at']);
                $user->delete();

                return redirect('/home')->with('success', 'Account deleted successfully');
            }

            return back()->withErrors(['otp' => 'Invalid OTP']);
        }

        // No OTP => initiate delete flow: send OTP to user's email and show confirm view
        $mailOtp = rand(100000, 999999);
        session([
            'delete_otp' => $mailOtp,
            'delete_otp_expires_at' => now()->addMinutes(10),
            // Keep compatibility with existing email template which reads 'mail_otp'
            'mail_otp' => $mailOtp,
            'mail_otp_expires_at' => now()->addMinutes(10),
        ]);

        // send email
        try {
            Mail::to($user->email)->send(new MailEmail(session('mail_otp')));
        } catch (\Throwable $e) {
            // log but continue to show confirm view
            $this->logActivity('delete account', 'error', "failed to send delete otp to {$user->email}");
        }

        $this->logActivity('request delete account', 'otp sent', "id: {$user->id} user {$user->user_name} requested delete otp {$mailOtp}");

        return view('edits.confirm', [
            'user' => $user,
            'newvalue' => $user->email,
            'newvalue_label' => 'email',
            'title' => 'Confirm Account Deletion',
            'actionRoute' => route('delete-account'),
            'method' => 'DELETE',
            'resendRoute' => route('delete-account'),
            'resendMethod' => 'DELETE',
        ]);
    }

    /**
     * Allow GET requests to show/initiate the delete confirmation flow.
     */
    public function showDeleteConfirm(Request $request)
    {
        $user = $request->user();

        // If there's an active OTP, just show the confirm view
        $expiresAt = session('delete_otp_expires_at');
        if ($expiresAt && $expiresAt > now() && session('delete_otp')) {
            return view('edits.confirm', [
                'user' => $user,
                'newvalue' => $user->email,
                'newvalue_label' => 'email',
                'title' => 'Confirm Account Deletion',
                'actionRoute' => route('delete-account'),
                'method' => 'DELETE',
                'resendRoute' => route('delete-account'),
                'resendMethod' => 'DELETE',
            ]);
        }

        // Otherwise initiate the flow (generate OTP and send email)
        $mailOtp = rand(100000, 999999);
        session([
            'delete_otp' => $mailOtp,
            'delete_otp_expires_at' => now()->addMinutes(10),
            'mail_otp' => $mailOtp,
            'mail_otp_expires_at' => now()->addMinutes(10),
        ]);

        try {
            mail::to($user->email)->send(new MailEmail(session('mail_otp')));
        } catch (\Throwable $e) {
            $this->logActivity('delete account', 'error', "failed to send delete otp to {$user->email}");
        }

        $this->logActivity('account deleted', 'email code sent', "id: {$user->id} deleting his account his otp {$mailOtp}");

        return view('edits.confirm', [
            'user' => $user,
            'newvalue' => $user->email,
            'newvalue_label' => 'email',
            'title' => 'Confirm Account Deletion',
            'actionRoute' => route('delete-account'),
            'method' => 'DELETE',
            'resendRoute' => route('delete-account'),
            'resendMethod' => 'DELETE',
        ]);
    }
}
