@extends('layouts.admin')

@section('page-class', 'page-flush')
@section('title', "Extraction d'e-mail(s)")

@section('breadcrumb')
        <li class="breadcrumb-item"><i class="fas fa-briefcase me-1"></i>Outils</li>
        <li class="breadcrumb-item active"><i class="fas fa-at me-1"></i>Extraction d'e-mail(s)</li>
@endsection

@section('content')
@php
    $latestResult = $latestResult ?? session('mailExtractorResult');
@endphp

<x-tool-back-link label="Retour à la liste des outils" :fallback="route('dashboard')" />

<div class="container-fluid px-lg-4 px-3 py-4">
    <div class="extractor-layout">
        <div class="extractor-layout__main">
            <div class="extractor-card">
                <div class="extractor-card__header">
                    <div class="extractor-card__title">
                        <i class="fas fa-at text-primary me-2"></i>
                        Extraction d'e-mail(s)
                    </div>
                    <button class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#extractorHelpModal">
                        <i class="fas fa-info-circle me-2"></i>Utilité et Fonctionnement →
                    </button>
                </div>

                <form method="POST" action="{{ route('tools.mail-extractor.run') }}" class="extractor-form mt-3">
                    @csrf
                    <div class="mb-4">
                        <label for="separator" class="form-label fw-semibold">Choisissez le séparateur <span class="text-danger">. requis</span></label>
                        <div class="alert alert-primary d-flex align-items-center py-2 px-3">
                            <i class="fas fa-lightbulb me-2"></i>
                            <span>Nous conseillons <strong>Retour à la ligne</strong> pour relire clairement le résultat.</span>
                        </div>
                        <select id="separator" name="separator" class="form-select form-select-lg" required>
                            <option value="" disabled {{ old('separator') ? '' : 'selected' }}>Type de séparateur disponible</option>
                            @foreach($separators as $key => $separator)
                                <option value="{{ $key }}" {{ old('separator') === $key ? 'selected' : '' }}>{{ $separator['label'] }}</option>
                            @endforeach
                        </select>
                        @error('separator')
                            <div class="text-danger small mt-1"><i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="text" class="form-label fw-semibold">Texte à traiter <span class="text-danger">. requis</span></label>
                        <div class="alert alert-primary d-flex align-items-center py-2 px-3">
                            <i class="fas fa-file-alt me-2"></i>
                            <span>Collez votre message ou document contenant les e-mails à extraire. Analyse gratuite.</span>
                        </div>
                        <textarea id="text" name="text" rows="7" class="form-control form-control-lg" placeholder="Coller le texte ici..." required>{{ old('text') }}</textarea>
                        @error('text')
                            <div class="text-danger small mt-1"><i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary btn-lg">
                            Lancer l'extraction →
                        </button>
                    </div>
                </form>

                <div class="extractor-result mt-4">
                    <div class="extractor-result__header">
                        <i class="fas fa-table me-2"></i>Résultat(s)
                    </div>
                    <div class="extractor-result__body">
                        @if($latestResult)
                            <div class="result-success">
                                <div class="d-flex justify-content-between flex-wrap gap-2">
                                    <div>
                                        <span class="badge bg-success-soft text-success">{{ $latestResult['count'] }} e-mail(s) trouvé(s)</span>
                                        <span class="separator-label">Séparateur : {{ $latestResult['separator_label'] }}</span>
                                    </div>
                                    <button class="btn btn-outline-secondary btn-sm" type="button" onclick="navigator.clipboard.writeText(`{{ $latestResult['result_string'] }}`)">
                                        <i class="fas fa-copy me-1"></i>Copier le résultat
                                    </button>
                                </div>
                                <textarea class="form-control mt-3" rows="6" readonly>{{ $latestResult['result_string'] }}</textarea>
                                <div class="text-muted small mt-2">Dernière extraction le {{ $latestResult['created_at']->format('d/m/Y \à H:i') }} UTC+0</div>
                            </div>
                        @else
                            <div class="result-empty text-center">
                                <div class="spinner-border text-success mb-3" role="status"></div>
                                <p class="mb-0">Le résultat de votre prochaine extraction apparaîtra ici.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="extractor-layout__history">
            <div class="history-panel">
                <div class="history-panel__header">
                    <i class="fas fa-history me-2 text-warning"></i>Historique des extractions ({{ $history->count() }})
                </div>
                <div class="history-panel__body">
                    @if($history->isEmpty())
                        <div class="history-empty text-center text-muted">
                            <svg width="72" height="72" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mb-3">
                                <path d="M5 8h14l-2 11H7L5 8z" stroke="#f97316" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M9 8V5a3 3 0 0 1 6 0v3" stroke="#f97316" stroke-width="1.5" stroke-linecap="round"/>
                                <circle cx="12" cy="13" r="1" fill="#f97316"/>
                                <circle cx="12" cy="17" r="1" fill="#f97316"/>
                            </svg>
                            <p>Aucune extraction enregistrée</p>
                        </div>
                    @else
                        <div class="history-list">
                            @foreach($history as $item)
                                <div class="history-item">
                                    <div class="history-count">{{ $item->result_count }} email(s)</div>
                                    <div class="history-separator">Séparateur : {{ $separators[$item->separator]['label'] ?? $item->separator }}</div>
                                    <div class="history-preview">{{ \Illuminate\Support\Str::limit($item->source_preview, 90) }}</div>
                                    <div class="history-meta">{{ $item->created_at->format('d/m/Y \à H:i') }} UTC+0</div>
                                    <textarea class="form-control form-control-sm mt-2" rows="3" readonly>{{ str_replace("\n", PHP_EOL, $item->emails) }}</textarea>
                                </div>
                            @endforeach
                        </div>
                        <form method="POST" action="{{ route('tools.mail-extractor.clear') }}" class="text-center mt-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash me-2"></i>Supprimer l'historique des extractions
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="extractorHelpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-info-circle me-2"></i>Utilité et fonctionnement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Collez vos emails ou un texte brut. L'outil détecte automatiquement toutes les adresses valides et les formate selon le séparateur choisi.</p>
                <ul>
                    <li>Choisissez un séparateur (retour à la ligne recommandé).</li>
                    <li>Collez votre texte ou vos messages.</li>
                    <li>Lancez l'extraction et copiez les e-mails nettoyés.</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<style>
    .extractor-layout {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    @media (min-width: 992px) {
        .extractor-layout {
            flex-direction: row;
            align-items: flex-start;
        }
        .extractor-layout__main {
            flex: 1 1 auto;
        }
        .extractor-layout__history {
            width: 360px;
            flex: 0 0 auto;
        }
    }
    .extractor-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 15px 40px rgba(15,23,42,0.08);
        padding: 2rem;
    }
    .extractor-card__header {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .extractor-card__title {
        font-size: 1.3rem;
        font-weight: 700;
        display: flex;
        align-items: center;
    }
    .extractor-form textarea {
        border-radius: 14px;
    }
    .extractor-result {
        border: 1px solid #d1fae5;
        border-radius: 18px;
    }
    .extractor-result__header {
        background: #ecfdf5;
        padding: 0.85rem 1.2rem;
        font-weight: 700;
        border-bottom: 1px solid #d1fae5;
    }
    .extractor-result__body {
        padding: 1.5rem;
    }
    .result-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 12px;
        padding: 1.25rem;
    }
    .bg-success-soft {
        background: #dcfce7;
    }
    .separator-label {
        font-weight: 600;
        color: #065f46;
        margin-left: 0.75rem;
    }
    .history-panel {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #f4d4b4;
        box-shadow: 0 15px 30px rgba(249,115,22,0.08);
    }
    .history-panel__header {
        font-weight: 700;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #ffe2c9;
    }
    .history-panel__body {
        padding: 1.25rem;
        max-height: 650px;
        overflow-y: auto;
    }
    .history-item {
        border: 1px solid #fde68a;
        border-radius: 14px;
        padding: 0.85rem;
        margin-bottom: 1rem;
        background: #fffbeb;
    }
    .history-count {
        font-weight: 700;
        color: #92400e;
    }
    .history-preview {
        font-size: 0.9rem;
        color: #78350f;
        margin-top: 0.25rem;
    }
    .history-meta {
        font-size: 0.8rem;
        color: #b45309;
        margin-top: 0.3rem;
    }
</style>
@endsection
