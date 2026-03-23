@extends('./../layouts/app')
@section('page-content')
    <div class="auth-viewport">
        <div class="auth-surface">
            <aside class="auth-hero">
                <div class="auth-hero__header">
                    <span class="auth-hero__logo">FlashBilan</span>
                    <span class="auth-hero__tag">Onboarding express</span>
                </div>
                <h1>Lancez votre espace administrateur en quelques minutes</h1>
                <p>Créez votre accès pour orchestrer vos comptes flash, automatiser vos alertes et rassurer vos clients à chaque étape.</p>
                <dl class="auth-hero__stats">
                    <div>
                        <dt>Durée moyenne</dt>
                        <dd>-3 min</dd>
                    </div>
                    <div>
                        <dt>Support</dt>
                        <dd>24/7</dd>
                    </div>
                    <div>
                        <dt>Satisfaction</dt>
                        <dd>98%</dd>
                    </div>
                </dl>
                <ul class="auth-hero__benefits">
                    <li><i class="fas fa-layer-group"></i> Profils clients centralisés et prêts à l'action.</li>
                    <li><i class="fas fa-sitemap"></i> Gestion simultanée des comptes, virements et remboursements.</li>
                    <li><i class="fas fa-headset"></i> Assistance proactive pour chaque simulation.</li>
                </ul>
            </aside>

            <section class="auth-card" aria-label="Formulaire d'inscription">
                @if (session()->has('error'))
                    <div class="auth-alert auth-alert--error">{{ session('error') }}</div>
                @endif

                <header class="auth-card__header">
                    <span class="auth-card__eyebrow">Rejoignez FlashBilan</span>
                    <h2>Inscription administrateur</h2>
                    <p>Complétez vos informations pour accéder à l'ensemble des outils de pilotage.</p>
                </header>

                <form action="{{ route('inscription') }}" method="post" class="auth-form" id="register-form" novalidate>
                    @csrf
                    <div class="auth-field">
                        <label for="nom">Nom</label>
                        <div class="auth-input">
                            <span class="auth-input__icon">N</span>
                            <input type="text" id="nom" name="nom" class="auth-input__control"
                                   value="{{ old('nom') }}" placeholder="Dupont" autocomplete="family-name" required>
                        </div>
                        @error('nom')
                            <p class="auth-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="auth-field">
                        <label for="prenom">Prénom</label>
                        <div class="auth-input">
                            <span class="auth-input__icon">P</span>
                            <input type="text" id="prenom" name="prenom" class="auth-input__control"
                                   value="{{ old('prenom') }}" placeholder="Alice" autocomplete="given-name" required>
                        </div>
                        @error('prenom')
                            <p class="auth-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="auth-field">
                        <label for="email">E-mail</label>
                        <div class="auth-input">
                            <span class="auth-input__icon">@</span>
                            <input type="email" id="email" name="email" class="auth-input__control"
                                   value="{{ old('email') }}" placeholder="nom.prenom@email.com" autocomplete="email" required>
                        </div>
                        @error('email')
                            <p class="auth-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="auth-field">
                        <label for="phone_number">Numéro de téléphone (format international)</label>
                        <div class="auth-input">
                            <span class="auth-input__icon">+</span>
                            <input type="tel" id="phone_number" name="phone_number" class="auth-input__control"
                                   value="{{ old('phone_number') }}" placeholder="+2250700000000" autocomplete="tel" required>
                        </div>
                        @error('phone_number')
                            <p class="auth-error">{{ $message }}</p>
                        @enderror
                    </div>

                    @if(isset($codeParrainage) && $codeParrainage)
                        <!-- Affichage du parrainage actif -->
                        <div class="auth-field">
                            <div class="parrainage-banner">
                                <div class="parrainage-header">
                                    <i class="fas fa-handshake"></i>
                                    <span>Inscription avec parrainage garantie</span>
                                    <span class="badge bg-success ms-2">Automatique</span>
                                </div>
                                <div class="parrainage-info">
                                    @if(session('parrain_info'))
                                        <p class="mb-1">
                                            <strong>Parrainé par :</strong> 
                                            {{ session('parrain_info.prenom') }} {{ session('parrain_info.nom') }}
                                        </p>
                                        <p class="mb-1 small">
                                            <i class="fas fa-gift me-1 text-success"></i>
                                            <strong>Votre parrain recevra {{ session('parrain_info.taux_commission') }}% de commission sur vos recharges</strong>
                                        </p>
                                        <p class="mb-1 small text-info">
                                            <i class="fas fa-info-circle me-1"></i>
                                            La commission s'applique uniquement lors de vos recharges de compte, pas à l'inscription
                                        </p>
                                        <p class="mb-0 small text-muted">
                                            <i class="fas fa-lock me-1"></i>
                                            Parrainage sécurisé et garanti - Aucune manipulation possible
                                        </p>
                                    @else
                                        <p class="mb-1">
                                            <strong>Code de parrainage :</strong> {{ $codeParrainage }}
                                        </p>
                                        <p class="mb-1 small">
                                            <i class="fas fa-gift me-1 text-success"></i>
                                            <strong>Votre parrain recevra 5% de commission sur vos recharges</strong>
                                        </p>
                                        <p class="mb-1 small text-info">
                                            <i class="fas fa-info-circle me-1"></i>
                                            La commission s'applique uniquement lors de vos recharges de compte, pas à l'inscription
                                        </p>
                                        <p class="mb-0 small text-muted">
                                            <i class="fas fa-lock me-1"></i>
                                            Parrainage sécurisé et garanti - Aucune manipulation possible
                                        </p>
                                    @endif
                                </div>

                            </div>
                            <!-- Champ caché pour le code de parrainage -->
                            <input type="hidden" id="code_parrainage" name="code_parrainage" value="{{ $codeParrainage }}">
                        </div>
                    @else
                        <!-- Champ manuel pour saisir un code de parrainage (optionnel) -->
                        <div class="auth-field" id="manual-parrainage-field">
                            <label for="code_parrainage">Code de parrainage (optionnel)</label>
                            <div class="auth-input">
                                <span class="auth-input__icon">#</span>
                                <input type="text" id="code_parrainage" name="code_parrainage" class="auth-input__control"
                                       value="{{ old('code_parrainage') }}" placeholder="Entrez le code de votre parrain" autocomplete="off">
                            </div>
                            @error('code_parrainage')
                                <p class="auth-error">{{ $message }}</p>
                            @enderror
                            <p class="auth-help">Si vous avez été invité par un ami, saisissez son code de parrainage pour qu'il reçoive sa commission.</p>
                        </div>
                    @endif

                    <div class="auth-field">
                        <label for="password">Mot de passe</label>
                        <div class="auth-input">
                            <span class="auth-input__icon">•••</span>
                            <input type="password" id="password" name="password" class="auth-input__control"
                                   placeholder="Mot de passe sécurisé" autocomplete="new-password" required>
                            <button type="button" class="auth-toggle" aria-label="Afficher le mot de passe">
                                <span class="auth-toggle__label">Afficher</span>
                            </button>
                        </div>
                        @error('password')
                            <p class="auth-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="auth-submit" id="register-submit">
                        <span class="auth-submit__text">Inscription</span>
                        <span class="auth-submit__spinner" aria-hidden="true"></span>
                    </button>

                    <p class="auth-card__meta">
                        Déjà membre&nbsp;? <a href="{{ route('connexion') }}">Connectez-vous</a>
                    </p>
                </form>
            </section>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('register-form');
            const submit = document.querySelector('#register-submit');
            const submitText = submit?.querySelector('.auth-submit__text');
            const spinner = submit?.querySelector('.auth-submit__spinner');

            if (form && submit && submitText && spinner) {
                form.addEventListener('submit', function () {
                    submit.disabled = true;
                    submitText.classList.add('is-hidden');
                    spinner.classList.add('is-visible');
                });
            }

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
            --auth-primary: #1a60ff;
            --auth-secondary: #00c1ff;
            --auth-dark: #102040;
            --auth-muted: #6b7897;
            --auth-shadow: 0 24px 60px -30px rgba(16, 32, 80, 0.45);
            --auth-glass: rgba(255, 255, 255, 0.9);
        }

        .auth-viewport {
            min-height: calc(100vh - 140px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: clamp(1.5rem, 5vw, 4rem);
            background: linear-gradient(145deg, #eef4ff, #ffffff 55%, #f2fbff);
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
            background: linear-gradient(145deg, rgba(26, 96, 255, 0.95), rgba(0, 193, 255, 0.82));
            display: grid;
            gap: 1.6rem;
            box-shadow: var(--auth-shadow);
            overflow: hidden;
        }

        .auth-hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top left, rgba(255, 255, 255, 0.2), transparent 60%);
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
            display: inline-block;
        }

        .auth-hero__logo img,
        img.auth-hero__logo {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            object-fit: cover;
            display: inline-block;
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
            font-size: clamp(2rem, 4vw, 2.55rem);
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
            background: rgba(255, 255, 255, 0.18);
            border-radius: 18px;
            padding: 0.8rem 1rem;
            text-align: center;
            backdrop-filter: blur(6px);
        }

        .auth-hero__stats dt {
            font-size: 0.75rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.75);
            margin-bottom: 0.35rem;
        }

        .auth-hero__stats dd {
            margin: 0;
            font-size: 1.35rem;
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
            gap: 0.8rem;
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
            font-size: clamp(1.9rem, 3.5vw, 2.3rem);
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
            background: rgba(242, 246, 255, 0.92);
            font-size: 0.98rem;
            color: var(--auth-dark);
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .auth-input__control:focus {
            outline: none;
            background: #ffffff;
            border-color: rgba(26, 96, 255, 0.45);
            box-shadow: 0 0 0 4px rgba(26, 96, 255, 0.16);
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
            background: rgba(26, 96, 255, 0.12);
            color: #0e3cc0;
        }

        .auth-error {
            margin: 0.35rem 0 0;
            font-size: 0.82rem;
            color: #dc2626;
            font-weight: 500;
        }

        .auth-help {
            margin: 0.35rem 0 0;
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 400;
            line-height: 1.4;
        }

        .parrainage-banner {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(16, 185, 129, 0.05));
            border: 2px solid rgba(34, 197, 94, 0.2);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 0.5rem;
            position: relative;
        }

        .parrainage-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            color: #059669;
            margin-bottom: 0.5rem;
        }

        .parrainage-header i {
            font-size: 1.1rem;
        }

        .parrainage-info {
            color: #064e3b;
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

        .auth-alert--error {
            background: #fff5f3;
            color: #b33030;
            border: 1px solid #ffd7d1;
        }

        .auth-alert.is-hiding {
            opacity: 0;
            transform: translateY(-6px);
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

