<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use App\Models\Compte;
use App\Models\Transfer;

class VirementEchecMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    public $compte;
    public $transfer;

    /**
     * Create a new message instance.
     */
    public function __construct($details, Compte $compte, Transfer $transfer)
    {
        $this->details = $details;
        $this->compte = $compte;
        $this->transfer = $transfer;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('noreply@FlashBilan.com', 'FlashBilan'),
            subject: __('emails.virement_failed_subject'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.VirementEchecMail',
            with: [
                'details' => $this->details,
                'compte' => $this->compte,
                'transfer' => $this->transfer,
            ],
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

