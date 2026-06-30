<?php

namespace App\Mail;

use App\Models\PaymentClaim;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentClaimRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailer = 'fluxtransfer';

    public function __construct(public PaymentClaim $claim) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('noreply@fluxtransfer.world', 'FLUXTRANSFER'),
            subject: 'Votre demande de paiement a été rejetée',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-claim-rejected',
            with: ['claim' => $this->claim],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
