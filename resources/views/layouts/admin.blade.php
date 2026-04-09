<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechParts Admin Control</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --admin-primary: #8b5cf6;
            --admin-dark: #0f172a;
            --admin-sidebar: #1e293b;
            --admin-bg: #f1f5f9;
        }
        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--admin-bg);
            color: #334155;
            overflow-x: hidden;
        }
        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            top: 0; left: 0;
            background: linear-gradient(180deg, var(--admin-dark) 0%, var(--admin-sidebar) 100%);
            color: white;
            z-index: 1000;
            padding-top: 2rem;
            transition: all 0.3s ease;
            box-shadow: 4px 0 15px rgba(0,0,0,0.1);
        }
        .main-content {
            margin-left: 280px;
            padding: 2rem;
            min-height: 100vh;
            transition: all 0.3s ease;
        }
        .sidebar-brand {
            font-weight: 800;
            font-size: 1.8rem;
            padding: 0 2rem 2rem;
            display: block;
            color: white;
            text-decoration: none;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 1rem;
        }
        .nav-item-admin {
            padding: 0.8rem 2rem;
            display: flex;
            align-items: center;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        .nav-item-admin:hover, .nav-item-admin.active {
            background: rgba(255,255,255,0.05);
            color: white;
            border-left-color: var(--admin-primary);
        }
        .nav-item-admin i {
            width: 25px;
            font-size: 1.2rem;
            margin-right: 10px;
        }
        .admin-card {
            background: white;
            border-radius: 16px;
            border: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            transition: transform 0.3s ease;
        }
        .admin-table {
            border-collapse: separate;
            border-spacing: 0 10px;
        }
        .admin-table tbody tr {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            border-radius: 12px;
            transition: transform 0.2s ease;
        }
        .admin-table tbody tr:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .admin-table td, .admin-table th {
            border: none;
            padding: 1rem 1.5rem;
            vertical-align: middle;
        }
        .admin-table th {
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
            padding-bottom: 0;
        }
        .admin-table td:first-child { border-top-left-radius: 12px; border-bottom-left-radius: 12px; }
        .admin-table td:last-child { border-top-right-radius: 12px; border-bottom-right-radius: 12px; }
        .btn-admin {
            background: var(--admin-primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-block;
        }
        .btn-admin:hover {
            background: #7c3aed;
            transform: translateY(-2px);
            color: white;
        }
        .topbar {
            background: white;
            border-radius: 16px;
            padding: 1rem 2rem;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <a href="{{ route('admin.products.index') }}" class="sidebar-brand">
            <i class="fas fa-microchip text-primary me-2"></i>Admin
        </a>
        
        <div class="d-flex flex-column gap-1">
            <a href="{{ route('admin.dashboard') }}" class="nav-item-admin {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i> Dashboard
            </a>
            <a href="{{ route('admin.products.index') }}" class="nav-item-admin {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="fas fa-box"></i> Inventory
            </a>
            <a href="{{ route('admin.categories.index') }}" class="nav-item-admin {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fas fa-tags"></i> Categories
            </a>
            <a href="{{ route('admin.brands.index') }}" class="nav-item-admin {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
                <i class="fas fa-industry"></i> Brands
            </a>
            <a href="{{ route('admin.orders.index') }}" class="nav-item-admin {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i> Orders
            </a>
            <a href="{{ route('admin.users.index') }}" class="nav-item-admin {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Users
            </a>
            
            <div class="mt-auto px-4 mt-5">
                <hr class="border-secondary opacity-25">
                <a href="{{ route('home') }}" class="nav-item-admin px-0">
                    <i class="fas fa-store"></i> View Store
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="nav-item-admin px-0 border-0 bg-transparent w-100 text-start text-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="topbar" data-aos="fade-down">
            <h4 class="m-0 fw-bold">@yield('header', 'Admin Control')</h4>
            <div class="d-flex align-items-center gap-3">
                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-primary fw-bold" style="width: 45px; height: 45px;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <h6 class="m-0 fw-bold">{{ Auth::user()->name }}</h6>
                    <small class="text-muted">{{ Auth::user()->role ?? 'Super Admin' }}</small>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4" data-aos="fade-down" data-aos-delay="100">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });
    </script>
</body>
</html>
