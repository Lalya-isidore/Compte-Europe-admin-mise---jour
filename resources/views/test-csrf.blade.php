@extends('layouts.admin')

@section('title', 'Test Session CSRF')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Test de gestion des sessions expirées</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Cette page permet de tester la gestion automatique des sessions expirées.
                    </div>

                    <!-- Test de formulaire normal -->
                    <div class="mb-4">
                        <h6>Test formulaire normal :</h6>
                        <form action="{{ route('affiliation.index') }}" method="GET" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-1"></i>
                                Soumettre formulaire
                            </button>
                        </form>
                        
                        <button class="btn btn-warning ms-2" onclick="expireToken()">
                            <i class="fas fa-clock me-1"></i>
                            Simuler expiration token
                        </button>
                    </div>

                    <!-- Test AJAX -->
                    <div class="mb-4">
                        <h6>Test requête AJAX :</h6>
                        <button class="btn btn-info" onclick="testAjax()">
                            <i class="fas fa-sync me-1"></i>
                            Test AJAX avec CSRF
                        </button>
                        
                        <div id="ajax-result" class="mt-2"></div>
                    </div>

                    <!-- Informations sur la session -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Informations session</h6>
                                    <p><strong>Token CSRF :</strong> <code id="csrf-token">{{ csrf_token() }}</code></p>
                                    <p><strong>Session ID :</strong> <code>{{ session()->getId() }}</code></p>
                                    <p><strong>Durée de vie :</strong> {{ config('session.lifetime') }} minutes</p>
                                    <p><strong>Driver :</strong> {{ config('session.driver') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Actions de test</h6>
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-success" onclick="refreshToken()">
                                            <i class="fas fa-redo me-1"></i>
                                            Rafraîchir le token
                                        </button>
                                        <button class="btn btn-danger" onclick="clearSession()">
                                            <i class="fas fa-trash me-1"></i>
                                            Vider la session
                                        </button>
                                        <button class="btn btn-secondary" onclick="window.location.reload()">
                                            <i class="fas fa-sync me-1"></i>
                                            Actualiser la page
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Fonction pour simuler l'expiration du token
function expireToken() {
    // Modifier le token CSRF pour le rendre invalide
    const tokenFields = document.querySelectorAll('input[name="_token"]');
    tokenFields.forEach(field => {
        field.value = 'invalid_token_' + Math.random();
    });
    
    // Mettre à jour l'affichage
    document.getElementById('csrf-token').textContent = 'TOKEN EXPIRÉ (simulé)';
    
    showNotification('Token expiré', 'Le token CSRF a été invalidé pour le test', 'warning');
}

// Test d'une requête AJAX avec CSRF
function testAjax() {
    const resultDiv = document.getElementById('ajax-result');
    resultDiv.innerHTML = '<div class="spinner-border spinner-border-sm"></div> Test en cours...';

    fetch('{{ route("affiliation.index") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 'invalid',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ test: true })
    })
    .then(response => {
        if (response.status === 419) {
            resultDiv.innerHTML = '<div class="alert alert-warning">Erreur 419 détectée - Session expirée !</div>';
        } else {
            resultDiv.innerHTML = '<div class="alert alert-success">Requête réussie !</div>';
        }
    })
    .catch(error => {
        resultDiv.innerHTML = '<div class="alert alert-danger">Erreur : ' + error.message + '</div>';
    });
}

// Rafraîchir le token CSRF
function refreshToken() {
    window.location.reload();
}

// Vider la session (simulation)
function clearSession() {
    if (confirm('Voulez-vous vraiment simuler la suppression de la session ?')) {
        // Simuler en invalidant tous les tokens
        expireToken();
        showNotification('Session vidée', 'Session simulée comme supprimée', 'info');
    }
}

// Notification helper (réutilise la fonction du csrf-handler.js)
function showNotification(title, message, type = 'info') {
    const toastHtml = `
        <div class="toast align-items-center text-white bg-${type === 'warning' ? 'warning' : (type === 'info' ? 'info' : 'success')} border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <strong>${title}</strong><br>${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `;

    let toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
        document.body.appendChild(toastContainer);
    }

    toastContainer.insertAdjacentHTML('beforeend', toastHtml);
    const toast = new bootstrap.Toast(toastContainer.lastElementChild);
    toast.show();
}
</script>
@endsection