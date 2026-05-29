@extends('admin.layout')

@section('title', $toolName)

@section('content')
<div class="mb-4">
    <h2 class="fw-bold h3 mb-1">
        <i data-lucide="mouse-pointer-click" style="width:28px;height:28px" class="me-2"></i>
        {{ $toolName }} — Dernières visites
    </h2>
    <p class="text-secondary">Les 100 dernières visites de cet outil (comptes admin exclus).</p>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        @if($visits->isEmpty())
            <div class="text-center py-5 text-secondary">
                <i data-lucide="inbox" style="width:48px;height:48px;opacity:.4"></i>
                <p class="mt-3">Aucune visite enregistrée.</p>
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
                @foreach($visits as $i => $visit)
                <tr>
                    <td class="text-secondary fw-bold">{{ $i + 1 }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white fw-bold"
                                 style="width:36px;height:36px;font-size:.85rem;flex-shrink:0;">
                                {{ strtoupper(substr($visit->user->prenom ?? '?', 0, 1)) }}{{ strtoupper(substr($visit->user->nom ?? '', 0, 1)) }}
                            </div>
                            <div class="fw-semibold">{{ $visit->user->prenom }} {{ $visit->user->nom }}</div>
                        </div>
                    </td>
                    <td>{{ $visit->user->email }}</td>
                    <td>{{ $visit->user->phone ?? '—' }}</td>
                    <td><code>{{ $visit->ip_address ?? '—' }}</code></td>
                    <td>
                        <span title="{{ $visit->created_at->setTimezone('Europe/Paris') }}">
                            {{ $visit->created_at->setTimezone('Europe/Paris')->format('d/m/Y à H:i') }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.users.show', $visit->user_id) }}" class="btn btn-sm btn-outline-primary">
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
