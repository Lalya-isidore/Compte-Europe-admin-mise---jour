@extends('layouts.admin')

@section('title', 'Mail Pro Privé')

@section('breadcrumb')
        <li class="breadcrumb-item"><i class="fas fa-briefcase me-1"></i>Outils</li>
        <li class="breadcrumb-item active"><i class="fas fa-shield-alt me-1"></i>Mail Pro Privé</li>
@endsection

@section('content')
<div class="container py-5">
    <div class="coming-soon-card text-center">
        <div class="coming-soon-icon mb-4">
            <i class="fas fa-envelope-shield"></i>
        </div>
        <h2 class="fw-bold mb-3">Mail Pro Privé</h2>
        <p class="lead mb-4">Cette fonctionnalité arrive bientôt. Nous préparons l'espace dédié avec noms de domaines sécurisés et boîtes privées.</p>
        <span class="badge bg-warning text-dark px-3 py-2">A venir</span>
    </div>
</div>

<style>
    .coming-soon-card {
        background: #fff;
        border-radius: 24px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 20px 45px rgba(15,23,42,0.08);
        padding: 3rem 2rem;
        max-width: 640px;
        margin: 0 auto;
    }
    .coming-soon-icon {
        width: 90px;
        height: 90px;
        border-radius: 999px;
        background: #eef2ff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #4f46e5;
        font-size: 2.5rem;
    }
</style>
@endsection
