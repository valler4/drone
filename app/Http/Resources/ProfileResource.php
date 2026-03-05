<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'success' => true,
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'bio' => $this->bio,
            'age' => $this->age,
            'gender' => $this->gender,
            'country' => $this->country,
            'created_at' => $this->created_at,

            'friendRequest' => $this->when(isset($this->friendship_info), $this->friendship_info)
        ];
    }
}
