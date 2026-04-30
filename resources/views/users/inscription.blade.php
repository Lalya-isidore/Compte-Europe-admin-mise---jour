@extends('./../layouts/app')

@section('page-content')
<div class="fb-auth-container">
    <div class="fb-auth-card fb-register-card animate-fade-in">
        <!-- 💎 Brand Header (Inspiré de KitsCMS + FlashBilan Pro) -->
        <div class="fb-brand-header">
            <div class="fb-logo-icon">
                <img src="{{ asset('images/logo-final-premium.png') }}" alt="FlashBilan" style="height: 70px; width: auto; object-fit: contain;">
            </div>
            <p class="fb-subtitle">Participez à la révolution financière digitale</p>
        </div>

        <!-- 🚀 Registration Form (Premium Grid Layout) -->
        <form action="{{ route('inscription') }}" method="POST" class="fb-form" id="registerForm">
            @csrf

            @if(session('error'))
                <div class="fb-alert fb-alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <div class="fb-form-grid">
                <!-- Nom / Prénom Group -->
                <div class="fb-input-group">
                    <label for="nom" class="fb-label">Nom de famille</label>
                    <div class="fb-input-wrapper">
                        <i class="far fa-user fb-input-icon"></i>
                        <input type="text" id="nom" name="nom" value="{{ old('nom') }}" 
                               class="fb-input @error('nom') is-invalid @enderror" 
                               placeholder="Dupont" required autocomplete="family-name">
                    </div>
                    @error('nom') <span class="fb-error">{{ $message }}</span> @enderror
                </div>

                <div class="fb-input-group">
                    <label for="prenom" class="fb-label">Prénom(s)</label>
                    <div class="fb-input-wrapper">
                        <i class="far fa-user fb-input-icon"></i>
                        <input type="text" id="prenom" name="prenom" value="{{ old('prenom') }}" 
                               class="fb-input @error('prenom') is-invalid @enderror" 
                               placeholder="Jean-Pierre" required autocomplete="given-name">
                    </div>
                    @error('prenom') <span class="fb-error">{{ $message }}</span> @enderror
                </div>

                <!-- Email / Phone Group -->
                <div class="fb-input-group">
                    <label for="email" class="fb-label">Email professionnel</label>
                    <div class="fb-input-wrapper">
                        <i class="far fa-envelope fb-input-icon"></i>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" 
                               class="fb-input @error('email') is-invalid @enderror" 
                               placeholder="nom@exemple.com" required autocomplete="email">
                    </div>
                    @error('email') <span class="fb-error">{{ $message }}</span> @enderror
                </div>

                <div class="fb-input-group">
                    <label for="phone_number" class="fb-label">Numéro de téléphone</label>
                    <div class="fb-input-wrapper">
                        <i class="fas fa-mobile-alt fb-input-icon"></i>
                        <input type="tel" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" 
                               class="fb-input @error('phone_number') is-invalid @enderror" 
                               placeholder="+225 00 00 00 00" required autocomplete="tel">
                    </div>
                    @error('phone_number') <span class="fb-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Parrainage Contextuel -->
            @if(isset($codeParrainage) && $codeParrainage)
                <div class="fb-parrainage-card">
                    <div class="fb-parrainage-header">
                        <i class="fas fa-gift"></i>
                        <span>Avantage Parrainage Actif</span>
                    </div>
                    <div class="fb-parrainage-body">
                        @if(session('parrain_info'))
                            <p>Invitée par <strong>{{ session('parrain_info.prenom') }} {{ session('parrain_info.nom') }}</strong></p>
                        @else
                            <p>Code cadeau appliqué : <strong>{{ $codeParrainage }}</strong></p>
                        @endif
                    </div>
                    <input type="hidden" name="code_parrainage" value="{{ $codeParrainage }}">
                </div>
            @else
                <div class="fb-input-group fb-full-row">
                    <label for="parrainage" class="fb-label">Code Parrainage (Optionnel)</label>
                    <div class="fb-input-wrapper">
                        <i class="fas fa-hashtag fb-input-icon"></i>
                        <input type="text" id="parrainage" name="parrainage" value="{{ old('parrainage') }}" 
                               class="fb-input" placeholder="Saisissez un code si vous en avez un">
                    </div>
                    <p class="fb-input-hint">Laissez ce champ vide si vous n'avez pas de code de parrainage.</p>
                </div>
            @endif

            <!-- Mot de passe unique -->
            <div class="fb-input-group">
                <label for="password" class="fb-label">Définir un mot de passe sécurisé</label>
                <div class="fb-input-wrapper">
                    <i class="fas fa-lock fb-input-icon"></i>
                    <input type="password" id="password" name="password" 
                           class="fb-input @error('password') is-invalid @enderror" 
                           placeholder="••••••••" required autocomplete="new-password">
                    <button type="button" class="fb-password-toggle" id="togglePassword">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
                <div class="fb-password-hint">Utilisez au moins 8 caractères avec des lettres et chiffres.</div>
                @error('password') <span class="fb-error">{{ $message }}</span> @enderror
            </div>

            <div class="fb-terms">
                <label class="fb-checkbox-container">
                    <input type="checkbox" name="terms" required>
                    <span class="fb-checkmark"></span>
                    <span class="fb-checkbox-label">J'accepte les <a href="#">Conditions d'Utilisation</a> et la <a href="#">Politique de Confidentialité</a>.</span>
                </label>
            </div>

            <button type="submit" class="fb-btn-primary" id="submitBtn">
                <span class="btn-text">Créer mon compte FlashBilan <i class="fas fa-arrow-right ml-2"></i></span>
                <div class="btn-loader"></div>
            </button>

            <!-- 🔗 Footer Links (KitsCMS Style) -->
            <div class="fb-auth-footer">
                <a href="{{ url('/') }}" class="fb-footer-link">
                    <i class="fas fa-home"></i> Accueil
                </a>
                <span class="fb-footer-sep">|</span>
                <a href="{{ route('connexion') }}" class="fb-footer-link">
                    <i class="fas fa-sign-in-alt"></i> Connexion
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

.fb-auth-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 90vh;
    padding: 30px 20px;
}

.fb-auth-card {
    background: var(--fb-glass-bg);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    width: 100%;
    max-width: 600px; /* Wider for registration */
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
    font-size: inherit;
    font-weight: inherit;
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

.fb-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
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

.fb-input-hint {
    font-size: 0.8rem;
    color: var(--fb-text-muted);
    font-weight: 400;
    margin-top: 4px;
    margin-bottom: 0;
}

.fb-password-hint {
    font-size: 0.78rem;
    color: var(--fb-text-muted);
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

.fb-parrainage-card {
    background: rgba(16, 185, 129, 0.08);
    border: 1.5px dashed var(--fb-success);
    border-radius: 16px;
    padding: 18px;
    margin-top: 5px;
    animation: fadeIn 0.5s ease;
}

.fb-parrainage-header {
    display: flex;
    align-items: center;
    gap: 10px;
    color: var(--fb-success);
    font-weight: 700;
    font-size: 0.95rem;
    margin-bottom: 6px;
}

.fb-parrainage-body {
    font-size: 0.9rem;
    color: #064e3b;
}

/* 🗳️ Checkbox Customization (KitsCMS refined) */
.fb-terms {
    margin: 5px 0;
}

.fb-checkbox-container {
    display: flex;
    align-items: flex-start;
    position: relative;
    padding-left: 32px;
    cursor: pointer;
    user-select: none;
}

.fb-checkbox-label {
    font-size: 0.9rem;
    color: var(--fb-text-muted);
    font-weight: 500;
    line-height: 1.4;
}

.fb-checkbox-label a {
    color: var(--fb-primary);
    text-decoration: none;
    font-weight: 700;
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
    height: 20px;
    width: 20px;
    background-color: #fff;
    border: 2px solid var(--fb-border);
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
    left: 6px;
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
}

.fb-btn-primary:hover i {
    transform: translateX(5px);
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

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* 📱 High-End Mobile Responsiveness */
@media (max-width: 640px) {
    .fb-form-grid {
        grid-template-columns: 1fr;
    }
    .fb-auth-container {
        padding: 15px 2px; /* Presque 100% de largeur sur mobile */
    }
    .fb-auth-card {
        padding: 40px 16px; /* Ajusté pour plus d'espace interne avec moins de marge externe */
        border-radius: 24px;
        margin: 0;
    }
    .fb-btn-primary {
        padding: 14px;
        font-size: 1rem;
    }
    .fb-brand-text {
        font-size: 2rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('registerForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoader = submitBtn.querySelector('.btn-loader');
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    // 🚀 Handle submission with UX feedback
    if (registerForm) {
        registerForm.addEventListener('submit', function() {
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.8';
            btnText.style.display = 'none';
            btnLoader.style.display = 'block';
        });
    }

    // 👁️ Improved Password Toggle
    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
            
            // Subtle feedback
            this.style.transform = 'scale(0.9)';
            setTimeout(() => this.style.transform = 'scale(1)', 100);
        });
    }
});
</script>
@endsection
