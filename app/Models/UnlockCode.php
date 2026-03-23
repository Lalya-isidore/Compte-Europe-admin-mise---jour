<?php
// app/Models/UnlockCode.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UnlockCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'compte_id',
        'transfer_id',
        'expires_at',
        'used_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    public function transfer()
    {
        return $this->belongsTo(Transfer::class);
    }

    public function compte()
    {
        return $this->belongsTo(Compte::class);
    }

    public static function generateCode()
    {
        // Génère un code de 8 caractères (chiffres uniquement)
        return str_pad(random_int(0, 99999999), 8, '0', STR_PAD_LEFT);
    }

    public static function createForCompte(Compte $compte, ?Transfer $transfer = null, array $attributes = [])
    {
        static::invalidateActiveCodes($compte->id);

        $payload = $attributes;
        $payload['code'] = $payload['code'] ?? static::generateCode();
        $payload['compte_id'] = $compte->id;
        $payload['transfer_id'] = $payload['transfer_id'] ?? $transfer?->id;
        $payload['expires_at'] = array_key_exists('expires_at', $payload)
            ? $payload['expires_at']
            : now()->addMinutes(30);

        return static::create($payload);
    }

    public static function snapshotCompteCode(Compte $compte, ?Transfer $transfer = null)
    {
        if (empty($compte->code_virement)) {
            return null;
        }

        return static::createForCompte($compte, $transfer, [
            'code' => $compte->code_virement,
            'expires_at' => null,
        ]);
    }

    protected static function invalidateActiveCodes(int $compteId): void
    {
        static::where('compte_id', $compteId)
            ->whereNull('used_at')
            ->update(['expires_at' => now()]);
    }

    public function isValid()
    {
        return !$this->used_at && 
               $this->expires_at->isFuture();
    }

    public function markAsUsed()
    {
        $this->used_at = now();
        $this->save();
    }
}
