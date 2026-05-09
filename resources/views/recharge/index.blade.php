@extends('layouts.admin')

@section('title', 'Recharge de Compte')

@section('breadcrumb')
    <li class="breadcrumb-item"><i class="fas fa-wallet me-1"></i>Recharge</li>
    <li class="breadcrumb-item active"><i class="fas fa-credit-card me-1"></i>Recharge de Compte</li>
@endsection

@section('content')
<div class="container-fluid py-4 px-0 px-sm-3">
    <div class="row g-0 g-sm-3">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-0 rounded-sm-3">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="fas fa-credit-card me-3 fs-4"></i>
                    <h4 class="mb-0">Recharge de Compte</h4>
                </div>
                <div class="card-body p-2 p-sm-4">
                    
                    <!-- Crédits FlashBilan disponibles -->
                    <div class="alert alert-success d-flex align-items-center mb-4">
                        <i class="fas fa-coins me-3 fs-5"></i>
                        <div>
                            <strong>Crédits disponibles :</strong>
                            <span class="fs-5 fw-bold">{{ number_format(auth()->user()->credit_user ?? 0, 0, ',', ' ') }} crédits</span>
                            <br>
                            <small class="text-muted">Chaque crédit vous permet de créer un compte FlashBilan</small>
                        </div>
                    </div>

                    <!-- Information sur les crédits -->
                    <div class="alert alert-warning d-flex align-items-center mb-4">
                        <i class="fas fa-info-circle me-3 fs-5"></i>
                        <div>
                            <strong><i class="fas fa-lightbulb me-1"></i> Comment ça fonctionne :</strong><br>
                            <small class="text-muted">
                                Les recharges vous donnent des <strong>crédits</strong> pour créer des comptes FlashBilan, pas de l'argent sur votre solde bancaire.
                            </small>
                        </div>
                    </div>

                    @if(auth()->user()->parrain_id)
                        <!-- Information parrainage -->
                        <div class="alert alert-success d-flex align-items-center mb-4">
                            <i class="fas fa-handshake me-3 fs-5"></i>
                            <div>
                                <strong><i class="fas fa-gift me-1"></i> Bonus parrainage actif !</strong><br>
                                <small class="text-muted">
                                    Votre parrain recevra automatiquement 5% de commission sur cette recharge.
                                </small>
                            </div>
                        </div>
                    @endif

                    <!-- Nouveaux packs -->
                    <div class="text-center mb-3">
                        <span class="badge fw-bold px-4 py-2" style="background:#10b981;font-size:.85rem;border-radius:999px;letter-spacing:.05em;">✨ NOUVEAUX PACKS</span>
                    </div>
                    <div class="row g-3 mb-4 pack-row">
                        <div class="col-6 col-md-6 col-lg-4">
                            <div class="card h-100 package-card position-relative" style="border:2px solid #10b981;border-radius:16px;background:#fff;" data-amount="1500" data-credits="1000">
                                <span class="position-absolute top-0 start-0 badge fw-bold px-2 py-1 m-2" style="background:#10b981;border-radius:8px;font-size:.7rem;">NOUVEAU</span>
                                <div class="card-body text-center p-4 pt-5">
                                    <div class="package-icon mb-2">
                                        <i class="fas fa-coins fs-1" style="color:#10b981;"></i>
                                    </div>
                                    <h5 class="card-title fw-bold mb-3" style="color:#10b981;">Pack Mini</h5>
                                    <div class="d-inline-block px-3 py-1 rounded-pill fw-bold mb-2" style="background:#059669;color:#fff;font-size:1.05rem;">1 500 F CFA</div>
                                    <p class="fw-bold text-primary mb-3" style="font-size:1.05rem;">+ 1 000 Crédits</p>
                                    <button class="btn btn-select-package w-100 fw-bold text-white" style="background:#10b981;border-radius:10px;border:none;">
                                        <i class="fas fa-check-circle me-2"></i>Choisir
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-6 col-lg-4">
                            <div class="card h-100 package-card position-relative" style="border:2px solid #f97316;border-radius:16px;background:#fff;" data-amount="3000" data-credits="2000">
                                <span class="position-absolute top-0 start-0 badge fw-bold px-2 py-1 m-2" style="background:#f97316;border-radius:8px;font-size:.7rem;">NOUVEAU</span>
                                <div class="card-body text-center p-4 pt-5">
                                    <div class="package-icon mb-2">
                                        <i class="fas fa-bolt fs-1" style="color:#f97316;"></i>
                                    </div>
                                    <h5 class="card-title fw-bold mb-3" style="color:#f97316;">Pack Essentiel</h5>
                                    <div class="d-inline-block px-3 py-1 rounded-pill fw-bold mb-2" style="background:#ea580c;color:#fff;font-size:1.05rem;">3 000 F CFA</div>
                                    <p class="fw-bold text-primary mb-3" style="font-size:1.05rem;">+ 2 000 Crédits</p>
                                    <button class="btn btn-select-package w-100 fw-bold text-white" style="background:#f97316;border-radius:10px;border:none;">
                                        <i class="fas fa-check-circle me-2"></i>Choisir
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-6 col-lg-4">
                            <div class="card h-100 package-card" style="border:2px solid #0d6efd;border-radius:16px;background:#fff;" data-amount="5000" data-credits="5000">
                                <div class="card-body text-center p-4">
                                    <div class="package-icon mb-2">
                                        <i class="fas fa-star fs-1" style="color:#0d6efd;"></i>
                                    </div>
                                    <h5 class="card-title fw-bold mb-3" style="color:#0d6efd;">Pack Starter</h5>
                                    <div class="d-inline-block px-3 py-1 rounded-pill fw-bold mb-2" style="background:#0b5ed7;color:#fff;font-size:1.05rem;">5 000 F CFA</div>
                                    <p class="fw-bold text-primary mb-3" style="font-size:1.05rem;">+ 5 000 Crédits</p>
                                    <button class="btn btn-select-package w-100 fw-bold text-white" style="background:#0d6efd;border-radius:10px;border:none;">
                                        <i class="fas fa-check-circle me-2"></i>Choisir
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Packages existants -->
                    <div class="row g-3 mb-5 pack-row">
                        <div class="col-6 col-md-6 col-lg-4">
                            <div class="card h-100 package-card" style="border:2px solid #198754;border-radius:16px;background:#fff;" data-amount="10000" data-credits="15000">
                                <div class="card-body text-center p-4">
                                    <div class="package-icon mb-2">
                                        <i class="fas fa-gem fs-1" style="color:#198754;"></i>
                                    </div>
                                    <h5 class="card-title fw-bold mb-1" style="color:#198754;">Pack Premium</h5>
                                    <div class="mb-2"><span class="badge" style="background:#198754;">+50% Bonus</span></div>
                                    <div class="d-inline-block px-3 py-1 rounded-pill fw-bold mb-2" style="background:#146c43;color:#fff;font-size:1.05rem;">10 000 F CFA</div>
                                    <p class="fw-bold text-primary mb-3" style="font-size:1.05rem;">+ 15 000 Crédits</p>
                                    <button class="btn btn-select-package w-100 fw-bold text-white" style="background:#198754;border-radius:10px;border:none;">
                                        <i class="fas fa-check-circle me-2"></i>Choisir
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-md-6 col-lg-4">
                            <div class="card h-100 package-card" style="border:2px solid #0891b2;border-radius:16px;background:#fff;" data-amount="15000" data-credits="25000">
                                <div class="card-body text-center p-4">
                                    <div class="package-icon mb-2">
                                        <i class="fas fa-bolt fs-1" style="color:#0891b2;"></i>
                                    </div>
                                    <h5 class="card-title fw-bold mb-1" style="color:#0891b2;">Pack Pro</h5>
                                    <div class="mb-2"><span class="badge" style="background:#0891b2;">+67% Bonus</span></div>
                                    <div class="d-inline-block px-3 py-1 rounded-pill fw-bold mb-2" style="background:#0e7490;color:#fff;font-size:1.05rem;">15 000 F CFA</div>
                                    <p class="fw-bold text-primary mb-3" style="font-size:1.05rem;">+ 25 000 Crédits</p>
                                    <button class="btn btn-select-package w-100 fw-bold text-white" style="background:#0891b2;border-radius:10px;border:none;">
                                        <i class="fas fa-check-circle me-2"></i>Choisir
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-md-6 col-lg-4">
                            <div class="card h-100 package-card" style="border:2px solid #d97706;border-radius:16px;background:#fff;" data-amount="25000" data-credits="40000">
                                <div class="card-body text-center p-4">
                                    <div class="package-icon mb-2">
                                        <i class="fas fa-crown fs-1" style="color:#d97706;"></i>
                                    </div>
                                    <h5 class="card-title fw-bold mb-1" style="color:#d97706;">Pack Gold</h5>
                                    <div class="mb-2"><span class="badge" style="background:#d97706;">+60% Bonus</span></div>
                                    <div class="d-inline-block px-3 py-1 rounded-pill fw-bold mb-2" style="background:#b45309;color:#fff;font-size:1.05rem;">25 000 F CFA</div>
                                    <p class="fw-bold text-primary mb-3" style="font-size:1.05rem;">+ 40 000 Crédits</p>
                                    <button class="btn btn-select-package w-100 fw-bold text-white" style="background:#d97706;border-radius:10px;border:none;">
                                        <i class="fas fa-check-circle me-2"></i>Choisir
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-md-6 col-lg-4">
                            <div class="card h-100 package-card" style="border:2px solid #dc3545;border-radius:16px;background:#fff;" data-amount="50000" data-credits="100000">
                                <div class="card-body text-center p-4">
                                    <div class="package-icon mb-2">
                                        <i class="fas fa-trophy fs-1" style="color:#dc3545;"></i>
                                    </div>
                                    <h5 class="card-title fw-bold mb-1" style="color:#dc3545;">Pack VIP</h5>
                                    <div class="mb-2"><span class="badge" style="background:#dc3545;">+100% Bonus</span></div>
                                    <div class="d-inline-block px-3 py-1 rounded-pill fw-bold mb-2" style="background:#b02a37;color:#fff;font-size:1.05rem;">50 000 F CFA</div>
                                    <p class="fw-bold text-primary mb-3" style="font-size:1.05rem;">+ 100 000 Crédits</p>
                                    <button class="btn btn-select-package w-100 fw-bold text-white" style="background:#dc3545;border-radius:10px;border:none;">
                                        <i class="fas fa-check-circle me-2"></i>Choisir
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section de paiement (cachée par défaut) -->
                    <div id="payment-section" class="d-none">
                        <div class="card border-2">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">
                                    <i class="fas fa-payment me-2"></i>Méthodes de Paiement
                                </h5>
                            </div>
                            <div class="card-body">
                                <form id="payment-form">
                                    @csrf
                                    <input type="hidden" id="selected-amount" name="amount">
                                    
                                    <!-- Récapitulatif -->
                                    <div class="alert alert-primary mb-4">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>Package sélectionné :</strong> <span id="selected-package-name"></span>
                                            </div>
                                            <div>
                                                <span class="fs-5 fw-bold" id="selected-amount-display"></span> F CFA
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <i class="fas fa-gift text-success me-2"></i>
                                            <strong>Crédits à recevoir :</strong> <span id="selected-credits-display" class="text-success fw-bold"></span>
                                        </div>
                                    </div>

                                    <!-- Options de paiement (seulement FedaPay et Mobile Money) -->
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <div class="payment-option" data-method="fedapay">
                                                <div class="card h-100 cursor-pointer">
                                                    <div class="card-body text-center p-3">
                                                        <i class="fab fa-cc-visa text-primary fs-2 mb-2"></i>
                                                        <h6 class="card-title">FedaPay</h6>
                                                        <p class="card-text small text-muted">Visa, MasterCard, Mobile Money</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="payment-option" data-method="mobile_money">
                                                <div class="card h-100 cursor-pointer">
                                                    <div class="card-body text-center p-3">
                                                        <i class="fas fa-phone text-info fs-2 mb-2"></i>
                                                        <h6 class="card-title">Mobile Money</h6>
                                                        <p class="card-text small text-muted">Paiement mobile direct</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" id="payment-method" name="payment_method">
                                    
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-lg px-5" id="btn-pay" disabled>
                                            <i class="fas fa-lock me-2"></i>Procéder au Paiement Sécurisé
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Historique des recharges -->
                    <div class="mt-5">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                            <h5 class="mb-0">
                                <i class="fas fa-history me-2"></i>Historique des Recharges
                            </h5>
                            @if($transactions->count() > 0)
                                <form id="clear-history-form" action="{{ route('recharge.history.clear') }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-trash-alt me-2"></i>Supprimer l'historique
                                    </button>
                                </form>
                            @endif
                        </div>
                        
                        
                        
                        @if($transactions->count() > 0)
                            <div class="transaction-history">
                                <div class="transaction-table d-none d-md-block">
                                    <table class="table table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Date</th>
                                                <th>ID Transaction</th>
                                                <th>Montant</th>
                                                <th>Crédits</th>
                                                <th>Méthode</th>
                                                <th>Statut</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($transactions as $transaction)
                                            <tr>
                                                <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    <code>{{ $transaction->transaction_id }}</code>
                                                </td>
                                                <td>{{ number_format($transaction->amount, 0, ',', ' ') }} F CFA</td>
                                                <td>
                                                    <span class="text-success fw-bold">
                                                        +{{ number_format($transaction->credits_earned, 0, ',', ' ') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary">
                                                        {{ strtoupper($transaction->payment_method) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($transaction->status === 'completed')
                                                        <span class="badge bg-success">Réussi</span>
                                                    @elseif($transaction->status === 'pending')
                                                        <span class="badge bg-warning">En cours</span>
                                                    @else
                                                        <span class="badge bg-danger">Échoué</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="transaction-cards d-md-none">
                                    @foreach($transactions as $transaction)
                                        <div class="transaction-card">
                                            <div class="transaction-row">
                                                <span class="label">Date</span>
                                                <span class="value">{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
                                            </div>
                                            <div class="transaction-row">
                                                <span class="label">ID Transaction</span>
                                                <span class="value"><code>{{ $transaction->transaction_id }}</code></span>
                                            </div>
                                            <div class="transaction-row">
                                                <span class="label">Montant</span>
                                                <span class="value">{{ number_format($transaction->amount, 0, ',', ' ') }} F CFA</span>
                                            </div>
                                            <div class="transaction-row">
                                                <span class="label">Crédits</span>
                                                <span class="value text-success fw-bold">+{{ number_format($transaction->credits_earned, 0, ',', ' ') }}</span>
                                            </div>
                                            <div class="transaction-row">
                                                <span class="label">Méthode</span>
                                                <span class="value"><span class="badge bg-secondary">{{ strtoupper($transaction->payment_method) }}</span></span>
                                            </div>
                                            <div class="transaction-row">
                                                <span class="label">Statut</span>
                                                <span class="value">
                                                    @if($transaction->status === 'completed')
                                                        <span class="badge bg-success">Réussi</span>
                                                    @elseif($transaction->status === 'pending')
                                                        <span class="badge bg-warning">En cours</span>
                                                    @else
                                                        <span class="badge bg-danger">Échoué</span>
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-center">
                                {{ $transactions->links('pagination::bootstrap-5') }}
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-inbox text-muted fs-1 mb-3"></i>
                                <p class="text-muted">Aucune recharge effectuée pour le moment</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.package-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.package-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.package-card.selected {
    transform: scale(1.05);
    box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
}

.payment-option {
    cursor: pointer;
    transition: all 0.3s ease;
}

.payment-option:hover .card {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.payment-option.selected .card {
    border: 2px solid #007bff !important;
    background-color: #f8f9fa;
}

.cursor-pointer {
    cursor: pointer;
}

/* Styles pour la modal d'erreur */
#errorModal .modal-content {
    border-radius: 15px;
    overflow: hidden;
}

#errorModal .modal-header {
    background: linear-gradient(135deg, #ffc107, #ffb300);
}

#errorModal .bg-warning.bg-opacity-25 {
    background-color: rgba(255, 193, 7, 0.2) !important;
}

#errorModal .alert-info {
    background-color: #e3f2fd;
    border-color: #90caf9;
    color: #0d47a1;
}

#errorModal .modal-footer .btn-primary {
    background: linear-gradient(135deg, #007bff, #0056b3);
    border: none;
    box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
}

#errorModal .modal-footer .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
}

/* Animation pour la modal */
#errorModal .modal.fade .modal-dialog {
    transition: transform 0.3s ease-out;
    transform: translateY(-50px);
}

#errorModal .modal.show .modal-dialog {
    transform: none;
}

/* Styles pour les options non disponibles */
.payment-unavailable {
    opacity: 0.7;
    position: relative;
}

.payment-unavailable .card {
    background-color: #f8f9fa;
    border-color: #e9ecef;
}

.payment-unavailable:hover .card {
    transform: none !important;
    box-shadow: none !important;
}

.unavailable-overlay {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 10;
}

.payment-unavailable .card-body::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: repeating-linear-gradient(
        45deg,
        transparent,
        transparent 10px,
        rgba(0,0,0,0.05) 10px,
        rgba(0,0,0,0.05) 20px
    );
    pointer-events: none;
}

/* Force table to remain horizontal on small screens: allow horizontal scroll */
@media (max-width: 575px) {
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .table {
        white-space: nowrap;
        min-width: 680px;
    }
    .table thead { display: table-header-group !important; }
    .table tbody tr { display: table-row !important; }
    .table tbody td:before { display: none !important; content: none !important; }
}

    .transaction-cards {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .transaction-card {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 1rem;
        background: #fff;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05);
    }

    .transaction-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        padding: 0.4rem 0;
        border-bottom: 1px dashed #e5e7eb;
    }

    .transaction-row:last-child {
        border-bottom: none;
    }

    .transaction-row .label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #6b7280;
        font-weight: 600;
    }

    .transaction-row .value {
        font-size: 0.95rem;
        color: #111827;
        text-align: right;
    }

    @media (max-width: 576px) {
        .pack-row > div {
            flex: 0 0 50% !important;
            max-width: 50% !important;
            width: 50% !important;
        }
        .package-card .card-body {
            padding: 0.6rem !important;
            padding-top: 1.8rem !important;
        }
        .package-card .package-icon { margin-bottom: 0.25rem !important; }
        .package-card .package-icon i { font-size: 1.4rem !important; }
        .package-card .card-title { font-size: 0.78rem !important; margin-bottom: 0.4rem !important; }
        .package-card .rounded-pill { font-size: 0.72rem !important; padding: 0.2rem 0.5rem !important; margin-bottom: 0.3rem !important; }
        .package-card p { font-size: 0.75rem !important; margin-bottom: 0.4rem !important; }
        .package-card .btn { font-size: 0.72rem !important; padding: 0.35rem 0.25rem !important; }
        .package-card .badge { font-size: 0.6rem !important; }
        .package-card .position-absolute { font-size: 0.6rem !important; padding: 0.15rem 0.35rem !important; }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let selectedAmount = null;
    let selectedCredits = null;
    let selectedMethod = null;
    let paymentWindow = null; // pre-opened window to avoid popup blockers

    const clearHistoryForm = document.getElementById('clear-history-form');
    if (clearHistoryForm) {
        clearHistoryForm.addEventListener('submit', function(e) {
            if (!confirm("Êtes-vous sûr de vouloir supprimer définitivement votre historique de recharges ?")) {
                e.preventDefault();
            }
        });
    }

    // Gestion de la sélection des packages
    document.querySelectorAll('.btn-select-package').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Package sélectionné');
            
            // Retirer la sélection précédente
            document.querySelectorAll('.package-card').forEach(card => {
                card.classList.remove('selected');
            });
            
            // Sélectionner le nouveau package
            const card = this.closest('.package-card');
            card.classList.add('selected');
            
            selectedAmount = card.dataset.amount;
            selectedCredits = card.dataset.credits;
            
            console.log('Montant:', selectedAmount, 'Crédits:', selectedCredits);
            
            // Mettre à jour les informations affichées
            document.getElementById('selected-amount').value = selectedAmount;
            document.getElementById('selected-amount-display').textContent = new Intl.NumberFormat('fr-FR').format(selectedAmount);
            document.getElementById('selected-credits-display').textContent = new Intl.NumberFormat('fr-FR').format(selectedCredits);
            
            // Déterminer le nom du package
            const packageNames = {
                '5000': 'Starter',
                '10000': 'Premium',
                '15000': 'Pro',
                '25000': 'Gold',
                '50000': 'VIP'
            };
            document.getElementById('selected-package-name').textContent = packageNames[selectedAmount] || 'Package ' + selectedAmount + ' F';
            
            // Afficher la section de paiement
            document.getElementById('payment-section').classList.remove('d-none');
            
            // Scroll vers la section de paiement
            document.getElementById('payment-section').scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
            // Pré-sélectionner automatiquement FedaPay pour accélérer l'affichage
            try {
                if (typeof selectFedaPay === 'function') {
                    selectFedaPay();
                }
            } catch (e) {
                console.warn('selectFedaPay not available yet', e);
            }

            // Fallback robuste: assurer la sélection même en cas de race (éléments non interactifs ou handlers non attachés)
            setTimeout(function() {
                try {
                    const fedapayOption = document.querySelector('[data-method="fedapay"]');
                    const paymentMethodInput = document.getElementById('payment-method');
                    const payBtn = document.getElementById('btn-pay');

                    if (fedapayOption) {
                        // Si l'option n'a pas encore la classe selected, simuler la sélection
                        if (!fedapayOption.classList.contains('selected')) {
                            try {
                                // Simuler le click (déclenchera le handler existant)
                                fedapayOption.dispatchEvent(new Event('click', { bubbles: true }));
                            } catch (err) {
                                // Dernier recours
                                try { fedapayOption.click(); } catch (e) { /* ignore */ }
                            }
                        }

                        // Assurer que l'input et le bouton sont correctement définis
                        if (paymentMethodInput) paymentMethodInput.value = 'fedapay';
                        if (payBtn) payBtn.disabled = false;

                        console.debug('fedapay auto-selected (fallback)');
                    }
                } catch (e) {
                    console.warn('fedapay auto-select fallback failed', e);
                }
            }, 50);
        });
    });

    // Gestion de la sélection des méthodes de paiement
    document.querySelectorAll('.payment-option').forEach(option => {
        option.addEventListener('click', function() {
            // Retirer la sélection précédente
            document.querySelectorAll('.payment-option').forEach(opt => {
                opt.classList.remove('selected');
            });
            
            // Sélectionner la nouvelle méthode
            this.classList.add('selected');
            selectedMethod = this.dataset.method;
            document.getElementById('payment-method').value = selectedMethod;
            
            // Activer le bouton de paiement
            document.getElementById('btn-pay').disabled = false;
        });
    });

    // Gestion du formulaire de paiement
    document.getElementById('payment-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!selectedAmount || !selectedMethod) {
            alert('Veuillez sélectionner un package et une méthode de paiement');
            return;
        }

        const btn = document.getElementById('btn-pay');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Traitement en cours...';

        // Préouvrir une nouvelle fenêtre/onglet ici (autorisé car dans le handler utilisateur)
        try {
            paymentWindow = window.open('', '_blank');
        } catch (e) {
            paymentWindow = null;
            console.warn('Impossible d\'ouvrir une nouvelle fenêtre', e);
        }

        // Envoyer la requête
        fetch('{{ route("recharge.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                amount: selectedAmount,
                payment_method: selectedMethod
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.payment_url) {
                // Si nous avons préouvert une fenêtre, utiliser celle-ci (évite les bloqueurs de popup)
                if (paymentWindow) {
                    try {
                        paymentWindow.location.href = data.payment_url;
                    } catch (e) {
                        // Dernier recours : naviguer dans la page actuelle
                        window.location.href = data.payment_url;
                    }
                } else {
                    // Rediriger dans la fenêtre courante
                    window.location.href = data.payment_url;
                }
            } else {
                // Fermer la fenêtre préouverte si erreur
                if (paymentWindow && !paymentWindow.closed) paymentWindow.close();
                // Afficher l'erreur dans une modal élégante
                showErrorModal(data.error || 'Erreur lors du traitement du paiement');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showErrorModal('Une erreur de connexion est survenue');
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
    });
    
    // Fonction pour afficher les erreurs dans une modal élégante
    function showErrorModal(message) {
        // Créer la modal si elle n'existe pas
        let modal = document.getElementById('errorModal');
        if (!modal) {
            modal = document.createElement('div');
            modal.id = 'errorModal';
            modal.innerHTML = `
                <div class="modal fade" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg">
                            <div class="modal-header bg-warning text-dark border-0">
                                <h5 class="modal-title d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Information Importante
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-warning bg-opacity-25 rounded-circle p-3 me-3">
                                        <i class="fas fa-info-circle text-warning fs-4"></i>
                                    </div>
                                    <div>
                                        <p class="mb-2 fw-bold">Méthode de paiement non disponible</p>
                                        <p class="mb-0 text-muted" id="error-message"></p>
                                    </div>
                                </div>
                                
                                <div class="alert alert-info mb-3">
                                    <strong>Solution recommandée :</strong>
                                    <br>Utilisez <strong>FedaPay</strong> qui prend en charge :
                                    <ul class="mb-0 mt-2">
                                        <li>Cartes Visa et MasterCard</li>
                                        <li>Orange Money et MTN Mobile Money</li>
                                        <li>Paiements sécurisés et instantanés</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="modal-footer border-0 pt-0">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-2"></i>Fermer
                                </button>
                                <button type="button" class="btn btn-primary" onclick="selectFedaPay()">
                                    <i class="fas fa-credit-card me-2"></i>Choisir FedaPay
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
        }
        
        // Mettre à jour le message et afficher la modal
        document.getElementById('error-message').textContent = message;
        const bsModal = new bootstrap.Modal(modal.querySelector('.modal'));
        bsModal.show();
    }
    
    // Fonction pour sélectionner automatiquement FedaPay
    function selectFedaPay() {
        // Fermer la modal si elle existe et si une instance Bootstrap est disponible
        try {
            const modalEl = document.querySelector('#errorModal .modal');
            if (modalEl) {
                const modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                if (modalInstance && typeof modalInstance.hide === 'function') {
                    modalInstance.hide();
                }
            }
        } catch (e) {
            // Ne pas bloquer la sélection si Bootstrap ou la modal ne sont pas disponibles
            console.debug('selectFedaPay: modal hide skipped', e);
        }

        // Sélectionner FedaPay automatiquement (sans dépendre de la modal)
        try {
            const fedapayOption = document.querySelector('[data-method="fedapay"]');
            if (fedapayOption) {
                fedapayOption.click();
            }
        } catch (e) {
            console.warn('selectFedaPay: unable to auto-select FedaPay', e);
        }
    }
});
</script>
@endsection
