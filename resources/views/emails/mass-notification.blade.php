<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $emailSubject ?? 'Notification' }}</title>
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
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            text-transform: uppercase;
        }

        .content {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 25px;
            font-weight: 600;
        }

        .message {
            color: #555;
            font-size: 15px;
            line-height: 1.8;
            white-space: pre-line;
        }

        .message a {
            color: #2563eb;
            font-weight: 600;
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

        @media only screen and (max-width: 600px) {
            body { padding: 20px 10px; }
            .header h1 { font-size: 20px; }
            .content { padding: 30px 20px; }
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

            <div class="message">{!! nl2br(e($emailMessage)) !!}</div>

            <div class="divider"></div>
        </div>

        <div class="footer">
            <p class="footer-text">Cet e-mail vous a été envoyé par {{ config('app.name', 'TRANSFERFLUX') }}.</p>
            <div class="footer-brand">{{ config('app.name', 'TRANSFERFLUX') }}</div>
        </div>
    </div>
</body>
</html>
