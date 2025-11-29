<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Affiliation;
use App\Models\Retrait;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CommissionController extends Controller
{
    public function index(Request $request)
    {
        $query = Commission::with(['affiliation.user', 'parrainneUser'])
            ->orderBy('date_action', 'desc');

        // Filtres
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('type')) {
            $query->where('action_type', $request->type);
        }

        $commissions = $query->paginate(20);

        $affiliationsSummary = Affiliation::with([
            'user',
            'retraits' => function ($query) {
                $query->latest('date_demande')->limit(1);
            },
        ])
            ->withSum([
                'commissions as commissions_validees_total' => function ($query) {
                    $query->whereIn('statut', ['validee', 'valide', 'retiree']);
                },
            ], 'montant_commission')
            ->withSum([
                'commissions as commissions_en_attente_total' => function ($query) {
                    $query->whereIn('statut', ['en_attente', 'en_cours_de_retrait']);
                },
            ], 'montant_commission')
            ->withSum([
                'retraits as retraits_en_attente_total' => function ($query) {
                    $query->whereIn('statut', ['en_attente', 'en_cours']);
                },
            ], 'montant')
            ->withCount([
                'retraits as retraits_en_attente_count' => function ($query) {
                    $query->whereIn('statut', ['en_attente', 'en_cours']);
                },
            ])
            ->orderByDesc('commissions_validees_total')
            ->get();

        // Statistiques
        $totalCommissions = Commission::whereIn('statut', ['validee', 'valide', 'retiree'])->sum('montant_commission');
        $totalAffiliations = Affiliation::count();
        $commissionsToday = Commission::whereDate('date_action', Carbon::today())
            ->whereIn('statut', ['validee', 'valide'])
            ->count();
        $averageCommissionRate = round(Commission::avg('taux_commission') ?? 5, 0);
        $monthlyTotal = Commission::whereIn('statut', ['validee', 'valide', 'retiree'])
            ->whereMonth('date_action', Carbon::now()->month)
            ->whereYear('date_action', Carbon::now()->year)
            ->sum('montant_commission');
        $pendingWithdrawalsCount = Retrait::whereIn('statut', ['en_attente', 'en_cours'])->count();
        $pendingWithdrawalsTotal = Retrait::whereIn('statut', ['en_attente', 'en_cours'])->sum('montant');
        $pendingWithdrawals = Retrait::with(['user', 'affiliation'])
            ->whereIn('statut', ['en_attente', 'en_cours'])
            ->orderBy('date_demande')
            ->get();

        return view('admin.commissions', compact(
            'commissions',
            'totalCommissions',
            'totalAffiliations',
            'commissionsToday',
            'averageCommissionRate',
            'monthlyTotal',
            'affiliationsSummary',
            'pendingWithdrawalsCount',
            'pendingWithdrawalsTotal',
            'pendingWithdrawals'
        ));
    }

    public function show($id)
    {
        $commission = Commission::with(['affiliation.user', 'parrainneUser'])->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'commission' => $commission,
            'details' => [
                'parrain_nom' => $commission->affiliation->user->nom ?? 'N/A',
                'parrain_email' => $commission->affiliation->user->email ?? 'N/A',
                'filleul_nom' => $commission->parrainneUser->nom ?? 'N/A',
                'filleul_email' => $commission->parrainneUser->email ?? 'N/A',
                'code_affiliation' => $commission->affiliation->code_affiliation ?? 'N/A',
                'date_action' => $commission->date_action->format('d/m/Y H:i:s'),
                'montant_base_formatted' => number_format($commission->montant_base, 0, ',', ' ') . ' F CFA',
                'montant_commission_formatted' => number_format($commission->montant_commission, 0, ',', ' ') . ' F CFA'
            ]
        ]);
    }

    public function validateCommission($id)
    {
        try {
            $commission = Commission::findOrFail($id);
            
            if ($commission->statut === 'validee') {
                return response()->json([
                    'success' => false,
                    'message' => 'Cette commission est déjà validée.'
                ]);
            }

            DB::beginTransaction();

            // Mettre à jour le statut de la commission
            $commission->update(['statut' => 'validee']);

            // Créditer le compte du parrain si ce n'est pas déjà fait
            if ($commission->affiliation && $commission->affiliation->user && $commission->affiliation->user->compte) {
                $compte = $commission->affiliation->user->compte;
                $compte->solde += $commission->montant_commission;
                $compte->save();

                // Mettre à jour le total des commissions de l'affiliation
                $commission->affiliation->increment('total_commissions', $commission->montant_commission);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Commission validée avec succès.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la validation : ' . $e->getMessage()
            ]);
        }
    }

    public function reject($id)
    {
        try {
            $commission = Commission::findOrFail($id);
            
            if ($commission->statut === 'validee') {
                return response()->json([
                    'success' => false,
                    'message' => 'Impossible de rejeter une commission déjà validée.'
                ]);
            }

            $commission->update(['statut' => 'rejetee']);

            return response()->json([
                'success' => true,
                'message' => 'Commission rejetée.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du rejet : ' . $e->getMessage()
            ]);
        }
    }

    public function markWithdrawalAsProcessed($id)
    {
        try {
            $retrait = Retrait::with('affiliation')->findOrFail($id);

            if ($retrait->statut === 'traite') {
                return response()->json([
                    'success' => false,
                    'message' => 'Cette demande de retrait est déjà marquée comme traitée.'
                ]);
            }

            DB::transaction(function () use ($retrait) {
                $now = Carbon::now();
                $montantRestant = (float) $retrait->montant;
                $commissionIds = [];

                $commissions = Commission::where('affiliation_id', $retrait->affiliation_id)
                    ->where('statut', 'en_cours_de_retrait')
                    ->orderBy('date_action')
                    ->lockForUpdate()
                    ->get();

                foreach ($commissions as $commission) {
                    if ($montantRestant <= 0) {
                        break;
                    }

                    $commissionIds[] = $commission->id;
                    $commissionDetails = $commission->details ?? [];
                    $commissionDetails['retrait_id'] = $retrait->id;
                    $commissionDetails['retire_le'] = $now->toDateTimeString();

                    $commission->statut = 'retiree';
                    $commission->details = $commissionDetails;
                    $commission->save();

                    $montantRestant -= (float) $commission->montant_commission;
                    if ($montantRestant < 0) {
                        $montantRestant = 0;
                    }
                }

                $details = $retrait->details ?? [];
                $details['commissions_traitees'] = $commissionIds;
                if ($montantRestant > 0) {
                    $details['montant_non_rapproche'] = round($montantRestant, 2);
                } else {
                    unset($details['montant_non_rapproche']);
                }
                $details['traite_le'] = $now->toDateTimeString();

                $retrait->statut = 'traite';
                $retrait->date_traitement = $now;
                $retrait->details = $details;
                $retrait->save();
            });

            return response()->json([
                'success' => true,
                'message' => 'Demande de retrait marquée comme traitée.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du traitement de la demande : ' . $e->getMessage()
            ]);
        }
    }

    public function statistics()
    {
        $stats = [
            'total_commissions' => Commission::whereIn('statut', ['validee', 'valide', 'retiree'])->sum('montant_commission'),
            'commissions_du_mois' => Commission::whereIn('statut', ['validee', 'valide', 'retiree'])
                ->whereMonth('date_action', Carbon::now()->month)
                ->whereYear('date_action', Carbon::now()->year)
                ->sum('montant_commission'),
            'nombre_affiliations_actives' => Affiliation::whereHas('commissions', function($query) {
                $query->whereIn('statut', ['validee', 'valide', 'retiree']);
            })->count(),
            'commission_moyenne' => Commission::whereIn('statut', ['validee', 'valide', 'retiree'])->avg('montant_commission'),
            'top_parrains' => DB::table('affiliations')
                ->join('users', 'affiliations.user_id', '=', 'users.id')
                ->select(
                    'users.nom',
                    'users.prenom',
                    'affiliations.code_affiliation',
                    'affiliations.total_commissions',
                    'affiliations.nombre_parrainages'
                )
                ->orderBy('affiliations.total_commissions', 'desc')
                ->limit(10)
                ->get()
        ];

        return response()->json($stats);
    }

    public function cleanupInscriptionCommissions()
    {
        try {
            $deletedCount = Commission::where('action_type', 'inscription')->delete();
            
            return response()->json([
                'success' => true,
                'message' => "{$deletedCount} commissions d'inscription supprimées avec succès."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du nettoyage : ' . $e->getMessage()
            ]);
        }
    }

    public function export(Request $request)
    {
        $query = Commission::with(['affiliation.user', 'parrainneUser']);

        if ($request->filled('date_debut')) {
            $query->whereDate('date_action', '>=', $request->date_debut);
        }

        if ($request->filled('date_fin')) {
            $query->whereDate('date_action', '<=', $request->date_fin);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $commissions = $query->get();

        $filename = 'commissions_' . Carbon::now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($commissions) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, [
                'Date',
                'Parrain',
                'Email Parrain',
                'Code Affiliation',
                'Filleul',
                'Email Filleul',
                'Action',
                'Montant Base',
                'Taux Commission',
                'Montant Commission',
                'Statut'
            ]);

            // Données
            foreach ($commissions as $commission) {
                fputcsv($file, [
                    $commission->date_action->format('d/m/Y H:i'),
                    ($commission->affiliation->user->nom ?? '') . ' ' . ($commission->affiliation->user->prenom ?? ''),
                    $commission->affiliation->user->email ?? '',
                    $commission->affiliation->code_affiliation ?? '',
                    ($commission->parrainneUser->nom ?? '') . ' ' . ($commission->parrainneUser->prenom ?? ''),
                    $commission->parrainneUser->email ?? '',
                    $commission->action_type,
                    $commission->montant_base,
                    $commission->taux_commission . '%',
                    $commission->montant_commission,
                    $commission->statut
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}