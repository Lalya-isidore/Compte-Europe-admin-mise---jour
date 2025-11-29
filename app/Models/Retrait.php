<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Retrait extends Model
{
    protected $fillable = [
        'user_id',
        'affiliation_id',
        'montant',
        'operateur',
        'numero_telephone',
        'statut',
        'date_demande',
        'date_traitement',
        'commentaire',
        'details',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'date_demande' => 'datetime',
        'date_traitement' => 'datetime',
        'details' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function affiliation(): BelongsTo
    {
        return $this->belongsTo(Affiliation::class);
    }

    public function getOperateurNomAttribute(): string
    {
        return match($this->operateur) {
            'mtn_benin' => 'MTN Bénin',
            'moov_benin' => 'Moov Bénin',
            'orange_burkina' => 'Orange Money Burkina Faso',
            'mtn_ci' => 'MTN Côte d\'Ivoire',
            'moov_ci' => 'Moov Côte d\'Ivoire',
            'orange_ci' => 'Orange Money Côte d\'Ivoire',
            'wave_ci' => 'Wave Côte d\'Ivoire',
            'orange_mali' => 'Orange Money Mali',
            'tmoney_togo' => 'T-Money Togo',
            'moov_togo' => 'Moov Togo',
            'orange_senegal' => 'Orange Money Sénégal',
            'free_senegal' => 'Free Money Sénégal',
            'emoney_senegal' => 'E-Money Sénégal',
            'wave_senegal' => 'Wave Sénégal',
            default => $this->operateur,
        };
    }

    public function getStatutColorAttribute(): string
    {
        return match($this->statut) {
            'en_attente' => 'warning',
            'en_cours' => 'info',
            'traite' => 'success',
            'annule' => 'danger',
            default => 'secondary',
        };
    }
}
