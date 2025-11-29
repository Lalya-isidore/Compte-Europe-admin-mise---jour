@extends('layouts.admin')

@section('title', 'Modifier la photo du compte')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Accueil</a> / Modifier la photo du compte
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="app-card">
                    <h3 class="mb-3">Modifier la photo d'un compte</h3>
                    <p class="text-muted">Entrez l'ID du compte, chargez ses informations puis téléversez une nouvelle image.</p>

                    <div class="mb-3">
                        <label for="compteId" class="form-label">ID du compte</label>
                        <div class="input-group">
                            <input type="number" id="compteId" class="form-control" placeholder="Ex: 123" min="1">
                            <button id="loadCompte" class="btn btn-primary">Charger</button>
                        </div>
                    </div>

                    <div id="compteInfo" style="display:none">
                        <div class="mb-3">
                            <label class="form-label">Aperçu actuel</label>
                            <div>
                                <img id="comptePhotoPreview" src="https://via.placeholder.com/150" alt="Photo" class="img-thumbnail" style="max-width:150px">
                            </div>
                        </div>

                        <div class="alert alert-info">
                            Seul le propriétaire du compte peut modifier sa photo de profil via son espace personnel. L'administration peut voir et prévisualiser la photo ici, mais ne peut pas la modifier.
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" id="clearForm" class="btn btn-secondary">Réinitialiser</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const loadBtn = document.getElementById('loadCompte');
            const compteIdInput = document.getElementById('compteId');
            const compteInfo = document.getElementById('compteInfo');
            const preview = document.getElementById('comptePhotoPreview');
            const photoForm = document.getElementById('photoForm');
            const clearBtn = document.getElementById('clearForm');

            loadBtn.addEventListener('click', async function (e) {
                e.preventDefault();
                const id = compteIdInput.value.trim();
                if (!id) {
                    alert('Veuillez saisir un ID de compte valide.');
                    return;
                }

                try {
                    const res = await fetch(`/compte/${id}/details`);
                    if (!res.ok) throw new Error('Compte introuvable');
                    const data = await res.json();

                    // Récupérer le chemin brut (priorité à la valeur complète fournie en photo_url)
                    // Si le contrôleur a déjà renvoyé une URL publique (photo_url), on l'utilise directement.
                    let photoUrl = data.photo_url || null;
                    if (!photoUrl) {
                        // Récupérer chemin brut depuis photo_path (ou variante camelCase)
                        const rawPath = data.photo_path || data.photoPath || '';
                        console.log('DEBUG raw path:', rawPath); // Pour debugging dans la console

                        // Nettoyer le chemin si l'API a déjà préfixé '/storage/'
                        const cleanPath = rawPath.replace(/^\/storage\//, '');

                        // Construire l'URL finale en relative (sans leading slash) pour gérer les sous-dossiers d'app
                        photoUrl = rawPath ? `storage/${cleanPath}` : null;
                        console.log('DEBUG final URL (relative):', photoUrl);
                    }

                    // Fallback vers un avatar généré si aucune image n'est disponible
                    preview.src = photoUrl ? photoUrl : `https://ui-avatars.com/api/?name=${encodeURIComponent((data.nom||data.name||'C')+' '+(data.prenom||''))}&size=256`;

                    // Make form post target to the update-photo route
                    photoForm.action = `/compte/${id}/update-photo`;
                    compteInfo.style.display = 'block';
                } catch (err) {
                    alert('Impossible de charger le compte : ' + (err.message || err));
                    compteInfo.style.display = 'none';
                }
            });

            photoForm.addEventListener('submit', function (e) {
                // Let normal form submission happen (POST to the configured action)
                if (!photoForm.action || photoForm.action === '#') {
                    e.preventDefault();
                    alert("Aucun compte chargé. Saisissez un ID puis cliquez sur 'Charger'.");
                }
            });

            clearBtn.addEventListener('click', function () {
                compteIdInput.value = '';
                compteInfo.style.display = 'none';
                preview.src = 'https://via.placeholder.com/150';
            });
        })();
    </script>

@endsection
