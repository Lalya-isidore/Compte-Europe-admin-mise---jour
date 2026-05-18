@extends('admin.layout')

@section('title', 'Tableau de bord')

@section('content')
<div class="mb-5">
    <h2 class="fw-bold h3 mb-2">Bonjour, {{ explode('@', session('admin_email', 'Admin'))[0] }} 👋</h2>
    <p class="text-secondary">Voici ce qui se passe sur votre plateforme aujourd'hui.</p>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="card-premium stat-card">
        <div class="stat-info">
            <h3>Utilisateurs</h3>
            <p class="stat-value">{{ number_format($stats['users_count'] ?? 0, 0, ',', ' ') }}</p>
        </div>
        <div class="stat-icon bg-primary bg-opacity-10 text-primary">
            <i data-lucide="users"></i>
        </div>
    </div>
    
    <div class="card-premium stat-card">
        <div class="stat-info">
            <h3>Comptes Créés</h3>
            <p class="stat-value">{{ number_format($stats['comptes_count'] ?? 0, 0, ',', ' ') }}</p>
        </div>
        <div class="stat-icon bg-info bg-opacity-10 text-info">
            <i data-lucide="credit-card"></i>
        </div>
    </div>
    
    <div class="card-premium stat-card">
        <div class="stat-info">
            <h3>Commissions</h3>
            <p class="stat-value">{{ number_format($stats['commissions_pending'] ?? 0, 0, ',', ' ') }}</p>
        </div>
        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
            <i data-lucide="percent"></i>
        </div>
    </div>
    
    <div class="card-premium stat-card">
        <div class="stat-info">
            <h3>Support (Ouverts)</h3>
            <p class="stat-value">{{ number_format($stats['support_tickets_open'] ?? 0, 0, ',', ' ') }}</p>
        </div>
        <div class="stat-icon bg-danger bg-opacity-10 text-danger">
            <i data-lucide="message-circle"></i>
        </div>
    </div>
</div>

{{-- Rechargements --}}
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0"><i data-lucide="trending-up" style="width:18px;height:18px;margin-right:6px;vertical-align:-3px"></i>Rechargements (F CFA)</h5>
        <a href="{{ route('rechargeStats.index') }}" class="btn btn-sm btn-outline-secondary">Voir le détail</a>
    </div>
    <div class="row g-3">
        <div class="col-4">
            <div class="card border-0 shadow-sm h-100 p-3 text-center">
                <div class="text-secondary small mb-1">Aujourd'hui</div>
                <div class="fw-bold fs-5 text-success">{{ number_format($rechargeStats['today'], 0, ',', ' ') }} <small style="font-size:.65em;font-weight:500">F</small></div>
            </div>
        </div>
        <div class="col-4">
            <div class="card border-0 shadow-sm h-100 p-3 text-center">
                <div class="text-secondary small mb-1">Cette semaine</div>
                <div class="fw-bold fs-5 text-primary">{{ number_format($rechargeStats['week'], 0, ',', ' ') }} <small style="font-size:.65em;font-weight:500">F</small></div>
            </div>
        </div>
        <div class="col-4">
            <div class="card border-0 shadow-sm h-100 p-3 text-center">
                <div class="text-secondary small mb-1">Ce mois</div>
                <div class="fw-bold fs-5 text-warning">{{ number_format($rechargeStats['month'], 0, ',', ' ') }} <small style="font-size:.65em;font-weight:500">F</small></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Quick Actions -->
    <div class="col-lg-8">
        <div class="card-premium mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold h5 mb-0">Actions Rapides</h4>
                <i data-lucide="zap" class="text-warning"></i>
            </div>
            
            <div class="row g-3">
                <div class="col-md-6">
                    <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                        <div class="p-4 rounded-4 border border-light-subtle h-100 transition-hover" style="background: #f8fafc;">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="p-2 bg-primary bg-opacity-10 text-primary rounded-3">
                                    <i data-lucide="user-plus" style="width: 20px; height: 20px;"></i>
                                </div>
                                <h5 class="h6 fw-bold mb-0 text-dark">Gérer les Utilisateurs</h5>
                            </div>
                            <p class="small text-secondary mb-0">Modifier les soldes, gérer les accès et voir les historiques complets.</p>
                        </div>
                    </a>
                </div>
                
                <div class="col-md-6">
                    <a href="{{ route('admin.commissions.index') }}" class="text-decoration-none">
                        <div class="p-4 rounded-4 border border-light-subtle h-100 transition-hover" style="background: #f8fafc;">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="p-2 bg-success bg-opacity-10 text-success rounded-3">
                                    <i data-lucide="arrow-up-right" style="width: 20px; height: 20px;"></i>
                                </div>
                                <h5 class="h6 fw-bold mb-0 text-dark">Valider Commissions</h5>
                            </div>
                            <p class="small text-secondary mb-0">Vérifier et approuver les demandes de retrait et les gains d'affiliation.</p>
                        </div>
                    </a>
                </div>
                
                <div class="col-md-6">
                    <a href="{{ route('admin.notifyUsers.index') }}" class="text-decoration-none">
                        <div class="p-4 rounded-4 border border-light-subtle h-100 transition-hover" style="background: #f8fafc;">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="p-2 bg-info bg-opacity-10 text-info rounded-3">
                                    <i data-lucide="send" style="width: 20px; height: 20px;"></i>
                                </div>
                                <h5 class="h6 fw-bold mb-0 text-dark">Campagne Email</h5>
                            </div>
                            <p class="small text-secondary mb-0">Envoyer des notifications de masse ou des alertes système aux utilisateurs.</p>
                        </div>
                    </a>
                </div>
                
                <div class="col-md-6">
                    <a href="{{ route('admin.support.index') }}" class="text-decoration-none">
                        <div class="p-4 rounded-4 border border-light-subtle h-100 transition-hover" style="background: #f8fafc;">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="p-2 bg-danger bg-opacity-10 text-danger rounded-3">
                                    <i data-lucide="life-buoy" style="width: 20px; height: 20px;"></i>
                                </div>
                                <h5 class="h6 fw-bold mb-0 text-dark">Centre de Support</h5>
                            </div>
                            <p class="small text-secondary mb-0">Répondre aux tickets d'assistance et gérer les messages d'aide.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Admin Info -->
    <div class="col-lg-4">
        <div class="card-premium bg-dark text-white border-0 shadow-lg mb-4">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="p-2 bg-primary rounded-circle">
                    <i data-lucide="shield" style="width: 20px; height: 20px;"></i>
                </div>
                <h4 class="fw-bold h5 mb-0">Session Sécurisée</h4>
            </div>
            
            <div class="mb-4">
                <p class="small text-secondary mb-1">Email Connecté</p>
                <p class="fw-bold mb-0">{{ $admin_email }}</p>
            </div>
            
            <div class="mb-4">
                <p class="small text-secondary mb-1">Dernière Connexion</p>
                <p class="fw-bold mb-0">{{ $login_time ? $login_time->setTimezone('Europe/Paris')->format('d/m/Y à H:i') : 'N/A' }}</p>
            </div>
            
            <div class="pt-3 border-top border-secondary">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="badge bg-success rounded-pill px-3 py-2">Session Active</span>
                    <i data-lucide="refresh-cw" class="text-secondary cursor-pointer" style="width: 16px; height: 16px;"></i>
                </div>
            </div>
        </div>
        
        <div class="card-premium">
            <h4 class="fw-bold h6 mb-3">Historique Rapide</h4>
            <div class="d-flex flex-column gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="dot bg-success"></div>
                    <div class="small">
                        <span class="text-secondary">Système stable</span>
                        <div class="smaller text-muted">Aujourd'hui à 09:00</div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="dot bg-primary"></div>
                    <div class="small">
                        <span class="text-secondary">Backup effectué</span>
                        <div class="smaller text-muted">Hier à 03:00</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Dernières recharges --}}
<div class="card-premium mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold h5 mb-0">
            <i data-lucide="credit-card" style="width:18px;height:18px;margin-right:6px;vertical-align:-3px"></i>
            5 dernières recharges de crédits
        </h4>
        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">Voir les utilisateurs</a>
    </div>

    @if($lastRecharges->isEmpty())
        <p class="text-secondary small text-center py-3">Aucune recharge enregistrée.</p>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size:.875rem">
                <thead class="table-light">
                    <tr>
                        <th>Utilisateur</th>
                        <th>Montant</th>
                        <th>Crédits</th>
                        <th>Méthode</th>
                        <th>Statut</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lastRecharges as $r)
                    <tr>
                        <td>
                            @if($r->user)
                                <a href="{{ route('admin.users.show', $r->user) }}" class="text-decoration-none fw-semibold">
                                    {{ $r->user->name ?? $r->user->email }}
                                </a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>{{ number_format($r->amount, 0, ',', ' ') }} F</td>
                        <td>{{ number_format($r->credits_earned, 0, ',', ' ') }}</td>
                        <td>{{ $r->payment_method ?? '—' }}</td>
                        <td>
                            @php
                                $badge = match($r->status) {
                                    'completed' => 'success',
                                    'pending'   => 'warning',
                                    'failed'    => 'danger',
                                    default     => 'secondary',
                                };
                                $label = match($r->status) {
                                    'completed' => 'Complété',
                                    'pending'   => 'En attente',
                                    'failed'    => 'Échoué',
                                    default     => ucfirst($r->status),
                                };
                            @endphp
                            <span class="badge bg-{{ $badge }}">{{ $label }}</span>
                        </td>
                        <td class="text-muted">{{ $r->created_at->setTimezone('Europe/Paris')->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<style>
    .transition-hover {
        transition: all 0.2s ease;
    }
    .transition-hover:hover {
        transform: translateY(-4px);
        background: #f1f5f9 !important;
        border-color: #cbd5e1 !important;
    }
    .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }
</style>
@endsection
