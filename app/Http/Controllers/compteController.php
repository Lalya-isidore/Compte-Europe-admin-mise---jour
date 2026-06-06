<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompteRequest;
use App\Mail\CodeDeblocageTransfertEmail;
use App\Models\Affiliation;
use App\Models\Compte;
use App\Models\Remboursement;
use App\Models\TransactionHistory;
use App\Models\Transfer;
use App\Notifications\OuvertureDeCompteEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Mail\CompteCreeMail;
use App\Mail\VirementEchecMail;
use App\Mail\RemborsementMail;
use App\Mail\SoldeAugmente;
use App\Mail\SoldeDiminue;
use App\Mail\CompteBloqueMail;
use App\Mail\CompteActiveMail;
use App\Mail\CodeDeblocageUtiliseMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Models\User; // Ajoutez cette ligne
use App\Models\UnlockCode;
use App\Services\SafeMailService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class CompteController extends Controller
{

    /**
     * Process an uploaded image: center-crop to square and resize, then store on public disk as JPEG.
     * Returns storage path (relative to disk) or null on failure.
     *
     * @param \Illuminate\Http\UploadedFile $uploadedFile
     * @param string $folder
     * @param int $size
     * @return string|null
     */
    private function getBankName(Compte $compte): string
    {
        $params = json_decode($compte->parameters ?? '{}', true) ?: [];
        if (!empty($params['bank_sender_name'])) {
            return $params['bank_sender_name'];
        }
        $regionKey = $compte->region ?: 'europe';
        $url = config("regions.{$regionKey}.client_login_url", 'TRANSFERFLUX');
        if (stripos($url, 'localhost') !== false) {
            return 'TRANSFERFLUX';
        }
        return strtoupper(str_replace(['https://','http://','www.','.world','.com','.fr','.net'], '', $url));
    }

    private function processAndStoreImage($uploadedFile, $folder = 'comptes-photos', $size = 300)
    {
        if (!$uploadedFile || !$uploadedFile->isValid()) {
            return null;
        }

        // Ensure folder exists
        Storage::disk('public')->makeDirectory($folder);

        $tmpPath = $uploadedFile->getPathname();
        $info = getimagesize($tmpPath);
        if (!$info) {
            return null;
        }

        $width = $info[0];
        $height = $info[1];
        $mime = $info['mime'];

        switch ($mime) {
            case 'image/jpeg':
            case 'image/jpg':
                $src = imagecreatefromjpeg($tmpPath);
                break;
            case 'image/png':
                $src = imagecreatefrompng($tmpPath);
                break;
            case 'image/gif':
                $src = imagecreatefromgif($tmpPath);
                break;
            default:
                return null;
        }

        if (!$src) {
            return null;
        }

        // Center crop to square
        $minSide = min($width, $height);
        $srcX = intval(($width - $minSide) / 2);
        $srcY = intval(($height - $minSide) / 2);

        $dst = imagecreatetruecolor($size, $size);
        // Preserve transparency for PNG and GIF by filling with white then handle alpha
        $white = imagecolorallocate($dst, 255, 255, 255);
        imagefill($dst, 0, 0, $white);

        imagecopyresampled($dst, $src, 0, 0, $srcX, $srcY, $size, $size, $minSide, $minSide);

        // Generate filename and store as JPEG
        $filename = uniqid('compte_') . '.jpg';
        $relativePath = rtrim($folder, '/') . '/' . $filename;
        $fullPath = Storage::disk('public')->path($relativePath);

        // Save as JPEG quality 85
        $saved = imagejpeg($dst, $fullPath, 85);

        // Free resources
        imagedestroy($src);
        imagedestroy($dst);

        return $saved ? $relativePath : null;
    }

    public function comptecreate(Compte $comptes, CompteRequest $request)
    {
        $authUser = Auth::user();
        if (!$authUser) {
            return redirect()->back()->with('error', 'Votre session a expiré. Veuillez vous reconnecter pour créer un compte.');
        }
        /** @var \App\Models\User $user */
        $user = $authUser;
        // Région du compte sélectionnée dans le formulaire
        $compteRegion = $request->input('compte_region', 'europe');
        if (!in_array($compteRegion, ['europe', 'afrique'])) {
            $compteRegion = 'europe';
        }

        // Coût dynamique selon la région du compte
        $regionConfig = config("regions.{$compteRegion}", config('regions.europe'));
        $baseCost = $regionConfig['compte_base_cost'] ?? 4000;
        $smsOptional = $regionConfig['compte_sms_optional'] ?? true;
        $smsCostPerUnit = $regionConfig['compte_sms_cost'] ?? 1000;

        if ($smsOptional) {
            $alertSmsRaw = $request->input('alert_sms');
            $alertSmsEnabled = filter_var($alertSmsRaw, FILTER_VALIDATE_BOOLEAN);
            $smsCost = $alertSmsEnabled ? $smsCostPerUnit : 0;
        } else {
            // Afrique : SMS obligatoire, inclus dans le coût de base
            $alertSmsEnabled = true;
            $smsCost = 0;
        }

        Log::info('Compte creation alert SMS flag', [
            'raw' => $request->input('alert_sms'),
            'enabled' => $alertSmsEnabled,
            'compteRegion' => $compteRegion,
        ]);
        $totalCost = $baseCost + $smsCost;
        // Vérification des crédits de l'utilisateur
        if ($user->credit_user < $totalCost) {
            $message = "Vous devez avoir au moins {$totalCost} crédits pour créer un compte.";
            if ($smsCost > 0) {
                $message = "Vous devez avoir au moins {$totalCost} crédits pour créer un compte avec alertes SMS.";
            }
            return redirect()->back()->with('error', $message);
        }

        $cardNumber = Compte::generateCardNumber();
        $cvv = Compte::generateCVV();
        $password = Compte::generatePassword();
        $code_virement = Compte::generateCodeVirement();
        // Handle optional uploaded profile photo
        $photoPath = null;
        if ($request->hasFile('photo')) {
            try {
                $photoPath = $this->processAndStoreImage($request->file('photo'), 'comptes-photos', 300);
            } catch (\Exception $e) {
                Log::warning('Erreur lors de l\'upload de la photo de profil: ' . $e->getMessage(), ['file' => $request->file('photo')]);
                $photoPath = null;
            }
        }

        $compte = Compte::create([
            'user_id' => Auth::id(),
            'region' => $compteRegion,
            // Générer et stocker un numéro de compte si la colonne existe en base
            'numerocompte' => Compte::generateAccountNumber(),
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'photo_path' => $photoPath,
            'password' => $password,
            'devise' => $request->devise,
            'lang' => $request->input('lang', 'fr'),
            'phone_number' => $request->phone_number,
            'country' => $request->country,
            'address' => $request->address,
            'account_balance' => $request->input('account_balance', 5000.00),
            'account_balance2' => $request->input('account_balance', 5000.00),
            'code_virement' => $code_virement,
            'account_type' => $request->input('account_type', 'Professionnel'),
            'account_status' => $request->input('account_status', 'Activé'), // Par défaut activé pour Flash Compte v1
            'transfer_supported' => $request->input('transfer_supported', 'Oui'),
            'card_number' => $cardNumber,
            'cvv' => $cvv,
            'start_percentage' => $request->input('start_percentage', 0),
            'end_percentage' => $request->input('end_percentage', 0),
            'iban' => $request->input('iban', ''),
            'failure_message' => (int)$request->input('end_percentage', 0) < 100 ? $request->input('failure_message', '') : '',
            'success_message' => (int)$request->input('end_percentage', 0) >= 100 ? $request->input('failure_message', '') : '',
            'alert_email' => true,
            'alert_sms' => $alertSmsEnabled,
        ]);

        // Enregistrer le solde initial dans l'historique pour les comptes créés manuellement
        try {
            TransactionHistory::create([
                'user_id' => Auth::id(),
                'compte_id' => $compte->id,
                'transaction_type' => 'Funds added',
                'devise' => $compte->devise,
                'amount' => $compte->account_balance,
                'description' => $this->getBankName($compte),
                'created_at' => now()->timezone(config('app.timezone')),
                'updated_at' => now()->timezone(config('app.timezone')),
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création de TransactionHistory initial: ' . $e->getMessage());
        }

        if ($alertSmsEnabled && !$compte->alert_sms) {
            $compte->alert_sms = true;
            $compte->save();
        }

        // Déduction des crédits
        $user->credit_user -= $totalCost;
        $user->save();

        // Envoi automatique des identifiants par e-mail si la case est cochée
        if ($request->has('send_credentials')) {
            try {
                $details = [
                    'title' => 'Ouverture de compte',
                    'body' => 'Votre compte a été créé avec succès.',
                ];
                SafeMailService::send($compte->email, new CompteCreeMail($details, $compte), 'Ouverture de compte');
                Log::info('Identifiants envoyés automatiquement par e-mail', [
                    'compte_id' => $compte->id,
                    'email' => $compte->email,
                ]);
            } catch (\Exception $e) {
                Log::error('Erreur lors de l\'envoi automatique des identifiants', [
                    'compte_id' => $compte->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // Redirection avec les données du compte créé pour la modal
        $clientName = strtoupper(trim(($compte->prenom ?? '') . ' ' . ($compte->nom ?? '')));
        $successMsg = "Compte créé avec succès. {$totalCost} crédits viennent d'être prélevés de votre compte.";
        if ($request->has('send_credentials')) {
            $successMsg .= '<br>Identifiant de connexion envoyé avec succès au client <strong>' . $clientName . '</strong> vers son e-mail <strong>&lt;' . e($compte->email) . '&gt;</strong>.';
        }
        return redirect()->route('compte.create')
            ->with('success', $successMsg)
            ->with('compte_created', $compte);
    }
    public function envoyerEmail($id)
    {
        Log::info('envoyerEmail appelé', ['id' => $id, 'ajax' => request()->ajax()]);

        $compte = Compte::find($id);

        if (!$compte) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['success' => false, 'error' => 'Compte non trouvé.'], 404);
            }
            return redirect()->back()->with('error', 'Compte non trouvé.');
        }

        $details = [
            'title' => 'Ouverture de compte',
            'body' => 'Vos identifiants de connexion.',
        ];

        $sent = SafeMailService::send($compte->email, new CompteCreeMail($details, $compte), 'Ouverture de compte');
        $clientName = strtoupper(trim(($compte->prenom ?? '') . ' ' . ($compte->nom ?? '')));

        if ($sent) {
            $successMsg = 'Identifiant de connexion envoyé avec succès au client <strong>' . $clientName . '</strong> vers son e-mail <strong>&lt;' . e($compte->email) . '&gt;</strong>.';
        } else {
            $successMsg = 'Erreur lors de l\'envoi. Vérifiez les logs.';
        }

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => $sent, 'message' => $successMsg]);
        }

        return redirect()->route("compte.create")->with($sent ? 'success' : 'error', $successMsg);
    }

    public function envoyerCodeDeblocage($id)
    {
        $compte = Compte::find($id);

        if (!$compte) {
            return redirect()->back()->with('error', 'Compte non trouvé.');
        }

        try {
            // Générer un nouveau code de déblocage
            $unlockCode = UnlockCode::createForCompte($compte, null, [
                'code' => $compte->code_virement,
            ]);

            $details = [
                'title' => 'Code de déblocage de votre transfert',
                'code' => $unlockCode->code,
                'expires_at' => $unlockCode->expires_at->format('H:i'),
                'compte_numero' => $compte->numerocompte,
            ];

            // Envoyer le code au client (Compte->email)
            if ($compte->email) {
                SafeMailService::send($compte->email, new CodeDeblocageTransfertEmail($details, $compte), 'Code de déblocage');
                $clientName = strtoupper(trim(($compte->prenom ?? '') . ' ' . ($compte->nom ?? '')));
                $successMsg = 'Code de déblocage envoyé avec succès au client <strong>' . $clientName . '</strong> vers son e-mail <strong>&lt;' . e($compte->email) . '&gt;</strong>.';
                
                if (request()->ajax() || request()->wantsJson()) {
                    return response()->json(['success' => true, 'message' => $successMsg]);
                }
                
                return redirect()->back()->with('success', $successMsg);
            } else {
                if (request()->ajax() || request()->wantsJson()) {
                    return response()->json(['success' => false, 'error' => 'Impossible de trouver l\'email du client.']);
                }
                return redirect()->back()->with('error', 'Impossible de trouver l\'email du client.');
            }
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi du code de déblocage: ' . $e->getMessage());
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['success' => false, 'error' => 'Une erreur est survenue lors de l\'envoi.']);
            }
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'envoi du code de déblocage.');
        }
    }


    public function overview()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('connexion');
        }

        $latestCompte = $user->comptes()->latest()->first();

        $phone = $user->phone ?? optional($latestCompte)->phone_number;
        $country = optional($latestCompte)->country;
        $countryFromPhone = $this->guessCountryFromPhone($phone);
        $resolvedCountry = $countryFromPhone ?? ($country ?: 'Non renseigné');

        $affiliation = Affiliation::where('user_id', $user->id)->first();
        $affiliateCode = $affiliation->code_affiliation ?? $user->code_parrainage;
        $defaultRegisterUrl = 'https://flashbilan.fr/inscription';
        $configuredRegisterUrl = trim((string) config('services.affiliation.register_url', ''));
        $registerUrlBase = $configuredRegisterUrl !== '' ? $configuredRegisterUrl : $defaultRegisterUrl;
        $registerUrl = rtrim($registerUrlBase, '/');
        $separator = str_contains($registerUrl, '?') ? '&' : '?';
        $affiliateLink = $affiliateCode ? sprintf('%s%sref=%s', $registerUrl, $separator, $affiliateCode) : null;

        $signupDate = $user->created_at ? Carbon::parse($user->created_at)->setTimezone('UTC') : null;
        $sessionTimezone = config('phone.default_timezone', config('app.timezone', 'UTC'));
        $sessionTimezoneLabel = config('phone.default_timezone_label', 'UTC+1');
        $lastLogin = Carbon::now($sessionTimezone);

        // IMPORTANT: Pour la page "Mon compte" nous affichons toujours
        // le statut comme "Actif" tant que l'utilisateur n'a pas perdu
        // l'accès au compte administrateur qui gère le système.
        // Le statut est donc forcé ici indépendamment du statut du dernier compte créé.
        $statusLabel = 'Actif';
        $statusVariant = 'success';

        return view('compte.profile', [
            'user' => $user,
            'profile' => [
                'full_name' => trim("{$user->prenom} {$user->nom}"),
                'email' => $user->email,
                'phone' => $phone ?? 'Non renseigné',
                'country' => $resolvedCountry,
                'signup_date' => $signupDate,
                'last_login' => $lastLogin,
                'last_login_timezone_label' => $sessionTimezoneLabel,
                'affiliation_link' => $affiliateLink,
                'affiliate_code' => $affiliateCode,
                'status_label' => $statusLabel,
                'status_variant' => $statusVariant,
            ],
        ]);
    }

    protected function guessCountryFromPhone(?string $phone): ?string
    {
        if (!$phone) {
            return null;
        }

        $normalized = preg_replace('/[^0-9+]/', '', $phone);
        if (!$normalized) {
            return null;
        }

        if (str_starts_with($normalized, '00')) {
            $normalized = '+' . substr($normalized, 2);
        } elseif ($normalized[0] !== '+') {
            $normalized = '+' . $normalized;
        }

        $map = config('phone.prefix_to_country', []);
        $codes = array_keys($map);
        usort($codes, fn($a, $b) => strlen($b) <=> strlen($a));

        foreach ($codes as $code) {
            if (str_starts_with($normalized, $code)) {
                return $map[$code];
            }
        }

        return null;
    }


    public function compteview()
    {
        // Charger uniquement les comptes de l'utilisateur connecté
        $comptes = Compte::where('user_id', Auth::id())
            ->where('numerocompte', 'NOT LIKE', 'test\_%')
            ->latest()
            ->get();

        // Déterminer précisément si un compte a déjà eu un virement "completed"
        // Faisons une requête par compte (exists) pour éviter les faux positifs
        // qui peuvent provenir d'agrégations ou de valeurs duplicatas.
        $comptes = $comptes->map(function ($compte) {
            // Le bouton remboursement s'affiche seulement si le DERNIER transfert est 'completed'
            // Use transaction_histories (compte_id correctly linked) to find the last
            // outgoing transfer for this specific account.
            $lastHistory = \App\Models\TransactionHistory::where('compte_id', $compte->id)
                ->where('transaction_type', 'Transfer sent')
                ->whereNotNull('transfer_id')
                ->latest()
                ->first();

            $compte->has_completed_transfer = false;
            $compte->last_transfer_amount = null;
            if ($lastHistory && $lastHistory->transfer_id) {
                $lastTransfer = \App\Models\Transfer::find($lastHistory->transfer_id);
                $compte->has_completed_transfer = $lastTransfer
                    && $lastTransfer->status === 'completed'
                    && $lastTransfer->user_id == $compte->user_id;
                if ($compte->has_completed_transfer) {
                    $compte->last_transfer_amount = $lastTransfer->solidvire;
                }
            }

            // Détecter si un UnlockCode a déjà été consommé pour ce compte (utilisé pour afficher
            // le libellé "Code déjà utilisé") — c'est plus précis que se baser sur les transferts.
            $compte->has_used_unlock_code = (bool) \App\Models\UnlockCode::where('compte_id', $compte->id)
                ->whereNotNull('used_at')
                ->exists();

            return $compte;
        });

        return view('compte.create', [
            'comptes' => $comptes,
            'availableCredits' => Auth::user()->credit_user ?? 0,
        ]);
    }
    public function show()
    {
        return view('pages.show');
    }




    public function rembourserCompte($id)
    {
        $compte = Compte::find($id);
        // dd($compte);
        if ($compte) {
            // Find last outgoing transfer for this specific account via transaction_histories
            // (transaction_histories has compte_id correctly linked, unlike transfers where compte_id=NULL)
            $lastHistory = \App\Models\TransactionHistory::where('compte_id', $compte->id)
                ->where('transaction_type', 'Transfer sent')
                ->whereNotNull('transfer_id')
                ->latest()
                ->first();

            if (!$lastHistory || !$lastHistory->transfer_id) {
                return redirect()->back()->with('error', 'Aucun virement en attente de remboursement.');
            }

            $lastTransfer = Transfer::find($lastHistory->transfer_id);
            if (!$lastTransfer || $lastTransfer->status !== 'completed' || $lastTransfer->user_id != $compte->user_id) {
                return redirect()->back()->with('error', 'Aucun virement en attente de remboursement.');
            }

            $rembourse = "rembourse";
            // Mettre à jour le solde du compte
            $compte->account_balance = $compte->account_balance + $lastTransfer->solidvire;
            $compte->account_balance2 = ($compte->account_balance2 ?? 0) + $lastTransfer->solidvire;
            $compte->save();

            // Mettre à jour le statut du transfert en "rembourse"
            $lastTransfer->status = $rembourse;
            $lastTransfer->save();

            // Enregistrer dans l'historique
            TransactionHistory::create([
                'user_id' => $compte->user_id,
                'compte_id' => $compte->id,
                'transaction_type' => 'Refund received',
                'devise' => $compte->devise,
                'amount' => $lastTransfer->solidvire,
                'description' => $lastTransfer->name_servieur,
                'created_at' => now()->timezone(config('app.timezone')),
                'updated_at' => now()->timezone(config('app.timezone')),
            ]);

            // Enregistrer le remboursement dans la table rembourcements
            try {
                Remboursement::create([
                    'compte_id' => $compte->id,
                    'montant' => $lastTransfer->solidvire,
                ]);
            } catch (\Exception $e) {
                Log::error('Erreur lors de la création du remboursement en base: ' . $e->getMessage(), [
                    'compte_id' => $compte->id,
                    'montant' => $lastTransfer->solidvire,
                ]);
            }

            $details = [
                'title' => 'Echec de Transfert. Remboursement du Solde',
                'body' => 'Votre virement de ' . $lastTransfer->solidvire . ' ' . $compte->devise . ' a echoué.',
            ];

            SafeMailService::send($compte->email, new RemborsementMail($details, $compte, $lastTransfer), 'Remboursement');

            return redirect()->back()->with('success', 'Le remboursement a été effectué avec succès.');
        } else {
            return redirect()->back()->with('error', 'Impossible de trouver le compte.');
        }
    }



    public function getCompteDetails($id)
    {
        $compte = Compte::find($id);

        if (!$compte) {
            return response()->json(['error' => 'Compte non trouvé.'], 404);
        }

        // Use transaction_histories (compte_id correctly linked) to find the last
        // outgoing transfer for this specific account.
        $lastHistory = \App\Models\TransactionHistory::where('compte_id', $compte->id)
            ->where('transaction_type', 'Transfer sent')
            ->whereNotNull('transfer_id')
            ->latest()
            ->first();

        $hasCompletedTransfer = false;
        if ($lastHistory && $lastHistory->transfer_id) {
            $lastTransfer = Transfer::find($lastHistory->transfer_id);
            $hasCompletedTransfer = $lastTransfer
                && $lastTransfer->status === 'completed'
                && $lastTransfer->user_id == $compte->user_id;
        }

        // Indique si le remboursement peut être proposé : il existe un virement complété pour CE compte
        $canRefund = $hasCompletedTransfer;

        // Indique si le dernier UnlockCode généré a déjà été consommé (used_at non nul)
        try {
            $latestUnlock = \App\Models\UnlockCode::where('compte_id', $compte->id)
                ->latest()
                ->first();

            $hasUsedUnlockCode = $latestUnlock ? (bool) $latestUnlock->used_at : false;

            if ($latestUnlock) {
                Log::info('getCompteDetails: unlock code status', [
                    'compte_id' => $compte->id,
                    'unlock_id' => $latestUnlock->id,
                    'code_used' => $hasUsedUnlockCode,
                ]);
            }
        } catch (\Throwable $e) {
            // If the DB schema is not up-to-date (missing columns) or another SQL error occurs,
            // log it and treat as not used to avoid throwing a 500 for the admin view.
            Log::error('Error checking UnlockCode.used_at for compte: ' . $compte->id, ['exception' => $e->getMessage()]);
            $hasUsedUnlockCode = false;
        }

        // Resolve photo_url: if photo_path is an absolute URL (ui-avatars etc.) use it directly,
        // otherwise build a public disk URL when a storage-relative path is present.
        $photoPathValue = $compte->photo_path;
        $photoUrlValue = null;
        if (!empty($photoPathValue)) {
            // treat absolute URLs as-is
            if (str_starts_with($photoPathValue, 'http://') || str_starts_with($photoPathValue, 'https://')) {
                $photoUrlValue = $photoPathValue;
                // add cache-busting based on file modification time when possible
                try {
                    if (!empty($photoPathValue) && !(str_starts_with($photoPathValue, 'http://') || str_starts_with($photoPathValue, 'https://'))) {
                        $server = Storage::disk('public')->path($photoPathValue);
                        if (file_exists($server)) {
                            $photoUrlValue .= '?v=' . filemtime($server);
                        } else {
                            $photoUrlValue .= '?v=' . time();
                        }
                    }
                } catch (\Throwable $e) {
                    // ignore and keep original URL
                }
            } else {
                // storage disk URL (will prefix with /storage/...)
                try {
                    // use asset() to generate a URL that respects the application's base path
                    $photoUrlValue = asset('storage/' . ltrim($photoPathValue, '/'));
                } catch (\Throwable $e) {
                    // fallback: build a relative storage path
                    $photoUrlValue = 'storage/' . ltrim($photoPathValue, '/');
                }
            }
        }

        return response()->json([
            'nom' => $compte->nom,
            'email' => $compte->email,
            'phone' => $compte->phone_number,
            'country' => $compte->country,
            'password' => $compte->password,
            'codeVirement' => $compte->code_virement,
            'address' => $compte->address,
            'balance' => $compte->account_balance,
            'accountType' => $compte->account_type,
            'accountStatus' => $compte->account_status,
            'transferSupported' => $compte->transfer_supported,
            'numerocompte' => $compte->numerocompte,
            'startPercentage' => $compte->start_percentage,
            'endPercentage' => $compte->end_percentage,
            'failureMessage' => $compte->failure_message,
            'compteId' => $compte->id,
            'devise' => $compte->devise,
            'alertEmail' => $compte->alert_email,
            'alertSms' => $compte->alert_sms,
            // 'codeUsed' doit refléter si un code de déblocage a effectivement été consommé
            // (unlock_codes.used_at) et non la présence d'un virement complété.
            'codeUsed' => $hasUsedUnlockCode,
            'canRefund' => $canRefund,
            // Coût de création dynamique selon région
            'creationCost' => (function () use ($compte) {
                $userRegion = $compte->user->region ?? 'europe';
                $rc = config("regions.{$userRegion}", config('regions.europe'));
                $base = $rc['compte_base_cost'] ?? 4000;
                $smsOpt = $rc['compte_sms_optional'] ?? true;
                $smsCost = $rc['compte_sms_cost'] ?? 1000;
                return $smsOpt ? $base + ($compte->alert_sms ? $smsCost : 0) : $base;
            })(),
            'createdAt' => optional($compte->created_at)->toAtomString(),
            'hasCompletedTransfer' => $hasCompletedTransfer,
            // Public URL for profile photo when available
            'photo_path' => $photoPathValue,
            'photo_url' => $photoUrlValue,
        ]);
    }

    /**
     * Debug helper: return storage info for a compte photo.
     * Admin-only route intended for debugging; returns JSON with
     * photo_path, photo_url, server path and file metadata.
     */
    public function debugPhoto($id)
    {
        $compte = Compte::find($id);

        if (!$compte) {
            return response()->json(['error' => 'Compte non trouvé.'], 404);
        }

        $photoPath = $compte->photo_path;
        // If photo_path is an absolute URL, use it directly for debugging; otherwise use storage disk helpers
        if (!empty($photoPath) && (str_starts_with($photoPath, 'http://') || str_starts_with($photoPath, 'https://'))) {
            $photoUrl = $photoPath;
            $diskExists = false;
            $serverPath = null;
            $isReadable = false;
            $size = null;
            $lastModified = null;
        } else {
            $photoUrl = $photoPath ? asset('storage/' . ltrim($photoPath, '/')) : null;
            $diskExists = $photoPath ? Storage::disk('public')->exists($photoPath) : false;
            $serverPath = $diskExists ? Storage::disk('public')->path($photoPath) : null;
            $isReadable = $serverPath ? is_readable($serverPath) : false;
            $size = $diskExists ? Storage::disk('public')->size($photoPath) : null;
            $lastModified = $serverPath && file_exists($serverPath) ? date('c', filemtime($serverPath)) : null;
        }

        return response()->json([
            'compte_id' => $compte->id,
            'photo_path' => $photoPath,
            'photo_url' => $photoUrl,
            'disk_exists' => $diskExists,
            'server_path' => $serverPath,
            'is_readable' => $isReadable,
            'size_bytes' => $size,
            'last_modified' => $lastModified,
        ]);
    }

    public function updateCodePin(Request $request, $id)
    {
        $compte = Compte::find($id);
        if (!$compte) {
            if ($request->ajax()) return response()->json(['status' => 'error', 'message' => 'Compte non trouvé.'], 404);
            return redirect()->back()->with('error', 'Compte non trouvé.');
        }

        $newPin = Compte::generatePassword();
        $compte->password = $newPin;
        $compte->save();

        $clientName = strtoupper(trim(($compte->prenom ?? '') . ' ' . ($compte->nom ?? '')));
        $msg = 'Code pin de l\'accès client <strong>' . $clientName . '</strong> mise à jour.';
        
        if ($request->ajax()) {
            return response()->json(['status' => 'success', 'message' => $msg]);
        }
        
        return redirect()->back()->with('success', $msg);
    }

    public function updateIban(Request $request, $id)
    {
        $compte = Compte::find($id);
        if (!$compte) {
            return redirect()->back()->with('error', 'Compte non trouvé.');
        }

        $compte->iban = $request->input('iban', '');
        $compte->save();

        $clientName = strtoupper(trim(($compte->prenom ?? '') . ' ' . ($compte->nom ?? '')));
        return redirect()->back()->with('success', 'L\'IBAN du client <strong>' . $clientName . '</strong> a été mis à jour avec succès.');
    }

    public function updateStatus(Request $request, $id)
    {
        $compte = Compte::find($id);

        if (!$compte) {
            if ($request->ajax()) return response()->json(['status' => 'error', 'message' => 'Compte non trouvé.'], 404);
            return redirect()->back()->withErrors(['error' => 'Compte non trouvé.']);
        }

        $ancienStatut = $compte->account_status;
        $nouveauStatut = $request->input('account_status');

        $compte->account_status = $nouveauStatut;
        $compte->save();

        // Envoyer un email si le statut change vers "Bloqué" ou "Activé"
        if ($nouveauStatut === 'Bloqué' && $ancienStatut !== 'Bloqué') {
            SafeMailService::send($compte->email, new CompteBloqueMail($compte), 'Compte bloqué');
        } elseif ($nouveauStatut === 'Activé' && $ancienStatut !== 'Activé') {
            SafeMailService::send($compte->email, new CompteActiveMail($compte), 'Compte activé');
        }

        $msg = 'Statut du compte mis à jour avec succès.';
        if ($request->ajax()) {
            return response()->json(['status' => 'success', 'message' => $msg]);
        }

        return redirect()->back()->with('success', $msg);
    }
    public function updateMessageAndPercentages(Request $request, $id)
    {
        \Log::info("Modification demandée pour le compte ID: $id", ['all' => $request->all()]);
        
        $data = $request->validate([
            'failure_message' => 'required|string|min:3',
            'start_percentage' => 'required|integer|min:0|max:99|lt:end_percentage',
            'end_percentage' => 'required|integer|min:1|max:100|gt:start_percentage',
        ], [
            'required' => 'Le champ :attribute est requis.',
            'min' => 'Le champ :attribute doit faire au moins :min caractères.',
            'lt' => 'Le :attribute doit être inférieur au pourcentage d\'arrêt.',
            'gt' => 'Le :attribute doit être supérieur au pourcentage de départ.',
        ], [
            'failure_message' => 'message à afficher',
            'start_percentage' => 'pourcentage de départ',
            'end_percentage' => 'pourcentage d\'arrêt',
        ]);

        $compte = Compte::find($id);

        if (!$compte) {
            return redirect()->back()->with('error', 'Compte non trouvé.');
        }

        $newMessage = trim($data['failure_message']);
        $newStart = (int) $data['start_percentage'];
        $newEnd = (int) $data['end_percentage'];

        $originalMessage = trim((string) $compte->failure_message);
        $originalEnd = (int) $compte->end_percentage;
        $originalStart = (int) $compte->start_percentage;

        $messageChanged = $newMessage !== $originalMessage;
        $startChanged = $newStart !== $originalStart;
        $endChanged = $newEnd !== $originalEnd;

        if (!$messageChanged && !$startChanged && !$endChanged) {
            return redirect()->back()
                ->with('error', 'Aucune modification détectée. Veuillez modifier le message ou les pourcentages.')
                ->withInput();
        }

        $compte->failure_message = $newMessage;
        $compte->start_percentage = $newStart;
        $compte->end_percentage = $newEnd;
        $compte->code_virement = Compte::generateCodeVirement();
        $compte->save();

        Log::channel('single')->info('MISE A JOUR MESSAGE ET POURCENTAGES', [
            'compte_id' => $compte->id,
            'ancien_message' => $originalMessage,
            'nouveau_message' => $newMessage,
            'ancien_start_percentage' => $originalStart,
            'ancien_end_percentage' => $originalEnd,
            'nouveau_start_percentage' => $compte->start_percentage,
            'nouveau_end_percentage' => $compte->end_percentage,
            'nouveau_code' => $compte->code_virement,
            'action' => 'updateMessageAndPercentages',
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Les informations ont bien été mise à jour avec succès, un nouveau code de transfert a été généré. Pour plus de détails, veuillez consulter la liste des accès.');
    }

    /**
     * Met à jour la photo de profil d'un compte (Admin uniquement)
     */
    public function updatePhoto(Request $request, $id)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $compte = Compte::find($id);

        // Helper to decide if the client expects JSON
        $expectsJson = $request->wantsJson() || $request->ajax() || $request->isJson();

        if (!$compte) {
            if ($expectsJson) {
                return response()->json(['error' => 'Compte non trouvé.'], 404);
            }
            return redirect()->back()->with('error', 'Compte non trouvé.');
        }

        // Authenticated user may change the profile photo (page is already auth-protected).
        $user = Auth::user();
        if (!$user) {
            Log::warning('Tentative non autorisée de mise à jour de photo', [
                'compte_id' => $compte->id,
                'user_id' => $user?->id,
                'user_role' => $user?->role ?? null,
            ]);

            if ($expectsJson) {
                return response()->json(['error' => 'Vous n\'êtes pas autorisé à modifier la photo de ce compte.'], 403);
            }

            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à modifier la photo de ce compte.');
        }

        // Supprimer proprement l'ancienne photo si elle existe sur le disque public
        if (!empty($compte->photo_path) && Storage::disk('public')->exists($compte->photo_path)) {
            try {
                Storage::disk('public')->delete($compte->photo_path);
            } catch (\Throwable $e) {
                Log::warning('Impossible de supprimer l\'ancienne photo', ['path' => $compte->photo_path, 'error' => $e->getMessage()]);
            }
        }

        // Traitement et stockage
        $photoPath = $this->processAndStoreImage($request->file('photo'), 'comptes-photos', 300);

        if ($photoPath) {
            $compte->photo_path = $photoPath; // Utiliser le chemin tel quel
            $compte->save();

            $photoUrl = asset('storage/' . ltrim($photoPath, '/'));
            // append version to bust cache
            try {
                $serverPathForVersion = Storage::disk('public')->path($photoPath);
                if (file_exists($serverPathForVersion)) {
                    $photoUrl .= '?v=' . filemtime($serverPathForVersion);
                } else {
                    $photoUrl .= '?v=' . time();
                }
            } catch (\Throwable $e) {
                // ignore
            }

            if ($expectsJson) {
                return response()->json([
                    'success' => true,
                    'photo_path' => $photoPath,
                    'photo_url' => $photoUrl,
                ], 200);
            }

            return redirect()->back()->with('success', 'Photo de profil mise à jour avec succès.');
        }

        if ($expectsJson) {
            return response()->json(['error' => 'Impossible de traiter l\'image fournie.'], 422);
        }

        return redirect()->back()->with('error', 'Impossible de traiter l\'image fournie.');
    }


    public function updateSolde(Request $request, $id)
    {
        $compte = Compte::find($id);
        $montant = $request->input('montant');

        // Garder l'ancien solde pour le log
        $old_balance = $compte->account_balance;

        $compte->account_balance += $montant;
        $compte->account_balance2 += $montant;

        // Régénérer le code de virement (utile pour tracer les changements)
        $compte->code_virement = Compte::generateCodeVirement();

        // LOG IMPORTANT
        Log::channel('single')->info('CODE VIREMENT REGENERE', [
            'compte_id' => $compte->id,
            'ancien_solde' => $old_balance,
            'nouveau_solde' => $compte->account_balance,
            'nouveau_code' => $compte->code_virement,
            'action' => 'updateSolde',
            'montant_ajoute' => $montant,
            'user_id' => Auth::id(),
        ]);

        $compte->save();

        // Enregistrer dans l'historique
        TransactionHistory::create([
            'user_id' => $compte->user_id,
            'compte_id' => $compte->id,
            'transaction_type' => 'Recharge',
            'devise' => $compte->devise,
            'amount' => $montant,
            'description' => $this->getBankName($compte),
            'created_at' => now()->timezone(config('app.timezone')),
            'updated_at' => now()->timezone(config('app.timezone')),
        ]);

        // === Bonus fidélité : 5000 crédits à la 4e recharge en 30 jours ===
        $since30Days = now()->subDays(30);

        $rechargesLast30Days = TransactionHistory::where('compte_id', $compte->id)
            ->where('transaction_type', 'Recharge')
            ->where('created_at', '>=', $since30Days)
            ->count();

        $bonusAlreadyGiven = TransactionHistory::where('compte_id', $compte->id)
            ->where('transaction_type', 'Loyalty bonus')
            ->where('created_at', '>=', $since30Days)
            ->exists();

        if ($rechargesLast30Days >= 4 && !$bonusAlreadyGiven) {
            $bonusAmount = 5000;
            $compte->account_balance += $bonusAmount;
            $compte->save();

            TransactionHistory::create([
                'user_id' => $compte->user_id,
                'compte_id' => $compte->id,
                'transaction_type' => 'Loyalty bonus',
                'devise' => $compte->devise,
                'amount' => $bonusAmount,
                'description' => 'Bonus fidélité – 4 recharges ce mois',
                'created_at' => now()->timezone(config('app.timezone')),
                'updated_at' => now()->timezone(config('app.timezone')),
            ]);

            Log::info('BONUS FIDÉLITÉ ACCORDÉ', [
                'compte_id' => $compte->id,
                'bonus' => $bonusAmount,
                'recharges_mois' => $rechargesThisMonth,
            ]);
        }

        // Envoyer un email au client (désactivable via la variable d'environnement BALANCE_EMAILS)
        if (env('BALANCE_EMAILS', true)) {
            SafeMailService::send($compte->email, new SoldeAugmente($compte, $montant), 'Augmentation solde');
        }

        $msg = "Ajout d'un montant de <b>" . number_format($montant, 2, ',', ' ') . " " . $compte->devise . "</b> au solde de l'accès client <b>" . $compte->prenom . " " . $compte->nom . "</b>.";
        if ($request->ajax()) {
            return response()->json(['status' => 'success', 'message' => $msg]);
        }

        return redirect()->back()->with('success', $msg . ' Pour plus de détails, veuillez consulter la liste des accès.');
    }

    public function diminuerSolde(Request $request, $id)
    {
        $request->validate([
            'montant' => 'required|numeric|min:0',
        ]);

        $compte = Compte::find($id);
        $montant = $request->input('montant');

        // Vérifiez si le solde ne deviendra pas négatif
        if ($compte->account_balance - $montant < 0) {
            $err = 'Le solde du compte ne peut pas devenir négatif.';
            if ($request->ajax()) return response()->json(['status' => 'error', 'message' => $err], 422);
            return redirect()->back()->with('error', $err);
        }

        // Garder l'ancien solde pour le log
        $old_balance = $compte->account_balance;

        $compte->account_balance -= $montant;
        $compte->account_balance2 -= $montant;

        // Régénérer le code de virement lorsqu'on modifie le solde (sécurité / traçabilité)
        $compte->code_virement = Compte::generateCodeVirement();

        // LOG IMPORTANT
        Log::channel('single')->info('SOLDE DIMINUE', [
            'compte_id' => $compte->id,
            'ancien_solde' => $old_balance,
            'nouveau_solde' => $compte->account_balance,
            'action' => 'diminuerSolde',
            'montant_retire' => $montant,
            'user_id' => Auth::id(),
        ]);

        $compte->save();

        // Enregistrer dans l'historique
        TransactionHistory::create([
            'user_id' => $compte->user_id,
            'compte_id' => $compte->id,
            'transaction_type' => 'Funds deducted',
            'devise' => $compte->devise,
            'amount' => $montant,
            'description' => $this->getBankName($compte),
            'created_at' => now()->timezone(config('app.timezone')),
            'updated_at' => now()->timezone(config('app.timezone')),
        ]);

        // Envoyer un email au client (désactivable via la variable d'environnement BALANCE_EMAILS)
        if (env('BALANCE_EMAILS', true)) {
            SafeMailService::send($compte->email, new SoldeDiminue($compte, $montant), 'Diminution solde');
        }

        $msg = "Retrait d'un montant de <b>" . number_format($montant, 2, ',', ' ') . " " . $compte->devise . "</b> au solde de l'accès client <b>" . $compte->prenom . " " . $compte->nom . "</b>.";
        if ($request->ajax()) {
            return response()->json(['status' => 'success', 'message' => $msg]);
        }

        return redirect()->back()->with('success', $msg . ' Pour plus de détails, veuillez consulter la liste des accès.');
    }


    public function modifierPourcentages(Request $request, $id)
    {
        // Valider les données du formulaire
        $request->validate([
            'start_percentage' => 'required|integer|min:0|max:100|lte:end_percentage',
            'end_percentage' => 'required|integer|min:1|max:100|gte:start_percentage',
        ]);

        // Récupérer les données du formulaire
        $startPercentage = $request->input('start_percentage');
        $endPercentage = $request->input('end_percentage');

        $compte = Compte::find($id);
        if (!$compte) {
            return redirect()->back()->with('error', 'Le compte associé n\'a pas été trouvé.');
        }

        if (!$compte->failure_message || trim($compte->failure_message) === '') {
            return redirect()->back()->with('error', 'Veuillez définir un message d\'échec avant de modifier les pourcentages.');
        }

        $originalStart = $compte->start_percentage;
        $originalEnd = $compte->end_percentage;

        $compte->start_percentage = $startPercentage;
        $compte->end_percentage = $endPercentage;
        $compte->code_virement = Compte::generateCodeVirement(); // Générer un nouveau code de virement

        // LOG IMPORTANT
        Log::channel('single')->info('CODE VIREMENT REGENERE', [
            'compte_id' => $compte->id,
            'ancien_start_percentage' => $originalStart,
            'ancien_end_percentage' => $originalEnd,
            'nouveau_start_percentage' => $compte->start_percentage,
            'nouveau_end_percentage' => $compte->end_percentage,
            'nouveau_code' => $compte->code_virement,
            'action' => 'modifierPourcentages',
            'user_id' => Auth::id(),
        ]);

        $compte->save();

        // Retourner une réponse réussie ou rediriger l'utilisateur
        return redirect()->back()->with('success', 'Les informations ont bien été mise à jour avec succès, un nouveau code de transfert a été généré. Pour plus de détails, veuillez consulter la liste des accès.');
    }


    /**
     * Delete a single Compte (account). This should not delete the parent User.
     * It removes related transfers safely (schema-check) then deletes the compte.
     */
    public function destroy($id)
    {
        try {
            $compte = Compte::findOrFail($id);

            // Only owner can delete their compte
            if ($compte->user_id !== Auth::id()) {
                return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à supprimer ce compte.');
            }

            // Remove related transfers safely
            try {
                if (Schema::hasColumn('transfers', 'compte_id')) {
                    $compte->transfers()->delete();
                } else {
                    if (!empty($compte->numerocompte)) {
                        Transfer::where('numerocompte', $compte->numerocompte)
                            ->where('user_id', $compte->user_id)
                            ->delete();
                    }
                }
            } catch (\Throwable $e) {
                Log::warning('Error while deleting related transfers for compte before destroy: ' . $e->getMessage(), [
                    'compte_id' => $compte->id,
                    'numerocompte' => $compte->numerocompte ?? null,
                ]);
            }

            $compte->delete();

            return redirect()->back()->with('success', 'Le compte a été supprimé avec succès.');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression du compte ' . $id . ' : ' . $e->getMessage(), [
                'exception' => $e->getMessage(),
                'trace' => method_exists($e, 'getTraceAsString') ? $e->getTraceAsString() : null,
                'compte_id' => $id,
                'user_id' => Auth::id(),
            ]);

            return redirect()->back()->with('error', 'Une erreur s\'est produite lors de la suppression du compte.');
        }
    }

    /**
     * Delete the full User and all related data via DB delete (relying on foreign-key cascades).
     * This route is invoked from the "Mon compte" page when the user wants to delete their whole account.
     */
    public function destroyUser($id)
    {
        try {
            $user = User::findOrFail($id);

            if ($user->id !== Auth::id()) {
                return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à supprimer cet utilisateur.');
            }

            DB::beginTransaction();
            DB::table('users')->where('id', $user->id)->delete();
            DB::commit();

            Log::info('User and related data deleted via user.destroy', [
                'deleted_user_id' => $user->id,
                'performed_by' => Auth::id(),
            ]);

            auth()->logout();
            return redirect()->route('connexion')->with('success', 'Votre compte et toutes les données associées ont été supprimés.');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Erreur lors de la suppression de l\'utilisateur ' . $id . ' : ' . $e->getMessage(), [
                'exception' => $e->getMessage(),
                'trace' => method_exists($e, 'getTraceAsString') ? $e->getTraceAsString() : null,
                'requested_id' => $id,
                'performed_by' => Auth::id(),
            ]);

            return redirect()->back()->with('error', 'Une erreur est survenue lors de la suppression.');
        }
    }
    // paiement et mise à jour des crédits
    public function payement5000(Request $request, $id)
    {
        try {
            // Vérifiez si la requête contient bien le champ 'transaction-status'
            if (!$request->has('transaction-status')) {
                return redirect()->back()->with('errors', 'Aucun statut de transaction reçu.');
            }

            $transactionStatus = $request->input('transaction-status');

            // Vérifier si l'utilisateur existe
            $user = User::find($id);
            if (!$user) {
                return redirect()->back()->with('errors', 'Utilisateur non trouvé.');
            }

            // Gérer les différents statuts de la transaction
            if ($transactionStatus == "approved") {
                $user->credit_user += 5000;
                $user->save();

                return redirect()->back()->with('success', 'Transaction réussie, 5 000 crédits ont été ajoutés à votre solde.');
            } else {
                // Pour les statuts 'pending' ou autres, ne rien faire et rediriger sans message
                return redirect()->back();
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('errors', 'Une erreur est survenue, veuillez réessayer.');
        }
    }

    // Les autres méthodes peuvent suivre la même logique
    public function payement10000(Request $request, $id)
    {
        try {
            if (!$request->has('transaction-status')) {
                return redirect()->back()->with('errors', 'Aucun statut de transaction reçu.');
            }

            $transactionStatus = $request->input('transaction-status');
            $user = User::find($id);

            if (!$user) {
                return redirect()->back()->with('errors', 'Utilisateur non trouvé.');
            }

            if ($transactionStatus == "approved") {
                $user->credit_user += 15000;
                $user->save();

                return redirect()->back()->with('success', 'Transaction réussie, 15 000 crédits ont été ajoutés à votre solde.');
            } else {
                return redirect()->back();
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('errors', 'Une erreur est survenue, veuillez réessayer.');
        }
    }

    public function payement15000(Request $request, $id)
    {
        try {
            if (!$request->has('transaction-status')) {
                return redirect()->back()->with('errors', 'Aucun statut de transaction reçu.');
            }

            $transactionStatus = $request->input('transaction-status');
            $user = User::find($id);

            if (!$user) {
                return redirect()->back()->with('errors', 'Utilisateur non trouvé.');
            }

            if ($transactionStatus == "approved") {
                $user->credit_user += 25000;
                $user->save();

                return redirect()->back()->with('success', 'Transaction réussie, 25 000 crédits ont été ajoutés à votre solde.');
            } else {
                return redirect()->back();
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('errors', 'Une erreur est survenue, veuillez réessayer.');
        }
    }

    public function payement25000(Request $request, $id)
    {
        try {
            if (!$request->has('transaction-status')) {
                return redirect()->back()->with('errors', 'Aucun statut de transaction reçu.');
            }

            $transactionStatus = $request->input('transaction-status');
            $user = User::find($id);

            if (!$user) {
                return redirect()->back()->with('errors', 'Utilisateur non trouvé.');
            }

            if ($transactionStatus == "approved") {
                $user->credit_user += 40000;
                $user->save();

                return redirect()->back()->with('success', 'Transaction réussie, 40 000 crédits ont été ajoutés à votre solde.');
            } else {
                return redirect()->back();
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('errors', 'Une erreur est survenue, veuillez réessayer.');
        }
    }

    public function payement50000(Request $request, $id)
    {
        try {
            if (!$request->has('transaction-status')) {
                return redirect()->back()->with('errors', 'Aucun statut de transaction reçu.');
            }

            $transactionStatus = $request->input('transaction-status');
            $user = User::find($id);

            if (!$user) {
                return redirect()->back()->with('errors', 'Utilisateur non trouvé.');
            }

            if ($transactionStatus == "approved") {
                $user->credit_user += 100000;
                $user->save();

                return redirect()->back()->with('success', 'Transaction réussie, 100 000 crédits ont été ajoutés à votre solde.');
            } else {
                return redirect()->back();
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('errors', 'Une erreur est survenue, veuillez réessayer.');
        }
    }
}
