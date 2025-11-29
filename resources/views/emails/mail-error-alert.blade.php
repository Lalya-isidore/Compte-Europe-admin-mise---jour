<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alerte Échec Email</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Arial, sans-serif; background-color: #f5f5f5;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f5f5; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                    
                    <!-- Header avec gradient rouge -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); padding: 30px 40px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 600;">
                                {{ __('emails.system_alert') }}
                            </h1>
                            <p style="margin: 10px 0 0; color: rgba(255,255,255,0.9); font-size: 16px;">
                                {{ __('emails.mail_send_failure_detected') }}
                            </p>
                        </td>
                    </tr>

                    <!-- Contenu principal -->
                    <tr>
                        <td style="padding: 40px;">
                            
                            <!-- Message principal -->
                            <div style="background: #fff3cd; border-left: 4px solid #ffc107; padding: 20px; margin-bottom: 30px; border-radius: 8px;">
                                <h2 style="margin: 0 0 10px; color: #856404; font-size: 18px; font-weight: 600;">
                                    {{ __('emails.mail_send_failure_detected') }}
                                </h2>
                                <p style="margin: 0; color: #856404; font-size: 14px; line-height: 1.6;">
                                    {{ __('emails.email_send_failure_explanation') }}
                                </p>
                            </div>

                            <!-- Détails de l'erreur -->
                            <div style="background: #f8f9fa; padding: 25px; border-radius: 8px; margin-bottom: 20px;">
                                <h3 style="margin: 0 0 20px; color: #212529; font-size: 16px; font-weight: 600; border-bottom: 2px solid #dee2e6; padding-bottom: 10px;">
                                    {{ __('emails.error_details') }}
                                </h3>
                                
                                <table width="100%" cellpadding="8" cellspacing="0">
                                    <tr>
                                        <td style="color: #6c757d; font-size: 14px; font-weight: 600; width: 40%;">
                                            {{ __('emails.label_date_time') }}
                                        </td>
                                        <td style="color: #212529; font-size: 14px;">
                                            {{ now()->format('d/m/Y à H:i:s') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color: #6c757d; font-size: 14px; font-weight: 600; padding-top: 15px;">
                                            {{ __('emails.label_failed_recipient') }}:
                                        </td>
                                        <td style="color: #212529; font-size: 14px; padding-top: 15px;">
                                            {{ $failedRecipient }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color: #6c757d; font-size: 14px; font-weight: 600; padding-top: 15px;">
                                            {{ __('emails.label_context') }}:
                                        </td>
                                        <td style="color: #212529; font-size: 14px; padding-top: 15px;">
                                            {{ $context }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color: #6c757d; font-size: 14px; font-weight: 600; padding-top: 15px; vertical-align: top;">
                                            {{ __('emails.label_error_message') }}:
                                        </td>
                                        <td style="color: #dc3545; font-size: 13px; padding-top: 15px; font-family: monospace; background: #fff; padding: 10px; border-radius: 4px;">
                                            {{ $errorMessage }}
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Causes possibles -->
                            <div style="background: #e7f3ff; padding: 25px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #0d6efd;">
                                <h3 style="margin: 0 0 15px; color: #004085; font-size: 16px; font-weight: 600;">
                                    {{ __('emails.possible_causes') }}
                                </h3>
                                <ul style="margin: 0; padding-left: 20px; color: #004085; font-size: 14px; line-height: 1.8;">
                                    <li><strong>{{ __('emails.cause_daily_limit') }}:</strong> {{ __('emails.cause_daily_limit_details') }}</li>
                                    <li><strong>{{ __('emails.cause_smtp_connection') }}:</strong> {{ __('emails.cause_smtp_connection_details') }}</li>
                                    <li><strong>{{ __('emails.cause_auth_failed') }}:</strong> {{ __('emails.cause_auth_failed_details') }}</li>
                                    <li><strong>{{ __('emails.cause_app_password_revoked') }}:</strong> {{ __('emails.cause_app_password_revoked_details') }}</li>
                                </ul>
                            </div>

                            <!-- Actions recommandées -->
                            <div style="background: #d1ecf1; padding: 25px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #17a2b8;">
                                <h3 style="margin: 0 0 15px; color: #0c5460; font-size: 16px; font-weight: 600;">
                                    {{ __('emails.recommended_actions') }}
                                </h3>
                                <ol style="margin: 0; padding-left: 20px; color: #0c5460; font-size: 14px; line-height: 1.8;">
                                    <li><strong>{{ __('emails.action_if_limit') }}:</strong> {{ __('emails.action_if_limit_details') }}</li>
                                    <li><strong>{{ __('emails.action_check_logs') }}:</strong> {{ __('emails.action_check_logs_details') }}</li>
                                    <li><strong>{{ __('emails.action_test_connection') }}:</strong> {{ __('emails.action_test_connection') }}</li>
                                    <li><strong>{{ __('emails.action_check_config') }}:</strong> {{ __('emails.action_check_config_details') }}</li>
                                    <li><strong>{{ __('emails.action_regenerate_password') }}:</strong> {{ __('emails.action_regenerate_password_details') }}</li>
                                </ol>
                            </div>

                            <!-- Informations système -->
                            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                                <h3 style="margin: 0 0 15px; color: #212529; font-size: 14px; font-weight: 600;">
                                    {{ __('emails.system_information') }}
                                </h3>
                                <table width="100%" cellpadding="5" cellspacing="0" style="font-size: 13px;">
                                    <tr>
                                        <td style="color: #6c757d; width: 40%;">{{ __('emails.label_smtp_server') }}:</td>
                                        <td style="color: #212529;">{{ config('mail.host') }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color: #6c757d;">{{ __('emails.label_port') }}:</td>
                                        <td style="color: #212529;">{{ config('mail.port') }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color: #6c757d;">{{ __('emails.label_account') }}:</td>
                                        <td style="color: #212529;">{{ config('mail.username') }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color: #6c757d;">{{ __('emails.label_environment') }}:</td>
                                        <td style="color: #212529;">{{ config('app.env') }}</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Note importante -->
                            <div style="background: #fff; border: 2px solid #dc3545; padding: 20px; border-radius: 8px;">
                                <p style="margin: 0; color: #dc3545; font-size: 14px; font-weight: 600; text-align: center;">
                                    {{ __('emails.alert_auto_generated_notice') }}
                                </p>
                            </div>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background: #f8f9fa; padding: 30px 40px; text-align: center; border-top: 1px solid #dee2e6;">
                            <p style="margin: 0 0 10px; color: #6c757d; font-size: 14px;">
                                <strong>{{ __('emails.footer_brand') }}</strong> - {{ __('emails.account_management_system') }}
                            </p>
                            <p style="margin: 0; color: #adb5bd; font-size: 12px;">
                                {{ __('emails.alert_generated_by_safemail') }}
                            </p>
                            <p style="margin: 10px 0 0; color: #adb5bd; font-size: 12px;">
                                {{ __('emails.contact_technical_team') }}
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
