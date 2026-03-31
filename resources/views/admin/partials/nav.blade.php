@php
    $adminEmail = session('admin_email');
@endphp
<nav class="navbar navbar-admin navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('admin.index') }}">
            🛡️ Administration
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar"
            aria-controls="adminNavbar" aria-expanded="false" aria-label="Basculer la navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="adminNavbar">
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.index') ? 'active' : '' }}" href="{{ route('admin.index') }}">
                        Tableau de bord
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                        Utilisateurs
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-1 {{ request()->routeIs('admin.support.*') ? 'active' : '' }}" href="{{ route('admin.support.index') }}">
                        <span>Messages</span>
                        <span class="badge bg-danger" id="adminSupportBadge" hidden>0</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.notifyUsers.*') ? 'active' : '' }}" href="{{ route('admin.notifyUsers.index') }}">
                        E-mails
                    </a>
                </li>
                <li class="nav-item">
                    <span class="nav-link text-white-50">
                        👤 {{ $adminEmail ?? 'Admin' }}
                    </span>
                </li>
                <li class="nav-item">
                    <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-white">
                            🚪 Déconnexion
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
