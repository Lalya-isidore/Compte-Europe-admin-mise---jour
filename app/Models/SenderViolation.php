<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SenderViolation extends Model
{
    protected $fillable = ['user_id', 'expediteur', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
}
