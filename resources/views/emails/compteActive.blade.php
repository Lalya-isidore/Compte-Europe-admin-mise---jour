<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('emails.compte_activated_title') }} - {{ __('emails.footer_brand') }}</title>
    <style>body{margin:0;padding:0}</style>
</head>
<body style="margin:0;padding:20px;font-family:Arial, sans-serif;background:#f4f4f6;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:10px;overflow:hidden;">
                    <tr>
                        <td style="background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);padding:20px;text-align:center;color:#fff;font-weight:700;"><span class="notranslate">🏦</span> {{ __('emails.footer_brand') }}<p style="margin:6px 0 0;font-size:13px;font-weight:400;">{{ __('emails.footer_partner') }}</p></td>
                    </tr>
                    <tr>
                        <td style="padding:20px;color:#333;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="text-align:center;padding-bottom:12px;"><div style="font-size:48px;line-height:48px;color:#28a745;"><span class="notranslate">✅</span></div></td>
                                </tr>
                                        <tr>
                                            <td style="font-size:20px;color:#28a745;font-weight:700;padding-bottom:12px;">{{ __('emails.compte_activated_heading') }}</td>
                                        </tr>
                                <tr>
                                    <td style="padding-bottom:12px;">{{ __('emails.greeting', ['name' => $compte->nom . ' ' . $compte->prenom]) }}</td>
                                </tr>
                                <tr>
                                    <td style="background:#d4edda;border-left:4px solid #28a745;padding:12px;border-radius:6px;margin-bottom:12px;"><span class="notranslate">✅</span> <strong>{{ __('emails.good_news') }}</strong> {{ __('emails.compte_activated_message') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 0;">{{ __('emails.compte_activated_explanation') }}</td>
                                </tr>
                                <tr>
                                    <td style="background:#f8f9fa;padding:12px;border-radius:6px;margin-top:12px;">
                                        <div style="font-size:14px;margin-bottom:8px;"><strong>{{ __('emails.label_holder') }} :</strong> {{ $compte->nom }} {{ $compte->prenom }}</div>
                                        <div style="font-size:14px;margin-bottom:8px;"><strong>{{ __('emails.label_email') }} :</strong> {{ $compte->email }}</div>
                                        <div style="font-size:14px;"><strong>{{ __('emails.label_current_balance') }} :</strong> {{ number_format($compte->account_balance, 2, ',', ' ') }} {{ $compte->devise }}</div>
                                    </td>
                                </tr>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top:12px;">{{ __('emails.thanks_welcome') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding-top:18px;color:#333;">{{ __('emails.regards') }}<br><strong>{{ __('emails.footer_brand') }}</strong></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#f8f9fa;padding:16px;text-align:center;color:#666;font-size:13px;">{{ __('emails.footer_brand') }} - {{ __('emails.service_client') }}<br><span style="font-size:11px;color:#999;">{{ __('emails.alert_auto_generated_notice') }}</span></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
