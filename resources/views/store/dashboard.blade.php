@extends('layouts.store')

@section('styles')
<style>
    .dashboard-sidebar {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 20px;
        overflow: hidden;
    }

    .profile-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
    }

    .nav-tabs .nav-link {
        border: none;
        color: var(--dark);
        opacity: 0.6;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
        padding: 1rem 1.5rem;
    }

    .nav-tabs .nav-link:hover {
        opacity: 1;
        border-color: rgba(99, 102, 241, 0.3);
    }

    .nav-tabs .nav-link.active {
        opacity: 1;
        color: var(--primary);
        background: transparent;
        border-bottom: 3px solid var(--primary);
        font-weight: 800;
    }

    .dashboard-content-card {
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.05);
    }

    .interactive-row {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .interactive-row:hover {
        transform: translateY(-3px) scale(1.01);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        background-color: white !important;
        z-index: 10;
        position: relative;
    }
</style>
@endsection

@section('content')
<div class="row g-4 pb-5">
    <div class="col-lg-3" data-aos="fade-right">
        <div class="dashboard-sidebar shadow-sm border-0 text-center">
            <div class="profile-header py-5 position-relative overflow-hidden">
                <div class="position-absolute top-0 end-0 opacity-10" style="transform: translate(20%, -20%);"><i class="fas fa-microchip fa-10x"></i></div>
                <div class="position-relative z-index-1">
                    <div class="mb-3 d-inline-block p-1 bg-white rounded-circle shadow-sm">
                        <div class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                    <p class="mb-2 opacity-75 small">{{ $user->email }}</p>
                    <span class="badge bg-white text-primary rounded-pill px-3">{{ $user->role }}</span>
                </div>
            </div>

            <div class="list-group list-group-flush text-start p-2">
                <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action d-flex align-items-center border-0 rounded-3 mb-1 hover-scale bg-transparent fw-semibold text-secondary py-3">
                    <i class="fas fa-cog me-3 text-primary"></i> Account Settings
                </a>
                <a href="javascript:void(0)" class="list-group-item list-group-item-action d-flex align-items-center border-0 rounded-3 hover-scale bg-transparent fw-semibold text-danger py-3" onclick="document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt me-3"></i> Secure Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-9" data-aos="fade-left" data-aos-delay="100">
        <div class="dashboard-content-card">
            <div class="card-header bg-transparent border-bottom-0 pt-0 px-0">
                <ul class="nav nav-tabs justify-content-start border-bottom w-100" id="dashboardTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders-pane" type="button" role="tab" aria-selected="true">
                            <i class="fas fa-box me-2"></i>Orders
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tickets-tab" data-bs-toggle="tab" data-bs-target="#tickets-pane" type="button" role="tab" aria-selected="false">
                            <i class="fas fa-headset me-2"></i>Support
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="wishlist-tab" data-bs-toggle="tab" data-bs-target="#wishlist-pane" type="button" role="tab" aria-selected="false">
                            <i class="fas fa-heart me-2"></i>Wishlist
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews-pane" type="button" role="tab" aria-selected="false">
                            <i class="fas fa-star me-2"></i>Reviews
                        </button>
                    </li>
                </ul>
            </div>

            <div class="card-body p-4 p-md-5">
                <div class="tab-content" id="dashboardTabsContent">

                    <!-- Orders Tab -->
                    <div class="tab-pane fade show active" id="orders-pane" role="tabpanel" tabindex="0">
                        <h4 class="fw-bold mb-4">Order History</h4>
                        @if($orders->count() > 0)
                        <div class="table-responsive rounded-4 shadow-sm border overflow-hidden">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light text-secondary text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px;">
                                    <tr>
                                        <th class="ps-4 py-3">Order #</th>
                                        <th class="py-3">Date</th>
                                        <th class="py-3">Total</th>
                                        <th class="py-3">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr class="interactive-row bg-white cursor-pointer" onclick="window.location='{{ route('checkout.success', $order) }}'">
                                        <td class="fw-bold ps-4 py-3 text-primary">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                        <td class="text-secondary">{{ $order->created_at->format('M d, Y') }}</td>
                                        <td class="fw-semibold">${{ number_format($order->total_amount, 2) }}</td>
                                        <td>
                                            @php
                                            $badge = match($order->status) {
                                            'Pending' => 'bg-warning bg-opacity-25 text-warning border-warning border border-opacity-50',
                                            'Processing' => 'bg-info bg-opacity-25 text-info border-info border border-opacity-50',
                                            'Shipped' => 'bg-primary bg-opacity-25 text-primary border-primary border border-opacity-50',
                                            'Delivered' => 'bg-success bg-opacity-25 text-success border-success border border-opacity-50',
                                            default => 'bg-secondary bg-opacity-25 text-secondary border-secondary border border-opacity-50'
                                            };
                                            @endphp
                                            <span class="badge {{ $badge }} rounded-pill px-3">{{ $order->status }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-5 text-muted border rounded-4 bg-light border-dashed">
                            <i class="fas fa-box-open fa-3x mb-3 opacity-50"></i>
                            <h5>No orders yet</h5>
                            <p>You haven't placed any orders. Start exploring our catalog.</p>
                            <a href="{{ route('home') }}" class="btn btn-gradient rounded-pill px-4 mt-2">Browse Store</a>
                        </div>
                        @endif
                    </div>

                    <!-- Tickets Tab -->
                    <div class="tab-pane fade" id="tickets-pane" role="tabpanel" tabindex="0">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="fw-bold mb-0">Support Tickets</h4>
                            <button class="btn btn-primary rounded-pill btn-sm px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#newTicketModal">
                                <i class="fas fa-plus me-1"></i>New Ticket
                            </button>
                        </div>
                        @if($tickets->count() > 0)
                        <div class="list-group list-group-flush rounded-4 overflow-hidden border">
                            @foreach($tickets as $ticket)
                            <div class="list-group-item p-4 interactive-row border-bottom">
                                <div class="d-flex w-100 justify-content-between align-items-center mb-2">
                                    <h5 class="mb-0 fw-bold">{{ $ticket->subject }}</h5>
                                    <span class="badge {{ $ticket->status === 'Open' ? 'bg-danger' : 'bg-success' }} rounded-pill px-3">{{ $ticket->status }}</span>
                                </div>
                                @if($ticket->product)
                                    <p class="mb-1 text-primary small fw-bold"><i class="fas fa-tag me-1"></i> {{ $ticket->product->name }}</p>
                                @endif
                                <p class="mb-2 text-secondary text-truncate" style="max-width: 80%;">{{ $ticket->message }}</p>
                                <div class="text-muted small d-flex align-items-center">
                                    <i class="far fa-clock me-1"></i> {{ $ticket->created_at->format('M d, Y') }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-5 text-muted border rounded-4 bg-light">
                            <i class="fas fa-headset fa-3x mb-3 opacity-50"></i>
                            <h5>No active tickets</h5>
                            <p>If you need help, feel free to submit a support ticket.</p>
                            <button class="btn btn-outline-primary rounded-pill px-4 mt-2" data-bs-toggle="modal" data-bs-target="#newTicketModal">Submit Ticket</button>
                        </div>
                        @endif
                    </div>

                    <!-- Wishlist Tab -->
                    <div class="tab-pane fade" id="wishlist-pane" role="tabpanel" tabindex="0">
                        <h4 class="fw-bold mb-4">Saved Hardware</h4>
                        @if($wishlists->count() > 0)
                        <div class="row row-cols-1 row-cols-md-2 g-4">
                            @foreach($wishlists as $wish)
                            @if($wish->product)
                            <div class="col">
                                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden interactive-row">
                                    <div class="d-flex flex-row h-100">
                                        <div class="bg-light d-flex align-items-center justify-content-center p-2" style="width: 120px; min-height: 120px;">
                                            @if($wish->product->image_path)
                                            <img src="{{ asset('storage/' . $wish->product->image_path) }}" class="img-fluid rounded shadow-sm" style="object-fit: cover;">
                                            @else
                                            <i class="fas fa-microchip fa-2x text-muted opacity-25"></i>
                                            @endif
                                        </div>
                                        <div class="card-body p-3 d-flex flex-column justify-content-center">
                                            <a href="{{ route('product.show', $wish->product) }}" class="text-decoration-none text-dark">
                                                <h6 class="card-title fw-bold text-truncate mb-1">{{ $wish->product->name }}</h6>
                                            </a>
                                            <p class="text-primary fw-bold mb-3">${{ number_format($wish->product->price, 2) }}</p>
                                            <div class="d-flex mt-auto">
                                                <form action="{{ route('cart.store') }}" method="POST" class="me-2 flex-grow-1">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $wish->product->id }}">
                                                    <button type="submit" class="btn btn-sm btn-dark rounded-pill w-100 fw-semibold"><i class="fas fa-cart-plus me-1"></i> Add</button>
                                                </form>
                                                <form action="{{ route('interactions.wishlist.remove', $wish->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" style="width: 32px; height: 32px; padding: 0;"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-5 text-muted border rounded-4 bg-light">
                            <i class="fas fa-heart fa-3x mb-3 opacity-50"></i>
                            <h5>Your wishlist is empty</h5>
                            <p>Save items you like to compare or buy later.</p>
                            <a href="{{ route('home') }}" class="btn btn-outline-danger rounded-pill px-4 mt-2"><i class="fas fa-search me-2"></i>Find Favorites</a>
                        </div>
                        @endif
                    </div>

                    <!-- Reviews Tab -->
                    <div class="tab-pane fade" id="reviews-pane" role="tabpanel" tabindex="0">
                        <h4 class="fw-bold mb-4">My Reviews</h4>
                        @if($reviews->count() > 0)
                        <div class="list-group list-group-flush rounded-4 overflow-hidden border">
                            @foreach($reviews as $review)
                            @if($review->product)
                            <div class="list-group-item p-4 interactive-row border-bottom">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <a href="{{ route('product.show', $review->product) }}" class="text-decoration-none text-dark">
                                        <h5 class="mb-0 fw-bold hover-primary transition-all">{{ $review->product->name }}</h5>
                                    </a>
                                    <div class="bg-light rounded-pill px-2 py-1 border shadow-sm text-warning">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star" style="font-size: 0.8rem;"></i>
                                            @endfor
                                    </div>
                                </div>
                                <p class="mb-2 text-secondary">"{{ $review->comment }}"</p>
                                <div class="text-muted small d-flex align-items-center">
                                    <i class="far fa-clock me-1"></i> {{ $review->created_at->format('M d, Y') }}
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-5 text-muted border rounded-4 bg-light">
                            <i class="fas fa-star fa-3x mb-3 opacity-50"></i>
                            <h5>No reviews yet</h5>
                            <p>After purchasing products, share your experience here.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Ticket Modal -->
<div class="modal fade" id="newTicketModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-primary text-white border-0 py-3">
                <h5 class="modal-title fw-bold"><i class="fas fa-headset me-2"></i>Open a Case</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('interactions.ticket.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <p class="text-muted small mb-4">Need help with an order or product issue? Submit a ticket and our support team will respond within 24 hours.</p>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary text-uppercase tracking-wider" style="font-size: 0.8rem;">Related Product <span class="fw-normal text-muted">(Optional)</span></label>
                        <select name="product_id" class="form-select bg-light border-0 shadow-sm rounded-3 py-2">
                            <option value="">-- General Support / Order Issue --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary text-uppercase tracking-wider" style="font-size: 0.8rem;">Subject</label>
                        <input type="text" name="subject" class="form-control bg-light border-0 shadow-sm rounded-3 py-2" required placeholder="Briefly describe your issue">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary text-uppercase tracking-wider" style="font-size: 0.8rem;">Message</label>
                        <textarea name="message" class="form-control bg-light border-0 shadow-sm rounded-3 py-2" rows="5" required placeholder="Provide details about your issue..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">Submit Ticket</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection