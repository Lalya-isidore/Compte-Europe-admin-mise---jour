<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Compte;
use App\Models\Transfer;
use App\Models\UnlockCode;

class LegacyWebhookController extends Controller
{
    public function virementVerified(Request $request)
    {
        $data = $request->validate([
            'compte_id' => 'nullable|integer',
            'code' => 'nullable|string',
            'amount' => 'nullable|numeric',
            'timestamp' => 'required|integer',
            'numerocompte' => 'nullable|string',
            'name_servieur' => 'nullable|string',
            'beneficiary_name' => 'nullable|string',
            'reason' => 'nullable|string',
        ]);

        $secret = env('LEGACY_WEBHOOK_SECRET');
        $signature = $request->header('X-Signature', '');
        $payload = $request->getContent();
        $expected = hash_hmac('sha256', $payload, $secret);

        if (! hash_equals($expected, $signature)) {
            Log::warning('Legacy webhook: invalid signature', ['remote' => $request->ip()]);
            return response()->json(['error' => 'Invalid signature'], 403);
        }

        if (abs(time() - (int)$data['timestamp']) > 300) {
            Log::warning('Legacy webhook: timestamp too old', ['timestamp' => $data['timestamp']]);
            return response()->json(['error' => 'Stale request'], 400);
        }

        $compte = null;
        if (! empty($data['compte_id'])) {
            $compte = Compte::find($data['compte_id']);
        }
        if (! $compte && ! empty($data['code'])) {
            $compte = Compte::where('code_virement', $data['code'])->first();
        }
        if (! $compte) {
            Log::warning('Legacy webhook: compte not found', ['payload' => $data]);
            return response()->json(['error' => 'Compte not found'], 404);
        }

        try {
            $existing = null;
            if (! empty($data['amount'])) {
                $existing = Transfer::where('user_id', $compte->user_id)
                    ->where('solidvire', $data['amount'])
                    ->where('status', 'completed')
                    ->whereNull('compte_id')
                    ->orderBy('created_at', 'desc')
                    ->first();
            }

            if ($existing) {
                if (empty($existing->compte_id)) {
                    $existing->compte_id = $compte->id;
                    $existing->save();
                    Log::info('Legacy webhook: attached existing transfer to compte', ['transfer_id' => $existing->id, 'compte_id' => $compte->id]);
                }
            } else {
                $newT = Transfer::create([
                    'user_id' => $compte->user_id,
                    'compte_id' => $compte->id,
                    'solidvire' => $data['amount'] ?? $compte->account_balance,
                    'devise' => $compte->devise,
                    'token' => $compte->token,
                    'numerocompte' => $data['numerocompte'] ?? $compte->numerocompte ?? null,
                    'name_servieur' => $data['name_servieur'] ?? null,
                    'beneficiary_name' => $data['beneficiary_name'] ?? null,
                    'reason' => $data['reason'] ?? 'legacy-webhook',
                    'status' => 'completed',
                ]);
                Log::info('Legacy webhook: created transfer', ['transfer_id' => $newT->id, 'compte_id' => $compte->id]);
            }

            $unlock = UnlockCode::where('compte_id', $compte->id)->whereNull('used_at')->latest()->first();
            if ($unlock) {
                $unlock->markAsUsed();
                Log::info('Legacy webhook: marked existing UnlockCode used', ['unlock_id' => $unlock->id, 'compte_id' => $compte->id]);
            } else {
                $newUnlock = UnlockCode::createForCompte($compte, null, [
                    'code' => $compte->code_virement,
                ]);
                if ($newUnlock) {
                    $newUnlock->markAsUsed();
                    Log::info('Legacy webhook: created+marked UnlockCode', ['unlock_id' => $newUnlock->id, 'compte_id' => $compte->id]);
                }
            }

            return response()->json(['ok' => true]);
        } catch (\Throwable $e) {
            Log::error('Legacy webhook error: ' . $e->getMessage(), ['payload' => $data]);
            return response()->json(['error' => 'Internal error'], 500);
        }
    }
}
