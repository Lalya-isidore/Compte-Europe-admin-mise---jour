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

            // Fallback automatique si numéro configuré et pas encore tenté
            if (!$sms->fallback_sent && config('services.twilio.phone_number')) {
                $this->sendFallback($sms);
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
            $sms->status = 'Livré (fallback)';
        } elseif (in_array($messageStatus, self::FALLBACK_STATUSES)) {
            $sms->status = 'Rejeté';
        }

        $sms->delivery_status = $messageStatus;
        $sms->save();

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
