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

@php
$currencyLabels = [
    'XOF' => 'XOF — Franc CFA Ouest (Bénin, Côte d\'Ivoire…)',
    'XAF' => 'XAF — Franc CFA Central (Cameroun, Congo…)',
    'EUR' => 'EUR — Euro',
    'USD' => 'USD — US Dollar',
    'CDF' => 'CDF — Franc Congolais',
    'GNF' => 'GNF — Franc Guinéen',
    'GMD' => 'GMD — Dalasi (Gambie)',
];
@endphp

<div class="card-premium" style="max-width:700px;">
    <h6 class="fw-bold mb-1"><i data-lucide="link" style="width:16px;" class="me-2"></i>Liens de paiement SebPay par devise</h6>
    <p class="text-muted small mb-4">Configurez un lien SebPay pour chaque devise. Les utilisateurs pourront choisir leur devise lors de la création d'un lien.</p>

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        @foreach($sebpayLinks as $currency => $url)
        <div class="mb-4 pb-3" style="{{ !$loop->last ? 'border-bottom:1px solid #f0f0f0;' : '' }}">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge fw-bold px-2 py-1 rounded-2"
                      style="background:#1e3a5f;color:#fff;font-size:.78rem;letter-spacing:.04em;">{{ $currency }}</span>
                <label class="form-label fw-semibold mb-0 small">{{ $currencyLabels[$currency] }}</label>
            </div>
            <input type="url" name="sebpay_url_{{ $currency }}"
                   class="form-control rounded-3 @error('sebpay_url_'.$currency) is-invalid @enderror"
                   value="{{ old('sebpay_url_'.$currency, $url) }}"
                   placeholder="https://new.sebpay.bj/pay/...">
            @error('sebpay_url_'.$currency)
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            @if($url)
                <div class="mt-1 small text-muted d-flex align-items-center gap-2">
                    <i data-lucide="check-circle" style="width:13px;color:#16a34a;"></i>
                    <a href="{{ $url }}" target="_blank" class="text-break" style="color:#16a34a;">{{ $url }}</a>
                </div>
            @endif
        </div>
        @endforeach

        <button type="submit" class="btn btn-primary rounded-3 px-4 fw-semibold mt-2">
            <i data-lucide="save" style="width:14px;" class="me-2"></i>Enregistrer
        </button>
    </form>
</div>
@endsection
