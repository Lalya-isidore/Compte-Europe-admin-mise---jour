<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SmsHistory;
use App\Services\SmsService;
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
                $sms->expediteur,
                $sms->destinataire,
                $sms->message
            );

            $newStatus = ($result['success'] ?? false) ? 'Envoyé' : 'Rejeté';
            $errorMsg  = $result['error'] ?? null;

            SmsHistory::create([
                'user_id'       => $sms->user_id,
                'expediteur'    => $sms->expediteur,
                'pays'          => $sms->pays,
                'destinataire'  => $sms->destinataire,
                'message'       => $sms->message,
                'sms_count'     => $sms->sms_count,
                'credits_used'  => 0,
                'status'        => $newStatus,
                'message_id'    => $result['message_id'] ?? null,
                'error_message' => $errorMsg,
            ]);

            if ($result['success'] ?? false) {
                return back()->with('success', "SMS renvoyé avec succès vers {$sms->destinataire}.");
            }
            return back()->with('error', "Renvoi échoué : " . ($errorMsg ?? 'erreur inconnue'));

        } catch (\Exception $e) {
            Log::error("Admin SMS resend failed for #{$id}: " . $e->getMessage());
            return back()->with('error', "Erreur lors du renvoi : " . $e->getMessage());
        }
    }
}
