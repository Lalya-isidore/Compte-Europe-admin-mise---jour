<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bonus Fidélité</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #fefce8 0%, #fef9c3 100%);
            padding: 40px 20px;
            line-height: 1.6;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(217, 119, 6, 0.15);
        }
        .header {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            padding: 36px 32px;
            text-align: center;
        }
        .header h1 {
            color: #fff;
            font-size: 1.5rem;
            font-weight: 700;
        }
        .header .emoji {
            font-size: 3rem;
            display: block;
            margin-bottom: 12px;
        }
        .body-content {
            padding: 36px 32px;
        }
        .greeting {
            font-size: 1.1rem;
            color: #1e293b;
            font-weight: 600;
            margin-bottom: 16px;
        }
        .message {
            color: #475569;
            font-size: 0.95rem;
            margin-bottom: 24px;
        }
        .bonus-box {
            background: linear-gradient(135deg, #fefce8 0%, #fef3c7 100%);
            border: 2px solid #fbbf24;
            border-radius: 14px;
            padding: 24px;
            text-align: center;
            margin-bottom: 24px;
        }
        .bonus-box .amount {
            font-size: 2.5rem;
            font-weight: 800;
            color: #92400e;
            line-height: 1.2;
        }
        .bonus-box .label {
            font-size: 0.9rem;
            color: #a16207;
            font-weight: 600;
            margin-top: 6px;
        }
        .bonus-box .trophy {
            font-size: 2rem;
            display: block;
            margin-bottom: 8px;
        }
        .steps {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
            margin-bottom: 16px;
        }
        .step {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
        }
        .step-check {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
        }
        .step-line {
            width: 20px;
            height: 3px;
            background: linear-gradient(90deg, #f59e0b, #d97706);
        }
        .info {
            color: #64748b;
            font-size: 0.85rem;
            margin-bottom: 20px;
        }
        .footer {
            background: #f8fafc;
            padding: 20px 32px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        .footer p {
            color: #94a3b8;
            font-size: 0.78rem;
        }
        .footer .brand {
            font-weight: 700;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="header">
            <span class="emoji">🎁</span>
            <h1>Bonus Fidélité</h1>
        </div>

        <div class="body-content">
            <p class="greeting">Bonjour {{ $user->name ?? $user->email }},</p>

            <p class="message">
                Félicitations ! 🎉 Vous avez effectué <strong>4 recharges de crédits</strong> au cours des 30 derniers jours.
                En récompense de votre fidélité, nous vous offrons un bonus de crédits !
            </p>

            <div class="steps">
                <span class="step">1</span>
                <span class="step-line"></span>
                <span class="step">2</span>
                <span class="step-line"></span>
                <span class="step">3</span>
                <span class="step-line"></span>
                <span class="step-check">&#10003;</span>
            </div>

            <div class="bonus-box">
                <span class="trophy">🏆</span>
                <div class="amount">+{{ number_format($bonusCredits, 0, ',', ' ') }}</div>
                <div class="label">crédits gratuits ajoutés à votre compte</div>
            </div>

            <p class="info">
                Ce bonus a été automatiquement ajouté à votre solde de crédits FlashBilan.
                Continuez à recharger pour profiter de nouveaux bonus chaque mois ! 🎊
            </p>
        </div>

        <div class="footer">
            <p class="brand">FLASHBILAN</p>
            <p>&copy; {{ date('Y') }} FlashBilan. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>
