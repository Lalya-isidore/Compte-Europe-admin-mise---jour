@extends('layouts.admin')

@section('title', 'Générateur de Badge Agent Multi-Format')

@section('breadcrumb')
    <li class="breadcrumb-item"><i class="fas fa-tools me-1"></i>Outils</li>
    <li class="breadcrumb-item active">Badge Agent</li>
@endsection

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Righteous&family=Dancing+Script:wght@600&family=Roboto+Mono:wght@400;700&family=Inter:wght@400;700;900&display=swap');

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
    grid-template-columns: 1fr 400px;
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
    display: flex; align-items: center; gap: 8px; color: var(--ce-primary);
}

.form-label {
    font-size: 0.78rem;
    font-weight: 700;
    color: var(--ce-text-dim);
    text-transform: uppercase;
    margin-bottom: 4px;
}

.form-control {
    border: 1.5px solid var(--ce-border);
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 0.88rem;
    background: #fafafa;
    transition: all .2s;
    width: 100%;
}

.form-control:focus { outline: none; border-color: var(--ce-primary); background: #fff; }

.template-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
}

.template-btn {
    border: 2px solid var(--ce-border);
    border-radius: 12px;
    padding: 12px 8px;
    cursor: pointer;
    background: #fafafa;
    transition: all .2s;
    text-align: left;
    display: flex;
    align-items: center;
    gap: 10px;
}

.template-btn:hover { border-color: var(--ce-primary); }
.template-btn.active { border-color: var(--ce-primary); background: #e3f2fd; }
.template-btn i { font-size: 1.2rem; }
.template-btn .tpl-info { display: flex; flex-direction: column; }
.template-btn .tpl-name { font-weight: 700; font-size: 0.85rem; }
.template-btn .tpl-type { font-size: 0.65rem; color: #888; text-transform: uppercase; }

/* Preview Frame */
.badge-preview-wrap { position: sticky; top: 8rem; }

.frame-container {
    perspective: 1000px;
    margin-bottom: 20px;
}

.badge-preview-frame {
    margin: 0 auto;
    border-radius: 12px;
    box-shadow: 0 20px 60px rgba(0,0,0,.2);
    overflow: hidden;
    position: relative;
    background: #fff;
    transition: width 0.3s, height 0.3s;
}

/* Orientation helpers */
.badge-preview-frame.landscape { width: 340px; height: 214px; }
.badge-preview-frame.portrait { width: 214px; height: 340px; }

.badge-preview-inner {
    position: absolute;
    top: 0; left: 0;
    transform-origin: top left;
}

/* Aspect transformations */
.badge-preview-frame.landscape .badge-preview-inner {
    width: 856px; height: 540px;
    transform: scale(0.3972); /* 340/856 */
}

.badge-preview-frame.portrait .badge-preview-inner {
    width: 540px; height: 856px;
    transform: scale(0.3963); /* 214/540 */
}

/* === SIGNATURE SHARED === */
.sig-box {
    position: absolute;
    display: flex; flex-direction: column; align-items: center;
}
.sig-text { font-family: 'Dancing Script', cursive; font-size: 34px; color: #111; }
.sig-img { max-height: 60px; object-fit: contain; filter: brightness(0.2); }
.sig-label { font-size: 14px; color: #888; margin-top: 4px; font-weight: 600; }

/* === TEMPLATE: CNI (Landscape) === */
.tpl-cni {
    background-image: url('{{ asset('images/tools/cni-bg.png') }}');
    background-size: cover;
    font-family: 'Inter', sans-serif;
}
.tpl-cni .cni-header { display: flex; justify-content: space-between; padding: 20px 40px; }
.tpl-cni .cni-title { text-align: center; }
.tpl-cni .cni-title h2 { font-size: 32px; font-weight: 900; margin: 0; }
.tpl-cni .cni-title p { font-size: 18px; font-weight: 700; margin: 0; opacity: 0.8; }
.tpl-cni .cni-flag { width: 80px; height: 55px; background: linear-gradient(to right, #002395 33%, #fff 33%, #fff 66%, #ed2939 66%); border-radius: 4px; }
.tpl-cni .cni-seal { width: 90px; height: 90px; background: url('{{ asset('images/tools/cni-rf-seal.png') }}') no-repeat; background-size: contain; }
.tpl-cni .cni-body { display: grid; grid-template-columns: 240px 1fr; padding: 0 40px; gap: 30px; }
.tpl-cni .cni-photo { width: 230px; height: 290px; object-fit: cover; background: #eee; }
.tpl-cni .cni-fields { font-size: 18px; line-height: 1.3; }
.tpl-cni .cni-label { color: #4b628a; font-weight: 700; margin-right: 8px; font-size: 16px; }
.tpl-cni .cni-value { font-weight: 900; text-transform: uppercase; }
.tpl-cni .sig-box { bottom: 40px; right: 60px; }

/* === TEMPLATE: MODERN (Landscape) === */
.tpl-modern { background: #fff; }
.tpl-modern .m-top { height: 160px; display: flex; align-items: flex-end; padding: 0 40px 20px; color: #fff; }
.tpl-modern .m-photo { width: 140px; height: 140px; border-radius: 50%; border: 6px solid #fff; position: relative; margin-bottom: -40px; background: #eee; overflow: hidden; }
.tpl-modern .m-photo img { width: 100%; height: 100%; object-fit: cover; }
.tpl-modern .m-body { padding: 60px 40px; }
.tpl-modern .m-name { font-size: 40px; font-weight: 800; }
.tpl-modern .m-role { font-size: 22px; font-weight: 600; margin-bottom: 20px; }
.tpl-modern .m-info { font-size: 18px; display: flex; flex-direction: column; gap: 8px; color: #667eea; }
.tpl-modern .m-strip { position: absolute; bottom: 0; left: 0; right: 0; height: 50px; display: flex; align-items: center; padding: 0 40px; color: #fff; font-weight: 700; font-size: 18px; }
.tpl-modern .sig-box { bottom: 80px; right: 60px; }

/* === TEMPLATE: VERTICAL (Portrait) === */
.tpl-vertical { background: #fff; width: 540px; height: 856px; display: flex; flex-direction: column; align-items: center; padding: 40px; }
.tpl-vertical .v-logo { height: 60px; margin-bottom: 30px; }
.tpl-vertical .v-photo { width: 300px; height: 300px; border-radius: 20px; overflow: hidden; border: 8px solid #eee; margin-bottom: 30px; }
.tpl-vertical .v-photo img { width: 100%; height: 100%; object-fit: cover; }
.tpl-vertical .v-name { font-size: 44px; font-weight: 800; color: #111; text-align: center; }
.tpl-vertical .v-role { font-size: 24px; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 40px; }
.tpl-vertical .v-id-strip { background: #111; color: #fff; width: 100%; padding: 15px; text-align: center; border-radius: 12px; font-family: monospace; font-size: 22px; margin-bottom: 40px; }
.tpl-vertical .v-info { display: flex; flex-direction: column; align-items: center; gap: 10px; color: #666; font-size: 18px; }
.tpl-vertical .sig-box { bottom: 40px; position: absolute; }

.btn-download { width: 100%; padding: 14px; border-radius: 12px; background: var(--ce-gradient); color: #fff; border:none; font-weight: 700; cursor: pointer; display:flex; justify-content: center; gap: 10px; margin-top: 10px; }

@media (max-width: 900px) {
    .badge-editor { grid-template-columns: 1fr; }
}
</style>

<div class="badge-wrap">
    <div class="badge-header">
        <h1><i class="fas fa-id-card"></i> <span>Badge Suite</span></h1>
        <div class="badge-certified"><i class="fas fa-magic"></i> Multi-Format Ready</div>
    </div>

    <div class="badge-editor">
        <div class="badge-form-col">
            {{-- Template Selector --}}
            <div class="ce-card">
                <h3><i class="fas fa-th-large"></i> Sélectionner le format & style</h3>
                <div class="template-grid">
                    <button class="template-btn active" data-tpl="tpl-modern" data-layout="landscape">
                        <i class="fas fa-id-badge text-primary"></i>
                        <div class="tpl-info">
                            <span class="tpl-name">Agent Modern</span>
                            <span class="tpl-type">Paysage • Classic</span>
                        </div>
                    </button>
                    <button class="template-btn" data-tpl="tpl-vertical" data-layout="portrait">
                        <i class="fas fa-portrait text-success"></i>
                        <div class="tpl-info">
                            <span class="tpl-name">Agent Portrait</span>
                            <span class="tpl-type">Vertical • Pro</span>
                        </div>
                    </button>
                    <button class="template-btn" data-tpl="tpl-dark" data-layout="landscape">
                        <i class="fas fa-moon text-dark"></i>
                        <div class="tpl-info">
                            <span class="tpl-name">Agent Dark</span>
                            <span class="tpl-type">Paysage • Dark</span>
                        </div>
                    </button>
                    <button class="template-btn" data-tpl="tpl-cni" data-layout="landscape">
                        <i class="fas fa-passport text-danger"></i>
                        <div class="tpl-info">
                            <span class="tpl-name">Type CNI FR</span>
                            <span class="tpl-type">Paysage • Officiel</span>
                        </div>
                    </button>
                </div>
            </div>

            {{-- Form Fields --}}
            <div class="ce-card">
                <h3><i class="fas fa-user-edit"></i> Données d'identité</h3>
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Nom Complet</label><input id="inp-name" class="form-control" placeholder="Jean Dupont"></div>
                    <div class="col-md-6"><label class="form-label">Poste / Rôle</label><input id="inp-role" class="form-control" placeholder="Agent Commercial"></div>
                    <div class="col-md-6"><label class="form-label">Structure / Agence</label><input id="inp-company" class="form-control" placeholder="FlashBilan SAS"></div>
                    <div class="col-md-6"><label class="form-label">Identifiant Badge</label><input id="inp-id" class="form-control" placeholder="AGT-2026-042"></div>
                    <div class="col-md-6"><label class="form-label">Téléphone</label><input id="inp-phone" class="form-control" placeholder="+33 6 01 02 03 04"></div>
                    <div class="col-md-6"><label class="form-label">Email</label><input id="inp-email" class="form-control" placeholder="contact@agence.fr"></div>
                </div>
            </div>

            {{-- Signature Option --}}
            <div class="ce-card">
                <h3><i class="fas fa-signature"></i> Signature</h3>
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Signature (Texte)</label><input id="inp-sig-text" class="form-control" placeholder="Jean Gem"></div>
                    <div class="col-md-6"><label class="form-label">Scan Signature</label><input type="file" id="inp-sig-file" class="form-control"></div>
                </div>
            </div>

            {{-- Photo & Logo --}}
            <div class="ce-card">
                <h3><i class="fas fa-images"></i> Médias</h3>
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Photo d'identité</label><input type="file" id="inp-photo" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label">Logo Entreprise</label><input type="file" id="inp-logo" class="form-control"></div>
                </div>
            </div>

            {{-- Accent Color --}}
            <div class="ce-card">
                <h3><i class="fas fa-palette"></i> Couleur Accent</h3>
                <div class="color-grid">
                    <div class="color-swatch active" data-color="#2196F3" style="background:#2196F3;"></div>
                    <div class="color-swatch" data-color="#4CAF50" style="background:#4CAF50;"></div>
                    <div class="color-swatch" data-color="#F44336" style="background:#F44336;"></div>
                    <div class="color-swatch" data-color="#9C27B0" style="background:#9C27B0;"></div>
                    <div class="color-swatch" data-color="#333333" style="background:#333333;"></div>
                </div>
            </div>
        </div>

        <div class="cni-preview-col">
            <div class="badge-preview-wrap">
                <div class="frame-container">
                    <div class="badge-preview-frame landscape" id="badge-frame">
                        <div class="badge-preview-inner tpl-modern" id="badge-inner"></div>
                    </div>
                </div>
                <button class="btn-download" id="btn-download"><i class="fas fa-download"></i> Enregistrer en PNG</button>
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
        role: 'Agent Commercial',
        company: 'FlashBilan SAS',
        id: 'AGT-2026-042',
        phone: '+33 6 01 02 03 04',
        email: 'contact@agence.fr',
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

        const sigHtml = `<div class="sig-box">
            ${state.sigImg ? `<img src="${state.sigImg}" class="sig-img">` : `<span class="sig-text">${state.sigText}</span>`}
            <div class="sig-label">Signature du titulaire</div>
        </div>`;

        if (state.tpl === 'tpl-cni') {
            html = `
                <div class="cni-header">
                    <div class="cni-flag"></div>
                    <div class="cni-title">
                        <h2>RÉPUBLIQUE FRANÇAISE</h2>
                        <p>CARTE D'IDENTITÉ - DOCUMENT OFFICIEL</p>
                    </div>
                    <div class="cni-seal"></div>
                </div>
                <div class="cni-body">
                    <div class="cni-photo-wrap">${state.photo ? `<img src="${state.photo}" class="cni-photo">` : `<div class="cni-photo" style="background:#ddd;display:flex;align-items:center;justify-content:center;font-size:100px;color:#ccc;"><i class="fas fa-user"></i></div>`}</div>
                    <div class="cni-fields">
                        <div><span class="cni-label">NOM :</span><span class="cni-value">${esc(state.name)}</span></div>
                        <div><span class="cni-label">PRÉNOMS :</span><span class="cni-value">${esc(state.role)}</span></div>
                        <div><span class="cni-label">SOCIÉTÉ :</span><span class="cni-value">${esc(state.company)}</span></div>
                        <div><span class="cni-label">ID :</span><span class="cni-value">${esc(state.id)}</span></div>
                        <div><span class="cni-label">TEL :</span><span class="cni-value">${state.phone}</span></div>
                    </div>
                </div>
                ${sigHtml}
            `;
        } else if (state.tpl === 'tpl-vertical') {
            html = `
                <div class="v-logo">${state.logo ? `<img src="${state.logo}" style="height:100%;">` : ''}</div>
                <div class="v-photo">${state.photo ? `<img src="${state.photo}">` : `<div style="width:100%;height:100%;background:#eee;display:flex;align-items:center;justify-content:center;font-size:120px;color:#ccc;"><i class="fas fa-user"></i></div>`}</div>
                <div class="v-name">${esc(state.name)}</div>
                <div class="v-role" style="color: ${state.accent}">${esc(state.role)}</div>
                <div class="v-id-strip" style="background: ${state.accent}">${esc(state.id)}</div>
                <div class="v-info">
                    <span><i class="fas fa-phone"></i> ${state.phone}</span>
                    <span><i class="fas fa-envelope"></i> ${state.email}</span>
                </div>
                ${sigHtml}
            `;
        } else {
            // Modern / Dark Horizontal
            let isDark = state.tpl === 'tpl-dark';
            html = `
                <div class="m-top" style="background: ${isDark ? '#1e293b' : `linear-gradient(135deg, ${state.accent}, ${state.accent}cc)`};">
                    <div class="m-photo">${state.photo ? `<img src="${state.photo}">` : `<i class="fas fa-user" style="font-size:3.5rem;color:#ccc;position:absolute;top:50%;left:50%;transform:translate(-50%,-50%)"></i>`}</div>
                    <div style="margin-left: 170px; margin-bottom: 30px;">
                        <div style="font-size: 24px; font-weight: 800;">${esc(state.company)}</div>
                    </div>
                    <div style="margin-left: auto;">
                        ${state.logo ? `<img src="${state.logo}" style="max-height: 60px; filter: ${isDark ? 'brightness(0) invert(1)' : 'grayscale(1) brightness(2)'};">` : ''}
                    </div>
                </div>
                <div class="m-body" style="background: ${isDark ? '#0f172a' : '#fff'}; color: ${isDark ? '#fff' : '#333'};">
                    <div class="m-name">${esc(state.name)}</div>
                    <div class="m-role" style="color: ${state.accent}">${esc(state.role)}</div>
                    <div class="m-info">
                        <span style="color: ${isDark ? '#94a3b8' : state.accent}">📞 ${state.phone}</span>
                        <span style="color: ${isDark ? '#94a3b8' : state.accent}">✉️ ${state.email}</span>
                    </div>
                    ${sigHtml}
                </div>
                <div class="m-strip" style="background: ${state.accent}">ID BADGE : ${state.id}</div>
            `;
        }

        inner.className = `badge-preview-inner ${state.tpl}`;
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
        const canvas = await html2canvas(inner, { scale: 2.5, width: w, height: h });
        const link = document.createElement('a');
        link.download = `badge-${state.name.replace(/\s+/g,'-').toLowerCase()}.png`;
        link.href = canvas.toDataURL(); link.click();
        btn.innerHTML = '<i class="fas fa-download"></i> Enregistrer en PNG';
    });

    updatePreview();
});
</script>
@endpush
