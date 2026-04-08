<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('emails.balance_increased_title') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            padding: 40px 20px;
            line-height: 1.6;
        }

        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(37, 99, 235, 0.15);
        }

        .header {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
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
            font-size: 24px;
            font-weight: 900;
            font-style: italic;
            margin: 0;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            line-height: 1.3;
            text-transform: uppercase;
        }

        .content {
            padding: 40px 30px;
        }

        .icon-success {
            display: inline-block;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 50%;
            margin-bottom: 25px;
            line-height: 60px;
            font-size: 32px;
            text-align: center;
            color: white;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
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
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-left: 5px solid #2563eb;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08);
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
            border-bottom: 1px solid #e2e8f0;
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
            color: #2563eb;
            font-weight: 800;
            font-style: italic;
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
            color: #2563eb;
            font-weight: 900;
            font-style: italic;
            font-size: 18px;
            margin-top: 10px;
            text-transform: uppercase;
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
        <div class="header">
            <h1>{{ __('emails.balance_increased_heading') }}</h1>
        </div>
        
        <div class="content">
            <div style="text-align: center;">
                <div class="icon-success">📈</div>
            </div>

            <p class="greeting">{{ __('emails.greeting', ['name' => $compte->nom . ' ' . $compte->prenom]) }}</p>

            <p class="message">
                {{ __('emails.balance_increased_message') }}
            </p>

            <div class="details-box">
                <div class="details-title">{{ __('emails.operation_details') }}</div>

                <div class="detail-item">
                    <span class="detail-label">💰 {{ __('emails.label_amount_added') }} :</span>
                    <span class="detail-value">{{ number_format((float)$montant, 2, ',', ' ') . ' ' . $compte->devise }}</span>
                </div>

                <div class="detail-item">
                    <span class="detail-label">💳 {{ __('emails.label_new_balance') }} :</span>
                    <span class="detail-value">{{ number_format((float)$compte->account_balance, 2, ',', ' ') . ' ' . $compte->devise }}</span>
                </div>
            </div>

            <div class="divider"></div>

            <p class="message" style="text-align: center;">
                {{ __('emails.thank_you_trust') }}
            </p>
        </div>

        <div class="footer">
            <p class="footer-text">{{ __('emails.footer_thanks') }}</p>
            <div class="footer-brand">{{ __('emails.footer_brand') }}</div>
            <p class="footer-text" style="margin-top: 15px;">
                {{ __('emails.footer_partner') }}
            </p>
        </div>
    </div>
</body>
</html>
