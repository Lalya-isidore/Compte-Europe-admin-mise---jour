(function () {
    const SUPPORT_ENDPOINTS = {
        data: '/support/widget/data',
        markRead: '/support/widget/read',
        create: '/support',
        reply: (ticketId) => `/support/${ticketId}/message`,
    };

    const STICKERS = ['😀', '🙌', '✅', '⚠️', '📎', '🙏', '💡', '🚀'];

    const templates = {
        container: `
            <div class="support-widget" id="supportWidget">
                <button class="support-widget__bubble" id="supportWidgetToggle" aria-label="Ouvrir la messagerie support">
                    <span class="support-widget__bubble-icon">💬</span>
                    <span class="support-widget__bubble-badge" id="supportWidgetBadge">0</span>
                </button>
                <div class="support-widget__panel" id="supportWidgetPanel" aria-hidden="true">
                    <div class="support-widget__header">
                        <div class="support-widget__header-pill">
                            <span class="support-widget__header-pill-icon">💬</span>
                            Messages
                        </div>
                        <div class="support-widget__header-center">
                            <div class="support-widget__avatar-group">
                                <span class="support-widget__avatar">FC</span>
                                <span class="support-widget__avatar support-widget__avatar--badge" id="supportLiveBadge" style="display: none;">LIVE</span>
                            </div>
                            <div class="support-widget__header-text">
                                <div class="support-widget__header-headline">Des questions ? Discutons !</div>
                                <div class="support-widget__header-status">Délai de réponse : 24h maximum</div>
                            </div>
                        </div>
                        <button class="support-widget__close" id="supportWidgetClose" aria-label="Fermer">&times;</button>
                    </div>
                    <div class="support-widget__body" id="supportWidgetBody">
                        <div class="support-widget__loader" id="supportWidgetLoader">
                            <span class="support-widget__spinner"></span>
                            <span>Chargement…</span>
                        </div>
                    </div>
                </div>
            </div>
        `,
        newTicketForm: `
            <div class="support-widget__new">
                <p class="support-widget__intro">Décrivez votre question, joignez un fichier ou un vocal si besoin.</p>
                <form class="support-widget__form" id="supportWidgetNewTicket" enctype="multipart/form-data">
                    <div class="support-widget__field">
                        <label>Sujet</label>
                        <input type="text" name="subject" maxlength="150" required placeholder="Ex : Problème de recharge" />
                    </div>
                    <div class="support-widget__field support-widget__field--message">
                        <label>Message</label>
                        <div class="support-widget__composer-wrapper">
                            <textarea class="support-widget__composer-textarea" name="message" rows="3" maxlength="2000" placeholder="Entrez votre message…"></textarea>
                            <div class="support-widget__composer">
                                <div class="support-widget__composer-icons">
                                    <button type="button" class="support-widget__icon-btn" data-action="emoji" title="Ajouter un sticker">😊</button>
                                    <button type="button" class="support-widget__icon-btn" data-action="attach" title="Ajouter une pièce jointe">📎</button>
                                    <input type="file" name="attachment" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.zip,.txt,.mp4,.mov" data-role="attachment-input" hidden>
                                    <button type="button" class="support-widget__icon-btn" data-action="voice" title="Enregistrer un message vocal">🎙️<span class="support-widget__voice-indicator" aria-hidden="true"></span></button>
                                </div>
                                <button type="submit" class="support-widget__send-btn">Envoyer</button>
                            </div>
                        </div>
                        <div class="support-widget__sticker-panel" data-sticker-panel>
                            ${STICKERS.map((sticker) => `<button type="button" class="support-widget__sticker-btn" data-sticker="${sticker}">${sticker}</button>`).join('')}
                        </div>
                    </div>
                    <div class="support-widget__previews" data-preview></div>
                </form>
            </div>
        `,
        conversation: (ticket) => `
            <div class="support-widget__conversation" data-ticket-id="${ticket.id}">
                <header class="support-widget__conversation-header">
                    <div>
                        <div class="support-widget__conversation-title">${ticket.subject}</div>
                        <small>Ticket #${ticket.id} • créé le ${ticket.created_at}</small>
                    </div>
                    <span class="support-widget__status support-widget__status--${ticket.status}">${statusLabel(ticket.status)}</span>
                </header>
                <div class="support-widget__messages" id="supportWidgetMessages">
                    ${ticket.messages.map(renderMessage).join('')}
                </div>
                <form class="support-widget__reply" id="supportWidgetReplyForm" enctype="multipart/form-data">
                    <div class="support-widget__composer-wrapper support-widget__composer-wrapper--reply">
                        <textarea class="support-widget__composer-textarea" name="message" rows="2" maxlength="2000" placeholder="Entrez votre message…"></textarea>
                        <div class="support-widget__composer">
                            <div class="support-widget__composer-icons">
                                <button type="button" class="support-widget__icon-btn" data-action="emoji" title="Ajouter un sticker">😊</button>
                                <button type="button" class="support-widget__icon-btn" data-action="attach" title="Ajouter une pièce jointe">📎</button>
                                <input type="file" name="attachment" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.zip,.txt,.mp4,.mov" data-role="attachment-input" hidden>
                                <button type="button" class="support-widget__icon-btn" data-action="voice" title="Enregistrer un message vocal">🎙️<span class="support-widget__voice-indicator" aria-hidden="true"></span></button>
                            </div>
                            <button type="submit" class="support-widget__send-btn support-widget__send-btn--reply">Envoyer</button>
                        </div>
                    </div>
                    <div class="support-widget__sticker-panel" data-sticker-panel>
                        ${STICKERS.map((sticker) => `<button type="button" class="support-widget__sticker-btn" data-sticker="${sticker}">${sticker}</button>`).join('')}
                    </div>
                    <div class="support-widget__previews" data-preview></div>
                </form>
            </div>
        `,
        alert: (type, message) => `
            <div class="support-widget__alert support-widget__alert--${type}" role="alert">
                ${message}
            </div>
        `,
    };

    const statusLabel = (status) => ({
        open: 'Ouverte',
        pending: 'En attente',
        answered: 'Répondu',
        closed: 'Fermée',
    }[status] || status);

    const escapeHtml = (text) => {
        const div = document.createElement('div');
        div.textContent = text || '';
        return div.innerHTML;
    };

    const formatText = (text) => escapeHtml(text).replace(/\n/g, '<br>');

    function renderAttachment(message) {
        if (message.file_url && message.file_type && message.file_type.startsWith('image/')) {
            return `
                <div class="support-widget__attachment">
                    <a href="${message.file_url}" target="_blank" rel="noopener">
                        <img src="${message.file_url}" alt="Pièce jointe" class="support-widget__attachment-image">
                    </a>
                </div>
            `;
        }

        if (message.file_url) {
            const name = escapeHtml(message.file_name || 'Télécharger la pièce jointe');
            return `
                <div class="support-widget__attachment">
                    <a href="${message.file_url}" class="support-widget__attachment-link" target="_blank" rel="noopener">📎 ${name}</a>
                </div>
            `;
        }

        return '';
    }

    function renderVoice(message) {
        if (!message.voice_url) {
            return '';
        }

        return `
            <div class="support-widget__voice">
                <audio controls preload="none">
                    <source src="${message.voice_url}">
                    Votre navigateur ne supporte pas la lecture audio.
                </audio>
            </div>
        `;
    }

    function renderMessage(message) {
        const role = message.sent_by_admin ? 'admin' : 'user';
        const author = message.sent_by_admin ? 'Support FlashCompte' : 'Vous';
        const hasText = message.content && message.content.trim().length;

        return `
            <div class="support-widget__message support-widget__message--${role}" data-message-id="${message.id}">
                ${hasText ? `<div class="support-widget__message-content">${formatText(message.content)}</div>` : ''}
                ${renderAttachment(message)}
                ${renderVoice(message)}
                <small>${author} • ${message.created_at}</small>
            </div>
        `;
    }

    function showAlert(container, type, message) {
        container.insertAdjacentHTML('afterbegin', templates.alert(type, message));
        const alert = container.querySelector('.support-widget__alert');
        if (alert) {
            setTimeout(() => alert.remove(), 5000);
        }
    }

    async function fetchWithCsrf(url, options = {}) {
        // Récupère le token CSRF en toute sécurité
        const meta = document.querySelector('meta[name="csrf-token"]');
        const token = meta ? meta.getAttribute('content') : null;

        const headers = new Headers(options.headers || {});
        headers.set('X-Requested-With', 'XMLHttpRequest');
        if (token) {
            headers.set('X-CSRF-TOKEN', token);
        }

        // Si le body n'est pas un FormData, on envoie du JSON
        if (options.body && !(options.body instanceof FormData)) {
            headers.set('Content-Type', 'application/json');
            options.body = JSON.stringify(options.body);
        }

        // Forcer l'envoi des cookies (sécurise les requêtes same-origin)
        const fetchOptions = { ...options, headers, credentials: options.credentials || 'same-origin' };

        const response = await fetch(url, fetchOptions);

        // Tenter de décoder la réponse JSON, mais tolérer le texte brut pour faciliter le debug
        const contentType = response.headers.get('content-type') || '';
        let parsed = null;
        if (contentType.includes('application/json')) {
            parsed = await response.json().catch(() => null);
        } else {
            parsed = await response.text().catch(() => null);
        }

        if (!response.ok) {
            const serverMessage = parsed && typeof parsed === 'object' && parsed.message ? parsed.message : (typeof parsed === 'string' ? parsed : null);
            const errorText = serverMessage || `Erreur ${response.status}: ${response.statusText}`;
            throw new Error(errorText);
        }

        return parsed;
    }

    function setupStickers(form) {
        const textarea = form.querySelector('textarea[name="message"]');
        const trigger = form.querySelector('[data-action="emoji"]');
        const panel = form.querySelector('[data-sticker-panel]');

        if (!textarea || !trigger || !panel) {
            return;
        }

        const hidePanel = () => panel.classList.remove('is-visible');

        trigger.addEventListener('click', (event) => {
            event.preventDefault();
            panel.classList.toggle('is-visible');
        });

        panel.querySelectorAll('[data-sticker]').forEach((button) => {
            button.addEventListener('click', () => {
                const sticker = button.getAttribute('data-sticker');
                const start = textarea.selectionStart || textarea.value.length;
                const end = textarea.selectionEnd || textarea.value.length;
                const value = textarea.value;
                textarea.value = `${value.slice(0, start)}${sticker} ${value.slice(end)}`;
                textarea.focus();
                const cursor = start + sticker.length + 1;
                textarea.setSelectionRange(cursor, cursor);
                hidePanel();
            });
        });

        document.addEventListener('click', (event) => {
            if (!form.contains(event.target)) {
                hidePanel();
            }
        });
    }

    function setupUploads(form) {
        const attachmentInput = form.querySelector('[data-role="attachment-input"]');
        const attachBtn = form.querySelector('[data-action="attach"]');
        const voiceBtn = form.querySelector('[data-action="voice"]');
        const previewBox = form.querySelector('[data-preview]');

        if (!previewBox) {
            return {
                reset: () => {},
                getVoiceBlob: () => null,
                clearVoice: () => {},
                isRecording: () => !!(voiceBtn && voiceBtn.classList.contains('is-recording')),
                stopRecording: () => {},
            };
        }

        const state = {
            recorder: null,
            chunks: [],
            voiceBlob: null,
            voiceName: null,
        };

        function resetPreview() {
            previewBox.innerHTML = '';
            if (attachmentInput) {
                attachmentInput.value = '';
            }
            state.voiceBlob = null;
            state.voiceName = null;
        }

        function addPreview(content) {
            previewBox.innerHTML = content;
        }

        if (attachBtn && attachmentInput) {
            attachBtn.addEventListener('click', () => attachmentInput.click());

            attachmentInput.addEventListener('change', () => {
                const file = attachmentInput.files && attachmentInput.files[0];
                if (!file) {
                    return;
                }
                const name = file.name.length > 28 ? `${file.name.slice(0, 20)}…${file.name.slice(-5)}` : file.name;
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = () => {
                        addPreview(`
                            <div class="support-widget__preview-item">
                                <img src="${reader.result}" alt="Aperçu" class="support-widget__preview-image" />
                                <span class="support-widget__preview-label">${name}</span>
                            </div>
                        `);
                    };
                    reader.readAsDataURL(file);
                } else {
                    addPreview(`
                        <div class="support-widget__preview-item">
                            <span class="support-widget__preview-label">📎 ${name}</span>
                        </div>
                    `);
                }
            });
        }

        async function startRecording() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                state.recorder = new MediaRecorder(stream);
                state.chunks = [];
                state.recorder.addEventListener('dataavailable', (event) => {
                    if (event.data.size > 0) {
                        state.chunks.push(event.data);
                    }
                });
                state.recorder.addEventListener('stop', () => {
                    stream.getTracks().forEach((track) => track.stop());
                    state.voiceBlob = new Blob(state.chunks, { type: 'audio/webm' });
                    state.voiceName = `enregistrement-${Date.now()}.webm`;
                    addPreview(`
                        <div class="support-widget__preview-item">
                            <span class="support-widget__preview-label">🎙️ Enregistrement prêt (${Math.ceil(state.voiceBlob.size / 1024)} Ko)</span>
                        </div>
                    `);
                    state.chunks = [];
                });
                state.recorder.start();
                voiceBtn.classList.add('is-recording');
                addPreview(`
                    <div class="support-widget__preview-item">
                        <span class="support-widget__preview-label">🎙️ Enregistrement en cours…</span>
                    </div>
                `);
            } catch (error) {
                console.error('Voice recording error', error);
                showAlert(form, 'danger', "Impossible d'accéder au microphone. Autorisez l'accès ou téléversez un fichier audio.");
            }
        }

        function stopRecording() {
            if (state.recorder && state.recorder.state !== 'inactive') {
                state.recorder.stop();
            }
            voiceBtn.classList.remove('is-recording');
        }

        if (voiceBtn) {
            if (!navigator.mediaDevices || !window.MediaRecorder) {
                voiceBtn.disabled = true;
                voiceBtn.title = "Enregistrement vocal non supporté par ce navigateur";
            } else {
                voiceBtn.addEventListener('click', () => {
                    if (voiceBtn.classList.contains('is-recording')) {
                        stopRecording();
                    } else {
                        startRecording();
                    }
                });
            }
        }

        return {
            reset: resetPreview,
            getVoiceBlob: () => {
                if (state.voiceBlob) {
                    return { blob: state.voiceBlob, name: state.voiceName };
                }
                return null;
            },
            clearVoice: () => {
                state.voiceBlob = null;
                state.voiceName = null;
            },
            isRecording: () => !!(voiceBtn && voiceBtn.classList.contains('is-recording')),
            stopRecording,
        };
    }

    function handleFormSubmission(form, { endpoint, onSuccess }) {
        const uploads = setupUploads(form);
        setupStickers(form);

        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const attachmentInput = form.querySelector('[data-role="attachment-input"]');
            const textarea = form.querySelector('textarea[name="message"]');
            const textValue = textarea ? textarea.value.trim() : '';
            const hasAttachment = attachmentInput && attachmentInput.files && attachmentInput.files.length > 0;
            const voiceRecording = uploads.getVoiceBlob();
            if (typeof uploads.isRecording === 'function' && uploads.isRecording()) {
                showAlert(form, 'danger', 'Terminez votre enregistrement vocal avant d\'envoyer.');
                return;
            }

            if (!textValue && !hasAttachment && !voiceRecording) {
                showAlert(form, 'danger', 'Ajoutez un message, une pièce jointe ou un vocal.');
                return;
            }

            form.classList.add('is-loading');

            try {
                const formData = new FormData(form);
                if (!textValue && textarea) {
                    formData.set('message', '');
                }

                if (voiceRecording) {
                    formData.set('voice', voiceRecording.blob, voiceRecording.name);
                }

                const response = await fetchWithCsrf(endpoint, {
                    method: 'POST',
                    body: formData,
                });

                onSuccess(response);
                form.reset();
                uploads.reset();
                uploads.clearVoice();
                const stickerPanel = form.querySelector('[data-sticker-panel]');
                if (stickerPanel) {
                    stickerPanel.classList.remove('is-visible');
                }
                if (typeof window.supportWidgetMarkRead === 'function') {
                    window.supportWidgetMarkRead();
                }
            } catch (error) {
                console.error('Support widget submit error:', error);
                showAlert(form, 'danger', error.message);
            } finally {
                form.classList.remove('is-loading');
            }
        });
    }

    function initSupportWidget() {
        if (!document.body || document.getElementById('supportWidget')) {
            return;
        }

        document.body.insertAdjacentHTML('beforeend', templates.container);

        const widget = document.getElementById('supportWidget');
        const panel = document.getElementById('supportWidgetPanel');
        const toggleBtn = document.getElementById('supportWidgetToggle');
        const closeBtn = document.getElementById('supportWidgetClose');
        const body = document.getElementById('supportWidgetBody');
        const loader = document.getElementById('supportWidgetLoader');
        const badge = document.getElementById('supportWidgetBadge');
        const headerStatus = widget.querySelector('.support-widget__header-status');
        let latestSupportStatus = null;
        let autoRefreshTimer = null;
        let isPanelOpen = false;
        let currentTicketId = null;
        let knownMessageIds = new Set();

        const openPanel = () => {
            panel.setAttribute('aria-hidden', 'false');
            panel.classList.add('is-open');
            if (widget) {
                widget.classList.add('is-open');
            }
            isPanelOpen = true;
            loadData();
            markMessagesRead();
            // Ensure the composer textarea is focusable and not disabled/readonly
            setTimeout(() => {
                try {
                    const ta = panel.querySelector('textarea[name="message"]');
                    if (ta) {
                        ta.removeAttribute('disabled');
                        ta.removeAttribute('readonly');
                        ta.tabIndex = 0;
                        ta.focus({ preventScroll: true });
                    }
                    // Sometimes CSS or other overlays may block pointer events — ensure panel accepts them
                    panel.style.pointerEvents = 'auto';
                } catch (err) {
                    console.error('SupportWidget focus patch error', err);
                }
            }, 150);
        };

        const closePanel = () => {
            panel.classList.remove('is-open');
            panel.setAttribute('aria-hidden', 'true');
            if (widget) {
                widget.classList.remove('is-open');
            }
            isPanelOpen = false;
        };

        async function loadData(options = {}) {
            const { silent = false } = options;

            if (!silent) {
                loader.style.display = 'flex';
            }
            try {
                const data = await fetchWithCsrf(SUPPORT_ENDPOINTS.data, { method: 'GET' });
                latestSupportStatus = data.support_status || null;
                // If user is actively typing in the composer (message textarea or subject input), avoid re-rendering
                const composerTextarea = panel ? panel.querySelector('textarea[name="message"]') : null;
                const subjectInput = panel ? panel.querySelector('input[name="subject"]') : null;
                const isMessageTyping = composerTextarea && (document.activeElement === composerTextarea || (composerTextarea.value && composerTextarea.value.trim().length > 0));
                const isSubjectTyping = subjectInput && (document.activeElement === subjectInput || (subjectInput.value && subjectInput.value.trim().length > 0));
                const isTyping = !!(isMessageTyping || isSubjectTyping);

                if (isTyping) {
                    // Debug: indicate that refresh is skipped when user is typing
                    // Debug log removed in production to avoid console noise
                    // Only update non-destructive pieces (badge/status) and skip syncing to avoid losing input
                    updateBadge(data.unread_count || 0);
                    updateHeaderStatus(latestSupportStatus);
                } else {
                    syncTicket(data.ticket, {
                        forceRender: currentTicketId === null || !document.getElementById('supportWidgetMessages'),
                        status: latestSupportStatus,
                    });
                }
                updateBadge(data.unread_count || 0);
                if (isPanelOpen && Number(data.unread_count || 0) > 0) {
                    await markMessagesRead();
                }
            } catch (error) {
                if (!silent) {
                    body.innerHTML = templates.alert('danger', error.message);
                } else {
                    console.error('Support widget refresh error', error);
                }
            } finally {
                if (!silent) {
                    loader.style.display = 'none';
                }
            }
        }

        async function markMessagesRead() {
            try {
                const response = await fetchWithCsrf(SUPPORT_ENDPOINTS.markRead, { method: 'POST' });
                updateBadge(response.unread_count || 0);
            } catch (error) {
                console.error('Support widget read tracking error', error);
            }
        }

        function updateBadge(count) {
            if (!badge) {
                return;
            }

            const value = Number(count) || 0;
            if (value > 0) {
                badge.textContent = value > 9 ? '9+' : String(value);
                badge.classList.add('is-visible');
            } else {
                badge.classList.remove('is-visible');
            }
        }

        function updateHeaderStatus(status) {
            if (!headerStatus) {
                return;
            }

            const fallback = 'Délai de réponse : 24h maximum';
            const liveBadge = document.getElementById('supportLiveBadge');
            
            if (status && status.active_message) {
                headerStatus.textContent = status.active_message;
                
                // Afficher le badge LIVE seulement si "Actif maintenant" est présent
                if (liveBadge) {
                    if (status.active_message.includes('Actif maintenant')) {
                        liveBadge.style.display = 'inline-block';
                    } else {
                        liveBadge.style.display = 'none';
                    }
                }
            } else {
                headerStatus.textContent = fallback;
                if (liveBadge) {
                    liveBadge.style.display = 'none';
                }
            }
        }

        window.supportWidgetMarkRead = markMessagesRead;

        function startAutoRefresh() {
            const interval = 1000;
            if (autoRefreshTimer) {
                return;
            }
            autoRefreshTimer = setInterval(() => {
                if (document.visibilityState === 'hidden') {
                    return;
                }
                loadData({ silent: true });
            }, interval);
        }

        function stopAutoRefresh() {
            if (!autoRefreshTimer) {
                return;
            }
            clearInterval(autoRefreshTimer);
            autoRefreshTimer = null;
        }

        function resetTicketState() {
            currentTicketId = null;
            knownMessageIds = new Set();
        }

        function renderNewTicketForm() {
            resetTicketState();
            body.innerHTML = templates.newTicketForm;
            const form = document.getElementById('supportWidgetNewTicket');
            handleFormSubmission(form, {
                endpoint: SUPPORT_ENDPOINTS.create,
                onSuccess: (response) => {
                    showAlert(body, 'success', response.message || 'Votre ticket a été créé.');
                    syncTicket(response.ticket, { forceRender: true });
                },
            });
        }

        function renderConversationView(ticket) {
            currentTicketId = ticket.id;
            knownMessageIds = new Set(ticket.messages.map((message) => message.id));
            body.innerHTML = templates.conversation(ticket);
            const replyForm = document.getElementById('supportWidgetReplyForm');
            const messagesContainer = document.getElementById('supportWidgetMessages');

            handleFormSubmission(replyForm, {
                endpoint: SUPPORT_ENDPOINTS.reply(ticket.id),
                onSuccess: (response) => {
                    if (response.entry) {
                        knownMessageIds.add(response.entry.id);
                        messagesContainer.insertAdjacentHTML('beforeend', renderMessage(response.entry));
                        messagesContainer.scrollTop = messagesContainer.scrollHeight;
                        if (typeof window.supportWidgetMarkRead === 'function') {
                            window.supportWidgetMarkRead();
                        }
                    }
                },
            });

            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function syncTicket(ticket, { forceRender = false, status = null } = {}) {
            updateHeaderStatus(status || latestSupportStatus);

            if (!ticket) {
                if (forceRender || currentTicketId !== null || !document.getElementById('supportWidgetNewTicket')) {
                    renderNewTicketForm();
                }
                return;
            }

            if (
                forceRender ||
                currentTicketId === null ||
                currentTicketId !== ticket.id ||
                !document.getElementById('supportWidgetMessages')
            ) {
                renderConversationView(ticket);
                return;
            }

            const messagesContainer = document.getElementById('supportWidgetMessages');
            if (!messagesContainer) {
                renderConversationView(ticket);
                return;
            }

            const newMessages = ticket.messages.filter((message) => !knownMessageIds.has(message.id));
            if (!newMessages.length) {
                return;
            }

            newMessages.forEach((message) => {
                knownMessageIds.add(message.id);
                messagesContainer.insertAdjacentHTML('beforeend', renderMessage(message));
            });
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        toggleBtn.addEventListener('click', () => {
            if (panel.classList.contains('is-open')) {
                closePanel();
            } else {
                openPanel();
            }
        });

        closeBtn.addEventListener('click', closePanel);

        loadData();
        startAutoRefresh();

        window.addEventListener('beforeunload', () => {
            stopAutoRefresh();
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        const isAuthenticated = document.body && document.body.dataset.supportEnabled === '1';
        if (!isAuthenticated) {
            return;
        }
        initSupportWidget();
    });
})();
