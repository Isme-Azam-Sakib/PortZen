<!-- Header -->
<header class="bg-dark py-3">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ route('home') }}" class="text-decoration-none">
            <h1 class="text-light m-0"><i class="fa-solid fa-layer-group"></i> PortZen</h1>
        </a>
        <nav>
            <ul class="nav">
                <li class="nav-item"><a class="nav-link text-light" href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Home</a></li>
                <!-- <li class="nav-item"><a class="nav-link text-light" href="{{ route('templates') }}"><i class="fa-solid fa-palette"></i> Templates</a></li> -->
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
