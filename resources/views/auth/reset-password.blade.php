@extends('layouts.auth')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-6 col-lg-5" data-aos="zoom-in" data-aos-duration="800">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background: rgba(255,255,255,0.9); backdrop-filter: blur(20px);">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-unlock-alt fa-2x"></i>
                    </div>
                    <h2 class="fw-bold text-dark">Reset Password</h2>
                    <p class="text-muted small">Choose a new, secure password below.</p>
                </div>

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control bg-light border-0 @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" value="{{ old('email', $request->email) }}" required autofocus>
                        <label for="email" class="text-muted"><i class="fas fa-envelope me-2"></i>Email address</label>
                        @error('email')
                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" name="password" class="form-control bg-light border-0 @error('password') is-invalid @enderror" id="password" placeholder="New Password" required>
                        <label for="password" class="text-muted"><i class="fas fa-lock me-2"></i>New Password</label>
                        @error('password')
                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-4">
                        <input type="password" name="password_confirmation" class="form-control bg-light border-0" id="password_confirmation" placeholder="Confirm Password" required>
                        <label for="password_confirmation" class="text-muted"><i class="fas fa-lock me-2"></i>Confirm Password</label>
                    </div>

                    <button type="submit" class="btn w-100 py-3 rounded-pill fw-bold shadow-sm mb-3 hover-scale transition-all" style="background: linear-gradient(45deg, var(--primary), var(--secondary)); color: white; border: none;">
                        Reset Password <i class="fas fa-check-circle ms-2"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
