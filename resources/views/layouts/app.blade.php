<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        @auth
            <aside class="sidebar" id="mobileSidebar">
                <div class="sidebar-header">
                    <h4>{{ config('app.name', 'Your App') }}</h4>
                </div>
                <nav class="sidebar-nav">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{ route('user.dashboard') }}"
                                class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                                <i class="fas fa-home me-3"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('user.expertise') }}"
                                class="nav-link {{ request()->routeIs('user.expertise') ? 'active' : '' }}">
                                <i class="fas fa-address-card me-3"></i>
                                <span>Add my expertise</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-user me-3"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                        @if (auth()->user() && auth()->user()->role === 'admin')
                            <div class="sidebar-section-title mt-4">Administration</div>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-users-cog me-3"></i>
                                    <span>User Management</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-cog me-3"></i>
                                    <span>Settings</span>
                                </a>
                            </li>
                        @endif

                    </ul>
                </nav>
                <div class="mt-auto">
                    <li class="nav-item list-unstyled"> <a href="{{ route('logout') }}" class="nav-link text-danger"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-3"></i>
                            <span>Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </div>
            </aside>
        @endauth

        @auth
            <button class="sidebar-toggle d-lg-none p-3" id="sidebarToggle">
                <i class="fas fa-bars fa-lg"></i>
            </button>
        @endauth

        <main class="main-content">
            <div class="content-wrapper"> @yield('content')
            </div>
        </main>
    </div>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>
