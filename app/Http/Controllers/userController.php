<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\Logs;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    use Logs;

    public function deleteAccount(Request $request)
    {
        $user = $request->user();

        if (!Hash::check($request->password, $user->password))
        {
            return back()->withErrors(['password' => 'Password is incorrect']);
        }

        $this->logActivity('delete account', "id: {$user->id} user {$user->user_name} deleted account");

        $user->delete();

        return redirect('/home')->with('success', 'Account deleted successfully');
    }
}
