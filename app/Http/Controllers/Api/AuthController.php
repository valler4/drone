<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\authRequest;
use App\Models\User;
use App\Traits\Logs;
use Illuminate\Support\Facades\auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use Logs;
    public function register(authRequest $request)
    {

        $registerData = $request->validated();

        $user = User::create([
            'name' => $registerData['name'],
            'user_name' => $registerData['user_name'],
            'email' => $registerData['email'],
            'password' => bcrypt($registerData['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Registration successful! Welcome to the home page '.$user->name,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,

        ], 201);

        $user->last_login = now();
        $user->save();

        $this->logActivity('new account', 'welcome to drone', "id: {$user->id} user {$user->user_name} registered");

    }

    public function login(Request $request)
    {

    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)){
        return response()->json([
            'message' => 'Invalid email or password',
        ], 401);
    }

    $user->tokens()->delete();

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'success' => true,
        'message' => 'Login successful! Welcome to the home page '.$user->name,
        'access_token' => $token,
        'token_type' => 'Bearer',
        'user' => $user,
    ], 200);

    $user->last_login = now();
    $user->save();

    $this->logActivity('login', 'logged in', "id: {$user->id} user {$user->user_name} logged in");

    }

    public function logout(Request $request)
    {
        $user = $request->user();

        $user->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout successful! You are now logged out',
        ], 200);

        $this->logActivity('logout', 'logged out', "id: {$user->id} user {$user->user_name} logged out");
    }
}
