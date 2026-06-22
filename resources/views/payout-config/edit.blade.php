@extends('layouts.admin')

@section('title', 'Mon compte de réception')

@section('breadcrumb')
    <li class="breadcrumb-item"><i class="fas fa-mobile-alt me-1"></i>Réception Mobile Money</li>
    <li class="breadcrumb-item active">Configuration</li>
@endsection

@section('content')
<div class="container-fluid px-0" style="max-width:560px;">

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-1"><i class="fas fa-mobile-alt text-success me-2"></i>Numéro de réception Mobile Money</h5>
            <p class="text-muted small mb-4">Ce numéro recevra les virements après validation de vos demandes de paiement.</p>

            @if(session('success'))
                <div class="alert alert-success rounded-3 py-2">{{ session('success') }}</div>
            @endif

            <form action="{{ route('payout-config.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Réseau Mobile Money <span class="text-danger">*</span></label>
                    <div class="d-flex gap-3 flex-wrap">
                        @foreach(['MTN' => '#FFCC00', 'MOOV' => '#0070C0', 'CELTIS' => '#E30613'] as $net => $color)
                        <label class="d-flex align-items-center gap-2 border rounded-3 px-3 py-2 cursor-pointer"
                               style="cursor:pointer; {{ old('network', $config->network ?? '') === $net ? "border-color:{$color}!important;background:rgba(0,0,0,.03);" : '' }}">
                            <input type="radio" name="network" value="{{ $net }}"
                                   {{ old('network', $config->network ?? '') === $net ? 'checked' : '' }}
                                   class="form-check-input m-0">
                            <span class="fw-bold" style="color:{{ $color }}">{{ $net }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('network')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Numéro de téléphone <span class="text-danger">*</span></label>
                    <input type="text" name="phone_number" class="form-control rounded-3 @error('phone_number') is-invalid @enderror"
                           value="{{ old('phone_number', $config->phone_number ?? '') }}"
                           placeholder="Ex: +229 97000000">
                    @error('phone_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Nom du titulaire <span class="text-muted fw-normal">(optionnel)</span></label>
                    <input type="text" name="holder_name" class="form-control rounded-3"
                           value="{{ old('holder_name', $config->holder_name ?? '') }}"
                           placeholder="Nom complet sur le compte mobile money">
                </div>

                <button type="submit" class="btn btn-success rounded-3 px-4 fw-semibold">
                    <i class="fas fa-save me-2"></i>Enregistrer
                </button>
                <a href="{{ route('payment-claims.index') }}" class="btn btn-light rounded-3 px-4 ms-2">Retour</a>
            </form>
        </div>
    </div>
</div>
@endsection
