<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client as TwilioClient;

class SmsService
{
    protected string $provider;

    public function __construct()
    {
        $this->provider = config('sms.provider', 'twilio');
    }

    public function send(string $to, string $message, ?string $sender = null): array
    {
        Log::info("Sending SMS via Twilio", ['to' => $to, 'sender' => $sender]);

        // Infobip temporairement désactivé — Twilio utilisé pour tous les envois
        // if ($this->provider === 'infobip') {
        //     return app(InfobipService::class)->sendSms($to, $message, $sender);
        // }

        return $this->sendViaTwilio($to, $message, $sender);
    }

    /**
     * Envoie via Twilio avec expéditeur alphanumérique.
     * Inclut un statusCallback pour détecter les échecs et déclencher le fallback.
     */
    public function sendViaTwilio(string $to, string $message, ?string $sender = null): array
    {
        $sid    = config('services.twilio.account_sid');
        $token  = config('services.twilio.auth_token');
        $from   = $sender ?: config('services.twilio.alpha_sender', 'FlashBilan');
        $callbackUrl = rtrim(config('app.url'), '/') . '/webhook/twilio/sms-status';

        if (!$sid || !$token) {
            return ['success' => false, 'error' => 'Twilio credentials manquants'];
        }

        try {
            $client  = new TwilioClient($sid, $token);
            $message = $client->messages->create($to, [
                'from'           => $from,
                'body'           => $message,
                'statusCallback' => $callbackUrl,
            ]);

            return [
                'success'    => true,
                'message_id' => $message->sid,
                'twilio_sid' => $message->sid,
            ];
        } catch (\Exception $e) {
            Log::error('Twilio sendViaTwilio error', ['error' => $e->getMessage(), 'to' => $to]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Fallback : renvoie avec le numéro Twilio classique.
     * Appelé automatiquement par le webhook si l'alphanumérique échoue.
     */
    public function sendFallback(string $to, string $message): array
    {
        $sid          = config('services.twilio.account_sid');
        $token        = config('services.twilio.auth_token');
        $phoneNumber  = config('services.twilio.phone_number');
        $callbackUrl  = rtrim(config('app.url'), '/') . '/webhook/twilio/sms-status-fallback';

        if (!$phoneNumber) {
            return ['success' => false, 'error' => 'Numéro fallback Twilio non configuré (TWILIO_PHONE_NUMBER)'];
        }

        try {
            $client  = new TwilioClient($sid, $token);
            $message = $client->messages->create($to, [
                'from'           => $phoneNumber,
                'body'           => $message,
                'statusCallback' => $callbackUrl,
            ]);

            return [
                'success'    => true,
                'message_id' => $message->sid,
                'twilio_sid' => $message->sid,
            ];
        } catch (\Exception $e) {
            Log::error('Twilio fallback error', ['error' => $e->getMessage(), 'to' => $to]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
