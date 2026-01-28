<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'receiver_id' => 'required|string|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
            'note' => 'nullable|string',
        ];
        [
            'receiver_id.required' => 'Receiver ID is required.',
            'receiver_id.exists' => 'The specified receiver does not exist.',
            'amount.required' => 'Amount is required.',
            'amount.numeric' => 'Amount must be a number.',
            'amount.min' => 'Amount must be at least 0.01.',
        ];
    }
}
