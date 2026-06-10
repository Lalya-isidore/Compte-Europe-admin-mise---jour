@extends('layouts.admin')

@section('title', 'Gestion des Comptes - Flash Compte')

@section('breadcrumb')
@endsection

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Cabin:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,400&family=Righteous&family=Roboto+Condensed:ital,wght@0,300;0,400;0,700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&display=swap');
@import url('https://cdn-uicons.flaticon.com/uicons-solid-rounded/css/uicons-solid-rounded.css');
@import url('https://cdn-uicons.flaticon.com/uicons-bold-rounded/css/uicons-bold-rounded.css');
@import url('https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css');
@import url('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css');

.fcp-wrap * { box-sizing: border-box; outline: none; }
.fcp-wrap { font-family: 'Cabin', sans-serif; }

/* Hide default layout alerts – this page uses custom modals */
.alert.alert-success.alert-dismissible,
.alert.alert-danger.alert-dismissible,
.alert.alert-info.alert-dismissible,
.alert.alert-warning.alert-dismissible { display: none !important; }

/* Page title */
.fcp-wrap .page-title {
    background-color: white;
    box-shadow: 0 0 12px 0px rgba(0,0,0,.14);
    font-family: 'Righteous', cursive;
    margin-bottom: 20px;
    padding: 20px;
    font-size: .9em;
    border-radius: 8px;
}
.fcp-wrap .page-title a, .fcp-wrap .page-title span {
    text-decoration: none; color: black; transition: all 150ms ease;
}
.fcp-wrap .page-title a:hover { color: #4285f4; }

/* U-data layout */
.fcp-wrap .u-data {
    position: relative;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    margin: 0 0 20px;
}
.fcp-wrap .u-data > div {
    position: relative;
    width: 49%;
    background-color: white;
    padding-bottom: 20px;
    border-radius: 8px;
    box-shadow: 0 0 12px 0px rgba(0,0,0,.08);
}
.fcp-wrap .u-title {
    font-family: 'Righteous', cursive;
    padding: 20px;
    border-bottom: 1px solid #e2e2e2;
    border-radius: 8px 8px 0 0;
}
.fcp-wrap .u-content { padding: 20px 10px; }
.fcp-wrap .ud-1 .u-title { color: #0d6efd !important; }
.fcp-wrap .ud-2 .u-title { color: #ff9214 !important; }

/* Credits badge */
.fcp-wrap .r-balance { margin-bottom: 20px; }
.fcp-wrap .r-about {
    color: #4285f4; margin-left: 10px; text-decoration: underline; cursor: pointer;
}
.fcp-wrap .r-about:hover { color: #4285f480; }

/* Tool info button */
.fcp-wrap .tool-info span {
    position: relative; display: inline-block; border: none;
    background-color: #4f429b; box-shadow: 0 0 12px rgba(0,0,0,.12);
    font-size: .9em; font-family: 'Cabin', sans-serif; text-align: center;
    border-radius: 4px; padding: 10px 20px; transition: all 200ms ease;
    user-select: none; color: white; cursor: pointer;
}
.fcp-wrap .tool-info span:hover { transform: scale(1.02); }
.fcp-wrap .tool-info span:active { transform: scale(.98); }
.fcp-wrap .tool-info span i { position: relative; top: 1px; }

/* Forms */
.fcp-wrap form {
    box-shadow: 0 0 12px 0 rgba(0,0,0,.15);
    border-radius: 4px;
    padding: 10px;
    margin-top: 40px;
}
.fcp-wrap .form-real { border: 1px solid #198754; }
.fcp-wrap .form-test { border: 1px solid #0d6efd; }
.fcp-wrap #form-lock { border: 1px solid #ff8900; }
.fcp-wrap .ttb-title {
    position: relative; top: -30px; display: inline-block;
    background-color: white; padding: 10px; border-radius: 4px;
    left: 10px; box-shadow: 0 0 12px 0 rgba(0,0,0,.15);
    font-family: 'Roboto Condensed', sans-serif;
}
.fcp-wrap .form-real .ttb-title { color: #198754; border: 1px solid #198754; }
.fcp-wrap .form-test .ttb-title { color: #0d6efd; border: 1px solid #0d6efd; }
.fcp-wrap .info-cl {
    padding: 0 !important; border-radius: 4px; margin: 0 auto 30px !important;
}
.fcp-wrap label { font-size: .9em; color: #555; }
.fcp-wrap input { font-size: .9em !important; padding: 10px !important; font-family: 'Roboto', sans-serif; }
.fcp-wrap #buy-credit label { display: block; margin: 10px 0 5px; }
.fcp-wrap textarea.form-control { min-height: 100px !important; }

/* Alert info */
.fcp-wrap .alert { font-family: 'Cabin', sans-serif; font-size: .9em; margin-bottom: 20px; }

/* History items */
.fcp-wrap .history-item {
    font-family: 'Cabin', sans-serif; font-size: .9em; padding: 10px;
    border-bottom: 1px solid #e2e2e2; background-color: #e2e2e275;
    transition: all 200ms ease; cursor: pointer;
}
.fcp-wrap .history-item:hover { background-color: #d4d4d4; }
.fcp-wrap .history-item:active { background-color: #e2e2e2; }

/* Btn group action */
.fcp-wrap .btn-group-action { position: relative; display: flex; flex-wrap: nowrap; }
.fcp-wrap .btn-group-action > a, .fcp-wrap .btn-group-action > button { display: inline-block; width: 48%; line-height: 16px; font-size: .96em; padding: 10px; }
.fcp-wrap .btn-group-action > .btn-1 { margin: 0 1% 10px 0; }
.fcp-wrap .btn-group-action > .btn-2 { margin: 0 0 10px 1%; }

/* delete link */
.fcp-wrap .delete-link { margin-top: 20px !important; font-size: 1em; }
.fcp-wrap .fcp-badge-dark {
    background: linear-gradient(135deg, #f0ebff 0%, #e8f0ff 100%) !important;
    color: #3b0764 !important;
    font-family: 'Roboto Mono', 'Courier New', monospace !important;
    font-weight: 700 !important;
    padding: 10px 20px 10px 28px !important;
    border-radius: 10px !important;
    letter-spacing: 8px !important;
    font-size: 1.35rem !important;
    display: inline-block !important;
    border: 1.5px solid #c4b5fd !important;
    box-shadow: 0 2px 8px rgba(107,72,231,0.13) !important;
    vertical-align: middle !important;
    user-select: all !important;
    cursor: text !important;
}

/* Link display */
.fcp-wrap #link-app { font-family: 'Cabin', sans-serif !important; }
.fcp-wrap .fcp-badge { 
    display: inline-block !important; padding: 4px 12px !important; 
    border-radius: 4px !important; font-size: 0.75rem !important; 
    font-weight: 700 !important; text-transform: uppercase !important; 
    line-height: 1.4 !important;
}
.fcp-wrap .fcp-badge-orange { background: #ff8900 !important; color: #fff !important; }
.fcp-wrap .fcp-badge-purple { background: #6f42c1 !important; color: #fff !important; }
.fcp-wrap .fcp-badge-green  { background: #198754 !important; color: #fff !important; }
.fcp-wrap .fcp-badge-red    { background: #dc3545 !important; color: #fff !important; }

/* Global Loading Container */
#fcp-loading {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background-color: rgba(255, 255, 255, 0.4); 
    backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);
    z-index: 99999; text-align: center; transition: all 300ms ease;
    visibility: hidden; opacity: 0; display: flex;
    flex-direction: column; align-items: center; justify-content: center; gap: 15px;
    pointer-events: none;
}
#fcp-loading.active {
    visibility: visible; opacity: 1; pointer-events: all;
}
.fcp-spinner {
    width: 60px; height: 60px; border: 5px solid #f3f3f3;
    border-top: 5px solid #667eea; border-radius: 50%;
    animation: spin 1s linear infinite;
    box-shadow: 0 0 15px rgba(102, 126, 234, 0.2);
}
@keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
.fcp-loading-text { font-weight: 600; color: #4b5563; font-size: 1.1rem; letter-spacing: 0.5px; }

/* Popover */
.fcp-wrap .popover-header { font-size: .86em !important; font-family: 'Cabin', sans-serif !important; font-weight: bold !important; }
.fcp-wrap .popover-body { font-size: .8em !important; font-family: 'Cabin', sans-serif !important; letter-spacing: .5px !important; }

/* Responsive */
@media screen and (max-width: 768px) {
    .fcp-wrap .u-data > div { width: 100%; margin-bottom: 20px; }
}
@media screen and (max-width: 500px) {
    .fcp-wrap .delete-link { max-width: 60%; line-height: 17px !important; padding: 8px 16px !important; }
    .fcp-wrap .btn-group-action > a, .fcp-wrap .btn-group-action > button { font-size: .82em; }
}

/* Modal */
.fcp-wrap .modal-footer { justify-content: flex-start !important; }
</style>


<div class="fcp-wrap" id="fcp-account">
    {{-- Breadcrumb title --}}
    <div class="page-title">
        <a href="{{ route('dashboard') }}"><i class="fi fi-rr-home"></i></a>
        &nbsp;<i class="fi fi-rr-angle-right"></i>&nbsp;
        <a href="{{ route('dashboard') }}"><i class="fi fi-rr-tool-box"></i> Outils</a>
        &nbsp;<i class="fi fi-rr-angle-right"></i>&nbsp;
        <span><i class="fi fi-rr-data-transfer"></i> Flash Compte Pro</span>
    </div>

    <div class="u-data">
        {{-- ======== COLONNE GAUCHE : Formulaires ======== --}}
        <div class="ud-1">
            <div class="u-title">
                <span><i class="fi fi-rr-data-transfer"></i> Flash Compte Pro</span>
            </div>
            <div class="u-content">
                <p class="r-balance">
                    <span>Crédit(s) disponible : <b>{{ number_format($availableCredits, 0, ',', ' ') }}</b></span>
                    <span class="r-about" data-bs-toggle="tooltip" data-bs-placement="bottom"
                          title="1 Crédit = 1 F CFA" tabindex="0">à savoir</span>
                </p>

                <p class="tool-info">
                    <span data-bs-toggle="modal" data-bs-target="#fcpHelpModal">
                        <i class="fi fi-rr-info"></i> Utilité et Fonctionnement<i class="bi bi-arrow-right-short"></i>
                    </span>
                </p>

                {{-- Info block --}}
                <div class="alert alert-primary" role="alert">
                    <p><i class="bi bi-info-circle"></i> Cet outil vous permet de créer des <b>accès flash compte</b> pour vos clients. Fonctionnalités disponibles : <b>(Solde de compte, Crédit/Débit, Remboursement, Carte virtuelle, Virement, Profil client, Alertes SMS et e-mail en temps réel).</b></p>
                    <b>NB :</b> Un accès <b>Flash Compte Pro</b> coûte <b>4000 crédits</b> (+ 1000 crédits pour les alertes SMS, les alertes e-mail sont gratuites).
                </div>

                {{-- ============ LIENS DE TEST ============ --}}
                @php
                    $testToken = 'test.' . base64_encode(Auth::id());
                    $testBaseUrlEurope = config('regions.europe.client_login_url', 'http://localhost/public_html');
                    $testBaseUrlAfrique = config('regions.afrique.client_login_url', 'http://localhost/public_html_Afriques');
                    $testLinkEurope = rtrim($testBaseUrlEurope, '/') . '/?c=' . $testToken . '&hash=ok';
                    $testLinkAfrique = rtrim($testBaseUrlAfrique, '/') . '/?c=' . $testToken . '&hash=ok';
                @endphp
                <p style="margin-top:15px;font-size:.92em;color:#555;">Une vidéo explicative du fonctionnement :</p>
                <div style="margin-bottom:20px;">
                    <a href="{{ route('tools.flash-compte-pro.video') }}" target="_blank" style="
                        display:inline-flex;align-items:center;gap:8px;width:100%;
                        background:#f8f5ff;border:1px solid #d0c4f7;color:#4f429b;
                        border-radius:8px;padding:12px 18px;font-size:.9em;
                        font-family:'Cabin',sans-serif;text-decoration:none;
                        transition:all 200ms ease;justify-content:space-between;
                    " onmouseover="this.style.background='#ede9ff'" onmouseout="this.style.background='#f8f5ff'">
                        <span style="display:flex;align-items:center;gap:8px;">
                            <i class="bi bi-play-circle-fill" style="font-size:1.1rem"></i>
                            Regarder la vidéo
                        </span>
                        <i class="bi bi-arrow-right-short" style="font-size:1.1rem"></i>
                    </a>
                </div>

                <p style="margin-top:15px;font-size:.92em;color:#555;">Vos liens de test personnel :</p>

                <div style="margin-bottom:16px;">
                    <small style="color:#888;font-weight:600;">EUROPE</small>
                    <div style="background:#f5f7fb;border:1px solid #e2e7f0;border-radius:8px;padding:12px 16px;margin:6px 0;font-size:.9em;font-family:'Roboto',monospace;word-break:break-all;color:#333;">
                        {{ $testLinkEurope }}
                    </div>
                    <div style="text-align:right;">
                        <a href="{{ $testLinkEurope }}" target="_blank" rel="noopener"
                           style="display:inline-block;background:#2563eb;color:#fff;padding:8px 18px;border-radius:6px;text-decoration:none;font-size:.88em;font-weight:600;">
                            Tester le système flash compte Europe &rarr;
                        </a>
                    </div>
                </div>

                <div style="margin-bottom:40px;">
                    <small style="color:#888;font-weight:600;">AFRIQUE</small>
                    <div style="background:#fef9f0;border:1px solid #f0dbb0;border-radius:8px;padding:12px 16px;margin:6px 0;font-size:.9em;font-family:'Roboto',monospace;word-break:break-all;color:#333;">
                        {{ $testLinkAfrique }}
                    </div>
                    <div style="text-align:right;">
                        <a href="{{ $testLinkAfrique }}" target="_blank" rel="noopener"
                           style="display:inline-block;background:#d97706;color:#fff;padding:8px 18px;border-radius:6px;text-decoration:none;font-size:.88em;font-weight:600;">
                            Tester le système flash compte Afrique &rarr;
                        </a>
                    </div>
                </div>

                {{-- ============ FORMULAIRE CRÉER ============ --}}
                <form method="POST" action="{{ route('compte.store') }}" class="form-real" id="form-create" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="account_type" value="Professionnel">
                    <input type="hidden" name="transfer_supported" value="Oui">
                    <div class="ttb-title"><i class="fi fi-br-layer-plus"></i> Créer un accès flash compte client</div>

                    <div class="info-cl">
                        <label class="form-label" style="font-size:1em !important;color:black !important">Région du compte :</label>
                        <div class="mb-3">
                            <label for="compte_region" class="form-label">Sélectionner la région . <i style="color:red">requis</i></label>
                            <select class="form-select" name="compte_region" id="compte_region" required onchange="document.getElementById('region-hint').textContent = this.value === 'afrique' ? 'Pour les clients vivant en Afrique' : 'Pour les clients vivant en Europe, Amérique et Asie'">
                                <option value="europe" {{ old('compte_region') == 'europe' ? 'selected' : '' }}>Europe</option>
                                <option value="afrique" {{ old('compte_region') == 'afrique' ? 'selected' : '' }}>Afrique</option>
                            </select>
                            <small id="region-hint" class="form-text text-muted">Pour les clients vivant en Europe, Amérique et Asie</small>
                        </div>
                    </div>

                    <div class="info-cl">
                        <label class="form-label" style="font-size:1em !important;color:black !important">Informations sur le client :</label>
                        <div class="row" style="margin-bottom:20px !important">
                            <div class="col">
                                <label for="nom" class="form-label">Nom . <i style="color:red">requis</i></label>
                                <input type="text" class="form-control" placeholder="*********" autocapitalize="words"
                                       id="nom" name="nom" value="{{ old('nom') }}" required>
                                @error('nom')
                                    <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="prenom" class="form-label">Prénom . <i style="color:red">requis</i></label>
                                <input type="text" class="form-control" placeholder="**********" autocapitalize="words"
                                       id="prenom" name="prenom" value="{{ old('prenom') }}" required>
                                @error('prenom')
                                    <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="country" class="form-label">Pays de résidence . <i style="color:red">requis</i></label>
                            <select class="form-select" name="country" required id="country">
                                <option disabled>Sélectionnez un pays</option>
                                <optgroup label="Afrique">
                                <option value="Afrique du Sud (+27)" data-tel="+27" data-code="ZA">🇿🇦 Afrique du Sud (+27)</option>
                                <option value="Algérie (+213)" data-tel="+213" data-code="DZ">🇩🇿 Algérie (+213)</option>
                                <option value="Angola (+244)" data-tel="+244" data-code="AO">🇦🇴 Angola (+244)</option>
                                <option value="Bénin (+229)" data-tel="+229" data-code="BJ">🇧🇯 Bénin (+229)</option>
                                <option value="Botswana (+267)" data-tel="+267" data-code="BW">🇧🇼 Botswana (+267)</option>
                                <option value="Burkina Faso (+226)" data-tel="+226" data-code="BF">🇧🇫 Burkina Faso (+226)</option>
                                <option value="Burundi (+257)" data-tel="+257" data-code="BI">🇧🇮 Burundi (+257)</option>
                                <option value="Cabo Verde (+238)" data-tel="+238" data-code="CV">🇨🇻 Cabo Verde (+238)</option>
                                <option value="Cameroun (+237)" data-tel="+237" data-code="CM">🇨🇲 Cameroun (+237)</option>
                                <option value="Centrafrique (+236)" data-tel="+236" data-code="CF">🇨🇫 Centrafrique (+236)</option>
                                <option value="Comores (+269)" data-tel="+269" data-code="KM">🇰🇲 Comores (+269)</option>
                                <option value="Congo-Brazzaville (+242)" data-tel="+242" data-code="CG">🇨🇬 Congo-Brazzaville (+242)</option>
                                <option value="Côte d'Ivoire (+225)" data-tel="+225" data-code="CI">🇨🇮 Côte d'Ivoire (+225)</option>
                                <option value="Djibouti (+253)" data-tel="+253" data-code="DJ">🇩🇯 Djibouti (+253)</option>
                                <option value="Égypte (+20)" data-tel="+20" data-code="EG">🇪🇬 Égypte (+20)</option>
                                <option value="Érythrée (+291)" data-tel="+291" data-code="ER">🇪🇷 Érythrée (+291)</option>
                                <option value="Eswatini (+268)" data-tel="+268" data-code="SZ">🇸🇿 Eswatini (+268)</option>
                                <option value="Éthiopie (+251)" data-tel="+251" data-code="ET">🇪🇹 Éthiopie (+251)</option>
                                <option value="Gabon (+241)" data-tel="+241" data-code="GA">🇬🇦 Gabon (+241)</option>
                                <option value="Gambie (+220)" data-tel="+220" data-code="GM">🇬🇲 Gambie (+220)</option>
                                <option value="Ghana (+233)" data-tel="+233" data-code="GH">🇬🇭 Ghana (+233)</option>
                                <option value="Guinée (+224)" data-tel="+224" data-code="GN">🇬🇳 Guinée (+224)</option>
                                <option value="Guinée-Bissau (+245)" data-tel="+245" data-code="GW">🇬🇼 Guinée-Bissau (+245)</option>
                                <option value="Guinée équatoriale (+240)" data-tel="+240" data-code="GQ">🇬🇶 Guinée équatoriale (+240)</option>
                                <option value="Kenya (+254)" data-tel="+254" data-code="KE">🇰🇪 Kenya (+254)</option>
                                <option value="Lesotho (+266)" data-tel="+266" data-code="LS">🇱🇸 Lesotho (+266)</option>
                                <option value="Libéria (+231)" data-tel="+231" data-code="LR">🇱🇷 Libéria (+231)</option>
                                <option value="Libye (+218)" data-tel="+218" data-code="LY">🇱🇾 Libye (+218)</option>
                                <option value="Madagascar (+261)" data-tel="+261" data-code="MG">🇲🇬 Madagascar (+261)</option>
                                <option value="Malawi (+265)" data-tel="+265" data-code="MW">🇲🇼 Malawi (+265)</option>
                                <option value="Mali (+223)" data-tel="+223" data-code="ML">🇲🇱 Mali (+223)</option>
                                <option value="Maroc (+212)" data-tel="+212" data-code="MA">🇲🇦 Maroc (+212)</option>
                                <option value="Maurice (+230)" data-tel="+230" data-code="MU">🇲🇺 Maurice (+230)</option>
                                <option value="Mauritanie (+222)" data-tel="+222" data-code="MR">🇲🇷 Mauritanie (+222)</option>
                                <option value="Mozambique (+258)" data-tel="+258" data-code="MZ">🇲🇿 Mozambique (+258)</option>
                                <option value="Namibie (+264)" data-tel="+264" data-code="NA">🇳🇦 Namibie (+264)</option>
                                <option value="Niger (+227)" data-tel="+227" data-code="NE">🇳🇪 Niger (+227)</option>
                                <option value="Nigéria (+234)" data-tel="+234" data-code="NG">🇳🇬 Nigéria (+234)</option>
                                <option value="Ouganda (+256)" data-tel="+256" data-code="UG">🇺🇬 Ouganda (+256)</option>
                                <option value="RD Congo (+243)" data-tel="+243" data-code="CD">🇨🇩 RD Congo (+243)</option>
                                <option value="Rwanda (+250)" data-tel="+250" data-code="RW">🇷🇼 Rwanda (+250)</option>
                                <option value="São Tomé-et-Príncipe (+239)" data-tel="+239" data-code="ST">🇸🇹 São Tomé-et-Príncipe (+239)</option>
                                <option value="Sénégal (+221)" data-tel="+221" data-code="SN">🇸🇳 Sénégal (+221)</option>
                                <option value="Seychelles (+248)" data-tel="+248" data-code="SC">🇸🇨 Seychelles (+248)</option>
                                <option value="Sierra Leone (+232)" data-tel="+232" data-code="SL">🇸🇱 Sierra Leone (+232)</option>
                                <option value="Somalie (+252)" data-tel="+252" data-code="SO">🇸🇴 Somalie (+252)</option>
                                <option value="Soudan (+249)" data-tel="+249" data-code="SD">🇸🇩 Soudan (+249)</option>
                                <option value="Soudan du Sud (+211)" data-tel="+211" data-code="SS">🇸🇸 Soudan du Sud (+211)</option>
                                <option value="Tanzanie (+255)" data-tel="+255" data-code="TZ">🇹🇿 Tanzanie (+255)</option>
                                <option value="Tchad (+235)" data-tel="+235" data-code="TD">🇹🇩 Tchad (+235)</option>
                                <option value="Togo (+228)" data-tel="+228" data-code="TG">🇹🇬 Togo (+228)</option>
                                <option value="Tunisie (+216)" data-tel="+216" data-code="TN">🇹🇳 Tunisie (+216)</option>
                                <option value="Zambie (+260)" data-tel="+260" data-code="ZM">🇿🇲 Zambie (+260)</option>
                                <option value="Zimbabwe (+263)" data-tel="+263" data-code="ZW">🇿🇼 Zimbabwe (+263)</option>
                                </optgroup>
                                <optgroup label="Europe">
                                <option value="Allemagne (+49)" data-tel="+49" data-code="DE">🇩🇪 Allemagne (+49)</option>
                                <option value="Autriche (+43)" data-tel="+43" data-code="AT">🇦🇹 Autriche (+43)</option>
                                <option value="Belgique (+32)" data-tel="+32" data-code="BE">🇧🇪 Belgique (+32)</option>
                                <option value="Bulgarie (+359)" data-tel="+359" data-code="BG">🇧🇬 Bulgarie (+359)</option>
                                <option value="Croatie (+385)" data-tel="+385" data-code="HR">🇭🇷 Croatie (+385)</option>
                                <option value="Danemark (+45)" data-tel="+45" data-code="DK">🇩🇰 Danemark (+45)</option>
                                <option value="Espagne (+34)" data-tel="+34" data-code="ES">🇪🇸 Espagne (+34)</option>
                                <option value="Finlande (+358)" data-tel="+358" data-code="FI">🇫🇮 Finlande (+358)</option>
                                <option value="France (+33)" data-tel="+33" data-code="FR" selected>🇫🇷 France (+33)</option>
                                <option value="Grèce (+30)" data-tel="+30" data-code="GR">🇬🇷 Grèce (+30)</option>
                                <option value="Hongrie (+36)" data-tel="+36" data-code="HU">🇭🇺 Hongrie (+36)</option>
                                <option value="Irlande (+353)" data-tel="+353" data-code="IE">🇮🇪 Irlande (+353)</option>
                                <option value="Islande (+354)" data-tel="+354" data-code="IS">🇮🇸 Islande (+354)</option>
                                <option value="Italie (+39)" data-tel="+39" data-code="IT">🇮🇹 Italie (+39)</option>
                                <option value="Luxembourg (+352)" data-tel="+352" data-code="LU">🇱🇺 Luxembourg (+352)</option>
                                <option value="Norvège (+47)" data-tel="+47" data-code="NO">🇳🇴 Norvège (+47)</option>
                                <option value="Pays-Bas (+31)" data-tel="+31" data-code="NL">🇳🇱 Pays-Bas (+31)</option>
                                <option value="Pologne (+48)" data-tel="+48" data-code="PL">🇵🇱 Pologne (+48)</option>
                                <option value="Portugal (+351)" data-tel="+351" data-code="PT">🇵🇹 Portugal (+351)</option>
                                <option value="République tchèque (+420)" data-tel="+420" data-code="CZ">🇨🇿 République tchèque (+420)</option>
                                <option value="Roumanie (+40)" data-tel="+40" data-code="RO">🇷🇴 Roumanie (+40)</option>
                                <option value="Royaume-Uni (+44)" data-tel="+44" data-code="GB">🇬🇧 Royaume-Uni (+44)</option>
                                <option value="Russie (+7)" data-tel="+7" data-code="RU">🇷🇺 Russie (+7)</option>
                                <option value="Suède (+46)" data-tel="+46" data-code="SE">🇸🇪 Suède (+46)</option>
                                <option value="Suisse (+41)" data-tel="+41" data-code="CH">🇨🇭 Suisse (+41)</option>
                                <option value="Turquie (+90)" data-tel="+90" data-code="TR">🇹🇷 Turquie (+90)</option>
                                <option value="Ukraine (+380)" data-tel="+380" data-code="UA">🇺🇦 Ukraine (+380)</option>
                                </optgroup>
                                <optgroup label="Amérique">
                                <option value="Argentine (+54)" data-tel="+54" data-code="AR">🇦🇷 Argentine (+54)</option>
                                <option value="Brésil (+55)" data-tel="+55" data-code="BR">🇧🇷 Brésil (+55)</option>
                                <option value="Canada (+1)" data-tel="+1" data-code="CA">🇨🇦 Canada (+1)</option>
                                <option value="Chili (+56)" data-tel="+56" data-code="CL">🇨🇱 Chili (+56)</option>
                                <option value="Colombie (+57)" data-tel="+57" data-code="CO">🇨🇴 Colombie (+57)</option>
                                <option value="Costa Rica (+506)" data-tel="+506" data-code="CR">🇨🇷 Costa Rica (+506)</option>
                                <option value="Cuba (+53)" data-tel="+53" data-code="CU">🇨🇺 Cuba (+53)</option>
                                <option value="Équateur (+593)" data-tel="+593" data-code="EC">🇪🇨 Équateur (+593)</option>
                                <option value="États-Unis (+1)" data-tel="+1" data-code="US">🇺🇸 États-Unis (+1)</option>
                                <option value="Guatemala (+502)" data-tel="+502" data-code="GT">🇬🇹 Guatemala (+502)</option>
                                <option value="Haïti (+509)" data-tel="+509" data-code="HT">🇭🇹 Haïti (+509)</option>
                                <option value="Honduras (+504)" data-tel="+504" data-code="HN">🇭🇳 Honduras (+504)</option>
                                <option value="Jamaïque (+1876)" data-tel="+1876" data-code="JM">🇯🇲 Jamaïque (+1876)</option>
                                <option value="Mexique (+52)" data-tel="+52" data-code="MX">🇲🇽 Mexique (+52)</option>
                                <option value="Panama (+507)" data-tel="+507" data-code="PA">🇵🇦 Panama (+507)</option>
                                <option value="Paraguay (+595)" data-tel="+595" data-code="PY">🇵🇾 Paraguay (+595)</option>
                                <option value="Pérou (+51)" data-tel="+51" data-code="PE">🇵🇪 Pérou (+51)</option>
                                <option value="République dominicaine (+1809)" data-tel="+1809" data-code="DO">🇩🇴 République dominicaine (+1809)</option>
                                <option value="Uruguay (+598)" data-tel="+598" data-code="UY">🇺🇾 Uruguay (+598)</option>
                                <option value="Venezuela (+58)" data-tel="+58" data-code="VE">🇻🇪 Venezuela (+58)</option>
                                </optgroup>
                                <optgroup label="Asie">
                                <option value="Arabie Saoudite (+966)" data-tel="+966" data-code="SA">🇸🇦 Arabie Saoudite (+966)</option>
                                <option value="Chine (+86)" data-tel="+86" data-code="CN">🇨🇳 Chine (+86)</option>
                                <option value="Corée du Sud (+82)" data-tel="+82" data-code="KR">🇰🇷 Corée du Sud (+82)</option>
                                <option value="Émirats arabes unis (+971)" data-tel="+971" data-code="AE">🇦🇪 Émirats arabes unis (+971)</option>
                                <option value="Inde (+91)" data-tel="+91" data-code="IN">🇮🇳 Inde (+91)</option>
                                <option value="Indonésie (+62)" data-tel="+62" data-code="ID">🇮🇩 Indonésie (+62)</option>
                                <option value="Irak (+964)" data-tel="+964" data-code="IQ">🇮🇶 Irak (+964)</option>
                                <option value="Iran (+98)" data-tel="+98" data-code="IR">🇮🇷 Iran (+98)</option>
                                <option value="Israël (+972)" data-tel="+972" data-code="IL">🇮🇱 Israël (+972)</option>
                                <option value="Japon (+81)" data-tel="+81" data-code="JP">🇯🇵 Japon (+81)</option>
                                <option value="Liban (+961)" data-tel="+961" data-code="LB">🇱🇧 Liban (+961)</option>
                                <option value="Malaisie (+60)" data-tel="+60" data-code="MY">🇲🇾 Malaisie (+60)</option>
                                <option value="Pakistan (+92)" data-tel="+92" data-code="PK">🇵🇰 Pakistan (+92)</option>
                                <option value="Philippines (+63)" data-tel="+63" data-code="PH">🇵🇭 Philippines (+63)</option>
                                <option value="Qatar (+974)" data-tel="+974" data-code="QA">🇶🇦 Qatar (+974)</option>
                                <option value="Singapour (+65)" data-tel="+65" data-code="SG">🇸🇬 Singapour (+65)</option>
                                <option value="Thaïlande (+66)" data-tel="+66" data-code="TH">🇹🇭 Thaïlande (+66)</option>
                                <option value="Viêt Nam (+84)" data-tel="+84" data-code="VN">🇻🇳 Viêt Nam (+84)</option>
                                </optgroup>
                                <optgroup label="Océanie">
                                <option value="Australie (+61)" data-tel="+61" data-code="AU">🇦🇺 Australie (+61)</option>
                                <option value="Nouvelle-Zélande (+64)" data-tel="+64" data-code="NZ">🇳🇿 Nouvelle-Zélande (+64)</option>
                                </optgroup>
                            </select>
                            @error('country')
                                <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row" style="margin-bottom:20px !important">
                            <div class="col">
                                <label for="phone_number" class="form-label">Numéro de téléphone . <i style="color:red">requis</i></label>
                                <input type="tel" class="form-control" id="phone_number" placeholder="+XXXXXXXXXX"
                                       name="phone_number" value="{{ old('phone_number') }}" required
                                       data-bs-toggle="popover" data-bs-trigger="focus"
                                       data-bs-content="Le numéro doit être au format international. Ex : +XXXXXXXXXX"
                                       data-bs-placement="top" data-bs-original-title="Numéro de téléphone">
                                @error('phone_number')
                                    <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="email" class="form-label">Adresse e-mail . <i style="color:red">requis</i></label>
                                <input type="email" class="form-control" id="email" placeholder="client@email.com"
                                       name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Adresse complète de résidence . <i style="color:red">requis</i></label>
                            <input type="text" class="form-control" id="address" placeholder="Adresse complète..."
                                   name="address" value="{{ old('address') }}" required>
                            @error('address')
                                <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="lang" class="form-label">Langue d'affichage du compte . <i style="color:red">requis</i></label>
                            <select name="lang" id="lang" class="form-select" required>
                                <option value="" disabled selected>Langue parlée par le client</option>
                                <optgroup label="Langues courantes">
                                    <option value="fr">Français</option>
                                    <option value="en">Anglais</option>
                                    <option value="es">Espagnol</option>
                                    <option value="pt">Portugais</option>
                                    <option value="ar">Arabe</option>
                                    <option value="de">Allemand</option>
                                    <option value="it">Italien</option>
                                    <option value="nl">Néerlandais</option>
                                    <option value="ru">Russe</option>
                                    <option value="zh-CN">Chinois (simplifié)</option>
                                </optgroup>
                                <optgroup label="Langues européennes">
                                    <option value="sq">Albanais</option>
                                    <option value="be">Biélorusse</option>
                                    <option value="bs">Bosnien</option>
                                    <option value="bg">Bulgare</option>
                                    <option value="ca">Catalan</option>
                                    <option value="hr">Croate</option>
                                    <option value="da">Danois</option>
                                    <option value="et">Estonien</option>
                                    <option value="fi">Finnois</option>
                                    <option value="gl">Galicien</option>
                                    <option value="el">Grec</option>
                                    <option value="hu">Hongrois</option>
                                    <option value="ga">Irlandais</option>
                                    <option value="is">Islandais</option>
                                    <option value="lv">Letton</option>
                                    <option value="lt">Lituanien</option>
                                    <option value="lb">Luxembourgeois</option>
                                    <option value="mk">Macédonien</option>
                                    <option value="mt">Maltais</option>
                                    <option value="no">Norvégien</option>
                                    <option value="pl">Polonais</option>
                                    <option value="ro">Roumain</option>
                                    <option value="sr">Serbe</option>
                                    <option value="sk">Slovaque</option>
                                    <option value="sl">Slovène</option>
                                    <option value="sv">Suédois</option>
                                    <option value="cs">Tchèque</option>
                                    <option value="uk">Ukrainien</option>
                                </optgroup>
                                <optgroup label="Langues africaines">
                                    <option value="af">Afrikaans</option>
                                    <option value="am">Amharique</option>
                                    <option value="bm">Bambara</option>
                                    <option value="ff">Peul (Fula)</option>
                                    <option value="ha">Haoussa</option>
                                    <option value="ig">Igbo</option>
                                    <option value="rw">Kinyarwanda</option>
                                    <option value="ln">Lingala</option>
                                    <option value="mg">Malgache</option>
                                    <option value="so">Somali</option>
                                    <option value="sw">Swahili</option>
                                    <option value="wo">Wolof</option>
                                    <option value="yo">Yoruba</option>
                                    <option value="zu">Zoulou</option>
                                </optgroup>
                                <optgroup label="Langues asiatiques">
                                    <option value="zh-TW">Chinois (traditionnel)</option>
                                    <option value="ko">Coréen</option>
                                    <option value="hi">Hindi</option>
                                    <option value="id">Indonésien</option>
                                    <option value="ja">Japonais</option>
                                    <option value="km">Khmer</option>
                                    <option value="ms">Malais</option>
                                    <option value="mn">Mongol</option>
                                    <option value="my">Birman</option>
                                    <option value="ne">Népalais</option>
                                    <option value="fa">Persan</option>
                                    <option value="tl">Tagalog (Filipino)</option>
                                    <option value="ta">Tamoul</option>
                                    <option value="th">Thaï</option>
                                    <option value="tr">Turc</option>
                                    <option value="ur">Ourdou</option>
                                    <option value="vi">Vietnamien</option>
                                    <option value="bn">Bengali</option>
                                    <option value="gu">Gujarati</option>
                                    <option value="kn">Kannada</option>
                                    <option value="ml">Malayalam</option>
                                    <option value="mr">Marathi</option>
                                    <option value="pa">Pendjabi</option>
                                    <option value="si">Cingalais</option>
                                    <option value="te">Télougou</option>
                                </optgroup>
                                <optgroup label="Autres langues">
                                    <option value="az">Azerbaïdjanais</option>
                                    <option value="eu">Basque</option>
                                    <option value="eo">Espéranto</option>
                                    <option value="ka">Géorgien</option>
                                    <option value="he">Hébreu</option>
                                    <option value="hy">Arménien</option>
                                    <option value="kk">Kazakh</option>
                                    <option value="ky">Kirghiz</option>
                                    <option value="lo">Lao</option>
                                    <option value="uz">Ouzbek</option>
                                    <option value="ps">Pachto</option>
                                    <option value="tg">Tadjik</option>
                                    <option value="tk">Turkmène</option>
                                    <option value="ht">Créole haïtien</option>
                                </optgroup>
                            </select>
                        </div>

                        {{-- Photo de profil (optionnel) --}}
                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo de profil . <i style="color:#53459a">optionnel</i></label>
                            <input type="file" class="form-control" id="photo" name="photo" accept="image/jpeg,image/png,image/jpg,image/gif">
                            @error('photo')
                                <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                            <small class="text-muted">Formats acceptés : JPEG, PNG, JPG, GIF. Max 2 Mo.</small>
                        </div>
                    </div>

                    <div class="info-cl">
                        <label class="form-label" style="font-size:1em !important;color:black !important">Solde du compte et virement :</label>
                        <div class="mb-3">
                            <label for="bank-sender" class="form-label">Banque émettrice des virements entrants . <i style="color:#53459a">facultatif</i></label>
                            <input type="text" class="form-control" id="bank-sender" placeholder="Nom de la banque"
                                   name="bank_sender_name" maxlength="30" value="{{ old('bank_sender_name') }}">
                        </div>
                        <div class="mb-3">
                            <label for="account_status" class="form-label">Statut du compte . <i style="color:red">requis</i></label>
                            <select class="form-select" name="account_status" id="account_status" required>
                                <option value="Activé" {{ old('account_status', 'Activé') == 'Activé' ? 'selected' : '' }} style="color:#198754">Activé</option>
                                <option value="Suspendu" {{ old('account_status') == 'Suspendu' ? 'selected' : '' }} style="color:#dc3545">Suspendu</option>
                                <option value="Examen" {{ old('account_status') == 'Examen' ? 'selected' : '' }} style="color:#856404">En examen</option>
                            </select>
                            @error('account_status')
                                <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row" style="margin-bottom:20px !important">
                            <div class="col">
                                <label for="account_balance" class="form-label">Montant à créditer . <i style="color:red">requis</i></label>
                                <input type="tel" class="form-control" placeholder="Ex : 50000" id="account_balance" name="account_balance"
                                       required value="{{ old('account_balance') }}"
                                       data-bs-toggle="popover" data-bs-trigger="focus"
                                       data-bs-content="Le montant saisi sera crédité sur le compte client."
                                       data-bs-placement="top" data-bs-original-title="Solde sur le compte">
                                @error('account_balance')
                                    <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="devise" class="form-label">Devise . <i style="color:red">requis</i></label>
                                <select name="devise" id="devise" class="form-select" required>
                                    <option value="" disabled selected>Devise disponible...</option>
                                    <optgroup label="Europe">
                                        <option value="€">Euro — EUR (€)</option>
                                        <option value="£">Livre sterling — GBP (£)</option>
                                        <option value="CHF">Franc suisse — CHF</option>
                                        <option value="kr">Couronne danoise — DKK (kr)</option>
                                        <option value="kr">Couronne suédoise — SEK (kr)</option>
                                        <option value="kr">Couronne norvégienne — NOK (kr)</option>
                                        <option value="Kč">Couronne tchèque — CZK (Kč)</option>
                                        <option value="zł">Zloty polonais — PLN (zł)</option>
                                        <option value="Ft">Forint hongrois — HUF (Ft)</option>
                                        <option value="lei">Leu roumain — RON (lei)</option>
                                        <option value="лв">Lev bulgare — BGN (лв)</option>
                                        <option value="kn">Kuna croate — HRK (kn)</option>
                                        <option value="ISK">Couronne islandaise — ISK</option>
                                        <option value="₺">Livre turque — TRY (₺)</option>
                                        <option value="₴">Hryvnia ukrainien — UAH (₴)</option>
                                        <option value="₽">Rouble russe — RUB (₽)</option>
                                        <option value="GEL">Lari géorgien — GEL</option>
                                        <option value="ALL">Lek albanais — ALL</option>
                                        <option value="RSD">Dinar serbe — RSD</option>
                                        <option value="MDL">Leu moldave — MDL</option>
                                        <option value="BAM">Mark convertible — BAM</option>
                                        <option value="MKD">Denar macédonien — MKD</option>
                                        <option value="BYN">Rouble biélorusse — BYN</option>
                                    </optgroup>
                                    <optgroup label="Afrique">
                                        <option value="XOF">Franc CFA BCEAO — XOF</option>
                                        <option value="XAF">Franc CFA BEAC — XAF</option>
                                        <option value="GNF">Franc guinéen — GNF</option>
                                        <option value="DH">Dirham marocain — MAD (DH)</option>
                                        <option value="DT">Dinar tunisien — TND (DT)</option>
                                        <option value="DA">Dinar algérien — DZD (DA)</option>
                                        <option value="₦">Naira nigérian — NGN (₦)</option>
                                        <option value="₵">Cedi ghanéen — GHS (₵)</option>
                                        <option value="KSh">Shilling kényan — KES (KSh)</option>
                                        <option value="USh">Shilling ougandais — UGX (USh)</option>
                                        <option value="TSh">Shilling tanzanien — TZS (TSh)</option>
                                        <option value="R">Rand sud-africain — ZAR (R)</option>
                                        <option value="E£">Livre égyptienne — EGP (E£)</option>
                                        <option value="Br">Birr éthiopien — ETB (Br)</option>
                                        <option value="FRw">Franc rwandais — RWF (FRw)</option>
                                        <option value="FC">Franc congolais — CDF (FC)</option>
                                        <option value="FBu">Franc burundais — BIF (FBu)</option>
                                        <option value="Ar">Ariary malgache — MGA (Ar)</option>
                                        <option value="MRU">Ouguiya mauritanien — MRU</option>
                                        <option value="₨">Roupie mauricienne — MUR (₨)</option>
                                        <option value="D">Dalasi gambien — GMD (D)</option>
                                        <option value="Le">Leone sierra-léonais — SLE (Le)</option>
                                        <option value="$">Dollar libérien — LRD ($)</option>
                                        <option value="P">Pula botswanais — BWP (P)</option>
                                        <option value="Db">Dobra santoméen — STN (Db)</option>
                                        <option value="CVE">Escudo cap-verdien — CVE</option>
                                        <option value="Nfk">Nakfa érythréen — ERN (Nfk)</option>
                                        <option value="SSP">Livre sud-soudanaise — SSP</option>
                                        <option value="SDG">Livre soudanaise — SDG</option>
                                        <option value="LYD">Dinar libyen — LYD</option>
                                        <option value="SCR">Roupie seychelloise — SCR</option>
                                        <option value="SZL">Lilangeni eswatinien — SZL</option>
                                        <option value="LSL">Loti lesothan — LSL</option>
                                        <option value="MWK">Kwacha malawite — MWK</option>
                                        <option value="ZMW">Kwacha zambien — ZMW</option>
                                        <option value="AOA">Kwanza angolais — AOA</option>
                                        <option value="MZN">Metical mozambicain — MZN</option>
                                        <option value="NAD">Dollar namibien — NAD</option>
                                        <option value="SOS">Shilling somalien — SOS</option>
                                        <option value="DJF">Franc djiboutien — DJF</option>
                                        <option value="KMF">Franc comorien — KMF</option>
                                    </optgroup>
                                    <optgroup label="Amérique du Nord">
                                        <option value="$">Dollar américain — USD ($)</option>
                                        <option value="$ CA">Dollar canadien — CAD ($ CA)</option>
                                        <option value="$ MX">Peso mexicain — MXN ($ MX)</option>
                                    </optgroup>
                                    <optgroup label="Amérique du Sud & Caraïbes">
                                        <option value="R$">Réal brésilien — BRL (R$)</option>
                                        <option value="$">Peso argentin — ARS ($)</option>
                                        <option value="$">Peso colombien — COP ($)</option>
                                        <option value="$">Peso chilien — CLP ($)</option>
                                        <option value="S/">Sol péruvien — PEN (S/)</option>
                                        <option value="$U">Peso uruguayen — UYU ($U)</option>
                                        <option value="Bs">Bolívar vénézuélien — VES (Bs)</option>
                                        <option value="Bs">Boliviano bolivien — BOB (Bs)</option>
                                        <option value="₲">Guaraní paraguayen — PYG (₲)</option>
                                        <option value="G">Gourde haïtienne — HTG (G)</option>
                                        <option value="$">Dollar jamaïcain — JMD ($)</option>
                                        <option value="$">Dollar trinidadien — TTD ($)</option>
                                        <option value="$">Dollar des Caraïbes orientales — XCD ($)</option>
                                        <option value="Q">Quetzal guatémaltèque — GTQ (Q)</option>
                                        <option value="L">Lempira hondurien — HNL (L)</option>
                                        <option value="C$">Córdoba nicaraguayen — NIO (C$)</option>
                                        <option value="₡">Colón costaricain — CRC (₡)</option>
                                        <option value="B/.">Balboa panaméen — PAB (B/.)</option>
                                        <option value="$">Peso dominicain — DOP ($)</option>
                                        <option value="$">Dollar des Bahamas — BSD ($)</option>
                                        <option value="$">Dollar bélizien — BZD ($)</option>
                                        <option value="$">Dollar guyanais — GYD ($)</option>
                                        <option value="$">Dollar surinamais — SRD ($)</option>
                                    </optgroup>
                                    <optgroup label="Asie">
                                        <option value="¥">Yen japonais — JPY (¥)</option>
                                        <option value="¥">Yuan chinois — CNY (¥)</option>
                                        <option value="₩">Won sud-coréen — KRW (₩)</option>
                                        <option value="₹">Roupie indienne — INR (₹)</option>
                                        <option value="₨">Roupie pakistanaise — PKR (₨)</option>
                                        <option value="৳">Taka bangladais — BDT (৳)</option>
                                        <option value="₨">Roupie sri-lankaise — LKR (₨)</option>
                                        <option value="₨">Roupie népalaise — NPR (₨)</option>
                                        <option value="₫">Dong vietnamien — VND (₫)</option>
                                        <option value="฿">Baht thaïlandais — THB (฿)</option>
                                        <option value="RM">Ringgit malaisien — MYR (RM)</option>
                                        <option value="S$">Dollar singapourien — SGD (S$)</option>
                                        <option value="₱">Peso philippin — PHP (₱)</option>
                                        <option value="Rp">Roupie indonésienne — IDR (Rp)</option>
                                        <option value="HK$">Dollar de Hong Kong — HKD (HK$)</option>
                                        <option value="NT$">Dollar taïwanais — TWD (NT$)</option>
                                        <option value="₸">Tenge kazakh — KZT (₸)</option>
                                        <option value="сўм">Sum ouzbek — UZS</option>
                                        <option value="₼">Manat azerbaïdjanais — AZN (₼)</option>
                                        <option value="₾">Lari géorgien — GEL (₾)</option>
                                        <option value="֏">Dram arménien — AMD (֏)</option>
                                        <option value="сом">Som kirghiz — KGS</option>
                                        <option value="₮">Tugrik mongol — MNT (₮)</option>
                                        <option value="K">Kyat birman — MMK (K)</option>
                                        <option value="៛">Riel cambodgien — KHR (៛)</option>
                                        <option value="₭">Kip laotien — LAK (₭)</option>
                                        <option value="MVR">Rufiyaa maldivien — MVR</option>
                                        <option value="Nu">Ngultrum bhoutanais — BTN (Nu)</option>
                                        <option value="Af">Afghani afghan — AFN (Af)</option>
                                        <option value="SMT">Somoni tadjik — TJS</option>
                                        <option value="TMT">Manat turkmène — TMT</option>
                                        <option value="MOP">Pataca macanaise — MOP</option>
                                        <option value="BND">Dollar brunéien — BND</option>
                                    </optgroup>
                                    <optgroup label="Moyen-Orient">
                                        <option value="د.إ">Dirham émirati — AED (د.إ)</option>
                                        <option value="﷼">Riyal saoudien — SAR (﷼)</option>
                                        <option value="﷼">Riyal qatari — QAR (﷼)</option>
                                        <option value="د.ك">Dinar koweïtien — KWD (د.ك)</option>
                                        <option value="ب.د">Dinar bahreïni — BHD (ب.د)</option>
                                        <option value="﷼">Rial omanais — OMR (﷼)</option>
                                        <option value="د.ع">Dinar irakien — IQD (د.ع)</option>
                                        <option value="JD">Dinar jordanien — JOD (JD)</option>
                                        <option value="₪">Shekel israélien — ILS (₪)</option>
                                        <option value="£L">Livre libanaise — LBP (£L)</option>
                                        <option value="£S">Livre syrienne — SYP (£S)</option>
                                        <option value="﷼">Rial iranien — IRR (﷼)</option>
                                        <option value="﷼">Rial yéménite — YER (﷼)</option>
                                    </optgroup>
                                    <optgroup label="Océanie">
                                        <option value="A$">Dollar australien — AUD (A$)</option>
                                        <option value="NZ$">Dollar néo-zélandais — NZD (NZ$)</option>
                                        <option value="FJ$">Dollar fidjien — FJD (FJ$)</option>
                                        <option value="T$">Pa'anga tongan — TOP (T$)</option>
                                        <option value="ST">Tālā samoan — WST (ST)</option>
                                        <option value="K">Kina papouasien — PGK (K)</option>
                                        <option value="VT">Vatu vanuatuan — VUV (VT)</option>
                                        <option value="SI$">Dollar des Îles Salomon — SBD (SI$)</option>
                                        <option value="XPF">Franc CFP — XPF</option>
                                    </optgroup>
                                </select>
                                @error('devise')
                                    <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row" style="margin-bottom:20px !important">
                            <div class="col">
                                <label for="start_percentage" class="form-label">Pourcentage de départ . <i style="color:red">requis</i></label>
                                <input type="tel" class="form-control" placeholder="Entre 0 et 100" id="start_percentage"
                                       name="start_percentage" value="{{ old('start_percentage') }}" required maxlength="3" autocomplete="off"
                                       data-bs-toggle="popover" data-bs-trigger="focus"
                                       data-bs-content="Le pourcentage de départ doit être inférieur au pourcentage d'arrêt et obligatoirement entre 0 et 100"
                                       data-bs-placement="top" data-bs-original-title="Pourcentage de départ">
                                @error('start_percentage')
                                    <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="end_percentage" class="form-label">Pourcentage d'arrêt . <i style="color:red">requis</i></label>
                                <input type="tel" class="form-control" placeholder="Entre 0 et 100" id="end_percentage"
                                       name="end_percentage" value="{{ old('end_percentage') }}" required maxlength="3" autocomplete="off"
                                       data-bs-toggle="popover" data-bs-trigger="focus"
                                       data-bs-content="Le pourcentage d'arrêt du virement doit être supérieur au pourcentage de départ et obligatoirement entre 0 et 100"
                                       data-bs-placement="top" data-bs-original-title="Pourcentage d'arrêt">
                                @error('end_percentage')
                                    <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="iban" class="form-label">IBAN / Numéro de compte</label>
                            <input type="text" class="form-control" id="iban" name="iban"
                                   placeholder="Ex: FR76 3000 6000 ... ou 0012345678901"
                                   value="{{ old('iban') }}" maxlength="50">
                            <small class="form-text text-muted">Facultatif. Si non renseigné, "Non renseigné" sera affiché au client.</small>
                        </div>

                        <div class="mb-3">
                            <label for="failure_message" class="form-label">Message à afficher . <i style="color:red">requis</i></label>
                            <textarea name="failure_message" id="failure_message" class="form-control"
                                      placeholder="Message affiché à la fin du virement..."
                                      spellcheck="false" required maxlength="510">{{ old('failure_message') }}</textarea>
                            @error('failure_message')
                                <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="send_credentials" id="send_credentials" value="1">
                                <label class="form-check-label" for="send_credentials">
                                    Envoyer automatiquement les identifiants de connexion au client par e-mail après la création
                                </label>
                                <small class="text-muted d-block">Si décoché, vous pourrez envoyer manuellement depuis le modal des détails.</small>
                            </div>
                        </div>
                    </div>

                    <div class="info-cl">
                        <label class="form-label" style="font-size:1em !important;color:black !important">Alerte par e-mail (Obligatoire) :</label>
                        <div class="alert alert-info" role="alert">
                            <div style="margin-bottom:4px">Les alertes par e-mail sont envoyées à l'adresse e-mail du client.</div>
                            <div><b>NB :</b> Les alertes par e-mail sont gratuites et intégrées par défaut.</div>
                        </div>
                    </div>

                    <div class="info-cl">
                        <label class="form-label" style="font-size:1em !important;color:black !important">Alerte par SMS (Facultatif) :</label>
                        <div class="form-check form-switch" style="margin: 10px 0px 20px">
                            <input class="form-check-input" type="checkbox" role="switch" id="alert-sms" name="alert_sms" value="1">
                            <label class="form-check-label" for="alert-sms">Activer les alertes par SMS</label>
                        </div>
                        <div class="alert alert-info" role="alert">
                            <div style="margin-bottom:4px">Les alertes par SMS sont envoyées vers le numéro de téléphone du client.</div>
                            <div><b>NB :</b> 1000 Crédits pour les alertes par SMS.</div>
                        </div>
                    </div>

                    <div class="info-cl">
                        <label class="form-label" style="font-size:1em !important;color:black !important">Notification dans le compte client (Facultatif) :</label>
                        <div class="form-check form-switch" style="margin: 10px 0px 20px">
                            <input class="form-check-input" type="checkbox" role="switch" id="alert-notif" name="alert_notif" value="1">
                            <label class="form-check-label" for="alert-notif">Activer les notifications</label>
                        </div>
                        <div class="alert alert-info" role="alert">
                            <div style="margin-bottom:4px">Active l'envoi de notifications directement dans le compte bancaire du client.</div>
                            <div style="margin-bottom:4px"><b>Après la création du compte, vous aurez un champ où vous pourrez envoyer des demandes de frais et autres notifications directement dans son compte.</b></div>
                            <div><b>NB :</b> 1000 Crédits pour activer les notifications.</div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-success" type="submit" name="create-access" value="true" id="create-access-btn">
                            Créer l'accès client (4000 Crédits) <i class="bi bi-arrow-right-short"></i>
                        </button>
                    </div>
                    <br>
                </form>

                {{-- ============ FORMULAIRE MODIFIER ============ --}}
                <form method="POST" action="{{ route('modifier.messagePourcentages', ['id' => 0]) }}" class="form-test" style="margin-top:50px" id="form-update">
                    @csrf
                    @method('PUT')
                    <div class="ttb-title"><i class="fi fi-rr-magic-wand"></i> Modifier les informations d'un accès client</div>
                    <div class="mb-3">
                        <label for="access-cl" class="form-label">Sélectionner l'accès client . <i style="color:red">requis</i></label>
                        <select name="access-cl" id="access-cl" class="form-select" required>
                            <option value="" disabled selected>Vos Flash Compte Client(s) Créés...</option>
                            @foreach($comptes as $compte)
                                <option value="{{ $compte->id }}" data-currency="{{ $compte->devise ?? 'XOF' }}">
                                    {{ $compte->prenom }} {{ $compte->nom }} - {{ $compte->email }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="update-data" class="form-label">Action(s) possible(s) sur l'accès choisi . <i style="color:red">requis</i></label>
                        <select name="update-data" id="update-data" class="form-select" required>
                            <option value="add-amount">Ajouter de l'argent au solde actuel du compte client</option>
                            <option value="sub-amount">Diminuer le solde actuel du compte client</option>
                            <option value="update-codepin">Changer le code PIN de connexion du compte client</option>
                            <option value="update-bank-sender">Modifier la banque émettrice des virements entrants</option>
                            <option value="update-pp-msg" selected>Modifier les pourcentages et le message à afficher</option>
                            <option value="update-photo">Modifier la photo de profil du client</option>
                            <option value="update-iban">Modifier l'IBAN / Numéro de compte du client</option>
                        </select>
                    </div>
                    <div class="update-photo" style="display:none">
                        <div class="mb-3">
                            <label class="form-label">Nouvelle photo de profil . <i style="color:red">requis</i></label>
                            <input type="file" class="form-control" id="update-photo-file" accept="image/jpeg,image/png,image/jpg,image/gif">
                            <small class="text-muted">Formats acceptés : JPEG, PNG, JPG, GIF. Max 2 Mo.</small>
                        </div>
                        <div id="photo-preview-container" style="display:none;margin-bottom:15px;text-align:center">
                            <img id="photo-preview-img" src="" alt="Aperçu" style="max-width:150px;border-radius:50%;border:3px solid #e5e7eb">
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="button" class="btn btn-primary" id="btn-update-photo">
                                Mettre à jour la photo <i class="bi bi-arrow-right-short"></i>
                            </button>
                        </div>
                    </div>
                    <div class="update-iban" style="display:none">
                        <div class="mb-3">
                            <label for="update-iban-field" class="form-label">IBAN / Numéro de compte</label>
                            <input type="text" class="form-control" id="update-iban-field"
                                   placeholder="Ex: FR76 3000 6000 ... ou 0012345678901" maxlength="50">
                            <small class="form-text text-muted">Laissez vide pour afficher "Non renseigné" au client.</small>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="button" class="btn btn-primary" id="btn-update-iban">
                                Mettre à jour l'IBAN <i class="bi bi-arrow-right-short"></i>
                            </button>
                        </div>
                    </div>
                    <div class="update-pp-msg">
                        <div class="row" style="margin-bottom:20px !important">
                            <div class="col">
                                <label for="update-start-percentage" class="form-label">Pourcentage de départ . <i style="color:red">requis</i></label>
                                <input type="tel" class="form-control" placeholder="Entre 0 et 100"
                                       id="update-start-percentage" name="start_percentage" value="{{ old('start_percentage') }}" required maxlength="3"
                                       autocomplete="off" data-bs-toggle="popover" data-bs-trigger="focus"
                                       data-bs-content="Le pourcentage de départ doit être inférieur au pourcentage d'arrêt et obligatoirement entre 0 et 100"
                                       data-bs-placement="top" data-bs-original-title="Pourcentage de départ">
                                @error('start_percentage')
                                    <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="update-end-percentage" class="form-label">Pourcentage d'arrêt . <i style="color:red">requis</i></label>
                                <input type="tel" class="form-control" placeholder="Entre 0 et 100"
                                       id="update-end-percentage" name="end_percentage" value="{{ old('end_percentage') }}" required maxlength="3"
                                       autocomplete="off" data-bs-toggle="popover" data-bs-trigger="focus"
                                       data-bs-content="Le pourcentage d'arrêt du virement doit être supérieur au pourcentage de départ et obligatoirement entre 0 et 100"
                                       data-bs-placement="top" data-bs-original-title="Pourcentage d'arrêt">
                                @error('end_percentage')
                                    <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="update-failure-message" class="form-label">Message à afficher . <i style="color:red">requis</i></label>
                            <textarea name="failure_message" id="update-failure-message" class="form-control"
                                      placeholder="Message à afficher à la fin du virement..." required maxlength="510">{{ old('failure_message') }}</textarea>
                            @error('failure_message')
                                <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                        <div class="alert alert-info" role="alert" style="margin:20px auto;">
                            <div style="margin-bottom:8px"><i class="bi bi-bag-check"></i> Récapitulatif de la mise à jour :</div>
                            <div style="margin-bottom:8px" id="show-cl-access"><i class="bi bi-signpost"></i> Accès client à mettre à jour : <b>—</b></div>
                            <div style="margin-bottom:8px" id="show-update-start"><i class="bi bi-signpost"></i> Nouveau pourcentage de départ : <b>N/A</b></div>
                            <div style="margin-bottom:8px" id="show-update-end"><i class="bi bi-signpost"></i> Nouveau pourcentage d'arrêt : <b>N/A</b></div>
                            <div style="margin-bottom:12px" id="show-update-message"><i class="bi bi-signpost"></i> Nouveau message à afficher : <b>N/A</b></div>
                            <div style="margin-bottom:8px" id="show-nb">NB : Un nouveau code de déblocage du virement est généré automatiquement à chaque mise à jour.</div>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-primary" type="submit" name="update-access" value="true" id="update-access">
                                Mise à jour<i class="bi bi-arrow-right-short"></i>
                            </button>
                        </div>
                    </div>
                    <br>
                </form>

                {{-- ============ FORMULAIRE BLOQUER/DÉBLOQUER ============ --}}
                <form method="POST" action="#" class="form-real" id="form-lock">
                    @csrf
                    @method('PUT')
                    <div class="ttb-title" style="border:1px solid #ff8900;color:#ff8900">
                        <i class="bi bi-shield-lock"></i> Bloquer ou débloquer un accès client
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sélectionner l'accès client . <i style="color:red">requis</i></label>
                        <select name="access-cl-lock" id="access-cl-lock" class="form-select" required>
                            <option value="" disabled selected>Vos Flash Compte Client(s) Créés...</option>
                            @foreach($comptes as $compte)
                                <option value="{{ $compte->id }}">
                                    {{ $compte->prenom }} {{ $compte->nom }} - {{ $compte->email }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="account_status" id="lock-status-value" value="">
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px;">
                        <button class="btn btn-danger" type="button" id="lock-access">
                            <i class="fi fi-rr-lock"></i> Bloqué l'accès
                        </button>
                        <button class="btn btn-warning" type="button" id="examen-access">
                            <i class="fi fi-rr-search-alt"></i> Mettre en examen
                        </button>
                        <button class="btn btn-success" type="button" id="unlock-access">
                            <i class="fi fi-rr-unlock"></i> Débloqué l'accès
                        </button>
                    </div>
                    <br>
                </form>
            </div>
        </div>

        {{-- ======== COLONNE DROITE : Liste des accès ======== --}}
        <div class="ud-2">
            <div class="u-title">
                <span><i class="fi fi-br-clipboard-list-check"></i> Liste des accès flash compte ({{ count($comptes) }})</span>
            </div>
            <div class="u-content">
                @if(count($comptes) === 0)
                    <p style="padding:40px 10px;text-align:center">
                        <i class="fas fa-inbox fa-3x text-muted"></i>
                        <br><br><span class="text-muted">Aucun accès flash compte créé pour le moment.</span>
                    </p>
                @else
                    <div class="history">
                        <div class="history-content">
                            @foreach($comptes as $index => $compte)
                            @php
                                $cRegion = $compte->region ?: 'europe';
                                $cBaseUrl = config('regions.' . $cRegion . '.client_login_url');
                                $cAccessUrl = $cBaseUrl . '/?c=' . $compte->numerocompte;
                                $isBlocked = in_array($compte->account_status, ['Bloqué', 'Suspendu']);
                                $isExamen = $compte->account_status === 'Examen';
                            @endphp
                            <div class="history-item" title="Voir plus de détails">
                                <div class="h-line" data-cursor="pointer">
                                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;">
                                        @if($compte->photo_path)
                                            <img src="{{ asset('storage/' . $compte->photo_path) }}" alt="" style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:2px solid #e5e7eb;">
                                        @else
                                            <div style="width:36px;height:36px;border-radius:50%;background:#e8eaf0 url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z' fill='%238b93a1'/%3E%3C/svg%3E&quot;) center/22px 22px no-repeat;border:2px solid #d1d5db;flex-shrink:0;"></div>
                                        @endif
                                        <b style="font-size:.95em;">{{ $compte->prenom }} {{ $compte->nom }}</b>
                                    </div>
                                    Lien d'accès : <b>{{ $cAccessUrl }}</b>
                                    généré le {{ optional($compte->created_at)->format('d/m/y à H:i') }} UTC+0
                                    <br>
                                    @if($isBlocked)
                                        <b style="color:#ff3333;background-color:#ff333340;padding:4px 8px;border-radius:30px;display:inline-block;font-size:.9em">
                                            <i class="bi bi-lock-fill"></i> Flash Compte bloqué
                                        </b>
                                    @elseif($isExamen)
                                        <b style="color:#856404;background-color:#fff3cd;padding:4px 8px;border-radius:30px;display:inline-block;font-size:.9em">
                                            <i class="bi bi-search"></i> Flash Compte en examen
                                        </b>
                                    @else
                                        <b style="color:#198754;background-color:#19875440;padding:4px 8px;border-radius:30px;display:inline-block;font-size:.9em">
                                            <i class="bi bi-check2-circle"></i> Flash Compte actif
                                        </b>
                                    @endif
                                </div>
                                @php
                                    $cParams = json_decode($compte->parameters ?? '{}', true) ?: [];
                                    $cBankName = $cParams['bank_sender_name'] ?? null;
                                    if (empty($cBankName)) {
                                        $cBankName = strtoupper(str_replace(['https://','http://','www.','.world','.com','.fr','.net'], '', config('regions.' . ($compte->region ?: 'europe') . '.client_login_url', 'TRANSFERFLUX')));
                                    }
                                    $cRegionCost = config("regions." . ($compte->region ?: 'europe'));
                                    $cBaseCost = $cRegionCost['compte_base_cost'] ?? 4000;
                                    $cSmsCost = ($cRegionCost['compte_sms_optional'] ?? true) ? ($compte->alert_sms ? ($cRegionCost['compte_sms_cost'] ?? 1000) : 0) : 0;
                                    $cTotalCost = $cBaseCost + $cSmsCost;
                                @endphp
                                <div class="h-data" style="display:none" id="fcp-{{ $index }}">
                                    {{-- Avatar + Nom --}}
                                    <div class="fcp-modal-avatar">
                                        @if(!empty($compte->photo_path))
                                            <img src="{{ asset('storage/' . $compte->photo_path) }}" alt="Photo">
                                        @else
                                            <div class="fcp-avatar-placeholder" style="margin:0 auto;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="#8b93a1"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                                            </div>
                                        @endif
                                        <div class="fcp-client-name">{{ $compte->prenom }} {{ $compte->nom }}</div>
                                        <div class="fcp-client-hash"><i class="bi bi-link-45deg"></i> {{ $compte->numerocompte ?? '—' }}</div>
                                        <div style="margin-top:8px">
                                            @if($isBlocked)
                                                <span class="fcp-badge fcp-badge-red"><i class="bi bi-lock-fill"></i> Bloqué</span>
                                            @elseif($isExamen)
                                                <span class="fcp-badge fcp-badge-orange"><i class="bi bi-search"></i> En examen</span>
                                            @else
                                                <span class="fcp-badge fcp-badge-green"><i class="bi bi-check2-circle"></i> Actif</span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Identifiants de connexion --}}
                                    <div class="fcp-section">
                                        <div class="fcp-section-title"><i class="bi bi-key"></i> Identifiants de connexion</div>
                                        <div class="fcp-cred-box">
                                            <div class="fcp-cred-row">
                                                <span class="fcp-cred-label">Lien de connexion</span>
                                                <span class="fcp-cred-value"><span id="link-{{ $index }}" style="word-break:break-all;font-size:.8rem;">{{ $cAccessUrl }}</span> <button type="button" class="fcp-copy-btn" title="Copier le lien" onclick="copyText(this, 'link-{{ $index }}')"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg></button></span>
                                            </div>
                                            <div class="fcp-cred-row">
                                                <span class="fcp-cred-label">E-mail</span>
                                                <span class="fcp-cred-value"><span id="email-{{ $index }}">{{ $compte->email }}</span> <button type="button" class="fcp-copy-btn" title="Copier l'email" onclick="copyText(this, 'email-{{ $index }}')"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg></button></span>
                                            </div>
                                            <div class="fcp-cred-row">
                                                <span class="fcp-cred-label">Code PIN</span>
                                                <span class="fcp-cred-value"><span id="pin-{{ $index }}">{{ $compte->password ?? '—' }}</span> <button type="button" class="fcp-copy-btn" title="Copier le PIN" onclick="copyText(this, 'pin-{{ $index }}')"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg></button></span>
                                            </div>
                                        </div>
                                        <div class="fcp-actions" style="margin-top:20px">
                                            <button type="button" class="btn-send-identifiants" data-id="{{ $compte->id }}">
                                                Envoyer les identifiants de connexion au client par e-mail <i class="bi bi-envelope"></i>
                                            </button>
                                            <button type="button" class="btn-send-unlock" data-id="{{ $compte->id }}">
                                                Envoyer le code de déblocage du virement au client par e-mail <i class="bi bi-envelope"></i>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Informations personnelles --}}
                                    <div class="fcp-section">
                                        <div class="fcp-section-title"><i class="bi bi-person"></i> Informations personnelles</div>
                                        <div class="fcp-info-grid">
                                            <div class="fcp-info-item">
                                                <div class="fcp-info-label">Prénom Nom</div>
                                                <div class="fcp-info-val">{{ $compte->prenom }} {{ $compte->nom }}</div>
                                            </div>
                                            <div class="fcp-info-item">
                                                <div class="fcp-info-label">Téléphone</div>
                                                <div class="fcp-info-val">{{ $compte->phone_number ?? '—' }}</div>
                                            </div>
                                            <div class="fcp-info-item">
                                                <div class="fcp-info-label">Pays</div>
                                                <div class="fcp-info-val">{{ $compte->country ?? '—' }}</div>
                                            </div>
                                            <div class="fcp-info-item">
                                                <div class="fcp-info-label">Langue</div>
                                                <div class="fcp-info-val">{{ strtoupper($compte->lang ?? 'fr') }}</div>
                                            </div>
                                            <div class="fcp-info-item full">
                                                <div class="fcp-info-label">Adresse</div>
                                                <div class="fcp-info-val">{{ $compte->address ?? '—' }}</div>
                                            </div>
                                            <div class="fcp-info-item full">
                                                <div class="fcp-info-label">E-mail</div>
                                                <div class="fcp-info-val">{{ $compte->email }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Compte & Virement --}}
                                    <div class="fcp-section">
                                        <div class="fcp-section-title"><i class="bi bi-bank"></i> Compte & Virement</div>
                                        <div class="fcp-detail-list">
                                            <div class="fcp-detail-card"><strong>Banque émettrice :</strong> {{ $cBankName }}</div>
                                            <div class="fcp-detail-card"><strong>IBAN / Numéro de compte :</strong> {{ $compte->iban ?: 'Non renseigné' }}</div>
                                            <div class="fcp-detail-card"><strong>Solde :</strong> <span style="color:#16a34a;font-weight:700;">{{ number_format($compte->account_balance ?? 0, 2, ',', ' ') }} {{ $compte->devise ?? '' }}</span>
                                                @if(($compte->has_completed_transfer ?? false) && ($compte->last_transfer_amount ?? 0) > 0)
                                                    <div style="margin-top:10px;padding:10px 14px;background:#fefce8;border:1px solid #fbbf24;border-radius:8px;font-size:0.85rem;color:#92400e;line-height:1.5;">
                                                        <i class="bi bi-info-circle-fill" style="color:#f59e0b;margin-right:6px;"></i>
                                                        Cet utilisateur a effectué un virement de <strong>{{ number_format($compte->last_transfer_amount ?? 0, 2, ',', ' ') }} {{ $compte->devise ?? '' }}</strong>. Appuyez sur le bouton ci-dessous pour procéder au remboursement.
                                                    </div>
                                                    <form id="rembours-form-{{ $compte->id }}" action="{{ route('comptes.rembourserCompte', $compte->id) }}" method="POST" style="display:inline-block;margin-top:8px;">
                                                        @csrf
                                                        <button type="button" class="btn btn-success btn-sm btn-rembourser" data-id="{{ $compte->id }}">
                                                            <i class="bi bi-arrow-counterclockwise"></i> Rembourser le solde
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>

                                            <div class="fcp-detail-card"><strong>Pourcentage de départ du virement :</strong> {{ $compte->start_percentage ?? '—' }}%</div>
                                            <div class="fcp-detail-card"><strong>Pourcentage d'arrêt du virement :</strong> {{ $compte->end_percentage ?? '—' }}%</div>
                                            <div class="fcp-detail-card"><strong>Message à affiché :</strong> <span style="background:#f0f4ff;padding:4px 10px;border-radius:6px;color:#2563eb;font-weight:600;">{{ $compte->failure_message ?? '—' }}</span></div>
                                            <div class="fcp-detail-card"><strong>Code de déblocage du virement :</strong> <span class="fcp-badge-dark" id="code-{{ $index }}" style="background:linear-gradient(135deg,#f0ebff,#e8f0ff);color:#3b0764;font-family:'Roboto Mono',monospace;font-weight:700;padding:10px 20px 10px 28px;border-radius:10px;letter-spacing:8px;font-size:1.35rem;display:inline-block;border:1.5px solid #c4b5fd;box-shadow:0 2px 8px rgba(107,72,231,0.13);vertical-align:middle;user-select:all;cursor:text;">{{ $compte->code_virement ?? '445182' }}</span> <button type="button" class="fcp-copy-btn" title="Copier le code" onclick="copyText(this, 'code-{{ $index }}')"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg></button></div>
                                            <div class="fcp-detail-card"><strong>Code déjà utilisé :</strong>
                                                @if($compte->has_used_unlock_code ?? false)
                                                    <span class="fcp-badge fcp-badge-purple">OUI</span>
                                                @else
                                                    <span class="fcp-badge fcp-badge-orange">NON</span>
                                                @endif
                                            </div>
                                            <div class="fcp-detail-card"><strong>Alert Mail Pro :</strong>
                                                @if($compte->alert_email)
                                                    <span style="color:#16a34a;"><i class="bi bi-check-circle-fill"></i> Activé</span>
                                                @else
                                                    <span style="color:#dc3545;"><i class="bi bi-x-circle-fill"></i> Désactivé</span>
                                                @endif
                                            </div>
                                            <div class="fcp-detail-card"><strong>Alert SMS Pro :</strong>
                                                @if($compte->alert_sms)
                                                    <span style="color:#16a34a;"><i class="bi bi-check-circle-fill"></i> Activé</span>
                                                @else
                                                    <span style="color:#dc3545;"><i class="bi bi-x-circle-fill"></i> Désactivé</span>
                                                @endif
                                            </div>
                                            <div class="fcp-detail-card"><strong>Notifications :</strong>
                                                @if($compte->alert_notif ?? false)
                                                    <span style="color:#16a34a;"><i class="bi bi-check-circle-fill"></i> Activé</span>
                                                @else
                                                    <span style="color:#dc3545;"><i class="bi bi-x-circle-fill"></i> Désactivé</span>
                                                    <button type="button" class="btn btn-outline-primary btn-sm btn-activate-notif ms-2" data-id="{{ $compte->id }}" style="font-size:.75rem;padding:2px 8px;border-radius:6px;">
                                                        Activer (1000 Crédits)
                                                    </button>
                                                @endif
                                            </div>
                                            <div class="fcp-detail-card"><strong>Coût de création :</strong> {{ number_format($cTotalCost, 0, ',', ' ') }} Crédits</div>
                                            <div class="fcp-detail-card"><strong>Date de création :</strong> {{ optional($compte->created_at)->format('d/m/y') }} à {{ optional($compte->created_at)->format('H:i') }} UTC+0</div>
                                            <div class="fcp-detail-card"><strong>Etat :</strong>
                                                @if($isBlocked)
                                                    <span class="fcp-badge fcp-badge-red"><i class="bi bi-lock-fill"></i> Flash Compte bloqué</span>
                                                @elseif($isExamen)
                                                    <span class="fcp-badge fcp-badge-orange"><i class="bi bi-search"></i> Flash Compte en examen</span>
                                                @else
                                                    <span class="fcp-badge fcp-badge-green"><i class="bi bi-check2-circle"></i> Flash Compte actif</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Notifications --}}
                                    @if($compte->alert_notif ?? false)
                                    <div class="fcp-section">
                                        <div class="fcp-section-title"><i class="bi bi-bell"></i> Envoyer une notification</div>
                                        <div style="display:flex;flex-direction:column;gap:8px;">
                                            <input type="text" class="form-control form-control-sm notif-titre-input" data-id="{{ $compte->id }}" maxlength="100" placeholder="Titre de la notification">
                                            <textarea class="form-control form-control-sm notif-message-input" data-id="{{ $compte->id }}" rows="3" maxlength="500" placeholder="Texte de la notification..."></textarea>
                                            <button type="button" class="btn btn-primary btn-sm btn-send-notif" data-id="{{ $compte->id }}" style="border-radius:8px;">
                                                <i class="bi bi-send"></i> Envoyer la notification
                                            </button>
                                        </div>
                                    </div>
                                    @endif

                                    {{-- Supprimer --}}
                                    <div class="fcp-footer-actions">
                                        <form id="delete-form-{{ $compte->id }}" method="POST" action="{{ route('account.destroy', $compte->id) }}" style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" style="border-radius:8px"
                                                    onclick="fcpConfirm('Supprimer', 'Confirmez-vous la suppression de ce lien d\'accès client ?').then(function(ok){ if(ok) document.getElementById('delete-form-{{ $compte->id }}').submit(); });">
                                                <i class="bi bi-trash3"></i> Supprimer cet accès
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ============ MODAL ALERTE ============ --}}
<div class="modal fade" id="fcp-modal" tabindex="-1" aria-hidden="true" style="z-index:1070;">
    <div class="modal-dialog modal-dialog-centered" style="max-width:300px;margin-left:auto;margin-right:auto;">
        <div class="modal-content" style="border:none;border-radius:16px;overflow:hidden;box-shadow:0 8px 40px rgba(0,0,0,.15)">
            <div class="modal-header" style="background:#198754;border:none;padding:12px 18px;border-radius:16px 16px 0 0;">
                <h5 class="modal-title" style="color:#fff;font-weight:700;font-size:.95rem;display:flex;align-items:center;gap:8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    Info
                </h5>
                <button type="button" class="btn-close" style="filter:brightness(0) invert(1)" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding:22px 20px;text-align:center;">
                <p id="fcp-modal-body" style="font-size:.9rem;color:#333;margin:0;line-height:1.6"></p>
            </div>
        </div>
    </div>
</div>

{{-- ============ MODAL INTERACTION (prompt/confirm) ============ --}}
<div class="modal fade" id="fcp-interact" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" style="z-index:1070;">
    <div class="modal-dialog modal-dialog-centered" style="max-width:400px;margin-left:auto;margin-right:auto;">
        <div class="modal-content">
            <div class="modal-header" id="fcp-interact-header">
                <h6 class="modal-title" style="color:#fff;" id="fcp-interact-title">Action</h6>
                <button type="button" class="btn-close" style="filter:brightness(0) invert(1)" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="fcp-interact-icon-wrap" id="fcp-interact-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                </div>
                <p id="fcp-interact-msg"></p>
                <div id="fcp-interact-input-wrap" style="display:none">
                    <input type="text" class="form-control" id="fcp-interact-input" placeholder="" autocomplete="off">
                    <small id="fcp-interact-hint" class="text-muted" style="display:none;margin-top:10px"></small>
                </div>
            </div>
            <div class="modal-footer" style="border:none;padding:0 24px 24px;justify-content:center !important;gap:12px;">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" id="fcp-interact-cancel" style="min-width:110px;border-radius:12px;padding:10px;font-weight:700;">Annuler</button>
                <button type="button" class="btn btn-primary" id="fcp-interact-ok" style="min-width:140px;border-radius:12px;padding:10px;font-weight:700;">Confirmer</button>
            </div>
        </div>
    </div>
</div>

{{-- ============ MODAL AIDE ============ --}}
<div class="modal fade" id="fcpHelpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fi fi-rr-info"></i> Utilité et Fonctionnement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="text-primary">Utilité</h6>
                <p>Cet outil vous permet de créer des <b>accès flash compte</b> pour vos clients à l'international. Les fonctionnalités disponibles dans le compte : <b>Solde de compte, Crédit/Débit de compte, Remboursement de solde, Carte virtuelle, Virement, Profil client, Alerte par SMS et par e-mail en temps réel.</b></p>
                <h6 class="text-primary">Fonctionnement</h6>
                <p>Un accès Flash Compte Pro doit être créé pour un client. Cet outil est payant (4 000 crédits pour un accès client, 1 000 crédits pour les alertes par SMS, les alertes par e-mail sont gratuites).</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

{{-- ============ MODAL DÉTAILS ACCÈS ============ --}}
<style>
    #fcp-data-box .modal-content { border:none; border-radius:18px; overflow:hidden; box-shadow: 0 10px 50px rgba(0,0,0,0.2); }
    #fcp-data-box .modal-header { background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); border:none; padding:22px 24px; position: relative; }
    #fcp-data-box .modal-header::after { content: ""; position: absolute; top: 0; left: 0; right: 0; height: 1px; background: rgba(255,255,255,0.1); }
    #fcp-data-box .modal-title { color:#fff; font-weight:700; font-size:1.15rem; letter-spacing: 0.3px; }
    #fcp-data-box .btn-close { filter:brightness(0) invert(1); opacity: 0.8; }
    #fcp-data-box .btn-close:hover { opacity: 1; }

    /* Interaction Modal (fcp-interact) Premium Styles */
    #fcp-interact { z-index: 9999 !important; }
    #fcp-interact .modal-content { border: none; border-radius: 20px; overflow: hidden; box-shadow: 0 15px 60px rgba(0,0,0,0.3); background: #ffffff; }
    #fcp-interact .modal-header { 
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); 
        border: none; padding: 18px 24px; 
        backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
    }
    #fcp-interact .modal-title { font-weight: 700; font-size: 1.05rem; letter-spacing: 0.5px; }
    #fcp-interact .modal-body { padding: 30px 24px; text-align: center; }
    .fcp-interact-icon-wrap { 
        width: 70px; height: 70px; border-radius: 50%; background: #f0f4ff; 
        display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;
        color: #4f46e5; transition: all 0.5s ease;
    }
    .fcp-interact-icon-wrap svg { width: 32px; height: 32px; }
    #fcp-interact-msg { font-size: 1.05rem; font-weight: 500; color: #1f2937; line-height: 1.5; margin-bottom: 20px; }
    #fcp-interact-msg b { color: #4f46e5; }
    
    #fcp-interact .btn-light { background: #f3f4f6; border: none; color: #4b5563; transition: all 0.2s; }
    #fcp-interact .btn-light:hover { background: #e5e7eb; color: #1f2937; }
    #fcp-interact #fcp-interact-ok { 
        background: linear-gradient(135deg, #4f46e5, #7c3aed); border: none; 
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3); transition: all 0.3s;
    }
    #fcp-interact #fcp-interact-ok:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4); }
    #fcp-interact #fcp-interact-ok:active { transform: translateY(0); }

    /* Success/Error Modal (fcp-modal) */
    #fcp-modal .modal-content { border: none; border-radius: 20px; box-shadow: 0 20px 70px rgba(0,0,0,0.25); }
    #fcp-modal .modal-header { border: none; padding: 18px 24px; }
    #fcp-modal .modal-title { font-weight: 700; font-size: 1.05rem; display: flex; align-items: center; gap: 10px; }
    #fcp-modal .modal-body { padding: 30px 25px; font-size: 1.05rem; font-weight: 500; line-height: 1.4; }

    #fcp-data-box .modal-content { background: #f8fafc; }
    #fcp-data-box .modal-header { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); border-bottom: 2px solid #3b82f6; padding: 24px 30px; }
    #fcp-data-box .modal-title { font-size: 1.25rem; }

    .fcp-modal-avatar { text-align:center; padding:30px 20px 20px; background:#fff; border-bottom:1px solid #e2e8f0; }
    .fcp-modal-avatar img, .fcp-modal-avatar .fcp-avatar-placeholder {
        width:84px; height:84px; border-radius:50%; object-fit:cover; border:4px solid #fff; box-shadow:0 6px 16px rgba(0,0,0,.08);
    }
    .fcp-avatar-placeholder { background:#e8eaf0; display:inline-flex; align-items:center; justify-content:center; }
    .fcp-modal-avatar .fcp-client-name { font-weight:800; font-size:1.2rem; margin-top:14px; color:#0f172a; }
    .fcp-modal-avatar .fcp-client-hash { font-size:.85rem; color:#64748b; font-family:monospace; margin-top:4px; }
    
    .fcp-section { padding:24px 20px 8px; border:none !important; }
    .fcp-section-title { font-weight:800; font-size:1rem; color:#4f46e5; text-transform:uppercase; letter-spacing:1px; margin-bottom:20px; display:flex; align-items:center; gap:10px; padding-bottom:12px; border-bottom: 2px solid #e0e7ff; }
    
    .fcp-detail-list { padding:0; display:flex; flex-direction:column; gap:16px; }
    .fcp-detail-card { 
        margin:0; padding:18px 20px; background:#ffffff; border:1px solid #e2e8f0; 
        border-radius:14px; font-size:0.95rem; color:#1e293b; line-height:1.6;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02); transition: all 0.3s ease;
        display: block; position: relative; overflow: hidden;
    }
    .fcp-detail-card::before {
        content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 4px;
        background: linear-gradient(to bottom, #4f46e5, #3b82f6);
        border-radius: 4px 0 0 4px; opacity: 0; transition: opacity 0.3s;
    }
    .fcp-detail-card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.06); border-color: #cbd5e1; }
    .fcp-detail-card:hover::before { opacity: 1; }
    .fcp-detail-card strong { font-weight:700; color:#64748b; font-size:0.8rem; text-transform:uppercase; letter-spacing:0.8px; display:block; margin-bottom:10px; }
    .fcp-cred-box { background:#f4f6fb; border-radius:10px; padding:14px 16px; }
    .fcp-cred-row { display:flex; justify-content:space-between; align-items:center; padding:6px 0; }
    .fcp-cred-row + .fcp-cred-row { border-top:1px solid #e8eaef; }
    .fcp-cred-label { font-size:.82rem; color:#666; }
    .fcp-cred-value { font-weight:600; font-size:.88rem; color:#1a1a2e; display:flex; align-items:center; gap:6px; }
    .fcp-copy-btn {
        background: #f8f9fa; border: 1px solid #e2e8f0; border-radius: 50%;
        width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center;
        cursor: pointer; color: #64748b; transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        padding: 0; margin-left: 8px; vertical-align: middle; box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    .fcp-copy-btn:hover { background: #667eea; color: #fff; border-color: #667eea; transform: translateY(-1px); box-shadow: 0 4px 6px rgba(102, 126, 234, 0.2); }
    .fcp-copy-btn:active { transform: translateY(0); }
    .fcp-copy-btn.copy-success { background: #10b981; color: #fff; border-color: #10b981; }
    .fcp-info-grid { display:grid; grid-template-columns:1fr 1fr; gap:8px 16px; }
    .fcp-info-item { padding:6px 0; }
    .fcp-info-label { font-size:.75rem; color:#999; text-transform:uppercase; letter-spacing:.3px; }
    .fcp-info-val { font-weight:600; font-size:.9rem; color:#333; margin-top:1px; }
    .fcp-info-item.full { grid-column: 1 / -1; }
    .fcp-badge { 
        display:inline-flex !important; align-items:center !important; gap:4px !important; 
        padding:4px 12px !important; border-radius:4px !important; 
        font-weight:700 !important; font-size:.75rem !important; text-transform:uppercase !important;
    }
    .fcp-badge-green  { background:#198754 !important; color:#fff !important; }
    .fcp-badge-red    { background:#dc3545 !important; color:#fff !important; }
    .fcp-badge-orange { background:#ff8900 !important; color:#fff !important; }
    .fcp-badge-purple { background:#6f42c1 !important; color:#fff !important; }
    .fcp-badge-dark {
        background: linear-gradient(135deg, #f0ebff 0%, #e8f0ff 100%) !important;
        color: #3b0764 !important;
        font-family: 'Roboto Mono', 'Courier New', monospace !important;
        font-weight: 700 !important;
        padding: 10px 20px 10px 28px !important;
        border-radius: 10px !important;
        letter-spacing: 8px !important;
        font-size: 1.35rem !important;
        border: 1.5px solid #c4b5fd !important;
        box-shadow: 0 2px 8px rgba(107,72,231,0.13) !important;
        vertical-align: middle !important;
        user-select: all !important;
        cursor: text !important;
    }
    
    .fcp-actions { display:flex; gap:8px; margin-top:20px; }
    .btn-send-identifiants, .btn-send-unlock { 
        flex: 1; border-radius: 10px; border: none; padding: 12px 4px;
        font-weight: 600; font-size: 0.65rem; text-transform: none; line-height: 1.3;
        display: flex; align-items: center; justify-content: center; text-align: center;
        transition: all 0.2s ease; min-height: 56px;
        cursor: pointer; position: relative;
    }
    .btn-send-identifiants i, .btn-send-unlock i { font-size: 0.9rem; margin-left: 5px; flex-shrink: 0; }
    
    .btn-send-identifiants { background: #007bff !important; color: white !important; }
    .btn-send-identifiants:hover { background: #0069d9 !important; transform: translateY(-1px); }
    
    .btn-send-unlock { background: #ffc107 !important; color: #000 !important; }
    .btn-send-unlock:hover { background: #e0a800 !important; transform: translateY(-1px); }

    .fcp-footer-actions { padding:12px 20px 20px; text-align:right; }
</style>
<div class="modal fade" id="fcp-data-box" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-person-badge"></i> Détails de l'accès client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 15px 6px;">
                <div id="fcp-data-box-body"></div>
                <textarea style="opacity:0;position:absolute;pointer-events:none;left:0" id="fcp-copy"></textarea>
            </div>
        </div>
    </div>
</div> {{-- End Modal --}}

{{-- Global Loader --}}
<div id="fcp-loading">
    <div class="fcp-spinner"></div>
    <div class="fcp-loading-text">Traitement en cours...</div>
</div>

@push('scripts')
<script>
// ---- Copy to clipboard helper ----
window.copyText = function(btn, elementId) {
    if (!btn) return;
    
    // Si appelé via l'ancien système (identifiant seulement)
    if (typeof btn === 'string') {
        elementId = btn;
        btn = document.querySelector('button[onclick*="' + elementId + '"]');
    }

    // On cherche l'élément source (en priorité à côté du bouton pour le modal)
    var target = null;
    if (btn.previousElementSibling) {
        target = btn.previousElementSibling;
    } else {
        target = document.getElementById(elementId);
    }
    
    if (!target) return;
    
    var text = target.innerText || target.textContent;
    navigator.clipboard.writeText(text.trim()).then(function(){
        var orig = btn.innerHTML;
        btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>';
        btn.classList.add('copy-success');
        setTimeout(function(){ 
            btn.innerHTML = orig;
            btn.classList.remove('copy-success');
        }, 1500);
    }).catch(function(err){
        console.error('Erreur de copie:', err);
    });
};

window.addEventListener('DOMContentLoaded', function(){
    // ---- Route templates ----
    var updatePpMsgBase = "{{ url('/modifier-message-pourcentages') }}";
    var updateSoldeBase = "{{ url('/update-solde') }}";
    var diminuerSoldeBase = "{{ url('/diminuer-solde') }}";
    var updateStatusBase = "{{ url('/update-status') }}";
    var updateCodePinBase = "{{ url('/updateCodePin') }}";
    var updateBankSenderBase = "{{ url('/compte/0/update-bank-sender') }}";
    var csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
    var _fcpNeedsReload = false;

    // ---- Modals ----
    var fcpModalEl = document.getElementById('fcp-modal');
    var fcpModal = fcpModalEl ? new bootstrap.Modal(fcpModalEl, { keyboard: false }) : null;
    var fcpDataBoxEl = document.getElementById('fcp-data-box');
    var fcpDataBox = fcpDataBoxEl ? new bootstrap.Modal(fcpDataBoxEl, { keyboard: false }) : null;
    var fcpInteractEl = document.getElementById('fcp-interact');
    var fcpInteract = fcpInteractEl ? new bootstrap.Modal(fcpInteractEl) : null;
    var _fcpInteractResolve = null;

    if (fcpModalEl) {
        fcpModalEl.addEventListener('hidden.bs.modal', function() {
            if (_fcpNeedsReload) {
                fcpShowLoader();
                location.reload();
            }
        });
    }

    // ---- Loader functions ----
    window.fcpShowLoader = function() {
        var loader = document.getElementById('fcp-loading');
        if (loader) loader.classList.add('active');
    };
    window.fcpHideLoader = function() {
        var loader = document.getElementById('fcp-loading');
        if (loader) loader.classList.remove('active');
    };

    // Auto-loader for all forms on submit
    document.querySelectorAll('form').forEach(function(form) {
        form.addEventListener('submit', function() {
            if (this.checkValidity()) {
                fcpShowLoader();
            }
        });
    });

    // ---- Tooltips & Popovers ----
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));
    ['phone_number','account_balance','start_percentage','end_percentage','update-start-percentage','update-end-percentage'].forEach(function(id){
        var el = document.getElementById(id);
        if (el) new bootstrap.Popover(el, { trigger: 'focus' });
    });

    // ---- History items click → modal ----
    document.querySelectorAll('.fcp-wrap .history-item').forEach(function(item){
        item.addEventListener('click', function(e){
            if (e.target.closest('form') || e.target.closest('button') || e.target.closest('a')) return;
            var data = this.querySelector('.h-data');
            if (data && fcpDataBox) {
                document.querySelector('#fcp-data-box .modal-title').innerText = "Détails de l'accès client";
                document.getElementById('fcp-data-box-body').innerHTML = data.innerHTML;
                fcpDataBox.show();
            }
        });
    });

    // ---- Send Email Buttons (AJAX Event Delegation) ----
    document.addEventListener('click', function(e) {
        var btn = e.target.closest('.btn-send-identifiants');
        if (btn) {
            e.preventDefault();
            var id = btn.getAttribute('data-id');
            
            btn.disabled = true;
            var originalHtml = btn.innerHTML;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Envoi...';
            
            fetch('/envoyerEmail/' + id, { 
                method: 'POST', 
                headers: { 
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', 
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                } 
            })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                if(data.success) showFcpModal(data.message || 'E-mail d\'identifiants envoyé avec succès !', 'success');
                else showFcpModal(data.error || data.message || 'Erreur lors de l\'envoi.', 'error');
            })
            .catch(function(err) { showFcpModal('Erreur réseau.', 'error'); })
            .finally(function() {
                btn.disabled = false;
                btn.innerHTML = originalHtml;
            });
        }

        var btnUnlock = e.target.closest('.btn-send-unlock');
        if (btnUnlock) {
            e.preventDefault();
            var id = btnUnlock.getAttribute('data-id');
            
            btnUnlock.disabled = true;
            var originalHtml = btnUnlock.innerHTML;
            btnUnlock.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Envoi...';
            
            fetch('/envoyerCodeDeblocage/' + id, { 
                method: 'POST', 
                headers: { 
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', 
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                } 
            })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                if(data.success) showFcpModal(data.message || 'Code de déblocage envoyé avec succès !', 'success');
                else showFcpModal(data.error || data.message || 'Erreur lors de l\'envoi.', 'error');
            })
            .catch(function(err) { showFcpModal('Erreur réseau.', 'error'); })
            .finally(function() {
                btnUnlock.disabled = false;
                btnUnlock.innerHTML = originalHtml;
            });
        }

        var btnRembourser = e.target.closest('.btn-rembourser');
        if (btnRembourser) {
            e.preventDefault();
            var id = btnRembourser.getAttribute('data-id');
            fcpConfirm('Remboursement', 'Confirmer le remboursement du solde ?').then(function(ok) {
                if (ok) document.getElementById('rembours-form-' + id).submit();
            });
        }

        var btnActivateNotif = e.target.closest('.btn-activate-notif');
        if (btnActivateNotif) {
            e.preventDefault();
            var id = btnActivateNotif.getAttribute('data-id');
            fcpConfirm('Activer les notifications', 'Activer les notifications pour ce compte coûte 1000 crédits. Confirmer ?').then(function(ok) {
                if (!ok) return;
                btnActivateNotif.disabled = true;
                var originalHtml = btnActivateNotif.innerHTML;
                btnActivateNotif.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

                fetch('/compte/' + id + '/activer-notifications', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (data.success) {
                        showFcpModal(data.message || 'Notifications activées !', 'success');
                        setTimeout(function() { window.location.reload(); }, 1200);
                    } else {
                        showFcpModal(data.message || 'Erreur.', 'error');
                        btnActivateNotif.disabled = false;
                        btnActivateNotif.innerHTML = originalHtml;
                    }
                })
                .catch(function() {
                    showFcpModal('Erreur réseau.', 'error');
                    btnActivateNotif.disabled = false;
                    btnActivateNotif.innerHTML = originalHtml;
                });
            });
        }

        var btnNotif = e.target.closest('.btn-send-notif');
        if (btnNotif) {
            e.preventDefault();
            var id = btnNotif.getAttribute('data-id');
            var titreInput   = document.querySelector('.notif-titre-input[data-id="' + id + '"]');
            var messageInput = document.querySelector('.notif-message-input[data-id="' + id + '"]');
            var titre   = titreInput   ? titreInput.value.trim()   : '';
            var message = messageInput ? messageInput.value.trim() : '';

            if (!titre && !message) {
                showFcpModal('Veuillez remplir le titre ou le message.', 'error');
                return;
            }

            btnNotif.disabled = true;
            var originalHtml = btnNotif.innerHTML;
            btnNotif.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Envoi...';

            fetch('/compte/' + id + '/notification', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ titre: titre, message: message })
            })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                if (data.success) {
                    showFcpModal(data.message || 'Notification envoyée !', 'success');
                    if (titreInput) titreInput.value = '';
                    if (messageInput) messageInput.value = '';
                } else {
                    showFcpModal(data.message || 'Erreur lors de l\'envoi.', 'error');
                }
            })
            .catch(function() { showFcpModal('Erreur réseau.', 'error'); })
            .finally(function() {
                btnNotif.disabled = false;
                btnNotif.innerHTML = originalHtml;
            });
        }
    });

    // ---- Alert SMS + Notification toggles ----
    function updateCreateBtnCost() {
        var btn = document.getElementById('create-access-btn');
        if (!btn) return;
        var smsChecked   = document.getElementById('alert-sms')   ? document.getElementById('alert-sms').checked   : false;
        var notifChecked = document.getElementById('alert-notif') ? document.getElementById('alert-notif').checked : false;
        var cost = 4000 + (smsChecked ? 1000 : 0) + (notifChecked ? 1000 : 0);
        btn.innerHTML = 'Créer l\'accès client (' + cost + ' Crédits) <i class="bi bi-arrow-right-short"></i>';
    }

    var alertSmsEl = document.getElementById('alert-sms');
    if (alertSmsEl) {
        alertSmsEl.addEventListener('change', updateCreateBtnCost);
    }

    var alertNotifEl = document.getElementById('alert-notif');
    if (alertNotifEl) {
        alertNotifEl.addEventListener('change', updateCreateBtnCost);
    }

    // ---- Phone format ----
    var telEl = document.getElementById('phone_number');
    if (telEl) telEl.addEventListener('blur', function(){ this.value = this.value.replace(/[ )(\-]/g, ''); });

    // ---- Utility: showFcpModal ----
    window.showFcpModal = function(content, status) {
        if (!fcpModal) {
            alert((status === 'success' ? 'INFO: ' : 'ERREUR: ') + content.replace(/<[^>]*>/g, ''));
            return;
        }
        status = status || 'error';
        var header = document.querySelector('#fcp-modal .modal-header');
        var title = document.querySelector('#fcp-modal .modal-title');
        var infoIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>';
        var alertIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>';
        if (status === 'success') {
            header.style.background = '#198754';
            title.innerHTML = infoIcon + ' Info';
        } else {
            header.style.background = '#e04f5f';
            title.innerHTML = alertIcon + ' Alert';
        }
        document.getElementById('fcp-modal-body').innerHTML = content;
        fcpModal.show();
    };

    // ---- Interaction Modals (Prompt/Confirm) ----
    var iconHelp = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>';
    var iconLock = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>';
    var iconUnlock = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 9.9-1"></path></svg>';
    var iconSearch = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>';
    var iconMoney = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>';
    var iconKey = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3m-3-3l-2.25-2.25"></path></svg>';
    var iconBank = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"></path><path d="M3 10h18"></path><path d="M5 6l7-3 7 3"></path><path d="M4 10v11"></path><path d="M20 10v11"></path><path d="M8 14v3"></path><path d="M12 14v3"></path><path d="M16 14v3"></path></svg>';

    window.fcpPrompt = function(title, message, placeholder, hint) {
        return new Promise(function(resolve) {
            if (!fcpInteract) { resolve(prompt(message, placeholder)); return; }
            _fcpInteractResolve = resolve;
            document.getElementById('fcp-interact-title').textContent = title || 'Saisie';
            document.getElementById('fcp-interact-msg').innerHTML = message || '';
            document.getElementById('fcp-interact-header').style.background = 'linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%)';
            
            var ic = document.getElementById('fcp-interact-icon');
            if (title.includes('Ajouter') || title.includes('Retirer')) ic.innerHTML = iconMoney;
            else if (title.includes('Banque')) ic.innerHTML = iconBank;
            else if (title.includes('PIN')) ic.innerHTML = iconKey;
            else ic.innerHTML = iconHelp;

            var inputWrap = document.getElementById('fcp-interact-input-wrap');
            var input = document.getElementById('fcp-interact-input');
            var hintEl = document.getElementById('fcp-interact-hint');
            inputWrap.style.display = '';
            input.value = '';
            input.placeholder = placeholder || '';
            if (hint) { hintEl.textContent = hint; hintEl.style.display = 'block'; } else { hintEl.style.display = 'none'; }
            document.getElementById('fcp-interact-ok').textContent = 'Valider';
            fcpInteract.show();
            setTimeout(function(){ input.focus(); }, 300);
        });
    };

    window.fcpConfirm = function(title, message) {
        return new Promise(function(resolve) {
            if (!fcpInteract) { resolve(confirm(message)); return; }
            _fcpInteractResolve = resolve;
            document.getElementById('fcp-interact-title').textContent = title || 'Confirmation';
            document.getElementById('fcp-interact-msg').innerHTML = message || '';
            
            var ic = document.getElementById('fcp-interact-icon');
            var header = document.getElementById('fcp-interact-header');
            if (message.includes('Bloqué')) { ic.innerHTML = iconLock; header.style.background = '#e04f5f'; }
            else if (message.includes('Examen')) { ic.innerHTML = iconSearch; header.style.background = '#f59e0b'; }
            else if (message.includes('Actif')) { ic.innerHTML = iconUnlock; header.style.background = '#10b981'; }
            else { ic.innerHTML = iconHelp; header.style.background = 'linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%)'; }

            document.getElementById('fcp-interact-input-wrap').style.display = 'none';
            document.getElementById('fcp-interact-ok').textContent = 'Confirmer';
            fcpInteract.show();
        });
    };

    if (fcpInteractEl) {
        document.getElementById('fcp-interact-ok').addEventListener('click', function(){
            var inputWrap = document.getElementById('fcp-interact-input-wrap');
            var val = (inputWrap.style.display !== 'none') ? document.getElementById('fcp-interact-input').value.trim() : true;
            if (inputWrap.style.display !== 'none' && !val) { document.getElementById('fcp-interact-input').focus(); return; }
            fcpInteract.hide();
            if (_fcpInteractResolve) { _fcpInteractResolve(val); _fcpInteractResolve = null; }
        });
        document.getElementById('fcp-interact-cancel').addEventListener('click', function(){
            fcpInteract.hide();
            if (_fcpInteractResolve) { _fcpInteractResolve(null); _fcpInteractResolve = null; }
        });
    }

    // ---- Creation form: btn activation ----
    (function(){
        var form = document.getElementById('form-create');
        var btn = document.getElementById('create-access-btn');
        if (!form || !btn) return;
        var check = function(){
            var reg = form.querySelectorAll('[required]');
            var ok = true;
            reg.forEach(function(el){ if(!el.value.trim()) ok = false; });
            btn.disabled = !ok;
            btn.style.opacity = ok ? '1' : '.6';
        };
        form.addEventListener('input', check);
        check();
    })();

    // ---- Consolidated Update Form Logic ----
    var updateForm = document.getElementById('form-update');
    var updateDataSel = document.getElementById('update-data');
    var ppMsgDiv = document.querySelector('.update-pp-msg');
    var photoBlock = document.querySelector('.update-photo');
    var ibanBlock = document.querySelector('.update-iban');
    var accessClSel = document.getElementById('access-cl');

    if (updateDataSel) {
        updateDataSel.addEventListener('change', function(){
            var val = this.value;
            // Toggle visibility
            if (ppMsgDiv) ppMsgDiv.style.display = (val === 'update-pp-msg') ? '' : 'none';
            if (photoBlock) photoBlock.style.display = (val === 'update-photo') ? '' : 'none';
            if (ibanBlock) ibanBlock.style.display = (val === 'update-iban') ? '' : 'none';
            // Sync 'required' attributes
            document.querySelectorAll('.update-pp-msg [name]').forEach(function(el){
                if (val === 'update-pp-msg') el.setAttribute('required', 'required');
                else el.removeAttribute('required');
            });
            // Prompt/AJAX actions
            if (['add-amount', 'sub-amount', 'update-codepin', 'update-status', 'update-bank-sender'].includes(val)) {
                handleOtherActions(val);
                this.value = 'update-pp-msg';
                if (ppMsgDiv) ppMsgDiv.style.display = '';
                if (ibanBlock) ibanBlock.style.display = 'none';
            }
        });
    }

    // ---- Update IBAN ----
    var btnUpdateIban = document.getElementById('btn-update-iban');
    if (btnUpdateIban) {
        btnUpdateIban.addEventListener('click', function(){
            var accessClVal = accessClSel ? accessClSel.value : '';
            if (!accessClVal) { showFcpModal('Veuillez sélectionner un accès client.'); return; }
            var ibanVal = document.getElementById('update-iban-field').value.trim();
            var name = accessClSel.options[accessClSel.selectedIndex]?.text || '';
            fcpConfirm('IBAN', 'Mettre à jour l\'IBAN du client <b>' + name + '</b> ?').then(function(ok){
                if (!ok) return;
                var formData = new FormData();
                formData.append('_token', csrfToken);
                formData.append('iban', ibanVal);
                fetch('{{ url("/updateIban") }}/' + accessClVal, { method: 'POST', body: formData })
                .then(function(res){
                    if (!res.ok) throw new Error('Erreur serveur');
                    showFcpModal('IBAN mis a jour avec succes !', 'success');
                    setTimeout(function(){ window.location.reload(); }, 1500);
                })
                .catch(function(err){ showFcpModal('Erreur : ' + err.message, 'error'); });
            });
        });
    }

    if (updateForm) {
        updateForm.addEventListener('submit', function(e){
            var id = accessClSel.value;
            var action = updateDataSel.value;
            if (!id) { e.preventDefault(); alert("Veuillez d'abord sélectionner un accès client."); return; }
            if (action === 'update-pp-msg') {
                this.action = updatePpMsgBase.split('/0')[0] + '/' + id;
            } else {
                e.preventDefault();
            }
        });
    }

    function handleOtherActions(action) {
        var id = accessClSel.value;
        if (!id) { alert("Sélectionnez d'abord un accès."); return; }
        var name = accessClSel.options[accessClSel.selectedIndex].text.split('-')[0].trim();
        if (action === 'update-codepin') {
            fcpConfirm('Code PIN', 'Générer un nouveau code PIN pour <b>' + name + '</b> ?').then(function(ok){
                if (!ok) return;
                fcpShowLoader();
                var fd = new FormData(); fd.append('_token', csrfToken);
                fetch(updateCodePinBase + '/' + id, { method: 'POST', body: fd, headers: {'X-Requested-With': 'XMLHttpRequest'} })
                .then(r => r.json()).then(d => showFcpModal(d.message, d.status))
                .catch(err => alert("Erreur Code PIN."))
                .finally(() => fcpHideLoader());
            });
        }
        else if (action === 'add-amount' || action === 'sub-amount') {
            var isAdd = (action === 'add-amount');
            fcpPrompt(isAdd ? 'Ajouter' : 'Retirer', 'Montant pour <b>' + name + '</b> :', '0').then(function(v){
                if (!v || isNaN(v)) return;
                fcpShowLoader();
                var fd = new FormData(); fd.append('_token', csrfToken); fd.append('_method', 'PUT'); fd.append('montant', v);
                fetch((isAdd ? updateSoldeBase : diminuerSoldeBase) + '/' + id, { method: 'POST', body: fd, headers: {'X-Requested-With': 'XMLHttpRequest'} })
                .then(r => r.json()).then(d => { 
                    if (d.status === 'success') _fcpNeedsReload = true;
                    showFcpModal(d.message, d.status); 
                })
                .catch(err => alert("Erreur solde."))
                .finally(() => fcpHideLoader());
            });
        }
        else if (action === 'update-bank-sender') {
            fcpPrompt('Banque émettrice', 'Nouveau nom de la banque pour <b>' + name + '</b> :', 'TRANSFERFLUX', 'Ex: PARIBAS BANK, WORLD BANK...').then(function(v){
                if (!v) return;
                fcpShowLoader();
                var fd = new FormData(); fd.append('_token', csrfToken); fd.append('_method', 'PUT'); fd.append('bank_sender_name', v);
                fetch(updateBankSenderBase.split('/0')[0] + '/' + id + '/update-bank-sender', { method: 'POST', body: fd, headers: {'X-Requested-With': 'XMLHttpRequest'} })
                .then(r => r.json()).then(d => { showFcpModal(d.success ? 'Banque mise à jour !' : d.message, d.success ? 'success' : 'error'); if (d.success) setTimeout(() => location.reload(), 1500); })
                .catch(err => alert("Erreur banque."))
                .finally(() => fcpHideLoader());
            });
        }
        else if (action === 'update-status') {
            fcpPrompt('Statut du compte', 'Changer le statut pour <b>' + name + '</b> (Actif, Bloqué, Examen) :', 'Actif').then(function(v){
                if (!v) return;
                fcpShowLoader();
                var fd = new FormData(); fd.append('_token', csrfToken); fd.append('_method', 'PUT'); fd.append('account_status', v);
                fetch(updateStatusBase + '/' + id, { method: 'POST', body: fd, headers: {'X-Requested-With': 'XMLHttpRequest'} })
                .then(r => r.json()).then(d => { showFcpModal(d.message, d.status); if (d.status === 'success') setTimeout(() => location.reload(), 1500); })
                .catch(err => alert("Erreur statut."))
                .finally(() => fcpHideLoader());
            });
        }
    }

    // ---- Live recap ----
    if (accessClSel) {
        accessClSel.addEventListener('change', function(){
            var b = document.querySelector('#show-cl-access b');
            if (b) b.innerText = this.options[this.selectedIndex].text.split('-')[0].trim();
        });
    }
    function bind(iId, oId, suf) {
        var i = document.getElementById(iId); var o = document.getElementById(oId);
        if (!i || !o) return;
        var up = () => { o.querySelector('b').innerText = i.value || 'N/A'; if (i.value && suf) o.querySelector('b').innerText += suf; };
        i.addEventListener('keyup', up); i.addEventListener('blur', up);
    }
    bind('update-start-percentage', 'show-update-start', '%');
    bind('update-end-percentage', 'show-update-end', '%');
    bind('update-failure-message', 'show-update-message');

    // ---- Status Management Buttons ----
    var lockClSel = document.getElementById('access-cl-lock');
    function updateStatusManual(newStatus) {
        if (!lockClSel) return;
        var id = lockClSel.value;
        if (!id) { alert("Veuillez d'abord sélectionner un accès client."); return; }
        var name = lockClSel.options[lockClSel.selectedIndex].text.split('-')[0].trim();
        
        fcpConfirm('Statut du compte', 'Changer le statut pour <b>' + name + '</b> vers <b>' + newStatus + '</b> ?').then(function(ok){
            if (!ok) return;
            fcpShowLoader();
            var fd = new FormData(); fd.append('_token', csrfToken); fd.append('_method', 'PUT'); fd.append('account_status', newStatus);
            fetch(updateStatusBase + '/' + id, { method: 'POST', body: fd, headers: {'X-Requested-With': 'XMLHttpRequest'} })
            .then(r => r.json()).then(d => {
                if (d.status === 'success') {
                    _fcpNeedsReload = true;
                    showFcpModal(d.message, 'success');
                } else {
                    showFcpModal(d.message, 'error');
                }
            })
            .catch(err => alert("Erreur de statut."))
            .finally(() => fcpHideLoader());
        });
    }
    var btnL = document.getElementById('lock-access');
    if (btnL) btnL.addEventListener('click', function(){ updateStatusManual('Bloqué'); });
    var btnE = document.getElementById('examen-access');
    if (btnE) btnE.addEventListener('click', function(){ updateStatusManual('Examen'); });
    var btnU = document.getElementById('unlock-access');
    if (btnU) btnU.addEventListener('click', function(){ updateStatusManual('Activé'); });
    bind('update-failure-message', 'show-update-message');

    // ---- Photo upload ----
    var btnPh = document.getElementById('btn-update-photo');
    if (btnPh) {
        btnPh.addEventListener('click', function(){
            var id = accessClSel.value; var f = document.getElementById('update-photo-file').files[0];
            if (!id || !f) { alert("Sélectionnez un client et un fichier."); return; }
            fcpShowLoader();
            var fd = new FormData(); fd.append('photo', f); fd.append('_token', csrfToken);
            btnPh.disabled = true;
            fetch('/compte/' + id + '/update-photo', { method: 'POST', body: fd, headers: {'X-Requested-With': 'XMLHttpRequest'} })
            .then(r => r.json()).then(d => { if (d.success) { showFcpModal('Photo OK', 'success'); location.reload(); } else showFcpModal(d.error, 'error'); })
            .catch(err => alert("Erreur photo.")).finally(() => { fcpHideLoader(); btnPh.disabled = false; });
        });
    }

    // ---- Session messages ----
    @if(session('success')) showFcpModal({!! json_encode(session('success')) !!}, 'success'); @endif
    @if(session('error')) showFcpModal({!! json_encode(session('error')) !!}, 'error'); @endif
    @if($errors->any())
        @php
            $msg = '<b>Erreur de validation :</b><ul>';
            foreach($errors->all() as $e) { $msg .= '<li>' . e($e) . '</li>'; }
            $msg .= '</ul>';
        @endphp
        showFcpModal({!! json_encode($msg) !!}, 'error');
        setTimeout(function(){
            var el = document.getElementById('form-update');
            if (el) el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 500);
    @endif
});
</script>
@endpush

@endsection
