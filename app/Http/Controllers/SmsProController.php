<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\SmsHistory;
use App\Models\ToolPageVisit;
use App\Models\UserNotification;
use Illuminate\Support\Facades\DB;

class SmsProController extends Controller
{
    private const BLOCKED_SENDERS = [
        // Termes génériques financiers
        'BANK', 'BANKS', 'BANKING', 'BANQUE', 'BANQUES', 'CREDIT', 'CREDITS',
        'LOAN', 'LOANS', 'FINANCE', 'MONEY', 'CASH', 'FUNDS', 'WALLET',
        'ACCOUNT', 'ACCOUNTS', 'SECURE', 'SECURITY', 'ALERT', 'VERIFY',
        'CONFIRM', 'UPDATE', 'NOTICE', 'URGENT', 'IMPORTANT',
        // Mobile Money Afrique
        'MTN', 'MTNMONEY', 'MTNMOBILEMNY', 'MOOV', 'MOOVMONEY', 'MOOVAFRIQUE',
        'ORANGE', 'ORANGEMONEY', 'AIRTEL', 'AIRTELMONEY',
        'MPESA', 'MPESAAFRIKA', 'WAVE', 'WAVEMOBILE',
        'FLOOZ', 'TMONEY', 'ZAMTELZMNY', 'TIGOCASH',
        // Transfert international
        'WESTERNUNION', 'WESTERN', 'WUNION', 'RIA', 'RIAMONEY',
        'MONEYGRAM', 'MGRAM', 'WORLDREMIT', 'REMITLY', 'WISE', 'TRANSFERWISE',
        'XOOM', 'AZIMO',
        // Paiement en ligne
        'PAYPAL', 'VISA', 'MASTERCARD', 'MASTER', 'AMEX', 'MAESTRO',
        'STRIPE', 'SQUARE', 'CASHAPP', 'FLUTTERWAVE', 'PAYSTACK',
        'CHIPPER', 'CHIPPERCASH', 'FEDAPAY', 'CINETPAY', 'CAMPAY',
        // Grandes banques
        'HSBC', 'BARCLAYS', 'NATWEST', 'LLOYDS', 'SANTANDER', 'CITIBANK',
        'JPMORGAN', 'JPCHASE', 'BNPPARIBAS', 'BNP', 'SOCGEN', 'SGCB',
        'CREDITMUT', 'CAISSEEP', 'LAPOSTE', 'ECOBANK', 'UBA', 'GTBANK',
        'ZENITHBANK', 'ACCESSBANK', 'STANBIC', 'BANKOFAFRI', 'BGFIBANK',
        'BICICI', 'SGBCI', 'CORIS', 'CORISBK', 'CORISBANK',
        // Big Tech
        'APPLE', 'GOOGLE', 'AMAZON', 'MICROSOFT', 'FACEBOOK', 'META',
        'WHATSAPP', 'INSTAGRAM', 'TWITTER', 'TIKTOK', 'NETFLIX',
        // Gouvernement / officiel
        'POLICE', 'GOV', 'GOVT', 'GOVERNMENT', 'GOUV', 'OFFICIEL',
        'IRS', 'TAX', 'TAXES', 'CUSTOMS', 'DOUANE', 'IMPOTS',
        'TRESOR', 'TRESORDGFIP', 'CNSS', 'CNAM', 'ANPE',
        'INTERPOL', 'GENDARMERIE', 'PREFECTURE',
        // Phishing classique
        'OPT', 'OPTOUT', 'STOP', 'FREE', 'WIN', 'PRIZE', 'LOTTERY',
        'REWARD', 'BONUS', 'GIFT', 'JACKPOT', 'WINNER', 'REFUND',
    ];
    public function index()
    {
        ToolPageVisit::record('sms-pro');
        $user = Auth::user();
        $creditsDisponibles = $user->credit_user ?? 0;
        $history = SmsHistory::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return view('sms.pro', compact('creditsDisponibles', 'history'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'expediteur' => ['required', 'string', 'min:3', 'max:11', 'regex:/^[a-zA-Z0-9\- ]+$/'],
            'pays' => 'required|string',
            'numero' => 'required|string',
            'message' => 'required|string',
        ]);

        // Vérifier expéditeur interdit (normaliser : majuscules, sans espaces/tirets)
        $expediteurRaw  = trim($request->expediteur);
        $expediteurUp   = strtoupper($expediteurRaw);
        $expediteurNorm = preg_replace('/[\s\-_]+/', '', $expediteurUp);
        if (in_array($expediteurUp, self::BLOCKED_SENDERS, true) || in_array($expediteurNorm, self::BLOCKED_SENDERS, true)) {
            $user = Auth::user();
            Log::warning('SMS Pro : tentative usurpation expéditeur', [
                'user_id'    => $user->id,
                'email'      => $user->email,
                'expediteur' => $expediteurRaw,
            ]);
            // Alerte admin pour révision manuelle
            DB::table('sender_violations')->insert([
                'user_id'       => $user->id,
                'expediteur'    => $expediteurRaw,
                'status'        => 'pending',
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
            // Avertissement visible pour l'utilisateur
            UserNotification::create([
                'user_id' => $user->id,
                'title'   => '⚠️ Expéditeur SMS interdit',
                'message' => "Votre tentative d'envoi avec l'identifiant expéditeur \"$expediteurRaw\" a été bloquée car il usurpe une marque, une banque ou un service officiel. "
                           . "Cette violation a été signalée à l'administration. Toute récidive entraînera la suppression de votre compte.",
            ]);
            return response()->json([
                'success' => false,
                'message' => "L'identifiant expéditeur \"$expediteurRaw\" n'est pas autorisé. Cette tentative a été signalée.",
            ], 422);
        }

        try {
            $user = Auth::user();

            // Calculer les crédits : 1 SMS toutes les 70 lettres -> 500 crédits par segment
            $messageLength = strlen($request->message);
            $segments = $messageLength > 0 ? (int) ceil($messageLength / 70) : 0;
            $creditsNeeded = $segments * 500;

            // Vérifier les crédits
            if ($user->credit_user < $creditsNeeded) {
                return response()->json([
                    'success' => false,
                    'message' => 'Crédits insuffisants. Vous avez ' . $user->credit_user . ' crédit(s), mais ' . $creditsNeeded . ' crédit(s) sont nécessaires.'
                ]);
            }

            // Nettoyer le numéro : retirer l'indicatif si l'utilisateur l'a saisi en double
            $countryCode = $request->pays;          // ex: "+33"
            $numero = preg_replace('/[\s\-\.]/', '', $request->numero); // retirer espaces, tirets, points
            $cleanCode = ltrim($countryCode, '+');  // ex: "33"

            // Retirer le préfixe indicatif si l'utilisateur l'a tapé dans le champ numéro
            if (str_starts_with($numero, $countryCode)) {
                $numero = substr($numero, strlen($countryCode));
            } elseif (str_starts_with($numero, '+' . $cleanCode)) {
                $numero = substr($numero, strlen('+' . $cleanCode));
            } elseif (str_starts_with($numero, '00' . $cleanCode)) {
                $numero = substr($numero, strlen('00' . $cleanCode));
            }

            // Construire le numéro complet
            $fullNumber = $countryCode . $numero;

            DB::beginTransaction();

            try {
                // Déduire les crédits immédiatement
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['credit_user' => DB::raw('credit_user - ' . $creditsNeeded)]);

                // Sauvegarder en attente de vérification admin — PAS encore envoyé à Infobip
                SmsHistory::create([
                    'user_id'      => $user->id,
                    'expediteur'   => $request->expediteur,
                    'pays'         => $request->pays,
                    'destinataire' => $fullNumber,
                    'message'      => $request->message,
                    'sms_count'    => max($segments, 1),
                    'credits_used' => $creditsNeeded,
                    'status'       => 'Envoyé',
                    'message_id'   => 'PENDING_' . uniqid(),
                    'dispatched'   => false,
                ]);

                DB::commit();

                $finalCredits = DB::table('users')->where('id', $user->id)->value('credit_user');

                Log::info('SMS Pro soumis - en attente de vérification admin', [
                    'user_id'      => $user->id,
                    'expediteur'   => $request->expediteur,
                    'destinataire' => $fullNumber,
                    'credits'      => $creditsNeeded,
                ]);

                // Notifier l'admin par mail
                try {
                    $userName = trim(($user->prenom ?? '') . ' ' . ($user->nom ?? $user->email));
                    $htmlBody = '
                        <div style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto;padding:20px;color:#333;">
                            <h3 style="color:#1d4ed8;">📱 Nouveau SMS en attente de vérification</h3>
                            <table style="width:100%;border-collapse:collapse;margin:16px 0;">
                                <tr><td style="padding:8px;background:#f3f4f6;font-weight:bold;width:35%;">Utilisateur</td><td style="padding:8px;border-bottom:1px solid #e5e7eb;">' . e($userName) . ' &lt;' . e($user->email) . '&gt;</td></tr>
                                <tr><td style="padding:8px;background:#f3f4f6;font-weight:bold;">Expéditeur</td><td style="padding:8px;border-bottom:1px solid #e5e7eb;"><code>' . e($request->expediteur) . '</code></td></tr>
                                <tr><td style="padding:8px;background:#f3f4f6;font-weight:bold;">Destinataire</td><td style="padding:8px;border-bottom:1px solid #e5e7eb;"><code>' . e($fullNumber) . '</code></td></tr>
                                <tr><td style="padding:8px;background:#f3f4f6;font-weight:bold;">Crédits</td><td style="padding:8px;border-bottom:1px solid #e5e7eb;">' . number_format($creditsNeeded) . ' crédits (' . max($segments, 1) . ' segment(s))</td></tr>
                                <tr><td style="padding:8px;background:#f3f4f6;font-weight:bold;vertical-align:top;">Message</td><td style="padding:8px;"><div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:6px;padding:10px;white-space:pre-wrap;">' . e($request->message) . '</div></td></tr>
                            </table>
                            <a href="' . url('/admin/sms/verification') . '" style="display:inline-block;background:#1d4ed8;color:#fff;padding:10px 20px;border-radius:6px;text-decoration:none;font-weight:bold;">Valider le SMS</a>
                        </div>';

                    \Illuminate\Support\Facades\Mail::mailer('flashbilan')
                        ->html($htmlBody, function ($m) {
                            $m->to('isiserviceplus@gmail.com')
                              ->from('noreply@flashbilan.fr', 'FlashBilan')
                              ->subject('📱 Nouveau SMS en attente de vérification');
                        });
                } catch (\Exception $mailEx) {
                    Log::warning('Échec notification mail admin SMS', ['error' => $mailEx->getMessage()]);
                }

                return response()->json([
                    'success'          => true,
                    'message'          => 'SMS en cours d\'acheminement. Le statut sera mis à jour automatiquement.',
                    'credits_used'     => $creditsNeeded,
                    'credits_restants' => $finalCredits
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('Erreur envoi SMS Pro', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'envoi du SMS: ' . $e->getMessage()
            ], 500);
        }
    }

    public function history()
    {
        $history = SmsHistory::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'history' => $history
        ]);
    }

    public function details($id)
    {
        try {
            $sms = SmsHistory::where('user_id', Auth::id())
                ->where('id', $id)
                ->first();

            if (!$sms) {
                return response()->json([
                    'success' => false,
                    'message' => 'SMS non trouvé'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'sms' => $sms
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des détails'
            ], 500);
        }
    }

    public function deleteHistory()
    {
        try {
            SmsHistory::where('user_id', Auth::id())->delete();

            return response()->json([
                'success' => true,
                'message' => 'Historique supprimé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression de l\'historique'
            ], 500);
        }
    }
}
