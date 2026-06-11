@extends('admin.layout')

@section('title', 'SMS Rejetés')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold h3 mb-1"><i data-lucide="message-x" style="width:28px;height:28px" class="me-2"></i>SMS Rejetés</h2>
    <p class="text-secondary">Messages envoyés par les utilisateurs et rejetés par l'opérateur.</p>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
        <i data-lucide="check-circle" style="width:16px;height:16px" class="me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
        <i data-lucide="alert-circle" style="width:16px;height:16px" class="me-1"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        @if($rejected->isEmpty())
            <div class="text-center py-5 text-secondary">
                <i data-lucide="check-circle" style="width:48px;height:48px;opacity:.4"></i>
                <p class="mt-3">Aucun SMS rejeté.</p>
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
                        <th>Message complet</th>
                        <th>Erreur opérateur</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rejected as $i => $sms)
                    <tr>
                        <td class="text-secondary fw-bold">{{ $rejected->firstItem() + $i }}</td>
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
                        <td><code>{{ $sms->destinataire }}</code> <span class="badge bg-secondary ms-1">{{ $sms->pays ?? '' }}</span></td>
                        <td style="max-width:320px;">
                            <div style="white-space:pre-wrap;word-break:break-word;background:#fff8f8;border:1px solid #fecaca;border-radius:6px;padding:8px 10px;font-size:.85rem;color:#1e293b;line-height:1.6;">{{ $sms->message }}</div>
                        </td>
                        <td>
                            @if($sms->error_message)
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle" style="font-size:.78rem;white-space:normal;max-width:180px;display:inline-block;text-align:left;">{{ $sms->error_message }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-muted" style="white-space:nowrap;">{{ $sms->created_at->setTimezone('Europe/Paris')->format('d/m/Y H:i') }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.smsRejected.resend', $sms->id) }}" onsubmit="return confirm('Renvoyer ce SMS à {{ $sms->destinataire }} ?')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-primary" title="Renvoyer">
                                    <i data-lucide="send" style="width:14px;height:14px"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($rejected->hasPages())
        <div class="px-4 py-3 border-top">
            {{ $rejected->links() }}
        </div>
        @endif
        @endif
    </div>
</div>
@endsection
