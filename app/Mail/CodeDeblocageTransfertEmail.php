<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use App\Models\Compte; // Assurez-vous d'importer le modèle Compte
use App\Models\Transfer;

class CodeDeblocageTransfertEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    public $transfer;
    public $compte; // Ajoutez cette ligne

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details, Compte $compte) // Modifiez le constructeur pour accepter le compte
    {
        $this->details = $details;
        $this->compte = $compte; // Initialisez la propriété
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('fluxbank37@gmail.com', 'TRANSFERFLUX'),
            subject: __('emails.transfer_unlock_code_title'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.CodeDeblocageTransfertEmail',
            with: [
                'details' => $this->details,
                'compte' => $this->compte, // Passez le compte à la vue
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
