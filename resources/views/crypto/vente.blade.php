@extends('layouts.admin')

@section('title', 'Vente de Crypto USDT')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
        <li class="breadcrumb-item"><i class="fas fa-briefcase me-1"></i>Outils</li>
        <li class="breadcrumb-item active"><i class="fas fa-coins me-1"></i>Vente de Crypto USDT</li>
    </ol>
@endsection

@section('content')
<div class="container py-5">
    <div class="coming-soon-card text-center">
        <div class="coming-soon-icon mb-4 bg-warning-subtle text-warning">
            <i class="fas fa-coins"></i>
        </div>
        <h2 class="fw-bold mb-3">Vente de Crypto USDT</h2>
        <p class="lead mb-4">Nous finalisons les intégrations de paiement crypto. L'espace sera disponible très bientôt.</p>
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
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
    }
    .bg-warning-subtle {
        background: #fef3c7;
    }
</style>
@endsection
