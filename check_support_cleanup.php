<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\SupportTicket;
use App\Models\SupportMessage;

echo "\n========================================\n";
echo "STATISTIQUES SUPPORT - NETTOYAGE AUTO\n";
echo "========================================\n\n";

// Total des tickets
$totalTickets = SupportTicket::count();
$totalMessages = SupportMessage::count();

echo "📊 TOTAL ACTUEL\n";
echo "  Tickets : {$totalTickets}\n";
echo "  Messages : {$totalMessages}\n\n";

// Par période
$periods = [
    ['label' => 'Moins de 24h', 'hours' => 24],
    ['label' => 'Entre 1 et 3 jours', 'min_days' => 1, 'max_days' => 3],
    ['label' => 'Entre 3 et 7 jours', 'min_days' => 3, 'max_days' => 7],
    ['label' => 'Plus de 7 jours', 'min_days' => 7],
    ['label' => 'Plus de 30 jours', 'min_days' => 30],
];

echo "📅 RÉPARTITION PAR PÉRIODE\n";
echo "----------------------------------------\n";

foreach ($periods as $period) {
    if (isset($period['hours'])) {
        $count = SupportTicket::where('created_at', '>=', now()->subHours($period['hours']))->count();
        $messages = SupportMessage::whereHas('ticket', function($q) use ($period) {
            $q->where('created_at', '>=', now()->subHours($period['hours']));
        })->count();
    } elseif (isset($period['max_days'])) {
        $count = SupportTicket::whereBetween('created_at', [
            now()->subDays($period['max_days']),
            now()->subDays($period['min_days'])
        ])->count();
        $messages = SupportMessage::whereHas('ticket', function($q) use ($period) {
            $q->whereBetween('created_at', [
                now()->subDays($period['max_days']),
                now()->subDays($period['min_days'])
            ]);
        })->count();
    } else {
        $count = SupportTicket::where('created_at', '<', now()->subDays($period['min_days']))->count();
        $messages = SupportMessage::whereHas('ticket', function($q) use ($period) {
            $q->where('created_at', '<', now()->subDays($period['min_days']));
        })->count();
    }
    
    echo "  {$period['label']}: {$count} ticket(s), {$messages} message(s)\n";
}

echo "\n";

// Tickets qui seront supprimés
$toDelete = SupportTicket::where('created_at', '<', now()->subDays(7))->count();
$messagesToDelete = SupportMessage::whereHas('ticket', function($q) {
    $q->where('created_at', '<', now()->subDays(7));
})->count();

if ($toDelete > 0) {
    echo "🗑️  PROCHAINE SUPPRESSION AUTOMATIQUE (>7 jours)\n";
    echo "  ⚠️  {$toDelete} ticket(s) seront supprimés\n";
    echo "  ⚠️  {$messagesToDelete} message(s) seront supprimés\n";
    echo "  ⏰ Exécution : Tous les jours à 3h du matin\n\n";
    
    echo "Pour supprimer manuellement maintenant :\n";
    echo "  php artisan support:clean-old --force\n\n";
} else {
    echo "✅ Aucun ticket à supprimer pour le moment\n\n";
}

// Statut par ticket
echo "📋 DÉTAILS DES TICKETS\n";
echo "----------------------------------------\n";

$tickets = SupportTicket::with('user')->orderBy('created_at', 'desc')->get();

if ($tickets->isEmpty()) {
    echo "  Aucun ticket trouvé\n";
} else {
    foreach ($tickets as $ticket) {
        $age = now()->diffInDays($ticket->created_at);
        $messageCount = $ticket->messages()->count();
        $status = $age >= 7 ? '🔴 À supprimer' : ($age >= 3 ? '🟠 Bientôt supprimé' : '🟢 Récent');
        
        echo "\n  Ticket #{$ticket->id}\n";
        echo "    Sujet : {$ticket->subject}\n";
        echo "    Utilisateur : " . ($ticket->user ? $ticket->user->name : 'Inconnu') . "\n";
        echo "    Créé le : " . $ticket->created_at->format('d/m/Y H:i') . " ({$age} jour(s))\n";
        echo "    Messages : {$messageCount}\n";
        echo "    Statut : {$ticket->status}\n";
        echo "    {$status}\n";
    }
}

echo "\n========================================\n\n";
