<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ActiveClientsController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->input('tab', 'credits');

        // Utilisateurs avec des crédits > 0
        $usersWithCredits = User::where('credit_user', '>', 0)
            ->orderByDesc('credit_user')
            ->get();

        // Utilisateurs avec au moins 1 compte
        $usersWithComptes = User::has('comptes')
            ->withCount('comptes')
            ->orderByDesc('comptes_count')
            ->get();

        return view('admin.active-clients', compact('usersWithCredits', 'usersWithComptes', 'tab'));
    }
}
