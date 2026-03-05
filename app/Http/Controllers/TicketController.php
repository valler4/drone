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
        $tickets = request()->user()->tickets()->latest()->paginate(30);

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

        return redirect()->route('tickets.index')->with('success', 'ticket created successfully');
    }

    public function show(Ticket $ticket): View
    {
        $this->authorize('view', $ticket);
        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket): View
    {
        $this->authorize('update', $ticket);
        return view('tickets.edit', compact('ticket'));
    }

    public function update(TicketRequest $request, Ticket $ticket): RedirectResponse
    {
        if ($ticket->status === 'closed') {
            return redirect()->route('tickets.index')->with('error', 'Closed tickets cannot be updated');
        }
        $this->authorize('update', $ticket);
        $ticket->update($request->validated());

        return redirect()->route('tickets.index')->with('success', 'ticket updated successfully');
    }

    public function destroy(Request $request, Ticket $ticket): RedirectResponse
    {
        $this->authorize('view', $ticket);
        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'ticket deleted successfully');
    }

    public function close(Request $request, Ticket $ticket): RedirectResponse
    {
        $this->authorize('view', $ticket);
        $ticket->update(['status' => 'closed']);

        return redirect()->route('tickets.index')->with('success', 'ticket closed successfully');
    }

}
