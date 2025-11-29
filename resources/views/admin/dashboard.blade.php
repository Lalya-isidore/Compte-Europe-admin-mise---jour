@extends('admin.layout')

@section('title', 'Tableau de bord Administration')

@push('styles')
<style>
    .welcome-card h2 {
        color: #333;
        margin-bottom: 10px;
    }
    .welcome-card p {
        color: #555;
        margin-bottom: 0;
        line-height: 1.6;
    }
    .admin-actions .card-admin h4 {
        color: #333;
        margin-bottom: 12px;
        font-weight: 600;
    }
    .admin-actions .card-admin p {
        color: #666;
        font-size: 0.95rem;
        margin-bottom: 20px;
    }
</style>
@endpush

@section('content')
    <div class="card-admin welcome-card mb-4">
        <h2>🛡️ Tableau de bord Administration</h2>
        <p>
            <strong>Administrateur :</strong> {{ $admin_email ?? 'Non défini' }}<br>
            <strong>Dernière connexion :</strong> {{ $login_time ? $login_time->format('d/m/Y à H:i') : 'Non disponible' }}<br>
            <strong>Statut :</strong> <span class="badge bg-success">Connecté</span>
        </p>
    </div>

    <div class="row admin-actions g-4">
        <div class="col-md-6">
            <div class="card-admin h-100">
                <h4>👥 Gestion des Utilisateurs</h4>
                <p>Consulter la liste des utilisateurs, ajuster leur crédit et gérer leurs sous-comptes.</p>
                <a href="{{ route('admin.users.index') }}" class="btn btn-gradient w-100">
                    Accéder
                </a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-admin h-100">
                <h4>📊 Gestion des Commissions</h4>
                <p>Consulter, valider et gérer toutes les commissions d'affiliation.</p>
                <a href="{{ route('admin.commissions.index') }}" class="btn btn-gradient w-100">
                    Accéder
                </a>
            </div>
        </div>
    </div>
@endsection

