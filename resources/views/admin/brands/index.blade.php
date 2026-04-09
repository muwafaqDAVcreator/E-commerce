@extends('layouts.admin')

@section('header', 'Brands')

@section('content')
<div class="row g-4" data-aos="fade-up">
    <div class="col-lg-4">
        <div class="admin-card p-4">
            <h5 class="fw-bold mb-4 border-bottom pb-3"><i class="fas fa-plus text-primary me-2"></i>New Brand</h5>
            <form action="{{ route('admin.brands.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold text-secondary">Brand Name</label>
                    <input type="text" name="name" class="form-control bg-light border-0 py-2" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold text-secondary">Description</label>
                    <textarea name="description" class="form-control bg-light border-0 py-2" rows="3"></textarea>
                </div>
                <button type="submit" class="btn-admin w-100 py-2">Add Brand</button>
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
                            <th>Brand</th>
                            <th>Description</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($brands as $brand)
                            <tr>
                                <td class="fw-bold text-primary">#{{ str_pad($brand->id, 3, '0', STR_PAD_LEFT) }}</td>
                                <td class="fw-bold">{{ $brand->name }}</td>
                                <td class="text-muted small">{{ \Illuminate\Support\Str::limit($brand->description, 50) }}</td>
                                <td class="text-end">
                                    <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-light text-danger rounded-circle shadow-sm hover-scale" style="width: 35px; height: 35px; line-height: 22px;" onclick="return confirm('Delete this brand?')"><i class="fas fa-trash"></i></button>
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
