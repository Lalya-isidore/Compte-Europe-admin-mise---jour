<?php

namespace App\Mail;

use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class SupportUserReply extends Mailable
{
    use Queueable, SerializesModels;

    public SupportTicket $ticket;
    public SupportMessage $supportMessage;

    public function __construct(SupportTicket $ticket, SupportMessage $supportMessage)
    {
        $this->ticket = $ticket;
        $this->supportMessage = $supportMessage;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), 'FlashBilan'),
            subject: 'Réponse à votre demande #' . $this->ticket->id . ' — ' . $this->ticket->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.support-reply',
            with: [
                'ticket' => $this->ticket,
                'supportMessage' => $this->supportMessage,
                'user' => $this->ticket->user,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
