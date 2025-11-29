<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('emails.virement_failed_subject') }} - {{ __('emails.footer_brand') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            padding: 40px 20px;
            line-height: 1.6;
        }

        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .header {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="40" fill="rgba(255,255,255,0.1)"/></svg>');
            opacity: 0.1;
        }

        .header h1 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            margin: 0;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .content {
            padding: 40px 30px;
        }

        .icon-error {
            display: inline-block;
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border-radius: 50%;
            margin-bottom: 25px;
            line-height: 70px;
            font-size: 40px;
        }

        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .message {
            color: #555;
            font-size: 15px;
            margin-bottom: 25px;
            line-height: 1.7;
        }

        .details-box {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border-left: 4px solid #ef4444;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .details-title {
            font-size: 16px;
            font-weight: 700;
            color: #333;
            margin-bottom: 15px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid rgba(239, 68, 68, 0.2);
            align-items: center;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #666;
            font-size: 14px;
            font-weight: 500;
        }

        .detail-value {
            color: #dc2626;
            font-weight: 700;
            font-size: 15px;
            text-align: right;
        }

        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #ddd, transparent);
            margin: 30px 0;
        }

        .footer {
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }

        .footer-text {
            color: #777;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .footer-brand {
            color: #667eea;
            font-weight: 700;
            font-size: 18px;
            margin-top: 10px;
        }

        @media only screen and (max-width: 600px) {
            body {
                padding: 20px 10px;
            }

            .header h1 {
                font-size: 24px;
            }

            .content {
                padding: 30px 20px;
            }

            .detail-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }

            .detail-value {
                text-align: left;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
            <tr>
                <td align="center">
                    <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:12px;overflow:hidden;">
                        <tr>
                            <td style="background:linear-gradient(135deg,#ef4444 0%,#dc2626 100%);padding:20px;text-align:center;color:#fff;font-weight:700;">{{ __('emails.virement_failed_title') }}</td>
                        <tr>
                            <td style="background:#f8f9fa;padding:16px;text-align:center;color:#777;font-size:13px;">{{ __('emails.footer_thanks') }}<div style="font-weight:700;color:#10b981;margin-top:6px;">{{ __('emails.footer_brand') }}</div></td>
                        </tr>
                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="text-align:center;padding-bottom:12px;"><div style="font-size:48px;line-height:48px;color:#ef4444;"><span class="notranslate">✗</span></div></td>
                                    </tr>
                                    <tr>
                                        <td style="font-size:16px;font-weight:600;padding-bottom:12px;">{{ __('emails.greeting', ['name' => $compte->nom . ' ' . $compte->prenom]) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom:12px;color:#555;">{{ __('emails.virement_failed_message') }}</td>
                                    </tr>
                                            <tr>
                                                <td>
                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:separate;border-spacing:0;margin:20px 0;background:#fee2e2;border-left:4px solid #ef4444;border-radius:12px;padding:18px;">
                                                        <tr>
                                                            <td style="font-size:16px;font-weight:700;color:#333;padding-bottom:12px;">{{ __('emails.details_title') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding:6px 0;">
                                                                <table role="presentation" width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse;">
                                                                    <tr>
                                                                        <td style="width:50%;color:#666;padding:8px 0;vertical-align:top;"><span class="notranslate">💰</span> <strong style="display:inline-block;margin-left:6px;font-weight:600;">{{ __('emails.label_amount') }}</strong></td>
                                                                        <td style="width:50%;text-align:right;color:#dc2626;font-weight:700;padding:8px 0;vertical-align:top;">{{ $transfer->solidvire }} {{ $compte->devise }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="color:#666;padding:8px 0;vertical-align:top;"><span class="notranslate">📅</span> <strong style="display:inline-block;margin-left:6px;font-weight:600;">{{ __('emails.label_date') }}</strong></td>
                                                                        <td style="text-align:right;color:#333;padding:8px 0;vertical-align:top;">{{ $transfer->created_at->format('d/m/Y H:i') }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="color:#666;padding:8px 0;vertical-align:top;"><span class="notranslate">👤</span> <strong style="display:inline-block;margin-left:6px;font-weight:600;">{{ __('emails.label_beneficiary') }}</strong></td>
                                                                        <td style="text-align:right;color:#333;padding:8px 0;vertical-align:top;">{{ $transfer->beneficiary_name }}</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                    <tr>
                                        <td style="padding-top:12px;text-align:center;color:#555;">Pour plus d'informations, veuillez contacter notre service client.</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="background:#f8f9fa;padding:16px;text-align:center;color:#777;font-size:13px;">{{ __('emails.footer_thanks') }}<div style="font-weight:700;color:#667eea;margin-top:6px;">{{ __('emails.footer_brand') }}</div></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
