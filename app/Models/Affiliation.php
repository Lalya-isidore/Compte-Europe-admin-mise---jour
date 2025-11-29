<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Affiliation extends Model
{
    protected $fillable = [
        'user_id',
        'parrain_id',
        'code_affiliation',
        'commission_rate',
        'total_commissions',
        'total_parraines',
        'is_active',
        'settings'
    ];

    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
        'commission_rate' => 'decimal:2',
        'total_commissions' => 'decimal:2',
    ];

    // Relation avec l'utilisateur propriétaire
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec le parrain
    public function parrain()
    {
        return $this->belongsTo(User::class, 'parrain_id');
    }

    // Relation avec les commissions
    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }

    public function retraits(): HasMany
    {
        return $this->hasMany(Retrait::class);
    }

    // Générer un code d'affiliation unique
    public static function generateCodeAffiliation()
    {
        do {
            $code = 'AFF' . strtoupper(substr(md5(uniqid()), 0, 8));
        } while (self::where('code_affiliation', $code)->exists());
        
        return $code;
    }
}
