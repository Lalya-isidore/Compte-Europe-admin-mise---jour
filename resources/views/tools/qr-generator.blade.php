@extends('layouts.admin')

@section('title', 'Générateur de QR Code Premium')

@section('breadcrumb')
    <li class="breadcrumb-item"><i class="fas fa-tools me-1"></i>Outils</li>
    <li class="breadcrumb-item active">Générateur de QR Code</li>
@endsection

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
@import url('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css');

:root {
    --vault-navy: #0a0d2e;
    --vault-navy-light: #151839;
    --vault-emerald: #10b981;
    --vault-emerald-glow: rgba(16, 185, 129, 0.4);
    --vault-glass: rgba(255, 255, 255, 0.03);
    --vault-glass-border: rgba(255, 255, 255, 0.1);
    --vault-text: #e0e0ff;
    --vault-text-dim: #a0a0c0;
}

.qr-premium-wrap {
    font-family: 'Inter', sans-serif;
    color: var(--vault-text);
    background: radial-gradient(circle at top right, #1a1c3d, var(--vault-navy));
    min-height: calc(100vh - 200px);
    border-radius: 24px;
    padding: 40px;
    position: relative;
    overflow: hidden;
}

/* Background elements */
.qr-premium-wrap::before {
    content: '';
    position: absolute;
    top: -100px;
    right: -100px;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, var(--vault-emerald-glow) 0%, transparent 70%);
    z-index: 0;
    pointer-events: none;
}

.qr-header {
    position: relative;
    z-index: 1;
    margin-bottom: 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.qr-header h1 {
    font-size: 1.8rem;
    font-weight: 700;
    letter-spacing: -0.02em;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 12px;
}

.qr-header h1 i {
    color: var(--vault-emerald);
}

.badge-certified {
    background: rgba(16, 185, 129, 0.1);
    color: var(--vault-emerald);
    border: 1px solid var(--vault-emerald);
    border-radius: 100px;
    padding: 4px 12px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.main-layout {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 40px;
    position: relative;
    z-index: 1;
}

@media (max-width: 1100px) {
    .main-layout { grid-template-columns: 1fr; }
}

/* Panels */
.glass-panel {
    background: var(--vault-glass);
    backdrop-filter: blur(20px);
    border: 1px solid var(--vault-glass-border);
    border-radius: 24px;
    padding: 32px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
}

/* Tabs */
.settings-tabs {
    display: flex;
    gap: 8px;
    margin-bottom: 32px;
    background: rgba(0, 0, 0, 0.2);
    padding: 6px;
    border-radius: 16px;
}

.tab-btn {
    flex: 1;
    border: none;
    background: transparent;
    color: var(--vault-text-dim);
    padding: 10px;
    border-radius: 12px;
    font-size: 0.9rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.tab-btn.active {
    background: var(--vault-navy-light);
    color: white;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}

/* Form Styles */
.settings-content {
    display: none;
}
.settings-content.active {
    display: block;
    animation: fadeIn 0.4s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.form-group {
    margin-bottom: 24px;
}

.form-label {
    display: block;
    margin-bottom: 8px;
    font-size: 0.85rem;
    font-weight: 500;
    color: var(--vault-text-dim);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.premium-input {
    width: 100%;
    background: rgba(0, 0, 0, 0.3);
    border: 1px solid var(--vault-glass-border);
    border-radius: 12px;
    padding: 14px 18px;
    color: white;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.premium-input:focus {
    outline: none;
    border-color: var(--vault-emerald);
    box-shadow: 0 0 0 4px var(--vault-emerald-glow);
}

.color-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
    gap: 16px;
}

.color-picker-wrap {
    position: relative;
}

.color-preview {
    width: 100%;
    height: 48px;
    border-radius: 10px;
    cursor: pointer;
    border: 1px solid var(--vault-glass-border);
    position: relative;
    overflow: hidden;
}

.color-preview input {
    position: absolute;
    top: -5px; left: -5px; width: 120%; height: 120%;
    cursor: pointer;
    opacity: 0;
}

/* Style Buttons */
.style-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
}

.style-btn {
    background: rgba(0, 0, 0, 0.2);
    border: 1px solid var(--vault-glass-border);
    border-radius: 12px;
    padding: 12px;
    color: var(--vault-text-dim);
    font-size: 0.8rem;
    cursor: pointer;
    transition: all 0.2s ease;
    text-align: center;
}

.style-btn:hover {
    background: rgba(255, 255, 255, 0.05);
}

.style-btn.active {
    background: var(--vault-emerald-glow);
    border-color: var(--vault-emerald);
    color: white;
}

/* Logo Upload */
.logo-upload-zone {
    border: 2px dashed var(--vault-glass-border);
    border-radius: 20px;
    padding: 32px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.01);
}

.logo-upload-zone:hover {
    border-color: var(--vault-emerald);
    background: rgba(16, 185, 129, 0.05);
}

.logo-upload-zone i {
    font-size: 2rem;
    color: var(--vault-emerald);
    margin-bottom: 12px;
}

/* Preview Column */
.preview-sticky {
    position: sticky;
    top: 20px;
}

.qr-canvas-wrap {
    width: 100%;
    aspect-ratio: 1;
    background: white;
    border-radius: 24px;
    padding: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
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
    background: rgba(10, 13, 46, 0.95);
    color: white;
    z-index: 5;
    transition: all 0.4s ease;
    text-align: center;
}

.preview-overlay.hidden {
    opacity: 0;
    pointer-events: none;
}

.btn-premium-action {
    width: 100%;
    background: var(--vault-emerald);
    color: var(--vault-navy);
    border: none;
    border-radius: 12px;
    padding: 16px;
    font-weight: 700;
    font-size: 1rem;
    margin-top: 24px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    box-shadow: 0 4px 15px var(--vault-emerald-glow);
}

.btn-premium-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px var(--vault-emerald-glow);
    filter: brightness(1.1);
}

.btn-premium-action:active {
    transform: translateY(0);
}

/* Custom Checkbox/Switch */
.premium-switch {
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
}

.switch-input { display: none; }
.switch-rail {
    width: 44px;
    height: 24px;
    background: rgba(255, 255, 255, 0.1);
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
.switch-input:checked + .switch-rail { background: var(--vault-emerald); }
.switch-input:checked + .switch-rail::before { transform: translateX(20px); }

/* ===== POSTER SECTION ===== */
.poster-divider {
    border: none;
    border-top: 1px solid var(--vault-glass-border);
    margin: 40px 0 32px;
}
.poster-toggle-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    position: relative;
    z-index: 1;
}
.poster-toggle-label {
    display: flex;
    align-items: center;
    gap: 14px;
    cursor: pointer;
}
.poster-toggle-label .ptl-icon {
    width: 48px; height: 48px;
    background: rgba(16,185,129,0.12);
    border: 1px solid var(--vault-emerald);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem;
    color: var(--vault-emerald);
}
.poster-toggle-label .ptl-text strong { font-size: .95rem; }
.poster-toggle-label .ptl-text span { font-size: .8rem; color: var(--vault-text-dim); display: block; }

.poster-editor {
    display: none;
    margin-top: 32px;
    position: relative;
    z-index: 1;
}
.poster-editor.open { display: grid; grid-template-columns: 1fr 300px; gap: 32px; align-items: start; }
@media (max-width: 900px) { .poster-editor.open { grid-template-columns: 1fr; } }

/* Background presets */
.bg-preset-grid { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 16px; }
.bg-preset-btn {
    width: 44px; height: 44px;
    border-radius: 10px;
    border: 2px solid transparent;
    cursor: pointer;
    transition: all .2s;
    position: relative;
}
.bg-preset-btn.active { border-color: var(--vault-emerald); transform: scale(1.1); }
.bg-preset-btn.custom-bg-btn {
    display: flex; align-items: center; justify-content: center;
    background: var(--vault-glass);
    border: 2px dashed var(--vault-glass-border);
    color: var(--vault-text-dim);
    font-size: 1.2rem;
    overflow: hidden; position: relative;
}
.bg-preset-btn.custom-bg-btn input[type="color"] {
    position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
}

/* Poster preview */
.poster-preview-wrap { position: sticky; top: 20px; display: flex; flex-direction: column; align-items: center; gap: 16px; }
.poster-preview-frame {
    width: 260px; height: 357px;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(0,0,0,.5);
    border: 1px solid var(--vault-glass-border);
    position: relative;
    background: #fff;
}
.poster-preview-inner {
    width: 800px; height: 1100px;
    transform-origin: top left;
    transform: scale(0.325);
    position: absolute; top: 0; left: 0;
    display: flex; flex-direction: column; align-items: center;
    padding: 60px 60px 50px;
    box-sizing: border-box;
    gap: 0;
}
.poster-logo-area { margin-bottom: 28px; }
.poster-logo-area img { width: 90px; height: 90px; object-fit: contain; display: none; border-radius: 10px; }
.poster-title-area { text-align: center; margin-bottom: 32px; width: 100%; }
.poster-title-area h2 { font-size: 3rem; font-weight: 800; line-height: 1.2; margin: 0 0 14px; word-break: break-word; }
.poster-title-area p  { font-size: 1.6rem; margin: 0; line-height: 1.4; word-break: break-word; }
.poster-qr-area {
    background: white;
    padding: 28px;
    border-radius: 24px;
    box-shadow: 0 8px 32px rgba(0,0,0,.18);
    margin-bottom: 32px;
    display: flex; align-items: center; justify-content: center;
}
.poster-qr-area canvas { display: block !important; }
.poster-cta-area { text-align: center; width: 100%; }
.poster-cta-area p { font-size: 1.5rem; font-weight: 600; margin: 0; word-break: break-word; }

.btn-dl-poster {
    width: 100%;
    background: linear-gradient(135deg, #7c3aed, #4f46e5);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 14px;
    font-weight: 700;
    font-size: .9rem;
    cursor: pointer;
    transition: all .3s;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    box-shadow: 0 4px 15px rgba(79,70,229,.4);
}
.btn-dl-poster:hover { transform: translateY(-2px); filter: brightness(1.1); }

</style>

<div class="qr-premium-wrap mt-4">
    <div class="qr-header">
        <h1><i class="bi bi-qr-code-scan"></i> Quantum QR Generator</h1>
        <div class="badge-certified"><i class="bi bi-shield-check me-1"></i> Sovereign Secure</div>
    </div>

    <div class="main-layout">
        <!-- Configuration Panel -->
        <div class="glass-panel">
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
                    <label class="form-label">Lien ou Contenu</label>
                    <input type="text" id="qr-data" class="premium-input" placeholder="https://votre-lien.com" autocomplete="off">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Taille du fichier</label>
                    <div class="style-grid">
                        <button class="style-btn active" data-size="512">512px</button>
                        <button class="style-btn" data-size="1024">1024px</button>
                        <button class="style-btn" data-size="2048">2048px</button>
                    </div>
                </div>

                <div class="form-group">
                    <div class="premium-switch">
                        <input type="checkbox" id="qr-high-precision" class="switch-input" checked>
                        <div class="switch-rail"></div>
                        <span style="font-size:0.9rem">Haute précision (Correction d'erreur H)</span>
                    </div>
                </div>
            </div>

            <!-- Tab: Style -->
            <div class="settings-content" id="tab-style">
                <div class="form-group">
                    <label class="form-label">Couleurs</label>
                    <div class="color-grid">
                        <div class="color-picker-wrap">
                            <div class="color-preview" id="preview-dots" style="background:#000000">
                                <input type="color" id="color-dots" value="#000000">
                            </div>
                            <span style="font-size:0.7rem; color:var(--vault-text-dim)">Dots</span>
                        </div>
                        <div class="color-picker-wrap">
                            <div class="color-preview" id="preview-bg" style="background:#ffffff">
                                <input type="color" id="color-bg" value="#ffffff">
                            </div>
                            <span style="font-size:0.7rem; color:var(--vault-text-dim)">Fond</span>
                        </div>
                        <div class="color-picker-wrap">
                            <div class="color-preview" id="preview-corners" style="background:#000000">
                                <input type="color" id="color-corners" value="#000000">
                            </div>
                            <span style="font-size:0.7rem; color:var(--vault-text-dim)">Corners</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Forme des modules</label>
                    <div class="style-grid">
                        <button class="style-btn active" data-dot="square">Carré</button>
                        <button class="style-btn" data-dot="dots">Rond</button>
                        <button class="style-btn" data-dot="rounded">Arrondi</button>
                        <button class="style-btn" data-dot="extra-rounded">Extra</button>
                        <button class="style-btn" data-dot="classy">Classy</button>
                        <button class="style-btn" data-dot="classy-rounded">Modern</button>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Style des coins</label>
                    <div class="style-grid">
                        <button class="style-btn active" data-corner="square">Carré</button>
                        <button class="style-btn" data-corner="extra-rounded">Arrondi</button>
                        <button class="style-btn" data-corner="dot">Point</button>
                    </div>
                </div>
            </div>

            <!-- Tab: Logo -->
            <div class="settings-content" id="tab-logo">
                <div class="logo-upload-zone" id="drop-zone">
                    <input type="file" id="logo-input" hidden accept="image/*">
                    <i class="bi bi-cloud-arrow-up"></i>
                    <h4 style="font-size:1rem; margin-bottom:8px">Déposez votre logo ici</h4>
                    <p style="font-size:0.8rem; color:var(--vault-text-dim)">Format PNG ou SVG recommandé<br>(Max 2Mo)</p>
                </div>
                
                <div id="logo-info" style="display:none; margin-top:16px; background:rgba(0,0,0,0.2); padding:12px; border-radius:12px; display:flex; align-items:center; gap:12px">
                    <img id="logo-preview-small" src="" style="width:40px; height:40px; object-fit:contain; border-radius:6px">
                    <div style="flex:1">
                        <div id="logo-filename" style="font-size:0.9rem; font-weight:600">logo.png</div>
                        <button id="remove-logo" style="background:none; border:none; color:#ff4d4d; font-size:0.75rem; padding:0; cursor:pointer">Supprimer le logo</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Preview Panel -->
        <div class="preview-sticky">
            <div class="qr-canvas-wrap" id="canvas-container">
                <div class="preview-overlay" id="preview-overlay">
                    <i class="bi bi-qr-code" style="font-size:3rem; margin-bottom:16px"></i>
                    <p style="font-weight:600">En attente de contenu...</p>
                    <p style="font-size:0.85rem; color:var(--vault-text-dim)">L'aperçu s'affichera ici dès que<br>vous saisirez un lien.</p>
                </div>
            </div>

            <button class="btn-premium-action" id="btn-download">
                <i class="bi bi-download"></i> TÉLÉCHARGER LE QR CODE
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
                <span>Optionnel — ajoutez titre, logo et couleurs pour une affiche prête à imprimer</span>
            </div>
        </label>
        <label class="premium-switch">
            <input type="checkbox" id="toggle-poster" class="switch-input">
            <div class="switch-rail"></div>
        </label>
    </div>

    <div class="poster-editor" id="poster-editor">
        {{-- Gauche : paramètres affiche --}}
        <div class="glass-panel">
            <div class="form-group">
                <label class="form-label"><i class="bi bi-type-bold me-1"></i> Titre de l'affiche</label>
                <input type="text" id="poster-title" class="premium-input" placeholder="Ex : Rejoignez-nous !" maxlength="60">
            </div>
            <div class="form-group">
                <label class="form-label"><i class="bi bi-text-left me-1"></i> Sous-titre / Description</label>
                <input type="text" id="poster-subtitle" class="premium-input" placeholder="Ex : Notre service disponible en ligne" maxlength="100">
            </div>
            <div class="form-group">
                <label class="form-label"><i class="bi bi-cursor-text me-1"></i> Texte sous le QR Code</label>
                <input type="text" id="poster-cta" class="premium-input" placeholder="Ex : Scannez pour accéder" maxlength="80" value="Scannez pour accéder">
            </div>

            <div class="form-group">
                <label class="form-label"><i class="bi bi-palette me-1"></i> Couleur de fond</label>
                <div class="bg-preset-grid" id="bg-preset-grid">
                    <button class="bg-preset-btn active" data-color="#ffffff" style="background:#ffffff;border-color:#e5e7eb" title="Blanc"></button>
                    <button class="bg-preset-btn" data-color="#0a0d2e" style="background:#0a0d2e" title="Marine"></button>
                    <button class="bg-preset-btn" data-color="#10b981" style="background:#10b981" title="Vert"></button>
                    <button class="bg-preset-btn" data-color="#0284c7" style="background:#0284c7" title="Bleu"></button>
                    <button class="bg-preset-btn" data-color="#7c3aed" style="background:#7c3aed" title="Violet"></button>
                    <button class="bg-preset-btn" data-color="#dc2626" style="background:#dc2626" title="Rouge"></button>
                    <button class="bg-preset-btn" data-color="#f59e0b" style="background:#f59e0b" title="Doré"></button>
                    <button class="bg-preset-btn" data-color="#1e293b" style="background:#1e293b" title="Ardoise"></button>
                    <button class="bg-preset-btn custom-bg-btn" title="Couleur personnalisée">
                        <i class="bi bi-plus-lg"></i>
                        <input type="color" id="poster-custom-color" value="#ffffff">
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label"><i class="bi bi-image me-1"></i> Logo de l'affiche <span style="font-weight:400;color:var(--vault-text-dim)">(facultatif)</span></label>
                <div class="logo-upload-zone" id="poster-logo-zone">
                    <input type="file" id="poster-logo-input" hidden accept="image/*">
                    <i class="bi bi-cloud-arrow-up"></i>
                    <p style="font-size:.85rem;margin:8px 0 0;color:var(--vault-text-dim)">Cliquez pour ajouter un logo</p>
                </div>
                <div id="poster-logo-info" style="display:none;margin-top:12px;background:rgba(0,0,0,.2);padding:10px 14px;border-radius:12px;display:flex;align-items:center;gap:12px">
                    <img id="poster-logo-thumb" src="" style="width:36px;height:36px;object-fit:contain;border-radius:6px">
                    <span id="poster-logo-name" style="flex:1;font-size:.85rem">logo.png</span>
                    <button id="poster-logo-remove" style="background:none;border:none;color:#ff4d4d;font-size:.8rem;cursor:pointer;padding:0">Supprimer</button>
                </div>
            </div>
        </div>

        {{-- Droite : aperçu affiche --}}
        <div class="poster-preview-wrap">
            <div style="font-size:.8rem;color:var(--vault-text-dim);text-transform:uppercase;letter-spacing:.05em">Aperçu affiche</div>
            <div class="poster-preview-frame">
                <div class="poster-preview-inner" id="poster-preview-inner">
                    <div class="poster-logo-area" id="pv-logo-area">
                        <img id="pv-logo" src="" alt="">
                    </div>
                    <div class="poster-title-area" id="pv-title-area">
                        <h2 id="pv-title">Titre de l'affiche</h2>
                        <p id="pv-subtitle"></p>
                    </div>
                    <div class="poster-qr-area" id="pv-qr-area">
                        <div id="pv-qr-placeholder" style="width:260px;height:260px;display:flex;align-items:center;justify-content:center;color:#ccc;font-size:.9rem;text-align:center">
                            <div><i class="bi bi-qr-code" style="font-size:3rem;display:block;margin-bottom:8px"></i>QR Code ici</div>
                        </div>
                    </div>
                    <div class="poster-cta-area" id="pv-cta-area">
                        <p id="pv-cta">Scannez pour accéder</p>
                    </div>
                </div>
            </div>
            <button class="btn-dl-poster" id="btn-dl-poster">
                <i class="bi bi-image"></i> Télécharger l'affiche
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
                currentOptions[key] = btn.dataset[key.replace('current', '').toLowerCase()] || btn.dataset[key] || btn.dataset.size || btn.dataset.dot || btn.dataset.corner;
                
                // Special mapping if needed
                if(key === 'dotStyle') currentOptions.dotStyle = btn.dataset.dot;
                if(key === 'cornerStyle') currentOptions.cornerStyle = btn.dataset.corner;
                if(key === 'size') currentOptions.size = parseInt(btn.dataset.size);

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

    document.getElementById('remove-logo').addEventListener('click', () => {
        logoData = null;
        logoInput.value = '';
        document.getElementById('logo-info').style.display = 'none';
        debouncedRender();
    });

    // DEBOUNCE RENDER
    let renderTimeout;
    function debouncedRender() {
        clearTimeout(renderTimeout);
        renderTimeout = setTimeout(renderQR, 300);
    }

    function renderQR() {
        if(!currentOptions.data) return;

        const container = document.getElementById('canvas-container');
        container.querySelectorAll('canvas').forEach(c => c.remove());

        const qrOptions = {
            width: 400, // Display width
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
        
        // Re-init with full size for export
        const exportOptions = {...qrInstance._options};
        exportOptions.width = currentOptions.size;
        exportOptions.height = currentOptions.size;
        
        const exportInstance = new QRCodeStyling(exportOptions);
        exportInstance.download({ name: "qr-code-" + Date.now(), extension: "png" });
    });

    // Initial check (if data exists)
    if(dataInput.value.trim()) {
        currentOptions.data = dataInput.value.trim();
        document.getElementById('preview-overlay').classList.add('hidden');
        renderQR();
    }

    // ===== POSTER SECTION =====
    const togglePoster = document.getElementById('toggle-poster');
    const posterEditor = document.getElementById('poster-editor');
    let posterBgColor = '#ffffff';
    let posterLogoData = null;

    togglePoster.addEventListener('change', () => {
        posterEditor.classList.toggle('open', togglePoster.checked);
        if (togglePoster.checked) updatePosterPreview();
    });

    // Background presets
    document.querySelectorAll('.bg-preset-btn[data-color]').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.bg-preset-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            posterBgColor = btn.dataset.color;
            updatePosterPreview();
        });
    });

    // Custom color
    document.getElementById('poster-custom-color').addEventListener('input', (e) => {
        document.querySelectorAll('.bg-preset-btn').forEach(b => b.classList.remove('active'));
        e.target.closest('.bg-preset-btn').classList.add('active');
        posterBgColor = e.target.value;
        updatePosterPreview();
    });

    // Poster text inputs
    ['poster-title', 'poster-subtitle', 'poster-cta'].forEach(id => {
        document.getElementById(id).addEventListener('input', updatePosterPreview);
    });

    // Poster logo upload
    const posterLogoZone = document.getElementById('poster-logo-zone');
    const posterLogoInput = document.getElementById('poster-logo-input');
    posterLogoZone.addEventListener('click', () => posterLogoInput.click());
    posterLogoInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = (ev) => {
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
        document.getElementById('pv-logo').src = '';
        updatePosterPreview();
    });

    function isDark(hex) {
        const r = parseInt(hex.slice(1,3),16), g = parseInt(hex.slice(3,5),16), b = parseInt(hex.slice(5,7),16);
        return (r*299 + g*587 + b*114) / 1000 < 128;
    }

    function updatePosterPreview() {
        const inner = document.getElementById('poster-preview-inner');
        inner.style.background = posterBgColor;
        const textColor = isDark(posterBgColor) ? '#ffffff' : '#111111';
        const subColor  = isDark(posterBgColor) ? 'rgba(255,255,255,0.75)' : 'rgba(0,0,0,0.6)';

        document.getElementById('pv-title').style.color = textColor;
        document.getElementById('pv-title').textContent = document.getElementById('poster-title').value || 'Titre de l\'affiche';
        document.getElementById('pv-subtitle').style.color = subColor;
        document.getElementById('pv-subtitle').textContent = document.getElementById('poster-subtitle').value;
        document.getElementById('pv-cta').style.color = textColor;
        document.getElementById('pv-cta').textContent = document.getElementById('poster-cta').value || 'Scannez pour accéder';

        // Inject QR canvas clone into poster preview
        const srcCanvas = document.querySelector('#canvas-container canvas');
        const pvQr = document.getElementById('pv-qr-area');
        const placeholder = document.getElementById('pv-qr-placeholder');
        pvQr.querySelectorAll('canvas').forEach(c => c.remove());
        if (srcCanvas) {
            placeholder.style.display = 'none';
            const clone = document.createElement('canvas');
            clone.width = srcCanvas.width;
            clone.height = srcCanvas.height;
            clone.style.width = '260px';
            clone.style.height = '260px';
            clone.getContext('2d').drawImage(srcCanvas, 0, 0);
            pvQr.appendChild(clone);
        } else {
            placeholder.style.display = 'flex';
        }
    }

    // Hook QR render to also update poster preview
    const origRender = renderQR;
    function renderQR() {
        origRender();
        if (togglePoster.checked) setTimeout(updatePosterPreview, 350);
    }

    // ===== DOWNLOAD POSTER =====
    document.getElementById('btn-dl-poster').addEventListener('click', async () => {
        const srcCanvas = document.querySelector('#canvas-container canvas');
        if (!srcCanvas) { alert('Générez d\'abord le QR Code avant de télécharger l\'affiche.'); return; }

        const W = 800, H = 1100;
        const canvas = document.createElement('canvas');
        canvas.width = W; canvas.height = H;
        const ctx = canvas.getContext('2d');

        // Background
        ctx.fillStyle = posterBgColor;
        ctx.fillRect(0, 0, W, H);

        const dark = isDark(posterBgColor);
        const textColor = dark ? '#ffffff' : '#111111';
        const subColor  = dark ? 'rgba(255,255,255,0.75)' : 'rgba(0,0,0,0.6)';

        let yPos = 60;

        // Logo
        if (posterLogoData) {
            await new Promise(resolve => {
                const img = new Image();
                img.onload = () => { ctx.drawImage(img, W/2 - 50, yPos, 100, 100); resolve(); };
                img.src = posterLogoData;
            });
            yPos += 120;
        }

        // Title
        const titleText = document.getElementById('poster-title').value.trim() || 'Titre de l\'affiche';
        ctx.font = 'bold 52px Arial, sans-serif';
        ctx.fillStyle = textColor;
        ctx.textAlign = 'center';
        yPos = drawWrappedText(ctx, titleText, W/2, yPos + 52, 680, 62) + 20;

        // Subtitle
        const subText = document.getElementById('poster-subtitle').value.trim();
        if (subText) {
            ctx.font = '28px Arial, sans-serif';
            ctx.fillStyle = subColor;
            yPos = drawWrappedText(ctx, subText, W/2, yPos + 28, 680, 36) + 20;
        }

        // QR code white card
        const qrSize = 340;
        const qrX = (W - qrSize) / 2 - 24;
        const qrY = yPos + 20;
        roundRect(ctx, qrX, qrY, qrSize + 48, qrSize + 48, 24);
        ctx.fillStyle = '#ffffff';
        ctx.fill();
        ctx.drawImage(srcCanvas, qrX + 24, qrY + 24, qrSize, qrSize);
        yPos = qrY + qrSize + 48 + 32;

        // CTA
        const ctaText = document.getElementById('poster-cta').value.trim() || 'Scannez pour accéder';
        ctx.font = 'bold 30px Arial, sans-serif';
        ctx.fillStyle = textColor;
        drawWrappedText(ctx, ctaText, W/2, yPos + 30, 680, 38);

        // Export
        canvas.toBlob(blob => {
            const a = document.createElement('a');
            a.href = URL.createObjectURL(blob);
            a.download = 'affiche-qr-' + Date.now() + '.png';
            a.click();
        }, 'image/png');
    });

    function drawWrappedText(ctx, text, x, y, maxWidth, lineHeight) {
        const words = text.split(' ');
        let line = '';
        let curY = y;
        words.forEach((word, i) => {
            const test = line + (line ? ' ' : '') + word;
            if (ctx.measureText(test).width > maxWidth && line) {
                ctx.fillText(line, x, curY);
                line = word;
                curY += lineHeight;
            } else { line = test; }
        });
        if (line) { ctx.fillText(line, x, curY); }
        return curY;
    }

    function roundRect(ctx, x, y, w, h, r) {
        ctx.beginPath();
        ctx.moveTo(x + r, y);
        ctx.lineTo(x + w - r, y);
        ctx.arcTo(x + w, y, x + w, y + r, r);
        ctx.lineTo(x + w, y + h - r);
        ctx.arcTo(x + w, y + h, x + w - r, y + h, r);
        ctx.lineTo(x + r, y + h);
        ctx.arcTo(x, y + h, x, y + h - r, r);
        ctx.lineTo(x, y + r);
        ctx.arcTo(x, y, x + r, y, r);
        ctx.closePath();
    }
});
</script>
@endpush
@endsection

