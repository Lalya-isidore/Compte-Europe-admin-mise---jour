@extends('layouts.auth-hero')

@section('title', 'Session expirée - ' . app('region')->appName())

@section('content')
<div class="container-fluid">
    <div class="row min-vh-100 justify-content-center">
        <!-- Côté gauche - Image/Branding -->
        <div class="col-lg-6 d-none d-lg-flex auth-hero">
            <div class="auth-hero__content">
                <div class="auth-hero__brand">
                    <h2 class="auth-hero__title">{{ app('region')->appName() }}</h2>
                    <p class="auth-hero__subtitle">Votre partenaire financier de confiance</p>
                </div>
                
                <div class="auth-hero__features">
                    <div class="auth-hero__feature">
                        <i class="fas fa-shield-alt"></i>
                        <span>Sécurité maximale</span>
                    </div>
                    <div class="auth-hero__feature">
                        <i class="fas fa-clock"></i>
                        <span>Disponible 24h/24</span>
                    </div>
                    <div class="auth-hero__feature">
                        <i class="fas fa-mobile-alt"></i>
                        <span>Accès mobile</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Côté droit - Contenu -->
        <div class="col-lg-6 col-xl-5 d-flex align-items-center justify-content-center">
            <section class="auth-card w-100" aria-label="Session expirée">
                <header class="auth-card__header text-center">
                    <div class="auth-icon mb-4">
                        <i class="fas fa-clock text-warning" style="font-size: 4rem;"></i>
                    </div>
                    <h1>Session expirée</h1>
                    <p>Votre session a expiré pour des raisons de sécurité. Pas de panique !</p>
                </header>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Que s'est-il passé ?</strong><br>
                    Pour votre sécurité, nous limitons la durée de validité des formulaires. Cette mesure protège vos données contre les attaques malveillantes.
                </div>

                <div class="text-center mb-4">
                    <button class="btn btn-primary me-2" onclick="window.location.reload()">
                        <i class="fas fa-redo me-2"></i>
                        Actualiser la page
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-home me-2"></i>
                        Retour à l'accueil
                    </a>
                </div>

                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Astuce :</strong> Si le problème persiste, essayez de vider le cache de votre navigateur ou utilisez un onglet de navigation privée.
                </div>

                <p class="auth-card__meta text-center">
                    Besoin d'aide ? <a href="mailto:support@{{ strtolower(app('region')->appName()) }}.com">Contactez notre support</a>
                </p>
            </section>
        </div>
    </div>
</div>

<style>
.auth-icon {
    opacity: 0.8;
}

.btn {
    border-radius: 12px;
    padding: 0.8rem 2rem;
    font-weight: 600;
    text-transform: none;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #1a60ff, #0e3cc0);
    border: none;
    box-shadow: 0 4px 15px rgba(26, 96, 255, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(26, 96, 255, 0.4);
}

.btn-outline-secondary {
    border: 2px solid #e9ecef;
    color: #6c757d;
}

.btn-outline-secondary:hover {
    background: #f8f9fa;
    transform: translateY(-1px);
}

.alert {
    border: none;
    border-radius: 12px;
    padding: 1rem 1.5rem;
}

.alert-info {
    background: linear-gradient(135deg, rgba(13, 202, 240, 0.1), rgba(13, 202, 240, 0.05));
    color: #055160;
}

.alert-warning {
    background: linear-gradient(135deg, rgba(255, 193, 7, 0.1), rgba(255, 193, 7, 0.05));
    color: #664d03;
}
</style>

<script>
// Auto-refresh après 10 secondes si l'utilisateur ne fait rien
setTimeout(function() {
    if (confirm('Voulez-vous actualiser la page automatiquement ?')) {
        window.location.reload();
    }
}, 10000);

// Message de debug pour les développeurs
console.log('Session expirée - Token CSRF invalide ou expiré');
</script>
@endsection
