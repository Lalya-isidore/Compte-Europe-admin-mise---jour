@extends('layouts.admin')

@section('title', 'Gestion du Portefeuille')

@section('breadcrumb')
    <li class="breadcrumb-item active">Portefeuille</li>
@endsection

@section('content')

@if(session('success'))
    <div class="alert alert-success rounded-3 py-2 mb-4">{{ session('success') }}</div>
@endif

{{-- Header --}}
<div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <h2 class="fw-bold mb-1" style="font-size:1.8rem;">Gestion du Portefeuille</h2>
        <p class="text-muted mb-0" style="font-size:.95rem;">Suivez vos soldes et gérez vos moyens de retrait.</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary rounded-3 px-3"><i class="ri-filter-line me-1"></i>Filtrer</button>
        <button class="btn btn-outline-secondary rounded-3 px-3"><i class="ri-download-line me-1"></i>Exporter en Excel</button>
    </div>
</div>

{{-- Stat cards --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:32px;">

    {{-- Solde Total --}}
    <div class="bg-white rounded-4 shadow-sm p-4" style="border:1px solid #eee;">
        <div style="width:44px;height:44px;border-radius:50%;background:#f3f4f6;display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
            <i class="ri-money-dollar-circle-line" style="font-size:1.3rem;color:#555;"></i>
        </div>
        <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;color:#aaa;letter-spacing:.06em;margin-bottom:6px;">Solde Total</div>
        <div style="font-size:1.6rem;font-weight:800;color:#111;">{{ number_format($totalBalance, 2) }} <span style="font-size:.9rem;font-weight:600;color:#888;">XOF</span></div>
        <div style="font-size:.72rem;color:#aaa;margin-top:8px;text-transform:uppercase;letter-spacing:.04em;">
            <span style="width:8px;height:8px;border-radius:50%;background:#aaa;display:inline-block;margin-right:4px;"></span>
            Transactions approuvées
        </div>
    </div>

    {{-- Solde Disponible --}}
    <div class="bg-white rounded-4 shadow-sm p-4" style="border:1px solid #eee;">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;">
            <div style="width:44px;height:44px;border-radius:50%;background:#f3e8ff;display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
                <i class="ri-wallet-3-line" style="font-size:1.3rem;color:#9333ea;"></i>
            </div>
            <i class="ri-arrow-right-up-line" style="color:#9333ea;font-size:1.1rem;"></i>
        </div>
        <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;color:#aaa;letter-spacing:.06em;margin-bottom:6px;">Solde Disponible</div>
        <div style="font-size:1.6rem;font-weight:800;color:#9333ea;">{{ number_format($availableBalance, 2) }} <span style="font-size:.9rem;font-weight:600;">XOF</span></div>
        <div style="font-size:.72rem;color:#9333ea;margin-top:8px;text-transform:uppercase;letter-spacing:.04em;">
            <span style="width:8px;height:8px;border-radius:50%;background:#9333ea;display:inline-block;margin-right:4px;"></span>
            Disponible
        </div>
    </div>

    {{-- Retrait en attente --}}
    <div class="bg-white rounded-4 shadow-sm p-4" style="border:1px solid #eee;">
        <div style="width:44px;height:44px;border-radius:50%;background:#fef3c7;display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
            <i class="ri-time-line" style="font-size:1.3rem;color:#d97706;"></i>
        </div>
        <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;color:#aaa;letter-spacing:.06em;margin-bottom:6px;">Retrait en attente</div>
        <div style="font-size:1.6rem;font-weight:800;color:#d97706;">{{ number_format($pendingBalance, 0) }} <span style="font-size:.9rem;font-weight:600;">XOF</span></div>
        <div style="font-size:.72rem;color:#d97706;margin-top:8px;text-transform:uppercase;letter-spacing:.04em;">
            <span style="width:8px;height:8px;border-radius:50%;background:#d97706;display:inline-block;margin-right:4px;"></span>
            Demandes en attente
        </div>
    </div>

    {{-- Solde Retiré --}}
    <div class="bg-white rounded-4 shadow-sm p-4" style="border:1px solid #eee;">
        <div style="width:44px;height:44px;border-radius:50%;background:#d1fae5;display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
            <i class="ri-piggy-bank-line" style="font-size:1.3rem;color:#059669;"></i>
        </div>
        <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;color:#aaa;letter-spacing:.06em;margin-bottom:6px;">Solde Retiré</div>
        <div style="font-size:1.6rem;font-weight:800;color:#059669;">{{ number_format($withdrawnBalance, 2) }} <span style="font-size:.9rem;font-weight:600;">XOF</span></div>
        <div style="font-size:.72rem;color:#059669;margin-top:8px;text-transform:uppercase;letter-spacing:.04em;">
            <span style="width:8px;height:8px;border-radius:50%;background:#059669;display:inline-block;margin-right:4px;"></span>
            Demandes validées
        </div>
    </div>

</div>

{{-- Contenu principal --}}
<div style="display:grid;grid-template-columns:1fr 320px;gap:24px;align-items:start;" class="portfolio-grid">

    {{-- Historique --}}
    <div>
        <div class="bg-white rounded-4 shadow-sm overflow-hidden" style="border:1px solid #eee;">
            <div style="padding:20px 24px 0;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
                <div class="d-flex align-items-center gap-2">
                    <i class="ri-history-line" style="color:#e8521a;font-size:1.1rem;"></i>
                    <span class="fw-bold" style="font-size:1rem;">Historique des Retraits</span>
                </div>
                <div style="position:relative;">
                    <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#bbb;">
                        <i class="ri-search-line"></i>
                    </span>
                    <input type="text" style="padding:8px 12px 8px 34px;border:1px solid #eee;border-radius:24px;font-size:.85rem;width:200px;outline:none;" placeholder="Rechercher...">
                </div>
            </div>

            <table style="width:100%;border-collapse:collapse;margin-top:16px;">
                <thead>
                    <tr style="font-size:.72rem;font-weight:700;text-transform:uppercase;color:#bbb;letter-spacing:.06em;border-bottom:1px solid #f0f0f0;">
                        <th style="padding:10px 24px;text-align:left;">ID</th>
                        <th style="padding:10px 16px;text-align:left;">Montant</th>
                        <th style="padding:10px 16px;text-align:left;">Statut</th>
                        <th style="padding:10px 16px;text-align:left;">Date de création</th>
                        <th style="padding:10px 24px;text-align:left;">Vers</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($history as $claim)
                    @php
                        $statusMap = [
                            'pending'  => ['label'=>'En attente','bg'=>'#fef3c7','color'=>'#d97706'],
                            'approved' => ['label'=>'Approuvé','bg'=>'#dbeafe','color'=>'#2563eb'],
                            'paid'     => ['label'=>'Payé','bg'=>'#d1fae5','color'=>'#059669'],
                            'rejected' => ['label'=>'Rejeté','bg'=>'#fee2e2','color'=>'#dc2626'],
                        ];
                        $st = $statusMap[$claim->status] ?? ['label'=>$claim->status,'bg'=>'#f0f0f0','color'=>'#555'];
                    @endphp
                    <tr style="{{ !$loop->last ? 'border-bottom:1px solid #f8f8f8;' : '' }}">
                        <td style="padding:14px 24px;font-size:.82rem;color:#aaa;font-family:monospace;">#{{ $claim->id }}</td>
                        <td style="padding:14px 16px;font-weight:700;font-size:.95rem;">{{ number_format($claim->amount, 2) }} <span style="font-size:.75rem;color:#aaa;">{{ $claim->currency }}</span></td>
                        <td style="padding:14px 16px;">
                            <span style="padding:3px 10px;border-radius:20px;font-size:.75rem;font-weight:700;background:{{ $st['bg'] }};color:{{ $st['color'] }};">
                                {{ $st['label'] }}
                            </span>
                        </td>
                        <td style="padding:14px 16px;color:#aaa;font-size:.85rem;">{{ $claim->created_at->format('d/m/Y') }}</td>
                        <td style="padding:14px 24px;font-size:.82rem;color:#555;">
                            {{ $claim->payout_network }} · {{ $claim->payout_phone }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding:50px;text-align:center;color:#ccc;font-style:italic;">Aucun retrait trouvé</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            @if($history->hasPages())
                <div class="px-4 py-3">{{ $history->links() }}</div>
            @endif
        </div>
    </div>

    {{-- Sidebar droite --}}
    <div style="display:flex;flex-direction:column;gap:20px;">

        {{-- Card Retraits Instantanés --}}
        <div style="background:#1e2937;border-radius:20px;padding:28px 24px;color:#fff;position:relative;overflow:hidden;">
            <div style="position:absolute;top:-20px;right:-20px;width:100px;height:100px;border-radius:50%;border:30px solid rgba(255,255,255,.05);"></div>
            <div style="position:absolute;bottom:-30px;right:20px;width:60px;height:60px;border-radius:50%;border:20px solid rgba(255,255,255,.05);"></div>
            <div style="font-size:1.3rem;font-weight:800;margin-bottom:10px;position:relative;">
                Retraits Instantanés
                <i class="ri-arrow-right-up-line ms-1" style="font-size:1rem;"></i>
            </div>
            <p style="font-size:.82rem;color:#94a3b8;line-height:1.6;margin-bottom:20px;position:relative;">
                Le délai de retrait est de 24h. Passé ce délai, contactez le support.
            </p>
            <a href="{{ route('payment-claims.index') }}"
               style="display:block;background:#e8521a;color:#fff;text-align:center;padding:12px;border-radius:12px;font-weight:700;font-size:.9rem;text-decoration:none;position:relative;">
                Demander un retrait
            </a>
        </div>

        {{-- Moyens de Paiement --}}
        <div class="bg-white rounded-4 shadow-sm p-4" style="border:1px solid #eee;">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <i class="ri-bank-card-line" style="color:#e8521a;"></i>
                        <span class="fw-bold" style="font-size:.95rem;">Moyens de Paiement</span>
                    </div>
                    <p class="text-muted small mb-0">Suivez vos soldes et gérez vos moyens de retrait.</p>
                </div>
                <button class="btn btn-sm fw-bold text-white rounded-3"
                        style="background:#e8521a;white-space:nowrap;"
                        onclick="openAddMethod()">
                    + Ajouter un moyen
                </button>
            </div>

            @forelse($payoutMethods as $method)
            <div style="display:flex;align-items:center;justify-content:space-between;padding:12px;border:1px solid #f0f0f0;border-radius:12px;margin-bottom:10px;">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:40px;height:40px;border-radius:10px;background:#fff7ed;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="ri-smartphone-line" style="color:#e8521a;font-size:1.1rem;"></i>
                    </div>
                    <div>
                        <div style="font-weight:700;font-size:.88rem;">{{ $method->holder_name }}</div>
                        <div style="font-size:.78rem;color:#aaa;font-family:monospace;">{{ $method->phone_number }}</div>
                        <div style="font-size:.72rem;color:#9333ea;margin-top:2px;">{{ $method->operator }}</div>
                    </div>
                </div>
                <form action="{{ route('portfolio.delete-method', $method->id) }}" method="POST"
                      onsubmit="return confirm('Supprimer ce moyen ?')" style="margin:0;">
                    @csrf @method('DELETE')
                    <button type="submit" style="border:none;background:none;color:#ddd;cursor:pointer;padding:4px;">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </form>
            </div>
            @empty
                <div class="text-center py-3 text-muted small">
                    Aucun moyen de paiement configuré.
                </div>
            @endforelse
        </div>

    </div>

</div>

{{-- Modal : Ajouter un moyen --}}
<div class="modal fade" id="addMethodModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:440px;">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Ajouter un moyen</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('portfolio.add-method') }}" method="POST">
                @csrf
                <div class="modal-body px-4 py-3">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Opérateur Mobile Money <span class="text-danger">*</span></label>
                        <select name="operator" class="form-select rounded-3 @error('operator') is-invalid @enderror">
                            <option value="">Choisir un opérateur</option>
                            @foreach(\App\Models\PayoutMethod::OPERATORS as $op)
                                <option value="{{ $op }}" {{ old('operator') === $op ? 'selected' : '' }}>{{ $op }}</option>
                            @endforeach
                        </select>
                        @error('operator')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Nom complet <span class="text-danger">*</span></label>
                        <input type="text" name="holder_name"
                               class="form-control rounded-3 @error('holder_name') is-invalid @enderror"
                               value="{{ old('holder_name') }}" placeholder="Ex: Mon numéro MTN">
                        @error('holder_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Numéro / Identifiant <span class="text-danger">*</span></label>
                        <input type="text" name="phone_number"
                               class="form-control rounded-3 @error('phone_number') is-invalid @enderror"
                               value="{{ old('phone_number') }}" placeholder="+229 00 00 00 00">
                        @error('phone_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn fw-bold px-4 rounded-3 text-white" style="background:#e8521a;">
                        Ajouter un moyen
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
@media (max-width: 900px) {
    .portfolio-grid { grid-template-columns: 1fr !important; }
}
</style>

@push('scripts')
<script>
function openAddMethod() {
    new bootstrap.Modal(document.getElementById('addMethodModal')).show();
}
@if($errors->has('operator') || $errors->has('holder_name') || $errors->has('phone_number'))
document.addEventListener('DOMContentLoaded', () => openAddMethod());
@endif
</script>
@endpush
@endsection
