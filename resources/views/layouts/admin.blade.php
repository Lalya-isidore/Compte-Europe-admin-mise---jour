<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FlashBilan Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/support-widget.css') }}">
    <script src="{{ asset('js/support-widget.js') }}" defer></script>
    <style>
        :root {
            --sidebar-width: 240px;
            --primary-color: #4f46e5;
            --secondary-color: #f8fafc;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
            --mobile-padding: 1rem;
        }

        @media (max-width: 991px) {
            :root {
                --sidebar-width: 220px;
            }
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            min-height: 100vh;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: min(var(--sidebar-width), 90vw);
            max-width: 320px;
            background: linear-gradient(180deg, #5b6be6 0%, #6c4fd5 65%, #7c3dbb 100%);
            padding: 0 0.5rem;
            z-index: 1000;
            overflow-y: auto;
            transition: transform 0.3s ease;
            border-radius: 0 24px 24px 0;
            box-shadow: 0 10px 40px rgba(83, 56, 181, 0.35);
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 999px;
        }

        .sidebar-header {
            padding: 1.75rem 1rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-profile {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .sidebar-avatar-large {
            width: 70px;
            height: 70px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            padding: 6px;
        }

        .sidebar-avatar-large img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
        }

        .sidebar-profile-info {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .sidebar-credit {
            font-weight: 600;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 1rem;
            text-shadow: 0 2px 6px rgba(0, 0, 0, 0.25);
        }

        .sidebar-credit i {
            font-size: 1.1rem;
            color: #ffe9a1;
        }

        .sidebar-username {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
            line-height: 1.15;
        }

        .sidebar-user-id {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.75rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.8);
            background: rgba(255, 255, 255, 0.18);
            padding: 0.25rem 0.55rem;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            align-self: flex-start;
        }

        .sidebar-nav {
            padding: 0.5rem 0 1rem;
        }

        .sidebar-nav-item {
            margin: 0.25rem 0;
        }

        .sidebar-nav-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.8rem 1.2rem;
            color: rgba(255, 255, 255, 0.92);
            text-decoration: none;
            transition: all 0.25s ease;
            border: none;
            background: none;
            width: 100%;
            border-radius: 12px;
            margin: 0.15rem 0.4rem;
        }

        .sidebar-link-main {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.98rem;
        }

        .sidebar-link-arrow {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.75);
        }

        .sidebar-nav-link:hover,
        .sidebar-nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            transform: translateX(6px);
        }

        .sidebar-nav-link i {
            width: 20px;
            margin-right: 0.75rem;
            font-size: 1.05rem;
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
            background: linear-gradient(135deg, #f7f9ff 0%, #ffffff 55%);
            border: 1px solid var(--border-color);
            border-radius: 26px;
            margin: 1.5rem 1.5rem 0;
            padding: 1.2rem 1.75rem;
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 1.5rem;
            box-shadow: 0 25px 60px rgba(15, 23, 42, 0.08);
        }

        .top-navbar__brand {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .brand-chip {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.65rem 0.9rem;
            background: rgba(99, 102, 241, 0.15);
            border-radius: 16px;
        }

        .brand-chip__logo {
            width: 46px;
            height: 46px;
            border-radius: 15px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #fff;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            letter-spacing: 1px;
            box-shadow: 0 6px 14px rgba(79, 70, 229, 0.35);
        }

        .brand-chip__logo i {
            font-size: 1.4rem;
        }

        .brand-chip__title {
            font-weight: 700;
            color: var(--text-primary);
        }

        .brand-chip__subtitle {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .top-navbar__breadcrumb {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .breadcrumb-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-secondary);
        }

        .breadcrumb {
            background: none;
            margin-bottom: 0;
            padding: 0;
            font-weight: 600;
        }

        .top-navbar__actions {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .hero-action {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.65rem 1.1rem;
            border-radius: 14px;
            border: 1px solid rgba(79, 70, 229, 0.3);
            background: rgba(79, 70, 229, 0.08);
            color: #312e81;
            font-weight: 600;
            text-decoration: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hero-action--accent {
            background: linear-gradient(135deg, #22d3ee, #4f46e5);
            color: #fff;
            border-color: transparent;
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.35);
        }

        .hero-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.1);
        }

        .page-content {
            padding: 2rem;
        }

        .mobile-sidebar-toggle {
            display: none;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            background: white;
            color: var(--text-primary);
            align-items: center;
            justify-content: center;
        }

        .mobile-sidebar-toggle:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.35);
        }
        .user-avatar {
            width: 56px;
            height: 56px;
            border-radius: 18px;
            border: 1px solid rgba(148, 163, 184, 0.5);
            background: #eef2ff;
            padding: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 14px;
        }

        .user-summary-card {
            display: none;
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

        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.is-open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
        }

        @media (max-width: 991px) {
            .top-navbar {
                grid-template-columns: 1fr;
                margin: 1rem;
                padding: 1rem 1.25rem;
            }

            .top-navbar__actions {
                flex-wrap: wrap;
            }

            .hero-action {
                flex: 1 1 180px;
                justify-content: center;
            }

            .page-content {
                padding: 1.25rem 1rem 2rem;
            }

            .mobile-sidebar-toggle {
                display: inline-flex;
            }

            .user-summary-card {
                margin: 1rem;
            }
        }

        @media (max-width: 575px) {
            .top-navbar {
                gap: 0.75rem;
            }

            .hero-action {
                flex: 1 1 140px;
                font-size: 0.92rem;
            }

            .user-summary-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .user-summary-card__stats {
                width: 100%;
            }

            .page-content {
                padding: var(--mobile-padding);
            }
        }
    </style>
</head>
<body data-support-enabled="{{ auth()->check() ? '1' : '0' }}">
    @php
        $currentUser = Auth::user();
        $userFirstName = $currentUser->prenom ?? 'Utilisateur';
        $userLastInitial = $currentUser && $currentUser->nom ? mb_substr($currentUser->nom, 0, 1) . '.' : '';
        $sidebarDisplayName = trim($userFirstName . ' ' . $userLastInitial);
        $sidebarInitial = strtoupper(mb_substr($currentUser->prenom ?: ($currentUser->nom ?? 'U'), 0, 1));
        $sidebarCredits = number_format($currentUser->credit_user ?? 0, 0, ',', ' ');
        $dashboardUrl = \Illuminate\Support\Facades\Route::has('dashboard') ? route('dashboard') : url('/');
        $tarifsUrl = \Illuminate\Support\Facades\Route::has('tarifs.index')
            ? route('tarifs.index')
            : (\Illuminate\Support\Facades\Route::has('recharge.index') ? route('recharge.index') : url('/'));
        $rechargeUrl = \Illuminate\Support\Facades\Route::has('recharge.index') ? route('recharge.index') : $tarifsUrl;
    @endphp
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-profile">
                <div class="sidebar-avatar-large">
                    <img src="{{ asset('images/avatar-default.svg') }}" alt="Avatar menu">
                </div>
                <div class="sidebar-profile-info">
                    <div class="sidebar-credit">
                        <i class="fas fa-coins"></i>
                        <span>{{ $sidebarCredits }} Crédit(s)</span>
                    </div>
                    <div class="sidebar-username">
                        <span>{{ $sidebarDisplayName }}</span>
                        <span class="sidebar-user-id">
                            <i class="fas fa-hashtag"></i>
                            ID {{ $currentUser->id ?? '—' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <nav class="sidebar-nav">
            <div class="sidebar-nav-item">
                <a href="{{ route('compte.view') }}" class="sidebar-nav-link {{ request()->routeIs('compte.*') ? 'active' : '' }}">
                    <div class="sidebar-link-main">
                        <i class="fas fa-user-circle"></i>
                        <span>Mon compte</span>
                    </div>
                </a>
            </div>
            
            <div class="sidebar-nav-item">
                <a href="{{ route('recharge.index') }}" class="sidebar-nav-link {{ request()->routeIs('recharge.*') ? 'active' : '' }}">
                    <div class="sidebar-link-main">
                        <i class="fas fa-wallet"></i>
                        <span>Recharge</span>
                    </div>
                    <span class="sidebar-link-arrow">&rarr;</span>
                </a>
            </div>
            
            <div class="sidebar-nav-item">
                <a href="{{ route('dashboard') }}" class="sidebar-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <div class="sidebar-link-main">
                        <i class="fas fa-briefcase"></i>
                        <span>Outils</span>
                    </div>
                </a>
            </div>
            
            <div class="sidebar-nav-item">
                <a href="{{ $tarifsUrl }}" class="sidebar-nav-link {{ request()->routeIs('tarifs.*') ? 'active' : '' }}">
                    <div class="sidebar-link-main">
                        <i class="fas fa-tags"></i>
                        <span>Tarifs</span>
                    </div>
                </a>
            </div>

            <div class="sidebar-nav-item">
                <a href="{{ route('affiliation.index') }}" class="sidebar-nav-link {{ request()->routeIs('affiliation.*') ? 'active' : '' }}">
                    <div class="sidebar-link-main">
                        <i class="fas fa-users"></i>
                        <span>Affiliation</span>
                    </div>
                </a>
            </div>

            @if (\Illuminate\Support\Facades\Route::has('admin.index'))
            <div class="sidebar-nav-item">
                <a href="{{ route('admin.index') }}" target="_blank" rel="noopener noreferrer" class="sidebar-nav-link {{ request()->is('admin*') ? 'active' : '' }}">
                    <div class="sidebar-link-main">
                        <i class="fas fa-shield-alt"></i>
                        <span>Administration</span>
                    </div>
                </a>
            </div>
            @endif
            
            <div class="sidebar-nav-item mt-4">
                <a href="{{ route('logout') }}" class="sidebar-nav-link">
                    <div class="sidebar-link-main">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Déconnexion</span>
                    </div>
                </a>
            </div>
        </nav>
    </div>

    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <div class="main-content">
        <div class="top-navbar">
            <div class="top-navbar__brand">
                <button type="button" class="mobile-sidebar-toggle" id="mobileSidebarToggle" aria-label="Afficher le menu">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="brand-chip">
                    <div class="brand-chip__logo" aria-hidden="true">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <div>
                        <div class="brand-chip__title">{{ config('app.name', 'FlashBilan') }}</div>
                        <div class="brand-chip__subtitle">Centre d'outils sécurisé</div>
                    </div>
                </div>
            </div>

            <div class="top-navbar__breadcrumb">
                <span class="breadcrumb-label">Navigation</span>
                <nav class="breadcrumb">
                    @yield('breadcrumb')
                </nav>
            </div>

            <div class="top-navbar__actions">
                <a href="{{ $dashboardUrl }}" class="hero-action">
                    <i class="fas fa-grip"></i>
                    <span>Liste des outils</span>
                </a>
                <a href="{{ $rechargeUrl }}" class="hero-action hero-action--accent">
                    <i class="fas fa-bolt"></i>
                    <span>Recharge rapide</span>
                </a>
            </div>
        </div>

        <div class="user-summary-card">
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
            const mobileBreakpoint = 991;
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
                    if (window.innerWidth <= mobileBreakpoint) {
                        closeSidebar();
                    }
                });
            });

            window.addEventListener('resize', function () {
                if (window.innerWidth > mobileBreakpoint) {
                    closeSidebar();
                }
            });

            // Auto-dismiss only the dismissible alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert.alert-dismissible');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
    @stack('scripts')
    @yield('scripts')
</body>
</html>
