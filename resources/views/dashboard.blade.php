@extends('layouts.admin')

@section('title', 'Liste des outils')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="ri-briefcase-line me-1"></i>Liste des outils</a></li>
    <li class="breadcrumb-item"><a href="{{ route('recharge.index') }}" class="breadcrumb-recharge-btn"><i class="ri-wallet-line"></i>Recharge</a></li>
@endsection

@section('content')
@php
    $paidTools = [
        ['label' => 'SMS Pro', 'image' => 'sms-pro.png', 'route' => route('sms.pro')],
        ['label' => 'Flash Compte Pro', 'image' => 'flash-compte-v1.png', 'route' => route('compte.create')],
        ['label' => 'Certificat de Don', 'image' => 'certificat-don.png', 'route' => route('tools.contrat-don'), 'badge' => 'New'],
        ['label' => 'Contrat de Prêt', 'image' => 'contrat-pret.jpeg', 'route' => route('tools.contrat-pret'), 'badge' => 'New'],
        ['label' => 'Calculateur de Prêt Pro', 'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="54" height="54" viewBox="0 0 24 24" fill="none" stroke="#1e3a5f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="2" width="16" height="20" rx="2"/><line x1="8" y1="6" x2="16" y2="6"/><line x1="8" y1="10" x2="10" y2="10"/><line x1="12" y1="10" x2="14" y2="10"/><line x1="16" y1="10" x2="16" y2="10"/><line x1="8" y1="14" x2="10" y2="14"/><line x1="12" y1="14" x2="14" y2="14"/><line x1="16" y1="14" x2="16" y2="14"/><line x1="8" y1="18" x2="10" y2="18"/><line x1="12" y1="18" x2="16" y2="18"/></svg>', 'route' => route('tools.simulateur-credit'), 'badge' => 'New'],
        ['label' => 'Mail Flash Pro', 'image' => 'mail-flash-pro.png', 'route' => route('mail.flash.pro')],
        ['label' => 'Demander un Paiement', 'svg' => '<img src="/images/tools/e1ccc317-49f0-4b1b-98d8-f695ee5bdd76.png" alt="Demander un Paiement" style="width:90px;height:90px;object-fit:contain;">', 'route' => route('payment-claims.index'), 'badge' => 'New'],
        ['label' => 'Collecte de code coupon', 'image' => 'code-coupon.png', 'route' => '#', 'badge' => 'Bientot'],
        ['label' => 'Verification IBAN / CB', 'image' => 'iban-check.png', 'route' => route('tools.iban-check')],
        ['label' => 'Verification telephone', 'image' => 'phone-verify.png', 'route' => route('tools.phone-verify')],
        ['label' => 'Mail Pro Prive', 'image' => 'mail-pro-prive.png', 'route' => route('mail.pro.prive'), 'badge' => 'Bientot'],
    ];

    $freeTools = [
        ['label' => 'Générateur QR Code', 'image' => 'qr-generator.svg', 'route' => route('tools.qr-generator'), 'badge' => 'New'],
        ['label' => 'Badge Agent', 'image' => 'badge-agent.png', 'route' => route('tools.badge-agent'), 'badge' => 'New'],
        ['label' => 'Mail Extractor', 'image' => 'mail-extractor.png', 'route' => route('tools.mail-extractor')],
        ['label' => "Verification d'un site web", 'image' => 'url-check.png', 'route' => route('tools.url-check')],
        ['label' => "Raccourcissement d'URL", 'image' => 'url-shortener.png', 'route' => route('tools.url-shortener')],
        ['label' => 'Vente de Crypto USDT', 'image' => 'crypto-usdt.png', 'route' => route('crypto.vente'), 'badge' => 'Bientot'],
        ['label' => 'Numeros virtuelles', 'image' => 'telephone.png', 'route' => 'https://console.whatsago.com/partners/45575', 'is_external' => true, 'badge' => 'Rupture', 'modal_trigger' => 'modalNumerosVirtuels'],
        ['label' => 'Cartes virtuelles', 'image' => 'virtual-cards.png', 'route' => 'https://neutrocard.com/new-login/', 'is_external' => true],
    ];
@endphp


<div class="row g-4">
    {{-- Outils payants --}}
    <div class="col-12 col-lg-6">
        <div class="tools-section">
            <div class="tools-section__header">
                <i class="fas fa-id-card"></i>
                <strong>Outils a acces payant</strong>
            </div>
            <div class="tools-grid">
                @foreach($paidTools as $tool)
                    @php $href = $tool['route'] ?? '#'; $isExternal = $tool['is_external'] ?? false; @endphp
                    <a href="{{ $href }}" class="tool-card" {!! $isExternal ? 'target="_blank" rel="noopener noreferrer"' : '' !!}>
                        @if(isset($tool['badge']))
                            <span class="tool-badge {{ $tool['badge'] === 'Bientot' ? 'tool-badge--soon' : ($tool['badge'] === 'New' ? 'tool-badge--new' : '') }}">{{ $tool['badge'] }}</span>
                        @endif
                        @if(isset($tool['svg']))
                            {!! $tool['svg'] !!}
                        @elseif(isset($tool['icon']))
                            <i class="{{ $tool['icon'] }} tool-icon-fa" style="color:{{ $tool['icon_color'] ?? '#1e3a5f' }};"></i>
                        @else
                            <img src="{{ asset('images/tools/' . $tool['image']) }}" alt="{{ $tool['label'] }}" class="tool-icon">
                        @endif
                        <span class="tool-label">{{ $tool['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Outils gratuits --}}
    <div class="col-12 col-lg-6">
        <div class="tools-section">
            <div class="tools-section__header">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.24 12.24a6 6 0 0 0-8.49-8.49L5 10.5V19h8.5z"/><line x1="16" y1="8" x2="2" y2="22"/><line x1="17.5" y1="15" x2="9" y2="15"/></svg>
                <strong>Outils a acces libre</strong>
            </div>
            <div class="tools-grid">
                @foreach($freeTools as $tool)
                    @php
                        $href = $tool['route'] ?? '#';
                        $isExternal = $tool['is_external'] ?? false;
                        $modalTrigger = $tool['modal_trigger'] ?? null;
                    @endphp
                    <a href="{{ $modalTrigger ? '#' : $href }}"
                       class="tool-card"
                       {!! ($isExternal && !$modalTrigger) ? 'target="_blank" rel="noopener noreferrer"' : '' !!}
                       {!! $modalTrigger ? 'data-bs-toggle="modal" data-bs-target="#' . $modalTrigger . '"' : '' !!}>
                        @if(isset($tool['badge']))
                            @php
                                $badgeClass = match($tool['badge']) {
                                    'Bientot' => 'tool-badge--soon',
                                    'New'     => 'tool-badge--new',
                                    'Rupture' => 'tool-badge--rupture',
                                    default   => '',
                                };
                            @endphp
                            <span class="tool-badge {{ $badgeClass }}">{{ $tool['badge'] }}</span>
                        @endif
                        @if(isset($tool['svg']))
                            {!! $tool['svg'] !!}
                        @elseif(isset($tool['icon']))
                            <i class="{{ $tool['icon'] }} tool-icon-fa" style="color:{{ $tool['icon_color'] ?? '#1e3a5f' }};"></i>
                        @else
                            <img src="{{ asset('images/tools/' . $tool['image']) }}" alt="{{ $tool['label'] }}" class="tool-icon">
                        @endif
                        <span class="tool-label">{{ $tool['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    .tools-section {
        background: var(--bg-card, #fff);
        border-radius: 14px;
        border: 1px solid var(--border-color, #e8e8e8);
        padding: 1.5rem;
        height: 100%;
    }

    .tools-section__header {
        font-size: 0.95rem;
        font-weight: 500;
        color: var(--text-primary, #333);
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding-bottom: 0.85rem;
        margin-bottom: 1rem;
        border-bottom: 1px solid var(--border-color, #e8e8e8);
    }

    .tools-section__header i {
        font-size: 1.1rem;
        color: var(--text-secondary, #888);
    }

    .tools-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.25rem;
    }

    .tool-card {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        padding: 1.5rem 1rem;
        background: #fff;
        border: 1px solid #eee;
        border-radius: 12px;
        text-decoration: none;
        color: var(--text-primary, #333);
        transition: all 0.2s ease;
        min-height: 155px;
    }

    .tool-card:hover {
        border-color: #ccc;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        transform: translateY(-2px);
        color: var(--text-primary, #333);
    }

    .tool-icon {
        width: 56px;
        height: 56px;
        object-fit: contain;
    }

    .tool-icon-fa {
        font-size: 2.4rem;
        width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .tool-label {
        font-size: 0.85rem;
        font-weight: 500;
        text-align: center;
        line-height: 1.3;
    }

    .tool-badge {
        position: absolute;
        top: 8px;
        left: 8px;
        z-index: 2;
        background: #2196F3;
        color: #fff;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 4px;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .tool-badge--soon {
        background: #fbbf24;
        color: #7c2d12;
    }

    .tool-badge--new {
        background: #2196F3;
        color: #fff;
    }

    .tool-badge--rupture {
        background: #ef4444;
        color: #fff;
    }

    @media (max-width: 575px) {
        .tools-grid {
            gap: 0.75rem;
        }

        .tool-card {
            padding: 1rem 0.5rem;
            min-height: 120px;
        }

        .tool-icon {
            width: 44px;
            height: 44px;
        }

        .tool-label {
            font-size: 0.8rem;
        }
    }
</style>

<style>
    img.tool-icon[src*="contrat-pret"], img.tool-icon[src*="badge-agent"] { 
        filter: drop-shadow(0 4px 8px rgba(0,0,0,0.15));
        transition: filter 0.3s ease;
    }
    .tool-card:hover img.tool-icon[src*="contrat-pret"], 
    .tool-card:hover img.tool-icon[src*="badge-agent"] {
        filter: drop-shadow(0 6px 12px rgba(0,0,0,0.2));
    }
    img.tool-icon[src*="contrat-pret"] { border-radius: 12px; }
    img.tool-icon[src*="badge-agent"] { width: 80px; height: 80px; }
    img.tool-icon[src*="certificat-don"] { width: 80px; height: 80px; }
</style>

{{-- Modal : Numéros Virtuels en rupture --}}
<div class="modal fade" id="modalNumerosVirtuels" tabindex="-1" aria-labelledby="modalNumerosVirtuelsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header border-0 pb-0" style="background: #fef2f2;">
                <div class="d-flex align-items-center gap-3 w-100 pt-1">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:48px;height:48px;background:#fee2e2;">
                        <img src="{{ asset('images/tools/telephone.png') }}" alt="Numéros Virtuels"
                             style="width:28px;height:28px;object-fit:contain;">
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0" id="modalNumerosVirtuelsLabel" style="font-size:1rem;">
                            Numéros Virtuels
                        </h5>
                        <span class="badge rounded-pill" style="background:#ef4444;font-size:0.7rem;">Rupture de stock</span>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
            </div>

            <div class="modal-body px-4 py-3">
                <div class="d-flex align-items-start gap-3 p-3 rounded-3 mb-3"
                     style="background:#fef2f2;border:1px solid #fecaca;">
                    <span style="font-size:1.4rem;flex-shrink:0;">⚠️</span>
                    <div>
                        <p class="fw-semibold mb-1" style="font-size:0.92rem;color:#991b1b;">
                            Aucun numéro disponible en ce moment
                        </p>
                        <p class="mb-0 text-secondary" style="font-size:0.85rem;line-height:1.5;">
                            Le stock de numéros virtuels WhatsApp est actuellement épuisé.
                            <strong>Ne rechargez pas votre compte</strong> dans l'immédiat pour cet usage.
                        </p>
                    </div>
                </div>
                <p class="text-secondary mb-0" style="font-size:0.83rem;">
                    Vous pouvez tout de même consulter le site partenaire pour vérifier la disponibilité ou être notifié lors d'un réapprovisionnement.
                </p>
            </div>

            <div class="modal-footer border-0 pt-0 pb-4 px-4 gap-2">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal"
                        style="font-size:0.85rem;">
                    Fermer
                </button>
                <a href="https://console.whatsago.com/partners/45575" target="_blank" rel="noopener noreferrer"
                   class="btn rounded-pill px-4 fw-semibold"
                   style="background:#1e3a5f;color:#fff;font-size:0.85rem;"
                   data-bs-dismiss="modal">
                    Voir quand même le site &rarr;
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
