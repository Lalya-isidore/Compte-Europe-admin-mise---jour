<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlatformVisit extends Model
{
    protected $fillable = ['user_id', 'ip_address', 'location', 'url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
