@extends('admin.layout')

@section('title', 'Violations expéditeur SMS')

@section('content')

<div class="mb-5">
    <h2 class="fw-bold h3 mb-2">
        <i data-lucide="shield-alert" style="width:28px;height:28px" class="me-2 text-danger"></i>
        Violations expéditeur SMS
    </h2>
    <p class="text-secondary">Tentatives d'usurpation d'identité détectées. Examine le nom utilisé et décide si le compte doit être supprimé.</p>
</div>

@if(session('success'))
    <div class="alert alert-success rounded-3 py-2 mb-4">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger rounded-3 py-2 mb-4">{{ session('error') }}</div>
@endif

<div class="card-premium">
    @if($violations->isEmpty())
        <div class="text-center py-5 text-secondary">
            <i data-lucide="shield-check" style="width:48px;height:48px;" class="opacity-25 mb-3"></i>
            <p>Aucune violation signalée.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Utilisateur</th>
                        <th>Email</th>
                        <th>Nom expéditeur tenté</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($violations as $v)
                    <tr class="{{ $v->isPending() ? 'table-warning' : '' }}">
                        <td>
                            @if($v->user)
                                <span class="fw-semibold">{{ $v->user->prenom }} {{ $v->user->nom }}</span>
                            @else
                                <span class="text-secondary fst-italic">Compte supprimé</span>
                            @endif
                        </td>
                        <td>
                            @if($v->user)
                                <span class="text-muted small">{{ $v->user->email }}</span>
                            @else
                                <span class="text-secondary">—</span>
                            @endif
                        </td>
                        <td>
                            <code class="text-danger fw-bold fs-6">{{ $v->expediteur }}</code>
                        </td>
                        <td class="text-muted small">
                            {{ $v->created_at->setTimezone('Europe/Paris')->format('d/m/Y à H:i') }}
                        </td>
                        <td>
                            @if($v->status === 'pending')
                                <span class="badge bg-warning text-dark">En attente</span>
                            @elseif($v->status === 'dismissed')
                                <span class="badge bg-secondary">Ignoré</span>
                            @elseif($v->status === 'deleted')
                                <span class="badge bg-danger">Compte supprimé</span>
                            @endif
                        </td>
                        <td>
                            @if($v->isPending())
                            <div class="d-flex gap-2">
                                <form action="{{ route('admin.senderViolations.deleteUser', $v) }}" method="POST"
                                      onsubmit="return confirm('Supprimer définitivement le compte de {{ $v->user?->prenom }} {{ $v->user?->nom }} et toutes ses données ?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i data-lucide="trash-2" style="width:14px;height:14px" class="me-1"></i>
                                        Supprimer le compte
                                    </button>
                                </form>
                                <form action="{{ route('admin.senderViolations.dismiss', $v) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                                        <i data-lucide="x" style="width:14px;height:14px" class="me-1"></i>
                                        Ignorer
                                    </button>
                                </form>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3">
            {{ $violations->links() }}
        </div>
    @endif
</div>

@endsection
