<?php

namespace App\Console\Commands;

use App\Models\SmsHistory;
use App\Services\SmsService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RetrySmsCommand extends Command
{
    protected $signature = 'sms:retry-failed';
    protected $description = 'Renvoie via numéro fallback les SMS rejetés après le délai de 60s';

    public function handle(SmsService $smsService): void
    {
        if (!config('services.twilio.phone_number')) {
            return;
        }

        $pending = SmsHistory::whereNotNull('retry_after')
            ->where('retry_after', '<=', now())
            ->where('fallback_sent', false)
            ->get();

        foreach ($pending as $sms) {
            $sms->retry_after = null;

            $response = $smsService->sendFallback($sms->destinataire, $sms->message);

            if ($response['success']) {
                $sms->fallback_sent = true;
                $sms->fallback_sid  = $response['twilio_sid'] ?? null;
                $sms->status        = 'Fallback envoyé';
                Log::info('SMS retry automatique envoyé', ['sms_id' => $sms->id, 'to' => $sms->destinataire]);
            } else {
                $sms->status = 'Échec';
                Log::warning('SMS retry automatique échoué', ['sms_id' => $sms->id, 'error' => $response['error'] ?? 'unknown']);
            }

            $sms->save();
        }
    }
}
