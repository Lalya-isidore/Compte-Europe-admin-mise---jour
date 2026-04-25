@extends('layouts.admin')

@section('title', 'Générateur de Badge Agent')

@section('breadcrumb')
    <li class="breadcrumb-item"><i class="fas fa-tools me-1"></i>Outils</li>
    <li class="breadcrumb-item active">Badge Agent</li>
@endsection

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Righteous&display=swap');

:root {
    --ce-primary: #2196F3;
    --ce-gradient: linear-gradient(135deg, #667eea, #764ba2);
    --ce-bg: #f5f3ef;
    --ce-card-bg: #ffffff;
    --ce-text: #333333;
    --ce-text-dim: #888888;
    --ce-border: #e8e8e8;
}

.badge-wrap {
    font-family: 'Poppins', sans-serif;
    color: var(--ce-text);
    padding: 20px 24px;
}

.badge-header {
    margin-bottom: 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}

.badge-header h1 {
    font-size: 1.6rem;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 12px;
}

.badge-header h1 span {
    font-family: 'Righteous', cursive;
    background: var(--ce-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.badge-certified {
    background: #fff;
    color: var(--ce-text-dim);
    border: 1px solid var(--ce-border);
    border-radius: 20px;
    padding: 6px 16px;
    font-size: 0.78rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
}

.badge-editor {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 24px;
    align-items: start;
}

.ce-card {
    background: var(--ce-card-bg);
    border-radius: 16px;
    border: 1px solid var(--ce-border);
    padding: 24px;
    margin-bottom: 20px;
}

.ce-card h3 {
    font-size: 0.95rem;
    font-weight: 700;
    margin: 0 0 18px;
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--ce-text);
}

.ce-card h3 i { font-size: 1rem; color: var(--ce-primary); }

.form-label {
    font-size: 0.82rem;
    font-weight: 600;
    color: var(--ce-text-dim);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
}

.form-control, .form-select {
    border: 1.5px solid var(--ce-border);
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 0.9rem;
    font-family: 'Poppins', sans-serif;
    color: var(--ce-text);
    background: #fafafa;
    transition: border-color .2s, box-shadow .2s;
    width: 100%;
}

.form-control:focus, .form-select:focus {
    outline: none;
    border-color: var(--ce-primary);
    box-shadow: 0 0 0 3px rgba(33,150,243,.12);
    background: #fff;
}

.color-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 8px;
}

.color-swatch {
    width: 100%;
    aspect-ratio: 1;
    border-radius: 10px;
    border: 3px solid transparent;
    cursor: pointer;
    transition: transform .15s, border-color .15s;
}

.color-swatch:hover { transform: scale(1.1); }
.color-swatch.active { border-color: #333; transform: scale(1.05); }

.template-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
}

.template-btn {
    border: 2px solid var(--ce-border);
    border-radius: 10px;
    padding: 10px 6px;
    cursor: pointer;
    font-size: 0.75rem;
    font-weight: 600;
    text-align: center;
    background: #fafafa;
    transition: all .2s;
    color: var(--ce-text);
}

.template-btn:hover { border-color: var(--ce-primary); background: #f0f7ff; }
.template-btn.active { border-color: var(--ce-primary); background: #e3f2fd; color: var(--ce-primary); }

.template-btn .tpl-icon { font-size: 1.4rem; display: block; margin-bottom: 4px; }

/* Photo upload */
.photo-upload-area {
    border: 2px dashed var(--ce-border);
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    transition: all .2s;
    position: relative;
    background: #fafafa;
}

.photo-upload-area:hover { border-color: var(--ce-primary); background: #f0f7ff; }

.photo-preview-thumb {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    display: none;
    margin: 0 auto 8px;
    border: 3px solid var(--ce-primary);
}

/* Preview panel */
.badge-preview-wrap {
    position: sticky;
    top: 80px;
}

.badge-preview-label {
    font-size: 0.82rem;
    font-weight: 700;
    color: var(--ce-text-dim);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.badge-preview-frame {
    width: 340px;
    height: 214px;
    margin: 0 auto;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,.18);
    position: relative;
}

/* CARD INNER — the actual 85.6×54mm card at 4x = 856x540px, scaled down */
.badge-preview-inner {
    width: 856px;
    height: 540px;
    transform: scale(0.3972);
    transform-origin: top left;
    position: absolute;
    top: 0; left: 0;
    border-radius: 46px;
    overflow: hidden;
    font-family: 'Poppins', sans-serif;
}

/* ====== TEMPLATE 1 : Modern Blue ====== */
.badge-preview-inner.tpl-modern {
    background: #ffffff;
}
.tpl-modern .badge-stripe {
    height: 160px;
    background: linear-gradient(135deg, #1565C0, #42A5F5);
    position: relative;
    display: flex;
    align-items: flex-end;
    padding: 0 40px 20px;
    gap: 30px;
}
.tpl-modern .badge-photo-wrap {
    width: 130px; height: 130px;
    border-radius: 50%;
    border: 5px solid rgba(255,255,255,.5);
    overflow: hidden;
    background: rgba(255,255,255,.2);
    flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: -30px;
}
.tpl-modern .badge-photo-wrap img { width: 100%; height: 100%; object-fit: cover; }
.tpl-modern .badge-photo-wrap .photo-placeholder { font-size: 3rem; color: rgba(255,255,255,.7); }
.tpl-modern .badge-top-info { padding-bottom: 8px; }
.tpl-modern .badge-company { font-size: 22px; font-weight: 800; color: #fff; line-height: 1.1; }
.tpl-modern .badge-logo-area { margin-left: auto; display:flex; align-items:center; }
.tpl-modern .badge-logo-area img { max-height: 60px; max-width: 120px; object-fit: contain; filter: brightness(0) invert(1); opacity:.9; }
.tpl-modern .badge-body { padding: 36px 40px 24px; }
.tpl-modern .badge-name { font-size: 36px; font-weight: 800; color: #1a1a1a; margin-bottom: 4px; line-height: 1.1; }
.tpl-modern .badge-role { font-size: 22px; font-weight: 600; color: #1565C0; margin-bottom: 24px; }
.tpl-modern .badge-info-row { display: flex; gap: 40px; margin-top: 4px; }
.tpl-modern .badge-info-item { display: flex; align-items: center; gap: 10px; font-size: 18px; color: #555; }
.tpl-modern .badge-info-icon { width: 32px; height: 32px; border-radius: 8px; background: #e3f2fd; display:flex; align-items:center; justify-content:center; font-size: 16px; color: #1565C0; flex-shrink:0; }
.tpl-modern .badge-id-strip { position: absolute; bottom: 0; left: 0; right: 0; height: 50px; background: linear-gradient(135deg, #1565C0, #42A5F5); display: flex; align-items: center; padding: 0 40px; gap: 14px; }
.tpl-modern .badge-id-text { color: rgba(255,255,255,.9); font-size: 18px; font-weight: 600; }
.tpl-modern .badge-id-val { color: #fff; font-size: 20px; font-weight: 800; font-family: monospace; letter-spacing: 2px; }

/* ====== TEMPLATE 2 : Dark Pro ====== */
.badge-preview-inner.tpl-dark {
    background: #0f172a;
}
.tpl-dark .badge-left-col {
    position: absolute; left: 0; top: 0; bottom: 0; width: 240px;
    background: linear-gradient(180deg, #1e293b, #0f172a);
    display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 20px;
    padding: 30px 20px;
}
.tpl-dark .badge-photo-wrap {
    width: 140px; height: 140px; border-radius: 50%;
    border: 4px solid #334155; overflow: hidden;
    background: #1e293b;
    display: flex; align-items: center; justify-content: center;
}
.tpl-dark .badge-photo-wrap img { width: 100%; height: 100%; object-fit: cover; }
.tpl-dark .badge-photo-wrap .photo-placeholder { font-size: 3.2rem; color: #475569; }
.tpl-dark .badge-id-chip { background: #334155; border-radius: 20px; padding: 6px 20px; color: #94a3b8; font-size: 17px; font-weight: 700; letter-spacing: 2px; font-family: monospace; }
.tpl-dark .badge-right-col {
    position: absolute; left: 240px; right: 0; top: 0; bottom: 0;
    padding: 36px 36px 30px;
    display: flex; flex-direction: column; justify-content: space-between;
}
.tpl-dark .badge-logo-area img { max-height: 50px; max-width: 120px; object-fit: contain; filter: brightness(0) invert(1); opacity:.6; }
.tpl-dark .badge-main { }
.tpl-dark .badge-role { font-size: 19px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 8px; }
.tpl-dark .badge-name { font-size: 38px; font-weight: 800; color: #f1f5f9; line-height: 1.1; margin-bottom: 12px; }
.tpl-dark .badge-company { font-size: 22px; font-weight: 600; color: #94a3b8; margin-bottom: 20px; }
.tpl-dark .badge-accent { width: 50px; height: 4px; border-radius: 2px; background: linear-gradient(90deg, #6366f1, #8b5cf6); margin-bottom: 20px; }
.tpl-dark .badge-info-row { display: flex; flex-direction: column; gap: 10px; }
.tpl-dark .badge-info-item { display: flex; align-items: center; gap: 10px; font-size: 17px; color: #94a3b8; }
.tpl-dark .badge-info-icon { font-size: 17px; color: #6366f1; }

/* ====== TEMPLATE 3 : Clean Minimal ====== */
.badge-preview-inner.tpl-minimal {
    background: #fafafa;
    border: 2px solid #e5e7eb;
}
.tpl-minimal .badge-top-bar {
    height: 12px;
    background: #1f2937;
}
.tpl-minimal .badge-content {
    display: flex; gap: 0; height: calc(100% - 12px);
}
.tpl-minimal .badge-left {
    width: 220px; padding: 30px 24px;
    display: flex; flex-direction: column; align-items: center; gap: 14px;
    background: #f3f4f6; border-right: 1px solid #e5e7eb;
}
.tpl-minimal .badge-photo-wrap {
    width: 130px; height: 130px; border-radius: 16px;
    overflow: hidden; background: #e5e7eb;
    display: flex; align-items: center; justify-content: center;
}
.tpl-minimal .badge-photo-wrap img { width: 100%; height: 100%; object-fit: cover; }
.tpl-minimal .badge-photo-wrap .photo-placeholder { font-size: 3rem; color: #9ca3af; }
.tpl-minimal .badge-id-chip { background: #1f2937; color: #fff; border-radius: 8px; padding: 5px 16px; font-size: 16px; font-weight: 700; letter-spacing: 1px; font-family: monospace; }
.tpl-minimal .badge-logo-min img { max-height: 40px; max-width: 100px; object-fit: contain; }
.tpl-minimal .badge-right {
    flex: 1; padding: 34px 36px;
    display: flex; flex-direction: column; justify-content: space-between;
}
.tpl-minimal .badge-company { font-size: 18px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 1px; }
.tpl-minimal .badge-name { font-size: 40px; font-weight: 800; color: #111827; line-height: 1.05; margin: 8px 0 4px; }
.tpl-minimal .badge-role { font-size: 21px; font-weight: 600; color: #374151; margin-bottom: 24px; }
.tpl-minimal .badge-divider { width: 40px; height: 3px; background: #1f2937; border-radius: 2px; margin-bottom: 20px; }
.tpl-minimal .badge-info-row { display: flex; flex-direction: column; gap: 10px; }
.tpl-minimal .badge-info-item { display: flex; align-items: center; gap: 10px; font-size: 17px; color: #6b7280; }
.tpl-minimal .badge-info-icon { font-size: 16px; color: #374151; }

/* Download btn */
.btn-download {
    width: 100%;
    margin-top: 16px;
    padding: 14px;
    border-radius: 12px;
    border: none;
    font-size: 1rem;
    font-weight: 700;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: #fff;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: opacity .2s, transform .15s;
    box-shadow: 0 4px 20px rgba(102,126,234,.4);
}

.btn-download:hover { opacity: .92; transform: translateY(-1px); }
.btn-download:active { transform: translateY(0); }

.size-info {
    text-align: center;
    font-size: 0.75rem;
    color: var(--ce-text-dim);
    margin-top: 8px;
}

/* Color accent applies to templates */
.badge-preview-inner[data-accent] .tpl-accent-bg { background: var(--accent-color) !important; }

@media (max-width: 900px) {
    .badge-editor { grid-template-columns: 1fr; }
    .badge-preview-wrap { position: static; }
    .badge-preview-frame { margin: 0 auto; }
}

@media (max-width: 768px) {
    .badge-wrap { padding: 14px 0; }
    .ce-card { border-radius: 0; box-shadow: none; border-left: none; border-right: none; }
    .color-grid { grid-template-columns: repeat(5, 1fr); }
}
</style>

<div class="badge-wrap">
    <div class="badge-header">
        <h1>
            <i class="fas fa-id-badge" style="color:#667eea;"></i>
            <span>Badge Agent</span>
        </h1>
        <div class="badge-certified">
            <i class="fas fa-star" style="color:#f59e0b;"></i> Outil Gratuit
        </div>
    </div>

    <div class="badge-editor">
        {{-- ===== FORMULAIRE ===== --}}
        <div class="badge-form-col">

            {{-- Modèle --}}
            <div class="ce-card">
                <h3><i class="fas fa-layer-group"></i> Modèle de carte</h3>
                <div class="template-grid">
                    <button class="template-btn active" data-tpl="tpl-modern" type="button">
                        <span class="tpl-icon">🔵</span>Modern Blue
                    </button>
                    <button class="template-btn" data-tpl="tpl-dark" type="button">
                        <span class="tpl-icon">⚫</span>Dark Pro
                    </button>
                    <button class="template-btn" data-tpl="tpl-minimal" type="button">
                        <span class="tpl-icon">⬜</span>Minimal
                    </button>
                </div>
            </div>

            {{-- Informations agent --}}
            <div class="ce-card">
                <h3><i class="fas fa-user-tie"></i> Informations de l'agent</h3>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                    <div>
                        <label class="form-label">Prénom & Nom</label>
                        <input type="text" id="inp-name" class="form-control" placeholder="Jean Dupont" maxlength="40">
                    </div>
                    <div>
                        <label class="form-label">Poste / Rôle</label>
                        <input type="text" id="inp-role" class="form-control" placeholder="Agent Commercial" maxlength="40">
                    </div>
                    <div>
                        <label class="form-label">Société / Agence</label>
                        <input type="text" id="inp-company" class="form-control" placeholder="FlashBilan SAS" maxlength="40">
                    </div>
                    <div>
                        <label class="form-label">Numéro ID / Badge</label>
                        <input type="text" id="inp-id" class="form-control" placeholder="AGT-2024-001" maxlength="20">
                    </div>
                    <div>
                        <label class="form-label">Téléphone</label>
                        <input type="text" id="inp-phone" class="form-control" placeholder="+33 6 00 00 00 00" maxlength="25">
                    </div>
                    <div>
                        <label class="form-label">Email</label>
                        <input type="text" id="inp-email" class="form-control" placeholder="agent@flashbilan.fr" maxlength="40">
                    </div>
                </div>
            </div>

            {{-- Photos --}}
            <div class="ce-card">
                <h3><i class="fas fa-images"></i> Photos</h3>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                    <div>
                        <label class="form-label">Photo de l'agent</label>
                        <div class="photo-upload-area" id="agent-photo-area" onclick="document.getElementById('inp-photo').click()">
                            <img id="agent-photo-preview" class="photo-preview-thumb" src="" alt="">
                            <div id="agent-photo-placeholder">
                                <i class="fas fa-user-circle" style="font-size:2rem;color:#ccc;display:block;margin-bottom:8px;"></i>
                                <div style="font-size:.8rem;color:#aaa;">Cliquez pour importer</div>
                            </div>
                        </div>
                        <input type="file" id="inp-photo" accept="image/*" style="display:none;">
                    </div>
                    <div>
                        <label class="form-label">Logo de l'entreprise</label>
                        <div class="photo-upload-area" id="logo-photo-area" onclick="document.getElementById('inp-logo').click()">
                            <img id="logo-photo-preview" class="photo-preview-thumb" src="" alt="" style="border-radius:8px;">
                            <div id="logo-photo-placeholder">
                                <i class="fas fa-building" style="font-size:2rem;color:#ccc;display:block;margin-bottom:8px;"></i>
                                <div style="font-size:.8rem;color:#aaa;">Cliquez pour importer</div>
                            </div>
                        </div>
                        <input type="file" id="inp-logo" accept="image/*" style="display:none;">
                    </div>
                </div>
            </div>

            {{-- Couleur accent --}}
            <div class="ce-card">
                <h3><i class="fas fa-palette"></i> Couleur principale</h3>
                <div class="color-grid">
                    <div class="color-swatch active" data-color="#1565C0" style="background:#1565C0;" title="Bleu"></div>
                    <div class="color-swatch" data-color="#7c3aed" style="background:#7c3aed;" title="Violet"></div>
                    <div class="color-swatch" data-color="#dc2626" style="background:#dc2626;" title="Rouge"></div>
                    <div class="color-swatch" data-color="#059669" style="background:#059669;" title="Vert"></div>
                    <div class="color-swatch" data-color="#d97706" style="background:#d97706;" title="Orange"></div>
                    <div class="color-swatch" data-color="#0891b2" style="background:#0891b2;" title="Cyan"></div>
                    <div class="color-swatch" data-color="#db2777" style="background:#db2777;" title="Rose"></div>
                    <div class="color-swatch" data-color="#0f172a" style="background:#0f172a;" title="Noir"></div>
                    <div class="color-swatch" data-color="#374151" style="background:#374151;" title="Gris"></div>
                    <div class="color-swatch" data-color="#b45309" style="background:#b45309;" title="Marron"></div>
                </div>
            </div>

        </div>

        {{-- ===== APERÇU ===== --}}
        <div class="badge-preview-wrap">
            <div class="badge-preview-label">
                <i class="fas fa-eye"></i> Aperçu en temps réel
            </div>

            <div class="badge-preview-frame" id="badge-frame">
                <div class="badge-preview-inner tpl-modern" id="badge-inner">

                    {{-- MODERN --}}
                    <div class="badge-stripe" id="pv-stripe">
                        <div class="badge-photo-wrap" id="pv-photo-wrap">
                            <span class="photo-placeholder" id="pv-photo-ph">👤</span>
                            <img id="pv-photo-img" src="" alt="" style="display:none;">
                        </div>
                        <div class="badge-top-info">
                            <div class="badge-company" id="pv-company">FlashBilan SAS</div>
                        </div>
                        <div class="badge-logo-area" id="pv-logo-area">
                            <img id="pv-logo-img" src="" alt="" style="display:none;">
                        </div>
                    </div>
                    <div class="badge-body" id="pv-body">
                        <div class="badge-name" id="pv-name">Jean Dupont</div>
                        <div class="badge-role" id="pv-role">Agent Commercial</div>
                        <div class="badge-info-row" id="pv-info-row">
                            <div class="badge-info-item" id="pv-phone-item">
                                <div class="badge-info-icon">📞</div>
                                <span id="pv-phone">+33 6 00 00 00 00</span>
                            </div>
                            <div class="badge-info-item" id="pv-email-item">
                                <div class="badge-info-icon">✉️</div>
                                <span id="pv-email">agent@flashbilan.fr</span>
                            </div>
                        </div>
                    </div>
                    <div class="badge-id-strip" id="pv-id-strip">
                        <span class="badge-id-text">ID :</span>
                        <span class="badge-id-val" id="pv-id">AGT-2024-001</span>
                    </div>

                </div>
            </div>

            <button class="btn-download" id="btn-download" type="button">
                <i class="fas fa-download"></i> Télécharger PNG (HD)
            </button>
            <div class="size-info">Taille réelle : 856 × 540 px (standard carte bancaire)</div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    // ===== État =====
    let currentTpl = 'tpl-modern';
    let accentColor = '#1565C0';
    let agentPhotoSrc = null;
    let logoSrc = null;

    const inner = document.getElementById('badge-inner');

    // ===== Inputs → aperçu =====
    const bindings = [
        { id: 'inp-name',    fn: v => setText('pv-name',    v || 'Jean Dupont') },
        { id: 'inp-role',    fn: v => setText('pv-role',    v || 'Agent Commercial') },
        { id: 'inp-company', fn: v => setText('pv-company', v || 'FlashBilan SAS') },
        { id: 'inp-id',      fn: v => setText('pv-id',      v || 'AGT-2024-001') },
        { id: 'inp-phone',   fn: v => setText('pv-phone',   v || '+33 6 00 00 00 00') },
        { id: 'inp-email',   fn: v => setText('pv-email',   v || 'agent@flashbilan.fr') },
    ];

    bindings.forEach(({ id, fn }) => {
        document.getElementById(id)?.addEventListener('input', e => fn(e.target.value.trim()));
    });

    function setText(elId, text) {
        const el = document.getElementById(elId);
        if (el) el.textContent = text;
    }

    // ===== Changement de modèle =====
    document.querySelectorAll('.template-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.template-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            currentTpl = btn.dataset.tpl;
            rebuildPreview();
        });
    });

    // ===== Couleur accent =====
    document.querySelectorAll('.color-swatch').forEach(sw => {
        sw.addEventListener('click', () => {
            document.querySelectorAll('.color-swatch').forEach(s => s.classList.remove('active'));
            sw.classList.add('active');
            accentColor = sw.dataset.color;
            applyAccent();
        });
    });

    function applyAccent() {
        if (currentTpl === 'tpl-modern') {
            const stripe = inner.querySelector('.badge-stripe');
            const idStrip = inner.querySelector('.badge-id-strip');
            const role = inner.querySelector('.badge-role');
            const icons = inner.querySelectorAll('.badge-info-icon');
            if (stripe) stripe.style.background = `linear-gradient(135deg, ${accentColor}, ${lightenHex(accentColor, 40)})`;
            if (idStrip) idStrip.style.background = `linear-gradient(135deg, ${accentColor}, ${lightenHex(accentColor, 40)})`;
            if (role) role.style.color = accentColor;
            icons.forEach(ic => { ic.style.background = hexToRgba(accentColor, 0.12); ic.style.color = accentColor; });
        } else if (currentTpl === 'tpl-dark') {
            const acc = inner.querySelector('.badge-accent');
            const icons = inner.querySelectorAll('.badge-info-icon');
            if (acc) acc.style.background = `linear-gradient(90deg, ${accentColor}, ${lightenHex(accentColor, 40)})`;
            icons.forEach(ic => ic.style.color = accentColor);
        } else if (currentTpl === 'tpl-minimal') {
            const bar = inner.querySelector('.badge-top-bar');
            const chip = inner.querySelector('.badge-id-chip');
            const divider = inner.querySelector('.badge-divider');
            if (bar) bar.style.background = accentColor;
            if (chip) chip.style.background = accentColor;
            if (divider) divider.style.background = accentColor;
        }
    }

    // ===== Photos =====
    document.getElementById('inp-photo').addEventListener('change', function() {
        if (!this.files[0]) return;
        const reader = new FileReader();
        reader.onload = e => {
            agentPhotoSrc = e.target.result;
            // Thumbnail
            const prev = document.getElementById('agent-photo-preview');
            const ph = document.getElementById('agent-photo-placeholder');
            prev.src = agentPhotoSrc; prev.style.display = 'block'; ph.style.display = 'none';
            updatePhoto();
        };
        reader.readAsDataURL(this.files[0]);
    });

    document.getElementById('inp-logo').addEventListener('change', function() {
        if (!this.files[0]) return;
        const reader = new FileReader();
        reader.onload = e => {
            logoSrc = e.target.result;
            const prev = document.getElementById('logo-photo-preview');
            const ph = document.getElementById('logo-photo-placeholder');
            prev.src = logoSrc; prev.style.display = 'block'; ph.style.display = 'none';
            updateLogo();
        };
        reader.readAsDataURL(this.files[0]);
    });

    function updatePhoto() {
        const ph = inner.querySelector('.photo-placeholder');
        const img = inner.querySelector('.badge-photo-wrap img');
        if (!img) return;
        if (agentPhotoSrc) { img.src = agentPhotoSrc; img.style.display = 'block'; if(ph) ph.style.display='none'; }
        else { img.style.display = 'none'; if(ph) ph.style.display='block'; }
    }

    function updateLogo() {
        const logoImg = inner.querySelector('.badge-logo-area img, .badge-logo-min img');
        if (!logoImg) return;
        if (logoSrc) { logoImg.src = logoSrc; logoImg.style.display = 'block'; }
        else { logoImg.style.display = 'none'; }
    }

    // ===== Rebuild preview on template change =====
    function rebuildPreview() {
        const name    = document.getElementById('inp-name').value.trim()    || 'Jean Dupont';
        const role    = document.getElementById('inp-role').value.trim()    || 'Agent Commercial';
        const company = document.getElementById('inp-company').value.trim() || 'FlashBilan SAS';
        const idVal   = document.getElementById('inp-id').value.trim()      || 'AGT-2024-001';
        const phone   = document.getElementById('inp-phone').value.trim()   || '+33 6 00 00 00 00';
        const email   = document.getElementById('inp-email').value.trim()   || 'agent@flashbilan.fr';

        let html = '';

        if (currentTpl === 'tpl-modern') {
            html = `
            <div class="badge-stripe">
                <div class="badge-photo-wrap">
                    ${agentPhotoSrc ? `<img src="${agentPhotoSrc}" alt="">` : `<span class="photo-placeholder">👤</span>`}
                </div>
                <div class="badge-top-info">
                    <div class="badge-company" id="pv-company">${esc(company)}</div>
                </div>
                <div class="badge-logo-area">
                    ${logoSrc ? `<img src="${logoSrc}" alt="">` : ''}
                </div>
            </div>
            <div class="badge-body">
                <div class="badge-name" id="pv-name">${esc(name)}</div>
                <div class="badge-role" id="pv-role">${esc(role)}</div>
                <div class="badge-info-row">
                    <div class="badge-info-item"><div class="badge-info-icon">📞</div><span id="pv-phone">${esc(phone)}</span></div>
                    <div class="badge-info-item"><div class="badge-info-icon">✉️</div><span id="pv-email">${esc(email)}</span></div>
                </div>
            </div>
            <div class="badge-id-strip">
                <span class="badge-id-text">ID :</span>
                <span class="badge-id-val" id="pv-id">${esc(idVal)}</span>
            </div>`;
        } else if (currentTpl === 'tpl-dark') {
            html = `
            <div class="badge-left-col">
                <div class="badge-photo-wrap">
                    ${agentPhotoSrc ? `<img src="${agentPhotoSrc}" alt="">` : `<span class="photo-placeholder">👤</span>`}
                </div>
                <div class="badge-id-chip">${esc(idVal)}</div>
            </div>
            <div class="badge-right-col">
                <div class="badge-logo-area">
                    ${logoSrc ? `<img src="${logoSrc}" alt="">` : ''}
                </div>
                <div class="badge-main">
                    <div class="badge-role">${esc(role)}</div>
                    <div class="badge-name">${esc(name)}</div>
                    <div class="badge-company">${esc(company)}</div>
                    <div class="badge-accent"></div>
                    <div class="badge-info-row">
                        <div class="badge-info-item"><span class="badge-info-icon">📞</span><span>${esc(phone)}</span></div>
                        <div class="badge-info-item"><span class="badge-info-icon">✉️</span><span>${esc(email)}</span></div>
                    </div>
                </div>
            </div>`;
        } else if (currentTpl === 'tpl-minimal') {
            html = `
            <div class="badge-top-bar"></div>
            <div class="badge-content">
                <div class="badge-left">
                    <div class="badge-photo-wrap">
                        ${agentPhotoSrc ? `<img src="${agentPhotoSrc}" alt="">` : `<span class="photo-placeholder">👤</span>`}
                    </div>
                    <div class="badge-id-chip">${esc(idVal)}</div>
                    <div class="badge-logo-min">${logoSrc ? `<img src="${logoSrc}" alt="">` : ''}</div>
                </div>
                <div class="badge-right">
                    <div class="badge-company">${esc(company)}</div>
                    <div>
                        <div class="badge-name">${esc(name)}</div>
                        <div class="badge-role">${esc(role)}</div>
                    </div>
                    <div>
                        <div class="badge-divider"></div>
                        <div class="badge-info-row">
                            <div class="badge-info-item"><span class="badge-info-icon">📞</span><span>${esc(phone)}</span></div>
                            <div class="badge-info-item"><span class="badge-info-icon">✉️</span><span>${esc(email)}</span></div>
                        </div>
                    </div>
                </div>
            </div>`;
        }

        inner.className = `badge-preview-inner ${currentTpl}`;
        inner.innerHTML = html;
        applyAccent();
    }

    function esc(str) {
        return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    // ===== Téléchargement PNG via html2canvas =====
    document.getElementById('btn-download').addEventListener('click', async () => {
        const btn = document.getElementById('btn-download');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Génération...';
        btn.disabled = true;

        try {
            // Charger html2canvas si pas encore chargé
            if (typeof html2canvas === 'undefined') {
                await loadScript('https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js');
            }

            const canvas = await html2canvas(inner, {
                scale: 2.52,
                useCORS: true,
                allowTaint: true,
                backgroundColor: null,
                logging: false,
                width: 856,
                height: 540,
            });

            const link = document.createElement('a');
            const name = document.getElementById('inp-name').value.trim() || 'badge-agent';
            link.download = `badge-${name.replace(/\s+/g,'-').toLowerCase()}.png`;
            link.href = canvas.toDataURL('image/png', 1.0);
            link.click();
        } catch(e) {
            alert('Erreur lors de la génération. Veuillez réessayer.');
            console.error(e);
        }

        btn.innerHTML = '<i class="fas fa-download"></i> Télécharger PNG (HD)';
        btn.disabled = false;
    });

    function loadScript(src) {
        return new Promise((resolve, reject) => {
            const s = document.createElement('script');
            s.src = src; s.onload = resolve; s.onerror = reject;
            document.head.appendChild(s);
        });
    }

    // ===== Helpers couleur =====
    function lightenHex(hex, amount) {
        let r = parseInt(hex.slice(1,3),16);
        let g = parseInt(hex.slice(3,5),16);
        let b = parseInt(hex.slice(5,7),16);
        r = Math.min(255, r + amount);
        g = Math.min(255, g + amount);
        b = Math.min(255, b + amount);
        return `rgb(${r},${g},${b})`;
    }

    function hexToRgba(hex, alpha) {
        const r = parseInt(hex.slice(1,3),16);
        const g = parseInt(hex.slice(3,5),16);
        const b = parseInt(hex.slice(5,7),16);
        return `rgba(${r},${g},${b},${alpha})`;
    }

    // Init
    applyAccent();
});
</script>
@endpush
