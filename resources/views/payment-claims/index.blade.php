@extends('layouts.admin')

@section('title', 'Gestion des Liens de Paiement')

@section('breadcrumb')
    <li class="breadcrumb-item active">Liens de Paiement</li>
@endsection

@section('content')

@php
$currencyLabels = [
    'XOF' => 'FCFA Ouest (XOF)',
    'XAF' => 'FCFA Central (XAF)',
    'EUR' => 'Euro (EUR)',
    'USD' => 'US Dollar (USD)',
    'CDF' => 'Franc Congolais (CDF)',
    'GNF' => 'Franc Guinéen (GNF)',
    'GMD' => 'Dalasi (GMD)',
];
@endphp

@if(session('success'))
    <div class="alert alert-success rounded-3 py-2 mb-4">{{ session('success') }}</div>
@endif
@if($errors->has('currency'))
    <div class="alert alert-danger rounded-3 py-2 mb-4">{{ $errors->first('currency') }}</div>
@endif
@if($errors->has('transaction_id') || $errors->has('amount') || $errors->has('screenshot'))
    <div class="alert alert-danger rounded-3 py-2 mb-4">{{ $errors->first() }}</div>
@endif

{{-- Header --}}
<div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <h2 class="fw-bold mb-1" style="font-size:1.8rem;">Gestion des Liens de Paiement</h2>
        <p class="text-muted mb-0" style="font-size:.95rem;">Créez et gérez vos liens de paiement pour vos produits et services.</p>
    </div>
    @if(count($availableCurrencies) > 0)
    <button class="btn fw-bold px-4 py-2 rounded-3 text-white"
            style="background:#e8521a;font-size:.95rem;"
            onclick="openCreateLink()">
        + &nbsp;Créer un lien
    </button>
    @endif
</div>

{{-- Utilité et Fonctionnement --}}
<div class="mb-4">
    <p style="margin-bottom:10px;">
        <span data-bs-toggle="modal" data-bs-target="#paymentLinksHelpModal"
              style="display:inline-block;background:#4f429b;color:#fff;border-radius:4px;padding:9px 18px;font-size:.88rem;font-weight:600;cursor:pointer;box-shadow:0 0 12px rgba(0,0,0,.12);transition:transform 200ms;"
              onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
            <i class="ri-information-line me-1"></i> Utilité et Fonctionnement <i class="ri-arrow-right-s-line"></i>
        </span>
    </p>
    <div class="alert alert-primary mb-0" role="alert" style="font-size:.88rem;">
        <p class="mb-2"><i class="ri-information-line me-1"></i> Cet outil vous permet de créer des <strong>liens de paiement</strong> à partager avec vos clients. Au lieu d'aller en agence, votre client <strong>paie directement depuis son téléphone</strong> — il clique sur le lien, entre son numéro mobile money, et <strong>confirme le paiement sur son téléphone</strong> en quelques secondes. Vous soumettez ensuite la capture d'écran et l'admin vire les fonds sur votre mobile money.</p>
        <p class="mb-2"><strong>NB :</strong> Les virements sont traités sous <strong>24h</strong>. Passé ce délai, contactez le support. Pays supportés : <strong>15 pays africains</strong> (XOF, XAF, CDF, GNF, GMD).</p>
        <div style="display:flex;gap:10px;flex-wrap:wrap;">
            <span style="background:#1d4ed8;color:#fff;border-radius:6px;padding:4px 12px;font-size:.82rem;font-weight:600;">
                <i class="ri-percent-line me-1"></i> Afrique de l'Ouest (XOF) : frais <strong>15%</strong>
            </span>
            <span style="background:#7c3aed;color:#fff;border-radius:6px;padding:4px 12px;font-size:.82rem;font-weight:600;">
                <i class="ri-percent-line me-1"></i> Afrique Centrale (XAF) : frais <strong>20%</strong>
            </span>
        </div>
    </div>
</div>

{{-- Modal Utilité et Fonctionnement --}}
<div class="modal fade" id="paymentLinksHelpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold"><i class="ri-information-line me-2"></i>Utilité et Fonctionnement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4">
                <h6 class="text-primary fw-bold">Utilité</h6>
                <p>Cet outil vous permet de créer des <strong>liens de paiement</strong> pour recevoir des paiements depuis <strong>15 pays africains</strong>. Au lieu d'aller en agence, votre client <strong>paie directement depuis son téléphone</strong> — il clique sur le lien, entre son numéro mobile money, et <strong>confirme le paiement sur son téléphone</strong> lui-même, en quelques secondes. Vous récupérez ensuite les fonds sur votre mobile money.</p>

                <h6 class="text-primary fw-bold">Fonctionnement</h6>
                <ol class="ps-3" style="font-size:.9rem;line-height:1.8;">
                    <li>Créez un lien par devise souhaitée (XOF, XAF, CDF, GNF, GMD).</li>
                    <li>Copiez et partagez le lien à votre client.</li>
                    <li>Votre client clique sur le lien, entre son numéro mobile money et confirme le paiement directement sur son téléphone — sans se déplacer en agence.</li>
                    <li>Vous soumettez la preuve de paiement (ID transaction + capture d'écran).</li>
                    <li>L'admin vérifie et vire les fonds sur votre numéro mobile money configuré.</li>
                </ol>

                <h6 class="text-primary fw-bold mt-3">Frais de service</h6>
                <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:12px;">
                    <span style="background:#1d4ed8;color:#fff;border-radius:6px;padding:5px 14px;font-size:.85rem;font-weight:600;">
                        <i class="ri-percent-line me-1"></i> Afrique de l'Ouest (XOF) : <strong>15%</strong>
                    </span>
                    <span style="background:#7c3aed;color:#fff;border-radius:6px;padding:5px 14px;font-size:.85rem;font-weight:600;">
                        <i class="ri-percent-line me-1"></i> Afrique Centrale (XAF) : <strong>20%</strong>
                    </span>
                </div>

                <div class="rounded-3 p-3 mt-2" style="background:#fff3cd;border:1px solid #fde68a;font-size:.85rem;">
                    <i class="ri-time-line me-1" style="color:#d97706;"></i>
                    <strong>Délai de traitement :</strong> les virements sont effectués sous 24h. Passé ce délai, contactez le support.
                </div>
            </div>
            <div class="modal-footer border-0 px-4 pb-4">
                <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

{{-- Pays supportés (ticker) --}}
@php
$pays = [
    ['bj','Bénin','XOF'],
    ['bf','Burkina Faso','XOF'],
    ['cm','Cameroun','XAF'],
    ['cg','Congo','XAF'],
    ['ci','Côte d\'Ivoire','XOF'],
    ['ga','Gabon','XAF'],
    ['gm','Gambie','GMD'],
    ['gn','Guinée','GNF'],
    ['gw','Guinée-Bissau','XOF'],
    ['ml','Mali','XOF'],
    ['ne','Niger','XOF'],
    ['cd','R.D.C','CDF'],
    ['sn','Sénégal','XOF'],
    ['td','Tchad','XAF'],
    ['tg','Togo','XOF'],
];
@endphp
<div style="margin-bottom:20px;display:flex;align-items:center;gap:12px;">
    <span style="font-size:.7rem;font-weight:700;text-transform:uppercase;color:#aaa;letter-spacing:.06em;white-space:nowrap;flex-shrink:0;">Pays supportés</span>
    <div style="overflow:hidden;flex:1;position:relative;">
        <div class="marquee-track">
            {{-- Liste dupliquée 2× pour boucle seamless --}}
            @foreach([1,2] as $_)
            <div class="marquee-list">
                @foreach($pays as [$code, $name, $currency])
                <span class="country-chip">
                    <img src="https://flagcdn.com/20x15/{{ $code }}.png" width="20" height="15" alt="{{ $name }}" style="border-radius:2px;flex-shrink:0;">
                    <span style="font-weight:500;">{{ $name }}</span>
                    <span style="font-size:.68rem;color:#aaa;">{{ $currency }}</span>
                </span>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>
</div>
<style>
.marquee-track {
    display: flex;
    width: max-content;
    animation: marquee-scroll 30s linear infinite;
}
.marquee-track:hover { animation-play-state: paused; }
.marquee-list {
    display: flex;
    align-items: center;
    gap: 6px;
    padding-right: 6px;
}
.country-chip {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 20px;
    background: #f8f9fa;
    border: 1px solid #eee;
    font-size: .78rem;
    color: #555;
    white-space: nowrap;
    flex-shrink: 0;
}
@keyframes marquee-scroll {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
</style>

{{-- Barre recherche --}}
<div class="d-flex align-items-center justify-content-between mb-3 gap-3 flex-wrap">
    <div style="position:relative;max-width:380px;width:100%;">
        <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#aaa;">
            <i class="ri-search-line"></i>
        </span>
        <input type="text" style="width:100%;padding:10px 14px 10px 38px;border:1px solid #ddd;border-radius:30px;font-size:.9rem;outline:none;"
               placeholder="Rechercher un lien...">
    </div>
    <button class="btn btn-outline-secondary rounded-3 px-4" style="white-space:nowrap;">
        <i class="ri-filter-line me-1"></i>Filtrer
    </button>
</div>

{{-- Vue mobile : cartes (cachée sur desktop) --}}
<div class="links-mobile">
@forelse($sebpayLinks as $currency => $link)
    <div style="padding:16px 20px;{{ !$loop->last ? 'border-bottom:1px solid #f0f0f0;' : '' }}">
        {{-- Ligne 1 : titre + badge --}}
        <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:6px;">
            <div style="font-weight:700;font-size:.95rem;">Paiement {{ $currency }}</div>
            <span style="flex-shrink:0;display:inline-block;padding:3px 12px;border-radius:20px;background:#d1fae5;color:#065f46;font-size:.75rem;font-weight:700;">ACTIF</span>
        </div>
        {{-- Ligne 2 : Copier puis URL en dessous --}}
        <div style="margin-bottom:10px;">
            <button onclick="copyAndShow('{{ addslashes($link['url']) }}', this)"
                    style="display:inline-block;background:#f0f0f0;border:1px solid #ddd;border-radius:6px;padding:3px 12px;font-size:.75rem;font-weight:600;cursor:pointer;margin-bottom:5px;">
                Copier
            </button>
            <a href="{{ $link['url'] }}" target="_blank" rel="noopener"
               style="font-family:monospace;font-size:.72rem;color:#2563eb;word-break:break-all;text-decoration:underline;">{{ $link['url'] }}</a>
        </div>
        {{-- Ligne 3 : montant + date + supprimer --}}
        <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;">
            <div style="font-size:.82rem;color:#555;">
                <span style="font-weight:600;">Min 1 {{ $currency }}</span>
                <span style="color:#aaa;margin-left:8px;">{{ $link['created_at']->format('d/m/Y') }}</span>
            </div>
            <form action="{{ route('payment-claims.delete-link', $currency) }}" method="POST"
                  onsubmit="return confirm('Supprimer le lien {{ $currency }} ?')" style="margin:0;">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-light rounded-2" style="color:#dc2626;">
                    <i class="ri-delete-bin-line"></i>
                </button>
            </form>
        </div>
    </div>
@empty
    <div style="padding:60px 20px;text-align:center;">
        <svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" fill="none" viewBox="0 0 24 24" stroke="#ddd" stroke-width="1.2" style="display:block;margin:0 auto 16px;">
            <circle cx="12" cy="12" r="10"/>
            <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>
        </svg>
        <p style="font-size:.95rem;color:#ccc;margin:0 0 16px;">Aucun lien de paiement trouvé.</p>
        @if(count($availableCurrencies) > 0)
        <button class="btn fw-bold px-4 py-2 rounded-3 text-white" style="background:#e8521a;" onclick="openCreateLink()">
            + &nbsp;Créer mon premier lien
        </button>
        @endif
    </div>
@endforelse
</div>

{{-- Table liens (cachée sur mobile) --}}
<div class="links-desktop">
    <div style="overflow-x:auto;">
    <table style="width:100%;border-collapse:collapse;min-width:560px;">
        <thead>
            <tr style="background:#fafafa;font-size:.75rem;font-weight:700;text-transform:uppercase;color:#999;letter-spacing:.06em;border-bottom:1px solid #eee;">
                <th style="padding:12px 20px;text-align:left;width:35%;">Titre</th>
                <th style="padding:12px 16px;text-align:left;width:15%;">Montant</th>
                <th style="padding:12px 16px;text-align:left;width:15%;">Statut</th>
                <th style="padding:12px 16px;text-align:left;width:20%;">Date de création</th>
                <th style="padding:12px 20px;text-align:right;width:15%;">Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($sebpayLinks as $currency => $link)
            <tr class="hover-row" style="{{ !$loop->last ? 'border-bottom:1px solid #f0f0f0;' : '' }}">
                <td style="padding:14px 20px;">
                    <div style="font-weight:600;font-size:.95rem;">Paiement {{ $currency }}</div>
                    <a href="{{ $link['url'] }}" target="_blank" rel="noopener"
                       style="font-family:monospace;font-size:.75rem;color:#2563eb;text-decoration:underline;word-break:break-all;margin-top:3px;display:block;">
                        {{ $link['url'] }}
                    </a>
                </td>
                <td style="padding:14px 16px;font-weight:600;font-size:.9rem;">Min 1 {{ $currency }}</td>
                <td style="padding:14px 16px;">
                    <span style="display:inline-block;padding:3px 12px;border-radius:20px;background:#d1fae5;color:#065f46;font-size:.78rem;font-weight:700;">ACTIF</span>
                </td>
                <td style="padding:14px 16px;color:#999;font-size:.88rem;">
                    {{ $link['created_at']->format('d/m/Y') }}
                </td>
                <td style="padding:14px 20px;text-align:right;">
                    <div style="display:flex;justify-content:flex-end;gap:8px;">
                        <button class="btn btn-sm btn-light rounded-2 fw-semibold" style="font-size:.78rem;"
                                onclick="copyAndShow('{{ addslashes($link['url']) }}', this)">
                            Copier
                        </button>
                        <form action="{{ route('payment-claims.delete-link', $currency) }}" method="POST"
                              onsubmit="return confirm('Supprimer le lien {{ $currency }} ?')" style="margin:0;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-light rounded-2" title="Supprimer"
                                    style="color:#dc2626;">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="padding:70px 20px;text-align:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" fill="none" viewBox="0 0 24 24" stroke="#ddd" stroke-width="1.2" style="display:block;margin:0 auto 16px;">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>
                    </svg>
                    <p style="font-size:.95rem;color:#ccc;margin:0 0 16px;">Aucun lien de paiement trouvé.</p>
                    @if(count($availableCurrencies) > 0)
                    <button class="btn fw-bold px-4 py-2 rounded-3 text-white"
                            style="background:#e8521a;font-size:.9rem;"
                            onclick="openCreateLink()">
                        + &nbsp;Créer mon premier lien
                    </button>
                    @endif
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
    </div>
</div>

    @if(count($sebpayLinks) > 0)
    <div style="padding:12px 20px;border-top:1px solid #f0f0f0;">
        <span style="font-size:.82rem;color:#aaa;display:block;margin-bottom:8px;">
            {{ count($sebpayLinks) }} lien{{ count($sebpayLinks) > 1 ? 's' : '' }} actif{{ count($sebpayLinks) > 1 ? 's' : '' }}
        </span>
        <a href="{{ route('portfolio.index') }}" class="btn fw-bold text-white rounded-3" style="background:#e8521a;font-size:.95rem;width:100%;padding:.5rem 1.5rem;">
            Voir mes paiements
        </a>
    </div>
    @endif
</div>

{{-- Historique des demandes --}}
@if($claims->isNotEmpty())
<div class="mt-5 pb-5">
    <h6 class="fw-bold mb-3 text-muted">Mes demandes de virement</h6>
    <div class="bg-white rounded-4 shadow-sm" style="border:1px solid #eee;">

        @php
            $statusMap2 = [
                'pending'  => ['#fff3cd','#856404','En attente'],
                'approved' => ['#cfe2ff','#0a58ca','Approuvée'],
                'paid'     => ['#d1fae5','#065f46','Payée'],
                'rejected' => ['#f8d7da','#842029','Rejetée'],
            ];
        @endphp

        {{-- Vue mobile : cartes --}}
        <div class="claims-mobile" style="padding:12px 16px;">
            @foreach($claims as $claim)
                @php $s2 = $statusMap2[$claim->status] ?? ['#eee','#555',$claim->status]; @endphp
                <div style="border:1px solid #f0f0f0;border-radius:10px;padding:14px;margin-bottom:10px;">
                    {{-- Ligne 1 : montant + statut --}}
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                        <span style="font-weight:700;font-size:1rem;">
                            {{ number_format($claim->net_amount ?? $claim->amount, 0, ',', ' ') }}
                            <span style="font-size:.78rem;color:#aaa;font-weight:400;">{{ $claim->currency }}</span>
                            @if($claim->net_amount)
                                <span style="font-size:.68rem;color:#aaa;font-weight:400;display:block;">brut {{ number_format($claim->amount, 0, ',', ' ') }} · frais {{ number_format($claim->commission_rate, 0) }}%</span>
                            @endif
                        </span>
                        <span style="flex-shrink:0;padding:3px 10px;border-radius:20px;font-size:.72rem;font-weight:700;background:{{ $s2[0] }};color:{{ $s2[1] }};">{{ $s2[2] }}</span>
                    </div>
                    {{-- Ligne 2 : réseau + numéro --}}
                    <div style="font-size:.82rem;color:#555;margin-bottom:4px;">{{ $claim->payout_network }} · {{ $claim->payout_phone }}</div>
                    {{-- Ligne 3 : ID + date + preuve --}}
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-top:6px;">
                        <div>
                            <div style="font-family:monospace;font-size:.72rem;color:#bbb;">{{ $claim->transaction_id }}</div>
                            <div style="font-size:.72rem;color:#ccc;">{{ $claim->created_at->format('d/m/Y') }}</div>
                        </div>
                        @if($claim->screenshot_path)
                            <a href="{{ asset('storage/'.$claim->screenshot_path) }}" target="_blank"
                               style="background:#f5f5f5;border:1px solid #eee;border-radius:8px;padding:6px 10px;font-size:.78rem;color:#555;text-decoration:none;">
                                <i class="ri-image-line me-1"></i>Voir
                            </a>
                        @endif
                    </div>
                    @if($claim->isRejected() && $claim->rejection_reason)
                        <div style="font-size:.75rem;color:#dc2626;margin-top:6px;padding:6px 8px;background:#fee2e2;border-radius:6px;">{{ $claim->rejection_reason }}</div>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Vue desktop : tableau --}}
        <div class="claims-desktop" style="overflow-x:auto;padding-right:80px;">
            <table class="table table-hover align-middle small mb-0" style="min-width:680px;">
                <thead style="background:#fafafa;font-size:.78rem;text-transform:uppercase;color:#888;">
                    <tr>
                        <th class="px-4 py-3">ID Transaction</th>
                        <th>Montant</th>
                        <th>Devise</th>
                        <th>Réseau</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th>Preuve</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($claims as $claim)
                    @php
                        $s2 = $statusMap2[$claim->status] ?? ['#eee','#555',$claim->status];
                        $netStyle = $claim->payout_network === 'MTN'
                            ? 'background:#fff3cd;color:#856404'
                            : ($claim->payout_network === 'MOOV'
                                ? 'background:#cfe2ff;color:#0a58ca'
                                : 'background:#f8d7da;color:#842029');
                    @endphp
                    <tr>
                        <td class="px-4 fw-semibold" style="font-family:monospace;">{{ $claim->transaction_id }}</td>
                        <td class="fw-bold">
                            {{ number_format($claim->net_amount ?? $claim->amount, 0, ',', ' ') }}
                            @if($claim->net_amount)
                                <div style="font-size:.72rem;color:#aaa;font-weight:400;">brut {{ number_format($claim->amount, 0, ',', ' ') }} · frais {{ number_format($claim->commission_rate, 0) }}%</div>
                            @endif
                        </td>
                        <td><span class="badge bg-secondary rounded-2">{{ $claim->currency }}</span></td>
                        <td>
                            <span class="badge rounded-pill px-2" style="{{ $netStyle }}">{{ $claim->payout_network }}</span>
                            <div class="text-muted smaller">{{ $claim->payout_phone }}</div>
                        </td>
                        <td>
                            <span class="badge rounded-pill px-2 fw-semibold"
                                  style="background:{{ $s2[0] }};color:{{ $s2[1] }};font-size:.75rem;">{{ $s2[2] }}</span>
                            @if($claim->isRejected() && $claim->rejection_reason)
                                <div class="text-danger smaller mt-1">{{ $claim->rejection_reason }}</div>
                            @endif
                        </td>
                        <td class="text-muted">{{ $claim->created_at->format('d/m/Y') }}</td>
                        <td>
                            @if($claim->screenshot_path)
                                <a href="{{ asset('storage/'.$claim->screenshot_path) }}" target="_blank"
                                   class="btn btn-sm btn-light rounded-2">
                                    <i class="ri-image-line"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        @if($claims->hasPages())
            <div class="px-4 py-3">{{ $claims->links() }}</div>
        @endif
    </div>
</div>
@endif

{{-- Modal : choisir devise + créer le lien --}}
<div class="modal fade" id="createLinkModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:480px;">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pt-4 px-4">
                <div>
                    <h5 class="modal-title fw-bold mb-1">🔗 Créer un lien de paiement</h5>
                    <p class="text-muted small mb-0">Choisissez la devise dans laquelle vos clients vont payer.</p>
                </div>
                <button class="btn-close ms-3" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                <form id="createLinkForm" action="{{ route('payment-claims.create-link') }}" method="POST">
                    @csrf
                    <input type="hidden" name="currency" id="selectedCurrencyInput">

                    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(120px,1fr));gap:12px;">
                        @foreach($availableCurrencies as $currency)
                        <button type="button"
                                onclick="pickCurrency('{{ $currency }}')"
                                id="card-{{ $currency }}"
                                style="border:2px solid #eee;border-radius:14px;padding:20px 10px;background:#fff;cursor:pointer;transition:all .18s;text-align:center;">
                            <div style="font-size:1.4rem;font-weight:800;color:#1e3a5f;line-height:1;">{{ $currency }}</div>
                            <div style="font-size:.72rem;color:#999;margin-top:6px;line-height:1.3;">{{ $currencyLabels[$currency] ?? $currency }}</div>
                        </button>
                        @endforeach
                    </div>

                    <div id="confirmBlock" style="display:none;margin-top:20px;">
                        <div class="rounded-3 p-3 mb-3" style="background:#fff7ed;border:1px solid #fed7aa;">
                            <p class="small mb-0">
                                <i class="ri-information-line me-1" style="color:#e8521a;"></i>
                                Un lien de paiement <strong id="confirmCurrencyLabel"></strong> sera ajouté à votre interface.
                                Vos clients pourront payer en ligne dans cette devise.
                            </p>
                        </div>
                        <button type="submit" class="btn fw-bold w-100 rounded-3 text-white py-2" style="background:#e8521a;">
                            <i class="ri-check-line me-2"></i>Confirmer la création
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal : soumettre preuve --}}
<div class="modal fade" id="submitModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:460px;">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">📤 Soumettre une preuve de paiement</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            @if(!$config)
            <div class="modal-body px-4 py-3">
                <div class="alert alert-warning rounded-3 small">
                    <i class="ri-alert-line me-2"></i>
                    Configurez d'abord votre numéro de réception mobile money.
                    <a href="{{ route('payout-config.edit') }}" class="fw-bold d-block mt-2">
                        <i class="ri-settings-3-line me-1"></i>Configurer mon numéro →
                    </a>
                </div>
            </div>
            @else
            <form action="{{ route('payment-claims.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-4 py-3">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Devise du paiement <span class="text-danger">*</span></label>
                        <select name="currency" id="submitCurrency"
                                class="form-select rounded-3 @error('currency') is-invalid @enderror">
                            @foreach($sebpayLinks as $currency => $link)
                                <option value="{{ $currency }}" {{ old('currency') === $currency ? 'selected' : '' }}>
                                    {{ $currency }} — {{ $currencyLabels[$currency] ?? $currency }}
                                </option>
                            @endforeach
                        </select>
                        @error('currency')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">ID de Transaction <span class="text-danger">*</span></label>
                        <input type="text" name="transaction_id"
                               class="form-control rounded-3 @error('transaction_id') is-invalid @enderror"
                               value="{{ old('transaction_id') }}"
                               placeholder="Ex: TXN-XXXXXXXXXX">
                        @error('transaction_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Montant reçu <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" name="amount" step="1" min="1"
                                   class="form-control rounded-start-3 @error('amount') is-invalid @enderror"
                                   value="{{ old('amount') }}" placeholder="Ex: 5000">
                            <span class="input-group-text bg-light" id="currencyAddon">
                                {{ array_key_first($sebpayLinks) ?? 'XOF' }}
                            </span>
                        </div>
                        @error('amount')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Capture d'écran (preuve) <span class="text-danger">*</span></label>
                        <input type="file" name="screenshot" accept="image/*"
                               class="form-control rounded-3 @error('screenshot') is-invalid @enderror">
                        <div class="text-muted small mt-1">JPG, PNG — max 5 Mo</div>
                        @error('screenshot')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="rounded-3 p-2 small" style="background:#f0fdf4;border:1px solid #bbf7d0;">
                        <i class="ri-bank-card-line me-1 text-success"></i>
                        Virement vers : <strong>{{ $config->network }}</strong> · {{ $config->phone_number }}
                        @if($config->holder_name) · {{ $config->holder_name }}@endif
                        <a href="{{ route('payout-config.edit') }}" class="ms-2 small text-muted"><i class="ri-edit-line"></i></a>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn fw-semibold px-4 rounded-3 text-white" style="background:#e8521a;">
                        <i class="ri-send-plane-line me-2"></i>Envoyer
                    </button>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>

<style>
.hover-row:hover { background:#fafafa; }
.links-mobile { display:none; }
.links-desktop { display:block; }
.claims-mobile { display:none; }
.claims-desktop { display:block; }
@media (max-width: 640px) {
    .links-mobile { display:block; }
    .links-desktop { display:none; }
    .claims-mobile { display:block; }
    .claims-desktop { display:none; }
}
</style>

@push('scripts')
<script>
var pickedCurrency = null;

function openCreateLink() {
    pickedCurrency = null;
    document.getElementById('confirmBlock').style.display = 'none';
    document.getElementById('selectedCurrencyInput').value = '';
    document.querySelectorAll('[id^="card-"]').forEach(c => c.style.borderColor = '#eee');
    new bootstrap.Modal(document.getElementById('createLinkModal')).show();
}

function pickCurrency(currency) {
    pickedCurrency = currency;
    document.getElementById('selectedCurrencyInput').value = currency;

    // Highlight selected card
    document.querySelectorAll('[id^="card-"]').forEach(c => c.style.borderColor = '#eee');
    const card = document.getElementById('card-' + currency);
    if (card) card.style.borderColor = '#e8521a';

    // Show confirm block
    document.getElementById('confirmCurrencyLabel').textContent = currency;
    document.getElementById('confirmBlock').style.display = 'block';
}

function openSubmitModal(currency) {
    const sel = document.getElementById('submitCurrency');
    const addon = document.getElementById('currencyAddon');
    if (sel && currency) {
        sel.value = currency;
        if (addon) addon.textContent = currency;
    }
    new bootstrap.Modal(document.getElementById('submitModal')).show();
}

function copyAndShow(url, btn) {
    navigator.clipboard.writeText(url).then(() => {
        const orig = btn.innerHTML;
        btn.innerHTML = '<i class="ri-check-line" style="color:#16a34a;"></i>';
        setTimeout(() => btn.innerHTML = orig, 2000);
    });
}

document.getElementById('submitCurrency')?.addEventListener('change', function() {
    const addon = document.getElementById('currencyAddon');
    if (addon) addon.textContent = this.value;
});

@if($errors->has('transaction_id') || $errors->has('amount') || $errors->has('screenshot'))
document.addEventListener('DOMContentLoaded', () => openSubmitModal('{{ old('currency', array_key_first($sebpayLinks ?? [])) }}'));
@endif
</script>
@endpush
@endsection
