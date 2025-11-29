<?php

namespace App\Console\Commands;

use App\Models\SupportTicket;
use App\Models\SupportMessage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CleanOldSupportTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'support:clean-old
                          {--days=7 : Nombre de jours avant suppression}
                          {--force : Supprimer sans confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Nettoie les tickets de support et leurs messages de plus de X jours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = (int) $this->option('days');
        $force = $this->option('force');

        $cutoffDate = now()->subDays($days);

        $this->info("🧹 Nettoyage des conversations de support");
        $this->info("📅 Suppression des tickets créés avant le : " . $cutoffDate->format('d/m/Y H:i'));
        $this->newLine();

        // Compter les tickets concernés
        $ticketsCount = SupportTicket::where('created_at', '<', $cutoffDate)->count();
        
        if ($ticketsCount === 0) {
            $this->info("✅ Aucun ticket à supprimer.");
            return Command::SUCCESS;
        }

        // Compter les messages concernés
        $messagesCount = SupportMessage::whereHas('ticket', function($query) use ($cutoffDate) {
            $query->where('created_at', '<', $cutoffDate);
        })->count();

        $this->warn("📊 Tickets à supprimer : {$ticketsCount}");
        $this->warn("📊 Messages à supprimer : {$messagesCount}");
        $this->newLine();

        // Confirmation
        if (!$force && !$this->confirm('⚠️  Voulez-vous vraiment supprimer ces conversations ?')) {
            $this->info('❌ Opération annulée.');
            return self::INVALID;
        }

        try {
            DB::beginTransaction();

            // Récupérer les IDs des tickets à supprimer
            $ticketIds = SupportTicket::where('created_at', '<', $cutoffDate)
                ->pluck('id')
                ->toArray();

            if (empty($ticketIds)) {
                $this->info("✅ Aucun ticket à supprimer.");
                DB::rollBack();
                return Command::SUCCESS;
            }

            // Supprimer d'abord tous les messages associés
            $deletedMessages = SupportMessage::whereIn('ticket_id', $ticketIds)->delete();
            $this->info("✓ Messages supprimés : {$deletedMessages}");

            // Puis supprimer les tickets
            $deletedTickets = SupportTicket::whereIn('id', $ticketIds)->delete();
            $this->info("✓ Tickets supprimés : {$deletedTickets}");

            DB::commit();

            // Log l'opération
            Log::info('Nettoyage automatique des tickets de support', [
                'days' => $days,
                'cutoff_date' => $cutoffDate->toDateTimeString(),
                'tickets_deleted' => $deletedTickets,
                'messages_deleted' => $deletedMessages,
            ]);

            $this->newLine();
            $this->info("✅ Nettoyage terminé avec succès !");
            $this->info("📦 {$deletedTickets} ticket(s) et {$deletedMessages} message(s) supprimés");

            return Command::SUCCESS;

        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->error("❌ Erreur lors du nettoyage : " . $e->getMessage());
            
            Log::error('Erreur lors du nettoyage des tickets de support', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return Command::FAILURE;
        }
    }
}
