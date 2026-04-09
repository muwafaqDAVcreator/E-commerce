@extends('layouts.admin')

@section('header', 'Edit Component')

@section('content')
<div class="row" data-aos="fade-up">
    <div class="col-lg-8">
        <div class="admin-card p-4 p-md-5">
            <h5 class="fw-bold mb-4 border-bottom pb-3"><i class="fas fa-edit me-2 text-primary"></i>Component Details</h5>
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label fw-bold text-secondary">Product Name</label>
                    <input type="text" name="name" class="form-control bg-light border-0 py-2" required value="{{ $product->name }}">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold text-secondary">Description</label>
                    <textarea name="description" class="form-control bg-light border-0 py-2" rows="4" required>{{ $product->description }}</textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-secondary">Price ($)</label>
                        <input type="number" name="price" step="0.01" class="form-control bg-light border-0 py-2" required value="{{ $product->price }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-secondary">Stock Quantity</label>
                        <input type="number" name="stock_quantity" class="form-control bg-light border-0 py-2" required value="{{ $product->stock_quantity }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-secondary">Category</label>
                        <select name="category_id" class="form-select bg-light border-0 py-2" required>
                            @foreach(\App\Models\Category::all() as $cat)
                                <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-secondary">Brand</label>
                        <select name="brand_id" class="form-select bg-light border-0 py-2" required>
                            @foreach(\App\Models\Brand::all() as $brand)
                                <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold text-secondary">Update Image (Optional)</label>
                    <input type="file" name="image" class="form-control bg-light border-0 py-2" accept="image/*">
                    @if($product->image_path)
                        <div class="mt-3 p-2 bg-light rounded d-inline-block">
                            <img src="{{ asset('storage/' . $product->image_path) }}" height="60" class="rounded shadow-sm">
                        </div>
                    @endif
                </div>
                <div class="d-flex gap-3">
                    <button type="submit" class="btn-admin py-2 px-4"><i class="fas fa-save me-2"></i> Update Product</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-light py-2 px-4 fw-bold">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
