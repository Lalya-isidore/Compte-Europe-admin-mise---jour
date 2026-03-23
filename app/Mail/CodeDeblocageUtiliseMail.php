<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use App\Models\Compte;

class CodeDeblocageUtiliseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $compte;
    public $transferDetails;

    /**
     * Create a new message instance.
     */
    public function __construct(Compte $compte, $transferDetails = null)
    {
        $this->compte = $compte;
        $this->transferDetails = $transferDetails;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('fluxbank37@gmail.com', 'TRANSFERFLUX'),
            subject: __('emails.unlock_code_used_title'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.codeDeblocageUtilise',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
