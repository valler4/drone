<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class passwordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'password' => 'required|string|min:8|filled|current_password',
            'new_password' => 'required|string|min:8|filled|different:password|confirmed',
        ];
        [
            'password.required' => 'Password is required',
            'password.confirmed' => 'Password confirmation does not match',
            'password.filled' => 'Password is required',
            'new_password.required' => 'New Password is required',
            'new_password.min' => 'New Password must be at least 8 characters',
            'new_password.filled' => 'New Password is required',
            'new_password.different' => 'New Password must be different from the current password',
        ];
    }
}
