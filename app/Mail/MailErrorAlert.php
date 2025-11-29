<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailErrorAlert extends Mailable
{
    use Queueable, SerializesModels;

    public $errorDetails;
    public $failedRecipient;
    public $context;
    public $errorMessage;

    /**
     * Create a new message instance.
     */
    public function __construct($errorDetails, $failedRecipient, $context, $errorMessage)
    {
        $this->errorDetails = $errorDetails;
        $this->failedRecipient = $failedRecipient;
        $this->context = $context;
        $this->errorMessage = $errorMessage;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('⚠️ ALERTE: Échec d\'envoi d\'email - TRANSFERFLUX')
                    ->view('emails.mail-error-alert');
    }
}
