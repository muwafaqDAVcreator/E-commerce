@extends('layouts.store')

@section('styles')
<style>
    .product-hero-bg {
        background: radial-gradient(circle at center, rgba(99, 102, 241, 0.05) 0%, transparent 70%);
        border-radius: 20px;
    }

    .main-image-wrapper {
        transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .main-image-wrapper:hover {
        transform: scale(1.05) rotate(2deg);
    }

    .review-card {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }

    .review-card:hover {
        background: #f8fafc;
        transform: translateX(10px);
        border-left-color: var(--primary);
    }
</style>
@endsection

@section('content')
<!-- Notice: To avoid excessive DOM code mapping here, I will structure this logically -->
<div class="row mb-5 align-items-center product-hero-bg p-4 p-md-5" data-aos="fade-up">
    <div class="col-md-5 mb-4 mb-md-0 position-relative">
        <div class="main-image-wrapper text-center">
            @if($product->image_path)
            <img src="{{ asset('storage/' . $product->image_path) }}" class="img-fluid rounded-4 shadow w-100" alt="{{ $product->name }}">
            @else
            <div class="bg-white rounded-4 shadow d-flex align-items-center justify-content-center w-100 mx-auto" style="height: 400px; max-width: 400px;">
                <i class="fas fa-microchip fa-6x text-primary opacity-25"></i>
            </div>
            @endif
        </div>
    </div>
    <div class="col-md-7 ps-md-5" data-aos="fade-left" data-aos-delay="200">
        <div class="d-flex align-items-center gap-2 mb-3">
            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-3 py-2 fw-bold tracking-wider text-uppercase" style="font-size:0.75rem;"><i class="fas fa-tag me-1"></i>{{ $product->category ? $product->category->name : 'Uncategorized' }}</span>
            <span class="badge bg-dark rounded-pill px-3 py-2 fw-bold" style="font-size:0.75rem;"><i class="fas fa-industry me-1"></i>{{ $product->brand ? $product->brand->name : 'No Brand' }}</span>
        </div>

        <h1 class="fw-bold display-5 mb-3">{{ $product->name }}</h1>

        <h2 class="fw-bold mb-4" style="background: linear-gradient(45deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-size: 3rem;">
            Rs{{ number_format($product->price, 2) }}
        </h2>

        <div class="bg-white p-4 rounded-4 shadow-sm mb-4 border-start border-4 border-primary">
            <p class="fs-5 m-0 text-secondary lh-lg" style="white-space: pre-line;">{{ $product->description }}</p>
        </div>

        <div class="mb-4 d-inline-block p-3 rounded-pill" style="background: rgba(255,255,255,0.7); backdrop-filter: blur(5px);">
            @if($product->stock_quantity > 10)
            <span class="text-success fw-bold fs-5"><i class="fas fa-check-circle me-2 fa-lg"></i>In Stock <span class="badge bg-success ms-2">{{ $product->stock_quantity }}</span></span>
            @elseif($product->stock_quantity > 0)
            <span class="text-warning text-dark fw-bold fs-5"><i class="fas fa-fire text-danger me-2 fa-lg" style="animation: pulse-badge 1s infinite;"></i>Selling Fast <span class="badge bg-warning text-dark ms-2">Only {{ $product->stock_quantity }} left</span></span>
            @else
            <span class="text-danger fw-bold fs-5"><i class="fas fa-times-circle me-2 fa-lg"></i>Out of Stock</span>
            @endif
        </div>

        <div class="d-flex gap-3">
            @if($product->stock_quantity > 0)
            <form action="{{ route('cart.store') }}" method="POST" class="flex-grow-1">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="btn btn-gradient btn-lg w-100 fw-bold rounded-pill shadow position-relative overflow-hidden group">
                    <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                </button>
            </form>
            @else
            <button class="btn btn-secondary btn-lg flex-grow-1 fw-bold rounded-pill shadow-sm" disabled>Out of Stock</button>
            @endif

            @if(Auth::check())
            <form action="{{ route('interactions.wishlist.toggle', $product) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-light btn-lg rounded-circle shadow-sm position-relative" style="width: 55px; height: 55px; border: 2px solid {{ $inWishlist ? 'var(--secondary)' : '#ddd' }};" data-bs-toggle="tooltip" title="{{ $inWishlist ? 'Remove' : 'Save' }}">
                    <i class="{{ $inWishlist ? 'fas text-danger' : 'far text-secondary' }} fa-heart position-absolute top-50 start-50 translate-middle fs-4" style="transition: transform 0.2s ease; {{ $inWishlist ? 'animation: pulse-badge 1.5s infinite;' : '' }}"></i>
                </button>
            </form>
            @else
            <a href="{{ route('login') }}" class="btn btn-light btn-lg rounded-circle shadow-sm d-flex align-items-center justify-content-center text-decoration-none" style="width: 55px; height: 55px; border: 2px solid #ddd;">
                <i class="far fa-heart text-secondary fs-4"></i>
            </a>
            @endif
        </div>

        <div class="mt-4 pt-3 border-top">
            @if(Auth::check())
                <button type="button" class="btn btn-outline-primary rounded-pill fw-bold bg-white shadow-sm hover-scale" data-bs-toggle="modal" data-bs-target="#productEnquiryModal">
                    <i class="fas fa-question-circle me-1"></i> Have a question about this product?
                </button>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill fw-bold bg-white shadow-sm hover-scale">
                    <i class="fas fa-question-circle me-1"></i> Log in to ask a question
                </a>
            @endif
        </div>
    </div>
</div>

<div class="row mt-5" data-aos="fade-up" data-aos-offset="100">
    <div class="col-12 px-md-5">
        <div class="d-flex align-items-center mb-5 border-bottom pb-3">
            <i class="fas fa-star text-warning fa-2x me-3"></i>
            <h3 class="fw-bold m-0">Community Reviews</h3>
        </div>

        <div class="row">
            <div class="col-lg-4 mb-4" data-aos="fade-right" data-aos-delay="100">
                @if(Auth::check())
                <div class="card border-0 shadow-lg bg-primary text-white rounded-4 overflow-hidden position-relative">
                    <div class="position-absolute top-0 end-0 opacity-10" style="transform: translate(20%, -20%);"><i class="fas fa-comment-alt fa-10x"></i></div>
                    <div class="card-body p-4 position-relative z-index-1">
                        <h4 class="fw-bold mb-3">{{ $userReview ? 'Update Your Review' : 'Drop a Review!' }}</h4>
                        <p class="text-white-50 small mb-4">Share your genuine experience to help fellow builders.</p>
                        <form action="{{ route('interactions.review.store', $product) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold text-white-50 uppercase tracking-wider" style="font-size:0.8rem;">Rating Level</label>
                                <select name="rating" class="form-select bg-white bg-opacity-10 border-0 text-white shadow-none fw-bold" required>
                                    <option value="5" class="text-dark" {{ ($userReview->rating ?? 5) == 5 ? 'selected' : '' }}>5 Stars</option>
                                    <option value="4" class="text-dark" {{ ($userReview->rating ?? 5) == 4 ? 'selected' : '' }}>4 Stars</option>
                                    <option value="3" class="text-dark" {{ ($userReview->rating ?? 5) == 3 ? 'selected' : '' }}>3 Stars</option>
                                    <option value="2" class="text-dark" {{ ($userReview->rating ?? 5) == 2 ? 'selected' : '' }}>2 Stars</option>
                                    <option value="1" class="text-dark" {{ ($userReview->rating ?? 5) == 1 ? 'selected' : '' }}>1 Star</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold text-white-50 uppercase tracking-wider" style="font-size:0.8rem;">Your Thoughts</label>
                                <textarea name="comment" class="form-control bg-white bg-opacity-10 border-0 text-white shadow-none placeholder-white-50" rows="4" required placeholder="This part blew my mind because...">{{ $userReview ? $userReview->comment : '' }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-light text-primary w-100 rounded-pill fw-bold shadow-sm transition-all hover-scale">{{ $userReview ? 'Update It' : 'Post It' }}</button>
                        </form>
                    </div>
                </div>
                @else
                <div class="card border-0 shadow-sm rounded-4 text-center p-5 bg-white">
                    <i class="fas fa-lock fa-3x text-muted mb-3 opacity-25"></i>
                    <h5 class="fw-bold">Members Only Feature</h5>
                    <p class="text-muted small">Create an account to join the community and leave a review.</p>
                    <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill fw-bold mt-2">Log In</a>
                </div>
                @endif
            </div>

            <div class="col-lg-8" data-aos="fade-left" data-aos-delay="200">
                <div class="ps-lg-4">
                    @forelse($product->reviews as $review)
                    <div class="card border-0 bg-white rounded-4 shadow-sm mb-3 review-card">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm text-white fw-bold" style="width: 45px; height: 45px; background: linear-gradient(135deg, var(--primary), var(--secondary));">
                                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold text-dark">{{ $review->user->name }}</h6>
                                        <small class="text-muted opacity-75" style="font-size: 0.75rem;">{{ $review->updated_at->format('M d, Y') }}</small>
                                    </div>
                                </div>
                                <div class="bg-light rounded-pill px-3 py-1 text-warning shadow-sm border">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star" style="font-size: 0.85rem;"></i>
                                        @endfor
                                </div>
                            </div>
                            <p class="mb-0 text-secondary lh-lg fs-6" style="font-weight: 300;">"{{ $review->comment }}"</p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light shadow-sm mb-4" style="width: 100px; height: 100px;">
                            <i class="far fa-comment-dots fa-3x text-muted opacity-25"></i>
                        </div>
                        <h4 class="fw-bold text-secondary">The silence is deafening...</h4>
                        <p class="text-muted">No reviews exist yet. Claim the #First spot!</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@if(Auth::check())
<!-- Product Enquiry Modal -->
<div class="modal fade" id="productEnquiryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-primary text-white border-0 py-3">
                <h5 class="modal-title fw-bold"><i class="fas fa-headset me-2"></i>Product Enquiry</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('interactions.ticket.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="modal-body p-4">
                    <p class="text-muted small mb-4">Have a specific question about the <strong>{{ $product->name }}</strong>? Ask our hardware experts directly!</p>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary text-uppercase tracking-wider" style="font-size: 0.8rem;">Subject</label>
                        <input type="text" name="subject" class="form-control bg-light border-0 shadow-sm rounded-3 py-2" value="Enquiry: {{ $product->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary text-uppercase tracking-wider" style="font-size: 0.8rem;">Your Question</label>
                        <textarea name="message" class="form-control bg-light border-0 shadow-sm rounded-3 py-2" rows="5" required placeholder="What would you like to know about this hardware?"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">Submit Enquiry</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection