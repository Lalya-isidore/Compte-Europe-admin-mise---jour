<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoyaltyBonusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailer = 'fluxtransfer';

    public $user;
    public $bonusCredits;

    public function __construct($user, $bonusCredits = 5000)
    {
        $this->user = $user;
        $this->bonusCredits = $bonusCredits;
    }

    public function build()
    {
        return $this->from('noreply@fluxtransfer.world', 'FLASHBILAN')
                    ->view('emails.loyaltyBonus')
                    ->subject('🎁 Bonus Fidélité – ' . number_format($this->bonusCredits, 0, ',', ' ') . ' crédits offerts !')
                    ->with([
                        'user' => $this->user,
                        'bonusCredits' => $this->bonusCredits,
                    ]);
    }
}
