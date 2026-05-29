<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Administration') | Admin Panel</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">

    <!-- Fonts & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin-premium.css') }}?v={{ filemtime(public_path('css/admin-premium.css')) }}">
    <script src="https://unpkg.com/lucide@latest"></script>
    
    @stack('styles')
</head>
<body>
    <div id="sidebarOverlay" class="sidebar-overlay"></div>
    <div class="admin-layout">
        <!-- Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Header -->
            <header class="top-header">
                <div class="header-left">
                    <button class="btn btn-link p-0 d-lg-none" id="sidebarToggle">
                        <i data-lucide="menu"></i>
                    </button>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}" class="text-secondary text-decoration-none">Admin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@yield('title', 'Tableau de bord')</li>
                        </ol>
                    </nav>
                </div>
                
                <div class="header-right">
                    <div class="d-flex align-items-center gap-3">
                        <div class="text-end d-none d-md-block">
                            <p class="mb-0 fw-bold small">{{ session('admin_email', 'Admin') }}</p>
                            <p class="mb-0 text-secondary smaller" style="font-size: 0.75rem;">Administrateur Principal</p>
                        </div>
                        <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i data-lucide="user" style="width: 20px; height: 20px;"></i>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-4 p-lg-5">
                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center gap-3">
                        <i data-lucide="check-circle" class="text-success"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center gap-3">
                        <i data-lucide="alert-circle" class="text-danger"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="animate-fade-up">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Sidebar Toggle for Mobile
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.add('active');
        }
        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
        }

        if(sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
            });
        }
        if(overlay) {
            overlay.addEventListener('click', closeSidebar);
        }
    </script>
    @stack('scripts')
</body>
</html>
