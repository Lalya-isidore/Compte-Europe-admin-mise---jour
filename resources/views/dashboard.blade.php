@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Dashboard FlashCompte</h1>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-university fa-3x text-primary mb-3"></i>
                    <h5>FlashCompte</h5>
                    <p>Gestion des comptes virtuels</p>
                    <a href="{{ route('compte.view') }}" class="btn btn-primary">Accéder</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-handshake fa-3x text-success mb-3"></i>
                    <h5>Affiliation</h5>
                    <p>Système de parrainage et commissions</p>
                    <a href="{{ route('affiliation.index') }}" class="btn btn-success">Gérer</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-credit-card fa-3x text-warning mb-3"></i>
                    <h5>Recharge</h5>
                    <p>Recharger votre compte FlashCompte</p>
                    <a href="{{ route('recharge.index') }}" class="btn btn-warning">Recharger</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
