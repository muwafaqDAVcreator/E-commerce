@extends('layouts.auth')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-6 col-lg-5" data-aos="zoom-in" data-aos-duration="800">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background: rgba(255,255,255,0.9); backdrop-filter: blur(20px);">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-key fa-2x"></i>
                    </div>
                    <h2 class="fw-bold text-dark">Forgot Password?</h2>
                    <p class="text-muted small">No problem. Just let us know your email address and we will email you a password reset link.</p>
                </div>

                @if (session('status'))
                    <div class="alert alert-success border-0 shadow-sm rounded-3 small fw-bold">
                        {{ session('status') }}
                    </div>
                @endif
                
                @if (session('test_link'))
                    <div class="alert alert-warning border-0 shadow-sm rounded-3 small mb-4 text-center">
                        <p class="mb-2 fw-bold text-dark">Testing Override Link Generated:</p>
                        <a href="{{ session('test_link') }}" class="btn btn-warning btn-sm rounded-pill fw-bold" target="_blank">
                            <i class="fas fa-external-link-alt me-1"></i> Open Password Reset
                        </a>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-floating mb-4">
                        <input type="email" name="email" class="form-control bg-light border-0 @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" value="{{ old('email') }}" required autofocus>
                        <label for="email" class="text-muted"><i class="fas fa-envelope me-2"></i>Email address</label>
                        @error('email')
                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn w-100 py-3 rounded-pill fw-bold shadow-sm mb-3 hover-scale transition-all" style="background: linear-gradient(45deg, var(--primary), var(--secondary)); color: white; border: none;">
                        Email Password Reset Link <i class="fas fa-paper-plane ms-2"></i>
                    </button>
                    
                    <p class="text-center text-muted small mb-0">
                        Remember your password? <a href="{{ route('login') }}" class="fw-bold text-decoration-none text-secondary">Back to login</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
