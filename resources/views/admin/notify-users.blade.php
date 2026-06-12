@extends('admin.layout')

@section('title', 'Notifier les utilisateurs')

@section('content')
<div class="mb-5">
    <h2 class="fw-bold h3 mb-2">Emailing & Notifications ✉️</h2>
    <p class="text-secondary">Envoyez des messages importants à vos utilisateurs en un clic.</p>
</div>

<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-10">
        <div class="card-premium shadow-lg border-0 p-0 overflow-hidden">
            <div class="bg-primary bg-opacity-10 p-4 border-bottom">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px;">
                        <i data-lucide="mail"></i>
                    </div>
                    <div>
                        <h3 class="h5 fw-bold mb-0 text-primary">Nouveau Message</h3>
                        <p class="smaller text-secondary mb-0 opacity-75">Envoyez une notification par e-mail globale ou ciblée.</p>
                    </div>
                </div>
            </div>

            <div class="card-body p-4 p-md-5">
                @if(session('success'))
                    <div class="alert alert-success border-0 rounded-4 shadow-sm mb-4 d-flex align-items-center gap-3 p-3">
                        <i data-lucide="check-circle" style="width: 20px;"></i>
                        <div class="fw-medium">{{ session('success') }}</div>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4 d-flex align-items-center gap-3 p-3">
                        <i data-lucide="alert-triangle" style="width: 20px;"></i>
                        <div class="fw-medium">{{ session('error') }}</div>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.notifyUsers.send') }}" id="emailForm" enctype="multipart/form-data">
                    @csrf

                    {{-- Type d'envoi --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark d-flex align-items-center gap-2 mb-2">
                            <i data-lucide="send" style="width: 16px;"></i> Type d'envoi
                        </label>
                        <div class="d-flex gap-2">
                            <label class="flex-fill text-center">
                                <input type="radio" name="type" value="email" id="type-email" class="btn-check" checked>
                                <span class="btn btn-outline-primary w-100 py-2 fw-medium">✉️ E-mail</span>
                            </label>
                            <label class="flex-fill text-center">
                                <input type="radio" name="type" value="chat" id="type-chat" class="btn-check">
                                <span class="btn btn-outline-success w-100 py-2 fw-medium">💬 Chat</span>
                            </label>
                            <label class="flex-fill text-center">
                                <input type="radio" name="type" value="both" id="type-both" class="btn-check">
                                <span class="btn btn-outline-warning w-100 py-2 fw-medium">📨 Les deux</span>
                            </label>
                        </div>
                        <p class="text-secondary small mt-2 mb-0" id="type-hint-email">Envoyé dans leur boîte e-mail (Gmail, etc.).</p>
                        <p class="text-secondary small mt-2 mb-0 d-none" id="type-hint-chat">Apparaît dans l'icône de support quand ils se connectent à leur compte.</p>
                        <p class="text-secondary small mt-2 mb-0 d-none" id="type-hint-both">Envoyé simultanément par e-mail et dans le chat de support.</p>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark d-flex align-items-center gap-2 mb-2">
                            <i data-lucide="users" style="width: 16px;"></i> Destinataires
                        </label>
                        <div class="input-group input-group-lg border rounded-3 overflow-hidden bg-light bg-opacity-50">
                            <select name="target" id="target-select" class="form-select border-0 bg-transparent fs-6 py-3" required>
                                <option value="all">Tous les utilisateurs ({{ $usersCount }})</option>
                                <option value="afrique">Utilisateurs Afrique ({{ $afriqueUsersCount }})</option>
                                <option value="missing_photo">Utilisateurs ayant des comptes sans photo ({{ $missingPhotoCount }})</option>
                                <option value="single">Un utilisateur spécifique</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4" id="single-user-block" style="display:none;">
                        <label class="form-label fw-bold text-dark d-flex align-items-center gap-2 mb-2">
                            <i data-lucide="search" style="width: 16px;"></i> Sélectionner l'utilisateur
                        </label>
                        <div class="position-relative mb-2">
                            <span class="position-absolute top-50 translate-middle-y ms-3" style="pointer-events:none;">
                                <i data-lucide="search" style="width:16px;height:16px;color:#9ca3af;"></i>
                            </span>
                            <input type="text" id="user-search-input" class="form-control border rounded-3 fs-6 py-3 bg-light bg-opacity-50" placeholder="Rechercher par nom ou e-mail..." autocomplete="off" style="padding-left:2.5rem;">
                        </div>
                        <select name="user_id" id="user-select" class="form-select form-select-lg border rounded-3 fs-6 py-3 bg-light bg-opacity-50" size="6" style="height:auto;">
                            <option value="">-- Choisir un utilisateur --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" data-search="{{ strtolower($user->prenom . ' ' . $user->nom . ' ' . $user->email) }}">{{ $user->prenom }} {{ $user->nom }} — {{ $user->email }}</option>
                            @endforeach
                        </select>
                        <div id="user-search-empty" class="smaller text-secondary mt-1 ms-1" style="display:none;">Aucun utilisateur trouvé.</div>
                    </div>

                    {{-- Modèles pré-remplis --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark d-flex align-items-center gap-2 mb-2">
                            <i data-lucide="zap" style="width: 16px;"></i> Modèles rapides
                        </label>
                        <div class="d-flex gap-2 flex-wrap">
                            <button type="button" class="btn btn-primary btn-sm rounded-pill px-3" id="tpl-welcome-afrique">
                                🌍 Bienvenue Afrique
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3" id="tpl-qr">
                                ✨ Générateur QR Gratuit
                            </button>
                            <button type="button" class="btn btn-outline-warning btn-sm rounded-pill px-3" id="tpl-loyalty">
                                🎁 Bonus Fidélité
                            </button>
                            <button type="button" class="btn btn-outline-success btn-sm rounded-pill px-3" id="tpl-contrat">
                                📄 Contrat de Prêt
                            </button>
                            <button type="button" class="btn btn-outline-info btn-sm rounded-pill px-3" id="tpl-calc">
                                🧮 Calculateur de Prêt Pro
                            </button>
                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" id="tpl-app">
                                📱 Application Mobile
                            </button>
                            <button type="button" class="btn btn-warning btn-sm rounded-pill px-3 fw-bold" id="tpl-promo-mai">
                                🔥 Promo 06-07 Mai
                            </button>
                            <button type="button" class="btn btn-outline-success btn-sm rounded-pill px-3" id="tpl-nouveaux-tarifs">
                                💳 Nouveaux tarifs
                            </button>
                        </div>
                    </div>

                    <div class="mb-4" id="subject-block">
                        <label class="form-label fw-bold text-dark d-flex align-items-center gap-2 mb-2">
                            <i data-lucide="type" style="width: 16px;"></i> Sujet de l'e-mail
                        </label>
                        <input type="text" name="subject" id="email-subject" class="form-control form-control-lg border rounded-3 fs-6 py-3 bg-light bg-opacity-50"
                               value="Mise à jour requise - Photo de profil client">
                        @error('subject')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4" id="banner-block">
                        <label class="form-label fw-bold text-dark d-flex align-items-center gap-2 mb-2">
                            <i data-lucide="image" style="width: 16px;"></i> Affiche / Bannière (optionnel)
                        </label>
                        <div id="image-drop-zone" class="border rounded-3 p-4 text-center bg-light bg-opacity-50" style="cursor:pointer;border-style:dashed !important;border-color:#c7d2fe !important;">
                            <input type="file" name="banner_image" id="banner-image-input" accept="image/*" style="display:none;">
                            <div id="image-placeholder">
                                <i data-lucide="upload-cloud" style="width:32px;height:32px;color:#6366f1;" class="mb-2"></i>
                                <p class="text-secondary mb-0 small">Cliquez pour choisir une image ou glissez-déposez</p>
                                <p class="text-secondary mb-0" style="font-size:0.75rem;">PNG, JPG, WEBP — max 5 Mo</p>
                            </div>
                            <div id="image-preview-container" style="display:none;">
                                <img id="image-preview" src="" alt="Aperçu" style="max-width:100%;max-height:300px;border-radius:8px;object-fit:contain;">
                                <div class="mt-2">
                                    <button type="button" id="remove-image-btn" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                        <i data-lucide="trash-2" style="width:13px;height:13px" class="me-1"></i>Retirer
                                    </button>
                                </div>
                            </div>
                        </div>
                        @error('banner_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-5">
                        <label class="form-label fw-bold text-dark d-flex align-items-center gap-2 mb-2">
                            <i data-lucide="align-left" style="width: 16px;"></i> Message
                        </label>
                        <textarea name="message" id="email-message" class="form-control border rounded-3 fs-6 p-4 bg-light bg-opacity-50" rows="12" required
                                  style="resize: none;">Bonjour,

Suite à une mise à jour de notre plateforme, nous vous invitons à mettre à jour la photo de profil de vos comptes clients.

Pour ce faire, rendez-vous sur notre plateforme : https://flashbilan.fr
Sélectionnez le compte client concerné, puis utilisez l'option "Modifier la photo de profil du client".

Cette mise à jour est importante pour garantir une expérience optimale à vos clients.

Cordialement,
L'équipe {{ config('app.name', 'TRANSFERFLUX') }}</textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit" id="submit-btn" class="btn btn-primary-premium btn-premium w-100 py-3 shadow-premium fs-5 fw-bold d-flex align-items-center justify-content-center gap-2">
                            <i data-lucide="send"></i> <span id="submit-label">Envoyer par e-mail</span>
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="card-footer bg-light p-4 text-center border-0">
                <p class="smaller text-secondary mb-0">
                    <i data-lucide="info" class="me-1" style="width: 14px;"></i> 
                    Les e-mails sont envoyés individuellement pour éviter d'être considérés comme du spam.
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    .shadow-premium {
        box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.4);
    }
    .form-select:focus, .form-control:focus {
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1) !important;
        background-color: white !important;
    }
    .fs-7 { font-size: 0.8rem; }
    #user-select { overflow-y: auto; }
    #user-select option { padding: 10px 14px; cursor: pointer; }
    #user-select option:checked { background: #2563eb; color: #fff; }
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    lucide.createIcons();
    
    const targetSelect = document.getElementById('target-select');
    const singleUserBlock = document.getElementById('single-user-block');
    const emailForm = document.getElementById('emailForm');
    const subjectBlock = document.getElementById('subject-block');
    const bannerBlock = document.getElementById('banner-block');
    const submitLabel = document.getElementById('submit-label');
    const typeHints = {
        email: document.getElementById('type-hint-email'),
        chat: document.getElementById('type-hint-chat'),
        both: document.getElementById('type-hint-both'),
    };
    const submitLabels = {
        email: 'Envoyer par e-mail',
        chat: 'Envoyer dans le chat',
        both: 'Envoyer par e-mail & chat',
    };

    function applyTypeToggle(type) {
        const isEmail = type === 'email' || type === 'both';
        subjectBlock.style.display = isEmail ? '' : 'none';
        bannerBlock.style.display = isEmail ? '' : 'none';
        submitLabel.textContent = submitLabels[type] || submitLabels.email;
        Object.keys(typeHints).forEach(k => {
            typeHints[k].classList.toggle('d-none', k !== type);
        });
    }

    document.querySelectorAll('input[name="type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            applyTypeToggle(this.value);
        });
    });

    // État initial
    const checkedType = document.querySelector('input[name="type"]:checked');
    if (checkedType) applyTypeToggle(checkedType.value);

    targetSelect.addEventListener('change', function(){
        if(this.value === 'single') {
            singleUserBlock.style.display = 'block';
            singleUserBlock.classList.add('animate__animated', 'animate__fadeInDown');
        } else {
            singleUserBlock.style.display = 'none';
        }
    });

    emailForm.addEventListener('submit', function(e) {
        if(!confirm('Attention : Vous êtes sur le point d\'envoyer un message à vos utilisateurs. Confirmer l\'envoi ?')) {
            e.preventDefault();
        }
    });

    // Recherche utilisateur en temps réel
    const userSearchInput = document.getElementById('user-search-input');
    const userSelect = document.getElementById('user-select');
    const userSearchEmpty = document.getElementById('user-search-empty');

    if (userSearchInput && userSelect) {
        const allOptions = Array.from(userSelect.options).filter(o => o.value !== '');

        userSearchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            let visibleCount = 0;

            allOptions.forEach(option => {
                const match = !query || option.dataset.search.includes(query);
                option.style.display = match ? '' : 'none';
                if (match) visibleCount++;
            });

            // Réinitialise la sélection vide
            userSelect.options[0].style.display = query ? 'none' : '';
            if (!query) userSelect.options[0].selected = true;

            userSearchEmpty.style.display = visibleCount === 0 ? 'block' : 'none';
        });

        userSearchInput.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                const visible = allOptions.filter(o => o.style.display !== 'none');
                if (visible.length) { visible[0].selected = true; userSelect.focus(); }
            }
        });
    }

    // Modèle Bienvenue Afrique
    document.getElementById('tpl-welcome-afrique')?.addEventListener('click', function() {
        document.getElementById('email-subject').value = 'Bienvenue sur votre nouvelle plateforme Flash Compte Europe !';
        document.getElementById('email-message').value = `Bonjour,

Nous avons le plaisir de vous informer que votre compte CompteAfrique a été migré avec succès vers notre nouvelle plateforme Flash Compte Europe.

Vous pouvez désormais vous connecter sur https://flashbilan.fr en utilisant vos identifiants habituels (email et mot de passe). Vous y retrouverez votre solde, vos comptes et tout votre historique de transactions.

Bienvenue dans cette nouvelle expérience plus rapide et sécurisée !

Cordialement,
L'équipe Flash Compte`;
        document.getElementById('target-select').value = 'afrique';
        singleUserBlock.style.display = 'none';
    });

    // Modèle QR Code Gratuit
    document.getElementById('tpl-qr')?.addEventListener('click', function() {
        document.getElementById('email-subject').value = '✨ Nouvelle fonctionnalité gratuite : Générateur de QR Code & Affiches !';
        document.getElementById('email-message').value = `Bonjour,

Nous avons le plaisir de vous annoncer le lancement d'une nouvelle fonctionnalité 100% gratuite sur FlashBilan ! 🎉

🔷 Générateur de QR Code & Affiches Professionnelles

Créez en quelques secondes des QR codes personnalisés et des affiches prêtes à imprimer pour vos réseaux sociaux, votre business ou vos promotions.

✅ 4 formats disponibles : Portrait, Paysage, Carré et Bannière
✅ Personnalisation complète : couleurs, logo, titre, sous-titre
✅ Ajout de vos réseaux sociaux (Facebook, Instagram, WhatsApp, TikTok...)
✅ Téléchargement immédiat en haute qualité (PNG)
✅ 100% gratuit, sans abonnement

👉 Accédez à la fonctionnalité dès maintenant : https://flashbilan.fr

Connectez-vous à votre compte et rendez-vous dans la section "Outils" pour découvrir le Générateur QR.

Cordialement,
L'équipe FlashBilan`;
        document.getElementById('target-select').value = 'all';
        singleUserBlock.style.display = 'none';
    });

    // Modèle Contrat de Prêt
    document.getElementById('tpl-contrat')?.addEventListener('click', function() {
        document.getElementById('email-subject').value = '📄 Nouveau sur FlashBilan : Générez vos Contrats de Prêt en PDF !';
        document.getElementById('email-message').value = `Bonjour,

Nous avons le plaisir de vous annoncer le lancement d'une nouvelle fonctionnalité sur FlashBilan ! 🎉

📄 Générateur de Contrat de Prêt Professionnel

Créez en quelques minutes un contrat de prêt complet, signé et prêt à télécharger en PDF.

✅ Contrat personnalisable (prêteur, emprunteur, montant, durée, taux)
✅ 10 langues disponibles : Français, Anglais, Espagnol, Portugais, Allemand, Italien, Néerlandais, Polonais, Croate, Russe
✅ Signature électronique intégrée (emprunteur + cachet prêteur)
✅ 10 articles réglementaires inclus
✅ Aperçu en temps réel avant téléchargement
✅ Première génération GRATUITE

👉 Connectez-vous à votre compte et rendez-vous dans la section "Outils" pour découvrir le Générateur de Contrat de Prêt.

🌐 https://flashbilan.fr

Cordialement,
L'équipe FlashBilan`;
        document.getElementById('target-select').value = 'all';
        singleUserBlock.style.display = 'none';
    });

    // Modèle Calculateur de Prêt Pro
    document.getElementById('tpl-calc')?.addEventListener('click', function() {
        document.getElementById('email-subject').value = '🧮 Nouveau sur FlashBilan : Calculez vos prêts et téléchargez votre rapport PDF !';
        document.getElementById('email-message').value = `Bonjour,

Nous avons le plaisir de vous annoncer le lancement d'une nouvelle fonctionnalité sur FlashBilan ! 🎉

🧮 Calculateur de Prêt Pro est maintenant disponible sur votre tableau de bord.

✅ Ce que vous pouvez faire :
- Simuler n'importe quel crédit ou prêt bancaire en quelques secondes
- Obtenir instantanément : la mensualité, le total des intérêts, et le coût total du prêt
- Visualiser la répartition capital / intérêts en temps réel
- Télécharger un rapport PDF complet avec tableau d'amortissement
- Choisir parmi 10 langues : Français, Anglais, Espagnol, Portugais, Allemand, Italien, Néerlandais, Polonais, Croate, Russe
- Compatible avec plus de 50 devises internationales

💡 Que vous soyez en train d'accompagner un client, préparer un dossier de financement ou simplement comparer des offres, cet outil vous fait gagner un temps précieux.

💰 Le téléchargement du rapport PDF coûte seulement 300 crédits.

👉 Accédez dès maintenant au Calculateur de Prêt Pro sur : https://flashbilan.fr

Cordialement,
L'équipe FlashBilan`;
        document.getElementById('target-select').value = 'all';
        singleUserBlock.style.display = 'none';
    });

    // Modèle Application Mobile
    document.getElementById('tpl-app')?.addEventListener('click', function() {
        document.getElementById('email-subject').value = '📱 FlashBilan est maintenant disponible comme application mobile !';
        document.getElementById('email-message').value = `Bonjour,

Nous avons une excellente nouvelle pour vous ! 🎉

📱 L'application FlashBilan est désormais disponible et peut être installée directement sur votre téléphone depuis notre site web — sans passer par l'App Store ou le Play Store.

✅ Installation rapide en 2 étapes :
1. Ouvrez https://flashbilan.fr dans votre navigateur (Chrome ou Safari)
2. Appuyez sur la bannière "Installer l'application" qui apparaît en bas de l'écran

Une fois installée, l'application apparaît sur votre écran d'accueil comme n'importe quelle autre application. Vous pouvez l'ouvrir directement sans passer par le navigateur.

✨ Avantages :
- Accès rapide en un clic depuis votre téléphone
- Interface optimisée pour mobile
- Fonctionne même avec une connexion lente
- Aucune mise à jour manuelle requise

👉 Rendez-vous sur https://flashbilan.fr pour installer l'application dès maintenant.

Cordialement,
L'équipe FlashBilan`;
        document.getElementById('target-select').value = 'all';
        singleUserBlock.style.display = 'none';
    });

    // Modèle Bonus Fidélité
    document.getElementById('tpl-loyalty')?.addEventListener('click', function() {
        document.getElementById('email-subject').value = '🎁 Nouveau : Gagnez 5 000 crédits gratuits avec le Bonus Fidélité !';
        document.getElementById('email-message').value = `Bonjour,

Nous sommes ravis de vous annoncer le lancement de notre programme Bonus Fidélité sur FlashBilan ! 🎉

Le principe est simple :

✅ Effectuez 4 recharges de crédits en 30 jours
✅ Recevez automatiquement 5 000 crédits gratuits
✅ Suivez votre progression en temps réel sur votre tableau de bord
✅ Le compteur se réinitialise tous les 30 jours

Votre progression est visible dès maintenant sur votre page d'accueil. Connectez-vous pour voir où vous en êtes ! 🚀

👉 Accédez à votre compte : https://flashbilan.fr

Cordialement,
L'équipe FlashBilan`;
        document.getElementById('target-select').value = 'all';
        singleUserBlock.style.display = 'none';
    });
    // Modèle Nouveaux tarifs
    document.getElementById('tpl-nouveaux-tarifs')?.addEventListener('click', function() {
        document.getElementById('email-subject').value = '💳 Nouveau : Rechargez dès 1 500 F CFA sur FlashBilan !';
        document.getElementById('email-message').value = `Bonjour,

Nous avons le plaisir de vous annoncer l'ajout de deux nouveaux tarifs de recharge sur FlashBilan !

💳 NOUVEAUX PACKS DISPONIBLES :

✅ Pack Mini — 1 500 F CFA
Recevez 1 000 crédits immédiatement.
Idéal pour tester nos outils sans engagement.

✅ Pack Essentiel — 3 000 F CFA
Recevez 2 000 crédits immédiatement.
Parfait pour une utilisation régulière.

Ces nouveaux packs s'ajoutent à nos offres existantes (5 000, 10 000, 25 000 et 50 000 F CFA) pour vous offrir encore plus de flexibilité.

👉 Rechargez dès maintenant sur : https://flashbilan.fr

Cordialement,
L'équipe FlashBilan`;
        document.getElementById('target-select').value = 'all';
        singleUserBlock.style.display = 'none';
    });

    // Modèle Promo 06-07 Mai
    document.getElementById('tpl-promo-mai')?.addEventListener('click', function() {
        document.getElementById('email-subject').value = '🔥 OFFRE LIMITÉE : +50% et +100% de crédits bonus — 06 et 07 Mai seulement !';
        document.getElementById('email-message').value = `Bonjour,

Nous avons une offre exceptionnelle pour vous, valable uniquement les 06 et 07 Mai 2026 !

🎁 RECHARGEZ ET RECEVEZ DES CRÉDITS BONUS :

✅ Offre 1 — +50% de crédit BONUS
Pour toute recharge de 5 000 CFA, vous recevez 2 500 CFA de crédit bonus.
Exemple : Rechargez 5 000 CFA → vous avez 7 500 CFA de crédit au total.

✅ Offre 2 — +100% de crédit BONUS
Pour toute recharge de 10 000 CFA et plus, vous recevez 100% de crédit bonus.
Exemple : Rechargez 10 000 CFA → vous avez 20 000 CFA de crédit au total.

⏳ Cette offre est valable uniquement les 06 et 07 Mai 2026. Ne la manquez pas !

👉 Connectez-vous dès maintenant pour en profiter : https://flashbilan.fr

Cordialement,
L'équipe FlashBilan`;
        document.getElementById('target-select').value = 'all';
        singleUserBlock.style.display = 'none';
    });

    // Upload image preview
    const dropZone = document.getElementById('image-drop-zone');
    const imageInput = document.getElementById('banner-image-input');
    const imagePreview = document.getElementById('image-preview');
    const imagePreviewContainer = document.getElementById('image-preview-container');
    const imagePlaceholder = document.getElementById('image-placeholder');
    const removeBtn = document.getElementById('remove-image-btn');

    if (dropZone) {
        dropZone.addEventListener('click', () => imageInput.click());

        dropZone.addEventListener('dragover', e => {
            e.preventDefault();
            dropZone.style.borderColor = '#6366f1';
            dropZone.style.background = 'rgba(99,102,241,0.05)';
        });
        dropZone.addEventListener('dragleave', () => {
            dropZone.style.borderColor = '#c7d2fe';
            dropZone.style.background = '';
        });
        dropZone.addEventListener('drop', e => {
            e.preventDefault();
            dropZone.style.borderColor = '#c7d2fe';
            dropZone.style.background = '';
            if (e.dataTransfer.files[0]) {
                imageInput.files = e.dataTransfer.files;
                showPreview(e.dataTransfer.files[0]);
            }
        });

        imageInput.addEventListener('change', function() {
            if (this.files[0]) showPreview(this.files[0]);
        });

        removeBtn.addEventListener('click', e => {
            e.stopPropagation();
            imageInput.value = '';
            imagePreviewContainer.style.display = 'none';
            imagePlaceholder.style.display = 'block';
        });

        function showPreview(file) {
            const reader = new FileReader();
            reader.onload = ev => {
                imagePreview.src = ev.target.result;
                imagePlaceholder.style.display = 'none';
                imagePreviewContainer.style.display = 'block';
                lucide.createIcons();
            };
            reader.readAsDataURL(file);
        }
    }
});
</script>
@endpush
