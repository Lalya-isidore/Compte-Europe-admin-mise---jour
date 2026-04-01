@php
    $adminEmail = session('admin_email');
@endphp

<aside class="sidebar" id="adminSidebar">
    <div class="sidebar-header">
        <div class="stat-icon bg-primary text-white">
            <i class="lucide-shield"></i>
        </div>
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
