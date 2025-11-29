
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('emails.password_reset_title') }} - {{ __('emails.footer_brand') }}</title>
    <style>body{margin:0;padding:0}</style>
</head>
<body style="margin:0;padding:20px;font-family:Segoe UI, Tahoma, Geneva, Verdana, sans-serif;background:#f5f5f7;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:10px;overflow:hidden;">
                    <tr>
                        <td style="background:#667eea;padding:24px 30px;text-align:center;color:#fff;font-weight:700;font-size:20px;">{{ __('emails.footer_brand') }}</td>
                    </tr>
                    <tr>
                        <td style="padding:28px 30px;color:#333;font-size:15px;line-height:1.6;">
                            <div style="font-size:18px;font-weight:600;margin-bottom:12px;">{{ __('emails.password_reset_heading') }}</div>
                            <div style="margin-bottom:12px;">{{ __('emails.greeting', ['name' => $user->name]) }}</div>
                            <div style="margin-bottom:12px;">{{ __('emails.password_reset_reason') }}</div>
                            <div style="margin-bottom:12px;">{{ __('emails.password_reset_click_link') }}</div>
                            <div style="text-align:center;margin:18px 0;">
                                <a href="{{ $url }}" style="display:inline-block;padding:12px 20px;background:#667eea;color:#fff;text-decoration:none;border-radius:6px;font-weight:600;">{{ __('emails.password_reset_button') }}</a>
                            </div>
                            <div style="color:#666;font-size:13px;margin-top:8px;">{{ __('emails.password_reset_no_action_needed') }}</div>
                            <div style="margin-top:18px;color:#333;">{{ __('emails.thanks') }}<br>{{ __('emails.footer_brand') }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#f8f9fa;padding:18px 30px;text-align:center;color:#777;font-size:13px;">{{ __('emails.footer_brand') }} - {{ __('emails.service_client') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
