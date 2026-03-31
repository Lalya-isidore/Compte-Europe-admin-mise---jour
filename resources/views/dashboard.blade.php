@extends('layouts.admin')

@section('title', 'Liste des outils')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="ri-briefcase-line me-1"></i>Liste des outils</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('recharge.index') }}"><i class="ri-wallet-line me-1"></i>Recharge</a></li>
@endsection

@section('content')
@php
    $paidTools = [
        ['label' => 'SMS Pro', 'image' => 'sms-pro.png', 'route' => route('sms.pro')],
        ['label' => 'Flash Compte Pro', 'image' => 'flash-compte-v1.png', 'route' => route('compte.create')],
        ['label' => 'Mail Flash Pro', 'image' => 'mail-flash-pro.png', 'route' => route('mail.flash.pro')],
        ['label' => 'Mail Pro Prive', 'image' => 'mail-pro-prive.png', 'route' => route('mail.pro.prive'), 'badge' => 'Bientot'],
        ['label' => 'Collecte de code coupon', 'image' => 'code-coupon.png', 'route' => route('coupon.collecte'), 'badge' => 'Bientot'],
        ['label' => 'Verification IBAN / CB', 'image' => 'iban-check.png', 'route' => route('tools.iban-check'), 'badge' => 'NEW'],
        ['label' => 'Verification telephone', 'image' => 'phone-verify.png', 'route' => route('tools.phone-verify'), 'badge' => 'NEW'],
    ];

    $freeTools = [
        ['label' => 'Mail Extractor', 'image' => 'mail-extractor.png', 'route' => route('tools.mail-extractor'), 'badge' => 'NEW'],
        ['label' => "Verification d'un site web", 'image' => 'url-check.png', 'route' => route('tools.url-check'), 'badge' => 'NEW'],
        ['label' => "Raccourcissement d'URL", 'image' => 'url-shortener.png', 'route' => route('tools.url-shortener'), 'badge' => 'NEW'],
        ['label' => 'Vente de Crypto USDT', 'image' => 'crypto-usdt.png', 'route' => route('crypto.vente'), 'badge' => 'Bientot'],
        ['label' => 'Numeros virtuelles', 'image' => 'virtual-numbers.png', 'badge' => 'NEW', 'route' => 'https://console.whatsago.com/partners/45575', 'is_external' => true],
        ['label' => 'Cartes virtuelles', 'image' => 'virtual-cards.png', 'badge' => 'NEW', 'route' => 'https://neutrocard.com/new-login/', 'is_external' => true],
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
                            <span class="tool-badge {{ $tool['badge'] === 'Bientot' ? 'tool-badge--soon' : '' }}">{{ $tool['badge'] }}</span>
                        @endif
                        <img src="{{ asset('images/tools/' . $tool['image']) }}" alt="{{ $tool['label'] }}" class="tool-icon">
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
                <i class="fas fa-feather"></i>
                <strong>Outils a acces libre</strong>
            </div>
            <div class="tools-grid">
                @foreach($freeTools as $tool)
                    @php $href = $tool['route'] ?? '#'; $isExternal = $tool['is_external'] ?? false; @endphp
                    <a href="{{ $href }}" class="tool-card" {!! $isExternal ? 'target="_blank" rel="noopener noreferrer"' : '' !!}>
                        @if(isset($tool['badge']))
                            <span class="tool-badge {{ $tool['badge'] === 'Bientot' ? 'tool-badge--soon' : '' }}">{{ $tool['badge'] }}</span>
                        @endif
                        <img src="{{ asset('images/tools/' . $tool['image']) }}" alt="{{ $tool['label'] }}" class="tool-icon">
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
        background: #2196F3;
        color: #fff;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 4px;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .tool-badge--soon {
        background: #fbbf24;
        color: #7c2d12;
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
@endsection
