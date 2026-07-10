@extends('admin.layout')

@section('title', 'Vérification SMS')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold h3 mb-1"><i data-lucide="shield-check" style="width:28px;height:28px" class="me-2"></i>Vérification SMS</h2>
    <p class="text-secondary">SMS en attente d'envoi vers Infobip. Vérifiez l'expéditeur et le contenu avant d'envoyer.</p>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        @if($pending->isEmpty())
            <div class="text-center py-5 text-secondary">
                <i data-lucide="check-circle-2" style="width:48px;height:48px;opacity:.4"></i>
                <p class="mt-3">Aucun SMS en attente de vérification.</p>
            </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle" style="font-size:.9rem;">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Utilisateur</th>
                        <th>Expéditeur</th>
                        <th>Destinataire</th>
                        <th>Message</th>
                        <th>Crédits</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pending as $i => $sms)
                    <tr>
                        <td class="text-secondary fw-bold">{{ $pending->firstItem() + $i }}</td>
                        <td>
                            @if($sms->user)
                                <a href="{{ route('admin.users.show', $sms->user_id) }}" class="text-decoration-none fw-semibold">
                                    {{ $sms->user->prenom ?? '' }} {{ $sms->user->nom ?? $sms->user->email }}
                                </a>
                                <div class="text-muted" style="font-size:.78rem;">{{ $sms->user->email }}</div>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td><code>{{ $sms->expediteur ?? '—' }}</code></td>
                        <td>
                            <code>{{ $sms->destinataire }}</code>
                            <span class="badge bg-secondary ms-1">{{ $sms->pays ?? '' }}</span>
                        </td>
                        <td style="min-width:220px;max-width:320px;">
                            <div style="white-space:pre-wrap;word-break:break-word;background:#f8fafc;border:1px solid #e2e8f0;border-radius:6px;padding:8px 10px;font-size:.85rem;color:#1e293b;line-height:1.6;">{{ $sms->message }}</div>
                            <div class="text-muted mt-1" style="font-size:.75rem;">{{ $sms->sms_count }} segment(s)</div>
                        </td>
                        <td class="fw-semibold">{{ number_format($sms->credits_used) }}</td>
                        <td class="text-muted" style="white-space:nowrap;">{{ $sms->created_at->setTimezone('Europe/Paris')->format('d/m/Y H:i') }}</td>
                        <td style="min-width:220px;">
                            {{-- Bouton Envoyer --}}
                            <form action="{{ route('admin.sms.dispatch', $sms->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Envoyer ce SMS à Infobip ?')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success mb-1">
                                    <i data-lucide="send" style="width:14px;height:14px" class="me-1"></i>Envoyer
                                </button>
                            </form>

                            {{-- Bouton Rejeter --}}
                            <button type="button" class="btn btn-sm btn-outline-danger mb-1"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#reject-form-{{ $sms->id }}">
                                <i data-lucide="x-circle" style="width:14px;height:14px" class="me-1"></i>Rejeter
                            </button>

                            <div class="collapse mt-2" id="reject-form-{{ $sms->id }}">
                                <form action="{{ route('admin.sms.reject', $sms->id) }}" method="POST">
                                    @csrf
                                    <textarea name="reason" rows="2" class="form-control form-control-sm mb-1"
                                              placeholder="Motif du rejet visible par l'utilisateur..." required
                                              style="font-size:.82rem;"></textarea>
                                    <button type="submit" class="btn btn-sm btn-danger w-100"
                                            onclick="return confirm('Rejeter et rembourser les crédits ?')">
                                        Confirmer le rejet
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($pending->hasPages())
        <div class="px-4 py-3 border-top">
            {{ $pending->links() }}
        </div>
        @endif
        @endif
    </div>
</div>
@endsection
