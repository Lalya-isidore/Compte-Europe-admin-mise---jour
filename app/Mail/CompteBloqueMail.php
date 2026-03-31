<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use App\Models\Compte;

class CompteBloqueMail extends Mailable
{
    use Queueable, SerializesModels;

    public $compte;

    /**
     * Create a new message instance.
     */
    public function __construct(Compte $compte)
    {
        $this->compte = $compte;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('emails.account_blocked_title') . ' - ' . __('emails.footer_brand'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.compteBloque',
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
