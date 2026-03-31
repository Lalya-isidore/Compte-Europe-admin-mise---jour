<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $type === 'new_ticket' ? 'Nouveau ticket support' : 'Nouveau message support' }}</title>
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
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            color: #ffffff;
            font-size: 20px;
            font-weight: 700;
            margin: 0;
        }

        .badge {
            display: inline-block;
            background: rgba(255,255,255,0.2);
            color: #fff;
            font-size: 12px;
            padding: 4px 12px;
            border-radius: 20px;
            margin-top: 8px;
        }

        .content { padding: 30px; }

        .info-box {
            background: #f8fafc;
            border-left: 4px solid #2563eb;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .info-label {
            font-size: 12px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 15px;
            color: #333;
            font-weight: 600;
        }

        .message-box {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
        }

        .message-box .label {
            font-size: 13px;
            color: #92400e;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .message-box .text {
            color: #555;
            font-size: 14px;
            line-height: 1.7;
            white-space: pre-line;
        }

        .cta {
            display: block;
            text-align: center;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 30px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 15px;
            margin: 25px 0 10px;
        }

        .footer {
            background: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }

        .footer-text { color: #999; font-size: 12px; }

        @media only screen and (max-width: 600px) {
            body { padding: 20px 10px; }
            .content { padding: 20px; }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="header">
            <h1>{{ $type === 'new_ticket' ? '🎫 Nouveau ticket de support' : '💬 Nouveau message de support' }}</h1>
            <div class="badge">Ticket #{{ $ticket->id }}</div>
        </div>

        <div class="content">
            <div class="info-box">
                <div style="margin-bottom: 15px;">
                    <div class="info-label">Utilisateur</div>
                    <div class="info-value">{{ $user->prenom ?? '' }} {{ $user->nom ?? '' }} ({{ $user->email ?? 'N/A' }})</div>
                </div>
                <div style="margin-bottom: 15px;">
                    <div class="info-label">Sujet</div>
                    <div class="info-value">{{ $ticket->subject }}</div>
                </div>
                <div>
                    <div class="info-label">Date</div>
                    <div class="info-value">{{ $supportMessage->created_at ? $supportMessage->created_at->format('d/m/Y à H:i') : now()->format('d/m/Y à H:i') }}</div>
                </div>
            </div>

            <div class="message-box">
                <div class="label">Message :</div>
                <div class="text">{{ $supportMessage->content }}</div>
            </div>

            @if($supportMessage->file_name)
            <p style="color: #666; font-size: 13px;">📎 Pièce jointe : {{ $supportMessage->file_name }}</p>
            @endif

            <a href="{{ url('/admin/support') }}" class="cta">Répondre dans l'administration</a>
        </div>

        <div class="footer">
            <p class="footer-text">{{ config('app.name', 'TRANSFERFLUX') }} — Notification automatique de support</p>
        </div>
    </div>
</body>
</html>
