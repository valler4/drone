<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50', 'regex:/^[a-zA-Z\s]+$/'],
            'user_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9-_.]+$/',
                Rule::unique('users', 'user_name')->ignore($this->user()->id)
            ],
            'bio' => ['nullable', 'string', 'max:1000'],
            'country' => ['nullable', 'string', 'max:100'],
            'gender' => ['nullable', Rule::in(['male', 'female', 'programmer'])],
            'age' => ['nullable', 'integer', 'between:0,150'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Display name is required.',
            'name.regex' => 'The name may only contain letters and spaces.',
            'user_name.required' => 'Username is mandatory.',
            'user_name.unique' => 'This username has already been taken.',
            'user_name.regex' => 'Username contains invalid characters.',
            'bio.max' => 'Bio description is too long (Max 1000 characters).',
            'gender.in' => 'Please select a valid gender option.',
            'age.integer' => 'Age must be a valid number.',
            'age.between' => 'Age must be between 0 and 150.',
            'profile_image.image' => 'The uploaded file must be an image.',
            'profile_image.mimes' => 'Only JPEG, PNG, JPG, and GIF files are allowed.',
            'profile_image.max' => 'Image size must not exceed 2MB.',
        ];
    }
}
