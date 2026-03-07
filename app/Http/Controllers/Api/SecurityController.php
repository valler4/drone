<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\passwordRequest;
use App\Http\Requests\PinCodeRequest;
use App\Traits\Logs;
use Illuminate\Support\Facades\Hash;

class SecurityController extends Controller
{
    use Logs;

    public function updatePassword(passwordRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        $user->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully. Please login again.',
        ], 200);
    }

    public function updatePinCode(PinCodeRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        $user->update([
            'pin_code' => Hash::make($request->pin_code),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pin code updated successfully',
        ], 200);
    }
}
