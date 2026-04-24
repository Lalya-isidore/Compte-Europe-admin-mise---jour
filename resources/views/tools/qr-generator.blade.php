@extends('layouts.admin')

@section('title', 'Générateur de QR Code')

@section('breadcrumb')
    <li class="breadcrumb-item"><i class="fas fa-tools me-1"></i>Outils</li>
    <li class="breadcrumb-item active">Générateur de QR Code</li>
@endsection

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Righteous&display=swap');
@import url('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css');

:root {
    --ce-primary: #2196F3;
    --ce-secondary: #FF6B35;
    --ce-success: #10b981;
    --ce-bg: #f5f3ef;
    --ce-card-bg: #ffffff;
    --ce-text: #333333;
    --ce-text-dim: #888888;
    --ce-border: #e8e8e8;
    --ce-gradient: linear-gradient(135deg, #FF6B35, #F7C948, #4ECDC4, #6C5CE7);
}

.qr-premium-wrap {
    font-family: 'Poppins', sans-serif;
    color: var(--ce-text);
    padding: 20px 24px;
}

.qr-header {
    margin-bottom: 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.qr-header h1 {
    font-size: 1.6rem;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 12px;
    color: var(--ce-text);
}

.qr-header h1 span {
    font-family: 'Righteous', cursive;
    background: var(--ce-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.badge-certified {
    background: #fff;
    color: var(--ce-text-dim);
    border: 1px solid var(--ce-border);
    border-radius: 100px;
    padding: 6px 14px;
    font-size: 0.75rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

.main-layout {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 30px;
}

@media (max-width: 1024px) {
    .main-layout { grid-template-columns: 1fr; }
}

/* Panels */
.ce-card {
    background: var(--ce-card-bg);
    border: 1px solid var(--ce-border);
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
}

/* Tabs */
.settings-tabs {
    display: flex;
    gap: 10px;
    margin-bottom: 30px;
    border-bottom: 1px solid var(--ce-border);
}

.tab-btn {
    padding: 12px 20px;
    border: none;
    background: transparent;
    color: var(--ce-text-dim);
    font-size: 0.9rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    position: relative;
    transition: all 0.2s ease;
}

.tab-btn::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 3px;
    background: var(--ce-primary);
    transform: scaleX(0);
    transition: transform 0.2s ease;
}

.tab-btn.active {
    color: var(--ce-primary);
}

.tab-btn.active::after {
    transform: scaleX(1);
}

/* Form Styles */
.settings-content {
    display: none;
}
.settings-content.active {
    display: block;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.form-group {
    margin-bottom: 24px;
}

.form-label {
    display: block;
    margin-bottom: 10px;
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--ce-text);
}

.ce-input {
    width: 100%;
    background: #fcfcfc;
    border: 1px solid var(--ce-border);
    border-radius: 12px;
    padding: 14px 18px;
    color: var(--ce-text);
    font-size: 0.95rem;
    transition: all 0.2s ease;
}

.ce-input:focus {
    outline: none;
    border-color: var(--ce-primary);
    box-shadow: 0 0 0 4px rgba(33, 150, 243, 0.1);
    background: #fff;
}

.color-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 24px;
    background: #f8f9fa;
    padding: 20px;
    border-radius: 16px;
    border: 1px solid var(--ce-border);
}

.color-picker-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}

.color-circle {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    border: 2px solid white;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    cursor: pointer;
    position: relative;
    overflow: hidden;
    transition: transform 0.2s ease;
}

.color-circle:hover {
    transform: scale(1.1);
}

.color-circle input {
    position: absolute;
    top: -5px; left: -5px; width: 140%; height: 140%;
    cursor: pointer;
    opacity: 0;
}

.color-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--ce-text-dim);
    text-transform: uppercase;
}

/* Presets */
.presets-grid {
    display: flex;
    gap: 8px;
    margin-top: 15px;
}

.preset-dot {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    cursor: pointer;
    border: 1px solid rgba(0,0,0,0.05);
    transition: transform 0.2s;
}

.preset-dot:hover {
    transform: scale(1.2);
}

/* Style Buttons */
.style-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
}

.style-btn {
    background: #f8f9fa;
    border: 1px solid var(--ce-border);
    border-radius: 12px;
    padding: 12px;
    color: var(--ce-text-dim);
    font-size: 0.8rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.style-btn:hover {
    background: #f0f1f3;
}

.style-btn.active {
    background: rgba(33, 150, 243, 0.08);
    border-color: var(--ce-primary);
    color: var(--ce-primary);
}

/* Format tabs */
.format-tabs { display:flex; gap:6px; }
.format-tab { flex:1; padding:8px 10px; border:2px solid var(--ce-border); border-radius:10px; background:var(--ce-bg); color:var(--ce-text-dim); font-size:.82rem; font-weight:600; cursor:pointer; transition:all .18s; display:flex; align-items:center; justify-content:center; gap:6px; }
.format-tab i { font-size:1rem; }
.format-tab.active { border-color:var(--ce-primary); background:rgba(33,150,243,.08); color:var(--ce-primary); }

/* Fond tabs */
.bg-tabs { display:flex; gap:6px; margin-bottom:12px; }
.bg-tab { flex:1; padding:7px 10px; border:2px solid var(--ce-border); border-radius:10px; background:var(--ce-bg); color:var(--ce-text-dim); font-size:.8rem; font-weight:600; cursor:pointer; transition:all .18s; }
.bg-tab.active { border-color:var(--ce-primary); background:rgba(33,150,243,.08); color:var(--ce-primary); }

/* Logo Upload */
.logo-upload-zone {
    border: 2px dashed var(--ce-border);
    border-radius: 20px;
    padding: 35px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease;
    background: #fcfcfc;
}

.logo-upload-zone:hover {
    border-color: var(--ce-primary);
    background: rgba(33, 150, 243, 0.02);
}

.logo-upload-zone i {
    font-size: 2.2rem;
    color: var(--ce-primary);
    margin-bottom: 12px;
}

/* Preview Column */
.preview-sticky {
    position: sticky;
    top: 90px;
}

.qr-canvas-wrap {
    width: 100%;
    max-width: 380px;
    margin: 0 auto;
    aspect-ratio: 1;
    background: white;
    border-radius: 20px;
    padding: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--ce-border);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
    position: relative;
    overflow: hidden;
}
/* Le canvas QR s'adapte toujours à la taille du conteneur */
#canvas-container canvas {
    max-width: 100% !important;
    height: auto !important;
    display: block;
}

.preview-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: #fff;
    color: var(--ce-text-dim);
    z-index: 5;
    text-align: center;
}

.preview-overlay.hidden {
    display: none;
}

.btn-ce-action {
    width: 100%;
    background: var(--ce-primary);
    color: white;
    border: none;
    border-radius: 14px;
    padding: 18px;
    font-weight: 700;
    font-size: 1rem;
    margin-top: 24px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    box-shadow: 0 4px 15px rgba(33, 150, 243, 0.2);
}

.btn-ce-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(33, 150, 243, 0.3);
    background: #1e88e5;
}

/* Custom Checkbox/Switch */
.ce-switch {
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
}

.switch-input { display: none; }
.switch-rail {
    width: 44px;
    height: 24px;
    background: #e0e0e0;
    border-radius: 12px;
    position: relative;
    transition: 0.3s;
}
.switch-rail::before {
    content: '';
    position: absolute;
    left: 4px; top: 4px;
    width: 16px; height: 16px;
    background: white;
    border-radius: 50%;
    transition: 0.3s;
}
.switch-input:checked + .switch-rail { background: var(--ce-success); }
.switch-input:checked + .switch-rail::before { transform: translateX(20px); }

/* ===== POSTER SECTION ===== */
.poster-divider { border: none; border-top: 2px dashed var(--ce-border); margin: 36px 0 28px; }

.poster-toggle-row {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 16px;
}
.poster-toggle-label {
    display: flex; align-items: center; gap: 14px; cursor: pointer;
}
.poster-toggle-label .ptl-icon {
    width: 46px; height: 46px;
    background: rgba(33,150,243,.08);
    border: 1px solid rgba(33,150,243,.25);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem; color: var(--ce-primary);
}
.poster-toggle-label .ptl-text strong { font-size: .95rem; color: var(--ce-text); }
.poster-toggle-label .ptl-text span { font-size: .8rem; color: var(--ce-text-dim); display: block; }

.poster-editor { display: none; margin-top: 28px; }
.poster-editor.open {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 28px; align-items: start;
}
@media (max-width: 900px) {
    .poster-editor.open { grid-template-columns: 1fr; }
    .poster-preview-wrap { position: static; width: 100%; align-items: center; justify-content: center; }
    .poster-preview-frame { margin: 0 auto !important; }
}

.bg-preset-grid { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 10px; }
.bg-preset-btn {
    width: 42px; height: 42px; border-radius: 10px;
    border: 2px solid transparent; cursor: pointer; transition: all .2s;
}
.bg-preset-btn.active { border-color: var(--ce-primary); transform: scale(1.12); }
.bg-preset-btn.custom-bg-btn {
    display: flex; align-items: center; justify-content: center;
    background: #f8f9fa; border: 2px dashed var(--ce-border);
    color: var(--ce-text-dim); font-size: 1.1rem; position: relative; overflow: hidden;
}
.bg-preset-btn.custom-bg-btn input[type="color"] {
    position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
}

.poster-preview-wrap { position: sticky; top: 90px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 14px; width: 100%; }
.poster-preview-frame {
    width: 300px; height: 412px;
    border-radius: 14px; overflow: hidden;
    box-shadow: 0 12px 40px rgba(0,0,0,.15);
    border: 1px solid var(--ce-border); position: relative; background: #fff;
    transition: width .3s, height .3s;
    margin: 0 auto;
}
.poster-preview-frame.landscape { width: 330px; height: 227px; }
.poster-preview-frame.square { width: 300px; height: 300px; }
.poster-preview-frame.banner { width: 340px; height: 113px; }

.poster-preview-inner {
    width: 800px; height: 1100px;
    transform-origin: top left; transform: scale(0.375);
    position: absolute; top: 0; left: 0;
    display: flex; flex-direction: column; align-items: center;
    padding: 55px 60px 40px; box-sizing: border-box;
}
/* Carré */
.poster-preview-inner.square { width: 1080px; height: 1080px; transform: scale(0.2778); }
/* Bannière */
.poster-preview-inner.banner {
    width: 1200px; height: 400px;
    transform: scale(0.2833);
    flex-direction: row; align-items: center;
    padding: 30px 40px; gap: 30px;
    display: flex;
}
.poster-preview-inner.banner .poster-landscape-left {
    flex: 1; display: flex; flex-direction: column;
    align-items: flex-start; justify-content: center; gap: 10px;
}
.poster-preview-inner.banner .poster-landscape-right {
    flex-shrink: 0; display: flex; flex-direction: column;
    align-items: center; justify-content: center; gap: 10px;
}
.poster-preview-inner.banner .poster-logo-area { margin-bottom: 0; }
.poster-preview-inner.banner .poster-logo-area img { width: 60px; height: 60px; }
.poster-preview-inner.banner .poster-title-area { text-align: left; margin-bottom: 0; }
.poster-preview-inner.banner .poster-title-area h2 { font-size: 32px; margin-bottom: 4px; line-height: 1.1; }
.poster-preview-inner.banner .poster-title-area p { font-size: 20px; }
.poster-preview-inner.banner .poster-qr-area { margin-bottom: 0; padding: 8px; }
.poster-preview-inner.banner .poster-qr-area canvas,
.poster-preview-inner.banner #pv-qr-placeholder { width: 240px !important; height: 240px !important; }
.poster-preview-inner.banner .poster-cta-area p { font-size: 18px; }
.poster-preview-inner.banner .poster-socials-area { padding: 4px 0 0; gap: 6px; }
.poster-preview-inner.banner .pv-social-dot { width: 34px; height: 34px; font-size: .9rem; }
.poster-preview-inner.banner .pv-social-name { font-size: 16px; max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

/* Paysage : flexbox 2 colonnes */
.poster-preview-inner.landscape {
    width: 1100px; height: 756px;
    transform: scale(0.3);
    flex-direction: row; align-items: center;
    padding: 50px 55px; gap: 40px;
    display: flex;
}
.poster-preview-inner.landscape .poster-landscape-left {
    flex: 1; display: flex; flex-direction: column;
    align-items: flex-start; justify-content: center; gap: 14px;
}
.poster-preview-inner.landscape .poster-landscape-right {
    flex-shrink: 0; display: flex; flex-direction: column;
    align-items: center; justify-content: center; gap: 16px;
}
.poster-preview-inner.landscape .poster-qr-area {
    flex-shrink: 0; width: auto;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 0;
}
.poster-preview-inner.landscape .poster-cta-area {
    text-align: center; width: auto;
}
.poster-logo-area { margin-bottom: 20px; }
.poster-logo-area img { width: 130px; height: 130px; object-fit: contain; border-radius: 10px; display: none; }
.poster-title-area { text-align: center; margin-bottom: 20px; width: 100%; }
.poster-title-area h2 { font-size: 46px; font-weight: 800; line-height: 1.15; margin: 0 0 12px; word-break: break-word; }
.poster-title-area p  { font-size: 30px; font-weight: 600; margin: 0; line-height: 1.4; word-break: break-word; }
.poster-qr-area {
    background: white; padding: 16px; border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0,0,0,.12); margin-bottom: 20px;
    display: flex; align-items: center; justify-content: center;
}
.poster-cta-area { text-align: center; width: 100%; }
.poster-cta-area p { font-size: 32px; font-weight: 700; margin: 0; word-break: break-word; }

.poster-socials-area { display: flex; flex-direction: column; align-items: flex-start; gap: 12px; padding: 16px 0 4px; width: 100%; }
.poster-socials-area.layout-horizontal { flex-direction: row; flex-wrap: wrap; gap: 14px 20px; align-items: flex-start; }
.pv-social-item { display: flex; align-items: center; gap: 10px; }
.layout-horizontal .pv-social-item { flex: 0 0 calc(50% - 10px); min-width: 0; }
.pv-social-dot { width: 52px; height: 52px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; color: #fff; flex-shrink: 0; }
.pv-social-name { font-size: 24px; font-weight: 600; }

/* Social icon selector */
.social-icons-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 8px; }
.social-icon-btn {
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    gap: 4px; padding: 10px 4px 8px;
    border: 2px solid var(--ce-border); border-radius: 12px;
    background: var(--ce-bg); color: var(--ce-text-dim);
    cursor: pointer; font-size: .65rem; font-weight: 600;
    text-align: center; transition: all .18s ease;
}
.social-icon-btn i { font-size: 1.25rem; transition: color .18s; }
.social-icon-btn:hover { border-color: #ccc; color: var(--ce-text); }
/* Bouton actif : fond coloré plein + icône blanche (style app icon) */
.social-icon-btn.active { color:#fff; border-color:transparent; }
.social-icon-btn.active span { color:rgba(255,255,255,.92); }
.social-icon-btn[data-network="facebook"].active  { background:#1877F2; border-color:#1877F2; }
.social-icon-btn[data-network="whatsapp"].active  { background:#25D366; border-color:#25D366; }
.social-icon-btn[data-network="instagram"].active { background:linear-gradient(135deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888); border-color:#E1306C; }
.social-icon-btn[data-network="tiktok"].active    { background:#010101; border-color:#010101; }
.social-icon-btn[data-network="youtube"].active   { background:#FF0000; border-color:#FF0000; }
.social-icon-btn[data-network="twitter"].active   { background:#000000; border-color:#000000; }
.social-icon-btn[data-network="linkedin"].active  { background:#0A66C2; border-color:#0A66C2; }
.social-icon-btn[data-network="telegram"].active  { background:#2CA5E0; border-color:#2CA5E0; }
.social-icon-btn[data-network="snapchat"].active  { background:#FFFC00; border-color:#FFFC00; color:#000; }
.social-icon-btn[data-network="snapchat"].active span { color:#000; }
.social-icon-btn[data-network="pinterest"].active { background:#E60023; border-color:#E60023; }
.social-icon-btn[data-network="website"].active   { background:#2196F3; border-color:#2196F3; }
.social-icon-btn[data-network="telephone"].active { background:#10b981; border-color:#10b981; }
.social-icon-btn[data-network="email"].active     { background:#EA4335; border-color:#EA4335; }
/* ======= RESPONSIVE MOBILE ======= */

/* 768px — tablette / mobile paysage */
@media (max-width: 768px) {
    /* Wrapper : 0 marge latérale sur mobile */
    .qr-premium-wrap { padding: 14px 0; }
    .ce-card { border-radius: 0; box-shadow: none; border-left: none; border-right: none; }

    /* Header : titre et badge sur 2 lignes si besoin */
    .qr-header { flex-wrap: wrap; gap: 10px; margin-bottom: 20px; }
    .qr-header h1 { font-size: 1.25rem; gap: 8px; }
    .badge-certified { font-size: .7rem; padding: 5px 10px; }

    /* QR layout : aperçu en haut, settings en bas */
    .main-layout { grid-template-columns: 1fr; gap: 20px; }
    .preview-sticky { position: static; order: -1; display: flex; flex-direction: column; align-items: stretch; gap: 12px; }

    /* Poster toggle : texte + switch s'empilent proprement */
    .poster-toggle-row { flex-direction: row; align-items: flex-start; gap: 12px; }
    .poster-toggle-label { flex: 1; align-items: flex-start; gap: 10px; }
    .ptl-icon { width: 38px; height: 38px; font-size: 1.1rem; flex-shrink: 0; }
    .poster-toggle-label .ptl-text strong { font-size: .88rem; }
    .poster-toggle-label .ptl-text span { font-size: .75rem; }

    /* Poster editor : 1 colonne */
    .poster-editor.open { grid-template-columns: 1fr; }
    .poster-preview-wrap { position: static; order: 2; width: 100%; align-items: center; }

    /* Card padding réduit */
    .ce-card { padding: 20px 16px; }

    /* Tabs scrollables */
    .settings-tabs { overflow-x: auto; gap: 4px; padding-bottom: 0; -webkit-overflow-scrolling: touch; }
    .tab-btn { padding: 10px 14px; font-size: .8rem; white-space: nowrap; flex-shrink: 0; }

    /* Format tabs — grille 2×2 sur mobile */
    .format-tabs { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
    .format-tab { font-size: .8rem; padding: 9px 8px; flex: none; justify-content: center; }
    .format-tab i { font-size: .95rem; }

    /* Fond tabs */
    .bg-tab { font-size: .75rem; padding: 7px 8px; }

    /* Cadre affiche centré */
    .poster-preview-frame { margin: 0 auto; }
}

/* 480px — smartphone portrait */
@media (max-width: 480px) {
    /* Color grid */
    .color-grid { gap: 14px; padding: 14px; }

    /* Style buttons */
    .style-btn { padding: 8px 6px; font-size: .72rem; }

    /* Social icons : 3 par ligne */
    .social-icons-grid { grid-template-columns: repeat(3, 1fr); gap: 6px; }
    .social-icon-btn { padding: 8px 3px 6px; font-size: .6rem; }
    .social-icon-btn i { font-size: 1.1rem; }

    /* Input */
    .ce-input { padding: 11px 14px; font-size: .88rem; }

    /* Télécharger l'affiche */
    .btn-dl-poster { font-size: .85rem; padding: 13px; }
}

@media (max-width: 500px) { .social-icons-grid { grid-template-columns: repeat(3, 1fr); } }

.btn-dl-poster {
    width: 100%; background: var(--ce-secondary); color: white; border: none;
    border-radius: 14px; padding: 16px; font-weight: 700; font-size: .92rem;
    cursor: pointer; transition: all .3s;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    box-shadow: 0 4px 15px rgba(255,107,53,.25);
}
.btn-dl-poster:hover { transform: translateY(-2px); filter: brightness(1.08); }

</style>

<div class="qr-premium-wrap mt-2">
    <div class="qr-header">
        <h1><i class="bi bi-qr-code-scan" style="color: var(--ce-primary)"></i> <span>Flash</span>QR Generator</h1>
        <div class="badge-certified"><i class="bi bi-shield-check" style="color: var(--ce-success)"></i> ISO 27001 Certified</div>
    </div>

    <div class="main-layout">
        <!-- Configuration Panel -->
        <div class="ce-card">
            <div class="settings-tabs">
                <button class="tab-btn active" data-tab="content">
                    <i class="bi bi-link-45deg"></i> Contenu
                </button>
                <button class="tab-btn" data-tab="style">
                    <i class="bi bi-palette"></i> Style
                </button>
                <button class="tab-btn" data-tab="logo">
                    <i class="bi bi-image"></i> Logo
                </button>
            </div>

            <!-- Tab: Content -->
            <div class="settings-content active" id="tab-content">
                <div class="form-group">
                    <label class="form-label">Lien ou Message</label>
                    <input type="text" id="qr-data" class="ce-input" placeholder="Entrez une URL ou un texte..." autocomplete="off">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Taille d'exportation</label>
                    <div class="style-grid">
                        <button class="style-btn active" data-size="512">512px</button>
                        <button class="style-btn" data-size="1024">1024px</button>
                        <button class="style-btn" data-size="2048">2048px</button>
                    </div>
                </div>

                <div class="form-group">
                    <div class="ce-switch">
                        <input type="checkbox" id="qr-high-precision" class="switch-input" checked>
                        <div class="switch-rail"></div>
                        <span style="font-size:0.9rem; font-weight:500">Optimiser la lisibilité (Correction H)</span>
                    </div>
                </div>
            </div>

            <!-- Tab: Style -->
            <div class="settings-content" id="tab-style">
                <div class="form-group">
                    <label class="form-label">Personnalisation des couleurs</label>
                    <div class="color-grid">
                        <div class="color-picker-item">
                            <div class="color-circle" id="preview-dots" style="background:#000000">
                                <input type="color" id="color-dots" value="#000000">
                            </div>
                            <span class="color-label">Modules</span>
                        </div>
                        <div class="color-picker-item">
                            <div class="color-circle" id="preview-bg" style="background:#ffffff">
                                <input type="color" id="color-bg" value="#ffffff">
                            </div>
                            <span class="color-label">Arrière-plan</span>
                        </div>
                        <div class="color-picker-item" style="border-left: 1px solid #ddd; padding-left: 20px;">
                            <div class="color-circle" id="preview-corners" style="background:#000000">
                                <input type="color" id="color-corners" value="#000000">
                            </div>
                            <span class="color-label">Coins</span>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <span style="font-size: 0.75rem; color: var(--ce-text-dim); font-weight: 600;">PRÉRÉGLAGES PROS</span>
                        <div class="presets-grid">
                            <div class="preset-dot" style="background: #000000" data-color="#000000" title="Pure Black"></div>
                            <div class="preset-dot" style="background: #2196F3" data-color="#2196F3" title="Finance Blue"></div>
                            <div class="preset-dot" style="background: #333333" data-color="#333333" title="Dark Gray"></div>
                            <div class="preset-dot" style="background: #1a237e" data-color="#1a237e" title="Deep Indigo"></div>
                            <div class="preset-dot" style="background: #e53935" data-color="#e53935" title="Security Red"></div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Style des modules</label>
                    <div class="style-grid">
                        <button class="style-btn active" data-dot="square">Carré</button>
                        <button class="style-btn" data-dot="dots">Rond</button>
                        <button class="style-btn" data-dot="rounded">Arrondi</button>
                        <button class="style-btn" data-dot="extra-rounded">Double</button>
                        <button class="style-btn" data-dot="classy">Élégant</button>
                        <button class="style-btn" data-dot="classy-rounded">Moderne</button>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Design des coins</label>
                    <div class="style-grid">
                        <button class="style-btn active" data-corner="square">Angle</button>
                        <button class="style-btn" data-corner="extra-rounded">Courbe</button>
                        <button class="style-btn" data-corner="dot">Cercle</button>
                    </div>
                </div>
            </div>

            <!-- Tab: Logo -->
            <div class="settings-content" id="tab-logo">
                <div class="logo-upload-zone" id="drop-zone">
                    <input type="file" id="logo-input" hidden accept="image/*">
                    <i class="bi bi-file-earmark-image"></i>
                    <h4 style="font-size:1rem; font-weight:600; margin-bottom:8px">Ajouter un logo central</h4>
                    <p style="font-size:0.8rem; color:var(--ce-text-dim)">Faites glisser une image ou cliquez ici<br>(PNG/SVG recommandé)</p>
                </div>
                
                <div id="logo-info" style="display:none; margin-top:20px; background:#f8f9fa; padding:15px; border-radius:15px; border:1px solid var(--ce-border); display:flex; align-items:center; gap:15px">
                    <img id="logo-preview-small" src="" style="width:45px; height:45px; object-fit:contain; border-radius:8px; background:white; padding:4px; border:1px solid var(--ce-border)">
                    <div style="flex:1">
                        <div id="logo-filename" style="font-size:0.9rem; font-weight:600; color:var(--ce-text)">logo.png</div>
                        <button id="remove-logo" style="background:none; border:none; color:#dc3545; font-size:0.75rem; font-weight:600; padding:0; cursor:pointer">Retirer le logo</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Preview Panel -->
        <div class="preview-sticky">
            <div class="qr-canvas-wrap" id="canvas-container">
                <div class="preview-overlay" id="preview-overlay">
                    <i class="bi bi-qr-code" style="font-size:4rem; color:#eee; margin-bottom:20px"></i>
                    <p style="font-weight:600; color:var(--ce-text); margin-bottom:5px">Prêt à générer</p>
                    <p style="font-size:0.85rem; color:var(--ce-text-dim)">L'aperçu apparaîtra ici dès que<br>vous commencerez à écrire.</p>
                </div>
            </div>

            <button class="btn-ce-action" id="btn-download">
                <i class="bi bi-download"></i> TÉLÉCHARGER (PNG)
            </button>
        </div>
    </div>

    {{-- ===== SECTION AFFICHE ===== --}}
    <hr class="poster-divider">

    <div class="poster-toggle-row">
        <label class="poster-toggle-label" for="toggle-poster">
            <div class="ptl-icon"><i class="bi bi-card-image"></i></div>
            <div class="ptl-text">
                <strong>Créer une affiche avec ce QR Code</strong>
                <span>Optionnel — ajoutez titre, logo et couleurs pour une affiche prête à imprimer ou partager</span>
            </div>
        </label>
        <label class="ce-switch">
            <input type="checkbox" id="toggle-poster" class="switch-input">
            <div class="switch-rail"></div>
        </label>
    </div>

    <div class="poster-editor" id="poster-editor">
        {{-- Gauche : paramètres --}}
        <div class="ce-card">
            <div class="form-group">
                <label class="form-label"><i class="bi bi-aspect-ratio me-1"></i> Format</label>
                <div class="format-tabs" id="format-tabs">
                    <button class="format-tab active" data-format="portrait" type="button"><i class="bi bi-phone"></i> Portrait</button>
                    <button class="format-tab" data-format="landscape" type="button"><i class="bi bi-tablet-landscape"></i> Paysage</button>
                    <button class="format-tab" data-format="square" type="button"><i class="bi bi-square"></i> Carré</button>
                    <button class="format-tab" data-format="banner" type="button"><i class="bi bi-layout-text-window"></i> Bannière</button>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label"><i class="bi bi-type-bold me-1"></i> Titre de l'affiche</label>
                <input type="text" id="poster-title" class="ce-input" placeholder="Ex : Rejoignez-nous !" maxlength="60">
            </div>
            <div class="form-group">
                <label class="form-label"><i class="bi bi-text-left me-1"></i> Sous-titre</label>
                <input type="text" id="poster-subtitle" class="ce-input" placeholder="Ex : Disponible en ligne 24h/24" maxlength="100">
            </div>
            <div class="form-group">
                <label class="form-label"><i class="bi bi-cursor-text me-1"></i> Texte sous le QR Code</label>
                <input type="text" id="poster-cta" class="ce-input" placeholder="Scannez pour accéder" maxlength="80" value="Scannez pour accéder">
            </div>
            <div class="form-group">
                <label class="form-label"><i class="bi bi-palette me-1"></i> Fond de l'affiche</label>
                {{-- Onglets Couleur / Image --}}
                <div class="bg-tabs" id="bg-tabs">
                    <button class="bg-tab active" data-tab="color" type="button"><i class="bi bi-paint-bucket me-1"></i>Couleur</button>
                    <button class="bg-tab" data-tab="image" type="button"><i class="bi bi-image me-1"></i>Image</button>
                </div>
                {{-- Panneau Couleur --}}
                <div id="bg-panel-color">
                    <div class="bg-preset-grid">
                        <button class="bg-preset-btn active" data-color="#ffffff" style="background:#ffffff;border:2px solid #e8e8e8" title="Blanc"></button>
                        <button class="bg-preset-btn" data-color="#0a0d2e" style="background:#0a0d2e" title="Marine"></button>
                        <button class="bg-preset-btn" data-color="#2196F3" style="background:#2196F3" title="Bleu"></button>
                        <button class="bg-preset-btn" data-color="#10b981" style="background:#10b981" title="Vert"></button>
                        <button class="bg-preset-btn" data-color="#FF6B35" style="background:#FF6B35" title="Orange"></button>
                        <button class="bg-preset-btn" data-color="#7c3aed" style="background:#7c3aed" title="Violet"></button>
                        <button class="bg-preset-btn" data-color="#dc2626" style="background:#dc2626" title="Rouge"></button>
                        <button class="bg-preset-btn" data-color="#1e293b" style="background:#1e293b" title="Ardoise"></button>
                        <button class="bg-preset-btn custom-bg-btn" title="Couleur personnalisée">
                            <i class="bi bi-plus-lg"></i>
                            <input type="color" id="poster-custom-color" value="#ffffff">
                        </button>
                    </div>
                </div>
                {{-- Panneau Image --}}
                <div id="bg-panel-image" style="display:none">
                    <div class="logo-upload-zone" id="bg-image-zone" style="padding:20px">
                        <input type="file" id="bg-image-input" hidden accept="image/*">
                        <i class="bi bi-image" style="font-size:1.6rem"></i>
                        <p style="font-size:.82rem;margin:6px 0 0;color:var(--ce-text-dim)">Cliquez pour ajouter une image de fond</p>
                    </div>
                    <div id="bg-image-info" style="display:none;margin-top:10px;background:#f8f9fa;padding:10px 14px;border-radius:10px;align-items:center;gap:10px;border:1px solid var(--ce-border)">
                        <img id="bg-image-thumb" src="" style="width:50px;height:34px;object-fit:cover;border-radius:6px">
                        <span id="bg-image-name" style="flex:1;font-size:.82rem;color:var(--ce-text)">image.jpg</span>
                        <button id="bg-image-remove" style="background:none;border:none;color:#dc2626;font-size:.78rem;cursor:pointer;padding:0">Supprimer</button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label"><i class="bi bi-image me-1"></i> Logo <span style="font-weight:400;color:var(--ce-text-dim)">(facultatif)</span></label>
                <div class="logo-upload-zone" id="poster-logo-zone" style="padding:20px">
                    <input type="file" id="poster-logo-input" hidden accept="image/*">
                    <i class="bi bi-cloud-arrow-up" style="font-size:1.6rem"></i>
                    <p style="font-size:.82rem;margin:6px 0 0;color:var(--ce-text-dim)">Cliquez pour ajouter un logo</p>
                </div>
                <div id="poster-logo-info" style="display:none;margin-top:10px;background:#f8f9fa;padding:10px 14px;border-radius:10px;align-items:center;gap:10px;border:1px solid var(--ce-border)">
                    <img id="poster-logo-thumb" src="" style="width:34px;height:34px;object-fit:contain;border-radius:6px">
                    <span id="poster-logo-name" style="flex:1;font-size:.82rem;color:var(--ce-text)">logo.png</span>
                    <button id="poster-logo-remove" style="background:none;border:none;color:#dc2626;font-size:.78rem;cursor:pointer;padding:0">Supprimer</button>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label"><i class="bi bi-share me-1"></i> Réseaux sociaux <span style="font-weight:400;color:var(--ce-text-dim)">(facultatif)</span></label>
                <p style="font-size:.78rem;color:var(--ce-text-dim);margin-bottom:10px">Sélectionnez les réseaux pour les afficher sur l'affiche</p>
                <div class="social-icons-grid" id="social-icons-grid">
                    <button class="social-icon-btn" data-network="facebook" data-color="#1877F2" type="button" title="Facebook">
                        <i class="bi bi-facebook"></i><span>Facebook</span>
                    </button>
                    <button class="social-icon-btn" data-network="whatsapp" data-color="#25D366" type="button" title="WhatsApp">
                        <i class="bi bi-whatsapp"></i><span>WhatsApp</span>
                    </button>
                    <button class="social-icon-btn" data-network="instagram" data-color="#E1306C" type="button" title="Instagram">
                        <i class="bi bi-instagram"></i><span>Instagram</span>
                    </button>
                    <button class="social-icon-btn" data-network="tiktok" data-color="#010101" type="button" title="TikTok">
                        <i class="bi bi-tiktok"></i><span>TikTok</span>
                    </button>
                    <button class="social-icon-btn" data-network="youtube" data-color="#FF0000" type="button" title="YouTube">
                        <i class="bi bi-youtube"></i><span>YouTube</span>
                    </button>
                    <button class="social-icon-btn" data-network="twitter" data-color="#000000" type="button" title="X / Twitter">
                        <i class="bi bi-twitter-x"></i><span>X / Twitter</span>
                    </button>
                    <button class="social-icon-btn" data-network="linkedin" data-color="#0A66C2" type="button" title="LinkedIn">
                        <i class="bi bi-linkedin"></i><span>LinkedIn</span>
                    </button>
                    <button class="social-icon-btn" data-network="telegram" data-color="#2CA5E0" type="button" title="Telegram">
                        <i class="bi bi-telegram"></i><span>Telegram</span>
                    </button>
                    <button class="social-icon-btn" data-network="snapchat" data-color="#FFFC00" type="button" title="Snapchat">
                        <i class="bi bi-snapchat"></i><span>Snapchat</span>
                    </button>
                    <button class="social-icon-btn" data-network="pinterest" data-color="#E60023" type="button" title="Pinterest">
                        <i class="bi bi-pinterest"></i><span>Pinterest</span>
                    </button>
                    <button class="social-icon-btn" data-network="website" data-color="#2196F3" type="button" title="Site Web">
                        <i class="bi bi-globe2"></i><span>Site Web</span>
                    </button>
                    <button class="social-icon-btn" data-network="telephone" data-color="#10b981" type="button" title="Téléphone">
                        <i class="bi bi-telephone"></i><span>Téléphone</span>
                    </button>
                    <button class="social-icon-btn" data-network="email" data-color="#EA4335" type="button" title="Courriel">
                        <i class="bi bi-envelope"></i><span>Courriel</span>
                    </button>
                </div>
                <div id="social-labels-wrap" style="margin-top:10px;display:flex;flex-direction:column;gap:8px"></div>
                <div id="socials-layout-row" style="margin-top:12px;display:none">
                    <label class="form-label" style="margin-bottom:6px;font-size:.78rem"><i class="bi bi-layout-wtf me-1"></i> Disposition des réseaux</label>
                    <div class="format-tabs" id="socials-layout-tabs">
                        <button class="format-tab active" data-layout="vertical" type="button"><i class="bi bi-list-ul"></i> Vertical</button>
                        <button class="format-tab" data-layout="horizontal" type="button"><i class="bi bi-columns-gap"></i> 2 par ligne</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Droite : aperçu --}}
        <div class="poster-preview-wrap">
            <div style="font-size:.78rem;color:var(--ce-text-dim);text-transform:uppercase;letter-spacing:.05em;font-weight:600">Aperçu affiche</div>
            <div class="poster-preview-frame">
                <div class="poster-preview-inner" id="poster-preview-inner">
                    <div class="poster-logo-area"><img id="pv-logo" src="" alt=""></div>
                    <div class="poster-title-area">
                        <h2 id="pv-title" style="color:#111">Titre de l'affiche</h2>
                        <p id="pv-subtitle" style="color:#555"></p>
                    </div>
                    <div class="poster-qr-area" id="pv-qr-area">
                        <div id="pv-qr-placeholder" style="width:380px;height:380px;display:flex;align-items:center;justify-content:center;color:#ccc;font-size:.85rem;text-align:center;flex-direction:column;gap:10px">
                            <i class="bi bi-qr-code" style="font-size:3rem"></i> QR Code ici
                        </div>
                    </div>
                    <div class="poster-cta-area">
                        <p id="pv-cta" style="color:#111">Scannez pour accéder</p>
                    </div>
                    <div class="poster-socials-area" id="pv-socials"></div>
                </div>
            </div>
            <button class="btn-dl-poster" id="btn-dl-poster">
                <i class="bi bi-card-image"></i> Télécharger l'affiche
            </button>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/qr-code-styling@1.6.0-rc.1/lib/qr-code-styling.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let qrInstance = null;
    let logoData = null;
    let currentOptions = {
        data: "",
        size: 512,
        dotStyle: 'square',
        cornerStyle: 'square',
        colorDots: '#000000',
        colorBg: '#ffffff',
        colorCorners: '#000000',
        highPrecision: true
    };

    // Tab switching
    const tabs = document.querySelectorAll('.tab-btn');
    const contents = document.querySelectorAll('.settings-content');
    
    tabs.forEach(btn => {
        btn.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            contents.forEach(c => c.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById(`tab-${btn.dataset.tab}`).classList.add('active');
        });
    });

    // Style buttons selection
    function setupStyleGroup(selector, key) {
        document.querySelectorAll(selector).forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll(selector).forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                
                const val = btn.dataset[key] || btn.dataset.size || btn.dataset.dot || btn.dataset.corner;
                if(key === 'dotStyle') currentOptions.dotStyle = btn.dataset.dot;
                else if(key === 'cornerStyle') currentOptions.cornerStyle = btn.dataset.corner;
                else if(key === 'size') currentOptions.size = parseInt(btn.dataset.size);
                else currentOptions[key] = val;

                debouncedRender();
            });
        });
    }

    setupStyleGroup('[data-size]', 'size');
    setupStyleGroup('[data-dot]', 'dotStyle');
    setupStyleGroup('[data-corner]', 'cornerStyle');

    // Color inputs
    const colorInputs = ['dots', 'bg', 'corners'];
    colorInputs.forEach(type => {
        const input = document.getElementById(`color-${type}`);
        const preview = document.getElementById(`preview-${type}`);
        input.addEventListener('input', (e) => {
            const val = e.target.value;
            preview.style.background = val;
            currentOptions[`color${type.charAt(0).toUpperCase() + type.slice(1)}`] = val;
            debouncedRender();
        });
    });

    // Presets selection
    document.querySelectorAll('.preset-dot').forEach(dot => {
        dot.addEventListener('click', () => {
            const color = dot.dataset.color;
            // Apply to Dots and Corners by default
            const inputs = ['dots', 'corners'];
            inputs.forEach(type => {
                document.getElementById(`color-${type}`).value = color;
                document.getElementById(`preview-${type}`).style.background = color;
                currentOptions[`color${type.charAt(0).toUpperCase() + type.slice(1)}`] = color;
            });
            debouncedRender();
        });
    });

    // Main data input
    const dataInput = document.getElementById('qr-data');
    dataInput.addEventListener('input', (e) => {
        currentOptions.data = e.target.value.trim();
        if(currentOptions.data) {
            document.getElementById('preview-overlay').classList.add('hidden');
        } else {
            document.getElementById('preview-overlay').classList.remove('hidden');
        }
        debouncedRender();
    });

    // High precision switch
    document.getElementById('qr-high-precision').addEventListener('change', (e) => {
        currentOptions.highPrecision = e.target.checked;
        debouncedRender();
    });

    // Logo Handling
    const dropZone = document.getElementById('drop-zone');
    const logoInput = document.getElementById('logo-input');

    dropZone.addEventListener('click', () => logoInput.click());
    
    logoInput.addEventListener('change', handleLogoFile);
    
    function handleLogoFile(e) {
        const file = e.target.files[0];
        if(!file) return;
        
        if(file.size > 2 * 1024 * 1024) {
            alert("Fichier trop volumineux (max 2Mo)");
            return;
        }

        const reader = new FileReader();
        reader.onload = (event) => {
            logoData = event.target.result;
            document.getElementById('logo-preview-small').src = logoData;
            document.getElementById('logo-filename').textContent = file.name;
            document.getElementById('logo-info').style.display = 'flex';
            debouncedRender();
        };
        reader.readAsDataURL(file);
    }

    document.getElementById('remove-logo').addEventListener('click', (e) => {
        e.stopPropagation();
        logoData = null;
        logoInput.value = '';
        document.getElementById('logo-info').style.display = 'none';
        debouncedRender();
    });

    // DEBOUNCE RENDER
    let renderTimeout;
    function debouncedRender() {
        clearTimeout(renderTimeout);
        renderTimeout = setTimeout(() => {
            renderQR();
            const togglePoster = document.getElementById('toggle-poster');
            if (togglePoster && togglePoster.checked) setTimeout(updatePosterPreview, 350);
        }, 200);
    }

    function renderQR() {
        if(!currentOptions.data) return;

        const container = document.getElementById('canvas-container');
        container.querySelectorAll('canvas').forEach(c => c.remove());

        const qrOptions = {
            width: 400,
            height: 400,
            type: 'canvas',
            margin: 10,
            data: currentOptions.data,
            dotsOptions: {
                color: currentOptions.colorDots,
                type: currentOptions.dotStyle
            },
            backgroundOptions: {
                color: currentOptions.colorBg,
            },
            cornersSquareOptions: {
                color: currentOptions.colorCorners,
                type: currentOptions.cornerStyle
            },
            cornersDotOptions: {
                color: currentOptions.colorCorners,
                type: currentOptions.cornerStyle === 'square' ? 'square' : 'dot'
            },
            qrOptions: {
                errorCorrectionLevel: currentOptions.highPrecision || logoData ? 'H' : 'M'
            },
            imageOptions: {
                crossOrigin: "anonymous",
                margin: 5
            }
        };

        if(logoData) {
            qrOptions.image = logoData;
            qrOptions.imageOptions.imageSize = 0.4;
        }

        qrInstance = new QRCodeStyling(qrOptions);
        qrInstance.append(container);
    }

    // DOWNLOAD
    document.getElementById('btn-download').addEventListener('click', () => {
        if(!qrInstance || !currentOptions.data) {
            alert("Veuillez d'abord saisir un contenu.");
            return;
        }
        
        const exportOptions = {...qrInstance._options};
        exportOptions.width = currentOptions.size;
        exportOptions.height = currentOptions.size;
        
        const exportInstance = new QRCodeStyling(exportOptions);
        exportInstance.download({ name: "qr-code-" + Date.now(), extension: "png" });
    });

    // Initial check
    if(dataInput.value.trim()) {
        currentOptions.data = dataInput.value.trim();
        document.getElementById('preview-overlay').classList.add('hidden');
        renderQR();
    }

    // ===== SECTION AFFICHE =====
    let posterBgColor = '#ffffff';
    let posterBgImage = null;
    let posterLogoData = null;
    let posterFormat = 'portrait'; // 'portrait' | 'landscape'

    // Format tabs
    document.querySelectorAll('.format-tab').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.format-tab').forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            posterFormat = tab.dataset.format;
            applyPosterFormat();
        });
    });

    function applyPosterFormat() {
        const frame = document.querySelector('.poster-preview-frame');
        const inner = document.getElementById('poster-preview-inner');
        const qrArea = document.getElementById('pv-qr-area');

        frame.classList.remove('landscape', 'square', 'banner');
        inner.classList.remove('landscape', 'square', 'banner');

        const needsTwoCol = posterFormat === 'landscape' || posterFormat === 'banner';

        if (needsTwoCol) {
            frame.classList.add(posterFormat);
            inner.classList.add(posterFormat);
            if (!inner.querySelector('.poster-landscape-right')) {
                const ctaArea = inner.querySelector('.poster-cta-area');
                const leftCol = document.createElement('div');
                leftCol.className = 'poster-landscape-left';
                [...inner.children].forEach(child => {
                    if (child !== qrArea && child !== ctaArea) leftCol.appendChild(child);
                });
                const rightCol = document.createElement('div');
                rightCol.className = 'poster-landscape-right';
                rightCol.appendChild(qrArea);
                rightCol.appendChild(ctaArea);
                inner.appendChild(leftCol);
                inner.appendChild(rightCol);
            }
        } else {
            // Restaurer portrait / carré
            const rightCol = inner.querySelector('.poster-landscape-right');
            const leftCol  = inner.querySelector('.poster-landscape-left');
            const logo    = inner.querySelector('.poster-logo-area');
            const title   = inner.querySelector('.poster-title-area');
            const cta     = inner.querySelector('.poster-cta-area');
            const socials = inner.querySelector('.poster-socials-area');
            if (rightCol || leftCol) {
                while (inner.firstChild) inner.removeChild(inner.firstChild);
                if (logo)    inner.appendChild(logo);
                if (title)   inner.appendChild(title);
                             inner.appendChild(qrArea);
                if (cta)     inner.appendChild(cta);
                if (socials) inner.appendChild(socials);
            }
            if (posterFormat === 'square') {
                frame.classList.add('square');
                inner.classList.add('square');
            }
        }
        updatePosterPreview();
    }

    // Onglets Couleur / Image
    document.querySelectorAll('.bg-tab').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.bg-tab').forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            const isImage = tab.dataset.tab === 'image';
            document.getElementById('bg-panel-color').style.display = isImage ? 'none' : 'block';
            document.getElementById('bg-panel-image').style.display = isImage ? 'block' : 'none';
            if (!isImage) { posterBgImage = null; updatePosterPreview(); }
        });
    });

    // Upload image de fond
    document.getElementById('bg-image-zone').addEventListener('click', () => document.getElementById('bg-image-input').click());
    document.getElementById('bg-image-input').addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;
        if (file.size > 5 * 1024 * 1024) { alert('Image trop volumineuse (max 5 Mo)'); return; }
        const reader = new FileReader();
        reader.onload = ev => {
            posterBgImage = ev.target.result;
            document.getElementById('bg-image-thumb').src = posterBgImage;
            document.getElementById('bg-image-name').textContent = file.name;
            document.getElementById('bg-image-info').style.display = 'flex';
            updatePosterPreview();
        };
        reader.readAsDataURL(file);
    });
    document.getElementById('bg-image-remove').addEventListener('click', () => {
        posterBgImage = null;
        document.getElementById('bg-image-input').value = '';
        document.getElementById('bg-image-info').style.display = 'none';
        updatePosterPreview();
    });
    let selectedSocials = []; // {network, color}
    let socialsLayout = 'vertical'; // 'vertical' | 'horizontal'

    // Sélecteur disposition réseaux
    document.querySelectorAll('#socials-layout-tabs .format-tab').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('#socials-layout-tabs .format-tab').forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            socialsLayout = tab.dataset.layout;
            updatePosterPreview();
        });
    });

    // Social icon toggle
    const networkNames = {
        facebook:'Facebook', whatsapp:'WhatsApp', instagram:'Instagram', tiktok:'TikTok',
        youtube:'YouTube', twitter:'X / Twitter', linkedin:'LinkedIn', telegram:'Telegram',
        snapchat:'Snapchat', pinterest:'Pinterest', website:'Site Web',
        telephone:'Téléphone', email:'Courriel'
    };
    const networkIcons = {
        facebook:'bi-facebook', whatsapp:'bi-whatsapp', instagram:'bi-instagram', tiktok:'bi-tiktok',
        youtube:'bi-youtube', twitter:'bi-twitter-x', linkedin:'bi-linkedin', telegram:'bi-telegram',
        snapchat:'bi-snapchat', pinterest:'bi-pinterest', website:'bi-globe2',
        telephone:'bi-telephone', email:'bi-envelope'
    };

    // Extraire les vrais caractères Unicode depuis le CSS chargé (pour Canvas)
    const networkIconChars = {};
    (function() {
        Object.entries(networkIcons).forEach(([net, iconClass]) => {
            const el = document.createElement('i');
            el.className = 'bi ' + iconClass;
            el.style.cssText = 'position:fixed;left:-9999px;visibility:hidden;font-size:16px';
            document.body.appendChild(el);
            const content = window.getComputedStyle(el, '::before').content;
            document.body.removeChild(el);
            if (content && content !== 'none') {
                networkIconChars[net] = content.replace(/^["']|["']$/g, '');
            }
        });
    })();

    const networkPlaceholders = {
        facebook:  'Ex : Page Officielle, @moncompte…',
        whatsapp:  'Ex : +33 6 12 34 56 78',
        instagram: 'Ex : @mon_instagram',
        tiktok:    'Ex : @montiktok',
        youtube:   'Ex : Ma Chaîne YouTube',
        twitter:   'Ex : @moncompte_x',
        linkedin:  'Ex : Mon Profil LinkedIn',
        telegram:  'Ex : @montelegram',
        snapchat:  'Ex : @monsnapchat',
        pinterest: 'Ex : @monpinterest',
        website:   'Ex : www.monsite.com',
        telephone: 'Ex : +33 6 12 34 56 78',
        email:     'Ex : contact@monsite.com',
    };

    function addSocialLabelInput(net, color) {
        const wrap = document.getElementById('social-labels-wrap');
        const row = document.createElement('div');
        row.id = `social-label-row-${net}`;
        row.style.cssText = 'display:flex;align-items:center;gap:8px';
        const iconColor = net === 'snapchat' ? '#000' : '#fff';
        const bgColor = net === 'snapchat' ? '#FFFC00' : color;
        const placeholder = networkPlaceholders[net] || 'Saisissez le nom à afficher';
        row.innerHTML = `
            <div style="width:30px;height:30px;border-radius:50%;background:${bgColor};display:flex;align-items:center;justify-content:center;flex-shrink:0;color:${iconColor};font-size:.9rem">
                <i class="bi ${networkIcons[net]}"></i>
            </div>
            <input type="text" id="social-label-${net}" class="ce-input" placeholder="${placeholder}" maxlength="50" style="flex:1;padding:8px 12px">`;
        wrap.appendChild(row);
        document.getElementById(`social-label-${net}`).addEventListener('input', function() {
            const idx = selectedSocials.findIndex(s => s.network === net);
            if (idx !== -1) selectedSocials[idx].label = this.value.trim();
            updatePosterPreview();
        });
    }

    document.querySelectorAll('.social-icon-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const net = btn.dataset.network;
            const color = btn.dataset.color;
            if (btn.classList.contains('active')) {
                btn.classList.remove('active');
                selectedSocials = selectedSocials.filter(s => s.network !== net);
                const row = document.getElementById(`social-label-row-${net}`);
                if (row) row.remove();
            } else {
                btn.classList.add('active');
                selectedSocials.push({ network: net, color: color, label: '' });
                addSocialLabelInput(net, color);
            }
            document.getElementById('socials-layout-row').style.display = selectedSocials.length > 0 ? 'block' : 'none';
            updatePosterPreview();
        });
    });

    document.getElementById('toggle-poster').addEventListener('change', function() {
        document.getElementById('poster-editor').classList.toggle('open', this.checked);
        if (this.checked) updatePosterPreview();
    });

    document.querySelectorAll('.bg-preset-btn[data-color]').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.bg-preset-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            posterBgColor = btn.dataset.color;
            updatePosterPreview();
        });
    });

    document.getElementById('poster-custom-color').addEventListener('input', function() {
        document.querySelectorAll('.bg-preset-btn').forEach(b => b.classList.remove('active'));
        this.closest('.bg-preset-btn').classList.add('active');
        posterBgColor = this.value;
        updatePosterPreview();
    });

    ['poster-title','poster-subtitle','poster-cta'].forEach(id => {
        document.getElementById(id).addEventListener('input', updatePosterPreview);
    });

    const posterLogoZone = document.getElementById('poster-logo-zone');
    const posterLogoInput = document.getElementById('poster-logo-input');
    posterLogoZone.addEventListener('click', () => posterLogoInput.click());
    posterLogoInput.addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = ev => {
            posterLogoData = ev.target.result;
            document.getElementById('poster-logo-thumb').src = posterLogoData;
            document.getElementById('poster-logo-name').textContent = file.name;
            document.getElementById('poster-logo-info').style.display = 'flex';
            document.getElementById('pv-logo').src = posterLogoData;
            document.getElementById('pv-logo').style.display = 'block';
            updatePosterPreview();
        };
        reader.readAsDataURL(file);
    });
    document.getElementById('poster-logo-remove').addEventListener('click', () => {
        posterLogoData = null;
        posterLogoInput.value = '';
        document.getElementById('poster-logo-info').style.display = 'none';
        document.getElementById('pv-logo').style.display = 'none';
        updatePosterPreview();
    });

    function isDark(hex) {
        const r = parseInt(hex.slice(1,3),16), g = parseInt(hex.slice(3,5),16), b = parseInt(hex.slice(5,7),16);
        return (r*299 + g*587 + b*114) / 1000 < 128;
    }

    function updatePosterPreview() {
        const inner = document.getElementById('poster-preview-inner');
        if (posterBgImage) {
            inner.style.background = `url(${posterBgImage}) center/cover no-repeat`;
        } else {
            inner.style.background = posterBgColor;
        }
        const _darkPreview = posterBgImage ? true : isDark(posterBgColor);
        const tc = _darkPreview ? '#ffffff' : '#111111';
        const sc = _darkPreview ? 'rgba(255,255,255,0.75)' : 'rgba(0,0,0,0.6)';
        document.getElementById('pv-title').style.color = tc;
        document.getElementById('pv-title').textContent = document.getElementById('poster-title').value || 'Titre de l\'affiche';
        document.getElementById('pv-subtitle').style.color = sc;
        document.getElementById('pv-subtitle').textContent = document.getElementById('poster-subtitle').value;
        document.getElementById('pv-cta').style.color = tc;
        document.getElementById('pv-cta').textContent = document.getElementById('poster-cta').value || 'Scannez pour accéder';

        const srcCanvas = document.querySelector('#canvas-container canvas');
        const pvQr = document.getElementById('pv-qr-area');
        pvQr.querySelectorAll('canvas').forEach(c => c.remove());
        if (srcCanvas) {
            document.getElementById('pv-qr-placeholder').style.display = 'none';
            const clone = document.createElement('canvas');
            clone.width = srcCanvas.width; clone.height = srcCanvas.height;
            clone.style.cssText = 'width:380px;height:380px;display:block';
            clone.getContext('2d').drawImage(srcCanvas, 0, 0);
            pvQr.appendChild(clone);
        } else {
            document.getElementById('pv-qr-placeholder').style.display = 'flex';
        }

        // Social items in preview
        const pvSocials = document.getElementById('pv-socials');
        pvSocials.innerHTML = '';
        pvSocials.classList.toggle('layout-horizontal', socialsLayout === 'horizontal');
        const activeSocials = selectedSocials.filter(s => s.label);
        if (activeSocials.length > 0) {
            const nameTc = _darkPreview ? '#ffffff' : '#111111';
            if (socialsLayout === 'vertical') {
                // Aligner le bloc sous le "S" de "Scannez pour accéder"
                const pvCtaText = document.getElementById('poster-cta').value.trim() || 'Scannez pour accéder';
                const tmpC = document.createElement('canvas');
                const tmpCtx = tmpC.getContext('2d');
                tmpCtx.font = 'bold 32px Arial';
                const pvCtaWidth = tmpCtx.measureText(pvCtaText).width;
                const contentW = 680;
                const groupMarginLeft = Math.max(0, (contentW - pvCtaWidth) / 2);
                const group = document.createElement('div');
                group.style.cssText = `display:inline-flex;flex-direction:column;gap:12px;align-items:flex-start;margin-left:${groupMarginLeft}px`;
                activeSocials.forEach(s => {
                    const item = document.createElement('div');
                    item.className = 'pv-social-item';
                    const dotBg = s.network === 'snapchat' ? '#FFFC00' : s.color;
                    const iconColor = s.network === 'snapchat' ? '#000' : '#fff';
                    item.innerHTML = `<div class="pv-social-dot" style="background:${dotBg};color:${iconColor}"><i class="bi ${networkIcons[s.network] || 'bi-share'}"></i></div><span class="pv-social-name" style="color:${nameTc}">${s.label}</span>`;
                    group.appendChild(item);
                });
                pvSocials.appendChild(group);
            } else {
                // 2 par ligne : chaque item prend ~50% de la largeur
                activeSocials.forEach(s => {
                    const item = document.createElement('div');
                    item.className = 'pv-social-item';
                    const dotBg = s.network === 'snapchat' ? '#FFFC00' : s.color;
                    const iconColor = s.network === 'snapchat' ? '#000' : '#fff';
                    item.innerHTML = `<div class="pv-social-dot" style="background:${dotBg};color:${iconColor}"><i class="bi ${networkIcons[s.network] || 'bi-share'}"></i></div><span class="pv-social-name" style="color:${nameTc}">${s.label}</span>`;
                    pvSocials.appendChild(item);
                });
            }
        }
    }


    // Télécharger l'affiche
    document.getElementById('btn-dl-poster').addEventListener('click', async () => {
        const srcCanvas = document.querySelector('#canvas-container canvas');
        if (!srcCanvas) { alert('Générez d\'abord le QR Code.'); return; }

        // Charger la police Bootstrap Icons pour le canvas
        try { await document.fonts.load('24px bootstrap-icons'); } catch(e) {}

        const isLandscape = posterFormat === 'landscape';
        const isSquare    = posterFormat === 'square';
        const isBanner    = posterFormat === 'banner';
        const W = isLandscape ? 1100 : isSquare ? 1080 : isBanner ? 1200 : 800;
        const H = isLandscape ? 756  : isSquare ? 1080 : isBanner ? 400  : 1100;
        const cv = document.createElement('canvas');
        cv.width = W; cv.height = H;
        const ctx = cv.getContext('2d');

        // Fond
        if (posterBgImage) {
            await new Promise(res => { const bgImg = new Image(); bgImg.onload = () => { ctx.drawImage(bgImg, 0, 0, W, H); res(); }; bgImg.src = posterBgImage; });
        } else {
            ctx.fillStyle = posterBgColor; ctx.fillRect(0, 0, W, H);
        }
        const dark = posterBgImage ? true : isDark(posterBgColor);
        const tc = dark ? '#ffffff' : '#111111';
        const sc = dark ? 'rgba(255,255,255,0.75)' : 'rgba(0,0,0,0.6)';

        const canvasSocials = selectedSocials.filter(s => s.label);

        if (isBanner) {
            // === BANNIÈRE : 1200×400px ===
            const pad = 44, leftMaxX = 750, rightX = 810;
            const leftContentW = leftMaxX - pad; // 706px max pour texte gauche
            const colW = leftContentW / 2;       // ~353px par colonne en mode 2/ligne
            // Centrage vertical du contenu gauche
            let y = 60;
            if (posterLogoData) {
                await new Promise(res => { const img = new Image(); img.onload = () => { ctx.drawImage(img, pad, y, 60, 60); res(); }; img.src = posterLogoData; });
                y += 74;
            }
            const title = document.getElementById('poster-title').value.trim() || 'Titre de l\'affiche';
            ctx.font = 'bold 38px Arial'; ctx.fillStyle = tc; ctx.textAlign = 'left';
            y = wrapText(ctx, title, pad, y + 38, leftContentW, 46) + 8;
            const sub = document.getElementById('poster-subtitle').value.trim();
            if (sub) { ctx.font = '600 22px Arial'; ctx.fillStyle = sc; y = wrapText(ctx, sub, pad, y + 22, leftContentW, 28) + 8; }
            if (canvasSocials.length > 0) {
                const cr = 20, lineH = cr*2 + 10;
                const maxLabelW = colW - cr*2 - 16;
                if (socialsLayout === 'horizontal') {
                    // 2 par ligne
                    for (let i = 0; i < canvasSocials.length; i++) {
                        const s = canvasSocials[i];
                        const col = i % 2;
                        const sx = pad + cr + col * colW;
                        if (col === 0 && i > 0) y += lineH;
                        ctx.beginPath(); ctx.arc(sx, y+cr, cr, 0, Math.PI*2);
                        ctx.fillStyle = s.network==='snapchat'?'#FFFC00':s.color; ctx.fill();
                        ctx.fillStyle = s.network==='snapchat'?'#000':'#fff';
                        ctx.textAlign='center'; ctx.textBaseline='middle';
                        ctx.font = `${Math.round(cr*1.1)}px bootstrap-icons`;
                        ctx.fillText(networkIconChars[s.network]||'', sx, y+cr);
                        ctx.textBaseline='alphabetic'; ctx.textAlign='left';
                        ctx.font='bold 18px Arial'; ctx.fillStyle=tc;
                        ctx.fillText(s.label, sx+cr+10, y+cr+6, maxLabelW);
                    }
                } else {
                    for (const s of canvasSocials) {
                        ctx.beginPath(); ctx.arc(pad+cr, y+cr, cr, 0, Math.PI*2);
                        ctx.fillStyle = s.network==='snapchat'?'#FFFC00':s.color; ctx.fill();
                        ctx.fillStyle = s.network==='snapchat'?'#000':'#fff';
                        ctx.textAlign='center'; ctx.textBaseline='middle';
                        ctx.font = `${Math.round(cr*1.1)}px bootstrap-icons`;
                        ctx.fillText(networkIconChars[s.network]||'', pad+cr, y+cr);
                        ctx.textBaseline='alphabetic'; ctx.textAlign='left';
                        ctx.font='bold 18px Arial'; ctx.fillStyle=tc;
                        ctx.fillText(s.label, pad+cr*2+10, y+cr+6, leftContentW-cr*2-10);
                        y += lineH;
                    }
                }
            }
            // QR à droite centré verticalement + CTA sous le QR
            const qs = 270, qy = (H - qs - 24 - 36) / 2;
            roundRect(ctx, rightX, qy, qs+24, qs+24, 12); ctx.fillStyle='#ffffff'; ctx.fill();
            ctx.drawImage(srcCanvas, rightX+12, qy+12, qs, qs);
            const cta = document.getElementById('poster-cta').value.trim() || 'Scannez pour accéder';
            ctx.font='bold 20px Arial'; ctx.fillStyle=tc; ctx.textAlign='center';
            ctx.fillText(cta, rightX+(qs+24)/2, qy+qs+24+26);

        } else if (isLandscape) {
            // === PAYSAGE : gauche (logo+titre+sous-titre+réseaux), droite (QR+CTA) ===
            const pad = 55, leftW = 580, rightX = 640;
            let y = pad;
            if (posterLogoData) {
                await new Promise(res => { const img = new Image(); img.onload = () => { ctx.drawImage(img, pad, y, 90, 90); res(); }; img.src = posterLogoData; });
                y += 108;
            }
            const title = document.getElementById('poster-title').value.trim() || 'Titre de l\'affiche';
            ctx.font = 'bold 42px Arial'; ctx.fillStyle = tc; ctx.textAlign = 'left';
            y = wrapText(ctx, title, pad, y + 42, leftW - pad, 52) + 14;
            const sub = document.getElementById('poster-subtitle').value.trim();
            if (sub) { ctx.font = '600 28px Arial'; ctx.fillStyle = sc; y = wrapText(ctx, sub, pad, y + 28, leftW - pad, 36) + 14; }
            // Réseaux dans colonne gauche (sans CTA)
            if (canvasSocials.length > 0) {
                const cr = 26, lineH = cr*2 + 12;
                for (const s of canvasSocials) {
                    ctx.beginPath(); ctx.arc(pad + cr, y + cr, cr, 0, Math.PI*2);
                    ctx.fillStyle = s.network==='snapchat'?'#FFFC00':s.color; ctx.fill();
                    ctx.fillStyle = s.network==='snapchat'?'#000':'#fff';
                    ctx.textAlign='center'; ctx.textBaseline='middle';
                    ctx.font = `${Math.round(cr*1.1)}px bootstrap-icons`;
                    ctx.fillText(networkIconChars[s.network]||'', pad+cr, y+cr);
                    ctx.textBaseline='alphabetic'; ctx.textAlign='left';
                    ctx.font='bold 22px Arial'; ctx.fillStyle=tc;
                    ctx.fillText(s.label, pad+cr*2+12, y+cr+8);
                    y += lineH;
                }
            }
            // QR à droite + CTA sous le QR
            const qs = 340, qy = (H - qs - 32 - 48) / 2;
            roundRect(ctx, rightX, qy, qs + 32, qs + 32, 16); ctx.fillStyle = '#ffffff'; ctx.fill();
            ctx.drawImage(srcCanvas, rightX + 16, qy + 16, qs, qs);
            const cta = document.getElementById('poster-cta').value.trim() || 'Scannez pour accéder';
            ctx.font = 'bold 26px Arial'; ctx.fillStyle = tc; ctx.textAlign = 'center';
            ctx.fillText(cta, rightX + (qs + 32) / 2, qy + qs + 32 + 34);

        } else {
            // === PORTRAIT / CARRÉ : centré vertical ===
            const pad = 60;
            const contentW = isSquare ? 960 : 680;
            const titleSize = isSquare ? 44 : 46;
            const qsSize = isSquare ? 400 : 380;
            let y = pad;
            if (posterLogoData) {
                await new Promise(res => { const img = new Image(); img.onload = () => { ctx.drawImage(img, W/2-65, y, 130, 130); res(); }; img.src = posterLogoData; });
                y += 150;
            }
            const title = document.getElementById('poster-title').value.trim() || 'Titre de l\'affiche';
            ctx.font = `bold ${titleSize}px Arial`; ctx.fillStyle = tc; ctx.textAlign = 'center';
            y = wrapText(ctx, title, W/2, y+titleSize, contentW, titleSize+12) + 20;
            const sub = document.getElementById('poster-subtitle').value.trim();
            if (sub) { ctx.font = '600 30px Arial'; ctx.fillStyle = sc; ctx.textAlign = 'center'; y = wrapText(ctx, sub, W/2, y+30, contentW, 38) + 18; }
            const qs = qsSize, qx = (W-qs)/2-16, qy = y+16;
            roundRect(ctx, qx, qy, qs+32, qs+32, 16); ctx.fillStyle = '#ffffff'; ctx.fill();
            ctx.drawImage(srcCanvas, qx+16, qy+16, qs, qs);
            y = qy + qs + 32 + 28;
            const cta = document.getElementById('poster-cta').value.trim() || 'Scannez pour accéder';
            ctx.font = 'bold 32px Arial'; ctx.fillStyle = tc; ctx.textAlign = 'center';
            y = wrapText(ctx, cta, W/2, y+32, contentW, 40) + 18;
            if (canvasSocials.length > 0) {
                const cr = 28, lineH = cr*2 + 14;
                ctx.font = 'bold 32px Arial';
                const ctaW = ctx.measureText(cta).width;
                const ix = W/2 - ctaW/2 + cr;
                const colW = contentW / 2; // largeur d'une colonne en mode horizontal

                if (socialsLayout === 'horizontal') {
                    // 2 par ligne
                    for (let i = 0; i < canvasSocials.length; i++) {
                        const s = canvasSocials[i];
                        const col = i % 2; // 0 = gauche, 1 = droite
                        const sx = ix + col * colW;
                        if (col === 0 && i > 0) y += lineH;
                        ctx.beginPath(); ctx.arc(sx, y+cr, cr, 0, Math.PI*2);
                        ctx.fillStyle = s.network==='snapchat'?'#FFFC00':s.color; ctx.fill();
                        ctx.fillStyle = s.network==='snapchat'?'#000':'#fff';
                        ctx.textAlign='center'; ctx.textBaseline='middle';
                        ctx.font = `${Math.round(cr*1.1)}px bootstrap-icons`;
                        ctx.fillText(networkIconChars[s.network]||'', sx, y+cr);
                        ctx.textBaseline='alphabetic'; ctx.textAlign='left';
                        ctx.font='bold 22px Arial'; ctx.fillStyle=tc;
                        ctx.fillText(s.label, sx+cr+12, y+cr+8);
                    }
                } else {
                    // Vertical : 1 par ligne
                    for (const s of canvasSocials) {
                        ctx.beginPath(); ctx.arc(ix, y+cr, cr, 0, Math.PI*2);
                        ctx.fillStyle = s.network==='snapchat'?'#FFFC00':s.color; ctx.fill();
                        ctx.fillStyle = s.network==='snapchat'?'#000':'#fff';
                        ctx.textAlign='center'; ctx.textBaseline='middle';
                        ctx.font = `${Math.round(cr*1.1)}px bootstrap-icons`;
                        ctx.fillText(networkIconChars[s.network]||'', ix, y+cr);
                        ctx.textBaseline='alphabetic'; ctx.textAlign='left';
                        ctx.font='bold 24px Arial'; ctx.fillStyle=tc;
                        ctx.fillText(s.label, ix+cr+14, y+cr+9);
                        y += lineH;
                    }
                }
            }
        }

        cv.toBlob(blob => { const a = document.createElement('a'); a.href = URL.createObjectURL(blob); a.download = `affiche-qr-${posterFormat}.png`; a.click(); }, 'image/png');
    });

    function wrapText(ctx, text, x, y, maxW, lh) {
        const words = text.split(' '); let line = '', cy = y;
        words.forEach(w => { const t = line ? line+' '+w : w; if (ctx.measureText(t).width > maxW && line) { ctx.fillText(line,x,cy); line=w; cy+=lh; } else line=t; });
        if (line) ctx.fillText(line,x,cy);
        return cy;
    }
    function roundRect(ctx, x, y, w, h, r) {
        ctx.beginPath(); ctx.moveTo(x+r,y); ctx.lineTo(x+w-r,y); ctx.arcTo(x+w,y,x+w,y+r,r);
        ctx.lineTo(x+w,y+h-r); ctx.arcTo(x+w,y+h,x+w-r,y+h,r); ctx.lineTo(x+r,y+h);
        ctx.arcTo(x,y+h,x,y+h-r,r); ctx.lineTo(x,y+r); ctx.arcTo(x,y,x+r,y,r); ctx.closePath();
    }
});
</script>
@endpush
@endsection
