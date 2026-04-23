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
        renderTimeout = setTimeout(renderQR, 200);
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
});
</script>
@endpush
@endsection
