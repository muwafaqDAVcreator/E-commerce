@extends('layouts.admin')

@section('header', 'Update Order Status')

@section('content')
<div class="row" data-aos="fade-up">
    <div class="col-lg-6">
        <div class="admin-card p-4 p-md-5">
            <h5 class="fw-bold mb-4 border-bottom pb-3"><i class="fas fa-shipping-fast me-2 text-primary"></i>Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h5>
            
            <div class="mb-4 bg-light p-3 rounded-3">
                <p class="mb-1"><span class="fw-bold text-secondary">Customer:</span> {{ $order->user->name }}</p>
                <p class="mb-1"><span class="fw-bold text-secondary">Total:</span> ${{ number_format($order->total_amount, 2) }}</p>
                <p class="mb-1"><span class="fw-bold text-secondary">Payment:</span> <span class="badge {{ $order->payment_status === 'Paid' ? 'bg-success' : 'bg-warning text-dark' }} rounded-pill">{{ $order->payment_status }}</span></p>
                <p class="mb-0"><span class="fw-bold text-secondary">Date:</span> {{ $order->created_at->format('M d, Y h:i A') }}</p>
            </div>

            <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="form-label fw-bold text-secondary">Shipping Status</label>
                    <select name="status" class="form-select bg-light border-0 py-2" required>
                        <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>Processing</option>
                        <option value="Shipped" {{ $order->status == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="Delivered" {{ $order->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="d-flex gap-3">
                    <button type="submit" class="btn-admin py-2 px-4"><i class="fas fa-save me-2"></i> Update Order</button>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-light py-2 px-4 fw-bold">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
