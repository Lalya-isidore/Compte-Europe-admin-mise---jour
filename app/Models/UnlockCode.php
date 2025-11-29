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

    public static function createForCompte(Compte $compte, ?Transfer $transfer = null)
    {
        // Invalider les anciens codes non utilisés pour ce compte
        static::where('compte_id', $compte->id)
            ->whereNull('used_at')
            ->update(['expires_at' => now()]);

        // Créer un nouveau code valide pour 30 minutes
        return static::create([
            'code' => static::generateCode(),
            'compte_id' => $compte->id,
            'transfer_id' => $transfer?->id,
            'expires_at' => now()->addMinutes(30),
        ]);
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
