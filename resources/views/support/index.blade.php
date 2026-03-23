@extends('layouts.admin')

@section('title', 'Support & Réclamations')

@push('styles')
<style>
    .support-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 12px 35px rgba(102, 126, 234, 0.15);
    }
    .ticket-list-item {
        border: 1px solid transparent;
        border-radius: 12px;
        padding: 0.9rem 1rem;
        margin-bottom: 0.8rem;
        background: #f7f8ff;
        transition: all 0.2s ease;
        display: block;
        text-decoration: none;
        color: inherit;
    }
    .ticket-list-item:hover {
        border-color: #665af0;
        box-shadow: 0 10px 24px rgba(102, 90, 240, 0.18);
        transform: translateY(-2px);
    }
    .ticket-list-item.active {
        border-color: #665af0;
        background: linear-gradient(135deg, rgba(102, 90, 240, 0.12), rgba(118, 75, 162, 0.08));
    }
    .conversation-wrapper {
        max-height: 520px;
        overflow-y: auto;
        padding-right: 6px;
    }
    .support-message {
        max-width: 85%;
        margin-bottom: 1rem;
        padding: 0.85rem 1rem;
        border-radius: 16px;
        position: relative;
        display: inline-block;
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.08);
    }
    .support-message.user {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        margin-left: auto;
        border-bottom-right-radius: 4px;
    }
    .support-message.admin {
        background: #f1f5f9;
        color: #333;
        margin-right: auto;
        border-bottom-left-radius: 4px;
    }
    .support-message small {
        display: block;
        margin-top: 0.45rem;
        font-size: 0.75rem;
        opacity: 0.7;
    }
    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
        color: #6c778a;
    }
</style>
@endpush

@section('content')
<div class="row g-4">
    <div class="col-lg-4">
        @php
            use Illuminate\Support\Str;

            $lastActive = $supportStatus['last_active_at'] ?? null;
            $activeMessage = $supportStatus['active_message'] ?? null;
        @endphp
        <div class="support-card mb-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h2 class="h5 mb-1">💬 Des questions ? Discutons !</h2>
                    <small class="text-muted">{{ $activeMessage ?? ($lastActive ? 'Support actif ' . $lastActive->diffForHumans() : 'Support habituellement actif en journée') }}</small>
                </div>
                <span class="badge bg-success">Live chat</span>
            </div>
            <p class="text-muted small mb-3">{{ $welcomeMessage }}</p>
        </div>

        <div class="support-card mb-4">
            <h2 class="h5 mb-3">📨 Nouvelle demande</h2>
            <p class="text-muted small mb-3">Expliquez votre problème ou votre question et nous vous répondrons dans les plus brefs délais.</p>
            <form action="{{ route('support.store') }}" method="POST" enctype="multipart/form-data" data-support-form="new-ticket">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Sujet</label>
                    <input type="text" name="subject" class="form-control" placeholder="Ex: Problème de recharge" value="{{ old('subject') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Message</label>
                    <textarea name="message" class="form-control support-message-input" rows="4" placeholder="Décrivez votre réclamation ou votre question">{{ old('message') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ajouter une pièce jointe</label>
                    <input type="file" name="attachment" class="form-control" accept=".png,.jpg,.jpeg,.pdf,.doc,.docx,.zip,.txt,.mp4,.mov">
                    <small class="text-muted">Formats acceptés : images, PDF, documents, vidéos (10 Mo max).</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Envoyer un message vocal</label>
                    <input type="file" name="voice" class="form-control" accept="audio/*">
                    <small class="text-muted">Enregistrez un message vocal depuis votre appareil (10 Mo max).</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Stickers rapides</label>
                    <div class="d-flex gap-2 flex-wrap">
                        @foreach(['😀','🙌','✅','⚠️','📎','🙏','💡'] as $sticker)
                            <button type="button" class="btn btn-outline-secondary btn-sm sticker-btn" data-sticker="{{ $sticker }}">{{ $sticker }}</button>
                        @endforeach
                    </div>
                    <small class="text-muted">Cliquez pour insérer un sticker dans votre message.</small>
                </div>
                <button type="submit" class="btn btn-gradient w-100">Envoyer ma demande</button>
            </form>
        </div>

        <div class="support-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h2 class="h5 mb-0">💬 Mes conversations</h2>
                <span class="badge bg-secondary">{{ $tickets->count() }}</span>
            </div>

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
                        'open' => 'Ouverte',
                        'pending' => 'En attente',
                        'answered' => 'Répondu',
                        'closed' => 'Fermée',
                    ];
                @endphp
                <a href="{{ route('support.index', ['ticket' => $ticket->id]) }}" class="ticket-list-item {{ $isActive ? 'active' : '' }}">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <strong class="text-truncate">{{ $ticket->subject }}</strong>
                        <span class="badge bg-{{ $statusColors[$ticket->status] ?? 'light' }}">{{ $statusLabels[$ticket->status] ?? $ticket->status }}</span>
                    </div>
                    <small class="text-muted">{{ optional($ticket->last_message_at ?? $ticket->updated_at)->diffForHumans() }}</small>
                </a>
            @empty
                <div class="empty-state">
                    <p class="mb-1">Vous n'avez pas encore de discussion.</p>
                    <small>Soumettez votre première demande via le formulaire ci-dessus.</small>
                </div>
            @endforelse
        </div>
    </div>

    <div class="col-lg-8">
        <div class="support-card h-100 d-flex flex-column">
            @if($activeTicket)
                @php
                    $statusColors = [
                        'open' => 'warning',
                        'pending' => 'secondary',
                        'answered' => 'info',
                        'closed' => 'success',
                    ];
                    $statusLabels = [
                        'open' => 'Ouverte',
                        'pending' => 'En attente',
                        'answered' => 'Répondu',
                        'closed' => 'Fermée',
                    ];
                @endphp
                <div class="d-flex align-items-start justify-content-between mb-4">
                    <div>
                        <h2 class="h5 mb-1">{{ $activeTicket->subject }}</h2>
                        <small class="text-muted">Ticket #{{ $activeTicket->id }} • Créé le {{ $activeTicket->created_at->format('d/m/Y H:i') }}</small>
                    </div>
                    <span class="badge bg-{{ $statusColors[$activeTicket->status] ?? 'light' }}">{{ $statusLabels[$activeTicket->status] ?? $activeTicket->status }}</span>
                </div>

                <div class="conversation-wrapper flex-grow-1 mb-3">
                    @foreach($activeTicket->messages as $message)
                        <div class="support-message {{ $message->sent_by_admin ? 'admin' : 'user' }}">
                            @if(Str::of($message->content)->trim()->isNotEmpty())
                                <div>{!! nl2br(e($message->content)) !!}</div>
                            @endif

                            @if($message->file_path)
                                <div class="mt-2">
                                    @if($message->file_type && Str::startsWith($message->file_type, 'image/'))
                                        <a href="{{ asset('storage/' . $message->file_path) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $message->file_path) }}" alt="Pièce jointe" style="max-width: 220px; border-radius: 10px;">
                                        </a>
                                    @else
                                        <a href="{{ asset('storage/' . $message->file_path) }}" target="_blank" class="btn btn-sm btn-light">
                                            📎 {{ $message->file_name ?? 'Télécharger la pièce jointe' }}
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
                                {{ $message->sent_by_admin ? 'Support FlashBilan' : 'Vous' }} • {{ $message->created_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                    @endforeach
                </div>

                @if($activeTicket->messages->isNotEmpty())
                    <hr>
                @endif

                @if($activeTicket->status !== 'closed')
                    <form action="{{ route('support.message.store', $activeTicket) }}" method="POST" class="mt-3" enctype="multipart/form-data">
                        @csrf
                        <label class="form-label">Répondre</label>
                        <div class="mb-2">
                            <div class="d-flex gap-2 flex-wrap mb-2">
                                @foreach(['😀','🙌','✅','⚠️','📎','🙏','💬'] as $sticker)
                                    <button type="button" class="btn btn-outline-secondary btn-sm sticker-btn" data-sticker="{{ $sticker }}">{{ $sticker }}</button>
                                @endforeach
                            </div>
                            <textarea name="message" class="form-control support-message-input" rows="3" placeholder="Écrivez votre message..."></textarea>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-md-6">
                                <label class="form-label small mb-1">Pièce jointe</label>
                                <input type="file" name="attachment" class="form-control" accept=".png,.jpg,.jpeg,.pdf,.doc,.docx,.zip,.txt,.mp4,.mov">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small mb-1">Message vocal</label>
                                <input type="file" name="voice" class="form-control" accept="audio/*">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">Vous pouvez envoyer un message, une pièce jointe ou un vocal.</small>
                            <button class="btn btn-gradient" type="submit">Envoyer</button>
                        </div>
                    </form>
                @else
                    <div class="alert alert-info mt-3 mb-0">
                        Cette conversation est close. Ouvrez un nouveau ticket si vous avez besoin de poursuivre l’échange.
                    </div>
                @endif
            @else
                <div class="empty-state flex-grow-1">
                    <h2 class="h5">Besoin d’aide ?</h2>
                    <p>Utilisez le formulaire à gauche pour démarrer une conversation avec notre équipe de support.</p>
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

                if (!textarea) {
                    textarea = document.querySelector('form[data-support-form="new-ticket"] textarea[name="message"]');
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

