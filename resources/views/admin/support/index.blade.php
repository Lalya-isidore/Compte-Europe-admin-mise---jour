@extends('admin.layout')

@section('title', 'Messages support')

@push('styles')
<style>
    .tickets-pane, .messages-pane {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 10px 28px rgba(30, 41, 59, 0.1);
        padding: 22px;
    }
    .ticket-entry {
        border-radius: 12px;
        padding: 0.9rem 1rem;
        border: 1px solid transparent;
        display: block;
        text-decoration: none;
        color: inherit;
        margin-bottom: 0.75rem;
        transition: all 0.2s ease;
    }
    .ticket-entry:hover {
        border-color: rgba(102, 126, 234, 0.35);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.18);
    }
    .ticket-entry.active {
        border-color: rgba(102, 126, 234, 0.65);
        background: rgba(102, 126, 234, 0.08);
    }
    .conversation-box {
        max-height: 520px;
        overflow-y: auto;
        padding-right: 4px;
    }
    .conversation-message {
        max-width: 80%;
        padding: 0.9rem 1rem;
        border-radius: 16px;
        margin-bottom: 1rem;
        position: relative;
        box-shadow: 0 8px 26px rgba(15, 23, 42, 0.08);
    }
    .conversation-message.user {
        background: #f4f7fb;
        border-bottom-left-radius: 4px;
        margin-right: auto;
    }
    .conversation-message.admin {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        border-bottom-right-radius: 4px;
        margin-left: auto;
    }
    .conversation-message small {
        display: block;
        margin-top: 0.45rem;
        font-size: 0.74rem;
        opacity: 0.8;
    }
</style>
@endpush

@section('content')
@php
    use Illuminate\Support\Str;
@endphp
<div class="row g-4">
    <div class="col-lg-4">
        <div class="tickets-pane">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h5 mb-0">Tickets support</h2>
                <span class="badge bg-secondary">{{ $tickets->total() }}</span>
            </div>

            <form method="GET" class="mb-3">
                <div class="input-group">
                    <select name="status" class="form-select">
                        <option value="">Tous les statuts</option>
                        @foreach(['open' => 'Ouverts', 'pending' => 'En attente', 'answered' => 'Répondu', 'closed' => 'Fermés'] as $value => $label)
                            <option value="{{ $value }}" {{ $currentStatus === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-outline-secondary" type="submit">Filtrer</button>
                </div>
            </form>

            @forelse($tickets as $ticket)
                @php
                    $isActive = $activeTicket && $ticket->id === $activeTicket->id;
                    $statusColors = [
                        'open' => 'warning',
                        'pending' => 'secondary',
                        'answered' => 'info',
                        'closed' => 'success',
                    ];
                    $statusLabels = [
                        'open' => 'Ouvert',
                        'pending' => 'En attente',
                        'answered' => 'Répondu',
                        'closed' => 'Fermé',
                    ];
                @endphp
                <a href="{{ route('admin.support.index', array_filter(['status' => $currentStatus, 'ticket' => $ticket->id])) }}" class="ticket-entry {{ $isActive ? 'active' : '' }}">
                    <div class="d-flex justify-content-between">
                        <strong class="text-truncate">#{{ $ticket->id }} • {{ $ticket->subject }}</strong>
                        <span class="badge bg-{{ $statusColors[$ticket->status] ?? 'light' }}">{{ $statusLabels[$ticket->status] ?? $ticket->status }}</span>
                    </div>
                    <div class="mt-2 small text-muted">
                        <div>{{ $ticket->user?->nom }} {{ $ticket->user?->prenom }}</div>
                        <div>{{ $ticket->user?->email }}</div>
                        <div>Maj: {{ optional($ticket->last_message_at ?? $ticket->updated_at)->diffForHumans() }}</div>
                    </div>
                </a>
            @empty
                <p class="text-muted">Aucune demande pour le moment.</p>
            @endforelse

            <div class="mt-3">
                {{ $tickets->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="messages-pane h-100 d-flex flex-column">
            @if($activeTicket)
                @php
                    $statusColors = [
                        'open' => 'warning',
                        'pending' => 'secondary',
                        'answered' => 'info',
                        'closed' => 'success',
                    ];
                    $statusLabels = [
                        'open' => 'Ouvert',
                        'pending' => 'En attente',
                        'answered' => 'Répondu',
                        'closed' => 'Fermé',
                    ];
                @endphp
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h2 class="h5 mb-1">{{ $activeTicket->subject }}</h2>
                        <div class="text-muted small">Ticket #{{ $activeTicket->id }} • {{ $activeTicket->user?->nom }} {{ $activeTicket->user?->prenom }} • {{ $activeTicket->user?->email }}</div>
                    </div>
                    <form action="{{ route('admin.support.status', $activeTicket) }}" method="POST" class="d-flex align-items-center gap-2">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="form-select form-select-sm">
                            @foreach($statusLabels as $value => $label)
                                <option value="{{ $value }}" {{ $activeTicket->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-outline-primary btn-sm" type="submit">Mettre à jour</button>
                    </form>
                </div>

                <div class="conversation-box flex-grow-1 mb-3">
                    @foreach($activeTicket->messages as $message)
                        <div class="conversation-message {{ $message->sent_by_admin ? 'admin' : 'user' }}">
                            @if(Str::of($message->content)->trim()->isNotEmpty())
                                <div>{!! nl2br(e($message->content)) !!}</div>
                            @endif
                            @if($message->file_path)
                                <div class="mt-2">
                                    @if($message->file_type && Str::startsWith($message->file_type, 'image/'))
                                        <a href="{{ asset('storage/' . $message->file_path) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $message->file_path) }}" alt="Pièce jointe" style="max-width: 240px; border-radius: 10px;">
                                        </a>
                                    @else
                                        <a href="{{ asset('storage/' . $message->file_path) }}" target="_blank" class="btn btn-sm btn-light">
                                            📎 {{ $message->file_name ?? 'Pièce jointe' }}
                                        </a>
                                    @endif
                                </div>
                            @endif
                            @if($message->voice_path)
                                <div class="mt-2">
                                    <audio controls src="{{ asset('storage/' . $message->voice_path) }}" style="width: 220px;"></audio>
                                </div>
                            @endif
                            <small>
                                {{ $message->sent_by_admin ? 'Administrateur' : ($message->user?->nom . ' ' . $message->user?->prenom) }} • {{ $message->created_at->setTimezone('Europe/Paris')->format('d/m/Y H:i') }}
                            </small>
                        </div>
                    @endforeach
                </div>

                <hr>

                <form action="{{ route('admin.support.reply', $activeTicket) }}" method="POST" class="mt-3" enctype="multipart/form-data" data-support-form="admin-reply">
                    @csrf
                    <label class="form-label">Réponse</label>
                    <div class="d-flex gap-2 flex-wrap mb-2">
                        @foreach(['😀','🙂','🙏','✅','⚠️','🚀','👍'] as $sticker)
                            <button type="button" class="btn btn-outline-light btn-sm sticker-btn" data-sticker="{{ $sticker }}">{{ $sticker }}</button>
                        @endforeach
                    </div>
                    <textarea name="message" class="form-control mb-2 support-message-input" rows="3" placeholder="Rédigez la réponse pour l’utilisateur"></textarea>
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small">Pièce jointe</label>
                            <input type="file" name="attachment" class="form-control" accept=".png,.jpg,.jpeg,.pdf,.doc,.docx,.zip,.txt,.mp4,.mov">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Message vocal</label>
                            <input type="file" name="voice" class="form-control" accept="audio/*">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">Le statut passera automatiquement à « Répondu ».</div>
                        <button class="btn btn-gradient" type="submit">Envoyer la réponse</button>
                    </div>
                </form>
            @else
                <div class="d-flex flex-column justify-content-center align-items-center text-center flex-grow-1" style="min-height: 320px;">
                    <h2 class="h5">Aucun ticket sélectionné</h2>
                    <p class="text-muted">Choisissez une demande dans la liste de gauche pour consulter les messages et y répondre.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stickerButtons = document.querySelectorAll('.sticker-btn');

        stickerButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const sticker = this.getAttribute('data-sticker');
                let textarea = null;

                const form = this.closest('form');
                if (form) {
                    textarea = form.querySelector('.support-message-input') || form.querySelector('textarea[name="message"]');
                }

                if (textarea) {
                    const start = textarea.selectionStart || textarea.value.length;
                    const end = textarea.selectionEnd || textarea.value.length;
                    const value = textarea.value;
                    textarea.value = value.slice(0, start) + sticker + ' ' + value.slice(end);
                    textarea.focus();
                    const cursor = start + sticker.length + 1;
                    textarea.setSelectionRange(cursor, cursor);
                }
            });
        });
    });
</script>
@endpush
