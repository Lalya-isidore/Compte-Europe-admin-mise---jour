<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UrlShortener extends Model
{
    protected $table = 'url_shortener_history';

    protected $fillable = [
        'user_id',
        'original_url',
        'short_url',
        'provider',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
