<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PinCodeRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pin_code' => 'required|digits_between:4,8|numeric',
        ];
        [
            'pin_code.required' => 'Pin Code is required',
            'pin_code.filled' => 'Pin Code is required',
            'pin_code.digits_between' => 'Pin Code must be 4 to 8 digits',
            'pin_code.numeric' => 'Pin Code must be a number',
        ];
    }
}
