@extends('layouts.admin')

@section('header', 'Manage User Permissions')

@section('content')
<div class="row" data-aos="fade-up">
    <div class="col-lg-6">
        <div class="admin-card p-4 p-md-5">
            <h5 class="fw-bold mb-4 border-bottom pb-3"><i class="fas fa-user-shield me-2 text-primary"></i>User: {{ $user->name }}</h5>
            
            <div class="mb-4 bg-light p-3 rounded-3">
                <p class="mb-1"><span class="fw-bold text-secondary">Email:</span> {{ $user->email }}</p>
                <p class="mb-0"><span class="fw-bold text-secondary">Joined:</span> {{ $user->created_at->format('M d, Y') }}</p>
            </div>

            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="form-label fw-bold text-secondary">Account Access Level</label>
                    <select name="role" class="form-select bg-light border-0 py-2" required>
                        <option value="Customer" {{ $user->role == 'Customer' ? 'selected' : '' }}>Customer (Default)</option>
                        <option value="Support" {{ $user->role == 'Support' ? 'selected' : '' }}>Support Agent</option>
                        <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>System Administrator</option>
                    </select>
                    <p class="text-muted small mt-2"><i class="fas fa-info-circle me-1"></i>Warning: Changing roles affects system access privileges.</p>
                </div>
                <div class="d-flex gap-3">
                    <button type="submit" class="btn-admin py-2 px-4"><i class="fas fa-save me-2"></i> Update Role</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light py-2 px-4 fw-bold">Back to Users</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
