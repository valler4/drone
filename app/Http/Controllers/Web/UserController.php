<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Traits\Logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    use Logs;

    public function deleteAccount(Request $request)
    {
        $user = $request->user();
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password is incorrect']);
        }
        $this->logActivity('delete account', '0', "id: {$user->id} user {$user->user_name} deleted account");
        $user->delete();

        return redirect('/home')->with('success', 'Account deleted successfully');
    }
}
