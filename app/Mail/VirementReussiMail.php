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

class VirementReussiMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailer = 'fluxtransfer';

    public $details;
    public $compte;
    public $transfer;

    public function __construct($details, Compte $compte, Transfer $transfer)
    {
        $this->details = $details;
        $this->compte = $compte;
        $this->transfer = $transfer;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('noreply@fluxtransfer.world', 'FLUXTRANSFER'),
            subject: __('emails.virement_success_subject'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.VirementReussiMail',
            with: [
                'details' => $this->details,
                'compte' => $this->compte,
                'transfer' => $this->transfer,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
