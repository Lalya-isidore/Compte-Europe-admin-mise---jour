<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FlashBilan - Administration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/support-widget.css') }}">
    <script src="{{ asset('js/support-widget.js') }}" defer></script>
    <!--<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/image/1.jpg') }} ">-->
    <!--<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/image/1.jpg') }} ">-->
    <!--<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/image/1.jpg') }} ">-->
    <link rel="manifest" href="/path/to/site.webmanifest">
</head>
<style>
    * {
        font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        background: #f5f7fb;
    }

    .app-header-shell {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        border-radius: 20px;
        box-shadow: 0 18px 35px rgba(13, 110, 253, 0.18);
        margin: 1.5rem auto 2.25rem;
        padding: 0.35rem;
        position: relative;
        max-width: 1160px;
    }

    .app-header-shell::after {
        content: '';
        position: absolute;
        inset: 100% 8% auto;
        height: 18px;
        border-radius: 999px;
        background: radial-gradient(circle at 50% 0%, rgba(13, 110, 253, 0.25), transparent 70%);
        opacity: 0.85;
        filter: blur(6px);
    }

    .app-navbar {
        background: rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        padding: 0.9rem 1.5rem;
        backdrop-filter: blur(10px);
    }

    .app-navbar .navbar-brand {
        color: #ffffff;
        font-size: 1.55rem;
        font-weight: 800;
        letter-spacing: 0.4px;
        text-transform: capitalize;
        display: flex;
        align-items: center;
        gap: 0.45rem;
    }

    .app-navbar .navbar-brand .brand-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #52e5ff;
        box-shadow: 0 0 12px rgba(82, 229, 255, 0.8);
        display: inline-block;
    }

    .app-navbar .nav-link {
        color: #f3f6ff;
        font-weight: 500;
        border-radius: 999px;
        padding: 0.45rem 1.1rem;
        transition: background-color 0.25s ease, color 0.25s ease, transform 0.2s ease;
    }

    .app-navbar .nav-link:hover,
    .app-navbar .nav-link:focus {
        background: rgba(255, 255, 255, 0.18);
        color: #ffffff;
        transform: translateY(-1px);
    }

    .app-navbar .nav-link.active {
        background: rgba(255, 255, 255, 0.3);
        color: #ffffff;
        font-weight: 600;
    }

    @media (max-width: 991.98px) {
        .app-header-shell {
            margin: 1rem 1.25rem 2rem;
            padding: 0.25rem;
        }

        .app-navbar {
            padding: 0.75rem 1rem;
        }

        .app-navbar .nav-link {
            margin-top: 0.35rem;
        }
    }
</style>
<body data-support-enabled="{{ auth()->check() ? '1' : '0' }}">

    <header class="app-header-shell">
        <nav class="app-navbar navbar navbar-expand-lg">
            <div class="container-fluid p-0" style="display: flex; justify-content: space-between; align-items: center;">
                <a class="navbar-brand" href="#">
                    <span class="brand-dot"></span>
                    FlashBilan
                </a>

                <div class="d-flex align-items-center">
                    <ul class="navbar-nav mb-0">
                        @auth
                            <li class="nav-item mx-1">
                                <a class="nav-link {{ request()->routeIs('compte.create') ? 'active' : '' }}" href="{{ route('compte.create') }}">Compte</a>
                            </li>
                            <li class="nav-item mx-1">
                                <a class="nav-link" href="{{ route('logout') }}">Me déconnecter</a>
                            </li>
                        @else
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Messages d'erreur et de succès -->
    @if(session('error'))
    <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Erreur :</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif

    @if(session('success'))
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <strong>Succès :</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif

    @if(session('warning'))
    <div class="container mt-3">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Attention :</strong> {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif

    @if(session('info'))
    <div class="container mt-3">
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Info :</strong> {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif

    <div class="container">
        @yield('page-content')
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
    <script src="{{ asset('js/csrf-handler.js') }}"></script>

    <script>
        // Écoute l'événement du clic sur le bouton de remboursement
        document.querySelector('.remboursement').addEventListener('click', function() {
            // Récupère l'ID du compte à rembourser depuis les données attribuées au bouton
            var compteId = this.getAttribute('data-compte-id');

            // Envoie une requête AJAX pour déclencher le remboursement
            fetch(`/compte/rembourse`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken // Assure-toi d'avoir le token CSRF correct ici
                    },
                    body: JSON.stringify({
                        compte_id: compteId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Vérifie si le remboursement a été effectué avec succès ou non
                    if (data.success) {
                        alert('Le remboursement a été effectué avec succès.');
                        location.reload(); // Recharge la page pour mettre à jour le solde du compte
                    } else {
                        alert('Le remboursement a échoué. Veuillez réessayer.');
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Récupère l'élément du bouton de remboursement
            var remboursementBtn = document.querySelector('.remboursement');

            // Récupère la valeur de l'attribut data-virement-effectue
            var virementEffectue = remboursementBtn.getAttribute('data-virement-effectue');

            // Vérifie si un virement a été effectué
            if (virementEffectue === 'true') {
                // Affiche le bouton de remboursement
                remboursementBtn.style.display = 'block';
            } else {
                // Cache le bouton de remboursement
                remboursementBtn.style.display = 'none';
            }
        });

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

</body>

</html>

