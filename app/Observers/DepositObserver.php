<?php

namespace App\Observers;

use App\Models\Deposit;
use App\Traits\Logs;

class DepositObserver
{
    use Logs;

    /**
     * Handle the Transaction "created" event.
     */
    public function created(deposit $deposit): void
    {
        $metadata = json_encode([
            'deposit_id' => $deposit->id,
            'paypal_order_id' => $deposit->payment_id,
            'amount' => $deposit->amount,
            'currency' => $deposit->currency,
            'type' => $deposit->type
        ]);

        $this->logActivity(
            'coin purchase',
            "Deposit of amount {$deposit->amount} by {$deposit->method} completed successfully.",
            $metadata
        );
    }

    /**
     * Handle the Transaction "updated" event.
     */
    public function updated(deposit $deposit): void
    {
        //
    }

    /**
     * Handle the Transaction "deleted" event.
     */
    public function deleted(deposit $deposit): void
    {
        //
    }

    /**
     * Handle the Transaction "restored" event.
     */
    public function restored(deposit $deposit): void
    {
        //
    }

    /**
     * Handle the Transaction "force deleted" event.
     */
    public function forceDeleted(deposit $deposit): void
    {
        //
    }
}
