@extends('layouts.admin')

@section('header', 'Add New Component')

@section('content')
<div class="row" data-aos="fade-up">
    <div class="col-lg-8">
        <div class="admin-card p-4 p-md-5">
            <h5 class="fw-bold mb-4 border-bottom pb-3"><i class="fas fa-microchip me-2 text-primary"></i>Component Details</h5>
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold text-secondary">Product Name</label>
                    <input type="text" name="name" class="form-control bg-light border-0 py-2" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold text-secondary">Description</label>
                    <textarea name="description" class="form-control bg-light border-0 py-2" rows="4" required></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-secondary">Price ($)</label>
                        <input type="number" name="price" step="0.01" class="form-control bg-light border-0 py-2" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-secondary">Stock Quantity</label>
                        <input type="number" name="stock_quantity" class="form-control bg-light border-0 py-2" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-secondary">Category</label>
                        <select name="category_id" class="form-select bg-light border-0 py-2" required>
                            @foreach(\App\Models\Category::all() as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-secondary">Brand</label>
                        <select name="brand_id" class="form-select bg-light border-0 py-2" required>
                            @foreach(\App\Models\Brand::all() as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold text-secondary">Product Image</label>
                    <input type="file" name="image" class="form-control bg-light border-0 py-2" accept="image/*">
                </div>
                <div class="d-flex gap-3">
                    <button type="submit" class="btn-admin py-2 px-4"><i class="fas fa-save me-2"></i> Save Product</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-light py-2 px-4 fw-bold">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
