@extends('layouts.admin')

@section('title', 'Gestion des Liens de Paiement')

@section('breadcrumb')
    <li class="breadcrumb-item active">Liens de Paiement</li>
@endsection

@section('content')

@if(session('success'))
    <div class="alert alert-success rounded-3 py-2 mb-4">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-danger rounded-3 py-2 mb-4">{{ $errors->first() }}</div>
@endif

{{-- Header --}}
<div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <h2 class="fw-bold mb-1" style="font-size:1.8rem;">Gestion des Liens de Paiement</h2>
        <p class="text-muted mb-0" style="font-size:.95rem;">Créez et gérez vos liens de paiement pour vos produits et services.</p>
    </div>
    <button class="btn fw-bold px-4 py-2 rounded-3 text-white"
            style="background:#e8521a;font-size:.95rem;"
            onclick="openCreateLink()">
        + &nbsp;Créer un lien
    </button>
</div>

{{-- Table liens --}}
<div class="bg-white rounded-4 shadow-sm" style="border:1px solid #eee;">
    {{-- Barre recherche --}}
    <div class="d-flex align-items-center justify-content-between p-3 border-bottom gap-3 flex-wrap">
        <div class="input-group" style="max-width:380px;">
            <span class="input-group-text bg-white border-end-0" style="border:1px solid #ddd;border-radius:24px 0 0 24px;">
                <i class="ri-search-line text-muted"></i>
            </span>
            <input type="text" class="form-control border-start-0 ps-1"
                   style="border:1px solid #ddd;border-left:none;border-radius:0 24px 24px 0;"
                   placeholder="Rechercher un lien...">
        </div>
        <button class="btn btn-outline-secondary rounded-3 px-3">
            <i class="ri-filter-line me-1"></i>Filtrer
        </button>
    </div>

    {{-- Entête tableau --}}
    <div class="row align-items-center px-4 py-2 border-bottom"
         style="background:#fafafa;font-size:.78rem;font-weight:700;text-transform:uppercase;color:#888;letter-spacing:.05em;">
        <div class="col-4">Titre</div>
        <div class="col-2">Montant</div>
        <div class="col-2">Statut</div>
        <div class="col-2">Date de création</div>
        <div class="col-2 text-end">Actions</div>
    </div>

    {{-- Ligne --}}
    @if($sebpayUrl)
    <div class="row align-items-center px-4 py-3 border-bottom hover-row">
        <div class="col-4">
            <div class="fw-bold" style="font-size:.95rem;">Paiement</div>
            <div class="text-muted small mt-1" style="font-family:monospace;font-size:.78rem;">
                {{ parse_url($sebpayUrl, PHP_URL_PATH) }}
            </div>
        </div>
        <div class="col-2">
            <span class="fw-bold">Min 1 FCFA</span>
        </div>
        <div class="col-2">
            <span class="badge rounded-pill px-3 py-1 fw-semibold"
                  style="background:#d1fae5;color:#065f46;font-size:.8rem;">ACTIF</span>
        </div>
        <div class="col-2 text-muted" style="font-size:.9rem;">
            {{ now()->format('d/m/Y') }}
        </div>
        <div class="col-2 d-flex justify-content-end gap-2">
            <button class="btn btn-sm btn-light rounded-2" title="Copier le lien" onclick="copyLink()">
                <i class="ri-file-copy-line"></i>
            </button>
            <button class="btn btn-sm btn-light rounded-2" title="Soumettre une preuve" onclick="openSubmitModal()"
                    style="color:#e8521a;">
                <i class="ri-send-plane-line"></i>
            </button>
        </div>
    </div>
    @else
    <div class="text-center py-5 text-muted">
        <i class="ri-link-unlink" style="font-size:2.5rem;opacity:.3;"></i>
        <p class="mt-3 mb-0">Aucun lien configuré. Contactez l'administrateur.</p>
    </div>
    @endif

    {{-- Pagination --}}
    <div class="px-4 py-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
        <span class="text-muted small">Affichage de <strong>1</strong> à <strong>1</strong> sur <strong>1</strong> résultats</span>
        <div class="d-flex gap-1">
            <button class="btn btn-sm btn-light rounded-2 disabled"><i class="ri-arrow-left-s-line"></i></button>
            <button class="btn btn-sm rounded-2 text-white fw-bold" style="background:#e8521a;min-width:32px;">1</button>
            <button class="btn btn-sm btn-light rounded-2 disabled"><i class="ri-arrow-right-s-line"></i></button>
        </div>
    </div>
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
                        <td class="fw-bold">{{ number_format($claim->amount, 0, ',', ' ') }} FCFA</td>
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
                            @php $map = ['pending'=>['#fff3cd','#856404','En attente'],'approved'=>['#cfe2ff','#0a58ca','Approuvée'],'paid'=>['#d1fae5','#065f46','Payée'],'rejected'=>['#f8d7da','#842029','Rejetée']]; $s=$map[$claim->status]??['#eee','#555',$claim->status]; @endphp
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

{{-- Modal : affichage lien généré --}}
<div class="modal fade" id="createLinkModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:480px;">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pt-4 px-4">
                <div>
                    <h5 class="modal-title fw-bold mb-1">🔗 Votre lien de paiement</h5>
                    <p class="text-muted small mb-0">Partagez ce lien avec vos clients pour recevoir des paiements.</p>
                </div>
                <button class="btn-close ms-3" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 py-3">
                @if($sebpayUrl)
                    <div class="bg-light rounded-3 p-3 d-flex align-items-center gap-2">
                        <code class="flex-grow-1 text-break small" id="linkToCopy">{{ $sebpayUrl }}</code>
                        <button class="btn btn-sm fw-semibold text-white flex-shrink-0 rounded-2"
                                style="background:#e8521a;" onclick="copyLink()">
                            <i class="ri-file-copy-line me-1"></i>Copier
                        </button>
                    </div>
                    <div id="copyFeedback" class="text-success small mt-2 d-none">
                        <i class="ri-check-line me-1"></i>Lien copié !
                    </div>
                    <div class="mt-3 p-3 rounded-3" style="background:#fff3cd;border:1px solid #ffc107;">
                        <div class="small fw-semibold mb-1">📋 Instructions pour vos clients :</div>
                        <ol class="small mb-0 ps-3" style="line-height:1.8;">
                            <li>Cliquer sur votre lien de paiement</li>
                            <li>Effectuer le paiement</li>
                            <li>Vous envoyer la <strong>capture d'écran</strong> + l'<strong>ID de transaction</strong></li>
                        </ol>
                    </div>
                    <div class="mt-3 border-top pt-3">
                        <button class="btn fw-semibold w-100 rounded-3 text-white"
                                style="background:#1e3a5f;"
                                onclick="bootstrap.Modal.getInstance(document.getElementById('createLinkModal')).hide(); openSubmitModal();">
                            <i class="ri-send-plane-line me-2"></i>J'ai reçu une preuve → Soumettre
                        </button>
                    </div>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="ri-time-line" style="font-size:2rem;opacity:.4;"></i>
                        <p class="mt-2 mb-0 small">Le lien est en cours de configuration par l'administrateur.</p>
                    </div>
                @endif
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
                        <label class="form-label fw-semibold small">ID de Transaction <span class="text-danger">*</span></label>
                        <input type="text" name="transaction_id"
                               class="form-control rounded-3 @error('transaction_id') is-invalid @enderror"
                               value="{{ old('transaction_id') }}"
                               placeholder="Ex: TXN-XXXXXXXXXX">
                        @error('transaction_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Montant reçu (FCFA) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" name="amount" step="1" min="1"
                                   class="form-control rounded-start-3 @error('amount') is-invalid @enderror"
                                   value="{{ old('amount') }}" placeholder="Ex: 5000">
                            <span class="input-group-text bg-light">FCFA</span>
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
                        <a href="{{ route('payout-config.edit') }}" class="ms-2 small text-muted">
                            <i class="ri-edit-line"></i>
                        </a>
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
.hover-row:hover { background: #fafafa; }
</style>

@push('scripts')
<script>
function openCreateLink() {
    new bootstrap.Modal(document.getElementById('createLinkModal')).show();
}
function openSubmitModal() {
    new bootstrap.Modal(document.getElementById('submitModal')).show();
}
function copyLink() {
    const txt = document.getElementById('linkToCopy')?.textContent?.trim();
    if (!txt) return;
    navigator.clipboard.writeText(txt).then(() => {
        const fb = document.getElementById('copyFeedback');
        if (fb) { fb.classList.remove('d-none'); setTimeout(() => fb.classList.add('d-none'), 2500); }
    });
}
// Ouvrir auto le modal de soumission si erreur de validation
@if($errors->any())
document.addEventListener('DOMContentLoaded', () => openSubmitModal());
@endif
</script>
@endpush
@endsection
