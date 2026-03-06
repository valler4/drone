<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'success' => true,
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'profile_image' => $this->profile_image
            ? asset('storage/profile_images/' . $this->profile_image)
            : asset('storage/profile_images/default.png'),
            'bio' => $this->bio,
            'age' => $this->age,
            'gender' => $this->gender,
            'country' => $this->country,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),

            'friendRequest' => $this->when(isset($this->friendship_info), $this->friendship_info)
        ];
    }
}
