<!DOCTYPE html>
<html lang="fr" translate="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="google" content="notranslate">
    <title>Connexion Administrateur</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        * { box-sizing: border-box; }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #1e1b4b 100%);
            font-family: 'Segoe UI', system-ui, sans-serif;
            padding: 1rem;
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
        }

        .login-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 40px 36px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
        }

        .login-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .login-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
            text-align: center;
            margin-bottom: 6px;
        }

        .login-subtitle {
            font-size: 0.875rem;
            color: #6b7280;
            text-align: center;
            margin-bottom: 28px;
        }

        .form-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-control {
            background: #f9fafb;
            border: 1.5px solid #d1d5db;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 0.95rem;
            color: #111827;
            transition: all 0.2s;
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        .form-control:focus {
            background: #fff;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
            outline: none;
            color: #111827;
        }

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border: none;
            border-radius: 10px;
            padding: 13px;
            font-size: 1rem;
            font-weight: 600;
            color: #fff;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 8px;
        }

        .btn-login:hover {
            opacity: 0.92;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.4);
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 12px 14px;
            color: #dc2626;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .login-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.78rem;
            color: #9ca3af;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-icon">
                <i data-lucide="shield-check" style="width:30px;height:30px;color:#fff;"></i>
            </div>

            <h1 class="login-title">Espace Admin</h1>
            <p class="login-subtitle">Veuillez vous identifier pour continuer</p>

            @if(session('error'))
                <div class="alert-error">
                    <i data-lucide="alert-circle" style="width:16px;height:16px;flex-shrink:0;"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Adresse e-mail</label>
                    <input type="email"
                           class="form-control"
                           id="email"
                           name="email"
                           placeholder="admin@example.com"
                           value="{{ old('email') }}"
                           required
                           autofocus>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password"
                           class="form-control"
                           id="password"
                           name="password"
                           placeholder="••••••••"
                           required>
                </div>

                <button type="submit" class="btn-login">
                    Se connecter
                </button>
            </form>

            <div class="login-footer">
                <i data-lucide="lock" style="width:12px;height:12px;"></i>
                Accès restreint — chiffrement AES-256
            </div>
        </div>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>
