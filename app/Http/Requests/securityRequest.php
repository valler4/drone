<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class securityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'new_password' => 'required|string|min:8|filled|different:password|confirmed',
            'pin_code' => 'required|digits_between:4,8|numeric',
        ];
        [
            'password.confirmed' => 'Password confirmation does not match',
            'new_password.required' => 'New Password is required',
            'new_password.min' => 'New Password must be at least 8 characters',
            'new_password.filled' => 'New Password is required',
            'new_password.different' => 'New Password must be different from the current password',
            'pin_code.required' => 'Pin Code is required',
            'pin_code.filled' => 'Pin Code is required',
            'pin_code.digits_between' => 'Pin Code must be 4 to 8 digits',
            'pin_code.numeric' => 'Pin Code must be a number',
        ];
    }
}
