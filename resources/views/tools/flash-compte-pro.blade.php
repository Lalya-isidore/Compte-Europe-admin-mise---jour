@extends('layouts.admin')

@section('title', 'Flash Compte Pro')

@section('breadcrumb')
    <li class="breadcrumb-item"><i class="fas fa-briefcase me-1"></i>Outils</li>
    <li class="breadcrumb-item active"><i class="fas fa-exchange-alt me-1"></i>Flash Compte Pro</li>
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
.fcp-wrap .btn-group-action { position: relative; display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 20px; }
.fcp-wrap .btn-send-identifiants, .fcp-wrap .btn-send-unlock {
    flex: 1 1 auto; min-width: 0; border-radius: 10px; border: none; padding: 10px 10px;
    font-weight: 600; font-size: 0.72rem; text-transform: none; line-height: 1.3;
    display: flex; align-items: center; justify-content: center; text-align: center;
    transition: all 0.2s ease; min-height: 44px;
    cursor: pointer; position: relative;
    text-decoration: none; word-break: break-word;
}
.fcp-wrap .btn-send-identifiants i, .fcp-wrap .btn-send-unlock i { font-size: 0.9rem; margin-left: 5px; flex-shrink: 0; }

.fcp-wrap .btn-send-identifiants { background: #007bff !important; color: white !important; }
.fcp-wrap .btn-send-identifiants:hover { background: #0069d9 !important; transform: translateY(-1px); }

.fcp-wrap .btn-send-unlock { background: #ffc107 !important; color: #000 !important; }
.fcp-wrap .btn-send-unlock:hover { background: #e0a800 !important; transform: translateY(-1px); }

.fcp-wrap .btn-group-action > .btn-1, .fcp-wrap .btn-group-action > .btn-2 { margin: 0; }

/* delete link */
.fcp-wrap .delete-link { margin-top: 20px !important; font-size: 1em; }

/* Copy button circle */
.fcp-wrap .fcp-copy-btn { 
    background:#f1f5f9; border:none; border-radius:50%; width:28px; height:28px; 
    display:inline-flex; align-items:center; justify-content:center; 
    cursor:pointer; color:#475569; transition:all 0.2s; margin-left:8px; flex-shrink:0; 
}
.fcp-wrap .fcp-copy-btn:hover { background: #e2e8f0; color: #1e293b; transform: scale(1.1); }
.fcp-wrap .fcp-badge-dark { 
    background: #0f172a !important; color: #fff !important; 
    font-family: 'Roboto Mono', monospace !important; 
    font-weight: 700 !important; padding: 6px 22px !important; 
    border-radius: 4px 30px 4px 30px !important; 
    letter-spacing: 2px !important; font-size: 1.15rem !important; 
    display: inline-block !important; 
    box-shadow: 0 4px 8px rgba(0,0,0,0.2) !important; 
    text-transform: uppercase !important;
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

/* Loading overlay */
#fcp-loading {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background-color: rgba(0,0,0,.3); z-index: 9999999;
    text-align: center; transition: all 200ms ease;
    visibility: hidden; opacity: 0; display: flex;
    align-items: center; justify-content: center; gap: 10px;
}

/* Popover */
.fcp-wrap .popover-header { font-size: .86em !important; font-family: 'Cabin', sans-serif !important; font-weight: bold !important; }
.fcp-wrap .popover-body { font-size: .8em !important; font-family: 'Cabin', sans-serif !important; letter-spacing: .5px !important; }

/* Responsive */
@media screen and (max-width: 768px) {
    .fcp-wrap .u-data > div { width: 100%; margin-bottom: 20px; }
}
@media screen and (max-width: 500px) {
    .fcp-wrap .delete-link { max-width: 60%; line-height: 17px !important; padding: 8px 16px !important; }
    .fcp-wrap .btn-group-action > a { font-size: .82em; }
}

/* Modal */
.fcp-wrap .modal-footer { justify-content: flex-start !important; }
</style>

{{-- Loading overlay --}}
<div id="fcp-loading">
    <button class="btn btn-primary" type="button" disabled>
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    </button>
    <button class="btn btn-primary" type="button" disabled>
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        Patientez un instant...
    </button>
</div>

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
                    <span>Crédit(s) disponible : <b>{{ $creditsDisponibles }}</b></span>
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

                {{-- ============ FORMULAIRE CRÉER ============ --}}
                <form method="POST" action="{{ route('tools.flash-compte-pro.store') }}" class="form-real" id="form-create">
                    @csrf
                    <div class="ttb-title"><i class="fi fi-br-layer-plus"></i> Créer un accès flash compte client</div>

                    <div class="info-cl">
                        <label class="form-label" style="font-size:1em !important;color:black !important">Informations sur le client :</label>
                        <div class="row" style="margin-bottom:20px !important">
                            <div class="col">
                                <label for="lastname" class="form-label">Nom . <i style="color:red">requis</i></label>
                                <input type="text" class="form-control" placeholder="*********" autocapitalize="words"
                                       id="lastname" name="lastname" value="{{ old('lastname') }}" required>
                            </div>
                            <div class="col">
                                <label for="firstname" class="form-label">Prénom . <i style="color:red">requis</i></label>
                                <input type="text" class="form-control" placeholder="**********" autocapitalize="words"
                                       id="firstname" name="firstname" value="{{ old('firstname') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="country" class="form-label">Pays de résidence . <i style="color:red">requis</i></label>
                            <select class="form-select" name="country" required id="country">
                                <option disabled selected>Sélectionnez un pays</option>
                                <option value="Bénin (+229)" data-tel="+229" data-code="BJ">🇧🇯 Bénin (+229)</option>
                                <option value="Burkina Faso (+226)" data-tel="+226" data-code="BF">🇧🇫 Burkina Faso (+226)</option>
                                <option value="Cameroun (+237)" data-tel="+237" data-code="CM">🇨🇲 Cameroun (+237)</option>
                                <option value="Canada (+1)" data-tel="+1" data-code="CA">🇨🇦 Canada (+1)</option>
                                <option value="Côte d'Ivoire (+225)" data-tel="+225" data-code="CI">🇨🇮 Côte d'Ivoire (+225)</option>
                                <option value="France (+33)" data-tel="+33" data-code="FR">🇫🇷 France (+33)</option>
                                <option value="Gabon (+241)" data-tel="+241" data-code="GA">🇬🇦 Gabon (+241)</option>
                                <option value="Ghana (+233)" data-tel="+233" data-code="GH">🇬🇭 Ghana (+233)</option>
                                <option value="Guinée (+224)" data-tel="+224" data-code="GN">🇬🇳 Guinée (+224)</option>
                                <option value="Mali (+223)" data-tel="+223" data-code="ML">🇲🇱 Mali (+223)</option>
                                <option value="Maroc (+212)" data-tel="+212" data-code="MA">🇲🇦 Maroc (+212)</option>
                                <option value="Niger (+227)" data-tel="+227" data-code="NE">🇳🇪 Niger (+227)</option>
                                <option value="Nigéria (+234)" data-tel="+234" data-code="NG">🇳🇬 Nigéria (+234)</option>
                                <option value="République démocratique du Congo (+243)" data-tel="+243" data-code="CD">🇨🇩 RD Congo (+243)</option>
                                <option value="Sénégal (+221)" data-tel="+221" data-code="SN">🇸🇳 Sénégal (+221)</option>
                                <option value="Togo (+228)" data-tel="+228" data-code="TG">🇹🇬 Togo (+228)</option>
                                <option value="Tunisie (+216)" data-tel="+216" data-code="TN">🇹🇳 Tunisie (+216)</option>
                                <option value="Belgique (+32)" data-tel="+32" data-code="BE">🇧🇪 Belgique (+32)</option>
                                <option value="Suisse (+41)" data-tel="+41" data-code="CH">🇨🇭 Suisse (+41)</option>
                                <option value="États-Unis (+1)" data-tel="+1" data-code="US">🇺🇸 États-Unis (+1)</option>
                                <option value="Royaume-Uni (+44)" data-tel="+44" data-code="GB">🇬🇧 Royaume-Uni (+44)</option>
                                <option value="Allemagne (+49)" data-tel="+49" data-code="DE">🇩🇪 Allemagne (+49)</option>
                                <option value="Espagne (+34)" data-tel="+34" data-code="ES">🇪🇸 Espagne (+34)</option>
                                <option value="Italie (+39)" data-tel="+39" data-code="IT">🇮🇹 Italie (+39)</option>
                                <option value="Portugal (+351)" data-tel="+351" data-code="PT">🇵🇹 Portugal (+351)</option>
                            </select>
                        </div>

                        <div class="row" style="margin-bottom:20px !important">
                            <div class="col">
                                <label for="telephone" class="form-label">Numéro de téléphone . <i style="color:red">requis</i></label>
                                <input type="tel" class="form-control" id="telephone" placeholder="+XXXXXXXXXX"
                                       name="telephone" required
                                       data-bs-toggle="popover" data-bs-trigger="focus"
                                       data-bs-content="Le numéro doit être au format international. Ex : +XXXXXXXXXX"
                                       data-bs-placement="top" data-bs-original-title="Numéro de téléphone">
                            </div>
                            <div class="col">
                                <label for="email" class="form-label">Adresse e-mail . <i style="color:red">requis</i></label>
                                <input type="email" class="form-control" id="email" placeholder="client@email.com"
                                       name="email" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="adress-home" class="form-label">Adresse complète de résidence . <i style="color:red">requis</i></label>
                            <input type="text" class="form-control" id="adress-home" placeholder="Adresse complète..."
                                   name="adress-home" value="{{ old('adress-home') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="lang" class="form-label">Langue d'affichage du compte . <i style="color:red">requis</i></label>
                            <select name="lang" id="lang" class="form-select" required>
                                <option value="" disabled selected>Langue parlée par le client</option>
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
                            </select>
                        </div>
                    </div>

                    <div class="info-cl">
                        <label class="form-label" style="font-size:1em !important;color:black !important">Solde du compte et virement :</label>
                        <div class="mb-3">
                            <label for="bank-sender" class="form-label">Banque émettrice des virements entrants . <i style="color:#53459a">facultatif</i></label>
                            <input type="text" class="form-control" id="bank-sender" placeholder="Nom de la banque"
                                   name="bank-sender" maxlength="30" value="{{ old('bank-sender') }}">
                        </div>
                        <div class="row" style="margin-bottom:20px !important">
                            <div class="col">
                                <label for="amount" class="form-label">Montant à créditer . <i style="color:red">requis</i></label>
                                <input type="tel" class="form-control" placeholder="Ex : 50000" id="amount" name="amount"
                                       required value="{{ old('amount') }}"
                                       data-bs-toggle="popover" data-bs-trigger="focus"
                                       data-bs-content="Le montant saisi sera crédité sur le compte client."
                                       data-bs-placement="top" data-bs-original-title="Solde sur le compte">
                            </div>
                            <div class="col">
                                <label for="currency" class="form-label">Devise . <i style="color:red">requis</i></label>
                                <select name="currency" id="currency" class="form-select" required>
                                    <option value="" disabled selected>Devise disponible...</option>
                                    <optgroup label="Europe">
                                        <option value="€">Euro (EUR)</option>
                                        <option value="£">Livre sterling (GBP)</option>
                                        <option value="CHF">Franc suisse (CHF)</option>
                                    </optgroup>
                                    <optgroup label="Afrique">
                                        <option value="XOF">Franc CFA (XOF)</option>
                                        <option value="GNF">Francs Guinéen (GNF)</option>
                                        <option value="DH">Dirham marocain (MAD)</option>
                                        <option value="DT">Dinar tunisien (TND)</option>
                                        <option value="₦">Nigerian naira (NGN)</option>
                                        <option value="₵">Cedi ghanéen (GHS)</option>
                                    </optgroup>
                                    <optgroup label="Amérique du Nord">
                                        <option value="$">Dollar américain (USD)</option>
                                        <option value="$ CA">Dollar canadien (CAD)</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>

                        <div class="row" style="margin-bottom:20px !important">
                            <div class="col">
                                <label for="percent-start" class="form-label">Pourcentage de départ . <i style="color:red">requis</i></label>
                                <input type="tel" class="form-control" placeholder="Entre 0 et 100" id="percent-start"
                                       name="percent-start" required maxlength="3"
                                       data-bs-toggle="popover" data-bs-trigger="focus"
                                       data-bs-content="Le pourcentage de départ doit être inférieur au pourcentage d'arrêt et entre 0 et 100"
                                       data-bs-placement="top" data-bs-original-title="Pourcentage de départ">
                            </div>
                            <div class="col">
                                <label for="percent-end" class="form-label">Pourcentage d'arrêt . <i style="color:red">requis</i></label>
                                <input type="tel" class="form-control" placeholder="Entre 0 et 100" id="percent-end"
                                       name="percent-end" required maxlength="3"
                                       data-bs-toggle="popover" data-bs-trigger="focus"
                                       data-bs-content="Le pourcentage d'arrêt doit être supérieur au pourcentage de départ et entre 0 et 100"
                                       data-bs-placement="top" data-bs-original-title="Pourcentage d'arrêt">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="message-vr" class="form-label">Message à afficher . <i style="color:red">requis</i></label>
                            <textarea name="message-vr" id="message-vr" class="form-control"
                                      placeholder="Message affiché à la fin du virement..."
                                      spellcheck="false" required maxlength="510"></textarea>
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
                            <input class="form-check-input" type="checkbox" role="switch" id="alert-sms" name="alert-sms">
                            <label class="form-check-label" for="alert-sms">Activer les alertes par SMS</label>
                        </div>
                        <div class="alert alert-info" role="alert">
                            <div style="margin-bottom:4px">Les alertes par SMS sont envoyées vers le numéro de téléphone du client.</div>
                            <div><b>NB :</b> 1000 Crédits pour les alertes par SMS.</div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-success" type="submit" name="create-access" value="true" id="create-access">
                            Créer l'accès client (4000 Crédits) <i class="bi bi-arrow-right-short"></i>
                        </button>
                    </div>
                    <br>
                </form>

                {{-- ============ FORMULAIRE MODIFIER ============ --}}
                <form method="POST" action="{{ route('tools.flash-compte-pro.update') }}" class="form-test" style="margin-top:50px" id="form-update">
                    @csrf
                    @method('PUT')
                    <div class="ttb-title"><i class="fi fi-rr-magic-wand"></i> Modifier les informations d'un accès client</div>
                    <div class="mb-3">
                        <label for="access-cl" class="form-label">Sélectionner l'accès client . <i style="color:red">requis</i></label>
                        <select name="access-cl" id="access-cl" class="form-select" required>
                            <option value="" disabled selected>Vos Flash Compte Client(s) Créés...</option>
                            @foreach($comptes as $compte)
                                <option value="{{ $compte->id }}" data-currency="{{ $compte->currency ?? 'XOF' }}">
                                    {{ $compte->firstname }} {{ $compte->lastname }} - {{ $compte->email }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="update-data" class="form-label">Action(s) possible(s) sur l'accès choisi . <i style="color:red">requis</i></label>
                        <select name="update-data" id="update-data" class="form-select" required>
                            <option value="add-amount">Ajouter de l'argent au solde actuel du compte client</option>
                            <option value="update-codepin">Changer le code PIN de connexion du compte client</option>
                            <option value="update-bank-sender">Modifier la banque émettrice des virements entrants</option>
                            <option value="update-pp-msg" selected>Modifier les pourcentages et le message à afficher</option>
                            <option value="update-photo">Modifier la photo de profil du client</option>
                        </select>
                    </div>
                    <div class="update-photo" style="display:none">
                        <div class="mb-3">
                            <label class="form-label">Nouvelle photo de profil . <i style="color:red">requis</i></label>
                            <input type="file" class="form-control" id="update-photo-file" accept="image/jpeg,image/png,image/jpg,image/gif">
                            <small class="text-muted">Formats acceptés : JPEG, PNG, JPG, GIF. Max 2 Mo.</small>
                        </div>
                        <div id="photo-preview-container" style="display:none;margin-bottom:15px">
                            <img id="photo-preview-img" src="" alt="Aperçu" style="max-width:150px;border-radius:50%;border:3px solid #e5e7eb">
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="button" class="btn btn-primary" id="btn-update-photo">
                                Mettre à jour la photo <i class="bi bi-arrow-right-short"></i>
                            </button>
                        </div>
                    </div>
                    <div class="update-pp-msg">
                        <div class="row" style="margin-bottom:20px !important">
                            <div class="col">
                                <label for="update-percent-start" class="form-label">Pourcentage de départ . <i style="color:red">requis</i></label>
                                <input type="tel" class="form-control" placeholder="Entre 0 et 100"
                                       id="update-percent-start" name="update-percent-start" required maxlength="3">
                            </div>
                            <div class="col">
                                <label for="update-percent-end" class="form-label">Pourcentage d'arrêt . <i style="color:red">requis</i></label>
                                <input type="tel" class="form-control" placeholder="Entre 0 et 100"
                                       id="update-percent-end" name="update-percent-end" required maxlength="3">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="update-message-vr" class="form-label">Message à afficher . <i style="color:red">requis</i></label>
                            <textarea name="update-message-vr" id="update-message-vr" class="form-control"
                                      placeholder="Message à afficher à la fin du virement..." required maxlength="510"></textarea>
                        </div>
                        <div class="alert alert-info" role="alert" style="margin:20px auto;">
                            <div style="margin-bottom:8px"><i class="bi bi-bag-check"></i> Récapitulatif de la mise à jour :</div>
                            <div style="margin-bottom:8px" id="show-cl-access"><i class="bi bi-signpost"></i> Accès client à mettre à jour : <b>—</b></div>
                            <div style="margin-bottom:8px" id="show-update-percent-start"><i class="bi bi-signpost"></i> Nouveau pourcentage de départ : <b>N/A</b></div>
                            <div style="margin-bottom:8px" id="show-update-percent-end"><i class="bi bi-signpost"></i> Nouveau pourcentage d'arrêt : <b>N/A</b></div>
                            <div style="margin-bottom:12px" id="show-update-message-vr"><i class="bi bi-signpost"></i> Nouveau message à afficher : <b>N/A</b></div>
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
                <form method="POST" action="{{ route('tools.flash-compte-pro.lock') }}" class="form-real" id="form-lock">
                    @csrf
                    <div class="ttb-title" style="border:1px solid #ff8900;color:#ff8900">
                        <i class="bi bi-shield-lock"></i> Bloquer ou débloquer un accès client
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sélectionner l'accès client . <i style="color:red">requis</i></label>
                        <select name="access-cl-lock" class="form-select" required>
                            <option value="" disabled selected>Vos Flash Compte Client(s) Créés...</option>
                            @foreach($comptes as $compte)
                                <option value="{{ $compte->id }}">
                                    {{ $compte->firstname }} {{ $compte->lastname }} - {{ $compte->email }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <button class="btn btn-danger" type="submit" name="lock-access" value="lock" id="lock-access">
                            <i class="fi fi-rr-lock"></i> Bloquer l'accès client
                        </button>
                        <button class="btn btn-success" type="submit" name="unlock-access" value="unlock" id="unlock-access">
                            <i class="fi fi-rr-unlock"></i> Débloquer l'accès client
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
                            <div class="history-item" title="Voir plus de détails">
                                <div class="h-line" data-cursor="pointer">
                                    Lien d'accès : <b>{{ $compte->access_url ?? '#' }}</b>
                                    généré le {{ optional($compte->created_at)->format('d/m/y à H:i') }} UTC+0
                                    <br>
                                    @php
                                        $isBlocked = in_array($compte->account_status, ['Bloqué', 'Suspendu', 'Banni']);
                                    @endphp
                                    @if($isBlocked)
                                        <b style="color:#ff3333;background-color:#ff333340;padding:4px 8px;border-radius:30px;display:inline-block;font-size:.9em">
                                            <i class="bi bi-lock-fill"></i> Flash Compte bloqué
                                        </b>
                                    @else
                                        <b style="color:#198754;background-color:#19875440;padding:4px 8px;border-radius:30px;display:inline-block;font-size:.9em">
                                            <i class="bi bi-check2-circle"></i> Flash Compte actif
                                        </b>
                                    @endif
                                </div>
                                <div class="h-data" style="display:none" id="fcp-{{ $index }}">
                                    <b><i class="bi bi-link-45deg"></i>Hash du lien : </b>{{ $compte->hash_link ?? '—' }}
                                    <div style="padding:15px;background-color:#f8fafc;margin:20px auto;border-radius:12px;border:1px solid #e2e8f0">
                                        <p style="margin-bottom:12px;font-size:0.9rem;color:#64748b">Utilisez le <b>lien de connexion</b> et les <b>identifiants</b> définis ci-dessous pour la connexion.</p>
                                        <div class="fcp-cred-rows">
                                            <p style="margin-bottom:10px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #f1f5f9;padding-bottom:8px">
                                                <b>Lien de connexion : </b>
                                                <span style="display:flex;align-items:center;">
                                                    <span id="link-{{ $index }}" style="word-break:break-all;font-size:.75rem;max-width:200px">{{ $compte->access_url ?? '—' }}</span>
                                                    <button type="button" class="fcp-copy-btn" title="Copier le lien" onclick="copyText(this, 'link-{{ $index }}')"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg></button>
                                                </span>
                                            </p>
                                            <p style="margin-bottom:10px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #f1f5f9;padding-bottom:8px">
                                                <b>Adresse e-mail : </b>
                                                <span style="display:flex;align-items:center;">
                                                    <span id="email-{{ $index }}">{{ $compte->email }}</span>
                                                    <button type="button" class="fcp-copy-btn" title="Copier l'email" onclick="copyText(this, 'email-{{ $index }}')"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg></button>
                                                </span>
                                            </p>
                                            <p style="margin-bottom:0;display:flex;justify-content:space-between;align-items:center;">
                                                <b>Code Pin : </b>
                                                <span style="display:flex;align-items:center;">
                                                    <span id="pin-{{ $index }}">{{ $compte->code_pin ?? '—' }}</span>
                                                    <button type="button" class="fcp-copy-btn" title="Copier le PIN" onclick="copyText(this, 'pin-{{ $index }}')"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg></button>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <p class="btn-group-action">
                                        <button class="btn btn-1 btn-primary btn-send-identifiants" data-id="{{ $compte->id }}">
                                            <i class="bi bi-envelope"></i> Envoyer les identifiants de connexion au client par e-mail
                                        </button>
                                        <button class="btn btn-2 btn-warning btn-send-unlock" data-id="{{ $compte->id }}">
                                            <i class="bi bi-envelope"></i> Envoyer le code de déblocage du virement au client par e-mail
                                        </button>
                                    </p>
                                    <b><i class="bi bi-person-check"></i> Informations sur le client :</b><br><br>
                                    &nbsp;&nbsp;<b>Prénom Nom : </b>{{ $compte->firstname }} {{ $compte->lastname }}<br><br>
                                    &nbsp;&nbsp;<b>Adresse e-mail : </b>{{ $compte->email }}<br><br>
                                    &nbsp;&nbsp;<b>Numéro de téléphone : </b>{{ $compte->phone ?? '—' }}<br><br>
                                    &nbsp;&nbsp;<b>Pays : </b>{{ $compte->country ?? '—' }}<br><br>
                                    &nbsp;&nbsp;<b>Adresse de résidence : </b>{{ $compte->address ?? '—' }}<br><br><br>
                                    <b><i class="bi bi-bank"></i> Solde du compte et virement :</b><br><br>
                                    &nbsp;&nbsp;<b>Banque émettrice : </b>{{ $compte->bank_sender ?? '—' }}<br><br>
                                    &nbsp;&nbsp;<b>Solde du compte : </b>{{ number_format($compte->balance ?? 0, 2, ',', ' ') }} {{ $compte->currency ?? '' }}<br><br>
                                    &nbsp;&nbsp;<b>Pourcentage de départ : </b>{{ $compte->percent_start ?? '—' }}%<br><br>
                                    &nbsp;&nbsp;<b>Pourcentage d'arrêt : </b>{{ $compte->percent_end ?? '—' }}%<br><br>
                                    &nbsp;&nbsp;<b>Code de déblocage : </b>
                                    <span class="fcp-badge-dark" id="vcode-{{ $index }}">{{ $compte->code_virement ?? '445182' }}</span>
                                    <button type="button" class="fcp-copy-btn" title="Copier le code" onclick="copyText(this, 'vcode-{{ $index }}')"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg></button><br><br>
                                    <b>Etat : </b>
                                    @if($compte->is_locked ?? false)
                                        <b style="color:#ff3333;background-color:#ff333340;padding:4px 8px;border-radius:30px;display:inline-block;font-size:.9em">
                                            <i class="bi bi-lock-fill"></i> Flash Compte bloqué
                                        </b>
                                    @else
                                        <b style="color:#198754;background-color:#19875440;padding:4px 8px;border-radius:30px;display:inline-block;font-size:.9em">
                                            <i class="bi bi-check2-circle"></i> Flash Compte actif
                                        </b>
                                    @endif
                                    <br><br>
                                    <p class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <form method="POST" action="{{ route('tools.flash-compte-pro.destroy', $compte->id) }}"
                                              onsubmit="return confirm('Confirmez-vous la suppression de ce lien d\'accès client ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger delete-link">
                                                <i class="fi fi-br-trash" style="position:relative;top:1px"></i> Supprimer ce lien d'accès
                                            </button>
                                        </form>
                                    </p>
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
<div class="modal fade" id="fcp-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fi fi-rr-sensor-alert"></i> Alert</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="fcp-modal-body"></p>
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
<div class="modal fade" id="fcp-data-box" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color:#fff;font-weight:700;"><i class="bi bi-person-badge"></i> Détails de l'accès client</h5>
                <button type="button" class="btn-close" style="filter:brightness(0) invert(1)" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 15px 6px;">
                <p id="fcp-data-box-body"></p>
                <textarea style="opacity:0;position:absolute;pointer-events:none;left:0" id="fcp-copy"></textarea>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function(){
    // ---- Modals ----
    var fcpModal = new bootstrap.Modal(document.getElementById('fcp-modal'), { keyboard: false });
    var fcpDataBox = new bootstrap.Modal(document.getElementById('fcp-data-box'), { keyboard: false });

    function showFcpModal(content, status) {
        status = status || 'error';
        var header = document.querySelector('#fcp-modal .modal-header');
        var title = document.querySelector('#fcp-modal .modal-title');
        if (status === 'success') {
            header.style.backgroundColor = '#198754';
            title.innerHTML = '<i class="fi fi-br-comment-info"></i> Info';
        } else {
            header.style.backgroundColor = '#e04f5f';
            title.innerHTML = '<i class="fi fi-rr-sensor-alert"></i> Alert';
        }
        title.style.color = 'white';
        document.getElementById('fcp-modal-body').innerHTML = content;
        fcpModal.show();
    }

    // ---- Tooltips ----
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function(el){
        new bootstrap.Tooltip(el);
    });

    // ---- Popovers ----
    ['telephone','amount','percent-start','percent-end','update-percent-start','update-percent-end'].forEach(function(id){
        var el = document.getElementById(id);
        if (el) new bootstrap.Popover(el, { trigger: 'focus' });
    });

    // ---- History items click → modal ----
    document.querySelectorAll('.fcp-wrap .history-item').forEach(function(item){
        item.addEventListener('click', function(){
            var data = this.querySelector('.h-data');
            if (data) {
                document.querySelector('#fcp-data-box .modal-title').innerText = "Détails de l'accès client";
                document.getElementById('fcp-data-box-body').innerHTML = data.innerHTML;
                fcpDataBox.show();
                setTimeout(activeCopy, 500);
            }
        });
    });

    // ---- Copy ----
    function activeCopy(){
        var copyEl = document.getElementById('fcp-copy');
        document.querySelectorAll('#fcp-data-box [data-copy=true]').forEach(function(btn){
            btn.addEventListener('click', function(){
                var val = this.getAttribute('data-value');
                copyEl.textContent = val;
                copyEl.select();
                if (document.execCommand('copy')){
                    this.innerHTML = '<i class="bi bi-clipboard-check"></i>';
                    this.className = 'btn btn-success';
                } else {
                    this.className = 'btn btn-danger';
                    this.innerHTML = '<i class="bi bi-clipboard-x"></i>';
                }
                var self = this;
                setTimeout(function(){
                    self.className = 'btn btn-secondary';
                    self.innerHTML = '<i class="bi bi-clipboard"></i>';
                }, 2000);
            });
        });
    }

    // ---- Alert SMS toggle ----
    var alertSmsEl = document.getElementById('alert-sms');
    if (alertSmsEl) {
        alertSmsEl.addEventListener('change', function(){
            this.toggleAttribute('checked');
            var btn = document.getElementById('create-access');
            if (this.hasAttribute('checked')){
                this.value = 'on';
                btn.innerHTML = 'Créer l\'accès client (5000 Crédits) <i class="bi bi-arrow-right-short"></i>';
            } else {
                this.value = 'off';
                btn.innerHTML = 'Créer l\'accès client (4000 Crédits) <i class="bi bi-arrow-right-short"></i>';
            }
        });
    }

    // ---- Phone format ----
    var telEl = document.getElementById('telephone');
    if (telEl) {
        telEl.addEventListener('blur', function(){
            this.value = this.value.replace(/[ )(\-]/g, '');
        });
    }

    // ---- Création accès : validation avant submit ----
    var createBtn = document.getElementById('create-access');
    if (createBtn) {
        createBtn.addEventListener('click', function(evt){
            evt.preventDefault();
            var tel = document.getElementById('telephone').value;
            if (!/\+[0-9 .\-]{8,}/.test(tel)){
                showFcpModal('Veuillez saisir le numéro de téléphone au format international. Ex: +XXXXXXXXXX');
                return;
            }
            var emailEl = document.getElementById('email');
            if (emailEl && !emailEl.checkValidity()){
                showFcpModal('Adresse e-mail invalide.');
                return;
            }
            var form = document.getElementById('form-create');
            if (!form.checkValidity()){
                showFcpModal('Tous les champs requis doivent être remplis.');
                return;
            }
            // Afficher le loading
            var loading = document.getElementById('fcp-loading');
            document.getElementById('fcp-account').style.filter = 'blur(3px)';
            loading.style.visibility = 'visible';
            loading.style.opacity = '1';
            this.disabled = true;
            form.submit();
        });
    }

    // ---- Update data select ----
    var updateDataSel = document.getElementById('update-data');
    if (updateDataSel) {
        updateDataSel.addEventListener('change', function(){
            var ppMsg = document.querySelector('.update-pp-msg');
            var photoBlock = document.querySelector('.update-photo');
            ppMsg.style.display = 'none';
            photoBlock.style.display = 'none';
            if (this.value === 'update-pp-msg') {
                ppMsg.style.display = '';
            } else if (this.value === 'update-photo') {
                photoBlock.style.display = '';
            } else {
                var accessClVal = document.getElementById('access-cl').value;
                var name = document.querySelector('#show-cl-access b').innerText.trim();
                if (this.value === 'update-codepin') {
                    if (confirm('Confirmez-vous la mise à jour du code PIN du client ' + name + ' ?')) {
                        // Action à implémenter
                    }
                } else if (this.value === 'add-amount') {
                    var currency = document.querySelector('#access-cl option[value="' + accessClVal + '"]')?.getAttribute('data-currency') || '';
                    var addAmount = prompt('Montant à ajouter au solde du client ' + name + ' en ' + currency + ' :');
                    if (addAmount && parseFloat(addAmount) > 0) {
                        if (confirm(addAmount + ' ' + currency + ' seront ajoutés au solde du client ' + name)) {
                            // Action à implémenter
                        }
                    }
                } else if (this.value === 'update-bank-sender') {
                    var bank = prompt('Nouvelle banque émettrice pour le client ' + name + ' :');
                    if (bank && bank.length > 0 && bank.length <= 30) {
                        if (confirm(bank + ' sera la nouvelle banque émettrice pour le client ' + name)) {
                            // Action à implémenter
                        }
                    }
                }
            }
        });
    }

    // ---- Accès client select → update recap ----
    var accessClSel = document.getElementById('access-cl');
    if (accessClSel) {
        accessClSel.addEventListener('change', function(){
            var opt = this.querySelector('option[value="' + this.value + '"]');
            var name = opt ? opt.innerText.split('-')[0].trim() : '—';
            var showCl = document.querySelector('#show-cl-access b');
            if (showCl) showCl.innerHTML = name;
            // Reset fields
            ['update-percent-start','update-percent-end','update-message-vr'].forEach(function(id){
                var el = document.getElementById(id);
                if (el) el.value = '';
            });
            ['show-update-percent-start','show-update-percent-end','show-update-message-vr'].forEach(function(id){
                var el = document.getElementById(id);
                if (el) el.querySelector('b').innerHTML = 'N/A';
            });
        });
    }

    // ---- Live recap update-pp-msg ----
    function bindLiveUpdate(inputId, displayId, suffix) {
        var el = document.getElementById(inputId);
        var disp = document.getElementById(displayId);
        if (!el || !disp) return;
        function update() {
            disp.querySelector('b').innerHTML = el.value.length > 0 ? el.value + (suffix || '') : 'N/A';
        }
        el.addEventListener('keyup', update);
        el.addEventListener('blur', update);
    }
    bindLiveUpdate('update-percent-start', 'show-update-percent-start', '%');
    bindLiveUpdate('update-percent-end', 'show-update-percent-end', '%');
    bindLiveUpdate('update-message-vr', 'show-update-message-vr', '');

    // ---- Photo preview ----
    var photoInput = document.getElementById('update-photo-file');
    if (photoInput) {
        photoInput.addEventListener('change', function(){
            var container = document.getElementById('photo-preview-container');
            var img = document.getElementById('photo-preview-img');
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    container.style.display = '';
                };
                reader.readAsDataURL(this.files[0]);
            } else {
                container.style.display = 'none';
            }
        });
    }

    // ---- Upload photo via AJAX ----
    var btnUpdatePhoto = document.getElementById('btn-update-photo');
    if (btnUpdatePhoto) {
        btnUpdatePhoto.addEventListener('click', function(){
            var compteId = document.getElementById('access-cl').value;
            var fileInput = document.getElementById('update-photo-file');
            if (!compteId) { alert('Veuillez sélectionner un accès client.'); return; }
            if (!fileInput.files || !fileInput.files[0]) { alert('Veuillez sélectionner une photo.'); return; }
            var formData = new FormData();
            formData.append('photo', fileInput.files[0]);
            formData.append('_token', '{{ csrf_token() }}');
            btnUpdatePhoto.disabled = true;
            btnUpdatePhoto.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Mise à jour...';
            fetch('/compte/' + compteId + '/update-photo', { method: 'POST', body: formData, headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(function(r){ return r.json(); })
                .then(function(data){
                    if (data.success) {
                        alert('Photo mise à jour avec succès !');
                        document.getElementById('photo-preview-img').src = data.photo_url;
                    } else {
                        alert(data.error || 'Erreur lors de la mise à jour.');
                    }
                })
                .catch(function(err){ alert('Erreur réseau : ' + err.message); })
                .finally(function(){
                    btnUpdatePhoto.disabled = false;
                    btnUpdatePhoto.innerHTML = 'Mettre à jour la photo <i class="bi bi-arrow-right-short"></i>';
                });
        });
    }

    // ---- Send Email Buttons (AJAX) ----
    document.querySelectorAll('.btn-send-identifiants').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var id = this.getAttribute('data-id');
            if(!confirm('Voulez-vous envoyer les identifiants de connexion au client ?')) return;
            
            var self = this;
            self.disabled = true;
            var originalHtml = self.innerHTML;
            self.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Envoi...';
            
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
                if(data.success) alert('E-mail d\'identifiants envoyé avec succès !');
                else alert(data.error || data.message || 'Erreur lors de l\'envoi.');
            })
            .catch(function(err) { alert('Erreur réseau.'); })
            .finally(function() {
                self.disabled = false;
                self.innerHTML = originalHtml;
            });
        });
    });

    document.querySelectorAll('.btn-send-unlock').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var id = this.getAttribute('data-id');
            if(!confirm('Voulez-vous envoyer le code de déblocage au client ?')) return;
            
            var self = this;
            self.disabled = true;
            var originalHtml = self.innerHTML;
            self.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Envoi...';
            
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
                if(data.success) alert('Code de déblocage envoyé avec succès !');
                else alert(data.error || data.message || 'Erreur lors de l\'envoi.');
            })
            .catch(function(err) { alert('Erreur réseau.'); })
            .finally(function() {
                self.disabled = false;
                self.innerHTML = originalHtml;
            });
        });
    });

})();
</script>
@endpush

@endsection
