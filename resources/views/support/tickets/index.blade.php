@extends('layouts.support')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Help Desk Tickets</h2>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Ticket ID</th>
                        <th>User</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tickets as $ticket)
                        <tr>
                            <td>#{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $ticket->user->name }}</td>
                            <td>{{ $ticket->subject }}</td>
                            <td>
                                <span class="badge {{ $ticket->status === 'Open' ? 'bg-danger' : 'bg-success' }}">
                                    {{ $ticket->status }}
                                </span>
                            </td>
                            <td>{{ $ticket->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('support.tickets.show', $ticket) }}" class="btn btn-sm btn-outline-primary">View / Respond</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No tickets found. Good job!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-3">
            {{ $tickets->links() }}
        </div>
    </div>
</div>
@endsection
