<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\authRequest;
use App\Models\User;
use App\Traits\Logs;
use Illuminate\Support\Facades\auth;

class registerController extends Controller
{
    use Logs;

    public function __invoke(authRequest $request)
    {

        $registerdata = $request->validated();

        $user = User::create([
            'name' => $registerdata['name'],
            'user_name' => $registerdata['user_name'],
            'email' => $registerdata['email'],
            'password' => bcrypt($registerdata['password']),
        ]);

        auth::login($user);

        $user->last_login = now();
        $user->save();

        $this->logActivity('new account', 'welcome to drone', "id: {$user->id} user {$user->user_name} registered");

        return redirect('/home')->with('success', 'Registration successful! Welcome to the home page '.$user->name);

    }
}
