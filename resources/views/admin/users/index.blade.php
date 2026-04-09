@extends('layouts.admin')

@section('header', 'User Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-up">
    <h5 class="fw-bold m-0 text-secondary">Platform Users</h5>
</div>

<div class="table-responsive" data-aos="fade-up" data-aos-delay="100">
    <table class="table admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Joined</th>
                <th class="text-end">Update Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td class="fw-bold text-muted">#{{ $user->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 40px; height: 40px;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span class="fw-semibold">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="text-secondary fw-semibold">{{ $user->email }}</td>
                    <td>
                        @php
                            $roleBadge = match($user->role) {
                                'Admin' => 'bg-danger text-white border border-danger',
                                'Support' => 'bg-info bg-opacity-25 text-info border border-info border-opacity-50',
                                default => 'bg-light text-secondary border'
                            };
                        @endphp
                        <span class="badge {{ $roleBadge }} rounded-pill px-3 py-2">{{ $user->role }}</span>
                    </td>
                    <td class="text-muted small"><i class="far fa-calendar-alt me-1"></i>{{ $user->created_at->format('M d, Y') }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-light text-primary rounded-circle shadow-sm" style="width: 35px; height: 35px; line-height: 22px;"><i class="fas fa-user-edit"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="mt-4 d-flex justify-content-center">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
