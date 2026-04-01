<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RechargeTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActiveClientsController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->input('tab', 'credits');

        // Utilisateurs avec des crédits > 0 + date du dernier crédit
        $usersWithCredits = User::where('credit_user', '>', 0)
            ->orderByDesc('credit_user')
            ->get();

        // Ajouter la date du dernier crédit pour chaque utilisateur
        $lastRecharges = RechargeTransaction::where('status', 'completed')
            ->select('user_id', DB::raw('MAX(completed_at) as last_recharge_at'))
            ->groupBy('user_id')
            ->pluck('last_recharge_at', 'user_id');

        foreach ($usersWithCredits as $user) {
            $user->last_recharge_at = $lastRecharges[$user->id] ?? null;
        }

        // Utilisateurs avec au moins 1 compte
        $usersWithComptes = User::has('comptes')
            ->withCount('comptes')
            ->orderByDesc('comptes_count')
            ->get();

        return view('admin.active-clients', compact('usersWithCredits', 'usersWithComptes', 'tab'));
    }
}
