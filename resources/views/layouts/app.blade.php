<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PortZen</title>
    
    <!-- Google Fonts - Single Import -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" 
          crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <!-- Header -->
    <header class="bg-dark py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="text-light">PortZen</h1>
            <nav>
                <ul class="nav">
                    <li class="nav-item"><a class="nav-link text-light" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="{{ route('templates') }}">Templates</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="{{ route('about') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="{{ route('contact') }}">Contact</a></li>
                    @guest
                        <li class="nav-item"><a class="btn btn-primary" href="{{ route('login') }}">Login / Signup</a></li>
                    @else
                        <li class="nav-item"><a class="btn btn-secondary" href="{{ route('dashboard') }}">Dashboard</a></li>
                    @endguest
                </ul>
                
            </nav>
            
        </div>
    </header>

    <!-- Page Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-light text-center py-3">
        <p>&copy; 2025 PortZen. All Rights Reserved.</p>
    </footer>

    <!-- Add Font Awesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
</body>
</html>
