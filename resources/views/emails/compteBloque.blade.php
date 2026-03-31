<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte Suspendu - TRANSFERFLUX</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            padding: 40px 20px;
            line-height: 1.6;
        }

        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(37, 99, 235, 0.15);
        }

        .email-header {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            padding: 40px 30px;
            text-align: center;
        }

        .email-header h1 {
            color: #ffffff;
            font-size: 24px;
            font-weight: 900;
            font-style: italic;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            text-transform: uppercase;
        }

        .email-header p {
            margin: 5px 0 0 0;
            font-size: 14px;
            color: rgba(255,255,255,0.8);
        }

        .email-body {
            padding: 40px 30px;
            color: #333333;
            line-height: 1.6;
        }

        .email-body h2 {
            color: #ef4444;
            font-size: 22px;
            margin-top: 8px;
            margin-bottom: 20px;
            text-align: center;
        }

        .info-box {
            background: #fff3cd;
            border-left: 5px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 8px;
        }

        .account-details {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-left: 5px solid #2563eb;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08);
        }

        .account-details p {
            margin: 10px 0;
            font-size: 15px;
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 8px;
        }

        .account-details p:last-child { border-bottom: none; }

        .account-details strong { color: #666; font-weight: 500; }

        .detail-value {
            color: #2563eb;
            font-weight: 800;
            font-style: italic;
        }

        .email-footer {
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
            margin-top: 10px;
            text-transform: uppercase;
        }

        .warning-icon {
            font-size: 50px;
            color: #ef4444;
            margin-bottom: 10px;
            text-align: center;
        }

        @media only screen and (max-width: 600px) {
            body { padding: 20px 10px; }
            .email-body { padding: 30px 20px; }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-header">
            <h1>TRANSFERFLUX</h1>
            <p>Votre partenaire financier de confiance</p>
        </div>

        <div class="email-body">
            <div style="text-align: center;">
                <div class="warning-icon">⚠️</div>
            </div>

            <h2>Compte Suspendu</h2>

            <p>Bonjour <strong>{{ $compte->nom }} {{ $compte->prenom }}</strong>,</p>

            <div class="info-box">
                <strong>⚠️ Notification :</strong> Votre compte a été temporairement suspendu.
            </div>

            <p>Nous vous informons que votre compte bancaire a été suspendu pour des raisons de sécurité ou administratives.</p>

            <div class="account-details">
                <p><strong>Titulaire :</strong> <span class="detail-value">{{ $compte->nom }} {{ $compte->prenom }}</span></p>
                <p><strong>Email :</strong> <span class="detail-value">{{ $compte->email }}</span></p>
                <p><strong>Statut :</strong> <span class="detail-value" style="color: #ef4444;">SUSPENDU</span></p>
            </div>

            <p><strong>Que faire maintenant ?</strong></p>
            <ul style="margin-bottom: 20px;">
                <li>Contactez notre service client pour plus d'informations</li>
                <li>Vérifiez votre conformité avec nos conditions d'utilisation</li>
                <li>Préparez vos documents d'identité si nécessaire</li>
            </ul>

            <p>Notre équipe est disponible pour vous assister et résoudre cette situation dans les meilleurs délais.</p>

            <p style="margin-top: 30px;">Cordialement,<br><strong class="footer-brand">TRANSFERFLUX</strong></p>
        </div>

        <div class="email-footer">
            <p><strong class="footer-brand">TRANSFERFLUX</strong> - Service Client</p>
            <p style="margin-top: 15px; font-size: 11px; color: #777;">
                Cet email a été envoyé automatiquement, merci de ne pas y répondre directement.
            </p>
        </div>
    </div>
</body>
</html>
