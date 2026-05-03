@extends('layouts.admin')

@section('title', 'Générateur de Badge Agent Pro')

@section('breadcrumb')
    <li class="breadcrumb-item"><i class="fas fa-tools me-1"></i>Outils</li>
    <li class="breadcrumb-item active">Badge Agent</li>
@endsection

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Righteous&family=Dancing+Script:wght@600&family=Great+Vibes&family=Roboto+Mono:wght@400;700&display=swap');

:root {
    --ce-primary: #2196F3;
    --ce-sidebar-bg: #2196F3;
    --ce-header-bg: #2196F3;
    --ce-pill-bg: #1976D2;
    --ce-text: #1e293b;
    --ce-text-dim: #64748b;
    --ce-border: #e2e8f0;
}

.badge-wrap { font-family: 'Poppins', sans-serif; color: var(--ce-text); padding: 24px; }
@media (max-width: 576px) { .badge-wrap { padding: 12px 0; } }

.badge-header { margin-bottom: 32px; padding: 0 15px; }
.badge-header h1 { font-size: 1.75rem; font-weight: 800; margin: 0; display: flex; align-items: center; gap: 12px; }
.badge-header h1 span { font-family: 'Righteous', cursive; background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

.badge-editor { display: grid; grid-template-columns: 1fr 380px; gap: 32px; align-items: start; }
@media (max-width: 992px) { .badge-editor { grid-template-columns: 1fr; } .preview-col { order: -1; margin-bottom: 32px; } }

.ce-card { background: #fff; border-radius: 20px; border: 1px solid var(--ce-border); padding: 24px; margin-bottom: 24px; }
.ce-card h3 { font-size: 1.1rem; font-weight: 700; margin: 0 0 20px; color: var(--ce-primary); display: flex; align-items: center; gap: 10px; }
.form-label { font-size: 0.75rem; font-weight: 700; color: var(--ce-text-dim); text-transform: uppercase; margin-bottom: 6px; }
.form-control, .form-select { border: 1.5px solid var(--ce-border); border-radius: 12px; padding: 10px 14px; font-size: 0.9rem; background: #fbfcfe; width: 100%; transition: all .2s; }
.form-control:focus { outline: none; border-color: var(--ce-primary); background: #fff; }

/* Preview Frame */
.badge-preview-wrap { position: sticky; top: 100px; }
@media (max-width: 992px) { .badge-preview-wrap { position: static; top: auto; } }
.badge-preview-frame { margin: 0 auto; border-radius: 30px; box-shadow: 0 30px 60px -12px rgba(0,0,0,0.25); overflow: hidden; position: relative; background: #fff; transform-origin: center; transform: translateZ(0); }
.badge-preview-frame.landscape { width: 340px; height: 214px; }
.badge-preview-frame.portrait { width: 254px; height: 403px; }
@media (max-width: 992px) { .preview-col { overflow: hidden; } }

.badge-preview-inner { position: absolute; top: 0; left: 0; transform-origin: top left; }
.badge-preview-frame.landscape .badge-preview-inner { width: 856px; height: 540px; transform: scale(0.3972); }
.badge-preview-frame.portrait .badge-preview-inner { width: 540px; height: 856px; transform: scale(0.4704); }

/* NEW LAYOUT (Landscape) */
.tpl-landscape { width: 856px; height: 540px; background: #fff; display: flex; position: relative; }
.l-sidebar { width: 235px; height: 100%; background: var(--ce-sidebar-bg); display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative; padding-bottom: 40px; }
.l-side-photo { width: 155px; height: 155px; border-radius: 50%; border: 6px solid rgba(255,255,255,0.4); overflow: hidden; margin-bottom: 40px; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; }
.l-side-photo img { width: 100%; height: 100%; object-fit: cover; }
.l-side-photo i { font-size: 70px; color: rgba(255,255,255,0.4); }

.l-side-pill { background: var(--ce-pill-bg); color: #fff; padding: 12px 25px; border-radius: 30px; font-weight: 800; font-size: 20px; font-family: 'Roboto Mono', monospace; position: absolute; bottom: 35px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }

.l-sidebar { border-right: 6px solid rgba(255,255,255,0.25); }
.l-main { flex: 1; display: flex; flex-direction: column; }
.l-top-bar { height: 65px; background: var(--ce-header-bg); display: flex; align-items: center; justify-content: center; padding: 0 30px; }
.l-company { color: #fff; font-size: 28px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; }

.l-content-area { flex: 1; padding: 24px 35px 16px; display: flex; gap: 30px; align-items: stretch; }
.l-left-col { flex: 1.2; display: flex; flex-direction: column; justify-content: space-between; }
.l-name { font-size: 54px; font-weight: 900; line-height: 1.05; color: #1e293b; letter-spacing: -2px; margin: 0; }
.l-role { font-size: 22px; font-weight: 700; color: var(--ce-primary); text-transform: uppercase; letter-spacing: 2px; margin: 6px 0 0; }
.l-contact { display: flex; flex-direction: column; gap: 12px; font-size: 22px; font-weight: 600; color: #334155; margin-top: auto; padding-top: 16px; }
.l-contact-item { display: flex; align-items: center; gap: 14px; }
.l-contact-item i { color: var(--ce-primary); font-size: 20px; width: 26px; text-align: center; }

.l-right-col { flex: 1; display: flex; align-items: center; }
.l-details-card { background: #f8fafc; border-radius: 20px; padding: 22px; border: 1px solid #f1f5f9; display: grid; grid-template-columns: 1fr 1fr; gap: 16px; width: 100%; }
.l-det-it { display: flex; flex-direction: column; }
.l-det-lbl { font-size: 13px; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 3px; }
.l-det-val { font-size: 20px; font-weight: 700; color: #1e293b; }

.l-footer { height: 90px; padding: 0 35px 24px; display: flex; justify-content: space-between; align-items: flex-end; border-top: 1px solid #f1f5f9; }
.l-id-footer { display: flex; flex-direction: column; }
.l-id-lbl { font-size: 14px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 2px; }
.l-id-val { font-size: 22px; font-weight: 800; color: var(--ce-primary); font-family: 'Roboto Mono', monospace; }

.l-sig-area { text-align: center; }
.l-sig-text { font-family: 'Great Vibes', cursive; font-size: 52px; color: #1e293b; line-height: 1; display: inline-block; transform: rotate(-3deg); transform-origin: center; }
.l-sig-img { max-height: 110px; max-width: 220px; filter: contrast(1.1) brightness(0.9); }
.l-sig-lbl { font-size: 12px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; }

/* PORTRAIT */
.tpl-portrait { width: 540px; height: 856px; background: #fff; display: flex; flex-direction: column; align-items: center; padding: 20px 35px 30px; }
.v-logo-box { height: 60px; margin-bottom: 16px; }
.v-photo { width: 180px !important; height: 180px !important; border-radius: 50%; overflow: hidden; border: 8px solid #f1f5f9; box-shadow: 0 10px 30px rgba(0,0,0,0.14); margin-bottom: 24px; background: #eee; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.v-photo img { width: 100%; height: 100%; object-fit: cover; display: block; }
.v-photo i { font-size: 95px; color: #cbd5e1; }
.v-name { font-size: 46px; font-weight: 900; text-align: center; line-height: 1.1; margin-bottom: 8px; }
.v-role { font-size: 22px; font-weight: 700; color: var(--ce-primary); text-transform: uppercase; letter-spacing: 2px; margin-bottom: 22px; }
.v-details { background: #f8fafc; border-radius: 16px; width: 100%; padding: 18px 22px; display: grid; grid-template-columns: 1fr 1fr; gap: 12px 18px; margin-bottom: 20px; }
.v-id-band { background: var(--ce-primary); color: #fff; width: 100%; padding: 13px; text-align: center; border-radius: 14px; font-family: monospace; font-size: 22px; font-weight: 800; margin-bottom: 20px; }

.btn-download { width: 100%; padding: 18px; border-radius: 18px; background: linear-gradient(135deg, #2196F3, #1565C0); color: #fff; border: none; font-weight: 800; font-size: 1.1rem; cursor: pointer; display: flex; justify-content: center; gap: 12px; margin-top: 15px; box-shadow: 0 10px 20px rgba(33, 150, 243, 0.3); }

.color-grid { display: flex; gap: 12px; }
.color-swatch { width: 45px; height: 45px; border-radius: 12px; cursor: pointer; border: 3px solid transparent; transition: transform .2s; }
.color-swatch.active { border-color: #000; transform: scale(1.1); }
</style>

<div class="badge-wrap">
    <div class="badge-header">
        <h1><i class="fas fa-id-badge"></i> <span>Badge Suite Pro</span></h1>
        <p class="cp-tool-info">
            <span data-bs-toggle="modal" data-bs-target="#baHelpModal">
                <i class="fas fa-info-circle"></i> Utilité et Fonctionnement <i class="fas fa-arrow-right" style="font-size:0.75em;"></i>
            </span>
        </p>
    </div>

    <div class="badge-editor">
        <div class="form-col">
            <div class="ce-card">
                <h3><i class="fas fa-palette"></i> Style & Couleur</h3>
                <div class="row g-3 align-items-center">
                    <div class="col-md-6">
                        <label class="form-label">Format</label>
                        <select id="inp-tpl" class="form-select">
                            <option value="tpl-landscape">🔵 Modern (Paysage)</option>
                            <option value="tpl-dark">⚫ Dark Pro (Paysage)</option>
                            <option value="tpl-portrait">⬜ Minimal (Portrait)</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Langue du badge</label>
                        <select id="inp-lang" class="form-select">
                            <option value="fr">🇫🇷 Français</option>
                            <option value="en">🇬🇧 English</option>
                            <option value="es">🇪🇸 Español</option>
                            <option value="pt">🇵🇹 Português</option>
                            <option value="ar">🇸🇦 العربية</option>
                            <option value="de">🇩🇪 Deutsch</option>
                            <option value="it">🇮🇹 Italiano</option>
                            <option value="nl">🇳🇱 Nederlands</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Couleur principale</label>
                        <div class="color-grid">
                            <div class="color-swatch active" data-color="#2196F3" style="background:#2196F3;"></div>
                            <div class="color-swatch" data-color="#E91E63" style="background:#E91E63;"></div>
                            <div class="color-swatch" data-color="#4CAF50" style="background:#4CAF50;"></div>
                            <div class="color-swatch" data-color="#FF9800" style="background:#FF9800;"></div>
                            <div class="color-swatch" data-color="#333333" style="background:#333333;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ce-card">
                <h3><i class="fas fa-user-circle"></i> Identité de l'Agent</h3>
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Nom Complet</label><input id="inp-name" class="form-control" placeholder="JEAN DUPONT"></div>
                    <div class="col-md-6"><label class="form-label">Fonction</label><input id="inp-role" class="form-control" placeholder="AGENT COMMERCIAL"></div>
                    <div class="col-md-6"><label class="form-label">Société</label><input id="inp-company" class="form-control" placeholder="FLASHBILAN SAS"></div>
                    <div class="col-md-6"><label class="form-label">ID Badge</label><input id="inp-id" class="form-control" placeholder="AGT-2024-001"></div>
                    <div class="col-md-4"><label class="form-label">Service</label><input id="inp-service" class="form-control" placeholder="VENTES"></div>
                    <div class="col-md-4"><label class="form-label">Sexe</label><select id="inp-sex" class="form-select"><option value="M">Masculin</option><option value="F">Féminin</option></select></div>
                    <div class="col-md-4"><label class="form-label">Groupe Sang.</label><input id="inp-blood" class="form-control" placeholder="A+"></div>
                </div>
            </div>

            <div class="ce-card">
                <h3><i class="fas fa-calendar-alt"></i> Dates & Lieux</h3>
                <div class="row g-3">
                    <div class="col-md-4"><label class="form-label">Date Naiss.</label><input id="inp-birth-date" class="form-control" placeholder="01/01/1990"></div>
                    <div class="col-md-4"><label class="form-label">Lieu Naiss.</label><input id="inp-birth-place" class="form-control" placeholder="PARIS"></div>
                    <div class="col-md-4"><label class="form-label">Expire le</label><input id="inp-expiry" class="form-control" placeholder="31/12/2026"></div>
                </div>
            </div>

            <div class="ce-card">
                <h3><i class="fas fa-mobile-alt"></i> Contact & Médias</h3>
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Téléphone</label><input id="inp-phone" class="form-control" placeholder="+33 6 00 000 000"></div>
                    <div class="col-md-6"><label class="form-label">Email</label><input id="inp-email" class="form-control" placeholder="agent@flashbilan.fr"></div>
                    <div class="col-md-6"><label class="form-label">Photo</label><input type="file" id="inp-photo" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label">Signature</label><input type="file" id="inp-sig-file" class="form-control"></div>
                </div>
            </div>
        </div>

        <div class="preview-col">
            <div class="badge-preview-wrap">
                <div class="badge-preview-frame landscape" id="badge-frame">
                    <div class="badge-preview-inner" id="badge-inner"></div>
                </div>
                <button class="btn-download" id="btn-download"><i class="fas fa-file-download"></i> TELECHARGER LE BADGE</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Utilité et Fonctionnement --}}
<div class="modal fade" id="baHelpModal" tabindex="-1" aria-labelledby="baHelpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="baHelpModalLabel"><i class="fas fa-info-circle"></i> Utilité et Fonctionnement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="text-primary">Utilité</h6>
                <p>Cet outil vous permet de créer un <b>badge d'agent professionnel</b> personnalisé avec photo, nom, fonction, société, groupe sanguin et date d'expiration. Idéal pour vos agents de terrain, commerciaux, ou tout personnel nécessitant une identification officielle.</p>
                <h6 class="text-primary">Fonctionnement</h6>
                <p>Choisissez un modèle (Modern Paysage, Dark Pro ou Minimal Portrait), renseignez les informations de l'agent et téléchargez une photo. L'aperçu se met à jour en temps réel. Cliquez sur <b>Télécharger le Badge</b> pour obtenir une image haute résolution prête à imprimer.</p>
                <p>Cet outil est <b>gratuit</b> et ne nécessite aucun crédit.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<style>
.cp-tool-info span { position: relative; display: inline-block; border: none; background-color: #4f429b; box-shadow: 0 0 12px rgba(0,0,0,.12); font-size: .88em; text-align: center; border-radius: 4px; padding: 8px 18px; transition: all 200ms ease; user-select: none; color: white; cursor: pointer; }
.cp-tool-info span:hover { transform: scale(1.02); }
.cp-tool-info span:active { transform: scale(.98); }
.cp-tool-info { margin-bottom: 14px; }
.badge-header .cp-tool-info { margin-top: 10px; margin-bottom: 0; }
</style>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const translations = {
        fr: { sex:'SEXE', blood:'GROUPE SANG.', birth:'DATE NAISS.', place:'LIEU NAISS.', service:'SERVICE', expiry:'EXPIRE LE', id:'IDENTIFIANT', sig:'SIGNATURE DU TITULAIRE' },
        en: { sex:'SEX', blood:'BLOOD GROUP', birth:'DATE OF BIRTH', place:'PLACE OF BIRTH', service:'DEPARTMENT', expiry:'EXPIRES', id:'ID NUMBER', sig:"HOLDER'S SIGNATURE" },
        es: { sex:'SEXO', blood:'GRUPO SANG.', birth:'FECHA NAC.', place:'LUGAR NAC.', service:'SERVICIO', expiry:'VENCE EL', id:'NÚMERO ID', sig:'FIRMA DEL TITULAR' },
        pt: { sex:'SEXO', blood:'GRUPO SANG.', birth:'DATA NASC.', place:'LOCAL NASC.', service:'SERVIÇO', expiry:'EXPIRA EM', id:'NÚMERO ID', sig:'ASSINATURA DO TITULAR' },
        ar: { sex:'الجنس', blood:'فصيلة الدم', birth:'تاريخ الميلاد', place:'مكان الميلاد', service:'القسم', expiry:'تاريخ الانتهاء', id:'رقم التعريف', sig:'توقيع الحامل' },
        de: { sex:'GESCHLECHT', blood:'BLUTGRUPPE', birth:'GEB. DATUM', place:'GEBURTSORT', service:'ABTEILUNG', expiry:'ABLAUFDATUM', id:'AUSWEIS-NR.', sig:'UNTERSCHRIFT' },
        it: { sex:'SESSO', blood:'GRUPPO SANG.', birth:'DATA NASC.', place:'LUOGO NASC.', service:'SERVIZIO', expiry:'SCADE IL', id:'NUMERO ID', sig:'FIRMA DEL TITOLARE' },
        nl: { sex:'GESLACHT', blood:'BLOEDGROEP', birth:'GEBOORTEDATUM', place:'GEBOORTEPLAATS', service:'DIENST', expiry:'VERVALDATUM', id:'ID-NUMMER', sig:'HANDTEKENING' },
    };

    let state = {
        tpl: 'tpl-landscape',
        lang: 'fr',
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
        sigImg: null,
        sigText: 'Jean Dupont'
    };

    const nameToSig = name => name.split(' ').map(w => w.charAt(0).toUpperCase() + w.slice(1).toLowerCase()).join(' ');

    const updatePreview = () => {
        const esc = s => s.toUpperCase().replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
        const t = key => translations[state.lang]?.[key] || translations.fr[key];
        const isRTL = state.lang === 'ar';
        const inner = document.getElementById('badge-inner');
        const frame = document.getElementById('badge-frame');
        
        document.documentElement.style.setProperty('--ce-primary', state.accent);
        document.documentElement.style.setProperty('--ce-sidebar-bg', state.accent);
        document.documentElement.style.setProperty('--ce-header-bg', state.accent);
        
        let html = '';

        if (state.tpl === 'tpl-landscape') {
            frame.className = 'badge-preview-frame landscape';
            html = `
                <div class="tpl-landscape">
                    <div class="l-sidebar">
                        <div class="l-side-photo" style="${state.photo ? `background-image:url('${state.photo}');background-size:cover;background-position:center;` : ''}">
                            ${state.photo ? '' : `<i class="fas fa-user" style="font-size:80px; color:rgba(255,255,255,0.5);"></i>`}
                        </div>
                        <div class="l-side-pill">${esc(state.id)}</div>
                    </div>
                    <div class="l-main">
                        <div class="l-top-bar">
                            <div class="l-company">${esc(state.company)}</div>
                        </div>
                        <div class="l-content-area">
                            <div class="l-left-col">
                                <div class="l-name">${esc(state.name)}</div>
                                <div class="l-role">${esc(state.role)}</div>
                                <div class="l-contact">
                                    <div class="l-contact-item"><i class="fas fa-phone"></i> ${state.phone}</div>
                                    <div class="l-contact-item"><i class="fas fa-envelope"></i> ${state.email}</div>
                                </div>
                            </div>
                            <div class="l-right-col">
                                <div class="l-details-card" dir="${isRTL ? 'rtl' : 'ltr'}">
                                    <div class="l-det-it"><span class="l-det-lbl">${t('sex')}</span><span class="l-det-val">${state.sex}</span></div>
                                    <div class="l-det-it"><span class="l-det-lbl">${t('blood')}</span><span class="l-det-val">${state.blood}</span></div>
                                    <div class="l-det-it"><span class="l-det-lbl">${t('birth')}</span><span class="l-det-val">${state.birth}</span></div>
                                    <div class="l-det-it"><span class="l-det-lbl">${t('place')}</span><span class="l-det-val">${esc(state.place)}</span></div>
                                    <div class="l-det-it"><span class="l-det-lbl">${t('service')}</span><span class="l-det-val">${esc(state.service)}</span></div>
                                    <div class="l-det-it"><span class="l-det-lbl">${t('expiry')}</span><span class="l-det-val" style="color:${state.accent}">${state.expiry}</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="l-footer" dir="${isRTL ? 'rtl' : 'ltr'}">
                            <div class="l-id-footer">
                                <span class="l-id-lbl">${t('id')}</span>
                                <span class="l-id-val">${esc(state.id)}</span>
                            </div>
                            <div class="l-sig-area">
                                ${state.sigImg ? `<img src="${state.sigImg}" class="l-sig-img">` : `<div class="l-sig-text">${state.sigText}</div>`}
                                <div class="l-sig-lbl">${t('sig')}</div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        } else if (state.tpl === 'tpl-dark') {
            frame.className = 'badge-preview-frame landscape';
            html = `
                <div class="tpl-landscape" style="background:#0f172a;">
                    <div class="l-sidebar" style="background:linear-gradient(180deg,#1e293b,#0f172a);">
                        <div class="l-logo-wrap" style="margin-bottom:0;">
                            ${state.logo ? `<img src="${state.logo}" style="filter:brightness(0) invert(1);opacity:.7;max-height:50px;max-width:150px;">` : ''}
                        </div>
                        <div class="l-side-photo" style="border-color:rgba(255,255,255,0.15);${state.photo ? `background-image:url('${state.photo}');background-size:cover;background-position:center;` : ''}">
                            ${state.photo ? '' : `<i class="fas fa-user" style="font-size:80px;color:rgba(255,255,255,0.2);"></i>`}
                        </div>
                        <div class="l-side-pill" style="background:${state.accent};font-size:17px;">${esc(state.id)}</div>
                    </div>
                    <div class="l-main" style="background:#0f172a;">
                        <div class="l-top-bar" style="background:#1e293b;">
                            <div class="l-company" style="color:#94a3b8;font-size:22px;letter-spacing:4px;">${esc(state.company)}</div>
                        </div>
                        <div class="l-content-area" style="background:#0f172a;">
                            <div class="l-left-col">
                                <div>
                                    <div class="l-name" style="color:#ffffff;">${esc(state.name)}</div>
                                    <div class="l-role" style="color:${state.accent};">${esc(state.role)}</div>
                                </div>
                                <div style="width:50px;height:4px;border-radius:2px;background:${state.accent};margin:8px 0;"></div>
                                <div class="l-contact">
                                    <div class="l-contact-item" style="color:#94a3b8;"><i class="fas fa-phone" style="color:${state.accent};"></i> ${state.phone}</div>
                                    <div class="l-contact-item" style="color:#94a3b8;"><i class="fas fa-envelope" style="color:${state.accent};"></i> ${state.email}</div>
                                </div>
                            </div>
                            <div class="l-right-col">
                                <div class="l-details-card" style="background:#1e293b;border-color:#334155;" dir="${isRTL ? 'rtl' : 'ltr'}">
                                    <div class="l-det-it"><span class="l-det-lbl">${t('sex')}</span><span class="l-det-val" style="color:#e2e8f0;">${state.sex}</span></div>
                                    <div class="l-det-it"><span class="l-det-lbl">${t('blood')}</span><span class="l-det-val" style="color:#e2e8f0;">${state.blood}</span></div>
                                    <div class="l-det-it"><span class="l-det-lbl">${t('birth')}</span><span class="l-det-val" style="color:#e2e8f0;">${state.birth}</span></div>
                                    <div class="l-det-it"><span class="l-det-lbl">${t('place')}</span><span class="l-det-val" style="color:#e2e8f0;">${esc(state.place)}</span></div>
                                    <div class="l-det-it"><span class="l-det-lbl">${t('service')}</span><span class="l-det-val" style="color:#e2e8f0;">${esc(state.service)}</span></div>
                                    <div class="l-det-it"><span class="l-det-lbl">${t('expiry')}</span><span class="l-det-val" style="color:${state.accent};">${state.expiry}</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="l-footer" style="background:#0f172a;border-top-color:#1e293b;" dir="${isRTL ? 'rtl' : 'ltr'}">
                            <div class="l-id-footer">
                                <span class="l-id-lbl">${t('id')}</span>
                                <span class="l-id-val" style="color:${state.accent};">${esc(state.id)}</span>
                            </div>
                            <div class="l-sig-area">
                                ${state.sigImg ? `<img src="${state.sigImg}" class="l-sig-img" style="filter:brightness(0) invert(1);">` : `<div class="l-sig-text" style="color:#f1f5f9;">${state.sigText}</div>`}
                                <div class="l-sig-lbl">${t('sig')}</div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        } else {
            frame.className = 'badge-preview-frame portrait';
            html = `
                <div class="tpl-portrait">
                    <div class="v-logo-box">
                        <div style="font-size:32px;font-weight:900;text-transform:uppercase;color:${state.accent}">${esc(state.company)}</div>
                    </div>
                    <div class="v-photo" style="${state.photo ? `background-image:url('${state.photo}');background-size:cover;background-position:center;` : 'background:linear-gradient(160deg,#e8edf5,#f1f5f9);display:flex;flex-direction:column;align-items:center;justify-content:flex-end;overflow:hidden;'}">
                        ${state.photo ? '' : `<i class="fas fa-user" style="font-size:220px; color:#c5cfe0; line-height:1; margin-bottom:-30px;"></i>`}
                    </div>
                    <div class="v-name">${esc(state.name)}</div>
                    <div class="v-role">${esc(state.role)}</div>
                    <div class="v-id-band">${esc(state.id)}</div>
                    <div class="v-details" dir="${isRTL ? 'rtl' : 'ltr'}">
                        <div class="l-det-it"><span class="l-det-lbl">${t('sex')}</span><span class="l-det-val">${state.sex}</span></div>
                        <div class="l-det-it"><span class="l-det-lbl">${t('blood')}</span><span class="l-det-val">${state.blood}</span></div>
                        <div class="l-det-it"><span class="l-det-lbl">${t('birth')}</span><span class="l-det-val">${state.birth}</span></div>
                        <div class="l-det-it"><span class="l-det-lbl">${t('place')}</span><span class="l-det-val">${esc(state.place)}</span></div>
                        <div class="l-det-it"><span class="l-det-lbl">${t('service')}</span><span class="l-det-val">${esc(state.service)}</span></div>
                        <div class="l-det-it"><span class="l-det-lbl">${t('expiry')}</span><span class="l-det-val" style="color:${state.accent};">${state.expiry}</span></div>
                    </div>
                    <div style="font-size:18px;font-weight:600;color:#64748b;margin-bottom:12px;" dir="${isRTL ? 'rtl' : 'ltr'}">
                        ${state.phone} | ${state.email}
                    </div>
                    <div class="l-sig-area">
                         ${state.sigImg ? `<img src="${state.sigImg}" class="l-sig-img" style="max-height:80px;">` : `<div class="l-sig-text" style="font-size:42px;">${state.sigText}</div>`}
                         <div class="l-sig-lbl">${t('sig')}</div>
                    </div>
                </div>
            `;
        }
        inner.innerHTML = html;
        resizePreview();
    };

    const resizePreview = () => {
        const frame = document.getElementById('badge-frame');
        const inner = document.getElementById('badge-inner');
        if (!frame || !inner) return;
        if (window.innerWidth > 992) {
            frame.style.width = '';
            frame.style.height = '';
            inner.style.transform = '';
            return;
        }
        const isPortrait = frame.classList.contains('portrait');
        const innerW = isPortrait ? 540 : 856;
        const innerH = isPortrait ? 856 : 540;
        const availW = frame.parentElement.clientWidth;
        const scale = availW / innerW;
        frame.style.width = availW + 'px';
        frame.style.height = (innerH * scale) + 'px';
        inner.style.transform = `scale(${scale})`;
    };
    window.addEventListener('resize', resizePreview);

    function removeWhiteBackground(dataUrl, callback) {
        const tmpImg = new Image();
        tmpImg.onload = function () {
            const canvas = document.createElement('canvas');
            canvas.width = tmpImg.width; canvas.height = tmpImg.height;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(tmpImg, 0, 0);
            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            const d = imageData.data, w = canvas.width, h = canvas.height;
            const samples = [0, w-1, (h-1)*w, (h-1)*w+(w-1), Math.floor(w/2), (h-1)*w+Math.floor(w/2)];
            let bgR=0,bgG=0,bgB=0,cnt=0;
            samples.forEach(p => { const i=p*4; bgR+=d[i]; bgG+=d[i+1]; bgB+=d[i+2]; cnt++; });
            bgR=Math.round(bgR/cnt); bgG=Math.round(bgG/cnt); bgB=Math.round(bgB/cnt);
            const brightness=(bgR+bgG+bgB)/3;
            const TOL = brightness>200?85:(brightness>160?70:55);
            const dist = (r,g,b) => Math.sqrt((bgR-r)**2+(bgG-g)**2+(bgB-b)**2);
            const visited = new Uint8Array(w*h);
            const stack = [];
            for(let x=0;x<w;x++){stack.push(x);stack.push(x+(h-1)*w);}
            for(let y=1;y<h-1;y++){stack.push(y*w);stack.push((w-1)+y*w);}
            while(stack.length){
                const pos=stack.pop(); if(visited[pos])continue; visited[pos]=1;
                if(dist(d[pos*4],d[pos*4+1],d[pos*4+2])>=TOL)continue;
                d[pos*4+3]=0;
                const x=pos%w,y=(pos/w)|0;
                if(x>0)stack.push(pos-1); if(x<w-1)stack.push(pos+1);
                if(y>0)stack.push(pos-w); if(y<h-1)stack.push(pos+w);
            }
            for(let pos=0;pos<w*h;pos++){
                if(visited[pos]||d[pos*4+3]===0)continue;
                const d2=dist(d[pos*4],d[pos*4+1],d[pos*4+2]);
                if(d2<TOL*1.5) d[pos*4+3]=Math.round(255*Math.min(1,Math.max(0,(d2-TOL)/(TOL*0.5))));
            }
            ctx.putImageData(imageData,0,0);
            callback(canvas.toDataURL('image/png'));
        };
        tmpImg.src = dataUrl;
    }

    // Events
    const inputs = ['name', 'role', 'service', 'company', 'id', 'birth', 'place', 'expiry', 'sex', 'blood', 'phone', 'email'];
    inputs.forEach(key => {
        const el = document.getElementById('inp-' + (key === 'birth' ? 'birth-date' : key === 'place' ? 'birth-place' : key));
        if(el) el.addEventListener('input', e => {
            state[key] = e.target.value;
            if (key === 'name' && !state.sigImg) state.sigText = nameToSig(e.target.value);
            updatePreview();
        });
    });

    document.getElementById('inp-tpl').addEventListener('change', e => { state.tpl = e.target.value; updatePreview(); });
    document.getElementById('inp-lang').addEventListener('change', e => { state.lang = e.target.value; updatePreview(); });

    const bindFile = (id, key) => {
        document.getElementById(id).addEventListener('change', function() {
            if (!this.files[0]) return;
            const r = new FileReader(); r.onload = e => { state[key] = e.target.result; updatePreview(); }; r.readAsDataURL(this.files[0]);
        });
    }
    bindFile('inp-photo', 'photo');
    document.getElementById('inp-sig-file').addEventListener('change', function() {
        if (!this.files[0]) { state.sigImg = null; state.sigText = nameToSig(state.name); updatePreview(); return; }
        const r = new FileReader();
        r.onload = e => removeWhiteBackground(e.target.result, processed => { state.sigImg = processed; updatePreview(); });
        r.readAsDataURL(this.files[0]);
    });

    document.querySelectorAll('.color-swatch').forEach(s => {
        s.addEventListener('click', () => {
            document.querySelectorAll('.color-swatch').forEach(x => x.classList.remove('active'));
            s.classList.add('active'); state.accent = s.dataset.color; updatePreview();
        });
    });

    document.getElementById('btn-download').addEventListener('click', async () => {
        const btn = document.getElementById('btn-download');
        let clone = null;
        try {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> GENERATION...';
            const badgeInner = document.getElementById('badge-inner');
            const target = badgeInner.firstElementChild;
            if (!target) throw new Error('Badge vide');

            // Cloner hors du conteneur transformé pour éviter les superpositions
            clone = target.cloneNode(true);
            clone.style.cssText = 'position:fixed;top:-9999px;left:-9999px;transform:none;z-index:-1;';
            document.body.appendChild(clone);

            const bgColor = state.tpl === 'tpl-dark' ? '#0f172a' : '#ffffff';
            const canvas = await html2canvas(clone, { scale: 3, useCORS: true, allowTaint: true, backgroundColor: bgColor });
            const link = document.createElement('a');
            link.download = `badge-${state.name.replace(/\s+/g,'-').toLowerCase() || 'agent'}.png`;
            link.href = canvas.toDataURL('image/png');
            link.click();
        } catch(e) {
            alert('Erreur lors du téléchargement. Veuillez réessayer.');
            console.error(e);
        } finally {
            if (clone) document.body.removeChild(clone);
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-file-download"></i> TELECHARGER LE BADGE';
        }
    });

    updatePreview();
});
</script>
@endpush
