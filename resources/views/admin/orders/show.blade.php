@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }} Details</h2>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back to Orders</a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-white"><strong>Order Items</strong></div>
            <div class="card-body p-0">
                <table class="table table-borderless mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product ? $item->product->name : 'Product Deleted' }}</td>
                            <td>${{ number_format($item->price_at_purchase, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td class="text-end">${{ number_format($item->price_at_purchase * $item->quantity, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="border-top">
                        <tr>
                            <th colspan="3" class="text-end">Total Amount:</th>
                            <th class="text-end">${{ number_format($order->total_amount, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-white"><strong>Customer Information</strong></div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $order->user->name }}</p>
                <p><strong>Email:</strong> {{ $order->user->email }}</p>
                <p><strong>Shipping Address:</strong><br> {!! nl2br(e($order->user->shipping_address ?? 'Not provided')) !!}</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-white"><strong>Update Order Status</strong></div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Order Status</label>
                        <select name="status" id="status" class="form-select text-dark" required>
                            <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>Processing</option>
                            <option value="Shipped" {{ $order->status == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="Delivered" {{ $order->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="tracking_number" class="form-label">Tracking Number</label>
                        <input type="text" name="tracking_number" id="tracking_number" class="form-control" value="{{ old('tracking_number', $order->tracking_number) }}" placeholder="e.g. 1Z9999999999999999">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Update Order</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
