<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public $incrementing = true;
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
