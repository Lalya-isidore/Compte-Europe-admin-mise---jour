<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FlashCompte Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/support-widget.css') }}">
    <script src="{{ asset('js/support-widget.js') }}" defer></script>
    <style>
        :root {
            --sidebar-width: 280px;
            --primary-color: #4f46e5;
            --secondary-color: #f8fafc;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 0;
            z-index: 1000;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: white;
        }

        .sidebar-logo i {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .sidebar-logo span {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .sidebar-nav-item {
            margin: 0.25rem 0;
        }

        .sidebar-nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .sidebar-nav-link:hover,
        .sidebar-nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(5px);
        }

        .sidebar-nav-link i {
            width: 20px;
            margin-right: 0.75rem;
            font-size: 1rem;
        }

        .sidebar-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.45);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
            z-index: 900;
        }

        .sidebar-backdrop.is-active {
            opacity: 1;
            pointer-events: auto;
        }

        body.sidebar-open {
            overflow: hidden;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        .top-navbar {
            background: white;
            padding: 1rem 2rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        .breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
            font-size: 0.9rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .page-content {
            padding: 2rem;
        }

        .mobile-sidebar-toggle {
            display: none;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            background: white;
            color: var(--text-primary);
        }

        .mobile-sidebar-toggle:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.35);
        }

        .app-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            text-align: center;
            cursor: pointer;
        }

        .app-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .app-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
        }

        .app-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }

        .app-description {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.is-open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }

            .top-navbar {
                padding: 0.75rem 1rem;
            }

            .breadcrumb {
                display: none;
            }

            .page-content {
                padding: 1.25rem 1rem 2rem;
            }

            .mobile-sidebar-toggle {
                display: inline-flex;
            }
        }
    </style>
</head>
<body data-support-enabled="{{ auth()->check() ? '1' : '0' }}">
    <div class="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="sidebar-logo">
                <i class="fas fa-cube"></i>
                <span>FlashCompte</span>
            </a>
        </div>
        
        <nav class="sidebar-nav">
            <div class="sidebar-nav-item">
                <a href="{{ route('dashboard') }}" class="sidebar-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
            </div>
            
            <div class="sidebar-nav-item">
                <a href="{{ route('compte.view') }}" class="sidebar-nav-link {{ request()->routeIs('compte.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    Mon compte
                </a>
            </div>
            
            <div class="sidebar-nav-item">
                <a href="{{ route('recharge.index') }}" class="sidebar-nav-link {{ request()->routeIs('recharge.*') ? 'active' : '' }}">
                    <i class="fas fa-credit-card"></i>
                    Recharge
                </a>
            </div>
            
            <div class="sidebar-nav-item">
                <a href="{{ route('admin.index') }}" target="_blank" class="sidebar-nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i>
                    Administration
                </a>
            </div>
            
            <div class="sidebar-nav-item">
                <a href="{{ route('affiliation.index') }}" class="sidebar-nav-link {{ request()->routeIs('affiliation.*') ? 'active' : '' }}">
                    <i class="fas fa-handshake"></i>
                    Affiliation
                </a>
            </div>
            
            <div class="sidebar-nav-item mt-4">
                <a href="{{ route('logout') }}" class="sidebar-nav-link">
                    <i class="fas fa-sign-out-alt"></i>
                    Déconnexion
                </a>
            </div>
        </nav>
    </div>

    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <div class="main-content">
        <div class="top-navbar">
            <button type="button" class="mobile-sidebar-toggle" id="mobileSidebarToggle" aria-label="Afficher le menu">
                <i class="fas fa-bars"></i>
            </button>
            <nav class="breadcrumb">
                @yield('breadcrumb')
            </nav>
            
            <div class="user-info">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->prenom ?? 'U', 0, 1)) }}
                </div>
                <div>
                    <div class="fw-semibold">{{ Auth::user()->prenom ?? 'Utilisateur' }} {{ Auth::user()->nom ?? '' }}</div>
                    <div class="text-muted small">{{ Auth::user()->email ?? '' }}</div>
                    <div class="text-muted small">ID: {{ Auth::user()->id }}</div>
                </div>
            </div>
        </div>

        <!-- Messages d'erreur et de succès -->
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mx-3 mt-3" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Erreur :</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mx-3 mt-3" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <strong>Succès :</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show mx-3 mt-3" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Attention :</strong> {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show mx-3 mt-3" role="alert">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Info :</strong> {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="page-content">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/csrf-handler.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.querySelector('.sidebar');
            const toggleButton = document.getElementById('mobileSidebarToggle');
            const backdrop = document.getElementById('sidebarBackdrop');
            const links = document.querySelectorAll('.sidebar-nav-link');
            const setExpanded = (value) => {
                if (toggleButton) {
                    toggleButton.setAttribute('aria-expanded', value ? 'true' : 'false');
                }
            };
            const closeSidebar = () => {
                sidebar.classList.remove('is-open');
                backdrop.classList.remove('is-active');
                document.body.classList.remove('sidebar-open');
                setExpanded(false);
            };
            const openSidebar = () => {
                sidebar.classList.add('is-open');
                backdrop.classList.add('is-active');
                document.body.classList.add('sidebar-open');
                setExpanded(true);
            };

            if (toggleButton) {
                setExpanded(false);
                toggleButton.addEventListener('click', function () {
                    if (sidebar.classList.contains('is-open')) {
                        closeSidebar();
                    } else {
                        openSidebar();
                    }
                });
            }

            if (backdrop) {
                backdrop.addEventListener('click', closeSidebar);
            }

            document.addEventListener('keyup', function (event) {
                if (event.key === 'Escape') {
                    closeSidebar();
                }
            });

            links.forEach(function (link) {
                link.addEventListener('click', function () {
                    if (window.innerWidth <= 768) {
                        closeSidebar();
                    }
                });
            });

            window.addEventListener('resize', function () {
                if (window.innerWidth > 768) {
                    closeSidebar();
                }
            });

            // Auto-dismiss alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
    @yield('scripts')
</body>
</html>