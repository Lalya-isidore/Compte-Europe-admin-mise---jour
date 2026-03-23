<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\SmsHistory;
use Illuminate\Support\Facades\DB;

class SmsWebhookController extends Controller
{
    /**
     * Recevoir les mises à jour de statut depuis Twilio
     * 
     * Twilio envoie des webhooks avec ces statuts possibles :
     * - queued: En file d'attente
     * - sending: En cours d'envoi
     * - sent: Envoyé à l'opérateur
     * - delivered: Livré au destinataire ✓
     * - undelivered: Non livré (numéro invalide, téléphone éteint, etc.) ✗
     * - failed: Échec (opérateur bloqué, filtrage, etc.) ✗
     */
    public function handleTwilioStatus(Request $request)
    {
        try {
            // Log de la requête reçue
            Log::info('Webhook Twilio reçu', [
                'data' => $request->all()
            ]);

            $messageSid = $request->input('MessageSid');
            $messageStatus = $request->input('MessageStatus');
            $errorCode = $request->input('ErrorCode');
            $errorMessage = $request->input('ErrorMessage');

            if (!$messageSid || !$messageStatus) {
                Log::warning('Webhook Twilio incomplet', [
                    'data' => $request->all()
                ]);
                return response()->json(['error' => 'Invalid webhook data'], 400);
            }

            // Trouver le SMS dans notre historique
            $sms = SmsHistory::where('message_id', $messageSid)->first();

            if (!$sms) {
                Log::warning('SMS non trouvé dans l\'historique', [
                    'message_sid' => $messageSid
                ]);
                return response()->json(['error' => 'SMS not found'], 404);
            }

            // Mapper les statuts Twilio vers nos statuts
            $ourStatus = $this->mapTwilioStatus($messageStatus);
            $previousStatus = $sms->status;

            // Mettre à jour le statut
            DB::beginTransaction();

            try {
                $sms->status = $ourStatus;
                
                // Si le SMS passe de "Envoyé" à "Rejeté", rembourser les crédits
                if ($previousStatus === 'Envoyé' && $ourStatus === 'Rejeté') {
                    $creditsToRefund = $sms->credits_used;
                    
                    DB::table('users')
                        ->where('id', $sms->user_id)
                        ->update(['credit_user' => DB::raw('credit_user + ' . $creditsToRefund)]);
                    
                    $sms->credits_used = 0;
                    
                    Log::info('SMS rejeté après envoi - Crédits remboursés', [
                        'sms_id' => $sms->id,
                        'user_id' => $sms->user_id,
                        'credits_refunded' => $creditsToRefund,
                        'twilio_status' => $messageStatus
                    ]);
                }

                // Enregistrer le message d'erreur si présent
                if ($errorCode || $errorMessage) {
                    $sms->error_message = "Code {$errorCode}: {$errorMessage}";
                }

                $sms->save();
                
                DB::commit();

                Log::info('Statut SMS mis à jour', [
                    'sms_id' => $sms->id,
                    'previous_status' => $previousStatus,
                    'new_status' => $ourStatus,
                    'twilio_status' => $messageStatus
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Status updated successfully'
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('Erreur traitement webhook Twilio', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mapper les statuts Twilio vers nos statuts
     */
    private function mapTwilioStatus($twilioStatus)
    {
        return match($twilioStatus) {
            'delivered' => 'Livré',
            'undelivered', 'failed' => 'Rejeté',
            'sent', 'sending', 'queued' => 'Envoyé',
            default => 'Envoyé',
        };
    }

    /**
     * Recevoir les mises à jour de statut depuis Infobip
     *
     * Infobip envoie un JSON avec un tableau "results" contenant :
     * - messageId: L'identifiant du message
     * - status.groupName: PENDING, DELIVERED, UNDELIVERABLE, EXPIRED, REJECTED
     * - error.name / error.description: Détails de l'erreur
     */
    public function handleInfobipStatus(Request $request)
    {
        try {
            Log::info('Webhook Infobip reçu', [
                'data' => $request->all()
            ]);

            $results = $request->input('results', []);

            if (empty($results)) {
                Log::warning('Webhook Infobip vide', [
                    'data' => $request->all()
                ]);
                return response()->json(['error' => 'No results in webhook'], 400);
            }

            foreach ($results as $result) {
                $messageId = $result['messageId'] ?? null;
                $statusGroupName = $result['status']['groupName'] ?? null;
                $errorName = $result['error']['name'] ?? null;
                $errorDescription = $result['error']['description'] ?? null;

                if (!$messageId || !$statusGroupName) {
                    Log::warning('Webhook Infobip - résultat incomplet', ['result' => $result]);
                    continue;
                }

                $sms = SmsHistory::where('message_id', $messageId)->first();

                if (!$sms) {
                    Log::warning('SMS Infobip non trouvé dans l\'historique', [
                        'message_id' => $messageId
                    ]);
                    continue;
                }

                $ourStatus = $this->mapInfobipStatus($statusGroupName);
                $previousStatus = $sms->status;

                // Ne pas rétrograder un statut final
                if ($previousStatus === 'Livré' || ($previousStatus === 'Rejeté' && $ourStatus === 'Envoyé')) {
                    Log::info('Statut Infobip ignoré (statut final déjà atteint)', [
                        'sms_id' => $sms->id,
                        'previous' => $previousStatus,
                        'incoming' => $ourStatus,
                    ]);
                    continue;
                }

                DB::beginTransaction();

                try {
                    $sms->status = $ourStatus;

                    // Si le SMS passe de "Envoyé" à "Rejeté", rembourser les crédits
                    if ($previousStatus === 'Envoyé' && $ourStatus === 'Rejeté') {
                        $creditsToRefund = $sms->credits_used;

                        DB::table('users')
                            ->where('id', $sms->user_id)
                            ->update(['credit_user' => DB::raw('credit_user + ' . $creditsToRefund)]);

                        $sms->credits_used = 0;

                        Log::info('SMS Infobip rejeté - Crédits remboursés', [
                            'sms_id' => $sms->id,
                            'user_id' => $sms->user_id,
                            'credits_refunded' => $creditsToRefund,
                            'infobip_status' => $statusGroupName,
                        ]);
                    }

                    // Enregistrer le message d'erreur traduit pour l'utilisateur
                    if ($errorName && $errorName !== 'NO_ERROR') {
                        $sms->error_message = $this->translateInfobipError($errorName, $errorDescription);
                    }

                    $sms->save();
                    DB::commit();

                    Log::info('Statut SMS Infobip mis à jour', [
                        'sms_id' => $sms->id,
                        'previous_status' => $previousStatus,
                        'new_status' => $ourStatus,
                        'infobip_status' => $statusGroupName,
                    ]);

                } catch (\Exception $e) {
                    DB::rollBack();
                    throw $e;
                }
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            Log::error('Erreur traitement webhook Infobip', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mapper les statuts Infobip vers nos statuts
     */
    private function mapInfobipStatus(string $groupName): string
    {
        return match (strtoupper($groupName)) {
            'DELIVERED' => 'Livré',
            'UNDELIVERABLE', 'REJECTED', 'EXPIRED' => 'Rejeté',
            'PENDING', 'ACCEPTED' => 'Envoyé',
            default => 'Envoyé',
        };
    }

    /**
     * Traduire les erreurs Infobip en messages compréhensibles
     */
    private function translateInfobipError(string $errorName, ?string $errorDescription = null): string
    {
        $translations = [
            'EC_ACCOUNT_NOT_PROVISIONED_FOR_SMS' => 'Le service SMS n\'est pas activé pour cette destination. Veuillez contacter le support.',
            'EC_ABSENT_SUBSCRIBER' => 'Le destinataire est injoignable (téléphone éteint ou hors réseau).',
            'EC_ABSENT_SUBSCRIBER_SM' => 'Le destinataire est injoignable (téléphone éteint ou hors réseau).',
            'EC_CALL_BARRED' => 'Le numéro du destinataire est bloqué ou restreint par l\'opérateur.',
            'EC_DELIVERY_FAILED' => 'La livraison du SMS a échoué. Veuillez réessayer.',
            'EC_DEST_ADDRESS_BLACKLISTED' => 'Ce numéro est sur liste noire et ne peut pas recevoir de SMS.',
            'EC_DEST_ADDRESS_NOT_FOUND' => 'Le numéro du destinataire est invalide ou n\'existe pas.',
            'EC_EXPIRED' => 'Le SMS a expiré avant d\'être livré (téléphone éteint trop longtemps).',
            'EC_INVALID_DESTINATION_ADDRESS' => 'Le numéro du destinataire est invalide. Vérifiez le format.',
            'EC_INVALID_SOURCE_ADDRESS' => 'Le nom d\'expéditeur est invalide ou non autorisé pour cette destination.',
            'EC_NOT_ENOUGH_CREDITS' => 'Crédits insuffisants sur le compte SMS. Contactez le support.',
            'EC_NOT_FOUND' => 'Le message n\'a pas été trouvé par l\'opérateur.',
            'EC_NUMBER_NOT_IN_NETWORK' => 'Le numéro n\'appartient à aucun réseau mobile connu.',
            'EC_REJECTED' => 'Le SMS a été rejeté par l\'opérateur du destinataire.',
            'EC_SYSTEM_ERROR' => 'Erreur système temporaire. Veuillez réessayer dans quelques minutes.',
            'EC_TELESERVICE_NOT_PROVISIONED' => 'Le destinataire n\'a pas le service SMS activé sur sa ligne.',
            'EC_UNKNOWN_SUBSCRIBER' => 'Le numéro du destinataire est inconnu du réseau mobile.',
            'EC_UNDELIVERABLE' => 'Le SMS n\'a pas pu être livré au destinataire.',
            'EC_MESSAGE_FILTERED' => 'Le SMS a été filtré par l\'opérateur (contenu ou expéditeur suspect).',
        ];

        return $translations[$errorName] ?? "Erreur lors de l'envoi du SMS. Veuillez réessayer ou contacter le support.";
    }

    /**
     * Webhook pour autres fournisseurs SMS (à implémenter selon besoin)
     */
    public function handleVonageStatus(Request $request)
    {
        // TODO: Implémenter pour Vonage/Nexmo
        return response()->json(['message' => 'Not implemented yet']);
    }
}
