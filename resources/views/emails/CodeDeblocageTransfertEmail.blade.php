<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('emails.transfer_unlock_code_title') }} - {{ __('emails.footer_brand') }}</title>
    <style>body{margin:0;padding:0}</style>
</head>
<body style="margin:0;padding:20px;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);font-family:Segoe UI, Tahoma, Geneva, Verdana, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:12px;overflow:hidden;">
                    <tr>
                        <td style="background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);padding:20px;text-align:center;color:#fff;font-weight:700;">{{ __('emails.transfer_unlock_heading') }}</td>
                    </tr>
                    <tr>
                        <td style="padding:24px;color:#333;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="text-align:center;padding-bottom:12px;"><div style="display:inline-block;width:60px;height:60px;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);border-radius:50%;line-height:60px;font-size:32px;color:#fff;"><span class="notranslate">🔐</span></div></td>
                                </tr>
                                <tr>
                                    <td style="font-size:16px;font-weight:600;padding-bottom:12px;">{{ __('emails.greeting', ['name' => $compte->nom.' '.$compte->prenom]) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom:12px;color:#555;">{{ __('emails.transfer_unlock_message_intro') }}</td>
                                </tr>
                                <tr>
                                    <td style="background:#f5f7fa;border-left:4px solid #667eea;padding:12px;border-radius:8px;margin-bottom:12px;text-align:center;font-size:16px;color:#333;"><strong>{{ $compte->account_balance2.' '.$compte->devise }}</strong></td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom:12px;color:#555;">{{ __('emails.transfer_unlock_code_label') }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align:center;padding:20px 0;">
                                        <div style="display:inline-block;background:#1a202c;color:#fff;padding:24px 30px;border-radius:12px;font-family:Courier New,monospace;font-size:36px;letter-spacing:6px;font-weight:900;">{{ $compte->code_virement }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="background:#fee2e2;border-left:4px solid #ef4444;padding:12px;border-radius:8px;margin-top:12px;color:#991b1b;font-weight:600;text-align:left;"><span class="notranslate">⚠️</span> {{ __('emails.do_not_share_unlock_code') }} {{ __('emails.unlock_code_personal_confidential') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding-top:18px;text-align:center;color:#555;">{{ __('emails.unlock_code_needed_finalize') }} {{ __('emails.contact_support_for_questions') }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#f8f9fa;padding:18px;text-align:center;color:#777;font-size:13px;">{{ __('emails.footer_thanks') }}<div style="font-weight:700;color:#667eea;margin-top:6px;">{{ __('emails.footer_brand') }}</div></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>