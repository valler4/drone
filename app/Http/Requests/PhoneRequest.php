<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhoneRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'phone' => 'required|string|regex:/^[0-9]{7,15}$/|unique:users,phone,' . $this->user()->id,
        ];
        [
            'phone.required' => 'Phone number is required',
            'phone.unique' => 'Phone number already exists',
            'phone.regex' => 'Phone number is invalid',
        ];
    }
}
