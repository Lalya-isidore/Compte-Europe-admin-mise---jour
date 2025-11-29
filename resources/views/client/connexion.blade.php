<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlashCompte - Espace Client</title>
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
        <div class="logo">
            <i class="fas fa-university"></i>
        </div>
        <h1 class="service-name">FlashCompte</h1>
    </div>

    @if(session('error') || $errors->any())
        <div class="alert">
            {{ session('error') ?: 'Oups!!! Adresse mail ou mot de passe incorrect.' }}
        </div>
    @endif

    <div class="login-container">
        <h2 class="login-title">Connexion Compte</h2>
        
        <form action="{{ route('client.auth') }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="email" 
                       name="email" 
                       class="form-control" 
                       placeholder="Adresse email" 
                       value="{{ old('email') }}"
                       required>
            </div>
            
            <div class="form-group">
                <div class="password-container">
                    <input type="password" 
                           name="password" 
                           id="password"
                           class="form-control" 
                           placeholder="Mot de passe" 
                           required>
                    <button type="button" class="password-toggle" onclick="togglePassword()">
                        <i class="fas fa-eye" id="toggleIcon"></i>
                    </button>
                </div>
            </div>
            
            <button type="submit" class="btn-login">
                Connexion
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