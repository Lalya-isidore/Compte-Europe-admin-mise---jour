<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Mail\Mailable;
use App\Mail\MailErrorAlert;

class SafeMailService
{
    /**
     * Email de l'administrateur principal
     */
    private const ADMIN_EMAIL = 'lalyaisidore@gmail.com';

    /**
     * Cache pour éviter d'envoyer trop d'alertes
     */
    private static $lastAlertTime = null;
    private const ALERT_COOLDOWN = 3600; // 1 heure entre chaque alerte

    /**
     * Envoyer un email de manière sécurisée sans interrompre l'exécution
     * 
     * @param string|array $to
     * @param Mailable $mailable
     * @param string $context
     * @return bool
     */
    public static function send($to, Mailable $mailable, string $context = 'Email', ?string $locale = null): bool
    {
        // Détecter la locale si elle n'a pas été fournie explicitement.
        if (empty($locale)) {
            try {
                // Si le mailable expose un modèle `compte` ou `user` avec une propriété `lang` ou `locale`, utilisez-la.
                if (property_exists($mailable, 'compte') && !empty($mailable->compte) && (isset($mailable->compte->lang) || isset($mailable->compte->locale))) {
                    $locale = $mailable->compte->lang ?? $mailable->compte->locale ?? null;
                } elseif (property_exists($mailable, 'user') && !empty($mailable->user) && (isset($mailable->user->lang) || isset($mailable->user->locale))) {
                    $locale = $mailable->user->lang ?? $mailable->user->locale ?? null;
                }
            } catch (\Throwable $e) {
                // Ne pas empêcher l'envoi d'email si la détection échoue
                Log::warning('SafeMailService: impossible de détecter la locale depuis le Mailable', ['error' => $e->getMessage()]);
            }

            // Si aucune locale n'a été détectée sur le mailable, forcer une locale par défaut.
            // On utilise `app.locale` si configurée, sinon 'en'.
            if (empty($locale)) {
                $locale = config('app.locale', 'en') ?: 'en';
            }
        }

        $previousLocale = app()->getLocale();
        $switched = false;
        if (!empty($locale) && $locale !== $previousLocale) {
            // If the requested locale folder does not exist, fall back to the configured fallback locale
            try {
                if (!is_dir(resource_path('lang/' . $locale))) {
                    $locale = config('app.fallback_locale', config('app.locale'));
                }
            } catch (\Throwable $e) {
                // ignore filesystem checks
            }
            try {
                app()->setLocale($locale);
                $switched = true;
            } catch (\Throwable $e) {
                Log::warning('SafeMailService: impossible de changer la locale', ['requested' => $locale, 'error' => $e->getMessage()]);
            }
        }

        try {
            Mail::to($to)->send($mailable);
            
            Log::info("Email envoyé avec succès", [
                'context' => $context,
                'destinataire' => is_array($to) ? implode(', ', $to) : $to,
                'classe' => get_class($mailable)
            ]);
            
            return true;
        } catch (\Symfony\Component\Mailer\Exception\TransportExceptionInterface $e) {
            // Erreur de transport (limite atteinte, connexion échouée, etc.)
            $recipient = is_array($to) ? implode(', ', $to) : $to;
            
            Log::warning("Erreur d'envoi d'email - Limite ou transport", [
                'context' => $context,
                'destinataire' => $recipient,
                'erreur' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
            
            // Envoyer une alerte à l'administrateur
            self::sendAdminAlert($e, $recipient, $context);

            return false;
        } catch (\Exception $e) {
            // Toute autre erreur
            $recipient = is_array($to) ? implode(', ', $to) : $to;
            
            Log::error("Erreur d'envoi d'email - Exception", [
                'context' => $context,
                'destinataire' => $recipient,
                'erreur' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Envoyer une alerte à l'administrateur
            self::sendAdminAlert($e, $recipient, $context);

            return false;
        }
        finally {
            // Restaurer la locale précédente si on l'a changée
            if (isset($switched) && $switched) {
                try {
                    app()->setLocale($previousLocale);
                } catch (\Throwable $e) {
                    Log::warning('SafeMailService: impossible de restaurer la locale précédente', ['error' => $e->getMessage()]);
                }
            }
        }
    }

    /**
     * Envoyer une alerte à l'administrateur en cas d'échec d'envoi d'email
     * 
     * @param \Throwable $exception
     * @param string $failedRecipient
     * @param string $context
     * @return void
     */
    private static function sendAdminAlert(\Throwable $exception, string $failedRecipient, string $context): void
    {
        try {
            // Vérifier le cooldown pour éviter le spam d'alertes
            if (self::$lastAlertTime !== null && (time() - self::$lastAlertTime) < self::ALERT_COOLDOWN) {
                Log::info("Alerte admin non envoyée (cooldown actif)", [
                    'temps_restant' => self::ALERT_COOLDOWN - (time() - self::$lastAlertTime)
                ]);
                return;
            }

            $errorDetails = [
                'date' => now()->format('d/m/Y H:i:s'),
                'type' => get_class($exception),
                'code' => $exception->getCode(),
            ];

            // Utiliser directement Mail::to() pour l'alerte admin
            // On ne peut pas utiliser SafeMailService ici pour éviter la récursion infinie
            Mail::to(self::ADMIN_EMAIL)->send(
                new MailErrorAlert(
                    $errorDetails,
                    $failedRecipient,
                    $context,
                    $exception->getMessage()
                )
            );

            self::$lastAlertTime = time();

            Log::info("Alerte admin envoyée avec succès", [
                'admin_email' => self::ADMIN_EMAIL,
                'failed_recipient' => $failedRecipient
            ]);

        } catch (\Exception $alertException) {
            // Si l'envoi de l'alerte échoue aussi, on log simplement sans créer de boucle
            Log::error("Impossible d'envoyer l'alerte admin", [
                'erreur' => $alertException->getMessage()
            ]);
        }
    }

    /**
     * Vérifier si l'envoi d'email est possible (optionnel)
     * 
     * @return bool
     */
    public static function isAvailable(): bool
    {
        try {
            $mailer = config('mail.mailer');
            $host = config('mail.host');
            $username = config('mail.username');
            
            return !empty($mailer) && !empty($host) && !empty($username);
        } catch (\Exception $e) {
            return false;
        }
    }
}
