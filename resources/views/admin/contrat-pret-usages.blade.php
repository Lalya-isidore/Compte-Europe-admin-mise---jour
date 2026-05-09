@extends('admin.layout')

@section('title', 'Utilisateurs — Contrat de Prêt')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold h3 mb-1"><i data-lucide="file-text" style="width:28px;height:28px" class="me-2"></i>Contrat de Prêt — Derniers utilisateurs</h2>
    <p class="text-secondary">Les 10 dernières personnes ayant utilisé l'outil Contrat de Prêt.</p>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        @if($usages->isEmpty())
            <div class="text-center py-5 text-secondary">
                <i data-lucide="inbox" style="width:48px;height:48px;opacity:.4"></i>
                <p class="mt-3">Aucune utilisation enregistrée.</p>
            </div>
        @else
        <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Utilisateur</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Adresse IP</th>
                    <th>Date & Heure</th>
                    <th>Profil</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usages as $i => $usage)
                <tr>
                    <td class="text-secondary fw-bold">{{ $i + 1 }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white fw-bold"
                                 style="width:36px;height:36px;font-size:.85rem;flex-shrink:0;">
                                {{ strtoupper(substr($usage->user->prenom ?? '?', 0, 1)) }}{{ strtoupper(substr($usage->user->nom ?? '', 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-semibold">{{ $usage->user->prenom }} {{ $usage->user->nom }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $usage->user->email }}</td>
                    <td>{{ $usage->user->phone ?? '—' }}</td>
                    <td><code>{{ $usage->ip_address ?? '—' }}</code></td>
                    <td>
                        <span title="{{ $usage->created_at->setTimezone('Europe/Paris') }}">
                            {{ $usage->created_at->setTimezone('Europe/Paris')->format('d/m/Y à H:i') }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.users.show', $usage->user_id) }}" class="btn btn-sm btn-outline-primary">
                            <i data-lucide="eye" style="width:14px;height:14px"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        @endif
    </div>
</div>
@endsection
