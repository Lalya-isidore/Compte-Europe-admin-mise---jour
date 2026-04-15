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

<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="fw-bold h3 mb-1">Centre de Support 💬</h2>
        <p class="text-secondary mb-0 small">Gérez les demandes d'assistance et communiquez avec vos utilisateurs.</p>
    </div>
</div>

{{-- Onglets mobile uniquement --}}
<div class="d-lg-none mb-3">
    <div class="btn-group w-100" role="group">
        <button type="button" class="btn btn-outline-primary active" id="btnTabList" onclick="showTab('list')">
            <i data-lucide="list" style="width:14px;height:14px;" class="me-1"></i> Tickets
            <span class="badge bg-primary ms-1 rounded-pill">{{ $tickets->total() }}</span>
        </button>
        <button type="button" class="btn btn-outline-primary {{ $activeTicket ? '' : 'disabled' }}" id="btnTabChat" onclick="showTab('chat')">
            <i data-lucide="message-square" style="width:14px;height:14px;" class="me-1"></i> Conversation
        </button>
    </div>
</div>

<div class="row g-4 align-items-stretch">
    {{-- Tickets List Pane --}}
    <div class="col-lg-4" id="paneList">
        <div class="card-premium h-100 d-flex flex-column p-0 overflow-hidden border">
            <div class="p-3 border-bottom bg-light bg-opacity-50">
                <div class="d-flex justify-content-between align-items-center mb-2">
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

            <div class="flex-grow-1 overflow-auto p-3" style="max-height: 650px;">
                @forelse($tickets as $ticket)
                    @php
                        $isActive = $activeTicket && $ticket->id === $activeTicket->id;
                    @endphp
                    <a href="{{ route('admin.support.index', array_filter(['status' => $currentStatus, 'ticket' => $ticket->id])) }}"
                       class="ticket-entry-premium mb-2 {{ $isActive ? 'active' : '' }}"
                       onclick="if(window.innerWidth < 992) showTab('chat')">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <span class="smaller fw-bold text-dark">#{{ $ticket->id }}</span>
                            <span class="badge-status-dot bg-{{ $statusColors[$ticket->status] ?? 'light' }}" title="{{ $statusLabels[$ticket->status] ?? $ticket->status }}"></span>
                        </div>
                        <h4 class="h6 fw-bold mb-1 text-truncate" style="max-width: 100%;">{{ $ticket->subject }}</h4>
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
    <div class="col-lg-8" id="paneChat">
        <div class="card-premium h-100 d-flex flex-column p-0 overflow-hidden border">
            @if($activeTicket)
                {{-- Chat Header --}}
                <div class="p-3 border-bottom bg-white">
                    <div class="d-flex align-items-start gap-2 mb-2">
                        {{-- Bouton retour mobile --}}
                        <button class="btn btn-sm btn-light d-lg-none me-1" onclick="showTab('list')" title="Retour">
                            <i data-lucide="arrow-left" style="width:16px;height:16px;"></i>
                        </button>
                        <div class="avatar bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0" style="width: 40px; height: 40px;">
                            {{ mb_substr($activeTicket->user?->prenom ?? '?', 0, 1) }}
                        </div>
                        <div class="overflow-hidden">
                            <h3 class="h6 fw-bold mb-0 text-truncate">{{ $activeTicket->subject }}</h3>
                            <p class="smaller text-secondary mb-0 text-truncate">Ticket #{{ $activeTicket->id }} • {{ $activeTicket->user?->nom }} {{ $activeTicket->user?->prenom }}</p>
                        </div>
                    </div>
                    <form action="{{ route('admin.support.status', $activeTicket) }}" method="POST" class="d-flex align-items-center gap-2 flex-wrap">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="form-select form-select-sm rounded-pill px-3 flex-grow-1" style="font-size: 0.78rem; min-width: 130px; max-width: 200px;">
                            @foreach($statusLabels as $value => $label)
                                <option value="{{ $value }}" {{ $activeTicket->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-primary-premium btn-premium py-1 px-3" style="font-size: 0.75rem;" type="submit">Appliquer</button>
                    </form>
                </div>

                {{-- Messages Conversation --}}
                <div class="flex-grow-1 overflow-auto p-3 bg-light bg-opacity-25" id="conversationBox" style="max-height: 450px;">
                    @foreach($activeTicket->messages as $message)
                        <div class="d-flex flex-column {{ $message->sent_by_admin ? 'align-items-end' : 'align-items-start' }} mb-3">
                            <div class="chat-bubble-premium {{ $message->sent_by_admin ? 'admin shadow-sm' : 'user border shadow-sm' }}">
                                @if(Str::of($message->content)->trim()->isNotEmpty())
                                    <div class="message-content">{!! nl2br(e($message->content)) !!}</div>
                                @endif

                                @if($message->file_path)
                                    <div class="mt-2 p-2 rounded-3 {{ $message->sent_by_admin ? 'bg-white bg-opacity-10 text-white' : 'bg-light' }}">
                                        @if($message->file_type && Str::startsWith($message->file_type, 'image/'))
                                            <a href="{{ asset('storage/' . $message->file_path) }}" target="_blank" class="d-block">
                                                <img src="{{ asset('storage/' . $message->file_path) }}" alt="Image" class="img-fluid rounded-3" style="max-height: 180px;">
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
                                    <div class="mt-2 p-2 rounded-3 {{ $message->sent_by_admin ? 'bg-white bg-opacity-10' : 'bg-light' }}">
                                        <audio controls src="{{ asset('storage/' . $message->voice_path) }}" class="w-100" style="height: 32px;"></audio>
                                    </div>
                                @endif
                            </div>
                            <span class="smaller text-secondary opacity-75 mt-1 px-1 d-flex align-items-center gap-1" style="font-size: 0.65rem;">
                                {{ $message->sent_by_admin ? 'Vous' : ($message->user?->nom ?? 'Client') }} • {{ $message->created_at?->setTimezone('Europe/Paris')->format('H:i') }}
                                @if($message->sent_by_admin && $message->read_at)
                                    <span class="text-primary fw-semibold" title="Lu le {{ $message->read_at->setTimezone('Europe/Paris')->format('d/m/Y à H:i') }}">✓ Vu</span>
                                @endif
                            </span>
                        </div>
                    @endforeach
                </div>

                {{-- Reply Area --}}
                <div class="p-3 border-top bg-white">
                    <form action="{{ route('admin.support.reply', $activeTicket) }}" method="POST" enctype="multipart/form-data" id="replyForm">
                        @csrf
                        {{-- Stickers --}}
                        <div class="d-flex gap-1 mb-2 overflow-auto pb-1" style="scrollbar-width: none;">
                            @foreach(['😃','✅','🆗','⚠️','🚀','👍','🙏'] as $sticker)
                                <button type="button" class="btn btn-light btn-sm rounded-circle flex-shrink-0 d-flex align-items-center justify-content-center sticker-btn"
                                        style="width: 30px; height: 30px; font-size: 0.9rem;" data-sticker="{{ $sticker }}">{{ $sticker }}</button>
                            @endforeach
                        </div>

                        <div class="reply-control-premium mb-2">
                            <textarea name="message" class="form-control border-0 bg-transparent support-message-input" rows="3"
                                      placeholder="Votre message ici..." style="box-shadow: none; resize: none; font-size: 0.9rem;"></textarea>
                        </div>

                        <div class="row g-2 mb-2">
                            <div class="col-12 col-sm-6">
                                <div class="d-flex align-items-center gap-2 p-2 border rounded-3 bg-light bg-opacity-50">
                                    <i data-lucide="paperclip" class="text-secondary flex-shrink-0" style="width: 14px;"></i>
                                    <input type="file" name="attachment" class="form-control form-control-sm border-0 bg-transparent" style="font-size: 0.78rem;" accept=".png,.jpg,.jpeg,.pdf,.doc,.docx,.zip,.txt">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="d-flex align-items-center gap-2 p-2 border rounded-3 bg-light bg-opacity-50">
                                    <i data-lucide="mic" class="text-secondary flex-shrink-0" style="width: 14px;"></i>
                                    <input type="file" name="voice" class="form-control form-control-sm border-0 bg-transparent" style="font-size: 0.78rem;" accept="audio/*">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center gap-2">
                            <span class="smaller text-secondary text-nowrap" style="font-size: 0.75rem;">
                                <i data-lucide="info" class="me-1" style="width: 11px;"></i> Statut auto: Répondu
                            </span>
                            <button class="btn btn-primary-premium btn-premium px-3" type="submit" style="white-space: nowrap;">
                                Envoyer <i data-lucide="send" class="ms-1" style="width: 14px;"></i>
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="d-flex flex-column justify-content-center align-items-center text-center p-5 h-100" style="min-height: 400px;">
                    <div class="p-4 bg-light rounded-circle mb-4">
                        <i data-lucide="message-square" class="text-secondary opacity-25" style="width: 64px; height: 64px;"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Sélectionnez une demande</h4>
                    <p class="text-secondary" style="max-width: 320px;">Choisissez un ticket dans la liste pour voir les messages et répondre à l'utilisateur.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .ticket-entry-premium {
        display: block;
        padding: 14px;
        border-radius: 12px;
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
        flex-shrink: 0;
    }
    .chat-bubble-premium {
        max-width: 80%;
        padding: 12px 16px;
        border-radius: 18px;
        font-size: 0.9rem;
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
        border-radius: 14px;
        padding: 8px;
    }
    ::-webkit-scrollbar { width: 4px; height: 4px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }

    @media (max-width: 991.98px) {
        #paneList, #paneChat { display: none !important; }
        #paneList.mobile-active, #paneChat.mobile-active { display: block !important; }
        .chat-bubble-premium { max-width: 90%; }
    }
</style>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        lucide.createIcons();

        const chatBox = document.getElementById('conversationBox');
        if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;

        document.querySelectorAll('.sticker-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const sticker = this.getAttribute('data-sticker');
                const textarea = document.querySelector('.support-message-input');
                if (textarea) {
                    const s = textarea.selectionStart, e = textarea.selectionEnd;
                    textarea.value = textarea.value.slice(0, s) + sticker + textarea.value.slice(e);
                    textarea.focus();
                    textarea.selectionStart = textarea.selectionEnd = s + sticker.length;
                }
            });
        });

        // Mobile tabs init
        initMobileTabs();
        window.addEventListener('resize', initMobileTabs);
    });

    function initMobileTabs() {
        const isMobile = window.innerWidth < 992;
        const list = document.getElementById('paneList');
        const chat = document.getElementById('paneChat');
        if (!list || !chat) return;

        if (isMobile) {
            const hasActiveTicket = {{ $activeTicket ? 'true' : 'false' }};
            list.classList.remove('mobile-active');
            chat.classList.remove('mobile-active');
            if (hasActiveTicket && sessionStorage.getItem('supportTab') === 'chat') {
                chat.classList.add('mobile-active');
                setTabActive('chat');
            } else {
                list.classList.add('mobile-active');
                setTabActive('list');
            }
        } else {
            list.classList.remove('mobile-active');
            chat.classList.remove('mobile-active');
        }
    }

    function showTab(tab) {
        const list = document.getElementById('paneList');
        const chat = document.getElementById('paneChat');
        if (!list || !chat) return;
        list.classList.remove('mobile-active');
        chat.classList.remove('mobile-active');
        if (tab === 'list') {
            list.classList.add('mobile-active');
        } else {
            chat.classList.add('mobile-active');
        }
        sessionStorage.setItem('supportTab', tab);
        setTabActive(tab);
    }

    function setTabActive(tab) {
        const btnList = document.getElementById('btnTabList');
        const btnChat = document.getElementById('btnTabChat');
        if (!btnList || !btnChat) return;
        btnList.classList.toggle('active', tab === 'list');
        btnChat.classList.toggle('active', tab === 'chat');
    }
</script>
@endpush
