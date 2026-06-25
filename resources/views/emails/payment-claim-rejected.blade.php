<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande rejetée</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #fff1f2 0%, #ffe4e6 100%); padding: 40px 20px; line-height: 1.6; }
        .email-wrapper { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 60px rgba(239, 68, 68, 0.15); }
        .header { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); padding: 40px 30px; text-align: center; }
        .header h1 { color: #ffffff; font-size: 22px; font-weight: 900; margin: 0; text-transform: uppercase; letter-spacing: 1px; }
        .content { padding: 40px 30px; }
        .icon { display: inline-block; width: 64px; height: 64px; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); border-radius: 50%; margin-bottom: 20px; line-height: 64px; font-size: 32px; text-align: center; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3); }
        .greeting { font-size: 18px; color: #333; margin-bottom: 16px; font-weight: 600; }
        .message { color: #555; font-size: 15px; margin-bottom: 25px; line-height: 1.7; }
        .details-box { background: #f8fafc; border-left: 5px solid #ef4444; border-radius: 12px; padding: 25px; margin: 25px 0; }
        .details-title { font-size: 15px; font-weight: 700; color: #333; margin-bottom: 15px; }
        .detail-item { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #e2e8f0; align-items: center; }
        .detail-item:last-child { border-bottom: none; }
        .detail-label { color: #666; font-size: 14px; font-weight: 500; }
        .detail-value { color: #dc2626; font-weight: 700; font-size: 15px; }
        .reason-box { background: #fef2f2; border: 1px solid #fecaca; border-radius: 10px; padding: 16px 20px; margin: 20px 0; font-size: 14px; color: #991b1b; }
        .info-box { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 16px 20px; margin: 20px 0; font-size: 14px; color: #1e40af; }
        .divider { height: 1px; background: linear-gradient(90deg, transparent, #ddd, transparent); margin: 25px 0; }
        .footer { background: #f8f9fa; padding: 25px 30px; text-align: center; border-top: 1px solid #e9ecef; }
        .footer-text { color: #777; font-size: 13px; margin-bottom: 8px; }
        .footer-brand { color: #dc2626; font-weight: 900; font-size: 18px; text-transform: uppercase; }
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
            <h1>Demande Rejetée ✗</h1>
        </div>
        <div class="content">
            <div style="text-align:center;">
                <div class="icon">✗</div>
            </div>
            <p class="greeting">Bonjour {{ $claim->user->prenom ?? '' }} {{ $claim->user->nom ?? '' }},</p>
            <p class="message">
                Nous vous informons que votre demande de paiement a été <strong>rejetée</strong> par notre équipe après vérification.
            </p>

            <div class="reason-box">
                ❌ <strong>Motif du rejet :</strong> {{ $claim->rejection_reason }}
            </div>

            <div class="details-box">
                <div class="details-title">Détails de la demande rejetée</div>
                <div class="detail-item">
                    <span class="detail-label">💰 Montant</span>
                    <span class="detail-value">{{ number_format((float)$claim->amount, 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">🔖 ID Transaction</span>
                    <span class="detail-value">{{ $claim->transaction_id }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">📅 Date de soumission</span>
                    <span class="detail-value">{{ $claim->created_at->format('d/m/Y à H:i') }}</span>
                </div>
            </div>

            <div class="info-box">
                💡 <strong>Que faire ?</strong> Si vous pensez qu'il s'agit d'une erreur ou si vous avez des questions,
                contactez notre support en précisant votre ID de transaction <strong>{{ $claim->transaction_id }}</strong>.
            </div>

            <div class="divider"></div>
            <p class="message" style="text-align:center; font-size:14px; color:#777;">
                Vous pouvez soumettre une nouvelle demande depuis votre espace FlashBilan si nécessaire.
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
