
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de mot de passe - TRANSFERFLUX</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            padding: 40px 20px;
            line-height: 1.6;
            margin: 0;
        }

        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(37, 99, 235, 0.15);
        }

        .header {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            padding: 40px 30px;
            text-align: center;
        }

        .header h1 {
            color: #ffffff;
            font-size: 24px;
            font-weight: 900;
            font-style: italic;
            margin: 0;
            text-transform: uppercase;
        }

        .content {
            padding: 40px 30px;
            color: #333;
        }

        .btn-container {
            text-align: center;
            margin: 35px 0;
        }

        .btn {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #ffffff !important;
            padding: 15px 35px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 700;
            font-style: italic;
            display: inline-block;
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);
            text-transform: uppercase;
        }

        .footer {
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }

        .footer-brand {
            color: #2563eb;
            font-weight: 900;
            font-style: italic;
            font-size: 18px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="header">
            <h1>TRANSFERFLUX</h1>
        </div>
        
        <div class="content">
            <h2 style="color: #2563eb; font-size: 22px; margin-bottom: 20px;">Réinitialisation de mot de passe</h2>
            
            <p>Bonjour {{ $user->name }},</p>
            
            <p>Vous recevez cet e-mail car nous avons reçu une demande de réinitialisation de votre mot de passe pour votre compte **TRANSFERFLUX**.</p>
            
            <p>Veuillez cliquer sur le lien ci-dessous pour réinitialiser votre mot de passe :</p>
            
            <div class="btn-container">
                <a href="{{ $url }}" class="btn">Réinitialiser le mot de passe</a>
            </div>
            
            <p style="font-size: 14px; color: #777;">Si vous n'avez pas demandé de réinitialisation de mot de passe, aucune autre action n'est requise.</p>
            
            <p style="margin-top: 30px;">Cordialement,<br><strong class="footer-brand">L'équipe TRANSFERFLUX</strong></p>
        </div>

        <div class="footer">
            <div class="footer-brand">TRANSFERFLUX</div>
            <p style="font-size: 12px; color: #999; margin-top: 15px;">
                Votre partenaire financier de confiance 🏦
            </p>
        </div>
    </div>
</body>
</html>
