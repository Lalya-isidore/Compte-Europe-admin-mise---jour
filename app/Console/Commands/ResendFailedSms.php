<?php

namespace App\Console\Commands;

use App\Models\SmsHistory;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ResendFailedSms extends Command
{
    protected $signature = 'sms:resend-failed
                            {--days=7 : Fenêtre en jours}
                            {--delay=5 : Délai en secondes entre chaque envoi}
                            {--dry-run : Simuler sans envoyer}';

    protected $description = 'Renvoie les SMS rejetés à cause d\'une erreur d\'authentification API';

    public function handle(SmsService $smsService): int
    {
        $days   = (int) $this->option('days');
        $delay  = (int) $this->option('delay');
        $dryRun = $this->option('dry-run');

        $sms = SmsHistory::where('status', 'Rejeté')
            ->where('error_message', 'like', '%Authentification API%')
            ->where('created_at', '>=', now()->subDays($days))
            ->get();

        if ($sms->isEmpty()) {
            $this->info('Aucun SMS à renvoyer.');
            return self::SUCCESS;
        }

        $this->info("SMS à renvoyer : {$sms->count()}" . ($dryRun ? ' (dry-run)' : ''));

        $sent = 0;
        $failed = 0;

        foreach ($sms as $record) {
            $segments      = max($record->sms_count, 1);
            $creditsNeeded = $segments * 500;
            $user          = User::find($record->user_id);

            if (!$user) {
                $this->warn("  [SKIP] SMS #{$record->id} — utilisateur introuvable");
                continue;
            }

            if ($user->credit_user < $creditsNeeded) {
                $this->warn("  [SKIP] SMS #{$record->id} ({$user->email}) — crédits insuffisants ({$user->credit_user} < {$creditsNeeded})");
                continue;
            }

            $this->line("  Renvoi SMS #{$record->id} → {$record->destinataire} (expéditeur: {$record->expediteur})");

            if ($dryRun) {
                $this->line("  [DRY-RUN] Renvoi simulé.");
                continue;
            }

            DB::beginTransaction();
            try {
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['credit_user' => DB::raw('credit_user - ' . $creditsNeeded)]);

                $response = $smsService->send($record->destinataire, $record->message, $record->expediteur);

                if ($response['success']) {
                    $record->status        = 'Envoyé';
                    $record->message_id    = $response['message_id'];
                    $record->credits_used  = $creditsNeeded;
                    $record->error_message = null;
                    $record->save();

                    DB::commit();
                    $this->info("  [OK] SMS #{$record->id} renvoyé (message_id: {$record->message_id})");
                    $sent++;

                    if ($delay > 0) {
                        sleep($delay);
                    }
                } else {
                    DB::rollBack();
                    $record->error_message = 'Erreur SMS: ' . ($response['error'] ?? 'Inconnue');
                    $record->save();

                    $this->error("  [FAIL] SMS #{$record->id} : " . ($response['error'] ?? 'Inconnue'));
                    $failed++;
                }
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('ResendFailedSms exception', ['id' => $record->id, 'error' => $e->getMessage()]);
                $this->error("  [EXCEPTION] SMS #{$record->id} : " . $e->getMessage());
                $failed++;
            }
        }

        $this->newLine();
        $this->info("Terminé — Envoyés : {$sent} | Échecs : {$failed}");

        return self::SUCCESS;
    }
}
