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
        @php $toolsOpen = request()->routeIs('admin.badgeAgentUsages.*') || request()->routeIs('admin.contratPretUsages.*') || request()->routeIs('admin.contratDonUsages.*'); @endphp
        <button type="button" class="menu-item menu-group-toggle {{ $toolsOpen ? 'active' : '' }}" onclick="toggleMenuGroup(this)">
            <i class="lucide-wrench"></i>
            <span>Outils</span>
            <i class="lucide-chevron-down menu-chevron" style="{{ $toolsOpen ? 'transform:rotate(180deg)' : '' }}"></i>
        </button>
        <div class="menu-group-items" style="{{ $toolsOpen ? '' : 'display:none;' }}">
            <a href="{{ route('admin.badgeAgentUsages.index') }}" class="menu-item menu-sub-item {{ request()->routeIs('admin.badgeAgentUsages.*') ? 'active' : '' }}">
                <i class="lucide-id-card"></i>
                <span>Badge Agent</span>
            </a>
            <a href="{{ route('admin.contratPretUsages.index') }}" class="menu-item menu-sub-item {{ request()->routeIs('admin.contratPretUsages.*') ? 'active' : '' }}">
                <i class="lucide-file-text"></i>
                <span>Contrat de Prêt</span>
            </a>
            <a href="{{ route('admin.contratDonUsages.index') }}" class="menu-item menu-sub-item {{ request()->routeIs('admin.contratDonUsages.*') ? 'active' : '' }}">
                <i class="lucide-heart-handshake"></i>
                <span>Document de Don</span>
            </a>
        </div>
        <a href="{{ route('admin.platformVisits.index') }}" class="menu-item {{ request()->routeIs('admin.platformVisits.*') ? 'active' : '' }}">
            <i class="lucide-bar-chart-2"></i>
            <span>Visites</span>
        </a>
        <a href="{{ route('admin.pwaInstalls.index') }}" class="menu-item {{ request()->routeIs('admin.pwaInstalls.*') ? 'active' : '' }}">
            <i class="lucide-smartphone"></i>
            <span>App installée</span>
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
