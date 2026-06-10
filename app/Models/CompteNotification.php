<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompteNotification extends Model
{
    protected $table = 'compte_notifications';

    protected $fillable = [
        'compte_id',
        'user_id',
        'titre',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function compte()
    {
        return $this->belongsTo(Compte::class);
    }
}
