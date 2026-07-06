<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class MassNotification extends Mailable
{
    use Queueable, SerializesModels;

    public string $emailSubject;
    public string $emailMessage;
    public User $user;
    public ?string $bannerUrl;

    public function __construct(string $subject, string $message, User $user, ?string $bannerUrl = null)
    {
        $this->emailSubject = $subject;
        $this->emailMessage = $message;
        $this->user = $user;
        $this->bannerUrl = $bannerUrl;
    }

    public $mailer = 'flashbilan';

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('noreply@flashbilan.fr', 'FlashBilan'),
            subject: $this->emailSubject
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.mass-notification',
            with: [
                'emailMessage' => $this->emailMessage,
                'user' => $this->user,
                'bannerUrl' => $this->bannerUrl,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
