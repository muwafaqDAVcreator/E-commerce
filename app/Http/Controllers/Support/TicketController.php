<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('support.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        $ticket->load('user');
        return view('support.tickets.show', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'status' => 'required|in:Open,Closed',
        ]);

        $ticket->update($validated);
        return redirect()->route('support.tickets.show', $ticket)->with('success', 'Ticket status updated.');
    }
}
