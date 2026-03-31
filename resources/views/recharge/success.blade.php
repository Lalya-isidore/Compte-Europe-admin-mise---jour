@extends('layouts.admin')

@section('title', 'Paiement Réussi')

@section('breadcrumb')
    <li class="breadcrumb-item"><i class="fas fa-wallet me-1"></i>Recharge</li>
    <li class="breadcrumb-item active"><i class="fas fa-check-circle me-1"></i>Paiement Réussi</li>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    
                    <h2 class="text-success mb-3">Paiement Réussi !</h2>
                    
                    @if(session('success'))
                        <div class="alert alert-success mb-4">
                            <i class="fas fa-check me-2"></i>{{ session('success') }}
                        </div>
                    @endif
                    
                    <p class="lead text-muted mb-4">
                        Votre recharge a été effectuée avec succès. 
                        Vos crédits ont été ajoutés à votre compte.
                    </p>
                    
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Information :</strong> Vous pouvez maintenant utiliser vos crédits pour créer des comptes {{ app('region')->appName() }}.
                    </div>
                    
                    <div class="d-flex gap-3 justify-content-center">
                        <a href="{{ route('recharge.index') }}" class="btn btn-primary">
                            <i class="fas fa-history me-2"></i>Voir l'Historique
                        </a>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-home me-2"></i>Retour au Tableau de Bord
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
