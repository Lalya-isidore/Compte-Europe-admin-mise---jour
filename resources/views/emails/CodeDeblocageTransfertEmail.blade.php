<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('emails.transfer_unlock_code_title') }}</title>
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

        .icon-lock {
            display: inline-block;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            border-radius: 50%;
            margin-bottom: 25px;
            line-height: 60px;
            font-size: 32px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
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
            margin-bottom: 30px;
            line-height: 1.7;
        }

        .amount-info {
            background: linear-gradient(135deg, #f8fafc 0%, #eff6ff 100%);
            border-left: 5px solid #2563eb;
            border-radius: 12px;
            padding: 20px 25px;
            margin: 25px 0;
            font-size: 16px;
            color: #333;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08);
        }

        .amount-info strong {
            color: #2563eb;
            font-size: 19px;
            font-weight: 800;
            font-style: italic;
        }

        .code-box {
            background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
            border-radius: 16px;
            padding: 35px;
            text-align: center;
            margin: 30px 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
        }

        .code-box::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.05), transparent);
            transform: rotate(45deg);
        }

        .code-label {
            color: #a0aec0;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .code {
            font-size: 48px;
            letter-spacing: 8px;
            font-weight: 900;
            color: #ffffff;
            font-family: 'Courier New', monospace;
            margin: 10px 0;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 1;
        }

        .warning-box {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border-left: 4px solid #ef4444;
            border-radius: 12px;
            padding: 20px 25px;
            margin: 30px 0;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .warning-icon {
            font-size: 32px;
            flex-shrink: 0;
        }

        .warning-text {
            color: #991b1b;
            font-size: 15px;
            font-weight: 600;
            line-height: 1.5;
        }

        .info-text {
            color: #555;
            font-size: 14px;
            line-height: 1.7;
            margin: 20px 0;
            text-align: center;
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
                font-size: 20px;
            }

            .content {
                padding: 30px 20px;
            }

            .code {
                font-size: 36px;
                letter-spacing: 5px;
            }

            .warning-box {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="header">
            <h1>{{ __('emails.transfer_unlock_heading') }}</h1>
        </div>

        <div class="content">
            <div style="text-align: center;">
                <div class="icon-lock">🔐</div>
            </div>

            <p class="greeting">{{ __('emails.greeting', ['name' => $compte->nom . ' ' . $compte->prenom]) }}</p>

            <p class="message">
                {{ __('emails.transfer_unlock_amount_intro') }}
            </p>

            <div class="amount-info">
                <strong>{{ number_format((float)$compte->account_balance2, 2, ',', ' ') . ' ' . $compte->devise }}</strong>
            </div>

            <p class="message">
                {{ __('emails.transfer_unlock_code_label') }}
            </p>

            <div class="code-box">
                <div class="code-label">{{ __('emails.your_unlock_code') }}</div>
                <div class="code">{{ $compte->code_virement }}</div>
            </div>

            <div class="warning-box">
                <div class="warning-icon">⚠️</div>
                <div class="warning-text">
                    {{ __('emails.do_not_share_unlock_code') }}<br>
                    {{ __('emails.unlock_code_personal_confidential') }}
                </div>
            </div>

            <div class="divider"></div>

            <p class="info-text">
                {{ __('emails.unlock_code_needed_finalize') }}<br>
                {{ __('emails.contact_support_for_questions') }}
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