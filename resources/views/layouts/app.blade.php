<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Kits FlashBilan — SMS Pro, Flash Compte Pro (Europe & Afrique), Mail Flash Pro, Numero virtuel (a partir de 3 200 CFA), Verification de numero de telephone, Verification d'IBAN/CB.">
    <meta name="keywords" content="FlashBilan, FlashBilan, SMS Pro, Flash Compte Pro, Mail Flash Pro, numero virtuel, verification telephone, verification IBAN, transfert argent, Europe, Afrique">
    <meta name="author" content="FlashBilan">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook / WhatsApp / Messenger -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Kits FlashBilan">
    <meta property="og:description" content="SMS Pro, Flash Compte Pro (Europe & Afrique), Mail Flash Pro, Numero virtuel (a partir de 3 200 CFA), Verification de numero de telephone, Verification d'IBAN/CB.">
    <meta property="og:image" content="{{ asset('images/og-preview1.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="FlashBilan">
    <meta property="og:locale" content="fr_FR">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Kits FlashBilan">
    <meta name="twitter:description" content="SMS Pro, Flash Compte Pro (Europe & Afrique), Mail Flash Pro, Numero virtuel (a partir de 3 200 CFA), Verification de numero de telephone, Verification d'IBAN/CB.">
    <meta name="twitter:image" content="{{ asset('images/og-preview1.png') }}">

    <title>Kits FlashBilan - {{ app('region')->appName() }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/support-widget.css') }}">
    <script src="{{ asset('js/support-widget.js') }}" defer></script>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-final-premium.png') }}">
    
    <!-- PWA Meta Tags -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#0d6efd">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Compte Europe Pro">
    <link rel="apple-touch-icon" href="{{ asset('icon-192.png') }}">
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

    /* 💎 KitsCMS-Inspired "Pro" Mesh Background */
    .auth-bg {
        position: fixed;
        inset: 0;
        z-index: -1;
        background-color: #f8fafc;
        background-image: 
            radial-gradient(at 0% 0%, hsla(253, 100%, 75%, 0.12) 0, transparent 50%), 
            radial-gradient(at 50% 0%, hsla(225, 100%, 77%, 0.15) 0, transparent 50%), 
            radial-gradient(at 100% 0%, hsla(339, 49%, 71%, 0.1) 0, transparent 50%);
        overflow: hidden;
    }

    .auth-blob {
        position: absolute;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(96, 165, 250, 0.15) 0%, rgba(96, 165, 250, 0) 70%);
        border-radius: 50%;
        filter: blur(80px);
        animation: float 25s infinite alternate;
        z-index: -1;
    }

    .auth-blob:nth-child(2) {
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(139, 92, 246, 0.1) 0%, rgba(139, 92, 246, 0) 70%);
        top: 20%;
        right: -10%;
        animation-duration: 30s;
        animation-delay: -5s;
    }

    .auth-blob:nth-child(3) {
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(236, 72, 153, 0.08) 0%, rgba(236, 72, 153, 0) 70%);
        bottom: -10%;
        left: 20%;
        animation-duration: 35s;
        animation-delay: -10s;
    }

    @keyframes float {
        0% { transform: translate(0, 0) rotate(0deg); }
        100% { transform: translate(100px, 50px) rotate(90deg); }
    }

    /* Abstract Lines (SVG mimics KitsCMS but improved) */
    .auth-lines {
        position: absolute;
        inset: 0;
        opacity: 0.4;
        pointer-events: none;
        z-index: -1;
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
<body data-support-enabled="{{ auth()->check() ? '1' : '0' }}">
    <!-- PWA Install Banner -->
    @auth
    <div id="pwa-install-banner">
        <img src="{{ asset('images/logo-final-premium.png') }}" alt="FlashBilan" class="pwa-icon" style="height: 48px; width: auto; object-fit: contain; border-radius: 10px;">
        <div class="pwa-text">
            <h4>Application Mobile</h4>
            <p id="pwa-desc">Téléchargez l'application pour un accès rapide.</p>
        </div>
        <button id="pwa-install-btn" class="pwa-btn">Installer</button>
        <button id="pwa-close-btn" class="pwa-close">&times;</button>
    </div>
    @endauth
    
    @if(request()->routeIs('connexion', 'inscription', 'password.request', 'password.reset'))
    <div class="auth-bg">
        <div class="auth-blob"></div>
        <div class="auth-blob"></div>
        <div class="auth-blob"></div>
        <svg class="auth-lines" viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M0,20 Q50,0 100,20" fill="none" stroke="rgba(99, 102, 241, 0.05)" stroke-width="0.5"/>
            <path d="M0,50 Q50,30 100,50" fill="none" stroke="rgba(99, 102, 241, 0.03)" stroke-width="0.5"/>
            <path d="M0,80 Q50,60 100,80" fill="none" stroke="rgba(99, 102, 241, 0.04)" stroke-width="0.5"/>
        </svg>
    </div>
    @endif

    @if(!request()->routeIs('connexion', 'inscription', 'login', 'password.request', 'password.reset') && !request()->is('/'))
    <header class="app-header-shell">
        <nav class="app-navbar navbar navbar-expand-lg">
            <div class="container-fluid p-0" style="display: flex; justify-content: space-between; align-items: center;">
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    <img src="{{ asset('images/logo-final-premium.png') }}" alt="FlashBilan" style="height: 38px; width: auto; object-fit: contain;">
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
    @endif

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
        var remboursementBtn = document.querySelector('.remboursement');
        if (remboursementBtn) remboursementBtn.addEventListener('click', function() {
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
            var remboursementBtn = document.querySelector('.remboursement');
            if (remboursementBtn) {
                var virementEffectue = remboursementBtn.getAttribute('data-virement-effectue');
                remboursementBtn.style.display = (virementEffectue === 'true') ? 'block' : 'none';
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

</body>

</html>
