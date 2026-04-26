@extends('layouts.admin')

@section('title', 'Liste des outils')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="ri-briefcase-line me-1"></i>Liste des outils</a></li>
    <li class="breadcrumb-item"><a href="{{ route('recharge.index') }}"><i class="ri-wallet-line me-1"></i>Recharge</a></li>
@endsection

@section('content')
@php
    $paidTools = [
        ['label' => 'SMS Pro', 'image' => 'sms-pro.png', 'route' => route('sms.pro')],
        ['label' => 'Flash Compte Pro', 'image' => 'flash-compte-v1.png', 'route' => route('compte.create')],
        ['label' => 'Mail Flash Pro', 'image' => 'mail-flash-pro.png', 'route' => route('mail.flash.pro')],
        ['label' => 'Contrat de Prêt', 'image' => 'contrat-pret.jpeg', 'route' => route('tools.contrat-pret'), 'badge' => 'New'],
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
        ['label' => 'Numeros virtuelles', 'image' => 'telephone.png', 'route' => 'https://console.whatsago.com/partners/45575', 'is_external' => true],
        ['label' => 'Cartes virtuelles', 'image' => 'virtual-cards.png', 'route' => 'https://neutrocard.com/new-login/', 'is_external' => true],
    ];
@endphp

{{-- === Bannière Bonus Fidélité === --}}
@php
    $user = auth()->user();
    $totalRechargesLast30 = 0;
    $totalBonusGiven = 0;
    if ($user) {
        $since30 = now()->subDays(30);
        // Compter les recharges crédits RÉUSSIES des 30 derniers jours
        $totalRechargesLast30 = \App\Models\RechargeTransaction::where('user_id', $user->id)
            ->where('status', 'completed')
            ->where('created_at', '>=', $since30)
            ->count();
        // Vérifier si le bonus a déjà été accordé
        $compteIds = \App\Models\Compte::where('user_id', $user->id)->pluck('id');
        if ($compteIds->isNotEmpty()) {
            $totalBonusGiven = \App\Models\TransactionHistory::whereIn('compte_id', $compteIds)
                ->where('transaction_type', 'Loyalty bonus')
                ->where('created_at', '>=', $since30)
                ->count();
        }
    }
    $loyaltyProgress = min($totalRechargesLast30, 4);
    $bonusClaimed = $totalBonusGiven > 0;
@endphp

<div class="loyalty-banner">
    <div class="loyalty-banner__left">
        <div class="loyalty-banner__icon">🎁</div>
        <div>
            <div class="loyalty-banner__title">🎉 Bonus Fidélité</div>
            <div class="loyalty-banner__desc">Effectuez 4 recharges de crédits en 30 jours et recevez <strong>5 000 crédits gratuits</strong> 🎊</div>
        </div>
    </div>
    <div class="loyalty-banner__right">
        <div class="loyalty-banner__steps">
            @for($i = 1; $i <= 4; $i++)
                <span class="loyalty-dot {{ $i <= $loyaltyProgress ? 'filled' : '' }} {{ $i === 4 && $bonusClaimed ? 'claimed' : '' }}">
                    @if($i === 4 && $bonusClaimed) ✅ @else {{ $i }} @endif
                </span>
                @if($i < 4) <span class="loyalty-bar {{ $i < $loyaltyProgress ? 'filled' : '' }}"></span> @endif
            @endfor
        </div>
        <div class="loyalty-banner__status">
            <span class="loyalty-banner__count">{{ $loyaltyProgress }}/4</span>
            @if($bonusClaimed)
                <span class="loyalty-badge-ok">🏆 +5 000 crédits obtenus !</span>
            @else
                <span class="loyalty-badge-wait">🎁 +5 000 crédits à la 4e recharge</span>
            @endif
        </div>
    </div>
</div>

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
                            <span class="tool-badge {{ $tool['badge'] === 'Bientot' ? 'tool-badge--soon' : ($tool['badge'] === 'New' ? 'tool-badge--new' : '') }}">{{ $tool['badge'] }}</span>
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
    /* === Bannière Bonus Fidélité === */
    .loyalty-banner {
        background: linear-gradient(135deg, #fefce8 0%, #fef9c3 40%, #fde68a 100%);
        border: 1px solid #fbbf24;
        border-radius: 16px;
        padding: 20px 24px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
    }
    .loyalty-banner__left {
        display: flex;
        align-items: center;
        gap: 14px;
        flex: 1;
        min-width: 220px;
    }
    .loyalty-banner__icon {
        font-size: 2.2rem;
        flex-shrink: 0;
    }
    .loyalty-banner__title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #92400e;
    }
    .loyalty-banner__desc {
        font-size: 0.82rem;
        color: #78350f;
        margin-top: 2px;
    }
    .loyalty-banner__right {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 10px;
        min-width: 200px;
    }
    .loyalty-banner__steps {
        display: flex;
        align-items: center;
        gap: 0;
    }
    .loyalty-dot {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #fef3c7;
        border: 2px solid #d97706;
        color: #92400e;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.8rem;
        transition: all 0.3s;
        flex-shrink: 0;
    }
    .loyalty-dot.filled {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: #fff;
        border-color: #b45309;
        box-shadow: 0 2px 8px rgba(217,119,6,0.35);
    }
    .loyalty-dot.claimed {
        background: linear-gradient(135deg, #10b981, #059669);
        border-color: #047857;
        color: #fff;
        box-shadow: 0 2px 8px rgba(16,185,129,0.35);
        font-size: 0.85rem;
    }
    .loyalty-bar {
        width: 24px;
        height: 3px;
        background: #fde68a;
        transition: background 0.3s;
    }
    .loyalty-bar.filled {
        background: linear-gradient(90deg, #f59e0b, #d97706);
    }
    .loyalty-banner__status {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .loyalty-banner__count {
        font-weight: 700;
        font-size: 1rem;
        color: #92400e;
    }
    .loyalty-badge-ok {
        font-size: 0.78rem;
        font-weight: 600;
        padding: 3px 12px;
        border-radius: 999px;
        background: rgba(16,185,129,0.15);
        color: #047857;
    }
    .loyalty-badge-wait {
        font-size: 0.78rem;
        font-weight: 600;
        padding: 3px 12px;
        border-radius: 999px;
        background: rgba(217,119,6,0.12);
        color: #92400e;
    }
    @media (max-width: 768px) {
        .loyalty-banner {
            flex-direction: column;
            align-items: stretch;
            padding: 16px;
            gap: 14px;
        }
        .loyalty-banner__left {
            gap: 10px;
        }
        .loyalty-banner__icon {
            font-size: 1.6rem;
        }
        .loyalty-banner__title {
            font-size: 0.95rem;
        }
        .loyalty-banner__desc {
            font-size: 0.75rem;
        }
        .loyalty-banner__right {
            align-items: stretch;
            width: 100%;
        }
        .loyalty-banner__steps {
            justify-content: center;
            width: 100%;
        }
        .loyalty-dot {
            width: 36px;
            height: 36px;
            font-size: 0.85rem;
        }
        .loyalty-bar {
            flex: 1;
            max-width: 40px;
        }
        .loyalty-banner__status {
            justify-content: space-between;
            width: 100%;
        }
        .loyalty-banner__count {
            font-size: 1.1rem;
        }
    }

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

    .tool-badge--new {
        background: #22c55e;
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
</style>
@endsection
