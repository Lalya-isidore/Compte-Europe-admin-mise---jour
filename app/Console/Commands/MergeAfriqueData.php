<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MergeAfriqueData extends Command
{
    protected $signature = 'merge:afrique
        {--dry-run : Simuler la migration sans écrire de données}
        {--offset=100000 : Offset à ajouter aux IDs de CompteAfrique}';

    protected $description = 'Migrer les données de CompteAfrique vers CompteEurope avec offset d\'IDs et fusion des emails en double';

    private int $offset;
    private bool $dryRun;
    private int $migrated = 0;
    private int $merged = 0;
    private int $skipped = 0;

    /**
     * Mapping Afrique user ID → Europe user ID (for duplicate email users).
     * For non-duplicate users: afrique_id → afrique_id + offset
     * For duplicate users:     afrique_id → existing europe_id
     */
    private array $userIdMap = [];

    public function handle(): int
    {
        $this->offset = (int) $this->option('offset');
        $this->dryRun = (bool) $this->option('dry-run');

        $this->info("=== Migration CompteAfrique → CompteEurope ===");
        $this->info("Offset: {$this->offset}");
        $this->info("Mode: " . ($this->dryRun ? 'DRY RUN (aucune écriture)' : 'RÉEL'));
        $this->newLine();

        // Vérifier la connexion
        try {
            $afriqueCount = DB::connection('mysql_afrique')->table('users')->count();
            $this->info("Connexion mysql_afrique OK - {$afriqueCount} utilisateurs trouvés");
        } catch (\Exception $e) {
            $this->error("Impossible de se connecter à mysql_afrique: " . $e->getMessage());
            return 1;
        }

        // Détecter les emails en double et construire le mapping
        $this->info("\n--- Vérification des conflits d'email ---");
        $afriqueUsers = DB::connection('mysql_afrique')->table('users')->get();
        $europeUsersByEmail = DB::table('users')->pluck('id', 'email')->toArray();

        $conflictEmails = [];
        foreach ($afriqueUsers as $afriqueUser) {
            if (isset($europeUsersByEmail[$afriqueUser->email])) {
                // Email en double → l'ID Afrique pointe vers l'ID Europe existant
                $this->userIdMap[$afriqueUser->id] = $europeUsersByEmail[$afriqueUser->email];
                $conflictEmails[] = $afriqueUser->email;
            } else {
                // Pas de conflit → l'ID Afrique reçoit l'offset
                $this->userIdMap[$afriqueUser->id] = $afriqueUser->id + $this->offset;
            }
        }

        if (!empty($conflictEmails)) {
            $this->warn("Emails en double trouvés (" . count($conflictEmails) . ") → données fusionnées :");
            foreach ($conflictEmails as $email) {
                $afriqueId = array_search($europeUsersByEmail[$email], $this->userIdMap);
                $this->warn("  - {$email} (Afrique #{$afriqueId} → Europe #{$europeUsersByEmail[$email]})");
            }
        } else {
            $this->info("Aucun conflit d'email détecté.");
        }

        // Vérifier les conflits de numerocompte
        $this->info("\n--- Vérification des conflits de numéro de compte ---");
        $afriqueComptes = DB::connection('mysql_afrique')->table('comptes')
            ->whereNotNull('numerocompte')->pluck('numerocompte')->toArray();
        $compteConflicts = DB::table('comptes')
            ->whereIn('numerocompte', $afriqueComptes)->pluck('numerocompte')->toArray();

        if (!empty($compteConflicts)) {
            $this->warn("Numéros de compte en double: " . implode(', ', $compteConflicts));
            $this->warn("Ces comptes recevront un nouveau numéro.");
        } else {
            $this->info("Aucun conflit de numéro de compte.");
        }

        // Vérifier les conflits d'ID
        $this->info("\n--- Vérification des conflits d'ID ---");
        $maxEuropeId = max(
            DB::table('users')->max('id') ?? 0,
            DB::table('comptes')->max('id') ?? 0,
            DB::table('affiliations')->max('id') ?? 0,
            DB::table('transfers')->max('id') ?? 0,
        );
        $maxAfriqueId = max(
            DB::connection('mysql_afrique')->table('users')->max('id') ?? 0,
            DB::connection('mysql_afrique')->table('comptes')->max('id') ?? 0,
        );

        if ($maxAfriqueId + $this->offset <= $maxEuropeId) {
            $this->error("L'offset {$this->offset} est trop petit ! Max ID Europe: {$maxEuropeId}, Max ID Afrique + offset: " . ($maxAfriqueId + $this->offset));
            return 1;
        }
        $this->info("Max ID Europe: {$maxEuropeId}, Offset: {$this->offset} → OK");

        if (!$this->dryRun && !$this->confirm('Voulez-vous lancer la migration RÉELLE ?')) {
            $this->info('Migration annulée.');
            return 0;
        }

        // Lancer la migration
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        try {
            DB::beginTransaction();

            $this->migrateUsers($conflictEmails);
            $this->mergeCredits($conflictEmails);
            $this->migrateComptes($compteConflicts);
            $this->migrateAffiliations();
            $this->migrateCommissions();
            $this->migrateVirements();
            $this->migrateTransfers();
            $this->migrateUnlockCodes();
            $this->migrateRemboursements();
            $this->migrateTransactionHistories();
            $this->migrateRechargeTransactions();
            $this->migrateRetraits();
            $this->migrateSupportTickets();
            $this->migrateSupportMessages();

            if ($this->dryRun) {
                DB::rollBack();
                $this->newLine();
                $this->info("=== DRY RUN terminé ===");
            } else {
                DB::commit();
                $this->newLine();
                $this->info("=== Migration terminée avec succès ===");
            }

            $this->info("Enregistrements migrés (nouveaux): {$this->migrated}");
            $this->info("Enregistrements fusionnés (email double): {$this->merged}");

            return 0;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Migration échouée: " . $e->getMessage());
            Log::error('MergeAfriqueData failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return 1;
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }

    /**
     * Résoudre l'ID Europe d'un user Afrique via le mapping.
     */
    private function resolveUserId(int $afriqueUserId): int
    {
        return $this->userIdMap[$afriqueUserId] ?? ($afriqueUserId + $this->offset);
    }

    /**
     * Vérifie si un user Afrique est un doublon (email existe déjà en Europe).
     */
    private function isDuplicateUser(int $afriqueUserId): bool
    {
        $mappedId = $this->userIdMap[$afriqueUserId] ?? null;
        // Si le mapping donne un ID sans offset, c'est un doublon
        return $mappedId !== null && $mappedId !== ($afriqueUserId + $this->offset);
    }

    // ─── Users ───────────────────────────────────────────────

    private function migrateUsers(array $conflictEmails): void
    {
        $this->info("\n--- Migration des utilisateurs ---");
        $users = DB::connection('mysql_afrique')->table('users')->get();
        $newCount = 0;
        $dupeCount = 0;

        foreach ($users as $user) {
            if (in_array($user->email, $conflictEmails)) {
                // Email en double → pas de création, les données seront rattachées à l'user Europe
                $dupeCount++;
                continue;
            }

            DB::table('users')->insert([
                'id' => $user->id + $this->offset,
                'nom' => $user->nom,
                'prenom' => $user->prenom,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'password' => $user->password,
                'phone' => $user->phone ?? null,
                'region' => 'afrique',
                'credit_user' => $user->credit_user ?? 0,
                'code_parrainage' => $user->code_parrainage,
                'parrain_id' => $user->parrain_id ? $this->resolveUserId($user->parrain_id) : null,
                'remember_token' => null,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ]);
            $newCount++;
            $this->migrated++;
        }
        $this->info("  Users: {$newCount} créés, {$dupeCount} doublons (données fusionnées vers compte Europe)");
    }

    /**
     * Fusionner les crédits des utilisateurs en double.
     * Les crédits Afrique sont AJOUTÉS aux crédits Europe existants.
     */
    private function mergeCredits(array $conflictEmails): void
    {
        if (empty($conflictEmails)) {
            return;
        }

        $this->info("\n--- Fusion des crédits pour les doublons ---");
        $afriqueUsers = DB::connection('mysql_afrique')->table('users')
            ->whereIn('email', $conflictEmails)->get();

        foreach ($afriqueUsers as $afriqueUser) {
            $europeId = $this->resolveUserId($afriqueUser->id);
            $afriqueCredits = $afriqueUser->credit_user ?? 0;

            if ($afriqueCredits > 0) {
                DB::table('users')->where('id', $europeId)->increment('credit_user', $afriqueCredits);
                $this->info("  {$afriqueUser->email}: +{$afriqueCredits} crédits ajoutés au compte Europe #{$europeId}");
            }
        }
    }

    // ─── Comptes ─────────────────────────────────────────────

    private function migrateComptes(array $compteConflicts): void
    {
        $this->info("\n--- Migration des comptes ---");
        $comptes = DB::connection('mysql_afrique')->table('comptes')->get();
        $count = 0;

        foreach ($comptes as $compte) {
            $numerocompte = $compte->numerocompte;
            if (in_array($numerocompte, $compteConflicts)) {
                $numerocompte = 'FC-' . strtoupper(\Illuminate\Support\Str::random(10));
            }

            $targetUserId = $this->resolveUserId($compte->user_id);
            $isDupe = $this->isDuplicateUser($compte->user_id);

            DB::table('comptes')->insert([
                'id' => $compte->id + $this->offset,
                'user_id' => $targetUserId,
                'region' => 'afrique',
                'nom' => $compte->nom,
                'prenom' => $compte->prenom,
                'email' => $compte->email,
                'phone_number' => $compte->phone_number,
                'country' => $compte->country,
                'address' => $compte->address,
                'devise' => $compte->devise,
                'lang' => $compte->lang,
                'account_balance' => $compte->account_balance,
                'account_balance2' => $compte->account_balance2,
                'account_type' => $compte->account_type,
                'code_virement' => $compte->code_virement,
                'account_status' => $compte->account_status,
                'password' => $compte->password,
                'transfer_supported' => $compte->transfer_supported,
                'token' => $compte->token,
                'iban' => $compte->iban,
                'parameters' => $compte->parameters,
                'card_number' => $compte->card_number,
                'cvv' => $compte->cvv,
                'start_percentage' => $compte->start_percentage,
                'end_percentage' => $compte->end_percentage,
                'failure_message' => $compte->failure_message,
                'is_default' => $compte->is_default ?? false,
                'alert_email' => $compte->alert_email ?? true,
                'alert_sms' => $compte->alert_sms ?? false,
                'credits_available' => $compte->credits_available ?? 0,
                'auto_deletes_at' => $compte->auto_deletes_at,
                'is_auto_created' => $compte->is_auto_created ?? false,
                'numerocompte' => $numerocompte,
                'photo_path' => $compte->photo_path,
                'created_at' => $compte->created_at,
                'updated_at' => $compte->updated_at,
            ]);

            if ($isDupe) {
                $this->merged++;
            } else {
                $this->migrated++;
            }
            $count++;
        }
        $this->info("  Comptes: {$count} migrés");
    }

    // ─── Affiliations ────────────────────────────────────────

    private function migrateAffiliations(): void
    {
        $this->info("--- Migration des affiliations ---");
        $rows = DB::connection('mysql_afrique')->table('affiliations')->get();
        $count = 0;

        foreach ($rows as $row) {
            DB::table('affiliations')->insert([
                'id' => $row->id + $this->offset,
                'user_id' => $this->resolveUserId($row->user_id),
                'parrain_id' => $row->parrain_id ? $this->resolveUserId($row->parrain_id) : null,
                'code_affiliation' => $row->code_affiliation,
                'commission_rate' => $row->commission_rate,
                'total_commissions' => $row->total_commissions,
                'total_parraines' => $row->total_parraines,
                'is_active' => $row->is_active,
                'settings' => $row->settings,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
            ]);
            $count++;
            $this->migrated++;
        }
        $this->info("  Affiliations: {$count} migrés");
    }

    // ─── Commissions ─────────────────────────────────────────

    private function migrateCommissions(): void
    {
        $this->info("--- Migration des commissions ---");
        $rows = DB::connection('mysql_afrique')->table('commissions')->get();
        $count = 0;

        foreach ($rows as $row) {
            DB::table('commissions')->insert([
                'id' => $row->id + $this->offset,
                'affiliation_id' => $row->affiliation_id + $this->offset,
                'parraine_user_id' => $this->resolveUserId($row->parraine_user_id),
                'compte_id' => $row->compte_id ? $row->compte_id + $this->offset : null,
                'action_type' => $row->action_type,
                'montant_base' => $row->montant_base,
                'taux_commission' => $row->taux_commission,
                'montant_commission' => $row->montant_commission,
                'statut' => $row->statut,
                'date_action' => $row->date_action,
                'date_validation' => $row->date_validation,
                'details' => $row->details,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
            ]);
            $count++;
            $this->migrated++;
        }
        $this->info("  Commissions: {$count} migrés");
    }

    // ─── Virements ───────────────────────────────────────────

    private function migrateVirements(): void
    {
        $this->info("--- Migration des virements ---");
        $rows = DB::connection('mysql_afrique')->table('virements')->get();
        $count = 0;

        foreach ($rows as $row) {
            DB::table('virements')->insert([
                'id' => $row->id + $this->offset,
                'compte_id' => $row->compte_id + $this->offset,
                'iban' => $row->iban,
                'bic' => $row->bic,
                'bank_name' => $row->bank_name,
                'beneficiary_name' => $row->beneficiary_name,
                'reason' => $row->reason,
                'solidvire' => $row->solidvire,
                'status' => $row->status,
                'unlock_code' => $row->unlock_code,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
            ]);
            $count++;
            $this->migrated++;
        }
        $this->info("  Virements: {$count} migrés");
    }

    // ─── Transfers ───────────────────────────────────────────

    private function migrateTransfers(): void
    {
        $this->info("--- Migration des transfers ---");
        $rows = DB::connection('mysql_afrique')->table('transfers')->get();
        $count = 0;

        foreach ($rows as $row) {
            $data = [
                'id' => $row->id + $this->offset,
                'user_id' => $this->resolveUserId($row->user_id),
                'numerocompte' => $row->numerocompte,
                'name_servieur' => $row->name_servieur,
                'beneficiary_name' => $row->beneficiary_name,
                'reason' => $row->reason,
                'devise' => $row->devise,
                'token' => $row->token,
                'solidvire' => $row->solidvire,
                'status' => $row->status,
                'compte_id' => $row->compte_id ? $row->compte_id + $this->offset : null,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
            ];

            if (isset($row->compte_id_inferred)) {
                $data['compte_id_inferred'] = $row->compte_id_inferred;
            }

            DB::table('transfers')->insert($data);
            $count++;
            $this->migrated++;
        }
        $this->info("  Transfers: {$count} migrés");
    }

    // ─── Unlock Codes ────────────────────────────────────────

    private function migrateUnlockCodes(): void
    {
        $this->info("--- Migration des unlock_codes ---");
        $rows = DB::connection('mysql_afrique')->table('unlock_codes')->get();
        $count = 0;

        foreach ($rows as $row) {
            DB::table('unlock_codes')->insert([
                'id' => $row->id + $this->offset,
                'transfer_id' => $row->transfer_id ? $row->transfer_id + $this->offset : null,
                'compte_id' => $row->compte_id ? $row->compte_id + $this->offset : null,
                'code' => $row->code,
                'expires_at' => $row->expires_at ?? null,
                'used_at' => $row->used_at ?? null,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
            ]);
            $count++;
            $this->migrated++;
        }
        $this->info("  Unlock codes: {$count} migrés");
    }

    // ─── Remboursements ──────────────────────────────────────

    private function migrateRemboursements(): void
    {
        $this->info("--- Migration des remboursements ---");
        $rows = DB::connection('mysql_afrique')->table('remboursements')->get();
        $count = 0;

        foreach ($rows as $row) {
            DB::table('remboursements')->insert([
                'id' => $row->id + $this->offset,
                'compte_id' => $row->compte_id + $this->offset,
                'montant' => $row->montant,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
            ]);
            $count++;
            $this->migrated++;
        }
        $this->info("  Remboursements: {$count} migrés");
    }

    // ─── Transaction Histories ───────────────────────────────

    private function migrateTransactionHistories(): void
    {
        $this->info("--- Migration des transaction_histories ---");
        $rows = DB::connection('mysql_afrique')->table('transaction_histories')->get();
        $count = 0;

        foreach ($rows as $row) {
            DB::table('transaction_histories')->insert([
                'id' => $row->id + $this->offset,
                'user_id' => $this->resolveUserId($row->user_id),
                'transaction_type' => $row->transaction_type,
                'amount' => $row->amount,
                'description' => $row->description,
                'devise' => $row->devise,
                'compte_id' => $row->compte_id ? $row->compte_id + $this->offset : null,
                'transfer_id' => isset($row->transfer_id) && $row->transfer_id ? $row->transfer_id + $this->offset : null,
                'mobile_number' => $row->mobile_number ?? null,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
            ]);
            $count++;
            $this->migrated++;
        }
        $this->info("  Transaction histories: {$count} migrés");
    }

    // ─── Recharge Transactions ───────────────────────────────

    private function migrateRechargeTransactions(): void
    {
        $this->info("--- Migration des recharge_transactions ---");
        $rows = DB::connection('mysql_afrique')->table('recharge_transactions')->get();
        $count = 0;

        foreach ($rows as $row) {
            DB::table('recharge_transactions')->insert([
                'id' => $row->id + $this->offset,
                'user_id' => $this->resolveUserId($row->user_id),
                'compte_id' => $row->compte_id ? $row->compte_id + $this->offset : null,
                'transaction_id' => $row->transaction_id,
                'amount' => $row->amount,
                'credits_earned' => $row->credits_earned,
                'payment_method' => $row->payment_method,
                'payment_provider' => $row->payment_provider,
                'status' => $row->status,
                'external_transaction_id' => $row->external_transaction_id,
                'payment_details' => $row->payment_details,
                'response_data' => $row->response_data,
                'failure_reason' => $row->failure_reason,
                'completed_at' => $row->completed_at,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
            ]);
            $count++;
            $this->migrated++;
        }
        $this->info("  Recharge transactions: {$count} migrés");
    }

    // ─── Retraits ────────────────────────────────────────────

    private function migrateRetraits(): void
    {
        $this->info("--- Migration des retraits ---");
        $rows = DB::connection('mysql_afrique')->table('retraits')->get();
        $count = 0;

        foreach ($rows as $row) {
            DB::table('retraits')->insert([
                'id' => $row->id + $this->offset,
                'user_id' => $this->resolveUserId($row->user_id),
                'affiliation_id' => $row->affiliation_id + $this->offset,
                'montant' => $row->montant,
                'operateur' => $row->operateur,
                'numero_telephone' => $row->numero_telephone,
                'statut' => $row->statut,
                'date_demande' => $row->date_demande,
                'date_traitement' => $row->date_traitement,
                'commentaire' => $row->commentaire,
                'details' => $row->details,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
            ]);
            $count++;
            $this->migrated++;
        }
        $this->info("  Retraits: {$count} migrés");
    }

    // ─── Support Tickets ─────────────────────────────────────

    private function migrateSupportTickets(): void
    {
        $this->info("--- Migration des support_tickets ---");
        $rows = DB::connection('mysql_afrique')->table('support_tickets')->get();
        $count = 0;

        foreach ($rows as $row) {
            DB::table('support_tickets')->insert([
                'id' => $row->id + $this->offset,
                'user_id' => $this->resolveUserId($row->user_id),
                'subject' => $row->subject,
                'status' => $row->status,
                'last_message_at' => $row->last_message_at,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
            ]);
            $count++;
            $this->migrated++;
        }
        $this->info("  Support tickets: {$count} migrés");
    }

    // ─── Support Messages ────────────────────────────────────

    private function migrateSupportMessages(): void
    {
        $this->info("--- Migration des support_messages ---");
        $rows = DB::connection('mysql_afrique')->table('support_messages')->get();
        $count = 0;

        foreach ($rows as $row) {
            DB::table('support_messages')->insert([
                'id' => $row->id + $this->offset,
                'support_ticket_id' => $row->support_ticket_id + $this->offset,
                'user_id' => $row->user_id ? $this->resolveUserId($row->user_id) : null,
                'sent_by_admin' => $row->sent_by_admin,
                'content' => $row->content,
                'file_name' => $row->file_name ?? null,
                'file_path' => $row->file_path ?? null,
                'file_type' => $row->file_type ?? null,
                'file_size' => $row->file_size ?? null,
                'voice_path' => $row->voice_path ?? null,
                'read_at' => $row->read_at,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
            ]);
            $count++;
            $this->migrated++;
        }
        $this->info("  Support messages: {$count} migrés");
    }
}
