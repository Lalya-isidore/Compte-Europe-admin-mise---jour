@extends('layouts.admin')

@section('title', 'Simulateur de Crédit')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Outils</a></li>
    <li class="breadcrumb-item active">Simulateur de Crédit</li>
@endsection

@section('content')
<div class="sc-wrapper">

    {{-- Alerte crédits insuffisants --}}
    @error('credits')
    <div style="background:#fff3cd;border:1px solid #ffc107;border-radius:10px;padding:14px 18px;margin-bottom:18px;display:flex;align-items:center;gap:12px;color:#856404;">
        <i class="fas fa-exclamation-triangle"></i>
        <span>{{ $message }}</span>
    </div>
    @enderror

    {{-- Info card --}}
    <div class="sc-info-card">
        <div class="sc-info-title"><i class="fas fa-calculator"></i> Simulateur de Crédit / Prêt Bancaire</div>
        <div class="sc-info-body">
            <p class="sc-r-balance">
                <span>Crédit(s) disponible : <b>{{ number_format($userCredits, 0, ',', ' ') }}</b></span>
                <span class="sc-r-about" data-bs-toggle="tooltip" data-bs-placement="bottom" title="1 Crédit = 1 F CFA" tabindex="0">à savoir</span>
            </p>
            <p class="sc-tool-info">
                <span data-bs-toggle="collapse" data-bs-target="#scInfoCollapse" aria-expanded="false">
                    <i class="fas fa-info-circle"></i> Utilité et Fonctionnement <i class="fas fa-arrow-right" style="font-size:0.75em;"></i>
                </span>
            </p>
            <div class="collapse show" id="scInfoCollapse">
                <div class="alert alert-primary" role="alert" style="font-size:.9em;">
                    <p><i class="fas fa-info-circle"></i> Simulez n'importe quel crédit ou prêt bancaire : mensualité, total des intérêts, tableau d'amortissement complet. L'aperçu se met à jour en temps réel.</p>
                    <b>NB :</b> Le téléchargement du rapport PDF avec le tableau d'amortissement coûte <b>500 crédits</b>.
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('tools.simulateur-credit.generate') }}" method="POST" id="sc-form">
        @csrf
        <div class="sc-grid">

            {{-- ======== COLONNE GAUCHE : Formulaire ======== --}}
            <div class="sc-col">

                {{-- Paramètres du prêt --}}
                <div class="sc-card">
                    <div class="sc-card__head"><i class="fas fa-sliders-h"></i> Paramètres du prêt</div>
                    <div class="sc-card__body">

                        <div class="sc-field">
                            <label>Nom du client <small>(optionnel)</small></label>
                            <input type="text" name="nom_client" id="nom-client" placeholder="Ex: Jean Dupont" value="{{ old('nom_client') }}">
                        </div>

                        <div class="sc-row2" style="margin-top:14px;">
                            <div class="sc-field">
                                <label>Montant emprunté <span class="req">*</span></label>
                                <input type="number" name="montant" id="montant" placeholder="Ex: 10000" min="1" step="0.01" required value="{{ old('montant') }}">
                            </div>
                            <div class="sc-field">
                                <label>Devise <span class="req">*</span></label>
                                <select name="devise" id="devise">
                                    <option value="€" selected>€ — Euro</option>
                                    <option value="XOF">XOF — Franc CFA</option>
                                    <option value="$">$ — Dollar USD</option>
                                    <option value="£">£ — Livre Sterling</option>
                                    <option value="CHF">CHF — Franc Suisse</option>
                                    <option value="MAD">MAD — Dirham Marocain</option>
                                    <option value="XAF">XAF — Franc CFA BEAC</option>
                                    <option value="GNF">GNF — Franc Guinéen</option>
                                    <option value="DZD">DZD — Dinar Algérien</option>
                                    <option value="TND">TND — Dinar Tunisien</option>
                                </select>
                            </div>
                        </div>

                        <div class="sc-row2" style="margin-top:14px;">
                            <div class="sc-field">
                                <label>Taux d'intérêt annuel (%) <span class="req">*</span></label>
                                <input type="number" name="taux" id="taux" placeholder="Ex: 5.5" min="0" max="100" step="0.01" required value="{{ old('taux', '5') }}">
                            </div>
                            <div class="sc-field">
                                <label>Durée (mois) <span class="req">*</span></label>
                                <input type="number" name="duree" id="duree" placeholder="Ex: 60" min="1" max="600" required value="{{ old('duree', '60') }}">
                            </div>
                        </div>

                        {{-- Slider durée --}}
                        <div class="sc-field" style="margin-top:14px;">
                            <label>Durée rapide</label>
                            <div class="sc-slider-row">
                                @php
                                $dureeLabels = [6=>'6 mois',12=>'1 an',24=>'2 ans',36=>'3 ans',48=>'4 ans',60=>'5 ans',84=>'7 ans',120=>'10 ans',180=>'15 ans',240=>'20 ans'];
                                @endphp
                                @foreach($dureeLabels as $m => $label)
                                <button type="button" class="sc-dur-btn" data-mois="{{ $m }}">{{ $label }}</button>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Bouton télécharger --}}
                <button type="submit" class="sc-btn-generate">
                    <i class="fas fa-file-pdf"></i>
                    Télécharger le rapport PDF
                    <span class="sc-btn-cost"><i class="fas fa-coins"></i> 500 crédits</span>
                </button>

            </div>

            {{-- ======== COLONNE DROITE : Résultats en temps réel ======== --}}
            <div class="sc-col">
                <div class="sc-card">
                    <div class="sc-card__head"><i class="fas fa-chart-bar"></i> Résultats de la simulation</div>
                    <div class="sc-card__body">

                        {{-- Résumé --}}
                        <div class="sc-results" id="sc-results">
                            <div class="sc-result-grid">
                                <div class="sc-result-item sc-result-item--primary">
                                    <span class="sc-result-label">Mensualité</span>
                                    <span class="sc-result-value" id="res-mensualite">—</span>
                                </div>
                                <div class="sc-result-item">
                                    <span class="sc-result-label">Total à rembourser</span>
                                    <span class="sc-result-value" id="res-total">—</span>
                                </div>
                                <div class="sc-result-item">
                                    <span class="sc-result-label">Coût total des intérêts</span>
                                    <span class="sc-result-value sc-result-value--red" id="res-interets">—</span>
                                </div>
                                <div class="sc-result-item">
                                    <span class="sc-result-label">Taux annuel</span>
                                    <span class="sc-result-value" id="res-taux">—</span>
                                </div>
                            </div>

                            {{-- Barre de répartition --}}
                            <div class="sc-bar-wrap" id="sc-bar-wrap" style="display:none;">
                                <div class="sc-bar-label">
                                    <span><span class="sc-dot sc-dot--blue"></span>Capital : <b id="bar-pct-capital">—</b></span>
                                    <span><span class="sc-dot sc-dot--red"></span>Intérêts : <b id="bar-pct-interets">—</b></span>
                                </div>
                                <div class="sc-bar">
                                    <div class="sc-bar-fill sc-bar-fill--blue" id="bar-capital" style="width:0%"></div>
                                    <div class="sc-bar-fill sc-bar-fill--red" id="bar-interets" style="width:0%"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Tableau d'amortissement (aperçu 12 premières lignes) --}}
                        <div style="margin-top:18px;">
                            <div style="font-size:0.83rem;font-weight:600;color:#1e3a5f;margin-bottom:8px;"><i class="fas fa-table"></i> Aperçu du tableau d'amortissement <small style="color:#999;font-weight:400;">(12 premières lignes)</small></div>
                            <div style="overflow-x:auto;">
                                <table class="sc-table" id="sc-amort-table">
                                    <thead>
                                        <tr>
                                            <th>Mois</th>
                                            <th>Échéance</th>
                                            <th>Capital</th>
                                            <th>Intérêts</th>
                                            <th>Restant dû</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sc-amort-body">
                                        <tr><td colspan="5" style="text-align:center;color:#999;padding:20px;">Remplissez le formulaire pour voir le tableau</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<style>
.sc-wrapper { max-width: 1200px; margin: 0 auto; }

/* Info card */
.sc-info-card { background:#fff; border-radius:8px; box-shadow:0 0 12px rgba(0,0,0,.08); margin-bottom:24px; overflow:hidden; }
.sc-info-title { font-family:'Righteous',cursive,sans-serif; padding:18px 20px; border-bottom:1px solid #e2e2e2; color:#0d6efd; font-size:1rem; }
.sc-info-body { padding:18px 20px 10px; }
.sc-r-balance { margin-bottom:14px; font-size:.92em; }
.sc-r-about { color:#4285f4; margin-left:10px; text-decoration:underline; cursor:pointer; font-size:.88em; }
.sc-r-about:hover { color:#4285f480; }
.sc-tool-info { margin-bottom:14px; }
.sc-tool-info span { display:inline-block; background:#4f429b; box-shadow:0 0 12px rgba(0,0,0,.12); font-size:.88em; border-radius:4px; padding:8px 18px; color:#fff; cursor:pointer; user-select:none; transition:all 200ms; }
.sc-tool-info span:hover { transform:scale(1.02); }

/* Grid */
.sc-grid { display:grid; grid-template-columns:1fr 1fr; gap:24px; align-items:start; }
.sc-col { display:flex; flex-direction:column; gap:18px; }

/* Card */
.sc-card { background:#fff; border:1px solid #e8e8e8; border-radius:12px; overflow:hidden; }
.sc-card__head { padding:13px 18px; background:#f8f9fb; border-bottom:1px solid #eee; font-size:.88rem; font-weight:600; color:#334; display:flex; align-items:center; gap:8px; }
.sc-card__head i { color:#1e3a5f; }
.sc-card__body { padding:18px; }

/* Fields */
.sc-row2 { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
.sc-field { display:flex; flex-direction:column; gap:5px; }
.sc-field label { font-size:.8rem; font-weight:600; color:#555; }
.sc-field input, .sc-field select { border:1px solid #ddd; border-radius:8px; padding:9px 12px; font-size:.88rem; color:#333; outline:none; transition:border-color .2s; background:#fff; }
.sc-field input:focus, .sc-field select:focus { border-color:#1e3a5f; box-shadow:0 0 0 3px rgba(30,58,95,.08); }
.req { color:#e53e3e; }

/* Slider durée */
.sc-slider-row { display:flex; flex-wrap:wrap; gap:6px; margin-top:4px; }
.sc-dur-btn { padding:4px 10px; border:1px solid #ddd; border-radius:20px; font-size:.75rem; background:#f8f9fb; cursor:pointer; transition:all .2s; color:#444; }
.sc-dur-btn:hover, .sc-dur-btn.active { background:#1e3a5f; color:#fff; border-color:#1e3a5f; }

/* Results */
.sc-result-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:16px; }
.sc-result-item { background:#f8f9fb; border:1px solid #eee; border-radius:10px; padding:14px; }
.sc-result-item--primary { background:#1e3a5f; border-color:#1e3a5f; }
.sc-result-label { display:block; font-size:.75rem; color:#888; margin-bottom:4px; }
.sc-result-item--primary .sc-result-label { color:rgba(255,255,255,.75); }
.sc-result-value { display:block; font-size:1.1rem; font-weight:700; color:#1a202c; }
.sc-result-item--primary .sc-result-value { color:#fff; font-size:1.3rem; }
.sc-result-value--red { color:#e53e3e; }

/* Barre répartition */
.sc-bar-wrap { margin-top:4px; }
.sc-bar-label { display:flex; justify-content:space-between; font-size:.78rem; color:#555; margin-bottom:6px; }
.sc-dot { display:inline-block; width:10px; height:10px; border-radius:50%; margin-right:4px; }
.sc-dot--blue { background:#1e3a5f; }
.sc-dot--red { background:#e53e3e; }
.sc-bar { display:flex; height:12px; border-radius:6px; overflow:hidden; background:#eee; }
.sc-bar-fill { transition:width .4s ease; }
.sc-bar-fill--blue { background:#1e3a5f; }
.sc-bar-fill--red { background:#e53e3e; }

/* Table */
.sc-table { width:100%; border-collapse:collapse; font-size:.78rem; }
.sc-table th { background:#1e3a5f; color:#fff; padding:7px 8px; text-align:center; font-weight:600; }
.sc-table td { padding:5px 8px; text-align:right; border-bottom:1px solid #f0f0f0; }
.sc-table td:first-child { text-align:center; font-weight:600; color:#1e3a5f; }
.sc-table tr:nth-child(even) td { background:#f8fafc; }

/* Bouton */
.sc-btn-generate { width:100%; padding:14px; background:linear-gradient(135deg,#1a7a3f,#25a858); color:#fff; border:none; border-radius:10px; font-size:.95rem; font-weight:600; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:10px; transition:all .2s; }
.sc-btn-generate:hover { background:linear-gradient(135deg,#156233,#1e8f49); transform:translateY(-1px); box-shadow:0 6px 20px rgba(26,122,63,.35); }
.sc-btn-cost { background:rgba(0,0,0,.15); border-radius:20px; padding:3px 10px; font-size:.72rem; display:flex; align-items:center; gap:4px; }

@media (max-width:900px) {
    .sc-grid { grid-template-columns:1fr; }
}
@media (max-width:600px) {
    .sc-wrapper { margin:0 -12px; }
    .sc-row2 { grid-template-columns:1fr; }
    .sc-result-grid { grid-template-columns:1fr; }
    .sc-btn-generate { width:auto; padding:10px 20px; font-size:.82rem; margin:0 auto; }
}
</style>

@push('scripts')
<script>
(function () {
    const fmtNum = (n, devise) => new Intl.NumberFormat('fr-FR', {minimumFractionDigits:2, maximumFractionDigits:2}).format(n) + ' ' + devise;

    function calcMensualite(montant, tauxAnn, duree) {
        if (tauxAnn === 0) return montant / duree;
        const r = tauxAnn / 100 / 12;
        return montant * (r * Math.pow(1+r, duree)) / (Math.pow(1+r, duree) - 1);
    }

    function buildTableau(montant, tauxAnn, duree) {
        const rows = [];
        const r = tauxAnn / 100 / 12;
        const mens = calcMensualite(montant, tauxAnn, duree);
        let restant = montant;
        for (let i = 1; i <= duree; i++) {
            const interet = Math.round(restant * r * 100) / 100;
            const capital = Math.round((mens - interet) * 100) / 100;
            restant = Math.round((restant - capital) * 100) / 100;
            rows.push({ mois:i, echeance: Math.round(mens*100)/100, capital, interet, restant: Math.max(0, restant) });
        }
        return rows;
    }

    function updateSim() {
        const montant = parseFloat(document.getElementById('montant').value) || 0;
        const taux    = parseFloat(document.getElementById('taux').value) || 0;
        const duree   = parseInt(document.getElementById('duree').value) || 0;
        const devise  = document.getElementById('devise').value || '€';

        if (!montant || !duree) {
            document.getElementById('res-mensualite').textContent = '—';
            document.getElementById('res-total').textContent = '—';
            document.getElementById('res-interets').textContent = '—';
            document.getElementById('res-taux').textContent = '—';
            document.getElementById('sc-bar-wrap').style.display = 'none';
            document.getElementById('sc-amort-body').innerHTML = '<tr><td colspan="5" style="text-align:center;color:#999;padding:20px;">Remplissez le formulaire pour voir le tableau</td></tr>';
            return;
        }

        const mens = calcMensualite(montant, taux, duree);
        const totalPaye = mens * duree;
        const totalInterets = totalPaye - montant;
        const pctCapital = Math.round(montant / totalPaye * 100);
        const pctInterets = 100 - pctCapital;

        document.getElementById('res-mensualite').textContent = fmtNum(mens, devise);
        document.getElementById('res-total').textContent = fmtNum(totalPaye, devise);
        document.getElementById('res-interets').textContent = fmtNum(Math.max(0, totalInterets), devise);
        document.getElementById('res-taux').textContent = taux + ' % / an';

        // Barre
        document.getElementById('sc-bar-wrap').style.display = 'block';
        document.getElementById('bar-capital').style.width = pctCapital + '%';
        document.getElementById('bar-interets').style.width = pctInterets + '%';
        document.getElementById('bar-pct-capital').textContent = pctCapital + '%';
        document.getElementById('bar-pct-interets').textContent = pctInterets + '%';

        // Tableau (12 premières lignes)
        const rows = buildTableau(montant, taux, duree);
        const preview = rows.slice(0, 12);
        const fmt = n => new Intl.NumberFormat('fr-FR', {minimumFractionDigits:2, maximumFractionDigits:2}).format(n);
        let html = preview.map(r =>
            `<tr><td>${r.mois}</td><td>${fmt(r.echeance)}</td><td>${fmt(r.capital)}</td><td>${fmt(r.interet)}</td><td>${fmt(r.restant)}</td></tr>`
        ).join('');
        if (rows.length > 12) {
            html += `<tr><td colspan="5" style="text-align:center;color:#888;font-style:italic;padding:8px;">… et ${rows.length - 12} ligne(s) supplémentaire(s) dans le PDF complet</td></tr>`;
        }
        document.getElementById('sc-amort-body').innerHTML = html;
    }

    document.addEventListener('DOMContentLoaded', function () {
        ['montant','taux','duree','devise'].forEach(id => {
            document.getElementById(id)?.addEventListener('input', updateSim);
            document.getElementById(id)?.addEventListener('change', updateSim);
        });

        // Boutons durée rapide
        document.querySelectorAll('.sc-dur-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.getElementById('duree').value = this.dataset.mois;
                document.querySelectorAll('.sc-dur-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                updateSim();
            });
        });

        updateSim();
    });
})();
</script>
@endpush

@endsection
