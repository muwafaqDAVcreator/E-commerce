<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Dashboard - Computer Parts E-Commerce</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background-color: #1a4a5a; color: white; padding-top: 1rem; }
        .sidebar a { color: #ccc; text-decoration: none; display: block; padding: 10px 15px; }
        .sidebar a:hover, .sidebar a.active { color: white; background-color: #246377; border-radius: 4px; }
        .main-content { padding: 20px; }
        .card { border: none; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 sidebar d-flex flex-column">
                <h4 class="px-3 mb-4">Support Panel</h4>
                <a href="{{ route('support.tickets.index') }}" class="{{ request()->routeIs('support.tickets.*') ? 'active' : '' }}">Help Desk Tickets</a>
                <hr>
                <a href="{{ route('dashboard') }}" class="mt-auto">Back to Store</a>
            </nav>
            <main class="col-md-10 main-content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
