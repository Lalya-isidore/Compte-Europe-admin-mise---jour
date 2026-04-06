<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SoldeDiminue extends Mailable
{
    use Queueable, SerializesModels;

    public $mailer = 'fluxtransfer';

    public $montant;
    public $compte;

    public function __construct($compte, $montant)
    {
        $this->compte = $compte;
        $this->montant = $montant;
    }

    public function build()
    {
        return $this->from('noreply@fluxtransfer.world', 'FLUXTRANSFER')
                    ->view('emails.soldeDiminue')
                    ->subject(__('emails.balance_decreased_title'))
                    ->with([
                        'compte' => $this->compte,
                        'montant' => $this->montant,
                    ]);
    }
}
