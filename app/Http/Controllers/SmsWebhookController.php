<?php

namespace App\Http\Controllers;

use App\Models\SmsHistory;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Twilio\Security\RequestValidator;

class SmsWebhookController extends Controller
{
    private const FALLBACK_STATUSES = ['failed', 'undelivered'];

    /**
     * Webhook principal : reçoit les mises à jour de statut Twilio.
     * Déclenche automatiquement le fallback numéro classique si l'alphanumérique échoue.
     */
    public function twilioStatus(Request $request)
    {
        if (!$this->validateTwilioSignature($request, '/webhook/twilio/sms-status')) {
            Log::warning('Twilio webhook: signature invalide', ['ip' => $request->ip()]);
            return response('Unauthorized', 403);
        }

        $messageSid    = $request->input('MessageSid');
        $messageStatus = $request->input('MessageStatus');
        $errorCode     = $request->input('ErrorCode');

        Log::info('Twilio status callback', [
            'sid' => $messageSid, 'status' => $messageStatus, 'error_code' => $errorCode,
        ]);

        $sms = SmsHistory::where('twilio_sid', $messageSid)->first();
        if (!$sms) {
            return response('OK', 200);
        }

        $sms->delivery_status = $messageStatus;
        $sms->error_code      = $errorCode;

        if ($messageStatus === 'delivered') {
            $sms->status = 'Livré';
        } elseif (in_array($messageStatus, self::FALLBACK_STATUSES)) {
            $sms->status = 'Rejeté';

            // Planifier le renvoi automatique dans 60s si numéro fallback configuré
            if (!$sms->fallback_sent && config('services.twilio.phone_number') && !$sms->retry_after) {
                $sms->retry_after = now()->addSeconds(60);
            }
        }

        $sms->save();
        return response('OK', 200);
    }

    /**
     * Webhook fallback : reçoit le statut du SMS renvoyé avec le numéro classique.
     */
    public function twilioStatusFallback(Request $request)
    {
        if (!$this->validateTwilioSignature($request, '/webhook/twilio/sms-status-fallback')) {
            return response('Unauthorized', 403);
        }

        $fallbackSid   = $request->input('MessageSid');
        $messageStatus = $request->input('MessageStatus');

        $sms = SmsHistory::where('fallback_sid', $fallbackSid)->first();
        if (!$sms) {
            return response('OK', 200);
        }

        if ($messageStatus === 'delivered') {
            $sms->status = 'Livré (2e tentative auto)';
        } elseif (in_array($messageStatus, self::FALLBACK_STATUSES)) {
            $sms->status = 'Rejeté';
        }

        $sms->delivery_status = $messageStatus;
        $sms->save();

        return response('OK', 200);
    }

    /**
     * Webhook Infobip : reçoit les rapports de livraison SMS.
     */
    public function handleInfobipStatus(Request $request)
    {
        $payload = $request->all();

        $results = $payload['results'] ?? [];

        foreach ($results as $result) {
            $messageId   = $result['messageId'] ?? null;
            $groupName   = $result['status']['groupName'] ?? null;
            $statusName  = $result['status']['name'] ?? null;

            if (!$messageId) continue;

            $sms = SmsHistory::where('message_id', $messageId)->first();
            if (!$sms) continue;

            if ($groupName === 'DELIVERED') {
                $sms->status = 'Livré';
            } elseif (in_array($groupName, ['UNDELIVERABLE', 'REJECTED', 'EXPIRED'])) {
                $sms->status = 'Rejeté';
                $sms->error_code = $result['error']['name'] ?? null;
            }

            try {
                $sms->delivery_status = strtolower($statusName ?? $groupName);
                $sms->save();
            } catch (\Exception) {
                // Colonne delivery_status absente en DB — sauvegarder sans elle
                try {
                    $sms->syncOriginal();
                    \Illuminate\Support\Facades\DB::table('sms_history')
                        ->where('id', $sms->id)
                        ->update(['status' => $sms->status, 'error_code' => $sms->error_code, 'updated_at' => now()]);
                } catch (\Exception $e2) {
                    Log::warning('Infobip DLR save failed', ['message_id' => $messageId, 'error' => $e2->getMessage()]);
                }
            }
        }

        return response('OK', 200);
    }

    private function sendFallback(SmsHistory $sms): void
    {
        try {
            $service  = app(SmsService::class);
            $response = $service->sendFallback($sms->destinataire, $sms->message);

            if ($response['success']) {
                $sms->fallback_sent = true;
                $sms->fallback_sid  = $response['twilio_sid'];
                $sms->status        = 'Fallback envoyé';
                Log::info('SMS fallback envoyé', [
                    'original_sid' => $sms->twilio_sid,
                    'fallback_sid' => $response['twilio_sid'],
                    'to'           => $sms->destinataire,
                ]);
            } else {
                Log::error('SMS fallback échoué', ['error' => $response['error'] ?? 'unknown']);
            }
        } catch (\Exception $e) {
            Log::error('SMS fallback exception', ['error' => $e->getMessage()]);
        }
    }

    private function validateTwilioSignature(Request $request, string $path): bool
    {
        $authToken = config('services.twilio.auth_token');
        if (!$authToken) {
            return false;
        }
        $url       = rtrim(config('app.url'), '/') . $path;
        $signature = $request->header('X-Twilio-Signature', '');
        $validator = new RequestValidator($authToken);
        return $validator->validate($signature, $url, $request->all());
    }
}
