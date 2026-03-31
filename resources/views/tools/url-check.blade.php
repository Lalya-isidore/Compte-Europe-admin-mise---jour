@extends('layouts.admin')

@section('title', "Vérification d'un URL")

@section('breadcrumb')
        <li class="breadcrumb-item"><i class="fas fa-briefcase me-1"></i>Outils</li>
        <li class="breadcrumb-item active"><i class="fas fa-globe me-1"></i>Vérification d'un site web</li>
@endsection

@section('content')
@php
    $result = $result ?? null;
    $hasResult = !empty($result);
@endphp

<x-tool-back-link label="Retour à la liste des outils" :fallback="route('dashboard')" />

<div class="container-fluid px-lg-4 px-3 py-4">
    <div class="row g-4 align-items-start">
        <div class="col-xl-8">
            <div class="url-hero-card">
                <div class="url-hero-card__title">
                    <i class="fas fa-globe-europe text-primary me-2"></i>
                    Vérifier un site web (Whois)
                </div>
                <div class="d-flex flex-wrap gap-3 mb-4">
                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#urlHelpModal">
                        <i class="fas fa-info-circle me-2"></i>Utilité et Fonctionnement →
                    </button>
                </div>

                <form method="POST" action="{{ route('tools.url-check.run') }}" class="url-form">
                    @csrf
                    <label for="url" class="form-label fw-semibold">Adresse URL <span class="text-danger">. requis</span></label>
                    <div class="alert alert-primary d-flex align-items-center py-2 px-3">
                        <i class="fas fa-lightbulb me-2"></i>
                        <span>Saisissez le nom de domaine du site web à vérifier sans le www. Cet outil est gratuit.</span>
                    </div>
                    <div class="input-group input-group-lg mb-2">
                        <input type="text" name="url" id="url" class="form-control" placeholder="nom-de-domaine.extension" value="{{ old('url') }}" required>
                        <button class="btn btn-primary" type="submit">
                            Lancer la vérification →
                        </button>
                    </div>
                    @error('url')
                        <div class="text-danger small"><i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}</div>
                    @enderror
                </form>

                <div class="url-result-panel mt-4">
                    <div class="url-result-panel__header">
                        <i class="fas fa-sliders-h me-2"></i>Résultat(s)
                    </div>
                    <div class="url-result-panel__body">
                        @if($hasResult)
                            <div class="row g-3">
                                <div class="col-md-3 col-sm-6">
                                    <div class="result-pill">
                                        <span class="result-pill__label">Statut HTTP</span>
                                        <span class="result-pill__value">{{ $result['status_code'] ?? '—' }}</span>
                                        <small>{{ $result['status_text'] ?? 'Non disponible' }}</small>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="result-pill">
                                        <span class="result-pill__label">Temps</span>
                                        <span class="result-pill__value">{{ $result['response_time'] ? $result['response_time'] . ' ms' : '—' }}</span>
                                        <small>{{ $result['reachable'] ? 'Serveur joignable' : 'Injoignable' }}</small>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="result-pill">
                                        <span class="result-pill__label">Certificat</span>
                                        <span class="result-pill__value">{{ $result['ssl'] ? 'HTTPS' : 'HTTP' }}</span>
                                        <small>{{ $result['ssl'] ? 'Connexion sécurisée' : 'Non sécurisé' }}</small>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="result-pill">
                                        <span class="result-pill__label">Adresse IP</span>
                                        <span class="result-pill__value">{{ $result['ip'] ?? '—' }}</span>
                                        <small>Résolution DNS</small>
                                    </div>
                                </div>
                            </div>

                            <div class="url-summary mt-4">
                                <div class="url-summary__item">
                                    <span class="label">URL saisie :</span>
                                    <span>{{ $result['input'] }}</span>
                                </div>
                                <div class="url-summary__item">
                                    <span class="label">URL finale :</span>
                                    <span>{{ $result['final_url'] ?? $result['normalized_url'] }}</span>
                                </div>
                            </div>

                            @if(!empty($result['error']))
                                <div class="alert alert-warning mt-3 mb-0">
                                    <i class="fas fa-exclamation-triangle me-2"></i>{{ $result['error'] }}
                                </div>
                            @endif

                            @if(!empty($result['headers']))
                                <div class="row g-3 mt-1">
                                    @foreach($result['headers'] as $header)
                                        <div class="col-md-6">
                                            <div class="header-chip">
                                                <div class="header-chip__name">{{ $header['name'] }}</div>
                                                <div class="header-chip__value">{{ $header['value'] }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            @if(!empty($result['body_snippet']))
                                <div class="body-snippet mt-3">{{ $result['body_snippet'] }}</div>
                            @endif
                        @else
                            <div class="result-empty text-center">
                                <div class="spinner-border text-success mb-3" role="status"></div>
                                <p class="mb-0">Les résultats apparaîtront ici après la vérification.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="history-panel">
                <div class="history-panel__header">
                    <i class="fas fa-history me-2 text-warning"></i>Historique des vérifications
                </div>
                <div class="history-panel__body">
                    <div class="history-empty text-center">
                        <img src="https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/svg/1f622.svg" alt="empty" width="70">
                        <p class="text-muted mt-3">Aucune vérification récente</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="urlHelpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-info-circle me-2"></i>Utilité et Fonctionnement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Ce service vérifie rapidement la disponibilité d'un site web, détecte les redirections, mesure le temps de réponse et confirme la présence d'un certificat HTTPS.</p>
                <ul>
                    <li>Entrez uniquement le nom de domaine (l'outil ajoute https:// automatiquement).</li>
                    <li>Le DNS et l'adresse IP sont résolus en quelques secondes.</li>
                    <li>Les résultats ne sont pas sauvegardés, ils disparaissent en fermant la page.</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<style>
    .url-hero-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 15px 40px rgba(15,23,42,0.08);
        padding: 2rem;
    }
    .url-hero-card__title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
    }
    .url-form input {
        border-radius: 14px 0 0 14px;
        padding: 0.85rem 1rem;
        font-size: 1rem;
    }
    .url-form button {
        border-radius: 0 14px 14px 0;
        padding: 0.85rem 1.5rem;
        font-weight: 600;
    }
    .url-result-panel {
        border: 1px solid #dbeafe;
        border-radius: 18px;
        overflow: hidden;
    }
    .url-result-panel__header {
        background: #eef2ff;
        padding: 0.85rem 1.25rem;
        font-weight: 700;
    }
    .url-result-panel__body {
        padding: 1.5rem;
    }
    .result-pill {
        border: 1px dashed #cbd5f5;
        border-radius: 16px;
        padding: 1rem;
        text-align: center;
        background: #f8fafc;
    }
    .result-pill__label {
        text-transform: uppercase;
        font-size: 0.75rem;
        color: #94a3b8;
    }
    .result-pill__value {
        font-size: 1.4rem;
        font-weight: 700;
        color: #0f172a;
    }
    .url-summary {
        background: #f1f5f9;
        border-radius: 12px;
        padding: 1rem 1.2rem;
    }
    .url-summary__item {
        display: flex;
        gap: 0.5rem;
        font-weight: 600;
        color: #0f172a;
    }
    .url-summary__item .label {
        color: #64748b;
        min-width: 120px;
    }
    .header-chip {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 0.85rem;
        background: #fff;
        height: 100%;
    }
    .header-chip__name {
        font-size: 0.8rem;
        text-transform: uppercase;
        color: #94a3b8;
    }
    .header-chip__value {
        font-weight: 600;
        color: #0f172a;
        margin-top: 0.25rem;
    }
    .body-snippet {
        background: #0f172a;
        color: #e2e8f0;
        border-radius: 14px;
        padding: 1rem;
        max-height: 220px;
        overflow-y: auto;
        font-family: 'Fira Code', monospace;
        font-size: 0.9rem;
    }
    .result-empty {
        padding: 2rem 0;
        color: #475569;
    }
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
    .history-panel__body {
        padding: 2rem 1.25rem;
    }
    .history-empty img {
        opacity: 0.85;
    }
</style>
@endsection
