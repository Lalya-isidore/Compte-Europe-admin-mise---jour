<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', app('region')->appName() . ' Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&family=Righteous&family=Cabin:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/support-widget.css') }}">
    <script src="{{ asset('js/support-widget.js') }}" defer></script>
    
    <!-- PWA Meta Tags -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#0d6efd">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Compte Europe Pro">
    <link rel="apple-touch-icon" href="{{ asset('icon-192.png') }}">
    <style>
        :root {
            --sidebar-width: 220px;
            --bg-page: #f5f3ef;
            --bg-sidebar: #ffffff;
            --bg-card: #ffffff;
            --text-primary: #333333;
            --text-secondary: #888888;
            --border-color: #e8e8e8;
            --accent-blue: #2196F3;
            --credit-red: #e53935;
            --mobile-padding: 1rem;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-page);
            min-height: 100vh;
            margin: 0;
        }

        /* ========== SIDEBAR ========== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            max-width: 320px;
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border-color);
            z-index: 1000;
            overflow-y: auto;
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: #ddd; border-radius: 999px; }

        /* Logo */
        .sidebar-logo {
            padding: 0.85rem 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-logo a {
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sidebar-logo-icon {
            width: 34px;
            height: 34px;
            background: linear-gradient(135deg, #FF6B35, #F7C948, #4ECDC4, #6C5CE7);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-logo-icon i {
            color: white;
            font-size: 1rem;
        }

        .sidebar-logo-text {
            font-family: 'Righteous', cursive;
            font-size: 1.2rem;
            color: var(--text-primary);
        }

        .sidebar-logo-text span {
            color: #e53935;
        }

        /* User profile */
        .sidebar-user {
            padding: 0.85rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-avatar {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
            background: #f0f0f0;
        }

        .sidebar-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .sidebar-user-info {
            display: flex;
            flex-direction: column;
            gap: 0.1rem;
            min-width: 0;
        }

        .sidebar-credit {
            display: flex;
            align-items: center;
            gap: 0.3rem;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--credit-red);
        }

        .sidebar-credit i {
            font-size: 0.85rem;
        }

        .sidebar-username {
            font-size: 0.8rem;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .sidebar-username i { font-size: 0.75rem; }

        /* Navigation */
        .sidebar-nav {
            flex: 1;
            padding: 0.5rem 0;
        }

        .sidebar-nav-item {
            position: relative;
        }

        .sidebar-nav-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1rem;
            color: #374151;
            text-decoration: none;
            font-family: 'Inter', -apple-system, sans-serif;
            font-size: 0.95rem;
            font-weight: 450;
            letter-spacing: -0.01em;
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
        }

        .sidebar-nav-link:hover {
            background: #f8f8f8;
            color: var(--text-primary);
        }

        .sidebar-nav-link.active {
            border-left-color: var(--accent-blue);
            background: #f0f7ff;
            color: var(--accent-blue);
            font-weight: 500;
        }

        .sidebar-link-main {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-nav-link i {
            width: 20px;
            text-align: center;
            font-size: 1.05rem;
            color: inherit;
        }

        .sidebar-link-arrow {
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .sidebar-nav-link.active .sidebar-link-arrow {
            color: var(--accent-blue);
        }

        .sidebar-logout {
            border-top: 1px solid var(--border-color);
            padding: 0.5rem 0;
        }

        /* Backdrop mobile */
        .sidebar-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
            z-index: 900;
        }

        .sidebar-backdrop.is-active {
            opacity: 1;
            pointer-events: auto;
        }

        body.sidebar-open { overflow: hidden; }

        /* ========== MAIN CONTENT ========== */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        /* Top header bar */
        .top-header {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, #fef3e2 0%, #fde8d0 100%);
            border-bottom: 1px solid rgba(245,166,35,.12);
            position: sticky;
            top: 0;
            z-index: 1020;
        }
        .top-header__left {
            display: none;
            align-items: center;
            gap: 0.6rem;
        }
        .top-header__logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }
        .top-header__menu {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            background: #fff;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1.2rem;
        }
        .top-header__actions {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        .top-header__btn {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            font-size: 1.4rem;
            text-decoration: none;
            transition: all 0.2s ease;
            background: #fff;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 8px rgba(0,0,0,.04);
        }
        .top-header__btn:hover {
            color: var(--accent-blue);
            border-color: var(--accent-blue);
            background: #f0f7ff;
        }
        .top-header__btn.active {
            color: #fff;
            background: var(--accent-blue);
            border-color: var(--accent-blue);
            box-shadow: 0 4px 12px rgba(33,150,243,.25);
        }
        .top-header__btn--toggle {
            color: #fff;
            background: var(--accent-blue);
            border-color: var(--accent-blue);
            box-shadow: 0 4px 12px rgba(33,150,243,.25);
            cursor: pointer;
        }
        .top-header__btn--toggle:hover {
            background: #1976d2;
            border-color: #1976d2;
        }
        .top-header__btn--logout {
            color: #e53935;
            background: #fff5f5;
            border-color: #fed7d7;
        }
        .top-header__btn--logout:hover {
            color: #fff;
            background: #e53935;
            border-color: #e53935;
            box-shadow: 0 4px 12px rgba(229,57,53,.25);
        }

        /* Breadcrumb bar */
        .breadcrumb-bar {
            background: var(--bg-card);
            border-radius: 14px;
            margin: 1rem 1.5rem 0;
            padding: 0.85rem 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,.03);
            border: 1px solid var(--border-color);
        }

        .breadcrumb-bar .breadcrumb {
            margin: 0;
            padding: 0;
            background: none;
            font-size: 0.95rem;
        }

        .breadcrumb-bar .breadcrumb-item a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .breadcrumb-bar .breadcrumb-item a:hover {
            color: var(--primary);
            text-decoration: underline;
        }

        .breadcrumb-bar .breadcrumb-item.active {
            color: var(--text-primary);
            font-weight: 600;
        }

        .breadcrumb-bar .breadcrumb-item + .breadcrumb-item::before {
            content: ">";
            color: var(--text-secondary);
        }

        .breadcrumb-bar .breadcrumb-item i {
            font-size: 0.85rem;
        }

        /* Page content */
        .page-content {
            padding: 1rem 0.75rem;
        }

        /* Mobile toggle */
        .mobile-sidebar-toggle {
            display: none;
            width: 44px;
            height: 44px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            background: white;
            color: var(--text-primary);
            align-items: center;
            justify-content: center;
            cursor: pointer;
            margin-right: 0.75rem;
        }

        .mobile-sidebar-toggle:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.3);
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 991px) {
            :root { --sidebar-width: 260px; }

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.is-open {
                transform: translateX(0);
                box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
            }

            .main-content {
                margin-left: 0;
            }

            .top-header {
                justify-content: space-between;
                padding: 0.75rem 1rem;
            }
            .top-header__left {
                display: flex;
            }
            .top-header__btn {
                width: 44px;
                height: 44px;
            }

            .breadcrumb-bar {
                padding: 0.75rem 1rem;
                margin: 0.75rem 0.75rem 0;
            }

            .page-content {
                padding: 1.25rem 1rem;
            }
        }

        @media (max-width: 575px) {
            .page-content {
                padding: var(--mobile-padding);
            }
            .page-content.page-flush {
                padding: 0;
            }
            .page-content.page-flush, .page-content.page-flush * {
                font-family: 'Cabin', sans-serif !important;
            }

            .breadcrumb-bar {
                padding: 0.6rem 0.75rem;
            }
        }

        #pwa-install-banner {
            display: none;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 95%;
            max-width: 450px;
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
            padding: 14px 18px;
            border-radius: 20px;
            box-shadow: 0 15px 45px rgba(13, 110, 253, 0.4);
            z-index: 99999;
            align-items: center;
            gap: 15px;
            animation: slideDown 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes slideDown {
            from { transform: translate(-50%, -120px); opacity: 0; }
            to { transform: translate(-50%, 0); opacity: 1; }
        }

        .pwa-icon {
            width: 54px;
            height: 54px;
            border-radius: 14px;
            background: white;
            padding: 2px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .pwa-text {
            flex: 1;
        }

        .pwa-text h4 {
            margin: 0;
            font-size: 1.05rem;
            font-weight: 800;
            color: white !important;
        }

        .pwa-text p {
            margin: 4px 0 0;
            font-size: 0.82rem;
            opacity: 0.95;
            line-height: 1.2;
            color: white !important;
        }

        .pwa-btn {
            background: white;
            color: #0d6efd;
            border: none;
            padding: 10px 18px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(255,255,255,0.2);
            white-space: nowrap;
        }

        .pwa-btn:active {
            transform: scale(0.95);
        }

        .pwa-close {
            background: transparent;
            color: rgba(255,255,255,0.7);
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 5px;
            line-height: 1;
        }
    </style>
</head>
<body data-support-enabled="{{ auth()->check() ? '1' : '0' }}">
    <!-- PWA Install Banner -->
    <div id="pwa-install-banner">
        <img src="{{ asset('images/logo-premium.png') }}" alt="FlashBilan" class="pwa-icon" style="height: 48px; width: auto; object-fit: contain; border-radius: 10px;">
        <div class="pwa-text">
            <h4>Application Mobile</h4>
            <p id="pwa-desc">Téléchargez l'application pour un accès rapide.</p>
        </div>
        <button id="pwa-install-btn" class="pwa-btn">Installer</button>
        <button id="pwa-close-btn" class="pwa-close">&times;</button>
    </div>
    @php
        $currentUser = Auth::user();
        $userFirstName = $currentUser->prenom ?? 'Utilisateur';
        $userLastInitial = $currentUser && $currentUser->nom ? mb_substr($currentUser->nom, 0, 1) . '.' : '';
        $sidebarDisplayName = trim($userFirstName . ' ' . $userLastInitial);
        $sidebarCredits = number_format($currentUser->credit_user ?? 0, 0, ',', ' ');
        $dashboardUrl = \Illuminate\Support\Facades\Route::has('dashboard') ? route('dashboard') : url('/');
        $tarifsUrl = \Illuminate\Support\Facades\Route::has('tarifs.index')
            ? route('tarifs.index')
            : (\Illuminate\Support\Facades\Route::has('recharge.index') ? route('recharge.index') : url('/'));
        $rechargeUrl = \Illuminate\Support\Facades\Route::has('recharge.index') ? route('recharge.index') : $tarifsUrl;
    @endphp

    {{-- SIDEBAR --}}
    <div class="sidebar">
        {{-- Logo --}}
        <div class="sidebar-logo">
            <a href="{{ $dashboardUrl }}">
                <div class="sidebar-logo-icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div class="sidebar-logo-text">Flash<span>Bilan</span></div>
            </a>
        </div>

        {{-- User --}}
        <div class="sidebar-user">
            <div class="sidebar-avatar">
                <img src="{{ asset('images/avatar-default.svg') }}" alt="Avatar">
            </div>
            <div class="sidebar-user-info">
                <div class="sidebar-credit">
                    <i class="ri-copper-coin-line"></i>
                    {{ $sidebarCredits }} Credit(s)
                </div>
                <div class="sidebar-username">
                    <i class="ri-user-3-line"></i>
                    {{ $sidebarDisplayName }}
                </div>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="sidebar-nav">
            <div class="sidebar-nav-item">
                <a href="{{ route('compte.view') }}" class="sidebar-nav-link {{ request()->routeIs('compte.*') ? 'active' : '' }}">
                    <div class="sidebar-link-main">
                        <i class="ri-user-line"></i>
                        <span>Mon compte</span>
                    </div>
                </a>
            </div>

            <div class="sidebar-nav-item">
                <a href="{{ route('recharge.index') }}" class="sidebar-nav-link {{ request()->routeIs('recharge.*') ? 'active' : '' }}">
                    <div class="sidebar-link-main">
                        <i class="ri-wallet-line"></i>
                        <span>Recharge</span>
                    </div>
                    <span class="sidebar-link-arrow">&rarr;</span>
                </a>
            </div>

            <div class="sidebar-nav-item">
                <a href="{{ route('dashboard') }}" class="sidebar-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <div class="sidebar-link-main">
                        <i class="ri-briefcase-line"></i>
                        <span>Outils</span>
                    </div>
                </a>
            </div>

            <div class="sidebar-nav-item">
                <a href="{{ $tarifsUrl }}" class="sidebar-nav-link {{ request()->routeIs('tarifs.*') ? 'active' : '' }}">
                    <div class="sidebar-link-main">
                        <i class="ri-price-tag-3-line"></i>
                        <span>Tarifs</span>
                    </div>
                </a>
            </div>

            <div class="sidebar-nav-item">
                <a href="{{ route('affiliation.index') }}" class="sidebar-nav-link {{ request()->routeIs('affiliation.*') ? 'active' : '' }}">
                    <div class="sidebar-link-main">
                        <i class="ri-team-line"></i>
                        <span>Affiliation</span>
                    </div>
                </a>
            </div>

        </nav>

        {{-- Logout --}}
        <div class="sidebar-logout">
            <div class="sidebar-nav-item">
                <a href="{{ route('logout') }}" class="sidebar-nav-link">
                    <div class="sidebar-link-main">
                        <i class="ri-logout-box-r-line"></i>
                        <span>Deconnexion</span>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    {{-- MAIN --}}
    <div class="main-content">
        {{-- Top header bar --}}
        <div class="top-header">
            <div class="top-header__left">
                <a href="{{ $dashboardUrl }}" class="top-header__logo">
                    <div class="sidebar-logo-icon"><i class="fas fa-chart-pie"></i></div>
                    <div class="sidebar-logo-text">Flash<span>Bilan</span></div>
                </a>
            </div>
            <div class="top-header__actions">
                <button type="button" class="top-header__btn top-header__btn--toggle" id="topHeaderToggle" title="Menu / Outils">
                    <i class="ri-apps-2-line" id="topHeaderToggleIcon"></i>
                </button>
                <a href="{{ route('logout') }}" class="top-header__btn top-header__btn--logout" title="Deconnexion">
                    <i class="ri-logout-box-r-line"></i>
                </a>
            </div>
        </div>

        {{-- Breadcrumb --}}
        <div class="breadcrumb-bar" @if(!trim($__env->yieldContent('breadcrumb'))) style="display:none" @endif>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ $dashboardUrl }}"><i class="ri-home-4-line"></i></a></li>
                        @yield('breadcrumb')
                    </ol>
                </nav>
            </div>
        </div>

        {{-- Alerts --}}
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

        <div class="page-content @yield('page-class')">
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
                if (toggleButton) toggleButton.setAttribute('aria-expanded', value ? 'true' : 'false');
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
                    sidebar.classList.contains('is-open') ? closeSidebar() : openSidebar();
                });
            }

            // Top header toggle button (blue grid icon)
            const topToggle = document.getElementById('topHeaderToggle');
            const topToggleIcon = document.getElementById('topHeaderToggleIcon');
            const updateToggleIcon = () => {
                if (!topToggleIcon) return;
                if (sidebar.classList.contains('is-open')) {
                    topToggleIcon.className = 'ri-close-line';
                } else {
                    topToggleIcon.className = 'ri-apps-2-line';
                }
            };
            if (topToggle) {
                topToggle.addEventListener('click', function () {
                    if (window.innerWidth <= mobileBreakpoint) {
                        sidebar.classList.contains('is-open') ? closeSidebar() : openSidebar();
                        updateToggleIcon();
                    } else {
                        window.location.href = '{{ route("dashboard") }}';
                    }
                });
            }

            // Update icon when sidebar closes by other means
            const origClose = closeSidebar;
            const origOpen = openSidebar;

            if (backdrop) backdrop.addEventListener('click', function() { closeSidebar(); updateToggleIcon(); });

            document.addEventListener('keyup', function (e) {
                if (e.key === 'Escape') { closeSidebar(); updateToggleIcon(); }
            });

            links.forEach(function (link) {
                link.addEventListener('click', function () {
                    if (window.innerWidth <= mobileBreakpoint) { closeSidebar(); updateToggleIcon(); }
                });
            });

            window.addEventListener('resize', function () {
                if (window.innerWidth > mobileBreakpoint) { closeSidebar(); updateToggleIcon(); }
            });

            // Auto-dismiss alerts
            document.querySelectorAll('.alert.alert-dismissible').forEach(function(alert) {
                setTimeout(function() {
                    new bootstrap.Alert(alert).close();
                }, 5000);
            });
        });

        // PWA Install Logic
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('Service Worker registered', reg))
                    .catch(err => console.log('Service Worker not registered', err));
            });
        }

        let deferredPrompt;
        const pwaBanner = document.getElementById('pwa-install-banner');
        const installBtn = document.getElementById('pwa-install-btn');
        const closeBtn = document.getElementById('pwa-close-btn');

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            const isStandalone = window.matchMedia('(display-mode: standalone)').matches;
            const isDismissed = sessionStorage.getItem('pwa-banner-dismissed');
            
            if (!isStandalone && !isDismissed) {
                pwaBanner.style.display = 'flex';
            }
        });

        // Detection for iOS
        const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
        const isStandalone = window.navigator.standalone === true || window.matchMedia('(display-mode: standalone)').matches;
        const isDismissed = sessionStorage.getItem('pwa-banner-dismissed');

        if (isIOS && !isStandalone && !isDismissed) {
            pwaBanner.style.display = 'flex';
            document.getElementById('pwa-desc').innerText = "Appuyez sur Partager puis 'Sur l'écran d'accueil'";
            installBtn.style.display = 'none';
        }

        if (installBtn) {
            installBtn.addEventListener('click', async () => {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    const { outcome } = await deferredPrompt.userChoice;
                    if (outcome === 'accepted') {
                        pwaBanner.style.display = 'none';
                    }
                    deferredPrompt = null;
                }
            });
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                pwaBanner.style.display = 'none';
                sessionStorage.setItem('pwa-banner-dismissed', 'true');
            });
        }
    </script>
    @stack('scripts')
    @yield('scripts')
</body>
</html>
