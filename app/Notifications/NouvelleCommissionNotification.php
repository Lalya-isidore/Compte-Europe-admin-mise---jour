<?php

namespace App\Notifications;

use App\Models\Commission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NouvelleCommissionNotification extends Notification
{
    use Queueable;

    public $commission;

    /**
     * Create a new notification instance.
     */
    public function __construct(Commission $commission)
    {
        $this->commission = $commission;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $filleul = $this->commission->filleul;
        $montant = number_format($this->commission->montant_commission, 2);

        return (new MailMessage)
            ->subject('🎉 Nouvelle commission de parrainage - FlashCompte')
            ->greeting('Félicitations ' . $notifiable->prenom . ' !')
            ->line("Vous avez reçu une nouvelle commission de **{$montant} F CFA** grâce à votre programme d'affiliation.")
            ->line("**Détails de la commission :**")
            ->line("• Filleul : {$filleul->prenom} {$filleul->nom}")
            ->line("• Type d'action : " . ucfirst(str_replace('_', ' ', $this->commission->action_type)))
            ->line("• Montant : {$montant} F CFA")
            ->line("• Date : " . $this->commission->created_at->format('d/m/Y à H:i'))
            ->action('Voir mes commissions', route('affiliation.index'))
            ->line('Continuez à partager votre lien de parrainage pour gagner plus de commissions!')
            ->line('Merci d\'utiliser FlashCompte !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'commission_id' => $this->commission->id,
            'montant' => $this->commission->montant_commission,
            'action_type' => $this->commission->action_type,
            'filleul_nom' => $this->commission->filleul->nom ?? 'Inconnu',
            'filleul_prenom' => $this->commission->filleul->prenom ?? 'Inconnu',
        ];
    }
}
