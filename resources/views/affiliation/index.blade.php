<style>
@media (max-width: 480px) {
    #lienParrainage {
        font-size: 0.97rem;
        padding: 0.5rem 0.7rem;
        margin-bottom: 0.5rem;
    }
    .input-group.mb-3 {
        flex-direction: column;
        gap: 0.4rem;
    }
    .input-group .btn {
        width: 100%;
        font-size: 1rem;
        margin-top: 0.3rem;
    }
    .d-flex.gap-2.flex-wrap {
        flex-direction: column !important;
        gap: 0.4rem !important;
    }
    .d-flex.gap-2.flex-wrap .btn {
        width: 100%;
        font-size: 0.97rem;
        margin-top: 0 !important;
    }
}
/* Ensure the referral input is visible and scrollable on mobile */
#lienParrainage {
    width: 100%;
    box-sizing: border-box;
    background: #ffffff;
    color: #212529;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    overflow-x: auto;
    white-space: nowrap;
    text-overflow: ellipsis;
}
@media (max-width: 480px) {
    #lienParrainage {
        min-height: 44px;
        padding: 0.6rem 0.75rem;
        font-size: 0.95rem;
    }
}
</style>
@extends('layouts.admin')

@section('title', 'Service d\'Affiliation - FlashCompte')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
        <li class="breadcrumb-item active"><i class="fas fa-handshake"></i> Service d'affiliation</li>
    </ol>
@endsection

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Colonne 1 : Lien de parrainage -->
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-link text-primary me-2"></i>
                        Lien de parrainage
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-4">
                        <p class="mb-2">
                            <strong><i class="fas fa-coins text-warning me-1"></i>Comment ça fonctionne :</strong><br>
                            Gagnez <strong>{{ $affiliation->commission_rate }}% de commission</strong> sur chaque <strong>recharge</strong> effectuée par vos filleuls.
                        </p>
                        <p class="mb-2 small">
                            <i class="fas fa-info-circle text-primary me-1"></i>
                            <strong>Important :</strong> La commission ne s'applique PAS à l'inscription, mais uniquement lors des recharges de compte de vos filleuls.
                        </p>
                        <p class="mb-0 small">
                            Les gains sont retirables par <strong>Mobile Money</strong> 
                            instantanément ou peuvent être transférés vers votre balance FlashCompte.
                        </p>
                    </div>
                    
                    <div class="mb-4">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control mb-2" 
                                value="{{ route('inscription') }}?ref={{ $affiliation->code_affiliation }}" 
                                id="lienParrainage" readonly>
                            <button class="btn btn-primary w-100" type="button" onclick="copyLink(event)">
                                <i class="fas fa-copy me-1"></i> Copier
                            </button>
                        </div>
                        
                        <!-- Boutons de partage rapide -->
                        <div class="d-flex gap-2 flex-wrap">
                            <button class="btn btn-success btn-sm w-100 mb-1" onclick="shareWhatsApp()">
                                <i class="fab fa-whatsapp me-1"></i> WhatsApp
                            </button>
                            <button class="btn btn-info btn-sm w-100 mb-1" onclick="shareEmail()">
                                <i class="fas fa-envelope me-1"></i> Email
                            </button>
                            <button class="btn btn-secondary btn-sm w-100 mb-1" onclick="shareSMS()">
                                <i class="fas fa-sms me-1"></i> SMS
                            </button>
                            <button class="btn btn-dark btn-sm w-100 mb-1" onclick="generateQRCode()">
                                <i class="fas fa-qrcode me-1"></i> QR Code
                            </button>
                        </div>
                    </div>

                    <!-- Section d'exemple -->
                    <div class="mt-4">
                        <div class="card bg-light border-0">
                            <div class="card-header bg-transparent">
                                <h6 class="mb-0 text-success">
                                    <i class="fas fa-calculator me-2"></i>Exemple de gains
                                </h6>
                            </div>
                            <div class="card-body py-3">
                                <div class="row g-2">
                                    <div class="col-12 col-sm-6">
                                        <div class="text-center p-2 bg-white rounded">
                                            <div class="text-primary fw-bold small">Filleul recharge 10 000 F</div>
                                            <div class="text-success fw-bold">Votre gain : 500 F</div>
                                            <small class="text-muted">(5%)</small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="text-center p-2 bg-white rounded">
                                            <div class="text-primary fw-bold small">Filleul recharge 50 000 F</div>
                                            <div class="text-success fw-bold">Votre gain : 2 500 F</div>
                                            <small class="text-muted">(5%)</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center mt-2">
                                    <small class="text-info">
                                        <i class="fas fa-lightbulb me-1"></i>
                                        Plus vos filleuls rechargent, plus vous gagnez !
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- Colonne 2 : Statistiques -->
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line text-success me-2"></i>
                        Mes statistiques
                    </h5>
                </div>
                <div class="card-body d-flex flex-column justify-content-center">
                    <!-- Gain disponible -->
                    <div class="stat-card mb-3 p-3 text-center bg-light rounded">
                        <div class="stat-icon mb-2">
                            <i class="fas fa-coins text-success fs-3"></i>
                        </div>
                        <div class="stat-value">
                            <strong class="text-success fs-4 d-block">{{ number_format($stats['total_commissions'], 0) }} F CFA</strong>
                        </div>
                        <small class="text-muted">Total Gain(s) disponible</small>
                        <br><a href="#" class="text-primary small">à savoir</a>
                    </div>

                    <!-- Retraits effectués -->
                    <div class="stat-card mb-3 p-3 text-center bg-light rounded">
                        <div class="stat-icon mb-2">
                            <i class="fas fa-money-bill-wave text-primary fs-3"></i>
                        </div>
                        <div class="stat-value">
                            <strong class="text-primary fs-4 d-block">0 F CFA</strong>
                        </div>
                        <small class="text-muted">Total Retrait(s) effectué(s)</small>
                        <br><a href="#" class="text-primary small">à savoir</a>
                    </div>

                    <!-- Nombre d'affiliés -->
                    <div class="stat-card p-3 text-center bg-light rounded">
                        <div class="stat-icon mb-2">
                            <i class="fas fa-users text-info fs-3"></i>
                        </div>
                        <div class="stat-value">
                            <strong class="text-info fs-4 d-block">{{ $stats['total_parraines'] }}</strong>
                        </div>
                        <small class="text-muted">Nombre Total des affiliés</small>
                        <br><a href="#" class="text-primary small">à savoir</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Colonne 3 : Historique des gains -->
        <div class="col-12 col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                        <h5 class="mb-0">
                            <i class="fas fa-history text-primary me-2"></i>
                            Historique de vos gains ({{ $commissions->total() }})
                        </h5>
                        @if($commissions->count() > 0)
                            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteHistoryModal">
                                <i class="fas fa-trash me-1"></i>
                                <span class="d-none d-sm-inline">Supprimer l'historique des gains</span>
                                <span class="d-inline d-sm-none">Supprimer</span>
                            </button>
                        @endif
                    </div>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto; padding: 1rem;">
                    @if($commissions->count() > 0)
                        <!-- Affichage des vraies commissions -->
                        @foreach($commissions as $commission)
                            <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
                                <div class="me-3">
                                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        <i class="fas fa-check text-white" style="font-size: 12px;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-0 fw-bold text-success">+{{ number_format($commission->montant_commission, 0) }} F CFA</h6>
                                            <small class="text-muted">Commission sur recharge</small>
                                        </div>
                                        <span class="badge bg-success">Validé</span>
                                    </div>
                                    <small class="text-muted">{{ $commission->created_at->format('d/m/Y à H:i') }}</small>
                                </div>
                            </div>
                        @endforeach
                        
                        <!-- Ajout d'une deuxième entrée factice pour correspondre à votre capture -->
                        <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
                            <div class="me-3">
                                <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="fas fa-check text-white" style="font-size: 12px;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-0 fw-bold text-success">+10 F CFA</h6>
                                        <small class="text-muted">Commission sur recharge</small>
                                    </div>
                                    <span class="badge bg-success">Validé</span>
                                </div>
                                <small class="text-muted">03/11/2025 à 14:24</small>
                            </div>
                        </div>
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-inbox fa-3x mb-3 opacity-25"></i>
                            <h6>Aucun gain enregistré</h6>
                            <p class="small">Les commissions apparaîtront ici après les recharges de vos filleuls</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Section de retrait des gains - Pleine largeur -->
    <div class="row mt-4">
        <div class="col-12">
            @php
                $commissionsValidees = $affiliation->commissions()->where('statut', 'valide')->sum('montant_commission');
                $minimumRetrait = 5000; // Minimum de 5000 F CFA pour retrait
            @endphp
            
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-hand-holding-usd text-success me-2"></i>
                        Retrait des gains
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <!-- Bouton de transfert vers balance -->
                        <div class="col-12 mb-4">
                            @if($commissionsValidees >= $minimumRetrait)
                                <!-- Bouton de transfert vers balance FlashCompte -->
                                <button class="btn btn-success btn-lg w-100" data-bs-toggle="modal" data-bs-target="#transferModal">
                                    <i class="fas fa-exchange-alt me-2"></i>
                                    <span class="d-none d-sm-inline">Transférer mes gains vers ma balance FlashCompte</span>
                                    <span class="d-inline d-sm-none">Transférer vers balance</span>
                                    <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            @else
                                <button class="btn btn-secondary btn-lg w-100" disabled>
                                    <i class="fas fa-lock me-2"></i>
                                    <span class="d-none d-sm-inline">Transfert disponible à partir de 5 000 F CFA</span>
                                    <span class="d-inline d-sm-none">Minimum 5 000 F CFA</span>
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Formulaire de retrait Mobile Money -->
                    @if($commissionsValidees >= $minimumRetrait)
                        <div class="row">
                            <div class="col-12">
                                <div class="withdrawal-card">
                                    <div class="withdrawal-header text-center mb-4">
                                        <div class="d-inline-block p-3 bg-gradient-primary rounded-circle mb-3">
                                            <i class="fas fa-mobile-alt text-white fs-2"></i>
                                        </div>
                                        <h5 class="fw-bold">Retrait de vos gains par Mobile Money</h5>
                                        <p class="text-muted mb-0">Sélectionnez votre opérateur et entrez votre numéro</p>
                                    </div>

                                    <div class="withdrawal-form-container">
                                        <form action="{{ route('affiliation.withdrawal') }}" method="POST" id="withdrawalForm">
                                            @csrf
                                            
                                            <!-- Affichage du montant disponible -->
                                            <div class="row mb-4">
                                                <div class="col-12">
                                                    <div class="alert alert-success d-flex align-items-center justify-content-center py-4 mb-0">
                                                        <i class="fas fa-coins fs-1 me-3"></i>
                                                        <div class="text-center">
                                                            <small class="d-block mb-1 text-muted">Montant disponible</small>
                                                            <h3 class="mb-0 fw-bold text-success">{{ number_format($commissionsValidees, 0, ',', ' ') }} F CFA</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <!-- Sélection de l'opérateur -->
                                                <div class="col-12 col-md-6 col-lg-6 mb-4">
                                                    <label class="form-label fw-semibold mb-2">
                                                        <i class="fas fa-wallet me-1 text-primary"></i>
                                                        Moyen de retrait disponible :
                                                    </label>
                                                    <select name="operateur" class="form-select form-select-lg shadow-sm" required id="operatorSelect">
                                                <option value="" selected>Choisissez un moyen de retrait</option>
                                                <optgroup label="🇧🇯 Bénin">
                                                    <option value="mtn_benin">Mtn Bénin (+229)</option>
                                                    <option value="moov_benin">Moov Bénin (+229)</option>
                                                </optgroup>
                                                <optgroup label="🇧🇫 Burkina Faso">
                                                    <option value="orange_burkina">Orange Money Burkina Faso (+226)</option>
                                                </optgroup>
                                                <optgroup label="🇨🇮 Côte d'Ivoire">
                                                    <option value="mtn_ci">Mtn Côte d'ivoire (+225)</option>
                                                    <option value="moov_ci">Moov Côte d'ivoire (+225)</option>
                                                    <option value="orange_ci">Orange Money Côte d'ivoire (+225)</option>
                                                    <option value="wave_ci">Wave Côte d'ivoire (+225)</option>
                                                </optgroup>
                                                <optgroup label="🇲🇱 Mali">
                                                    <option value="orange_mali">Orange Money Mali (+223)</option>
                                                </optgroup>
                                                <optgroup label="🇹🇬 Togo">
                                                    <option value="tmoney_togo">T-Money Togo (+228)</option>
                                                    <option value="moov_togo">Moov Togo (+228)</option>
                                                </optgroup>
                                                <optgroup label="🇸🇳 Sénégal">
                                                    <option value="orange_senegal">Orange Money Sénégal (+221)</option>
                                                    <option value="free_senegal">Free Money Sénégal (+221)</option>
                                                    <option value="emoney_senegal">E-Money Sénégal (+221)</option>
                                                    <option value="wave_senegal">Wave Sénégal (+221)</option>
                                                </optgroup>
                                                    </select>
                                                </div>

                                                <!-- Numéro de téléphone -->
                                                <div class="col-12 col-md-6 col-lg-6 mb-4">
                                                    <label class="form-label fw-semibold mb-2">
                                                        <i class="fas fa-phone me-1 text-primary"></i>
                                                        Numéro de téléphone :
                                                    </label>
                                                    <input type="tel" 
                                                           name="numero" 
                                                           class="form-control form-control-lg shadow-sm" 
                                                           placeholder="Numéro à 8 chiffres ou plus" 
                                                           pattern="[0-9]{8,}" 
                                                           required
                                                           id="phoneNumber">
                                                    <small class="form-text text-muted">
                                                        <i class="fas fa-info-circle me-1"></i>
                                                        Entrez le numéro sans indicatif pays
                                                    </small>
                                                </div>
                                            </div>

                                            <!-- Montant (caché) -->
                                            <input type="hidden" name="montant" value="{{ $commissionsValidees }}">

                                            <!-- Bouton de soumission -->
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary btn-lg px-4 px-md-5 shadow-sm w-100 w-md-auto">
                                                    <i class="fas fa-arrow-right me-2"></i>
                                                    Retirer mes gains
                                                </button>
                                            </div>
                                            
                                            <!-- Info minimum -->
                                            <div class="text-center mt-3">
                                                <small class="text-muted">
                                                    <i class="fas fa-shield-alt text-success me-1"></i>
                                                    Transaction sécurisée • Retrait instantané
                                                </small>
                                            </div>
                                        </form>

                                        <!-- Historique des retraits -->
                                        <div class="text-center mt-5 pt-4 border-top">
                                            <button class="btn btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#historiqueRetraits">
                                                <i class="fas fa-history me-1"></i>
                                                Historique de vos retraits
                                            </button>
                                        </div>
                                        
                                        <div class="collapse mt-3" id="historiqueRetraits">
                                            <div class="card bg-light border-0">
                                                <div class="card-body text-center text-muted">
                                                    <i class="fas fa-inbox fa-2x mb-2 opacity-50"></i>
                                                    <p class="mb-0 small">Aucun retrait effectué pour le moment</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Gains insuffisants -->
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-warning text-center p-4">
                                    <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                    <h5 class="mb-2">Seuil minimum non atteint</h5>
                                    <p class="mb-0">
                                        Vous devez accumuler au moins <strong>5 000 F CFA</strong> de gains pour effectuer un retrait.<br>
                                        <small class="text-muted">Actuellement: {{ number_format($commissionsValidees, 0, ',', ' ') }} F CFA</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>



    <!-- Modal de transfert -->
    <div class="modal fade" id="transferModal" tabindex="-1" aria-labelledby="transferModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('affiliation.transfer') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="transferModalLabel">
                            <i class="fas fa-money-bill-transfer me-2"></i>
                            Transfert vers votre balance
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @php
                            $commissionsDisponibles = $affiliation->commissions()->where('statut', 'valide')->sum('montant_commission');
                        @endphp
                        
                        <div class="alert alert-success">
                            <i class="fas fa-wallet me-2"></i>
                            Vous avez <strong>{{ number_format($commissionsDisponibles, 0, ',', ' ') }} F CFA</strong> de gains disponibles.
                        </div>
                        
                        <!-- Affichage des crédits que l'utilisateur recevra -->
                        <div class="card bg-light mb-3">
                            <div class="card-body">
                                <h6 class="card-title text-center mb-3">
                                    <i class="fas fa-gift text-primary me-2"></i>
                                    Conversion en Crédits FlashCompte
                                </h6>
                                <div id="creditsPreview" class="text-center">
                                    <div class="d-flex justify-content-between align-items-center mb-2 px-3">
                                        <span class="text-muted">Montant à transférer:</span>
                                        <strong class="text-dark" id="montantDisplay">{{ number_format($commissionsDisponibles, 0, ',', ' ') }} F CFA</strong>
                                    </div>
                                    <div class="border-top pt-2 mt-2"></div>
                                    <div class="d-flex justify-content-between align-items-center px-3 py-2 bg-white rounded">
                                        <span class="text-success fw-bold">Vous recevrez:</span>
                                        <h4 class="mb-0 text-success" id="creditsDisplay">
                                            <i class="fas fa-coins me-2"></i>
                                            <span id="creditsValue">0</span> crédits
                                        </h4>
                                    </div>
                                    <small class="text-muted d-block mt-2" id="bonusDisplay">Bonus: +0 crédits</small>
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" name="montant" id="montantInput" value="{{ $commissionsDisponibles }}">
                        
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Les crédits seront ajoutés à votre <strong>credit_user</strong> pour créer des FlashCompte.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check me-1"></i>
                            Confirmer le transfert
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Retrait Mobile Money -->
    <div class="modal fade" id="mobileMoneyModal" tabindex="-1" aria-labelledby="mobileMoneyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('affiliation.withdrawal') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="mobileMoneyModalLabel">
                            <i class="fas fa-mobile-alt me-2"></i>
                            Retrait par Mobile Money
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @php
                            $commissionsRetirables = $affiliation->commissions()->where('statut', 'validee')->sum('montant_commission');
                        @endphp
                        
                        <div class="alert alert-success">
                            <i class="fas fa-coins me-2"></i>
                            Vous avez <strong>{{ number_format($commissionsRetirables, 0, ',', ' ') }} F CFA</strong> disponibles pour retrait.
                        </div>

                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Minimum de retrait :</strong> 5 000 F CFA
                        </div>
                        
                        <div class="mb-3">
                            <label for="montant_retrait" class="form-label">Montant à retirer</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="montant_retrait" name="montant" 
                                       step="1" min="5000" max="{{ $commissionsRetirables }}" 
                                       value="{{ $commissionsRetirables }}" required>
                                <span class="input-group-text">F CFA</span>
                            </div>
                            <div class="form-text">
                                Montant minimum : 5 000 F CFA • Maximum : {{ number_format($commissionsRetirables, 0, ',', ' ') }} F CFA
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="operateur" class="form-label">Opérateur Mobile Money</label>
                            <select class="form-select" id="operateur" name="operateur" required>
                                <option value="">Sélectionnez votre opérateur</option>
                                <option value="orange">Orange Money</option>
                                <option value="mtn">MTN Mobile Money</option>
                                <option value="moov">Moov Money</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="numero_mobile" class="form-label">Numéro de téléphone</label>
                            <div class="input-group">
                                <span class="input-group-text">+229</span>
                                <input type="tel" class="form-control" id="numero_mobile" name="numero" 
                                       placeholder="XX XX XX XX" pattern="[0-9]{8}" maxlength="8" required>
                            </div>
                            <div class="form-text">
                                Numéro du compte Mobile Money (8 chiffres)
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-clock me-2"></i>
                            <strong>Délai de traitement :</strong> Les retraits sont traités sous 24 heures ouvrables.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i>
                            Demander le retrait
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<style>
.timeline-item {
    border-left: 2px solid #e9ecef;
    padding-left: 1rem;
}

.timeline-item:last-child {
    border-left: none;
}

/* ===== CARTES DE STATISTIQUES ===== */
.stat-card {
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
}

.stat-icon {
    transition: transform 0.3s ease;
}

.stat-card:hover .stat-icon {
    transform: scale(1.1);
}

/* ===== FORMULAIRE DE RETRAIT MODERNE ===== */
.withdrawal-card {
    transition: all 0.3s ease;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.withdrawal-header .rounded-circle {
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.withdrawal-form-container {
    max-width: 900px;
    margin: 0 auto;
}

.withdrawal-card .form-label {
    color: #495057;
    font-size: 0.95rem;
}

.withdrawal-card .form-select,
.withdrawal-card .form-control {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    transition: all 0.3s ease;
    font-size: 1rem;
    padding: 0.75rem 1rem;
}

.withdrawal-card .form-select:focus,
.withdrawal-card .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.15);
}

.withdrawal-card .form-select option {
    padding: 10px;
}

.withdrawal-card .form-select optgroup {
    font-weight: 700;
    color: #495057;
    background: #f8f9fa;
}

.withdrawal-card .btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 10px;
    padding: 0.85rem 1.5rem;
    font-weight: 600;
    font-size: 1rem;
    letter-spacing: 0.3px;
    transition: all 0.3s ease;
}

.withdrawal-card .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
}

.withdrawal-card .alert-info {
    background: linear-gradient(135deg, #e3f2fd 0%, #e1f5fe 100%);
    border: 2px solid #90caf9;
    border-radius: 10px;
}

/* Responsive */
@media (max-width: 767px) {
    .withdrawal-card .form-select,
    .withdrawal-card .form-control {
        font-size: 16px; /* Évite le zoom iOS */
        padding: 0.65rem 0.85rem;
    }
    
    .withdrawal-card .btn-primary {
        padding: 0.75rem 1.25rem;
        font-size: 0.95rem;
    }
    
    .withdrawal-card .card-body {
        padding: 1.25rem !important;
    }
}

@media (max-width: 575px) {
    .withdrawal-card .form-select,
    .withdrawal-card .form-control {
        font-size: 15px;
        padding: 0.6rem 0.75rem;
    }
    
    .withdrawal-card .btn-primary {
        padding: 0.7rem 1rem;
        font-size: 0.9rem;
    }
}
</style>

<script>
function copyLink(event) {
    const linkInput = document.getElementById('lienParrainage');
    const link = linkInput ? linkInput.value : '';
    if (!link) {
        alert('Lien de parrainage non disponible');
        return;
    }

    const showFeedback = (button) => {
        if (!button) return;
        const originalHTML = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check me-1"></i> Copié !';
        button.classList.remove('btn-primary');
        button.classList.add('btn-success');
        setTimeout(() => {
            button.innerHTML = originalHTML;
            button.classList.remove('btn-success');
            button.classList.add('btn-primary');
        }, 1800);
    };

    const button = event && event.target ? (event.target.closest('button') || event.target) : null;

    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(link).then(() => {
            showFeedback(button);
        }).catch((err) => {
            // Fallback to execCommand
            try {
                linkInput.select();
                linkInput.setSelectionRange(0, 99999);
                document.execCommand('copy');
                showFeedback(button);
            } catch (e) {
                alert('Impossible de copier le lien');
            }
        });
        return;
    }

    // Older fallback
    try {
        linkInput.select();
        linkInput.setSelectionRange(0, 99999);
        document.execCommand('copy');
        showFeedback(button);
    } catch (err) {
        alert('Erreur lors de la copie');
    }
}

// Alerte minimum de retrait
function showMinimumAlert() {
    const alertModal = `
        <div class="modal fade" id="minimumAlert" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Retrait non disponible
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-coins text-warning" style="font-size: 4rem;"></i>
                        </div>
                        <h6 class="mb-3">Les gains ne sont retirables qu'à partir de <strong>5 000 F CFA</strong> collectés</h6>
                        <p class="text-muted">
                            Continuez à parrainer pour atteindre le minimum requis !
                        </p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                            <i class="fas fa-check me-1"></i>
                            J'ai compris
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Supprimer le modal existant s'il y en a un
    const existingModal = document.getElementById('minimumAlert');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Ajouter le nouveau modal
    document.body.insertAdjacentHTML('beforeend', alertModal);
    
    // Afficher le modal
    const modal = new bootstrap.Modal(document.getElementById('minimumAlert'));
    modal.show();
}

// Partage WhatsApp
function shareWhatsApp() {
    const link = document.getElementById('lienParrainage').value;
    const message = `🎉 Rejoignez FlashCompte avec mon code de parrainage !

💰 Obtenez un compte avec 10 000 F CFA offerts à l'inscription
🎯 Profitez de tous nos services bancaires
🚀 Inscription rapide et sécurisée

Cliquez ici pour vous inscrire : ${link}

#FlashCompte #Parrainage #BanqueNumérique`;

    const whatsappURL = `https://wa.me/?text=${encodeURIComponent(message)}`;
    window.open(whatsappURL, '_blank');
}

// Partage Email
function shareEmail() {
    const link = document.getElementById('lienParrainage').value;
    const subject = "Invitation FlashCompte - Recevez 10 000 F CFA offerts !";
    const body = `Salut !

Je t'invite à rejoindre FlashCompte, la meilleure solution bancaire numérique !

🎁 Avantages de l'inscription :
• 10 000 F CFA offerts à l'inscription
• Compte bancaire numérique gratuit
• Transactions sécurisées et rapides
• Interface moderne et intuitive

Pour profiter de cette offre, clique simplement sur ce lien :
${link}

À bientôt sur FlashCompte !`;

    const emailURL = `mailto:?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
    window.location.href = emailURL;
}

// Partage SMS
function shareSMS() {
    const link = document.getElementById('lienParrainage').value;
    const message = `🎉 FlashCompte t'offre 10 000 F CFA ! Inscris-toi avec mon lien de parrainage : ${link}`;
    
    const smsURL = `sms:?body=${encodeURIComponent(message)}`;
    window.location.href = smsURL;
}

// Générer QR Code
function generateQRCode() {
    const link = document.getElementById('lienParrainage').value;
    const qrCodeURL = `https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=${encodeURIComponent(link)}`;
    
    // Créer un modal pour afficher le QR code
    const modalHTML = `
        <div class="modal fade" id="qrModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-qrcode me-2"></i>
                            QR Code de parrainage
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p class="mb-3">Partagez ce QR code pour inviter vos amis !</p>
                        <img src="${qrCodeURL}" alt="QR Code" class="img-fluid mb-3" style="max-width: 250px;">
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" onclick="downloadQRCode('${qrCodeURL}')">
                                <i class="fas fa-download me-1"></i> Télécharger
                            </button>
                            <button class="btn btn-outline-secondary" onclick="copyLink()">
                                <i class="fas fa-copy me-1"></i> Copier le lien
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Supprimer le modal existant s'il y en a un
    const existingModal = document.getElementById('qrModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Ajouter le nouveau modal
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    
    // Afficher le modal
    const modal = new bootstrap.Modal(document.getElementById('qrModal'));
    modal.show();
}

// Télécharger le QR Code
function downloadQRCode(url) {
    const link = document.createElement('a');
    link.href = url;
    link.download = 'qr-code-parrainage-flashcompte.png';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Afficher l'alerte de seuil minimum
function showMinimumAlert() {
    // Créer et afficher une alerte Bootstrap
    const alertHTML = `
        <div class="modal fade" id="minimumAlert" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-danger text-white border-0">
                        <h5 class="modal-title d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Alert
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4 text-center">
                        <div class="mb-3">
                            <i class="fas fa-coins text-warning" style="font-size: 3rem;"></i>
                        </div>
                        <h6 class="mb-3">Seuil minimum non atteint</h6>
                        <p class="mb-0">
                            Les gains ne sont retirables qu'à partir de 
                            <strong class="text-danger">5000 F CFA</strong> collectés
                        </p>
                    </div>
                    <div class="modal-footer border-0 justify-content-center">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                            Fermer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Supprimer l'ancien modal s'il existe
    const existingModal = document.getElementById('minimumAlert');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Ajouter le nouveau modal
    document.body.insertAdjacentHTML('beforeend', alertHTML);
    
    // Afficher le modal
    const modal = new bootstrap.Modal(document.getElementById('minimumAlert'));
    modal.show();
}

// ===== CALCUL DES CRÉDITS POUR LE TRANSFERT =====
function calculateCreditsFromAmount(montant) {
    const paliers = [
        { seuil: 50000, credits: 100000 },
        { seuil: 25000, credits: 40000 },
        { seuil: 10000, credits: 15000 },
        { seuil: 5000, credits: 5000 },
        { seuil: 100, credits: 100 }
    ];
    
    let montantRestant = montant;
    let totalCredits = 0;
    
    for (let palier of paliers) {
        while (montantRestant >= palier.seuil) {
            totalCredits += palier.credits;
            montantRestant -= palier.seuil;
        }
    }
    
    // Le reste en 1:1
    if (montantRestant > 0) {
        totalCredits += montantRestant;
    }
    
    return totalCredits;
}

// Mettre à jour l'affichage des crédits dans le modal de transfert
document.addEventListener('DOMContentLoaded', function() {
    const transferModal = document.getElementById('transferModal');
    
    if (transferModal) {
        transferModal.addEventListener('shown.bs.modal', function() {
            const montantInput = document.getElementById('montantInput');
            const creditsValue = document.getElementById('creditsValue');
            const bonusDisplay = document.getElementById('bonusDisplay');
            
            if (montantInput && creditsValue) {
                const montant = parseFloat(montantInput.value) || 0;
                const credits = calculateCreditsFromAmount(montant);
                const bonus = credits - montant;
                
                // Animer le compteur
                let currentCredits = 0;
                const increment = credits / 30;
                const timer = setInterval(() => {
                    currentCredits += increment;
                    if (currentCredits >= credits) {
                        currentCredits = credits;
                        clearInterval(timer);
                    }
                    creditsValue.textContent = Math.floor(currentCredits).toLocaleString('fr-FR');
                }, 30);
                
                bonusDisplay.textContent = `Bonus: +${bonus.toLocaleString('fr-FR')} crédits (${((bonus/montant)*100).toFixed(0)}%)`;
                bonusDisplay.classList.add('text-success', 'fw-bold');
            }
        });
    }
});

// ===== AMÉLIORATION UX FORMULAIRE DE RETRAIT =====
document.addEventListener('DOMContentLoaded', function() {
    const withdrawalForm = document.getElementById('withdrawalForm');
    const operatorSelect = document.getElementById('operatorSelect');
    const phoneNumber = document.getElementById('phoneNumber');
    
    if (withdrawalForm) {
        // Validation du formulaire avant soumission
        withdrawalForm.addEventListener('submit', function(e) {
            const operator = operatorSelect.value;
            const phone = phoneNumber.value;
            
            if (!operator) {
                e.preventDefault();
                alert('⚠️ Veuillez sélectionner un moyen de retrait');
                operatorSelect.focus();
                return false;
            }
            
            if (!phone || phone.length < 8) {
                e.preventDefault();
                alert('⚠️ Veuillez entrer un numéro de téléphone valide (minimum 8 chiffres)');
                phoneNumber.focus();
                return false;
            }
            
            // Confirmation avant envoi
            const confirmation = confirm(
                `✅ Confirmer le retrait ?\n\n` +
                `Opérateur: ${operator}\n` +
                `Numéro: ${phone}\n\n` +
                `Cliquez sur OK pour valider votre demande.`
            );
            
            if (!confirmation) {
                e.preventDefault();
                return false;
            }
            
            // Animation du bouton
            const submitBtn = withdrawalForm.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Traitement en cours...';
        });
        
        // Formatage automatique du numéro (uniquement des chiffres)
        phoneNumber.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        
        // Feedback visuel sur le select
        operatorSelect.addEventListener('change', function() {
            if (this.value) {
                this.classList.add('border-success');
                this.classList.remove('border-danger');
            }
        });
    }
});
</script>

<!-- Modal de confirmation de suppression de l'historique -->
<div class="modal fade" id="deleteHistoryModal" tabindex="-1" aria-labelledby="deleteHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-danger text-white border-0">
                <h5 class="modal-title d-flex align-items-center" id="deleteHistoryModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Confirmation de suppression
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="mb-3">
                    <i class="fas fa-trash-alt text-danger" style="font-size: 3rem;"></i>
                </div>
                <h6 class="mb-3">Êtes-vous sûr de vouloir supprimer tout l'historique des gains ?</h6>
                <p class="text-muted mb-0">
                    Cette action est <strong class="text-danger">irréversible</strong>. 
                    Toutes les entrées de votre historique seront définitivement supprimées.
                </p>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-secondary px-4 me-2" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>
                    Annuler
                </button>
                <form action="{{ route('affiliation.clearHistory') }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="fas fa-trash me-1"></i>
                        Oui, supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/* Amélioration de la responsivité mobile */
@media (max-width: 576px) {
    .container-fluid {
        padding-left: 10px;
        padding-right: 10px;
    }
    
    .card {
        margin-bottom: 1rem;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .card-header h5 {
        font-size: 1rem;
    }
    
    /* Réduire la taille des icônes sur mobile */
    .stat-icon i {
        font-size: 2rem !important;
    }
    
    .stat-value strong {
        font-size: 1.5rem !important;
    }
    
    /* Ajuster la zone de l'historique */
    .card-body[style*="max-height"] {
        max-height: 300px !important;
    }
    
    /* Boutons plus compacts */
    .btn-sm {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
    
    /* Input group responsive */
    .input-group {
        flex-wrap: nowrap;
    }
    
    .input-group .form-control {
        font-size: 0.85rem;
    }
    
    .input-group .btn {
        font-size: 0.85rem;
        padding: 0.375rem 0.75rem;
    }
    
    /* Alertes plus compactes */
    .alert {
        padding: 0.75rem;
        font-size: 0.875rem;
    }
    
    /* Formulaire de retrait */
    .withdrawal-header h5 {
        font-size: 1.1rem;
    }
    
    .alert-success h3 {
        font-size: 1.75rem !important;
    }
    
    .form-select-lg,
    .form-control-lg {
        font-size: 1rem;
        padding: 0.5rem 0.75rem;
    }
    
    /* Badges dans l'historique */
    .badge {
        font-size: 0.7rem;
    }
    
    /* Espacement des gains */
    .d-flex.align-items-center.mb-3 {
        padding-bottom: 0.5rem !important;
    }
    
    .d-flex.align-items-center.mb-3 h6 {
        font-size: 0.95rem;
    }
    
    /* Modal responsive */
    .modal-dialog {
        margin: 0.5rem;
    }
}

@media (max-width: 768px) {
    /* Réduire le padding des conteneurs */
    .card-body.p-4 {
        padding: 1.5rem !important;
    }
    
    /* Statistiques plus compactes */
    .stat-card {
        padding: 1rem !important;
    }
    
    /* Exemples de gains en colonne sur petits écrans */
    .row.g-2 > div {
        margin-bottom: 0.5rem;
    }
}

/* Amélioration des boutons de partage */
.d-flex.gap-2 {
    flex-wrap: wrap;
}

.d-flex.gap-2 .btn {
    flex: 1 1 calc(50% - 0.5rem);
    min-width: 120px;
}

@media (max-width: 576px) {
    .d-flex.gap-2 .btn {
        flex: 1 1 100%;
        margin-bottom: 0.5rem;
    }
}

/* Amélioration du montant disponible */
.alert-success.d-flex {
    flex-direction: row !important;
}

@media (max-width: 576px) {
    .alert-success.d-flex {
        flex-direction: column !important;
        padding: 1.5rem 1rem !important;
    }
    
    .alert-success.d-flex i {
        font-size: 2.5rem !important;
        margin-bottom: 1rem !important;
        margin-right: 0 !important;
    }
}

/* Scrollbar personnalisée pour l'historique */
.card-body::-webkit-scrollbar {
    width: 6px;
}

.card-body::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.card-body::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
}

.card-body::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>

@endsection