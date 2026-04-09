@extends('layouts.store')

@section('content')
<div class="row w-100 m-0">
    <div class="col-12 mb-4">
        <h2 class="fw-bold"><i class="fas fa-lock text-success me-2"></i>Secure Checkout</h2>
    </div>

    <div class="col-md-7">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white fw-bold py-3 fs-5">Shipping Details</div>
            <div class="card-body">
                <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label text-muted">Full Name</label>
                        <input type="text" class="form-control bg-light" value="{{ Auth::user()->name }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted">Email Address</label>
                        <input type="email" class="form-control bg-light" value="{{ Auth::user()->email }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="shipping_address" class="form-label fw-semibold">Shipping Address</label>
                        <textarea name="shipping_address" id="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror" rows="4" required placeholder="123 Example St, City, State, ZIP...">{{ old('shipping_address', Auth::user()->shipping_address) }}</textarea>
                        @error('shipping_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <p class="form-text mt-2"><i class="fas fa-info-circle me-1"></i>Updating this will also update the default address on your profile.</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Payment Method</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment_method" id="pay_stripe" value="stripe" checked>
                            <label class="form-check-label" for="pay_stripe">
                                <i class="fab fa-stripe text-primary me-1"></i> Secure Card Payment (Stripe)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="pay_cod" value="cod">
                            <label class="form-check-label" for="pay_cod">
                                <i class="fas fa-truck text-success me-1"></i> Cash on Delivery (COD)
                            </label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card shadow-sm border-0 mb-4 bg-light">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-3 border-bottom pb-2">Order Summary</h5>
                
                <div class="mb-4" style="max-height: 250px; overflow-y: auto;">
                    @foreach($cart as $id => $item)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h6 class="mb-0 text-dark">{{ $item['name'] }}</h6>
                                <small class="text-muted">Qty: {{ $item['quantity'] }}</small>
                            </div>
                            <span class="fw-semibold">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="border-top pt-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 text-muted border-bottom pb-3">
                        <span>Shipping/Taxes</span>
                        <span>Free</span>
                    </div>
                    <div class="d-flex justify-content-between fw-bold fs-4 mb-4 text-primary">
                        <span>Total Due</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                    
                    <button type="submit" form="checkout-form" class="btn btn-primary btn-gradient w-100 py-3 fw-bold fs-5 shadow-sm rounded-pill hover-scale">
                        <i class="fas fa-lock me-2"></i>Complete Order
                    </button>
                    
                    <p class="text-center text-muted small mt-3 mb-0">
                        <i class="fas fa-shield-alt me-1"></i>Payments are processed securely.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
