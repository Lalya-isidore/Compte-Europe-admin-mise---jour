@extends('layouts.admin')

@section('page-class', 'page-flush')
@section('title', 'SMS Pro')

@php
$svg = [
    'sms'       => '<svg width="26" height="26" viewBox="0 0 24 24" fill="white"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H5.17L4 17.17V4h16v12zM7 9h2v2H7zm4 0h2v2h-2zm4 0h2v2h-2z"/></svg>',
    'plane'     => '<svg width="16" height="16" viewBox="0 0 24 24" fill="white"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>',
    'plane_lg'  => '<svg width="22" height="22" viewBox="0 0 24 24" fill="white"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>',
    'check'     => '<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>',
    'check_green'=> '<svg width="15" height="15" viewBox="0 0 24 24" fill="#16a34a"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>',
    'chevron'   => '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>',
    'info'      => '<svg width="18" height="18" viewBox="0 0 24 24" fill="#0891b2"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>',
    'user'      => '<svg width="18" height="18" viewBox="0 0 24 24" fill="#3b82f6"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>',
    'users'     => '<svg width="18" height="18" viewBox="0 0 24 24" fill="#16a34a"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>',
    'chat'      => '<svg width="18" height="18" viewBox="0 0 24 24" fill="#7c3aed"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z"/><circle cx="9" cy="11" r="1.5"/><circle cx="12" cy="11" r="1.5"/><circle cx="15" cy="11" r="1.5"/></svg>',
    'coins'     => '<svg width="15" height="15" viewBox="0 0 24 24" fill="#16a34a"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-1.7c-1.18-.35-2-.97-2-2.3h2c0 .56.52.88 1.18.88.61 0 1.12-.3 1.12-.88 0-.45-.3-.8-1.35-1.12C10.55 11.47 9 10.97 9 9c0-1.17.88-2.07 2-2.3V5h2v1.7c1.18.35 2 .97 2 2.3h-2c0-.56-.52-.88-1.18-.88-.61 0-1.12.3-1.12.88 0 .45.3.8 1.35 1.12C14.45 10.53 16 11.03 16 13c0 1.17-.88 2.07-2 2.3V17z"/></svg>',
    'history'   => '<svg width="16" height="16" viewBox="0 0 24 24" fill="#3b82f6"><path d="M13 3a9 9 0 0 0-9 9H1l3.89 3.89.07.14L9 12H6a7 7 0 1 1 2.05 4.95l-1.42 1.42A9 9 0 1 0 13 3z"/><path d="M12 8v5l4.28 2.54.72-1.21-3.5-2.08V8z"/></svg>',
    'shield'    => '<svg width="16" height="16" viewBox="0 0 24 24" fill="#16a34a"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>',
    'trash'     => '<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>',
    'warning'   => '<svg width="16" height="16" viewBox="0 0 24 24" fill="#f59e0b"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>',
    'briefcase' => '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M14 6V4h-4v2H2v14h20V6h-8zM10 4h4v2h-4V4zM20 18H4V8h16v10z"/></svg>',
];
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item">{!! $svg['briefcase'] !!} Outils</li>
    <li class="breadcrumb-item active">{!! $svg['sms'] !!} SMS Pro</li>
@endsection

@push('styles')
<style>
    .sms-pro-wrapper {
        width: 100%;
        overflow-x: hidden;
    }
    .sms-layout-row {
        display: flex;
        flex-wrap: wrap;
        width: 100%;
    }
    @media (min-width: 1200px) {
        .sms-layout-row {
            flex-wrap: nowrap;
        }
    }
    .sms-form-column {
        background-color: #fff;
    }
    .sms-history-column {
        background-color: #f8f9fa;
        border-left: 1px solid #dee2e6;
    }
    .sms-history-column__header {
        background-color: #ff9800;
        color: #000;
        padding: 12px 20px;
    }
    .history-scroll {
        max-height: calc(100vh - 150px);
        overflow-y: auto;
        min-height: 400px;
    }
    .sms-action-buttons {
        margin-bottom: 1.5rem;
    }
    .sms-action-buttons__item {
        margin-bottom: 1rem;
    }
    .sms-action-buttons .btn {
        width: 100%;
        border-radius: 14px;
        font-weight: 600;
        padding: 0.9rem 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 0.5rem;
        box-shadow: 0 10px 20px rgba(15, 23, 42, 0.12);
        transition: transform 0.15s ease, box-shadow 0.15s ease;
        white-space: normal;
        text-align: center;
    }
    .sms-action-buttons .btn span {
        flex: 1 1 100%;
    }
    .sms-action-buttons .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 24px rgba(15, 23, 42, 0.18);
    }
    .sms-info-btn {
        background-image: linear-gradient(135deg, #14b8c2, #0d8ea0);
        background-color: #0d8ea0;
        border: 1px solid #0d8ea0;
        color: #fff !important;
    }
    .sms-send-btn {
        background-image: linear-gradient(135deg, #2ac36c, #1d914d);
        background-color: #1d914d;
        border: 1px solid #1d914d;
        color: #fff !important;
    }
    .sms-info-btn:focus,
    .sms-info-btn:active,
    .sms-send-btn:focus,
    .sms-send-btn:active {
        color: #fff !important;
        box-shadow: 0 0 0 0.2rem rgba(20, 184, 194, 0.25);
    }
    @media (max-width: 991px) {
        .sms-layout-row {
            flex-wrap: wrap;
        }
        .sms-form-column,
        .sms-history-column {
            flex: 1 0 100%;
            max-width: 100%;
        }
        .sms-history-column {
            border-left: 0;
            border-top: 1px solid #dee2e6;
        }
        .history-scroll {
            max-height: none;
            min-height: auto;
        }
    }
    @media (max-width: 575px) {
        .sms-form-column,
        .sms-history-column {
            padding: 0.5rem !important;
        }
        .sms-history-column__header {
            padding: 10px 16px;
        }
        .history-scroll {
            padding: 0.75rem !important;
        }
        .sms-action-buttons__item {
            margin-bottom: 0.9rem;
        }
        .sms-form-header-credits {
            display: none !important;
        }
        .sms-form-header-icon {
            width: 38px !important;
            height: 38px !important;
        }
        .sms-field-icon {
            display: none !important;
        }
    }
</style>
@endpush

@section('content')
<x-tool-back-link label="Retour à la liste des outils" :fallback="route('dashboard')" />

<div class="container-fluid px-0 sms-pro-wrapper" style="max-width: 100%;">

    <!-- Hero card SMS Pro -->
    <div class="mx-3 mx-sm-4 mt-2 mb-2 rounded-4 overflow-hidden position-relative" style="background:linear-gradient(135deg,#e8f0fe 0%,#f0f4ff 100%);border:1px solid #dbe4ff;">
        <div class="d-flex align-items-center gap-3 p-3">
            <div class="flex-shrink-0 rounded-3 d-flex align-items-center justify-content-center" style="width:60px;height:60px;background:#1d4ed8;">
                {!! $svg['sms'] !!}
            </div>
            <div class="flex-grow-1">
                <h4 class="fw-bold mb-1" style="color:#1e293b;">SMS Pro</h4>
                <p class="mb-0 text-secondary" style="font-size:.88rem;">Envoyez des SMS professionnels rapidement et en toute simplicité.</p>
            </div>
            <div class="flex-shrink-0 d-none d-sm-flex align-items-center">
                <span class="badge d-flex align-items-center gap-1 px-3 py-2" style="background:#dcfce7;color:#16a34a;font-size:.85rem;border-radius:999px;">
                    {!! $svg['check'] !!} Actif
                </span>
            </div>
        </div>
    </div>

    <!-- Bouton info -->
    <div class="mx-3 mx-sm-4 mb-2">
        <button class="btn w-100 d-flex align-items-center gap-3 px-3 py-3 rounded-3" type="button"
            data-bs-toggle="modal" data-bs-target="#utiliteModal"
            style="background:#fff;color:#1e293b;border:1.5px solid #e2e8f0;text-align:left;">
            <div class="flex-shrink-0 rounded-circle d-flex align-items-center justify-content-center" style="width:38px;height:38px;background:#e0f2fe;">
                {!! $svg['info'] !!}
            </div>
            <div class="flex-grow-1">
                <div class="fw-bold" style="font-size:.92rem;">Utilité, Fonctionnement</div>
                <div class="text-secondary" style="font-size:.78rem;">En savoir plus</div>
            </div>
            <span class="ms-auto text-secondary">{!! $svg['chevron'] !!}</span>
        </button>
    </div>

    <div class="row g-0 m-0 sms-layout-row">
        <!-- Colonne gauche: Formulaire d'envoi -->
        <div class="col-12 col-xl-8 p-2 sms-form-column">

            <!-- En-tête formulaire avec crédits -->
            <div class="rounded-3 p-3 mb-2 d-flex align-items-center gap-3" style="background:#fff;border:1px solid #e2e8f0;box-shadow:0 1px 3px rgba(0,0,0,.05);">
                <div class="flex-shrink-0 rounded-3 d-flex align-items-center justify-content-center sms-form-header-icon" style="width:48px;height:48px;background:#1d4ed8;">
                    {!! $svg['plane'] !!}
                </div>
                <div class="flex-grow-1">
                    <div class="fw-bold" style="color:#1e293b;font-size:.95rem;">Envoyer un SMS Pro</div>
                    <div class="text-secondary" style="font-size:.8rem;">Remplissez les informations ci-dessous pour envoyer votre SMS.</div>
                </div>
                <div class="flex-shrink-0 text-end rounded-3 px-3 py-2 sms-form-header-credits" style="background:#f0fdf4;border:1px solid #bbf7d0;">
                    <div class="text-secondary" style="font-size:.72rem;">Crédit disponible</div>
                    <div class="fw-bold d-flex align-items-center gap-1 justify-content-end" style="color:#16a34a;font-size:1.15rem;">
                        <span id="credits-display">{{ $creditsDisponibles }}</span>
                        {!! $svg['coins'] !!}
                    </div>
                </div>
            </div>

            <form id="sms-form">
                @csrf

                <!-- Expéditeur -->
                <div class="rounded-3 p-3 mb-2 d-flex align-items-start gap-3" style="background:#fff;border:1px solid #e2e8f0;">
                    <div class="flex-shrink-0 rounded-circle d-flex align-items-center justify-content-center sms-field-icon" style="width:40px;height:40px;background:#eff6ff;">
                        {!! $svg['user'] !!}
                    </div>
                    <div class="flex-grow-1">
                        <label class="fw-semibold mb-1 d-block" style="color:#1e293b;">Expéditeur (De) <span class="text-danger">*</span></label>
                        <div class="text-secondary mb-2" style="font-size:.82rem;">Le nom de l'expéditeur apparaîtra sur le téléphone du destinataire.</div>
                        <input type="text" class="form-control" name="expediteur" placeholder="Nom de l'expéditeur" maxlength="11" required>
                        <div class="d-flex align-items-start gap-3 mt-2 p-3 rounded-3" style="background:#fffbeb;border:1.5px solid #fcd34d;">
                            <span style="flex-shrink:0;margin-top:2px;">{!! $svg['warning'] !!}</span>
                            <div style="color:#92400e;font-size:.93rem;line-height:1.6;">
                                <strong style="color:#b45309;">Noms interdits :</strong> Évitez les mots comme <strong style="color:#b45309;">Bank, Banking, Money, Pay, Finance, Cash, Credit, Loan, Wallet, Western, Transfer, MTN MoMo, BNP Paribas</strong> ou tout autre nom de société existante pour éviter les rejets des SMS — ces noms sont automatiquement rejetés par les opérateurs mobiles et <strong style="color:#b45309;">vos crédits ne seront pas remboursés</strong>.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Destinataire -->
                <div class="rounded-3 p-3 mb-2 d-flex align-items-start gap-3" style="background:#fff;border:1px solid #e2e8f0;">
                    <div class="flex-shrink-0 rounded-circle d-flex align-items-center justify-content-center sms-field-icon" style="width:40px;height:40px;background:#f0fdf4;">
                        {!! $svg['users'] !!}
                    </div>
                    <div class="flex-grow-1">
                        <label class="fw-semibold mb-2 d-block" style="color:#1e293b;">Destinataire (A) <span class="text-danger">*</span></label>
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <select class="form-select" name="pays" required>
                                        <option value="">Indicatif Pays</option>
                                        <option value="+93">🇦🇫 Afghanistan (+93)</option>
                                        <option value="+355">🇦🇱 Albanie (+355)</option>
                                        <option value="+213">🇩🇿 Algérie (+213)</option>
                                        <option value="+376">🇦🇩 Andorre (+376)</option>
                                        <option value="+244">🇦🇴 Angola (+244)</option>
                                        <option value="+54">🇦🇷 Argentine (+54)</option>
                                        <option value="+374">🇦🇲 Arménie (+374)</option>
                                        <option value="+61">🇦🇺 Australie (+61)</option>
                                        <option value="+43">🇦🇹 Autriche (+43)</option>
                                        <option value="+994">🇦🇿 Azerbaïdjan (+994)</option>
                                        <option value="+973">🇧🇭 Bahreïn (+973)</option>
                                        <option value="+880">🇧🇩 Bangladesh (+880)</option>
                                        <option value="+32">🇧🇪 Belgique (+32)</option>
                                        <option value="+229">🇧🇯 Bénin (+229)</option>
                                        <option value="+975">🇧🇹 Bhoutan (+975)</option>
                                        <option value="+591">🇧🇴 Bolivie (+591)</option>
                                        <option value="+387">🇧🇦 Bosnie-Herzégovine (+387)</option>
                                        <option value="+267">🇧🇼 Botswana (+267)</option>
                                        <option value="+55">🇧🇷 Brésil (+55)</option>
                                        <option value="+673">🇧🇳 Brunei (+673)</option>
                                        <option value="+359">🇧🇬 Bulgarie (+359)</option>
                                        <option value="+226">🇧🇫 Burkina Faso (+226)</option>
                                        <option value="+257">🇧🇮 Burundi (+257)</option>
                                        <option value="+855">🇰🇭 Cambodge (+855)</option>
                                        <option value="+237">🇨🇲 Cameroun (+237)</option>
                                        <option value="+1">🇨🇦 Canada (+1)</option>
                                        <option value="+238">🇨🇻 Cap-Vert (+238)</option>
                                        <option value="+236">🇨🇫 Centrafrique (+236)</option>
                                        <option value="+56">🇨🇱 Chili (+56)</option>
                                        <option value="+86">🇨🇳 Chine (+86)</option>
                                        <option value="+357">🇨🇾 Chypre (+357)</option>
                                        <option value="+57">🇨🇴 Colombie (+57)</option>
                                        <option value="+269">🇰🇲 Comores (+269)</option>
                                        <option value="+242">🇨🇬 Congo-Brazzaville (+242)</option>
                                        <option value="+243">🇨🇩 Congo-Kinshasa (+243)</option>
                                        <option value="+850">🇰🇵 Corée du Nord (+850)</option>
                                        <option value="+82">🇰🇷 Corée du Sud (+82)</option>
                                        <option value="+506">🇨🇷 Costa Rica (+506)</option>
                                        <option value="+225">🇨🇮 Côte d'Ivoire (+225)</option>
                                        <option value="+385">🇭🇷 Croatie (+385)</option>
                                        <option value="+53">🇨🇺 Cuba (+53)</option>
                                        <option value="+45">🇩🇰 Danemark (+45)</option>
                                        <option value="+253">🇩🇯 Djibouti (+253)</option>
                                        <option value="+20">🇪🇬 Égypte (+20)</option>
                                        <option value="+971">🇦🇪 Émirats arabes unis (+971)</option>
                                        <option value="+593">🇪🇨 Équateur (+593)</option>
                                        <option value="+291">🇪🇷 Érythrée (+291)</option>
                                        <option value="+34">🇪🇸 Espagne (+34)</option>
                                        <option value="+372">🇪🇪 Estonie (+372)</option>
                                        <option value="+268">🇸🇿 Eswatini (+268)</option>
                                        <option value="+1">🇺🇸 États-Unis (+1)</option>
                                        <option value="+251">🇪🇹 Éthiopie (+251)</option>
                                        <option value="+679">🇫🇯 Fidji (+679)</option>
                                        <option value="+358">🇫🇮 Finlande (+358)</option>
                                        <option value="+33">🇫🇷 France (+33)</option>
                                        <option value="+241">🇬🇦 Gabon (+241)</option>
                                        <option value="+220">🇬🇲 Gambie (+220)</option>
                                        <option value="+995">🇬🇪 Géorgie (+995)</option>
                                        <option value="+233">🇬🇭 Ghana (+233)</option>
                                        <option value="+30">🇬🇷 Grèce (+30)</option>
                                        <option value="+502">🇬🇹 Guatemala (+502)</option>
                                        <option value="+224">🇬🇳 Guinée (+224)</option>
                                        <option value="+245">🇬🇼 Guinée-Bissau (+245)</option>
                                        <option value="+240">🇬🇶 Guinée équatoriale (+240)</option>
                                        <option value="+592">🇬🇾 Guyana (+592)</option>
                                        <option value="+509">🇭🇹 Haïti (+509)</option>
                                        <option value="+504">🇭🇳 Honduras (+504)</option>
                                        <option value="+852">🇭🇰 Hong Kong (+852)</option>
                                        <option value="+36">🇭🇺 Hongrie (+36)</option>
                                        <option value="+91">🇮🇳 Inde (+91)</option>
                                        <option value="+62">🇮🇩 Indonésie (+62)</option>
                                        <option value="+98">🇮🇷 Iran (+98)</option>
                                        <option value="+964">🇮🇶 Irak (+964)</option>
                                        <option value="+353">🇮🇪 Irlande (+353)</option>
                                        <option value="+354">🇮🇸 Islande (+354)</option>
                                        <option value="+972">🇮🇱 Israël (+972)</option>
                                        <option value="+39">🇮🇹 Italie (+39)</option>
                                        <option value="+81">🇯🇵 Japon (+81)</option>
                                        <option value="+962">🇯🇴 Jordanie (+962)</option>
                                        <option value="+7">🇰🇿 Kazakhstan (+7)</option>
                                        <option value="+254">🇰🇪 Kenya (+254)</option>
                                        <option value="+996">🇰🇬 Kirghizistan (+996)</option>
                                        <option value="+965">🇰🇼 Koweït (+965)</option>
                                        <option value="+856">🇱🇦 Laos (+856)</option>
                                        <option value="+266">🇱🇸 Lesotho (+266)</option>
                                        <option value="+371">🇱🇻 Lettonie (+371)</option>
                                        <option value="+961">🇱🇧 Liban (+961)</option>
                                        <option value="+231">🇱🇷 Liberia (+231)</option>
                                        <option value="+218">🇱🇾 Libye (+218)</option>
                                        <option value="+423">🇱🇮 Liechtenstein (+423)</option>
                                        <option value="+370">🇱🇹 Lituanie (+370)</option>
                                        <option value="+352">🇱🇺 Luxembourg (+352)</option>
                                        <option value="+853">🇲🇴 Macao (+853)</option>
                                        <option value="+389">🇲🇰 Macédoine du Nord (+389)</option>
                                        <option value="+261">🇲🇬 Madagascar (+261)</option>
                                        <option value="+60">🇲🇾 Malaisie (+60)</option>
                                        <option value="+265">🇲🇼 Malawi (+265)</option>
                                        <option value="+960">🇲🇻 Maldives (+960)</option>
                                        <option value="+223">🇲🇱 Mali (+223)</option>
                                        <option value="+356">🇲🇹 Malte (+356)</option>
                                        <option value="+212">🇲🇦 Maroc (+212)</option>
                                        <option value="+230">🇲🇺 Maurice (+230)</option>
                                        <option value="+222">🇲🇷 Mauritanie (+222)</option>
                                        <option value="+52">🇲🇽 Mexique (+52)</option>
                                        <option value="+373">🇲🇩 Moldavie (+373)</option>
                                        <option value="+377">🇲🇨 Monaco (+377)</option>
                                        <option value="+976">🇲🇳 Mongolie (+976)</option>
                                        <option value="+382">🇲🇪 Monténégro (+382)</option>
                                        <option value="+258">🇲🇿 Mozambique (+258)</option>
                                        <option value="+95">🇲🇲 Myanmar (+95)</option>
                                        <option value="+264">🇳🇦 Namibie (+264)</option>
                                        <option value="+977">🇳🇵 Népal (+977)</option>
                                        <option value="+505">🇳🇮 Nicaragua (+505)</option>
                                        <option value="+227">🇳🇪 Niger (+227)</option>
                                        <option value="+234">🇳🇬 Nigeria (+234)</option>
                                        <option value="+47">🇳🇴 Norvège (+47)</option>
                                        <option value="+64">🇳🇿 Nouvelle-Zélande (+64)</option>
                                        <option value="+968">🇴🇲 Oman (+968)</option>
                                        <option value="+256">🇺🇬 Ouganda (+256)</option>
                                        <option value="+998">🇺🇿 Ouzbékistan (+998)</option>
                                        <option value="+92">🇵🇰 Pakistan (+92)</option>
                                        <option value="+507">🇵🇦 Panama (+507)</option>
                                        <option value="+595">🇵🇾 Paraguay (+595)</option>
                                        <option value="+31">🇳🇱 Pays-Bas (+31)</option>
                                        <option value="+51">🇵🇪 Pérou (+51)</option>
                                        <option value="+63">🇵🇭 Philippines (+63)</option>
                                        <option value="+48">🇵🇱 Pologne (+48)</option>
                                        <option value="+351">🇵🇹 Portugal (+351)</option>
                                        <option value="+974">🇶🇦 Qatar (+974)</option>
                                        <option value="+40">🇷🇴 Roumanie (+40)</option>
                                        <option value="+44">🇬🇧 Royaume-Uni (+44)</option>
                                        <option value="+7">🇷🇺 Russie (+7)</option>
                                        <option value="+250">🇷🇼 Rwanda (+250)</option>
                                        <option value="+966">🇸🇦 Arabie saoudite (+966)</option>
                                        <option value="+221">🇸🇳 Sénégal (+221)</option>
                                        <option value="+381">🇷🇸 Serbie (+381)</option>
                                        <option value="+248">🇸🇨 Seychelles (+248)</option>
                                        <option value="+232">🇸🇱 Sierra Leone (+232)</option>
                                        <option value="+65">🇸🇬 Singapour (+65)</option>
                                        <option value="+421">🇸🇰 Slovaquie (+421)</option>
                                        <option value="+386">🇸🇮 Slovénie (+386)</option>
                                        <option value="+252">🇸🇴 Somalie (+252)</option>
                                        <option value="+249">🇸🇩 Soudan (+249)</option>
                                        <option value="+211">🇸🇸 Soudan du Sud (+211)</option>
                                        <option value="+94">🇱🇰 Sri Lanka (+94)</option>
                                        <option value="+46">🇸🇪 Suède (+46)</option>
                                        <option value="+41">🇨🇭 Suisse (+41)</option>
                                        <option value="+597">🇸🇷 Suriname (+597)</option>
                                        <option value="+963">🇸🇾 Syrie (+963)</option>
                                        <option value="+992">🇹🇯 Tadjikistan (+992)</option>
                                        <option value="+886">🇹🇼 Taïwan (+886)</option>
                                        <option value="+255">🇹🇿 Tanzanie (+255)</option>
                                        <option value="+235">🇹🇩 Tchad (+235)</option>
                                        <option value="+420">🇨🇿 Tchéquie (+420)</option>
                                        <option value="+66">🇹🇭 Thaïlande (+66)</option>
                                        <option value="+670">🇹🇱 Timor oriental (+670)</option>
                                        <option value="+228">🇹🇬 Togo (+228)</option>
                                        <option value="+216">🇹🇳 Tunisie (+216)</option>
                                        <option value="+993">🇹🇲 Turkménistan (+993)</option>
                                        <option value="+90">🇹🇷 Turquie (+90)</option>
                                        <option value="+380">🇺🇦 Ukraine (+380)</option>
                                        <option value="+598">🇺🇾 Uruguay (+598)</option>
                                        <option value="+58">🇻🇪 Venezuela (+58)</option>
                                        <option value="+84">🇻🇳 Vietnam (+84)</option>
                                        <option value="+967">🇾🇪 Yémen (+967)</option>
                                        <option value="+260">🇿🇲 Zambie (+260)</option>
                                        <option value="+263">🇿🇼 Zimbabwe (+263)</option>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <input type="tel" class="form-control" name="numero" id="numero" placeholder="Numéro sans indicatif pays (ex: 612345678)" required>
                                    <small class="text-muted" id="numero-hint" style="display:none;">L'indicatif <strong id="hint-code"></strong> sera ajouté automatiquement. Saisissez uniquement le numéro local.</small>
                                </div>
                            </div>
                            <div class="text-secondary mt-2" style="font-size:.82rem;">Entrez le numéro de téléphone du destinataire sans l'indicatif du pays.</div>
                        </div>
                </div>

                <!-- Message -->
                <div class="rounded-3 p-3 mb-2 d-flex align-items-start gap-3" style="background:#fff;border:1px solid #e2e8f0;">
                    <div class="flex-shrink-0 rounded-circle d-flex align-items-center justify-content-center sms-field-icon" style="width:40px;height:40px;background:#faf5ff;">
                        {!! $svg['chat'] !!}
                    </div>
                    <div class="flex-grow-1">
                        <label class="fw-semibold mb-2 d-block" style="color:#1e293b;">Message (Contenu) <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="message" id="message" rows="6" placeholder="Votre message ici..." required></textarea>
                        <div class="mt-2 d-flex gap-2 flex-wrap">
                            <span class="badge bg-light text-dark border"><span id="char-count">0</span> caractère(s)</span>
                            <span class="badge bg-light text-dark border">Coût d'envoi : <span id="cost">0</span> Crédits</span>
                        </div>
                    </div>
                </div>

                <!-- Bouton envoi -->
                <button type="submit" class="btn w-100 fw-bold text-white py-3 rounded-3 d-flex align-items-center justify-content-center gap-2 mb-3" style="background:#16a34a;font-size:1rem;">
                    {!! $svg['plane_lg'] !!}
                    Envoyer le SMS Pro (<span id="final-cost">0</span> Crédits) →
                </button>
            </form>
        </div>

        <!-- Colonne droite: Historique -->
        <div class="col-12 col-xl-4 p-0 sms-history-column">
            <!-- Header historique -->
            <div class="p-3 d-flex align-items-center gap-2" style="background:#fff;border-bottom:1px solid #e2e8f0;">
                {!! $svg['history'] !!}
                <h6 class="mb-0 fw-bold" style="color:#1e293b;">Historique des envois (<span id="history-count">{{ count($history) }}</span>)</h6>
            </div>
            <div class="p-3 history-scroll">
                <div id="history-container">
                    @if($history->isEmpty())
                        <!-- État vide -->
                        <div class="text-center py-4">
                            <div class="mb-3" style="margin:0 auto;width:110px;">
                                <svg viewBox="0 0 110 90" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:110px;height:90px;">
                                    <!-- Boîte ouverte -->
                                    <rect x="15" y="42" width="70" height="42" rx="5" fill="#bfdbfe"/>
                                    <path d="M15 42 L50 54 L85 42" stroke="#93c5fd" stroke-width="2" fill="none"/>
                                    <!-- Rabat gauche -->
                                    <path d="M15 42 L22 28 L50 28 L50 54 Z" fill="#dbeafe" stroke="#93c5fd" stroke-width="1.5"/>
                                    <!-- Rabat droit -->
                                    <path d="M85 42 L78 28 L50 28 L50 54 Z" fill="#eff6ff" stroke="#93c5fd" stroke-width="1.5"/>
                                    <!-- Avion en papier -->
                                    <g transform="translate(68, 8) rotate(-20)">
                                        <path d="M0 8 L22 0 L14 14 Z" fill="#3b82f6"/>
                                        <path d="M0 8 L14 14 L10 20 Z" fill="#60a5fa"/>
                                        <path d="M14 14 L10 20 L22 0 Z" fill="#2563eb"/>
                                    </g>
                                    <!-- Pointillés trajectoire -->
                                    <path d="M58 22 Q65 15 72 12" stroke="#93c5fd" stroke-width="1.5" stroke-dasharray="3 3" fill="none"/>
                                </svg>
                            </div>
                            <p class="fw-semibold mb-1" style="color:#1e293b;">Aucun envoi pour le moment</p>
                            <p class="text-secondary mb-0" style="font-size:.83rem;">Vos envois de SMS apparaîtront ici.</p>
                        </div>
                    @else
                        @foreach($history as $item)
                            <div class="border-bottom pb-2 mb-2" style="cursor:pointer;" onclick="showSmsDetails({{ $item->id }})">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    @if($item->status === 'Livré')
                                        <span class="badge bg-success">Livré ✓</span>
                                    @elseif($item->status === 'Envoyé')
                                        <span class="badge bg-info">Envoyé ✉</span>
                                    @else
                                        <span class="badge bg-danger">Rejeté ⚠</span>
                                    @endif
                                    <small class="text-muted">{{ $item->created_at->setTimezone('Europe/Paris')->format('d/m/y') }} à {{ $item->created_at->setTimezone('Europe/Paris')->format('H:i') }}</small>
                                </div>
                                <div class="small">
                                    <strong>De {{ $item->expediteur }} au {{ $item->destinataire }}</strong> le {{ $item->created_at->setTimezone('Europe/Paris')->format('d/m/Y') }} à {{ $item->created_at->setTimezone('Europe/Paris')->format('H:i') }}
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="mt-3 pb-3">
                    <button class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center gap-2" id="btnSupprimerHistorique">
                        {!! $svg['trash'] !!} Supprimer l'historique des envois
                    </button>
                </div>

                <!-- Bonnes pratiques -->
                <div class="mt-3 rounded-3 p-3" style="background:#fff;border:1px solid #e2e8f0;">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        {!! $svg['shield'] !!}
                        <span class="fw-bold" style="color:#1e293b;font-size:.92rem;">Bonnes pratiques</span>
                    </div>
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex gap-2 mb-2">
                            <span class="flex-shrink-0 mt-1">{!! $svg['check_green'] !!}</span>
                            <span class="text-secondary" style="font-size:.85rem;">Utilisez des noms d'expéditeur clairs et professionnels.</span>
                        </li>
                        <li class="d-flex gap-2 mb-2">
                            <span class="flex-shrink-0 mt-1">{!! $svg['check_green'] !!}</span>
                            <span class="text-secondary" style="font-size:.85rem;">Évitez les mots interdits pour garantir la livraison.</span>
                        </li>
                        <li class="d-flex gap-2">
                            <span class="flex-shrink-0 mt-1">{!! $svg['check_green'] !!}</span>
                            <span class="text-secondary" style="font-size:.85rem;">Vérifiez vos crédits avant chaque envoi.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Utilité et Fonctionnement -->
<div class="modal fade" id="utiliteModal" tabindex="-1" aria-labelledby="utiliteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 600px; max-height: 90vh;">
        <div class="modal-content" style="max-height: 90vh;">
            <div class="modal-header">
                <h5 class="modal-title" id="utiliteModalLabel">Utilité et Fonctionnement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="overflow-y: auto; max-height: calc(90vh - 120px);">
                <h5 class="text-primary mb-3">Utilité</h5>
                <p style="text-align: justify;">
                    <strong>SMS Pro</strong> : Service de messagerie SMS Professionnel mondiale. Que vous soyez un particulier, une start-up ou une entreprise, communiquez facilement avec vos clients en envoyant des SMS Pro dans le monde entier grâce à notre plateforme ayant plus de 240 connexions directes avec les opérateurs à l'international. Optimisé pour la vitesse, la qualité et les coûts, envoyez des alertes bancaires, des confirmations de commande, des SMS cross selling, marketing, de rappel, de relance client inactif, de fidélisation ou promotionnel, etc... avec le nom d'expéditeur de votre choix. Notre routage intelligent garantit la livraison de vos messages au moment, à l'endroit et de la façon que vous avez choisis. Ne vous souciez pas du volume ni du contenu. Que vous envoyez des centaines ou des millions de messages, notre réseau de messagerie SMS est fiable et performant.
                </p>

                <h5 class="text-primary mb-3 mt-4">Fonctionnement</h5>
                <p style="text-align: justify;">
                    Pour envoyer votre SMS Pro, vous devez juste avoir du crédit <strong>Kitscms</strong>, remplir le formulaire d'envoi disponible sur cette page en respectant les formats définis pour chaque champ.
                </p>

                <div class="mb-3">
                    <p><strong>Expéditeur</strong> <em>(obligatoire)</em> : Le nom de l'expéditeur ne doit contenir que de 3 à 11 caractères alphabétiques espace inclus [a-zA-Z ]. Exemple : <strong>Mon Entreprise</strong></p>
                </div>

                <div class="mb-3">
                    <p><strong>Destinataire</strong> <em>(obligatoire)</em> : Le numéro de téléphone du destinataire doit être au format international.</p>
                </div>

                <div class="mb-3">
                    <p><strong>Message</strong> <em>(obligatoire)</em> : Le message destiné à votre destinataire. Personnaliser le contenu en toute liberté et en fonction de vos besoins.</p>
                </div>

                <div class="mb-3 p-3" style="background-color: #d1ecf1; border: 1px solid #bee5eb; border-radius: 5px;">
                    <p class="mb-2" style="color: #0c5460;">Avec le status de suivi, obtenez plus d'informations sur l'état de votre SMS Pro après l'envoi :</p>
                    <ul class="mb-0" style="color: #0c5460;">
                        <li>* Le status <strong style="color: #28a745;">livré</strong> vous informe que votre SMS Pro a bien été livré à votre destinataire avec succès et accusé de réception.</li>
                        <li>* Le status <strong style="color: #007bff;">envoyé</strong> vous informe que votre SMS Pro a bien été envoyé à votre destinataire avec succès et sans accusé de réception.</li>
                        <li>* Le status <strong style="color: #dc3545;">rejeté</strong> vous informe que votre SMS Pro a été rejeté par le fournisseur mobile du destinataire (Nom d'expéditeur suspect ou numéro mobile non répertorié). Vous ne serez pas facturé pour les messages rejetés.</li>
                    </ul>
                </div>

                <h5 class="text-primary mb-3 mt-4">Liste des couvertures supportées</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>N°</th>
                                <th>Pays</th>
                                <th>Indicatif (+)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>1</td><td>Afghanistan (AF)</td><td>+93</td></tr>
                            <tr><td>2</td><td>Afrique du Sud (ZA)</td><td>+27</td></tr>
                            <tr><td>3</td><td>Albanie (AL)</td><td>+355</td></tr>
                            <tr><td>4</td><td>Algérie (DZ)</td><td>+213</td></tr>
                            <tr><td>5</td><td>Allemagne (DE)</td><td>+49</td></tr>
                            <tr><td>6</td><td>Andorre (AD)</td><td>+376</td></tr>
                            <tr><td>7</td><td>Angola (AO)</td><td>+244</td></tr>
                            <tr><td>8</td><td>Anguilla (AI)</td><td>+1264</td></tr>
                            <tr><td>9</td><td>Antarctique (AQ)</td><td>+672</td></tr>
                            <tr><td>10</td><td>Argentine (AR)</td><td>+54</td></tr>
                            <tr><td>11</td><td>Arménie (AM)</td><td>+374</td></tr>
                            <tr><td>12</td><td>Australie (AU)</td><td>+61</td></tr>
                            <tr><td>13</td><td>Autriche (AT)</td><td>+43</td></tr>
                            <tr><td>14</td><td>Azerbaïdjan (AZ)</td><td>+994</td></tr>
                            <tr><td>15</td><td>Bahreïn (BH)</td><td>+973</td></tr>
                            <tr><td>16</td><td>Bangladesh (BD)</td><td>+880</td></tr>
                            <tr><td>17</td><td>Belgique (BE)</td><td>+32</td></tr>
                            <tr><td>18</td><td>Bénin (BJ)</td><td>+229</td></tr>
                            <tr><td>19</td><td>Bolivie (BO)</td><td>+591</td></tr>
                            <tr><td>20</td><td>Bosnie-Herzégovine (BA)</td><td>+387</td></tr>
                            <tr><td>21</td><td>Brésil (BR)</td><td>+55</td></tr>
                            <tr><td>22</td><td>Bulgarie (BG)</td><td>+359</td></tr>
                            <tr><td>23</td><td>Burkina Faso (BF)</td><td>+226</td></tr>
                            <tr><td>24</td><td>Burundi (BI)</td><td>+257</td></tr>
                            <tr><td>25</td><td>Cambodge (KH)</td><td>+855</td></tr>
                            <tr><td>26</td><td>Cameroun (CM)</td><td>+237</td></tr>
                            <tr><td>27</td><td>Canada (CA)</td><td>+1</td></tr>
                            <tr><td>28</td><td>Chili (CL)</td><td>+56</td></tr>
                            <tr><td>29</td><td>Chine (CN)</td><td>+86</td></tr>
                            <tr><td>30</td><td>Chypre (CY)</td><td>+357</td></tr>
                            <tr><td>31</td><td>Colombie (CO)</td><td>+57</td></tr>
                            <tr><td>32</td><td>Congo-Kinshasa (CD)</td><td>+243</td></tr>
                            <tr><td>33</td><td>Corée du Sud (KR)</td><td>+82</td></tr>
                            <tr><td>34</td><td>Costa Rica (CR)</td><td>+506</td></tr>
                            <tr><td>35</td><td>Côte d'Ivoire (CI)</td><td>+225</td></tr>
                            <tr><td>36</td><td>Croatie (HR)</td><td>+385</td></tr>
                            <tr><td>37</td><td>Danemark (DK)</td><td>+45</td></tr>
                            <tr><td>38</td><td>Égypte (EG)</td><td>+20</td></tr>
                            <tr><td>39</td><td>Émirats arabes unis (AE)</td><td>+971</td></tr>
                            <tr><td>40</td><td>Équateur (EC)</td><td>+593</td></tr>
                            <tr><td>41</td><td>Espagne (ES)</td><td>+34</td></tr>
                            <tr><td>42</td><td>Estonie (EE)</td><td>+372</td></tr>
                            <tr><td>43</td><td>États-Unis (US)</td><td>+1</td></tr>
                            <tr><td>44</td><td>Éthiopie (ET)</td><td>+251</td></tr>
                            <tr><td>45</td><td>Finlande (FI)</td><td>+358</td></tr>
                            <tr><td>46</td><td>France (FR)</td><td>+33</td></tr>
                            <tr><td>47</td><td>Gabon (GA)</td><td>+241</td></tr>
                            <tr><td>48</td><td>Géorgie (GE)</td><td>+995</td></tr>
                            <tr><td>49</td><td>Ghana (GH)</td><td>+233</td></tr>
                            <tr><td>50</td><td>Grèce (GR)</td><td>+30</td></tr>
                            <tr><td>51</td><td>Guatemala (GT)</td><td>+502</td></tr>
                            <tr><td>52</td><td>Guinée (GN)</td><td>+224</td></tr>
                            <tr><td>53</td><td>Hongrie (HU)</td><td>+36</td></tr>
                            <tr><td>54</td><td>Inde (IN)</td><td>+91</td></tr>
                            <tr><td>55</td><td>Indonésie (ID)</td><td>+62</td></tr>
                            <tr><td>56</td><td>Irak (IQ)</td><td>+964</td></tr>
                            <tr><td>57</td><td>Irlande (IE)</td><td>+353</td></tr>
                            <tr><td>58</td><td>Islande (IS)</td><td>+354</td></tr>
                            <tr><td>59</td><td>Israël (IL)</td><td>+972</td></tr>
                            <tr><td>60</td><td>Italie (IT)</td><td>+39</td></tr>
                            <tr><td>61</td><td>Japon (JP)</td><td>+81</td></tr>
                            <tr><td>62</td><td>Jordanie (JO)</td><td>+962</td></tr>
                            <tr><td>63</td><td>Kenya (KE)</td><td>+254</td></tr>
                            <tr><td>64</td><td>Koweït (KW)</td><td>+965</td></tr>
                            <tr><td>65</td><td>Lettonie (LV)</td><td>+371</td></tr>
                            <tr><td>66</td><td>Liban (LB)</td><td>+961</td></tr>
                            <tr><td>67</td><td>Libye (LY)</td><td>+218</td></tr>
                            <tr><td>68</td><td>Lituanie (LT)</td><td>+370</td></tr>
                            <tr><td>69</td><td>Luxembourg (LU)</td><td>+352</td></tr>
                            <tr><td>70</td><td>Madagascar (MG)</td><td>+261</td></tr>
                            <tr><td>71</td><td>Malaisie (MY)</td><td>+60</td></tr>
                            <tr><td>72</td><td>Mali (ML)</td><td>+223</td></tr>
                            <tr><td>73</td><td>Malte (MT)</td><td>+356</td></tr>
                            <tr><td>74</td><td>Maroc (MA)</td><td>+212</td></tr>
                            <tr><td>75</td><td>Maurice (MU)</td><td>+230</td></tr>
                            <tr><td>76</td><td>Mauritanie (MR)</td><td>+222</td></tr>
                            <tr><td>77</td><td>Mexique (MX)</td><td>+52</td></tr>
                            <tr><td>78</td><td>Moldavie (MD)</td><td>+373</td></tr>
                            <tr><td>79</td><td>Mongolie (MN)</td><td>+976</td></tr>
                            <tr><td>80</td><td>Mozambique (MZ)</td><td>+258</td></tr>
                            <tr><td>81</td><td>Népal (NP)</td><td>+977</td></tr>
                            <tr><td>82</td><td>Nicaragua (NI)</td><td>+505</td></tr>
                            <tr><td>83</td><td>Niger (NE)</td><td>+227</td></tr>
                            <tr><td>84</td><td>Nigeria (NG)</td><td>+234</td></tr>
                            <tr><td>85</td><td>Norvège (NO)</td><td>+47</td></tr>
                            <tr><td>86</td><td>Nouvelle-Zélande (NZ)</td><td>+64</td></tr>
                            <tr><td>87</td><td>Oman (OM)</td><td>+968</td></tr>
                            <tr><td>88</td><td>Ouganda (UG)</td><td>+256</td></tr>
                            <tr><td>89</td><td>Pakistan (PK)</td><td>+92</td></tr>
                            <tr><td>90</td><td>Panama (PA)</td><td>+507</td></tr>
                            <tr><td>91</td><td>Paraguay (PY)</td><td>+595</td></tr>
                            <tr><td>92</td><td>Pays-Bas (NL)</td><td>+31</td></tr>
                            <tr><td>93</td><td>Pérou (PE)</td><td>+51</td></tr>
                            <tr><td>94</td><td>Philippines (PH)</td><td>+63</td></tr>
                            <tr><td>95</td><td>Pologne (PL)</td><td>+48</td></tr>
                            <tr><td>96</td><td>Portugal (PT)</td><td>+351</td></tr>
                            <tr><td>97</td><td>Qatar (QA)</td><td>+974</td></tr>
                            <tr><td>98</td><td>Roumanie (RO)</td><td>+40</td></tr>
                            <tr><td>99</td><td>Royaume-Uni (GB)</td><td>+44</td></tr>
                            <tr><td>100</td><td>Russie (RU)</td><td>+7</td></tr>
                            <tr><td>101</td><td>Rwanda (RW)</td><td>+250</td></tr>
                            <tr><td>102</td><td>Arabie saoudite (SA)</td><td>+966</td></tr>
                            <tr><td>103</td><td>Sénégal (SN)</td><td>+221</td></tr>
                            <tr><td>104</td><td>Serbie (RS)</td><td>+381</td></tr>
                            <tr><td>105</td><td>Singapour (SG)</td><td>+65</td></tr>
                            <tr><td>106</td><td>Slovaquie (SK)</td><td>+421</td></tr>
                            <tr><td>107</td><td>Slovénie (SI)</td><td>+386</td></tr>
                            <tr><td>108</td><td>Soudan (SD)</td><td>+249</td></tr>
                            <tr><td>109</td><td>Sri Lanka (LK)</td><td>+94</td></tr>
                            <tr><td>110</td><td>Suède (SE)</td><td>+46</td></tr>
                            <tr><td>111</td><td>Suisse (CH)</td><td>+41</td></tr>
                            <tr><td>112</td><td>Taïwan (TW)</td><td>+886</td></tr>
                            <tr><td>113</td><td>Tanzanie (TZ)</td><td>+255</td></tr>
                            <tr><td>114</td><td>Tchad (TD)</td><td>+235</td></tr>
                            <tr><td>115</td><td>Tchéquie (CZ)</td><td>+420</td></tr>
                            <tr><td>116</td><td>Thaïlande (TH)</td><td>+66</td></tr>
                            <tr><td>117</td><td>Togo (TG)</td><td>+228</td></tr>
                            <tr><td>118</td><td>Tunisie (TN)</td><td>+216</td></tr>
                            <tr><td>119</td><td>Turquie (TR)</td><td>+90</td></tr>
                            <tr><td>120</td><td>Ukraine (UA)</td><td>+380</td></tr>
                            <tr><td>121</td><td>Uruguay (UY)</td><td>+598</td></tr>
                            <tr><td>122</td><td>Venezuela (VE)</td><td>+58</td></tr>
                            <tr><td>123</td><td>Vietnam (VN)</td><td>+84</td></tr>
                            <tr><td>124</td><td>Yémen (YE)</td><td>+967</td></tr>
                            <tr><td>125</td><td>Zambie (ZM)</td><td>+260</td></tr>
                            <tr><td>126</td><td>Zimbabwe (ZW)</td><td>+263</td></tr>
                            <tr><td>127</td><td>Antigua-et-Barbuda (AG)</td><td>+1268</td></tr>
                            <tr><td>128</td><td>Aruba (AW)</td><td>+297</td></tr>
                            <tr><td>129</td><td>Bahamas (BS)</td><td>+1242</td></tr>
                            <tr><td>130</td><td>Barbade (BB)</td><td>+1246</td></tr>
                            <tr><td>131</td><td>Belize (BZ)</td><td>+501</td></tr>
                            <tr><td>132</td><td>Bermudes (BM)</td><td>+1441</td></tr>
                            <tr><td>133</td><td>Bhoutan (BT)</td><td>+975</td></tr>
                            <tr><td>134</td><td>Botswana (BW)</td><td>+267</td></tr>
                            <tr><td>135</td><td>Brunei (BN)</td><td>+673</td></tr>
                            <tr><td>136</td><td>Cap-Vert (CV)</td><td>+238</td></tr>
                            <tr><td>137</td><td>Îles Caïmans (KY)</td><td>+1345</td></tr>
                            <tr><td>138</td><td>Centrafrique (CF)</td><td>+236</td></tr>
                            <tr><td>139</td><td>Comores (KM)</td><td>+269</td></tr>
                            <tr><td>140</td><td>Congo-Brazzaville (CG)</td><td>+242</td></tr>
                            <tr><td>141</td><td>Îles Cook (CK)</td><td>+682</td></tr>
                            <tr><td>142</td><td>Cuba (CU)</td><td>+53</td></tr>
                            <tr><td>143</td><td>Curaçao (CW)</td><td>+599</td></tr>
                            <tr><td>144</td><td>Djibouti (DJ)</td><td>+253</td></tr>
                            <tr><td>145</td><td>Dominique (DM)</td><td>+1767</td></tr>
                            <tr><td>146</td><td>République dominicaine (DO)</td><td>+1809</td></tr>
                            <tr><td>147</td><td>El Salvador (SV)</td><td>+503</td></tr>
                            <tr><td>148</td><td>Érythrée (ER)</td><td>+291</td></tr>
                            <tr><td>149</td><td>Eswatini (SZ)</td><td>+268</td></tr>
                            <tr><td>150</td><td>Îles Féroé (FO)</td><td>+298</td></tr>
                            <tr><td>151</td><td>Fidji (FJ)</td><td>+679</td></tr>
                            <tr><td>152</td><td>Polynésie française (PF)</td><td>+689</td></tr>
                            <tr><td>153</td><td>Gambie (GM)</td><td>+220</td></tr>
                            <tr><td>154</td><td>Gibraltar (GI)</td><td>+350</td></tr>
                            <tr><td>155</td><td>Groenland (GL)</td><td>+299</td></tr>
                            <tr><td>156</td><td>Grenade (GD)</td><td>+1473</td></tr>
                            <tr><td>157</td><td>Guadeloupe (GP)</td><td>+590</td></tr>
                            <tr><td>158</td><td>Guam (GU)</td><td>+1671</td></tr>
                            <tr><td>159</td><td>Guinée-Bissau (GW)</td><td>+245</td></tr>
                            <tr><td>160</td><td>Guinée équatoriale (GQ)</td><td>+240</td></tr>
                            <tr><td>161</td><td>Guyana (GY)</td><td>+592</td></tr>
                            <tr><td>162</td><td>Guyane française (GF)</td><td>+594</td></tr>
                            <tr><td>163</td><td>Haïti (HT)</td><td>+509</td></tr>
                            <tr><td>164</td><td>Honduras (HN)</td><td>+504</td></tr>
                            <tr><td>165</td><td>Hong Kong (HK)</td><td>+852</td></tr>
                            <tr><td>166</td><td>Île de Man (IM)</td><td>+44</td></tr>
                            <tr><td>167</td><td>Îles Vierges britanniques (VG)</td><td>+1284</td></tr>
                            <tr><td>168</td><td>Îles Vierges américaines (VI)</td><td>+1340</td></tr>
                            <tr><td>169</td><td>Iran (IR)</td><td>+98</td></tr>
                            <tr><td>170</td><td>Jamaïque (JM)</td><td>+1876</td></tr>
                            <tr><td>171</td><td>Jersey (JE)</td><td>+44</td></tr>
                            <tr><td>172</td><td>Kazakhstan (KZ)</td><td>+7</td></tr>
                            <tr><td>173</td><td>Kirghizistan (KG)</td><td>+996</td></tr>
                            <tr><td>174</td><td>Kiribati (KI)</td><td>+686</td></tr>
                            <tr><td>175</td><td>Kosovo (XK)</td><td>+383</td></tr>
                            <tr><td>176</td><td>Laos (LA)</td><td>+856</td></tr>
                            <tr><td>177</td><td>Lesotho (LS)</td><td>+266</td></tr>
                            <tr><td>178</td><td>Liberia (LR)</td><td>+231</td></tr>
                            <tr><td>179</td><td>Liechtenstein (LI)</td><td>+423</td></tr>
                            <tr><td>180</td><td>Macao (MO)</td><td>+853</td></tr>
                            <tr><td>181</td><td>Macédoine du Nord (MK)</td><td>+389</td></tr>
                            <tr><td>182</td><td>Malawi (MW)</td><td>+265</td></tr>
                            <tr><td>183</td><td>Maldives (MV)</td><td>+960</td></tr>
                            <tr><td>184</td><td>Îles Malouines (FK)</td><td>+500</td></tr>
                            <tr><td>185</td><td>Martinique (MQ)</td><td>+596</td></tr>
                            <tr><td>186</td><td>Mayotte (YT)</td><td>+262</td></tr>
                            <tr><td>187</td><td>Monaco (MC)</td><td>+377</td></tr>
                            <tr><td>188</td><td>Monténégro (ME)</td><td>+382</td></tr>
                            <tr><td>189</td><td>Montserrat (MS)</td><td>+1664</td></tr>
                            <tr><td>190</td><td>Myanmar (MM)</td><td>+95</td></tr>
                            <tr><td>191</td><td>Namibie (NA)</td><td>+264</td></tr>
                            <tr><td>192</td><td>Nauru (NR)</td><td>+674</td></tr>
                            <tr><td>193</td><td>Nouvelle-Calédonie (NC)</td><td>+687</td></tr>
                            <tr><td>194</td><td>Niue (NU)</td><td>+683</td></tr>
                            <tr><td>195</td><td>Île Norfolk (NF)</td><td>+672</td></tr>
                            <tr><td>196</td><td>Corée du Nord (KP)</td><td>+850</td></tr>
                            <tr><td>197</td><td>Îles Mariannes du Nord (MP)</td><td>+1670</td></tr>
                            <tr><td>198</td><td>Ouzbékistan (UZ)</td><td>+998</td></tr>
                            <tr><td>199</td><td>Palaos (PW)</td><td>+680</td></tr>
                            <tr><td>200</td><td>Palestine (PS)</td><td>+970</td></tr>
                            <tr><td>201</td><td>Papouasie-Nouvelle-Guinée (PG)</td><td>+675</td></tr>
                            <tr><td>202</td><td>Porto Rico (PR)</td><td>+1787</td></tr>
                            <tr><td>203</td><td>La Réunion (RE)</td><td>+262</td></tr>
                            <tr><td>204</td><td>Saint-Barthélemy (BL)</td><td>+590</td></tr>
                            <tr><td>205</td><td>Sainte-Hélène (SH)</td><td>+290</td></tr>
                            <tr><td>206</td><td>Saint-Kitts-et-Nevis (KN)</td><td>+1869</td></tr>
                            <tr><td>207</td><td>Sainte-Lucie (LC)</td><td>+1758</td></tr>
                            <tr><td>208</td><td>Saint-Martin (MF)</td><td>+590</td></tr>
                            <tr><td>209</td><td>Saint-Pierre-et-Miquelon (PM)</td><td>+508</td></tr>
                            <tr><td>210</td><td>Saint-Vincent-et-les-Grenadines (VC)</td><td>+1784</td></tr>
                            <tr><td>211</td><td>Samoa (WS)</td><td>+685</td></tr>
                            <tr><td>212</td><td>Samoa américaines (AS)</td><td>+1684</td></tr>
                            <tr><td>213</td><td>Saint-Marin (SM)</td><td>+378</td></tr>
                            <tr><td>214</td><td>Sao Tomé-et-Principe (ST)</td><td>+239</td></tr>
                            <tr><td>215</td><td>Seychelles (SC)</td><td>+248</td></tr>
                            <tr><td>216</td><td>Sierra Leone (SL)</td><td>+232</td></tr>
                            <tr><td>217</td><td>Sint Maarten (SX)</td><td>+1721</td></tr>
                            <tr><td>218</td><td>Somalie (SO)</td><td>+252</td></tr>
                            <tr><td>219</td><td>Soudan du Sud (SS)</td><td>+211</td></tr>
                            <tr><td>220</td><td>Suriname (SR)</td><td>+597</td></tr>
                            <tr><td>221</td><td>Svalbard et Jan Mayen (SJ)</td><td>+47</td></tr>
                            <tr><td>222</td><td>Syrie (SY)</td><td>+963</td></tr>
                            <tr><td>223</td><td>Tadjikistan (TJ)</td><td>+992</td></tr>
                            <tr><td>224</td><td>Timor oriental (TL)</td><td>+670</td></tr>
                            <tr><td>225</td><td>Tonga (TO)</td><td>+676</td></tr>
                            <tr><td>226</td><td>Trinité-et-Tobago (TT)</td><td>+1868</td></tr>
                            <tr><td>227</td><td>Turkménistan (TM)</td><td>+993</td></tr>
                            <tr><td>228</td><td>Îles Turques-et-Caïques (TC)</td><td>+1649</td></tr>
                            <tr><td>229</td><td>Tuvalu (TV)</td><td>+688</td></tr>
                            <tr><td>230</td><td>Vanuatu (VU)</td><td>+678</td></tr>
                            <tr><td>231</td><td>Vatican (VA)</td><td>+39</td></tr>
                            <tr><td>232</td><td>Wallis-et-Futuna (WF)</td><td>+681</td></tr>
                            <tr><td>233</td><td>Sahara occidental (EH)</td><td>+212</td></tr>
                            <tr><td>234</td><td>Albanie (AL)</td><td>+355</td></tr>
                            <tr><td>235</td><td>Anguilla (AI)</td><td>+1264</td></tr>
                            <tr><td>236</td><td>Antarctique (AQ)</td><td>+672</td></tr>
                            <tr><td>237</td><td>Île Bouvet (BV)</td><td>+47</td></tr>
                            <tr><td>238</td><td>Îles Cocos (CC)</td><td>+61</td></tr>
                            <tr><td>239</td><td>Îles Christmas (CX)</td><td>+61</td></tr>
                            <tr><td>240</td><td>Guadeloupe (GP)</td><td>+590</td></tr>
                            <tr><td>241</td><td>Guernesey (GG)</td><td>+44</td></tr>
                            <tr><td>242</td><td>Îles Heard-et-MacDonald (HM)</td><td>+672</td></tr>
                            <tr><td>243</td><td>Pitcairn (PN)</td><td>+870</td></tr>
                            <tr><td>244</td><td>Sahara occidental (EH)</td><td>+212</td></tr>
                            <tr><td>245</td><td>Tokelau (TK)</td><td>+690</td></tr>
                            <tr><td>246</td><td>Antarctique français (TF)</td><td>+262</td></tr>
                            <tr><td>247</td><td>Îles mineures éloignées des États-Unis (UM)</td><td>+1</td></tr>
                            <tr><td>248</td><td>Sahara occidental (EH)</td><td>+212</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Détails SMS -->
<div class="modal fade" id="smsDetailsModal" tabindex="-1" aria-labelledby="smsDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="smsDetailsModalLabel">Détails du SMS Pro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="smsDetailsContent">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const messageInput = document.getElementById('message');
    const charCount = document.getElementById('char-count');
    const cost = document.getElementById('cost');
    const finalCost = document.getElementById('final-cost');

    // Calculer le nombre de caractères et crédits
    messageInput.addEventListener('input', function() {
        const length = this.value.length;
        const segments = length > 0 ? Math.ceil(length / 70) : 0;
        const credits = segments * 500;

        charCount.textContent = length;
        cost.textContent = credits;
        finalCost.textContent = credits;
    });

    // Gestion indicatif pays - afficher le hint et auto-strip
    const paysSelect = document.querySelector('select[name="pays"]');
    const numeroInput = document.getElementById('numero');
    const numeroHint = document.getElementById('numero-hint');
    const hintCode = document.getElementById('hint-code');

    paysSelect.addEventListener('change', function() {
        if (this.value) {
            numeroHint.style.display = 'block';
            hintCode.textContent = this.value;
            stripIndicatifFromNumero();
        } else {
            numeroHint.style.display = 'none';
        }
    });

    numeroInput.addEventListener('input', function() {
        stripIndicatifFromNumero();
    });

    function stripIndicatifFromNumero() {
        const code = paysSelect.value; // ex: "+33"
        if (!code) return;
        let num = numeroInput.value.replace(/[\s\-\.]/g, '');
        const cleanCode = code.replace('+', ''); // "33"

        if (num.startsWith(code)) {
            numeroInput.value = num.substring(code.length);
        } else if (num.startsWith('+' + cleanCode)) {
            numeroInput.value = num.substring(cleanCode.length + 1);
        } else if (num.startsWith('00' + cleanCode)) {
            numeroInput.value = num.substring(cleanCode.length + 2);
        }
    }

    // Soumission du formulaire
    document.getElementById('sms-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('{{ route("sms.pro.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                expediteur: formData.get('expediteur'),
                pays: formData.get('pays'),
                numero: formData.get('numero'),
                message: formData.get('message')
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                showNotification(data.message + ' Crédits restants: ' + data.credits_restants, 'success');
                this.reset();
                charCount.textContent = '0';
                cost.textContent = '0';
                finalCost.textContent = '0';
                document.getElementById('credits-display').textContent = data.credits_restants;
                loadHistory();
            } else {
                showNotification('Erreur: ' + data.message, 'danger');
            }
        })
        .catch(error => {
            showNotification('Erreur lors de l\'envoi du SMS', 'danger');
            console.error(error);
        });
    });

    // Charger l'historique
    function loadHistory() {
        fetch('{{ route("sms.pro.history") }}', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                updateHistoryTable(data.history);
            }
        })
        .catch(error => console.error('Erreur chargement historique:', error));
    }

    function updateHistoryTable(history) {
        const container = document.getElementById('history-container');
        const countElement = document.getElementById('history-count');
        
        countElement.textContent = history.length;
        
        if(history.length === 0) {
            container.innerHTML = `
                <div class="text-center py-4">
                    <div class="mb-3" style="margin:0 auto;width:110px;">
                        <svg viewBox="0 0 110 90" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:110px;height:90px;">
                            <rect x="15" y="42" width="70" height="42" rx="5" fill="#bfdbfe"/>
                            <path d="M15 42 L50 54 L85 42" stroke="#93c5fd" stroke-width="2" fill="none"/>
                            <path d="M15 42 L22 28 L50 28 L50 54 Z" fill="#dbeafe" stroke="#93c5fd" stroke-width="1.5"/>
                            <path d="M85 42 L78 28 L50 28 L50 54 Z" fill="#eff6ff" stroke="#93c5fd" stroke-width="1.5"/>
                            <g transform="translate(68, 8) rotate(-20)">
                                <path d="M0 8 L22 0 L14 14 Z" fill="#3b82f6"/>
                                <path d="M0 8 L14 14 L10 20 Z" fill="#60a5fa"/>
                                <path d="M14 14 L10 20 L22 0 Z" fill="#2563eb"/>
                            </g>
                            <path d="M58 22 Q65 15 72 12" stroke="#93c5fd" stroke-width="1.5" stroke-dasharray="3 3" fill="none"/>
                        </svg>
                    </div>
                    <p class="fw-semibold mb-1" style="color:#1e293b;">Aucun envoi pour le moment</p>
                    <p class="text-secondary mb-0" style="font-size:.83rem;">Vos envois de SMS apparaîtront ici.</p>
                </div>`;
            return;
        }

        let html = '';
        history.forEach(item => {
            const date = new Date(item.created_at);
            const dateStr = date.toLocaleDateString('fr-FR', { day: '2-digit', month: '2-digit', year: '2-digit' });
            const timeStr = date.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
            const fullDateStr = date.toLocaleDateString('fr-FR', { day: '2-digit', month: '2-digit', year: 'numeric' });
            
            let statusBadge = '';
            let statusText = '';
            if(item.status === 'Livré') {
                statusBadge = 'bg-success';
                statusText = 'Livré ✓';
            } else if(item.status === 'Envoyé') {
                statusBadge = 'bg-info';
                statusText = 'Envoyé ✉';
            } else if(item.status === 'Rejeté') {
                statusBadge = 'bg-danger';
                statusText = 'Rejeté ⚠';
            } else {
                statusBadge = 'bg-warning text-dark';
                statusText = 'En attente';
            }
            
            html += `
                <div class="border-bottom pb-2 mb-2" style="cursor: pointer;" onclick="showSmsDetails(${item.id})">
                    <div class="d-flex justify-content-between align-items-start mb-1">
                        <span class="badge ${statusBadge}">${statusText}</span>
                        <small class="text-muted">${dateStr} à ${timeStr} UTC+0</small>
                    </div>
                    <div class="small">
                        <strong>De ${item.expediteur} au ${item.destinataire}</strong> le ${fullDateStr} à ${timeStr} UTC+0
                    </div>
                </div>
            `;
        });
        container.innerHTML = html;
    }

    // Fonction pour afficher les détails d'un SMS
    window.showSmsDetails = function(smsId) {
        const modal = new bootstrap.Modal(document.getElementById('smsDetailsModal'));
        const content = document.getElementById('smsDetailsContent');
        
        // Afficher le loader
        content.innerHTML = `
            <div class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Chargement...</span>
                </div>
            </div>
        `;
        
        modal.show();
        
        // Charger les détails
        fetch(`{{ url('/sms/pro/details') }}/${smsId}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                const sms = data.sms;
                const date = new Date(sms.created_at);
                const dateStr = date.toLocaleDateString('fr-FR', { day: '2-digit', month: '2-digit', year: 'numeric' });
                const timeStr = date.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
                
                let statusBadge = '';
                if(sms.status === 'Livré') {
                    statusBadge = '<span class="badge bg-success">Livré ✓</span>';
                } else if(sms.status === 'Envoyé') {
                    statusBadge = '<span class="badge bg-info">Envoyé ✉</span>';
                } else {
                    statusBadge = '<span class="badge bg-danger">Rejeté ⚠</span>';
                }
                
                content.innerHTML = `
                    <div class="mb-3">
                        <strong>Expéditeur :</strong> ${sms.expediteur}
                    </div>
                    <div class="mb-3">
                        <strong>Destinataire :</strong> ${sms.destinataire}
                    </div>
                    <div class="mb-3">
                        <strong>Message :</strong> ${sms.message}
                    </div>
                    <div class="mb-3">
                        <strong>Coût d'envoi :</strong> ${sms.credits_used} Crédits
                    </div>
                    <div class="mb-3">
                        <strong>Date d'envoi :</strong> ${dateStr} à ${timeStr} UTC+0
                    </div>
                    <div class="mb-3">
                        <strong>Statut :</strong> ${statusBadge}
                    </div>
                    ${sms.error_message ? `<div class="alert alert-danger mb-0"><strong>Erreur :</strong> ${sms.error_message}</div>` : ''}
                `;
            } else {
                content.innerHTML = '<div class="alert alert-danger">Erreur lors du chargement des détails</div>';
            }
        })
        .catch(error => {
            content.innerHTML = '<div class="alert alert-danger">Erreur lors du chargement des détails</div>';
            console.error(error);
        });
    };

    // Fonction pour afficher les notifications
    function showNotification(message, type) {
        // Supprimer les anciennes notifications
        const oldAlerts = document.querySelectorAll('.custom-notification');
        oldAlerts.forEach(alert => alert.remove());
        
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed custom-notification`;
        alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px; max-width: 500px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);';
        alertDiv.innerHTML = `
            <strong>${type === 'success' ? '✓' : '✗'}</strong> ${message}
            <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
        `;
        document.body.appendChild(alertDiv);
    }

    // Charger l'historique au démarrage et rafraîchir toutes les 15s pour capter les mises à jour webhook
    loadHistory();
    setInterval(loadHistory, 15000);

    // Supprimer l'historique
    document.getElementById('btnSupprimerHistorique').addEventListener('click', function() {
        if(confirm('Voulez-vous vraiment supprimer tout l\'historique ?')) {
            fetch('{{ route("sms.pro.delete-history") }}', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    showNotification('Historique supprimé avec succès', 'success');
                    loadHistory();
                } else {
                    showNotification('Erreur lors de la suppression', 'danger');
                }
            })
            .catch(error => {
                showNotification('Erreur lors de la suppression', 'danger');
                console.error(error);
            });
        }
    });
});
</script>
@endsection
