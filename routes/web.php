<?php

use Illuminate\Support\Facades\Route;

// ── Webhooks Twilio SMS (public — pas de CSRF, pas d'auth) ──────
Route::withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])->group(function () {
    Route::post('/webhook/twilio/sms-status', [App\Http\Controllers\SmsWebhookController::class, 'twilioStatus'])->name('webhook.twilio.sms-status');
    Route::post('/webhook/twilio/sms-status-fallback', [App\Http\Controllers\SmsWebhookController::class, 'twilioStatusFallback'])->name('webhook.twilio.sms-status-fallback');
});

Route::get('/', function () {
    if (!session()->has('visit_source')) {
        $referer = request()->headers->get('referer', '');
        $source = str_contains($referer, 'google.') ? 'Google' : 'Manuel';
        session(['visit_source' => $source]);
    }
    return \Illuminate\Support\Facades\Auth::check()
        ? redirect()->route('dashboard')
        : view('landing');
})->name('landing');
use App\Http\Controllers\CompteController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SousCompteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VirementController;
use App\Http\Controllers\TarifsController;
use App\Http\Controllers\MailExtractorController;
use App\Http\Controllers\UrlCheckController;
use App\Http\Controllers\UrlShortenerController;
use App\Http\Controllers\PhoneVerifyController;
use App\Http\Controllers\IbanCheckController;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\Admin\SupportTicketController;
use Illuminate\Support\Facades\Auth;

// Root route now points to the users connexion view



Route::middleware(['guest'])->group(function () {

    Route::get('inscription', [UserController::class, 'inscriptionRoute'])->name('inscription');
    Route::get('connexion', [UserController::class, 'connexionRoute'])->name('connexion');
    Route::get('connexion', [UserController::class, 'connexionRoute'])->name('login');
    Route::post('connexion', [UserController::class, 'connexion'])->name('connexion');
    // Form POST handler: use a distinct route name to avoid duplicate route name errors
    Route::post('inscription', [UserController::class, 'inscription'])->name('inscription.submit');
});

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/pwa/installed', [App\Http\Controllers\PwaController::class, 'markInstalled'])->name('pwa.installed');

    // SMS Pro Routes
    Route::get('/sms/pro', [App\Http\Controllers\SmsProController::class, 'index'])->name('sms.pro');
    Route::post('/sms/pro/send', [App\Http\Controllers\SmsProController::class, 'send'])->name('sms.pro.send');
    Route::get('/sms/pro/history', [App\Http\Controllers\SmsProController::class, 'history'])->name('sms.pro.history');
    Route::get('/sms/pro/details/{id}', [App\Http\Controllers\SmsProController::class, 'details'])->name('sms.pro.details');
    Route::delete('/sms/pro/history', [App\Http\Controllers\SmsProController::class, 'deleteHistory'])->name('sms.pro.delete-history');

    // Mail Flash Pro Routes
    Route::get('/mail/flash-pro', [App\Http\Controllers\MailProController::class, 'index'])->name('mail.flash.pro');
    Route::post('/mail/flash-pro/send', [App\Http\Controllers\MailProController::class, 'send'])->name('mail.flash.pro.send');
    Route::get('/mail/flash-pro/details/{id}', [App\Http\Controllers\MailProController::class, 'details'])->name('mail.flash.pro.details');
    Route::delete('/mail/flash-pro/history', [App\Http\Controllers\MailProController::class, 'deleteHistory'])->name('mail.flash.pro.delete-history');
    Route::get('/mail/flash-pro/open/{messageId}', [App\Http\Controllers\MailProController::class, 'trackOpen'])
        ->name('mail.flash.pro.open')
        ->withoutMiddleware(['auth']);

    // Mail Pro Privé
    Route::get('/mail/pro-prive', function() { return view('mail.pro-prive'); })->name('mail.pro.prive');

    // Collecte de code coupon
    Route::get('/coupon/collecte', [App\Http\Controllers\Tools\CouponCollectionController::class, 'index'])->name('tools.coupon.index');
    Route::post('/coupon/collecte', [App\Http\Controllers\Tools\CouponCollectionController::class, 'store'])->name('tools.coupon.store');
    Route::get('/coupon/collecte/{id}', [App\Http\Controllers\Tools\CouponCollectionController::class, 'show'])->name('tools.coupon.show');
    Route::delete('/coupon/collecte/{id}', [App\Http\Controllers\Tools\CouponCollectionController::class, 'destroy'])->name('tools.coupon.destroy');
    Route::post('/coupon/notify/{coupon}', [App\Http\Controllers\Tools\CouponCollectionController::class, 'notify'])->name('tools.coupon.notify');

    // Vente de crypto USDT
    Route::get('/crypto/vente', function () { return view('crypto.vente'); })->name('crypto.vente');

    // URL Tools
    Route::get('/tools/qr-generator', function () {
        \App\Models\ToolPageVisit::record('qr-generator');
        return view('tools.qr-generator');
    })->name('tools.qr-generator');

    Route::get('/tools/badge-agent', [App\Http\Controllers\BadgeAgentController::class, 'index'])->name('tools.badge-agent');

    // Générateur de Contrat de Prêt
    Route::get('/tools/contrat-pret', [App\Http\Controllers\Tools\ContratPretController::class, 'index'])->name('tools.contrat-pret');
    Route::post('/tools/contrat-pret/generate', [App\Http\Controllers\Tools\ContratPretController::class, 'generate'])->name('tools.contrat-pret.generate');

    // Générateur de Document de Don
    Route::get('/tools/contrat-don', [App\Http\Controllers\Tools\ContratDonController::class, 'index'])->name('tools.contrat-don');
    Route::post('/tools/contrat-don/generate', [App\Http\Controllers\Tools\ContratDonController::class, 'generate'])->name('tools.contrat-don.generate');

    // Historique des contrats
    Route::get('/contracts/history/{id}/download', [App\Http\Controllers\Tools\ContractHistoryController::class, 'download'])->name('contracts.history.download');
    Route::delete('/contracts/history/{id}', [App\Http\Controllers\Tools\ContractHistoryController::class, 'destroy'])->name('contracts.history.destroy');

    // Simulateur de Crédit / Prêt Bancaire
    Route::get('/tools/simulateur-credit', [App\Http\Controllers\Tools\SimulateurCreditController::class, 'index'])->name('tools.simulateur-credit');
    Route::post('/tools/simulateur-credit/generate', [App\Http\Controllers\Tools\SimulateurCreditController::class, 'generate'])->name('tools.simulateur-credit.generate');

    Route::get('/tools/url-check', [UrlCheckController::class, 'index'])->name('tools.url-check');
    Route::post('/tools/url-check', [UrlCheckController::class, 'check'])->name('tools.url-check.run');
    Route::get('/tools/url-shortener', [UrlShortenerController::class, 'index'])->name('tools.url-shortener');
    Route::post('/tools/url-shortener', [UrlShortenerController::class, 'store'])->name('tools.url-shortener.store');
    Route::delete('/tools/url-shortener', [UrlShortenerController::class, 'destroy'])->name('tools.url-shortener.delete');

    // Vérification de numéro de téléphone (HLR Lookup)
    Route::get('/tools/phone-verify', [PhoneVerifyController::class, 'index'])->name('tools.phone-verify');
    Route::post('/tools/phone-verify', [PhoneVerifyController::class, 'verify'])->name('tools.phone-verify.run');
    Route::delete('/tools/phone-verify/{id}', [PhoneVerifyController::class, 'destroy'])->name('tools.phone-verify.delete');
    Route::delete('/tools/phone-verify', [PhoneVerifyController::class, 'clear'])->name('tools.phone-verify.clear');

    // Vérification IBAN / CB
    Route::get('/tools/iban-check', [IbanCheckController::class, 'index'])->name('tools.iban-check');
    Route::post('/tools/iban-check', [IbanCheckController::class, 'verify'])->name('tools.iban-check.run');
    Route::delete('/tools/iban-check/{id}', [IbanCheckController::class, 'destroy'])->name('tools.iban-check.delete');
    Route::delete('/tools/iban-check', [IbanCheckController::class, 'clear'])->name('tools.iban-check.clear');

    // Flash Compte Pro v1
    Route::get('/tools/flash-compte-pro', function () {
        \App\Models\ToolPageVisit::record('flash-compte-pro');
        $creditsDisponibles = number_format(auth()->user()->credit_user ?? 0, 0, ',', ' ');
        $comptes = \App\Models\Compte::where('user_id', auth()->id())
            ->whereRaw("numerocompte NOT LIKE 'test\\_%'")
            ->orderByDesc('created_at')
            ->get();
        return view('tools.flash-compte-pro', compact('creditsDisponibles', 'comptes'));
    })->name('tools.flash-compte-pro');

    Route::post('/tools/flash-compte-pro', [CompteController::class, 'comptecreate'])->name('tools.flash-compte-pro.store');

    Route::put('/tools/flash-compte-pro/update', [CompteController::class, 'updateMessageAndPercentages'])->name('tools.flash-compte-pro.update');

    Route::post('/tools/flash-compte-pro/lock', function (\Illuminate\Http\Request $request) {
        $compteId = $request->input('access-cl');
        $compte = \App\Models\Compte::where('user_id', auth()->id())->find($compteId);
        if (!$compte) return back()->with('error', 'Compte introuvable.');

        if ($request->has('lock-access')) {
            $compte->account_status = 'Bloqué';
            $msg = 'Accès client bloqué avec succès.';
        } else {
            $compte->account_status = 'Activé';
            $msg = 'Accès client débloqué avec succès.';
        }
        
        $compte->save();
        return back()->with('success', $msg);
    })->name('tools.flash-compte-pro.lock');

    Route::delete('/tools/flash-compte-pro/{id}', [CompteController::class, 'destroy'])->name('tools.flash-compte-pro.destroy');

    // Extraction d'e-mail(s)
    Route::get('/tools/mail-extractor', [MailExtractorController::class, 'index'])->name('tools.mail-extractor');
    Route::post('/tools/mail-extractor', [MailExtractorController::class, 'store'])->name('tools.mail-extractor.run');
    Route::delete('/tools/mail-extractor', [MailExtractorController::class, 'destroy'])->name('tools.mail-extractor.clear');

    Route::get('/tarifs', [TarifsController::class, 'index'])->name('tarifs.index');

    // Route::get('/pages/create', [PageController::class, 'create'])->name('pages.create');
    // Route::post('/pages', [PageController::class, 'store'])->name('pages.store');

    // Route::get('/pages/show', [compteController::class, 'show'])->name('pagesshow');
    Route::get('logout', [UserController::class, 'logout'])->name('logout');
    // Liste des comptes de l'utilisateur
    Route::get('/compte', [CompteController::class, 'overview'])->name('compte.view');
    // Formulaire de création (affiche la vue de création)
    Route::get('/compte/create', [CompteController::class, 'compteview'])->name('compte.create');
    // Enregistrement du compte (soumission du formulaire)
    Route::post('/compte', [CompteController::class, 'comptecreate'])->name('compte.store');
    
    // Routes d'affiliation
    Route::get('/affiliation', [App\Http\Controllers\AffiliationController::class, 'index'])->name('affiliation.index');
    Route::post('/affiliation/activate', [App\Http\Controllers\AffiliationController::class, 'activate'])->name('affiliation.activate');
    Route::post('/affiliation/transfer', [App\Http\Controllers\AffiliationController::class, 'transferToBalance'])->name('affiliation.transfer');
    Route::post('/affiliation/withdrawal', [App\Http\Controllers\AffiliationController::class, 'withdrawal'])->name('affiliation.withdrawal');
    Route::post('/affiliation/validate/{commission}', [App\Http\Controllers\AffiliationController::class, 'validateCommission'])->name('affiliation.validate');
    Route::delete('/affiliation/clear-history', [App\Http\Controllers\AffiliationController::class, 'clearHistory'])->name('affiliation.clearHistory');
    
    // Routes de recharge
    Route::get('/recharge', [App\Http\Controllers\RechargeController::class, 'index'])->name('recharge.index');
    Route::post('/recharge', [App\Http\Controllers\RechargeController::class, 'store'])->name('recharge.store');
    Route::get('/recharge/success', [App\Http\Controllers\RechargeController::class, 'success'])->name('recharge.success');
    Route::get('/recharge/cancel', [App\Http\Controllers\RechargeController::class, 'cancel'])->name('recharge.cancel');
    Route::delete('/recharge/history', [App\Http\Controllers\RechargeController::class, 'clearHistory'])->name('recharge.history.clear');
    // Vérifier le statut d'une transaction par son transaction_id (propriétaire uniquement)
    Route::get('/recharge/status/{transactionId}', [App\Http\Controllers\RechargeController::class, 'status'])->name('recharge.status');

    // Support & assistance
    Route::get('/support', [SupportController::class, 'index'])->name('support.index');
    Route::post('/support', [SupportController::class, 'storeTicket'])->name('support.store');
    Route::post('/support/{ticket}/message', [SupportController::class, 'storeMessage'])->name('support.message.store');
    Route::get('/support/widget/data', [SupportController::class, 'widgetData'])->name('support.widget.data');
    Route::post('/support/widget/read', [SupportController::class, 'markWidgetRead'])->name('support.widget.read');

    // Route de test rapide
    Route::get('/test-recharge-system', function() {
        $user = Auth::user();
        if (!$user) {
            return "Vous devez être connecté pour tester";
        }
        
        $compte = \App\Models\Compte::where('user_id', $user->id)->first();
        if (!$compte) {
            return "Aucun compte trouvé pour cet utilisateur";
        }
        
        return "✅ Système opérationnel<br>" .
               "👤 Utilisateur: {$user->nom} {$user->prenom}<br>" .
               "💰 Solde actuel: " . number_format($compte->account_balance, 0, ',', ' ') . " F CFA<br>" .
               "🔗 <a href='" . route('recharge.index') . "'>Aller à la recharge</a>";
    })->name('test.recharge.system');
    
    // Test configuration FedaPay
    Route::get('/test-fedapay-config', function() {
        return [
            'secret_key_configured' => config('services.fedapay.secret_key') ? 'YES' : 'NO',
            'secret_key_start' => substr(config('services.fedapay.secret_key', ''), 0, 10) . '...',
            'public_key_configured' => config('services.fedapay.public_key') ? 'YES' : 'NO',
            'public_key_start' => substr(config('services.fedapay.public_key', ''), 0, 10) . '...',
            'environment' => app()->environment()
        ];
    })->name('test.fedapay.config');
    
    // Route de test pour CSRF (uniquement en développement)
    if (app()->environment('local')) {
        Route::get('/test-csrf', function () {
            return view('test-csrf');
        })->name('test.csrf');
    }
});

// Page vidéo Flash Compte Pro — publique (accessible sans compte)
Route::get('/tools/flash-compte-pro/video', function () {
    \App\Models\ToolPageVisit::record('flash-compte-pro-video');
    return view('tools.flash-compte-video');
})->name('tools.flash-compte-pro.video');

// Webhooks publics (sans authentification)
// - POST : notifications serveur (webhook) envoyées par FedaPay
// - GET  : redirections utilisateur après paiement (return/cancel)
// Séparer les endpoints réduit les problèmes liés aux règles d'hébergeur
// (ex: certains panels/restreignent les méthodes sur un même path).

// Webhook POST (notifications serveur)
Route::post('/recharge/webhook/fedapay', [App\Http\Controllers\RechargeController::class, 'fedapayWebhook'])
    ->name('recharge.webhook.fedapay')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// Some providers or older tokens may still redirect to the old path using GET.
// Provide a GET fallback on the same path that forwards to the dedicated return route.
Route::get('/recharge/webhook/fedapay', function () {
    // Preserve query string and forward to the explicit return route
    $qs = request()->getQueryString();
    $target = route('recharge.return.fedapay') . ($qs ? "?{$qs}" : '');
    return redirect($target);
})->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// Return/Cancel GET (retours utilisateur après paiement)
Route::get('/recharge/return/fedapay', [App\Http\Controllers\RechargeController::class, 'fedapayReturn'])
    ->name('recharge.return.fedapay')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

Route::post('/recharge/webhook/oosic', [App\Http\Controllers\RechargeController::class, 'oosicWebhook'])
    ->name('recharge.webhook.oosic')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// Route temporaire pour compléter les transactions manuellement
Route::get('/complete-pending-transactions', [App\Http\Controllers\RechargeController::class, 'completePendingTransactions']);

// Route pour corriger les transactions incorrectement validées
Route::get('/fix-incorrect-transactions', [App\Http\Controllers\RechargeController::class, 'fixIncorrectTransactions']);

// Route pour supprimer la transaction frauduleuse
Route::get('/remove-fraudulent-transaction', [App\Http\Controllers\RechargeController::class, 'removeFraudulentTransaction']);

// Route pour diagnostiquer les problèmes d'affiliation
Route::get('/debug-affiliation', [App\Http\Controllers\RechargeController::class, 'debugAffiliation']);

// Route pour voir les affiliés et leurs recharges
Route::get('/check-affiliates', [App\Http\Controllers\RechargeController::class, 'checkAffiliates']);

// Route pour vérifier les données d'affiliation
Route::get('/check-affiliation-data', [App\Http\Controllers\RechargeController::class, 'checkAffiliationData']);

// Route pour vérifier le lien de parrainage
Route::get('/debug-parrainage/{userId}', [App\Http\Controllers\RechargeController::class, 'debugParrainage']);

// Route pour voir tous les utilisateurs récents
Route::get('/recent-users', [App\Http\Controllers\RechargeController::class, 'recentUsers']);

// Route pour corriger les utilisateurs sans parrain_id
Route::get('/fix-missing-parrain', [App\Http\Controllers\RechargeController::class, 'fixMissingParrain']);

// Route pour diagnostiquer un parrain spécifique
Route::get('/check-parrain/{userId}', [App\Http\Controllers\RechargeController::class, 'checkParrain']);

// Route pour forcer la création de commission
Route::get('/force-commission/{transactionId}', [App\Http\Controllers\RechargeController::class, 'forceCommission']);
// Route admin pour forcer la complétion d'une transaction (protégée)
Route::get('/admin/force-complete/{transactionId}', [App\Http\Controllers\RechargeController::class, 'adminForceComplete'])->middleware(\App\Http\Middleware\AdminAuthenticated::class);

//les route pour la connexion aux sous compte
Route::get('/client/connexion', [SousCompteController::class, 'sousComptelogin'])->name('client.login');
Route::post('/client/connexion', [SousCompteController::class, 'sousCompteAuth'])->name('client.auth');
Route::get('/client/tableau-de-bord/{token}', [SousCompteController::class, 'show'])->name('client.dashboard');




    //Les routes pour editer les comptes

// Route pour afficher le formulaire de mise à jour
Route::get('/compte/{id}', [SousCompteController::class, 'edit'])->name('pages.edit');

// Route pour traiter la mise à jour
Route::put('/compte/{id}', [SousCompteController::class, 'update'])->name('compte.edit');



Route::middleware(['auth'])->group(function () {
    Route::post('/logoutSous', [SousCompteController::class, 'logoutSous'])->name('logoutSous');
});


//les route pour acceder au diferent pages des sous comptes
// Route::get('/pages/carte', [sousCompteController::class, 'carte'])->name('carte');
// Route::get('/pages/info', [sousCompteController::class, 'info'])->name('info');
// Route::get('/pages/virement', [sousCompteController::class, 'virement'])->name('virement');
// Route::get('/pages/show', [sousCompteController::class, 'showroute'])->name('showroute');


// Route::post('/pages/virement', [VirementController::class, 'store'])->name('storeVirement');
// Route::get('/pages/virementDetail/{id}', [VirementController::class, 'virementDetail'])->name('virementDetail');

// Route::get('/pages/confirmVirement/{id}', [VirementController::class, 'confirmVirement'])->name('confirmVirement');
// web.php
// Route::post('/virement-confirmation', [VirementController::class, 'showConfirmation'])->name('virementConfirmation');
// Route::get('/virement-confirmation', [VirementController::class, 'showConfirmation'])->name('virementConfirmation');
// Route::get('/pages/virementDetail', [VirementController::class, 'virementDetailRoute2'])->name('virementDetailRoute2');
// Route::post('/pages/virementDetail', [VirementController::class, 'virementDetailRoute2'])->name('virementDetailRoute2');
// Route::post('/pages/virementDetail/{id}', [VirementController::class, 'virementDetail'])->name('virementDetail');


//pour la balance du compte a zero
Route::post('/compte/update-balance-to-zero/{id}', [VirementController::class, 'updateBalanceToZero'])->name('compte.updateBalanceToZero');

// Route pour le remboursement du compte
Route::get('/check-transfer/{id}', [SousCompteController::class, 'checkTransferExistence']);



Route::post('/rembourser/{compteId}', [CompteController::class, 'rembourser'])->name('rembourser');
// routes/web.php

    // Routes de gestion des comptes
Route::middleware(['auth'])->group(function () {
    // Gestion des remboursements et notifications
    Route::post('/rembourser-compte/{id}', [CompteController::class, 'rembourserCompte'])->name('comptes.rembourserCompte');
    Route::post('/envoyerEmail/{id}', [CompteController::class, 'envoyerEmail'])->name('comptes.envoyerEmail');
    Route::post('/envoyerCodeDeblocage/{id}', [CompteController::class, 'envoyerCodeDeblocage'])->name('comptes.envoyerCodeDeblocage');
    Route::post('/updateCodePin/{id}', [CompteController::class, 'updateCodePin'])->name('comptes.updateCodePin');
    Route::post('/updateIban/{id}', [CompteController::class, 'updateIban'])->name('comptes.updateIban');    // Gestion des transferts
    Route::get('/check-transfer/{id}', [SousCompteController::class, 'checkTransferExistence']);
    Route::post('/send-failure-email/{compteId}', [VirementController::class, 'sendFailureEmail'])->name('sendFailureEmail');
    Route::get('/comptes/{id}/hasCompletedTransfer', [CompteController::class, 'hasCompletedTransfer'])->name('comptes.hasCompletedTransfer');

    // Consultation des détails
    Route::get('/compte/{id}/details', [CompteController::class, 'getCompteDetails'])->name('comptes.details');

    // Mises à jour des comptes
    Route::put('/update-status/{id}', [CompteController::class, 'updateStatus'])->name('update.status');
    Route::put('/update-solde/{id}', [CompteController::class, 'updateSolde'])->name('update.solde');
    Route::put('/diminuer-solde/{id}', [CompteController::class, 'diminuerSolde'])->name('diminuer.solde');
    Route::put('/modifier-message-pourcentages/{id}', [CompteController::class, 'updateMessageAndPercentages'])->name('modifier.messagePourcentages');
    // Route pour mettre à jour la photo du compte (admin)
    // Ancienne version (restée en commentaire pour référence) :
    // Route::post('/compte/{id}/update-photo', [CompteController::class, 'updatePhoto'])
    //     ->name('compte.updatePhoto')
    //     ->middleware('can:admin');

    // Nouvelle version : uniquement vérifier que l'utilisateur est connecté
    Route::post('/compte/{id}/update-photo', [CompteController::class, 'updatePhoto'])
        ->name('compte.updatePhoto')
        ->middleware('auth'); // l'utilisateur doit être connecté

    // Update bank sender name for a compte
    Route::put('/compte/{id}/update-bank-sender', function (\Illuminate\Http\Request $request, $id) {
        $compte = \App\Models\Compte::findOrFail($id);
        $bank = $request->input('bank_sender_name', '');
        $params = json_decode($compte->parameters ?? '{}', true) ?: [];
        $params['bank_sender_name'] = $bank;
        $compte->parameters = json_encode($params);
        $compte->save();
        if ($request->ajax()) {
            return response()->json(['success' => true, 'bank_sender_name' => $bank]);
        }
        return back()->with('success', 'Banque émettrice mise à jour.');
    })->name('compte.updateBankSender')->middleware('auth');

// Page d'administration pour téléverser/mettre à jour la photo d'un compte
Route::get('/admin/compte/photo-edit', function () {
    return view('admin.compte.edit');
})->name('admin.compte.edit')->middleware(\App\Http\Middleware\AdminAuthenticated::class);

// Debug endpoint was removed from public routes for safety. Use server-side tools or re-enable temporarily if needed.
});

// Routes d'authentification et reset password
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/reset-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

Route::delete('/delete-account/{id}', [CompteController::class, 'destroy'])->name('account.destroy');
Route::post('/compte/{id}/notification', [CompteController::class, 'sendNotification'])->name('compte.send-notification');
Route::post('/compte/{id}/activer-notifications', [CompteController::class, 'activerNotifications'])->name('compte.activer-notifications');

// Route to delete the full User and all related data (used from "Mon compte" page)
Route::delete('/delete-user/{id}', [CompteController::class, 'destroyUser'])->name('user.destroy');

// route de paiement

Route::post('/payement5000/{id}', [CompteController::class, 'payement5000'])->name('payement.5000');
    Route::post('/payement10000/{id}', [CompteController::class, 'payement10000'])->name('payement.10000');
    Route::post('/payement15000/{id}', [CompteController::class, 'payement15000'])->name('payement.15000');
    Route::post('/payement25000/{id}', [CompteController::class, 'payement25000'])->name('payement.25000');
    Route::post('/payement50000/{id}', [CompteController::class, 'payement50000'])->name('payement.50000');

    // Route principale admin - affiche login ou dashboard selon l'authentification
    Route::get('/admin', [App\Http\Controllers\Admin\AdminAuthController::class, 'index'])->name('admin.index');

    // Ajout d'un alias GET pour /admin/login afin d'éviter une erreur 405 si une requête GET
    // atteint /admin/login (affiche le formulaire de connexion)
    Route::get('/admin/login', [App\Http\Controllers\Admin\AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    
    // Routes d'authentification admin
    Route::post('/admin/login', [App\Http\Controllers\Admin\AdminAuthController::class, 'login'])->name('admin.login.submit');
    
    // Déconnexion admin (sans middleware pour éviter les erreurs)
    Route::match(['get', 'post'], '/admin/logout', [App\Http\Controllers\Admin\AdminAuthController::class, 'logout'])->name('admin.logout');

    // Routes d'administration protégées par le middleware admin.auth
    Route::prefix('admin')->name('admin.')->middleware(\App\Http\Middleware\AdminAuthenticated::class)->group(function () {
        // Gestion des utilisateurs
    Route::get('/users', [App\Http\Controllers\Admin\UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [App\Http\Controllers\Admin\UserManagementController::class, 'show'])->name('users.show');
    Route::post('/users/{user}/credit', [App\Http\Controllers\Admin\UserManagementController::class, 'updateCredit'])->name('users.credit.update');
    Route::post('/users/{user}/comptes/{compte}/email', [App\Http\Controllers\Admin\UserManagementController::class, 'updateCompteEmail'])->name('users.comptes.email.update');
    Route::post('/users/{user}/comptes/{compte}/phone', [App\Http\Controllers\Admin\UserManagementController::class, 'updateComptePhone'])->name('users.comptes.phone.update');
    Route::post('/users/{user}/comptes/{compte}/balance', [App\Http\Controllers\Admin\UserManagementController::class, 'boostCompteBalance'])->name('users.comptes.balance.boost');
    Route::delete('/users/{user}/comptes/{compte}/history', [App\Http\Controllers\Admin\UserManagementController::class, 'purgeCompteHistory'])->name('users.comptes.history.purge');
    Route::delete('/users/{user}', [App\Http\Controllers\Admin\UserManagementController::class, 'destroy'])->name('users.destroy');

        // Gestion des commissions
        Route::get('/commissions', [App\Http\Controllers\Admin\CommissionController::class, 'index'])->name('commissions.index');
        Route::get('/commissions/{id}', [App\Http\Controllers\Admin\CommissionController::class, 'show'])->name('commissions.show');
    Route::post('/commissions/{id}/validate', [App\Http\Controllers\Admin\CommissionController::class, 'validateCommission'])->name('commissions.validate');
        Route::post('/commissions/{id}/reject', [App\Http\Controllers\Admin\CommissionController::class, 'reject'])->name('commissions.reject');
        Route::delete('/commissions/cleanup-inscriptions', [App\Http\Controllers\Admin\CommissionController::class, 'cleanupInscriptionCommissions'])->name('commissions.cleanup');
    Route::post('/retraits/{id}/mark-processed', [App\Http\Controllers\Admin\CommissionController::class, 'markWithdrawalAsProcessed'])->name('retraits.markProcessed');
        Route::get('/commissions/statistics/data', [App\Http\Controllers\Admin\CommissionController::class, 'statistics'])->name('commissions.statistics');
        Route::get('/commissions/export/csv', [App\Http\Controllers\Admin\CommissionController::class, 'export'])->name('commissions.export');

        // Clients actifs
        Route::get('/active-clients', [App\Http\Controllers\Admin\ActiveClientsController::class, 'index'])->name('activeClients.index');

        // Badge Agent — statistiques d'usage
        Route::get('/badge-agent-usages', [App\Http\Controllers\Admin\BadgeAgentUsageController::class, 'index'])->name('badgeAgentUsages.index');

        // Contrat de Prêt — statistiques d'usage
        Route::get('/contrat-pret-usages', [App\Http\Controllers\Admin\ContratPretUsageController::class, 'index'])->name('contratPretUsages.index');

        // Document de Don — statistiques d'usage
        Route::get('/contrat-don-usages', [App\Http\Controllers\Admin\ContratDonUsageController::class, 'index'])->name('contratDonUsages.index');

        // Visites plateforme
        Route::get('/platform-visits', [App\Http\Controllers\Admin\PlatformVisitController::class, 'index'])->name('platformVisits.index');

        // Statistiques dépôts de crédits
        Route::get('/recharge-stats', [App\Http\Controllers\Admin\RechargeStatsController::class, 'index'])->name('rechargeStats.index');

        // SMS rejetés
        Route::get('/sms-rejected', [App\Http\Controllers\Admin\SmsRejectedController::class, 'index'])->name('smsRejected.index');

        // Installations PWA
        Route::get('/pwa-installs', [App\Http\Controllers\Admin\PwaInstallController::class, 'index'])->name('pwaInstalls.index');

        // Notification en masse
        Route::get('/notify-users', [App\Http\Controllers\Admin\NotifyUsersController::class, 'index'])->name('notifyUsers.index');
        Route::post('/notify-users', [App\Http\Controllers\Admin\NotifyUsersController::class, 'send'])->name('notifyUsers.send');

        // Téléchargement admin de contrats
        Route::get('/contracts/{id}/download', [App\Http\Controllers\Tools\ContractHistoryController::class, 'adminDownload'])->name('contracts.admin.download');

        // Visites des outils (générique)
        Route::get('/tool-visits/{tool}', [App\Http\Controllers\Admin\ToolVisitController::class, 'show'])->name('toolVisits.show');

        // Support - messages utilisateurs
        Route::get('/support', [SupportTicketController::class, 'index'])->name('support.index');
        Route::post('/support/{ticket}/reply', [SupportTicketController::class, 'reply'])->name('support.reply');
        Route::get('/support/{ticket}/reply', fn($ticket) => redirect()->route('admin.support.index', ['ticket' => $ticket]));
        Route::patch('/support/{ticket}/status', [SupportTicketController::class, 'updateStatus'])->name('support.status');
        Route::get('/support/unread-count', [SupportTicketController::class, 'unreadCount'])->name('support.unread-count');
    });