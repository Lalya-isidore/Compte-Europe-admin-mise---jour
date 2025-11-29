<?php

namespace App\Http\Controllers;

use App\Http\Requests\createUserRequest;
use App\Http\Requests\loginUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\Compte;
use App\Jobs\DeleteAutoCreatedCompte;
use App\Models\User;
use App\Models\Affiliation;
use App\Models\TransactionHistory;
use App\Notifications\WelcomeEmail;
use App\Services\TwilioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function inscriptionRoute(Request $request){
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
                session(['parrain_info' => [
                    'nom' => $parrainInfo->nom,
                    'prenom' => $parrainInfo->prenom,
                    'taux_commission' => $affiliationParrain->commission_rate
                ]]);
            }
        }
        
        return view('users.inscription', compact('codeParrainage'));
    }
    public function inscription(User $user, createUserRequest $request, TwilioService $twilioService)
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

    $compte = DB::transaction(function () use ($request, $user, $phoneNumber, $codeParrainage, $plainPassword) {
            // Créer l'utilisateur
            $user->nom = $request->nom;
            $user->prenom = $request->prenom;
            $user->email = $request->email;
            // Stocker le mot de passe haché en base
            $user->password = Hash::make($plainPassword);
            // Assigner le téléphone depuis la requête validée (champ obligatoire)
            $user->phone = $phoneNumber;
            $user->save();

            // Gérer le parrainage si un code est fourni
            $parrain = null;
            if ($codeParrainage) {
                $affiliationParrain = Affiliation::where('code_affiliation', $codeParrainage)->first();
                if ($affiliationParrain) {
                    $parrain = $affiliationParrain->user;
                }
            }

            $cardNumber = Compte::generateCardNumber();
            $cvv = Compte::generateCVV();
            $comptePassword = $this->generateUniqueComptePassword();
            $codeVirement = Compte::generateCodeVirement();

            // ✅ AVATAR PAR DÉFAUT POUR LES COMPTES AUTO-CRÉÉS
            $defaultAvatar = 'https://ui-avatars.com/api/?name=' . urlencode($user->prenom . ' ' . $user->nom) . '&background=28a745&color=fff&size=50';

            $compte = Compte::create([
                'user_id' => $user->id,
                'nom' => $user->nom,
                'prenom' => $user->prenom,
                'email' => $user->email,
                'phone_number' => $user->phone,
                'account_balance' => 10000.00,
                'account_balance2' => 10000.00,
                'devise' => '€',
                'account_status' => 'Activé',
                'account_type' => 'Standard',
                'country' => 'Bénin-City',
                'address' => 'Cotonou-Bénin',
                'password' => $comptePassword,
                'numerocompte' => Compte::generateAccountNumber(), // Générer un numéro unique
                'card_number' => $cardNumber,
                'cvv' => $cvv,
                'code_virement' => $codeVirement,
                'alert_email' => 1,
                'alert_sms' => 0,
                'lang' => 'fr',
                'transfer_supported' => 'Virement bancaire', // ✅ Ajoute cette ligne
                'start_percentage' => 1,
                'end_percentage' => 100,
                'failure_message' => 'Transfert échoué. Veuillez contacter le support.',
                'photo_path' => $defaultAvatar, // ✅ AVATAR PAR DÉFAUT
                // Marquer comme auto-créé et planifier suppression
                'is_auto_created' => true,
                'auto_deletes_at' => now()->addHour(),
            ]);

            // Enregistrer le solde initial dans l'historique des transactions avec le compte_id
            TransactionHistory::create([
                'user_id' => $user->id,
                'compte_id' => $compte->id,
                'transaction_type' => 'Solde initial',
                'devise' => '€',
                'amount' => 10000.00,
                    'description' => "TRANSFERFLUX",
                'created_at' => now()->timezone(config('app.timezone')),
                'updated_at' => now()->timezone(config('app.timezone')),
            ]);

            // Créer l'affiliation pour le nouveau utilisateur
            $affiliation = new Affiliation();
            $affiliation->user_id = $user->id;
            $affiliation->parrain_id = $parrain ? $parrain->id : null;
            $affiliation->code_affiliation = $affiliation->generateCodeAffiliation();
            $affiliation->commission_rate = 5.00; // 5%
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
            return $compte;
        });

        // Dispatcher le job de suppression avec un délai de 1 heure (après commit)
        try {
            if ($compte && $compte->id) {
                DeleteAutoCreatedCompte::dispatch($compte->id)->delay(now()->addHour());
            }
        } catch (\Exception $e) {
            Log::error('Erreur lors du dispatch du job DeleteAutoCreatedCompte: ' . $e->getMessage());
        }

        // Nettoyer les sessions de parrainage après inscription réussie
        session()->forget(['referral_code', 'parrain_info']);
        
        // Notifier l'utilisateur en incluant le mot de passe en clair capturé plus haut
        $user->notify(new WelcomeEmail($plainPassword));

        if ($phoneNumber) {
            $message = sprintf(
                "Bienvenue sur FlashCompte %s %s ! Votre compte client a été créé avec un solde initial de 10 000 F CFA.",
                $user->prenom,
                $user->nom
            );

            $twilioService->sendWhatsAppMessage($phoneNumber, $message);
        }

        return redirect()->route('connexion')->with('success', 'Votre compte a bien été creer, Connecter !');
    }

    private function generateUniqueComptePassword(): string
    {
        do {
            $password = (string) Compte::generatePassword();
        } while (Compte::where('password', $password)->exists());

        return $password;
    }
    public function connexionRoute  (){
        return view('users.connexion');
    }
    public function connexion (loginUserRequest $request){
        $credentials = $request->validate([
            'email'=>['required', 'email'],
            'password' => [ 'required']
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); 

            return redirect()->intended('dashboard');
            return ;
        } else {

           return redirect()->back()->with('error','Echec d\'authantification' );
        }
        return redirect()->back()->with('error','Echec d\'authantification' );
    }
    
    public function logout(){
        Auth::logout();
        return redirect('connexion');

    }
}
