<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmsHistory extends Model
{
    protected $table = 'sms_history';

    protected $fillable = [
        'user_id',
        'expediteur',
        'pays',
        'destinataire',
        'message',
        'sms_count',
        'credits_used',
        'status',
        'message_id',
        'error_message',
        'twilio_sid',
        'delivery_status',
        'error_code',
        'fallback_sent',
        'fallback_sid',
        'retry_after',
    ];

    protected $casts = [
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
        'retry_after'   => 'datetime',
        'fallback_sent' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'Livré' => 'success',
            'En attente' => 'warning',
            'Rejeté' => 'danger',
            'Échec' => 'danger',
            default => 'secondary',
        };
    }
}
