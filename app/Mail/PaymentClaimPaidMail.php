<?php

namespace App\Mail;

use App\Models\PaymentClaim;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentClaimPaidMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailer = 'fluxtransfer';

    public function __construct(public PaymentClaim $claim) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('noreply@fluxtransfer.world', 'FLUXTRANSFER'),
            subject: 'Votre virement mobile money a été effectué',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-claim-paid',
            with: ['claim' => $this->claim],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
