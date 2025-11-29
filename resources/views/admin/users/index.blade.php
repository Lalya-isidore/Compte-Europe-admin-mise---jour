@extends('admin.layout')

@section('title', 'Gestion des utilisateurs')

@push('styles')
<style>
    .search-input {
        max-width: 320px;
    }
    .badge-pill {
        border-radius: 30px;
        padding: 0.4rem 0.9rem;
    }
</style>
@endpush

@section('content')
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">👥 Gestion des utilisateurs</h1>
            <p class="text-muted mb-0">Consultez les comptes clients, leurs crédits et accédez aux détails.</p>
        </div>
        <form method="GET" class="w-100 w-md-auto" action="{{ route('admin.users.index') }}">
            <div class="input-group search-input ms-md-auto">
                <input type="text" name="search" class="form-control" placeholder="Recherche (ID, nom, email, téléphone)"
                       value="{{ $search }}">
                <button class="btn btn-gradient" type="submit">Rechercher</button>
            </div>
        </form>
    </div>

    <div class="card-admin">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th class="text-center">Crédit</th>
                        <th class="text-center">Sous-comptes</th>
                        <th class="text-center">Solde total comptes</th>
                        <th>Date d'inscription</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <strong>{{ $user->nom }} {{ $user->prenom }}</strong>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?? '—' }}</td>
                            <td class="text-center">
                                <span class="badge bg-primary badge-pill">
                                    {{ number_format($user->credit_user ?? 0, 0, ',', ' ') }} crédits
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info text-dark badge-pill">{{ $user->comptes_count }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark badge-pill">
                                    {{ number_format($user->total_account_balance ?? 0, 0, ',', ' ') }} F CFA
                                </span>
                            </td>
                            <td>{{ $user->created_at?->format('d/m/Y') }}</td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline-primary btn-sm">
                                        Voir détails
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="delete-user-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                Aucun utilisateur trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.delete-user-form').forEach((form) => {
        form.addEventListener('submit', (event) => {
            const nameCell = form.closest('tr')?.querySelector('td:first-child strong');
            const displayName = nameCell ? nameCell.textContent.trim() : 'cet utilisateur';
            const message = `Confirmez-vous la suppression définitive de ${displayName} ? Toutes ses données associées seront également supprimées.`;
            if (!confirm(message)) {
                event.preventDefault();
            }
        });
    });
});
</script>
@endpush
