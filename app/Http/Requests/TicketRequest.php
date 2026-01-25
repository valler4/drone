<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
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
        $pattern = $this->allowedPattern();

        return [
            'title' => ['required', 'string', 'max:255', 'min:3', 'regex:'.$pattern],
            'subject' => ['required', 'string', 'max:1000', 'min:10', 'regex:'.$pattern],
        ];
    }

    /**
     * Allowed characters pattern used by validation rules.
     */
    protected function allowedPattern(): string
    {
        return '/^[a-zA-Z0-9\s.,;:!?()\[\]{}<>#%&@\'"-]*$/';
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'title.string' => 'Title must be a string',
            'title.max' => 'Title must be less than 255 characters',
            'title.min' => 'Title must be at least 3 characters',
            'subject.required' => 'Description is required',
            'subject.string' => 'Description must be a string',
            'subject.max' => 'Description must be less than 1000 characters',
            'subject.min' => 'Description must be at least 10 characters',
        ];
    }
}
