<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>TRANSFERFLUX - Accueil</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/mobile-responsive.css') }}">
    <meta name="theme-color" content="#667eea">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="light-content">
</head>
<body>
    @auth
    <div class="mobile-dashboard">
        <!-- Header mobile avec barre de statut -->
        <div class="mobile-header">
            <div class="status-bar">
                <span>22:18</span>
                <div class="status-indicators">
                    <span>●●●●</span>
                    <i class="fas fa-wifi"></i>
                    <i class="fas fa-battery-three-quarters"></i>
                </div>
            </div>
            
            <div class="app-header">
                <div class="app-title">
                    <i class="fas fa-bars"></i>
                    TRANSFERFLUX
                </div>
                <a href="{{route('info')}}">
                    <img src="{{ $compte->photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($compte->prenom.' '.$compte->nom).'&background=667eea&color=fff&size=36' }}" 
                         alt="Profile" 
                         class="profile-avatar">
                </a>
            </div>
        </div>

        <!-- Notification de virement reçu -->
        <div class="notification-bar">
            <div class="notification-icon">
                <i class="fas fa-times"></i>
            </div>
            <div class="notification-text">
                Un virement de <strong>{{number_format($compte->account_balance, 2, ',', ' ')}} €</strong> a été reçu et 
                crédité sur votre compte. Vous pouvez ajouter votre <strong>IBAN</strong> afin d'effectuer un 
                virement externe vers votre <strong>TRANSFERFLUX</strong>.
            </div>
        </div>

        <!-- Messages d'alerte -->
        @if(session('success'))
        <div class="mobile-alert success">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="mobile-alert error">
            {{ session('error') }}
        </div>
        @endif

        <!-- Salutation utilisateur -->
        <div class="user-greeting">
            Bonjour {{$compte->prenom}} {{$compte->nom}}
        </div>

        <!-- Carte de solde -->
        <div class="balance-card">
            <div class="balance-label">
                <i class="fas fa-coins"></i>
                Solde du compte :
            </div>
            <div class="balance-amount">{{number_format($compte->account_balance, 2, ',', ' ')}} €</div>
            
            <div class="action-buttons">
                <a href="{{route('virement')}}" class="action-btn transfer">
                    Effectuer un virement
                    <i class="fas fa-arrow-right"></i>
                </a>
                <a href="{{route('carte')}}" class="action-btn card">
                    Ma carte
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Section historique des transactions -->
        <div class="transaction-section">
            <h4 class="transaction-header">Historique des transactions</h4>
            <div class="transaction-list">
                @isset($histories)
                @forelse($histories as $index => $history)
                <div class="transaction-item animate-slide-in" style="animation-delay: {{ $index * 0.1 }}s">
                    <div class="transaction-icon 
                        @if(in_array($history->transaction_type, ['Funds added', 'Solde initial', 'transfer received'])) received
                        @elseif($history->transaction_type == 'Transfer sent') sent
                        @elseif($history->transaction_type == 'Refund received') refund
                        @else received @endif">
                        
                        @if(in_array($history->transaction_type, ['Funds added', 'Solde initial', 'transfer received']))
                            <i class="fas fa-arrow-down"></i>
                        @elseif($history->transaction_type == 'Transfer sent')
                            <i class="fas fa-arrow-up"></i>
                        @elseif($history->transaction_type == 'Refund received')
                            <i class="fas fa-sync-alt"></i>
                        @else
                            <i class="fas fa-university"></i>
                        @endif
                    </div>
                    
                    <div class="transaction-details">
                        <div class="transaction-title">{{ ucwords(str_replace('_', ' ', $history->transaction_type)) }}</div>
                        <div class="transaction-description">{{ $history->description }}</div>
                    </div>
                    
                    <div class="transaction-amount">
                        <div class="amount-value {{ $history->amount >= 0 ? 'positive' : 'negative' }}">
                            {{ $history->amount >= 0 ? '+' : '' }}{{ number_format($history->amount, 2, ',', ' ') }} €
                        </div>
                        <div class="transaction-date">{{ formatTransactionDate($history->created_at) }}</div>
                    </div>
                </div>
                @empty
                @endforelse
                @endisset
                
                <!-- Transactions d'exemple pour correspondre à la capture -->
                <div class="transaction-item animate-slide-in">
                    <div class="transaction-icon sent">
                        <i class="fas fa-arrow-up"></i>
                    </div>
                    <div class="transaction-details">
                        <div class="transaction-title">Transfer sent</div>
                        <div class="transaction-description">ParisBaa</div>
                    </div>
                    <div class="transaction-amount">
                        <div class="amount-value negative">- 10 000,00 €</div>
                        <div class="transaction-date">2025-11-09 19:13:16</div>
                    </div>
                </div>

                <div class="transaction-item animate-slide-in">
                    <div class="transaction-icon refund">
                        <i class="fas fa-sync-alt"></i>
                    </div>
                    <div class="transaction-details">
                        <div class="transaction-title">Refund received</div>
                        <div class="transaction-description">TRANSFERFLUX</div>
                    </div>
                    <div class="transaction-amount">
                        <div class="amount-value positive">+ 10 000,00 €</div>
                        <div class="transaction-date">2025-11-09 19:09:05</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation bottom -->
    <footer class="bottom-nav">
        <div class="nav-container">
            <a href="{{route('showroute')}}" class="nav-item active">
                <div class="nav-icon">
                    <i class="fas fa-coins"></i>
                </div>
                <div class="nav-label">Payer</div>
            </a>
            
            <a href="{{route('carte')}}" class="nav-item">
                <div class="nav-icon">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="nav-label">Ma carte</div>
            </a>
            
            <a href="{{route('virement')}}" class="nav-item">
                <div class="nav-icon">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <div class="nav-label">Virement</div>
            </a>
            
            <a href="{{route('info')}}" class="nav-item">
                <div class="nav-icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="nav-label">Mon compte</div>
            </a>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation des transactions au chargement
            const transactions = document.querySelectorAll('.transaction-item');
            transactions.forEach((item, index) => {
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Gestion du clic sur les transactions
            transactions.forEach(item => {
                item.addEventListener('click', function() {
                    // Animation de feedback
                    this.style.transform = 'scale(0.98)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 150);
                    
                    // Ici vous pouvez ajouter une action, comme ouvrir un modal avec plus de détails
                    console.log('Transaction cliquée:', this);
                });
            });

            // Gestion du swipe pour actualiser (optionnel)
            let startY = 0;
            let currentY = 0;
            let pullThreshold = 100;
            
            document.addEventListener('touchstart', function(e) {
                startY = e.touches[0].clientY;
            });
            
            document.addEventListener('touchmove', function(e) {
                currentY = e.touches[0].clientY;
                if (currentY > startY + pullThreshold && window.scrollY === 0) {
                    // Ici vous pouvez ajouter un indicateur de "pull to refresh"
                }
            });
            
            document.addEventListener('touchend', function() {
                if (currentY > startY + pullThreshold && window.scrollY === 0) {
                    // Déclencher l'actualisation
                    refreshData();
                }
                startY = 0;
                currentY = 0;
            });

            // Gestion de la fermeture de la notification
            const notificationClose = document.querySelector('.notification-icon');
            if (notificationClose) {
                notificationClose.addEventListener('click', function() {
                    const notification = document.querySelector('.notification-bar');
                    if (notification) {
                        notification.style.transform = 'translateY(-100%)';
                        notification.style.opacity = '0';
                        setTimeout(() => {
                            notification.style.display = 'none';
                        }, 300);
                    }
                });
            }

            // Fonction d'actualisation
            function refreshData() {
                const balanceElement = document.querySelector('.balance-amount');
                if (balanceElement) {
                    balanceElement.classList.add('animate-pulse');
                    
                    // Simuler une actualisation
                    setTimeout(() => {
                        balanceElement.classList.remove('animate-pulse');
                        // Ici vous pouvez faire un appel AJAX pour actualiser les données
                    }, 1000);
                }
            }

            // Gestion des erreurs d'images
            document.querySelectorAll('img').forEach(img => {
                img.addEventListener('error', function() {
                    this.src = 'https://ui-avatars.com/api/?name=User&background=667eea&color=fff&size=36';
                });
            });

            // Support du mode sombre (détection automatique)
            if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.body.classList.add('dark-mode');
            }

            // Gestion du changement d'orientation
            window.addEventListener('orientationchange', function() {
                setTimeout(() => {
                    // Ajustements si nécessaire après changement d'orientation
                }, 100);
            });
        });

        // Service Worker pour le mode offline (optionnel)
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js').catch(console.error);
        }
    </script>
    @endauth
</body>
</html>