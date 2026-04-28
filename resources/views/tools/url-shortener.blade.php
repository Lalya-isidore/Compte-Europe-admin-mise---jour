@extends('layouts.admin')

@section('page-class', 'page-flush')
@section('title', "Raccourcissement d'URL")

@section('breadcrumb')
        <li class="breadcrumb-item"><i class="fas fa-briefcase me-1"></i>Outils</li>
        <li class="breadcrumb-item active"><i class="fas fa-link me-1"></i>Raccourcissement d'URL</li>
@endsection

@section('content')
@php
    $history = $history ?? collect();
    $latestResult = session('shortResult');
@endphp

<x-tool-back-link label="Retour à la liste des outils" :fallback="route('dashboard')" />

<div class="container-fluid px-lg-4 px-3 py-4">
    <div class="shortener-layout">
        <div class="shortener-layout__main">
            <div class="shortener-card">
                <div class="shortener-card__title">
                    <i class="fas fa-link text-primary me-2"></i>
                    Raccourcissement d'URL
                </div>

                <button class="btn btn-outline-info btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#shortenerHelpModal">
                    <i class="fas fa-info-circle me-2"></i>Utilité et Fonctionnement →
                </button>

                <form method="POST" action="{{ route('tools.url-shortener.store') }}" class="shortener-form">
                    @csrf
                    <label for="url" class="form-label fw-semibold">Adresse URL <span class="text-danger">. requis</span></label>
                    <div class="alert alert-primary d-flex align-items-center py-2 px-3">
                        <i class="fas fa-lightbulb me-2"></i>
                        <span>Saisissez l'adresse URL à raccourcir. Cet outil est gratuit.</span>
                    </div>
                    <input type="text" name="url" id="url" class="form-control form-control-lg mb-3" placeholder="Adresse URL..." value="{{ old('url') }}" required>
                    @error('url')
                        <div class="text-danger small mb-2"><i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}</div>
                    @enderror
                    <div class="text-end">
                        <button class="btn btn-primary btn-lg" type="submit">
                            Obtenir le raccourci →
                        </button>
                    </div>
                </form>

                <div class="short-result-panel mt-4">
                    <div class="short-result-panel__header">
                        <i class="fas fa-sliders-h me-2"></i>Résultat(s)
                    </div>
                    <div class="short-result-panel__body">
                        @if($latestResult)
                            <div class="result-success">
                                <div>
                                    <span class="result-label">Lien court :</span>
                                    <a href="{{ $latestResult['short_url'] }}" target="_blank" rel="noopener" class="result-link">{{ $latestResult['short_url'] }}</a>
                                </div>
                                <div class="mt-2">
                                    <span class="result-label">Destination :</span>
                                    <span>{{ $latestResult['original_url'] }}</span>
                                </div>
                                <div class="mt-2 text-muted small">
                                    Créé le {{ $latestResult['created_at']->format('d/m/Y \à H:i') }} UTC+0
                                </div>
                            </div>
                        @else
                            <div class="result-empty text-center">
                                <div class="spinner-border text-success mb-3" role="status"></div>
                                <p class="mb-0">Votre raccourci apparaîtra ici.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="shortener-layout__history">
            <div class="history-panel">
                <div class="history-panel__header">
                    <i class="fas fa-history me-2 text-warning"></i>Historique des raccourcis ({{ $history->count() }})
                </div>
                <div class="history-panel__body">
                    @if($history->isEmpty())
                        <div class="history-empty text-center text-muted">
                            <p>Aucun raccourci enregistré</p>
                        </div>
                    @else
                        <div class="history-list">
                            @foreach($history as $item)
                                <div class="history-item">
                                    <a href="{{ $item->short_url }}" target="_blank" rel="noopener" class="history-short">{{ $item->short_url }}</a>
                                    <span class="history-destination">qui redirige vers <strong>{{ \Illuminate\Support\Str::limit($item->original_url, 60) }}</strong></span>
                                    <div class="history-meta">créé le {{ $item->created_at->format('d/m/y \à H:i') }} UTC+0</div>
                                </div>
                            @endforeach
                        </div>
                        <form method="POST" action="{{ route('tools.url-shortener.delete') }}" class="text-center mt-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash me-2"></i>Supprimer l'historique des raccourcis
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="shortenerHelpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-info-circle me-2"></i>Utilité et Fonctionnement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Créez un lien court partageable instantanément pour vos campagnes SMS, mails ou réseaux sociaux.</p>
                <ul>
                    <li>Entrez un lien long valide (https:// conseillé).</li>
                    <li>Le système génère un lien court via is.gd et l'ajoute à votre historique.</li>
                    <li>Vous pouvez effacer l'historique à tout moment.</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<style>
    .shortener-layout {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    @media (min-width: 992px) {
        .shortener-layout {
            flex-direction: row;
            align-items: flex-start;
        }
        .shortener-layout__main {
            width: 0;
            flex: 1 1 0%;
        }
        .shortener-layout__history {
            width: 360px;
            flex: 0 0 auto;
        }
    }
    .shortener-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 15px 40px rgba(15,23,42,0.08);
        padding: 2rem;
    }
    .shortener-card__title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
    }
    .shortener-form input {
        border-radius: 12px;
        padding: 0.8rem 1rem;
    }
    .short-result-panel {
        border: 1px solid #d1fae5;
        border-radius: 18px;
        overflow: hidden;
    }
    .short-result-panel__header {
        background: #ecfdf5;
        padding: 0.85rem 1.2rem;
        font-weight: 700;
    }
    .short-result-panel__body {
        padding: 1.5rem;
    }
    .result-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 12px;
        padding: 1rem;
        font-weight: 600;
    }
    .result-label {
        color: #22c55e;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.08em;
    }
    .result-link {
        font-weight: 700;
        color: #0f172a;
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
        padding: 1.5rem;
        max-height: 550px;
        overflow-y: auto;
    }
    .history-item {
        border-bottom: 1px solid #d1d5db;
        padding: 0.85rem 0;
    }
    .history-short {
        font-weight: 700;
        color: #0f172a;
        text-decoration: none;
    }
    .history-destination {
        display: block;
        color: #374151;
    }
    .history-meta {
        font-size: 0.8rem;
        color: #6b7280;
    }
</style>
@endsection
