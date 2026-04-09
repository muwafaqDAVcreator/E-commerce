@extends('layouts.admin')

@section('header', 'Inventory Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-up">
    <h5 class="fw-bold m-0 text-secondary">All Components</h5>
    <a href="{{ route('admin.products.create') }}" class="btn-admin shadow-sm"><i class="fas fa-plus me-2"></i> Add Product</a>
</div>

<div class="table-responsive" data-aos="fade-up" data-aos-delay="100">
    <table class="table admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td class="fw-bold text-muted">#{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>
                        @if($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" class="rounded shadow-sm" style="width: 45px; height: 45px; object-fit: cover;">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 45px; height: 45px;"><i class="fas fa-microchip"></i></div>
                        @endif
                    </td>
                    <td class="fw-bold">{{ $product->name }}</td>
                    <td><span class="badge bg-light text-primary border px-2 py-1">{{ $product->category ? $product->category->name : 'N/A' }}</span></td>
                    <td class="fw-bold text-success">${{ number_format($product->price, 2) }}</td>
                    <td>
                        @if($product->stock_quantity > 0)
                            <span class="text-success small fw-bold"><i class="fas fa-circle me-1" style="font-size:8px;"></i>{{ $product->stock_quantity }} Avail</span>
                        @else
                            <span class="text-danger small fw-bold"><i class="fas fa-circle me-1" style="font-size:8px;"></i>Out of Stock</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-light text-primary me-2 rounded-circle shadow-sm hover-scale" style="width: 35px; height: 35px; line-height: 22px;"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-light text-danger rounded-circle shadow-sm hover-scale" style="width: 35px; height: 35px; line-height: 22px;" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="mt-4 d-flex justify-content-center">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
