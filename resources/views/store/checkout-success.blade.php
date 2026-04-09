@extends('layouts.store')

@section('content')
<div class="row justify-content-center pt-5">
    <div class="col-md-8 text-center">
        <div class="card shadow-sm border-0 py-5">
            <div class="card-body">
                <div class="mb-4">
                    <i class="fas fa-check-circle text-success" style="font-size: 80px;"></i>
                </div>
                <h2 class="fw-bold mb-3">Thank you for your order!</h2>
                <p class="text-muted fs-5 mb-4">Your payment of <strong>${{ number_format($order->total_amount, 2) }}</strong> was successfully processed.</p>
                
                <div class="bg-light p-4 rounded text-start mb-4 mx-auto" style="max-width: 400px;">
                    <p class="mb-1"><span class="text-muted">Order ID:</span> <span class="fw-bold float-end">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span></p>
                    <p class="mb-1"><span class="text-muted">Date:</span> <span class="fw-bold float-end">{{ $order->created_at->format('M d, Y h:i A') }}</span></p>
                    <p class="mb-1"><span class="text-muted">Status:</span> <span class="badge bg-warning text-dark float-end">Pending Shipment</span></p>
                </div>

                <div>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary px-4 py-2 me-2">View Order Dashboard</a>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary px-4 py-2">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
