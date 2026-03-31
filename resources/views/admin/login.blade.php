<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion Administrateur | Admin Panel</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">

    <!-- Fonts & Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin-premium.css') }}">
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        body {
            background: radial-gradient(circle at top right, #6366f1, transparent),
                        radial-gradient(circle at bottom left, #4f46e5, transparent),
                        #0f172a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 48px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            color: white;
        }
        
        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            padding: 14px 16px;
            border-radius: 12px;
        }
        
        .form-control:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: #6366f1;
            color: white;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.2);
        }
        
        .form-label {
            color: #94a3b8;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 8px;
        }
        
        .btn-login {
            background: #6366f1;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.2s;
            color: white;
        }
        
        .btn-login:hover {
            background: #4f46e5;
            transform: translateY(-1px);
            box-shadow: 0 10px 20px -5px rgba(99, 102, 241, 0.5);
        }
    </style>
</head>
<body>
    <div class="login-card animate-fade-up">
        <div class="text-center mb-5">
            <div class="d-inline-flex p-3 bg-primary bg-opacity-10 rounded-4 mb-4">
                <i data-lucide="shield-check" class="text-primary" style="width: 40px; height: 40px;"></i>
            </div>
            <h2 class="fw-bold h3 mb-2">Espace Admin</h2>
            <p class="text-secondary small">Veuillez vous identifier pour continuer</p>
        </div>

        @if(session('error'))
            <div class="alert alert-danger bg-danger bg-opacity-10 border-0 text-white small mb-4 py-3 rounded-4">
                <i data-lucide="alert-circle" class="me-2" style="width: 16px; height: 16px;"></i>
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            
            <div class="mb-4">
                <label for="email" class="form-label">Email</label>
                <div class="position-relative">
                    <input type="email" 
                           class="form-control" 
                           id="email" 
                           name="email" 
                           placeholder="admin@example.com"
                           value="{{ old('email') }}"
                           required 
                           autofocus>
                </div>
            </div>

            <div class="mb-5">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label for="password" class="form-label mb-0">Mot de passe</label>
                </div>
                <input type="password" 
                       class="form-control" 
                       id="password" 
                       name="password" 
                       placeholder="••••••••"
                       required>
            </div>

            <button type="submit" class="btn btn-login w-100 mb-4">
                Connexion
            </button>
        </form>

        <div class="text-center">
            <p class="text-secondary smaller mb-0">
                <i data-lucide="lock" class="me-1" style="width: 12px; height: 12px;"></i>
                Accès restreint par chiffrement AES-256
            </p>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
