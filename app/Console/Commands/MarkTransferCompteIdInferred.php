<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MarkTransferCompteIdInferred extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfers:mark-inferred {--batch=1000} {--apply}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark transfers.compte_id_inferred = 0 for confirmed matches and 1 for inferred ones. Dry-run by default.';

    public function handle()
    {
        $batch = (int)$this->option('batch');
        $apply = (bool)$this->option('apply');

        $this->info("Starting transfers:mark-inferred (batch={$batch}) apply=" . ($apply ? 'yes' : 'no'));

        $total = DB::table('transfers')->count();
        $this->info("Total transfers: {$total}");

        $offset = 0;
        $updated = 0;
        $confirmed = 0;
        $inferred = 0;

        while (true) {
            $rows = DB::table('transfers')->orderBy('id')->offset($offset)->limit($batch)->get();
            if ($rows->isEmpty()) {
                break;
            }

            foreach ($rows as $r) {
                // Default: inferred
                $mark = 1;

                if ($r->compte_id) {
                    // check if the compte row matches numerocompte and user_id
                    $compte = DB::table('comptes')->where('id', $r->compte_id)->first();
                    if ($compte && isset($r->numerocompte) && $compte->numerocompte == $r->numerocompte && $compte->user_id == $r->user_id) {
                        $mark = 0; // confirmed
                    }
                }

                if ($apply) {
                    DB::table('transfers')->where('id', $r->id)->update(['compte_id_inferred' => $mark]);
                }

                if ($mark === 0) {
                    $confirmed++;
                } else {
                    $inferred++;
                }

                $updated++;
            }

            $offset += $batch;
            $this->info("Processed {$offset}/{$total} rows...");
        }

        $this->info("Done. Processed {$updated} rows. confirmed={$confirmed} inferred={$inferred}");

        if (! $apply) {
            $this->info('Dry-run only. Rerun with --apply to write changes.');
        }

        return 0;
    }
}
