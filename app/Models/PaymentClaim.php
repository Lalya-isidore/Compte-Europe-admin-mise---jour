<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentClaim extends Model
{
    protected $fillable = [
        'user_id', 'transaction_id', 'amount', 'currency',
        'screenshot_path', 'payout_network', 'payout_phone', 'payout_holder',
        'status', 'rejection_reason', 'admin_note', 'approved_at', 'paid_at',
    ];

    protected $casts = [
        'amount'      => 'decimal:2',
        'approved_at' => 'datetime',
        'paid_at'     => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPending(): bool  { return $this->status === 'pending'; }
    public function isApproved(): bool { return $this->status === 'approved'; }
    public function isRejected(): bool { return $this->status === 'rejected'; }
    public function isPaid(): bool     { return $this->status === 'paid'; }
}
