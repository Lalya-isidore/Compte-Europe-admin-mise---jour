<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ouverture de compte chez TRANSFERFLUX</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .header {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="40" fill="rgba(255,255,255,0.1)"/></svg>');
            opacity: 0.1;
        }

        .header h1 {
            color: #ffffff;
            font-size: 24px;
            font-weight: 900;
            font-style: italic;
            margin: 0;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            line-height: 1.3;
            text-transform: uppercase;
        }

        .content {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .message {
            color: #555;
            font-size: 15px;
            margin-bottom: 30px;
            line-height: 1.7;
        }

        .amount-info {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-left: 5px solid #2563eb;
            border-radius: 12px;
            padding: 20px 25px;
            margin: 25px 0;
            font-size: 16px;
            color: #333;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08);
        }

        .credentials-box {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-left: 5px solid #2563eb;
            border-radius: 12px;
            padding: 25px;
            margin: 30px 0;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08);
        }

        .credentials-title {
            font-size: 16px;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .credentials-title::before {
            content: '🔐';
            margin-right: 10px;
            font-size: 20px;
        }

        .credential-item {
            background: white;
            padding: 15px 20px;
            margin-bottom: 12px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .credential-item:last-child {
            margin-bottom: 0;
        }

        .credential-label {
            font-size: 14px;
            color: #666;
            font-weight: 500;
        }

        .credential-value {
            font-size: 15px;
            color: #2563eb;
            font-weight: 700;
            font-family: 'Courier New', monospace;
        }

        .button-container {
            text-align: center;
            margin: 35px 0;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #ffffff !important;
            text-decoration: none !important;
            padding: 16px 40px;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 700;
            font-style: italic;
            font-size: 16px;
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
            transition: all 0.3s ease;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
        }

        .amount-info strong {
            color: #2563eb;
            font-size: 18px;
            font-weight: 800;
            font-style: italic;
        }

        .info-text {
            color: #555;
            font-size: 15px;
            line-height: 1.7;
            margin: 25px 0;
        }

        .support-link {
            color: #2563eb;
            font-weight: 600;
            text-decoration: none;
        }

        .support-link:hover {
            text-decoration: underline;
        }

        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #ddd, transparent);
            margin: 30px 0;
        }

        .footer {
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }

        .footer-text {
            color: #777;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .footer-brand {
            color: #2563eb;
            font-weight: 900;
            font-style: italic;
            font-size: 18px;
            margin-top: 10px;
            text-transform: uppercase;
        }

        .icon-check {
            display: inline-block;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            border-radius: 50%;
            margin-bottom: 25px;
            line-height: 60px;
            font-size: 32px;
            text-align: center;
            color: white;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }

        @media only screen and (max-width: 600px) {
            body {
                padding: 20px 10px;
            }

            .header h1 {
                font-size: 24px;
            }

            .content {
                padding: 30px 20px;
            }

            .credential-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .cta-button {
                padding: 14px 30px;
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="header">
            <h1>Ouverture de compte sur TRANSFERFLUX</h1>
        </div>
        
        <div class="content">
            <div style="text-align: center;">
                <div class="icon-check">✓</div>
            </div>

            <p class="greeting">Bonjour {{ $compte->nom.' '.$compte->prenom }},</p>
            
            <p class="message">
                Nous avons le plaisir de vous informer que votre compte a été créé avec succès et crédité d'un montant de <strong>{{ number_format((float)$compte->account_balance, 2, ',', ' ') }} {{ $compte->devise }}</strong>.
            </p>

            <div class="credentials-box">
                <div class="credentials-title">Vos identifiants sont:</div>
                
                <div class="credential-item">
                    <span class="credential-label">📧 Email:</span>
                    <span class="credential-value">{{ $compte->email }}</span>
                </div>

                <div class="credential-item">
                    <span class="credential-label">🔑 Mot de passe:</span>
                    <span class="credential-value">{{ $compte->password }}</span>
                </div>

                <div class="credential-item">
                    <span class="credential-label">💰 Solde initial:</span>
                    <span class="credential-value">{{ number_format((float)$compte->account_balance, 2, ',', ' ') }} {{ $compte->devise }}</span>
                </div>
            </div>

            <div class="button-container">
                @php
                    $regionKey = $compte->region ?: 'europe';
                    $baseUrl = config('regions.' . $regionKey . '.client_login_url', 'https://fluxtransfer.world');
                    $accessLink = rtrim($baseUrl, '/') . '/?c=' . $compte->numerocompte;
                @endphp
                <a href="{{ $accessLink }}" class="cta-button" style="color:#ffffff !important; text-decoration:none !important;">
                    Connectez-vous à votre espace client
                </a>
            </div>

            <p class="info-text">
                Vous pouvez maintenant accéder à votre compte et profiter de nos services.
            </p>

            <div class="divider"></div>

            <p class="info-text">
                Si vous avez des questions ou si vous avez besoin de plus d'informations, 
                n'hésitez pas à nous contacter à votre 
                <a href="#" class="support-link">adresse e-mail de support</a>.
            </p>
        </div>

        <div class="footer">
            <p class="footer-text">Merci d'utiliser TRANSFERFLUX !</p>
            <div class="footer-brand">TRANSFERFLUX</div>
            <p class="footer-text" style="margin-top: 15px;">
                Votre partenaire financier de confiance 🏦
            </p>
        </div>
    </div>
</body>
</html>