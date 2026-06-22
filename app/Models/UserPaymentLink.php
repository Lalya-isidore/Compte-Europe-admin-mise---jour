<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPaymentLink extends Model
{
    protected $fillable = ['user_id', 'currency'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
