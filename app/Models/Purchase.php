<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            do {
                $model->id = str_pad(mt_rand(1000000000, 9999999999), 8, '0', STR_PAD_LEFT);
            } while (self::where('id', $model->id)->exists());
        });
    }
    protected $fillable = ['buyer_id', 'seller_id', 'product_id', 'quantity', 'price','status'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class , 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class , 'seller_id');
    }
}
