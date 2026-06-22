@extends('layouts.admin')

@section('title', 'Encaissement SebPay')

@section('breadcrumb')
    <li class="breadcrumb-item"><i class="fas fa-link me-1"></i>Encaissement</li>
    <li class="breadcrumb-item active">SebPay</li>
@endsection

@section('content')
<div class="container-fluid px-0">

    {{-- Lien SebPay --}}
    <div class="card border-0 rounded-4 shadow-sm mb-4" style="background:linear-gradient(135deg,#ff6b35,#f7931e);">
        <div class="card-body p-4 text-white">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <h5 class="fw-bold mb-1"><i class="fas fa-link me-2"></i>Votre lien de paiement</h5>
                    <p class="mb-2 opacity-75 small">Partagez ce lien avec vos clients pour recevoir des paiements.</p>
                    @if($sebpayUrl)
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <code class="bg-white bg-opacity-25 rounded-2 px-2 py-1 small text-white" id="sebpayLink">{{ $sebpayUrl }}</code>
                            <button class="btn btn-sm btn-light text-dark rounded-2 fw-semibold" onclick="copySebpay()">
                                <i class="fas fa-copy me-1"></i>Copier
                            </button>
                        </div>
                    @else
                        <span class="opacity-75 small"><i class="fas fa-clock me-1"></i>Lien en cours de configuration par l'admin…</span>
                    @endif
                </div>
                @if($config)
                    <div class="text-end">
                        <div class="small opacity-75 mb-1">Réception sur</div>
                        <div class="fw-bold">{{ $config->network }} · {{ $config->phone_number }}</div>
                        @if($config->holder_name)<div class="small opacity-75">{{ $config->holder_name }}</div>@endif
                        <a href="{{ route('payout-config.edit') }}" class="btn btn-sm btn-light text-dark mt-2 rounded-2">
                            <i class="fas fa-edit me-1"></i>Modifier
                        </a>
                    </div>
                @else
                    <a href="{{ route('payout-config.edit') }}" class="btn btn-light text-dark fw-semibold rounded-3">
                        <i class="fas fa-mobile-alt me-2"></i>Configurer mon numéro
                    </a>
                @endif
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-3 py-2 mb-4">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger rounded-3 py-2 mb-4">{{ $errors->first() }}</div>
    @endif

    <div class="row g-4">

        {{-- Formulaire de soumission --}}
        <div class="col-lg-5">
            <div class="card border-0 rounded-4 shadow-sm h-100">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3"><i class="fas fa-paper-plane text-primary me-2"></i>Soumettre une preuve de paiement</h6>

                    @if(!$config)
                        <div class="alert alert-warning rounded-3 small py-2">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Configurez d'abord votre numéro de réception mobile money.
                            <a href="{{ route('payout-config.edit') }}" class="fw-bold">Configurer →</a>
                        </div>
                    @else
                        <form action="{{ route('payment-claims.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-semibold small">ID de Transaction SebPay <span class="text-danger">*</span></label>
                                <input type="text" name="transaction_id"
                                       class="form-control rounded-3 @error('transaction_id') is-invalid @enderror"
                                       value="{{ old('transaction_id') }}"
                                       placeholder="Ex: TXN-XXXXXXXXXX">
                                @error('transaction_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Montant reçu (XOF) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="amount" step="1" min="1"
                                           class="form-control rounded-start-3 @error('amount') is-invalid @enderror"
                                           value="{{ old('amount') }}" placeholder="Ex: 5000">
                                    <span class="input-group-text bg-light">FCFA</span>
                                </div>
                                @error('amount')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold small">Capture d'écran (preuve) <span class="text-danger">*</span></label>
                                <input type="file" name="screenshot" accept="image/*"
                                       class="form-control rounded-3 @error('screenshot') is-invalid @enderror">
                                <div class="text-muted small mt-1">JPG, PNG, WEBP — max 5 Mo</div>
                                @error('screenshot')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="bg-light rounded-3 p-3 mb-4 small">
                                <div class="fw-semibold mb-1">Virement vers :</div>
                                <span class="badge" style="background:{{ $config->network==='MTN'?'#FFCC00':($config->network==='MOOV'?'#0070C0':'#E30613') }};color:{{ $config->network==='MTN'?'#333':'#fff' }}">
                                    {{ $config->network }}
                                </span>
                                <span class="ms-2">{{ $config->phone_number }}</span>
                                @if($config->holder_name)<span class="text-muted ms-1">· {{ $config->holder_name }}</span>@endif
                            </div>

                            <button type="submit" class="btn btn-primary rounded-3 px-4 fw-semibold w-100">
                                <i class="fas fa-upload me-2"></i>Envoyer la demande
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        {{-- Historique --}}
        <div class="col-lg-7">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3"><i class="fas fa-history text-secondary me-2"></i>Mes demandes</h6>

                    @if($claims->isEmpty())
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fa-2x mb-3 opacity-25"></i>
                            <p class="mb-0">Aucune demande pour le moment.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle small mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID Transaction</th>
                                        <th>Montant</th>
                                        <th>Statut</th>
                                        <th>Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($claims as $claim)
                                    <tr>
                                        <td class="fw-semibold">{{ $claim->transaction_id }}</td>
                                        <td class="fw-bold">{{ number_format($claim->amount, 0, ',', ' ') }} FCFA</td>
                                        <td>
                                            @php
                                                $badge = match($claim->status) {
                                                    'pending'  => ['warning', 'En attente'],
                                                    'approved' => ['info',    'Approuvée'],
                                                    'paid'     => ['success', 'Payée'],
                                                    'rejected' => ['danger',  'Rejetée'],
                                                    default    => ['secondary', $claim->status],
                                                };
                                            @endphp
                                            <span class="badge bg-{{ $badge[0] }} bg-opacity-15 text-{{ $badge[0] }} rounded-pill px-2">
                                                {{ $badge[1] }}
                                            </span>
                                            @if($claim->isRejected() && $claim->rejection_reason)
                                                <i class="fas fa-info-circle text-danger ms-1"
                                                   title="{{ $claim->rejection_reason }}"
                                                   data-bs-toggle="tooltip"></i>
                                            @endif
                                        </td>
                                        <td class="text-muted">{{ $claim->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            @if($claim->screenshot_path)
                                                <a href="{{ asset('storage/'.$claim->screenshot_path) }}" target="_blank"
                                                   class="btn btn-sm btn-outline-secondary rounded-2">
                                                    <i class="fas fa-image"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">{{ $claims->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function copySebpay() {
    const txt = document.getElementById('sebpayLink')?.textContent?.trim();
    if (!txt) return;
    navigator.clipboard.writeText(txt).then(() => {
        const btn = event.target.closest('button');
        const orig = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check me-1"></i>Copié !';
        setTimeout(() => btn.innerHTML = orig, 2000);
    });
}
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));
});
</script>
@endpush
@endsection
