<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SenderViolation;
use Illuminate\Support\Facades\DB;

class SenderViolationController extends Controller
{
    public function index()
    {
        $violations = SenderViolation::with('user')
            ->orderByRaw("FIELD(status, 'pending', 'dismissed', 'deleted')")
            ->orderByDesc('created_at')
            ->paginate(30);

        $pendingCount = SenderViolation::where('status', 'pending')->count();

        return view('admin.sender-violations.index', compact('violations', 'pendingCount'));
    }

    public function deleteUser(SenderViolation $senderViolation)
    {
        if (! $senderViolation->isPending()) {
            return back()->with('error', 'Cette violation a déjà été traitée.');
        }

        $userId = $senderViolation->user_id;

        DB::transaction(function () use ($userId, $senderViolation) {
            // Supprimer les données utilisateur dans l'ordre (éviter les FK)
            DB::table('sms_history')->where('user_id', $userId)->delete();
            DB::table('mail_history')->where('user_id', $userId)->delete();
            DB::table('user_notifications')->where('user_id', $userId)->delete();
            DB::table('tool_page_visits')->where('user_id', $userId)->delete();
            DB::table('platform_visits')->where('user_id', $userId)->delete();
            DB::table('url_shortener_history')->where('user_id', $userId)->delete();
            DB::table('url_verifications')->where('user_id', $userId)->delete();
            DB::table('email_extractor_history')->where('user_id', $userId)->delete();
            DB::table('iban_verifications')->where('user_id', $userId)->delete();
            DB::table('phone_verifications')->where('user_id', $userId)->delete();
            DB::table('badge_agent_usages')->where('user_id', $userId)->delete();
            DB::table('contrat_pret_usages')->where('user_id', $userId)->delete();
            DB::table('contrat_don_usages')->where('user_id', $userId)->delete();
            DB::table('contract_histories')->where('user_id', $userId)->delete();
            DB::table('payment_claims')->where('user_id', $userId)->delete();
            DB::table('user_payment_links')->where('user_id', $userId)->delete();
            DB::table('payout_configs')->where('user_id', $userId)->delete();
            DB::table('payout_methods')->where('user_id', $userId)->delete();
            DB::table('support_tickets')->where('user_id', $userId)->delete();
            DB::table('affiliations')->where('user_id', $userId)->delete();
            DB::table('recharge_transactions')->where('user_id', $userId)->delete();

            // Comptes bancaires et leurs transactions
            $compteIds = DB::table('comptes')->where('user_id', $userId)->pluck('id');
            if ($compteIds->isNotEmpty()) {
                DB::table('recharge_transactions')->whereIn('compte_id', $compteIds)->delete();
                DB::table('transfers')->whereIn('compte_id', $compteIds)->delete();
                DB::table('transaction_histories')->whereIn('compte_id', $compteIds)->delete();
                DB::table('retraits')->whereIn('compte_id', $compteIds)->delete();
                DB::table('commissions')->whereIn('compte_id', $compteIds)->delete();
                DB::table('comptes')->where('user_id', $userId)->delete();
            }

            // Marquer la violation comme traitée avant de supprimer le user (FK cascade supprime les autres violations)
            DB::table('sender_violations')
                ->where('user_id', $userId)
                ->update(['status' => 'deleted']);

            // Supprimer les sessions actives
            DB::table('sessions')->where('user_id', $userId)->delete();

            // Supprimer le compte utilisateur
            DB::table('users')->where('id', $userId)->delete();
        });

        return back()->with('success', 'Compte supprimé avec toutes ses données.');
    }

    public function dismiss(SenderViolation $senderViolation)
    {
        if (! $senderViolation->isPending()) {
            return back()->with('error', 'Cette violation a déjà été traitée.');
        }

        $senderViolation->update(['status' => 'dismissed']);

        return back()->with('success', 'Violation ignorée.');
    }
}
