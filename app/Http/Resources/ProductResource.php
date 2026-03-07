<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'status' => $this->status,
            'product_image' => $this->product_image ? asset('storage/' . $this->product_image) : null,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'user_name' => $this->user->user_name,
            ],
        ];
    }
}
