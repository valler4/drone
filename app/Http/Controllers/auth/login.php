<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\authRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Traits\Logs;

class login extends Controller
{
    use Logs;

    public function auth(authRequest $request){
        user::create($request->validated());
    }

    public function __invoke(Request $request)
    {

        if (Auth::attempt(
            request()->only('email','password'),
            request()->boolean('remember')
        )){

            $user = $request->user();
            $user->last_login = now();
            $user->save();

            $this->logActivity('login', "id: {$user->id} user {$user->user_name} logged in");

            request()->session()->regenerate();
            return redirect()->intended('/home')->with('success', 'You are logged in successfully ' . Auth::user()->name);


            }

        return back()
        ->withErrors(['error'=>'email or password are incorrect'])
        ->onlyInput('email');
    }
}
