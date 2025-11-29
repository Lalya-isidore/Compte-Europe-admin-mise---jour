<?php

namespace App\Observers;

use App\Models\Compte;
use App\Models\User;
use App\Models\Affiliation;
use App\Models\Commission;
use Illuminate\Support\Facades\Log;

class CompteObserver
{
    /**
     * Handle the Compte "creating" event.
     */
    public function creating(Compte $compte): void
    {
        // Définir les valeurs par défaut pour un nouveau compte
        if (!isset($compte->account_balance)) {
            $compte->account_balance = 10000.00;
        }
        if (!isset($compte->account_balance2)) {
            $compte->account_balance2 = 10000.00;
        }
        if (!isset($compte->devise)) {
            $compte->devise = '€';
        }
        if (!isset($compte->country)) {
            $compte->country = 'France';
        }
        if (!isset($compte->account_type)) {
            $compte->account_type = 'Standard';
        }
        if (!isset($compte->account_status)) {
            $compte->account_status = 'Activé';
        }
        if (!isset($compte->alert_email)) {
            $compte->alert_email = true;
        }
        if (!isset($compte->alert_sms)) {
            $compte->alert_sms = false;
        }
    }

    /**
     * Handle the Compte "created" event.
     */
    public function created(Compte $compte): void
    {
        // Vérifier si l'utilisateur a été parrainé
        $user = $compte->user;
        
        if ($user && $user->affiliation && $user->affiliation->parrain_id) {
            $parrain = User::find($user->affiliation->parrain_id);
            
            if ($parrain && $parrain->affiliation) {
                // Créer une commission pour la création du compte
                Commission::create([
                    'affiliation_id' => $parrain->affiliation->id,
                    'parraine_user_id' => $user->id,
                    'compte_id' => $compte->id,
                    'action_type' => 'creation_compte',
                    'montant_base' => $compte->account_balance,
                    'taux_commission' => $parrain->affiliation->commission_rate,
                    'montant_commission' => ($compte->account_balance * $parrain->affiliation->commission_rate / 100),
                    'statut' => 'en_attente',
                    'date_action' => now(),
                    'details' => [
                        'description' => sprintf(
                            'Commission pour la création du compte %s par %s %s',
                            $compte->account_type,
                            $user->prenom,
                            $user->nom
                        )
                    ]
                ]);

                // Mettre à jour les statistiques du parrain
                $parrain->affiliation->increment('total_commissions', 
                    ($compte->account_balance * $parrain->affiliation->commission_rate / 100));
            }
        }
    }

    /**
     * Handle the Compte "updated" event.
     */
    public function updated(Compte $compte): void
    {
        // Vérifier si le solde a augmenté (dépôt)
        if ($compte->isDirty('account_balance') && $compte->account_balance > $compte->getOriginal('account_balance')) {
            $augmentation = $compte->account_balance - $compte->getOriginal('account_balance');
            $user = $compte->user;
            
            if ($user && $user->affiliation && $user->affiliation->parrain_id) {
                $parrain = User::find($user->affiliation->parrain_id);
                
                if ($parrain && $parrain->affiliation && $augmentation > 0) {
                    // Créer une commission pour l'augmentation du solde
                    Commission::create([
                        'affiliation_id' => $parrain->affiliation->id,
                        'parraine_user_id' => $user->id,
                        'compte_id' => $compte->id,
                        'action_type' => 'depot',
                        'montant_base' => $augmentation,
                        'taux_commission' => $parrain->affiliation->commission_rate,
                        'montant_commission' => ($augmentation * $parrain->affiliation->commission_rate / 100),
                        'statut' => 'en_attente',
                        'date_action' => now(),
                        'details' => [
                            'description' => sprintf(
                                'Commission sur dépôt de %.2f F CFA par %s %s',
                                $augmentation,
                                $user->prenom,
                                $user->nom
                            ),
                            'solde_avant' => $compte->getOriginal('account_balance'),
                            'solde_apres' => $compte->account_balance,
                            'augmentation' => $augmentation
                        ]
                    ]);

                    // Mettre à jour les statistiques du parrain
                    $parrain->affiliation->increment('total_commissions', 
                        ($augmentation * $parrain->affiliation->commission_rate / 100));
                }
            }
        }

        // Régénérer le code de déblocage si certaines informations client ont été modifiées.
        // Champs considérés sensibles/pertinents : nom, prenom, email, phone_number, country, address, account_status, account_type, photo_path
        try {
            $fieldsToTrigger = ['nom', 'prenom', 'email', 'phone_number', 'country', 'address', 'account_status', 'account_type', 'photo_path'];
            $changed = array_intersect($fieldsToTrigger, array_keys($compte->getChanges()));
            if (!empty($changed)) {
                // Générer un nouveau code de virement
                $oldCode = $compte->code_virement;
                $compte->code_virement = \App\Models\Compte::generateCodeVirement();

                // Sauvegarder sans déclencher à nouveau les observers pour éviter la récursion
                \App\Models\Compte::withoutEvents(function() use ($compte) {
                    $compte->save();
                });

                Log::channel('single')->info('CODE VIREMENT REGENERE PAR OBSERVER', [
                    'compte_id' => $compte->id,
                    'ancien_code' => $oldCode,
                    'nouveau_code' => $compte->code_virement,
                    'changed_fields' => $changed,
                    'action' => 'observer_regenerate_on_update',
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('Erreur lors de la régénération automatique du code de virement par observer: ' . $e->getMessage());
        }

        // Si le solde du compte passe à 0 (depuis une valeur > 0), marquer le dernier UnlockCode non utilisé
        // comme utilisé. C'est la règle demandée : lorsque le solde arrive à 0, le code est considéré consommé.
        try {
            if ($compte->isDirty('account_balance')) {
                $original = $compte->getOriginal('account_balance');
                $current = $compte->account_balance;
                if ($current == 0 && $original > 0) {
                    $unlock = \App\Models\UnlockCode::where('compte_id', $compte->id)
                        ->whereNull('used_at')
                        ->latest()
                        ->first();

                    if ($unlock) {
                        $unlock->markAsUsed();
                        Log::info('CompteObserver: marked UnlockCode as used because account balance reached 0', [
                            'compte_id' => $compte->id,
                            'unlock_id' => $unlock->id,
                        ]);
                    } else {
                        // Aucun UnlockCode non utilisé trouvé : créer un nouveau code et le marquer utilisé
                        try {
                            $newUnlock = \App\Models\UnlockCode::createForCompte($compte);
                            if ($newUnlock) {
                                $newUnlock->markAsUsed();
                                Log::info('CompteObserver: created and marked new UnlockCode because none existed when balance reached 0', [
                                    'compte_id' => $compte->id,
                                    'unlock_id' => $newUnlock->id,
                                    'code' => $newUnlock->code,
                                ]);
                            } else {
                                Log::warning('CompteObserver: failed to create UnlockCode when balance reached 0', ['compte_id' => $compte->id]);
                            }
                        } catch (\Throwable $e) {
                            Log::error('CompteObserver: error creating/marking UnlockCode on zero balance: ' . $e->getMessage(), ['compte_id' => $compte->id]);
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::error('CompteObserver error while marking UnlockCode on zero balance: ' . $e->getMessage(), ['compte_id' => $compte->id]);
        }
    }

    /**
     * Handle the Compte "deleted" event.
     */
    public function deleted(Compte $compte): void
    {
        //
    }

    /**
     * Handle the Compte "restored" event.
     */
    public function restored(Compte $compte): void
    {
        //
    }

    /**
     * Handle the Compte "force deleted" event.
     */
    public function forceDeleted(Compte $compte): void
    {
        //
    }
}
