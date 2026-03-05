<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'success'=>true,
            'id'=>$this->id,
            'title'=>$this->title,
            'subject'=>$this->subject,
            'status'=>$this->status,
            'user_id'=>$this->user_id,
            'owner'=>$this->user->name,
            'created_at'=>$this->created_at->format('Y-m-d H:i'),
            'updated_at'=>$this->updated_at->format('Y-m-d H:i'),
        ];
    }
}
