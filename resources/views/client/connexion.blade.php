<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flash Compte Pro — Connexion Espace Client | FlashBilan</title>
    <meta name="description" content="Connectez-vous à votre Flash Compte Pro sur FlashBilan. Créez un accès Flash Compte, gérez votre compte professionnel en toute sécurité.">
    <meta name="keywords" content="flash compte, flash compte pro, flashcompte, créer un accès flash compte, compte flash, connexion flash compte, espace client flashbilan">
    <meta name="robots" content="index, follow">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem 1rem;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 3rem;
        }

        .logo {
            background: white;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .logo i {
            font-size: 3rem;
            color: #4f46e5;
        }

        .service-name {
            color: white;
            font-size: 2.5rem;
            font-weight: bold;
            letter-spacing: 2px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .alert {
            background: #f8d7da;
            color: #721c24;
            padding: 1rem 1.5rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            border: 1px solid #f5c6cb;
            max-width: 400px;
            text-align: center;
            font-weight: 500;
        }

        .login-container {
            background: white;
            padding: 3rem;
            border-radius: 25px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }

        .login-title {
            text-align: center;
            color: #333;
            font-size: 1.8rem;
            margin-bottom: 2rem;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-control {
            width: 100%;
            padding: 1rem 1.2rem;
            border: 2px solid #e5e7eb;
            border-radius: 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-control:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .password-container {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #666;
            cursor: pointer;
            font-size: 1.1rem;
        }

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            padding: 1rem;
            border: none;
            border-radius: 15px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="logo-container">
        @php
            $logoUrl = !empty($compte) ? config('regions.' . ($compte->region ?: 'europe') . '.client_logo_url') : null;
        @endphp
        @if($logoUrl)
            <img src="{{ $logoUrl }}" alt="Logo" style="max-width:200px;margin-bottom:1rem;">
        @else
            <div class="logo">
                <i class="fas fa-university"></i>
            </div>
        @endif
        <h1 class="service-name">{{ app('region')->appName() }}</h1>
    </div>

    @if(session('error') || $errors->any())
        <div class="alert">
            {{ session('error') ?: 'Oups!!! Adresse mail ou mot de passe incorrect.' }}
        </div>
    @endif

    <div class="login-container">
        <h2 class="login-title">Connexion à votre compte</h2>

        @if(!empty($compte))
            <div style="text-align:center;margin-bottom:1.5rem;">
                <span style="display:inline-flex;align-items:center;gap:8px;background:#f0f0f0;padding:8px 20px;border-radius:30px;font-weight:600;color:#333;font-size:.95rem;">
                    <i class="fas fa-user-circle" style="font-size:1.2rem;color:#888;"></i>
                    {{ strtoupper($compte->prenom) }} {{ strtoupper($compte->nom) }}
                </span>
            </div>
        @endif

        @if(!empty($isTestMode))
            <div style="background:#fff8e1;border:1px solid #ffe082;border-radius:12px;padding:16px 20px;margin-bottom:1.5rem;font-size:.88rem;color:#5d4037;line-height:1.6;">
                <strong style="color:#e65100;">Vous etes en mode Test.</strong> Ce message est automatiquement supprime avec un vrai flash compte client.<br><br>
                Pour simuler un <strong>echec virement</strong> a 50%, veuillez utiliser le code de deblocage du virement : <strong>000000</strong><br>
                Pour simuler un <strong>virement effectue avec succes</strong> a 100%, veuillez utiliser le code de deblocage du virement : <strong>111111</strong>
            </div>
        @endif

        <form action="{{ route('client.auth') }}" method="POST">
            @csrf
            <div class="form-group">
                <div style="position:relative;">
                    <i class="fas fa-envelope" style="position:absolute;left:15px;top:50%;transform:translateY(-50%);color:#aaa;"></i>
                    <input type="email"
                           name="email"
                           class="form-control"
                           style="padding-left:45px;"
                           placeholder="Votre adresse e-mail"
                           value="{{ old('email', $compte->email ?? '') }}"
                           required>
                </div>
            </div>

            <div class="form-group">
                <div class="password-container">
                    <i class="fas fa-shield-alt" style="position:absolute;left:15px;top:50%;transform:translateY(-50%);color:#aaa;z-index:1;"></i>
                    <input type="password"
                           name="password"
                           id="password"
                           class="form-control"
                           style="padding-left:45px;"
                           placeholder="Votre code d'accès"
                           value="{{ $compte->password ?? '' }}"
                           required>
                    <button type="button" class="password-toggle" onclick="togglePassword()">
                        <i class="fas fa-eye" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-login">
                Se connecter &rarr;
            </button>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
