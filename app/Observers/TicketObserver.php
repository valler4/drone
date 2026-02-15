<?php

namespace App\Observers;

use App\Models\Ticket;
use App\Traits\Logs;

class TicketObserver
{
    use Logs;
    /**
     * Handle the ticket "created" event.
     */
    public function created(ticket $ticket): void
    {
        $this->logActivity(
            'create ticket',
            "ticket {$ticket->id} created successfully",
            "id: {$ticket->user_id} created a new ticket id: {$ticket->id}"
        );
    }

    /**
     * Handle the ticket "updated" event.
     */
    public function updated(ticket $ticket): void
    {
        if ($ticket->wasChanged('status')) {
        $this->logActivity(
            'update ticket',
            "ticket {$ticket->id} is now {$ticket->status}",
            "id: {$ticket->user_id} updated a ticket id: {$ticket->id}"
        );
        } else {
        $this->logActivity(
            'update ticket',
            "ticket {$ticket->id} updated successfully",
            "id: {$ticket->user_id} updated a ticket id: {$ticket->id}"
        );
        }
    }

    /**
     * Handle the ticket "deleted" event.
     */
    public function deleted(ticket $ticket): void
    {
        $this->logActivity(
            'delete ticket',
            "ticket {$ticket->id} deleted successfully",
            "id: {$ticket->user_id} deleted a ticket id: {$ticket->id}"
        );
    }

    /**
     * Handle the ticket "restored" event.
     */
    public function restored(ticket $ticket): void
    {
        //
    }

    /**
     * Handle the ticket "force deleted" event.
     */
    public function forceDeleted(ticket $ticket): void
    {
        //
    }
}
