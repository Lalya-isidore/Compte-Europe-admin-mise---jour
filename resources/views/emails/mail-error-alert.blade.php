@extends('emails.layouts.modern')

@php
    $emailTitle = __('emails.system_alert');
    $primaryFrom = '#dc2626';
    $primaryTo = '#b91c1c';
@endphp

@section('content')
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="text-align:center;padding-bottom:12px;">
                <span style="display:inline-block;width:74px;height:74px;line-height:74px;border-radius:50%;background:#fef2f2;text-align:center;font-size:32px;color:#b91c1c;vertical-align:middle;">
                    <span class="notranslate">🚨</span>
                </span>
            </td>
        </tr>
        <tr>
            <td style="font-size:24px;color:#b91c1c;font-weight:700;text-align:center;padding-bottom:8px;">
                {{ __('emails.mail_send_failure_detected') }}
            </td>
        </tr>
        <tr>
            <td style="text-align:center;font-size:15px;color:#5f6b7d;padding-bottom:18px;">
                {{ __('emails.email_send_failure_explanation') }}
            </td>
        </tr>
        <tr>
            <td>
                <div style="background:#fff6da;border-left:5px solid #facc15;padding:18px 20px;border-radius:16px;font-size:14px;color:#854d0e;margin-bottom:22px;">
                    {{ __('emails.system_alert') }} · {{ __('emails.mail_send_failure_detected') }}
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;border-radius:20px;border:1px solid #e2e8f0;padding:22px;margin-bottom:24px;">
                    <tr>
                        <td style="font-size:13px;font-weight:700;color:#64748b;letter-spacing:0.08em;text-transform:uppercase;padding-bottom:14px;">{{ __('emails.error_details') }}</td>
                    </tr>
                    <tr>
                        <td style="font-size:14px;color:#1f2937;padding-bottom:10px;">
                            <strong>{{ __('emails.label_date_time') }}:</strong> {{ now()->format('d/m/Y \à H:i:s') }}
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size:14px;color:#1f2937;padding-bottom:10px;">
                            <strong>{{ __('emails.label_failed_recipient') }}:</strong> {{ $failedRecipient }}
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size:14px;color:#1f2937;padding-bottom:10px;">
                            <strong>{{ __('emails.label_context') }}:</strong> {{ $context }}
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size:14px;color:#b91c1c;background:#fff;border-radius:14px;padding:14px;border:1px solid #fee2e2;font-family:'Courier New',monospace;">
                            <strong>{{ __('emails.label_error_message') }}:</strong><br>{{ $errorMessage }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <div style="background:#eff6ff;border-left:5px solid #2563eb;border-radius:16px;padding:18px 20px;margin-bottom:20px;">
                    <div style="font-size:15px;font-weight:700;color:#1d4ed8;margin-bottom:10px;">{{ __('emails.possible_causes') }}</div>
                    <ul style="margin:0;padding-left:20px;color:#1e3a8a;font-size:14px;line-height:1.7;">
                        <li><strong>{{ __('emails.cause_daily_limit') }}:</strong> {{ __('emails.cause_daily_limit_details') }}</li>
                        <li><strong>{{ __('emails.cause_smtp_connection') }}:</strong> {{ __('emails.cause_smtp_connection_details') }}</li>
                        <li><strong>{{ __('emails.cause_auth_failed') }}:</strong> {{ __('emails.cause_auth_failed_details') }}</li>
                        <li><strong>{{ __('emails.cause_app_password_revoked') }}:</strong> {{ __('emails.cause_app_password_revoked_details') }}</li>
                    </ul>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="background:#ecfeff;border-left:5px solid #0f766e;border-radius:16px;padding:18px 20px;margin-bottom:20px;">
                    <div style="font-size:15px;font-weight:700;color:#115e59;margin-bottom:10px;">{{ __('emails.recommended_actions') }}</div>
                    <ol style="margin:0;padding-left:20px;color:#134e4a;font-size:14px;line-height:1.7;">
                        <li><strong>{{ __('emails.action_if_limit') }}:</strong> {{ __('emails.action_if_limit_details') }}</li>
                        <li><strong>{{ __('emails.action_check_logs') }}:</strong> {{ __('emails.action_check_logs_details') }}</li>
                        <li><strong>{{ __('emails.action_test_connection') }}:</strong> {{ __('emails.action_test_connection') }}</li>
                        <li><strong>{{ __('emails.action_check_config') }}:</strong> {{ __('emails.action_check_config_details') }}</li>
                        <li><strong>{{ __('emails.action_regenerate_password') }}:</strong> {{ __('emails.action_regenerate_password_details') }}</li>
                    </ol>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f9fafb;border-radius:18px;border:1px solid #e5e7eb;padding:18px 20px;margin-bottom:20px;">
                    <tr>
                        <td style="font-size:14px;font-weight:700;color:#374151;padding-bottom:10px;text-transform:uppercase;letter-spacing:0.08em;">{{ __('emails.system_information') }}</td>
                    </tr>
                    <tr>
                        <td style="font-size:14px;color:#4b5563;padding-bottom:6px;"><strong>{{ __('emails.label_smtp_server') }}:</strong> {{ config('mail.host') }}</td>
                    </tr>
                    <tr>
                        <td style="font-size:14px;color:#4b5563;padding-bottom:6px;"><strong>{{ __('emails.label_port') }}:</strong> {{ config('mail.port') }}</td>
                    </tr>
                    <tr>
                        <td style="font-size:14px;color:#4b5563;padding-bottom:6px;"><strong>{{ __('emails.label_account') }}:</strong> {{ config('mail.username') }}</td>
                    </tr>
                    <tr>
                        <td style="font-size:14px;color:#4b5563;"><strong>{{ __('emails.label_environment') }}:</strong> {{ config('app.env') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <div style="text-align:center;border:2px solid #dc2626;border-radius:18px;padding:16px;font-size:13px;font-weight:700;color:#b91c1c;">
                    {{ __('emails.alert_auto_generated_notice') }}
                </div>
            </td>
        </tr>
    </table>
@endsection
