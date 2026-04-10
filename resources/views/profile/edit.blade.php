@extends('layouts.store')

@section('styles')
<style>
    .profile-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 20px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
        padding: 2.5rem;
    }
</style>
@endsection

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-lg-8" data-aos="fade-up">
        <h2 class="fw-bold mb-4">Account Settings</h2>

        <!-- Profile Information -->
        <div class="profile-card">
            <h4 class="fw-bold mb-3">Profile Information</h4>
            <p class="text-secondary mb-4">Update your account's profile information, email address, and shipping address.</p>

            <form method="post" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                <div class="mb-3">
                    <label for="name" class="form-label fw-bold small text-secondary text-uppercase tracking-wider">Name</label>
                    <input type="text" class="form-control bg-light border-0 shadow-sm rounded-3 py-2" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name') <div class="text-danger small mt-1 fw-semibold">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-bold small text-secondary text-uppercase tracking-wider">Email Address</label>
                    <input type="email" class="form-control bg-light border-0 shadow-sm rounded-3 py-2" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email') <div class="text-danger small mt-1 fw-semibold">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label for="shipping_address" class="form-label fw-bold small text-secondary text-uppercase tracking-wider">Default Shipping Address</label>
                    <textarea class="form-control bg-light border-0 shadow-sm rounded-3 py-2" id="shipping_address" name="shipping_address" rows="3">{{ old('shipping_address', $user->shipping_address) }}</textarea>
                    @error('shipping_address') <div class="text-danger small mt-1 fw-semibold">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex align-items-center gap-3">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">Save Changes</button>
                    @if (session('status') === 'profile-updated')
                        <span class="text-success small fw-bold"><i class="fas fa-check-circle me-1"></i> Successfully Saved.</span>
                    @endif
                </div>
            </form>
        </div>

        <!-- Update Password -->
        <div class="profile-card">
            <h4 class="fw-bold mb-3">Update Security</h4>
            <p class="text-secondary mb-4">Ensure your account is using a long, random password to stay secure.</p>

            <form method="post" action="{{ route('password.update') }}">
                @csrf
                @method('put')

                <div class="mb-3">
                    <label for="current_password" class="form-label fw-bold small text-secondary text-uppercase tracking-wider">Current Password</label>
                    <input type="password" class="form-control bg-light border-0 shadow-sm rounded-3 py-2" id="current_password" name="current_password" autocomplete="current-password">
                    @error('current_password', 'updatePassword') <div class="text-danger small mt-1 fw-semibold">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-bold small text-secondary text-uppercase tracking-wider">New Password</label>
                    <input type="password" class="form-control bg-light border-0 shadow-sm rounded-3 py-2" id="password" name="password" autocomplete="new-password">
                    @error('password', 'updatePassword') <div class="text-danger small mt-1 fw-semibold">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-bold small text-secondary text-uppercase tracking-wider">Confirm New Password</label>
                    <input type="password" class="form-control bg-light border-0 shadow-sm rounded-3 py-2" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
                    @error('password_confirmation', 'updatePassword') <div class="text-danger small mt-1 fw-semibold">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex align-items-center gap-3">
                    <button type="submit" class="btn btn-dark rounded-pill px-4 fw-bold shadow-sm">Update Password</button>
                    @if (session('status') === 'password-updated')
                        <span class="text-success small fw-bold"><i class="fas fa-check-circle me-1"></i> Password Updated.</span>
                    @endif
                </div>
            </form>
        </div>

        <!-- Delete Account -->
        <div class="profile-card border-danger border-opacity-25" style="background: rgba(254, 242, 242, 0.5);">
            <h4 class="fw-bold text-danger mb-3">Delete Account</h4>
            <p class="text-secondary mb-4 text-dark opacity-75">Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</p>

            <button type="button" class="btn btn-outline-danger rounded-pill px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                <i class="fas fa-trash-alt me-2"></i>Delete Account
            </button>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                
                <div class="modal-header bg-danger text-white border-0 py-3">
                    <h5 class="modal-title fw-bold">Confirm Account Deletion</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-secondary fw-semibold mb-4">Please enter your password to confirm you would like to permanently delete your account. This action cannot be undone.</p>
                    
                    <div class="mb-3">
                        <label for="delete_password" class="form-label fw-bold small text-secondary text-uppercase tracking-wider">Account Password</label>
                        <input type="password" class="form-control bg-light border-0 shadow-sm rounded-3 py-2" id="delete_password" name="password" required>
                        @error('password', 'userDeletion') <div class="text-danger small mt-1 fw-semibold">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold shadow-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold shadow-sm">Permanently Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- If there are deletion errors, open the modal automatically -->
@if($errors->userDeletion->isNotEmpty())
@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var myModal = new bootstrap.Modal(document.getElementById('deleteAccountModal'));
        myModal.show();
    });
</script>
@endsection
@endif

@endsection
