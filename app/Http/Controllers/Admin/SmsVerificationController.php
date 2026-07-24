<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SmsHistory;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SmsVerificationController extends Controller
{
    public function index()
    {
        $pending = SmsHistory::with('user')
            ->where('dispatched', false)
            ->where('status', 'Envoyé')
            ->orderBy('created_at', 'asc')
            ->paginate(50);

        return view('admin.sms-verification', compact('pending'));
    }

    public function dispatch(Request $request, int $id)
    {
        $sms = SmsHistory::findOrFail($id);

        if ($sms->dispatched) {
            return back()->with('error', 'Ce SMS a déjà été traité.');
        }

        $smsService = app(SmsService::class);
        $response = $smsService->send($sms->destinataire, $sms->message, $sms->expediteur);

        DB::beginTransaction();

        try {
            if ($response['success']) {
                $sms->message_id = $response['message_id'];
                $sms->dispatched = true;
                $sms->save();

                Log::info('SMS dispatché vers Twilio par admin', [
                    'sms_id'     => $sms->id,
                    'message_id' => $sms->message_id,
                ]);

                DB::commit();
                return back()->with('success', 'SMS envoyé via Twilio. Le statut sera mis à jour automatiquement.');
            }

            // Twilio a rejeté immédiatement — rembourser les crédits
            DB::table('users')
                ->where('id', $sms->user_id)
                ->update(['credit_user' => DB::raw('credit_user + ' . $sms->credits_used)]);

            $sms->status        = 'Rejeté';
            $sms->error_message = 'Rejeté par l\'opérateur : ' . ($response['error'] ?? 'Erreur inconnue');
            $sms->credits_used  = 0;
            $sms->dispatched    = true;
            $sms->save();

            DB::commit();

            Log::warning('SMS rejeté par Twilio lors du dispatch admin', [
                'sms_id' => $sms->id,
                'error'  => $response['error'] ?? '',
            ]);

            return back()->with('error', 'Twilio a rejeté le SMS. Les crédits ont été remboursés à l\'utilisateur.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur dispatch SMS admin', ['error' => $e->getMessage(), 'sms_id' => $id]);
            return back()->with('error', 'Erreur lors de l\'envoi : ' . $e->getMessage());
        }
    }

    public function reject(Request $request, int $id)
    {
        $request->validate(['reason' => 'required|string|max:500']);

        $sms = SmsHistory::findOrFail($id);

        if ($sms->dispatched) {
            return back()->with('error', 'Ce SMS a déjà été traité.');
        }

        DB::beginTransaction();

        try {
            DB::table('users')
                ->where('id', $sms->user_id)
                ->update(['credit_user' => DB::raw('credit_user + ' . $sms->credits_used)]);

            $sms->status           = 'Rejeté';
            $sms->rejection_reason = $request->reason;
            $sms->credits_used     = 0;
            $sms->dispatched       = true;
            $sms->save();

            DB::commit();

            Log::info('SMS rejeté manuellement par admin', [
                'sms_id' => $sms->id,
                'reason' => $request->reason,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur rejet SMS admin', ['error' => $e->getMessage(), 'sms_id' => $id]);
            return back()->with('error', 'Erreur lors du rejet : ' . $e->getMessage());
        }

        return back()->with('success', 'SMS rejeté. Les crédits ont été remboursés à l\'utilisateur.');
    }
}
