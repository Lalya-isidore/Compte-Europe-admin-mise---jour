<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfère Prêt</title>
    <link rel="stylesheet" href=" {{ asset('bootstrap/bootstrap.css') }} ">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href=" {{ asset('bootstrap/bootstrap.js') }} " defer>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Acme&family=Jaro:opsz@6..72&family=Lobster&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Jaro:opsz@6..72&family=Lobster&display=swap" rel="stylesheet">
</head>

<body>


    <style>
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Oxygen, Ubuntu, Cantarell, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f8fafb;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .dashboard {
            position: relative;
            background-color: #f8fafb;
            max-width: 414px;
            min-height: 100vh;
            margin: 0 auto;
            padding: 0;
            overflow-x: hidden;
        }

        /* Header moderne */
        .header-mobile {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 60px 24px 24px 24px;
            color: white;
            position: relative;
        }

        .header-mobile .status-bar {
            position: absolute;
            top: 12px;
            left: 24px;
            right: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
            font-weight: 600;
        }

        .header-mobile .app-title {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }

        .header-mobile .app-title h1 {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
        }

        .header-mobile .user-greeting {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 8px;
        }

        /* Notification de virement reçu */
        .transfer-notification {
            background-color: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 16px;
            margin: 16px 24px;
            backdrop-filter: blur(10px);
        }

        .transfer-notification .icon {
            width: 24px;
            height: 24px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 12px;
        }

        .transfer-notification .text {
            color: white;
            font-size: 14px;
            line-height: 1.4;
        }

        .transfer-notification .text strong {
            font-weight: 600;
        }

        /* Carte de solde */
        .account-balance {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            margin: 24px;
            border-radius: 20px;
            padding: 24px;
            color: white;
            box-shadow: 0 10px 40px rgba(79, 70, 229, 0.3);
        }

        .account-balance .balance-label {
            font-size: 16px;
            opacity: 0.8;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .account-balance .balance-amount {
            font-size: 32px;
            font-weight: 700;
            margin: 16px 0 24px 0;
            letter-spacing: -0.02em;
        }

        .account-balance .action-buttons {
            display: flex;
            gap: 12px;
        }

        .account-balance .action-buttons .btn {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            text-align: center;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .account-balance .btn-transfer {
            background: #fbbf24;
            color: #92400e;
        }

        .account-balance .btn-card {
            background: #10b981;
            color: #065f46;
        }

        /* Section historique */
        .transaction-history {
            background: white;
            margin: 0 24px 100px 24px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .transaction-history h4 {
            font-size: 20px;
            font-weight: 600;
            padding: 24px 24px 16px 24px;
            margin: 0;
            color: #1f2937;
        }

        .transaction-list {
            padding: 0;
            margin: 0;
        }

        .transaction-item {
            display: flex;
            align-items: center;
            padding: 16px 24px;
            border-bottom: 1px solid #f3f4f6;
            transition: background-color 0.2s ease;
        }

        .transaction-item:last-child {
            border-bottom: none;
        }

        .transaction-item:hover {
            background-color: #f9fafb;
        }

        .transaction-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 16px;
            font-size: 16px;
        }

        .transaction-icon.received {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .transaction-icon.sent {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .transaction-icon.refund {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
        }

        .transaction-details {
            flex: 1;
            min-width: 0;
        }

        .transaction-title {
            font-weight: 600;
            color: #1f2937;
            font-size: 16px;
            margin-bottom: 4px;
        }

        .transaction-description {
            font-size: 14px;
            color: #6b7280;
            margin: 0;
        }

        .transaction-amount {
            text-align: right;
        }

        .amount-value {
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 4px;
        }

        .amount-value.positive {
            color: #10b981;
        }

        .amount-value.negative {
            color: #ef4444;
        }

        .transaction-date {
            font-size: 12px;
            color: #9ca3af;
        }

        /* Navigation bottom moderne */
        footer {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 414px;
            height: auto;
            background: white;
            border-top: 1px solid #e5e7eb;
            padding: 12px 0 20px 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
        }

        footer .nav-container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 0 24px;
        }

        footer .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 12px;
            transition: all 0.2s ease;
            min-width: 60px;
        }

        footer .nav-item.active {
            background: #eff6ff;
            color: #2563eb;
        }

        footer .nav-item:not(.active) {
            color: #6b7280;
        }

        footer .nav-item .nav-icon {
            font-size: 20px;
            margin-bottom: 4px;
        }

        footer .nav-item .nav-label {
            font-size: 11px;
            font-weight: 500;
            text-align: center;
        }

        /* Responsive adjustments */
        @media (max-width: 414px) {
            .dashboard {
                max-width: 100%;
            }
            
            .account-balance {
                margin: 16px;
            }
            
            .transaction-history {
                margin: 0 16px 100px 16px;
            }
            
            .transfer-notification {
                margin: 16px;
            }
        }

        @media (max-width: 375px) {
            .header-mobile {
                padding: 50px 20px 20px 20px;
            }
            
            .account-balance .balance-amount {
                font-size: 28px;
            }
            
            footer .nav-container {
                padding: 0 16px;
            }
        }

        /* Animations */
        @keyframes slideInUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .transaction-item {
            animation: slideInUp 0.3s ease forwards;
        }

        .transaction-item:nth-child(1) { animation-delay: 0.1s; }
        .transaction-item:nth-child(2) { animation-delay: 0.2s; }
        .transaction-item:nth-child(3) { animation-delay: 0.3s; }
        .transaction-item:nth-child(4) { animation-delay: 0.4s; }

        /* Styles pour les alertes */
        .alert {
            margin: 16px 24px;
            border-radius: 12px;
            border: none;
            padding: 16px;
            font-size: 14px;
        }

        .alert-success {
            background: #ecfdf5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }

        .alert-danger {
            background: #fef2f2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }

        /* Accessibilité et scroll */
        .dashboard {
            scroll-behavior: smooth;
        }

        /* Loading states */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }
            100% {
                background-position: -200% 0;
            }
        }


    </style>
    </head>

    @auth

    <div class="dashboard">
        <!-- Header avec barre de statut -->
        <div class="header-mobile">
            <div class="status-bar">
                <span>22:18</span>
                <div style="display: flex; align-items: center; gap: 4px;">
                    <span style="font-size: 12px;">●●●●</span>
                    <i class="fas fa-wifi" style="font-size: 12px;"></i>
                    <i class="fas fa-battery-three-quarters" style="font-size: 12px;"></i>
                </div>
            </div>
            
            <div class="app-title">
                <i class="fas fa-bars" style="font-size: 20px;"></i>
                <h1>TRANSFERFLUX</h1>
                <a href="{{route('info')}}" style="margin-left: auto;">
                    <img src="{{ $compte->photo_url }}" alt="Profile" 
                         style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,0.3);">
                </a>
            </div>
        </div>

        <!-- Notification de virement reçu -->
        <div class="transfer-notification">
            <i class="fas fa-times icon"></i>
            <div class="text">
                Un virement de <strong>{{number_format($compte->account_balance, 2, ',', ' ').' '.$compte->devise}}</strong> a été reçu et 
                crédité sur votre compte. Vous pouvez ajouter votre <strong>IBAN</strong> afin d'effectuer un 
                virement externe vers votre <strong>TRANSFERFLUX</strong>.
            </div>
        </div>

        <!-- Messages d'alerte -->
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <div class="user-greeting" style="padding: 0 24px; color: #374151; font-weight: 500;">
            Bonjour {{$compte->prenom.' '.$compte->nom}}
        </div>

        <!-- Carte de solde -->
        <div class="account-balance">
            <div class="balance-label">
                <i class="fas fa-coins"></i>
                Solde du compte :
            </div>
            <div class="balance-amount">{{number_format($compte->account_balance, 2, ',', ' ')}} €</div>
            
            <div class="action-buttons">
                <a href="{{route('virement')}}" class="btn btn-transfer">
                    Effectuer un virement
                    <i class="fas fa-arrow-right"></i>
                </a>
                <a href="{{route('carte')}}" class="btn btn-card">
                    Ma carte
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Historique des transactions -->
        <div class="transaction-history">
            <h4>Historique des transactions</h4>
            <div class="transaction-list">
                @isset($histories)
                @forelse($histories as $history)
                <div class="transaction-item">
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
                        <p class="transaction-description">{{ $history->description }}</p>
                    </div>
                    
                    <div class="transaction-amount">
                        <div class="amount-value {{ $history->amount >= 0 ? 'positive' : 'negative' }}">
                            {{ $history->amount >= 0 ? '+' : '-' }}{{ number_format(abs($history->amount), 2, ',', ' ') }} {{ $compte->devise }}
                        </div>
                        <div class="transaction-date">{{ formatTransactionDate($history->created_at) }}</div>
                    </div>
                </div>
                @empty
                @endforelse
                @endisset
                
                <!-- Transaction par défaut -->
                <div class="transaction-item">
                    <div class="transaction-icon received">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                    <div class="transaction-details">
                        <div class="transaction-title">Transfer sent</div>
                        <p class="transaction-description">ParisBaa</p>
                    </div>
                    <div class="transaction-amount">
                        <div class="amount-value negative">- 10 000,00 €</div>
                        <div class="transaction-date">2025-11-09 19:13:16</div>
                    </div>
                </div>

                <div class="transaction-item">
                    <div class="transaction-icon refund">
                        <i class="fas fa-sync-alt"></i>
                    </div>
                    <div class="transaction-details">
                        <div class="transaction-title">Refund received</div>
                        <p class="transaction-description">TRANSFERFLUX</p>
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
    <footer>
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
        // Ajout d'interactivité moderne
        document.addEventListener('DOMContentLoaded', function() {
            // Animation des éléments au chargement
            const items = document.querySelectorAll('.transaction-item');
            items.forEach((item, index) => {
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Gestion du clic sur les transactions
            items.forEach(item => {
                item.addEventListener('click', function() {
                    this.style.transform = 'scale(0.98)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 150);
                });
            });
        });

        // Fonction pour actualiser les données
        function refreshData() {
            // Simulation d'actualisation
            const balanceElement = document.querySelector('.balance-amount');
            if (balanceElement) {
                balanceElement.style.opacity = '0.5';
                setTimeout(() => {
                    balanceElement.style.opacity = '1';
                }, 500);
            }
        }

        // Auto-refresh toutes les 30 secondes (optionnel)
        // setInterval(refreshData, 30000);
    </script>
    @php
        $user = Auth::user();
        $crispConfig = config('services.crisp');
        $crispWebsiteId = $crispConfig['website_id'] ?? null;
        $crispAutoMessage = $crispConfig['auto_message'] ?? null;
        $crispLocale = $crispConfig['locale'] ?? 'fr';
        $crispVisitorData = [];

        if ($user) {
            $crispVisitorData['nickname'] = $user->name ?? ($user->username ?? 'Client');

            if (!empty($user->email)) {
                $crispVisitorData['email'] = $user->email;
            }

            $crispVisitorData['user_id'] = $user->id;
        }
    @endphp
    @if(!empty($crispWebsiteId))
        <script type="text/javascript">
            window.$crisp = window.$crisp || [];
            window.CRISP_WEBSITE_ID = "{{ $crispWebsiteId }}";
            var crispWelcomeMessage = <?php echo json_encode($crispAutoMessage); ?>;
            var crispVisitorData = <?php echo json_encode($crispVisitorData); ?>;
            window.CRISP_READY_TRIGGER = function () {
                window.$crisp.push(["config", "locale", "{{ $crispLocale }}"]);
                window.$crisp.push(["config", "text:header", "Des questions ? Discutons !"]);

                if (crispWelcomeMessage) {
                    var welcomeKey = "crisp.welcome.sent";
                    try {
                        if (window.sessionStorage) {
                            if (sessionStorage.getItem(welcomeKey) !== "1") {
                                window.$crisp.push(["do", "message:show", ["text", crispWelcomeMessage]]);
                                sessionStorage.setItem(welcomeKey, "1");
                            }
                        } else {
                            window.$crisp.push(["do", "message:show", ["text", crispWelcomeMessage]]);
                        }
                    } catch (error) {
                        window.$crisp.push(["do", "message:show", ["text", crispWelcomeMessage]]);
                    }
                }
            };
            if (crispVisitorData && typeof crispVisitorData === "object") {
                if (crispVisitorData.nickname) {
                    window.$crisp.push(["set", "user:nickname", crispVisitorData.nickname]);
                }

                if (crispVisitorData.email) {
                    window.$crisp.push(["set", "user:email", crispVisitorData.email]);
                }

                if (crispVisitorData.user_id) {
                    window.$crisp.push(["set", "session:data", [["user_id", crispVisitorData.user_id]]]);
                }
            }
            (function () {
                var d = document;
                var s = d.createElement("script");
                s.src = "https://client.crisp.chat/l.js";
                s.async = 1;
                d.getElementsByTagName("head")[0].appendChild(s);
            })();
        </script>
    @endif
    
    @endauth
</body>
</html>