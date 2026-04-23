@extends('layouts.admin')

@section('title', 'Générateur de QR Code')

@section('breadcrumb')
    <li class="breadcrumb-item"><i class="fas fa-briefcase me-1"></i>Outils</li>
    <li class="breadcrumb-item active">Générateur de QR Code</li>
@endsection

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Cabin:wght@400;500;600;700&family=Righteous&display=swap');
@import url('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css');
@import url('https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css');

.qr-wrap { font-family: 'Cabin', sans-serif; }

.qr-wrap .page-title {
    background: white;
    box-shadow: 0 0 12px rgba(0,0,0,.14);
    font-family: 'Righteous', cursive;
    margin-bottom: 24px;
    padding: 20px;
    font-size: .9em;
    border-radius: 8px;
}
.qr-wrap .page-title a, .qr-wrap .page-title span {
    text-decoration: none; color: black; transition: 150ms;
}
.qr-wrap .page-title a:hover { color: #4f46e5; }

.qr-wrap .qr-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(0,0,0,.08);
    padding: 28px;
    max-width: 960px;
    margin: 0 auto;
}

.qr-wrap .qr-card-title {
    font-family: 'Righteous', cursive;
    color: #4f46e5;
    font-size: 1.1rem;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.qr-wrap .layout {
    display: flex;
    gap: 32px;
    align-items: flex-start;
    flex-wrap: wrap;
}
.qr-wrap .form-col { flex: 1 1 340px; min-width: 0; }
.qr-wrap .preview-col {
    flex: 0 0 260px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 16px;
}

.qr-wrap label { font-size: .88rem; font-weight: 600; color: #374151; margin-bottom: 4px; display: block; }
.qr-wrap .form-control, .qr-wrap .form-select {
    font-size: .9rem !important;
    border-radius: 8px !important;
    padding: 10px 14px !important;
}

.qr-wrap .color-row {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}
.qr-wrap .color-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
    flex: 1 1 100px;
}
.qr-wrap input[type="color"] {
    width: 100%;
    height: 44px;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    padding: 4px;
    cursor: pointer;
}

.qr-wrap .logo-upload-box {
    border: 2px dashed #d1d5db;
    border-radius: 10px;
    padding: 16px;
    text-align: center;
    cursor: pointer;
    transition: all 200ms;
    background: #fafafa;
    position: relative;
}
.qr-wrap .logo-upload-box:hover { border-color: #4f46e5; background: #f5f3ff; }
.qr-wrap .logo-upload-box input[type="file"] {
    position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
}
.qr-wrap .logo-preview {
    width: 48px; height: 48px; object-fit: contain; border-radius: 6px;
    display: none; margin: 0 auto 6px;
}
.qr-wrap .logo-upload-icon { font-size: 1.6rem; color: #9ca3af; margin-bottom: 4px; }
.qr-wrap .logo-upload-text { font-size: .82rem; color: #6b7280; }

.qr-wrap .preview-box {
    width: 220px; height: 220px;
    background: #f9fafb;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    display: flex; align-items: center; justify-content: center;
    overflow: hidden;
}
.qr-wrap .preview-box canvas, .qr-wrap .preview-box svg { max-width: 200px; max-height: 200px; }
.qr-wrap .preview-placeholder {
    text-align: center;
    color: #9ca3af;
    font-size: .85rem;
}
.qr-wrap .preview-placeholder i { font-size: 2.5rem; display: block; margin-bottom: 8px; }

.qr-wrap .btn-generate {
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    color: white;
    border: none;
    border-radius: 8px;
    padding: 12px 24px;
    font-size: .95rem;
    font-weight: 600;
    font-family: 'Cabin', sans-serif;
    width: 100%;
    cursor: pointer;
    transition: all 200ms;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    margin-top: 8px;
}
.qr-wrap .btn-generate:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(79,70,229,.4); }
.qr-wrap .btn-generate:active { transform: translateY(0); }

.qr-wrap .btn-download {
    background: #10b981;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 10px 20px;
    font-size: .88rem;
    font-weight: 600;
    font-family: 'Cabin', sans-serif;
    cursor: pointer;
    transition: all 200ms;
    display: none;
    align-items: center; justify-content: center; gap: 6px;
    width: 100%;
}
.qr-wrap .btn-download:hover { background: #059669; }
.qr-wrap .btn-download.visible { display: flex; }

.qr-wrap .dot-style-grid {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}
.qr-wrap .dot-style-btn {
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    padding: 6px 12px;
    font-size: .8rem;
    background: white;
    cursor: pointer;
    transition: all 150ms;
    font-family: 'Cabin', sans-serif;
    font-weight: 600;
    color: #374151;
}
.qr-wrap .dot-style-btn.active { border-color: #4f46e5; color: #4f46e5; background: #f5f3ff; }

.qr-wrap .free-badge {
    display: inline-flex; align-items: center; gap: 5px;
    background: #ecfdf5; color: #059669;
    border: 1px solid #a7f3d0;
    border-radius: 20px; padding: 4px 12px;
    font-size: .8rem; font-weight: 700;
    margin-left: auto;
}
</style>

<div class="qr-wrap">
    <div class="page-title">
        <a href="{{ route('dashboard') }}"><i class="fi fi-rr-home"></i></a>
        &nbsp;<i class="fi fi-rr-angle-right"></i>&nbsp;
        <a href="{{ route('dashboard') }}"><i class="fi fi-rr-tool-box"></i> Outils</a>
        &nbsp;<i class="fi fi-rr-angle-right"></i>&nbsp;
        <span><i class="bi bi-qr-code"></i> Générateur de QR Code</span>
    </div>

    <div class="qr-card">
        <div class="qr-card-title">
            <i class="bi bi-qr-code-scan"></i>
            Générateur de QR Code personnalisé
            <span class="free-badge"><i class="bi bi-check-circle-fill"></i> Gratuit</span>
        </div>

        <div class="layout">
            {{-- ===== FORMULAIRE ===== --}}
            <div class="form-col">
                <div class="mb-4">
                    <label for="qr-url"><i class="bi bi-link-45deg"></i> Lien à encoder <span style="color:red">*</span></label>
                    <input type="url" class="form-control" id="qr-url" placeholder="https://example.com" autocomplete="off">
                </div>

                <div class="mb-4">
                    <label><i class="bi bi-palette"></i> Couleurs</label>
                    <div class="color-row">
                        <div class="color-item">
                            <label style="font-size:.78rem;color:#6b7280">Modules (points)</label>
                            <input type="color" id="qr-color-dots" value="#000000">
                        </div>
                        <div class="color-item">
                            <label style="font-size:.78rem;color:#6b7280">Fond</label>
                            <input type="color" id="qr-color-bg" value="#ffffff">
                        </div>
                        <div class="color-item">
                            <label style="font-size:.78rem;color:#6b7280">Bords (carrés)</label>
                            <input type="color" id="qr-color-corners" value="#000000">
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label><i class="bi bi-grid-3x3"></i> Style des points</label>
                    <div class="dot-style-grid">
                        <button class="dot-style-btn active" data-style="square">Carré</button>
                        <button class="dot-style-btn" data-style="dots">Rond</button>
                        <button class="dot-style-btn" data-style="rounded">Arrondi</button>
                        <button class="dot-style-btn" data-style="classy">Classy</button>
                        <button class="dot-style-btn" data-style="classy-rounded">Classy+</button>
                    </div>
                </div>

                <div class="mb-4">
                    <label><i class="bi bi-image"></i> Logo au centre <span style="font-weight:400;color:#9ca3af">(facultatif)</span></label>
                    <div class="logo-upload-box" id="logo-upload-box">
                        <input type="file" id="qr-logo" accept="image/png,image/jpeg,image/svg+xml,image/webp">
                        <img id="logo-preview-img" class="logo-preview" src="" alt="">
                        <div class="logo-upload-icon" id="logo-icon"><i class="bi bi-cloud-arrow-up"></i></div>
                        <div class="logo-upload-text" id="logo-text">Cliquez pour ajouter un logo<br><span style="font-size:.75rem">PNG, JPG, SVG — Max 2 Mo</span></div>
                    </div>
                    <button type="button" id="btn-remove-logo" style="display:none;margin-top:6px;font-size:.8rem;border:none;background:none;color:#ef4444;cursor:pointer;padding:0">
                        <i class="bi bi-trash"></i> Supprimer le logo
                    </button>
                </div>

                <div class="mb-3">
                    <label for="qr-size"><i class="bi bi-arrows-fullscreen"></i> Taille (px)</label>
                    <select class="form-select" id="qr-size">
                        <option value="256">256 × 256</option>
                        <option value="512" selected>512 × 512</option>
                        <option value="1024">1024 × 1024</option>
                    </select>
                </div>

                <button class="btn-generate" id="btn-generate">
                    <i class="bi bi-qr-code"></i> Générer le QR Code
                </button>
            </div>

            {{-- ===== APERÇU ===== --}}
            <div class="preview-col">
                <div style="font-weight:700;font-size:.9rem;color:#374151;align-self:flex-start">Aperçu</div>
                <div class="preview-box" id="qr-preview-box">
                    <div class="preview-placeholder" id="qr-placeholder">
                        <i class="bi bi-qr-code"></i>
                        Le QR code<br>apparaîtra ici
                    </div>
                </div>
                <button class="btn-download" id="btn-download">
                    <i class="bi bi-download"></i> Télécharger (PNG)
                </button>
                <div id="qr-success-msg" style="display:none;font-size:.8rem;color:#059669;text-align:center">
                    <i class="bi bi-check-circle-fill"></i> QR Code généré avec succès !
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/qr-code-styling@1.6.0-rc.1/lib/qr-code-styling.js"></script>
<script>
(function () {
    var qrInstance = null;
    var logoDataUrl = null;
    var selectedDotStyle = 'square';

    // Dot style buttons
    document.querySelectorAll('.dot-style-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.dot-style-btn').forEach(function (b) { b.classList.remove('active'); });
            this.classList.add('active');
            selectedDotStyle = this.getAttribute('data-style');
        });
    });

    // Logo upload
    var logoInput = document.getElementById('qr-logo');
    var logoPreviewImg = document.getElementById('logo-preview-img');
    var logoIcon = document.getElementById('logo-icon');
    var logoText = document.getElementById('logo-text');
    var btnRemoveLogo = document.getElementById('btn-remove-logo');

    logoInput.addEventListener('change', function () {
        var file = this.files[0];
        if (!file) return;
        if (file.size > 2 * 1024 * 1024) { alert('Le logo ne doit pas dépasser 2 Mo.'); return; }
        var reader = new FileReader();
        reader.onload = function (e) {
            logoDataUrl = e.target.result;
            logoPreviewImg.src = logoDataUrl;
            logoPreviewImg.style.display = 'block';
            logoIcon.style.display = 'none';
            logoText.textContent = file.name;
            btnRemoveLogo.style.display = 'inline-block';
        };
        reader.readAsDataURL(file);
    });

    btnRemoveLogo.addEventListener('click', function () {
        logoDataUrl = null;
        logoInput.value = '';
        logoPreviewImg.style.display = 'none';
        logoPreviewImg.src = '';
        logoIcon.style.display = 'block';
        logoText.innerHTML = 'Cliquez pour ajouter un logo<br><span style="font-size:.75rem">PNG, JPG, SVG — Max 2 Mo</span>';
        btnRemoveLogo.style.display = 'none';
    });

    // Generate
    document.getElementById('btn-generate').addEventListener('click', function () {
        var url = document.getElementById('qr-url').value.trim();
        if (!url) { alert('Veuillez saisir un lien.'); return; }
        if (!/^https?:\/\//i.test(url)) { url = 'https://' + url; }

        var size = parseInt(document.getElementById('qr-size').value);
        var dotColor = document.getElementById('qr-color-dots').value;
        var bgColor = document.getElementById('qr-color-bg').value;
        var cornerColor = document.getElementById('qr-color-corners').value;

        var options = {
            width: size,
            height: size,
            type: 'canvas',
            data: url,
            dotsOptions: { color: dotColor, type: selectedDotStyle },
            backgroundOptions: { color: bgColor },
            cornersSquareOptions: { color: cornerColor },
            cornersDotOptions: { color: cornerColor },
            qrOptions: { errorCorrectionLevel: logoDataUrl ? 'H' : 'M' },
        };

        if (logoDataUrl) {
            options.image = logoDataUrl;
            options.imageOptions = { crossOrigin: 'anonymous', margin: 4, imageSize: 0.3 };
        }

        var previewBox = document.getElementById('qr-preview-box');
        document.getElementById('qr-placeholder').style.display = 'none';

        // Nettoyer l'ancien QR
        var old = previewBox.querySelector('canvas');
        if (old) old.remove();

        qrInstance = new QRCodeStyling(options);
        qrInstance.append(previewBox);

        document.getElementById('btn-download').classList.add('visible');
        var msg = document.getElementById('qr-success-msg');
        msg.style.display = 'block';
        setTimeout(function () { msg.style.display = 'none'; }, 3000);
    });

    // Download
    document.getElementById('btn-download').addEventListener('click', function () {
        if (!qrInstance) return;
        qrInstance.download({ name: 'qr-code', extension: 'png' });
    });
})();
</script>
@endpush
@endsection
