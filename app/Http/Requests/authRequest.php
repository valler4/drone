<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class authRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_name' => 'required|string|unique:users|min:3|max:50|regex:/^[a-zA-Z0-9-_.]+/',
            'name' => 'required|string|regex:/^[a-zA-Z\s]+$/|min:3|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'remember_token' => 'nullable|string',
        ];
        [
            'user_name.required' => 'Username is required',
            'user_name.unique' => 'Username already exists',
            'user_name.regex' => 'Username is not valid',
            'user_name.min' => 'Username must be at least 3 characters',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email address',
            'email.unique' => 'Email already exists',
            'name.required' => 'Name is required',
            'name.regex' => 'Name is not valid',
            'name.min' => 'Name must be at least 3 characters',
        ];
    }
}
