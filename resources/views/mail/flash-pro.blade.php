@extends('layouts.admin')

@section('content')
<!-- Summernote (éditeur WYSIWYG sans clé API) -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/lang/summernote-fr-FR.min.js"></script>

<style>
    .notification-custom {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        max-width: 500px;
    }
    .badge-open {
        background: linear-gradient(90deg, #c084fc, #a855f7);
        color: #fff;
    }
    .mail-utilite-modal {
        max-width: 760px;
    }
    .history-scroll {
        max-height: calc(100vh - 150px);
        overflow-y: auto;
        min-height: 400px;
    }
    @media (max-width: 991px) {
        .history-scroll {
            max-height: none;
            min-height: auto;
        }
    }
</style>

<x-tool-back-link label="Retour à la liste des outils" :fallback="route('dashboard')" />

<div class="container-fluid px-4 py-4">
    <div class="row">
        <!-- Colonne gauche : Formulaire d'envoi (66%) -->
        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-envelope-open-text me-2"></i>Mail Pro</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="row align-items-center gy-2">
                            <div class="col-12 col-md">
                                <strong>Crédit(s) actuel : <span id="credits-display">{{ $creditsDisponibles }}</span></strong>
                                <a href="{{ route('recharge.index') }}" class="text-primary ms-2">à savoir</a>
                            </div>
                            <div class="col-12 col-md-auto">
                                <div class="d-flex flex-column flex-sm-row gap-2 justify-content-md-end">
                                    <button type="button" class="btn btn-info text-white w-100 w-md-auto" data-bs-toggle="modal" data-bs-target="#utiliteModal">
                                        <i class="fas fa-info-circle me-2"></i>Utilité et Fonctionnement <i class="fas fa-arrow-right ms-2"></i>
                                    </button>
                                    <div class="btn btn-outline-success w-100 w-md-auto" style="cursor: default;">
                                        <i class="fas fa-envelope me-2"></i>Envoyer un mail pro
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulaire d'envoi -->
                    <form id="mail-form">
                        @csrf
                        
                        <!-- Expéditeur -->
                        <div class="mb-3">
                            <label for="expediteur" class="form-label">Expéditeur (De) <span class="text-danger">. requis</span></label>
                            <input type="text" class="form-control" id="expediteur" name="expediteur" placeholder="Nom de l'expéditeur" required maxlength="255">
                        </div>

                        <!-- Destinataire -->
                        <div class="mb-3">
                            <label for="destinataire" class="form-label">Destinataire (À) <span class="text-danger">. requis</span></label>
                            <input type="email" class="form-control" id="destinataire" name="destinataire" placeholder="Adresse e-mail" required>
                        </div>

                        <!-- Objet -->
                        <div class="mb-3">
                            <label for="objet" class="form-label">Objet <span class="text-danger">. requis</span></label>
                            <input type="text" class="form-control" id="objet" name="objet" placeholder="L'objet de l'e-mail" required maxlength="500">
                        </div>

                        <!-- Contenu de l'e-mail -->
                        <div class="mb-3">
                            <label for="contenu" class="form-label">Contenu de l'e-mail <span class="text-danger">. requis</span></label>
                            <textarea class="form-control" id="contenu" name="contenu" rows="10" placeholder="Rédigez votre message..." required></textarea>
                        </div>

                        <!-- Répondre à (facultatif) -->
                        <div class="mb-3">
                            <label for="adresse_reponse" class="form-label">Répondre à <span class="text-muted">. facultatif</span></label>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>Pour le suivi, vous recevrez la/les réponse(s) de votre destinataire à l'adresse e-mail que vous aurez saisi dans le champ ci-dessous. Si vous ne précisez pas ce champ, la/les réponse(s) de votre destinataire vous seront envoyées à l'email de votre compte <strong>{{ Auth::user()->email }}</strong>.
                            </div>
                            <input type="email" class="form-control" id="adresse_reponse" name="adresse_reponse" placeholder="Votre adresse e-mail">
                        </div>

                        <!-- Joindre un fichier -->
                        <div class="mb-3">
                            <label for="fichier" class="form-label">Joindre un fichier (Pdf, Word, Image)</label>
                            <input type="file" class="form-control" id="fichier" name="fichier" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <small class="text-danger d-block">Taille Maximum : 2 Mo</small>
                            <small class="text-muted">Ajouter une pièce jointe consomme <strong>2000 Crédits</strong> au lieu de 1000.</small>
                        </div>

                        <!-- Bouton d'envoi -->
                        <div class="text-center text-md-end">
                            <button type="submit" class="btn btn-success btn-lg w-100 w-md-auto" id="send-btn" data-base="1000" data-attachment="2000">
                                Envoyer le mail pro (<span id="mail-cost">1000</span> Crédits) <i class="fas fa-paper-plane ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Colonne droite : Historique (33%) -->
        <div class="col-12 col-xl-4">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Historique des envois (<span id="history-count">{{ count($history) }}</span>)</h5>
                </div>
                <div class="p-3 history-scroll">
                    <div id="history-container">
                        @if($history->isEmpty())
                            <p class="text-center text-muted">Aucun envoi pour le moment</p>
                        @else
                            @foreach($history as $item)
                                <div class="border-bottom pb-2 mb-2" style="cursor: pointer;" onclick="showMailDetails({{ $item->id }})">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        @if($item->status === 'Livré')
                                            <span class="badge bg-success">Livré ✓</span>
                                        @elseif($item->status === 'Envoyé')
                                            <span class="badge bg-info">Envoyé ✉</span>
                                        @elseif($item->status === 'Ouvert')
                                            <span class="badge badge-open"><i class="fas fa-envelope-open me-1"></i>Ouvert</span>
                                        @else
                                            <span class="badge bg-danger">Rejeté ⚠</span>
                                        @endif
                                        <small class="text-muted">{{ $item->created_at->format('d/m/y') }} à {{ $item->created_at->format('H:i') }} UTC+0</small>
                                    </div>
                                    <div class="small">
                                        <strong>De {{ $item->expediteur }} à {{ $item->destinataire }}</strong> le {{ $item->created_at->format('d/m/Y') }} à {{ $item->created_at->format('H:i') }} UTC+0
                                        @if($item->opened_at)
                                            <div class="text-muted mt-1">
                                                <i class="fas fa-eye me-1"></i>Ouvert le {{ $item->opened_at->format('d/m/Y') }} à {{ $item->opened_at->format('H:i') }} UTC+0 ({{ $item->open_count ?? 1 }} fois)
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    @if(!$history->isEmpty())
                        <div class="mt-3 text-md-end text-center">
                            <button class="btn btn-danger btn-sm w-100 w-md-auto" onclick="deleteHistory()">
                                <i class="fas fa-trash me-2"></i>Supprimer l'historique des envois
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Utilité et Fonctionnement -->
<div class="modal fade" id="utiliteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable mail-utilite-modal">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-info-circle me-2"></i>Mail Pro - Utilité et Fonctionnement</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div style="background-color: #d1ecf1; border: 1px solid #bee5eb; padding: 20px; border-radius: 5px;">
                    <h4 class="mb-4">📧 Mail Pro : Service de messagerie professionnelle</h4>
                    
                    <h5 class="text-primary mt-4 mb-3">🎯 Utilité du service</h5>
                    <p>Mail Pro vous permet d'envoyer des emails professionnels avec votre propre nom d'expéditeur, idéal pour :</p>
                    <ul>
                        <li>📢 Campagnes marketing et newsletters</li>
                        <li>🔔 Notifications et alertes clients</li>
                        <li>📄 Envoi de documents professionnels</li>
                        <li>🤝 Communication commerciale</li>
                        <li>💼 Prospection et relances clients</li>
                    </ul>

                    <h5 class="text-primary mt-4 mb-3">⚙️ Comment ça fonctionne ?</h5>
                    <ol>
                        <li><strong>Remplissez le formulaire :</strong>
                            <ul>
                                <li>Nom de l'expéditeur (votre nom ou celui de votre entreprise)</li>
                                <li>Adresse email du destinataire</li>
                                <li>Objet de l'email</li>
                                <li>Contenu du message</li>
                                <li>(Optionnel) Adresse de réponse personnalisée</li>
                                <li>(Optionnel) Pièce jointe (PDF, Word, Image - max 2 Mo)</li>
                            </ul>
                        </li>
                        <li><strong>Coût :</strong> 1000 crédits par email envoyé</li>
                        <li><strong>Envoi instantané :</strong> L'email est envoyé immédiatement</li>
                        <li><strong>Suivi :</strong> Consultez l'historique de vos envois avec les statuts</li>
                    </ol>

                    <h5 class="text-primary mt-4 mb-3">📊 Statuts des emails</h5>
                    <div class="mb-2">
                        <span class="badge bg-info">Envoyé</span>
                        <span class="ms-2">Email envoyé avec succès, en attente de confirmation de livraison</span>
                    </div>
                    <div class="mb-2">
                        <span class="badge bg-success">Livré</span>
                        <span class="ms-2">Email confirmé livré au destinataire</span>
                    </div>
                    <div class="mb-2">
                        <span class="badge bg-danger">Rejeté</span>
                        <span class="ms-2">Email non livré (adresse invalide, boîte pleine, etc.) - Crédits remboursés automatiquement</span>
                    </div>

                    <h5 class="text-primary mt-4 mb-3">💡 Conseils d'utilisation</h5>
                    <ul>
                        <li>✅ Utilisez un objet clair et pertinent</li>
                        <li>✅ Personnalisez le nom de l'expéditeur</li>
                        <li>✅ Ajoutez une adresse de réponse pour le suivi</li>
                        <li>✅ Vérifiez l'adresse email du destinataire</li>
                        <li>⚠️ Respectez les règles anti-spam</li>
                        <li>⚠️ N'envoyez que des emails sollicités</li>
                    </ul>

                    <h5 class="text-primary mt-4 mb-3">🔒 Sécurité et confidentialité</h5>
                    <p>Vos données sont sécurisées et vos emails sont envoyés via des serveurs professionnels fiables. Nous ne partageons jamais vos informations avec des tiers.</p>

                    <div class="alert alert-warning mt-4">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Important :</strong> L'envoi d'emails non sollicités (spam) est strictement interdit et peut entraîner la suspension de votre compte.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Détails -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-envelope-open-text me-2"></i>Détails de l'email</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="details-content">
                <!-- Contenu chargé dynamiquement -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialisation Summernote avec une barre d'outils riche
    $('#contenu').summernote({
        height: 260,
        lang: 'fr-FR',
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link', 'table', 'hr']],
            ['view', ['codeview', 'fullscreen']]
        ]
    });

    const form = document.getElementById('mail-form');
    const sendBtn = document.getElementById('send-btn');
    const fileInput = document.getElementById('fichier');
    const defaultButtonMarkup = sendBtn.innerHTML;

    function getMailCostElement() {
        return document.getElementById('mail-cost');
    }

    function updateCost() {
        const hasFile = fileInput.value.trim() !== '';
        const cost = hasFile ? sendBtn.dataset.attachment : sendBtn.dataset.base;
        const mailCost = getMailCostElement();
        if (mailCost) {
            mailCost.textContent = cost;
        }
    }

    fileInput.addEventListener('change', updateCost);
    updateCost();

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Récupérer le contenu depuis Summernote
        const contenu = $('#contenu').summernote('code');
        
        const formData = new FormData(form);
        formData.set('contenu', contenu); // Mettre à jour avec le contenu formaté
        
        sendBtn.disabled = true;
        sendBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Envoi en cours...';

        fetch('{{ route("mail.flash.pro.send") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('✓ ' + data.message, 'success');
                
                // Update credits
                document.getElementById('credits-display').textContent = data.credits_restants;

                // Reset form
                form.reset();
                $('#contenu').summernote('code', '');

                // Refresh page after 2 seconds
                setTimeout(() => {
                    location.reload();
                }, 2000);
            } else {
                showNotification('✗ ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('✗ Erreur lors de l\'envoi de l\'email', 'error');
        })
        .finally(() => {
            sendBtn.disabled = false;
            sendBtn.innerHTML = defaultButtonMarkup;
            updateCost();
        });
    });
});

function showNotification(message, type) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const notification = document.createElement('div');
    notification.className = `alert ${alertClass} alert-dismissible notification-custom`;
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
    `;
    document.body.appendChild(notification);
}

function showMailDetails(id) {
    fetch(`/mail/flash-pro/details/${id}`)
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                const mail = data.mail;
                const date = new Date(mail.created_at);
                const openedAt = mail.opened_at ? new Date(mail.opened_at) : null;
                const dateStr = date.toLocaleDateString('fr-FR', { day: '2-digit', month: '2-digit', year: 'numeric' });
                const timeStr = date.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
                const openedDateStr = openedAt ? openedAt.toLocaleDateString('fr-FR', { day: '2-digit', month: '2-digit', year: 'numeric' }) : null;
                const openedTimeStr = openedAt ? openedAt.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' }) : null;
                
                let statusBadge = '';
                if(mail.status === 'Livré') {
                    statusBadge = '<span class="badge bg-success">Livré ✓</span>';
                } else if(mail.status === 'Envoyé') {
                    statusBadge = '<span class="badge bg-info">Envoyé ✉</span>';
                } else if(mail.status === 'Ouvert') {
                    statusBadge = '<span class="badge badge-open"><i class="fas fa-envelope-open me-1"></i>Ouvert</span>';
                } else {
                    statusBadge = '<span class="badge bg-danger">Rejeté ⚠</span>';
                }
                
                const content = document.getElementById('details-content');
                content.innerHTML = `
                    <div class="mb-3">
                        <strong>Expéditeur :</strong> ${mail.expediteur}
                    </div>
                    <div class="mb-3">
                        <strong>Destinataire :</strong> ${mail.destinataire}
                    </div>
                    <div class="mb-3">
                        <strong>Objet :</strong> ${mail.objet}
                    </div>
                    <div class="mb-3">
                        <strong>Message :</strong>
                        <div class="border p-2 mt-2" style="max-height: 300px; overflow-y: auto;">
                            ${mail.contenu}
                        </div>
                    </div>
                    ${mail.adresse_reponse ? `
                    <div class="mb-3">
                        <strong>Adresse de réponse :</strong> ${mail.adresse_reponse}
                    </div>
                    ` : ''}
                    ${mail.fichier_joint ? `
                    <div class="mb-3">
                        <strong>Fichier joint :</strong> <a href="/storage/${mail.fichier_joint}" target="_blank">Télécharger</a>
                    </div>
                    ` : ''}
                    <div class="mb-3">
                        <strong>Coût d'envoi :</strong> ${mail.credits_used} Crédits
                    </div>
                    <div class="mb-3">
                        <strong>Date d'envoi :</strong> ${dateStr} à ${timeStr} UTC+0
                    </div>
                    <div class="mb-3">
                        <strong>Statut :</strong> ${statusBadge}
                    </div>
                    ${openedAt ? `
                    <div class="mb-3">
                        <strong>Ouverture :</strong> ${openedDateStr} à ${openedTimeStr} UTC+0
                        <span class="badge bg-secondary ms-2">${mail.open_count || 1} ouverture(s)</span>
                    </div>
                    ` : ''}
                    ${mail.error_message ? `
                    <div class="alert alert-danger">
                        <strong>Message d'erreur :</strong> ${mail.error_message}
                    </div>
                    ` : ''}
                `;
                
                const modal = new bootstrap.Modal(document.getElementById('detailsModal'));
                modal.show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('✗ Erreur lors du chargement des détails', 'error');
        });
}

function deleteHistory() {
    if (!confirm('Êtes-vous sûr de vouloir supprimer tout l\'historique ?')) {
        return;
    }

    fetch('{{ route("mail.flash.pro.delete-history") }}', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('✓ ' + data.message, 'success');
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            showNotification('✗ Erreur lors de la suppression', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('✗ Erreur lors de la suppression', 'error');
    });
}
</script>
@endsection
