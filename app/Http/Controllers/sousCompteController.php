<?php

namespace App\Http\Controllers;

use App\Http\Requests\SousCompteRequest;
use App\Models\Compte;
use App\Models\TransactionHistory;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SousCompteController extends Controller
{
    public function sousComptelogin(Request $request)
    {
        $compte = null;
        $hash = $request->query('c');

        if ($hash) {
            $compte = Compte::where('numerocompte', $hash)->first();
        }

        $isTestMode = $compte && str_starts_with($compte->numerocompte ?? '', 'test_');

        return view('client.connexion', compact('compte', 'isTestMode'));
    }

    public function sousCompteAuth(SousCompteRequest $request)
    {
        $compte = Compte::where('email', $request->email)->first();

        if ($compte && $request->password === $compte->password) {
            $token = Str::random(60);
            $compte->update(['token' => $token]);

            session([
                'token' => $token,
                'sous_compte_id' => $compte->id,
                'sous_compte_token' => $token,
            ]);

            return redirect()->route('client.dashboard', $token);
        }

        return back()->withErrors(['email' => 'Email or password is incorrect.']);
    }

    public function show(string $token)
    {
        $compte = Compte::where('token', $token)->first();

        if (! $compte || session('token') !== $token) {
            return redirect()->route('client.login');
        }

        $histories = TransactionHistory::where('compte_id', $compte->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.show', compact('compte', 'histories'));
    }

    public function showroute()
    {
        $compte = $this->getConnectedCompte();

        if (! $compte) {
            return redirect()->route('client.login');
        }

        $histories = TransactionHistory::where('compte_id', $compte->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.show', compact('compte', 'histories'));
    }

    public function info()
    {
        $compte = $this->getConnectedCompte();

        if (! $compte) {
            return redirect()->route('client.login');
        }

        return view('pages.info', compact('compte'));
    }

    public function carte()
    {
        $compte = $this->getConnectedCompte();

        if (! $compte) {
            return redirect()->route('client.login');
        }

        return view('pages.carte', compact('compte'));
    }

    public function virement()
    {
        $compte = $this->getConnectedCompte();

        if (! $compte) {
            return redirect()->route('client.login');
        }

        return view('pages.virement', compact('compte'));
    }

    public function edit(int $id)
    {
        $compte = Compte::findOrFail($id);

        return view('pages.edit', compact('compte'));
    }

    public function update(Request $request, int $id)
    {
        $compte = Compte::findOrFail($id);
        $compte->update($request->all());

        return redirect()->route('pages.edit', $compte->id)
            ->with('success', 'Informations mises à jour avec succès.');
    }

    public function logoutSous(Request $request)
    {
        $sousCompteId = session('sous_compte_id');

        if ($sousCompteId && Compte::find($sousCompteId)) {
            $request->session()->forget(['sous_compte_id', 'sous_compte_token', 'token']);
            $request->session()->regenerate();

            return redirect()->route('client.login')->with('success', 'Déconnexion réussie.');
        }

        return redirect()->route('client.login')->withErrors(['error' => 'Déconnexion échouée.']);
    }

    public function checkTransferExistence(int $id)
    {
        $compte = Compte::find($id);
        $userId = $compte ? $compte->user_id : $id;

        $isTransferExist = Transfer::where('user_id', $userId)
            ->where('status', 'completed')
            ->exists();

        return response()->json(['exists' => $isTransferExist]);
    }

    private function getConnectedCompte(): ?Compte
    {
        $token = session('token');

        if (! $token) {
            return null;
        }

        return Compte::where('token', $token)->first();
    }
}
