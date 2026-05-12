<?php

namespace App\Http\Controllers;

use App\Models\RechargeTransaction;
use App\Models\Compte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use GuzzleHttp\Client;
use FedaPay\FedaPay;
use FedaPay\Transaction;
use App\Models\Affiliation;
use App\Models\Commission;

class RechargeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Log de test pour vérifier que les logs fonctionnent en production
        Log::info('Test log: RechargeController@index called', ['user_id' => $user->id ?? null]);
        
        // Vérifier si l'utilisateur est connecté
        if (!$user) {
            return redirect()->route('connexion');
        }
        
        // Récupérer le premier compte de l'utilisateur
        $compte = Compte::where('user_id', $user->id)->first();
        
        $transactions = RechargeTransaction::where('user_id', $user->id)
                                         ->orderBy('created_at', 'desc')
                                         ->paginate(10);
        
        return view('recharge.index', compact('transactions', 'compte'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|in:1500,3000,5000,10000,15000,20000,25000,50000',
            // Include all supported payment methods (matches switch cases)
            'payment_method' => 'required|in:fedapay,oosic,card,mobile_money,bank_transfer'
        ]);

        $user = Auth::user();
        $compte = Compte::where('user_id', $user->id)->first();

        // Créer la transaction (compte_id optionnel)
        $transaction = RechargeTransaction::create([
            'user_id' => $user->id,
            'compte_id' => $compte->id ?? null,
            'transaction_id' => RechargeTransaction::generateTransactionId(),
            'amount' => $request->amount,
            'credits_earned' => RechargeTransaction::calculateCredits($request->amount),
            'payment_method' => $request->payment_method,
            'status' => 'pending'
        ]);

        // Rediriger vers le processeur de paiement approprié
        switch ($request->payment_method) {
            case 'fedapay':
                return $this->processFedapayPayment($transaction);
            case 'oosic':
                return $this->processOosicPayment($transaction);
            case 'card':
                return $this->processCardPayment($transaction);
            case 'mobile_money':
                return $this->processMobileMoneyPayment($transaction);
            default:
                return response()->json(['error' => 'Méthode de paiement non supportée'], 400);
        }
    }

    private function processFedapayPayment($transaction)
    {
        // Vérifier que les clés FedaPay sont configurées
        if (!config('services.fedapay.secret_key')) {
            return response()->json(['error' => 'Configuration FedaPay manquante. Contactez l\'administrateur.'], 500);
        }
        
        try {
            // Configuration FedaPay
            FedaPay::setApiKey(config('services.fedapay.secret_key'));
            FedaPay::setEnvironment('live');
            
            Log::info('Creating FedaPay transaction', [
                'amount' => $transaction->amount,
                'transaction_id' => $transaction->transaction_id
            ]);
            
            // Créer la transaction FedaPay avec URLs complètes
            $fedapayTransaction = Transaction::create([
                'description' => app('region')->config('fedapay_description', 'Recharge'),
                'amount' => (int)$transaction->amount,
                'currency' => [
                    'iso' => 'XOF'
                ],
                'callback_url' => route('recharge.webhook.fedapay'),
                'cancel_url' => route('recharge.return.fedapay', ['status' => 'canceled', 'close' => 'true', 'local_tx' => $transaction->transaction_id]),
                'return_url' => route('recharge.return.fedapay', ['status' => 'approved', 'local_tx' => $transaction->transaction_id]),
                'custom_metadata' => [
                    'transaction_id' => $transaction->transaction_id,
                    'user_id' => $transaction->user_id
                ]
            ]);
            
            // Générer le token de paiement
            $token = $fedapayTransaction->generateToken();
            
            $transaction->update([
                'external_transaction_id' => $fedapayTransaction->id,
                'payment_provider' => 'fedapay',
                'response_data' => [
                    'fedapay_id' => $fedapayTransaction->id,
                    'token' => $token->token ?? null
                ]
            ]);

            return response()->json([
                'success' => true,
                'payment_url' => $token->url,
                'transaction_id' => $transaction->transaction_id
            ]);

        } catch (\Exception $e) {
            Log::error('FedaPay Error', [
                'transaction_id' => $transaction->transaction_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'config_check' => [
                    'secret_key_exists' => config('services.fedapay.secret_key') ? 'yes' : 'no',
                    'secret_key_length' => strlen(config('services.fedapay.secret_key') ?? '')
                ]
            ]);
            
            // En cas d'erreur FedaPay, retourner l'erreur
            $transaction->update([
                'status' => 'failed',
                'failure_reason' => $e->getMessage()
            ]);
            
            return response()->json(['error' => 'Erreur lors de l\'initialisation du paiement FedaPay. Veuillez réessayer.'], 500);
        }
    }

    private function processOosicPayment($transaction)
    {
        // Vérifier que les clés OOSIC sont configurées
        if (!config('services.oosic.api_key')) {
            return response()->json(['error' => 'OOSIC non configuré. Utilisez FedaPay pour le moment.'], 500);
        }
        
        try {
            $client = new Client();
            
            $response = $client->post('https://api.oosic.net/v1/payments', [
                'headers' => [
                    'Authorization' => 'Bearer ' . config('services.oosic.api_key'),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'amount' => $transaction->amount,
                    'currency' => 'XOF',
                    'description' => app('region')->config('fedapay_description', 'Recharge'),
                    'return_url' => route('recharge.success'),
                    'cancel_url' => route('recharge.cancel'),
                    'webhook_url' => route('recharge.webhook.oosic'),
                    'reference' => $transaction->transaction_id
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            
            $transaction->update([
                'external_transaction_id' => $data['payment_id'],
                'payment_provider' => 'oosic',
                'response_data' => $data
            ]);

            return response()->json([
                'success' => true,
                'payment_url' => $data['payment_url']
            ]);

        } catch (\Exception $e) {
            $transaction->update([
                'status' => 'failed',
                'failure_reason' => $e->getMessage()
            ]);
            
            return response()->json(['error' => 'Erreur lors de l\'initialisation du paiement OOSIC'], 500);
        }
    }

    private function processCardPayment($transaction)
    {
        // Rediriger vers FedaPay qui gère les cartes bancaires
        return $this->processFedapayPayment($transaction);
    }

    private function processMobileMoneyPayment($transaction)
    {
        // Rediriger vers FedaPay qui gère le mobile money
        return $this->processFedapayPayment($transaction);
    }



    // Webhooks pour les notifications de paiement
    public function fedapayWebhook(Request $request)
    {
        try {
            $data = $request->all();
            $method = $request->method();
            
            Log::info('FedaPay Webhook received', [
                'method' => $method,
                'data' => $data
            ]);
            
            // Gérer les redirections GET (retour utilisateur)
            if ($method === 'GET') {
                return $this->handleFedapayRedirect($request);
            }
            
            // Gérer les notifications POST (webhooks)
            return $this->handleFedapayNotification($request);
            
        } catch (\Exception $e) {
            Log::error('FedaPay Webhook Error', [
                'error' => $e->getMessage(),
                'data' => $request->all(),
                'method' => $request->method()
            ]);
            
            return response('Error', 500);
        }
    }

    /**
     * Endpoint dédié pour les retours utilisateur (GET) après paiement via FedaPay.
     * Délègue vers la logique existante de redirection.
     */
    public function fedapayReturn(Request $request)
    {
        try {
            return $this->handleFedapayRedirect($request);
        } catch (\Exception $e) {
            Log::error('FedaPay Return Error', ['error' => $e->getMessage()]);
            return response('Error', 500);
        }
    }

    private function handleFedapayRedirect(Request $request)
    {
        $status = $request->get('status');
        $transactionId = $request->get('id');
        $localTx = $request->get('local_tx');
        $close = $request->get('close');

        Log::info('FedaPay Redirect', [
            'status' => $status,
            'transaction_id' => $transactionId,
            'local_tx' => $localTx,
            'close' => $close
        ]);

        // Tenter de retrouver la transaction locale
        // Priorité 1 : paramètre local_tx (notre propre ID, fiable)
        // Priorité 2 : paramètre id (ID FedaPay, peut être absent)
        try {
            $tx = null;
            if ($localTx) {
                $tx = RechargeTransaction::where('transaction_id', $localTx)->first();
            }
            if (! $tx && $transactionId) {
                $tx = RechargeTransaction::where('external_transaction_id', $transactionId)->first();
                if (! $tx) {
                    $tx = RechargeTransaction::where('transaction_id', $transactionId)->first();
                }
            }

            if ($status === 'approved' || $status === 'completed') {
                if ($tx && $tx->status !== 'completed') {
                    $this->completeTransaction($tx);
                    Log::info('Transaction marked completed from redirect', ['transaction_id' => $tx->transaction_id]);
                }
                return redirect()->route('recharge.success')->with('success', 'Paiement effectué avec succès !');
            } elseif ($status === 'canceled' || $status === 'declined' || $close === 'true') {
                if ($tx && $tx->status !== 'failed') {
                    $tx->update([
                        'status' => 'failed',
                        'failure_reason' => 'Payment canceled/declined by user (redirect)'
                    ]);
                    Log::info('Transaction marked failed from redirect', ['transaction_id' => $tx->transaction_id]);
                }
                return redirect()->route('recharge.cancel')->with('error', 'Paiement annulé ou refusé.');
            } else {
                // Statut pending ou inconnu, rediriger vers recharge
                return redirect()->route('recharge.index')->with('info', 'Paiement en cours de traitement...');
            }
        } catch (\Exception $e) {
            Log::warning('Error while handling FedaPay redirect', ['error' => $e->getMessage()]);
            // Même en cas d'erreur, rediriger proprement
            if ($status === 'approved') {
                return redirect()->route('recharge.success')->with('success', 'Paiement effectué avec succès !');
            }
            if ($status === 'canceled' || $status === 'declined' || $close === 'true') {
                return redirect()->route('recharge.cancel')->with('error', 'Paiement annulé ou refusé.');
            }
            return redirect()->route('recharge.index')->with('info', 'Paiement en cours de traitement...');
        }
    }

    private function handleFedapayNotification(Request $request)
    {
        // Loguer le payload brut pour diagnostiquer les formats inattendus
        $raw = null;
        try {
            $raw = file_get_contents('php://input');
            Log::info('FedaPay raw notification payload', ['raw' => $raw]);
        } catch (\Exception $e) {
            Log::warning('Could not read raw FedaPay payload', ['error' => $e->getMessage()]);
        }

        // Entrée simple et normalisée pour repérer rapidement les webhooks
        Log::info('FEDA_WEBHOOK_RECEIVED', ['method' => $request->method(), 'ip' => $request->ip()]);

        // Loguer les headers reçus (utile pour debug de signature)
        try {
            $headers = [];
            foreach (getallheaders() as $k => $v) {
                $headers[$k] = $v;
            }
            Log::info('FedaPay webhook headers', ['headers' => $headers]);
        } catch (\Exception $e) {
            Log::warning('Could not read request headers', ['error' => $e->getMessage()]);
        }

        // Vérification HMAC (si configurée) - supporte plusieurs noms de header usuels
        // Essayer les secrets des deux régions (europe + afrique)
        $webhookSecrets = array_filter([
            config('regions.europe.fedapay_webhook_secret'),
            config('regions.afrique.fedapay_webhook_secret'),
            config('services.fedapay.webhook_secret'), // fallback legacy
        ]);
        $webhookSecret = !empty($webhookSecrets) ? true : false;
        if ($webhookSecret) {
            // Récupérer et normaliser la signature (supporte plusieurs formats :
            // "sha256=<hex>", plain hex, ou Faraday style "t=...,s=<hex>")
            $signatureHeader = $request->header('X-Fedapay-Signature') ?? $request->header('X-Signature') ?? $request->header('Signature') ?? $request->header('X-Hub-Signature');
            $signatureHeader = null;
            foreach (['X-Fedapay-Signature', 'x-fedapay-signature', 'X-Fedapay-Signature'] as $h) {
                if (!empty($headers[$h])) {
                    $signatureHeader = $headers[$h];
                    break;
                }
            }

            $receivedSignatureRaw = $signatureHeader;
            if (is_array($receivedSignatureRaw)) {
                $receivedSignatureRaw = $receivedSignatureRaw[0];
            }

            // Extraire le cas Faraday 't=...,s=<hex>' si présent
            $receivedSignature = $receivedSignatureRaw;
            if (is_string($receivedSignature) && preg_match('/\bs=([0-9a-fA-F]+)\b/', $receivedSignature, $m)) {
                $receivedSignature = $m[1];
            }

            // Normalise: certains envoient 'sha256=<hex>'
            if (is_string($receivedSignature) && strpos($receivedSignature, 'sha256=') === 0) {
                $receivedSignature = substr($receivedSignature, strlen('sha256='));
            }

            // Lowercase pour éviter les différences de casse
            if (is_string($receivedSignature)) {
                $receivedSignature = strtolower($receivedSignature);
            }

            // Préparer le payload utilisé pour la vérification
            $payloadToVerify = $raw ?: json_encode($request->all());

            // Essayer chaque secret de région jusqu'à trouver une correspondance
            $signatureValid = false;
            foreach ($webhookSecrets as $secret) {
                $expected = strtolower(hash_hmac('sha256', $payloadToVerify, $secret));
                if (is_string($receivedSignature) && hash_equals($expected, strtolower($receivedSignature))) {
                    $signatureValid = true;
                    break;
                }
            }

            if (!$signatureValid) {
                Log::warning('FedaPay webhook signature mismatch for all region secrets', [
                    'received_normalized' => $receivedSignature,
                    'received_raw' => $receivedSignatureRaw,
                    'payload_sample' => substr($payloadToVerify, 0, 1000),
                ]);

                return response('Signature mismatch', 400);
            }

            Log::info('FedaPay webhook signature verified');
        } else {
            Log::info('No FedaPay webhook secret configured, skipping signature verification');
        }

        $data = $request->all();
        $transactionId = null;

        // Chercher l'ID de transaction dans plusieurs emplacements possibles
        $candidates = [
            // structure attendue
            ['entity', 'custom_metadata', 'transaction_id'],
            ['data', 'object', 'custom_metadata', 'transaction_id'],
            // autres variantes observées chez certains fournisseurs
            ['data', 'object', 'metadata', 'transaction_id'],
            ['entity', 'object', 'metadata', 'transaction_id'],
            // top-level
            ['transaction_id'],
            ['data', 'transaction_id'],
            ['data', 'object', 'id']
        ];

        foreach ($candidates as $path) {
            $tmp = $data;
            foreach ($path as $key) {
                if (is_array($tmp) && array_key_exists($key, $tmp)) {
                    $tmp = $tmp[$key];
                } else {
                    $tmp = null;
                    break;
                }
            }
            if (!empty($tmp)) {
                $transactionId = $tmp;
                break;
            }
        }

        if (!$transactionId) {
            Log::warning('No transaction ID found in FedaPay notification', ['data_sample' => array_slice($data, 0, 10)]);
            return response('No transaction ID', 400);
        }
        
        $transaction = RechargeTransaction::where('transaction_id', $transactionId)->first();
        
        if (!$transaction) {
            // Lorsque la transaction introuvable, logger l'évènement mais
            // renvoyer HTTP 200 à FedaPay pour éviter des tentatives de
            // redelivery répétées côté provider. Les cas réels restent
            // investigables via les logs.
            Log::warning('Transaction not found - returning 200 to avoid redelivery', ['transaction_id' => $transactionId]);
            return response('OK', 200);
        }
        
        // Vérifier le statut du paiement
        $status = $data['name'] ?? '';
        
        if ($status === 'transaction.approved' || $status === 'transaction.completed') {
            $this->completeTransaction($transaction);
            Log::info('Transaction completed via FedaPay notification', ['transaction_id' => $transactionId]);
        } elseif ($status === 'transaction.declined' || $status === 'transaction.canceled') {
            $transaction->update([
                'status' => 'failed',
                'failure_reason' => 'Payment declined or canceled by FedaPay'
            ]);
            Log::info('Transaction failed via FedaPay notification', ['transaction_id' => $transactionId]);
        }
        
        return response('OK', 200);
    }

    public function oosicWebhook(Request $request)
    {
        $data = $request->all();
        
        $transaction = RechargeTransaction::where('transaction_id', $data['reference'])->first();
        
        if ($transaction && $data['status'] === 'completed') {
            $this->completeTransaction($transaction);
        }
        
        return response('OK', 200);
    }

    private function completeTransaction($transaction)
    {
        // Effectuer la mise à jour atomique du statut + crédits en base.
        // Appel des commissions effectué APRÈS commit pour éviter que
        // des erreurs secondaires annulent l'ajout des crédits.
        try {
            DB::beginTransaction();

            // Mettre à jour le statut de la transaction
            $transaction->update([
                'status' => 'completed',
                'completed_at' => now()
            ]);

            // Récupérer l'utilisateur lié
            $user = $transaction->user;
            if (! $user) {
                Log::error('completeTransaction: user not found for transaction', ['transaction_id' => $transaction->transaction_id]);
                DB::rollBack();
                return;
            }

            $credits_avant = $user->credit_user ?? 0;
            $credits_to_add = (int) ($transaction->credits_earned ?? 0);

            // Incrementer directement en base pour éviter les problèmes de modèle
            DB::table('users')->where('id', $user->id)->increment('credit_user', $credits_to_add);

            // Recharger le modèle user pour avoir la valeur à jour
            $user->refresh();
            $credits_apres = $user->credit_user ?? ($credits_avant + $credits_to_add);

            // Enregistrer dans l'historique des transactions si la relation existe
            try {
                $compte = $transaction->compte;
                if ($compte && method_exists($compte, 'historiques')) {
                    $compte->historiques()->create([
                        'type' => 'credit_recharge',
                        'montant' => $transaction->credits_earned,
                        'solde_avant' => $credits_avant,
                        'solde_apres' => $credits_apres,
                        'description' => "Recharge de crédits : {$transaction->amount} F CFA → {$transaction->credits_earned} crédits FlashBilan"
                    ]);
                }
            } catch (\Exception $e) {
                Log::warning('Historique transaction failed', [
                    'transaction_id' => $transaction->transaction_id,
                    'error' => $e->getMessage()
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('completeTransaction failed', [
                'transaction_id' => $transaction->transaction_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return;
        }

        // === Bonus fidélité : 5000 crédits à la 4e recharge réussie en 30 jours ===
        try {
            $since30 = now()->subDays(30);
            $userId = $transaction->user_id;

            $rechargesLast30 = RechargeTransaction::where('user_id', $userId)
                ->where('status', 'completed')
                ->where('created_at', '>=', $since30)
                ->count();

            $compteIds = \App\Models\Compte::where('user_id', $userId)->pluck('id');
            $bonusAlreadyGiven = $compteIds->isNotEmpty()
                ? \App\Models\TransactionHistory::whereIn('compte_id', $compteIds)
                    ->where('transaction_type', 'Loyalty bonus')
                    ->where('created_at', '>=', $since30)
                    ->exists()
                : false;

            if ($rechargesLast30 >= 4 && !$bonusAlreadyGiven) {
                $bonusCredits = 5000;
                DB::table('users')->where('id', $userId)->increment('credit_user', $bonusCredits);

                // Enregistrer le bonus dans l'historique
                $firstCompte = $compteIds->first();
                if ($firstCompte) {
                    \App\Models\TransactionHistory::create([
                        'user_id' => $userId,
                        'compte_id' => $firstCompte,
                        'transaction_type' => 'Loyalty bonus',
                        'devise' => 'crédits',
                        'amount' => $bonusCredits,
                        'description' => 'Bonus fidélité – 4 recharges en 30 jours',
                    ]);
                }

                // Envoyer un email de notification du bonus
                try {
                    $bonusUser = \App\Models\User::find($userId);
                    if ($bonusUser && $bonusUser->email) {
                        \Illuminate\Support\Facades\Mail::to($bonusUser->email)
                            ->send(new \App\Mail\LoyaltyBonusMail($bonusUser, $bonusCredits));
                    }
                } catch (\Exception $mailEx) {
                    Log::warning('Loyalty bonus email failed', ['error' => $mailEx->getMessage()]);
                }

                Log::info('BONUS FIDÉLITÉ ACCORDÉ', [
                    'user_id' => $userId,
                    'bonus' => $bonusCredits,
                    'recharges_30j' => $rechargesLast30,
                ]);
            }
        } catch (\Exception $e) {
            Log::warning('Loyalty bonus check failed', ['error' => $e->getMessage()]);
        }

        // Appeler le traitement des commissions hors transaction pour
        // éviter que des erreurs dans cette étape annulent l'ajout des crédits.
        try {
            \Log::info('AVANT APPEL processAffiliationCommissions', [
                'transaction_id' => $transaction->transaction_id
            ]);

            $this->processAffiliationCommissions($transaction);

            \Log::info('APRÈS APPEL processAffiliationCommissions');
        } catch (\Exception $e) {
            Log::error('processAffiliationCommissions post-commit failed', [
                'transaction_id' => $transaction->transaction_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Traiter les commissions d'affiliation pour une transaction de recharge
     */
    private function processAffiliationCommissions($transaction)
    {
        \Log::info('=== DÉBUT PROCESSAFFILIATIONCOMMISSIONS ===', [
            'transaction_id' => $transaction->transaction_id
        ]);
        
        try {
            $user = $transaction->user;
            
            Log::info('Starting commission processing', [
                'transaction_id' => $transaction->transaction_id,
                'user_id' => $user->id,
                'user_parrain_id' => $user->parrain_id
            ]);
            
            // Vérifier si l'utilisateur a un parrain
            if (!$user->parrain_id) {
                Log::info('No parrain found for user', ['user_id' => $user->id]);
                return;
            }

            // Récupérer l'affiliation du parrain
            $parrainAffiliation = \App\Models\Affiliation::where('user_id', $user->parrain_id)
                                                        ->where('is_active', true)
                                                        ->first();

            Log::info('Parrain affiliation lookup', [
                'parrain_id' => $user->parrain_id,
                'affiliation_found' => !empty($parrainAffiliation),
                'affiliation_id' => $parrainAffiliation->id ?? null
            ]);

            if (!$parrainAffiliation) {
                Log::error('Parrain affiliation not found or inactive', [
                    'user_id' => $user->id,
                    'parrain_id' => $user->parrain_id,
                    'all_affiliations' => \App\Models\Affiliation::where('user_id', $user->parrain_id)->get(['id', 'user_id', 'is_active'])->toArray()
                ]);
                return;
            }

            // Calculer la commission (5% par défaut) et normaliser
            $tauxCommission = $parrainAffiliation->commission_rate ?? 5;
            $montantBase = $transaction->amount; // Montant de la recharge en F CFA
            $montantCommission = round((($montantBase * $tauxCommission) / 100), 2);

            // Idempotence : éviter la création en double si déjà créée pour cette transaction
            $exists = \App\Models\Commission::where('details->transaction_id', $transaction->transaction_id)->exists();
            if ($exists) {
                Log::info('Commission already exists for transaction, skipping', ['transaction_id' => $transaction->transaction_id]);
                return;
            }

            // Créer la commission et appliquer les increments dans une transaction DB
            try {
                DB::transaction(function() use ($parrainAffiliation, $user, $transaction, $montantBase, $tauxCommission, $montantCommission, &$commission, &$parrainUser, &$parrainCompte) {
                    $commission = \App\Models\Commission::create([
                        'affiliation_id' => $parrainAffiliation->id,
                        'parraine_user_id' => $user->id,
                        'compte_id' => $transaction->compte_id,
                        'action_type' => 'recharge',
                        'montant_base' => $montantBase,
                        'taux_commission' => $tauxCommission,
                        'montant_commission' => $montantCommission,
                        'statut' => 'valide', // Auto-validée pour les recharges
                        'date_action' => now(),
                        'date_validation' => now(),
                        'details' => [
                            'transaction_id' => $transaction->transaction_id,
                            'payment_method' => $transaction->payment_method,
                            'credits_earned' => $transaction->credits_earned,
                            'auto_processed' => true
                        ]
                    ]);

                    // Mettre à jour les totaux de l'affiliation
                    $parrainAffiliation->increment('total_commissions', $montantCommission);

                    // Créditer le compte du parrain avec la commission si possible
                    $parrainUser = \App\Models\User::find($user->parrain_id);
                    if ($parrainUser) {
                        $parrainCompte = \App\Models\Compte::where('user_id', $parrainUser->id)->first();
                        if ($parrainCompte) {
                            $parrainCompte->increment('account_balance', $montantCommission);
                            // Ajouter à l'historique du parrain
                            if (method_exists($parrainCompte, 'historiques')) {
                                $parrainCompte->historiques()->create([
                                    'type' => 'commission',
                                    'montant' => $montantCommission,
                                    'solde_avant' => $parrainCompte->account_balance - $montantCommission,
                                    'solde_apres' => $parrainCompte->account_balance,
                                    'description' => "Commission d'affiliation - Recharge de {$user->nom} {$user->prenom} ({$montantBase} F CFA)"
                                ]);
                            }
                        }
                    }
                });
            } catch (\Exception $e) {
                Log::error('Failed to create/process commission transactionally', [
                    'transaction_id' => $transaction->transaction_id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return;
            }

            Log::info('Affiliation commission processed', [
                'commission_id' => $commission->id ?? null,
                'parrain_id' => $user->parrain_id,
                'filleul_id' => $user->id,
                'montant_base' => $montantBase,
                'montant_commission' => $montantCommission,
                'taux' => $tauxCommission
            ]);

            // Optionnel : Envoyer une notification au parrain si utilisateur trouvé
            if (!empty($parrainUser) && $parrainUser instanceof \App\Models\User) {
                $this->notifyParrainCommission($parrainUser, $commission);
            } else {
                Log::warning('Parrain user not found, skipping notification', ['parrain_id' => $user->parrain_id, 'transaction_id' => $transaction->transaction_id]);
            }

        } catch (\Exception $e) {
            Log::error('Affiliation commission processing failed', [
                'transaction_id' => $transaction->transaction_id,
                'user_id' => $transaction->user_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Notifier le parrain de sa nouvelle commission (optionnel)
     */
    private function notifyParrainCommission($parrainUser, $commission)
    {
        try {
            // Ici vous pouvez ajouter l'envoi d'email, SMS, ou notification push
            Log::info('Parrain commission notification', [
                'parrain_id' => $parrainUser->id,
                'parrain_email' => $parrainUser->email,
                'commission_amount' => $commission->montant_commission
            ]);
            
            // Exemple de notification par email (à décommenter si vous voulez l'activer)
            /*
            Mail::to($parrainUser->email)->send(new CommissionEarnedMail($commission));
            */
            
        } catch (\Exception $e) {
            Log::warning('Parrain notification failed', ['error' => $e->getMessage()]);
        }
    }

    public function success()
    {
        return view('recharge.success')->with('success', 'Paiement effectué avec succès! Vos crédits ont été ajoutés à votre compte.');
    }

    /**
     * Retourne le statut d'une transaction de recharge par transaction_id.
     * Accessible uniquement au propriétaire de la transaction.
     */
    public function status(Request $request, $transactionId)
    {
        $transaction = RechargeTransaction::where('transaction_id', $transactionId)->first();

        if (! $transaction) {
            return response()->json(['success' => false, 'message' => 'Transaction introuvable'], 404);
        }

        // Vérifier que l'utilisateur connecté est bien le propriétaire
        $user = Auth::user();
        if (! $user || $user->id !== $transaction->user_id) {
            return response()->json(['success' => false, 'message' => 'Accès refusé'], 403);
        }

        return response()->json([
            'success' => true,
            'transaction_id' => $transaction->transaction_id,
            'status' => $transaction->status,
            'amount' => $transaction->amount,
            'credits_earned' => $transaction->credits_earned,
            'payment_provider' => $transaction->payment_provider,
            'external_transaction_id' => $transaction->external_transaction_id,
            'created_at' => $transaction->created_at,
            'completed_at' => $transaction->completed_at,
        ]);
    }

    /**
     * Supprimer l'historique des recharges de l'utilisateur connecté.
     */
    public function clearHistory()
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('connexion');
        }

        try {
            $deletedCount = RechargeTransaction::where('user_id', $user->id)->delete();

            $message = $deletedCount > 0
                ? "Historique des recharges supprimé ({$deletedCount} entrée(s))."
                : "Aucune recharge à supprimer.";

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Erreur suppression historique recharge', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 'Impossible de supprimer l\'historique pour le moment.');
        }
    }

    public function cancel()
    {
        return view('recharge.cancel')->with('error', 'Paiement annulé ou refusé. Vous pouvez réessayer à tout moment.');
    }



    /**
     * Page d'administration pour tester les paiements
     */
    public function adminPaymentsTest()
    {
        $recent_transactions = RechargeTransaction::with(['user', 'compte'])
                                                ->orderBy('created_at', 'desc')
                                                ->limit(10)
                                                ->get();
                                                
        return view('admin.payments-test', compact('recent_transactions'));
    }

    /**
     * Vérifier le statut d'une transaction
     */
    public function checkTransactionStatus($transactionId)
    {
        $transaction = RechargeTransaction::with(['user', 'compte'])
                                        ->where('transaction_id', $transactionId)
                                        ->first();
        
        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }
        
        return response()->json([
            'transaction' => $transaction,
            'current_balance' => $transaction->compte ? $transaction->compte->account_balance : 0
        ]);
    }

    /**
     * Méthode SÉCURISÉE pour compléter manuellement les transactions pending
     * Vérifie le statut FedaPay avant de compléter
     */
    public function completePendingTransactions()
    {
        $pendingTransactions = RechargeTransaction::where('status', 'pending')
            ->where('payment_method', 'fedapay')
            ->whereNotNull('external_transaction_id')
            ->orderBy('created_at', 'desc')
            ->get();

        $completed = [];
        $errors = [];
        $skipped = [];

        foreach ($pendingTransactions as $transaction) {
            try {
                // Vérifier le statut réel sur FedaPay
                $fedapayStatus = $this->checkFedapayTransactionStatus($transaction->external_transaction_id);
                
                if ($fedapayStatus === 'approved' || $fedapayStatus === 'completed') {
                    // Transaction vraiment payée - la compléter
                    $this->completeTransaction($transaction);
                    $completed[] = [
                        'transaction_id' => $transaction->transaction_id,
                        'amount' => $transaction->amount,
                        'credits' => $transaction->credits_earned,
                        'user_id' => $transaction->user_id,
                        'fedapay_status' => $fedapayStatus
                    ];
                } elseif ($fedapayStatus === 'canceled' || $fedapayStatus === 'declined' || $fedapayStatus === 'failed') {
                    // Transaction annulée/refusée - la marquer comme échouée
                    $transaction->update([
                        'status' => 'failed',
                        'failure_reason' => "FedaPay status: {$fedapayStatus}"
                    ]);
                    $skipped[] = [
                        'transaction_id' => $transaction->transaction_id,
                        'reason' => "Transaction {$fedapayStatus} sur FedaPay",
                        'fedapay_status' => $fedapayStatus
                    ];
                } else {
                    // Statut inconnu ou en attente
                    $skipped[] = [
                        'transaction_id' => $transaction->transaction_id,
                        'reason' => "Statut FedaPay inconnu ou en attente: {$fedapayStatus}",
                        'fedapay_status' => $fedapayStatus
                    ];
                }
                
            } catch (\Exception $e) {
                $errors[] = [
                    'transaction_id' => $transaction->transaction_id,
                    'error' => $e->getMessage()
                ];
            }
        }

        return response()->json([
            'message' => 'Traitement sécurisé terminé',
            'completed_count' => count($completed),
            'error_count' => count($errors),
            'skipped_count' => count($skipped),
            'completed' => $completed,
            'errors' => $errors,
            'skipped' => $skipped
        ]);
    }

    /**
     * Vérifier le statut d'une transaction sur FedaPay
     */
    private function checkFedapayTransactionStatus($fedapayTransactionId)
    {
        try {
            // Configuration FedaPay
            \FedaPay\FedaPay::setApiKey(config('services.fedapay.secret_key'));
            \FedaPay\FedaPay::setEnvironment('live');
            
            // Récupérer la transaction FedaPay
            $fedapayTransaction = \FedaPay\Transaction::retrieve($fedapayTransactionId);
            
            return $fedapayTransaction->status ?? 'unknown';
            
        } catch (\Exception $e) {
            Log::error('Erreur vérification statut FedaPay', [
                'fedapay_id' => $fedapayTransactionId,
                'error' => $e->getMessage()
            ]);
            return 'error';
        }
    }

    /**
     * Corriger les transactions incorrectement validées
     */
    public function fixIncorrectTransactions()
    {
        // IDs des transactions réellement payées (selon FedaPay)
        $reallyPaidTransactions = [
            'RCRZO1WSNX1762171910', // 100 F CFA - 13:11:51
            'RCWDO1HL0L1762171544'  // 100 F CFA - 13:05:45
        ];

        // IDs des transactions non payées (en attente sur FedaPay)
        $unpaidTransactions = [
            'RC6U9KHWE51762171299',  // 5000 F CFA
            'RC6MXF2YCM1762170923',  // 5000 F CFA  
            'RCRIJM5HZB1762170647',  // 5000 F CFA
            'RCEF9UYVSL1762170408'   // 5000 F CFA
        ];

        $user = \App\Models\User::find(13); // User ID from the completed transactions
        $creditsBefore = $user->credit_user ?? 0;
        
        $totalCreditsToRemove = 0;
        $totalCommissionsToRemove = 0;
        $corrected = [];
        $errors = [];

        try {
            DB::beginTransaction();
            
            // 1. Corriger les transactions non payées
            foreach ($unpaidTransactions as $transactionId) {
                $transaction = RechargeTransaction::where('transaction_id', $transactionId)->first();
                
                if ($transaction && $transaction->status === 'completed') {
                    // Remettre en pending
                    $transaction->update([
                        'status' => 'pending',
                        'completed_at' => null
                    ]);
                    
                    $totalCreditsToRemove += $transaction->credits_earned;
                    
                    // Supprimer les commissions associées
                    $commissions = \App\Models\Commission::where('details->transaction_id', $transactionId)->get();
                    foreach ($commissions as $commission) {
                        $totalCommissionsToRemove += $commission->montant_commission;
                        
                        // Retirer la commission du parrain
                        if ($commission->affiliation && $commission->affiliation->user) {
                            $parrainUser = $commission->affiliation->user;
                            $parrainCompte = \App\Models\Compte::where('user_id', $parrainUser->id)->first();
                            if ($parrainCompte) {
                                $parrainCompte->decrement('account_balance', $commission->montant_commission);
                            }
                        }
                        
                        // Supprimer la commission
                        $commission->delete();
                    }
                    
                    $corrected[] = [
                        'transaction_id' => $transactionId,
                        'amount' => $transaction->amount,
                        'credits_removed' => $transaction->credits_earned
                    ];
                }
            }
            
            // 2. Corriger les crédits utilisateur
            $user->credit_user = $creditsBefore - $totalCreditsToRemove;
            $user->save();
            
            DB::commit();
            
            return response()->json([
                'message' => 'Correction terminée',
                'credits_before' => $creditsBefore,
                'credits_removed' => $totalCreditsToRemove,
                'credits_after' => $user->credit_user,
                'commissions_removed' => $totalCommissionsToRemove,
                'corrected_transactions' => $corrected,
                'really_paid_count' => count($reallyPaidTransactions),
                'unpaid_corrected_count' => count($corrected)
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => 'Erreur lors de la correction: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer la transaction frauduleuse obtenue sans paiement
     */
    public function removeFraudulentTransaction()
    {
        $fraudulentTransactionId = 'RCAPWX1SKU1762173292'; // Transaction annulée mais créditée
        
        try {
            DB::beginTransaction();
            
            $transaction = RechargeTransaction::where('transaction_id', $fraudulentTransactionId)->first();
            $user = \App\Models\User::find(13);
            
            if (!$transaction || !$user) {
                return response()->json(['error' => 'Transaction ou utilisateur non trouvé'], 404);
            }
            
            $creditsBefore = $user->credit_user;
            
            // Retirer les crédits frauduleux
            $user->credit_user = $creditsBefore - $transaction->credits_earned;
            $user->save();
            
            // Supprimer les commissions associées si elles existent
            $commissions = \App\Models\Commission::where('details->transaction_id', $fraudulentTransactionId)->get();
            $commissionsRemoved = 0;
            
            foreach ($commissions as $commission) {
                // Retirer la commission du parrain
                if ($commission->affiliation && $commission->affiliation->user) {
                    $parrainUser = $commission->affiliation->user;
                    $parrainCompte = \App\Models\Compte::where('user_id', $parrainUser->id)->first();
                    if ($parrainCompte) {
                        $parrainCompte->decrement('account_balance', $commission->montant_commission);
                    }
                }
                $commissionsRemoved += $commission->montant_commission;
                $commission->delete();
            }
            
            // Supprimer ou marquer la transaction comme frauduleuse
            $transaction->update([
                'status' => 'failed',
                'failure_reason' => 'Transaction annulée par l\'utilisateur - pas de paiement réel'
            ]);
            
            DB::commit();
            
            return response()->json([
                'message' => 'Transaction frauduleuse supprimée',
                'transaction_id' => $fraudulentTransactionId,
                'credits_before' => $creditsBefore,
                'credits_removed' => $transaction->credits_earned,
                'credits_after' => $user->credit_user,
                'commissions_removed' => $commissionsRemoved
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Diagnostiquer les problèmes d'affiliation
     */
    public function debugAffiliation()
    {
        $user = \App\Models\User::find(13);
        
        if (!$user) {
            return response()->json(['error' => 'Utilisateur non trouvé'], 404);
        }

        $debug = [
            'user_info' => [
                'id' => $user->id,
                'email' => $user->email,
                'parrain_id' => $user->parrain_id,
                'has_parrain' => !empty($user->parrain_id)
            ]
        ];

        // Vérifier le parrain si il existe
        if ($user->parrain_id) {
            $parrain = \App\Models\User::find($user->parrain_id);
            $debug['parrain_info'] = [
                'exists' => !empty($parrain),
                'id' => $parrain->id ?? null,
                'email' => $parrain->email ?? null
            ];

            if ($parrain) {
                // Vérifier l'affiliation du parrain
                $affiliation = \App\Models\Affiliation::where('user_id', $user->parrain_id)
                    ->where('is_active', true)
                    ->first();

                $debug['affiliation_info'] = [
                    'exists' => !empty($affiliation),
                    'is_active' => $affiliation->is_active ?? false,
                    'commission_rate' => $affiliation->commission_rate ?? null,
                    'total_commissions' => $affiliation->total_commissions ?? 0
                ];
            }
        } else {
            $debug['parrain_info'] = ['message' => 'Aucun parrain configuré'];
        }

        // Vérifier les commissions existantes
        $commissions = \App\Models\Commission::where('parraine_user_id', $user->id)->get();
        $debug['commissions'] = [
            'count' => $commissions->count(),
            'list' => $commissions->map(function($c) {
                return [
                    'id' => $c->id,
                    'montant_base' => $c->montant_base,
                    'montant_commission' => $c->montant_commission,
                    'statut' => $c->statut,
                    'created_at' => $c->created_at
                ];
            })
        ];

        return response()->json($debug);
    }

    /**
     * Vérifier les affiliés et leurs recharges
     */
    public function checkAffiliates()
    {
        $user = \App\Models\User::find(13); // Votre ID
        
        if (!$user) {
            return response()->json(['error' => 'Utilisateur ID 13 non trouvé'], 404);
        }
        
        // Trouver tous vos affiliés (utilisateurs dont vous êtes le parrain)
        $affilies = \App\Models\User::where('parrain_id', $user->id)->get();
        
        $result = [
            'parrain_info' => [
                'id' => $user->id,
                'email' => $user->email,
                'total_affilies' => $affilies->count()
            ],
            'affilies' => []
        ];
        
        foreach ($affilies as $affilie) {
            // Récupérer les recharges de chaque affilié
            $recharges = \App\Models\RechargeTransaction::where('user_id', $affilie->id)
                ->where('status', 'completed')
                ->get();
                
            $totalRecharge = $recharges->sum('amount');
            $totalCommissionsPossibles = $totalRecharge * 0.05; // 5%
            
            // Vérifier les commissions réellement créées
            $commissionsCreees = \App\Models\Commission::where('parraine_user_id', $affilie->id)->get();
            $totalCommissionsCreees = $commissionsCreees->sum('montant_commission');
            
            $result['affilies'][] = [
                'affilie_info' => [
                    'id' => $affilie->id,
                    'email' => $affilie->email,
                    'created_at' => $affilie->created_at
                ],
                'recharges' => [
                    'count' => $recharges->count(),
                    'total_amount' => $totalRecharge,
                    'recharges_list' => $recharges->map(function($r) {
                        return [
                            'id' => $r->transaction_id,
                            'amount' => $r->amount,
                            'status' => $r->status,
                            'created_at' => $r->created_at
                        ];
                    })
                ],
                'commissions' => [
                    'attendues' => $totalCommissionsPossibles,
                    'creees' => $totalCommissionsCreees,
                    'manquantes' => $totalCommissionsPossibles - $totalCommissionsCreees,
                    'commissions_list' => $commissionsCreees->map(function($c) {
                        return [
                            'montant' => $c->montant_commission,
                            'statut' => $c->statut,
                            'created_at' => $c->created_at
                        ];
                    })
                ]
            ];
        }
        
        return response()->json($result);
    }

    /**
     * Débugger un lien de parrainage spécifique
     */
    public function debugParrainage($userId)
    {
        $user = \App\Models\User::find($userId);
        
        if (!$user) {
            return response()->json(['error' => 'Utilisateur non trouvé'], 404);
        }

        $result = [
            'user_info' => [
                'id' => $user->id,
                'email' => $user->email,
                'parrain_id' => $user->parrain_id,
                'created_at' => $user->created_at
            ]
        ];

        // Info du parrain si il existe
        if ($user->parrain_id) {
            $parrain = \App\Models\User::find($user->parrain_id);
            $parrainAffiliation = \App\Models\Affiliation::where('user_id', $user->parrain_id)->first();
            
            $result['parrain_info'] = [
                'id' => $parrain->id ?? null,
                'email' => $parrain->email ?? null,
                'affiliation_active' => $parrainAffiliation ? $parrainAffiliation->is_active : false,
                'commission_rate' => $parrainAffiliation ? $parrainAffiliation->commission_rate : null
            ];
        }

        // Recharges de cet utilisateur
        $recharges = \App\Models\RechargeTransaction::where('user_id', $userId)
            ->where('status', 'completed')
            ->get();
            
        $result['recharges'] = $recharges->map(function($r) {
            return [
                'transaction_id' => $r->transaction_id,
                'amount' => $r->amount,
                'status' => $r->status,
                'created_at' => $r->created_at
            ];
        });

        // Commissions générées par cet utilisateur
        $commissions = \App\Models\Commission::where('parraine_user_id', $userId)->get();
        $result['commissions_generees'] = $commissions->map(function($c) {
            return [
                'id' => $c->id,
                'montant_base' => $c->montant_base,
                'montant_commission' => $c->montant_commission,
                'statut' => $c->statut,
                'created_at' => $c->created_at
            ];
        });

        return response()->json($result);
    }

    /**
     * Voir les utilisateurs récents pour trouver le nouveau compte
     */
    public function recentUsers()
    {
        $users = \App\Models\User::orderBy('created_at', 'desc')
            ->limit(10)
            ->get(['id', 'email', 'parrain_id', 'created_at']);
            
        return response()->json([
            'recent_users' => $users->map(function($u) {
                return [
                    'id' => $u->id,
                    'email' => $u->email,
                    'parrain_id' => $u->parrain_id,
                    'created_at' => $u->created_at,
                    'debug_url' => url("/debug-parrainage/{$u->id}")
                ];
            })
        ]);
    }

    /**
     * Diagnostiquer un parrain - vérifier son affiliation et capacité à recevoir des commissions
     */
    public function checkParrain($userId)
    {
        $user = \App\Models\User::find($userId);
        
        if (!$user) {
            return response()->json(['error' => 'Utilisateur non trouvé'], 404);
        }

        // Vérifier l'affiliation de ce parrain
        $affiliation = \App\Models\Affiliation::where('user_id', $userId)->first();
        
        // Ses filleuls
        $filleuls = \App\Models\User::where('parrain_id', $userId)->get();
        
        // Commissions qu'il a reçues
        $commissionsRecues = \App\Models\Commission::whereHas('affiliation', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->get();

        return response()->json([
            'parrain_info' => [
                'id' => $user->id,
                'email' => $user->email,
                'created_at' => $user->created_at
            ],
            'affiliation' => $affiliation ? [
                'id' => $affiliation->id,
                'code_affiliation' => $affiliation->code_affiliation,
                'is_active' => $affiliation->is_active,
                'commission_rate' => $affiliation->commission_rate,
                'total_parraines' => $affiliation->total_parraines,
                'total_commissions' => $affiliation->total_commissions,
                'created_at' => $affiliation->created_at
            ] : null,
            'filleuls' => $filleuls->map(function($f) {
                return [
                    'id' => $f->id,
                    'email' => $f->email,
                    'created_at' => $f->created_at
                ];
            }),
            'diagnostic' => [
                'has_affiliation' => !empty($affiliation),
                'affiliation_active' => $affiliation ? $affiliation->is_active : false,
                'can_receive_commissions' => !empty($affiliation) && $affiliation->is_active,
                'filleuls_count' => $filleuls->count()
            ]
        ]);
    }

    /**
     * Forcer la création de commission pour une transaction spécifique
     */
    public function forceCommission($transactionId)
    {
        $transaction = RechargeTransaction::where('transaction_id', $transactionId)->first();
        
        if (!$transaction) {
            return response()->json(['error' => 'Transaction non trouvée'], 404);
        }

        try {
            // Appeler directement la méthode de commission avec debugging forcé
            $result = $this->forceProcessAffiliationCommissions($transaction);
            
            return response()->json([
                'message' => 'Commission forcée',
                'transaction_id' => $transactionId,
                'result' => $result
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors du forçage',
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    /**
     * Endpoint admin pour forcer la complétion d'une transaction spécifique.
     * Protégé par le middleware AdminAuthenticated (déclaré dans les routes).
     */
    public function adminForceComplete($transactionId)
    {
        $transaction = RechargeTransaction::where('transaction_id', $transactionId)->first();

        if (! $transaction) {
            return response()->json(['error' => 'Transaction non trouvée'], 404);
        }

        if ($transaction->status === 'completed') {
            return response()->json(['message' => 'Transaction déjà complétée', 'transaction_id' => $transactionId], 200);
        }

        try {
            // Appeler la méthode interne qui effectue la complétion (mise à jour status, crédit, commissions)
            $this->completeTransaction($transaction);

            return response()->json([
                'message' => 'Transaction complétée avec succès',
                'transaction_id' => $transactionId,
                'status' => $transaction->status
            ], 200);

        } catch (\Exception $e) {
            Log::error('Erreur adminForceComplete', ['transaction_id' => $transactionId, 'error' => $e->getMessage()]);
            return response()->json(['error' => 'Erreur lors de la complétion: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Version forcée de processAffiliationCommissions avec debugging complet
     */
    private function forceProcessAffiliationCommissions($transaction)
    {
        $debug = ['steps' => []];
        
        $debug['steps'][] = 'Début du traitement forcé';
        
        $user = $transaction->user;
        $debug['steps'][] = "Utilisateur trouvé: ID {$user->id}, Email: {$user->email}";
        
        if (!$user->parrain_id) {
            $debug['steps'][] = 'ARRÊT: Aucun parrain_id trouvé';
            return $debug;
        }
        
        $debug['steps'][] = "Parrain ID trouvé: {$user->parrain_id}";
        
        // Récupérer l'affiliation du parrain
        $parrainAffiliation = \App\Models\Affiliation::where('user_id', $user->parrain_id)
                                                    ->where('is_active', true)
                                                    ->first();
        
        if (!$parrainAffiliation) {
            $debug['steps'][] = 'ARRÊT: Affiliation du parrain non trouvée ou inactive';
            return $debug;
        }
        
        $debug['steps'][] = "Affiliation trouvée: ID {$parrainAffiliation->id}, Taux: {$parrainAffiliation->commission_rate}%";
        
        // Calculer la commission
        $tauxCommission = $parrainAffiliation->commission_rate ?? 5;
        $montantBase = $transaction->amount;
        $montantCommission = ($montantBase * $tauxCommission) / 100;
        
        $debug['steps'][] = "Calcul: {$montantBase} F CFA × {$tauxCommission}% = {$montantCommission} F CFA";
        
        // Créer la commission
        $commission = \App\Models\Commission::create([
            'affiliation_id' => $parrainAffiliation->id,
            'parraine_user_id' => $user->id,
            'compte_id' => $transaction->compte_id,
            'action_type' => 'recharge',
            'montant_base' => $montantBase,
            'taux_commission' => $tauxCommission,
            'montant_commission' => $montantCommission,
            'statut' => 'valide',
            'date_action' => now(),
            'date_validation' => now(),
            'details' => [
                'transaction_id' => $transaction->transaction_id,
                'forced_creation' => true
            ]
        ]);
        
        $debug['steps'][] = "Commission créée: ID {$commission->id}";
        
        // Mettre à jour l'affiliation
        $parrainAffiliation->increment('total_commissions', $montantCommission);
        $debug['steps'][] = "Total commissions parrain mis à jour";
        
        // Créditer le parrain
        $parrainUser = \App\Models\User::find($user->parrain_id);
        $parrainCompte = \App\Models\Compte::where('user_id', $parrainUser->id)->first();
        
        if ($parrainCompte) {
            $parrainCompte->increment('account_balance', $montantCommission);
            $debug['steps'][] = "Compte parrain crédité de {$montantCommission} F CFA";
        }
        
        $debug['steps'][] = 'Commission forcée avec succès !';
        
        return $debug;
    }

    /**
     * Vérifier les données d'affiliation dans la base
     */
    public function checkAffiliationData()
    {
        $user = \App\Models\User::find(13);
        
        // Vérifier l'enregistrement d'affiliation
        $affiliation = \App\Models\Affiliation::where('user_id', $user->id)->first();
        
        // Compter réellement les affiliés
        $realAffiliatesCount = \App\Models\User::where('parrain_id', $user->id)->count();
        
        // Compter depuis la table affiliation si elle existe
        $affiliationCount = 0;
        if ($affiliation) {
            $affiliationCount = $affiliation->total_parraines;
        }
        
        return response()->json([
            'user_id' => $user->id,
            'affiliation_exists' => !empty($affiliation),
            'affiliation_data' => $affiliation ? [
                'id' => $affiliation->id,
                'total_parraines' => $affiliation->total_parraines,
                'total_commissions' => $affiliation->total_commissions,
                'is_active' => $affiliation->is_active,
                'created_at' => $affiliation->created_at
            ] : null,
            'real_affiliates_count' => $realAffiliatesCount,
            'discrepancy' => [
                'affiliation_shows' => $affiliationCount,
                'database_shows' => $realAffiliatesCount,
                'difference' => $affiliationCount - $realAffiliatesCount
            ],
            'all_users_with_parrain' => \App\Models\User::whereNotNull('parrain_id')->get(['id', 'email', 'parrain_id'])->toArray()
        ]);
    }
}

