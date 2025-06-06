<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Styles -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('styles')
</head>

<body>
    <div class="d-flex flex-column flex-lg-row min-vh-100">
        <!-- Sidebar - Only show when user is authenticated -->

        <!-- Mobile Toggle Button -->
        @auth
            <button class="sidebar-toggle d-lg-none btn btn-dark position-fixed start-0 top-0 m-3 z-3" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
        @endauth
        
        @auth
            <aside class="sidebar bg-dark text-white p-3">
                <div class="sidebar-header mb-4">
                    <h4 class="text-center mb-0">{{ config('app.name') }}</h4>
                </div>
                <nav class="sidebar-nav">
                    <ul class="nav flex-column">
                        <!-- Main Section -->
                        <li class="nav-item">
                            <a href="{{ route('user.dashboard') }}"
                                class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                                <i class="fas fa-home me-3"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <!-- User Section -->
                        <div class="sidebar-section-title">User</div>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-user me-3"></i>
                                <span>Profile</span>
                            </a>
                        </li>

                        <!-- Admin Section -->
                        @if (auth()->user() && auth()->user()->role === 'admin')
                            <div class="sidebar-section-title">Administration</div>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-users-cog me-3"></i>
                                    <span>User Management</span>
                                    <i class="fas fa-chevron-down ms-auto"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-cog me-3"></i>
                                    <span>Settings</span>
                                </a>
                            </li>
                        @endif

                        <!-- Expert Section -->
                        @if (auth()->user() && auth()->user()->role === 'expert')
                            <div class="sidebar-section-title">Expert Tools</div>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-tasks me-3"></i>
                                    <span>Expert Panel</span>
                                    <i class="fas fa-chevron-down ms-auto"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-flask me-3"></i>
                                    <span>Sandbox</span>
                                    <div class="badge bg-info ms-2">New</div>
                                </a>
                            </li>
                        @endif

                        <!-- Logout -->
                        <li class="nav-item mt-auto">
                            <a href="{{ route('logout') }}" class="nav-link text-danger"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-3"></i>
                                <span>Logout</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </nav>
            </aside>
        @endauth

        <!-- Main Content -->
        <main class="flex-grow-1 p-4">
            @yield('content')
        </main>
    </div>

    @push('styles')
        <style>
            :root {
                --sidebar-width: 280px;
                --sidebar-bg: #1e293b;
                --sidebar-text: #e2e8f0;
                --sidebar-active-bg: rgba(255, 255, 255, 0.1);
                --sidebar-hover-bg: rgba(255, 255, 255, 0.05);
                --sidebar-section-color: #94a3b8;
                --sidebar-link-color: #ffffff;
                /* رنگ سفید برای لینک‌ها */
                --sidebar-link-hover-color: #ffffff;
                /* رنگ سفید هنگام هاور */
            }

            .sidebar .nav-link {
                display: flex;
                align-items: center;
                color: var(--sidebar-link-color) !important;
                /* اضافه کردن !important برای اطمینان از اعمال شدن */
                border-radius: 0.5rem;
                padding: 0.75rem 1.5rem;
                margin: 0.25rem 0;
                transition: all 0.2s ease;
                position: relative;
                text-decoration: none;
            }

            .sidebar .nav-link:hover {
                background-color: var(--sidebar-hover-bg);
                color: var(--sidebar-link-hover-color) !important;
                /* تغییر رنگ متن هنگام هاور */
            }

            .sidebar .nav-link.active {
                background-color: var(--sidebar-active-bg);
                color: var(--sidebar-link-hover-color) !important;
                /* تغییر رنگ متن برای لینک فعال */
                font-weight: 500;
            }

            .sidebar .nav-link.active::before {
                content: '';
                position: absolute;
                left: 0;
                top: 0;
                bottom: 0;
                width: 4px;
                background-color: #3b82f6;
                border-radius: 0 4px 4px 0;
            }

            .sidebar .nav-link i {
                width: 24px;
                text-align: center;
                font-size: 1.1rem;
            }

            .sidebar .badge {
                font-size: 0.65rem;
                padding: 0.25rem 0.5rem;
            }

            @media (max-width: 991.98px) {
                .sidebar {
                    width: 100%;
                    min-height: auto;
                    position: fixed;
                    bottom: 0;
                    left: 0;
                    right: 0;
                    z-index: 1000;
                    flex-direction: row;
                    padding: 0.5rem;
                }

                .sidebar-header,
                .sidebar-section-title {
                    display: none;
                }

                .sidebar-nav {
                    width: 100%;
                }

                .sidebar-nav ul {
                    flex-direction: row;
                    justify-content: space-around;
                }

                .sidebar .nav-link {
                    flex-direction: column;
                    padding: 0.5rem;
                    font-size: 0.75rem;
                    margin: 0;
                }

                .sidebar .nav-link i {
                    margin-bottom: 0.25rem;
                    margin-right: 0;
                }

                .sidebar .nav-link span {
                    display: none;
                }

                .sidebar .nav-link.active::before {
                    width: 100%;
                    height: 3px;
                    top: auto;
                    bottom: 0;
                    border-radius: 3px 3px 0 0;
                }

                main {
                    margin-bottom: 70px;
                }

                .sidebar .nav-link {
                    color: #fff !important;
                }
            }
        </style>
    @endpush
</body>

</html>
