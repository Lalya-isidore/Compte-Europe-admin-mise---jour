<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('users.connexion');
});
use App\Http\Controllers\CompteController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SousCompteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VirementController;
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

    // Route::get('/pages/create', [PageController::class, 'create'])->name('pages.create');
    // Route::post('/pages', [PageController::class, 'store'])->name('pages.store');

    // Route::get('/pages/show', [compteController::class, 'show'])->name('pagesshow');
    Route::get('logout', [UserController::class, 'logout'])->name('logout');
    // Liste des comptes de l'utilisateur
    Route::get('/compte', [CompteController::class, 'compteview'])->name('compte.view');
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
// Route::get('/compte/{id}', [sousCompteController::class, 'edit'])->name('pages.edit');

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
    Route::post('/envoyerCodeDeblocage/{id}', [CompteController::class, 'envoyerCodeDeblocage'])->name('comptes.envoyerCodeDeblocage');    // Gestion des transferts
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

// route de paiement

Route::post('/payement5000/{id}', [CompteController::class, 'payement5000'])->name('payement.5000');
    Route::post('/payement10000/{id}', [CompteController::class, 'payement10000'])->name('payement.10000');
    Route::post('/payement25000/{id}', [CompteController::class, 'payement25000'])->name('payement.25000');
    Route::post('/payement50000/{id}', [CompteController::class, 'payement50000'])->name('payement.50000');

    // Route principale admin - affiche login ou dashboard selon l'authentification
    Route::get('/admin', [App\Http\Controllers\Admin\AdminAuthController::class, 'index'])->name('admin.index');
    
    // Routes d'authentification admin
    Route::post('/admin/login', [App\Http\Controllers\Admin\AdminAuthController::class, 'login'])->name('admin.login.submit');
    
    // Déconnexion admin (sans middleware pour éviter les erreurs)
    Route::post('/admin/logout', [App\Http\Controllers\Admin\AdminAuthController::class, 'logout'])->name('admin.logout');

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

        // Support - messages utilisateurs
        Route::get('/support', [SupportTicketController::class, 'index'])->name('support.index');
        Route::post('/support/{ticket}/reply', [SupportTicketController::class, 'reply'])->name('support.reply');
        Route::patch('/support/{ticket}/status', [SupportTicketController::class, 'updateStatus'])->name('support.status');
        Route::get('/support/unread-count', [SupportTicketController::class, 'unreadCount'])->name('support.unread-count');
    });