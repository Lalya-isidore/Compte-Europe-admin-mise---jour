<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('emails.unlock_code_used_title') }} - {{ __('emails.footer_brand') }}</title>
    <style>body{margin:0;padding:0}</style>
</head>
<body style="margin:0;padding:20px;background:#f4f4f6;font-family:Arial, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:10px;overflow:hidden;">
                    <tr>
                        <td style="background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);padding:20px;text-align:center;color:#fff;font-weight:700;">{{ __('emails.unlock_code_used_heading') }}</td>
                    </tr>
                    <tr>
                        <td style="padding:24px;color:#333;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="text-align:center;padding-bottom:12px;"><div style="font-size:48px;line-height:48px;color:#ff9800;"><span class="notranslate">🔓</span></div></td>
                                </tr>
                                <tr>
                                    <td style="font-size:16px;font-weight:600;padding-bottom:12px;">{{ __('emails.greeting_simple') }}</td>
                                </tr>
                                <tr>
                                    <td style="background:#fff3cd;border-left:4px solid #ff9800;padding:12px;border-radius:6px;margin-bottom:12px;">{{ __('emails.info_notification') }} {{ __('emails.unlock_code_used_alert') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 0;">{{ __('emails.unlock_code_used_explanation') }}</td>
                                </tr>
                                <tr>
                                    <td style="background:#f8f9fa;padding:12px;border-radius:6px;margin-top:12px;">
                                        <div style="font-size:14px;margin-bottom:8px;"><strong>{{ __('emails.label_holder') }}:</strong> {{ $compte->nom }} {{ $compte->prenom }}</div>
                                        <div style="font-size:14px;margin-bottom:8px;"><strong>{{ __('emails.label_email') }}:</strong> {{ $compte->email }}</div>
                                        <div style="font-size:14px;margin-bottom:8px;"><strong>{{ __('emails.label_date_time') }}:</strong> {{ now()->format('d/m/Y à H:i') }}</div>
                                        @if($transferDetails)
                                            <div style="font-size:14px;margin-bottom:8px;"><strong>{{ __('emails.label_transfer_amount') }}:</strong> {{ number_format($transferDetails['montant'] ?? 0, 2, ',', ' ') }} {{ $compte->devise }}</div>
                                            @if(isset($transferDetails['destinataire']))
                                                <div style="font-size:14px;margin-bottom:8px;"><strong>{{ __('emails.label_recipient') }}:</strong> {{ $transferDetails['destinataire'] }}</div>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top:12px;font-weight:700;">{{ __('emails.urgent_if_not_you') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 0;">
                                        <ul style="margin:0;padding-left:18px;color:#333;">
                                            <li>{{ __('emails.contact_support_immediately') }}</li>
                                            <li>{{ __('emails.check_recent_transactions') }}</li>
                                            <li>{{ __('emails.change_access_codes') }}</li>
                                        </ul>
                                    </td>
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
