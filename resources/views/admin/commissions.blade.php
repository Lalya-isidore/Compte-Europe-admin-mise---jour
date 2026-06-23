@extends('admin.layout')

@section('title', 'Commissions d\'Affiliation')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
@php
    $statusColors = [
        'validee' => 'success',
        'valide' => 'success',
        'en_attente' => 'warning',
        'en_cours_de_retrait' => 'info',
        'retiree' => 'primary',
        'rejetee' => 'danger',
    ];
    $statusLabels = [
        'validee' => 'Validée',
        'valide' => 'Validée',
        'en_attente' => 'En attente',
        'en_cours_de_retrait' => 'En cours...',
        'retiree' => 'Traitée',
        'rejetee' => 'Rejetée',
    ];
@endphp

{{-- Header --}}
<div class="mb-5 d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h2 class="fw-bold h3 mb-2">Gestion des Commissions 📈</h2>
        <p class="text-secondary">Suivez les performances de parrainage et validez les gains.</p>
    </div>
    <div class="card-premium py-2 px-4 shadow-sm border-0 d-flex align-items-center gap-3">
        <div class="text-end">
            <span class="smaller text-secondary d-block">Gain Total Distribué</span>
            <span class="h5 fw-bold text-dark mb-0">{{ number_format($totalCommissions, 0, ',', ' ') }} F CFA</span>
        </div>
        <div class="stat-icon bg-success bg-opacity-10 text-success ms-2">
            <i data-lucide="award"></i>
        </div>
    </div>
</div>

{{-- Stats Grid --}}
<div class="stats-grid mb-5">
    <div class="card-premium stat-card">
        <div class="stat-info">
            <h3>Affiliations Actives</h3>
            <p class="stat-value">{{ number_format($totalAffiliations, 0, ',', ' ') }}</p>
        </div>
        <div class="stat-icon bg-primary bg-opacity-10 text-primary">
            <i data-lucide="users"></i>
        </div>
    </div>
    
    <div class="card-premium stat-card">
        <div class="stat-info">
            <h3>Gain du Jour</h3>
            <p class="stat-value text-success">+{{ number_format($commissionsToday, 0, ',', ' ') }}</p>
        </div>
        <div class="stat-icon bg-success bg-opacity-10 text-success">
            <i data-lucide="trending-up"></i>
        </div>
    </div>
    
    <div class="card-premium stat-card">
        <div class="stat-info">
            <h3>Taux de Com. Moyen</h3>
            <p class="stat-value">{{ $averageCommissionRate }}%</p>
        </div>
        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
            <i data-lucide="percent"></i>
        </div>
    </div>
    
    <div class="card-premium stat-card">
        <div class="stat-info">
            <h3>Volume du Mois</h3>
            <p class="stat-value">{{ number_format($monthlyTotal, 0, ',', ' ') }} F</p>
        </div>
        <div class="stat-icon bg-info bg-opacity-10 text-info">
            <i data-lucide="bar-chart-3"></i>
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
    {{-- Pending Withdrawals --}}
    <div class="col-12">
        <div class="card-premium shadow-sm border p-0 overflow-hidden {{ $pendingWithdrawals->isNotEmpty() ? 'border-danger border-opacity-25' : '' }}">
            <div class="px-4 py-3 border-bottom bg-light bg-opacity-50 d-flex justify-content-between align-items-center">
                <h3 class="h6 fw-bold mb-0 d-flex align-items-center gap-2">
                    <i data-lucide="wallet" class="text-danger"></i>
                    Demandes de retrait en attente
                </h3>
                @if($pendingWithdrawals->isNotEmpty())
                    <span class="badge bg-danger rounded-pill px-3">{{ $pendingWithdrawalsCount }} demande(s)</span>
                @endif
            </div>
            <div class="card-body p-0">
                @if($pendingWithdrawals->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr class="smaller text-secondary text-uppercase fw-bold">
                                    <th class="ps-4">Affilié</th>
                                    <th>Montant</th>
                                    <th>Opérateur</th>
                                    <th>Numéro</th>
                                    <th>Statut</th>
                                    <th class="pe-4 text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingWithdrawals as $withdrawal)
                                    <tr>
                                        <td class="ps-4 py-3">
                                            <div class="fw-bold text-dark">{{ $withdrawal->user->nom ?? 'N/A' }} {{ $withdrawal->user->prenom ?? '' }}</div>
                                            <div class="smaller text-secondary">{{ $withdrawal->user->email ?? '' }}</div>
                                        </td>
                                        <td class="py-3 fw-bold text-danger">{{ number_format((float) $withdrawal->montant, 0, ',', ' ') }} F</td>
                                        <td class="py-3 smaller">{{ $withdrawal->operateur_nom ?? ucfirst($withdrawal->operateur) }}</td>
                                        <td class="py-3 smaller fw-medium">{{ $withdrawal->numero_telephone }}</td>
                                        <td class="py-3">
                                            <span class="badge bg-{{ $withdrawal->statut_color }} bg-opacity-10 text-{{ $withdrawal->statut_color }} rounded-pill px-3">
                                                {{ ucwords(str_replace('_', ' ', $withdrawal->statut)) }}
                                            </span>
                                        </td>
                                        <td class="pe-4 py-3 text-end">
                                            <button class="btn btn-success btn-premium btn-sm js-mark-withdrawal" data-retrait-id="{{ $withdrawal->id }}">
                                                <i data-lucide="check" class="me-1" style="width: 14px;"></i> Traité
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-5 text-center text-secondary opacity-50">
                        <i data-lucide="check-circle-2" class="mb-2" style="width: 48px; height: 48px;"></i>
                        <p class="mb-0">Aucune demande de retrait en attente.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Affiliates Summary --}}
    <div class="col-12">
        <div class="card-premium shadow-sm border p-0 overflow-hidden">
            <div class="px-4 py-3 border-bottom bg-light bg-opacity-50 d-flex justify-content-between align-items-center">
                <h3 class="h6 fw-bold mb-0 d-flex align-items-center gap-2">
                    <i data-lucide="shield-check" class="text-primary"></i>
                    Vue d'ensemble par affilié
                </h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr class="smaller text-secondary text-uppercase fw-bold">
                                <th class="ps-4">Affilié & Code</th>
                                <th>Validées</th>
                                <th>En attente</th>
                                <th>Retraits</th>
                                <th class="pe-4">Dernière demande</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($affiliationsSummary as $affiliation)
                                @php
                                    $lastRetrait = $affiliation->retraits->first();
                                    $validatedTotal = (float) ($affiliation->commissions_validees_total ?? 0);
                                    $pendingTotal = (float) ($affiliation->commissions_en_attente_total ?? 0);
                                @endphp
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="fw-bold text-dark">{{ $affiliation->user->nom ?? 'N/A' }} {{ $affiliation->user->prenom ?? '' }}</div>
                                        <div class="smaller fw-medium text-primary">Code: {{ $affiliation->code_affiliation }}</div>
                                    </td>
                                    <td class="py-3">
                                        <span class="fw-bold text-success">{{ number_format($validatedTotal, 0, ',', ' ') }} F</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="fw-bold text-warning">{{ number_format($pendingTotal, 0, ',', ' ') }} F</span>
                                    </td>
                                    <td class="py-3">
                                        @if($affiliation->retraits_en_attente_count)
                                            <span class="badge bg-danger rounded-pill px-2">{{ $affiliation->retraits_en_attente_count }}</span>
                                            <div class="smaller fw-bold text-danger mt-1">{{ number_format((float) $affiliation->retraits_en_attente_total, 0, ',', ' ') }} F</div>
                                        @else
                                            <span class="text-secondary smaller opacity-50">Aucun</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 py-3">
                                        @if($lastRetrait)
                                            <div class="smaller fw-bold text-dark">{{ number_format((float) $lastRetrait->montant, 0, ',', ' ') }} F</div>
                                            <span class="badge bg-{{ $lastRetrait->statut_color }} rounded-pill" style="font-size: 0.65rem;">
                                                {{ ucwords(str_replace('_', ' ', $lastRetrait->statut)) }}
                                            </span>
                                        @else
                                            <span class="text-secondary smaller">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Search & Filters --}}
<div class="card-premium mb-4 border-0 shadow-sm py-3 px-4">
    <div class="row g-3 align-items-center">
        <div class="col-lg-8 col-md-7">
            <form method="GET" class="d-flex gap-2">
                <div class="input-group input-group-sm border rounded-3 overflow-hidden" style="background: #f8fafc; max-width: 250px;">
                    <span class="input-group-text border-0 bg-transparent ps-3">
                        <i data-lucide="filter" class="text-secondary" style="width: 14px;"></i>
                    </span>
                    <select name="statut" class="form-select border-0 bg-transparent fs-7 py-2" onchange="this.form.submit()">
                        <option value="">Tous les statuts</option>
                        @foreach(['validee', 'en_attente', 'en_cours_de_retrait', 'retiree'] as $st)
                            <option value="{{ $st }}" {{ request('statut') === $st ? 'selected' : '' }}>{{ $statusLabels[$st] ?? $st }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group input-group-sm border rounded-3 overflow-hidden" style="background: #f8fafc; max-width: 200px;">
                    <select name="type" class="form-select border-0 bg-transparent fs-7 py-2" onchange="this.form.submit()">
                        <option value="">Tous les types</option>
                        <option value="recharge" {{ request('type') === 'recharge' ? 'selected' : '' }}>Recharges</option>
                        <option value="inscription" {{ request('type') === 'inscription' ? 'selected' : '' }}>Inscriptions</option>
                    </select>
                </div>
                @if(request('statut') || request('type'))
                    <a href="{{ route('admin.commissions.index') }}" class="btn btn-light btn-premium btn-sm border">Réinitialiser</a>
                @endif
            </form>
        </div>
        <div class="col-lg-4 col-md-5 text-end">
            @if(\App\Models\Commission::where('action_type', 'inscription')->count() > 0)
                <button class="btn btn-soft-warning btn-premium btn-sm js-cleanup-inscriptions">
                    <i data-lucide="broom" class="me-1" style="width: 14px;"></i> 
                    Nettoyer les inscriptions ({{ \App\Models\Commission::where('action_type', 'inscription')->count() }})
                </button>
            @endif
        </div>
    </div>
</div>

{{-- Main Commissions Table --}}
<div class="card-premium shadow-sm border p-0 overflow-hidden mb-5">
    <div class="table-responsive">
        <table class="table table-hover mb-0" id="mainCommissionsTable">
            <thead class="bg-light">
                <tr class="smaller text-secondary text-uppercase fw-bold">
                    <th class="ps-4">Date</th>
                    <th>Parrain</th>
                    <th>Filleul</th>
                    <th>Type</th>
                    <th>Comm.</th>
                    <th>Statut</th>
                    <th class="pe-4 text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($commissions as $commission)
                    @php
                        $pInitials = mb_substr($commission->affiliation->user->prenom ?? '?', 0, 1) . mb_substr($commission->affiliation->user->nom ?? '', 0, 1);
                    @endphp
                    <tr>
                        <td class="ps-4 py-3 smaller text-secondary">
                            {{ $commission->date_action->setTimezone('Europe/Paris')->format('d/m/Y') }}<br>
                            <span class="opacity-50">{{ $commission->date_action->setTimezone('Europe/Paris')->format('H:i') }}</span>
                        </td>
                        <td class="py-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar bg-primary bg-opacity-10 text-primary rounded-pill d-flex align-items-center justify-content-center fw-bold smaller" style="width: 32px; height: 32px;">
                                    {{ $pInitials }}
                                </div>
                                <div class="overflow-hidden">
                                    <div class="fw-bold text-dark text-truncate" style="max-width: 120px;">{{ $commission->affiliation->user->nom ?? 'N/A' }}</div>
                                    <div class="smaller text-primary opacity-75">{{ $commission->affiliation->code_affiliation ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3">
                            <div class="fw-bold text-dark text-truncate" style="max-width: 120px;">{{ $commission->parrainneUser->nom ?? 'N/A' }}</div>
                            <div class="smaller text-secondary opacity-75">{{ $commission->parrainneUser->email ?? '' }}</div>
                        </td>
                        <td class="py-3">
                            <span class="badge bg-light text-secondary rounded-pill px-2" style="font-size: 0.65rem;">{{ ucfirst($commission->action_type) }}</span>
                        </td>
                        <td class="py-3">
                            <div class="fw-bold text-success">{{ number_format($commission->montant_commission, 0, ',', ' ') }} F</div>
                            <div class="smaller text-secondary opacity-50">{{ $commission->taux_commission }}% de {{ number_format($commission->montant_base, 0, ',', ' ') }}</div>
                        </td>
                        <td class="py-3">
                            <span class="badge bg-{{ $statusColors[$commission->statut] ?? 'light' }} bg-opacity-10 text-{{ $statusColors[$commission->statut] ?? 'dark' }} rounded-pill px-3">
                                {{ $statusLabels[$commission->statut] ?? $commission->statut }}
                            </span>
                        </td>
                        <td class="pe-4 py-3 text-end">
                            <button class="btn btn-light btn-premium btn-sm js-show-commission border" data-commission-id="{{ $commission->id }}">
                                <i data-lucide="eye" style="width: 14px;"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination --}}
<div class="d-flex justify-content-center pt-4 mb-5">
    {{ $commissions->links('pagination::bootstrap-5') }}
</div>

@push('modals')
{{-- Modal for Details --}}
<div class="modal fade" id="commissionModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content glass-morphism border-0 rounded-4 overflow-hidden shadow-premium">
            <div class="modal-header border-0 bg-primary bg-opacity-10 py-4 px-4">
                <h5 class="modal-title fw-bold text-primary d-flex align-items-center gap-2">
                    <i data-lucide="info"></i>
                    Détails de la Commission
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="commissionDetails">
                <!-- Loaded via AJAX -->
            </div>
        </div>
    </div>
</div>
@endpush

<style>
    .btn-soft-warning {
        background-color: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
    }
    .btn-soft-warning:hover {
        background-color: #fef3c7;
        color: #92400e;
    }
    .glass-morphism {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
    }
    .fs-7 { font-size: 0.8rem; }
    .shadow-premium { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15); }
</style>
@endsection

@push('scripts')
<script>
async function showCommissionDetails(commissionId) {
    const detailsContainer = document.getElementById('commissionDetails');
    detailsContainer.innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-primary mb-3" role="status"></div>
            <p class="text-secondary">Chargement des données...</p>
        </div>
    `;
    
    const modal = new bootstrap.Modal(document.getElementById('commissionModal'));
    modal.show();
    
    try {
        const response = await fetch(`/admin/commissions/${commissionId}`, {
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
        });
        
        if (response.ok) {
            const data = await response.json();
            const details = data.details;
            const commission = data.commission;
            
            const statusMap = {
                'validee': { label: 'Validée', class: 'success' },
                'valide': { label: 'Validée', class: 'success' },
                'en_attente': { label: 'En attente', class: 'warning' },
                'en_cours_de_retrait': { label: 'En transfert', class: 'info' },
                'retiree': { label: 'Retrait Traité', class: 'primary' },
                'rejetee': { label: 'Rejetée', class: 'danger' }
            };
            const s = statusMap[commission.statut] || { label: commission.statut, class: 'secondary' };
            
            detailsContainer.innerHTML = `
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-4 h-100">
                            <h6 class="fw-bold mb-3 text-primary d-flex align-items-center gap-2">
                                <i data-lucide="user-plus" style="width: 16px;"></i> Parrain
                            </h6>
                            <p class="mb-1 fw-bold text-dark">${details.parrain_nom}</p>
                            <p class="smaller text-secondary mb-3">${details.parrain_email}</p>
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">Code: ${details.code_affiliation}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-4 h-100">
                            <h6 class="fw-bold mb-3 text-success d-flex align-items-center gap-2">
                                <i data-lucide="user" style="width: 16px;"></i> Filleul
                            </h6>
                            <p class="mb-1 fw-bold text-dark">${details.filleul_nom}</p>
                            <p class="smaller text-secondary mb-0">${details.filleul_email}</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 p-4 border rounded-4">
                    <h6 class="fw-bold mb-4 text-dark border-bottom pb-2">Informations Financières</h6>
                    <div class="row g-4">
                        <div class="col-sm-6">
                            <div class="smaller text-secondary opacity-75">Date d'action</div>
                            <div class="fw-bold text-dark">${details.date_action}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="smaller text-secondary opacity-75">Type de commission</div>
                            <div class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-2 mt-1">${commission.action_type}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="smaller text-secondary opacity-75">Montant Rechargé</div>
                            <div class="h5 fw-bold text-dark mb-0">${details.montant_base_formatted}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="smaller text-secondary opacity-75">Commission (${commission.taux_commission}%)</div>
                            <div class="h5 fw-bold text-success mb-0">${details.montant_commission_formatted}</div>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                        <span class="badge bg-${s.class} bg-opacity-10 text-${s.class} rounded-pill px-4 py-2 fs-7">${s.label}</span>
                        
                        ${commission.statut === 'en_attente' ? `
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-danger btn-premium btn-sm px-3" onclick="rejectCommission(${commissionId})">Rejeter</button>
                            <button class="btn btn-success btn-premium btn-sm px-4" onclick="validateCommission(${commissionId})">Valider le gain</button>
                        </div>
                        ` : ''}
                    </div>
                </div>
            `;
            // Re-initialize Lucide icons in modal
            lucide.createIcons();
        } else {
            throw new Error('Erreur API');
        }
    } catch (error) {
        detailsContainer.innerHTML = `<div class="alert alert-danger border-0 rounded-4">Erreur lors de la récupération des détails.</div>`;
    }
}

async function validateCommission(commissionId) {
    if (!confirm('Confirmer la validation de cette commission ? Le solde de l\'affilié sera crédité.')) return;
    try {
        const response = await fetch(\`/admin/commissions/\${commissionId}/validate\`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
        });
        const data = await response.json();
        if (data.success) { location.reload(); } else { alert(data.message); }
    } catch (error) { alert('Erreur serveur'); }
}

async function rejectCommission(commissionId) {
    if (!confirm('Rejeter cette commission ?')) return;
    try {
        const response = await fetch(\`/admin/commissions/\${commissionId}/reject\`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
        });
        const data = await response.json();
        if (data.success) { location.reload(); } else { alert(data.message); }
    } catch (error) { alert('Erreur serveur'); }
}

async function markWithdrawalProcessed(retraitId) {
    if (!confirm('Confirmez-vous avoir effectué le paiement de ce retrait ?')) return;
    try {
        const response = await fetch(\`/admin/retraits/\${retraitId}/mark-processed\`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
        });
        const data = await response.json();
        if (data.success) { location.reload(); } else { alert(data.message); }
    } catch (error) { alert('Erreur lors de la validation du retrait'); }
}

async function cleanupInscriptionCommissions() {
    if (!confirm('Supprimer définitivement les commissions d\'inscription obsolètes ?')) return;
    try {
        const response = await fetch('/admin/commissions/cleanup-inscriptions', {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
        });
        const data = await response.json();
        if (data.success) { location.reload(); } else { alert(data.message); }
    } catch (error) { alert('Erreur lors du nettoyage'); }
}

document.addEventListener('DOMContentLoaded', () => {
    lucide.createIcons();
    
    document.querySelectorAll('.js-show-commission').forEach(button => {
        button.addEventListener('click', () => {
            const commissionId = button.getAttribute('data-commission-id');
            if (commissionId) showCommissionDetails(commissionId);
        });
    });

    document.querySelectorAll('.js-mark-withdrawal').forEach(button => {
        button.addEventListener('click', () => {
            const retraitId = button.getAttribute('data-retrait-id');
            if (retraitId) markWithdrawalProcessed(retraitId);
        });
    });

    const cleanupBtn = document.querySelector('.js-cleanup-inscriptions');
    if (cleanupBtn) cleanupBtn.addEventListener('click', cleanupInscriptionCommissions);
});
</script>
@endpush