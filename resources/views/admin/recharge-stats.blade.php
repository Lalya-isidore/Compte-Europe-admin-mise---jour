@extends('admin.layout')

@section('title', 'Statistiques des dépôts')

@push('styles')
<style>
.chart-container { position:relative; height:280px; margin-bottom:0; }
.tab-section-title {
    font-size:.7rem; font-weight:700; text-transform:uppercase;
    letter-spacing:.05em; color:#94a3b8; padding:1rem 1.25rem .5rem;
}
</style>
@endpush

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
        <div class="p-3">
            <div class="chart-container"><canvas id="chartJour"></canvas></div>
        </div>
        <div class="tab-section-title">Détail jour par jour</div>
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
        <div class="p-3">
            <div class="chart-container"><canvas id="chartSemaine"></canvas></div>
        </div>
        <div class="tab-section-title">Détail semaine par semaine</div>
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
        <div class="p-3">
            <div class="chart-container"><canvas id="chartMois"></canvas></div>
        </div>
        <div class="tab-section-title">Détail mois par mois</div>
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
                    @php $moisNoms = ['','Janv','Févr','Mars','Avr','Mai','Juin','Juil','Août','Sept','Oct','Nov','Déc']; @endphp
                    @forelse($byMonth as $row)
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
        <div class="p-3">
            <div class="chart-container"><canvas id="chartAnnee"></canvas></div>
        </div>
        <div class="tab-section-title">Détail par année</div>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const chartDefaults = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: { position: 'top', labels: { boxWidth: 12, font: { size: 12 } } },
        tooltip: {
            callbacks: {
                label: function(ctx) {
                    if (ctx.dataset.yAxisID === 'yMontant') {
                        return ' ' + ctx.parsed.y.toLocaleString('fr-FR') + ' F CFA';
                    }
                    return ' ' + ctx.parsed.y + ' dépôts';
                }
            }
        }
    },
    scales: {
        x: { grid: { display: false }, ticks: { font: { size: 11 } } },
        yMontant: {
            type: 'linear', position: 'left',
            ticks: {
                font: { size: 11 },
                callback: v => (v >= 1000 ? (v/1000).toFixed(0)+'k' : v) + ' F'
            },
            grid: { color: '#f1f5f9' }
        },
        yDepots: {
            type: 'linear', position: 'right',
            ticks: { font: { size: 11 }, stepSize: 1 },
            grid: { drawOnChartArea: false }
        }
    }
};

function makeChart(id, labels, montants, depots) {
    return new Chart(document.getElementById(id), {
        data: {
            labels,
            datasets: [
                {
                    type: 'bar',
                    label: 'Montant (F CFA)',
                    data: montants,
                    backgroundColor: 'rgba(99,102,241,.75)',
                    borderRadius: 6,
                    yAxisID: 'yMontant',
                    order: 2
                },
                {
                    type: 'line',
                    label: 'Nb dépôts',
                    data: depots,
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245,158,11,.15)',
                    borderWidth: 2,
                    pointRadius: 4,
                    tension: 0.3,
                    yAxisID: 'yDepots',
                    fill: true,
                    order: 1
                }
            ]
        },
        options: chartDefaults
    });
}

// Données PAR JOUR (ordre chronologique)
const jourData = @json($byDay->sortBy('periode')->values());
makeChart(
    'chartJour',
    jourData.map(r => r.periode.slice(5).split('-').reverse().join('/')),
    jourData.map(r => r.montant_total),
    jourData.map(r => r.nb_depots)
);

// Données PAR SEMAINE
const semData = @json($byWeek->sortBy(fn($r) => $r->annee * 100 + $r->semaine)->values());
makeChart(
    'chartSemaine',
    semData.map(r => 'S'+r.semaine+' '+r.annee),
    semData.map(r => r.montant_total),
    semData.map(r => r.nb_depots)
);

// Données PAR MOIS
const moisNoms = ['','Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'];
const moisData = @json($byMonth->sortBy(fn($r) => $r->annee * 100 + $r->mois)->values());
makeChart(
    'chartMois',
    moisData.map(r => moisNoms[r.mois]+' '+r.annee),
    moisData.map(r => r.montant_total),
    moisData.map(r => r.nb_depots)
);

// Données PAR ANNÉE
const anneeData = @json($byYear->sortBy('annee')->values());
makeChart(
    'chartAnnee',
    anneeData.map(r => String(r.annee)),
    anneeData.map(r => r.montant_total),
    anneeData.map(r => r.nb_depots)
);

// Redessiner les graphiques cachés à l'ouverture de l'onglet
// (Chart.js nécessite que le canvas soit visible au premier render)
document.querySelectorAll('[data-bs-toggle="tab"]').forEach(btn => {
    btn.addEventListener('shown.bs.tab', () => Chart.instances && Object.values(Chart.instances).forEach(c => c.resize()));
});
</script>
@endpush
