@extends('layouts.admin')

@section('title', 'Détails de la collecte')

@section('breadcrumb')
    <li class="breadcrumb-item"><i class="fas fa-briefcase me-1"></i>Outils</li>
    <li class="breadcrumb-item"><a href="{{ route('tools.coupon.index') }}">Collecte de code coupon</a></li>
    <li class="breadcrumb-item active">Détails</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-header bg-primary py-4 px-4 text-white border-0">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-white text-primary me-3">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0">Collecte {{ $collection->kind }}</h4>
                        <p class="mb-0 opacity-75">Créée le {{ $collection->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    <div class="ms-auto pt-2">
                        @if($collection->status == 'active')
                            <span class="badge bg-success rounded-pill px-4 py-2 border-0">ACTIVE</span>
                        @else
                            <span class="badge bg-secondary rounded-pill px-4 py-2 border-0">TERMINÉE / EXPIREE</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <label class="form-label fw-bold text-muted small text-uppercase">Lien de collecte public à partager avec votre client :</label>
                        <div class="input-group mb-3">
                            @php
                                $couponUrl = config('services.region.coupon_collect_url');
                                $publicLink = rtrim($couponUrl, '/') . '?c=' . $collection->token;
                            @endphp
                            <input type="text" class="form-control form-control-lg bg-light border-0" value="{{ $publicLink }}" readonly id="publicLink">
                            <button class="btn btn-primary px-4" type="button" onclick="copyLink()">
                                <i class="fas fa-copy me-2"></i>Copier
                            </button>
                        </div>
                        <p class="small text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Une fois que le client aura soumis son code sur ce lien, celui-ci expirera automatiquement pour des raisons de sécurité.
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end pt-3">
                        <a href="{{ $publicLink }}" target="_blank" class="btn btn-outline-primary btn-lg rounded-pill px-4">
                            <i class="fas fa-external-link-alt me-2"></i>Tester le lien
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-list me-2"></i>Codes coupons collectés
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Email Client</th>
                                <th>Type</th>
                                <th>Code Coupon</th>
                                <th>Montant</th>
                                <th>Statut</th>
                                <th>Collecté le</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($collection->coupons as $coupon)
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-semibold text-primary">{{ $coupon->client_email ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $collection->kind }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="code-badge bg-light text-dark fw-mono py-1 px-3 rounded-3 border me-2 small">
                                            {{ $coupon->code }}
                                        </div>
                                        <button class="btn btn-link btn-sm text-primary p-0" onclick="copyToClipboard('{{ $coupon->code }}')">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <b class="text-success">{{ $coupon->amount ?? '0.00' }}</b>
                                </td>
                                <td>
                                    @if($coupon->status == 'pending')
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3">En attente</span>
                                    @else
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">Validé</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ $coupon->created_at->format('d/m/Y H:i') }}</small>
                                </td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-sm btn-outline-dark rounded-pill px-3">
                                        <i class="fas fa-check me-1"></i>Utilisé
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="fas fa-hourglass-half fa-3x text-muted opacity-25"></i>
                                    </div>
                                    <p class="text-muted mb-0">Aucun code n'a encore été collecté via ce lien.</p>
                                    <small class="text-muted">Partagez le lien ci-dessus avec votre client pour commencer la collecte.</small>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyLink() {
    var copyText = document.getElementById("publicLink");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value);
    
    Swal.fire({
        icon: 'success',
        title: 'Lien copié !',
        text: 'Le lien de collecte a été copié dans votre presse-papier.',
        timer: 2000,
        showConfirmButton: false
    });
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text);
    Toastify({
        text: "Code copié !",
        duration: 2000,
        gravity: "bottom",
        position: "center",
        style: {
            background: "linear-gradient(to right, #4338ca, #6366f1)",
            borderRadius: "10px"
        }
    }).showToast();
}
</script>

<style>
    .icon-box {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 18px;
        font-size: 1.8rem;
    }
    .fw-mono {
        font-family: 'Roboto Mono', monospace;
        letter-spacing: 1px;
    }
    .code-badge {
        font-size: 1.1rem;
        min-width: 200px;
        text-align: center;
    }
    .bg-warning-subtle { background-color: #fef3c7; }
    .text-warning { color: #d97706 !important; }
</style>
@endsection
