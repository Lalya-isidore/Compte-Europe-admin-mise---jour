@extends('layouts.admin')

@section('title', 'Paiement Annulé')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('recharge.index') }}"><i class="fas fa-wallet me-1"></i>Recharge</a></li>
    <li class="breadcrumb-item active"><i class="fas fa-times-circle me-1"></i>Paiement Annulé</li>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <i class="fas fa-times-circle text-danger" style="font-size: 4rem;"></i>
                    </div>
                    
                    <h2 class="text-danger mb-3">Paiement Annulé</h2>
                    
                    @if(session('error'))
                        <div class="alert alert-warning mb-4">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                        </div>
                    @endif
                    
                    <p class="lead text-muted mb-4">
                        Votre paiement a été annulé ou a échoué. 
                        Aucun montant n'a été débité de votre compte.
                    </p>
                    
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Que faire maintenant ?</strong>
                        <ul class="text-start mt-2 mb-0">
                            <li>Vérifiez votre solde avant de réessayer</li>
                            <li>Essayez une autre méthode de paiement</li>
                            <li>Contactez votre banque si le problème persiste</li>
                        </ul>
                    </div>
                    
                    <div class="d-flex flex-column flex-sm-row flex-wrap gap-3 justify-content-center">
                        <a href="{{ route('recharge.index') }}" class="btn btn-primary w-100 w-md-auto">
                            <i class="fas fa-redo me-2"></i>Réessayer le Paiement
                        </a>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary w-100 w-md-auto">
                            <i class="fas fa-home me-2"></i>Retour au Tableau de Bord
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection