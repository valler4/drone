<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\authRequest;
use App\Models\User;
use App\Traits\Logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
    use Logs;

    public function auth(authRequest $request)
    {
        user::create($request->validated());
    }

    public function __invoke(Request $request)
    {

        if (Auth::attempt(
            request()->only('email', 'password'),
            request()->boolean('remember')
        )) {

            $user = $request->user();
            $user->last_login = now();
            $user->save();

            request()->session()->regenerate();

            $this->logActivity('login', 'logged in', "id: {$user->id} user {$user->user_name} logged in");

            return redirect()->intended('/home')->with('success', 'You are logged in successfully '.Auth::user()->name);

        }

        return back()
            ->withErrors(['error' => 'email or password are incorrect'])
            ->onlyInput('email');
    }
}
