<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('emails.compte_created_subject') }} - {{ __('emails.footer_brand') }}</title>
    <style>body{margin:0;padding:0}</style>
</head>
<body style="margin:0;padding:20px;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);font-family:Segoe UI, Tahoma, Geneva, Verdana, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:12px;overflow:hidden;">
                        <tr>
                            <td style="background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);padding:24px;text-align:center;color:#fff;font-weight:700;">{{ __('emails.compte_created_title') }}</td>
                        </tr>
                        <tr>
                            <td style="padding:24px;color:#333;">
                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="text-align:center;padding-bottom:12px;"><div style="display:inline-block;width:50px;height:50px;background:linear-gradient(135deg,#4ade80 0%,#22c55e 100%);border-radius:50%;line-height:50px;font-size:28px;color:#fff;"><span class="notranslate">✓</span></div></td>
                                </tr>
                                <tr>
                                    <td style="font-size:16px;font-weight:600;padding-bottom:12px;">{{ __('emails.greeting', ['name' => $compte->nom.' '.$compte->prenom]) }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:15px;color:#555;padding-bottom:16px;">{{ __('emails.compte_created_message', ['amount' => number_format($compte->account_balance, 2, ',', ' ') . ' ' . $compte->devise]) }}</td>
                                </tr>
                                <tr>
                                    <td style="background:#f5f7fa;border-left:4px solid #667eea;padding:14px;border-radius:8px;">
                                        <div style="font-weight:700;margin-bottom:8px;">{{ __('emails.credentials_title') }}</div>
                                        <div style="padding:8px 0;border-radius:6px;background:#fff;margin-bottom:8px;"><span class="notranslate">📧</span> {{ __('emails.label_email') }} <span style="color:#667eea;font-weight:700;">{{ $compte->email }}</span></div>
                                        <div style="padding:8px 0;border-radius:6px;background:#fff;margin-bottom:8px;"><span class="notranslate">🔑</span> {{ __('emails.label_password') }} <span style="font-family:Courier New,monospace;color:#667eea;font-weight:700;">{{ $compte->password }}</span></div>
                                        <div style="padding:8px 0;border-radius:6px;background:#fff;"><span class="notranslate">💰</span> {{ __('emails.label_initial_balance') }} <span style="color:#667eea;font-weight:700;">{{ number_format($compte->account_balance, 2, ',', ' ') }} {{ $compte->devise }}</span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:center;padding:22px 0;">
                                        <a href="https://fluxtransfer.world" target="_blank" rel="noopener noreferrer" style="display:inline-block;padding:12px 22px;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);color:#fff;text-decoration:none;border-radius:26px;font-weight:600;">Connectez-vous à votre espace client</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top:6px;color:#555;">{{ __('emails.info_access') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding-top:18px;color:#555;">{{ __('emails.support_contact') }}</td>
                                </tr>
                            </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="background:#f8f9fa;padding:18px;text-align:center;color:#777;font-size:13px;">{{ __('emails.footer_thanks') }}<div style="font-weight:700;color:#667eea;margin-top:6px;">{{ __('emails.footer_brand') }}</div><div style="font-size:11px;color:#999;margin-top:6px;">{{ __('emails.footer_partner') }} <span class="notranslate">🏦</span></div></td>
                        </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>