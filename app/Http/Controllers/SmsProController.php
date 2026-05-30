<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\SmsHistory;
use App\Models\ToolPageVisit;
use Illuminate\Support\Facades\DB;
use Twilio\Rest\Client;

class SmsProController extends Controller
{
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
            'expediteur' => 'required|string|max:11',
            'pays' => 'required|string',
            'numero' => 'required|string',
            'message' => 'required|string',
        ]);

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
                // Déduire les crédits immédiatement via DB query
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['credit_user' => DB::raw('credit_user - ' . $creditsNeeded)]);

                // Envoyer le SMS via le service SMS (Infobip par défaut)
                $status = 'Rejeté';
                $messageId = 'SMS_' . uniqid();
                $errorMessage = 'API SMS non configurée - SMS non envoyé';

                $smsService = app(\App\Services\SmsService::class);
                $response = $smsService->send($fullNumber, $request->message, $request->expediteur);

                if ($response['success']) {
                    // Statut initial "Envoyé" - sera mis à jour par le webhook si applicable
                    $status = 'Envoyé';
                    $messageId = $response['message_id'];
                    $errorMessage = null;

                    Log::info('SMS envoyé avec succès via SmsService', [
                        'message_id' => $messageId,
                        'to' => $fullNumber
                    ]);
                } else {
                    $status = 'Rejeté';
                    $errorMessage = 'Erreur SMS: ' . ($response['error'] ?? 'Inconnue');

                    Log::error('Erreur envoi SMS via SmsService', [
                        'error' => $errorMessage,
                        'to' => $fullNumber
                    ]);
                }

                // Si le SMS est rejeté, rembourser les crédits
                if ($status === 'Rejeté') {
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['credit_user' => DB::raw('credit_user + ' . $creditsNeeded)]);
                }

                // Sauvegarder dans l'historique
                SmsHistory::create([
                    'user_id' => $user->id,
                    'expediteur' => $request->expediteur,
                    'pays' => $request->pays,
                    'destinataire' => $fullNumber,
                    'message' => $request->message,
                    'sms_count' => max($segments, 1),
                    'credits_used' => $status === 'Rejeté' ? 0 : $creditsNeeded, // Envoyé = crédits déduits, Rejeté = déjà remboursé
                    'status' => $status,
                    'message_id' => $messageId,
                    'error_message' => $errorMessage
                ]);

                DB::commit();

                // Récupérer les crédits à jour
                $finalCredits = DB::table('users')
                    ->where('id', $user->id)
                    ->value('credit_user');

                Log::info('SMS Pro traité', [
                    'user_id' => $user->id,
                    'expediteur' => $request->expediteur,
                    'destinataire' => $fullNumber,
                    'credits_utilises' => $status === 'Livré' ? $creditsNeeded : 0,
                    'status' => $status,
                    'credits_restants' => $finalCredits
                ]);

                if ($status === 'Rejeté') {
                    return response()->json([
                        'success' => false,
                        'message' => 'SMS rejeté. Vos crédits ont été remboursés.',
                        'credits_restants' => $finalCredits
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'SMS en cours d\'acheminement. Le statut sera mis à jour automatiquement.',
                    'credits_used' => $creditsNeeded,
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
