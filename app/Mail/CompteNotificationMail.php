<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompteNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailer = 'flashbilan';

    public $compte;
    public string $titre;
    public string $notifMessage;

    public function __construct($compte, string $titre, string $notifMessage)
    {
        $this->compte        = $compte;
        $this->titre         = $titre;
        $this->notifMessage  = $notifMessage;
    }

    public function build()
    {
        return $this->from('noreply@flashbilan.fr', 'FlashBilan')
                    ->subject($this->titre)
                    ->view('emails.compteNotification')
                    ->with([
                        'compte'        => $this->compte,
                        'titre'         => $this->titre,
                        'notifMessage'  => $this->notifMessage,
                    ]);
    }
}
