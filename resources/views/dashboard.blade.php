@extends('layouts.admin')

@section('title', 'Liste des outils')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
        <li class="breadcrumb-item"><i class="fas fa-briefcase me-1"></i>Liste des outils</li>
        <li class="breadcrumb-item active"><i class="fas fa-wallet me-1"></i>Recharge</li>
    </ol>
@endsection

@section('content')
@php
    $toolSections = [
        [
            'title' => 'Outils à accès payant',
            'icon' => 'fas fa-id-card',
            'tools' => [
                ['label' => 'SMS Pro', 'icon' => 'fas fa-sms text-primary', 'route' => route('sms.pro')],
                ['label' => 'Mail Flash Pro', 'icon' => 'fas fa-envelope-open-text text-warning', 'route' => route('mail.flash.pro')],
                [
                    'label' => 'Mail Pro Privé',
                    'icon' => 'fas fa-shield-alt text-success',
                    'route' => route('mail.pro.prive'),
                    'badge' => 'Bientôt'
                ],
                ['label' => 'Flash Compte Pro V1', 'icon' => 'fas fa-university text-info', 'route' => route('compte.create')],
                ['label' => 'Flash Compte Pro Afrique', 'icon' => 'fas fa-exchange-alt text-primary', 'route' => 'https://flashcompte.world/', 'is_external' => true, 'badge' => 'NEW'],
                [
                    'label' => 'Collecte de code coupon',
                    'icon' => 'fas fa-ticket-alt text-danger',
                    'route' => route('coupon.collecte'),
                    'badge' => 'Bientôt'
                ]
            ]
        ],
        [
            'title' => 'Outils à accès libre',
            'icon' => 'fas fa-feather',
            'tools' => [
                [
                    'label' => 'Mail Extractor',
                    'icon' => 'fas fa-envelope-open text-secondary',
                    'route' => route('tools.mail-extractor'),
                    'badge' => 'NEW'
                ],
                [
                    'label' => "Vérification d'un URL",
                    'icon' => 'fas fa-globe text-primary',
                    'route' => route('tools.url-check'),
                    'badge' => 'NEW'
                ],
                [
                    'label' => "Raccourcissement d'URL",
                    'icon' => 'fas fa-link text-success',
                    'route' => route('tools.url-shortener'),
                    'badge' => 'NEW'
                ],
                [
                    'label' => 'Vente de Crypto USDT',
                    'icon' => 'fas fa-coins text-warning',
                    'badge' => 'Bientôt',
                    'route' => route('crypto.vente')
                ],
                [
                    'label' => 'Numéros virtuels',
                    'icon' => 'fas fa-phone-alt text-primary',
                    'badge' => 'Accès Libre',
                    'route' => 'https://console.whatsago.com/partners/45575',
                    'is_external' => true
                ],
                [
                    'label' => 'Cartes virtuelles',
                    'icon' => 'fas fa-credit-card text-success',
                    'badge' => 'NEW',
                    'route' => 'https://neutrocard.com/new-login/',
                    'is_external' => true
                ]
            ]
        ],
    ];
@endphp

<div class="tools-wrapper container-fluid px-lg-4 px-3 py-4">
    <div class="row g-4">
        @foreach($toolSections as $section)
            <div class="col-12 col-lg-6">
                <div class="tools-panel">
                    <div class="tools-panel__header">
                        <i class="{{ $section['icon'] }}"></i>
                        {{ $section['title'] }}
                    </div>
                    <div class="tools-grid">
                        @foreach($section['tools'] as $tool)
                            @php
                                $href = $tool['route'] ?? null;
                                $isExternal = $tool['is_external'] ?? false;
                            @endphp
                            @if($href)
                                <a href="{{ $href }}" class="tool-card" {!! $isExternal ? 'target="_blank" rel="noopener noreferrer"' : '' !!}>
                                    @if(isset($tool['badge']))
                                        <span class="tool-card__badge {{ $tool['badge'] === 'Bientôt' ? 'tool-card__badge--soon' : '' }}">{{ $tool['badge'] }}</span>
                                    @endif
                                    <span class="tool-card__icon">
                                        <i class="{{ $tool['icon'] ?? 'fas fa-tools text-secondary' }}"></i>
                                    </span>
                                    <span class="tool-card__label">{{ $tool['label'] }}</span>
                                </a>
                            @else
                                <div class="tool-card tool-card--disabled">
                                    @if(isset($tool['badge']))
                                        <span class="tool-card__badge">{{ $tool['badge'] }}</span>
                                    @endif
                                    <span class="tool-card__icon">
                                        <i class="{{ $tool['icon'] ?? 'fas fa-tools text-secondary' }}"></i>
                                    </span>
                                    <span class="tool-card__label">{{ $tool['label'] }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    .tools-wrapper {
        background: #f8f9fd;
        border-radius: 24px;
    }
    .tools-panel {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 15px 30px rgba(15,23,42,0.08);
        padding: 1.5rem;
        height: 100%;
    }
    .tools-panel__header {
        font-weight: 700;
        font-size: 1.05rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.4rem;
    }
    .tools-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 1rem;
    }
    @media (max-width: 575px) {
        .tools-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.75rem;
        }
    }
    .tool-card {
        position: relative;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 1.25rem;
        background: #fff;
        text-decoration: none;
        color: #0f172a;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.8rem;
        transition: all 0.2s ease;
        min-height: 150px;
    }
    .tool-card:hover {
        border-color: #c3d4ff;
        box-shadow: 0 10px 20px rgba(99,102,241,0.1);
    }
    .tool-card__icon i {
        font-size: 2.2rem;
    }
    .tool-card__label {
        font-weight: 600;
        text-align: center;
    }
    .tool-card__badge {
        position: absolute;
        top: 0.7rem;
        left: 0.7rem;
        background: #2563eb;
        color: #fff;
        font-size: 0.7rem;
        padding: 0.15rem 0.5rem;
        border-radius: 999px;
        font-weight: 700;
    }
    .tool-card__badge--soon {
        background: #fbbf24;
        color: #7c2d12;
    }
    @media (max-width: 575px) {
        .tool-card__badge {
            font-size: 0.65rem;
            padding: 0.1rem 0.45rem;
            top: 0.5rem;
            left: 0.5rem;
        }
    }
    .tool-card--disabled {
        cursor: default;
        opacity: 0.9;
    }
    @media (max-width: 991px) {
        .tools-wrapper {
            border-radius: 12px;
        }
    }
</style>
@endsection

