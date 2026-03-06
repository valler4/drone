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
            'new_password' => 'required|string|min:8|filled|different:password|confirmed',
        ];
        [
            'password.confirmed' => 'Password confirmation does not match',
            'new_password.required' => 'New Password is required',
            'new_password.min' => 'New Password must be at least 8 characters',
            'new_password.filled' => 'New Password is required',
            'new_password.different' => 'New Password must be different from the current password',
        ];
    }
}
