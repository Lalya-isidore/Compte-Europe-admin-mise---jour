<!DOCTYPE html>
@php
    $computedLang = $emailLang ?? str_replace('_', '-', app()->getLocale());
    $emailDir = $emailDir ?? 'ltr';
@endphp
<html lang="{{ $computedLang }}" dir="{{ $emailDir }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ trim(($emailTitle ?? '') . ' - ' . __('emails.footer_brand')) }}</title>
</head>
@php
    $primaryFrom = $primaryFrom ?? '#6a5af9';
    $primaryTo = $primaryTo ?? '#c048ff';
    $bodyBackground = $bodyBackground ?? '#ffffff';
    $containerWidth = $containerWidth ?? 640;
@endphp
<body style="margin:0;padding:0;background:{{ $bodyBackground }};font-family:'Roboto', Arial, sans-serif;color:#1f2a37;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
        <tr>
            <td align="center" style="padding:32px 16px;">
                <table role="presentation" width="{{ $containerWidth }}" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:24px;overflow:hidden;border:1px solid #e6eaf2;box-shadow:0 14px 40px rgba(15,23,42,0.08);">
                    <tr>
                        <td style="background:linear-gradient(135deg, {{ $primaryFrom }} 0%, {{ $primaryTo }} 100%);padding:32px 24px;text-align:center;color:#fff;">
                            <div style="font-size:18px;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;display:flex;align-items:center;justify-content:center;gap:8px;">
                                <span class="notranslate" style="font-size:26px;">🏦</span>
                                {{ __('emails.footer_brand') }}
                            </div>
                            <p style="margin:8px 0 0;font-size:14px;font-weight:400;opacity:0.9;">{{ __('emails.footer_partner') }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:36px 32px 32px;">
                            @yield('content')
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#f7f7fb;padding:24px;text-align:center;color:#77809a;font-size:12px;border-top:1px solid #eceff5;">
                            {{ __('emails.footer_brand') }} · {{ __('emails.service_client') }}<br>
                            <span style="font-size:11px;color:#a0a7bc;">
                                {{ __('emails.alert_auto_generated_notice') }}
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
