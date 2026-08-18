<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Voting System') }}</title>

        <!-- Google Fonts: Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Bootstrap CSS & Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

        <style>
            :root {
                --bs-font-sans-serif: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                --bs-body-font-family: var(--bs-font-sans-serif);
                --bs-body-bg: #f8fafc;
                --bs-body-color: #1e293b;
                --primary-gradient: linear-gradient(135deg, #2563eb, #1d4ed8);
                --card-border-radius: 14px;
            }

            body {
                font-family: var(--bs-font-sans-serif);
                background-color: var(--bs-body-bg);
                color: var(--bs-body-color);
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            main {
                flex: 1 0 auto;
            }

            /* Navbar Polish */
            .navbar-custom {
                background: #0f172a;
                border-bottom: 1px solid rgba(255, 255, 255, 0.08);
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            }

            .navbar-brand {
                font-size: 1.25rem;
                letter-spacing: -0.02em;
            }

            .navbar-brand-icon {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 34px;
                height: 34px;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 8px;
                font-size: 1.1rem;
            }

            .nav-link {
                font-weight: 500;
                font-size: 0.935rem;
                padding: 0.5rem 0.85rem !important;
                border-radius: 8px;
                transition: all 0.15s ease;
                color: #cbd5e1 !important;
            }

            .nav-link:hover {
                color: #ffffff !important;
                background: rgba(255, 255, 255, 0.08);
            }

            .nav-link.active-nav {
                color: #ffffff !important;
                background: rgba(255, 255, 255, 0.15);
                font-weight: 600;
            }

            .dropdown-menu {
                border: 1px solid rgba(0, 0, 0, 0.08);
                border-radius: 12px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
                padding: 0.5rem;
            }

            .dropdown-item {
                border-radius: 6px;
                padding: 0.5rem 0.85rem;
                font-size: 0.9rem;
                font-weight: 500;
                transition: all 0.15s ease;
            }

            .dropdown-item:hover {
                background-color: #f1f5f9;
                color: #0f172a;
            }

            /* Cards & Panels */
            .card {
                border: 1px solid #e2e8f0;
                border-radius: var(--card-border-radius);
                background-color: #ffffff;
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.04), 0 1px 2px -1px rgba(0, 0, 0, 0.04);
                transition: box-shadow 0.2s ease, transform 0.2s ease;
            }

            .card.hover-lift:hover {
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
                transform: translateY(-2px);
            }

            .card-header {
                background-color: #ffffff;
                border-bottom: 1px solid #f1f5f9;
                padding: 1.15rem 1.35rem;
                border-top-left-radius: var(--card-border-radius) !important;
                border-top-right-radius: var(--card-border-radius) !important;
            }

            .card-body {
                padding: 1.35rem;
            }

            /* Buttons */
            .btn {
                font-weight: 500;
                font-size: 0.925rem;
                border-radius: 8px;
                padding: 0.5rem 1rem;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 0.35rem;
                transition: all 0.15s ease-in-out;
            }

            .btn-sm {
                padding: 0.35rem 0.75rem;
                font-size: 0.84rem;
                border-radius: 6px;
            }

            .btn-lg {
                padding: 0.75rem 1.5rem;
                font-size: 1.05rem;
                border-radius: 10px;
            }

            .btn:active {
                transform: scale(0.98);
            }

            .btn-primary {
                background-color: #2563eb;
                border-color: #2563eb;
                box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
            }

            .btn-primary:hover {
                background-color: #1d4ed8;
                border-color: #1d4ed8;
                box-shadow: 0 4px 8px rgba(37, 99, 235, 0.3);
            }

            .btn-success {
                background-color: #10b981;
                border-color: #10b981;
                box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
            }

            .btn-success:hover {
                background-color: #059669;
                border-color: #059669;
            }

            /* Forms */
            .form-control, .form-select {
                border: 1px solid #cbd5e1;
                border-radius: 8px;
                padding: 0.6rem 0.85rem;
                font-size: 0.95rem;
                color: #1e293b;
                transition: border-color 0.15s ease, box-shadow 0.15s ease;
            }

            .form-control:focus, .form-select:focus {
                border-color: #3b82f6;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
            }

            .form-label {
                font-weight: 500;
                font-size: 0.875rem;
                color: #334155;
                margin-bottom: 0.35rem;
            }

            /* Badges */
            .badge {
                font-weight: 600;
                padding: 0.35em 0.7em;
                border-radius: 6px;
                letter-spacing: 0.01em;
            }

            .badge.bg-success { background-color: #10b981 !important; }
            .badge.bg-primary { background-color: #2563eb !important; }
            .badge.bg-info { background-color: #0284c7 !important; color: #fff !important; }
            .badge.bg-secondary { background-color: #64748b !important; }
            .badge.bg-warning { background-color: #f59e0b !important; color: #fff !important; }

            /* Tables */
            .table {
                vertical-align: middle;
            }

            .table thead th {
                font-size: 0.8rem;
                text-transform: uppercase;
                letter-spacing: 0.04em;
                font-weight: 600;
                color: #64748b;
                background-color: #f8fafc;
                border-bottom: 1px solid #e2e8f0;
                padding: 0.85rem 1rem;
            }

            .table tbody td {
                padding: 0.9rem 1rem;
                border-bottom: 1px solid #f1f5f9;
                font-size: 0.92rem;
            }

            .table-hover tbody tr:hover {
                background-color: #f8fafc;
            }

            /* Alerts */
            .alert {
                border-radius: 10px;
                border-width: 1px;
                font-size: 0.925rem;
            }

            .alert-success {
                background-color: #f0fdf4;
                border-color: #bbf7d0;
                color: #166534;
            }

            .alert-danger {
                background-color: #fef2f2;
                border-color: #fecaca;
                color: #991b1b;
            }

            .alert-info {
                background-color: #f0f9ff;
                border-color: #bae6fd;
                color: #0369a1;
            }

            .alert-warning {
                background-color: #fffbeb;
                border-color: #fde68a;
                color: #92400e;
            }

            /* Stat Cards */
            .stat-card {
                border: 0;
                border-radius: var(--card-border-radius);
                color: #ffffff;
                position: relative;
                overflow: hidden;
            }

            .stat-card .stat-icon {
                position: absolute;
                right: 15px;
                bottom: 10px;
                font-size: 3.5rem;
                opacity: 0.15;
            }

            .stat-card-blue { background: linear-gradient(135deg, #2563eb, #1d4ed8); }
            .stat-card-green { background: linear-gradient(135deg, #10b981, #059669); }
            .stat-card-teal { background: linear-gradient(135deg, #0284c7, #0369a1); }
            .stat-card-amber { background: linear-gradient(135deg, #f59e0b, #d97706); }

            /* Footer */
            footer {
                background: #0f172a;
                border-top: 1px solid rgba(255, 255, 255, 0.08);
            }
        </style>

        @stack('styles')
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
            <div class="container">
                <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('home') }}">
                    <span class="navbar-brand-icon">🗳️</span>
                    <span>Voting System</span>
                </a>
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-lg-center gap-1">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active-nav' : '' }}" href="{{ route('dashboard') }}">
                                    <i class="bi bi-grid me-1"></i> Dashboard
                                </a>
                            </li>
                            @if(auth()->user()->isAdmin())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('elections.*') ? 'active-nav' : '' }}" href="{{ route('elections.index') }}">
                                        <i class="bi bi-box-seam me-1"></i> Elections
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('reports.*') ? 'active-nav' : '' }}" href="{{ route('reports.analytics') }}">
                                        <i class="bi bi-graph-up me-1"></i> Analytics
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item dropdown ms-lg-2">
                                <a class="nav-link dropdown-toggle d-flex align-items-center gap-1 py-1" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-person-circle fs-5"></i>
                                    <span>{{ auth()->user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userDropdown">
                                    <li class="px-3 py-2 border-bottom">
                                        <div class="fw-bold text-dark">{{ auth()->user()->name }}</div>
                                        <small class="text-muted text-capitalize">{{ auth()->user()->role }}</small>
                                    </li>
                                    <li>
                                        <a class="dropdown-item mt-1" href="{{ route('profile') }}">
                                            <i class="bi bi-person me-2 text-primary"></i>My Profile
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-1"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('login') ? 'active-nav' : '' }}" href="{{ route('login') }}">
                                    <i class="bi bi-box-arrow-in-right me-1"></i> Login
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-primary btn-sm ms-lg-2" href="{{ route('register') }}">
                                    <i class="bi bi-person-plus me-1"></i> Register
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 shadow-sm" role="alert">
                        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                        <div>
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 shadow-sm" role="alert">
                        <i class="bi bi-check-circle-fill fs-5"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('status'))
                    <div class="alert alert-info alert-dismissible fade show d-flex align-items-center gap-2 shadow-sm" role="alert">
                        <i class="bi bi-info-circle-fill fs-5"></i>
                        <div>{{ session('status') }}</div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        <footer class="text-light py-4 mt-auto">
            <div class="container">
                <div class="row align-items-center gy-2">
                    <div class="col-md-6 text-center text-md-start">
                        <p class="mb-0 text-secondary">&copy; {{ date('Y') }} Voting System. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <a href="{{ route('home') }}#contributors" class="text-secondary text-decoration-none me-3 hover-white">
                            <i class="bi bi-people me-1"></i> Contributors
                        </a>
                        <a href="https://github.com" class="text-secondary text-decoration-none hover-white" target="_blank" rel="noopener">
                            <i class="bi bi-github me-1"></i> GitHub
                        </a>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        @stack('scripts')
    </body>
</html>
