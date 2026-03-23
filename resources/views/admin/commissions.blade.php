@extends('admin.layout')

@section('title', 'Commissions d\'Affiliation')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-handshake me-2"></i>Commissions d'Affiliation
                    </h4>
                    <div class="d-flex gap-2">
                        <span class="badge bg-light text-dark fs-6">
                            Total: {{ number_format($totalCommissions, 0, ',', ' ') }} F CFA
                        </span>
                    </div>
                </div>
                <div class="card-body p-4">
                    
                    <!-- Statistiques rapides -->
                    <div class="row mb-4">
                        <div class="col-12 col-sm-6 col-md-3 mb-3 mb-md-0">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-users fs-2 mb-2"></i>
                                    <h3>{{ $totalAffiliations }}</h3>
                                    <p class="mb-0">Affiliations Actives</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 mb-3 mb-md-0">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-coins fs-2 mb-2"></i>
                                    <h3>{{ $commissionsToday }}</h3>
                                    <p class="mb-0">Commissions Aujourd'hui</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 mb-3 mb-md-0">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-percentage fs-2 mb-2"></i>
                                    <h3>{{ $averageCommissionRate }}%</h3>
                                    <p class="mb-0">Taux Moyen</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 mb-3 mb-md-0">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-chart-line fs-2 mb-2"></i>
                                    <h3>{{ number_format($monthlyTotal, 0, ',', ' ') }}</h3>
                                    <p class="mb-0">F CFA ce mois</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-hand-holding-usd fs-2 mb-2"></i>
                                    <h3>{{ $pendingWithdrawalsCount }}</h3>
                                    <p class="mb-1">Retraits en attente</p>
                                    <small class="text-white-50">{{ number_format($pendingWithdrawalsTotal ?? 0, 0, ',', ' ') }} F CFA</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-user-friends text-primary me-2"></i>Vue d'ensemble par affilié</h5>
                            <span class="text-muted">{{ $affiliationsSummary->count() }} affilié(s)</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Utilisateur</th>
                                            <th>Code d'affiliation</th>
                                            <th>Commissions validées</th>
                                            <th>Commissions en attente</th>
                                            <th>Retraits en attente</th>
                                            <th>Dernière demande</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($affiliationsSummary as $affiliation)
                                            @php
                                                $lastRetrait = $affiliation->retraits->first();
                                                $validatedTotal = (float) ($affiliation->commissions_validees_total ?? 0);
                                                $pendingTotal = (float) ($affiliation->commissions_en_attente_total ?? 0);
                                                $withdrawalPendingTotal = (float) ($affiliation->retraits_en_attente_total ?? 0);
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="fw-bold">{{ $affiliation->user->nom ?? 'N/A' }} {{ $affiliation->user->prenom ?? '' }}</div>
                                                    <small class="text-muted">{{ $affiliation->user->email ?? '—' }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary">{{ $affiliation->code_affiliation }}</span>
                                                </td>
                                                <td class="fw-bold text-success">
                                                    {{ number_format($validatedTotal, 0, ',', ' ') }} F
                                                </td>
                                                <td class="fw-bold text-warning">
                                                    {{ number_format($pendingTotal, 0, ',', ' ') }} F
                                                </td>
                                                <td>
                                                    @if($affiliation->retraits_en_attente_count)
                                                        <span class="badge bg-danger">{{ $affiliation->retraits_en_attente_count }} demande(s)</span>
                                                        <div class="fw-bold">
                                                            {{ number_format($withdrawalPendingTotal, 0, ',', ' ') }} F
                                                        </div>
                                                    @else
                                                        <span class="text-muted">Aucune demande</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($lastRetrait)
                                                        <div class="fw-bold">
                                                            {{ number_format((float) $lastRetrait->montant, 0, ',', ' ') }} F
                                                        </div>
                                                        <div>
                                                            <span class="badge bg-{{ $lastRetrait->statut_color }}">
                                                                {{ ucwords(str_replace('_', ' ', $lastRetrait->statut)) }}
                                                            </span>
                                                        </div>
                                                            <small class="text-muted">
                                                            {{ $lastRetrait->date_demande ? $lastRetrait->date_demande->setTimezone('Europe/Paris')->format('d/m/Y H:i') : '' }}
                                                        </small>
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-3">
                                                    Aucune affiliation trouvée.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-hand-holding-usd text-danger me-2"></i>Demandes de retrait en attente</h5>
                            <span class="text-muted">{{ $pendingWithdrawals->count() }} demande(s)</span>
                        </div>
                        <div class="card-body p-0">
                            @if($pendingWithdrawals->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Date de demande</th>
                                                <th>Affilié</th>
                                                <th>Montant</th>
                                                <th>Opérateur</th>
                                                <th>Numéro</th>
                                                <th>Statut</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pendingWithdrawals as $withdrawal)
                                                <tr>
                                                    <td>{{ $withdrawal->date_demande ? $withdrawal->date_demande->setTimezone('Europe/Paris')->format('d/m/Y H:i') : '—' }}</td>
                                                    <td>
                                                        <div class="fw-bold">{{ $withdrawal->user->nom ?? 'N/A' }} {{ $withdrawal->user->prenom ?? '' }}</div>
                                                        <small class="text-muted">{{ $withdrawal->user->email ?? '' }}</small>
                                                    </td>
                                                    <td class="fw-bold text-danger">{{ number_format((float) $withdrawal->montant, 0, ',', ' ') }} F</td>
                                                    <td>{{ $withdrawal->operateur_nom ?? ucfirst($withdrawal->operateur) }}</td>
                                                    <td>{{ $withdrawal->numero_telephone }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $withdrawal->statut_color }}">{{ ucwords(str_replace('_', ' ', $withdrawal->statut)) }}</span>
                                                    </td>
                                                    <td>
                                                        @if(in_array($withdrawal->statut, ['en_attente', 'en_cours']))
                                                            <button class="btn btn-sm btn-success js-mark-withdrawal" data-retrait-id="{{ $withdrawal->id }}">
                                                                <i class="fas fa-check me-1"></i>Marquer traité
                                                            </button>
                                                        @else
                                                            <span class="text-muted">—</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="p-4 text-center text-muted">
                                    Aucune demande de retrait en attente.
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Filtres -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <form method="GET" class="d-flex gap-3">
                                <select name="statut" class="form-select">
                                    <option value="">Tous les statuts</option>
                                    <option value="validee" {{ request('statut') === 'validee' ? 'selected' : '' }}>Validées</option>
                                    <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                                    <option value="en_cours_de_retrait" {{ request('statut') === 'en_cours_de_retrait' ? 'selected' : '' }}>En cours de retrait</option>
                                    <option value="retiree" {{ request('statut') === 'retiree' ? 'selected' : '' }}>Retrait traité</option>
                                </select>
                                <select name="type" class="form-select">
                                    <option value="">Tous les types</option>
                                    <option value="recharge" {{ request('type') === 'recharge' ? 'selected' : '' }}>Recharges</option>
                                    <option value="inscription" {{ request('type') === 'inscription' ? 'selected' : '' }}>Inscriptions (anciennes)</option>
                                </select>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter me-2"></i>Filtrer
                                </button>
                            </form>
                        </div>
                        <div class="col-md-4 text-end">
                            @if(\App\Models\Commission::where('action_type', 'inscription')->count() > 0)
                            <button class="btn btn-warning js-cleanup-inscriptions">
                                <i class="fas fa-broom me-2"></i>Nettoyer les inscriptions
                                <span class="badge bg-light text-dark">{{ \App\Models\Commission::where('action_type', 'inscription')->count() }}</span>
                            </button>
                            @endif
                        </div>
                    </div>

                    <!-- Tableau des commissions -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Date</th>
                                    <th>Parrain</th>
                                    <th>Filleul</th>
                                    <th>Action</th>
                                    <th>Montant Base</th>
                                    <th>Taux</th>
                                    <th>Commission</th>
                                    <th>Statut</th>
                                    <th>Détails</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($commissions as $commission)
                                <tr>
                                    <td>{{ $commission->date_action->setTimezone('Europe/Paris')->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $commission->affiliation->user->nom ?? 'N/A' }} {{ $commission->affiliation->user->prenom ?? '' }}</div>
                                                <small class="text-muted">{{ $commission->affiliation->code_affiliation ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $commission->parrainneUser->nom ?? 'N/A' }} {{ $commission->parrainneUser->prenom ?? '' }}</div>
                                        <small class="text-muted">{{ $commission->parrainneUser->email ?? '' }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ ucfirst($commission->action_type) }}</span>
                                    </td>
                                    <td class="fw-bold">{{ number_format($commission->montant_base, 0, ',', ' ') }} F</td>
                                    <td>{{ $commission->taux_commission }}%</td>
                                    <td class="fw-bold text-success">{{ number_format($commission->montant_commission, 0, ',', ' ') }} F</td>
                                    <td>
                                        @if(in_array($commission->statut, ['validee', 'valide']))
                                            <span class="badge bg-success">Validée</span>
                                        @elseif($commission->statut === 'en_attente')
                                            <span class="badge bg-warning">En attente</span>
                                        @elseif($commission->statut === 'en_cours_de_retrait')
                                            <span class="badge bg-info">En cours de retrait</span>
                                        @elseif($commission->statut === 'retiree')
                                            <span class="badge bg-primary">Retrait traité</span>
                                        @elseif($commission->statut === 'rejetee')
                                            <span class="badge bg-danger">Rejetée</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucwords(str_replace('_', ' ', $commission->statut)) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info js-show-commission" data-commission-id="{{ $commission->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $commissions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour les détails -->
<div class="modal fade" id="commissionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Détails de la Commission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="commissionDetails">
                <!-- Contenu chargé dynamiquement -->
            </div>
        </div>
    </div>
</div>

<script>
async function showCommissionDetails(commissionId) {
    document.getElementById('commissionDetails').innerHTML = `
        <div class="text-center">
            <i class="fas fa-spinner fa-spin fs-1 text-primary"></i>
            <p class="mt-2">Chargement des détails...</p>
        </div>
    `;
    
    const modal = new bootstrap.Modal(document.getElementById('commissionModal'));
    modal.show();
    
    try {
        const response = await fetch(`/admin/commissions/${commissionId}`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        if (response.ok) {
            const data = await response.json();
            const details = data.details;
            const commission = data.commission;
            const statutBadge = (() => {
                switch (commission.statut) {
                    case 'validee':
                    case 'valide':
                        return '<span class="badge bg-success">Validée</span>';
                    case 'en_attente':
                        return '<span class="badge bg-warning">En attente</span>';
                    case 'en_cours_de_retrait':
                        return '<span class="badge bg-info">En cours de retrait</span>';
                    case 'retiree':
                        return '<span class="badge bg-primary">Retrait traité</span>';
                    case 'rejetee':
                        return '<span class="badge bg-danger">Rejetée</span>';
                    default:
                        return `<span class="badge bg-secondary">${commission.statut.replace(/_/g, ' ')}</span>`;
                }
            })();
            
            document.getElementById('commissionDetails').innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">Informations du Parrain</h6>
                        <table class="table table-sm">
                            <tr><td><strong>Nom:</strong></td><td>${details.parrain_nom}</td></tr>
                            <tr><td><strong>Email:</strong></td><td>${details.parrain_email}</td></tr>
                            <tr><td><strong>Code Affiliation:</strong></td><td><span class="badge bg-secondary">${details.code_affiliation}</span></td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success">Informations du Filleul</h6>
                        <table class="table table-sm">
                            <tr><td><strong>Nom:</strong></td><td>${details.filleul_nom}</td></tr>
                            <tr><td><strong>Email:</strong></td><td>${details.filleul_email}</td></tr>
                        </table>
                    </div>
                </div>
                
                <hr>
                
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="text-info">Détails de la Commission</h6>
                        <table class="table table-sm">
                            <tr><td><strong>Date d'action:</strong></td><td>${details.date_action}</td></tr>
                            <tr><td><strong>Type d'action:</strong></td><td><span class="badge bg-primary">${commission.action_type}</span></td></tr>
                            <tr><td><strong>Montant de base:</strong></td><td class="fw-bold">${details.montant_base_formatted}</td></tr>
                            <tr><td><strong>Taux de commission:</strong></td><td>${commission.taux_commission}%</td></tr>
                            <tr><td><strong>Montant de commission:</strong></td><td class="fw-bold text-success">${details.montant_commission_formatted}</td></tr>
                            <tr><td><strong>Statut:</strong></td><td>
                                ${statutBadge}
                            </td></tr>
                        </table>
                    </div>
                </div>
                
                ${commission.statut === 'en_attente' ? `
                <div class="d-flex gap-2 mt-3">
                    <button class="btn btn-success btn-sm" onclick="validateCommission(${commissionId})">
                        <i class="fas fa-check me-2"></i>Valider
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="rejectCommission(${commissionId})">
                        <i class="fas fa-times me-2"></i>Rejeter
                    </button>
                </div>
                ` : ''}
            `;
        } else {
            throw new Error('Erreur de chargement');
        }
    } catch (error) {
        document.getElementById('commissionDetails').innerHTML = `
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Erreur lors du chargement des détails.
            </div>
        `;
    }
}

async function validateCommission(commissionId) {
    if (!confirm('Êtes-vous sûr de vouloir valider cette commission ?')) {
        return;
    }
    
    try {
        const response = await fetch(`/admin/commissions/${commissionId}/validate`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            showAlert('success', data.message);
            location.reload();
        } else {
            showAlert('danger', data.message);
        }
    } catch (error) {
        showAlert('danger', 'Erreur lors de la validation');
    }
}

async function rejectCommission(commissionId) {
    if (!confirm('Êtes-vous sûr de vouloir rejeter cette commission ?')) {
        return;
    }
    
    try {
        const response = await fetch(`/admin/commissions/${commissionId}/reject`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            showAlert('success', data.message);
            location.reload();
        } else {
            showAlert('danger', data.message);
        }
    } catch (error) {
        showAlert('danger', 'Erreur lors du rejet');
    }
}

async function markWithdrawalProcessed(retraitId) {
    if (!confirm('Confirmez-vous avoir traité cette demande de retrait ?')) {
        return;
    }

    try {
        const response = await fetch(`/admin/retraits/${retraitId}/mark-processed`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        const data = await response.json();

        if (data.success) {
            showAlert('success', data.message);
            setTimeout(() => window.location.reload(), 1200);
        } else {
            showAlert('danger', data.message);
        }
    } catch (error) {
        showAlert('danger', 'Erreur lors de la mise à jour du retrait');
    }
}

async function cleanupInscriptionCommissions() {
    if (!confirm('⚠️ ATTENTION ⚠️\n\nCette action va supprimer définitivement toutes les commissions liées aux inscriptions.\n\nCes commissions ne sont plus nécessaires car le système a été modifié pour ne créer des commissions QUE lors des recharges.\n\nÊtes-vous sûr de vouloir continuer ?')) {
        return;
    }
    
    try {
        const response = await fetch('/admin/commissions/cleanup-inscriptions', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            showAlert('success', data.message);
            setTimeout(() => {
                location.reload();
            }, 2000);
        } else {
            showAlert('danger', data.message);
        }
    } catch (error) {
        showAlert('danger', 'Erreur lors du nettoyage');
    }
}

function showAlert(type, message) {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999;">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', alertHtml);
    
    // Auto-remove après 5 secondes
    setTimeout(() => {
        const alert = document.querySelector('.alert:last-child');
        if (alert) alert.remove();
    }, 5000);
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.js-show-commission').forEach(button => {
        button.addEventListener('click', () => {
            const commissionId = button.getAttribute('data-commission-id');
            if (commissionId) {
                showCommissionDetails(commissionId);
            }
        });
    });

    document.querySelectorAll('.js-mark-withdrawal').forEach(button => {
        button.addEventListener('click', () => {
            const retraitId = button.getAttribute('data-retrait-id');
            if (retraitId) {
                markWithdrawalProcessed(retraitId);
            }
        });
    });

    document.querySelectorAll('.js-cleanup-inscriptions').forEach(button => {
        button.addEventListener('click', cleanupInscriptionCommissions);
    });
});
</script>

<style>
.avatar-sm {
    width: 35px;
    height: 35px;
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
}

/* ===== RESPONSIVE - HEADER ===== */
@media (max-width: 767px) {
    .card-header {
        padding: 1rem;
    }
    
    .card-header h4 {
        font-size: 1.1rem;
    }
    
    .card-header .badge {
        font-size: 0.8rem;
        padding: 0.35rem 0.6rem;
    }
    
    .card-body {
        padding: 1rem;
    }
}

@media (max-width: 575px) {
    .card-header {
        padding: 0.85rem;
        flex-direction: column;
        align-items: flex-start !important;
        gap: 0.75rem;
    }
    
    .card-header h4 {
        font-size: 1rem;
        margin-bottom: 0;
    }
    
    .card-header .d-flex {
        width: 100%;
        justify-content: flex-start !important;
    }
}

/* ===== RESPONSIVE - CARTES DE STATISTIQUES ===== */
@media (max-width: 767px) {
    /* Mobile - Les cartes ont déjà mb-3 dans le HTML */
    .row.mb-4 [class*="col-"] {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }
    
    /* Cartes de stats plus compactes */
    .row.mb-4 .card {
        height: 100%;
    }
    
    .row.mb-4 .card-body {
        padding: 1rem;
    }
    
    .row.mb-4 .card-body h3 {
        font-size: 1.75rem;
        margin-bottom: 0.5rem;
    }
    
    .row.mb-4 .card-body p {
        font-size: 0.9rem;
    }
    
    .row.mb-4 .card-body i {
        font-size: 1.5rem !important;
    }
}

@media (max-width: 575px) {
    /* Petits mobiles - Plus d'espace */
    .row.mb-4 [class*="col-md-"] {
        margin-bottom: 0.85rem;
    }
    
    .row.mb-4 .card-body {
        padding: 0.85rem;
    }
    
    .row.mb-4 .card-body h3 {
        font-size: 1.5rem;
    }
    
    .row.mb-4 .card-body p {
        font-size: 0.85rem;
    }
    
    .row.mb-4 .card-body small {
        font-size: 0.75rem;
    }
}

@media (max-width: 380px) {
    /* Très petits écrans */
    .row.mb-4 [class*="col-md-"] {
        margin-bottom: 0.75rem;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }
    
    .row.mb-4 .card-body {
        padding: 0.75rem;
    }
    
    .row.mb-4 .card-body h3 {
        font-size: 1.35rem;
    }
    
    .row.mb-4 .card-body i {
        font-size: 1.35rem !important;
    }
}

/* ===== RESPONSIVE - TABLEAUX ===== */
@media (max-width: 767px) {
    .table-responsive {
        border-radius: 0.5rem;
        margin: 0 -0.5rem;
    }
    
    .table {
        font-size: 0.85rem;
    }
    
    .table th,
    .table td {
        padding: 0.65rem 0.5rem;
        white-space: nowrap;
    }
    
    .table thead th {
        font-size: 0.8rem;
    }
    
    /* Boutons dans le tableau */
    .table .btn {
        padding: 0.35rem 0.6rem;
        font-size: 0.8rem;
    }
    
    .table .badge {
        font-size: 0.7rem;
        padding: 0.3rem 0.5rem;
    }
}

@media (max-width: 575px) {
    .table {
        font-size: 0.8rem;
    }
    
    .table th,
    .table td {
        padding: 0.5rem 0.4rem;
    }
    
    .table thead th {
        font-size: 0.75rem;
    }
    
    .table .btn {
        padding: 0.3rem 0.5rem;
        font-size: 0.75rem;
    }
}

@media (max-width: 380px) {
    .table {
        font-size: 0.75rem;
    }
    
    .table th,
    .table td {
        padding: 0.4rem 0.3rem;
    }
}

/* ===== RESPONSIVE - CONTAINER ===== */
@media (max-width: 767px) {
    .container-fluid {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }
}

@media (max-width: 575px) {
    .container-fluid {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }
    
    .container-fluid.py-4 {
        padding-top: 1rem !important;
        padding-bottom: 1rem !important;
    }
}
</style>
@endsection