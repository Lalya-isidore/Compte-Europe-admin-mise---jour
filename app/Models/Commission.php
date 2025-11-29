<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $fillable = [
        'affiliation_id',
        'parraine_user_id',
        'compte_id',
        'action_type',
        'montant_base',
        'taux_commission',
        'montant_commission',
        'statut',
        'date_action',
        'date_validation',
        'details'
    ];

    protected $casts = [
        'details' => 'array',
        'montant_base' => 'decimal:2',
        'taux_commission' => 'decimal:2',
        'montant_commission' => 'decimal:2',
        'date_action' => 'datetime',
        'date_validation' => 'datetime',
    ];

    // Relations
    public function affiliation()
    {
        return $this->belongsTo(Affiliation::class);
    }

    public function parrainneUser()
    {
        return $this->belongsTo(User::class, 'parraine_user_id');
    }

    public function filleul()
    {
        return $this->belongsTo(User::class, 'parraine_user_id');
    }

    public function compte()
    {
        return $this->belongsTo(Compte::class);
    }
}
