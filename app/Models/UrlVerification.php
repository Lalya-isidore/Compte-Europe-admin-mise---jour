<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrlVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'domain',
        'lookup_status',
        'registrar',
        'expires_at',
        'lookup_data',
        'error_message',
    ];

    protected $casts = [
        'lookup_data' => 'array',
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
