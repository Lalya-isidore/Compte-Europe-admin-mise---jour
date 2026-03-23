@extends('admin.layout')

@section('title', 'Détails utilisateur')

@push('styles')
<style>
    .user-summary {
        display: grid;
        gap: 1.5rem;
    }
    @media (min-width: 768px) {
        .user-summary {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }
    .summary-card {
        background: #fff;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 7px 24px rgba(76, 81, 191, 0.12);
    }
    .summary-card h3 {
        font-size: 1.15rem;
        margin-bottom: 0.5rem;
    }
    .summary-card p {
        margin: 0;
        color: #555;
    }
    .table-section {
        margin-top: 2.5rem;
    }
    .badge-credit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        padding: 0.4rem 0.9rem;
        border-radius: 999rem;
        font-weight: 500;
    }
    .admin-subaccount-actions {
        min-width: 210px;
    }
    .admin-subaccount-actions form input[type="number"] {
        min-width: 120px;
    }
</style>
@endpush

@section('content')
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">👤 {{ $user->nom }} {{ $user->prenom }}</h1>
            <p class="text-muted mb-0">État civil, sous-comptes et recharges de l'utilisateur.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                ← Retour à la liste
            </a>
            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="delete-user-form" data-user-name="{{ trim($user->nom . ' ' . $user->prenom) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">
                    Supprimer l'utilisateur
                </button>
            </form>
        </div>
    </div>

    <div class="user-summary">
        <div class="summary-card">
            <h3>Crédit utilisateur</h3>
            <p class="display-6 mb-3">{{ number_format($user->credit_user ?? 0, 0, ',', ' ') }} crédits</p>
            <form action="{{ route('admin.users.credit.update', $user) }}" method="POST" class="d-flex gap-2">
                @csrf
                <input type="number" name="credit_user" class="form-control" min="0"
                       value="{{ old('credit_user', $user->credit_user ?? 0) }}" required>
                <button type="submit" class="btn btn-gradient">Mettre à jour</button>
            </form>
        </div>
        <div class="summary-card">
            <h3>Sous-comptes</h3>
            <p class="display-6 mb-0">{{ $user->comptes->count() }}</p>
            <p class="text-muted">Total des comptes créés par l'utilisateur.</p>
        </div>
        <div class="summary-card">
            <h3>Recharges validées</h3>
            <p class="display-6 mb-0">{{ number_format($totalRechargeAmount, 0, ',', ' ') }} F CFA</p>
            <p class="text-muted">Montant total des recharges acceptées pour l'achat de crédits.</p>
        </div>
    </div>

    <div class="table-section" id="comptes">
        <h2 class="h4 mb-3">📂 Sous-comptes</h2>
        <div class="card-admin">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Solde</th>
                            <th>Téléphone</th>
                            <th>Devise</th>
                            <th>Statut</th>
                            <th class="text-center">Gestion admin</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($user->comptes as $compte)
                            <tr id="compte-{{ $compte->id }}">
                                <td>{{ $compte->id }}</td>
                                <td>{{ $compte->nom }} {{ $compte->prenom }}</td>
                                <td>
                                    <form action="{{ route('admin.users.comptes.email.update', [$user, $compte]) }}" method="POST" class="d-flex gap-2 flex-column flex-md-row">
                                        @csrf
                                        <input type="email" name="email" class="form-control w-100" value="{{ old('email', $compte->email) }}" required>
                                        <button type="submit" class="btn btn-gradient w-100 w-md-auto mt-2 mt-md-0">Mettre à jour</button>
                                    </form>
                                </td>
                                <td>{{ number_format($compte->account_balance, 0, ',', ' ') }} F CFA</td>
                                <td>
                                    <form action="{{ route('admin.users.comptes.phone.update', [$user, $compte]) }}" method="POST" class="d-flex gap-2 flex-column flex-md-row">
                                        @csrf
                                        <input type="tel" name="phone_number" class="form-control w-100" value="{{ old('phone_number', $compte->phone_number) }}" placeholder="Numéro" required>
                                        <button type="submit" class="btn btn-gradient w-100 w-md-auto mt-2 mt-md-0">Mettre à jour</button>
                                    </form>
                                </td>
                                <td>{{ $compte->devise ?? '—' }}</td>
                                <td><span class="badge bg-light text-dark">{{ ucfirst($compte->account_status ?? '—') }}</span></td>
                                <td class="text-center admin-subaccount-actions">
                                    <div class="d-flex flex-column gap-2">
                                        <form action="{{ route('admin.users.comptes.balance.boost', [$user, $compte]) }}" method="POST" class="d-flex flex-column flex-md-row gap-2 align-items-stretch">
                                            @csrf
                                            <input type="number" name="amount" class="form-control w-100" min="1" step="1" placeholder="Montant" required>
                                            <button type="submit" class="btn btn-success w-100 w-md-auto mt-2 mt-md-0">Augmenter</button>
                                        </form>
                                        <form action="{{ route('admin.users.comptes.history.purge', [$user, $compte]) }}" method="POST" data-admin-action="purge-history" class="d-flex">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">Effacer l'historique</button>
                                        </form>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('compte.edit', $compte->id) }}" class="btn btn-outline-primary btn-sm">Ouvrir</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">Aucun sous-compte créé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="table-section" id="recharges">
        <h2 class="h4 mb-3">💰 Recharges</h2>
        <div class="card-admin">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Montant</th>
                            <th>Crédits obtenus</th>
                            <th>Méthode</th>
                            <th>Statut</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recharges as $recharge)
                            <tr>
                                <td>{{ $recharge->transaction_id }}</td>
                                <td>{{ number_format($recharge->amount, 0, ',', ' ') }} F CFA</td>
                                <td><span class="badge badge-credit">{{ number_format($recharge->credits_earned, 0, ',', ' ') }} crédits</span></td>
                                <td>{{ $recharge->payment_method ?? '—' }}</td>
                                <td>
                                    <span class="badge bg-{{ $recharge->status === 'completed' ? 'success' : ($recharge->status === 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($recharge->status) }}
                                    </span>
                                </td>
                                <td>{{ $recharge->created_at?->setTimezone('Europe/Paris')->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Aucune recharge enregistrée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const deleteForm = document.querySelector('.delete-user-form');
    if (deleteForm) {
        deleteForm.addEventListener('submit', (event) => {
            const displayName = (deleteForm.dataset.userName || '').trim() || 'cet utilisateur';
            const message = `Confirmez-vous la suppression définitive de ${displayName} ? Cette action supprimera également ses comptes, recharges et affiliations.`;
            if (!confirm(message)) {
                event.preventDefault();
            }
        });
    }

    document.querySelectorAll('form[data-admin-action="purge-history"]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            const row = form.closest('tr');
            const compteLabel = row ? row.querySelector('td:nth-child(2)')?.textContent.trim() : 'ce sous-compte';
            const message = `Supprimer tout l'historique lié à ${compteLabel || 'ce sous-compte'} ? Cette action est irréversible.`;
            if (!confirm(message)) {
                event.preventDefault();
            }
        });
    });
});
</script>
@endpush
