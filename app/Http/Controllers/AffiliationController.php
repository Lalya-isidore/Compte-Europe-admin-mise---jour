<?php

namespace App\Http\Controllers;

use App\Models\Affiliation;
use App\Models\Commission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AffiliationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $affiliation = $user->affiliation;
        
        if (!$affiliation) {
            // Créer une affiliation automatiquement
            $affiliation = Affiliation::create([
                'user_id' => $user->id,
                'code_affiliation' => Affiliation::generateCodeAffiliation(),
                'commission_rate' => 5.00,
            ]);
        }
        
        $commissions = $affiliation->commissions()
            ->with(['filleul'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        $stats = [
            'total_parraines' => $affiliation->total_parraines,
            'total_commissions' => $affiliation->commissions()->where('statut', 'valide')->sum('montant_commission'), // Seulement les gains disponibles
            'commissions_en_attente' => $affiliation->commissions()->where('statut', 'en_attente')->sum('montant_commission'),
            'commissions_ce_mois' => $affiliation->commissions()
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('montant_commission'),
        ];
        
        return view('affiliation.index', compact('affiliation', 'commissions', 'stats'));
    }
    
    public function activate()
    {
        $user = Auth::user();
        
        if (!$user->affiliation) {
            $affiliation = Affiliation::create([
                'user_id' => $user->id,
                'code_affiliation' => Affiliation::generateCodeAffiliation(),
                'commission_rate' => 5.00,
            ]);
            
            return redirect()->route('affiliation.index')->with('success', 'Votre programme d\'affiliation a été activé !');
        }
        
        return redirect()->route('affiliation.index');
    }

    public function transferToBalance(Request $request)
    {
        $user = Auth::user();
        $affiliation = $user->affiliation;
        
        if (!$affiliation) {
            return redirect()->back()->with('error', 'Aucun programme d\'affiliation trouvé.');
        }

        // Calculer le montant disponible (commissions validées)
        $commissionsDisponibles = $affiliation->commissions()
            ->where('statut', 'valide')
            ->sum('montant_commission');

        if ($commissionsDisponibles <= 0) {
            return redirect()->back()->with('error', 'Aucune commission disponible pour le transfert.');
        }

        $montantDemande = $request->input('montant', $commissionsDisponibles);
        
        // Vérifier que le montant demandé est disponible
        if ($montantDemande > $commissionsDisponibles) {
            return redirect()->back()->with('error', 'Montant demandé supérieur aux commissions disponibles.');
        }

        try {
            $creditsGagnes = 0;
            
            \DB::transaction(function () use ($affiliation, $user, $montantDemande, &$creditsGagnes) {
                // Calculer les crédits selon les paliers de recharge
                $creditsGagnes = $this->calculateCreditsFromAmount($montantDemande);
                
                // Créditer les crédits utilisateur (credit_user)
                $creditsBefore = $user->credit_user ?? 0;
                $user->credit_user = $creditsBefore + $creditsGagnes;
                $user->save();

                // Marquer les commissions comme payées
                $commissions = $affiliation->commissions()
                    ->where('statut', 'valide')
                    ->orderBy('created_at', 'asc')
                    ->get();

                $montantRestant = $montantDemande;
                foreach ($commissions as $commission) {
                    if ($montantRestant <= 0) break;
                    
                    if ($commission->montant_commission <= $montantRestant) {
                        $commission->update([
                            'statut' => 'paye',
                            'date_validation' => now()
                        ]);
                        $montantRestant -= $commission->montant_commission;
                    }
                }

                // Créer un historique de la transaction (si l'utilisateur a un compte)
                $comptePrincipal = $user->comptes()->where('is_default', true)->first();
                if ($comptePrincipal) {
                    \App\Models\TransactionHistory::create([
                        'user_id' => $user->id,
                        'compte_id' => $comptePrincipal->id,
                        'transaction_type' => 'Transfert Affiliation',
                        'amount' => $montantDemande,
                        'description' => "Transfert gains d'affiliation : {$montantDemande} F CFA → {$creditsGagnes} crédits FlashBilan",
                        'devise' => 'F CFA',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                
                // Log
                \Log::info('Transfert gains affiliation vers crédits', [
                    'user_id' => $user->id,
                    'montant_fcfa' => $montantDemande,
                    'credits_gagnes' => $creditsGagnes,
                    'credits_before' => $creditsBefore,
                    'credits_after' => $user->credit_user
                ]);
            });

            return redirect()->back()->with('success', 
                sprintf('%.0f F CFA transférés avec succès ! Vous avez reçu %s crédits FlashBilan.', 
                    $montantDemande, 
                    number_format($creditsGagnes, 0, ',', ' ')
                ));
                
        } catch (\Exception $e) {
            \Log::error('Erreur transfert gains affiliation', [
                'user_id' => $user->id ?? null,
                'error' => $e->getMessage()
            ]);
            return redirect()->back()->with('error', 'Erreur lors du transfert : ' . $e->getMessage());
        }
    }
    
    /**
     * Calculer les crédits basés sur le montant avec la même logique que les recharges
     */
    private function calculateCreditsFromAmount($montant)
    {
        // Utiliser les paliers de recharge standards
        $paliers = [
            50000 => 100000,  // 50 000 F = 100 000 crédits (+100%)
            25000 => 40000,   // 25 000 F = 40 000 crédits (+60%)
            10000 => 15000,   // 10 000 F = 15 000 crédits (+50%)
            5000 => 5000,     // 5 000 F = 5 000 crédits (+0%)
            100 => 100,       // 100 F = 100 crédits (+0%)
        ];
        
        // Calculer les crédits par paliers
        $montantRestant = $montant;
        $totalCredits = 0;
        
        foreach ($paliers as $palierMontant => $palierCredits) {
            while ($montantRestant >= $palierMontant) {
                $totalCredits += $palierCredits;
                $montantRestant -= $palierMontant;
            }
        }
        
        // Pour le reste, appliquer un ratio de 1:1
        if ($montantRestant > 0) {
            $totalCredits += $montantRestant;
        }
        
        return $totalCredits;
    }

    public function validateCommission(Request $request, $commissionId)
    {
        $user = Auth::user();
        $commission = Commission::findOrFail($commissionId);
        
        // Vérifier que cette commission appartient à l'utilisateur connecté
        if ($commission->affiliation->user_id !== $user->id) {
            return redirect()->back()->with('error', 'Commission non trouvée.');
        }

        if ($commission->statut === 'en_attente') {
            $commission->update([
                'statut' => 'valide',
                'date_validation' => now()
            ]);

            return redirect()->back()->with('success', 'Commission validée avec succès !');
        }

        return redirect()->back()->with('error', 'Cette commission ne peut pas être validée.');
    }

    public function withdrawal(Request $request)
    {
        $request->validate([
            'montant' => 'required|numeric|min:5000',
            'operateur' => 'required|in:mtn_benin,moov_benin,orange_burkina,mtn_ci,moov_ci,orange_ci,wave_ci,orange_mali,tmoney_togo,moov_togo,orange_senegal,free_senegal,emoney_senegal,wave_senegal',
            'numero' => 'required|regex:/^[0-9]{8,}$/',
        ], [
            'montant.min' => 'Le montant minimum de retrait est de 5 000 F CFA',
            'numero.regex' => 'Le numéro doit contenir au moins 8 chiffres',
        ]);

        $user = Auth::user();
        $affiliation = $user->affiliation;

        if (!$affiliation) {
            return redirect()->back()->with('error', 'Affiliation non trouvée.');
        }

        $commissionsDisponibles = $affiliation->commissions()
            ->where('statut', 'valide')
            ->sum('montant_commission');

        if ($request->montant > $commissionsDisponibles) {
            return redirect()->back()->with('error', 'Montant supérieur aux commissions disponibles.');
        }

        if ($request->montant < 5000) {
            return redirect()->back()->with('error', 'Le montant minimum de retrait est de 5 000 F CFA.');
        }

        try {
            // Déterminer l'indicatif pays selon l'opérateur
            $indicatifs = [
                'mtn_benin' => '+229',
                'moov_benin' => '+229',
                'orange_burkina' => '+226',
                'mtn_ci' => '+225',
                'moov_ci' => '+225',
                'orange_ci' => '+225',
                'wave_ci' => '+225',
                'orange_mali' => '+223',
                'tmoney_togo' => '+228',
                'moov_togo' => '+228',
                'orange_senegal' => '+221',
                'free_senegal' => '+221',
                'emoney_senegal' => '+221',
                'wave_senegal' => '+221',
            ];
            
            $indicatif = $indicatifs[$request->operateur] ?? '+229';
            
            // Créer une demande de retrait
            $retrait = \App\Models\Retrait::create([
                'user_id' => $user->id,
                'affiliation_id' => $affiliation->id,
                'montant' => $request->montant,
                'operateur' => $request->operateur,
                'numero_telephone' => $indicatif . $request->numero,
                'statut' => 'en_attente',
                'date_demande' => now(),
            ]);

            // Marquer les commissions comme "en_cours_de_retrait"
            $montantRestant = $request->montant;
            $commissions = $affiliation->commissions()
                ->where('statut', 'valide')
                ->orderBy('created_at', 'asc')
                ->get();

            foreach ($commissions as $commission) {
                if ($montantRestant <= 0) break;

                if ($commission->montant_commission <= $montantRestant) {
                    $commission->update(['statut' => 'en_cours_de_retrait']);
                    $montantRestant -= $commission->montant_commission;
                } else {
                    // Gérer le cas où une commission doit être partiellement utilisée
                    // Pour simplifier, on évite ce cas en traitant les retraits par commission complète
                    break;
                }
            }

            // Log de la demande
            \Log::info('Demande de retrait créée', [
                'user_id' => $user->id,
                'montant' => $request->montant,
                'operateur' => $request->operateur,
                'numero' => $request->numero
            ]);

            return redirect()->back()->with('success', 
                'Demande de retrait envoyée avec succès ! Vous serez contacté sous 24h pour finaliser le retrait.');

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la demande de retrait', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 
                'Erreur lors de la demande de retrait. Veuillez réessayer.');
        }
    }

    /**
     * Supprimer l'historique des gains/commissions
     */
    public function clearHistory()
    {
        try {
            $user = Auth::user();
            $affiliation = $user->affiliation;

            if (!$affiliation) {
                return redirect()->back()->with('error', 'Aucune affiliation trouvée.');
            }

            // Supprimer toutes les commissions de l'utilisateur
            $deletedCount = $affiliation->commissions()->delete();

            return redirect()->back()->with('success', 
                "L'historique des gains a été supprimé avec succès ! ({$deletedCount} entrée(s) supprimée(s))");

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la suppression de l\'historique', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 
                'Erreur lors de la suppression de l\'historique. Veuillez réessayer.');
        }
    }
}

