<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NumverifyService
{
    protected string $apiKey;
    protected string $baseUrl = 'http://apilayer.net/api/validate';

    public function __construct()
    {
        $this->apiKey = config('services.numverify.api_key') ?? '';
    }

    public function numberLookup(string $phoneNumber): array
    {
        if (empty($this->apiKey)) {
            return ['success' => false, 'error' => 'Clé API Numverify non configurée'];
        }

        // Numverify attend le numéro avec le + devant
        $number = $phoneNumber;
        if (!str_starts_with($number, '+')) {
            $number = '+' . ltrim($number, '0');
        }

        try {
            $response = Http::withoutVerifying()->get($this->baseUrl, [
                'access_key' => $this->apiKey,
                'number'     => $number,
                'format'     => 1,
            ]);

            Log::info('Numverify Number Lookup', [
                'status' => $response->status(),
                'phone'  => $number,
                'body'   => $response->json(),
            ]);

            if (!$response->successful()) {
                return ['success' => false, 'error' => 'Erreur API Numverify: ' . $response->status()];
            }

            $data = $response->json();

            // Numverify retourne success:false en cas d'erreur (ex: clé invalide)
            if (isset($data['success']) && $data['success'] === false) {
                $code = $data['error']['code'] ?? 0;
                $info = $data['error']['info'] ?? 'Erreur inconnue';
                Log::error('Numverify API error', ['code' => $code, 'info' => $info]);
                return ['success' => false, 'error' => 'Erreur vérification : ' . $info];
            }

            $isValid = (bool) ($data['valid'] ?? false);

            return [
                'success'      => true,
                'is_valid'     => $isValid,
                'phone_number' => $data['international_format'] ?? $number,
                'country_name' => $data['country_name'] ?? null,
                'country_code' => $data['country_prefix'] ?? null,
                'network_name' => $data['carrier'] ?? null,
                'network_type' => $data['line_type'] ?? null,
                'is_reachable' => $isValid,
                'ported'       => false,
                'roaming'      => false,
                'mcc_mnc'      => null,
                'status'       => $isValid ? 'DELIVERED' : 'UNDELIVERABLE',
                'raw'          => $data,
            ];

        } catch (\Exception $e) {
            Log::error('Exception Numverify', ['message' => $e->getMessage(), 'phone' => $phoneNumber]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
