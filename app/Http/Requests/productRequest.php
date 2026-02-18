<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class productRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|min:3',
            'description' => 'required|string|min:10',
            'price' => 'required|numeric|min:0|max:999999999',
            'quantity' => 'required|integer|min:0',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:open,close',
        ];
        [
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name must be less than 255 characters',
            'name.min' => 'Name must be at least 3 characters',
            'description.required' => 'Description is required',
            'description.string' => 'Description must be a string',
            'description.min' => 'Description must be at least 10 characters',
            'price.required' => 'Price is required',
            'price.numeric' => 'Price must be a number',
            'price.min' => 'Price must be at least 0',
            'price.max' => 'Price must be less than 999999999',
            'quantity.required' => 'Quantity is required',
            'quantity.integer' => 'Quantity must be an integer',
            'quantity.min' => 'Quantity must be at least 0',
            'product_image.image' => 'Product image must be an image',
            'product_image.mimes' => 'Product image must be a jpeg, png, jpg, or gif',
            'product_image.max' => 'Product image size must be less than 2MB',
        ];
    }
}
