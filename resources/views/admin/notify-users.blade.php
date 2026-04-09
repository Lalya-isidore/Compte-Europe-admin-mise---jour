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

                <form method="POST" action="{{ route('admin.notifyUsers.send') }}" id="emailForm">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark d-flex align-items-center gap-2 mb-2">
                            <i data-lucide="users" style="width: 16px;"></i> Destinataires
                        </label>
                        <div class="input-group input-group-lg border rounded-3 overflow-hidden bg-light bg-opacity-50">
                            <select name="target" id="target-select" class="form-select border-0 bg-transparent fs-6 py-3" required>
                                <option value="all">Tous les utilisateurs ({{ $usersCount }})</option>
                                <option value="missing_photo">Utilisateurs ayant des comptes sans photo ({{ $missingPhotoCount }})</option>
                                <option value="single">Un utilisateur spécifique</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4" id="single-user-block" style="display:none;">
                        <label class="form-label fw-bold text-dark d-flex align-items-center gap-2 mb-2">
                            <i data-lucide="search" style="width: 16px;"></i> Sélectionner l'utilisateur
                        </label>
                        <select name="user_id" class="form-select form-select-lg border rounded-3 fs-6 py-3 bg-light bg-opacity-50">
                            <option value="">-- Choisir un utilisateur --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->prenom }} {{ $user->nom }} — {{ $user->email }}</option>
                            @endforeach
                        </select>
                        <div class="smaller text-secondary mt-1 ms-1">Tapez pour rechercher un utilisateur précis.</div>
                    </div>

                    {{-- Modèles pré-remplis --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark d-flex align-items-center gap-2 mb-2">
                            <i data-lucide="zap" style="width: 16px;"></i> Modèles rapides
                        </label>
                        <div class="d-flex gap-2 flex-wrap">
                            <button type="button" class="btn btn-outline-warning btn-sm rounded-pill px-3" id="tpl-loyalty">
                                🎁 Bonus Fidélité
                            </button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark d-flex align-items-center gap-2 mb-2">
                            <i data-lucide="type" style="width: 16px;"></i> Sujet de l'e-mail
                        </label>
                        <input type="text" name="subject" id="email-subject" class="form-control form-control-lg border rounded-3 fs-6 py-3 bg-light bg-opacity-50"
                               value="Mise à jour requise - Photo de profil client" required>
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
                        <button type="submit" class="btn btn-primary-premium btn-premium w-100 py-3 shadow-premium fs-5 fw-bold d-flex align-items-center justify-content-center gap-2">
                            <i data-lucide="send"></i> Envoyer la notification
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
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    lucide.createIcons();
    
    const targetSelect = document.getElementById('target-select');
    const singleUserBlock = document.getElementById('single-user-block');
    const emailForm = document.getElementById('emailForm');
    
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
});
</script>
@endpush
