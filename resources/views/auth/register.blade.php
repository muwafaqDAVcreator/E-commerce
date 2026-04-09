@extends('layouts.auth')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-7 col-lg-6" data-aos="fade-up" data-aos-duration="1000">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background: rgba(255,255,255,0.9); backdrop-filter: blur(20px);">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-user-plus fa-2x"></i>
                    </div>
                    <h2 class="fw-bold text-dark">Join TechParts</h2>
                    <p class="text-muted">Create an account to track orders and save your favorites.</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="form-floating mb-3">
                        <input type="text" name="name" class="form-control bg-light border-0 @error('name') is-invalid @enderror" id="name" placeholder="John Doe" value="{{ old('name') }}" required autofocus>
                        <label for="name" class="text-muted"><i class="fas fa-user me-2"></i>Full Name</label>
                        @error('name')
                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control bg-light border-0 @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" value="{{ old('email') }}" required>
                        <label for="email" class="text-muted"><i class="fas fa-envelope me-2"></i>Email address</label>
                        @error('email')
                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-4">
                        <!-- Password -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="password" name="password" class="form-control bg-light border-0 @error('password') is-invalid @enderror" id="password" placeholder="Password" required>
                                <label for="password" class="text-muted"><i class="fas fa-lock me-2"></i>Password</label>
                                @error('password')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="password" name="password_confirmation" class="form-control bg-light border-0 @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="Confirm Password" required>
                                <label for="password_confirmation" class="text-muted"><i class="fas fa-check-circle me-2"></i>Confirm Password</label>
                                @error('password_confirmation')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn w-100 py-3 rounded-pill fw-bold shadow-sm mb-3 hover-scale transition-all" style="background: linear-gradient(45deg, var(--secondary), var(--primary)); color: white; border: none;">
                        Create Account <i class="fas fa-user-check ms-2"></i>
                    </button>
                    
                    <p class="text-center text-muted small mb-0">
                        Already have an account? <a href="{{ route('login') }}" class="fw-bold text-decoration-none text-primary">Log in here</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
