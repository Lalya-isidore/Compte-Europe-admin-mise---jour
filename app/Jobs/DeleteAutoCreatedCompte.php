<?php

namespace App\Jobs;

use App\Models\Compte;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Transfer;

class DeleteAutoCreatedCompte implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $compteId;

    public function __construct($compteId)
    {
        $this->compteId = $compteId;
    }

    public function handle()
    {
        try {
            $compte = Compte::find($this->compteId);
            
            if (! $compte) {
                Log::info("Compte auto-suppression : Compte {$this->compteId} déjà supprimé.");
                return;
            }

            // Ne supprimer que si c'est un compte auto-crée et que l'heure est dépassée
            // Supprimer définitivement le compte auto-créé et toutes ses données associées
            if ($compte->auto_deletes_at && $compte->auto_deletes_at->isPast() && $compte->is_auto_created) {
                // Supprimer toutes les données liées
                try {
                    if (method_exists($compte, 'transactionHistories')) {
                        $compte->transactionHistories()->delete();
                    }
                } catch (\Exception $e) {
                    Log::warning("Suppression liée: transactionHistories delete failed for compte {$compte->id}: " . $e->getMessage());
                }

                try {
                    if (method_exists($compte, 'rechargeTransactions')) {
                        $compte->rechargeTransactions()->delete();
                    }
                } catch (\Exception $e) {
                    Log::warning("Suppression liée: rechargeTransactions delete failed for compte {$compte->id}: " . $e->getMessage());
                }

                try {
                    if (method_exists($compte, 'transfers')) {
                        if (Schema::hasColumn('transfers', 'compte_id')) {
                            $compte->transfers()->delete();
                        } else {
                            if (! empty($compte->numerocompte)) {
                                Transfer::where('numerocompte', $compte->numerocompte)
                                    ->where('user_id', $compte->user_id)
                                    ->delete();
                            }
                        }
                    }
                } catch (\Throwable $e) {
                    Log::warning("Suppression liée: transfers delete failed for compte {$compte->id}: " . $e->getMessage());
                }

                // Enfin supprimer le compte lui-même
                $compte->delete();

                Log::info("Compte auto-suppression : Compte {$this->compteId} et données associées supprimés définitivement.");
            }
        } catch (\Exception $e) {
            Log::error("Compte auto-suppression : Erreur lors de la suppression du compte {$this->compteId} : " . $e->getMessage());
        }
    }

    // NOTE: canBeDeleted() removed — deletion is now forced for auto-created comptes when
    // auto_deletes_at has passed. The old conservative check logic was intentionally removed
    // per operator request to delete the compte and its associated data unconditionally.
}
