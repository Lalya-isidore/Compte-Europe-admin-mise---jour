@extends('admin.layout')

@section('title', 'Statistiques des visites')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold h3 mb-1"><i data-lucide="bar-chart-2" style="width:28px;height:28px" class="me-2"></i>Visites de la plateforme</h2>
    <p class="text-secondary">Nombre de visites des utilisateurs connectés sur la plateforme.</p>
</div>

{{-- Stat cards --}}
<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 p-4 text-center">
            <div class="mb-2" style="font-size:2rem;">📅</div>
            <div class="text-secondary small mb-1">Aujourd'hui</div>
            <div class="fw-bold" style="font-size:2.4rem;line-height:1;">{{ number_format($visitToday, 0, ',', ' ') }}</div>
            <div class="text-secondary smaller mt-1">visites</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 p-4 text-center">
            <div class="mb-2" style="font-size:2rem;">📆</div>
            <div class="text-secondary small mb-1">Cette semaine</div>
            <div class="fw-bold" style="font-size:2.4rem;line-height:1;">{{ number_format($visitWeek, 0, ',', ' ') }}</div>
            <div class="text-secondary smaller mt-1">visites</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 p-4 text-center">
            <div class="mb-2" style="font-size:2rem;">🗓️</div>
            <div class="text-secondary small mb-1">Ce mois</div>
            <div class="fw-bold" style="font-size:2.4rem;line-height:1;">{{ number_format($visitMonth, 0, ',', ' ') }}</div>
            <div class="text-secondary smaller mt-1">visites</div>
        </div>
    </div>
</div>

{{-- Tableau par jour --}}
<div class="card border-0 shadow-sm mb-5">
    <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
        <h5 class="fw-bold mb-0"><i data-lucide="calendar-days" style="width:18px;height:18px" class="me-2"></i>Visites par jour — 30 derniers jours</h5>
    </div>
    <div class="card-body p-0">
        @if($dailyStats->isEmpty())
            <div class="text-center py-5 text-secondary">
                <i data-lucide="inbox" style="width:48px;height:48px;opacity:.4"></i>
                <p class="mt-3">Aucune donnée disponible.</p>
            </div>
        @else
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th class="text-center">Total visites</th>
                    <th class="text-center">Visiteurs uniques</th>
                    <th>Barre</th>
                </tr>
            </thead>
            <tbody>
                @php $maxTotal = $dailyStats->max('total') ?: 1; @endphp
                @foreach($dailyStats as $stat)
                <tr>
                    <td class="fw-semibold">{{ \Carbon\Carbon::parse($stat->date)->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 fw-semibold">{{ $stat->total }}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 fw-semibold">{{ $stat->unique_users }}</span>
                    </td>
                    <td style="width:35%;">
                        <div style="background:#e9ecef;border-radius:999px;height:8px;overflow:hidden;">
                            <div style="width:{{ round(($stat->total / $maxTotal) * 100) }}%;background:linear-gradient(90deg,#6366f1,#818cf8);height:100%;border-radius:999px;"></div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

{{-- Dernières visites --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
        <h5 class="fw-bold mb-0"><i data-lucide="clock" style="width:18px;height:18px" class="me-2"></i>20 dernières visites</h5>
    </div>
    <div class="card-body p-0">
        @if($recentVisits->isEmpty())
            <div class="text-center py-5 text-secondary">
                <i data-lucide="inbox" style="width:48px;height:48px;opacity:.4"></i>
                <p class="mt-3">Aucune visite enregistrée.</p>
            </div>
        @else
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Utilisateur</th>
                    <th>Page</th>
                    <th>Lieu</th>
                    <th>Date & Heure</th>
                    <th>Profil</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentVisits as $visit)
                <tr>
                    <td>
                        @if($visit->user)
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white fw-bold"
                                 style="width:32px;height:32px;font-size:.75rem;flex-shrink:0;">
                                {{ strtoupper(substr($visit->user->prenom ?? '?', 0, 1)) }}{{ strtoupper(substr($visit->user->nom ?? '', 0, 1)) }}
                            </div>
                            <span class="fw-semibold">{{ $visit->user->prenom }} {{ $visit->user->nom }}</span>
                        </div>
                        @else
                            <span class="text-secondary">—</span>
                        @endif
                    </td>
                    <td><code class="text-primary">/{{ $visit->url }}</code></td>
                    <td>
                        @if($visit->location)
                            <span><i data-lucide="map-pin" style="width:13px;height:13px" class="me-1 text-danger"></i>{{ $visit->location }}</span>
                        @else
                            <code class="text-secondary">{{ $visit->ip_address ?? '—' }}</code>
                        @endif
                    </td>
                    <td>{{ $visit->created_at->format('d/m/Y à H:i') }}</td>
                    <td>
                        @if($visit->user)
                        <a href="{{ route('admin.users.show', $visit->user_id) }}" class="btn btn-sm btn-outline-primary">
                            <i data-lucide="eye" style="width:14px;height:14px"></i>
                        </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection
