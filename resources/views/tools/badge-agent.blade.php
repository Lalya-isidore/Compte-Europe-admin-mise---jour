@extends('layouts.admin')

@section('title', 'Générateur de Carte d\'Identité (CNI)')

@section('breadcrumb')
    <li class="breadcrumb-item"><i class="fas fa-tools me-1"></i>Outils</li>
    <li class="breadcrumb-item active">Générateur CNI</li>
@endsection

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Dancing+Script:wght@600&family=Roboto+Mono:wght@400;700&display=swap');

:root {
    --ce-primary: #0055A4; /* French Blue */
    --ce-bg: #f8fafc;
    --ce-card-bg: #ffffff;
    --ce-text: #1e293b;
    --ce-text-dim: #64748b;
    --ce-border: #e2e8f0;
}

.cni-wrap {
    font-family: 'Inter', sans-serif;
    color: var(--ce-text);
    padding: 24px;
}

.cni-header {
    margin-bottom: 32px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.cni-header h1 {
    font-size: 1.75rem;
    font-weight: 800;
    margin: 0;
    color: var(--ce-primary);
    display: flex;
    align-items: center;
    gap: 12px;
}

.cni-grid {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 32px;
    align-items: start;
}

.ce-card {
    background: var(--ce-card-bg);
    border-radius: 20px;
    border: 1px solid var(--ce-border);
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
}

.ce-card h3 {
    font-size: 1rem;
    font-weight: 700;
    margin: 0 0 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    color: var(--ce-primary);
    border-bottom: 1px solid var(--ce-border);
    padding-bottom: 12px;
}

.form-label {
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--ce-text-dim);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
}

.form-control {
    border: 1.5px solid var(--ce-border);
    border-radius: 12px;
    padding: 10px 14px;
    font-size: 0.9rem;
    transition: all .2s;
    background: #fbfcfe;
}

.form-control:focus {
    border-color: var(--ce-primary);
    box-shadow: 0 0 0 3px rgba(0, 85, 164, 0.1);
    background: #fff;
    outline: none;
}

/* Photo selection */
.photo-upload-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.photo-box {
    border: 2px dashed var(--ce-border);
    border-radius: 12px;
    padding: 16px;
    text-align: center;
    cursor: pointer;
    transition: all .2s;
    background: #fbfcfe;
}

.photo-box:hover {
    border-color: var(--ce-primary);
    background: #f0f7ff;
}

.photo-box img {
    width: 60px;
    height: 75px;
    object-fit: cover;
    border-radius: 4px;
    margin-bottom: 8px;
    display: none;
    border: 1px solid var(--ce-border);
}

.photo-box i {
    font-size: 24px;
    color: #cbd5e1;
    display: block;
    margin-bottom: 8px;
}

/* Preview area */
.preview-sticky {
    position: sticky;
    top: 100px;
}

.cni-frame {
    width: 380px;
    height: 240px;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    margin: 0 auto 24px;
    position: relative;
    border: 1px solid #ddd;
}

/* THE CARD DESIGN */
.cni-inner {
    width: 856px;
    height: 540px;
    background-image: url('{{ asset('images/tools/cni-bg.png') }}');
    background-size: cover;
    background-position: center;
    transform: scale(0.4439); /* 380/856 */
    transform-origin: top left;
    position: absolute;
    top: 0; left: 0;
    color: #0b1c3d;
    font-weight: 500;
}

.cni-header-strip {
    display: flex;
    justify-content: space-between;
    padding: 20px 40px;
    align-items: flex-start;
}

.cni-flag {
    width: 100px;
    height: 65px;
    background: linear-gradient(to right, #002395 33.3%, #ffffff 33.3%, #ffffff 66.6%, #ed2939 66.6%);
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.cni-title {
    text-align: center;
    flex: 1;
}

.cni-title h2 {
    font-size: 34px;
    font-weight: 900;
    margin: 0;
    letter-spacing: 2px;
}

.cni-title p {
    font-size: 20px;
    font-weight: 700;
    margin: -4px 0 0;
    opacity: 0.8;
}

.cni-rf-seal {
    width: 110px;
    height: 110px;
    background-image: url('{{ asset('images/tools/cni-rf-seal.png') }}');
    background-size: contain;
    background-repeat: no-repeat;
    margin-top: -10px;
}

.cni-main-content {
    display: grid;
    grid-template-columns: 260px 1fr;
    padding: 0 40px;
    gap: 30px;
}

.cni-photo-area {
    position: relative;
}

.cni-photo-placeholder {
    width: 240px;
    height: 300px;
    background: rgba(255,255,255,0.3);
    border: 1px solid rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 100px;
    color: rgba(0,0,0,0.1);
}

.cni-photo-img {
    width: 240px;
    height: 300px;
    object-fit: cover;
    display: none;
    filter: contrast(1.1) saturate(0.9);
}

.cni-info-fields {
    font-size: 19px;
    line-height: 1.25;
}

.cni-field {
    margin-bottom: 12px;
}

.cni-label {
    color: #4b628a;
    font-size: 16px;
    font-weight: 600;
    margin-right: 8px;
}

.cni-value {
    color: #0b1c3d;
    font-weight: 800;
    text-transform: uppercase;
}

.cni-footer-info {
    position: absolute;
    bottom: 60px;
    left: 40px;
    right: 40px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    font-size: 18px;
}

.cni-bottom-id {
    position: absolute;
    bottom: 20px;
    right: 40px;
    font-family: 'Roboto Mono', monospace;
    font-size: 20px;
    font-weight: 700;
}

.cni-watermark {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(-25deg);
    font-size: 60px;
    font-weight: 900;
    opacity: 0.04;
    white-space: nowrap;
    pointer-events: none;
    letter-spacing: 15px;
}

.cni-chip {
    position: absolute;
    bottom: 40px;
    left: 40px;
    width: 70px;
    height: 55px;
    background: linear-gradient(135deg, #f3d16b, #d4a72d);
    border-radius: 8px;
    border: 1px solid #b38a1a;
    mask-image: radial-gradient(circle at 50% 50%, black 60%, transparent 100%);
}

.signature-area {
    position: absolute;
    bottom: 30px;
    right: 60px;
    width: 200px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.signature-img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    filter: brightness(0.2) contrast(1.5);
    display: none;
}

.signature-text {
    font-family: 'Dancing Script', cursive;
    font-size: 32px;
    color: #111;
    text-align: center;
}

.signature-label {
    position: absolute;
    bottom: 10px;
    right: 60px;
    font-size: 14px;
    color: #4b628a;
    font-weight: 600;
}

/* Controls */
.btn-primary {
    background: var(--ce-primary);
    border: none;
    border-radius: 12px;
    padding: 14px;
    font-weight: 700;
    width: 100%;
    margin-bottom: 12px;
    box-shadow: 0 4px 12px rgba(0, 85, 164, 0.3);
}

.btn-secondary {
    background: #fff;
    color: var(--ce-text);
    border: 1px solid var(--ce-border);
    border-radius: 12px;
    padding: 12px;
    font-weight: 600;
    width: 100%;
}

@media (max-width: 992px) {
    .cni-grid { grid-template-columns: 1fr; }
    .preview-sticky { position: static; }
}
</style>

<div class="cni-wrap">
    <div class="cni-header">
        <h1><i class="fas fa-id-card"></i> Générateur de CNI Française</h1>
        <div class="badge bg-primary rounded-pill px-3 py-2">Modèle Officiel 2021</div>
    </div>

    <div class="cni-grid">
        <div class="cni-form-col">
            {{-- État Civil --}}
            <div class="ce-card">
                <h3><i class="fas fa-user"></i> État Civil</h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nom</label>
                        <input type="text" id="inp-nom" class="form-control" placeholder="ROBINSON FLUIT">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Prénoms</label>
                        <input type="text" id="inp-prenoms" class="form-control" placeholder="MARCK">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Né(e) le</label>
                        <input type="text" id="inp-birth-date" class="form-control" placeholder="01/01/1990">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">À (Lieu)</label>
                        <input type="text" id="inp-birth-place" class="form-control" placeholder="LYON (69)">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nationalité</label>
                        <input type="text" id="inp-nationality" class="form-control" placeholder="FRANÇAISE">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Taille (m)</label>
                        <input type="text" id="inp-height" class="form-control" placeholder="1,80 m">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Adresse</label>
                        <textarea id="inp-address" class="form-control" rows="2" placeholder="10 Rue de la République\n75001 PARIS"></textarea>
                    </div>
                </div>
            </div>

            {{-- Document --}}
            <div class="ce-card">
                <h3><i class="fas fa-file-invoice"></i> Détails du Document</h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">N° d'identité</label>
                        <input type="text" id="inp-id-num" class="form-control" placeholder="12AB34567">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date d'émission</label>
                        <input type="text" id="inp-issue-date" class="form-control" placeholder="01/01/2024">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date d'expiration</label>
                        <input type="text" id="inp-expiry-date" class="form-control" placeholder="01/01/2034">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Autorité</label>
                        <input type="text" id="inp-authority" class="form-control" placeholder="PRÉFECTURE DE PARIS">
                    </div>
                </div>
            </div>

            {{-- Médias --}}
            <div class="ce-card">
                <h3><i class="fas fa-camera"></i> Photos & Signature</h3>
                <div class="photo-upload-container">
                    <div class="photo-box" onclick="document.getElementById('file-photo').click()">
                        <img id="prev-photo" src="" alt="">
                        <i class="fas fa-user-plus"></i>
                        <span class="d-block text-muted small">Photo d'identité</span>
                        <input type="file" id="file-photo" hidden accept="image/*">
                    </div>
                    <div class="photo-box" onclick="document.getElementById('file-sig').click()">
                        <img id="prev-sig" src="" alt="">
                        <i class="fas fa-signature"></i>
                        <span class="d-block text-muted small">Importer Signature</span>
                        <input type="file" id="file-sig" hidden accept="image/*">
                    </div>
                </div>
                <div class="mt-3">
                    <label class="form-label">Ou Signature Texte (Style manuscrit)</label>
                    <input type="text" id="inp-sig-text" class="form-control" placeholder="Jean Gem">
                </div>
            </div>
        </div>

        <div class="preview-col">
            <div class="preview-sticky">
                <div class="d-flex align-items-center gap-2 mb-3 text-muted">
                    <i class="fas fa-eye"></i>
                    <span class="fw-bold small text-uppercase">Aperçu Haute Définition</span>
                </div>

                <div class="cni-frame" id="cni-frame">
                    <div class="cni-inner" id="cni-render">
                        <div class="cni-watermark">DOCUMENT OFFICIEL</div>
                        
                        <div class="cni-header-strip">
                            <div class="cni-flag"></div>
                            <div class="cni-title">
                                <h2>RÉPUBLIQUE FRANÇAISE</h2>
                                <p>CARTE D'IDENTITÉ - DOCUMENT OFFICIEL</p>
                            </div>
                            <div class="cni-rf-seal"></div>
                        </div>

                        <div class="cni-main-content">
                            <div class="cni-photo-area">
                                <div class="cni-photo-placeholder"><i class="fas fa-user"></i></div>
                                <img src="" class="cni-photo-img" id="pv-photo">
                            </div>

                            <div class="cni-info-fields">
                                <div class="cni-field">
                                    <span class="cni-label">Nom :</span>
                                    <span class="cni-value" id="pv-nom">ROBINSON FLUIT</span>
                                </div>
                                <div class="cni-field">
                                    <span class="cni-label">Prénoms :</span>
                                    <span class="cni-value" id="pv-prenoms">MARCK</span>
                                </div>
                                <div class="cni-field">
                                    <span class="cni-label">Né(e) le :</span>
                                    <span class="cni-value" id="pv-birth-date">01/01/1990</span>
                                    <span class="cni-label ms-4">À :</span>
                                    <span class="cni-value" id="pv-birth-place">LYON (69)</span>
                                </div>
                                <div class="cni-field">
                                    <span class="cni-label">Nationalité :</span>
                                    <span class="cni-value" id="pv-nationality">FRANÇAISE</span>
                                </div>
                                <div class="cni-field">
                                    <span class="cni-label">Taille :</span>
                                    <span class="cni-value" id="pv-height">1,80 m</span>
                                </div>
                                <div class="cni-field mt-3">
                                    <span class="cni-label">Adresse :</span>
                                    <span class="cni-value" id="pv-address" style="display:block; text-transform: none; line-height: 1.4;">10 Rue de la République<br>75001 PARIS</span>
                                </div>
                            </div>
                        </div>

                        <div class="cni-footer-info">
                            <div>
                                <span class="cni-label">Numéro d'identité :</span>
                                <span class="cni-value" id="pv-id-num">12AB34567</span>
                            </div>
                            <div>
                                <span class="cni-label">Date :</span>
                                <span class="cni-value" id="pv-date">01/01/2024</span>
                            </div>
                            <div class="mt-2">
                                <span class="cni-label">Date d'émission :</span>
                                <span class="cni-value" id="pv-issue-date">01/01/2024</span>
                            </div>
                            <div class="mt-2">
                                <span class="cni-label">Date d'expiration :</span>
                                <span class="cni-value" id="pv-expiry-date">01/01/2034</span>
                            </div>
                            <div class="col-span-2 mt-2">
                                <span class="cni-label">Autorité de délivrance :</span>
                                <span class="cni-value" id="pv-authority">PRÉFECTURE DE PARIS</span>
                            </div>
                        </div>

                        <div class="cni-chip"></div>

                        <div class="signature-area">
                            <img src="" class="signature-img" id="pv-sig-img">
                            <span class="signature-text" id="pv-sig-text">Jean Gem</span>
                        </div>
                        <span class="signature-label">Signature du titulaire</span>

                        <div class="cni-bottom-id" id="pv-id-bottom">12AB34567 <<<<<<<<<<< 01/01/2034</div>
                    </div>
                </div>

                <button class="btn btn-primary" id="btn-download">
                    <i class="fas fa-download me-2"></i> Télécharger la Carte (HD)
                </button>
                <p class="text-center text-muted small">Dimensions standard : 85.6mm × 54mm (ID-1)</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const render = document.getElementById('cni-render');

    // Helper formatting
    const formatValue = (val, def) => val.trim().toUpperCase() || def;

    // Field bindings
    const bindings = [
        { id: 'inp-nom',         pv: 'pv-nom',         def: 'ROBINSON FLUIT' },
        { id: 'inp-prenoms',     pv: 'pv-prenoms',     def: 'MARCK' },
        { id: 'inp-birth-date',  pv: 'pv-birth-date',  def: '01/01/1990' },
        { id: 'inp-birth-place', pv: 'pv-birth-place', def: 'LYON (69)' },
        { id: 'inp-nationality', pv: 'pv-nationality', def: 'FRANÇAISE' },
        { id: 'inp-height',      pv: 'pv-height',      def: '1,80 m' },
        { id: 'inp-id-num',      pv: 'pv-id-num',      def: '12AB34567' },
        { id: 'inp-issue-date',  pv: 'pv-issue-date',  def: '01/01/2024' },
        { id: 'inp-expiry-date', pv: 'pv-expiry-date', def: '01/01/2034' },
        { id: 'inp-authority',   pv: 'pv-authority',   def: 'PRÉFECTURE DE PARIS' },
    ];

    bindings.forEach(bind => {
        const inp = document.getElementById(bind.id);
        const pv = document.getElementById(bind.pv);
        inp.addEventListener('input', () => {
            const val = formatValue(inp.value, bind.def);
            pv.textContent = val;
            if(bind.id === 'inp-id-num') {
                document.getElementById('pv-id-bottom').textContent = `${val} <<<<<<<<<<< ${document.getElementById('inp-expiry-date').value || '01/01/2034'}`;
            }
            if(bind.id === 'inp-issue-date') {
                document.getElementById('pv-date').textContent = val;
            }
            if(bind.id === 'inp-expiry-date') {
                 const idNum = document.getElementById('inp-id-num').value || '12AB34567';
                 document.getElementById('pv-id-bottom').textContent = `${idNum} <<<<<<<<<<< ${val || '01/01/2034'}`;
            }
        });
    });

    // Special: Address
    const inpAddress = document.getElementById('inp-address');
    const pvAddress = document.getElementById('pv-address');
    inpAddress.addEventListener('input', () => {
        pvAddress.innerHTML = (inpAddress.value || '10 Rue de la République\n75001 PARIS').replace(/\n/g, '<br>');
    });

    // Photos
    const handleImage = (inpId, pvId, thumbId) => {
        const fileInp = document.getElementById(inpId);
        fileInp.addEventListener('change', function() {
            if (!this.files[0]) return;
            const reader = new FileReader();
            reader.onload = (e) => {
                document.getElementById(pvId).src = e.target.result;
                document.getElementById(pvId).style.display = 'block';
                if(thumbId) {
                    const thumb = document.getElementById(thumbId);
                    thumb.src = e.target.result;
                    thumb.style.display = 'block';
                    thumb.nextElementSibling.style.display = 'none'; // hide icon
                }
                if(inpId === 'file-sig') {
                    document.getElementById('pv-sig-text').style.display = 'none';
                }
            };
            reader.readAsDataURL(this.files[0]);
        });
    };

    handleImage('file-photo', 'pv-photo', 'prev-photo');
    handleImage('file-sig', 'pv-sig-img', 'prev-sig');

    // Signature Text
    const inpSigText = document.getElementById('inp-sig-text');
    const pvSigText = document.getElementById('pv-sig-text');
    const pvSigImg = document.getElementById('pv-sig-img');

    inpSigText.addEventListener('input', () => {
        if(inpSigText.value.trim()) {
            pvSigText.textContent = inpSigText.value;
            pvSigText.style.display = 'block';
            pvSigImg.style.display = 'none';
        } else if(!pvSigImg.src || pvSigImg.style.display === 'none') {
            pvSigText.textContent = 'Jean Gem';
            pvSigText.style.display = 'block';
        }
    });

    // Download
    document.getElementById('btn-download').addEventListener('click', async () => {
        const btn = document.getElementById('btn-download');
        const originalContent = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Génération...';
        btn.disabled = true;

        try {
            const canvas = await html2canvas(render, {
                scale: 3,
                useCORS: true,
                allowTaint: true,
                backgroundColor: null,
                width: 856,
                height: 540
            });

            const link = document.createElement('a');
            const nom = document.getElementById('inp-nom').value || 'CNI-FR';
            link.download = `${nom.toLowerCase().replace(/\s+/g, '-')}-identite.png`;
            link.href = canvas.toDataURL('image/png', 1.0);
            link.click();
        } catch (e) {
            alert('Erreur lors de la génération. Veuillez réessayer.');
            console.error(e);
        } finally {
            btn.innerHTML = originalContent;
            btn.disabled = false;
        }
    });
});
</script>
@endpush
