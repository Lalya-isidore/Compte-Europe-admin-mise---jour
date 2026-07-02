@extends('admin.layout')

@section('title', ($user->nom ?? '') . ' ' . ($user->prenom ?? '') . ' - Détail utilisateur')

@section('content')
@php
    $initials = mb_substr($user->prenom ?? '', 0, 1) . mb_substr($user->nom ?? '', 0, 1);
    $statusColors = [
        'completed' => 'success',
        'pending' => 'warning',
        'failed' => 'danger'
    ];
@endphp

{{-- Profile Header Card --}}
<div class="card-premium mb-5 border-0 shadow-sm p-4">
    <div class="row align-items-center g-4">
        <div class="col-auto">
            <div class="avatar bg-primary bg-opacity-10 text-primary rounded-4 d-flex align-items-center justify-content-center shadow-soft" 
                 style="width: 80px; height: 80px; font-size: 1.8rem; font-weight: 800;">
                {{ $initials ?: '?' }}
            </div>
        </div>
        <div class="col">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                <div>
                    <h2 class="h3 fw-bold text-dark mb-1">{{ $user->nom }} {{ $user->prenom }}</h2>
                    <div class="d-flex flex-column gap-1 text-secondary smaller">
                        <span class="d-flex align-items-center gap-1">
                            <i data-lucide="mail" style="width: 14px;"></i> {{ $user->email }}
                        </span>
                        @if($user->phone)
                            <span class="d-flex align-items-center gap-1">
                                <i data-lucide="phone" style="width: 14px;"></i> {{ $user->phone }}
                            </span>
                        @endif
                        <span class="d-flex align-items-center gap-1">
                            <i data-lucide="calendar" style="width: 14px;"></i> Inscrit le {{ $user->created_at?->setTimezone('Europe/Paris')->format('d/m/Y à H:i') }}
                        </span>
                        @if($user->source)
                        <span class="d-flex align-items-center gap-1">
                            <i data-lucide="{{ $user->source === 'Google' ? 'search' : 'share-2' }}" style="width: 14px;"></i>
                            Source : <strong>{{ $user->source }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light btn-premium btn-sm border">
                        <i data-lucide="arrow-left" class="me-1"></i> Retour
                    </a>
                    <button type="button" class="btn btn-warning btn-premium btn-sm"
                            onclick="openNotifModal({{ $user->id }}, '{{ addslashes(trim($user->prenom . ' ' . $user->nom)) }}')"
                            title="Envoyer une notification">
                        <i data-lucide="bell" class="me-1" style="width:14px;"></i> Notifier
                    </button>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="js-delete-user" data-name="{{ $user->nom }} {{ $user->prenom }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-premium btn-sm">
                            <i data-lucide="trash-2" class="me-1"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Stats Grid --}}
<div class="stats-grid mb-5">
    <div class="card-premium stat-card border-start border-primary border-4">
        <div class="stat-info">
            <h3>Crédits Disponibles</h3>
            <p class="stat-value">{{ number_format($user->credit_user ?? 0, 0, ',', ' ') }}</p>
            <form action="{{ route('admin.users.credit.update', $user) }}" method="POST" class="mt-3">
                @csrf
                <div class="input-group input-group-sm">
                    <input type="number" name="credit_user" class="form-control border-end-0 fs-7" min="0" value="{{ $user->credit_user }}" placeholder="Nouveau montant">
                    <button class="btn btn-primary btn-sm px-3" type="submit">Mise à jour</button>
                </div>
            </form>
        </div>
        <div class="stat-icon bg-primary bg-opacity-10 text-primary">
            <i data-lucide="wallet"></i>
        </div>
    </div>
    
    <div class="card-premium stat-card border-start border-success border-4">
        <div class="stat-info">
            <h3>Sous-comptes</h3>
            <p class="stat-value">{{ $user->comptes->count() }}</p>
            <p class="smaller text-secondary">Comptes bancaires créés</p>
        </div>
        <div class="stat-icon bg-success bg-opacity-10 text-success">
            <i data-lucide="layout-grid"></i>
        </div>
    </div>
    
    <div class="card-premium stat-card border-start border-warning border-4">
        <div class="stat-info">
            <h3>Total Recharges</h3>
            <p class="stat-value">{{ number_format($totalRechargeAmount ?? 0, 0, ',', ' ') }} F</p>
            <p class="smaller text-secondary">Montant validé accepté</p>
        </div>
        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
            <i data-lucide="badge-dollar-sign"></i>
        </div>
    </div>
</div>

{{-- Sub-accounts Listing --}}
<div class="mb-4 d-flex justify-content-between align-items-center">
    <h3 class="h5 fw-bold text-dark d-flex align-items-center gap-2 mb-0">
        <i data-lucide="credit-card" class="text-primary"></i>
        Sous-comptes Clients
        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 fs-7 ms-2">{{ $user->comptes->count() }}</span>
    </h3>
</div>

<div class="row g-4 mb-5">
    @forelse($user->comptes as $compte)
        @php
            $ci = mb_substr($compte->prenom ?? '', 0, 1) . mb_substr($compte->nom ?? '', 0, 1);
            $accountStatusColor = match($compte->account_status) {
                'active' => 'success',
                'blocked', 'suspended' => 'danger',
                default => 'secondary',
            };
        @endphp
        <div class="col-xl-6 col-lg-12">
            <div class="card-premium shadow-sm border p-0 overflow-hidden h-100">
                <div class="p-3 border-bottom bg-light bg-opacity-50 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <div class="avatar bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center smaller fw-bold" style="width: 32px; height: 32px;">
                            {{ $ci ?: '?' }}
                        </div>
                        <div>
                            <div class="fw-bold text-dark">{{ $compte->nom }} {{ $compte->prenom }}</div>
                            <div class="smaller text-secondary opacity-75">ID: #{{ $compte->id }} — {{ $compte->devise ?? 'EUR' }}</div>
                        </div>
                    </div>
                    <span class="badge bg-{{ $accountStatusColor }} bg-opacity-10 text-{{ $accountStatusColor }} rounded-pill px-3">
                        {{ ucfirst($compte->account_status ?? 'inconnu') }}
                    </span>
                </div>
                <div class="p-4">
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <label class="smaller text-secondary text-uppercase fw-bold opacity-50 d-block mb-1">Solde Actuel</label>
                            <div class="fw-bold text-primary mb-0" style="font-size:clamp(0.85rem,2vw,1.1rem);word-break:break-word;line-height:1.3;">{{ number_format($compte->account_balance, 0, ',', ' ') }} {{ $compte->devise ?? 'F CFA' }}</div>
                        </div>
                        <div class="col-6">
                            <label class="smaller text-secondary text-uppercase fw-bold opacity-50 d-block mb-1">IBAN</label>
                            <div class="smaller fw-medium text-dark text-truncate" title="{{ $compte->iban }}">{{ $compte->iban ?: '—' }}</div>
                        </div>
                        <div class="col-12">
                            <label class="smaller text-secondary text-uppercase fw-bold opacity-50 d-block mb-1">Email Client</label>
                            <div class="smaller fw-medium text-dark text-truncate" title="{{ $compte->email }}">{{ $compte->email ?: '—' }}</div>
                        </div>
                        <div class="col-6">
                            <label class="smaller text-secondary text-uppercase fw-bold opacity-50 d-block mb-1">Téléphone Client</label>
                            <div class="smaller fw-medium text-dark">{{ $compte->phone_number ?: '—' }}</div>
                        </div>
                        <div class="col-12">
                            <label class="smaller text-secondary text-uppercase fw-bold opacity-50 d-block mb-1">Compte créé le</label>
                            <div class="smaller fw-medium text-dark">{{ $compte->created_at?->setTimezone('Europe/Paris')->format('d/m/Y à H:i') ?? '—' }}</div>
                        </div>
                    </div>
                    
                    <div class="mb-4 pt-3 border-top">
                        <label class="smaller text-secondary text-uppercase fw-bold opacity-50 d-block mb-2">Actions Rapides</label>
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-outline-primary btn-premium btn-sm" onclick="toggleEdit('email', {{ $compte->id }})">
                                <i data-lucide="mail-edit" class="me-1"></i> Email
                            </button>
                            <button class="btn btn-outline-primary btn-premium btn-sm" onclick="toggleEdit('phone', {{ $compte->id }})">
                                <i data-lucide="phone-forwarded" class="me-1"></i> Tél.
                            </button>
                            <button class="btn btn-outline-success btn-premium btn-sm" onclick="toggleEdit('boost', {{ $compte->id }})">
                                <i data-lucide="trending-up" class="me-1"></i> Booster solde
                            </button>
                            @php
                                $compteUrl = ($compte->region === 'afrique')
                                    ? 'https://bank.fluxtransfer.world/index.php?page=connexion&id=' . $compte->id
                                    : 'https://fluxtransfer.world/index.php?page=connexion&id=' . $compte->id;
                            @endphp
                            <a href="{{ $compteUrl }}" target="_blank" class="btn btn-primary-premium btn-premium btn-sm ms-auto px-4">
                                <i data-lucide="external-link" class="me-1"></i> Ouvrir
                            </a>
                        </div>
                    </div>

                    {{-- Formulaires Inline Cachés --}}
                    <div id="edit-forms-{{ $compte->id }}">
                        <form action="{{ route('admin.users.comptes.email.update', [$user, $compte]) }}" method="POST" id="form-email-{{ $compte->id }}" style="display:none;" class="mb-2">
                            @csrf
                            <div class="input-group input-group-sm border rounded-pill overflow-hidden bg-light shadow-sm">
                                <input type="email" name="email" class="form-control border-0 bg-transparent fs-7 px-3" value="{{ $compte->email }}" placeholder="Nouvel email client" required>
                                <button type="submit" class="btn btn-primary px-3">Valider</button>
                            </div>
                        </form>
                        
                        <form action="{{ route('admin.users.comptes.phone.update', [$user, $compte]) }}" method="POST" id="form-phone-{{ $compte->id }}" style="display:none;" class="mb-2">
                            @csrf
                            <div class="input-group input-group-sm border rounded-pill overflow-hidden bg-light shadow-sm">
                                <input type="tel" name="phone_number" class="form-control border-0 bg-transparent fs-7 px-3" value="{{ $compte->phone_number }}" placeholder="Nouveau numéro client" required>
                                <button type="submit" class="btn btn-primary px-3">Valider</button>
                            </div>
                        </form>
                        
                        <form action="{{ route('admin.users.comptes.balance.boost', [$user, $compte]) }}" method="POST" id="form-boost-{{ $compte->id }}" style="display:none;" class="mb-2">
                            @csrf
                            <div class="input-group input-group-sm border rounded-pill overflow-hidden bg-light shadow-sm">
                                <input type="number" name="amount" class="form-control border-0 bg-transparent fs-7 px-3" placeholder="Montant à ajouter" required>
                                <button type="submit" class="btn btn-success px-3">Ajouter</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="px-4 py-2 bg-light border-top d-flex justify-content-between align-items-center">
                    <span class="smaller text-secondary">Attention : Action irréversible</span>
                    <form action="{{ route('admin.users.comptes.history.purge', [$user, $compte]) }}" method="POST" class="js-purge-history" data-name="{{ $compte->nom }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link link-danger p-0 fs-7 fw-bold text-decoration-none">
                            <i data-lucide="eraser"></i> Effacer historique
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card-premium p-5 text-center text-secondary opacity-50">
                <i data-lucide="frown" class="mb-2" style="width: 48px; height: 48px;"></i>
                <p class="mb-0">Aucun sous-compte créé pour cet utilisateur.</p>
            </div>
        </div>
    @endforelse
</div>

{{-- Recharges Table --}}
<div class="mb-4">
    <h3 class="h5 fw-bold text-dark d-flex align-items-center gap-2 mb-0">
        <i data-lucide="history" class="text-warning"></i>
        Historique des Recharges
    </h3>
</div>

<div class="card-premium shadow-sm border p-0 overflow-hidden mb-5">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="bg-light">
                <tr class="smaller text-secondary text-uppercase fw-bold">
                    <th class="ps-4">ID Transaction</th>
                    <th>Montant</th>
                    <th>Crédits</th>
                    <th>Méthode</th>
                    <th>Statut</th>
                    <th class="pe-4 text-end">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recharges as $recharge)
                    <tr>
                        <td class="ps-4 py-3 smaller fw-medium text-dark font-monospace">{{ $recharge->transaction_id }}</td>
                        <td class="py-3">
                            <span class="fw-bold text-dark">{{ number_format($recharge->amount, 0, ',', ' ') }} F</span>
                        </td>
                        <td class="py-3">
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">+{{ number_format($recharge->credits_earned, 0, ',', ' ') }} cr.</span>
                        </td>
                        <td class="py-3 smaller text-secondary">{{ $recharge->payment_method ?: '—' }}</td>
                        <td class="py-3">
                            <span class="badge bg-{{ $statusColors[$recharge->status] ?? 'secondary' }} bg-opacity-10 text-{{ $statusColors[$recharge->status] ?? 'secondary' }} rounded-pill px-3">
                                {{ ucfirst($recharge->status) }}
                            </span>
                        </td>
                        <td class="pe-4 py-3 text-end smaller text-secondary">
                            {{ $recharge->created_at?->setTimezone('Europe/Paris')->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-5 text-center text-secondary opacity-50">Aucune recharge enregistrée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- SMS Pro --}}
<div class="mb-4">
    <h3 class="h5 fw-bold text-dark d-flex align-items-center gap-2 mb-0">
        <i data-lucide="message-square" class="text-success"></i>
        SMS Pro
        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 fs-7 ms-2">{{ $smsHistory->count() }}</span>
    </h3>
</div>

<div class="card-premium shadow-sm border p-0 overflow-hidden mb-5">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="bg-light">
                <tr class="smaller text-secondary text-uppercase fw-bold">
                    <th class="ps-4">Expéditeur</th>
                    <th>Pays</th>
                    <th>Destinataire</th>
                    <th>Message</th>
                    <th>SMS</th>
                    <th>Crédits</th>
                    <th>Statut</th>
                    <th class="pe-4 text-end">Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($smsHistory as $sms)
                    <tr>
                        <td class="ps-4 py-3 smaller fw-medium text-dark">{{ $sms->expediteur ?: '—' }}</td>
                        <td class="py-3 smaller text-secondary">{{ $sms->pays ?: '—' }}</td>
                        <td class="py-3 smaller text-dark font-monospace">{{ $sms->destinataire ?: '—' }}</td>
                        <td class="py-3 smaller text-secondary" style="max-width: 220px;">
                            <span class="d-block text-truncate">{{ Str::limit($sms->message, 40) }}</span>
                            @if($sms->message && strlen($sms->message) > 40)
                                <a href="#" class="sms-toggle-msg" style="font-size:.75rem;color:#2563eb;" data-full="{{ e($sms->message) }}" data-expanded="0">▼ Voir tout</a>
                                <div class="sms-full-msg" style="display:none;margin-top:6px;white-space:pre-wrap;background:#f8fafc;border:1px solid #e2e8f0;border-radius:6px;padding:7px 9px;font-size:.82rem;color:#1e293b;line-height:1.6;"></div>
                            @endif
                        </td>
                        <td class="py-3 text-center">
                            <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-2">{{ $sms->sms_count }}</span>
                        </td>
                        <td class="py-3">
                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3">{{ $sms->credits_used }} cr.</span>
                        </td>
                        <td class="py-3">
                            @php
                                $smsBadge = match($sms->status) {
                                    'Livré' => 'success',
                                    'En attente' => 'warning',
                                    'Rejeté', 'Échec' => 'danger',
                                    default => 'secondary',
                                };
                            @endphp
                            <span class="badge bg-{{ $smsBadge }} bg-opacity-10 text-{{ $smsBadge }} rounded-pill px-3">{{ $sms->status }}</span>
                            @if($sms->error_message)
                                <div class="smaller text-danger mt-1" style="max-width:180px;line-height:1.3;">{{ $sms->error_message }}</div>
                            @endif
                        </td>
                        <td class="pe-4 py-3 text-end smaller text-secondary">
                            {{ $sms->created_at?->setTimezone('Europe/Paris')->format('d/m/Y H:i') }}
                        </td>
                        <td class="py-3">
                            @if(in_array($sms->status, ['Rejeté', 'Échec']))
                                <form method="POST" action="{{ route('admin.smsRejected.resend', $sms->id) }}" onsubmit="return confirm('Renvoyer ce SMS à {{ $sms->destinataire }} ?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-primary" title="Renvoyer">
                                        <i data-lucide="send" style="width:13px;height:13px"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="p-5 text-center text-secondary opacity-50">Aucun SMS envoyé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Mail Pro --}}
<div class="mb-4">
    <h3 class="h5 fw-bold text-dark d-flex align-items-center gap-2 mb-0">
        <i data-lucide="mail" class="text-primary"></i>
        Mail Pro
        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 fs-7 ms-2">{{ $mailHistory->count() }}</span>
    </h3>
</div>

<div class="card-premium shadow-sm border p-0 overflow-hidden mb-5">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="bg-light">
                <tr class="smaller text-secondary text-uppercase fw-bold">
                    <th class="ps-4">Expéditeur</th>
                    <th>Destinataire</th>
                    <th>Objet</th>
                    <th>Crédits</th>
                    <th>Statut</th>
                    <th>Ouvertures</th>
                    <th class="pe-4 text-end">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mailHistory as $mail)
                    <tr>
                        <td class="ps-4 py-3 smaller fw-medium text-dark">{{ $mail->expediteur ?: '—' }}</td>
                        <td class="py-3 smaller text-dark font-monospace">{{ $mail->destinataire ?: '—' }}</td>
                        <td class="py-3 smaller text-secondary" style="max-width: 180px;">
                            <span class="d-block text-truncate" title="{{ $mail->objet }}">{{ $mail->objet ?: '—' }}</span>
                        </td>
                        <td class="py-3">
                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3">{{ $mail->credits_used }} cr.</span>
                        </td>
                        <td class="py-3">
                            @php
                                $mailBadge = match($mail->status) {
                                    'Envoyé' => 'success',
                                    'En attente' => 'warning',
                                    'Échec' => 'danger',
                                    default => 'secondary',
                                };
                            @endphp
                            <span class="badge bg-{{ $mailBadge }} bg-opacity-10 text-{{ $mailBadge }} rounded-pill px-3">{{ $mail->status }}</span>
                        </td>
                        <td class="py-3 text-center">
                            @if($mail->open_count > 0)
                                <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-2" title="Ouvert le {{ $mail->opened_at?->setTimezone('Europe/Paris')->format('d/m/Y H:i') }}">
                                    {{ $mail->open_count }}×
                                </span>
                            @else
                                <span class="text-secondary smaller">—</span>
                            @endif
                        </td>
                        <td class="pe-4 py-3 text-end smaller text-secondary">
                            {{ $mail->created_at?->setTimezone('Europe/Paris')->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-5 text-center text-secondary opacity-50">Aucun mail envoyé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Collecte Coupons --}}
<div class="mb-4">
    <h3 class="h5 fw-bold text-dark d-flex align-items-center gap-2 mb-0">
        <i data-lucide="ticket" class="text-danger"></i>
        Collecte Coupons
        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 fs-7 ms-2">{{ $couponCollections->count() }}</span>
    </h3>
</div>

<div class="card-premium shadow-sm border p-0 overflow-hidden mb-5">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="bg-light">
                <tr class="smaller text-secondary text-uppercase fw-bold">
                    <th class="ps-4">Type</th>
                    <th>Langue</th>
                    <th>Quantité</th>
                    <th>Token</th>
                    <th>Coût</th>
                    <th>Statut</th>
                    <th>Coupons</th>
                    <th class="pe-4 text-end">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($couponCollections as $collection)
                    <tr>
                        <td class="ps-4 py-3 smaller fw-medium text-dark">{{ $collection->kind ?: '—' }}</td>
                        <td class="py-3 smaller text-secondary">{{ strtoupper($collection->lang ?: '—') }}</td>
                        <td class="py-3 text-center">
                            <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-2">{{ $collection->count }}</span>
                        </td>
                        <td class="py-3 smaller font-monospace text-secondary" style="max-width: 120px;">
                            <span class="d-block text-truncate" title="{{ $collection->token }}">{{ $collection->token ?: '—' }}</span>
                        </td>
                        <td class="py-3">
                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3">{{ $collection->cost }} cr.</span>
                        </td>
                        <td class="py-3">
                            @php
                                $couponBadge = match($collection->status) {
                                    'completed', 'success' => 'success',
                                    'pending' => 'warning',
                                    'failed' => 'danger',
                                    default => 'secondary',
                                };
                            @endphp
                            <span class="badge bg-{{ $couponBadge }} bg-opacity-10 text-{{ $couponBadge }} rounded-pill px-3">{{ ucfirst($collection->status) }}</span>
                        </td>
                        <td class="py-3 smaller text-secondary">
                            @if($collection->coupons->isNotEmpty())
                                <button class="btn btn-link p-0 fs-7 text-primary text-decoration-none fw-bold"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#coupons-{{ $collection->id }}">
                                    Voir {{ $collection->coupons->count() }} code(s)
                                </button>
                                <div class="collapse mt-2" id="coupons-{{ $collection->id }}">
                                    @foreach($collection->coupons as $coupon)
                                        <span class="badge bg-light text-dark border me-1 mb-1 font-monospace">{{ $coupon->code ?? $coupon->coupon ?? '?' }}</span>
                                    @endforeach
                                </div>
                            @else
                                —
                            @endif
                        </td>
                        <td class="pe-4 py-3 text-end smaller text-secondary">
                            {{ $collection->created_at?->setTimezone('Europe/Paris')->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-5 text-center text-secondary opacity-50">Aucune collecte de coupons.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Contrats de Prêt générés --}}
<div class="card-premium border-0 shadow-sm mb-4">
    <div class="d-flex align-items-center justify-content-between px-4 pt-4 pb-3 border-bottom">
        <h5 class="fw-bold mb-0 d-flex align-items-center gap-2">
            <i data-lucide="file-text" style="width:18px;color:#6366f1"></i>
            Documents de Prêt générés
        </h5>
        <span class="badge rounded-pill bg-secondary bg-opacity-10 text-secondary">{{ $contratPretUsages->count() }}</span>
    </div>
    <div class="table-responsive">
        <table class="table table-sm table-hover align-middle mb-0" style="font-size:.9rem;">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Document</th>
                    <th>Détails</th>
                    <th>Date</th>
                    <th>Expire dans</th>
                    <th style="width:140px;"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($contractHistoriesPret as $hist)
                <tr @if($hist->is_test) style="background:#fff8e1;" @endif>
                    <td class="ps-4 py-3">
                        @if($hist->is_test)
                            <span class="badge" style="background:#f59e0b;color:#fff;font-size:.7rem;margin-bottom:3px;display:inline-block;">⚠ FILIGRANE</span><br>
                        @endif
                        <span style="font-weight:600;color:#1a3a5c;">{{ $hist->display_name }}</span>
                    </td>
                    <td class="py-3" style="color:#4b5563;">
                        @if(!empty($hist->metadata['emprunteur']))
                            <span>Emprunteur : <strong>{{ $hist->metadata['emprunteur'] }}</strong></span><br>
                        @endif
                        @if(!empty($hist->metadata['montant']))
                            <span>{{ number_format($hist->metadata['montant'], 0, ',', ' ') }} {{ $hist->metadata['devise'] ?? '' }}</span>
                        @endif
                    </td>
                    <td class="py-3" style="white-space:nowrap;color:#6b7280;">{{ $hist->created_at->setTimezone('Europe/Paris')->format('d/m/Y H:i') }}</td>
                    <td class="py-3" style="white-space:nowrap;">
                        @php $diff = now()->diff($hist->expires_at); @endphp
                        @if($diff->days > 0)
                            <span style="color:#059669;">{{ $diff->days }}j {{ $diff->h }}h</span>
                        @else
                            <span style="color:#dc2626;">{{ $diff->h }}h {{ $diff->i }}min</span>
                        @endif
                    </td>
                    <td class="py-3 pe-4">
                        <a href="{{ route('admin.contracts.admin.download', $hist->id) }}"
                           class="btn btn-sm"
                           style="background:#1a3a5c;color:#fff;padding:4px 10px;border-radius:6px;font-size:.8rem;text-decoration:none;">
                            <i data-lucide="download" style="width:13px;height:13px;vertical-align:middle;"></i> Télécharger PDF
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-5 text-center text-secondary opacity-50">Aucun document de prêt généré.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Contrats de Don générés --}}
<div class="card-premium border-0 shadow-sm mb-4">
    <div class="d-flex align-items-center justify-content-between px-4 pt-4 pb-3 border-bottom">
        <h5 class="fw-bold mb-0 d-flex align-items-center gap-2">
            <i data-lucide="heart-handshake" style="width:18px;color:#16a34a"></i>
            Documents de Don générés
        </h5>
        <span class="badge rounded-pill bg-secondary bg-opacity-10 text-secondary">{{ $contratDonUsages->count() }}</span>
    </div>
    <div class="table-responsive">
        <table class="table table-sm table-hover align-middle mb-0" style="font-size:.9rem;">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Document</th>
                    <th>Détails</th>
                    <th>Date</th>
                    <th>Expire dans</th>
                    <th style="width:140px;"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($contractHistoriesDon as $hist)
                <tr @if($hist->is_test) style="background:#fff8e1;" @endif>
                    <td class="ps-4 py-3">
                        @if($hist->is_test)
                            <span class="badge" style="background:#f59e0b;color:#fff;font-size:.7rem;margin-bottom:3px;display:inline-block;">⚠ FILIGRANE</span><br>
                        @endif
                        <span style="font-weight:600;color:#1a3a5c;">{{ $hist->display_name }}</span>
                    </td>
                    <td class="py-3" style="color:#4b5563;">
                        @if(!empty($hist->metadata['donateur']))
                            <span>Donateur : <strong>{{ $hist->metadata['donateur'] }}</strong></span><br>
                        @endif
                        @if(!empty($hist->metadata['montant']))
                            <span>{{ number_format($hist->metadata['montant'], 0, ',', ' ') }} {{ $hist->metadata['devise'] ?? '' }}</span>
                        @endif
                    </td>
                    <td class="py-3" style="white-space:nowrap;color:#6b7280;">{{ $hist->created_at->setTimezone('Europe/Paris')->format('d/m/Y H:i') }}</td>
                    <td class="py-3" style="white-space:nowrap;">
                        @php $diff = now()->diff($hist->expires_at); @endphp
                        @if($diff->days > 0)
                            <span style="color:#059669;">{{ $diff->days }}j {{ $diff->h }}h</span>
                        @else
                            <span style="color:#dc2626;">{{ $diff->h }}h {{ $diff->i }}min</span>
                        @endif
                    </td>
                    <td class="py-3 pe-4">
                        <a href="{{ route('admin.contracts.admin.download', $hist->id) }}"
                           class="btn btn-sm"
                           style="background:#1a3a5c;color:#fff;padding:4px 10px;border-radius:6px;font-size:.8rem;text-decoration:none;">
                            <i data-lucide="download" style="width:13px;height:13px;vertical-align:middle;"></i> Télécharger PDF
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-5 text-center text-secondary opacity-50">Aucun document de don généré.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    .shadow-soft {
        box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.2);
    }
    .fs-7 { font-size: 0.8rem; }
    .stat-card form .input-group:focus-within {
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.sms-toggle-msg').forEach(function (link) {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            var expanded = this.dataset.expanded === '1';
            var box = this.nextElementSibling;
            if (!expanded) {
                box.textContent = this.dataset.full;
                box.style.display = 'block';
                this.textContent = '▲ Réduire';
                this.dataset.expanded = '1';
            } else {
                box.style.display = 'none';
                this.textContent = '▼ Voir tout';
                this.dataset.expanded = '0';
            }
        });
    });
});
</script>
@endsection

@push('scripts')
<script>
function toggleEdit(type, id) {
    const types = ['email', 'phone', 'boost'];
    types.forEach(t => {
        const form = document.getElementById(`form-${t}-${id}`);
        if(t === type) {
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
            if(form.style.display === 'block') form.querySelector('input').focus();
        } else {
            form.style.display = 'none';
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    lucide.createIcons();
    
    // Suppression Utilisateur
    document.querySelector('.js-delete-user')?.addEventListener('submit', function(e) {
        const name = this.getAttribute('data-name');
        if(!confirm(`Supprimer l'utilisateur "${name}" et TOUTES ses données ? Cette action est irréversible.`)) {
            e.preventDefault();
        }
    });

    // Purge Historique
    document.querySelectorAll('.js-purge-history').forEach(form => {
        form.addEventListener('submit', function(e) {
            const name = this.getAttribute('data-name');
            if(!confirm(`⚠️ ATTENTION : Effacer TOUT l'historique du compte de "${name}" ? Action irréversible.`)) {
                e.preventDefault();
            }
        });
    });
});

function openNotifModal(userId, userName) {
    document.getElementById('notifUserId').value = userId;
    document.getElementById('notifUserName').textContent = 'Destinataire : ' + userName;
    document.getElementById('notifTitle').value = '';
    document.getElementById('notifMessage').value = '';
    const fb = document.getElementById('notifFeedback');
    fb.className = 'd-none';
    fb.textContent = '';
    const btn = document.getElementById('notifSendBtn');
    btn.disabled = false;
    btn.innerHTML = '<i data-lucide="send" style="width:14px;" class="me-1"></i> Envoyer';
    lucide.createIcons();
    new bootstrap.Modal(document.getElementById('notifModal')).show();
}

function sendNotif() {
    const userId  = document.getElementById('notifUserId').value;
    const title   = document.getElementById('notifTitle').value.trim();
    const message = document.getElementById('notifMessage').value.trim();
    const fb      = document.getElementById('notifFeedback');
    const btn     = document.getElementById('notifSendBtn');

    if (!message) {
        fb.className = 'alert alert-danger rounded-3 p-2 small';
        fb.textContent = 'Le message est obligatoire.';
        return;
    }

    btn.disabled = true;
    btn.textContent = 'Envoi en cours...';
    fb.className = 'd-none';

    fetch('/console_/users/' + userId + '/notify', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ title: title || null, message })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            fb.className = 'alert alert-success rounded-3 p-2 small';
            fb.textContent = '✅ Notification envoyée avec succès.';
            setTimeout(() => {
                bootstrap.Modal.getInstance(document.getElementById('notifModal')).hide();
            }, 1500);
        } else {
            fb.className = 'alert alert-danger rounded-3 p-2 small';
            fb.textContent = 'Erreur : ' + (data.message || 'Inconnue');
            btn.disabled = false;
            btn.innerHTML = '<i data-lucide="send" style="width:14px;" class="me-1"></i> Envoyer';
            lucide.createIcons();
        }
    })
    .catch(() => {
        fb.className = 'alert alert-danger rounded-3 p-2 small';
        fb.textContent = 'Erreur réseau. Réessayez.';
        btn.disabled = false;
        btn.innerHTML = '<i data-lucide="send" style="width:14px;" class="me-1"></i> Envoyer';
        lucide.createIcons();
    });
}
</script>
@endpush

@push('modals')
{{-- Modal notification --}}
<div class="modal fade" id="notifModal" tabindex="-1" aria-labelledby="notifModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" id="notifModalLabel">🔔 Envoyer une notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 py-3">
                <input type="hidden" id="notifUserId">
                <p class="text-secondary small mb-3" id="notifUserName"></p>
                <div class="mb-3">
                    <label class="form-label fw-semibold small text-dark">Titre <span class="text-secondary fw-normal">(optionnel)</span></label>
                    <input type="text" id="notifTitle" class="form-control rounded-3" placeholder="Ex: Mise à jour importante" maxlength="255">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold small text-dark">Message <span class="text-danger">*</span></label>
                    <textarea id="notifMessage" class="form-control rounded-3" rows="4" placeholder="Votre message à cet utilisateur..." maxlength="5000"></textarea>
                </div>
                <div id="notifFeedback" class="d-none rounded-3 p-2 small"></div>
            </div>
            <div class="modal-footer border-0 pt-0 px-4 pb-4">
                <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-warning rounded-3 fw-semibold px-4" id="notifSendBtn" onclick="sendNotif()">
                    <i data-lucide="send" style="width:14px;" class="me-1"></i> Envoyer
                </button>
            </div>
        </div>
    </div>
</div>
@endpush
