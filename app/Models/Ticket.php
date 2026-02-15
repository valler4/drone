<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            do {
                $model->id = str_pad(mt_rand(10000000, 99999999), 8, '0', STR_PAD_LEFT);
            } while (self::where('id', $model->id)->exists());
        });
    }
    protected $fillable = ['title', 'subject', 'user_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
