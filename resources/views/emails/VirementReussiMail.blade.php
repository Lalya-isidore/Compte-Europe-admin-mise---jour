<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('emails.virement_success_subject') }} - {{ __('emails.footer_brand') }}</title>
    <style>body{margin:0;padding:0}</style>
</head>
<body style="margin:0;padding:20px;background:linear-gradient(135deg,#10b981 0%,#059669 100%);font-family:Segoe UI, Tahoma, Geneva, Verdana, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:12px;overflow:hidden;">
                    <tr>
                        <td style="background:linear-gradient(135deg,#10b981 0%,#059669 100%);padding:20px;text-align:center;color:#fff;font-weight:700;">{{ __('emails.virement_success_title') }}</td>
                    </tr>
                    <tr>
                        <td style="padding:24px;color:#333;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="text-align:center;padding-bottom:12px;"><div style="font-size:48px;line-height:48px;color:#fff;"><span class="notranslate">✓</span></div></td>
                                </tr>
                                <tr>
                                    <td style="font-size:16px;font-weight:600;padding-bottom:12px;">{{ __('emails.greeting', ['name' => $compte->nom . ' ' . $compte->prenom]) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom:12px;color:#555;">{{ __('emails.virement_success_message') }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:separate;border-spacing:0;margin:18px 0;background:#ecfdf5;border-left:4px solid #10b981;border-radius:10px;padding:12px;">
                                            <tr>
                                                <td style="font-size:16px;font-weight:700;color:#333;padding-bottom:8px;">{{ __('emails.details_title') }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding:8px 0;">
                                                    <table role="presentation" width="100%" cellpadding="4" cellspacing="0" style="border-collapse:collapse;">
                                                        <tr>
                                                            <td style="width:50%;color:#666;"><span class="notranslate">💰</span> {{ __('emails.label_amount') }}</td>
                                                            <td style="width:50%;text-align:right;color:#059669;font-weight:700;">{{ $transfer->solidvire }} {{ $compte->devise }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="color:#666;padding-top:6px;"><span class="notranslate">📅</span> {{ __('emails.label_date') }}</td>
                                                            <td style="text-align:right;padding-top:6px;color:#333;">{{ $transfer->created_at->format('d/m/Y H:i') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="color:#666;padding-top:6px;"><span class="notranslate">👤</span> {{ __('emails.label_beneficiary') }}</td>
                                                            <td style="text-align:right;padding-top:6px;color:#333;">{{ $transfer->beneficiary_name }}</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top:12px;text-align:center;color:#1e40af;font-style:italic;">{{ __('emails.virement_notice') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding-top:18px;text-align:center;color:#555;">{{ __('emails.thanks') }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#f8f9fa;padding:16px;text-align:center;color:#777;font-size:13px;">{{ __('emails.footer_thanks') }}<div style="font-weight:700;color:#10b981;margin-top:6px;">{{ __('emails.footer_brand') }}</div></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
