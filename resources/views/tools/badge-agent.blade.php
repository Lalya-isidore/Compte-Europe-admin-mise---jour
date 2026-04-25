@extends('layouts.admin')

@section('title', 'Générateur de Badge Agent Pro')

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
    padding: 0 15px;
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
    .ce-card { padding: 16px; border-radius: 12px; margin-bottom: 16px; }
}

.ce-card h3 {
    font-size: 1.1rem;
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

.form-control, .form-select {
    border: 1.5px solid var(--ce-border);
    border-radius: 12px;
    padding: 10px 14px;
    font-size: 0.9rem;
    background: #fbfcfe;
    transition: all .2s;
    width: 100%;
}

.form-control:focus, .form-select:focus { outline: none; border-color: var(--ce-primary); background: #fff; }

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

.tpl-landscape { width: 856px; height: 540px; background: #fff; position: relative; overflow: hidden; display: flex; flex-direction: column; }
.l-header { height: 140px; display: flex; align-items: center; padding: 0 40px; position: relative; }
.l-photo { width: 170px; height: 170px; border-radius: 50%; border: 8px solid #fff; box-shadow: 0 10px 30px rgba(0,0,0,0.1); position: absolute; left: 40px; bottom: -60px; background: #eee; overflow: hidden; z-index: 2; }
.l-photo img { width: 100%; height: 100%; object-fit: cover; }
.l-company { font-size: 26px; font-weight: 800; color: #fff; margin-left: 200px; text-transform: uppercase; }
.l-logo { margin-left: auto; max-height: 70px; }

.l-body { flex: 1; padding: 60px 40px 10px; display: grid; grid-template-columns: 1.2fr 1fr; gap: 30px; }
.l-main-info { display: flex; flex-direction: column; gap: 5px; }
.l-name { font-size: 44px; font-weight: 900; line-height: 1.1; margin-bottom: 2px; color: #0f172a; }
.l-role { font-size: 20px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 15px; }

.l-details-box { display: flex; flex-direction: column; justify-content: center; }
.l-details-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; font-size: 15px; background: #f8fafc; padding: 15px; border-radius: 12px; }

.l-det-label { font-weight: 700; color: #94a3b8; text-transform: uppercase; font-size: 12px; }
.l-det-val { font-weight: 600; color: #1e293b; }

.l-contact { font-size: 18px; display: flex; flex-direction: column; gap: 8px; font-weight: 600; color: #475569; }
.l-contact i { width: 22px; text-align: center; color: var(--ce-primary); }


.l-sig { position: absolute; bottom: 85px; right: 50px; text-align: center; }
.l-strip { height: 60px; display: flex; align-items: center; padding: 0 40px; color: #fff; font-weight: 800; font-size: 22px; font-family: 'Roboto Mono', monospace; }

/* Portrait */
.tpl-portrait { width: 540px; height: 856px; background: #fff; display: flex; flex-direction: column; align-items: center; padding: 40px 30px; position: relative; }
.v-logo { height: 65px; margin-bottom: 30px; }
.v-photo { width: 280px; height: 280px; border-radius: 20px; overflow: hidden; border: 8px solid #f8fafc; box-shadow: 0 10px 30px rgba(0,0,0,0.1); margin-bottom: 30px; }
.v-photo img { width: 100%; height: 100%; object-fit: cover; }
.v-name { font-size: 42px; font-weight: 900; text-align: center; margin-bottom: 5px; line-height: 1; }
.v-role { font-size: 20px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 25px; }
.v-strip { width: 100%; height: 65px; display: flex; align-items: center; justify-content: center; border-radius: 14px; color: #fff; font-family: 'Roboto Mono', monospace; font-size: 22px; margin-bottom: 25px; }
.v-details { width: 100%; display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 25px; background: #f8fafc; padding: 15px; border-radius: 12px; }
.v-det-item { display: flex; flex-direction: column; }
.v-det-label { font-size: 10px; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 2px; }
.v-det-val { font-size: 14px; font-weight: 700; }
.v-sig { margin-top: auto; text-align: center; }

/* Signatures */
.sig-text { font-family: 'Dancing Script', cursive; font-size: 38px; color: #0f172a; margin-bottom: 0; }
.sig-img { max-height: 70px; filter: contrast(1.5) brightness(0.2); }
.sig-label { font-size: 12px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; }

.color-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 10px; }
.color-swatch { aspect-ratio: 1; border-radius: 12px; cursor: pointer; border: 3px solid transparent; }
.color-swatch.active { border-color: #000; scale: 1.1; }

.btn-download { width: 100%; padding: 16px; border-radius: 16px; background: var(--ce-gradient); color: #fff; border: none; font-weight: 800; font-size: 1rem; cursor: pointer; display: flex; justify-content: center; gap: 12px; box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.4); margin-top: 15px; }

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
        <h1><i class="fas fa-id-badge"></i> <span>Badge Suite Pro</span></h1>
    </div>

    <div class="badge-editor">
        <div class="form-col">
            {{-- Template --}}
            <div class="ce-card">
                <h3><i class="fas fa-magic"></i> Style & Format</h3>
                <div class="template-grid">
                    <button class="template-btn active" data-tpl="tpl-modern" data-layout="landscape">
                        <i class="fas fa-id-card"></i>
                        <div><span class="tpl-name">Agent Modern</span><span class="tpl-type">Paysage</span></div>
                    </button>
                    <button class="template-btn" data-tpl="tpl-vertical" data-layout="portrait">
                        <i class="fas fa-portrait"></i>
                        <div><span class="tpl-name">Agent Portrait</span><span class="tpl-type">Vertical</span></div>
                    </button>
                    <button class="template-btn" data-tpl="tpl-dark" data-layout="landscape">
                        <i class="fas fa-moon"></i>
                        <div><span class="tpl-name">Agent Dark</span><span class="tpl-type">Paysage</span></div>
                    </button>
                </div>
            </div>

            {{-- Agent Details --}}
            <div class="ce-card">
                <h3><i class="fas fa-user-tie"></i> Informations de l'Agent</h3>
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Nom Complet</label><input id="inp-name" class="form-control" placeholder="JEAN DUPONT"></div>
                    <div class="col-md-6"><label class="form-label">Poste / Fonction</label><input id="inp-role" class="form-control" placeholder="AGENT COMMERCIAL"></div>
                    <div class="col-md-6"><label class="form-label">Service / Dépt</label><input id="inp-service" class="form-control" placeholder="VENTES"></div>
                    <div class="col-md-6"><label class="form-label">Structure / Agence</label><input id="inp-company" class="form-control" placeholder="FLASHBILAN SAS"></div>
                    <div class="col-md-6"><label class="form-label">Identifiant Badge</label><input id="inp-id" class="form-control" placeholder="AGT-2024-001"></div>
                    <div class="col-md-6"><label class="form-label">Sexe</label><select id="inp-sex" class="form-select"><option value="M">Masculin</option><option value="F">Féminin</option></select></div>
                </div>
            </div>

            {{-- Official Data --}}
            <div class="ce-card">
                <h3><i class="fas fa-file-contract"></i> Données Officielles</h3>
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Date de Naissance</label><input id="inp-birth-date" class="form-control" placeholder="01/01/1990"></div>
                    <div class="col-md-6"><label class="form-label">Lieu de Naissance</label><input id="inp-birth-place" class="form-control" placeholder="PARIS, FRANCE"></div>
                    <div class="col-md-6"><label class="form-label">Date d'Expiration</label><input id="inp-expiry" class="form-control" placeholder="31/12/2026"></div>
                    <div class="col-md-6"><label class="form-label">Groupe Sanguin</label><input id="inp-blood" class="form-control" placeholder="A+"></div>
                </div>
            </div>

            {{-- Contact --}}
            <div class="ce-card">
                <h3><i class="fas fa-phone-alt"></i> Contact & Médias</h3>
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Téléphone</label><input id="inp-phone" class="form-control" placeholder="+33 6 00 00 00 00"></div>
                    <div class="col-md-6"><label class="form-label">Email</label><input id="inp-email" class="form-control" placeholder="agent@flashbilan.fr"></div>
                    <div class="col-md-6"><label class="form-label">Photo d'identité</label><input type="file" id="inp-photo" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label">Logo Entreprise</label><input type="file" id="inp-logo" class="form-control"></div>
                </div>
            </div>

            {{-- Signature --}}
            <div class="ce-card">
                <h3><i class="fas fa-pen-nib"></i> Signature</h3>
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Signature (Texte)</label><input id="inp-sig-text" class="form-control" placeholder="Jean Gem"></div>
                    <div class="col-md-6"><label class="form-label">Scan Signature</label><input type="file" id="inp-sig-file" class="form-control"></div>
                </div>
            </div>

            {{-- Color --}}
            <div class="ce-card">
                <h3><i class="fas fa-palette"></i> Couleur Style</h3>
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
        service: 'VENTES',
        company: 'FLASHBILAN SAS',
        id: 'AGT-2024-001',
        birth: '01/01/1990',
        place: 'PARIS, FRANCE',
        expiry: '31/12/2026',
        sex: 'M',
        blood: 'A+',
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
                    <div class="v-photo">${state.photo ? `<img src="${state.photo}">` : `<i class="fas fa-user" style="font-size:100px;color:#ccc;margin-top:80px;"></i>`}</div>
                    <div class="v-name">${esc(state.name)}</div>
                    <div class="v-role" style="color: ${state.accent}">${esc(state.role)}</div>
                    <div class="v-strip" style="background: ${state.accent}">ID NO: ${esc(state.id)}</div>
                    <div class="v-details">
                        <div class="v-det-item"><span class="v-det-label">Sexe</span><span class="v-det-val">${state.sex}</span></div>
                        <div class="v-det-item"><span class="v-det-label">Groupe Sang.</span><span class="v-det-val">${state.blood}</span></div>
                        <div class="v-det-item"><span class="v-det-label">Né le</span><span class="v-det-val">${state.birth}</span></div>
                        <div class="v-det-item"><span class="v-det-label">Expire le</span><span class="v-det-val">${state.expiry}</span></div>
                    </div>
                    <div style="font-size:14px;font-weight:600;color:#64748b;text-align:center;">
                        <i class="fas fa-phone"></i> ${state.phone} | <i class="fas fa-envelope"></i> ${state.email}
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
                        <div class="l-main-info">
                            <div class="l-name">${esc(state.name)}</div>
                            <div class="l-role" style="color: ${state.accent}">${esc(state.role)}</div>
                            <div class="l-contact">
                                <div><i class="fas fa-phone" style="color:${state.accent}"></i> ${state.phone}</div>
                                <div><i class="fas fa-envelope" style="color:${state.accent}"></i> ${state.email}</div>
                            </div>
                        </div>
                        <div class="l-details-box">
                            <div class="l-details-grid">
                                <div><div class="l-det-label">Sexe</div><div class="l-det-val">${state.sex}</div></div>
                                <div><div class="l-det-label">Groupe Sang.</div><div class="l-det-val">${state.blood}</div></div>
                                <div><div class="l-det-label">Date Nais.</div><div class="l-det-val">${state.birth}</div></div>
                                <div><div class="l-det-label">Lieu Nais.</div><div class="l-det-val">${state.place}</div></div>
                                <div><div class="l-det-label">Service</div><div class="l-det-val">${esc(state.service)}</div></div>
                                <div><div class="l-det-label">Expire le</div><div class="l-det-val" style="color:${state.accent}">${state.expiry}</div></div>
                            </div>
                        </div>
                    </div>
                    <div class="l-sig">${sigHtml}</div>
                    <div class="l-strip" style="background: ${state.accent};">IDENTIFIANT : ${esc(state.id)}</div>
                </div>
            `;
        }


        inner.innerHTML = html;
        frame.className = `badge-preview-frame ${state.layout}`;
    };

    // Mapping
    const fields = {
        name: 'inp-name', role: 'inp-role', service: 'inp-service', company: 'inp-company',
        id: 'inp-id', birth: 'inp-birth-date', place: 'inp-birth-place', expiry: 'inp-expiry',
        sex: 'inp-sex', blood: 'inp-blood', phone: 'inp-phone', email: 'inp-email'
    };

    Object.entries(fields).forEach(([k, id]) => {
        document.getElementById(id).addEventListener('input', e => { state[k] = e.target.value; updatePreview(); });
    });

    document.getElementById('inp-sig-text').addEventListener('input', e => {
        state.sigText = e.target.value || 'Jean Gem'; state.sigImg = null; updatePreview();
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
            btn.classList.add('active'); state.tpl = btn.dataset.tpl; state.layout = btn.dataset.layout; updatePreview();
        });
    });

    document.querySelectorAll('.color-swatch').forEach(s => {
        s.addEventListener('click', () => {
            document.querySelectorAll('.color-swatch').forEach(x => x.classList.remove('active'));
            s.classList.add('active'); state.accent = s.dataset.color; updatePreview();
        });
    });

    document.getElementById('btn-download').addEventListener('click', async () => {
        const btn = document.getElementById('btn-download');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Génération...';
        const w = state.layout === 'landscape' ? 856 : 540;
        const h = state.layout === 'landscape' ? 540 : 856;
        const canvas = await html2canvas(inner.firstChild, { scale: 3, width: w, height: h });
        const link = document.createElement('a'); link.download = `badge-${state.name.replace(/\s+/g,'-').toLowerCase()}.png`;
        link.href = canvas.toDataURL(); link.click();
        btn.innerHTML = '<i class="fas fa-download"></i> Enregistrer HD (PNG)';
    });

    updatePreview();
});
</script>
@endpush
