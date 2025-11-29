<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Compte;
use App\Models\UnlockCode;
use Illuminate\Support\Facades\Log;

class MarkUnlockUsedOnZeroBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unlock:mark-zero-balance {--compte= : Optional single compte id to process} {--dry-run : Show what would be done without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark the latest unused UnlockCode as used for comptes whose balance is 0';

    public function handle()
    {
        $compteOption = $this->option('compte');
        $dryRun = $this->option('dry-run');

        if ($compteOption) {
            $compteIds = [(int)$compteOption];
        } else {
            $compteIds = Compte::where('account_balance', 0)->pluck('id')->toArray();
        }

        if (empty($compteIds)) {
            $this->info('Aucun compte avec balance = 0 trouvé.');
            return 0;
        }

        $this->info('Processing ' . count($compteIds) . ' compte(s)...');

        // For each compte, find the latest unused UnlockCode (if any) and mark it used
        foreach ($compteIds as $compteId) {
            try {
                $unlock = UnlockCode::where('compte_id', $compteId)
                    ->whereNull('used_at')
                    ->orderBy('created_at', 'desc')
                    ->first();

                if (! $unlock) {
                    $this->line("compte_id={$compteId} : pas d'UnlockCode non utilisé trouvé.");
                    continue;
                }

                if ($dryRun) {
                    $this->line("[dry-run] compte_id={$compteId} -> would mark unlock_id={$unlock->id} code={$unlock->code} as used");
                    continue;
                }

                $unlock->markAsUsed();
                $this->info("compte_id={$compteId} -> marked unlock_id={$unlock->id} code={$unlock->code} as used");
                Log::info('unlock:mark-zero-balance: marked used', ['compte_id' => $compteId, 'unlock_id' => $unlock->id, 'code' => $unlock->code]);
            } catch (\Throwable $e) {
                $this->error("Erreur sur compte_id={$compteId} : " . $e->getMessage());
                Log::error('unlock:mark-zero-balance error', ['compte_id' => $compteId, 'error' => $e->getMessage()]);
            }
        }

        $this->info('Done.');

        return 0;
    }
}
