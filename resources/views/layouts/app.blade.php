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

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('styles') <!-- For additional CSS -->
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
        .dropdown-menu-custom {
            min-width: 150px;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .btn-dashboard {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <div class="d-flex flex-column min-vh-100">
        <header class="navbar navbar-expand-lg navbar-light navbar-custom">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">Social Media</a>
                <div class="d-flex ml-auto">
                    @if (Auth::check())
                        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-dashboard">Dashboard</a>
                    @endif
                    <div class="dropdown ms-3">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            @if (Auth::check())
                                {{ Auth::user()->name }}
                            @else
                                Guest
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-custom" aria-labelledby="dropdownMenuButton">
                            @if (Auth::check())
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
                            @else
                                <li><a class="dropdown-item" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-grow-1">
            @yield('content')
        </main>
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
