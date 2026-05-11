@extends('admin.layout')

@section('title', 'Statistiques des dépôts')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold h3 mb-1"><i data-lucide="credit-card" style="width:28px;height:28px" class="me-2"></i>Statistiques des dépôts de crédits</h2>
    <p class="text-secondary">Suivi des achats de crédits effectués par les utilisateurs.</p>
</div>

{{-- Cartes résumé --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100 p-3 text-center">
            <div class="text-secondary small mb-1">Total dépôts</div>
            <div class="fw-bold fs-4">{{ number_format($totals['transactions'], 0, ',', ' ') }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100 p-3 text-center">
            <div class="text-secondary small mb-1">Montant total</div>
            <div class="fw-bold fs-4 text-success">{{ number_format($totals['amount'], 0, ',', ' ') }} <small style="font-size:.7em">F CFA</small></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100 p-3 text-center">
            <div class="text-secondary small mb-1">Crédits distribués</div>
            <div class="fw-bold fs-4 text-primary">{{ number_format($totals['credits'], 0, ',', ' ') }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100 p-3 text-center">
            <div class="text-secondary small mb-1">Utilisateurs uniques</div>
            <div class="fw-bold fs-4 text-warning">{{ number_format($totals['users'], 0, ',', ' ') }}</div>
        </div>
    </div>
</div>

{{-- Onglets --}}
<ul class="nav nav-tabs mb-0" id="statsTabs">
    <li class="nav-item">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-jour">Par jour <span class="badge bg-secondary ms-1">30j</span></button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-semaine">Par semaine <span class="badge bg-secondary ms-1">12s</span></button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-mois">Par mois <span class="badge bg-secondary ms-1">12m</span></button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-annee">Par année</button>
    </li>
</ul>

<div class="tab-content card border-0 shadow-sm border-top-0 rounded-top-0">

    {{-- PAR JOUR --}}
    <div class="tab-pane fade show active" id="tab-jour">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th class="text-center">Nb dépôts</th>
                        <th class="text-end">Montant total</th>
                        <th class="text-end">Crédits distribués</th>
                        <th class="text-center">Utilisateurs</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($byDay as $row)
                    <tr>
                        <td class="fw-semibold">{{ \Carbon\Carbon::parse($row->periode)->setTimezone('Europe/Paris')->isoFormat('dddd D MMMM YYYY') }}</td>
                        <td class="text-center"><span class="badge bg-primary">{{ $row->nb_depots }}</span></td>
                        <td class="text-end fw-bold text-success">{{ number_format($row->montant_total, 0, ',', ' ') }} F CFA</td>
                        <td class="text-end">{{ number_format($row->credits_total, 0, ',', ' ') }} crédits</td>
                        <td class="text-center text-secondary">{{ $row->nb_utilisateurs }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-secondary py-4">Aucun dépôt ces 30 derniers jours.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PAR SEMAINE --}}
    <div class="tab-pane fade" id="tab-semaine">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Semaine</th>
                        <th class="text-center">Nb dépôts</th>
                        <th class="text-end">Montant total</th>
                        <th class="text-end">Crédits distribués</th>
                        <th class="text-center">Utilisateurs</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($byWeek as $row)
                    <tr>
                        <td class="fw-semibold">
                            Sem. {{ $row->semaine }} — {{ \Carbon\Carbon::parse($row->debut_semaine)->format('d/m') }} au {{ \Carbon\Carbon::parse($row->fin_semaine)->format('d/m/Y') }}
                        </td>
                        <td class="text-center"><span class="badge bg-primary">{{ $row->nb_depots }}</span></td>
                        <td class="text-end fw-bold text-success">{{ number_format($row->montant_total, 0, ',', ' ') }} F CFA</td>
                        <td class="text-end">{{ number_format($row->credits_total, 0, ',', ' ') }} crédits</td>
                        <td class="text-center text-secondary">{{ $row->nb_utilisateurs }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-secondary py-4">Aucun dépôt ces 12 dernières semaines.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PAR MOIS --}}
    <div class="tab-pane fade" id="tab-mois">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Mois</th>
                        <th class="text-center">Nb dépôts</th>
                        <th class="text-end">Montant total</th>
                        <th class="text-end">Crédits distribués</th>
                        <th class="text-center">Utilisateurs</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($byMonth as $row)
                    @php
                        $moisNoms = ['', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
                    @endphp
                    <tr>
                        <td class="fw-semibold">{{ $moisNoms[$row->mois] }} {{ $row->annee }}</td>
                        <td class="text-center"><span class="badge bg-primary">{{ $row->nb_depots }}</span></td>
                        <td class="text-end fw-bold text-success">{{ number_format($row->montant_total, 0, ',', ' ') }} F CFA</td>
                        <td class="text-end">{{ number_format($row->credits_total, 0, ',', ' ') }} crédits</td>
                        <td class="text-center text-secondary">{{ $row->nb_utilisateurs }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-secondary py-4">Aucun dépôt ces 12 derniers mois.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PAR ANNÉE --}}
    <div class="tab-pane fade" id="tab-annee">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Année</th>
                        <th class="text-center">Nb dépôts</th>
                        <th class="text-end">Montant total</th>
                        <th class="text-end">Crédits distribués</th>
                        <th class="text-center">Utilisateurs</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($byYear as $row)
                    <tr>
                        <td class="fw-semibold fs-5">{{ $row->annee }}</td>
                        <td class="text-center"><span class="badge bg-primary">{{ $row->nb_depots }}</span></td>
                        <td class="text-end fw-bold text-success">{{ number_format($row->montant_total, 0, ',', ' ') }} F CFA</td>
                        <td class="text-end">{{ number_format($row->credits_total, 0, ',', ' ') }} crédits</td>
                        <td class="text-center text-secondary">{{ $row->nb_utilisateurs }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-secondary py-4">Aucune donnée.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
