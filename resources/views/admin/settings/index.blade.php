@extends('admin.layout')

@section('title', 'Paramètres Plateforme')

@section('content')

<div class="mb-5">
    <h2 class="fw-bold h3 mb-2">Paramètres Plateforme ⚙️</h2>
    <p class="text-secondary">Configuration globale de la plateforme.</p>
</div>

@if(session('success'))
    <div class="alert alert-success rounded-3 py-2 mb-4">{{ session('success') }}</div>
@endif

<div class="card-premium" style="max-width:600px;">
    <h6 class="fw-bold mb-4"><i data-lucide="link" style="width:16px;" class="me-2"></i>Lien de paiement SebPay</h6>

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="form-label fw-semibold">URL du lien de paiement</label>
            <input type="url" name="sebpay_payment_url"
                   class="form-control rounded-3 @error('sebpay_payment_url') is-invalid @enderror"
                   value="{{ old('sebpay_payment_url', $sebpayUrl) }}"
                   placeholder="https://new.sebpay.bj/pay/...">
            <div class="form-text">Ce lien sera affiché à tous les utilisateurs dans leur espace Encaissement.</div>
            @error('sebpay_payment_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        @if($sebpayUrl)
        <div class="bg-light rounded-3 p-3 mb-4 d-flex align-items-center gap-3">
            <i data-lucide="external-link" class="text-primary" style="width:18px;flex-shrink:0;"></i>
            <div>
                <div class="small text-muted mb-1">Lien actuel :</div>
                <a href="{{ $sebpayUrl }}" target="_blank" class="small text-break">{{ $sebpayUrl }}</a>
            </div>
        </div>
        @endif

        <button type="submit" class="btn btn-primary rounded-3 px-4 fw-semibold">
            <i data-lucide="save" style="width:14px;" class="me-2"></i>Enregistrer
        </button>
    </form>
</div>
@endsection
