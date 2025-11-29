<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupportMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'support_ticket_id',
        'user_id',
        'sent_by_admin',
        'content',
        'read_at',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'voice_path',
    ];

    protected $casts = [
        'sent_by_admin' => 'boolean',
        'read_at' => 'datetime',
    ];

    protected $appends = [
        'attachment_url',
        'voice_url',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(SupportTicket::class, 'support_ticket_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getAttachmentUrlAttribute(): ?string
    {
        return $this->file_path ? asset('storage/' . ltrim($this->file_path, '/')) : null;
    }

    public function getVoiceUrlAttribute(): ?string
    {
        return $this->voice_path ? asset('storage/' . ltrim($this->voice_path, '/')) : null;
    }
}
