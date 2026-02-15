<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            do {
                $model->id = str_pad(mt_rand(1000000000, 9999999999), 8, '0', STR_PAD_LEFT);
            } while (self::where('id', $model->id)->exists());
        });
        static::deleting(function ($product) {
            if ($product->product_image) {
                Storage::disk('public')->delete($product->product_image);
            }
        });
    }
    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'status',
        'product_image',
    ];

    public function getImageUrlAttribute()
    {
        if (!$this->product_image) {
            return asset('images/default-product.jpg');
        } else {
            return asset(storage::url($this->product_image));
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
