<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class SmsService
{
    protected string $provider;

    public function __construct()
    {
        $this->provider = config('sms.provider', 'infobip');
    }

    /**
     * Send SMS using the configured provider
     */
    public function send(string $to, string $message, ?string $sender = null): array
    {
        Log::info("Sending SMS via {$this->provider}", ['to' => $to]);

        if ($this->provider === 'infobip') {
            return app(InfobipService::class)->sendSms($to, $message, $sender);
        }

        if ($this->provider === 'twilio') {
            // Adapt to existing TwilioService or implement Twilio sending here
            // For now, let's bridge to TwilioService if it exists and has a compatible method
            // or just use the SDK if SID/Token are available
            return $this->sendViaTwilio($to, $message);
        }

        return [
            'success' => false,
            'error' => "Provider {$this->provider} not implemented"
        ];
    }

    protected function sendViaTwilio(string $to, string $message): array
    {
        $sid = config('services.twilio.account_sid');
        $token = config('services.twilio.auth_token');
        $from = config('services.twilio.phone_number');

        if (!$sid || !$token || !$from) {
            return ['success' => false, 'error' => 'Twilio credentials missing'];
        }

        try {
            $client = new \Twilio\Rest\Client($sid, $token);
            $response = $client->messages->create($to, [
                'from' => $from,
                'body' => $message
            ]);

            return [
                'success' => true,
                'message_id' => $response->sid
            ];
        } catch (\Exception $e) {
            Log::error('Twilio SMS error: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
