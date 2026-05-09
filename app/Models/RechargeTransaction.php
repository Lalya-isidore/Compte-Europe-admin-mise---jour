<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RechargeTransaction extends Model
{
    protected $fillable = [
        'user_id',
        'compte_id',
        'transaction_id',
        'amount',
        'credits_earned',
        'payment_method',
        'payment_provider',
        'status',
        'external_transaction_id',
        'payment_details',
        'response_data',
        'failure_reason',
        'completed_at'
    ];

    protected $casts = [
        'payment_details' => 'array',
        'response_data' => 'array',
        'amount' => 'decimal:2',
        'completed_at' => 'datetime',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function compte()
    {
        return $this->belongsTo(Compte::class);
    }

    // Générer un ID de transaction unique
    public static function generateTransactionId()
    {
        do {
            $id = 'RC' . strtoupper(Str::random(8)) . time();
        } while (self::where('transaction_id', $id)->exists());
        
        return $id;
    }

    // Calculer les crédits basés sur le montant
    public static function calculateCredits($amount)
    {
        // Logique de calcul des crédits selon les paliers
        $creditRates = [
            100 => 100,      // 100 F CFA = 100 crédits
            1500 => 1000,    // 1500 F CFA = 1000 crédits
            3000 => 2000,    // 3000 F CFA = 2000 crédits
            5000 => 5000,    // 5000 F CFA = 5000 crédits (+0%)
            10000 => 15000,  // 10000 F CFA = 15000 crédits (+50%)
            15000 => 25000,  // 15000 F CFA = 25000 crédits (+67%)
            20000 => 35000,  // 20000 F CFA = 35000 crédits (+75%)
            25000 => 40000,  // 25000 F CFA = 40000 crédits (+60%)
            50000 => 100000, // 50000 F CFA = 100000 crédits (+100%)
        ];

        return $creditRates[$amount] ?? $amount; // Retourner le montant si pas de bonus
    }

    // Scopes pour les requêtes fréquentes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeByPaymentMethod($query, $method)
    {
        return $query->where('payment_method', $method);
    }
}
