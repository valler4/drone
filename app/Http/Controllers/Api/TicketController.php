<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketRequest;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TicketController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request, Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        $tickets = request()->user()->tickets()->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Tickets retrieved successfully',
            'tickets' => $tickets
        ]);
    }

    public function store(TicketRequest $request)
    {

        $ticketData = $request->validated();
        $ticket = $request->user()->tickets()->create($ticketData);

        return response()->json([
            'success' => true,
            'message' => 'Ticket created successfully',
            'ticket' => $ticket
        ]);
    }

    public function show(Request $request, Ticket $ticket)
    {
        $this->authorize('view', $ticket);
        return response()->json([
            'success' => true,
            'message' => 'Ticket retrieved successfully',
            'ticket' => $ticket
        ]);
    }

    public function update(TicketRequest $request, Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        $ticket->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Ticket updated successfully',
            'ticket' => $ticket
        ]);
    }

    public function destroy(Request $request, Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        $ticket->delete();

        return response()->json([
            'success' => true,
            'message' => 'Ticket deleted successfully'
        ]);
    }

    public function close(Request $request, Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        $ticket->update(['status' => 'closed']);

        return response()->json([
            'success' => true,
            'message' => 'Ticket closed successfully'
        ]);
    }
}
