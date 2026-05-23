@extends('layouts.admin')

@section('page-class', 'page-flush')
@section('title', 'Vérification IBAN/CB')

@section('breadcrumb')
    <li class="breadcrumb-item"><i class="fas fa-briefcase me-1"></i>Outils</li>
    <li class="breadcrumb-item active"><i class="fas fa-credit-card me-1"></i>Vérification IBAN/CB</li>
@endsection

@section('content')
@php
    $result = $result ?? null;
    $hasResult = !empty($result);
@endphp

<x-tool-back-link label="Retour à la liste des outils" :fallback="route('dashboard')" />

<div class="container-fluid px-lg-2 px-2 py-3">
    <div class="row g-4 align-items-start">
        {{-- Colonne principale --}}
        <div class="col-xl-8">
            <div class="iban-hero-card">
                <div class="iban-hero-card__title">
                    <i class="fas fa-credit-card text-primary me-2"></i>
                    Vérification IBAN/CB
                </div>

                <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
                    <span class="credits-badge">
                        <i class="fas fa-coins me-1"></i>Crédit(s) disponible : <strong>{{ $creditsDisponibles }}</strong>
                    </span>
                    <span data-bs-toggle="tooltip" data-bs-placement="bottom" title="1 Crédit = 1 F CFA" tabindex="0" style="color:#4285f4;text-decoration:underline;cursor:pointer;font-size:0.88em;">à savoir</span>
                </div>

                <div class="d-flex flex-wrap gap-3 mb-4">
                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ibanHelpModal">
                        <i class="fas fa-info-circle me-2"></i>Utilité et Fonctionnement &rarr;
                    </button>
                </div>

                <form method="POST" action="{{ route('tools.iban-check.run') }}" class="iban-form">
                    @csrf

                    <div class="mb-3">
                        <label for="type" class="form-label fw-semibold">Sélectionner le type <span class="text-danger">. requis</span></label>
                        <select name="type" id="type" class="form-select form-select-lg" required>
                            <option value="">Type de vérification</option>
                            <option value="iban" {{ old('type') === 'iban' ? 'selected' : '' }}>Numéro IBAN</option>
                            <option value="cb" {{ old('type') === 'cb' ? 'selected' : '' }}>Numéro CB (Carte bancaire)</option>
                        </select>
                        @error('type')
                            <div class="text-danger small mt-1"><i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="numero" class="form-label fw-semibold">Numéro IBAN / Numéro CB <span class="text-danger">. requis</span></label>
                        <div class="alert alert-primary d-flex align-items-center py-2 px-3 mb-2">
                            <i class="fas fa-lightbulb me-2"></i>
                            <span>Saisissez le numéro IBAN ou le numéro CB à vérifier</span>
                        </div>
                        <input type="text" name="numero" id="numero" class="form-control form-control-lg"
                               placeholder="XXXXXXXXXXXX" value="{{ old('numero') }}" required>
                        @error('numero')
                            <div class="text-danger small mt-1"><i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}</div>
                        @enderror
                        @error('credits')
                            <div class="text-danger small mt-1"><i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-end">
                        <button class="btn btn-primary btn-lg px-4" type="submit">
                            Lancer la vérification (500 Crédits) &rarr;
                        </button>
                    </div>
                </form>

                {{-- Résultats --}}
                <div class="iban-result-panel mt-4">
                    <div class="iban-result-panel__header">
                        <i class="fas fa-sliders-h me-2"></i>Résultat(s)
                    </div>
                    <div class="iban-result-panel__body">
                        @if($hasResult)
                            <div class="row g-3">
                                <div class="col-md-4 col-sm-6">
                                    <div class="result-pill {{ $result['is_valid'] ? 'result-pill--success' : 'result-pill--danger' }}">
                                        <span class="result-pill__label">Statut</span>
                                        <span class="result-pill__value">{{ $result['is_valid'] ? 'Valide' : 'Invalide' }}</span>
                                        <small>{{ strtoupper($result['type']) }} {{ $result['number_masked'] }}</small>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-6">
                                    <div class="result-pill">
                                        <span class="result-pill__label">Pays</span>
                                        <span class="result-pill__value">{{ $result['country'] ?? '—' }}</span>
                                        <small>Pays d'émission</small>
                                    </div>
                                </div>

                                @if($result['type'] === 'iban')
                                    <div class="col-md-4 col-sm-6">
                                        <div class="result-pill">
                                            <span class="result-pill__label">Code banque</span>
                                            <span class="result-pill__value">{{ $result['bank_code'] ?? '—' }}</span>
                                            <small>{{ $result['bank_name'] ?? 'Identifiant bancaire' }}</small>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-4 col-sm-6">
                                        <div class="result-pill">
                                            <span class="result-pill__label">Marque</span>
                                            <span class="result-pill__value">{{ $result['card_brand'] ?? '—' }}</span>
                                            <small>Réseau de paiement</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="result-pill">
                                            <span class="result-pill__label">Type</span>
                                            <span class="result-pill__value">{{ $result['card_type'] ?? '—' }}</span>
                                            <small>Débit / Crédit</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="result-pill">
                                            <span class="result-pill__label">Banque émettrice</span>
                                            <span class="result-pill__value">{{ $result['bank_name'] ?? '—' }}</span>
                                            <small>Établissement</small>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            @if(!empty($result['error']))
                                <div class="alert alert-warning mt-3 mb-0">
                                    <i class="fas fa-exclamation-triangle me-2"></i>{{ $result['error'] }}
                                </div>
                            @endif
                        @else
                            <div class="result-empty text-center">
                                <div class="spinner-border text-primary mb-3" role="status"></div>
                                <p class="mb-0">Les résultats apparaîtront ici après la vérification.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Colonne historique --}}
        <div class="col-xl-4">
            <div class="history-panel">
                <div class="history-panel__header">
                    <i class="fas fa-history me-2 text-warning"></i>Historique des vérifications
                </div>
                <div class="history-panel__body">
                    @if($history->isEmpty())
                        <div class="history-empty text-center py-4">
                            <img src="https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/svg/1f4b3.svg" alt="card" width="60">
                            <p class="text-muted mt-3 mb-0">Aucune vérification récente</p>
                        </div>
                    @else
                        <div class="history-scroll">
                            @foreach($history as $item)
                                <div class="history-item d-flex align-items-start gap-2">
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-bold">{{ $item->number_masked }}</span>
                                            <span class="badge {{ $item->is_valid ? 'bg-success' : 'bg-danger' }}">
                                                {{ $item->is_valid ? 'Valide' : 'Invalide' }}
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-between mt-1">
                                            <small class="text-muted">
                                                <span class="badge bg-secondary">{{ strtoupper($item->type) }}</span>
                                                {{ $item->country ?? '' }}
                                                @if($item->card_brand) &bull; {{ $item->card_brand }} @endif
                                            </small>
                                            <small class="text-muted">{{ $item->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('tools.iban-check.delete', $item->id) }}" class="flex-shrink-0" onsubmit="return confirm('Supprimer ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger border-0 p-1" title="Supprimer">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>

                        <div class="text-center mt-3 pt-3 border-top">
                            <form method="POST" action="{{ route('tools.iban-check.clear') }}" onsubmit="return confirm('Supprimer tout l\'historique ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash-alt me-1"></i>Supprimer tout l'historique
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal aide --}}
<div class="modal fade" id="ibanHelpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-info-circle me-2"></i>Utilité et Fonctionnement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="text-primary">Utilité</h6>
                <p>Cet outil est capable de vérifier et de valider les numéros IBAN et Carte bancaire en temps réel. Il est important de s'assurer de la validité et de connaître le pays émetteur ainsi que d'autres informations complémentaires sur une carte bancaire afin d'assurer le bon déroulement d'un <strong>TPE</strong> ou de toute autre opération financière mettant deux banques en communication.</p>

                <h6 class="text-primary">Fonctionnement</h6>
                <p>Pour vérifier la validité et avoir des informations sur un IBAN ou une carte bancaire, vous devez juste avoir du crédit <strong>FlashBilan</strong> et remplir le formulaire disponible sur cette page en respectant le format défini pour chaque champ.</p>
                <p class="mb-0">Avec l'historique des vérifications, obtenez des informations sur les vérifications d'IBAN et de carte bancaire effectuées avec votre compte FlashBilan depuis sa création.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<style>
    .iban-hero-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 15px 40px rgba(15,23,42,0.08);
        padding: 2rem;
    }
    .iban-hero-card__title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
    }
    .credits-badge {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #1e40af;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
    }
    .iban-form select,
    .iban-form input {
        border-radius: 12px;
    }
    .iban-result-panel {
        border: 1px solid #dbeafe;
        border-radius: 18px;
        overflow: hidden;
    }
    .iban-result-panel__header {
        background: #eef2ff;
        padding: 0.85rem 1.25rem;
        font-weight: 700;
        color: #3730a3;
    }
    .iban-result-panel__body {
        padding: 1.5rem;
    }
    .result-pill {
        border: 1px dashed #cbd5e1;
        border-radius: 16px;
        padding: 1rem;
        text-align: center;
        background: #f8fafc;
    }
    .result-pill--success { border-color: #86efac; background: #f0fdf4; }
    .result-pill--danger { border-color: #fca5a5; background: #fef2f2; }
    .result-pill__label {
        display: block;
        text-transform: uppercase;
        font-size: 0.7rem;
        color: #94a3b8;
        letter-spacing: 0.05em;
    }
    .result-pill__value {
        display: block;
        font-size: 1.2rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0.25rem 0;
    }
    .result-pill small { color: #64748b; font-size: 0.78rem; }
    .result-empty { padding: 2rem 0; color: #475569; }
    .history-panel {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #f4d4b4;
        box-shadow: 0 15px 30px rgba(249,115,22,0.08);
        height: 100%;
    }
    .history-panel__header {
        font-weight: 700;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #ffe2c9;
    }
    .history-panel__body { padding: 1rem 1.25rem; }
    .history-scroll { max-height: 500px; overflow-y: auto; }
    .history-item { padding: 0.75rem 0; border-bottom: 1px solid #f1f5f9; }
    .history-item:last-child { border-bottom: none; }
</style>
@endsection
