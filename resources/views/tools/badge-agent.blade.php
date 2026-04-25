@extends('layouts.admin')

@section('title', 'Générateur de Badge Agent')

@section('breadcrumb')
    <li class="breadcrumb-item"><i class="fas fa-tools me-1"></i>Outils</li>
    <li class="breadcrumb-item active">Badge Agent</li>
@endsection

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Righteous&family=Dancing+Script:wght@600&family=Roboto+Mono:wght@400;700&display=swap');

:root {
    --ce-primary: #2196F3;
    --ce-gradient: linear-gradient(135deg, #667eea, #764ba2);
    --ce-bg: #f8fafc;
    --ce-card-bg: #ffffff;
    --ce-text: #1e293b;
    --ce-text-dim: #64748b;
    --ce-border: #e2e8f0;
}

.badge-wrap {
    font-family: 'Poppins', sans-serif;
    color: var(--ce-text);
    padding: 24px;
}

@media (max-width: 576px) {
    .badge-wrap { padding: 12px 0; }
}


.badge-header {
    margin-bottom: 32px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.badge-header h1 {
    font-size: 1.75rem;
    font-weight: 800;
    margin: 0;
    display: flex; align-items: center; gap: 12px;
}

.badge-header h1 span {
    font-family: 'Righteous', cursive;
    background: var(--ce-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.badge-editor {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 32px;
    align-items: start;
}

.ce-card {
    background: var(--ce-card-bg);
    border-radius: 20px;
    border: 1px solid var(--ce-border);
    padding: 24px;
    margin-bottom: 24px;
}

@media (max-width: 768px) {
    .ce-card { padding: 16px; border-radius: 12px; }
}


.ce-card h3 {
    font-size: 1rem;
    font-weight: 700;
    margin: 0 0 20px;
    display: flex; align-items: center; gap: 10px; color: var(--ce-primary);
}

.form-label {
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--ce-text-dim);
    text-transform: uppercase;
    margin-bottom: 6px;
}

.form-control {
    border: 1.5px solid var(--ce-border);
    border-radius: 12px;
    padding: 10px 14px;
    font-size: 0.9rem;
    background: #fbfcfe;
    transition: all .2s;
    width: 100%;
}

.form-control:focus { outline: none; border-color: var(--ce-primary); background: #fff; }

.template-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

.template-btn {
    border: 2px solid var(--ce-border);
    border-radius: 14px;
    padding: 14px;
    cursor: pointer;
    background: #fff;
    transition: all .2s;
    display: flex;
    align-items: center;
    gap: 12px;
}

.template-btn.active { border-color: var(--ce-primary); background: #f0f7ff; }
.template-btn i { font-size: 1.4rem; color: #cbd5e1; }
.template-btn.active i { color: var(--ce-primary); }
.template-btn .tpl-name { display: block; font-weight: 700; font-size: 0.9rem; }
.template-btn .tpl-type { font-size: 0.7rem; color: #94a3b8; text-transform: uppercase; }

/* Preview Frame */
.badge-preview-wrap { position: sticky; top: 100px; }

.badge-preview-frame {
    margin: 0 auto;
    border-radius: 24px;
    box-shadow: 0 30px 60px -12px rgba(0,0,0,0.25);
    overflow: hidden;
    position: relative;
    background: #fff;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.badge-preview-frame.landscape { width: 340px; height: 214px; }
.badge-preview-frame.portrait { width: 214px; height: 340px; }

@media (max-width: 480px) {
    .badge-preview-wrap { display: flex; flex-direction: column; align-items: center; }
    .badge-preview-frame.landscape { transform: scale(0.9); }
    .badge-preview-frame.portrait { transform: scale(0.9); }
}

@media (max-width: 360px) {
    .badge-preview-frame.landscape { transform: scale(0.8); margin-bottom: -15px; }
    .badge-preview-frame.portrait { transform: scale(0.8); margin-bottom: -15px; }
}


.badge-preview-inner {
    position: absolute;
    top: 0; left: 0;
    transform-origin: top left;
}

.badge-preview-frame.landscape .badge-preview-inner { width: 856px; height: 540px; transform: scale(0.3972); }
.badge-preview-frame.portrait .badge-preview-inner { width: 540px; height: 856px; transform: scale(0.3963); }

/* CONTENT BLOCKS */

/* Landscape Templates (Modern / Dark) */
.tpl-landscape { width: 856px; height: 540px; background: #fff; position: relative; overflow: hidden; display: flex; flex-direction: column; }

.l-header { height: 160px; display: flex; align-items: center; padding: 0 40px; position: relative; }
.l-photo { width: 170px; height: 170px; border-radius: 50%; border: 8px solid #fff; box-shadow: 0 10px 30px rgba(0,0,0,0.1); position: absolute; left: 40px; bottom: -50px; background: #eee; overflow: hidden; z-index: 2; }
.l-photo img { width: 100%; height: 100%; object-fit: cover; }
.l-company { font-size: 28px; font-weight: 800; color: #fff; margin-left: 200px; text-transform: uppercase; letter-spacing: 1px; }
.l-logo { margin-left: auto; max-height: 80px; max-width: 150px; object-fit: contain; }

.l-body { flex: 1; padding: 70px 40px 40px; }
.l-name { font-size: 48px; font-weight: 800; line-height: 1.1; margin-bottom: 5px; }
.l-role { font-size: 24px; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 30px; }
.l-info { display: flex; flex-direction: column; gap: 10px; font-size: 20px; font-weight: 500; }
.l-info-item { display: flex; align-items: center; gap: 12px; }

.l-strip { height: 60px; display: flex; align-items: center; padding: 0 40px; color: #fff; font-weight: 800; font-size: 22px; font-family: 'Roboto Mono', monospace; letter-spacing: 2px; }

.l-sig { position: absolute; bottom: 80px; right: 50px; text-align: center; }

/* Portrait Template (Vertical) */
.tpl-portrait { width: 540px; height: 856px; background: #fff; display: flex; flex-direction: column; align-items: center; padding: 50px 40px; position: relative; }
.v-logo { height: 75px; margin-bottom: 40px; }
.v-photo { width: 320px; height: 320px; border-radius: 30px; overflow: hidden; border: 10px solid #f8fafc; box-shadow: 0 15px 40px rgba(0,0,0,0.1); margin-bottom: 40px; background: #eee; }
.v-photo img { width: 100%; height: 100%; object-fit: cover; }
.v-name { font-size: 48px; font-weight: 900; line-height: 1.1; text-align: center; margin-bottom: 8px; color: #0f172a; }
.v-role { font-size: 24px; font-weight: 700; text-transform: uppercase; letter-spacing: 3px; text-align: center; margin-bottom: 30px; }
.v-strip { width: 100%; height: 70px; display: flex; align-items: center; justify-content: center; border-radius: 16px; color: #fff; font-family: 'Roboto Mono', monospace; font-size: 24px; font-weight: 800; margin-bottom: 40px; }
.v-info { display: flex; flex-direction: column; gap: 12px; font-size: 20px; font-weight: 600; color: #64748b; }
.v-sig { margin-top: auto; text-align: center; padding-bottom: 20px; }

/* SIGNATURES */
.sig-text { font-family: 'Dancing Script', cursive; font-size: 42px; color: #0f172a; margin-bottom: 0; }
.sig-img { max-height: 80px; filter: contrast(1.5) brightness(0.2); }
.sig-label { font-size: 15px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; }

.color-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 10px; }
.color-swatch { aspect-ratio: 1; border-radius: 12px; border: 3px solid transparent; cursor: pointer; transition: transform .15s; }
.color-swatch:hover { transform: scale(1.1); }
.color-swatch.active { border-color: #0f172a; }

.btn-download { width: 100%; padding: 16px; border-radius: 16px; background: var(--ce-gradient); color: #fff; border: none; font-weight: 800; font-size: 1rem; cursor: pointer; display: flex; justify-content: center; gap: 12px; box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.4); }

@media (max-width: 992px) {
    .badge-editor { grid-template-columns: 1fr; }
    .preview-col { order: -1; margin-bottom: 32px; }
    .badge-preview-wrap { position: static; }
}


@media (max-width: 576px) {
    .template-grid { grid-template-columns: 1fr; }
    .badge-header h1 { font-size: 1.4rem; }
}

</style>

<div class="badge-wrap">
    <div class="badge-header">
        <h1><i class="fas fa-id-card"></i> <span>Badge Agent Tool</span></h1>
        <div class="badge-certified"><i class="fas fa-magic"></i> Version Premium</div>
    </div>

    <div class="badge-editor">
        <div class="form-col">
            {{-- Format selection --}}
            <div class="ce-card">
                <h3><i class="fas fa-layer-group"></i> Format du badge</h3>
                <div class="template-grid">
                    <button class="template-btn active" data-tpl="tpl-modern" data-layout="landscape">
                        <i class="fas fa-id-badge"></i>
                        <div><span class="tpl-name">Modern Horizontal</span><span class="tpl-type">Paysage</span></div>
                    </button>
                    <button class="template-btn" data-tpl="tpl-vertical" data-layout="portrait">
                        <i class="fas fa-portrait"></i>
                        <div><span class="tpl-name">Professionnel Vertical</span><span class="tpl-type">Portrait</span></div>
                    </button>
                    <button class="template-btn" data-tpl="tpl-dark" data-layout="landscape">
                        <i class="fas fa-moon"></i>
                        <div><span class="tpl-name">Dark Horizontal</span><span class="tpl-type">Paysage</span></div>
                    </button>
                </div>
            </div>

            {{-- Fields --}}
            <div class="ce-card">
                <h3><i class="fas fa-user-edit"></i> Détails de l'agent</h3>
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Prénom & Nom</label><input id="inp-name" class="form-control" placeholder="JEAN DUPONT"></div>
                    <div class="col-md-6"><label class="form-label">Poste / Rôle</label><input id="inp-role" class="form-control" placeholder="AGENT COMMERCIAL"></div>
                    <div class="col-md-6"><label class="form-label">Société</label><input id="inp-company" class="form-control" placeholder="FLASHBILAN SAS"></div>
                    <div class="col-md-6"><label class="form-label">Identifiant AGT</label><input id="inp-id" class="form-control" placeholder="AGT-2024-001"></div>
                    <div class="col-md-6"><label class="form-label">Téléphone</label><input id="inp-phone" class="form-control" placeholder="+33 6 00 00 00 00"></div>
                    <div class="col-md-6"><label class="form-label">Email</label><input id="inp-email" class="form-control" placeholder="agent@flashbilan.fr"></div>
                </div>
            </div>

            {{-- Signature --}}
            <div class="ce-card">
                <h3><i class="fas fa-signature"></i> Signature</h3>
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Signature (Texte)</label><input id="inp-sig-text" class="form-control" placeholder="Jean Gem"></div>
                    <div class="col-md-6"><label class="form-label">Importer Scan</label><input type="file" id="inp-sig-file" class="form-control"></div>
                </div>
            </div>

            {{-- Médias --}}
            <div class="ce-card">
                <h3><i class="fas fa-camera"></i> Photos & Logos</h3>
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Photo d'identité</label><input type="file" id="inp-photo" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label">Logo Entreprise</label><input type="file" id="inp-logo" class="form-control"></div>
                </div>
            </div>

            {{-- Colors --}}
            <div class="ce-card">
                <h3><i class="fas fa-palette"></i> Couleur Accent</h3>
                <div class="color-grid">
                    <div class="color-swatch active" data-color="#2196F3" style="background:#2196F3;"></div>
                    <div class="color-swatch" data-color="#4CAF50" style="background:#4CAF50;"></div>
                    <div class="color-swatch" data-color="#F44336" style="background:#F44336;"></div>
                    <div class="color-swatch" data-color="#9C27B0" style="background:#9C27B0;"></div>
                    <div class="color-swatch" data-color="#1e293b" style="background:#1e293b;"></div>
                </div>
            </div>
        </div>

        <div class="preview-col">
            <div class="badge-preview-wrap">
                <div class="badge-preview-frame landscape" id="badge-frame">
                    <div class="badge-preview-inner" id="badge-inner"></div>
                </div>
                <button class="btn-download" id="btn-download"><i class="fas fa-download"></i> Enregistrer HD (PNG)</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    let state = {
        tpl: 'tpl-modern',
        layout: 'landscape',
        accent: '#2196F3',
        name: 'JEAN DUPONT',
        role: 'AGENT COMMERCIAL',
        company: 'FLASHBILAN SAS',
        id: 'AGT-2024-001',
        phone: '+33 6 00 00 00 00',
        email: 'agent@flashbilan.fr',
        photo: null,
        logo: null,
        sigImg: null,
        sigText: 'Jean Gem'
    };

    const inner = document.getElementById('badge-inner');
    const frame = document.getElementById('badge-frame');

    const updatePreview = () => {
        let html = '';
        const esc = s => s.toUpperCase().replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
        const escRaw = s => s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');

        const sigHtml = `
            <div class="sig-block">
                ${state.sigImg ? `<img src="${state.sigImg}" class="sig-img">` : `<p class="sig-text">${state.sigText}</p>`}
                <div class="sig-label">Signature du titulaire</div>
            </div>
        `;

        if (state.layout === 'portrait') {
            html = `
                <div class="tpl-portrait" style="border-top: 15px solid ${state.accent};">
                    <div class="v-logo">${state.logo ? `<img src="${state.logo}" style="max-height:100%;">` : ''}</div>
                    <div class="v-photo">${state.photo ? `<img src="${state.photo}">` : `<i class="fas fa-user" style="font-size:100px;color:#ccc;margin-top:100px;"></i>`}</div>
                    <div class="v-name">${esc(state.name)}</div>
                    <div class="v-role" style="color: ${state.accent}">${esc(state.role)}</div>
                    <div class="v-strip" style="background: ${state.accent}">ID: ${esc(state.id)}</div>
                    <div class="v-info">
                        <div><i class="fas fa-phone"></i> ${state.phone}</div>
                        <div><i class="fas fa-envelope"></i> ${state.email}</div>
                    </div>
                    <div class="v-sig">${sigHtml}</div>
                </div>
            `;
        } else {
            let isDark = state.tpl === 'tpl-dark';
            html = `
                <div class="tpl-landscape" style="background: ${isDark ? '#0f172a' : '#fff'}; color: ${isDark ? '#fff' : '#1e293b'};">
                    <div class="l-header" style="background: ${isDark ? '#1e293b' : `linear-gradient(135deg, ${state.accent}, ${state.accent}cc)`};">
                        <div class="l-photo">${state.photo ? `<img src="${state.photo}">` : `<i class="fas fa-user" style="font-size:80px;color:#ccc;margin:45px 0 0 45px;"></i>`}</div>
                        <div class="l-company">${esc(state.company)}</div>
                        <div class="l-logo">${state.logo ? `<img src="${state.logo}" style="filter: ${isDark ? 'brightness(0) invert(1)' : 'grayscale(1) brightness(5)'};">` : ''}</div>
                    </div>
                    <div class="l-body">
                        <div class="l-name">${esc(state.name)}</div>
                        <div class="l-role" style="color: ${state.accent}">${esc(state.role)}</div>
                        <div class="l-info">
                            <div class="l-info-item"><i class="fas fa-phone" style="width:24px;color:${state.accent};"></i> ${state.phone}</div>
                            <div class="l-info-item"><i class="fas fa-envelope" style="width:24px;color:${state.accent};"></i> ${state.email}</div>
                        </div>
                    </div>
                    <div class="l-sig">${sigHtml}</div>
                    <div class="l-strip" style="background: ${state.accent};">ID BADGE : ${esc(state.id)}</div>
                </div>
            `;
        }

        inner.innerHTML = html;
        frame.className = `badge-preview-frame ${state.layout}`;
    };

    // Events
    ['name', 'role', 'company', 'id', 'phone', 'email'].forEach(f => {
        document.getElementById('inp-'+f).addEventListener('input', e => { state[f] = e.target.value; updatePreview(); });
    });

    document.getElementById('inp-sig-text').addEventListener('input', e => {
        state.sigText = e.target.value || 'Jean Gem';
        state.sigImg = null;
        updatePreview();
    });

    const bindFile = (id, key) => {
        document.getElementById(id).addEventListener('change', function() {
            if (!this.files[0]) return;
            const r = new FileReader(); r.onload = e => { state[key] = e.target.result; updatePreview(); }; r.readAsDataURL(this.files[0]);
        });
    }
    bindFile('inp-photo', 'photo'); bindFile('inp-logo', 'logo'); bindFile('inp-sig-file', 'sigImg');

    document.querySelectorAll('.template-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.template-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            state.tpl = btn.dataset.tpl;
            state.layout = btn.dataset.layout;
            updatePreview();
        });
    });

    document.querySelectorAll('.color-swatch').forEach(s => {
        s.addEventListener('click', () => {
            document.querySelectorAll('.color-swatch').forEach(x => x.classList.remove('active'));
            s.classList.add('active');
            state.accent = s.dataset.color;
            updatePreview();
        });
    });

    document.getElementById('btn-download').addEventListener('click', async () => {
        const btn = document.getElementById('btn-download');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Génération...';
        const w = state.layout === 'landscape' ? 856 : 540;
        const h = state.layout === 'landscape' ? 540 : 856;
        const canvas = await html2canvas(inner.firstChild, { scale: 3, width: w, height: h });
        const link = document.createElement('a');
        link.download = `badge-${state.name.replace(/\s+/g,'-').toLowerCase()}.png`;
        link.href = canvas.toDataURL(); link.click();
        btn.innerHTML = '<i class="fas fa-download"></i> Enregistrer HD (PNG)';
    });

    updatePreview();
});
</script>
@endpush
