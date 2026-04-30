@extends('./../layouts/app')

@section('page-content')
<div class="fb-auth-container">
    <div class="fb-auth-card animate-fade-in">
        <!-- 💎 Brand Header -->
        <div class="fb-brand-header">
            <div class="fb-logo-icon">
                <img src="{{ asset('images/logo-final-premium.png') }}" alt="FlashBilan" style="height: 70px; width: auto; object-fit: contain;">
            </div>
            <h1 class="fb-brand-text">Flash<span>Bilan</span></h1>
            <p class="fb-subtitle">Définissez votre nouveau mot de passe</p>
        </div>

        <form action="{{ route('password.update') }}" method="POST" class="fb-form" id="resetForm">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="fb-input-group">
                <label for="email" class="fb-label">Confirmez votre E-mail</label>
                <div class="fb-input-wrapper">
                    <i class="far fa-envelope fb-input-icon"></i>
                    <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}" 
                           class="fb-input @error('email') is-invalid @enderror" 
                           placeholder="alice@exemple.com" required autocomplete="email" readonly>
                </div>
                @error('email') <span class="fb-error">{{ $message }}</span> @enderror
            </div>

            <div class="fb-input-group">
                <label for="password" class="fb-label">Nouveau Mot de passe</label>
                <div class="fb-input-wrapper">
                    <i class="fas fa-lock fb-input-icon"></i>
                    <input type="password" id="password" name="password" 
                           class="fb-input @error('password') is-invalid @enderror" 
                           placeholder="8 caractères minimum" required autocomplete="new-password" autofocus>
                    <button type="button" class="fb-password-toggle" id="togglePassword">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
                @error('password') <span class="fb-error">{{ $message }}</span> @enderror
            </div>

            <div class="fb-input-group">
                <label for="password-confirm" class="fb-label">Confirmez le mot de passe</label>
                <div class="fb-input-wrapper">
                    <i class="fas fa-lock fb-input-icon"></i>
                    <input type="password" id="password-confirm" name="password_confirmation" 
                           class="fb-input" placeholder="Répétez votre mot de passe" required autocomplete="new-password">
                </div>
            </div>

            <button type="submit" class="fb-btn-primary" id="submitBtn">
                <span class="btn-text">Réinitialiser le mot de passe <i class="fas fa-arrow-right ml-2"></i></span>
                <div class="btn-loader"></div>
            </button>
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

/* ⚡ Primary Button */
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
    justify(content: center;
    align-items: center;
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
}

.fb-btn-primary:hover {
    background: var(--fb-primary-dark);
    transform: translateY(-3px);
    box-shadow: 0 12px 24px rgba(13, 110, 253, 0.35);
}

.fb-btn-primary i {
    transition: transform 0.3s ease;
    margin-left: 8px;
}

.fb-btn-primary:hover i {
    transform: translateX(5px);
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
        padding: 15px 2px;
    }
    .fb-auth-card {
        padding: 35px 18px;
        border-radius: 20px;
        margin: 0;
    }
    .fb-btn-primary {
        padding: 14px 10px;
        font-size: 0.95rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('resetForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoader = submitBtn.querySelector('.btn-loader');
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    if (form) {
        form.addEventListener('submit', function() {
            submitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoader.style.display = 'block';
        });
    }

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
