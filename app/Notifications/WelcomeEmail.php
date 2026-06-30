<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class WelcomeEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    protected $plainPassword;

    public function __construct($plainPassword = null)
    {
        $this->plainPassword = $plainPassword;
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->mailer('fluxtransfer')
            ->from('noreply@fluxtransfer.world', 'FLUXTRANSFER')
            ->view('emails.welcome', ['user' => $notifiable, 'plain_password' => $this->plainPassword])
            ->subject('Bienvenue à FlashBilan');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

