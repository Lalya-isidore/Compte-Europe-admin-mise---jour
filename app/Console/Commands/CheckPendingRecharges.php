<?php

namespace App\Console\Commands;

use App\Models\RechargeTransaction;
use App\Http\Controllers\RechargeController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckPendingRecharges extends Command
{
    protected $signature   = 'recharge:check-pending';
    protected $description = 'Vérifie et complète les transactions de recharge en attente via FedaPay';

    public function handle(): int
    {
        $pending = RechargeTransaction::where('status', 'pending')
            ->where('payment_method', 'fedapay')
            ->whereNotNull('external_transaction_id')
            ->where('created_at', '>=', now()->subHours(24))
            ->orderBy('created_at', 'desc')
            ->get();

        if ($pending->isEmpty()) {
            return self::SUCCESS;
        }

        $this->info("Vérification de {$pending->count()} transaction(s) en attente...");

        $controller   = app(RechargeController::class);
        $completed    = 0;
        $failed       = 0;
        $skipped      = 0;

        foreach ($pending as $transaction) {
            try {
                $fedapayStatus = $this->callProtected($controller, 'checkFedapayTransactionStatus', [$transaction->external_transaction_id]);

                if (in_array($fedapayStatus, ['approved', 'completed'])) {
                    $this->callProtected($controller, 'completeTransaction', [$transaction]);
                    $completed++;
                    Log::info('recharge:check-pending — transaction complétée', [
                        'transaction_id' => $transaction->transaction_id,
                        'user_id'        => $transaction->user_id,
                        'credits'        => $transaction->credits_earned,
                    ]);
                } elseif (in_array($fedapayStatus, ['canceled', 'declined', 'failed'])) {
                    $transaction->update([
                        'status'         => 'failed',
                        'failure_reason' => "FedaPay status: {$fedapayStatus}",
                    ]);
                    $failed++;
                } else {
                    $skipped++;
                }
            } catch (\Exception $e) {
                Log::error('recharge:check-pending — erreur', [
                    'transaction_id' => $transaction->transaction_id,
                    'error'          => $e->getMessage(),
                ]);
            }
        }

        $this->info("Résultat : {$completed} complétée(s), {$failed} échouée(s), {$skipped} ignorée(s).");

        return self::SUCCESS;
    }

    private function callProtected(object $object, string $method, array $args = []): mixed
    {
        $ref = new \ReflectionMethod($object, $method);
        $ref->setAccessible(true);
        return $ref->invokeArgs($object, $args);
    }
}
