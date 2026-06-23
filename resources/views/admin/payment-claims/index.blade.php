@extends('admin.layout')

@section('title', 'Demandes de paiement SebPay')

@section('content')

<div class="mb-5">
    <h2 class="fw-bold h3 mb-2">Demandes de paiement SebPay 💳</h2>
    <p class="text-secondary">Vérifiez les preuves de paiement et virez les fonds en mobile money.</p>
</div>

@if(session('success'))
    <div class="alert alert-success rounded-3 py-2 mb-4">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger rounded-3 py-2 mb-4">{{ session('error') }}</div>
@endif

{{-- Compteurs --}}
<div class="row g-3 mb-5">
    @php
        $tabs = [
            'pending'  => ['label' => 'En attente', 'color' => 'warning', 'icon' => 'clock'],
            'approved' => ['label' => 'Approuvées', 'color' => 'info',    'icon' => 'check-circle'],
            'paid'     => ['label' => 'Payées',     'color' => 'success', 'icon' => 'dollar-sign'],
            'rejected' => ['label' => 'Rejetées',   'color' => 'danger',  'icon' => 'x-circle'],
        ];
    @endphp
    @foreach($tabs as $key => $tab)
    <div class="col-6 col-lg-3">
        <a href="{{ request()->fullUrlWithQuery(['status' => $key]) }}"
           class="card-premium stat-card text-decoration-none border-start border-{{ $tab['color'] }} border-4 {{ $status === $key ? 'shadow' : '' }}">
            <div class="stat-info">
                <h3>{{ $counts[$key] }}</h3>
                <p>{{ $tab['label'] }}</p>
            </div>
            <div class="stat-icon text-{{ $tab['color'] }}">
                <i data-lucide="{{ $tab['icon'] }}" style="width:28px;height:28px;"></i>
            </div>
        </a>
    </div>
    @endforeach
</div>

{{-- Table --}}
<div class="card-premium">
    @if($claims->isEmpty())
        <div class="text-center py-5 text-secondary">
            <i data-lucide="inbox" style="width:48px;height:48px;" class="opacity-25 mb-3"></i>
            <p>Aucune demande {{ $status !== 'all' ? '"'.$status.'"' : '' }} pour le moment.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Utilisateur</th>
                        <th>ID Transaction</th>
                        <th>Montant</th>
                        <th>Virement vers</th>
                        <th>Preuve</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($claims as $claim)
                <tr>
                    <td>
                        <div class="fw-semibold">{{ $claim->user->prenom ?? '' }} {{ $claim->user->nom ?? '' }}</div>
                        <div class="text-secondary smaller">{{ $claim->user->email ?? '' }}</div>
                    </td>
                    <td>
                        <code class="bg-light rounded px-2 py-1 small">{{ $claim->transaction_id }}</code>
                    </td>
                    <td class="fw-bold">{{ number_format($claim->amount, 0, ',', ' ') }} FCFA</td>
                    <td>
                        <span class="badge rounded-pill px-2"
                              style="background:{{ $claim->payout_network==='MTN'?'#FFCC00':($claim->payout_network==='MOOV'?'#0070C0':'#E30613') }};color:{{ $claim->payout_network==='MTN'?'#333':'#fff' }}">
                            {{ $claim->payout_network }}
                        </span>
                        <div class="small mt-1">{{ $claim->payout_phone }}</div>
                        @if($claim->payout_holder)<div class="text-muted smaller">{{ $claim->payout_holder }}</div>@endif
                    </td>
                    <td>
                        @if($claim->screenshot_path)
                            <a href="{{ asset('storage/'.$claim->screenshot_path) }}" target="_blank"
                               class="btn btn-sm btn-outline-secondary rounded-2">
                                <i data-lucide="image" style="width:14px;"></i> Voir
                            </a>
                        @else
                            <span class="text-muted smaller">—</span>
                        @endif
                    </td>
                    <td class="text-secondary smaller">{{ $claim->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($claim->isPending())
                            {{-- Approuver --}}
                            <button class="btn btn-sm btn-success rounded-2 me-1"
                                    onclick="openApprove({{ $claim->id }})">
                                <i data-lucide="check" style="width:13px;"></i> Approuver
                            </button>
                            {{-- Rejeter --}}
                            <button class="btn btn-sm btn-outline-danger rounded-2"
                                    onclick="openReject({{ $claim->id }})">
                                <i data-lucide="x" style="width:13px;"></i> Rejeter
                            </button>

                        @elseif($claim->isApproved())
                            <form action="{{ route('admin.paymentClaims.markPaid', $claim) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-primary rounded-2">
                                    <i data-lucide="banknote" style="width:13px;"></i> Marquer payé
                                </button>
                            </form>

                        @elseif($claim->isPaid())
                            <span class="badge bg-success rounded-pill px-2">✅ Payé</span>
                            @if($claim->paid_at)<div class="text-muted smaller">{{ $claim->paid_at->format('d/m H:i') }}</div>@endif

                        @elseif($claim->isRejected())
                            <span class="badge bg-danger bg-opacity-15 text-danger rounded-pill px-2">Rejeté</span>
                            @if($claim->rejection_reason)
                                <div class="text-muted smaller mt-1" title="{{ $claim->rejection_reason }}">
                                    {{ \Str::limit($claim->rejection_reason, 40) }}
                                </div>
                            @endif
                        @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $claims->withQueryString()->links() }}</div>
    @endif
</div>

@push('modals')
{{-- Modal Approuver --}}
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:400px;">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pt-4 px-4">
                <h6 class="modal-title fw-bold">✅ Approuver la demande</h6>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="approveForm" method="POST">
                @csrf
                <div class="modal-body px-4 py-2">
                    <label class="form-label small fw-semibold">Note admin <span class="text-muted fw-normal">(optionnel)</span></label>
                    <textarea name="admin_note" class="form-control rounded-3" rows="3"
                              placeholder="Ex: Virement de 5000 FCFA envoyé sur MTN 97XXXXXX"></textarea>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success rounded-3 fw-semibold px-4">Approuver</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Rejeter --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:400px;">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pt-4 px-4">
                <h6 class="modal-title fw-bold text-danger">✗ Rejeter la demande</h6>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm" method="POST" novalidate>
                @csrf
                <div class="modal-body px-4 py-2">
                    <label class="form-label small fw-semibold">Motif du rejet <span class="text-danger">*</span></label>
                    <textarea id="rejectReason" name="rejection_reason" class="form-control rounded-3" rows="3"
                              placeholder="Ex: ID de transaction introuvable dans SebPay"></textarea>
                    <div id="rejectError" class="text-danger small mt-1" style="display:none;">Le motif est obligatoire.</div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger rounded-3 fw-semibold px-4" onclick="submitReject()">Rejeter</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var approveModal = new bootstrap.Modal(document.getElementById('approveModal'), {backdrop: 'static', keyboard: false});
    var rejectModal  = new bootstrap.Modal(document.getElementById('rejectModal'),  {backdrop: 'static', keyboard: false});

    window.openApprove = function(id) {
        document.getElementById('approveForm').action = '/admin/payment-claims/' + id + '/approve';
        approveModal.show();
    };
    window.openReject = function(id) {
        document.getElementById('rejectReason').value = '';
        document.getElementById('rejectError').style.display = 'none';
        document.getElementById('rejectForm').action = '/admin/payment-claims/' + id + '/reject';
        rejectModal.show();
    };
    window.submitReject = function() {
        var reason = document.getElementById('rejectReason').value.trim();
        if (!reason) {
            document.getElementById('rejectError').style.display = 'block';
            document.getElementById('rejectReason').focus();
            return;
        }
        document.getElementById('rejectError').style.display = 'none';
        document.getElementById('rejectForm').submit();
    };
});
</script>
@endpush
@endsection
