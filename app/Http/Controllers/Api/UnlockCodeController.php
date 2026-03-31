<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Compte;
use App\Models\UnlockCode;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class UnlockCodeController extends Controller
{
    public function consume(Request $request): JsonResponse
    {
        $this->validateApiKey($request);

        $validated = $request->validate([
            'code' => 'required|string',
            'compte_token' => 'nullable|string',
            'compte_email' => 'nullable|email',
            'compte_id' => 'nullable|integer',
        ]);

        $compte = $this->resolveCompte($validated);
        if (! $compte) {
            return response()->json(['message' => 'Compte introuvable.'], 404);
        }

        try {
            $unlock = UnlockCode::snapshotCompteCode($compte);
            if ($unlock && empty($unlock->used_at)) {
                $unlock->markAsUsed();
            }

            return response()->json([
                'status' => 'ok',
                'compte_id' => $compte->id,
                'unlock_id' => $unlock?->id,
            ]);
        } catch (\Throwable $e) {
            Log::error('API unlock consume failure', [
                'compte_id' => $compte->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json(['message' => 'Erreur serveur.'], 500);
        }
    }

    protected function validateApiKey(Request $request): void
    {
        $expected = config('services.unlock_codes.api_key');
        if (! $expected) {
            return;
        }

        $provided = $request->header('X-API-Key') ?? $request->input('api_key');
        if (! hash_equals($expected, (string) $provided)) {
            abort(response()->json(['message' => 'API key invalide.'], 401));
        }
    }

    protected function resolveCompte(array $payload): ?Compte
    {
        if (! empty($payload['compte_id'])) {
            $compte = Compte::find($payload['compte_id']);
            if ($compte) {
                return $compte;
            }
        }

        if (! empty($payload['compte_token'])) {
            $compte = Compte::where('token', $payload['compte_token'])->first();
            if ($compte) {
                return $compte;
            }
        }

        if (! empty($payload['compte_email'])) {
            return Compte::where('email', $payload['compte_email'])->latest()->first();
        }

        return null;
    }
}
