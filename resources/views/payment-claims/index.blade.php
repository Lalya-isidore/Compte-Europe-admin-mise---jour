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

{{-- Table liens --}}
<div class="bg-white rounded-4 shadow-sm overflow-hidden" style="border:1px solid #eee;">
    <table style="width:100%;border-collapse:collapse;">
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
                    <div style="font-family:monospace;font-size:.75rem;color:#aaa;margin-top:3px;">
                        {{ parse_url($link['url'], PHP_URL_PATH) }}
                    </div>
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
                        <button class="btn btn-sm btn-light rounded-2" title="Copier le lien"
                                onclick="copyAndShow('{{ addslashes($link['url']) }}', this)">
                            <i class="ri-file-copy-line"></i>
                        </button>
                        <button class="btn btn-sm btn-light rounded-2" title="Soumettre une preuve"
                                onclick="openSubmitModal('{{ $currency }}')"
                                style="color:#e8521a;">
                            <i class="ri-send-plane-line"></i>
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

    @if(count($sebpayLinks) > 0)
    <div style="padding:12px 20px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;border-top:1px solid #f0f0f0;">
        <span style="font-size:.82rem;color:#aaa;">
            {{ count($sebpayLinks) }} lien{{ count($sebpayLinks) > 1 ? 's' : '' }} actif{{ count($sebpayLinks) > 1 ? 's' : '' }}
        </span>
        <a href="{{ route('portfolio.index') }}" class="btn btn-sm fw-semibold text-white rounded-2" style="background:#e8521a;">
            Voir mes paiements
        </a>
    </div>
    @endif
</div>

{{-- Historique des demandes --}}
@if($claims->isNotEmpty())
<div class="mt-5">
    <h6 class="fw-bold mb-3 text-muted">Mes demandes de virement</h6>
    <div class="bg-white rounded-4 shadow-sm" style="border:1px solid #eee;">
        <div class="table-responsive">
            <table class="table table-hover align-middle small mb-0">
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
                    <tr>
                        <td class="px-4 fw-semibold" style="font-family:monospace;">{{ $claim->transaction_id }}</td>
                        <td class="fw-bold">{{ number_format($claim->amount, 0, ',', ' ') }}</td>
                        <td><span class="badge bg-secondary rounded-2">{{ $claim->currency }}</span></td>
                        <td>
                            @php
                                $netStyle = $claim->payout_network === 'MTN'
                                    ? 'background:#fff3cd;color:#856404'
                                    : ($claim->payout_network === 'MOOV'
                                        ? 'background:#cfe2ff;color:#0a58ca'
                                        : 'background:#f8d7da;color:#842029');
                            @endphp
                            <span class="badge rounded-pill px-2" style="{{ $netStyle }}">{{ $claim->payout_network }}</span>
                            <div class="text-muted smaller">{{ $claim->payout_phone }}</div>
                        </td>
                        <td>
                            @php
                                $map = ['pending'=>['#fff3cd','#856404','En attente'],'approved'=>['#cfe2ff','#0a58ca','Approuvée'],'paid'=>['#d1fae5','#065f46','Payée'],'rejected'=>['#f8d7da','#842029','Rejetée']];
                                $s = $map[$claim->status] ?? ['#eee','#555',$claim->status];
                            @endphp
                            <span class="badge rounded-pill px-2 fw-semibold"
                                  style="background:{{ $s[0] }};color:{{ $s[1] }};font-size:.75rem;">{{ $s[2] }}</span>
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
                                Vos clients pourront payer dans cette devise via SebPay.
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
