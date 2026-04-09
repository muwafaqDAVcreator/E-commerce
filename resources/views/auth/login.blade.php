@extends('layouts.auth')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-6 col-lg-5" data-aos="zoom-in" data-aos-duration="800">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background: rgba(255,255,255,0.9); backdrop-filter: blur(20px);">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-user-lock fa-2x"></i>
                    </div>
                    <h2 class="fw-bold text-dark">Welcome Back</h2>
                    <p class="text-muted">Enter your credentials to access your account.</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success border-0 shadow-sm rounded-3">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control bg-light border-0 @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" value="{{ old('email') }}" required autofocus>
                        <label for="email" class="text-muted"><i class="fas fa-envelope me-2"></i>Email address</label>
                        @error('email')
                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-floating mb-3">
                        <input type="password" name="password" class="form-control bg-light border-0 @error('password') is-invalid @enderror" id="password" placeholder="Password" required>
                        <label for="password" class="text-muted"><i class="fas fa-lock me-2"></i>Password</label>
                        @error('password')
                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input shadow-none" type="checkbox" name="remember" id="remember_me">
                            <label class="form-check-label text-muted small" for="remember_me">
                                Remember me
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="small text-decoration-none fw-semibold text-primary">Forgot password?</a>
                        @endif
                    </div>

                    <button type="submit" class="btn w-100 py-3 rounded-pill fw-bold shadow-sm mb-3 hover-scale transition-all" style="background: linear-gradient(45deg, var(--primary), var(--secondary)); color: white; border: none;">
                        Sign In <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                    
                    <p class="text-center text-muted small mb-0">
                        Don't have an account? <a href="{{ route('register') }}" class="fw-bold text-decoration-none text-secondary">Create one now</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
