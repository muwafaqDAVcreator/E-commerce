<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechParts - Premium E-Commerce</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #ec4899;
            --dark: #0f172a;
            --light: #f8fafc;
            --glass-bg: rgba(255, 255, 255, 0.85);
            --glass-border: rgba(255, 255, 255, 0.2);
        }

        body {
            background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
            font-family: 'Outfit', sans-serif;
            color: var(--dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* Glassmorphism Navbar */
        .navbar-glass {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--glass-border);
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
        }

        .nav-link {
            font-weight: 600;
            color: var(--dark) !important;
            transition: color 0.3s ease, transform 0.3s ease;
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .nav-link:hover {
            color: var(--primary) !important;
            transform: translateY(-2px);
        }

        .btn-gradient {
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            border: none;
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        .btn-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, var(--secondary), var(--primary));
            z-index: -1;
            transition: opacity 0.3s ease;
            opacity: 0;
        }

        .btn-gradient:hover::before {
            opacity: 1;
        }

        .btn-gradient:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.5);
            color: white;
        }

        /* Animated Badge */
        .cart-badge {
            animation: pulse-badge 2s infinite;
        }

        @keyframes pulse-badge {
            0% {
                transform: scale(1) translate(-50%, -50%);
                box-shadow: 0 0 0 0 rgba(236, 72, 153, 0.7);
            }

            70% {
                transform: scale(1.1) translate(-50%, -50%);
                box-shadow: 0 0 0 10px rgba(236, 72, 153, 0);
            }

            100% {
                transform: scale(1) translate(-50%, -50%);
                box-shadow: 0 0 0 0 rgba(236, 72, 153, 0);
            }
        }

        /* Page Transitions */
        main {
            flex: 1;
            animation: fadeIn 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .footer-glass {
            background: var(--dark);
            color: white;
            position: relative;
            overflow: hidden;
        }
    </style>
    @yield('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light navbar-glass sticky-top py-3">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}" data-aos="fade-right">
                <i class="fas fa-microchip me-2"></i>TechParts
            </a>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars fs-3 text-dark"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto" data-aos="fade-down" data-aos-delay="100">
                    <li class="nav-item ms-lg-4">
                        <a class="nav-link" href="{{ route('home') }}">Catalog</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto align-items-center" data-aos="fade-left" data-aos-delay="200">
                    <li class="nav-item me-4">
                        <a class="nav-link text-dark position-relative" href="/cart" style="font-size: 1.2rem;">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-badge">
                                {{ count(session('cart', [])) }}
                            </span>
                        </a>
                    </li>
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Log In</a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-gradient px-4 rounded-pill" href="{{ route('register') }}">Sign Up</a>
                    </li>
                    @else
                    <li class="nav-item dropdown">
                        <a class="btn btn-gradient px-4 rounded-pill dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg" style="border-radius: 12px; animation: dropdownFade 0.3s ease;">
                            <li><a class="dropdown-item py-2 fw-semibold" href="{{ route('dashboard') }}"><i class="fas fa-columns me-2 text-primary"></i>Dashboard</a></li>
                            @if(Auth::user()->role === 'Admin')
                            <li><a class="dropdown-item py-2 fw-semibold text-danger" href="{{ route('admin.dashboard') }}"><i class="fas fa-lock me-2"></i>Admin Panel</a></li>
                            @endif
                            @if(Auth::user()->role === 'Support' || Auth::user()->role === 'Admin')
                            <li><a class="dropdown-item py-2 fw-semibold text-info" href="{{ route('support.tickets.index') }}"><i class="fas fa-headset me-2"></i>Support Panel</a></li>
                            @endif
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 fw-semibold text-danger"><i class="fas fa-sign-out-alt me-2"></i>Log Out</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-5" id="main-content">
        <div class="container">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 bg-success text-white" role="alert" style="border-radius: 12px; animation: slideDown 0.5s ease;">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 bg-danger text-white" role="alert" style="border-radius: 12px; animation: slideDown 0.5s ease;">
                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @yield('content')
        </div>
    </main>

    <style>
        .hover-white:hover { color: white !important; transform: translateX(5px); display: inline-block; }
    </style>
    
    <footer class="footer-glass pt-5 mt-auto border-top" style="border-color: rgba(255,255,255,0.1) !important;">
        <div class="container pb-5">
            <div class="row g-4" data-aos="fade-up">
                <div class="col-lg-4 pe-lg-5">
                    <h3 class="fw-bold mb-4" style="background: linear-gradient(45deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        <i class="fas fa-microchip me-2 text-primary"></i>TechParts
                    </h3>
                    <p class="text-white-50 lh-lg">Empowering creators, developers, and gamers with premium hardware components and unparalleled customer success.</p>
                    <div class="d-flex gap-3 mt-4">
                        <a href="#" class="btn btn-outline-light rounded-circle shadow-sm" style="width: 45px; height: 45px; line-height: 33px;"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="btn btn-outline-light rounded-circle shadow-sm" style="width: 45px; height: 45px; line-height: 33px;"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="btn btn-outline-light rounded-circle shadow-sm" style="width: 45px; height: 45px; line-height: 33px;"><i class="fab fa-discord"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-4">
                    <h5 class="fw-bold text-white mb-4">Store</h5>
                    <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
                        <li><a href="{{ route('home') }}" class="text-white-50 text-decoration-none hover-white transition-all">All Components</a></li>
                        <li><a href="{{ route('cart.index') }}" class="text-white-50 text-decoration-none hover-white transition-all">Shopping Cart</a></li>
                        <li><a href="{{ route('register') }}" class="text-white-50 text-decoration-none hover-white transition-all">Create Account</a></li>
                        <li><a href="{{ route('dashboard') }}" class="text-white-50 text-decoration-none hover-white transition-all">Track Order</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-4">
                    <h5 class="fw-bold text-white mb-4">Contact Info</h5>
                    <ul class="list-unstyled d-flex flex-column gap-3 mb-0 text-white-50">
                        <li class="d-flex"><i class="fas fa-map-marker-alt mt-1 me-3 text-primary"></i> 123 spillroad, Tech District, colombo</li>
                        <li class="d-flex"><i class="fas fa-phone-alt mt-1 me-3 text-primary"></i> +94 71 493 0480</li>
                        <li class="d-flex"><i class="fas fa-envelope mt-1 me-3 text-primary"></i> support@techparts.test</li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-4">
                    <h5 class="fw-bold text-white mb-4">Quick Support</h5>
                    <form action="#" method="POST" class="bg-white bg-opacity-10 p-3 rounded-4 border border-white border-opacity-10 shadow-sm" onsubmit="event.preventDefault(); alert('Thanks! Our support team will reach out.');">
                        <div class="mb-2">
                            <input type="text" class="form-control bg-transparent text-white border-white border-opacity-25 shadow-none" placeholder="Your query..." required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold shadow-sm hover-scale transition-all">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="border-top border-white border-opacity-10 py-4 text-center">
            <p class="mb-0 text-white-50 small">&copy; {{ date('Y') }} TechParts Inc. Elevating your build. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 50
        });

        // Add smooth hover interactions to alerts
        document.querySelectorAll('.alert').forEach(alert => {
            alert.addEventListener('mouseenter', () => alert.style.transform = 'scale(1.02)');
            alert.addEventListener('mouseleave', () => alert.style.transform = 'scale(1)');
            alert.style.transition = 'transform 0.3s ease';
        });
    </script>
    @yield('scripts')
</body>

</html>