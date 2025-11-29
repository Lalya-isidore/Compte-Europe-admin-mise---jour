<!DOCTYPE html>
<html lang="{{ $compte->lang ?? app()->getLocale() }}" dir="{{ in_array($compte->lang ?? app()->getLocale(), ['ar','he','fa']) ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <!-- allow Gmail automatic translation; do not block with google:notranslate -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('emails.refund_subject') }} - {{ __('emails.footer_brand') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
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
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
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

        .header.notranslate h1 {
            color: #ffffff;
            font-size: 26px;
            font-weight: 700;
            margin: 0;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            line-height: 1.3;
        }

        .content {
            padding: 40px 30px;
        }

        .icon-refund {
            display: inline-block;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
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
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-left: 4px solid #f59e0b;
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
            border-bottom: 1px solid rgba(245, 158, 11, 0.2);
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
            color: #d97706;
            font-weight: 700;
            font-size: 15px;
            text-align: right;
        }

        .refund-notice {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border-left: 4px solid #3b82f6;
            border-radius: 12px;
            margin: 25px 0;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .refund-icon {
            font-size: 32px;
            flex-shrink: 0;
        }

        .refund-text {
            color: #1e40af;
            font-size: 15px;
            font-weight: 600;
            line-height: 1.5;
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
                font-size: 22px;
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

            .refund-notice {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <!-- Header : table-based to remain stable when Gmail injects translation spans -->
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;margin:0 auto;">
            <tr>
                <td align="center" style="background:#f59e0b;padding:40px 30px;text-align:center;">
                    <?php $title = __('emails.refund_title'); $lines = preg_split('/\r\n|\r|\n/', $title); ?>
                    @foreach($lines as $line)
                        <div style="color:#ffffff;font-size:26px;font-weight:700;line-height:1.3;margin:0;padding:0;">{{ trim($line) }}</div>
                    @endforeach
                </td>
            </tr>
        </table>

        <div class="content" style="padding:40px 30px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                <tr>
                    <td style="text-align:center;padding-bottom:12px;">
                        <div class="notranslate" style="display:inline-block;width:60px;height:60px;background:#f59e0b;border-radius:50%;line-height:60px;font-size:32px;color:#ffffff;">⚠️</div>
                    </td>
                </tr>

                <tr>
                    <td style="padding:6px 0;text-align:left;">
                        <div style="font-size:18px;color:#333;font-weight:600;">{{ __('emails.greeting', ['name' => $compte->nom . ' ' . $compte->prenom]) }}</div>
                    </td>
                </tr>

                <tr>
                    <td style="padding:12px 0;color:#555;font-size:15px;line-height:1.7;">
                        {{ __('emails.refund_failed_message') }}
                    </td>
                </tr>

                <tr>
                    <td>
                        <!-- details table kept inline for translation resilience -->
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:separate;border-spacing:0;margin:25px 0;background:#fff7d9;border-left:4px solid #f59e0b;border-radius:12px;">
                            <tr>
                                <td style="padding:18px 20px;vertical-align:top;">
                                    <div style="font-size:16px;font-weight:700;color:#333;margin-bottom:12px;">{{ __('emails.details_title') }}</div>

                                    <table role="presentation" width="100%" cellpadding="10" cellspacing="0" style="border-collapse:collapse;">
                                        <tr>
                                            <td style="width:40%;vertical-align:top;color:#666;font-size:14px;font-weight:500;padding:10px 0;">{{ __('emails.label_amount') }}</td>
                                            <td style="width:60%;vertical-align:top;color:#d97706;font-weight:700;font-size:15px;text-align:right;padding:10px 0;">{{ number_format($compte->account_balance2, 2, ',', ' ') . ' ' . $compte->devise }}</td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align:top;color:#666;font-size:14px;font-weight:500;padding:10px 0;">{{ __('emails.label_date') }}</td>
                                            <td style="vertical-align:top;color:#333;font-size:14px;text-align:right;padding:10px 0;">{{ $transfer->created_at }}</td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align:top;color:#666;font-size:14px;font-weight:500;padding:10px 0;">{{ __('emails.label_recipient') }}</td>
                                            <td style="vertical-align:top;color:#333;font-size:14px;text-align:right;padding:10px 0;">{{ $transfer->beneficiary_name }}</td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align:top;color:#666;font-size:14px;font-weight:500;padding:10px 0;">{{ __('emails.label_reason') }}</td>
                                            <td style="vertical-align:top;color:#333;font-size:14px;text-align:right;padding:10px 0;">{{ $transfer->reason }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;margin:25px 0;">
                            <tr>
                                <td style="background:#dbeafe;border-left:4px solid #3b82f6;border-radius:12px;padding:18px 20px;">
                                    @php
                                        $amountHtml = '<strong>' . number_format($compte->account_balance2, 2, ',', ' ') . ' ' . $compte->devise . '</strong>';
                                        // Keep translation strings free of presentation HTML; inject the amount HTML safely afterwards
                                        $refundRaw = str_replace(':amount', $amountHtml, __('emails.refund_notice'));
                                    @endphp
                                    <div class="notranslate" style="vertical-align:middle;font-size:15px;font-weight:600;color:#1e40af;">💳&nbsp;&nbsp;{!! $refundRaw !!}</div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="padding-top:6px;padding-bottom:6px;">
                        <div style="height:1px;background:#e6e6e6;width:100%;"></div>
                    </td>
                </tr>

                <tr>
                    <td style="padding:12px 0;text-align:center;color:#555;font-size:15px;">
                        {{ __('emails.apology') }}
                    </td>
                </tr>
            </table>
        </div>

        <!-- Footer as table-based block with inline styles -->
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;background:#f8f9fa;">
            <tr>
                <td style="padding:24px;text-align:center;border-top:1px solid #e9ecef;">
                    <div style="color:#777;font-size:13px;margin-bottom:8px;">{{ __('emails.footer_thanks') }}</div>
                    <div style="color:#667eea;font-weight:700;font-size:18px;margin-bottom:6px;">{{ __('emails.footer_brand') }}</div>
                    <div style="color:#777;font-size:13px;margin-top:6px;">{{ __('emails.footer_partner') }}</div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
