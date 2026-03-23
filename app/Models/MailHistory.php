<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailHistory extends Model
{
    protected $table = 'mail_history';

    protected $fillable = [
        'user_id',
        'expediteur',
        'destinataire',
        'objet',
        'contenu',
        'adresse_reponse',
        'fichier_joint',
        'credits_used',
        'status',
        'message_id',
        'error_message',
        'opened_at',
        'open_count'
    ];

    protected $casts = [
        'opened_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
