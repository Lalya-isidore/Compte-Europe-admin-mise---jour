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

            $response = Http::withoutVerifying()->withHeaders([
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

            $body = $response->json();
            $errorText = $body['requestError']['serviceException']['text']
                ?? $body['requestError']['policyException']['text']
                ?? ($body['messages'][0]['status']['description'] ?? null)
                ?? ('Erreur Infobip HTTP ' . $response->status());

            Log::error('Infobip API error', [
                'status' => $response->status(),
                'body' => $response->body(),
                'error_text' => $errorText,
                'to' => $to
            ]);

            return [
                'success' => false,
                'error' => $errorText,
                'details' => $body
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
     * Perform a Number Lookup (HLR) via Infobip
     *
     * @param string $phoneNumber Full phone number with country code
     * @return array Lookup result
     */
    public function numberLookup(string $phoneNumber): array
    {
        if (empty($this->apiKey)) {
            Log::error('Infobip API key is not configured');
            return ['success' => false, 'error' => 'Clé API non configurée'];
        }

        $url = "{$this->baseUrl}/number/1/query";
        $formattedNumber = $this->formatNumber($phoneNumber);

        try {
            $response = Http::withoutVerifying()->withHeaders([
                'Authorization' => "App {$this->apiKey}",
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($url, [
                'to' => $formattedNumber,
            ]);

            Log::info('Infobip Number Lookup response', [
                'status' => $response->status(),
                'body' => $response->json(),
                'phone' => $formattedNumber,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $result = $data['results'][0] ?? null;

                if (!$result) {
                    return ['success' => false, 'error' => 'Aucun résultat retourné par Infobip'];
                }

                $statusGroup = $result['status']['groupName'] ?? 'UNKNOWN';

                // Si le service HLR n'est pas activé sur le compte Infobip
                if ($statusGroup === 'REJECTED') {
                    $statusDesc = $result['status']['description'] ?? 'Rejeté';
                    return ['success' => false, 'error' => 'Service HLR non disponible : ' . $statusDesc];
                }

                $isValid = in_array($statusGroup, ['DELIVERED', 'PENDING']);

                return [
                    'success' => true,
                    'is_valid' => $isValid,
                    'phone_number' => $result['to'] ?? $formattedNumber,
                    'country_name' => $result['originalNetwork']['countryName'] ?? null,
                    'country_code' => $result['countryPrefix'] ?? null,
                    'network_name' => $result['originalNetwork']['networkName'] ?? null,
                    'network_type' => $result['numberType'] ?? null,
                    'is_reachable' => $statusGroup === 'DELIVERED',
                    'ported' => $result['ported'] ?? false,
                    'roaming' => $result['roaming'] ?? false,
                    'mcc_mnc' => $result['mccMnc'] ?? null,
                    'status' => $statusGroup,
                    'raw' => $result,
                ];
            }

            Log::error('Infobip Number Lookup error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return [
                'success' => false,
                'error' => 'Erreur API Infobip: ' . $response->status(),
            ];

        } catch (\Exception $e) {
            Log::error('Exception during Infobip Number Lookup', [
                'message' => $e->getMessage(),
                'phone' => $phoneNumber,
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
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
