<?php

namespace App\Observers;

use App\Models\Transaction;
use App\Traits\Logs;

class TransactionObserver
{
    use Logs;
    /**
     * Handle the Transaction "created" event.
     */
    public function created(transaction $transaction): void
    {
        $receivername = $transaction->receiver->user_name;
        $senderid = $transaction->sender->id;
        $receiverid = $transaction->receiver->id;
        $amount = $transaction->amount;
        $this->logActivity(
            'transfer money',
            "Transaction of amount {$amount} mr.  {$receivername}  completed successfully.",
            "Transaction of amount {$amount} from user ID: {$senderid} to user ID: {$receiverid} completed successfully."
        );
    }

    /**
     * Handle the Transaction "updated" event.
     */
    public function updated(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "deleted" event.
     */
    public function deleted(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "restored" event.
     */
    public function restored(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "force deleted" event.
     */
    public function forceDeleted(Transaction $transaction): void
    {
        //
    }
}
