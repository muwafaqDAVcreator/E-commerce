@extends('layouts.store')

@section('styles')
<style>
    /* Catalog Specific Animations */
    .filter-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .filter-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
    }

    .product-card {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        border-radius: 16px;
        background: white;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .product-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 40px rgba(99, 102, 241, 0.15);
    }

    .product-img-wrapper {
        overflow: hidden;
        position: relative;
    }

    .product-img {
        height: 220px;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .product-card:hover .product-img {
        transform: scale(1.1) rotate(1deg);
    }

    .product-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.5), transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: flex-end;
        padding: 1rem;
    }

    .product-card:hover .product-overlay {
        opacity: 1;
    }

    .price-tag {
        font-size: 1.5rem;
        font-weight: 800;
        background: linear-gradient(45deg, var(--primary), var(--secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .btn-add {
        border-radius: 12px;
        transition: all 0.3s ease;
        background: var(--dark);
        border: none;
    }

    .btn-add:hover {
        background: var(--primary);
        transform: scale(1.05);
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<div class="row align-items-center mb-5" data-aos="fade-in">
    <div class="col-12 bg-white rounded-4 p-5 shadow-sm position-relative overflow-hidden" style="min-height: 250px;">
        <div class="position-absolute top-0 end-0 opacity-10" style="transform: translate(20%, -20%) rotate(15deg);">
            <i class="fas fa-microchip" style="font-size: 300px;"></i>
        </div>
        <div class="position-relative z-index-1">
            <h1 class="display-4 fw-bold mb-3" style="background: linear-gradient(45deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Build Your Dream Rig</h1>
            <p class="fs-5 text-secondary mb-0 w-75">Discover premium components, meticulously categorized for developers, gamers, and enthusiasts.</p>
        </div>
    </div>
</div>

<div class="row">
    <!-- Filters Sidebar -->
    <aside class="col-lg-3 mb-4" data-aos="fade-right" data-aos-delay="100">
        <div class="filter-card p-4 position-sticky" style="top: 100px;">
            <h5 class="fw-bold mb-4 d-flex align-items-center"><i class="fas fa-sliders-h me-2 text-primary"></i>Refine Search</h5>
            <form action="{{ route('home') }}" method="GET">

                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary small text-uppercase tracking-wider">Keywords</label>
                    <div class="input-group border rounded-3 overflow-hidden shadow-sm">
                        <input type="text" name="search" class="form-control border-0 shadow-none bg-light" placeholder="e.g. RTX 4090..." value="{{ request('search') }}">
                        <button class="btn btn-light border-0 bg-light text-primary" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary small text-uppercase tracking-wider">Category</label>
                    <select name="category" class="form-select border-0 bg-light shadow-sm rounded-3" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary small text-uppercase tracking-wider">Manufacturer</label>
                    <select name="brand" class="form-select border-0 bg-light shadow-sm rounded-3" onchange="this.form.submit()">
                        <option value="">All Brands</option>
                        @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary small text-uppercase tracking-wider">Budget Range</label>
                    <div class="d-flex align-items-center gap-2">
                        <input type="number" name="min_price" class="form-control border-0 bg-light shadow-sm rounded-3 text-center" placeholder="Min $" value="{{ request('min_price') }}">
                        <span class="text-secondary">-</span>
                        <input type="number" name="max_price" class="form-control border-0 bg-light shadow-sm rounded-3 text-center" placeholder="Max $" value="{{ request('max_price') }}">
                    </div>
                </div>

                <div class="d-grid gap-2 mt-5">
                    <button type="submit" class="btn btn-gradient rounded-pill py-2 shadow-sm">Apply Filters</button>
                    <a href="{{ route('home') }}" class="btn btn-light rounded-pill py-2 text-muted fw-semibold transition-all hover-danger">Clear All</a>
                </div>
            </form>
        </div>
    </aside>

    <!-- Product Grid -->
    <main class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-left" data-aos-delay="200">
            <h3 class="fw-bold m-0"><i class="fas fa-bolt text-warning me-2"></i>Available Stock</h3>
            <span class="badge bg-white text-dark shadow-sm px-3 py-2 rounded-pill border">{{ $products->total() }} Components Found</span>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
            @forelse($products as $index => $product)
            <div class="col" data-aos="zoom-in-up" data-aos-delay="{{ $index * 50 }}">
                <div class="card h-100 product-card">
                    <div class="product-img-wrapper">
                        @if($product->image_path)
                        <a href="{{ route('product.show', $product) }}">
                            <img src="{{ asset('storage/' . $product->image_path) }}" class="card-img-top product-img w-100" alt="{{ $product->name }}">
                        </a>
                        @else
                        <a href="{{ route('product.show', $product) }}" class="text-decoration-none">
                            <div class="card-img-top product-img bg-light d-flex align-items-center justify-content-center">
                                <i class="fas fa-microchip fa-4x text-muted opacity-50"></i>
                            </div>
                        </a>
                        @endif
                        <!-- Quick View Overlay -->
                        <div class="product-overlay">
                            <a href="{{ route('product.show', $product) }}" class="btn btn-light btn-sm rounded-pill w-100 fw-bold shadow">
                                <i class="fas fa-eye me-1"></i> Quick View
                            </a>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column p-4">
                        <span class="badge bg-light text-primary mb-2 align-self-start border" style="font-weight:600;">{{ $product->category ? $product->category->name : 'Part' }}</span>
                        <h5 class="card-title fw-bold text-dark mb-1">
                            <a href="{{ route('product.show', $product) }}" class="text-decoration-none text-dark">{{ $product->name }}</a>
                        </h5>
                        <p class="text-muted small fw-semibold mb-3">
                            <i class="fas fa-industry me-1"></i>{{ $product->brand ? $product->brand->name : 'Unknown' }}
                        </p>

                        <div class="d-flex justify-content-between align-items-end mt-auto mb-3">
                            <div class="price-tag">${{ number_format($product->price, 2) }}</div>
                            @if($product->stock_quantity > 0)
                            <span class="text-success small fw-bold"><i class="fas fa-circle me-1" style="font-size: 8px;"></i>In Stock</span>
                            @else
                            <span class="text-danger small fw-bold"><i class="fas fa-circle me-1" style="font-size: 8px;"></i>Out</span>
                            @endif
                        </div>

                        @if($product->stock_quantity > 0)
                        <form action="{{ route('cart.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn btn-add btn-dark text-white w-100 py-2 fw-bold shadow-sm">
                                <i class="fas fa-cart-plus me-2"></i>Add to Cart
                            </button>
                        </form>
                        @else
                        <button class="btn btn-secondary w-100 py-2 fw-bold" disabled>Out of Stock</button>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12" data-aos="fade-up">
                <div class="card border-0 shadow-sm p-5 text-center rounded-4 w-100">
                    <i class="fas fa-search-minus fa-4x mb-4 text-muted opacity-50" style="animation: pulse-badge 2s infinite;"></i>
                    <h3 class="fw-bold">No exact matches found</h3>
                    <p class="text-muted fs-5">We couldn't find any parts matching your specific configuration.</p>
                    <div>
                        <a href="{{ route('home') }}" class="btn btn-gradient px-4 py-2 rounded-pill mt-3">Reset Filters</a>
                    </div>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5" data-aos="fade-in" data-aos-delay="300">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    </main>
</div>
@endsection