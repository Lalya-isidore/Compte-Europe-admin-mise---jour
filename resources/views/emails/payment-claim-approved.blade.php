<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande approuvée</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); padding: 40px 20px; line-height: 1.6; }
        .email-wrapper { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 60px rgba(16, 185, 129, 0.15); }
        .header { background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 40px 30px; text-align: center; }
        .header h1 { color: #ffffff; font-size: 22px; font-weight: 900; margin: 0; text-transform: uppercase; letter-spacing: 1px; }
        .content { padding: 40px 30px; }
        .icon { display: inline-block; width: 64px; height: 64px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 50%; margin-bottom: 20px; line-height: 64px; font-size: 32px; text-align: center; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3); }
        .greeting { font-size: 18px; color: #333; margin-bottom: 16px; font-weight: 600; }
        .message { color: #555; font-size: 15px; margin-bottom: 25px; line-height: 1.7; }
        .details-box { background: #f8fafc; border-left: 5px solid #10b981; border-radius: 12px; padding: 25px; margin: 25px 0; }
        .details-title { font-size: 15px; font-weight: 700; color: #333; margin-bottom: 15px; }
        .detail-item { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #e2e8f0; align-items: center; }
        .detail-item:last-child { border-bottom: none; }
        .detail-label { color: #666; font-size: 14px; font-weight: 500; }
        .detail-value { color: #059669; font-weight: 700; font-size: 15px; }
        .info-box { background: #fffbeb; border: 1px solid #fde68a; border-radius: 10px; padding: 16px 20px; margin: 20px 0; font-size: 14px; color: #92400e; }
        .divider { height: 1px; background: linear-gradient(90deg, transparent, #ddd, transparent); margin: 25px 0; }
        .footer { background: #f8f9fa; padding: 25px 30px; text-align: center; border-top: 1px solid #e9ecef; }
        .footer-text { color: #777; font-size: 13px; margin-bottom: 8px; }
        .footer-brand { color: #059669; font-weight: 900; font-size: 18px; text-transform: uppercase; }
        @media only screen and (max-width: 600px) {
            body { padding: 20px 10px; }
            .content { padding: 25px 20px; }
            .detail-item { flex-direction: column; gap: 4px; }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="header">
            <h1>Demande Approuvée ✅</h1>
        </div>
        <div class="content">
            <div style="text-align:center;">
                <div class="icon">✅</div>
            </div>
            <p class="greeting">Bonjour {{ $claim->user->prenom ?? '' }} {{ $claim->user->nom ?? '' }},</p>
            <p class="message">
                Bonne nouvelle ! Votre demande de paiement a été <strong>approuvée</strong> par notre équipe.
                Le virement vers votre mobile money est en cours de traitement.
            </p>

            <div class="details-box">
                <div class="details-title">Détails de votre demande</div>
                <div class="detail-item">
                    <span class="detail-label">💰 Montant payé par votre client</span>
                    <span class="detail-value">{{ number_format((float)$claim->amount, 0, ',', ' ') }} {{ $claim->currency }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">📉 Frais de service ({{ number_format((float)$claim->commission_rate, 0) }}%)</span>
                    <span class="detail-value" style="color:#dc2626;">- {{ number_format((float)$claim->amount - (float)$claim->net_amount, 0, ',', ' ') }} {{ $claim->currency }}</span>
                </div>
                <div class="detail-item" style="background:#f0fdf4;border-radius:8px;padding:12px;margin-top:4px;">
                    <span class="detail-label" style="font-weight:700;color:#166534;">✅ Montant que vous recevrez</span>
                    <span class="detail-value" style="color:#059669;font-size:18px;">{{ number_format((float)$claim->net_amount, 0, ',', ' ') }} {{ $claim->currency }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">📱 Réseau</span>
                    <span class="detail-value">{{ $claim->payout_network }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">📞 Numéro</span>
                    <span class="detail-value">{{ $claim->payout_phone }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">🔖 ID Transaction</span>
                    <span class="detail-value">{{ $claim->transaction_id }}</span>
                </div>
                @if($claim->admin_note)
                <div class="detail-item">
                    <span class="detail-label">📝 Note</span>
                    <span class="detail-value">{{ $claim->admin_note }}</span>
                </div>
                @endif
            </div>

            <div class="info-box">
                ⏱️ <strong>Délai de traitement :</strong> le virement sera effectué dans les <strong>24 heures</strong>.
                Si vous ne le recevez pas dans ce délai, contactez notre support.
            </div>

            <div class="divider"></div>
            <p class="message" style="text-align:center; font-size:14px; color:#777;">
                Merci pour votre confiance. Vous pouvez suivre l'état de vos demandes depuis votre espace FlashBilan.
            </p>
        </div>
        <div class="footer">
            <p class="footer-text">Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
            <div class="footer-brand">FlashBilan</div>
            <p class="footer-text" style="margin-top:10px;">flashbilan.fr</p>
        </div>
    </div>
</body>
</html>
