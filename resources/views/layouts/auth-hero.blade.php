<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ trim($__env->yieldContent('title', app('region')->appName() . ' - Espace sécurisé')) }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/support-widget.css') }}">
    @stack('styles')
    <style>
        :root {
            color-scheme: only light;
        }

        body {
            min-height: 100vh;
            margin: 0;
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 45%, #052c65 100%);
            color: #0f172a;
        }

        .auth-shell {
            min-height: 100vh;
            display: flex;
            align-items: stretch;
            justify-content: center;
            padding: 2rem 1.5rem;
        }

        .auth-shell > * {
            flex: 1 1 auto;
        }

        .auth-hero {
            background: linear-gradient(135deg, rgba(255,255,255,0.15), rgba(255,255,255,0.05));
            border-radius: 32px;
            margin: 2rem;
            padding: 3rem;
            color: #ffffff;
            position: relative;
            overflow: hidden;
            box-shadow: 0 25px 70px rgba(15, 23, 42, 0.32);
        }

        .auth-hero::after {
            content: '';
            position: absolute;
            inset: auto -60% -50% -60%;
            height: 80%;
            background: radial-gradient(circle at center, rgba(255,255,255,0.35), transparent 65%);
            opacity: 0.35;
        }

        .auth-hero__content {
            position: relative;
            z-index: 1;
        }

        .auth-hero__title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .auth-hero__subtitle {
            font-size: 1rem;
            opacity: 0.85;
        }

        .auth-hero__features {
            margin-top: 3rem;
            display: grid;
            gap: 1rem;
        }

        .auth-hero__feature {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-weight: 500;
        }

        .auth-card {
            width: 100%;
            max-width: 480px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 28px;
            padding: 2.5rem;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.16);
        }

        .auth-card__header h1 {
            font-size: 1.9rem;
            font-weight: 700;
            color: #0f172a;
        }

        .auth-card__meta {
            font-size: 0.95rem;
            color: #475569;
        }

        @media (max-width: 991.98px) {
            .auth-shell {
                padding: 1.5rem 1rem;
                display: block;
            }

            .auth-hero {
                display: none;
            }

            .auth-card {
                padding: 2rem 1.75rem;
                border-radius: 22px;
            }
        }
    </style>
</head>
<body data-support-enabled="{{ auth()->check() ? '1' : '0' }}">
    <!-- Messages d'erreur et de succès -->
    @if(session('error'))
    <div class="position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 9999; width: 90%; max-width: 500px;">
        <div class="alert alert-danger alert-dismissible fade show shadow-lg" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Erreur :</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif

    @if(session('success'))
    <div class="position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 9999; width: 90%; max-width: 500px;">
        <div class="alert alert-success alert-dismissible fade show shadow-lg" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <strong>Succès :</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif

    @if(session('warning'))
    <div class="position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 9999; width: 90%; max-width: 500px;">
        <div class="alert alert-warning alert-dismissible fade show shadow-lg" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Attention :</strong> {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif

    @if(session('info'))
    <div class="position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 9999; width: 90%; max-width: 500px;">
        <div class="alert alert-info alert-dismissible fade show shadow-lg" role="alert">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Info :</strong> {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif

    <div class="auth-shell">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="{{ asset('js/support-widget.js') }}" defer></script>
    <script>
        // Auto-dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
    @stack('scripts')
</body>
</html>

