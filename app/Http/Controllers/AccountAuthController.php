<?php


namespace App\Http\Controllers;

use App\Models\Compte;
use App\Models\User;
use App\Notifications\OuvertureDeCompteEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AccountAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('compte.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Essayez de trouver l'utilisateur principal ou un sous-compte avec l'adresse e-mail fournie
        $compte = User::where('email', $request->email)->first();
        $subAccount = Compte::where('email', $request->email)->first();

        if ($compte && Hash::check($request->password, $compte->password)) {
            // Authentification réussie pour l'utilisateur principal
            $token = Str::random(60);
            $compte->update(['token' => $token]);

            session(['token' => $token]);

            // Notifier l'utilisateur principal de la connexion
            $compte->notify(new OuvertureDeCompteEmail());

            return redirect()->route('account.show', $token);
        } elseif ($subAccount && Hash::check($request->password, $subAccount->password)) {
            // Authentification réussie pour un sous-compte
            $token = Str::random(60);
            $subAccount->update(['token' => $token]);

            session(['token' => $token]);

            // Optionnel: notifier l'utilisateur principal de la connexion du sous-compte
            // $compte = $subAccount->parentAccount;
            // $compte->notify(new SubAccountLoginNotification($subAccount));

            return redirect()->route('subaccount.show', $token);
        } else {
            // Authentification échouée
            return back()->withErrors(['email' => 'Email ou mot de passe incorrect.']);
        }
    }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     $compte = Compte::where('email', $request->email)->first();

    //     if ($compte && Hash::check($request->password, $compte->password)) {
    //         $token = Str::random(60);
    //         $compte->update(['token' => $token]);

    //         session(['token' => $token]);

    //         return redirect()->route('account.show', $token);
    //     }
    //     $compte->notify(new OuvertureDeCompteEmail());

    //     return back()->withErrors(['email' => 'Email or password is incorrect.']);
    // }
    public function showAccount($token)
    {
        // Trouver le compte en fonction du token
        $compte = Compte::where('token', $token)->first();

        // Vérifier si le compte existe et si le token de session correspond au token fourni
        if (!$compte || session('token') != $token) {
            // Rediriger vers la page de connexion si les vérifications échouent
            return redirect()->route('compte.login')->withErrors(['token' => 'Authentification échouée. Veuillez vous reconnecter.']);
        }

        // Retourner la vue du compte avec les données du compte
        return view('compte.show', compact('compte'));
    }
}
