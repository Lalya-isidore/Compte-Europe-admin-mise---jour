<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MassNotification extends Mailable
{
    use Queueable, SerializesModels;

    public string $emailSubject;
    public string $emailMessage;
    public User $user;

    public function __construct(string $subject, string $message, User $user)
    {
        $this->emailSubject = $subject;
        $this->emailMessage = $message;
        $this->user = $user;
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->emailSubject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.mass-notification',
            with: [
                'emailMessage' => $this->emailMessage,
                'user' => $this->user,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
