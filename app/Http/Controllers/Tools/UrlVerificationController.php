<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use App\Models\UrlVerification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UrlVerificationController extends Controller
{
    public function index()
    {
        $history = UrlVerification::where('user_id', Auth::id())
            ->latest()
            ->limit(10)
            ->get();

        return view('tools.url-verification', compact('history'));
    }

    public function check(Request $request)
    {
        $request->validate([
            'domain' => ['required', 'string', 'max:255'],
        ]);

        $domain = $this->normalizeDomain($request->input('domain'));

        if (! $this->isValidDomain($domain)) {
            return response()->json([
                'success' => false,
                'message' => 'Veuillez renseigner un nom de domaine valide (ex: exemple.com)'
            ], 422);
        }

        $userId = Auth::id();
        $lookupStatus = 'error';
        $errorMessage = null;
        $lookupData = null;
        $registrar = null;
        $expiresAt = null;

        try {
            $response = Http::timeout(15)
                ->acceptJson()
                ->get('https://rdap.org/domain/' . $domain);

            if ($response->status() === 404) {
                $errorMessage = 'Impossible de trouver des informations WHOIS pour ce domaine.';
            } elseif ($response->failed()) {
                $errorMessage = 'Le service WHOIS est momentanément indisponible.';
            } else {
                $payload = $response->json();
                $lookupStatus = 'success';
                $lookupData = $this->transformPayload($payload);
                $registrar = $lookupData['registrar'] ?? null;
                $expiresAt = isset($lookupData['expires_at']) && $lookupData['expires_at']
                    ? Carbon::parse($lookupData['expires_at'])
                    : null;
            }
        } catch (\Throwable $e) {
            $errorMessage = 'Erreur réseau: ' . $e->getMessage();
            Log::error('URL verification failed', [
                'domain' => $domain,
                'error' => $e->getMessage(),
            ]);
        }

        $record = UrlVerification::create([
            'user_id' => $userId,
            'domain' => $domain,
            'lookup_status' => $lookupStatus,
            'registrar' => $registrar,
            'expires_at' => $expiresAt,
            'lookup_data' => $lookupData,
            'error_message' => $errorMessage,
        ]);

        if ($lookupStatus !== 'success') {
            return response()->json([
                'success' => false,
                'message' => $errorMessage ?? 'Une erreur inconnue est survenue.',
                'history' => $this->historyPayload($record)
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $lookupData,
            'history' => $this->historyPayload($record)
        ]);
    }

    private function normalizeDomain(string $value): string
    {
        $clean = trim(Str::lower($value));
        $clean = preg_replace('#^https?://#', '', $clean);
        $clean = preg_replace('#/.*$#', '', $clean);
        return preg_replace('#^www\.#', '', $clean);
    }

    private function isValidDomain(string $domain): bool
    {
        return (bool) preg_match('/^([a-z0-9-]+\.)+[a-z]{2,}$/i', $domain);
    }

    private function transformPayload(?array $payload): ?array
    {
        if (! $payload) {
            return null;
        }

        $events = collect($payload['events'] ?? []);
        $getEventDate = function (array $actions) use ($events) {
            foreach ($actions as $action) {
                $match = $events->firstWhere('eventAction', $action);
                if ($match && ! empty($match['eventDate'])) {
                    return $match['eventDate'];
                }
            }
            return null;
        };

        $nameservers = collect($payload['nameservers'] ?? [])
            ->pluck('ldhName')
            ->filter()
            ->unique()
            ->values()
            ->all();

        return [
            'domain' => $payload['ldhName'] ?? null,
            'status' => $payload['status'] ?? [],
            'registrar' => $this->extractRegistrar($payload),
            'created_at' => $getEventDate(['registration', 'registered']),
            'updated_at' => $getEventDate(['last changed', 'last update']),
            'expires_at' => $getEventDate(['expiration', 'expiry']),
            'name_servers' => $nameservers,
            'raw' => $payload,
        ];
    }

    private function extractRegistrar(array $payload): ?string
    {
        if (! empty($payload['registrar']['name'])) {
            return $payload['registrar']['name'];
        }

        foreach ($payload['entities'] ?? [] as $entity) {
            if (($entity['roles'][0] ?? null) === 'registrar') {
                $vcard = $entity['vcardArray'][1] ?? [];
                foreach ($vcard as $card) {
                    if (($card[0] ?? null) === 'fn' && ! empty($card[3])) {
                        return $card[3];
                    }
                }
            }
        }

        return null;
    }

    private function historyPayload(UrlVerification $record): array
    {
        return [
            'id' => $record->id,
            'domain' => $record->domain,
            'status' => $record->lookup_status,
            'created_at' => $record->created_at->toIso8601String(),
        ];
    }
}
