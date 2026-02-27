<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Ticket extends Model
{
    use Searchable;

    public function toSearchableArray()
    {
        return [
            'id'=>$this->id,
            'title' => $this->title,
            'subject' => $this->subject,
        ];
    }

    public $incrementing = true;
    protected $fillable = ['title', 'subject', 'user_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
