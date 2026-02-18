<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    public $incrementing = true;

    protected $table = 'deposits';

    protected $fillable = [
        'user_id',
        'amount',
        'type',
        'payment_id',
        'currency',
        'status',
        'method',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
