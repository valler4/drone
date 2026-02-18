<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public $incrementing = true;
    protected $fillable = ['title', 'subject', 'user_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
