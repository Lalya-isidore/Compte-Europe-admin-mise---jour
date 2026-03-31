<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réponse à votre demande</title>
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

        .header {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            padding: 35px 30px;
            text-align: center;
        }

        .header h1 {
            color: #ffffff;
            font-size: 22px;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            margin: 0;
        }

        .content { padding: 35px 30px; }

        .greeting {
            font-size: 17px;
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .intro {
            color: #555;
            font-size: 15px;
            margin-bottom: 25px;
            line-height: 1.7;
        }

        .ticket-ref {
            display: inline-block;
            background: #eff6ff;
            color: #2563eb;
            font-weight: 700;
            font-size: 13px;
            padding: 4px 12px;
            border-radius: 6px;
        }

        .message-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-left: 4px solid #22c55e;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }

        .message-box .label {
            font-size: 13px;
            color: #166534;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .message-box .text {
            color: #444;
            font-size: 14px;
            line-height: 1.8;
            white-space: pre-line;
        }

        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #ddd, transparent);
            margin: 25px 0;
        }

        .note {
            color: #888;
            font-size: 13px;
            text-align: center;
            line-height: 1.6;
        }

        .footer {
            background: #f8f9fa;
            padding: 25px 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }

        .footer-text { color: #999; font-size: 12px; }

        .footer-brand {
            color: #2563eb;
            font-weight: 900;
            font-style: italic;
            font-size: 16px;
            margin-top: 8px;
            text-transform: uppercase;
        }

        @media only screen and (max-width: 600px) {
            body { padding: 20px 10px; }
            .content { padding: 25px 20px; }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="header">
            <h1>{{ config('app.name', 'TRANSFERFLUX') }}</h1>
        </div>

        <div class="content">
            <p class="greeting">Bonjour {{ $user->prenom ?? $user->nom ?? '' }},</p>

            <p class="intro">
                Nous avons répondu à votre demande de support.
                <br><span class="ticket-ref">Ticket #{{ $ticket->id }} — {{ $ticket->subject }}</span>
            </p>

            <div class="message-box">
                <div class="label">Notre réponse :</div>
                <div class="text">{{ $supportMessage->content }}</div>
            </div>

            <div class="divider"></div>

            <p class="note">
                Vous pouvez continuer la conversation directement depuis votre espace client via le chat de support.
            </p>
        </div>

        <div class="footer">
            <p class="footer-text">Merci pour votre confiance.</p>
            <div class="footer-brand">{{ config('app.name', 'TRANSFERFLUX') }}</div>
        </div>
    </div>
</body>
</html>
