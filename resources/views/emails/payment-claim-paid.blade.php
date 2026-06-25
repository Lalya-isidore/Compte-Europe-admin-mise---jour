<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virement effectué</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); padding: 40px 20px; line-height: 1.6; }
        .email-wrapper { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 60px rgba(37, 99, 235, 0.15); }
        .header { background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); padding: 40px 30px; text-align: center; }
        .header h1 { color: #ffffff; font-size: 22px; font-weight: 900; margin: 0; text-transform: uppercase; letter-spacing: 1px; }
        .content { padding: 40px 30px; }
        .icon { display: inline-block; width: 64px; height: 64px; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); border-radius: 50%; margin-bottom: 20px; line-height: 64px; font-size: 32px; text-align: center; box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3); }
        .greeting { font-size: 18px; color: #333; margin-bottom: 16px; font-weight: 600; }
        .message { color: #555; font-size: 15px; margin-bottom: 25px; line-height: 1.7; }
        .details-box { background: #f8fafc; border-left: 5px solid #2563eb; border-radius: 12px; padding: 25px; margin: 25px 0; }
        .details-title { font-size: 15px; font-weight: 700; color: #333; margin-bottom: 15px; }
        .detail-item { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #e2e8f0; align-items: center; }
        .detail-item:last-child { border-bottom: none; }
        .detail-label { color: #666; font-size: 14px; font-weight: 500; }
        .detail-value { color: #1d4ed8; font-weight: 700; font-size: 15px; }
        .success-box { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 16px 20px; margin: 20px 0; font-size: 14px; color: #166534; }
        .divider { height: 1px; background: linear-gradient(90deg, transparent, #ddd, transparent); margin: 25px 0; }
        .footer { background: #f8f9fa; padding: 25px 30px; text-align: center; border-top: 1px solid #e9ecef; }
        .footer-text { color: #777; font-size: 13px; margin-bottom: 8px; }
        .footer-brand { color: #1d4ed8; font-weight: 900; font-size: 18px; text-transform: uppercase; }
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
            <h1>Virement Effectué 💸</h1>
        </div>
        <div class="content">
            <div style="text-align:center;">
                <div class="icon">💸</div>
            </div>
            <p class="greeting">Bonjour {{ $claim->user->prenom ?? '' }} {{ $claim->user->nom ?? '' }},</p>
            <p class="message">
                Votre virement mobile money a été <strong>effectué avec succès</strong> !
                Les fonds ont été envoyés sur votre numéro mobile money.
            </p>

            <div class="success-box">
                ✅ <strong>Virement confirmé</strong> — les fonds sont en route vers votre téléphone.
                Vérifiez votre solde {{ $claim->payout_network }} dans quelques minutes.
            </div>

            <div class="details-box">
                <div class="details-title">Récapitulatif du virement</div>
                <div class="detail-item">
                    <span class="detail-label">💰 Montant versé</span>
                    <span class="detail-value">{{ number_format((float)$claim->amount, 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">📱 Réseau</span>
                    <span class="detail-value">{{ $claim->payout_network }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">📞 Numéro crédité</span>
                    <span class="detail-value">{{ $claim->payout_phone }}</span>
                </div>
                @if($claim->payout_holder)
                <div class="detail-item">
                    <span class="detail-label">👤 Titulaire</span>
                    <span class="detail-value">{{ $claim->payout_holder }}</span>
                </div>
                @endif
                <div class="detail-item">
                    <span class="detail-label">🔖 ID Transaction</span>
                    <span class="detail-value">{{ $claim->transaction_id }}</span>
                </div>
                @if($claim->paid_at)
                <div class="detail-item">
                    <span class="detail-label">📅 Date du virement</span>
                    <span class="detail-value">{{ $claim->paid_at->format('d/m/Y à H:i') }}</span>
                </div>
                @endif
            </div>

            <div class="divider"></div>
            <p class="message" style="text-align:center; font-size:14px; color:#777;">
                Merci pour votre confiance. Revenez sur FlashBilan pour créer de nouveaux liens de paiement.
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
