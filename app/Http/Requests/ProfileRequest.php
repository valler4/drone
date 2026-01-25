<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'user_name' => 'required|string|max:255|regex:/^[a-zA-Z0-9-_.]+/|unique:users,user_name,' . $this->user()->id,
            'name' => 'required|string|regex:/^[a-zA-Z\s]+$/|max:50',
            'age' => 'nullable|integer|between:0,150',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
        [
            'user_name.required' => 'Username is required',
            'user_name.unique' => 'Username already exists',
            'email.email' => 'Email must be a valid email address',
            'email.unique' => 'Email already exists',
            'phone.digits_between' => 'Phone number must be between 7 and 15 digits',
            'phone.unique' => 'Phone number already exists',
            'age.integer' => 'Age must be an integer',
            'age.between' => 'Age must be between 0 and 150',
            'profile_image.image' => 'Profile image must be an image',
            'profile_image.mimes' => 'Profile image must be a JPEG, PNG, or JPG',
            'profile_image.max' => 'Profile image size must be less than 2MB',
            'name.required' => 'Name is required',
            'name.regex' => 'Name must contain only letters and spaces',
        ];
    }
}
