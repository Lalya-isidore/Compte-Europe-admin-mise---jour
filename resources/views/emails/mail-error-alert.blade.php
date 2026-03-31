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
                    
                    <!-- Header avec gradient de marque -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); padding: 30px 40px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 26px; font-weight: 900; font-style: italic; text-transform: uppercase;">
                                ⚠️ ALERTE SYSTÈME
                            </h1>
                            <p style="margin: 10px 0 0; color: rgba(255,255,255,0.9); font-size: 16px;">
                                Échec d'envoi d'email détecté
                            </p>
                        </td>
                    </tr>

                    <!-- Contenu principal -->
                    <tr>
                        <td style="padding: 40px;">
                            
                            <!-- Message principal -->
                            <div style="background: #fff3cd; border-left: 4px solid #ffc107; padding: 20px; margin-bottom: 30px; border-radius: 8px;">
                                <h2 style="margin: 0 0 10px; color: #856404; font-size: 18px; font-weight: 600;">
                                    ⚠️ Problème d'envoi d'email
                                </h2>
                                <p style="margin: 0; color: #856404; font-size: 14px; line-height: 1.6;">
                                    Un email n'a pas pu être envoyé. Cela peut indiquer que la limite quotidienne de 500 emails a été atteinte ou qu'il y a un problème avec le serveur SMTP.
                                </p>
                            </div>

                            <!-- Détails de l'erreur -->
                            <div style="background: #f8f9fa; padding: 25px; border-radius: 8px; margin-bottom: 20px;">
                                <h3 style="margin: 0 0 20px; color: #212529; font-size: 16px; font-weight: 600; border-bottom: 2px solid #dee2e6; padding-bottom: 10px;">
                                    📋 Détails de l'erreur
                                </h3>
                                
                                <table width="100%" cellpadding="8" cellspacing="0">
                                    <tr>
                                        <td style="color: #6c757d; font-size: 14px; font-weight: 600; width: 40%;">
                                            🕐 Date et heure:
                                        </td>
                                        <td style="color: #212529; font-size: 14px;">
                                            {{ now()->format('d/m/Y à H:i:s') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color: #6c757d; font-size: 14px; font-weight: 600; padding-top: 15px;">
                                            📧 Destinataire concerné:
                                        </td>
                                        <td style="color: #212529; font-size: 14px; padding-top: 15px;">
                                            {{ $failedRecipient }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color: #6c757d; font-size: 14px; font-weight: 600; padding-top: 15px;">
                                            📝 Contexte:
                                        </td>
                                        <td style="color: #212529; font-size: 14px; padding-top: 15px;">
                                            {{ $context }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color: #6c757d; font-size: 14px; font-weight: 600; padding-top: 15px; vertical-align: top;">
                                            ❌ Message d'erreur:
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
                                    🔍 Causes possibles
                                </h3>
                                <ul style="margin: 0; padding-left: 20px; color: #004085; font-size: 14px; line-height: 1.8;">
                                    <li><strong>Limite quotidienne atteinte:</strong> Gmail limite à 500 emails/jour pour les comptes Google Workspace (100/jour pour les comptes gratuits)</li>
                                    <li><strong>Problème de connexion SMTP:</strong> Le serveur Gmail peut être temporairement indisponible</li>
                                    <li><strong>Authentification échouée:</strong> Vérifiez les identifiants dans le fichier .env</li>
                                    <li><strong>Mot de passe d'application expiré:</strong> Le mot de passe d'application Gmail peut avoir été révoqué</li>
                                </ul>
                            </div>

                            <!-- Actions recommandées -->
                            <div style="background: #d1ecf1; padding: 25px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #17a2b8;">
                                <h3 style="margin: 0 0 15px; color: #0c5460; font-size: 16px; font-weight: 600;">
                                    ✅ Actions recommandées
                                </h3>
                                <ol style="margin: 0; padding-left: 20px; color: #0c5460; font-size: 14px; line-height: 1.8;">
                                    <li><strong>Si limite atteinte:</strong> Attendez jusqu'à demain (réinitialisation à minuit PST)</li>
                                    <li><strong>Vérifier les logs:</strong> Consultez <code style="background: #fff; padding: 2px 6px; border-radius: 3px; font-family: monospace;">storage/logs/laravel.log</code></li>
                                    <li><strong>Tester la connexion:</strong> Exécutez <code style="background: #fff; padding: 2px 6px; border-radius: 3px; font-family: monospace;">php artisan email:test</code></li>
                                    <li><strong>Vérifier la configuration:</strong> Contrôlez les paramètres SMTP dans le fichier .env</li>
                                    <li><strong>Régénérer le mot de passe:</strong> Si nécessaire, créez un nouveau mot de passe d'application Gmail</li>
                                </ol>
                            </div>

                            <!-- Informations système -->
                            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                                <h3 style="margin: 0 0 15px; color: #212529; font-size: 14px; font-weight: 600;">
                                    🖥️ Informations système
                                </h3>
                                <table width="100%" cellpadding="5" cellspacing="0" style="font-size: 13px;">
                                    <tr>
                                        <td style="color: #6c757d; width: 40%;">Serveur SMTP:</td>
                                        <td style="color: #212529;">{{ config('mail.host') }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color: #6c757d;">Port:</td>
                                        <td style="color: #212529;">{{ config('mail.port') }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color: #6c757d;">Compte:</td>
                                        <td style="color: #212529;">{{ config('mail.username') }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color: #6c757d;">Environnement:</td>
                                        <td style="color: #212529;">{{ config('app.env') }}</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Note importante -->
                            <div style="background: #fff; border: 2px solid #dc3545; padding: 20px; border-radius: 8px;">
                                <p style="margin: 0; color: #dc3545; font-size: 14px; font-weight: 600; text-align: center;">
                                    ⚠️ Cette alerte est automatique. L'application continue de fonctionner normalement, mais les emails ne sont pas envoyés.
                                </p>
                            </div>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background: #f8f9fa; padding: 30px 40px; text-align: center; border-top: 1px solid #dee2e6;">
                            <p style="margin: 0 0 10px; color: #6c757d; font-size: 14px;">
                                <strong>TRANSFERFLUX</strong> - Système de gestion des comptes
                            </p>
                            <p style="margin: 0; color: #adb5bd; font-size: 12px;">
                                Cette alerte a été générée automatiquement par le système SafeMailService
                            </p>
                            <p style="margin: 10px 0 0; color: #adb5bd; font-size: 12px;">
                                Pour toute question, contactez votre équipe technique
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
