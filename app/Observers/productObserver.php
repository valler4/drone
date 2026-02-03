<?php

namespace App\Observers;

use App\Models\product;
use App\Traits\Logs;

class productObserver
{
    use Logs;
    /**
     * Handle the product "created" event.
     */
    public function created(product $product): void
    {
        $amount = $product->price;
        $this->logActivity(
            'create product',
            "Product of amount {$amount} created successfully.",
            "mr {$product->user_id} created a new product of amount {$amount} id: {$product->id}"
        );
    }

    /**
     * Handle the product "updated" event.
     */
    public function updated(product $product): void
    {
        if ($product->wasChanged('status')) {
            $this->logActivity(
                'update product',
                "product {$product->id} is now {$product->status}",
                "id: {$product->user_id} updated a product id: {$product->id}"
            );
        } elseif ($product->user_id === auth()->user()->id){
            $this->logActivity(
                'update product',
                "product {$product->id} updated successfully",
                "id: {$product->user_id} updated a product id: {$product->id}"
            );
        }
    }

    /**
     * Handle the product "deleted" event.
     */
    public function deleted(product $product): void
    {
        $this->logActivity(
            'delete product',
            "product {$product->id} deleted successfully",
            "id: {$product->user_id} deleted a product id: {$product->id}"
        );
    }

    /**
     * Handle the product "restored" event.
     */
    public function restored(product $product): void
    {
        //
    }

    /**
     * Handle the product "force deleted" event.
     */
    public function forceDeleted(product $product): void
    {
        //
    }
}
