@extends('admin.layout')

@section('title', 'Installations PWA')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold h3 mb-1"><i data-lucide="smartphone" style="width:28px;height:28px" class="me-2"></i>Utilisateurs ayant installé l'application</h2>
    <p class="text-secondary">Utilisateurs qui ont téléchargé l'application FlashBilan sur leur téléphone.</p>
</div>

<div class="card border-0 shadow-sm mb-4 p-4 text-center" style="max-width:200px;">
    <div class="mb-1" style="font-size:2rem;">📲</div>
    <div class="fw-bold" style="font-size:2.4rem;line-height:1;">{{ $total }}</div>
    <div class="text-secondary small mt-1">installations</div>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Utilisateur</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Date d'installation</th>
                    <th>Région</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold"
                                style="width:36px;height:36px;font-size:0.85rem;flex-shrink:0;">
                                {{ strtoupper(substr($user->prenom ?? $user->nom ?? '?', 0, 1)) }}{{ strtoupper(substr($user->nom ?? '', 0, 1)) }}
                            </div>
                            <span class="fw-semibold">{{ strtoupper($user->nom ?? '') }} {{ ucfirst($user->prenom ?? '') }}</span>
                        </div>
                    </td>
                    <td class="text-secondary">{{ $user->email }}</td>
                    <td class="text-secondary">{{ $user->phone ?? '—' }}</td>
                    <td>{{ \Carbon\Carbon::parse($user->pwa_installed_at)->setTimezone('Europe/Paris')->format('d/m/Y à H:i') }}</td>
                    <td><span class="badge bg-light text-dark border">{{ strtoupper($user->region ?? 'EU') }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-secondary py-5">Aucun utilisateur n'a encore installé l'application.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
