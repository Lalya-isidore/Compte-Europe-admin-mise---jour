<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InfobipService
{
    protected string $apiKey;
    protected string $baseUrl;
    protected string $sender;

    public function __construct()
    {
        $this->apiKey = config('services.infobip.api_key') ?? config('sms.infobip.api_key') ?? '';
        $this->baseUrl = rtrim(config('services.infobip.base_url') ?? config('sms.infobip.base_url') ?? 'https://m9pzm6.api.infobip.com', '/');
        $this->sender = config('services.infobip.sender') ?? config('sms.infobip.sender') ?? 'Movicredo';
    }

    /**
     * Send an SMS via Infobip
     * 
     * @param string $to The destination phone number (with country code)
     * @param string $message The message content
     * @return array Response data with 'success' and 'message_id' or 'error'
     */
    public function sendSms(string $to, string $message, ?string $sender = null): array
    {
        if (empty($this->apiKey)) {
            Log::error('Infobip API key is not configured');
            return ['success' => false, 'error' => 'API key missing'];
        }

        $url = "{$this->baseUrl}/sms/2/text/advanced";

        try {
            $webhookUrl = rtrim(config('app.url'), '/') . '/api/sms/webhook/infobip';

            $response = Http::withHeaders([
                'Authorization' => "App {$this->apiKey}",
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($url, [
                        'messages' => [
                            [
                                'from' => $sender ?? $this->sender,
                                'destinations' => [
                                    ['to' => $this->formatNumber($to)]
                                ],
                                'text' => $message,
                                'notifyUrl' => $webhookUrl,
                                'notifyContentType' => 'application/json',
                            ]
                        ]
                    ]);

            if ($response->successful()) {
                $data = $response->json();
                $messageId = $data['messages'][0]['messageId'] ?? null;

                Log::info('Infobip SMS sent successfully', [
                    'to' => $to,
                    'message_id' => $messageId
                ]);

                return [
                    'success' => true,
                    'message_id' => $messageId,
                    'data' => $data
                ];
            }

            Log::error('Infobip API error', [
                'status' => $response->status(),
                'body' => $response->body(),
                'to' => $to
            ]);

            return [
                'success' => false,
                'error' => 'Infobip API error: ' . $response->status(),
                'details' => $response->json()
            ];

        } catch (\Exception $e) {
            Log::error('Exception during Infobip SMS sending', [
                'message' => $e->getMessage(),
                'to' => $to
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Format number to ensure it has '+' if needed
     */
    protected function formatNumber(string $number): string
    {
        $normalized = preg_replace('/[^0-9]/', '', $number);
        return $normalized; // Infobip typically expects numbers without + but with country code, OR with +
    }
}
