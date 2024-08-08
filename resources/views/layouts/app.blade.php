<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>


    @yield('styles') <!-- For additional CSS -->
    @stack('styles')
    <style>
        body {
            background: linear-gradient(to right, #7a22d8, #a0a7b3); /* Gradient background for the page */
            color: #333;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            min-height: 100vh; /* Ensure body covers full viewport height */
        }
        .navbar-custom {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e2e6ea;
        }
        .navbar-brand {
            font-weight: bold;
            color: #007bff;
        }
        .navbar-brand:hover {
            color: #0056b3;
        }
        .navbar-nav .nav-item .nav-link {
            color: #333;
        }
        .navbar-nav .nav-item .nav-link:hover {
            color: #007bff;
        }
        .btn-dashboard {
   
    top: 8px;
    right: 300px;
    z-index: 1000;
}
        .dropdown-menu-custom {
            min-width: 150px;
        }
        .dropdown-item:hover {
            background-color: #f1f1f1;
        }
        .dropdown-toggle::after {
            display: none; /* Hide the default arrow */
        }
        footer {
            background-color: #343a40;
            color: #fff;
            padding: 2rem 0;
            border-top: 1px solid #454d55;
            text-align: center;
        }
        footer a {
            color: #17a2b8;
            text-decoration: none;
        }
        footer a:hover {
            text-decoration: underline;
            color: #0d6efd;
        }
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        .footer-content p {
            margin: 0;
        }
        .footer-content p:first-child {
            margin-bottom: 1rem;
        }
        .footer-content p:last-child {
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="d-flex flex-column min-vh-100">
        <header class="navbar navbar-expand-lg navbar-light navbar-custom">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">Social Media</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        @if (Auth::check())
                            @if (Auth::user()->hasRole('superadmin'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('posts.index') }}">Manage Posts</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('posts.index') }}">Feed</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('users.index') }}">Manage Users</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('posts.myPosts') }}">View My Posts</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('posts.index') }}">Feed</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('posts.create') }}">Create Post</a>
                                </li>
                            @endif
                        @endif
                    </ul>
                    <div class="d-flex ms-auto">
                        @if (Auth::check())
                            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-dashboard">Dashboard</a>
                            <div class="dropdown ms-3">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-custom" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <div class="ms-3">
                                <a class="btn btn-primary" href="{{ route('login') }}">{{ __('Login') }}</a>
                                <a class="btn btn-secondary ms-2" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-grow-1">
            @yield('content')
        </main>

        <footer>
            <div class="footer-content">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
                <p>
                    <a href="{{ url('/privacy-policy') }}">Privacy Policy</a> |
                    <a href="{{ url('/terms-of-service') }}">Terms of Service</a>
                </p>
            </div>
        </footer>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    @stack('scripts')

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
