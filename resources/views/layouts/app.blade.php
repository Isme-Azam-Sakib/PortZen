<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PortZen</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- Header -->
    <header class="bg-dark py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="{{ route('home') }}" class="text-decoration-none">
                <h1 class="text-light m-0"><i class="fa-solid fa-layer-group"></i> PortZen</h1>
            </a>
            <nav>
                <ul class="nav">
                    <li class="nav-item"><a class="nav-link text-light" href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Home</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="{{ route('templates') }}"><i class="fa-solid fa-palette"></i> Templates</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="{{ route('about') }}"><i class="fa-solid fa-circle-info"></i> About</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="{{ route('contact') }}"><i class="fa-solid fa-envelope"></i> Contact</a></li>
                    @guest
                        <li class="nav-item"><a class="btn btn-primary" href="{{ route('login') }}"><i class="fa-solid fa-right-to-bracket"></i> Login / Signup</a></li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fa-solid fa-user-pen"></i> Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fa-solid fa-right-from-bracket"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </nav>
        </div>
    </header>

    <!-- Page Content -->
    <main class="py-4">
        @if(session('success'))
            <div class="container">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="fa-solid fa-link"></i> Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-light text-decoration-none"><i class="fa-solid fa-chevron-right"></i> Home</a></li>
                        <li><a href="{{ route('templates') }}" class="text-light text-decoration-none"><i class="fa-solid fa-chevron-right"></i> Templates</a></li>
                        <li><a href="{{ route('about') }}" class="text-light text-decoration-none"><i class="fa-solid fa-chevron-right"></i> About</a></li>
                        <li><a href="{{ route('contact') }}" class="text-light text-decoration-none"><i class="fa-solid fa-chevron-right"></i> Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5><i class="fa-solid fa-envelope"></i> Contact Us</h5>
                    <p><i class="fa-solid fa-envelope"></i> info@portzen.com</p>
                    <p><i class="fa-solid fa-phone"></i> +1 234 567 890</p>
                </div>
                <div class="col-md-4">
                    <h5><i class="fa-solid fa-share-nodes"></i> Follow Us</h5>
                    <div class="social-links">
                        <a href="#" class="text-light mx-2"><i class="fa-brands fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-light mx-2"><i class="fa-brands fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-light mx-2"><i class="fa-brands fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-light mx-2"><i class="fa-brands fa-linkedin fa-lg"></i></a>
                    </div>
                </div>
            </div>
            <hr>
            <p class="text-center mb-0"><i class="fa-regular fa-copyright"></i> 2024 PortZen. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
