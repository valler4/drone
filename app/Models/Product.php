<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use Searchable;

    public function toSearchableArray()
    {
        return[
            'id'=>$this->id,
            'name'=>$this->name,
            'description'=>$this->description,
        ];
    }

    public $incrementing = true;
    protected static function boot()
    {
        parent::boot();
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
