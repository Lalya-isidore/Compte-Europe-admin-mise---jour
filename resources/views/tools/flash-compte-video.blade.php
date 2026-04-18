@extends('layouts.admin')

@section('title', 'Vidéo explicative - Flash Compte Pro')

@section('breadcrumb')
    <li class="breadcrumb-item"><i class="fas fa-briefcase me-1"></i>Outils</li>
    <li class="breadcrumb-item"><a href="{{ route('compte.create') }}"><i class="fas fa-exchange-alt me-1"></i>Flash Compte Pro</a></li>
    <li class="breadcrumb-item active"><i class="fas fa-play-circle me-1"></i>Vidéo explicative</li>
@endsection

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Cabin:wght@400;500;600;700&family=Righteous&display=swap');
@import url('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css');
@import url('https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css');

.fcp-video-wrap { font-family: 'Cabin', sans-serif; }

.fcp-video-wrap .page-title {
    background: white;
    box-shadow: 0 0 12px rgba(0,0,0,.14);
    font-family: 'Righteous', cursive;
    margin-bottom: 24px;
    padding: 20px;
    font-size: .9em;
    border-radius: 8px;
}
.fcp-video-wrap .page-title a, .fcp-video-wrap .page-title span {
    text-decoration: none; color: black; transition: all 150ms ease;
}
.fcp-video-wrap .page-title a:hover { color: #4285f4; }

.fcp-video-wrap .video-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 0 24px rgba(0,0,0,.1);
    overflow: hidden;
    max-width: 900px;
    margin: 0 auto 32px;
}

.fcp-video-wrap .video-card-header {
    background: linear-gradient(135deg, #4f429b 0%, #6f42c1 100%);
    color: white;
    padding: 20px 24px;
    display: flex;
    align-items: center;
    gap: 12px;
}
.fcp-video-wrap .video-card-header i { font-size: 1.4rem; }
.fcp-video-wrap .video-card-header h5 {
    margin: 0;
    font-family: 'Righteous', cursive;
    font-size: 1.1rem;
}
.fcp-video-wrap .video-card-header p {
    margin: 4px 0 0;
    font-size: .82rem;
    opacity: .85;
}

.fcp-video-wrap .video-container {
    position: relative;
    background: #000;
    width: 100%;
}
.fcp-video-wrap video {
    width: 100%;
    display: block;
    max-height: 520px;
}

.fcp-video-wrap .video-card-footer {
    padding: 20px 24px;
    border-top: 1px solid #f1f1f1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
}
.fcp-video-wrap .video-info {
    font-size: .85rem;
    color: #555;
    display: flex;
    align-items: center;
    gap: 8px;
}
.fcp-video-wrap .video-info i { color: #4f429b; }

.fcp-video-wrap .info-section {
    max-width: 900px;
    margin: 0 auto;
}
.fcp-video-wrap .info-section .alert {
    font-size: .9rem;
    border-radius: 10px;
}
.fcp-video-wrap .feature-list {
    list-style: none;
    padding: 0;
    margin: 12px 0 0;
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}
.fcp-video-wrap .feature-list li {
    background: #f0ecff;
    color: #4f429b;
    border-radius: 20px;
    padding: 4px 14px;
    font-size: .82rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 5px;
}
</style>

<div class="fcp-video-wrap">
    {{-- Breadcrumb title --}}
    <div class="page-title">
        <a href="{{ route('dashboard') }}"><i class="fi fi-rr-home"></i></a>
        &nbsp;<i class="fi fi-rr-angle-right"></i>&nbsp;
        <a href="{{ route('dashboard') }}"><i class="fi fi-rr-tool-box"></i> Outils</a>
        &nbsp;<i class="fi fi-rr-angle-right"></i>&nbsp;
        <a href="{{ route('compte.create') }}"><i class="fi fi-rr-data-transfer"></i> Flash Compte Pro</a>
        &nbsp;<i class="fi fi-rr-angle-right"></i>&nbsp;
        <span><i class="bi bi-play-circle"></i> Vidéo explicative</span>
    </div>

    {{-- Video card --}}
    <div class="video-card">
        <div class="video-card-header">
            <i class="bi bi-play-circle-fill"></i>
            <div>
                <h5>Vidéo explicative — Flash Compte Pro</h5>
                <p>Découvrez comment fonctionne l'outil Flash Compte Pro</p>
            </div>
        </div>
        <div class="video-container">
            <video controls preload="metadata" controlsList="nodownload" poster="">
                <source src="{{ asset('storage/video-flash-compte.mp4') }}" type="video/mp4">
                Votre navigateur ne supporte pas la lecture vidéo.
            </video>
        </div>
        <div class="video-card-footer">
            <span class="video-info">
                <i class="bi bi-info-circle"></i>
                Vidéo de présentation du système Flash Compte Pro
            </span>
            <a href="{{ route('compte.create') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left-short"></i> Retour à l'outil
            </a>
        </div>
    </div>

    {{-- Info section --}}
    <div class="info-section">
        <div class="alert alert-primary">
            <p style="margin-bottom:8px"><i class="bi bi-info-circle"></i> <b>Flash Compte Pro</b> vous permet de créer des accès flash compte pour vos clients à l'international.</p>
            <p style="margin-bottom:8px">Fonctionnalités disponibles :</p>
            <ul class="feature-list">
                <li><i class="bi bi-check-circle-fill"></i> Solde de compte</li>
                <li><i class="bi bi-check-circle-fill"></i> Crédit/Débit</li>
                <li><i class="bi bi-check-circle-fill"></i> Remboursement</li>
                <li><i class="bi bi-check-circle-fill"></i> Carte virtuelle</li>
                <li><i class="bi bi-check-circle-fill"></i> Virement</li>
                <li><i class="bi bi-check-circle-fill"></i> Profil client</li>
                <li><i class="bi bi-check-circle-fill"></i> Alertes SMS</li>
                <li><i class="bi bi-check-circle-fill"></i> Alertes e-mail temps réel</li>
            </ul>
            <p style="margin-top:12px;margin-bottom:0"><b>NB :</b> Un accès Flash Compte Pro coûte <b>4000 crédits</b> (+ 1000 crédits pour les alertes SMS).</p>
        </div>
        <div class="d-flex justify-content-center" style="margin-top:8px">
            <a href="{{ route('compte.create') }}" class="btn btn-primary">
                <i class="bi bi-lightning-fill"></i> Créer un accès Flash Compte
            </a>
        </div>
    </div>
</div>
@endsection
