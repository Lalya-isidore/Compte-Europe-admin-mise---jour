@extends('layouts.admin')

@section('title', 'Test Paiements - Administration')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-credit-card me-2"></i>Administration Paiements - Mode Production
                    </h4>
                </div>
                <div class="card-body p-4">
                    
                    <div class="alert alert-success mb-4">
                        <i class="fas fa-shield-alt me-2"></i>
                        <strong>Système de Paiement en Production :</strong> 
                        <br>• FedaPay Live : {{ config('services.fedapay.secret_key') ? 'Activé ✅' : 'Non configuré ❌' }}
                        <br>• Toutes les transactions sont réelles
                        <br>• Mode : Production avec vraies clés API
                    </div>

                    <!-- Test de paiement réel -->
                    <div class="card mb-4">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">⚠️ Test Paiement Réel - Argent Débité</h5>
                        </div>
                        <div class="card-body">
                            <form id="test-payment-form">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Montant de test</label>
                                        <select class="form-select" name="amount" required>
                                            <option value="1000">1 000 F CFA (Test)</option>
                                            <option value="5000">5 000 F CFA</option>
                                            <option value="10000">10 000 F CFA</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Méthode de paiement</label>
                                        <select class="form-select" name="payment_method" required>
                                            <option value="fedapay">FedaPay (Cartes + Mobile Money)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Action</label>
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-play me-2"></i>Lancer Test
                                        </button>
                                    </div>
                                </div>
                            </form>
                            
                            <div id="test-result" class="d-none mt-3">
                                <div class="alert alert-info">
                                    <strong>Résultat du test :</strong>
                                    <pre id="test-output"></pre>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transactions récentes -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-list me-2"></i>Dernières Transactions
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID Transaction</th>
                                            <th>Utilisateur</th>
                                            <th>Montant</th>
                                            <th>Méthode</th>
                                            <th>Statut</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recent_transactions as $transaction)
                                        <tr>
                                            <td><code>{{ $transaction->transaction_id }}</code></td>
                                            <td>{{ $transaction->user->nom ?? 'N/A' }} {{ $transaction->user->prenom ?? '' }}</td>
                                            <td>{{ number_format($transaction->amount, 0, ',', ' ') }} F</td>
                                            <td>
                                                <span class="badge bg-info">{{ strtoupper($transaction->payment_method) }}</span>
                                            </td>
                                            <td>
                                                @switch($transaction->status)
                                                    @case('completed')
                                                        <span class="badge bg-success">Réussi</span>
                                                        @break
                                                    @case('pending')
                                                        <span class="badge bg-warning">En cours</span>
                                                        @break
                                                    @case('failed')
                                                        <span class="badge bg-danger">Échoué</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ ucfirst($transaction->status) }}</span>
                                                @endswitch
                                            </td>
                                            <td>{{ $transaction->created_at->setTimezone('Europe/Paris')->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-info" onclick="showTransactionDetails('{{ $transaction->id }}')">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('test-payment-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const btn = this.querySelector('button[type="submit"]');
    const originalText = btn.innerHTML;
    
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Test en cours...';
    
    fetch('{{ route("recharge.store") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('test-result').classList.remove('d-none');
        document.getElementById('test-output').textContent = JSON.stringify(data, null, 2);
        
        if (data.success && data.payment_url) {
            // Ouvrir la page de paiement dans une nouvelle fenêtre
            window.open(data.payment_url, '_blank');
        }
    })
    .catch(error => {
        document.getElementById('test-result').classList.remove('d-none');
        document.getElementById('test-output').textContent = 'Erreur: ' + error.message;
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = originalText;
    });
});

function showTransactionDetails(transactionId) {
    // Ici on peut ajouter une modal pour afficher les détails complets
    alert('Détails transaction ID: ' + transactionId);
}
</script>
@endsection