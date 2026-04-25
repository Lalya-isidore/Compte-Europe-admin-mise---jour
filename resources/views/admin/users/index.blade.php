@extends('admin.layout')

@section('title', 'Gestion des utilisateurs')

@section('content')
    {{-- Header --}}
    <div class="mb-5">
        <h2 class="fw-bold h3 mb-2">Gestion des Utilisateurs 👥</h2>
        <p class="text-secondary">Consultez, recherchez et gérez les comptes de vos utilisateurs.</p>
    </div>

    {{-- Stats Grid --}}
    <div class="stats-grid">
        <div class="card-premium stat-card">
            <div class="stat-info">
                <h3>Total Utilisateurs</h3>
                <p class="stat-value">{{ number_format($globalStats['total_users'] ?? 0, 0, ',', ' ') }}</p>
            </div>
            <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                <i data-lucide="users"></i>
            </div>
        </div>
        
        <div class="card-premium stat-card">
            <div class="stat-info">
                <h3>Sous-comptes</h3>
                <p class="stat-value">{{ number_format($globalStats['total_comptes'] ?? 0, 0, ',', ' ') }}</p>
            </div>
            <div class="stat-icon bg-info bg-opacity-10 text-info">
                <i data-lucide="credit-card"></i>
            </div>
        </div>
        
        <div class="card-premium stat-card">
            <div class="stat-info">
                <h3>Crédits Clients</h3>
                <p class="stat-value">{{ number_format($globalStats['total_credits'] ?? 0, 0, ',', ' ') }}</p>
            </div>
            <div class="stat-icon bg-success bg-opacity-10 text-success">
                <i data-lucide="coins"></i>
            </div>
        </div>
        
        <div class="card-premium stat-card">
            <div class="stat-info">
                <h3>Solde Total</h3>
                <p class="stat-value">{{ number_format($globalStats['total_solde'] ?? 0, 0, ',', ' ') }} F</p>
            </div>
            <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                <i data-lucide="banknote"></i>
            </div>
        </div>
    </div>

    {{-- Search Bar --}}
    <div class="card-premium mb-4 border-0 shadow-sm py-3 px-4">
        <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3 align-items-center">
            <div class="col-lg-8 col-md-7">
                <div class="input-group input-group-lg border rounded-3 overflow-hidden" style="background: #f8fafc;">
                    <span class="input-group-text border-0 bg-transparent ps-3">
                        <i data-lucide="search" class="text-secondary" style="width: 20px;"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-0 bg-transparent fs-6 py-3" placeholder="Rechercher par nom, email, téléphone ou ID..." value="{{ $search }}">
                </div>
            </div>
            <div class="col-lg-4 col-md-5 d-flex gap-2">
                <button class="btn btn-primary-premium btn-premium flex-grow-1 py-3" type="submit">Rechercher</button>
                @if($search)
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light btn-premium py-3 border">Effacer</a>
                @endif
            </div>
        </form>
    </div>

    {{-- Users Grid --}}
    @if($users->count())
        <div class="row g-4 mb-5">
            @foreach($users as $user)
                @php
                    $initials = mb_substr($user->prenom ?? '', 0, 1) . mb_substr($user->nom ?? '', 0, 1);
                    $balance = $user->total_account_balance ?? 0;
                @endphp
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="card-premium h-100 transition-hover border border-light-subtle d-flex flex-column p-4">
                        <div class="mb-4" style="overflow:hidden;">
                            <div class="d-flex align-items-center gap-3" style="min-width:0;">
                                <div class="avatar bg-primary bg-opacity-10 text-primary rounded-4 d-flex align-items-center justify-content-center fw-bold fs-5 flex-shrink-0" style="width:52px;height:52px;">
                                    {{ $initials ?: '?' }}
                                </div>
                                <div style="min-width:0;overflow:hidden;">
                                    <h3 class="h6 fw-bold mb-0 text-dark text-truncate" title="{{ $user->nom }} {{ $user->prenom }}">{{ $user->nom }} {{ $user->prenom }}</h3>
                                    <span class="text-secondary smaller">ID: #{{ $user->id }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i data-lucide="mail" class="text-secondary" style="width: 14px;"></i>
                                <span class="smaller text-secondary text-truncate">{{ $user->email }}</span>
                            </div>
                            @if($user->phone)
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i data-lucide="phone" class="text-secondary" style="width: 14px;"></i>
                                <span class="smaller text-secondary">{{ $user->phone }}</span>
                            </div>
                            @endif
                            <div class="d-flex align-items-center gap-2">
                                <i data-lucide="calendar" class="text-secondary" style="width: 14px;"></i>
                                <span class="smaller text-secondary">Inscrit le {{ $user->created_at?->format('d/m/Y') }}</span>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2 mb-4 mt-auto">
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 fw-semibold" style="font-size: 0.7rem;">
                                {{ number_format($user->credit_user ?? 0, 0, ',', ' ') }} credits
                            </span>
                            <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-2 fw-semibold" style="font-size: 0.7rem;">
                                {{ $user->comptes_count }} compte{{ $user->comptes_count > 1 ? 's' : '' }}
                            </span>
                            @if($balance > 0)
                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-2 fw-semibold" style="font-size: 0.7rem;">
                                {{ number_format($balance, 0, ',', ' ') }} F
                            </span>
                            @endif
                        </div>

                        <div class="d-flex gap-2 pt-3 border-top">
                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-primary-premium btn-premium flex-grow-1 shadow-sm py-2">
                                <i data-lucide="eye" class="me-1" style="width: 14px;"></i> Détails
                            </a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="delete-user-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-premium py-2 border-0 bg-danger bg-opacity-10 text-danger hover-bg-danger">
                                    <i data-lucide="trash-2" style="width: 16px;"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center pt-4">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="card-premium py-5 text-center shadow-none border border-dashed border-2">
            <div class="py-5">
                <i data-lucide="search-x" class="text-secondary opacity-25 mb-3" style="width: 64px; height: 64px;"></i>
                <h4 class="fw-bold mb-2">Aucun utilisateur trouvé</h4>
                <p class="text-secondary mb-4">Ajustez vos critères de recherche pour obtenir des résultats.</p>
                <a href="{{ route('admin.users.index') }}" class="btn btn-primary-premium btn-premium px-4">Réinitialiser la recherche</a>
            </div>
        </div>
    @endif

    <style>
        .transition-hover {
            transition: all 0.3s ease;
        }
        .transition-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: var(--primary) !important;
        }
        .hover-bg-danger:hover {
            background-color: var(--danger) !important;
            color: white !important;
        }
        .pagination {
            gap: 5px;
        }
        .page-item .page-link {
            border-radius: 8px !important;
            border: none;
            padding: 10px 16px;
            color: var(--secondary);
            font-weight: 500;
        }
        .page-item.active .page-link {
            background-color: var(--primary);
            color: white;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }
    </style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    lucide.createIcons();
    
    document.querySelectorAll('.delete-user-form').forEach((form) => {
        form.addEventListener('submit', (event) => {
            const card = form.closest('.card-premium');
            const nameEl = card ? card.querySelector('h3') : null;
            const displayName = nameEl ? nameEl.textContent.trim() : 'cet utilisateur';
            if (!confirm('Attention : Êtes-vous sûr de vouloir supprimer ' + displayName + ' ? Cette action supprimera définitivement tous ses comptes et historiques.')) {
                event.preventDefault();
            }
        });
    });
});
</script>
@endpush
