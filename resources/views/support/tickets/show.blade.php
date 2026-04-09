@extends('layouts.support')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Ticket #{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}</h2>
    <a href="{{ route('support.tickets.index') }}" class="btn btn-secondary">Back to Tickets</a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ $ticket->subject }}</h4>
                <h6 class="card-subtitle mb-2 text-muted">From: {{ $ticket->user->name }} &middot; {{ $ticket->created_at->diffForHumans() }}</h6>
                <hr>
                <div class="ticket-message p-3 bg-light rounded border">
                    {!! nl2br(e($ticket->message)) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-white"><strong>Update Status</strong></div>
            <div class="card-body">
                <form action="{{ route('support.tickets.update', $ticket) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Ticket Status</label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="Open" {{ $ticket->status === 'Open' ? 'selected' : '' }}>Open</option>
                            <option value="Closed" {{ $ticket->status === 'Closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Update Ticket</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
