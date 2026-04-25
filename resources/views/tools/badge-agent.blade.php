@extends('layouts.admin')

@section('title', 'Générateur de Badge Agent')

@section('breadcrumb')
    <li class="breadcrumb-item"><i class="fas fa-tools me-1"></i>Outils</li>
    <li class="breadcrumb-item active">Badge Agent</li>
@endsection

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Righteous&family=Dancing+Script:wght@600&display=swap');

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
    margin-bottom: 4px;
}

.form-control, .form-select {
    border: 1.5px solid var(--ce-border);
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 0.9rem;
    color: var(--ce-text);
    background: #fafafa;
    transition: all .2s;
    width: 100%;
}

.form-control:focus { outline: none; border-color: var(--ce-primary); background: #fff; }

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
}

.template-btn.active { border-color: var(--ce-primary); background: #e3f2fd; color: var(--ce-primary); }

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
}

.color-swatch.active { border-color: #333; transform: scale(1.05); }

/* Preview */
.badge-preview-wrap { position: sticky; top: 80px; }

.badge-preview-frame {
    width: 340px;
    height: 214px;
    margin: 0 auto;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,.18);
    position: relative;
}

.badge-preview-inner {
    width: 856px;
    height: 540px;
    transform: scale(0.3972);
    transform-origin: top left;
    position: absolute;
    top: 0; left: 0;
    border-radius: 46px;
    overflow: hidden;
}

/* SIGNATURES */
.sig-area {
    position: absolute;
    bottom: 30px;
    right: 40px;
    width: 220px;
    height: 90px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.sig-img {
    max-width: 100%;
    max-height: 70px;
    object-fit: contain;
    filter: brightness(0.2) contrast(1.5);
    display: none;
}

.sig-text {
    font-family: 'Dancing Script', cursive;
    font-size: 38px;
    color: #111;
    text-align: center;
}

.sig-label {
    font-size: 16px;
    color: #888;
    margin-top: 4px;
    font-weight: 600;
}

/* === TEMPLATES === */

/* MODERN */
.tpl-modern { background: #fff; }
.tpl-modern .badge-stripe {
    height: 160px;
    background: linear-gradient(135deg, #1565C0, #42A5F5);
    display: flex; align-items: flex-end; padding: 0 40px 20px; gap: 30px;
}
.tpl-modern .badge-photo-wrap {
    width: 130px; height: 130px; border-radius: 50%; border: 5px solid rgba(255,255,255,.5); overflow: hidden;
    background: rgba(255,255,255,.2); display: flex; align-items: center; justify-content: center; margin-bottom: -30px;
}
.tpl-modern .badge-photo-wrap img { width: 100%; height: 100%; object-fit: cover; }
.tpl-modern .badge-company { font-size: 24px; font-weight: 800; color: #fff; }
.tpl-modern .badge-logo-area { margin-left: auto; }
.tpl-modern .badge-logo-area img { max-height: 60px; filter: brightness(0) invert(1); }
.tpl-modern .badge-body { padding: 40px 40px; position: relative; }
.tpl-modern .badge-name { font-size: 36px; font-weight: 800; color: #1a1a1a; line-height: 1.1; }
.tpl-modern .badge-role { font-size: 22px; font-weight: 600; color: #1565C0; margin-bottom: 24px; }
.tpl-modern .badge-info-item { display: flex; align-items: center; gap: 10px; font-size: 18px; color: #555; margin-bottom: 6px;}
.tpl-modern .badge-info-icon { width: 32px; height: 32px; border-radius: 8px; background: #e3f2fd; display:flex; align-items:center; justify-content:center; color: #1565C0; }
.tpl-modern .badge-id-strip { position: absolute; bottom: 0; left: 0; right: 0; height: 50px; background: #1565C0; display: flex; align-items: center; padding: 0 40px; gap: 14px; color: #fff; }

/* DARK */
.tpl-dark { background: #0f172a; }
.tpl-dark .badge-left-col { position: absolute; left: 0; top: 0; bottom: 0; width: 240px; background: #1e293b; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 30px; }
.tpl-dark .badge-photo-wrap { width: 140px; height: 140px; border-radius: 50%; border: 4px solid #334155; overflow: hidden; }
.tpl-dark .badge-id-chip { background: #334155; color: #94a3b8; border-radius: 20px; padding: 6px 20px; margin-top: 15px; font-size: 17px; font-family: monospace; }
.tpl-dark .badge-right-col { position: absolute; left: 240px; right: 0; top: 0; bottom: 0; padding: 40px; display: flex; flex-direction: column; }
.tpl-dark .badge-name { font-size: 38px; font-weight: 800; color: #f1f5f9; }
.tpl-dark .badge-role { font-size: 19px; color: #64748b; text-transform: uppercase; letter-spacing: 2px; }
.tpl-dark .badge-company { font-size: 22px; color: #94a3b8; margin-top: 10px; }
.tpl-dark .badge-info-item { display: flex; align-items: center; gap: 10px; color: #94a3b8; margin-top: 10px; font-size: 17px; }
.tpl-dark .badge-logo-area { margin-top: auto; }
.tpl-dark .badge-logo-area img { max-height: 40px; filter: brightness(0) invert(1); opacity: 0.6;}

/* MINIMAL */
.tpl-minimal { background: #fff; border: 2px solid #eee; }
.tpl-minimal .badge-left { position: absolute; left: 0; top: 0; bottom: 0; width: 220px; background: #f3f4f6; display: flex; flex-direction: column; align-items: center; padding: 40px 20px; }
.tpl-minimal .badge-photo-wrap { width: 130px; height: 130px; border-radius: 12px; overflow: hidden; background: #ddd; }
.tpl-minimal .badge-photo-wrap img { width: 100%; height: 100%; object-fit: cover; }
.tpl-minimal .badge-id-chip { background: #1f2937; color: #fff; border-radius: 6px; padding: 6px 15px; margin-top: 15px; font-family: monospace; font-size: 16px; }
.tpl-minimal .badge-right { position: absolute; left: 220px; right: 0; top: 0; bottom: 0; padding: 40px; display: flex; flex-direction: column; }
.tpl-minimal .badge-company { font-size: 18px; font-weight: 700; color: #6b7280; text-transform: uppercase; }
.tpl-minimal .badge-name { font-size: 40px; font-weight: 800; color: #111; margin-top: 10px; }
.tpl-minimal .badge-role { font-size: 21px; color: #444; margin-bottom: 20px; }
.tpl-minimal .badge-info-item { display: flex; align-items: center; gap: 10px; color: #6b7280; font-size: 17px; margin-top: 5px; }

.btn-download { width: 100%; margin-top: 16px; padding: 14px; border-radius: 12px; border: none; font-weight: 700; background: var(--ce-gradient); color: #fff; cursor: pointer; display: flex; justify-content: center; align-items: center; gap: 10px; box-shadow: 0 4px 20px rgba(102,126,234,.4); }

@media (max-width: 900px) {
    .badge-editor { grid-template-columns: 1fr; }
    .badge-preview-wrap { position: static; }
}
</style>

<div class="badge-wrap">
    <div class="badge-header">
        <h1><i class="fas fa-id-badge" style="color:#667eea;"></i> <span>Badge Agent Tool</span></h1>
        <div class="badge-certified"><i class="fas fa-star" style="color:#f59e0b;"></i> Version Premium</div>
    </div>

    <div class="badge-editor">
        <div class="badge-form-col">
            {{-- Modèle --}}
            <div class="ce-card">
                <h3><i class="fas fa-layer-group"></i> Modèle de carte</h3>
                <div class="template-grid">
                    <button class="template-btn active" data-tpl="tpl-modern" type="button">Modern Blue</button>
                    <button class="template-btn" data-tpl="tpl-dark" type="button">Dark Pro</button>
                    <button class="template-btn" data-tpl="tpl-minimal" type="button">Minimal</button>
                </div>
            </div>

            {{-- Infos --}}
            <div class="ce-card">
                <h3><i class="fas fa-user-tie"></i> Informations de l'agent</h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Prénom & Nom</label>
                        <input type="text" id="inp-name" class="form-control" placeholder="Jean Dupont">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Poste / Rôle</label>
                        <input type="text" id="inp-role" class="form-control" placeholder="Agent Commercial">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Société</label>
                        <input type="text" id="inp-company" class="form-control" placeholder="FlashBilan SAS">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Numéro ID</label>
                        <input type="text" id="inp-id" class="form-control" placeholder="AGT-2024-001">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Téléphone</label>
                        <input type="text" id="inp-phone" class="form-control" placeholder="+33 6 00 00 00 00">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="text" id="inp-email" class="form-control" placeholder="agent@flashbilan.fr">
                    </div>
                </div>
            </div>

            {{-- Signature Nouvelle --}}
            <div class="ce-card">
                <h3><i class="fas fa-signature"></i> Signature du titulaire</h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Importer Image Signature</label>
                        <input type="file" id="inp-sig-file" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Ou Signature Texte</label>
                        <input type="text" id="inp-sig-text" class="form-control" placeholder="Jean Dupont">
                    </div>
                </div>
            </div>

            {{-- Médias --}}
            <div class="ce-card">
                <h3><i class="fas fa-images"></i> Photos & Logos</h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Photo Agent</label>
                        <input type="file" id="inp-photo" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Logo Entreprise</label>
                        <input type="file" id="inp-logo" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>

            {{-- Couleur --}}
            <div class="ce-card">
                <h3><i class="fas fa-palette"></i> Couleur Accent</h3>
                <div class="color-grid">
                    <div class="color-swatch active" data-color="#1565C0" style="background:#1565C0;"></div>
                    <div class="color-swatch" data-color="#7c3aed" style="background:#7c3aed;"></div>
                    <div class="color-swatch" data-color="#dc2626" style="background:#dc2626;"></div>
                    <div class="color-swatch" data-color="#059669" style="background:#059669;"></div>
                    <div class="color-swatch" data-color="#0f172a" style="background:#0f172a;"></div>
                </div>
            </div>
        </div>

        {{-- Preview --}}
        <div class="badge-preview-wrap">
            <div class="badge-preview-frame">
                <div class="badge-preview-inner tpl-modern" id="badge-inner">
                    {{-- HTML injecté dynamiquement par JS --}}
                </div>
            </div>
            <button class="btn-download" id="btn-download"><i class="fas fa-download"></i> Télécharger Badge (HD)</button>
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
        accent: '#1565C0',
        name: 'Jean Dupont',
        role: 'Agent Commercial',
        company: 'FlashBilan SAS',
        id: 'AGT-2024-001',
        phone: '+33 6 00 00 00 00',
        email: 'agent@flashbilan.fr',
        photo: null,
        logo: null,
        sigImg: null,
        sigText: 'Jean Gem' // Par défaut comme demandé
    };

    const inner = document.getElementById('badge-inner');

    const updatePreview = () => {
        let html = '';
        const esc = s => s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');

        const sigHtml = `
            <div class="sig-area">
                ${state.sigImg ? `<img src="${state.sigImg}" class="sig-img" style="display:block;">` : `<span class="sig-text">${esc(state.sigText)}</span>`}
                <span class="sig-label">Signature du titulaire</span>
            </div>
        `;

        if (state.tpl === 'tpl-modern') {
            html = `
                <div class="badge-stripe" style="background: linear-gradient(135deg, ${state.accent}, ${state.accent}cc)">
                    <div class="badge-photo-wrap">
                        ${state.photo ? `<img src="${state.photo}">` : '<i class="fas fa-user" style="font-size:3rem;color:white;opacity:0.5"></i>'}
                    </div>
                    <div class="badge-company">${esc(state.company)}</div>
                    <div class="badge-logo-area">
                        ${state.logo ? `<img src="${state.logo}">` : ''}
                    </div>
                </div>
                <div class="badge-body">
                    <div class="badge-name">${esc(state.name)}</div>
                    <div class="badge-role" style="color: ${state.accent}">${esc(state.role)}</div>
                    <div class="badge-info-item"><span class="badge-info-icon" style="background:${state.accent}20;color:${state.accent}">📞</span>${esc(state.phone)}</div>
                    <div class="badge-info-item"><span class="badge-info-icon" style="background:${state.accent}20;color:${state.accent}">✉️</span>${esc(state.email)}</div>
                    ${sigHtml}
                </div>
                <div class="badge-id-strip" style="background: ${state.accent}">
                    <span>ID :</span> <strong>${esc(state.id)}</strong>
                </div>
            `;
        } else if (state.tpl === 'tpl-dark') {
            html = `
                <div class="badge-left-col" style="background: linear-gradient(180deg, #1e293b, #0f172a)">
                    <div class="badge-photo-wrap" style="border-color: ${state.accent}40">
                        ${state.photo ? `<img src="${state.photo}" style="width:100%;height:100%;object-fit:cover;">` : '<i class="fas fa-user" style="font-size:3.5rem;color:#475569"></i>'}
                    </div>
                    <div class="badge-id-chip" style="background: #334155">${esc(state.id)}</div>
                </div>
                <div class="badge-right-col">
                    <div class="badge-role" style="color: ${state.accent}">${esc(state.role)}</div>
                    <div class="badge-name">${esc(state.name)}</div>
                    <div class="badge-company">${esc(state.company)}</div>
                    <div style="width:50px;height:4px;background:${state.accent};margin:20px 0;"></div>
                    <div class="badge-info-item"><i class="fas fa-phone" style="color:${state.accent}"></i> ${esc(state.phone)}</div>
                    <div class="badge-info-item"><i class="fas fa-envelope" style="color:${state.accent}"></i> ${esc(state.email)}</div>
                    ${sigHtml}
                    <div class="badge-logo-area">
                        ${state.logo ? `<img src="${state.logo}">` : ''}
                    </div>
                </div>
            `;
        } else {
            html = `
                <div class="badge-left">
                    <div class="badge-photo-wrap">
                        ${state.photo ? `<img src="${state.photo}">` : '<i class="fas fa-user" style="font-size:3rem;color:#9ca3af"></i>'}
                    </div>
                    <div class="badge-id-chip" style="background: ${state.accent}">${esc(state.id)}</div>
                    <div style="margin-top:auto;">
                        ${state.logo ? `<img src="${state.logo}" style="max-height:40px;">` : ''}
                    </div>
                </div>
                <div class="badge-right">
                    <div class="badge-company">${esc(state.company)}</div>
                    <div class="badge-name">${esc(state.name)}</div>
                    <div class="badge-role">${esc(state.role)}</div>
                    <div style="width:40px;height:3px;background:${state.accent};margin-bottom:20px;"></div>
                    <div class="badge-info-item"><i class="fas fa-phone"></i> ${esc(state.phone)}</div>
                    <div class="badge-info-item"><i class="fas fa-envelope"></i> ${esc(state.email)}</div>
                    ${sigHtml}
                </div>
            `;
        }

        inner.className = `badge-preview-inner ${state.tpl}`;
        inner.innerHTML = html;
    };

    // Listeners
    ['name', 'role', 'company', 'id', 'phone', 'email'].forEach(f => {
        document.getElementById('inp-'+f).addEventListener('input', e => { state[f] = e.target.value || ''; updatePreview(); });
    });

    document.getElementById('inp-sig-text').addEventListener('input', e => {
        state.sigText = e.target.value.trim() || 'Jean Gem';
        state.sigImg = null;
        updatePreview();
    });

    const handleFile = (id, key) => {
        document.getElementById(id).addEventListener('change', function() {
            if (!this.files[0]) return;
            const r = new FileReader();
            r.onload = e => { state[key] = e.target.result; updatePreview(); };
            r.readAsDataURL(this.files[0]);
        });
    };
    handleFile('inp-photo', 'photo');
    handleFile('inp-logo', 'logo');
    handleFile('inp-sig-file', 'sigImg');

    document.querySelectorAll('.template-btn').forEach(b => {
        b.addEventListener('click', () => {
            document.querySelectorAll('.template-btn').forEach(x => x.classList.remove('active'));
            b.classList.add('active');
            state.tpl = b.dataset.tpl;
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
        const b = document.getElementById('btn-download');
        b.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Génération...';
        const canvas = await html2canvas(inner, { scale: 2.5, width: 856, height: 540 });
        const link = document.createElement('a');
        link.download = `badge-${state.name.replace(/\s+/g,'-').toLowerCase()}.png`;
        link.href = canvas.toDataURL();
        link.click();
        b.innerHTML = '<i class="fas fa-download"></i> Télécharger Badge (HD)';
    });

    updatePreview();
});
</script>
@endpush
