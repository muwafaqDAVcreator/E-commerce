<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechParts - Authentication</title>
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
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #ec4899;
        }
        body {
            background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
            overflow-x: hidden;
        }
        .btn-primary-gradient {
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            border: none;
            color: white;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .btn-primary-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(99,102,241,0.4);
            color: white;
        }
        .hover-scale { transition: transform 0.3s ease; }
        .hover-scale:hover { transform: scale(1.02); }
        .tracking-wider { letter-spacing: 2px; }
    </style>
</head>
<body>
    <div class="container w-100">
        <div class="text-center mb-4 pb-2" data-aos="fade-down" data-aos-duration="600">
            <a href="{{ route('home') }}" class="text-decoration-none d-inline-block hover-scale">
                <h2 class="fw-bold mb-0" style="background: linear-gradient(45deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="fas fa-microchip me-2 text-primary"></i>TechParts
                </h2>
                <p class="text-muted small fw-bold tracking-wider text-uppercase mt-2"><i class="fas fa-arrow-left me-1"></i> Return to Store</p>
            </a>
        </div>
        
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });
    </script>
</body>
</html>
