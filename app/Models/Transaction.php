<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $incrementing = true;
    protected $table = 'transactions';
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'amount',
        'type',
        'note',
    ];
    // Relations for observer use
    public function sender()
    {
        return $this->belongsTo(User::class,'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class,'receiver_id');
    }

}
