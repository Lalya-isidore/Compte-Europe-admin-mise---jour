<?php
namespace App\Observers;

use App\Models\Transfer;
use App\Models\UnlockCode;
use Illuminate\Support\Facades\Log;

class TransferObserver
{
    /**
     * Handle the Transfer "updated" event.
     */
    public function updated(Transfer $transfer): void
    {
        // Only act when the status field changed to completed
        if ($transfer->isDirty('status') && $transfer->status === 'completed') {
            $this->markUnlockIfNeeded($transfer);
        }
    }

    /**
     * Handle the Transfer "created" event in case a transfer is created
     * already with status 'completed'.
     */
    public function created(Transfer $transfer): void
    {
        if ($transfer->status === 'completed') {
            $this->markUnlockIfNeeded($transfer);
        }
    }

    /**
     * Shared logic to locate an UnlockCode related to a transfer or compte
     * and mark it as used if appropriate.
     */
    private function markUnlockIfNeeded(Transfer $transfer): void
    {
        try {
            // Prefer unlock codes directly linked to this transfer
            $unlock = UnlockCode::where('transfer_id', $transfer->id)->latest()->first();

            // Fallback: try to find by compte_id if transfer relation was not set on the unlock
            if (! $unlock && ! empty($transfer->compte_id)) {
                $unlock = UnlockCode::where('compte_id', $transfer->compte_id)
                    ->whereNull('used_at')
                    ->latest()
                    ->first();
            }

            if ($unlock && ! $unlock->used_at) {
                $unlock->markAsUsed();
                Log::info('TransferObserver: marked UnlockCode as used because transfer completed', [
                    'transfer_id' => $transfer->id,
                    'unlock_id' => $unlock->id,
                    'compte_id' => $transfer->compte_id ?? null,
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('TransferObserver error while marking unlock code used: ' . $e->getMessage(), ['transfer_id' => $transfer->id]);
        }
    }
}
