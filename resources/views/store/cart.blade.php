@extends('layouts.store')

@section('styles')
<style>
    .cart-row {
        transition: all 0.3s ease;
        border-radius: 12px;
    }

    .cart-row:hover {
        background-color: white;
        transform: scale(1.01);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .qty-input {
        text-align: center;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    .qty-input:focus {
        box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.25);
        border-color: var(--primary);
    }

    .btn-icon {
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .btn-icon:hover {
        transform: translateY(-2px);
    }
</style>
@endsection

@section('content')
<div class="mb-5 text-center" data-aos="fade-down">
    <h1 class="fw-bold display-5 m-0 position-relative d-inline-block">
        Checkout Cart
        <div class="position-absolute w-50 h-100 rounded-pill" style="background: var(--primary); z-index:-1; opacity:0.1; top: 10%; left:25%;"></div>
    </h1>
    <p class="text-muted mt-2 fs-5">Review your parts before securing your build.</p>
</div>

@if(count($cart) > 0)
<div class="row g-4">
    <div class="col-lg-8" data-aos="fade-right" data-aos-delay="100">
        <div class="card shadow-sm border-0 bg-transparent">
            <div class="card-body p-0">
                <div class="d-flex flex-column gap-3">
                    @foreach($cart as $id => $details)
                    <div class="cart-row p-3 bg-light border">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-5 d-flex align-items-center mb-3 mb-md-0">
                                @if($details['image_path'])
                                <img src="{{ asset('storage/' . $details['image_path']) }}" class="rounded shadow-sm me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                @else
                                <div class="bg-white rounded shadow-sm d-flex align-items-center justify-content-center me-3" style="width: 80px; height: 80px;">
                                    <i class="fas fa-microchip fa-2x text-muted opacity-50"></i>
                                </div>
                                @endif
                                <div>
                                    <h5 class="fw-bold mb-1 text-dark">{{ $details['name'] }}</h5>
                                    <span class="text-primary fw-bold">${{ number_format($details['price'], 2) }}</span>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex align-items-center bg-white p-1 rounded-pill shadow-sm d-inline-flex">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="quantity" value="{{ $details['quantity'] }}" class="form-control form-control-sm border-0 qty-input fw-bold bg-transparent" min="1" style="width: 50px;">
                                    <button type="submit" class="btn btn-sm btn-light rounded-circle ms-1"><i class="fas fa-check text-success"></i></button>
                                </form>
                            </div>
                            <div class="col-6 col-md-4 d-flex justify-content-end align-items-center">
                                <div class="fw-bold fs-5 me-4">${{ number_format($details['price'] * $details['quantity'], 2) }}</div>
                                <form action="{{ route('cart.destroy', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-outline-danger bg-white shadow-sm border-0"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4" data-aos="fade-left" data-aos-delay="200">
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden position-relative">
            <div class="position-absolute top-0 start-0 w-100 h-100 bg-white" style="z-index:-2;"></div>
            <div class="position-absolute top-0 end-0 w-50 h-50 rounded-circle" style="background: radial-gradient(circle, rgba(99,102,241,0.1) 0%, transparent 70%); z-index:-1; transform: translate(30%, -30%);"></div>

            <div class="card-body p-4 p-xl-5">
                <h4 class="card-title fw-bold mb-4 d-flex align-items-center"><i class="fas fa-receipt text-primary me-2"></i>Summary</h4>

                <div class="d-flex justify-content-between mb-3 fs-5">
                    <span class="text-secondary fw-semibold">Subtotal</span>
                    <span class="fw-bold">${{ number_format($total, 2) }}</span>
                </div>

                <div class="d-flex justify-content-between mb-4 pb-4 border-bottom text-secondary">
                    <span>Shipping Estimate</span>
                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-2">Free Delivery</span>
                </div>

                <div class="d-flex justify-content-between fw-bold mb-5" style="font-size: 1.8rem;">
                    <span>Total</span>
                    <span class="text-primary">${{ number_format($total, 2) }}</span>
                </div>

                @if(Auth::check())
                <a href="{{ route('checkout.index') }}" class="btn btn-gradient w-100 py-3 rounded-pill fw-bold fs-5 shadow position-relative z-index-1 overflow-hidden" style="transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                    Secure Checkout <i class="fas fa-arrow-right ms-2"></i>
                </a>
                @else
                <div class="alert alert-warning border-0 shadow-sm rounded-3">
                    <i class="fas fa-lock me-2"></i> You must <a href="{{ route('login') }}" class="fw-bold text-dark text-decoration-underline">Log In</a> to checkout.
                </div>
                @endif
                <div class="text-center mt-3">
                    <a href="{{ route('home') }}" class="btn btn-link text-decoration-none text-muted fw-semibold hover-primary transition-all"><i class="fas fa-arrow-left me-1"></i> Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="d-flex justify-content-center" data-aos="zoom-in" data-aos-delay="100">
    <div class="text-center p-5 shadow-sm border-0 bg-white rounded-4" style="max-width: 500px; width: 100%;">
        <div class="position-relative d-inline-block mb-4">
            <i class="fas fa-shopping-basket fa-5x text-primary opacity-25"></i>
            <i class="fas fa-times position-absolute bottom-0 end-0 text-danger fs-3 bg-white rounded-circle p-1 shadow-sm"></i>
        </div>
        <h3 class="fw-bold">Your cart is empty</h3>
        <p class="text-muted fs-5 mb-4">Add some premium hardware to get started.</p>
        <a href="{{ route('home') }}" class="btn btn-gradient px-5 py-3 rounded-pill fw-bold shadow"><i class="fas fa-search me-2"></i>Browse Catalog</a>
    </div>
</div>
@endif
@endsection