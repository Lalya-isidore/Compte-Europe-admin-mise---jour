<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SoldeDiminue extends Mailable
{
    use Queueable, SerializesModels;

    public $montant;
    public $compte;

    public function __construct($compte, $montant)
    {
        $this->compte = $compte;
        $this->montant = $montant;
    }

    public function build()
    {
        return $this->from('fluxbank37@gmail.com', 'TRANSFERFLUX')
                    ->view('emails.soldeDiminue')
                    ->subject('Votre solde a été diminué - TRANSFERFLUX')
                    ->with([
                        'compte' => $this->compte,
                        'montant' => $this->montant,
                    ]);
    }
}
