@extends('admin.layout')

@section('title', 'Clients actifs')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold h3 mb-1">Clients actifs</h2>
    <p class="text-secondary">Utilisateurs ayant des credits ou des comptes clients.</p>
</div>

<!-- Onglets -->
<ul class="nav nav-tabs mb-4" role="tablist">
    <li class="nav-item">
        <a class="nav-link {{ $tab === 'credits' ? 'active' : '' }}" href="?tab=credits">
            <i data-lucide="coins" style="width:16px;height:16px" class="me-1"></i>
            Avec credits <span class="badge bg-primary ms-1">{{ $usersWithCredits->count() }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $tab === 'comptes' ? 'active' : '' }}" href="?tab=comptes">
            <i data-lucide="wallet" style="width:16px;height:16px" class="me-1"></i>
            Avec comptes <span class="badge bg-success ms-1">{{ $usersWithComptes->count() }}</span>
        </a>
    </li>
</ul>

<!-- Tab Credits -->
@if($tab === 'credits')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom py-3">
        <h5 class="mb-0 fw-bold">Utilisateurs avec des credits ({{ $usersWithCredits->count() }})</h5>
    </div>
    <div class="card-body p-0">
        @if($usersWithCredits->isEmpty())
            <div class="text-center py-5 text-muted">
                <i data-lucide="inbox" style="width:48px;height:48px" class="mb-3 opacity-50"></i>
                <p>Aucun utilisateur avec des credits.</p>
            </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0 py-3 px-4">#</th>
                        <th class="border-0 py-3">Nom</th>
                        <th class="border-0 py-3">Email</th>
                        <th class="border-0 py-3">Telephone</th>
                        <th class="border-0 py-3 text-end">Credits</th>
                        <th class="border-0 py-3 text-center">Dernier credit</th>
                        <th class="border-0 py-3 text-center">Inscription</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usersWithCredits as $i => $user)
                    <tr>
                        <td class="px-4 py-3 text-muted">{{ $i + 1 }}</td>
                        <td class="py-3">
                            <div class="fw-semibold">{{ $user->prenom }} {{ $user->nom }}</div>
                        </td>
                        <td class="py-3">
                            <a href="mailto:{{ $user->email }}" class="text-decoration-none">{{ $user->email }}</a>
                        </td>
                        <td class="py-3">{{ $user->phone_number ?? '-' }}</td>
                        <td class="py-3 text-end">
                            <span class="badge bg-primary bg-opacity-10 text-primary fw-bold fs-6">
                                {{ number_format($user->credit_user, 0, ',', ' ') }}
                            </span>
                        </td>
                        <td class="py-3 text-center small">
                            @if($user->last_recharge_at)
                                <span class="text-success fw-semibold">{{ \Carbon\Carbon::parse($user->last_recharge_at)->setTimezone('Europe/Paris')->format('d/m/Y H:i') }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="py-3 text-center text-muted small">
                            {{ $user->created_at ? $user->created_at->setTimezone('Europe/Paris')->format('d/m/Y') : '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
    @if($usersWithCredits->isNotEmpty())
    <div class="card-footer bg-light border-top-0 py-3 px-4">
        <div class="d-flex justify-content-between align-items-center">
            <span class="text-muted small">Total : {{ $usersWithCredits->count() }} utilisateurs</span>
            <span class="fw-bold text-primary">{{ number_format($usersWithCredits->sum('credit_user'), 0, ',', ' ') }} credits au total</span>
        </div>
    </div>
    @endif
</div>
@endif

<!-- Tab Comptes -->
@if($tab === 'comptes')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom py-3">
        <h5 class="mb-0 fw-bold">Utilisateurs avec des comptes clients ({{ $usersWithComptes->count() }})</h5>
    </div>
    <div class="card-body p-0">
        @if($usersWithComptes->isEmpty())
            <div class="text-center py-5 text-muted">
                <i data-lucide="inbox" style="width:48px;height:48px" class="mb-3 opacity-50"></i>
                <p>Aucun utilisateur avec des comptes.</p>
            </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0 py-3 px-4">#</th>
                        <th class="border-0 py-3">Nom</th>
                        <th class="border-0 py-3">Email</th>
                        <th class="border-0 py-3">Telephone</th>
                        <th class="border-0 py-3 text-center">Comptes</th>
                        <th class="border-0 py-3 text-end">Credits</th>
                        <th class="border-0 py-3 text-center">Inscription</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usersWithComptes as $i => $user)
                    <tr>
                        <td class="px-4 py-3 text-muted">{{ $i + 1 }}</td>
                        <td class="py-3">
                            <div class="fw-semibold">{{ $user->prenom }} {{ $user->nom }}</div>
                        </td>
                        <td class="py-3">
                            <a href="mailto:{{ $user->email }}" class="text-decoration-none">{{ $user->email }}</a>
                        </td>
                        <td class="py-3">{{ $user->phone_number ?? '-' }}</td>
                        <td class="py-3 text-center">
                            <span class="badge bg-success bg-opacity-10 text-success fw-bold fs-6">
                                {{ $user->comptes_count }}
                            </span>
                        </td>
                        <td class="py-3 text-end">
                            <span class="text-muted">{{ number_format($user->credit_user, 0, ',', ' ') }}</span>
                        </td>
                        <td class="py-3 text-center text-muted small">
                            {{ $user->created_at ? $user->created_at->setTimezone('Europe/Paris')->format('d/m/Y') : '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
    @if($usersWithComptes->isNotEmpty())
    <div class="card-footer bg-light border-top-0 py-3 px-4">
        <div class="d-flex justify-content-between align-items-center">
            <span class="text-muted small">Total : {{ $usersWithComptes->count() }} utilisateurs</span>
            <span class="fw-bold text-success">{{ $usersWithComptes->sum('comptes_count') }} comptes au total</span>
        </div>
    </div>
    @endif
</div>
@endif
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => { if (typeof lucide !== 'undefined') lucide.createIcons(); });
</script>
@endpush
