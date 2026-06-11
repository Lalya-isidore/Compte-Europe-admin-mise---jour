<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SmsHistory;
use App\Services\SmsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SmsRejectedController extends Controller
{
    private const EXCLUDED_EMAILS = [
        'candide730@gmail.com',
        'lalyaisidore@gmail.com',
        'floralalya@gmail.com',
        'isidore@lannkin.com',
        'isiserviceplus@gmail.com',
        'durandfranck249@gmail.com',
    ];

    public function index()
    {
        $rejected = SmsHistory::with('user')
            ->where('status', 'Rejeté')
            ->whereHas('user', fn($q) => $q->whereNotIn('email', self::EXCLUDED_EMAILS))
            ->latest()
            ->paginate(50);

        return view('admin.sms-rejected', compact('rejected'));
    }

    public function resend(int $id)
    {
        $sms = SmsHistory::findOrFail($id);

        try {
            $result = (new SmsService())->send(
                $sms->destinataire,
                $sms->message,
                $sms->expediteur
            );

            $success      = $result['success'] ?? false;
            $newStatus    = $success ? 'Envoyé' : 'Rejeté';
            $errorMsg     = $result['error'] ?? null;
            $creditsNeeded = ($sms->sms_count ?? 1) * 500;

            if ($success && $sms->user_id) {
                DB::table('users')
                    ->where('id', $sms->user_id)
                    ->update(['credit_user' => DB::raw('credit_user - ' . $creditsNeeded)]);
            }

            SmsHistory::create([
                'user_id'       => $sms->user_id,
                'expediteur'    => $sms->expediteur,
                'pays'          => $sms->pays,
                'destinataire'  => $sms->destinataire,
                'message'       => $sms->message,
                'sms_count'     => $sms->sms_count,
                'credits_used'  => $success ? $creditsNeeded : 0,
                'status'        => $newStatus,
                'message_id'    => $result['message_id'] ?? null,
                'twilio_sid'    => $result['twilio_sid'] ?? null,
                'error_message' => $errorMsg,
            ]);

            if ($success) {
                return back()->with('success', "SMS renvoyé avec succès vers {$sms->destinataire}. {$creditsNeeded} crédit(s) déduit(s).");
            }
            return back()->with('error', "Renvoi échoué : " . ($errorMsg ?? 'erreur inconnue'));

        } catch (\Exception $e) {
            Log::error("Admin SMS resend failed for #{$id}: " . $e->getMessage());
            return back()->with('error', "Erreur lors du renvoi : " . $e->getMessage());
        }
    }
}
