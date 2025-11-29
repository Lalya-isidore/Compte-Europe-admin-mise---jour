<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transfer;
use App\Models\Compte;
use Illuminate\Support\Facades\DB;

class BackfillTransfersCompteId extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfers:backfill-compte-id {--apply : Actually write updates} {--batch=1000 : Batch size for chunking}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backfill transfers.compte_id from numerocompte + user_id. Run without --apply to dry-run.';

    public function handle()
    {
        $apply = (bool) $this->option('apply');
        $batch = (int) $this->option('batch');

        $this->info('Backfill transfers.compte_id (apply=' . ($apply ? 'yes' : 'no') . ', batch=' . $batch . ')');

        $total = Transfer::count();
        $this->info("Total transfers: {$total}");

        $csvDir = storage_path('backfill');
        if (! is_dir($csvDir)) {
            mkdir($csvDir, 0755, true);
        }

        $csvPath = $csvDir . DIRECTORY_SEPARATOR . 'transfers_ambiguous_' . date('Ymd_His') . '.csv';
        $fp = fopen($csvPath, 'w');
        fputcsv($fp, ['id', 'user_id', 'numerocompte', 'matches', 'notes']);

        $updated = 0;
        $ambiguous = 0;

        Transfer::chunk($batch, function ($transfers) use (&$updated, &$ambiguous, $apply, $fp) {
            foreach ($transfers as $t) {
                try {
                    // 1) Exact match by numerocompte + user_id (strongest)
                    $matches = Compte::where('numerocompte', $t->numerocompte)
                        ->where('user_id', $t->user_id)
                        ->get();

                    if ($matches->count() === 1) {
                        $compteId = $matches->first()->id;
                        if ($apply) {
                            DB::table('transfers')->where('id', $t->id)->update(['compte_id' => $compteId]);
                        }
                        $updated++;
                        continue;
                    }

                    // 2) Prefer matching by email if we can extract one (email is the most reliable)
                    $candidateEmail = null;
                    // If transfer has a dedicated email column, use it
                    if (isset($t->email) && filter_var($t->email, FILTER_VALIDATE_EMAIL)) {
                        $candidateEmail = $t->email;
                    }

                    // Otherwise try to extract an email from name_servieur or beneficiary_name
                    if (! $candidateEmail) {
                        $fieldsToScan = [];
                        if (isset($t->name_servieur)) $fieldsToScan[] = $t->name_servieur;
                        if (isset($t->beneficiary_name)) $fieldsToScan[] = $t->beneficiary_name;
                        foreach ($fieldsToScan as $field) {
                            if (! $field) continue;
                            if (preg_match('/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}/i', $field, $m)) {
                                $candidateEmail = $m[0];
                                break;
                            }
                        }
                    }

                    if ($candidateEmail) {
                        $user = \App\Models\User::where('email', $candidateEmail)->first();
                        if ($user) {
                            // If this user has exactly one compte, use it
                            $comptesForUser = Compte::where('user_id', $user->id)->get();
                            if ($comptesForUser->count() === 1) {
                                $compteId = $comptesForUser->first()->id;
                                if ($apply) {
                                    DB::table('transfers')->where('id', $t->id)->update(['compte_id' => $compteId]);
                                }
                                $updated++;
                                continue;
                            }

                            // If multiple comptes for this user, try to prefer auto-created compte
                            $byAuto = $comptesForUser->where('is_auto_created', 1);
                            if ($byAuto->count() === 1) {
                                $compteId = $byAuto->first()->id;
                                if ($apply) {
                                    DB::table('transfers')->where('id', $t->id)->update(['compte_id' => $compteId]);
                                }
                                $updated++;
                                continue;
                            }

                            // Otherwise try to prefer numerocompte among this user's comptes
                            $byNum = $comptesForUser->where('numerocompte', $t->numerocompte);
                            if ($byNum->count() === 1) {
                                $compteId = $byNum->first()->id;
                                if ($apply) {
                                    DB::table('transfers')->where('id', $t->id)->update(['compte_id' => $compteId]);
                                }
                                $updated++;
                                continue;
                            }
                        }
                    }

                    // 3) Fallback: prefer the user's auto-created compte (if transfer.user_id present)
                    $autoCompte = null;
                    if ($t->user_id) {
                        $autoCompte = Compte::where('user_id', $t->user_id)->where('is_auto_created', 1)->first();
                    }
                    if ($autoCompte) {
                        if ($apply) {
                            DB::table('transfers')->where('id', $t->id)->update(['compte_id' => $autoCompte->id]);
                        }
                        $updated++;
                        continue;
                    }

                    // Nothing matched uniquely -> mark ambiguous
                    $ambiguous++;
                    fputcsv($fp, [$t->id, $t->user_id, $t->numerocompte, 'ambiguous', '']);
                } catch (\Throwable $e) {
                    fputcsv($fp, [$t->id, $t->user_id, $t->numerocompte, 'error', $e->getMessage()]);
                }
            }
        });

        fclose($fp);

        $this->info("Done. Updated: {$updated}. Ambiguous/failed: {$ambiguous}.");
        $this->info("Ambiguous CSV: {$csvPath}");
        if (! $apply) {
            $this->info('Dry-run complete. Re-run with --apply to write updates.');
        }

        return 0;
    }
}
