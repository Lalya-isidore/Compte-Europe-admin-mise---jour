<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IbanVerification extends Model
{
    protected $fillable = [
        'user_id', 'type', 'number_masked', 'is_valid',
        'country', 'bank_name', 'bic_code',
        'card_brand', 'card_type', 'lookup_data',
        'credits_used', 'error_message',
    ];

    protected $casts = [
        'is_valid' => 'boolean',
        'lookup_data' => 'array',
        'credits_used' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
