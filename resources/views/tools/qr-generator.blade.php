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
    aspect-ratio: 1;
    background: white;
    border-radius: 20px;
    padding: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--ce-border);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
    position: relative;
    overflow: hidden;
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
    grid-template-columns: 1fr 280px;
    gap: 28px; align-items: start;
}
@media (max-width: 900px) { .poster-editor.open { grid-template-columns: 1fr; } }

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

.poster-preview-wrap { position: sticky; top: 90px; display: flex; flex-direction: column; align-items: center; gap: 14px; }
.poster-preview-frame {
    width: 224px; height: 308px;
    border-radius: 14px; overflow: hidden;
    box-shadow: 0 12px 40px rgba(0,0,0,.15);
    border: 1px solid var(--ce-border); position: relative; background: #fff;
}
.poster-preview-inner {
    width: 800px; height: 1100px;
    transform-origin: top left; transform: scale(0.28);
    position: absolute; top: 0; left: 0;
    display: flex; flex-direction: column; align-items: center;
    padding: 60px 60px 50px; box-sizing: border-box;
}
.poster-logo-area { margin-bottom: 24px; }
.poster-logo-area img { width: 90px; height: 90px; object-fit: contain; border-radius: 10px; display: none; }
.poster-title-area { text-align: center; margin-bottom: 28px; width: 100%; }
.poster-title-area h2 { font-size: 3rem; font-weight: 800; line-height: 1.2; margin: 0 0 14px; word-break: break-word; }
.poster-title-area p  { font-size: 1.6rem; margin: 0; line-height: 1.4; word-break: break-word; }
.poster-qr-area {
    background: white; padding: 28px; border-radius: 24px;
    box-shadow: 0 8px 32px rgba(0,0,0,.12); margin-bottom: 28px;
    display: flex; align-items: center; justify-content: center;
}
.poster-cta-area { text-align: center; width: 100%; }
.poster-cta-area p { font-size: 1.5rem; font-weight: 600; margin: 0; word-break: break-word; }

.poster-socials-area { display: flex; flex-direction: column; align-items: center; gap: 10px; padding: 10px 0 4px; width: 100%; }
.pv-social-item { display: flex; align-items: center; gap: 7px; }
.pv-social-dot { width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1rem; color: #fff; flex-shrink: 0; }
.pv-social-name { font-size: .85rem; font-weight: 600; }

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
.social-icon-btn.active { border-color: var(--ce-primary); background: rgba(33,150,243,.08); color: var(--ce-primary); }
.social-icon-btn[data-network="facebook"].active  { border-color:#1877F2; background:rgba(24,119,242,.1); color:#1877F2; }
.social-icon-btn[data-network="whatsapp"].active  { border-color:#25D366; background:rgba(37,211,102,.1); color:#25D366; }
.social-icon-btn[data-network="instagram"].active { border-color:#E1306C; background:rgba(225,48,108,.1); color:#E1306C; }
.social-icon-btn[data-network="tiktok"].active    { border-color:#010101; background:rgba(1,1,1,.07);    color:#010101; }
.social-icon-btn[data-network="youtube"].active   { border-color:#FF0000; background:rgba(255,0,0,.08); color:#FF0000; }
.social-icon-btn[data-network="twitter"].active   { border-color:#555;    background:rgba(0,0,0,.06);   color:#111; }
.social-icon-btn[data-network="linkedin"].active  { border-color:#0A66C2; background:rgba(10,102,194,.1); color:#0A66C2; }
.social-icon-btn[data-network="telegram"].active  { border-color:#2CA5E0; background:rgba(44,165,224,.1); color:#2CA5E0; }
.social-icon-btn[data-network="snapchat"].active  { border-color:#ccb800; background:rgba(255,252,0,.15); color:#a09500; }
.social-icon-btn[data-network="pinterest"].active { border-color:#E60023; background:rgba(230,0,35,.08); color:#E60023; }
.social-icon-btn[data-network="website"].active   { border-color:#2196F3; background:rgba(33,150,243,.1); color:#2196F3; }
@media (max-width: 500px) { .social-icons-grid { grid-template-columns: repeat(4, 1fr); } }

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
                <label class="form-label"><i class="bi bi-palette me-1"></i> Couleur de fond</label>
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
                </div>
                <div id="social-labels-wrap" style="margin-top:10px;display:flex;flex-direction:column;gap:8px"></div>
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
                        <div id="pv-qr-placeholder" style="width:260px;height:260px;display:flex;align-items:center;justify-content:center;color:#ccc;font-size:.85rem;text-align:center;flex-direction:column;gap:10px">
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
    let posterLogoData = null;
    let selectedSocials = []; // {network, color}

    // Social icon toggle
    const networkNames = {
        facebook:'Facebook', whatsapp:'WhatsApp', instagram:'Instagram', tiktok:'TikTok',
        youtube:'YouTube', twitter:'X / Twitter', linkedin:'LinkedIn', telegram:'Telegram',
        snapchat:'Snapchat', pinterest:'Pinterest', website:'Site Web'
    };
    const networkIcons = {
        facebook:'bi-facebook', whatsapp:'bi-whatsapp', instagram:'bi-instagram', tiktok:'bi-tiktok',
        youtube:'bi-youtube', twitter:'bi-twitter-x', linkedin:'bi-linkedin', telegram:'bi-telegram',
        snapchat:'bi-snapchat', pinterest:'bi-pinterest', website:'bi-globe2'
    };

    function addSocialLabelInput(net, color) {
        const wrap = document.getElementById('social-labels-wrap');
        const row = document.createElement('div');
        row.id = `social-label-row-${net}`;
        row.style.cssText = 'display:flex;align-items:center;gap:8px';
        const iconColor = net === 'snapchat' ? '#000' : '#fff';
        const bgColor = net === 'snapchat' ? '#FFFC00' : color;
        row.innerHTML = `
            <div style="width:30px;height:30px;border-radius:50%;background:${bgColor};display:flex;align-items:center;justify-content:center;flex-shrink:0;color:${iconColor};font-size:.9rem">
                <i class="bi ${networkIcons[net]}"></i>
            </div>
            <input type="text" id="social-label-${net}" class="ce-input" placeholder="Saisissez le nom à afficher" maxlength="50" style="flex:1;padding:8px 12px">`;
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
        inner.style.background = posterBgColor;
        const tc = isDark(posterBgColor) ? '#ffffff' : '#111111';
        const sc = isDark(posterBgColor) ? 'rgba(255,255,255,0.75)' : 'rgba(0,0,0,0.6)';
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
            clone.style.cssText = 'width:260px;height:260px;display:block';
            clone.getContext('2d').drawImage(srcCanvas, 0, 0);
            pvQr.appendChild(clone);
        } else {
            document.getElementById('pv-qr-placeholder').style.display = 'flex';
        }

        // Social items in preview (circle + user-typed name)
        const pvSocials = document.getElementById('pv-socials');
        pvSocials.innerHTML = '';
        const activeSocials = selectedSocials.filter(s => s.label);
        if (activeSocials.length > 0) {
            const dark = isDark(posterBgColor);
            const nameTc = dark ? '#ffffff' : '#111111';
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


    // Télécharger l'affiche
    document.getElementById('btn-dl-poster').addEventListener('click', async () => {
        const srcCanvas = document.querySelector('#canvas-container canvas');
        if (!srcCanvas) { alert('Générez d\'abord le QR Code.'); return; }

        const W = 800, H = 1100;
        const cv = document.createElement('canvas');
        cv.width = W; cv.height = H;
        const ctx = cv.getContext('2d');

        ctx.fillStyle = posterBgColor;
        ctx.fillRect(0, 0, W, H);

        const dark = isDark(posterBgColor);
        const tc = dark ? '#ffffff' : '#111111';
        const sc = dark ? 'rgba(255,255,255,0.75)' : 'rgba(0,0,0,0.6)';
        let y = 60;

        if (posterLogoData) {
            await new Promise(res => { const img = new Image(); img.onload = () => { ctx.drawImage(img, W/2-50, y, 100, 100); res(); }; img.src = posterLogoData; });
            y += 120;
        }

        const title = document.getElementById('poster-title').value.trim() || 'Titre de l\'affiche';
        ctx.font = 'bold 52px Arial'; ctx.fillStyle = tc; ctx.textAlign = 'center';
        y = wrapText(ctx, title, W/2, y+52, 680, 62) + 24;

        const sub = document.getElementById('poster-subtitle').value.trim();
        if (sub) { ctx.font = '28px Arial'; ctx.fillStyle = sc; y = wrapText(ctx, sub, W/2, y+28, 680, 36) + 20; }

        const qs = 340, qx = (W-qs)/2-24, qy = y+20;
        roundRect(ctx, qx, qy, qs+48, qs+48, 24); ctx.fillStyle = '#ffffff'; ctx.fill();
        ctx.drawImage(srcCanvas, qx+24, qy+24, qs, qs);
        y = qy + qs + 48 + 36;

        const cta = document.getElementById('poster-cta').value.trim() || 'Scannez pour accéder';
        ctx.font = 'bold 30px Arial'; ctx.fillStyle = tc;
        y = wrapText(ctx, cta, W/2, y+30, 680, 38) + 50;

        // Social items on canvas — one per line, centered
        const canvasSocials = selectedSocials.filter(s => s.label);
        if (canvasSocials.length > 0) {
            const cr = 26, lineH = cr*2 + 16;
            ctx.font = 'bold 22px Arial';
            for (const s of canvasSocials) {
                const lbl = s.label;
                const tw = ctx.measureText(lbl).width;
                const rowW = cr*2 + 12 + tw;
                const ix = (W - rowW) / 2 + cr;
                // circle
                ctx.beginPath(); ctx.arc(ix, y + cr, cr, 0, Math.PI*2);
                ctx.fillStyle = s.network === 'snapchat' ? '#FFFC00' : s.color; ctx.fill();
                // initial inside circle
                const initials = { facebook:'f', whatsapp:'W', instagram:'In', tiktok:'T', youtube:'▶', twitter:'X', linkedin:'in', telegram:'T', snapchat:'S', pinterest:'P', website:'W' };
                ctx.fillStyle = s.network === 'snapchat' ? '#000' : '#fff';
                ctx.font = 'bold 22px Arial'; ctx.textAlign = 'center';
                ctx.fillText(initials[s.network] || s.network[0].toUpperCase(), ix, y + cr + 8);
                // label text
                ctx.textAlign = 'left'; ctx.fillStyle = tc;
                ctx.fillText(lbl, ix + cr + 12, y + cr + 8);
                y += lineH;
            }
            y += 10;
        }

        cv.toBlob(blob => { const a = document.createElement('a'); a.href = URL.createObjectURL(blob); a.download = 'affiche-qr.png'; a.click(); }, 'image/png');
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
