<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Affiliation;
use App\Notifications\WelcomeEmail;
use App\Services\SafeMailService;
use App\Services\SmsService;
use App\Services\TwilioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function inscriptionRoute(Request $request)
    {
        // Récupérer le code de parrainage depuis l'URL ou la session
        $codeParrainage = $request->get('ref') ?? session('referral_code');

        // Si un code est présent dans l'URL, le stocker en session pour persistence
        if ($request->get('ref')) {
            session(['referral_code' => $request->get('ref')]);
            $codeParrainage = $request->get('ref');

            // Vérifier si le code existe et récupérer les infos du parrain
            $affiliationParrain = \App\Models\Affiliation::where('code_affiliation', $codeParrainage)->first();
            if ($affiliationParrain) {
                $parrainInfo = $affiliationParrain->user;
                session([
                    'parrain_info' => [
                        'nom' => $parrainInfo->nom,
                        'prenom' => $parrainInfo->prenom,
                        'taux_commission' => $affiliationParrain->commission_rate
                    ]
                ]);
            }
        }

        return view('users.inscription', compact('codeParrainage'));
    }
    public function inscription(User $user, CreateUserRequest $request, SmsService $smsService)
    {
        $phoneNumber = preg_replace('/\s+/', '', (string) $request->input('phone_number'));
        // capture le mot de passe en clair pour l'envoyer par email (ne pas le stocker en clair)
        $plainPassword = $request->password;
        $codeParrainage = $request->input('code_parrainage');

        // Vérification de sécurité : si un code était en session, il doit correspondre
        if (session('referral_code') && $codeParrainage !== session('referral_code')) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['code_parrainage' => 'Tentative de manipulation du code de parrainage détectée.']);
        }

        $region = app('region')->current();
        $regionConfig = config("regions.{$region}");

        DB::transaction(function () use ($request, $user, $phoneNumber, $codeParrainage, $plainPassword, $region, $regionConfig) {
            // Créer l'utilisateur
            $user->nom = $request->nom;
            $user->prenom = $request->prenom;
            $user->email = $request->email;
            // Stocker le mot de passe haché en base
            $user->password = Hash::make($plainPassword);
            // Assigner le téléphone depuis la requête validée (champ obligatoire)
            $user->phone = $phoneNumber;
            $user->region = $region;
            $user->source = session('visit_source', 'Manuel');
            $user->save();

            // Gérer le parrainage si un code est fourni
            $parrain = null;
            if ($codeParrainage) {
                $affiliationParrain = Affiliation::where('code_affiliation', $codeParrainage)->first();
                if ($affiliationParrain) {
                    $parrain = $affiliationParrain->user;
                }
            }

            // Créer l'affiliation pour le nouveau utilisateur
            $affiliation = new Affiliation();
            $affiliation->user_id = $user->id;
            $affiliation->parrain_id = $parrain ? $parrain->id : null;
            $affiliation->code_affiliation = $affiliation->generateCodeAffiliation();
            $affiliation->commission_rate = 10.00; // 10%
            $affiliation->save();

            // Si il y a un parrain, enregistrer la relation ET assigner le parrain_id
            if ($parrain) {
                // CRITIQUE: Assigner le parrain_id à l'utilisateur
                $user->parrain_id = $parrain->id;
                $user->save();

                // Incrémenter uniquement le nombre de parrainés (pas les commissions)
                $affiliationParrain->increment('total_parraines');

                // Note: Les commissions seront créées uniquement lors des recharges
                Log::info("Nouveau parrainage enregistré", [
                    'parrain_id' => $parrain->id,
                    'filleul_id' => $user->id,
                    'code_affiliation' => $codeParrainage
                ]);
            }
        });

        // Nettoyer les sessions de parrainage après inscription réussie
        session()->forget(['referral_code', 'parrain_info']);

        // Notifier l'utilisateur en incluant le mot de passe en clair capturé plus haut
        $user->notify(new WelcomeEmail($plainPassword));

        // Notifier l'admin d'une nouvelle inscription
        try {
            $adminEmail = 'isiserviceplus@gmail.com';
            SafeMailService::send(
                $adminEmail,
                new \App\Mail\MassNotification(
                    'Nouvelle inscription sur ' . config('app.name'),
                    "Un nouvel utilisateur vient de s'inscrire sur la plateforme.\n\nNom : {$user->nom}\nPrénom : {$user->prenom}\nEmail : {$user->email}\nTéléphone : {$user->phone_number}\nDate : " . now()->format('d/m/Y à H:i'),
                    $user
                ),
                'Notification nouvelle inscription'
            );
        } catch (\Throwable $e) {
            Log::warning('Échec notification admin nouvelle inscription', ['error' => $e->getMessage()]);
        }

        return redirect()->route('connexion')->with('success', 'Votre compte a bien été creer, Connecter !');
    }

    public function connexionRoute()
    {
        return view('users.connexion');
    }
    public function connexion(LoginUserRequest $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Si c'est l'admin principal, rediriger vers l'espace admin
            if (Auth::user()->email === 'isiserviceplus@gmail.com') {
                Session::put('admin_authenticated', true);
                Session::put('admin_email', Auth::user()->email);
                Session::put('admin_login_time', now());
                return redirect()->route('admin.index');
            }

            return redirect()->intended('dashboard');
        } else {

            return redirect()->back()->with('error', 'Echec d\'authantification');
        }
        return redirect()->back()->with('error', 'Echec d\'authantification');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('connexion');

    }
}

