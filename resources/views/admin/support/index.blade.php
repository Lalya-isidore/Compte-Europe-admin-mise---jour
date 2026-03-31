@extends('admin.layout')

@section('title', 'Gestion du Support')

@section('content')
@php
    use Illuminate\Support\Str;
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
    $statusIcons = [
        'open' => 'alert-circle',
        'pending' => 'clock',
        'answered' => 'message-square',
        'closed' => 'check-circle',
    ];
@endphp

<div class="mb-4">
    <h2 class="fw-bold h3 mb-2">Centre de Support 💬</h2>
    <p class="text-secondary">Gérez les demandes d'assistance et communiquez avec vos utilisateurs.</p>
</div>

<div class="row g-4 align-items-stretch">
    {{-- Tickets List Pane --}}
    <div class="col-lg-4">
        <div class="card-premium h-100 d-flex flex-column p-0 overflow-hidden border">
            <div class="p-4 border-bottom bg-light bg-opacity-50">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="h6 fw-bold mb-0">Demandes récentes</h3>
                    <span class="badge bg-primary rounded-pill">{{ $tickets->total() }}</span>
                </div>
                
                <form method="GET" action="{{ route('admin.support.index') }}">
                    <div class="input-group input-group-sm border rounded-3 overflow-hidden bg-white">
                        <select name="status" class="form-select border-0 bg-transparent text-secondary" style="font-size: 0.8rem;" onchange="this.form.submit()">
                            <option value="">Tous les statuts</option>
                            @foreach($statusLabels as $value => $label)
                                <option value="{{ $value }}" {{ $currentStatus === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <button class="btn border-0 bg-transparent text-secondary" type="submit">
                            <i data-lucide="filter" style="width: 14px;"></i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="flex-grow-1 overflow-auto p-3" style="max-height: 700px;">
                @forelse($tickets as $ticket)
                    @php
                        $isActive = $activeTicket && $ticket->id === $activeTicket->id;
                    @endphp
                    <a href="{{ route('admin.support.index', array_filter(['status' => $currentStatus, 'ticket' => $ticket->id])) }}" 
                       class="ticket-entry-premium mb-2 {{ $isActive ? 'active' : '' }}">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="smaller fw-bold text-dark">#{{ $ticket->id }}</span>
                            <span class="badge-status-dot bg-{{ $statusColors[$ticket->status] ?? 'light' }}" title="{{ $statusLabels[$ticket->status] ?? $ticket->status }}"></span>
                        </div>
                        <h4 class="h6 fw-bold mb-1 text-truncate">{{ $ticket->subject }}</h4>
                        <p class="smaller text-secondary mb-2 text-truncate">{{ $ticket->user?->nom }} {{ $ticket->user?->prenom }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-{{ $statusColors[$ticket->status] ?? 'light' }} bg-opacity-10 text-{{ $statusColors[$ticket->status] ?? 'dark' }} rounded-pill px-2 py-1" style="font-size: 0.65rem;">
                                {{ $statusLabels[$ticket->status] ?? $ticket->status }}
                            </span>
                            <span class="text-secondary" style="font-size: 0.65rem;">
                                <i data-lucide="clock" class="me-1" style="width: 10px;"></i>
                                {{ optional($ticket->last_message_at ?? $ticket->updated_at)->diffForHumans() }}
                            </span>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-5 opacity-50">
                        <i data-lucide="inbox" class="mb-2" style="width: 40px; height: 40px;"></i>
                        <p class="smaller">Aucun ticket trouvé</p>
                    </div>
                @endforelse
            </div>

            <div class="p-3 border-top bg-light bg-opacity-25">
                {{ $tickets->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    {{-- Chat Pane --}}
    <div class="col-lg-8">
        <div class="card-premium h-100 d-flex flex-column p-0 overflow-hidden border">
            @if($activeTicket)
                {{-- Chat Header --}}
                <div class="p-4 border-bottom bg-white d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 44px; height: 44px;">
                            {{ mb_substr($activeTicket->user?->prenom ?? '?', 0, 1) }}
                        </div>
                        <div>
                            <h3 class="h6 fw-bold mb-0">{{ $activeTicket->subject }}</h3>
                            <p class="smaller text-secondary mb-0">Ticket #{{ $activeTicket->id }} • {{ $activeTicket->user?->nom }} {{ $activeTicket->user?->prenom }}</p>
                        </div>
                    </div>
                    <form action="{{ route('admin.support.status', $activeTicket) }}" method="POST" class="d-flex align-items-center gap-2">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="form-select form-select-sm rounded-pill px-3" style="font-size: 0.75rem; min-width: 120px;">
                            @foreach($statusLabels as $value => $label)
                                <option value="{{ $value }}" {{ $activeTicket->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-primary-premium btn-premium py-1 px-3" style="font-size: 0.7rem;" type="submit">Appliquer</button>
                    </form>
                </div>

                {{-- Messages Conversation --}}
                <div class="flex-grow-1 overflow-auto p-4 bg-light bg-opacity-25" id="conversationBox" style="max-height: 500px;">
                    @foreach($activeTicket->messages as $message)
                        <div class="d-flex flex-column {{ $message->sent_by_admin ? 'align-items-end' : 'align-items-start' }} mb-4">
                            <div class="chat-bubble-premium {{ $message->sent_by_admin ? 'admin shadow-sm' : 'user border shadow-sm' }}">
                                @if(Str::of($message->content)->trim()->isNotEmpty())
                                    <div class="message-content">{!! nl2br(e($message->content)) !!}</div>
                                @endif
                                
                                @if($message->file_path)
                                    <div class="mt-3 p-2 rounded-3 {{ $message->sent_by_admin ? 'bg-white bg-opacity-10 text-white' : 'bg-light' }}">
                                        @if($message->file_type && Str::startsWith($message->file_type, 'image/'))
                                            <a href="{{ asset('storage/' . $message->file_path) }}" target="_blank" class="d-block">
                                                <img src="{{ asset('storage/' . $message->file_path) }}" alt="Image" class="img-fluid rounded-3" style="max-height: 200px;">
                                            </a>
                                        @else
                                            <a href="{{ asset('storage/' . $message->file_path) }}" target="_blank" class="text-decoration-none d-flex align-items-center gap-2 {{ $message->sent_by_admin ? 'text-white' : 'text-primary' }}">
                                                <i data-lucide="file" style="width: 16px;"></i>
                                                <span class="smaller fw-medium">{{ Str::limit($message->file_name ?? 'Pièce jointe', 25) }}</span>
                                            </a>
                                        @endif
                                    </div>
                                @endif

                                @if($message->voice_path)
                                    <div class="mt-3 p-2 rounded-3 {{ $message->sent_by_admin ? 'bg-white bg-opacity-10' : 'bg-light' }}">
                                        <audio controls src="{{ asset('storage/' . $message->voice_path) }}" class="w-100" style="height: 32px; filter: contrast(1.1) brightness(0.9);"></audio>
                                    </div>
                                @endif
                            </div>
                            <span class="smaller text-secondary opacity-75 mt-1 px-2" style="font-size: 0.65rem;">
                                {{ $message->sent_by_admin ? 'Vous' : ($message->user?->nom ?? 'Client') }} • {{ $message->created_at?->setTimezone('Europe/Paris')->format('H:i') }}
                            </span>
                        </div>
                    @endforeach
                </div>

                {{-- Reply Area --}}
                <div class="p-4 border-top bg-white">
                    <form action="{{ route('admin.support.reply', $activeTicket) }}" method="POST" enctype="multipart/form-data" id="replyForm">
                        @csrf
                        <div class="d-flex gap-2 mb-3">
                            @foreach(['😃','✅','🆗','⚠️','🚀','👍','🙏'] as $sticker)
                                <button type="button" class="btn btn-light btn-sm rounded-circle d-flex align-items-center justify-content-center sticker-btn" 
                                        style="width: 32px; height: 32px; font-size: 1rem;" data-sticker="{{ $sticker }}">{{ $sticker }}</button>
                            @endforeach
                        </div>

                        <div class="reply-control-premium mb-3">
                            <textarea name="message" class="form-control border-0 bg-transparent support-message-input" rows="3" 
                                      placeholder="Votre message ici..." style="box-shadow: none; resize: none;"></textarea>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center gap-2 p-2 border rounded-3 bg-light bg-opacity-50">
                                    <i data-lucide="paperclip" class="text-secondary" style="width: 16px;"></i>
                                    <input type="file" name="attachment" class="form-control form-control-sm border-0 bg-transparent fs-7" accept=".png,.jpg,.jpeg,.pdf,.doc,.docx,.zip,.txt">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center gap-2 p-2 border rounded-3 bg-light bg-opacity-50">
                                    <i data-lucide="mic" class="text-secondary" style="width: 16px;"></i>
                                    <input type="file" name="voice" class="form-control form-control-sm border-0 bg-transparent fs-7" accept="audio/*">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="smaller text-secondary"><i data-lucide="info" class="me-1" style="width: 12px;"></i> Statut auto: Répondu</span>
                            <button class="btn btn-primary-premium btn-premium px-4" type="submit">
                                Envoyer <i data-lucide="send" class="ms-2" style="width: 16px;"></i>
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="d-flex flex-column justify-content-center align-items-center text-center p-5 h-100" style="min-height: 450px;">
                    <div class="p-4 bg-light rounded-circle mb-4">
                        <i data-lucide="message-square" class="text-secondary opacity-25" style="width: 64px; height: 64px;"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Sélectionnez une demande</h4>
                    <p class="text-secondary" style="max-width: 320px;">Choisissez un ticket dans la liste de gauche pour voir les messages et répondre à l'utilisateur.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* New Component Styles */
    .ticket-entry-premium {
        display: block;
        padding: 16px;
        border-radius: 14px;
        border: 1px solid transparent;
        text-decoration: none;
        color: inherit;
        transition: all 0.2s ease;
        background: white;
    }
    .ticket-entry-premium:hover {
        background: #f8fafc;
        border-color: #e2e8f0;
    }
    .ticket-entry-premium.active {
        background: #f1f5f9;
        border-color: var(--primary);
        box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.1);
    }
    .badge-status-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
    }
    .chat-bubble-premium {
        max-width: 75%;
        padding: 14px 18px;
        border-radius: 20px;
        font-size: 0.925rem;
        line-height: 1.5;
    }
    .chat-bubble-premium.user {
        background: white;
        border-bottom-left-radius: 4px;
        color: #1e293b;
    }
    .chat-bubble-premium.admin {
        background: var(--primary);
        color: white;
        border-bottom-right-radius: 4px;
    }
    .reply-control-premium {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 8px;
    }
    .fs-7 { font-size: 0.8rem; }
    
    /* Scrollbar styling */
    ::-webkit-scrollbar {
        width: 6px;
    }
    ::-webkit-scrollbar-track {
        background: transparent;
    }
    ::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: #cbd5e1;
    }
</style>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        lucide.createIcons();
        
        // Auto-scroll to bottom of conversation
        const chatBox = document.getElementById('conversationBox');
        if (chatBox) {
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        // Sticker insertion logic
        const stickerButtons = document.querySelectorAll('.sticker-btn');
        stickerButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const sticker = this.getAttribute('data-sticker');
                const textarea = document.querySelector('.support-message-input');
                if (textarea) {
                    const start = textarea.selectionStart;
                    const end = textarea.selectionEnd;
                    const text = textarea.value;
                    textarea.value = text.slice(0, start) + sticker + text.slice(end);
                    textarea.focus();
                    textarea.selectionStart = textarea.selectionEnd = start + sticker.length;
                }
            });
        });
    });
</script>
@endpush
