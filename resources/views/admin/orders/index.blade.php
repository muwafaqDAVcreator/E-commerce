@extends('layouts.admin')

@section('header', 'Order Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-up">
    <h5 class="fw-bold m-0 text-secondary">Recent Orders</h5>
</div>

<div class="table-responsive" data-aos="fade-up" data-aos-delay="100">
    <table class="table admin-table">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Payment</th>
                <th>Shipping Status</th>
                <th>Date</th>
                <th class="text-end">Details</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td class="fw-bold text-primary">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td class="fw-semibold">{{ $order->user->name }}</td>
                    <td class="fw-bold">${{ number_format($order->total_amount, 2) }}</td>
                    <td>
                        <span class="badge {{ $order->payment_status === 'Paid' ? 'bg-success' : 'bg-warning text-dark' }} bg-opacity-10 border border-opacity-50 text-{{ $order->payment_status === 'Paid' ? 'success' : 'warning text-dark' }} border-{{ $order->payment_status === 'Paid' ? 'success' : 'warning' }} rounded-pill px-3">{{ $order->payment_status }}</span>
                    </td>
                    <td>
                        <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="m-0 p-0">
                            @csrf @method('PUT')
                            <select name="status" class="form-select form-select-sm bg-light border-0 fw-bold shadow-sm" style="width: 130px; border-radius: 8px;" onchange="this.form.submit()">
                                <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }} class="text-warning">Pending</option>
                                <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }} class="text-info">Processing</option>
                                <option value="Shipped" {{ $order->status == 'Shipped' ? 'selected' : '' }} class="text-primary">Shipped</option>
                                <option value="Delivered" {{ $order->status == 'Delivered' ? 'selected' : '' }} class="text-success">Delivered</option>
                                <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }} class="text-danger">Cancelled</option>
                            </select>
                        </form>
                    </td>
                    <td class="text-muted small fw-semibold">{{ $order->created_at->format('M d, Y h:i A') }}</td>
                    <td class="text-end">
                        <button type="button" class="btn btn-sm btn-light text-primary rounded-circle shadow-sm hover-scale" style="width: 35px; height: 35px; line-height: 22px;" data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="mt-4 d-flex justify-content-center">
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- Modals for Orders -->
@foreach($orders as $order)
<div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-light border-0 py-3 d-flex align-items-center">
                <h5 class="modal-title fw-bold text-dark m-0"><i class="fas fa-receipt text-primary me-2"></i>Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }} Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 bg-white">
                <div class="row g-4">
                    <div class="col-md-7 border-end pe-md-4">
                        <h6 class="fw-bold text-secondary mb-3 text-uppercase tracking-wider" style="font-size: 0.8rem;">Purchased Components</h6>
                        <ul class="list-group list-group-flush border rounded-3 overflow-hidden shadow-sm">
                            @foreach($order->items as $item)
                                <li class="list-group-item p-3 d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        @if($item->product && $item->product->image_path)
                                            <img src="{{ asset('storage/' . $item->product->image_path) }}" width="45" height="45" style="object-fit:cover;" class="rounded shadow-sm border me-3">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center me-3 text-muted border" style="width: 45px; height: 45px;"><i class="fas fa-microchip"></i></div>
                                        @endif
                                        <div>
                                            <a href="{{ $item->product ? route('product.show', $item->product) : '#' }}" target="_blank" class="fw-bold text-dark text-decoration-none hover-primary d-block">{{ $item->product ? \Illuminate\Support\Str::limit($item->product->name, 35) : 'Unknown Part' }}</a>
                                            <span class="badge bg-light text-secondary border mt-1">{{ $item->quantity }}x (${{ number_format($item->price, 2) }})</span>
                                        </div>
                                    </div>
                                    <span class="fw-bold text-primary">${{ number_format($item->price * $item->quantity, 2) }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <div class="d-flex justify-content-between mt-3 px-3">
                            <span class="fw-bold text-secondary">Total Paid</span>
                            <span class="fw-bold text-success fs-5">${{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <h6 class="fw-bold text-secondary mb-3 text-uppercase tracking-wider" style="font-size: 0.8rem;">Shipping Information</h6>
                        <div class="p-3 bg-light rounded-3 shadow-sm border mb-4">
                            <div class="mb-2"><i class="fas fa-user text-muted mx-2"></i><span class="fw-semibold">{{ $order->user->name }}</span></div>
                            <div class="mb-2"><i class="fas fa-envelope text-muted mx-2"></i><span class="text-muted small">{{ $order->user->email }}</span></div>
                            <div class="mt-3 pt-3 border-top position-relative">
                                <span class="position-absolute top-0 start-0 translate-middle text-muted bg-light px-1" style="font-size:0.7rem;">DELIVERY</span>
                                @if($order->user->shipping_address)
                                    <p class="m-0 text-secondary lh-sm" style="font-size: 0.9rem;">{{ $order->user->shipping_address }}</p>
                                @else
                                    <span class="badge bg-warning text-dark"><i class="fas fa-exclamation-triangle me-1"></i>No address on file</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 p-3 bg-light">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<style>
    .tracking-wider { letter-spacing: 1px; }
    .hover-primary:hover { color: var(--admin-primary) !important; }
</style>
@endsection
