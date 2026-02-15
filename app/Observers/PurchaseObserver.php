<?php

namespace App\Observers;

use App\Models\Purchase;
use App\Traits\Logs;

class PurchaseObserver
{
    use Logs;
    /**
     * Handle the purchase "created" event.
     */
    public function created(purchase $purchase): void
    {
        $this->logActivity(
            'purchase created',
            "purchase ID: {$purchase->id} | amount: {$purchase->price} created successfully",
            "purchase ID: {$purchase->id} | buyer ID: {$purchase->buyer_id} | seller ID: {$purchase->seller_id} | amount: {$purchase->price} created successfully"
        );
    }

    /**
     * Handle the purchase "updated" event.
     */
    public function updated(purchase $purchase): void
    {
        //
    }

    /**
     * Handle the purchase "deleted" event.
     */
    public function deleted(purchase $purchase): void
    {
        //
    }

    /**
     * Handle the purchase "restored" event.
     */
    public function restored(purchase $purchase): void
    {
        //
    }

    /**
     * Handle the purchase "force deleted" event.
     */
    public function forceDeleted(purchase $purchase): void
    {
        //
    }
}
