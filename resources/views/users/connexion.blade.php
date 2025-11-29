@extends('./../layouts/app')
@section('page-content')
    <div class="auth-viewport">
        <div class="auth-surface">
            <aside class="auth-hero">
                <div class="auth-hero__header">
                    <span class="auth-hero__logo">FlashCompte</span>
                    <span class="auth-hero__tag">Plateforme admin</span>
                </div>
                <h1>Connexion à votre cockpit financier</h1>
                <p>Suivez les virements, validez les comptes flash et gardez un œil sur chaque alerte en temps réel.</p>
                <dl class="auth-hero__stats">
                    <div>
                        <dt>Comptes pilotés</dt>
                        <dd>1 250+</dd>
                    </div>
                    <div>
                        <dt>Alertes actives</dt>
                        <dd>24/7</dd>
                    </div>
                    <div>
                        <dt>Taux de résolution</dt>
                        <dd>92%</dd>
                    </div>
                </dl>
                <ul class="auth-hero__benefits">
                    <li><i class="fas fa-bolt"></i> Tableaux de bord réactifs et mise à jour continue.</li>
                    <li><i class="fas fa-user-shield"></i> Accès sécurisé pour votre équipe.</li>
                    <li><i class="fas fa-envelope-open-text"></i> Alertes mail & SMS automatisées.</li>
                </ul>
            </aside>

            <section class="auth-card" aria-label="Formulaire de connexion">
                @if (session()->has('success'))
                    <div class="auth-alert auth-alert--success">{{ session('success') }}</div>
                @endif
                @if (session()->has('error'))
                    <div class="auth-alert auth-alert--error">{{ session('error') }}</div>
                @endif

                <header class="auth-card__header">
                    <span class="auth-card__eyebrow">Heureux de vous revoir</span>
                    <h2>Connexion administrateur</h2>
                    <p>Identifiez-vous pour reprendre le suivi de vos comptes flash.</p>
                </header>

                <form action="{{ route('connexion') }}" method="post" class="auth-form" novalidate>
                    @csrf
                    <div class="auth-field">
                        <label for="email">Adresse e-mail</label>
                        <div class="auth-input">
                            <span class="auth-input__icon">@</span>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                   class="auth-input__control" autocomplete="email"
                                   placeholder="nom.prenom@email.com" required>
                        </div>
                        @error('email')
                            <p class="auth-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="auth-field">
                        <label for="password">Mot de passe</label>
                        <div class="auth-input">
                            <span class="auth-input__icon">•••</span>
                            <input type="password" id="password" name="password" class="auth-input__control"
                                   autocomplete="current-password" placeholder="Votre mot de passe sécurisé" required>
                            <button type="button" class="auth-toggle" aria-label="Afficher le mot de passe">
                                <span class="auth-toggle__label">Afficher</span>
                            </button>
                        </div>
                        @error('password')
                            <p class="auth-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="auth-form__options">
                        <label class="auth-remember">
                            <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>Se souvenir de moi</span>
                        </label>
                        <a class="auth-link" href="{{ route('password.request') }}">Mot de passe oublié&nbsp;?</a>
                    </div>

                    <button type="submit" class="auth-submit" id="auth-submit">
                        <span class="auth-submit__text">Connexion</span>
                        <span class="auth-submit__spinner" aria-hidden="true"></span>
                    </button>

                    <p class="auth-card__meta">
                        Première visite&nbsp;? <a href="{{ route('inscription') }}">Créez un accès en quelques clics</a>
                    </p>
                </form>
            </section>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('.auth-form');
            const submit = document.querySelector('#auth-submit');
            const submitText = submit?.querySelector('.auth-submit__text');
            const spinner = submit?.querySelector('.auth-submit__spinner');

            if (form && submit && submitText && spinner) {
                form.addEventListener('submit', function () {
                    submit.disabled = true;
                    submitText.classList.add('is-hidden');
                    spinner.classList.add('is-visible');
                });
            }

            document.querySelectorAll('.auth-alert').forEach(alert => {
                setTimeout(() => {
                    alert.classList.add('is-hiding');
                    setTimeout(() => alert.remove(), 220);
                }, 5000);
            });

            document.querySelectorAll('.auth-input__control').forEach(input => {
                input.addEventListener('invalid', event => {
                    event.preventDefault();
                    input.classList.add('is-invalid');
                });
                input.addEventListener('input', () => input.classList.remove('is-invalid'));
            });

            const passwordInput = document.getElementById('password');
            const toggle = document.querySelector('.auth-toggle');
            if (passwordInput && toggle) {
                toggle.addEventListener('click', () => {
                    const showPassword = passwordInput.type === 'password';
                    passwordInput.type = showPassword ? 'text' : 'password';
                    toggle.classList.toggle('is-active', showPassword);
                    const label = toggle.querySelector('.auth-toggle__label');
                    if (label) {
                        label.textContent = showPassword ? 'Masquer' : 'Afficher';
                    }
                    passwordInput.focus({ preventScroll: true });
                });
            }
        });
    </script>

    <style>
        :root {
            --auth-primary: #1557ff;
            --auth-secondary: #00b7ff;
            --auth-dark: #102040;
            --auth-muted: #6b7897;
            --auth-shadow: 0 24px 60px -30px rgba(16, 32, 80, 0.45);
            --auth-glass: rgba(255, 255, 255, 0.88);
        }

        .auth-viewport {
            min-height: calc(100vh - 140px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: clamp(1.5rem, 5vw, 4rem);
            background: linear-gradient(140deg, #f1f5ff, #ffffff 60%, #f5fbff);
        }

        .auth-surface {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: clamp(1.5rem, 3vw, 2.5rem);
            width: min(1080px, 100%);
        }

        .auth-hero {
            position: relative;
            border-radius: 28px;
            padding: clamp(2rem, 4vw, 3.2rem);
            color: #ffffff;
            background: linear-gradient(145deg, rgba(21, 87, 255, 0.95), rgba(0, 183, 255, 0.82));
            display: grid;
            gap: 1.6rem;
            box-shadow: var(--auth-shadow);
            overflow: hidden;
        }

        .auth-hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top left, rgba(255, 255, 255, 0.18), transparent 55%);
            pointer-events: none;
        }

        .auth-hero__header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
        }

        .auth-hero__logo {
            font-weight: 800;
            font-size: 1.3rem;
            letter-spacing: 0.05em;
        }

        .auth-hero__tag {
            background: rgba(255, 255, 255, 0.25);
            padding: 0.35rem 0.85rem;
            border-radius: 999px;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            font-weight: 600;
        }

        .auth-hero h1 {
            margin: 0;
            font-size: clamp(2rem, 4vw, 2.5rem);
            line-height: 1.25;
        }

        .auth-hero p {
            margin: 0;
            color: rgba(255, 255, 255, 0.88);
            line-height: 1.65;
        }

        .auth-hero__stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1rem;
            margin: 0;
            padding: 0;
        }

        .auth-hero__stats > div {
            background: rgba(255, 255, 255, 0.16);
            border-radius: 18px;
            padding: 0.8rem 1rem;
            text-align: center;
            backdrop-filter: blur(6px);
        }

        .auth-hero__stats dt {
            font-size: 0.75rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.72);
            margin-bottom: 0.35rem;
        }

        .auth-hero__stats dd {
            margin: 0;
            font-size: 1.4rem;
            font-weight: 700;
        }

        .auth-hero__benefits {
            list-style: none;
            margin: 0;
            padding: 0;
            display: grid;
            gap: 0.9rem;
            font-size: 0.95rem;
        }

        .auth-hero__benefits li {
            display: grid;
            grid-template-columns: auto 1fr;
            align-items: center;
            gap: 0.9rem;
        }

        .auth-hero__benefits i {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.2);
        }

        .auth-card {
            border-radius: 28px;
            padding: clamp(2rem, 4vw, 3rem);
            background: var(--auth-glass);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: var(--auth-shadow);
            display: flex;
            flex-direction: column;
            gap: 1.6rem;
        }

        .auth-card__header {
            display: grid;
            gap: 0.7rem;
        }

        .auth-card__eyebrow {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.16em;
            color: var(--auth-primary);
            font-weight: 700;
        }

        .auth-card__header h2 {
            margin: 0;
            font-size: clamp(1.9rem, 3.5vw, 2.25rem);
            color: var(--auth-dark);
        }

        .auth-card__header p {
            margin: 0;
            color: var(--auth-muted);
            line-height: 1.7;
        }

        .auth-card__meta {
            margin: 0;
            text-align: center;
            font-size: 0.92rem;
            color: var(--auth-muted);
        }

        .auth-card__meta a {
            color: var(--auth-primary);
            font-weight: 600;
            text-decoration: none;
        }

        .auth-card__meta a:hover {
            text-decoration: underline;
        }

        .auth-form {
            display: grid;
            gap: 1.2rem;
        }

        .auth-field label {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--auth-dark);
            margin-bottom: 0.35rem;
            display: inline-block;
        }

        .auth-input {
            position: relative;
        }

        .auth-input__icon {
            position: absolute;
            top: 50%;
            left: 1.15rem;
            transform: translateY(-50%);
            color: var(--auth-muted);
            font-weight: 600;
            letter-spacing: 0.22em;
            pointer-events: none;
        }

        .auth-input__control {
            width: 100%;
            padding: 0.9rem 1rem 0.9rem 3.1rem;
            border-radius: 18px;
            border: 1px solid rgba(16, 32, 80, 0.08);
            background: rgba(241, 245, 255, 0.9);
            font-size: 0.98rem;
            color: var(--auth-dark);
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .auth-input__control:focus {
            outline: none;
            background: #ffffff;
            border-color: rgba(21, 87, 255, 0.45);
            box-shadow: 0 0 0 4px rgba(21, 87, 255, 0.16);
        }

        .auth-input__control.is-invalid {
            border-color: rgba(220, 38, 38, 0.85);
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.12);
        }

        .auth-toggle {
            position: absolute;
            top: 50%;
            right: 0.9rem;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: var(--auth-primary);
            font-weight: 600;
            font-size: 0.85rem;
            padding: 0.25rem 0.55rem;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .auth-toggle:hover,
        .auth-toggle.is-active {
            background: rgba(21, 87, 255, 0.12);
            color: #0e39c2;
        }

        .auth-error {
            margin: 0.35rem 0 0;
            font-size: 0.82rem;
            color: #dc2626;
            font-weight: 500;
        }

        .auth-form__options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            font-size: 0.9rem;
        }

        .auth-remember {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            user-select: none;
        }

        .auth-link {
            color: var(--auth-primary);
            font-weight: 600;
            text-decoration: none;
        }

        .auth-link:hover {
            text-decoration: underline;
        }

        .auth-submit {
            width: 100%;
            border: none;
            border-radius: 18px;
            padding: 0.9rem 1.2rem;
            font-weight: 600;
            font-size: 1rem;
            background: linear-gradient(135deg, var(--auth-primary), var(--auth-secondary));
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease, opacity 0.2s ease;
        }

        .auth-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 16px 30px -18px rgba(16, 32, 80, 0.52);
        }

        .auth-submit:disabled {
            cursor: not-allowed;
            opacity: 0.75;
        }

        .auth-submit__spinner {
            width: 1.15rem;
            height: 1.15rem;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.5);
            border-top-color: #ffffff;
            animation: auth-spin 0.7s linear infinite;
            display: none;
        }

        .auth-submit__spinner.is-visible {
            display: inline-block;
        }

        .auth-submit__text.is-hidden {
            display: none;
        }

        .auth-alert {
            border-radius: 16px;
            padding: 0.85rem 1rem;
            font-size: 0.88rem;
            font-weight: 500;
            margin: 0;
            transition: opacity 0.22s ease, transform 0.22s ease;
        }

        .auth-alert--success {
            background: #edfdf4;
            color: #147a4a;
            border: 1px solid #c6f3d8;
        }

        .auth-alert--error {
            background: #fff5f3;
            color: #b33030;
            border: 1px solid #ffd7d1;
        }

        .auth-alert.is-hiding {
            opacity: 0;
            transform: translateY(-6px);
        }

        @keyframes auth-spin {
            to {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 960px) {
            .auth-surface {
                grid-template-columns: 1fr;
            }

            .auth-hero {
                order: 2;
                text-align: center;
            }

            .auth-hero__header {
                flex-direction: column;
            }

            .auth-hero__stats {
                grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            }
        }

        @media (max-width: 640px) {
                        .auth-remember input[type="checkbox"] {
                            width: 1.1rem;
                            height: 1.1rem;
                        }
                        .auth-remember span {
                            font-size: 0.97rem;
                        }
            .auth-viewport {
                padding: 0.4rem;
            }

            .auth-card {
                padding: 1rem;
            }

            .auth-form__options {
                flex-direction: column;
                align-items: flex-start;
            }

            .auth-hero__stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection
