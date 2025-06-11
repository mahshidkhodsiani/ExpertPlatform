<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


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
                            <a href="{{ route('user.expertise.show') }}"
                                class="nav-link {{ request()->routeIs('user.expertise.show') ? 'active' : '' }}">
                                <i class="fas fa-list me-3"></i>
                                <span>Show my expertises</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('expertises.show') }}"
                                class="nav-link {{ request()->routeIs('expertises.show') ? 'active' : '' }}">
                                <i class="fas fa-list-check me-3"></i>
                                <span>Show all expertises</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('user.profile') }}"
                                class="nav-link {{ request()->routeIs('user.profile') ? 'active' : '' }}">
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



    @if (session('toast'))
        <div id="custom-toast" class="toast fade" role="alert" aria-live="assertive" aria-atomic="true"
            style="position: fixed; top: 25px; right: 25px; min-width: 300px; z-index: 9999; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
            <div class="toast-header d-flex justify-content-between align-items-center"
                style="background: linear-gradient(135deg, {{ session('toast.type') == 'success' ? '#28a745' : '#dc3545' }} 0%, {{ session('toast.type') == 'success' ? '#218838' : '#c82333' }} 100%); border-radius: 5px 5px 0 0; color: white;">
                <div class="d-flex align-items-center">
                    <svg class="bi flex-shrink-0 me-2" width="20" height="20" fill="currentColor"
                        viewBox="0 0 16 16">
                        @if (session('toast.type') == 'success')
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        @else
                            <path
                                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                        @endif
                    </svg>
                    <strong class="me-auto">{{ session('toast.title') }}</strong>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
            <div class="toast-body" style="background-color: #f8f9fa; border-radius: 0 0 5px 5px;">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        {{ session('toast.message') }}
                    </div>
                </div>
            </div>
        </div>

        <style>
            .toast {
                opacity: 1;
                transition: all 0.3s ease;
            }

            .toast.fade {
                opacity: 0;
            }

            .toast.show {
                opacity: 1;
                transform: translateX(0) !important;
            }

            #custom-toast {
                transform: translateX(100%);
            }
        </style>

        <script>
            $(document).ready(function() {
                const toast = $('#custom-toast');

                toast.toast({
                    animation: false,
                    autohide: true,
                    delay: 3000
                });

                // Animation in
                toast.addClass('show');
                toast.css('transform', 'translateX(0)');

                // Animation out before hiding
                toast.on('hide.bs.toast', function() {
                    toast.css('transform', 'translateX(100%)');
                    setTimeout(() => toast.remove(), 300);
                });

                toast.toast('show');
            });
        </script>
    @endif


</body>

</html>
