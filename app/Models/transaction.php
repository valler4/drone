<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class transaction extends Model
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
