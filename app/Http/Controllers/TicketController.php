<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Models\ticket as Ticket;
use App\Traits\Logs;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    use Logs, AuthorizesRequests;

    public function index(): View
    {
        $tickets = request()->user()->tickets()->latest()->paginate(10);

        return view('tickets.index', compact('tickets'));
    }

    public function create(): View
    {
        return view('tickets.create');
    }

    public function store(TicketRequest $request): RedirectResponse
    {
        $ticketdata = $request->validated();
        $ticket = $request->user()->tickets()->create($ticketdata);
        $this->logActivity('create ticket', "id: {$request->user()->id} created a new ticket id: {$ticket->id}");

        return redirect()->route('tickets.index')->with('success', 'ticket created successfully');
    }

    public function show(Ticket $ticket): View
    {
        $this->authorize('view', $ticket);

        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket): View
    {
        $this->authorize('view', $ticket);

        return view('tickets.edit', compact('ticket'));
    }

    public function update(TicketRequest $request, Ticket $ticket): RedirectResponse
    {
        $this->authorize('view', $ticket);
        $ticket->update($request->validated());
        $this->logActivity('update ticket', "id: {$request->user()->id} updated a ticket id: {$ticket->id}");

        return redirect()->route('tickets.index')->with('success', 'ticket updated successfully');
    }

    public function destroy(Request $request, Ticket $ticket): RedirectResponse
    {
        $this->authorize('view', $ticket);
        $ticket->delete();
        $this->logActivity('delete ticket', "id: {$request->user()->id} deleted a ticket id: {$ticket->id}");

        return redirect()->route('tickets.index')->with('success', 'ticket deleted successfully');
    }

    public function close(Request $request, Ticket $ticket): RedirectResponse
    {
        $this->authorize('view', $ticket);
        $ticket->update(['status' => 'closed']);
        $this->logActivity('delete ticket', "id: {$request->user()->id} deleted a ticket id: {$ticket->id}");

        return redirect()->route('tickets.index')->with('success', 'ticket deleted successfully');
    }

}
