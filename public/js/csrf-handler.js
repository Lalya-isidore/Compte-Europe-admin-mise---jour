/**
 * Gestion globale des erreurs CSRF (419) pour FlashCompte
 * 
 * Ce script gère automatiquement les sessions expirées et propose
 * des solutions à l'utilisateur sans perdre ses données.
 */

document.addEventListener('DOMContentLoaded', function() {
    // Intercepter toutes les requêtes de formulaires
    document.addEventListener('submit', function(e) {
        const form = e.target;
        
        // Si c'est un formulaire avec CSRF
        if (form.querySelector('input[name="_token"]')) {
            // Vérifier si le token semble expiré (plus de 2 heures)
            const tokenField = form.querySelector('input[name="_token"]');
            if (tokenField && isTokenExpired()) {
                e.preventDefault();
                showTokenExpiredModal(form);
                return false;
            }
        }
    });

    // Intercepter les requêtes AJAX pour détecter les erreurs 419
    if (window.fetch) {
        const originalFetch = window.fetch;
        window.fetch = function(...args) {
            return originalFetch.apply(this, args)
                .then(response => {
                    if (response.status === 419) {
                        handleTokenExpired();
                    }
                    return response;
                })
                .catch(error => {
                    console.error('Erreur de requête:', error);
                    return Promise.reject(error);
                });
        };
    }
});

/**
 * Vérifier si le token CSRF semble expiré
 */
function isTokenExpired() {
    // Vérifier l'âge de la page (approximatif)
    const pageLoadTime = performance.timing.navigationStart;
    const currentTime = Date.now();
    const pageAge = (currentTime - pageLoadTime) / 1000 / 60; // en minutes
    
    // Si la page est ouverte depuis plus de 110 minutes (token expire à 120min)
    return pageAge > 110;
}

/**
 * Afficher un modal d'alerte pour token expiré
 */
function showTokenExpiredModal(form) {
    // Créer le modal dynamiquement
    const modalHtml = `
        <div class="modal fade" id="tokenExpiredModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Session sur le point d'expirer
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Votre session est sur le point d'expirer. Pour continuer en toute sécurité :</p>
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-primary" onclick="refreshAndSubmit()">
                                <i class="fas fa-redo me-2"></i>
                                Actualiser et soumettre le formulaire
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="refreshPage()">
                                <i class="fas fa-sync me-2"></i>
                                Juste actualiser la page
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

    // Ajouter le modal au DOM s'il n'existe pas
    if (!document.getElementById('tokenExpiredModal')) {
        document.body.insertAdjacentHTML('beforeend', modalHtml);
    }

    // Stocker la référence du formulaire
    window.pendingForm = form;

    // Afficher le modal
    const modal = new bootstrap.Modal(document.getElementById('tokenExpiredModal'));
    modal.show();
}

/**
 * Gérer l'expiration du token détectée via AJAX
 */
function handleTokenExpired() {
    showNotification('Session expirée', 'Votre session a expiré. La page va être actualisée.', 'warning');
    
    // Actualiser automatiquement après 3 secondes
    setTimeout(() => {
        window.location.reload();
    }, 3000);
}

/**
 * Actualiser la page et soumettre le formulaire
 */
function refreshAndSubmit() {
    if (window.pendingForm) {
        // Sauvegarder les données du formulaire dans sessionStorage
        const formData = new FormData(window.pendingForm);
        const savedData = {};
        
        for (let [key, value] of formData.entries()) {
            if (key !== '_token') {
                savedData[key] = value;
            }
        }
        
        sessionStorage.setItem('savedFormData', JSON.stringify(savedData));
        sessionStorage.setItem('shouldResubmit', 'true');
    }
    
    refreshPage();
}

/**
 * Actualiser la page
 */
function refreshPage() {
    window.location.reload();
}

/**
 * Restaurer les données du formulaire après refresh
 */
function restoreFormData() {
    const savedData = sessionStorage.getItem('savedFormData');
    const shouldResubmit = sessionStorage.getItem('shouldResubmit');
    
    if (savedData) {
        const data = JSON.parse(savedData);
        
        // Remplir les champs du formulaire
        Object.keys(data).forEach(key => {
            const field = document.querySelector(`[name="${key}"]`);
            if (field) {
                field.value = data[key];
            }
        });

        // Nettoyer le stockage
        sessionStorage.removeItem('savedFormData');
        
        // Soumettre automatiquement si demandé
        if (shouldResubmit === 'true') {
            sessionStorage.removeItem('shouldResubmit');
            
            // Attendre un peu pour que l'utilisateur voit les données restaurées
            setTimeout(() => {
                const form = document.querySelector('form');
                if (form && confirm('Souhaitez-vous soumettre le formulaire avec les données restaurées ?')) {
                    form.submit();
                }
            }, 1000);
        }
    }
}

/**
 * Afficher une notification toast
 */
function showNotification(title, message, type = 'info') {
    // Créer une notification toast Bootstrap
    const toastHtml = `
        <div class="toast align-items-center text-white bg-${type === 'warning' ? 'warning' : 'primary'} border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <strong>${title}</strong><br>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `;

    // Container pour les toasts
    let toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
        document.body.appendChild(toastContainer);
    }

    // Ajouter le toast
    toastContainer.insertAdjacentHTML('beforeend', toastHtml);
    
    // Activer le toast
    const toastElement = toastContainer.lastElementChild;
    const toast = new bootstrap.Toast(toastElement);
    toast.show();

    // Supprimer le toast après fermeture
    toastElement.addEventListener('hidden.bs.toast', () => {
        toastElement.remove();
    });
}

// Restaurer les données au chargement de la page
document.addEventListener('DOMContentLoaded', restoreFormData);