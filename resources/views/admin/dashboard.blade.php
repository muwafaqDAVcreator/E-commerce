@extends('layouts.admin')

@section('header', 'System Analytics')

@section('content')
<!-- SweetAlert2 for notifications -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="row g-4 mb-4" data-aos="fade-up">
    <!-- Revenue Card -->
    <div class="col-md-4">
        <div class="admin-card p-4 overflow-hidden position-relative h-100" style="background: linear-gradient(135deg, #4f46e5, #8b5cf6); color: white;">
            <div class="position-absolute top-0 end-0 opacity-25" style="transform: translate(20%, -20%) rotate(-15deg);"><i class="fas fa-wallet fa-6x"></i></div>
            <div class="position-relative z-index-1">
                <p class="text-white-50 fw-bold mb-1 text-uppercase tracking-wider">Total Revenue</p>
                <h2 class="fw-bold mb-0">${{ number_format($totalRevenue, 2) }}</h2>
                <div class="mt-3 bg-white bg-opacity-25 rounded-pill px-3 py-1 d-inline-block shadow-sm">
                    <span class="small fw-bold"><i class="fas fa-arrow-up me-1"></i>+12.5%</span> All Time
                </div>
            </div>
        </div>
    </div>
    
    <!-- Orders Card -->
    <div class="col-md-4">
        <div class="admin-card p-4 overflow-hidden position-relative h-100 bg-white">
            <div class="position-absolute top-0 end-0 text-success opacity-10" style="transform: translate(20%, -20%) rotate(-15deg);"><i class="fas fa-shopping-cart fa-6x"></i></div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;"><i class="fas fa-box-open fs-4"></i></div>
                <span class="badge bg-success rounded-pill shadow-sm">Orders</span>
            </div>
            <h2 class="fw-bold mb-1 text-dark">{{ $totalOrders }}</h2>
            <p class="text-muted small fw-semibold mb-0">Processed Shipments</p>
        </div>
    </div>
    
    <!-- Customers Card -->
    <div class="col-md-4">
        <div class="admin-card p-4 overflow-hidden position-relative h-100 bg-white">
            <div class="position-absolute top-0 end-0 text-primary opacity-10" style="transform: translate(20%, -20%) rotate(-15deg);"><i class="fas fa-users fa-6x"></i></div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;"><i class="fas fa-user-friends fs-4"></i></div>
                <span class="badge bg-primary rounded-pill shadow-sm">Customers</span>
            </div>
            <h2 class="fw-bold mb-1 text-dark">{{ $totalCustomers }}</h2>
            <p class="text-muted small fw-semibold mb-0">Registered accounts</p>
        </div>
    </div>
</div>

<div class="row g-4 mb-4" data-aos="fade-up" data-aos-delay="100">
    <!-- Chart Section -->
    <div class="col-lg-8">
        <div class="admin-card p-4 h-100">
            <h5 class="fw-bold border-bottom pb-3 mb-4"><i class="fas fa-chart-line text-primary me-2"></i>Sales Performance Overview</h5>
            <div class="position-relative" style="height: 300px; width: 100%;">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Low Stock Alerts -->
    <div class="col-lg-4">
        <div class="admin-card p-4 h-100">
            <h5 class="fw-bold border-bottom pb-3 mb-4"><i class="fas fa-exclamation-triangle text-warning me-2"></i>Inventory Alerts</h5>
            @if($lowStockProducts->count() > 0)
                <div class="alert alert-danger bg-danger bg-opacity-10 py-2 border-danger border-opacity-25 rounded-3 mb-3 d-flex align-items-center">
                    <i class="fas fa-exclamation-circle text-danger me-2 fa-lg" style="animation: pulse-badge 1.5s infinite;"></i>
                    <strong class="text-danger">{{ $lowStockProducts->count() }} items need restocking!</strong>
                </div>
                <div class="list-group list-group-flush">
                    @foreach($lowStockProducts as $product)
                        <div class="list-group-item px-0 py-3 bg-transparent d-flex justify-content-between align-items-center border-bottom-dashed">
                            <div>
                                <a href="{{ route('admin.products.edit', $product) }}" class="fw-bold text-dark text-decoration-none hover-primary">{{ \Illuminate\Support\Str::limit($product->name, 25) }}</a>
                                <p class="text-muted small mb-0">{{ $product->category ? $product->category->name : 'Part' }}</p>
                            </div>
                            <span class="badge bg-danger rounded-pill shadow-sm px-3 py-2">{{ $product->stock_quantity }} Left</span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center p-4">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-check fa-2x"></i>
                    </div>
                    <h6 class="fw-bold text-success">Inventory Healthy</h6>
                    <p class="text-muted small">All products are well stocked.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Trigger alert specifically for low stock if we have them
        @if($lowStockProducts->count() > 0)
        Swal.fire({
            title: 'Inventory Warning!',
            text: 'You have {{ $lowStockProducts->count() }} products with critically low stock.',
            icon: 'warning',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        @endif

        // Render Animated Chart
        const ctx = document.getElementById('salesChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(99, 102, 241, 0.5)');   
        gradient.addColorStop(1, 'rgba(99, 102, 241, 0.0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label: 'Revenue ($)',
                    data: [12000, 19000, 15000, 25000, 22000, 30000, {{ $totalRevenue > 30000 ? $totalRevenue : 35000 }}],
                    backgroundColor: gradient,
                    borderColor: '#6366f1',
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#6366f1',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false, drawBorder: false } },
                    y: { grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false }, beginAtZero: true }
                },
                animation: { duration: 2000, easing: 'easeOutQuart' }
            }
        });
    });
</script>
<style>
    .border-bottom-dashed { border-bottom: 1px dashed rgba(0,0,0,0.1); }
    .list-group-item:last-child { border-bottom: none !important; }
</style>
@endsection
