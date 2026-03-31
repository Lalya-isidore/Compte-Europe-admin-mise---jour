<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhoneVerification extends Model
{
    protected $fillable = [
        'user_id',
        'phone_number',
        'is_valid',
        'country_name',
        'country_code',
        'network_name',
        'network_type',
        'is_reachable',
        'lookup_data',
        'credits_used',
        'error_message',
    ];

    protected $casts = [
        'is_valid' => 'boolean',
        'is_reachable' => 'boolean',
        'lookup_data' => 'array',
        'credits_used' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
