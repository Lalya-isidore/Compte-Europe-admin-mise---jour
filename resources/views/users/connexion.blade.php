@extends('./../layouts/app')

@section('page-content')
<div class="fb-auth-container">
    <div class="fb-auth-card animate-fade-in">
        <!-- 💎 Brand Header (Inspiré de KitsCMS + FlashBilan Pro) -->
        <div class="fb-brand-header">
            <div class="fb-logo-icon">
                <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="40" height="40" rx="10" fill="url(#fb_grad)" />
                    <path d="M20 10C14.4772 10 10 14.4772 10 20C10 25.5228 14.4772 30 20 30C25.5228 30 30 25.5228 30 20C30 14.4772 25.5228 10 20 10ZM20 27.5C15.8579 27.5 12.5 24.1421 12.5 20C12.5 15.8579 15.8579 12.5 20 12.5V20H27.5C27.5 24.1421 24.1421 27.5 20 27.5Z" fill="white"/>
                    <defs>
                        <linearGradient id="fb_grad" x1="0" y1="0" x2="40" y2="40" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#F59E0B"/>
                            <stop offset="1" stop-color="#10B981"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            <h1 class="fb-brand-text">Flash<span>Bilan</span></h1>
            <p class="fb-subtitle">Connectez-vous pour piloter vos finances</p>
        </div>

        <!-- 🚀 Auth Form -->
        <form action="{{ route('connexion') }}" method="POST" class="fb-form" id="loginForm">
            @csrf

            <!-- Alerts -->
            @if(session('error'))
                <div class="fb-alert fb-alert-error" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif


            <div class="fb-input-group">
                <label for="email" class="fb-label">Email Professionnel</label>
                <div class="fb-input-wrapper">
                    <i class="far fa-envelope fb-input-icon"></i>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" 
                           class="fb-input @error('email') is-invalid @enderror" 
                           placeholder="nom@exemple.com" required autocomplete="email" autofocus>
                </div>
                @error('email') <span class="fb-error">{{ $message }}</span> @enderror
            </div>

            <div class="fb-input-group">
                <div class="fb-label-row" style="display: flex; justify-content: space-between; align-items: center;">
                    <label for="password" class="fb-label">Mot de passe</label>
                    <a href="{{ route('password.request') }}" class="fb-forgot-link" style="font-size: 0.8rem; font-weight: 600; color: var(--fb-primary); text-decoration: none;">Oublié ?</a>
                </div>
                <div class="fb-input-wrapper">
                    <i class="fas fa-lock fb-input-icon"></i>
                    <input type="password" id="password" name="password" 
                           class="fb-input @error('password') is-invalid @enderror" 
                           placeholder="••••••••" required autocomplete="current-password">
                    <button type="button" class="fb-password-toggle" id="togglePassword">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
                @error('password') <span class="fb-error">{{ $message }}</span> @enderror
            </div>

            <div class="fb-options">
                <label class="fb-checkbox-container">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span class="fb-checkmark"></span>
                    <span class="fb-checkbox-label">Rester connecté</span>
                </label>
            </div>

            <button type="submit" class="fb-btn-primary" id="submitBtn">
                <span class="btn-text">Se connecter <i class="fas fa-arrow-right ml-2"></i></span>
                <div class="btn-loader"></div>
            </button>

            <div class="fb-divider">
                <span>Pas encore de compte ?</span>
            </div>

            <a href="{{ route('inscription') }}" class="fb-btn-outline">
                Créer un compte FlashBilan
            </a>

            <!-- 🔗 Footer Links (KitsCMS Style) -->
            <div class="fb-auth-footer">
                <a href="{{ url('/') }}" class="fb-footer-link">
                    <i class="fas fa-home"></i> Accueil
                </a>
                <span class="fb-footer-sep">|</span>
                <a href="{{ route('inscription') }}" class="fb-footer-link">
                    <i class="fas fa-user-plus"></i> Inscription
                </a>
                <span class="fb-footer-sep">|</span>
                <a href="{{ route('password.request') }}" class="fb-footer-link">
                    <i class="fas fa-key"></i> Aide
                </a>
            </div>
        </form>
    </div>
</div>

<style>
/* 🎨 FlashBilan Ultra-Premium Auth Design System */
:root {
    --fb-primary: #0D6EFD;
    --fb-primary-dark: #0a58ca;
    --fb-secondary: #EF4444;
    --fb-success: #10B981;
    --fb-bg-input: #F8FAFC;
    --fb-text-main: #1E293B;
    --fb-text-muted: #64748B;
    --fb-border: #E2E8F0;
    --fb-radius: 12px;
    --fb-glass-bg: rgba(255, 255, 255, 0.85);
}

.fb-auth-container *:not(i):not(.fas):not(.far):not(.fab):not(.fa) {
    font-family: 'Inter', 'SF Pro Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.fb-auth-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 85vh;
    padding: 20px;
}

.fb-auth-card {
    background: var(--fb-glass-bg);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    width: 100%;
    max-width: 440px;
    padding: 40px;
    border-radius: 28px;
    border: 1px solid rgba(255, 255, 255, 0.6);
    box-shadow: 
        0 20px 25px -5px rgba(0, 0, 0, 0.05),
        0 10px 10px -5px rgba(0, 0, 0, 0.02),
        inset 0 0 0 1px rgba(255, 255, 255, 0.4);
    animation: authCardEntrance 0.7s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes authCardEntrance {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.fb-brand-header {
    text-align: center;
    margin-bottom: 35px;
}

.fb-logo-icon svg {
    width: 60px;
    height: 60px;
    margin-bottom: 18px;
    filter: drop-shadow(0 4px 12px rgba(245, 158, 11, 0.3));
}

.fb-brand-text {
    font-size: 2.4rem;
    font-weight: 800;
    color: var(--fb-text-main);
    letter-spacing: -1px;
    margin: 0;
}

.fb-brand-text span {
    color: var(--fb-secondary);
}

.fb-subtitle {
    color: var(--fb-text-muted);
    font-size: 1rem;
    margin-top: 10px;
}

.fb-form {
    display: flex;
    flex-direction: column;
    gap: 22px;
}

.fb-input-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.fb-label {
    font-size: 0.88rem;
    font-weight: 600;
    color: var(--fb-text-main);
    display: flex;
    align-items: center;
    gap: 6px;
}

.fb-input-wrapper {
    position: relative;
}

.fb-input-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--fb-text-muted);
    font-size: 1rem;
    pointer-events: none;
    transition: all 0.3s ease;
}

.fb-input {
    width: 100%;
    padding: 13px 15px 13px 44px;
    background: var(--fb-bg-input);
    border: 1.5px solid var(--fb-border);
    border-radius: var(--fb-radius);
    font-size: 1rem;
    color: var(--fb-text-main);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.fb-input:focus {
    outline: none;
    background: #fff;
    border-color: var(--fb-primary);
    box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
}

.fb-input:focus + .fb-input-icon {
    color: var(--fb-primary);
    transform: translateY(-50%) scale(1.1);
}

.fb-input.is-invalid {
    border-color: var(--fb-secondary);
    background: #fef2f2;
}

.fb-error {
    font-size: 0.8rem;
    color: var(--fb-secondary);
    font-weight: 500;
    margin-top: 4px;
}

.fb-password-toggle {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    border: none;
    background: none;
    color: var(--fb-text-muted);
    cursor: pointer;
    padding: 6px;
    transition: all 0.2s ease;
}

.fb-password-toggle:hover {
    color: var(--fb-text-main);
}

.fb-options {
    display: flex;
    align-items: center;
}

.fb-checkbox-container {
    display: flex;
    align-items: center;
    position: relative;
    padding-left: 28px;
    cursor: pointer;
    user-select: none;
}

.fb-checkbox-label {
    font-size: 0.88rem;
    color: var(--fb-text-muted);
    font-weight: 500;
}

.fb-checkbox-container input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
}

.fb-checkmark {
    position: absolute;
    top: 2px;
    left: 0;
    height: 18px;
    width: 18px;
    background-color: #fff;
    border: 1.5px solid var(--fb-border);
    border-radius: 6px;
    transition: all 0.2s ease;
}

.fb-checkbox-container:hover input ~ .fb-checkmark {
    border-color: var(--fb-primary);
}

.fb-checkbox-container input:checked ~ .fb-checkmark {
    background-color: var(--fb-primary);
    border-color: var(--fb-primary);
}

.fb-checkmark:after {
    content: "";
    position: absolute;
    display: none;
    left: 5px;
    top: 2px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

.fb-checkbox-container input:checked ~ .fb-checkmark:after {
    display: block;
}

/* ⚡ Primary Button (Arrow style) */
.fb-btn-primary {
    width: 100%;
    background: var(--fb-primary);
    color: white;
    border: none;
    padding: 16px;
    border-radius: var(--fb-radius);
    font-size: 1.1rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
}

.fb-btn-primary:hover {
    background: var(--fb-primary-dark);
    transform: translateY(-3px);
    box-shadow: 0 12px 24px rgba(13, 110, 253, 0.35);
}

.fb-btn-primary:active {
    transform: translateY(-1px);
}

.fb-btn-primary i {
    transition: transform 0.3s ease;
    margin-left: 8px;
}

.fb-btn-primary:hover i {
    transform: translateX(5px);
}

.fb-btn-outline {
    width: 100%;
    background: transparent;
    color: var(--fb-text-main);
    border: 1.5px solid var(--fb-border);
    padding: 14px;
    border-radius: var(--fb-radius);
    font-size: 0.95rem;
    font-weight: 600;
    text-decoration: none;
    text-align: center;
    transition: all 0.3s ease;
}

.fb-btn-outline:hover {
    background: #fff;
    border-color: var(--fb-primary);
    color: var(--fb-primary);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.fb-divider {
    text-align: center;
    position: relative;
    margin: 5px 0;
}

.fb-divider:before {
    content: "";
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: var(--fb-border);
    z-index: 1;
}

.fb-divider span {
    background: #fff;
    padding: 0 12px;
    font-size: 0.8rem;
    color: var(--fb-text-muted);
    position: relative;
    z-index: 2;
}

/* 🔗 Footer KitsCMS style */
.fb-auth-footer {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 15px;
    margin-top: 15px;
    padding-top: 20px;
    border-top: 1px solid var(--fb-border);
}

.fb-footer-link {
    color: var(--fb-text-muted);
    font-size: 0.88rem;
    font-weight: 600;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
}

.fb-footer-link:hover {
    color: var(--fb-primary);
}

.fb-footer-sep {
    color: var(--fb-border);
    font-weight: 300;
}

.fb-alert {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 18px;
    border-radius: 14px;
    font-size: 0.9rem;
    font-weight: 500;
    margin-bottom: 25px;
}

.fb-alert-error {
    background: #FEF2F2;
    color: #B91C1C;
    border: 1px solid #FEE2E2;
}

.fb-alert-success {
    background: #F0FDF4;
    color: #166534;
    border: 1px solid #DCFCE7;
}

.btn-loader {
    display: none;
    width: 22px;
    height: 22px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: fb-spin 0.8s linear infinite;
}

@keyframes fb-spin {
    to { transform: rotate(360deg); }
}

/* 📱 Responsive */
@media (max-width: 480px) {
    .fb-auth-container {
        padding: 15px 2px; /* Presque 100% de largeur sur mobile */
    }
    .fb-auth-card {
        padding: 40px 18px; /* Ajusté pour plus d'espace interne avec moins de marge externe */
        border-radius: 20px;
        margin: 0;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    }
    .fb-btn-primary {
        padding: 14px;
        font-size: 1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoader = submitBtn.querySelector('.btn-loader');
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    // 🚀 Handle submission
    if (loginForm) {
        loginForm.addEventListener('submit', function() {
            submitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoader.style.display = 'block';
        });
    }

    // 👁️ Password toggle
    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    }
});
</script>
@endsection
