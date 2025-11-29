<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('emails.balance_decreased_title') }} - {{ __('emails.footer_brand') }}</title>
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

        .icon-warning {
            display: inline-block;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border-radius: 50%;
            margin-bottom: 25px;
            line-height: 60px;
            font-size: 32px;
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
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #666;
            font-size: 14px;
        }

        .detail-value {
            color: #dc2626;
            font-weight: 700;
            font-size: 16px;
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
                gap: 5px;
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
                            <td style="background:linear-gradient(135deg,#ef4444 0%,#dc2626 100%);padding:20px;text-align:center;color:#fff;font-weight:700;">{{ __('emails.balance_decreased_heading') }}</td>
                        </tr>
                        <tr>
                            <td style="padding:24px;color:#333;">
                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="text-align:center;padding-bottom:12px;"><div style="font-size:48px;line-height:48px;color:#ef4444;"><span class="notranslate">📉</span></div></td>
                                    </tr>
                                    <tr>
                                        <td style="font-size:16px;font-weight:600;padding-bottom:12px;">{{ __('emails.greeting', ['name' => $compte->nom . ' ' . $compte->prenom]) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom:12px;color:#555;">{{ __('emails.balance_decreased_message') }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:separate;border-spacing:0;margin:18px 0;background:#fee2e2;border-left:4px solid #ef4444;border-radius:10px;padding:12px;">
                                                <tr>
                                                    <td style="font-size:16px;font-weight:700;color:#333;padding-bottom:8px;">{{ __('emails.operation_details') }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:8px 0;">
                                                        <table role="presentation" width="100%" cellpadding="4" cellspacing="0" style="border-collapse:collapse;">
                                                            <tr>
                                                                <td style="width:50%;color:#666;"><span class="notranslate">💸</span> {{ __('emails.label_amount_deducted') }}</td>
                                                                <td style="width:50%;text-align:right;color:#dc2626;font-weight:700;">{{ number_format($montant, 2, ',', ' ') . ' ' . $compte->devise }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="color:#666;padding-top:6px;"><span class="notranslate">💳</span> {{ __('emails.label_new_balance') }}</td>
                                                                <td style="text-align:right;padding-top:6px;color:#333;">{{ number_format($compte->account_balance, 2, ',', ' ') . ' ' . $compte->devise }}</td>
                                                            </tr>
                                                        </table>
                                                            <!-- duplicate rows removed to fix table nesting and layout in email clients -->
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
    </div>
</body>
</html>
