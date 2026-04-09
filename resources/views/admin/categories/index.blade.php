@extends('layouts.admin')

@section('header', 'Categories')

@section('content')
<div class="row g-4" data-aos="fade-up">
    <div class="col-lg-4">
        <div class="admin-card p-4">
            <h5 class="fw-bold mb-4 border-bottom pb-3"><i class="fas fa-plus text-primary me-2"></i>New Category</h5>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold text-secondary">Name</label>
                    <input type="text" name="name" class="form-control bg-light border-0 py-2" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold text-secondary">Description</label>
                    <textarea name="description" class="form-control bg-light border-0 py-2" rows="3"></textarea>
                </div>
                <button type="submit" class="btn-admin w-100 py-2">Add Category</button>
            </form>
        </div>
    </div>
    
    <div class="col-lg-8">
        <div class="admin-card">
            @if(session('error'))
                <div class="alert alert-danger mx-3 mt-3 mb-0 border-0 rounded-3 shadow-sm">{{ session('error') }}</div>
            @endif
            <div class="table-responsive p-3">
                <table class="table admin-table mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $cat)
                            <tr>
                                <td class="fw-bold text-primary">#{{ str_pad($cat->id, 3, '0', STR_PAD_LEFT) }}</td>
                                <td class="fw-bold">{{ $cat->name }}</td>
                                <td class="text-muted small">{{ \Illuminate\Support\Str::limit($cat->description, 50) }}</td>
                                <td class="text-end">
                                    <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-light text-danger rounded-circle shadow-sm hover-scale" style="width: 35px; height: 35px; line-height: 22px;" onclick="return confirm('Delete this category?')"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
