<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            do {
                $model->id = str_pad(mt_rand(100000000000, 999999999999), 8, '0', STR_PAD_LEFT);
            } while (self::where('id', $model->id)->exists());
        });
    }

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
