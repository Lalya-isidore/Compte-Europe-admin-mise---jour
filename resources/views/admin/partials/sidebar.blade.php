@php
    $adminEmail = session('admin_email');
@endphp

<aside class="sidebar" id="adminSidebar">
    <div class="sidebar-header">
        <img src="{{ asset('icon-192.png') }}" alt="FlashBilan" style="width:40px;height:40px;border-radius:10px;object-fit:contain;">
        <h2>ADMIN PANEL</h2>
    </div>
    
    <div class="sidebar-menu">
        <p class="menu-label">Main</p>
        <a href="{{ route('admin.index') }}" class="menu-item {{ request()->routeIs('admin.index') ? 'active' : '' }}">
            <i class="lucide-layout-dashboard"></i>
            <span>Tableau de bord</span>
        </a>
        
        <p class="menu-label">Management</p>
        <a href="{{ route('admin.users.index') }}" class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="lucide-users"></i>
            <span>Utilisateurs</span>
        </a>
        <a href="{{ route('admin.commissions.index') }}" class="menu-item {{ request()->routeIs('admin.commissions.*') ? 'active' : '' }}">
            <i class="lucide-percent"></i>
            <span>Commissions</span>
        </a>
        <a href="{{ route('admin.activeClients.index') }}" class="menu-item {{ request()->routeIs('admin.activeClients.*') ? 'active' : '' }}">
            <i class="lucide-user-check"></i>
            <span>Clients actifs</span>
        </a>
        @php
            $paidSlugs = ['simulateur-credit','phone-verify','iban-check','flash-compte-pro','coupon','sms-pro','payment-claims'];
            $freeSlugs = ['qr-generator','url-check','url-shortener','mail-extractor'];
            $currentTool = request()->route('tool');
            $paidOpen = request()->routeIs('admin.contratPretUsages.*')
                     || request()->routeIs('admin.contratDonUsages.*')
                     || request()->routeIs('admin.paymentClaims.*')
                     || (request()->routeIs('admin.toolVisits.show') && in_array($currentTool, $paidSlugs));
            $freeOpen  = request()->routeIs('admin.badgeAgentUsages.*')
                     || (request()->routeIs('admin.toolVisits.show') && in_array($currentTool, $freeSlugs));
        @endphp

        {{-- Outils à accès payant --}}
        <button type="button" class="menu-item menu-group-toggle {{ $paidOpen ? 'active' : '' }}" onclick="toggleMenuGroup(this)">
            <i class="lucide-lock"></i>
            <span>Outils payants</span>
            <i class="lucide-chevron-down menu-chevron" style="{{ $paidOpen ? 'transform:rotate(180deg)' : '' }}"></i>
        </button>
        <div class="menu-group-items" style="{{ $paidOpen ? '' : 'display:none;' }}">
            <a href="{{ route('admin.contratPretUsages.index') }}" class="menu-item menu-sub-item {{ request()->routeIs('admin.contratPretUsages.*') ? 'active' : '' }}">
                <i class="lucide-file-text"></i>
                <span>Contrat de Prêt</span>
            </a>
            <a href="{{ route('admin.contratDonUsages.index') }}" class="menu-item menu-sub-item {{ request()->routeIs('admin.contratDonUsages.*') ? 'active' : '' }}">
                <i class="lucide-heart-handshake"></i>
                <span>Document de Don</span>
            </a>
            <a href="{{ route('admin.toolVisits.show', 'simulateur-credit') }}" class="menu-item menu-sub-item {{ $currentTool === 'simulateur-credit' ? 'active' : '' }}">
                <i class="lucide-calculator"></i>
                <span>Simulateur Crédit</span>
            </a>
            <a href="{{ route('admin.toolVisits.show', 'phone-verify') }}" class="menu-item menu-sub-item {{ $currentTool === 'phone-verify' ? 'active' : '' }}">
                <i class="lucide-phone"></i>
                <span>Vérif. Téléphone</span>
            </a>
            <a href="{{ route('admin.toolVisits.show', 'iban-check') }}" class="menu-item menu-sub-item {{ $currentTool === 'iban-check' ? 'active' : '' }}">
                <i class="lucide-credit-card"></i>
                <span>Vérif. IBAN</span>
            </a>
            <a href="{{ route('admin.toolVisits.show', 'flash-compte-pro') }}" class="menu-item menu-sub-item {{ $currentTool === 'flash-compte-pro' ? 'active' : '' }}">
                <i class="lucide-zap"></i>
                <span>Flash Compte Pro</span>
            </a>
            <a href="{{ route('admin.toolVisits.show', 'flash-compte-pro-video') }}" class="menu-item menu-sub-item {{ $currentTool === 'flash-compte-pro-video' ? 'active' : '' }}">
                <i class="lucide-play-circle"></i>
                <span>Vidéo Flash Compte</span>
            </a>
            <a href="{{ route('admin.toolVisits.show', 'coupon') }}" class="menu-item menu-sub-item {{ $currentTool === 'coupon' ? 'active' : '' }}">
                <i class="lucide-ticket"></i>
                <span>Collecte Coupon</span>
            </a>
            <a href="{{ route('admin.toolVisits.show', 'sms-pro') }}" class="menu-item menu-sub-item {{ $currentTool === 'sms-pro' ? 'active' : '' }}">
                <i class="lucide-message-circle"></i>
                <span>SMS Pro</span>
            </a>
            <a href="{{ route('admin.toolVisits.show', 'payment-claims') }}" class="menu-item menu-sub-item {{ $currentTool === 'payment-claims' ? 'active' : '' }}">
                <i class="lucide-users"></i>
                <span>Visites — Dem. paiement</span>
            </a>
            <a href="{{ route('admin.paymentClaims.index') }}" class="menu-item menu-sub-item {{ request()->routeIs('admin.paymentClaims.*') ? 'active' : '' }}">
                <i class="lucide-banknote"></i>
                <span>Demande de paiement</span>
                @php $pendingClaims = \App\Models\PaymentClaim::where('status','pending')->count(); @endphp
                @if($pendingClaims > 0)
                    <span class="badge bg-warning text-dark ms-auto">{{ $pendingClaims }}</span>
                @endif
            </a>
        </div>

        {{-- Outils à accès libre --}}
        <button type="button" class="menu-item menu-group-toggle {{ $freeOpen ? 'active' : '' }}" onclick="toggleMenuGroup(this)">
            <i class="lucide-unlock"></i>
            <span>Outils gratuits</span>
            <i class="lucide-chevron-down menu-chevron" style="{{ $freeOpen ? 'transform:rotate(180deg)' : '' }}"></i>
        </button>
        <div class="menu-group-items" style="{{ $freeOpen ? '' : 'display:none;' }}">
            <a href="{{ route('admin.badgeAgentUsages.index') }}" class="menu-item menu-sub-item {{ request()->routeIs('admin.badgeAgentUsages.*') ? 'active' : '' }}">
                <i class="lucide-id-card"></i>
                <span>Badge Agent</span>
            </a>
            <a href="{{ route('admin.toolVisits.show', 'qr-generator') }}" class="menu-item menu-sub-item {{ $currentTool === 'qr-generator' ? 'active' : '' }}">
                <i class="lucide-qr-code"></i>
                <span>QR Code</span>
            </a>
            <a href="{{ route('admin.toolVisits.show', 'url-check') }}" class="menu-item menu-sub-item {{ $currentTool === 'url-check' ? 'active' : '' }}">
                <i class="lucide-shield-check"></i>
                <span>Vérif. URL</span>
            </a>
            <a href="{{ route('admin.toolVisits.show', 'url-shortener') }}" class="menu-item menu-sub-item {{ $currentTool === 'url-shortener' ? 'active' : '' }}">
                <i class="lucide-link"></i>
                <span>Raccourcisseur URL</span>
            </a>
            <a href="{{ route('admin.toolVisits.show', 'mail-extractor') }}" class="menu-item menu-sub-item {{ $currentTool === 'mail-extractor' ? 'active' : '' }}">
                <i class="lucide-mail-search"></i>
                <span>Extracteur E-mails</span>
            </a>
        </div>
        <p class="menu-label">Statistiques</p>
        <a href="{{ route('admin.platformVisits.index') }}" class="menu-item {{ request()->routeIs('admin.platformVisits.*') ? 'active' : '' }}">
            <i class="lucide-bar-chart-2"></i>
            <span>Visites</span>
        </a>
        <a href="{{ route('admin.pwaInstalls.index') }}" class="menu-item {{ request()->routeIs('admin.pwaInstalls.*') ? 'active' : '' }}">
            <i class="lucide-smartphone"></i>
            <span>App installée</span>
        </a>
        <a href="{{ route('admin.toolVisits.show', 'recharge') }}" class="menu-item {{ $currentTool === 'recharge' ? 'active' : '' }}">
            <i class="lucide-wallet"></i>
            <span>Page Recharge</span>
        </a>
        <a href="{{ route('admin.rechargeStats.index') }}" class="menu-item {{ request()->routeIs('admin.rechargeStats.*') ? 'active' : '' }}">
            <i class="lucide-credit-card"></i>
            <span>Dépôts crédits</span>
        </a>

        <p class="menu-label">Communication</p>
        <a href="{{ route('admin.support.index') }}" class="menu-item {{ request()->routeIs('admin.support.*') ? 'active' : '' }}">
            <i class="lucide-message-square"></i>
            <span>Support</span>
            <span class="badge bg-danger ms-auto" id="adminSidebarBadge" hidden>0</span>
        </a>
        <a href="{{ route('admin.notifyUsers.index') }}" class="menu-item {{ request()->routeIs('admin.notifyUsers.*') ? 'active' : '' }}">
            <i class="lucide-mail"></i>
            <span>Emailing</span>
        </a>

        <div style="margin-top: auto; padding-top: 40px;">
            <p class="menu-label">System</p>
            <a href="{{ route('admin.settings.index') }}" class="menu-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="lucide-settings"></i>
                <span>Paramètres</span>
            </a>
            <form action="{{ route('admin.logout') }}" method="POST" id="logoutForm">
                @csrf
                <button type="submit" class="menu-item w-100 border-0 bg-transparent text-start">
                    <i class="lucide-log-out"></i>
                    <span>Déconnexion</span>
                </button>
            </form>
        </div>
    </div>
</aside>

<script>
    function toggleMenuGroup(btn) {
        const items = btn.nextElementSibling;
        const chevron = btn.querySelector('.menu-chevron');
        const isOpen = items.style.display !== 'none';
        items.style.display = isOpen ? 'none' : 'block';
        if (chevron) chevron.style.transform = isOpen ? '' : 'rotate(180deg)';
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Simple polling for the badge (reusing the logic from the old nav)
        const sidebarBadge = document.getElementById('adminSidebarBadge');
        if (sidebarBadge) {
            const fetchSidebarCount = async () => {
                try {
                    const response = await fetch('{{ route('admin.support.unread-count') }}', {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    if (response.ok) {
                        const data = await response.json();
                        const count = Number(data.count) || 0;
                        if (count > 0) {
                            sidebarBadge.textContent = count > 99 ? '99+' : count;
                            sidebarBadge.hidden = false;
                        } else {
                            sidebarBadge.hidden = true;
                        }
                    }
                } catch (e) {}
            };
            fetchSidebarCount();
            setInterval(fetchSidebarCount, 30000);
        }
    });
</script>
