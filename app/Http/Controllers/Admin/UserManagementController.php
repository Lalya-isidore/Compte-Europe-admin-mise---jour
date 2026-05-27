<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Compte;
use App\Models\RechargeTransaction;
use App\Models\TransactionHistory;
use App\Models\Transfer;
use App\Models\UnlockCode;
use App\Models\Commission;
use App\Models\Remboursement;
use App\Models\User;
use App\Models\virement as Virement;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use App\Models\Affiliation;
use App\Models\SmsHistory;
use App\Models\MailHistory;
use App\Models\CouponCollection;
use App\Models\ContratPretUsage;
use App\Models\ContratDonUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    /**
     * Liste des utilisateurs avec statistiques de base.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::query()
            ->withCount('comptes')
            ->withSum('comptes as total_account_balance', 'account_balance')
            ->when($search, function ($query) use ($search) {
                $term = "%{$search}%";
                $query->where(function ($innerQuery) use ($term, $search) {
                    $innerQuery->where('nom', 'like', $term)
                        ->orWhere('prenom', 'like', $term)
                        ->orWhere('email', 'like', $term)
                        ->orWhere('phone', 'like', $term)
                        ->orWhereRaw("CONCAT(prenom, ' ', nom) LIKE ?", [$term])
                        ->orWhereRaw("CONCAT(nom, ' ', prenom) LIKE ?", [$term]);

                    if (is_numeric($search)) {
                        $innerQuery->orWhere('id', (int) $search);
                    }
                });
            })
            ->orderByDesc('created_at')
            ->paginate(16)
            ->withQueryString();

        // Global Stats
        $globalStats = [
            'total_users' => User::count(),
            'total_comptes' => Compte::count(),
            'total_credits' => User::sum('credit_user'),
            'total_solde' => Compte::sum('account_balance'),
        ];

        return view('admin.users.index', compact('users', 'search', 'globalStats'));
    }

    /**
     * Détails d'un utilisateur et de ses comptes.
     */
    public function show(User $user)
    {
        $user->load(['comptes' => function ($query) {
            $query->orderByDesc('created_at');
        }]);

        $recharges = RechargeTransaction::with('compte')
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->limit(100)
            ->get();

        $totalRechargeAmount = RechargeTransaction::where('user_id', $user->id)
            ->where('status', 'completed')
            ->sum('amount');

        $smsHistory = SmsHistory::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->limit(100)
            ->get();

        $mailHistory = MailHistory::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->limit(100)
            ->get();

        $couponCollections = CouponCollection::with('coupons')
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->limit(50)
            ->get();

        $contratPretUsages = ContratPretUsage::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        $contratDonUsages = ContratDonUsage::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        return view('admin.users.show', [
            'user' => $user,
            'recharges' => $recharges,
            'totalRechargeAmount' => $totalRechargeAmount,
            'smsHistory' => $smsHistory,
            'mailHistory' => $mailHistory,
            'couponCollections' => $couponCollections,
            'contratPretUsages' => $contratPretUsages,
            'contratDonUsages' => $contratDonUsages,
        ]);
    }

    /**
     * Mise à jour du crédit utilisateur.
     */
    public function updateCredit(Request $request, User $user)
    {
        $data = $request->validate([
            'credit_user' => ['required', 'numeric', 'min:0'],
        ]);

        $user->update(['credit_user' => $data['credit_user']]);

        Session::flash('success', "Crédit de l'utilisateur mis à jour avec succès.");

        return redirect()->route('admin.users.show', $user);
    }

    /**
     * Mise à jour de l'adresse email d'un sous-compte.
     */
    public function updateCompteEmail(Request $request, User $user, Compte $compte)
    {
        abort_if($compte->user_id !== $user->id, 404);

        $data = $request->validate([
            'email' => ['required', 'email', Rule::unique('comptes', 'email')->ignore($compte->id)],
        ]);

        $compte->update(['email' => $data['email']]);

        Session::flash('success', 'Email du sous-compte mis à jour avec succès.');

        return redirect()->route('admin.users.show', $user)->withFragment('compte-' . $compte->id);
    }

    /**
     * Mise à jour du numéro de téléphone d'un sous-compte.
     */
    public function updateComptePhone(Request $request, User $user, Compte $compte)
    {
        abort_if($compte->user_id !== $user->id, 404);

        $data = $request->validate([
            'phone_number' => ['required', 'string', 'max:30'],
        ]);

        $compte->update(['phone_number' => $data['phone_number']]);

        Session::flash('success', 'Numéro du sous-compte mis à jour avec succès.');

        return redirect()->route('admin.users.show', $user)->withFragment('compte-' . $compte->id);
    }

    public function boostCompteBalance(Request $request, User $user, Compte $compte)
    {
        abort_if($compte->user_id !== $user->id, 404);

        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
        ]);

        $amount = (float) $data['amount'];

        DB::transaction(function () use ($compte, $amount) {
            $compte->increment('account_balance', $amount);

            if (! is_null($compte->account_balance2)) {
                $compte->increment('account_balance2', $amount);
            }

            TransactionHistory::create([
                'user_id' => $compte->user_id,
                'compte_id' => $compte->id,
                'transaction_type' => 'Ajustement administrateur',
                'amount' => round($amount, 2),
                'description' => 'Augmentation manuelle du solde via l’administration',
                'devise' => $compte->devise ?? 'F CFA',
            ]);
        });

        $compte->refresh();

        Session::flash('success', 'Solde du sous-compte augmenté de ' . number_format($amount, 0, ',', ' ') . ' F CFA.');

        return redirect()->route('admin.users.show', $user)->withFragment('compte-' . $compte->id);
    }

    public function purgeCompteHistory(Request $request, User $user, Compte $compte)
    {
        abort_if($compte->user_id !== $user->id, 404);

        DB::transaction(function () use ($compte) {
            TransactionHistory::where('compte_id', $compte->id)->delete();
            Transfer::where('compte_id', $compte->id)->delete();
            RechargeTransaction::where('compte_id', $compte->id)->delete();
            UnlockCode::where('compte_id', $compte->id)->delete();
            Commission::where('compte_id', $compte->id)->delete();
            Remboursement::where('compte_id', $compte->id)->delete();
            Virement::where('compte_id', $compte->id)->delete();
        });

        Session::flash('success', 'Historique intégral du sous-compte supprimé.');

        return redirect()->route('admin.users.show', $user)->withFragment('compte-' . $compte->id);
    }

    public function destroy(Request $request, User $user)
    {
        $identifier = trim(($user->nom . ' ' . $user->prenom)) ?: ($user->email ?? 'Utilisateur #' . $user->id);

        try {
            DB::transaction(function () use ($user) {
                // Supprimer les données liées à chaque compte
                foreach ($user->comptes as $compte) {
                    TransactionHistory::where('compte_id', $compte->id)->delete();
                    Transfer::where('compte_id', $compte->id)->delete();
                    RechargeTransaction::where('compte_id', $compte->id)->delete();
                    UnlockCode::where('compte_id', $compte->id)->delete();
                    Commission::where('compte_id', $compte->id)->delete();
                    Remboursement::where('compte_id', $compte->id)->delete();
                    Virement::where('compte_id', $compte->id)->delete();
                    $compte->delete();
                }

                // Supprimer les tickets et messages de support
                $ticketIds = SupportTicket::where('user_id', $user->id)->pluck('id');
                SupportMessage::whereIn('support_ticket_id', $ticketIds)->delete();
                SupportTicket::whereIn('id', $ticketIds)->delete();

                // Supprimer l'affiliation
                Affiliation::where('user_id', $user->id)->delete();

                // Supprimer l'utilisateur
                $user->delete();
            });

            Session::flash('success', "L'utilisateur {$identifier} a été supprimé.");

            return redirect()->route('admin.users.index');
        } catch (\Throwable $e) {
            Session::flash('error', 'Erreur lors de la suppression de l\'utilisateur : ' . $e->getMessage());

            return back();
        }
    }
}
