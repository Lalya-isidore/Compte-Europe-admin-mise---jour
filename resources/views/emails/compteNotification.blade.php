<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titre }}</title>
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
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            font-size: 22px;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .content { padding: 40px 30px; }
        .icon-bell {
            display: inline-block;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            border-radius: 50%;
            margin-bottom: 25px;
            line-height: 60px;
            font-size: 28px;
            text-align: center;
            color: white;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }
        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .message-box {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-left: 5px solid #6366f1;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.08);
        }
        .message-title {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 12px;
        }
        .message-body {
            font-size: 15px;
            color: #374151;
            line-height: 1.7;
            white-space: pre-wrap;
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
        .footer-text { color: #777; font-size: 13px; margin-bottom: 10px; }
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
            .content { padding: 30px 20px; }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="header">
            <h1>FLUXTRANSFER</h1>
        </div>

        <div class="content">
            <div style="text-align: center;">
                <div class="icon-bell">🔔</div>
            </div>

            <p class="greeting">Bonjour {{ $compte->prenom }} {{ $compte->nom }},</p>

            <div class="message-box">
                <div class="message-title">{{ $titre }}</div>
                <div class="message-body">{{ $notifMessage }}</div>
            </div>

            <div class="divider"></div>

            <p style="text-align:center; color:#555; font-size:14px;">
                Ce message vous a été envoyé par votre conseiller FLUXTRANSFER.
            </p>
        </div>

        <div class="footer">
            <p class="footer-text">Merci de votre confiance.</p>
            <div class="footer-brand">FLUXTRANSFER</div>
            <p class="footer-text" style="margin-top: 15px;">
                Votre partenaire de confiance pour vos transferts internationaux.
            </p>
        </div>
    </div>
</body>
</html>
