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

class SupportAdminNotification extends Mailable
{
    use Queueable, SerializesModels;

    public SupportTicket $ticket;
    public SupportMessage $supportMessage;
    public string $type;

    public function __construct(SupportTicket $ticket, SupportMessage $supportMessage, string $type = 'new_ticket')
    {
        $this->ticket = $ticket;
        $this->supportMessage = $supportMessage;
        $this->type = $type;
    }

    public function envelope(): Envelope
    {
        $subject = $this->type === 'new_ticket'
            ? '[Support] Nouveau ticket #' . $this->ticket->id . ' — ' . $this->ticket->subject
            : '[Support] Nouveau message sur le ticket #' . $this->ticket->id;

        return new Envelope(
            from: new Address(config('mail.from.address'), 'FlashBilan'),
            subject: $subject
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-notification',
            with: [
                'ticket' => $this->ticket,
                'supportMessage' => $this->supportMessage,
                'type' => $this->type,
                'user' => $this->ticket->user,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
