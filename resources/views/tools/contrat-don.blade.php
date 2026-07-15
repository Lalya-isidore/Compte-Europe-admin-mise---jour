@extends('layouts.admin')

@section('title', 'Générateur de Document de Don')

@section('breadcrumb')
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600&display=swap" rel="stylesheet">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Outils</a></li>
    <li class="breadcrumb-item active">Document de Don</li>
@endsection

@section('content')
<div class="cp-wrapper">

    {{-- Alerte crédits insuffisants --}}
    @error('credits')
    <div style="background:#fff3cd; border:1px solid #ffc107; border-radius:10px; padding:14px 18px; margin-bottom:18px; display:flex; align-items:center; gap:12px; color:#856404;">
        <i class="fas fa-exclamation-triangle" style="font-size:1.2rem;"></i>
        <span>{{ $message }}</span>
    </div>
    @enderror

    {{-- Info section --}}
    <div class="cp-info-card">
        <div class="cp-info-title"><i class="fas fa-hand-holding-heart"></i> Document de Don / Donation</div>
        <div class="cp-info-body">
            <p class="cp-r-balance">
                <span>Crédit(s) disponible : <b>{{ number_format($userCredits, 0, ',', ' ') }}</b></span>
                <span class="cp-r-about" data-bs-toggle="tooltip" data-bs-placement="bottom" title="1 Crédit = 1 F CFA" tabindex="0">à savoir</span>
            </p>
            <div class="alert alert-primary" role="alert" style="font-size:.9em;">
                <p><i class="fas fa-info-circle"></i> Cet outil génère un <b>Certificat d'Enregistrement de Donation</b> officiel, certifié par le Tribunal, suivant le modèle légal international. Parfait pour les donations de fonds (testamentaires ou entre vifs).</p>
                <b>NB :</b> Chaque téléchargement coûte <b>1 000 crédits</b>. La première génération est <b>gratuite</b>.
            </div>
        </div>
    </div>

    <form action="{{ route('tools.contrat-don.generate') }}" method="POST" id="cp-form" enctype="multipart/form-data">
        @csrf
        <div class="cp-grid">

            {{-- ======== COLONNE GAUCHE : Formulaire ======== --}}
            <div class="cp-col">

                {{-- Langue --}}
                <div class="cp-card">
                    <div class="cp-card__head"><i class="fas fa-language"></i> Langue du document</div>
                    <div class="cp-card__body">
                        <div class="cp-field">
                            <select name="lang" id="lang-select">
                                <option value="fr">🇫🇷 Français</option>
                                <option value="en">🇬🇧 Anglais</option>
                                <option value="es">🇪🇸 Espagnol</option>
                                <option value="pt">🇵🇹 Portugais</option>
                                <option value="de">🇩🇪 Allemand</option>
                                <option value="it">🇮🇹 Italien</option>
                                <option value="ru">🇷🇺 Russe</option>
                                <option value="ar">🇸🇦 Arabe</option>
                                <option value="zh">🇨🇳 Chinois</option>
                                <option value="tr">🇹🇷 Turc</option>
                                <option value="no">🇳🇴 Norvégien</option>
                                <option value="el">🇬🇷 Grec</option>
                                <option value="pl">🇵🇱 Polonais</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Pays du notaire --}}
                <div class="cp-card">
                    <div class="cp-card__head"><i class="fas fa-flag"></i> Pays du Notaire</div>
                    <div class="cp-card__body">
                        <div class="cp-field">
                            <label>Pays</label>
                            <select name="pays_notaire" id="pays-notaire-select">
                                @foreach($flags as $code => $label)
                                    <option value="{{ $code }}" {{ $code === 'fr' ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="cp-row2" style="margin-top:14px;">
                            <div class="cp-field">
                                <label>Nom de la République <span class="req">*</span></label>
                                <input type="text" name="nom_republique" id="nom-republique"
                                    placeholder="Ex: République Française"
                                    value="{{ $republicNames['fr'] ?? 'République Française' }}" required>
                            </div>
                            <div class="cp-field">
                                <label>Ville du Tribunal <span class="req">*</span></label>
                                <input type="text" name="ville_tribunal" id="ville-tribunal"
                                    placeholder="Ex: Nantes" value="{{ $capitalCities['fr'] }}" required>
                            </div>
                        </div>
                        <div class="cp-field" style="margin-top:14px;">
                            <label>Domicile du Notaire <span class="req">*</span></label>
                            <input type="text" name="adresse_notaire" id="adresse-notaire"
                                placeholder="Ex: domicilié en France à Boulogne-Billancourt"
                                value="{{ $notaireAdresses['fr'] }}" required>
                            <small style="color:#888; font-size:11px;">Ce texte apparaîtra dans la phrase de certification du notaire.</small>
                        </div>
                    </div>
                </div>

                {{-- Donateur --}}
                <div class="cp-card">
                    <div class="cp-card__head"><i class="fas fa-user-donate"></i> Identification du Donateur</div>
                    <div class="cp-card__body">
                        <div class="cp-row2">
                            <div class="cp-field">
                                <label>Nom <span class="req">*</span></label>
                                <input type="text" name="donateur_nom" id="donateur_nom" placeholder="Ex: DUPONT" required>
                            </div>
                            <div class="cp-field">
                                <label>Prénom <span class="req">*</span></label>
                                <input type="text" name="donateur_prenom" id="donateur_prenom" placeholder="Ex: Alice" required>
                            </div>
                        </div>
                        <div class="cp-row2" style="margin-top: 14px;">
                            <div class="cp-field">
                                <label>Pays <span class="req">*</span></label>
                                <input type="text" name="donateur_pays" id="donateur_pays" placeholder="Ex: France" required>
                            </div>
                            <div class="cp-field">
                                <label>Adresse complète <span class="req">*</span></label>
                                <input type="text" name="donateur_adresse" id="donateur_adresse" placeholder="Ex: 15 Rue de la Paix, Paris" required>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Donataire --}}
                <div class="cp-card">
                    <div class="cp-card__head"><i class="fas fa-user-receive"></i> Identification du Bénéficiaire</div>
                    <div class="cp-card__body">
                        <div class="cp-field">
                            <label>Nom et Prénoms complets <span class="req">*</span></label>
                            <input type="text" name="donataire_nom" id="donataire_nom" placeholder="Ex: TOVAR LOPEZ BLAS MARTIN" required>
                        </div>
                        <div class="cp-row2" style="margin-top: 14px;">
                            <div class="cp-field">
                                <label>Pays <span class="req">*</span></label>
                                <input type="text" name="donataire_pays" id="donataire_pays" placeholder="Ex: Venezuela / Pérou" required>
                            </div>
                            <div class="cp-field">
                                <label>Adresse complète <span class="req">*</span></label>
                                <input type="text" name="donataire_adresse" id="donataire_adresse" placeholder="Ex: 12 Av. Bolívar, Lima" required>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Somme --}}
                <div class="cp-card">
                    <div class="cp-card__head"><i class="fas fa-coins"></i> Détails de la Donation</div>
                    <div class="cp-card__body">
                        <div class="cp-row2">
                            <div class="cp-field">
                                <label>Montant <span class="req">*</span></label>
                                <input type="number" name="montant" id="montant" placeholder="Ex: 350000" min="1" step="1" required>
                            </div>
                            <div class="cp-field">
                                <label>Devise <span class="req">*</span></label>
                                <select name="devise" id="devise">
                                    @foreach($currencies as $code => $info)
                                        <option value="{{ $code }}" {{ $code === 'EUR' ? 'selected' : '' }}>
                                            {{ $code }} — {{ $info['symbol'] }} — {{ $info['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Personnalisation du Cachet --}}
                <div class="cp-card">
                    <div class="cp-card__head"><i class="fas fa-stamp"></i> Personnalisation du Cachet Notaire</div>
                    <div class="cp-card__body">
                        <div class="cp-field" style="margin-bottom:14px;">
                            <label>Style du Cachet</label>
                            <div style="display:flex; gap:10px;">
                                <label style="flex:1; cursor:pointer;">
                                    <input type="radio" name="seal_style" value="rect" checked style="display:none;" onchange="generateSealPreview()">
                                    <div class="seal-style-pill">Carré</div>
                                </label>
                                <label style="flex:1; cursor:pointer;">
                                    <input type="radio" name="seal_style" value="round" style="display:none;" onchange="generateSealPreview()">
                                    <div class="seal-style-pill">Rond</div>
                                </label>
                            </div>
                        </div>
                        <div class="cp-field">
                            <label>Libellé (Haut) <span class="req">*</span></label>
                            <input type="text" name="seal_label" id="seal_label" placeholder="Ex: CABINET NOTARIAL" value="CABINET NOTARIAL">
                        </div>
                        <div class="cp-row2" style="margin-top: 14px;">
                            <div class="cp-field">
                                <label>Nom du Notaire <span class="req">*</span></label>
                                <input type="text" name="seal_notaire" id="seal_notaire" placeholder="Ex: MARIE AIMÉE PEYRON" value="MARIE AIMÉE PEYRON">
                            </div>
                            <div class="cp-field">
                                <label>Téléphone de l'Avocat <span class="req">*</span></label>
                                <input type="text" name="seal_phone" id="seal_phone" placeholder="Ex: +44 20 1234 5678" value="+44 20 7946 0123">
                            </div>
                        </div>
                        <div class="cp-field" style="margin-top: 14px;">
                            <label>Titre Professionnel <span class="req">*</span></label>
                            <input type="text" name="seal_title" id="seal_title" placeholder="Ex: AVOCAT À LA COUR SUPRÊME" value="AVOCAT À LA COUR SUPRÊME">
                        </div>
                        <div class="cp-field" style="margin-top: 14px;">
                            <label>Ville / Localisation <span class="req">*</span></label>
                            <input type="text" name="seal_city" id="seal_city" placeholder="Ex: Londres" value="Londres">
                        </div>
                        <div style="margin-bottom:12px;">
                            <div class="cachet-label">Couleur du Cachet</div>
                            <div style="display:flex; gap:8px;">
                                <button type="button" class="cachet-color active" style="background:#1a5ea8;" onclick="setSealColor('#1a5ea8',this)" title="Bleu"></button>
                                <button type="button" class="cachet-color" style="background:#c0392b;" onclick="setSealColor('#c0392b',this)" title="Rouge"></button>
                                <button type="button" class="cachet-color" style="background:#1a1a1a;" onclick="setSealColor('#1a1a1a',this)" title="Noir"></button>
                                <button type="button" class="cachet-color" style="background:#155724;" onclick="setSealColor('#155724',this)" title="Vert"></button>
                                <button type="button" class="cachet-color" style="background:#6b21a8;" onclick="setSealColor('#6b21a8',this)" title="Violet"></button>
                            </div>
                            <input type="hidden" name="seal_color" id="seal_color" value="#1a5ea8">
                        </div>

                        {{-- Aperçu cachet --}}
                        <div style="margin-top: 15px;">
                            <div class="cachet-label">Aperçu du Cachet</div>
                            <div style="background:repeating-conic-gradient(#ccc 0% 25%,#fff 0% 50%) 0 0/12px 12px; border-radius:6px; padding:8px; display:inline-block;">
                                <canvas id="seal-canvas" width="180" height="180" style="display:block;"></canvas>
                            </div>
                        </div>

                        <small style="color:#888; font-size:11px; margin-top:8px; display:block;">Ces informations apparaîtront à l'intérieur du cachet circulaire officiel.</small>
                    </div>
                </div>

                {{-- Signature du Donateur --}}
                <div class="cp-card">
                    <div class="cp-card__head"><i class="fas fa-signature"></i> Signature du Donateur</div>
                    <div class="cp-card__body">
                        <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:12px; text-align:center; margin-bottom:12px;">
                            <img id="sig-don-preview" src="/images/images%20ent%C3%AAte%20don/image%20copy%2010.png" style="height:80px; opacity:0.85; display:block; margin:0 auto;">
                        </div>
                        <div class="cp-field">
                            <label>Remplacer par votre propre signature (optionnel)</label>
                            <input type="file" name="sig_don_image" id="sig_don_image" accept="image/*" onchange="previewUploadedSigDon(this)">
                        </div>
                        <input type="hidden" name="sig_don_image_data" id="sig_don_image_data">
                    </div>
                </div>

                {{-- Signature du Notaire --}}
                <div class="cp-card">
                    <div class="cp-card__head"><i class="fas fa-signature"></i> Signature du Notaire</div>
                    <div class="cp-card__body">
                        <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:12px; text-align:center; margin-bottom:12px;">
                            <img id="sig-not-preview" src="/images/images%20ent%C3%AAte%20don/image%20copy%2011.png" style="height:80px; opacity:0.85; display:block; margin:0 auto;">
                        </div>
                        <div class="cp-field">
                            <label>Remplacer par votre propre signature (optionnel)</label>
                            <input type="file" name="sig_image" id="sig_image" accept="image/*" onchange="previewUploadedSig(this)">
                        </div>
                        <input type="hidden" name="sig_image_data" id="sig_image_data">
                    </div>
                </div>

                {{-- Paragraphes personnalisables --}}
                <div class="cp-card">
                    <div class="cp-card__head cp-card__head--toggle" onclick="toggleParasSection()" style="cursor:pointer;">
                        <i class="fas fa-edit"></i> Contenu du document
                        <small style="font-weight:normal; margin-left:8px; opacity:0.7;">Modifiez les paragraphes</small>
                        <i class="fas fa-chevron-down" id="paras-chev" style="margin-left:auto; transition:transform 0.2s;"></i>
                    </div>
                    <div id="paras-section" style="display:none;">
                        <div class="cp-card__body" style="padding-top:10px;">
                            <button type="button" onclick="resetParagraphs()" class="cp-btn-reset">
                                <i class="fas fa-sync-alt"></i> Réinitialiser depuis la langue sélectionnée
                            </button>
                            <div style="margin-top:12px;">
                                @php
                                $paraItems = [
                                    ['key'=>'clause',      'label'=>'Clause de certification (page 1)',   'name'=>'para_clause',       'hint'=>'Variables : :montant :devise :donneur :banque'],
                                    ['key'=>'p2para1',     'label'=>'Paragraphe principal (page 2)',       'name'=>'para_p2_para1',     'hint'=>'Variables : :donneur :montant :devise :donataire'],
                                    ['key'=>'bullet1',     'label'=>'Déclaration 1 du donateur',           'name'=>'para_bullet1',      'hint'=>''],
                                    ['key'=>'bullet2',     'label'=>'Déclaration 2 du donateur',           'name'=>'para_bullet2',      'hint'=>''],
                                    ['key'=>'bullet3',     'label'=>'Déclaration 3 du donateur',           'name'=>'para_bullet3',      'hint'=>''],
                                    ['key'=>'accept1',     'label'=>'Acceptation 1 du bénéficiaire',       'name'=>'para_accept1',      'hint'=>''],
                                    ['key'=>'accept2',     'label'=>'Acceptation 2 du bénéficiaire',       'name'=>'para_accept2',      'hint'=>''],
                                    ['key'=>'notcertifie', 'label'=>'Certification du notaire',            'name'=>'para_notcertifie',  'hint'=>'Variables : :territoire :notaire :adresse'],
                                    ['key'=>'legal2',      'label'=>'Disposition légale 1',                'name'=>'para_legal2',       'hint'=>''],
                                    ['key'=>'legal3',      'label'=>'Disposition légale 2',                'name'=>'para_legal3',       'hint'=>'Variable : :donataire'],
                                ];
                                @endphp
                                @foreach($paraItems as $i => $p)
                                <div class="art-item" id="para-item-{{ $p['key'] }}">
                                    <div class="art-item__hd" onclick="togglePara('{{ $p['key'] }}')">
                                        <span class="art-item__badge">{{ $i + 1 }}</span>
                                        <span style="font-size:0.85rem; flex:1;">{{ $p['label'] }}</span>
                                        <i class="fas fa-chevron-down art-chev" id="para-chev-{{ $p['key'] }}"></i>
                                    </div>
                                    <div class="art-item__bd" id="para-bd-{{ $p['key'] }}" style="display:none;">
                                        <textarea name="{{ $p['name'] }}" id="para-{{ $p['key'] }}" class="art-corps-inp" rows="3" placeholder="Texte du paragraphe..."></textarea>
                                        @if($p['hint'])<div class="para-hint">{{ $p['hint'] }}</div>@endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="cp-btn-generate">
                    <i class="fas fa-file-pdf"></i>
                    Générer le Testament
                    @if($freeUsed)
                    <span style="margin-left:10px; background:rgba(255,255,255,0.18); border-radius:20px; padding:2px 10px; font-size:0.78rem; font-weight:600; letter-spacing:0.5px;">
                        <i class="fas fa-coins" style="font-size:0.72rem; margin-right:4px;"></i>1 000 crédits
                    </span>
                    @else
                    <span style="margin-left:10px; background:rgba(255,255,255,0.18); border-radius:20px; padding:2px 10px; font-size:0.78rem; font-weight:600; letter-spacing:0.5px;">
                        <i class="fas fa-gift" style="font-size:0.72rem;"></i> Gratuit
                    </span>
                    @endif
                </button>

            </div>

            {{-- ======== COLONNE DROITE : Aperçu ======== --}}
            @php
                $hStars = str_repeat('★ ', 32);
                $vStars = str_repeat('★', 70);
                $vStarArray = preg_split('//u', $vStars, -1, PREG_SPLIT_NO_EMPTY);
            @endphp
            <div class="cp-col cp-col--preview">
                <div class="cp-card cp-card--preview-sticky">
                    <div class="cp-card__head"><i class="fas fa-eye"></i> Aperçu (Modèle Officiel)</div>
                    <div class="cp-preview">
                        
                        {{-- PAGE 1 --}}
                        <div class="cp-preview__doc" id="prev-page-1">
                            <div class="prev-star-border-fixed prev-b-top">{{ $hStars }}</div>
                            <div class="prev-star-border-fixed prev-b-bottom">{{ $hStars }}</div>
                            <div class="prev-star-border-fixed prev-b-left">
                                @foreach($vStarArray as $s)
                                    {{ $s }}<br>
                                @endforeach
                            </div>
                            <div class="prev-star-border-fixed prev-b-right">
                                @foreach($vStarArray as $s)
                                    {{ $s }}<br>
                                @endforeach
                            </div>
                            
                            <div class="prev-container">
                                <img src="/images/contract/justice-scales.svg" class="prev-watermark" style="position: absolute; top: 28%; left: 50%; transform: translateX(-50%); width: 75%; opacity: 0.05; z-index: 0; pointer-events: none;">

                                <div class="prev-hdr-logos" style="display:flex; align-items:center; justify-content:space-between; gap:10px; margin-bottom:10px; width: 100%;">
                                    <div style="width: 25%; text-align: center;"><img src="/images/images entête don/image.png" style="max-height: 50px; max-width: 100%;"></div>
                                    <div style="width: 50%; text-align: center; position: relative;">
                                        <img src="/images/images entête don/image copy 3.png" style="max-height: 55px; max-width: 100%; mix-blend-mode: multiply;">
                                        <div id="prev-notaire-logo-text" style="text-align: center; font-family: 'DejaVu Sans', sans-serif; font-size: 8px; color: #1a3a5c; font-style: italic; font-weight: bold; margin-top: -14px;">{{ ucfirst(strtolower($translations['fr']['notario'])) }}</div>
                                    </div>
                                    <div style="width: 25%; text-align: center;"><img src="/images/images entête don/image copy 2.png" style="max-height: 50px; max-width: 100%;"></div>
                                </div>

                                <div style="text-align: center; margin-top: 5px;">
                                    <div class="prev-rep-fr" id="prev-rep-fr" style="color: #1565b5; font-size: 15px; font-weight: bold; text-decoration: underline; margin-bottom: 3px;">RÉPUBLIQUE FRANÇAISE</div>
                                    <div class="prev-min-jus" id="prev-min-jus" style="font-weight: bold; font-size: 10px; color: #000; margin-bottom: 2px;">Ministère de la Justice et de la Législation</div>
                                    <div class="prev-human" id="prev-human" style="font-weight: bold; font-size: 10px; color: #000; margin-bottom: 2px;">droits de l'homme</div>
                                    <div class="prev-div" style="font-weight: bold; margin: 2px 0; color: #000;">------------------</div>
                                    <div class="prev-tribunal" id="prev-tribunal" style="font-weight: bold; font-size: 10px; color: #000; margin-bottom: 2px;">Tribunal de Grande Instance de Nantes</div>
                                    <div class="prev-div" style="font-weight: bold; margin: 2px 0; color: #000;">------------------</div>
                                    <div class="prev-greffier" id="prev-greffier" style="font-weight: bold; font-size: 10px; color: #000; margin-bottom: 2px;">Greffier en Chef</div>
                                    <div class="prev-div" style="font-weight: bold; margin: 2px 0; color: #000;">------------------</div>
                                    <div class="prev-dossier" style="margin: 4px 0;">
                                        <div style="display:inline-block; border: 1px solid #000; padding: 2px 12px; font-weight:bold; font-size: 10px; color: #000;">
                                            <span id="prev-no-lbl">N°</span> <span id="prev-dossier-val">XX XXX - XXX MJLDH / TPIC / EMMQ</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="prev-title-doc" id="prev-titre" style="text-align: center; color: #c00000; font-size: 13px; font-weight: bold; text-decoration: underline; margin: 12px 0 8px; text-transform: uppercase;">CERTIFICAT D'ENREGISTREMENT DE DONATION</div>

                                <table class="prev-id-table" style="width:100%; border-collapse:separate; border-spacing:10px 0; margin:8px 0; table-layout:fixed;">
                                    <tr>
                                        <td class="prev-id-box" style="border: 0.5px solid #333; padding: 6px 8px; width: 50%; vertical-align: top; font-size: 7.5px;">
                                            <div class="prev-id-lbl" id="prev-id-don" style="color: #1F3864; font-weight: bold; text-decoration: underline; font-size: 7.5px; text-transform: uppercase; margin-bottom: 3px;">LE DONATEUR</div>
                                            <div class="prev-id-name" id="prev-val-don-fullname" style="font-weight: bold; font-size: 9px; margin: 3px 0; display: block; color: #000;">—</div>
                                            <div class="prev-id-row" style="font-size: 7.5px; margin: 4px 0;"><strong class="prev-lbl-pay" style="text-decoration:underline;">PAYS :</strong> <span id="prev-val-don-pay">—</span></div>
                                            <div class="prev-id-row" style="font-size: 7.5px; margin: 4px 0;"><strong class="prev-lbl-adr" style="text-decoration:underline;">ADRESSE :</strong> <span id="prev-val-don-adr">—</span></div>
                                            <div class="prev-id-note" id="prev-as-don" style="font-style: italic; font-size: 7px; margin-top: 6px; border-top: 0.5px solid #ccc; padding-top: 3px;">Ci-après dénommé "Le Donateur"</div>
                                        </td>
                                        <td class="prev-id-box" style="border: 0.5px solid #333; padding: 6px 8px; width: 50%; vertical-align: top; font-size: 7.5px;">
                                            <div class="prev-id-lbl" id="prev-id-ben" style="color: #1F3864; font-weight: bold; text-decoration: underline; font-size: 7.5px; text-transform: uppercase; margin-bottom: 3px;">BÉNÉFICIAIRE</div>
                                            <div class="prev-id-name" id="prev-val-ben-nom" style="font-weight: bold; font-size: 9px; margin: 3px 0; display: block; color: #000;">—</div>
                                            <div class="prev-id-row" style="font-size: 7.5px; margin: 4px 0;"><strong class="prev-lbl-pay" style="text-decoration:underline;">PAYS :</strong> <span id="prev-val-ben-pay">—</span></div>
                                            <div class="prev-id-row" style="font-size: 7.5px; margin: 4px 0;"><strong class="prev-lbl-adr" style="text-decoration:underline;">ADRESSE :</strong> <span id="prev-val-ben-adr">—</span></div>
                                            <div class="prev-id-note" id="prev-as-ben" style="font-style: italic; font-size: 7px; margin-top: 6px; border-top: 0.5px solid #ccc; padding-top: 3px;">Ci-après dénommé "Le Bénéficiaire"</div>
                                        </td>
                                    </tr>
                                </table>

                                <div class="prev-clause" id="prev-clause-text" style="text-transform: uppercase;">
                                    JE CERTIFIE QUE LA SOMME DE — — EST TRANSFÉRABLE DU COMPTE BANCAIRE DE M. — VERS LE COMPTE BANCAIRE AU CHOIX DU BÉNÉFICIAIRE.
                                </div>

                                <div class="prev-date" id="prev-date-1" style="text-align: right; font-weight: bold; margin: 8px 0; font-size: 8.5px;">
                                    {{ date('d/m/Y') }}
                                </div>

                                <div class="prev-sigs" style="display: flex; gap: 5px; margin-top: 45px; table-layout: fixed; width: 100%;">
                                    <div class="prev-sig-item" style="flex: 1; text-align: center; font-size: 8px; width: 33.33%;">
                                        <span class="prev-sig-lbl" id="prev-sig-lbl-don" style="color: #c00000; font-weight: bold; text-transform: uppercase; text-decoration: underline; display: block; margin-bottom: 5px; height: 18px;">DONATEUR</span>
                                        <div class="prev-sig-box" style="height: 60px; display: flex; align-items: center; justify-content: center; position: relative;">
                                            <img id="prev-sig-donateur-img-1" src="/images/images entête don/image copy 10.png" style="max-height: 40px; opacity: 0.85;">
                                        </div>
                                        <div class="prev-sig-val" id="prev-sig-val-don" style="font-weight: bold; margin-top: 4px; font-size: 7.5px;">—</div>
                                    </div>
                                    <div class="prev-sig-item" style="flex: 1; text-align: center; font-size: 8px; width: 33.33%;">
                                        <span class="prev-sig-lbl" id="prev-sig-lbl-not" style="color: #c00000; font-weight: bold; text-transform: uppercase; text-decoration: underline; display: block; margin-bottom: 5px; height: 18px;">NOTAIRE</span>
                                        <div class="prev-sig-box" style="height: 60px; display: flex; align-items: center; justify-content: center; position: relative;">
                                            <img id="prev-sig-notaire-img-1" src="/images/images entête don/image copy 11.png" style="max-height: 50px; opacity: 0.92;">
                                        </div>
                                        <div class="prev-sig-val" id="prev-sig-val-not" style="font-weight: bold; margin-top: 4px; font-size: 7.5px;">MARIE AIMÉE PEYRON</div>
                                    </div>
                                    <div class="prev-sig-item" style="flex: 1; text-align: center; font-size: 8px; width: 33.33%;">
                                        <span class="prev-sig-lbl" id="prev-sig-lbl-ben" style="color: #c00000; font-weight: bold; text-transform: uppercase; text-decoration: underline; display: block; margin-bottom: 5px; height: 18px;">BÉNÉFICIAIRE</span>
                                        <div class="prev-sig-box" style="height: 60px;"></div>
                                        <div class="prev-sig-val" id="prev-sig-val-ben" style="font-weight: bold; margin-top: 4px; font-size: 7.5px;">—</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PAGE 2 --}}
                        <div class="cp-preview__doc" id="prev-page-2">
                            <div class="prev-star-border-fixed prev-b-top">{{ $hStars }}</div>
                            <div class="prev-star-border-fixed prev-b-bottom">{{ $hStars }}</div>
                            <div class="prev-star-border-fixed prev-b-left">
                                @foreach($vStarArray as $s)
                                    {{ $s }}<br>
                                @endforeach
                            </div>
                            <div class="prev-star-border-fixed prev-b-right">
                                @foreach($vStarArray as $s)
                                    {{ $s }}<br>
                                @endforeach
                            </div>
                            
                            <div class="prev-container" style="position: relative; z-index: 1;">
                                <div class="prev-hdr-logos" style="display:flex; align-items:center; justify-content:space-between; gap:10px; margin-bottom:5px; width: 100%;">
                                    <div style="width: 25%; text-align: center;"><img id="prev-flag-logo-left" src="/images/contract/marianne-flag.png" style="max-height:55px; max-width:90px; width:auto; height:auto;"></div>
                                    <div style="width: 50%;"></div>
                                    <div style="width: 25%; text-align: center;"><img id="prev-flag-logo-right" src="/images/contract/marianne-flag.png" style="max-height:55px; max-width:90px; width:auto; height:auto;"></div>
                                </div>

                                <div style="text-align: center; margin-top: 5px;">
                                    <div class="prev-rep-fr" id="prev-rep-fr-2" style="color: #1565b5; font-size: 15px; font-weight: bold; text-decoration: underline; margin-bottom: 3px;">RÉPUBLIQUE FRANÇAISE</div>
                                    <div class="prev-min-jus" id="prev-min-jus-2" style="font-weight: bold; font-size: 10px; color: #000; margin-bottom: 2px;">Ministère de la Justice et de la Législation</div>
                                    <div class="prev-human" id="prev-human-2" style="font-weight: bold; font-size: 10px; color: #000; margin-bottom: 2px;">droits de l'homme</div>
                                    <div class="prev-div" style="font-weight: bold; margin: 2px 0; color: #000;">------------------</div>
                                    <div class="prev-tribunal" id="prev-tribunal-2" style="font-weight: bold; font-size: 10px; color: #000; margin-bottom: 2px;">Tribunal de Grande Instance de Nantes</div>
                                    <div class="prev-div" style="font-weight: bold; margin: 2px 0; color: #000;">------------------</div>
                                </div>

                                <div class="prev-title-doc" id="prev-titre-2" style="text-align: center; color: #c00000; font-size: 13px; font-weight: bold; text-decoration: underline; margin: 10px 0; text-transform: uppercase;">CERTIFICAT D'ENREGISTREMENT DE TESTAMENT</div>

                                <div class="prev-legal-para" id="prev-p2-para1">
                                    Le dénommé — cède, de façon gratuite, absolue, irrévocable et inconditionnelle, la somme de —, et cède tous ses droits et titularité à —.
                                </div>

                                <div class="prev-legal-para" id="prev-p2-donateur-declare">Le Donateur déclare et certifie que :</div>
                                <div class="prev-legal-bullet" id="prev-p2-bullet1">• Il est l'unique propriétaire des fonds,</div>
                                <div class="prev-legal-bullet" id="prev-p2-bullet2">• Il a le droit, le pouvoir et l'autorité pour donner son consentement à cette donation pour son compte ;</div>
                                <div class="prev-legal-bullet" id="prev-p2-bullet3">• Selon les informations dont il dispose, les fonds sont dans une banque locale et sont transférables à tout moment vers le compte bancaire du bénéficiaire.</div>

                                <div class="prev-legal-para"><span id="prev-p2-senor">M./Mme</span> <strong id="prev-p2-donataire-name-bold">—</strong> :</div>
                                <div class="prev-legal-bullet" id="prev-p2-accept1">• Accepte la donation des FONDS et en assume la garde totale, et l'utilisation conformément aux politiques et Lois 77-995 de l'article 4 du 18/12/77 optant pour les cas de Donation ;</div>
                                <div class="prev-legal-bullet" id="prev-p2-accept2">• S'engage à utiliser les fonds correctement et à dépenser l'argent légalement.</div>

                                <div class="prev-legal-para" id="prev-p2-notaire-certifie">
                                    L'acte de donation est régi et interprété conformément aux lois en vigueur sur le territoire français et sous la supervision judiciaire de Maître MARIE AIMÉE PEYRON, notaire privé et accrédité, domicilié en France à Boulogne-Billancourt.
                                </div>
                                <div class="prev-legal-para" id="prev-p2-legal2">La donation entre en vigueur à compter de la date de signature par les parties.</div>
                                <div class="prev-legal-para" id="prev-p2-legal3">— reconnaît avoir bénéficié des fonds faisant partie de cet acte de donation.</div>

                                <div class="prev-sigs" style="display: flex; gap: 5px; margin-top: 8px; table-layout: fixed; width: 100%;">
                                    <div class="prev-sig-item" style="flex: 1; text-align: center; font-size: 8px; width: 33.33%;">
                                        <span class="prev-sig-lbl" style="color: #c00000; font-weight: bold; text-transform: uppercase; text-decoration: underline; display: block; margin-bottom: 5px; height: 18px;">DONATEUR</span>
                                        <div class="prev-sig-box" style="height: 50px; display: flex; align-items: center; justify-content: center; position: relative;">
                                            <img id="prev-sig-donateur-img-2" src="/images/images entête don/image copy 10.png" style="max-height: 35px; opacity: 0.85;">
                                        </div>
                                        <div class="prev-sig-val" id="prev-sig-val-don-2" style="font-weight: bold; margin-top: 4px; font-size: 7.5px;">—</div>
                                    </div>
                                    <div class="prev-sig-item" style="flex: 1; text-align: center; font-size: 8px; width: 33.33%;">
                                        <span class="prev-sig-lbl" style="color: #c00000; font-weight: bold; text-transform: uppercase; text-decoration: underline; display: block; margin-bottom: 5px; height: 18px;">NOTAIRE</span>
                                        
                                        <div class="prev-sig-box" style="height: 50px; display: flex; align-items: center; justify-content: center; position: relative;">
                                            <div style="position: relative; display: inline-block; width: 100px; height: 50px;">
                                                <img src="/images/images entête don/timbre.png" style="position: absolute; bottom: 8px; left: 12px; height: 26px; width: auto; z-index: 1; opacity: 0.85;">
                                                <img id="prev-sig-notaire-img-2" src="/images/images entête don/image copy 11.png" style="position: absolute; bottom: -5px; left: -3px; width: 80px; height: auto; z-index: 2; opacity: 0.92;">
                                                <canvas id="prev-seal-canvas" class="prev-seal-canvas-styled"></canvas>
                                            </div>
                                        </div>
                                        
                                        <div class="prev-sig-val" id="prev-sig-val-not-2" style="font-weight: bold; margin-top: 4px; font-size: 7.5px;">MARIE AIMÉE PEYRON</div>
                                    </div>
                                    <div class="prev-sig-item" style="flex: 1; text-align: center; font-size: 8px; width: 33.33%;">
                                        <span class="prev-sig-lbl" style="color: #c00000; font-weight: bold; text-transform: uppercase; text-decoration: underline; display: block; margin-bottom: 5px; height: 18px;">BÉNÉFICIAIRE</span>
                                        <div class="prev-sig-box" style="height: 50px;"></div>
                                        <div class="prev-sig-val" id="prev-sig-val-ben-2" style="font-weight: bold; margin-top: 4px; font-size: 7.5px;">—</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<style>
.cp-wrapper { max-width: 960px; margin: 0 auto; padding: 0 20px; }
.cp-info-card { background: #fff; border-radius: 8px; box-shadow: 0 0 12px 0 rgba(0,0,0,.08); margin-bottom: 24px; overflow: hidden; }
.cp-info-title { font-family: 'Righteous', cursive, sans-serif; padding: 18px 20px; border-bottom: 1px solid #e2e2e2; color: #0d6efd; font-size: 1rem; }
.cp-info-body { padding: 18px 20px 10px; }
.cp-r-balance { margin-bottom: 14px; font-size: 0.92em; }
.cp-r-about { color: #4285f4; margin-left: 10px; text-decoration: underline; cursor: pointer; font-size: 0.88em; }

.cp-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; align-items: start; }
.cp-col { display: flex; flex-direction: column; gap: 18px; }

.cp-card { background: #fff; border: 1px solid #e8e8e8; border-radius: 12px; overflow: hidden; }
.cp-card__head { padding: 13px 18px; background: #f8f9fb; border-bottom: 1px solid #eee; font-size: 0.88rem; font-weight: 600; color: #334; display: flex; align-items: center; gap: 8px; }
.cp-card__head i { color: #1e3a5f; }
.cp-card__body { padding: 18px; }

.cp-row2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.cp-field { display: flex; flex-direction: column; gap: 5px; }
.cp-field label { font-size: 0.8rem; font-weight: 600; color: #555; }
.cp-field input, .cp-field select { border: 1px solid #ddd; border-radius: 8px; padding: 9px 12px; font-size: 0.88rem; color: #333; outline: none; transition: border-color 0.2s; background: #fff; }
.req { color: #e53e3e; }

.cp-btn-generate { width: 100%; padding: 14px; background: linear-gradient(135deg, #1a7a2e, #28a745); color: #fff; border: none; border-radius: 10px; font-size: 0.95rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; transition: all 0.2s; }
.cp-btn-generate:hover { background: linear-gradient(135deg, #145c22, #1e8035); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(40,167,69,0.35); }

/* A4 Realistic Preview Viewer Style */
.cp-col--preview .cp-card { overflow: visible; }
.cp-card--preview-sticky { position: sticky; top: 20px; z-index: 100; }
.cp-preview {
    padding: 20px 15px;
    background: #525659; /* classic dark grey PDF reader background */
    display: flex;
    flex-direction: column;
    gap: 20px;
    max-height: 820px;
    overflow-y: auto;
    border-radius: 8px;
}
.cp-preview__doc {
    background: #fff;
    border: 1px solid #cbd5e1;
    border-radius: 4px;
    padding: 0;
    font-family: 'Times New Roman', Times, 'Georgia', 'Liberation Serif', 'Noto Serif', serif;
    color: #000;
    box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    position: relative;
    overflow: hidden;
    width: 100%;
    min-height: 820px;
    height: 820px;
    display: flex;
    flex-direction: column;
    box-sizing: border-box;
}

.prev-star-border-fixed {
    position: absolute;
    z-index: 999;
    color: #000;
    font-size: 7.5pt;
    line-height: 1;
    font-family: 'DejaVu Sans', sans-serif;
    pointer-events: none;
    user-select: none;
}
.prev-b-top    { top: 2px; left: 0; right: 0; text-align: center; padding: 0 10px; }
.prev-b-bottom { bottom: 2px; left: 0; right: 0; text-align: center; padding: 0 10px; }
.prev-b-left   { top: 12px; bottom: 12px; left: 4px; width: 12px; text-align: center; word-wrap: break-word; overflow: hidden; line-height: 0.95; }
.prev-b-right  { top: 12px; bottom: 12px; right: 4px; width: 12px; text-align: center; word-wrap: break-word; overflow: hidden; line-height: 0.95; }

.prev-container {
    padding: 24px 30px 40px;
    position: relative;
    z-index: 1;
    box-sizing: border-box;
    width: 100%;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.prev-hdr-logos { text-align: center; margin-bottom: 8px; }
.prev-hdr-logos img { height: 30px; margin: 0 5px; }

.prev-rep-fr { text-align: center; color: #1565b5; font-size: 13px; font-weight: bold; text-decoration: underline; margin-bottom: 2px; }
.prev-min-jus { text-align: center; font-weight: bold; font-size: 8px; color: #000; margin-bottom: 1px; }
.prev-human   { text-align: center; font-weight: bold; font-size: 8px; color: #000; margin-bottom: 1px; }
.prev-div      { text-align: center; color: #000; font-size: 8px; font-weight: bold; }

.prev-tribunal { text-align: center; font-weight: bold; font-size: 8px; color: #000; margin-bottom: 1px; }
.prev-greffier { text-align: center; font-weight: bold; font-size: 8px; color: #000; margin-bottom: 1px; }
.prev-dossier  { text-align: center; font-weight: bold; font-size: 8px; margin: 4px 0; }

.prev-title-doc { text-align: center; color: #c00000; font-size: 12px; font-weight: bold; text-decoration: underline; margin: 12px 0 8px; text-transform: uppercase; }

.prev-clause {
    font-size: 8.5px;
    font-weight: bold;
    text-align: justify;
    margin: 12px 0;
    line-height: 1.6;
    color: #000;
    font-family: 'Times New Roman', Times, 'Georgia', 'Liberation Serif', 'Noto Serif', serif;
}
.prev-date { text-align: right; font-weight: bold; margin: 8px 0; font-size: 8.5px; }

.prev-legal-para {
    text-align: justify;
    font-size: 11px;
    line-height: 1.6;
    margin-bottom: 12px;
    font-weight: bold;
    color: #000;
    font-family: 'Times New Roman', Times, 'Georgia', 'Liberation Serif', 'Noto Serif', serif;
}
.prev-legal-bullet {
    text-align: justify;
    font-size: 11px;
    line-height: 1.6;
    margin-left: 10px;
    margin-bottom: 8px;
    font-weight: bold;
    color: #000;
    font-family: 'Times New Roman', Times, 'Georgia', 'Liberation Serif', 'Noto Serif', serif;
}

.prev-sigs { display: flex; gap: 5px; margin-top: auto !important; }
.prev-sig-item { flex: 1; text-align: center; font-size: 8px; }
.prev-sig-lbl { color: #c00000; font-weight: bold; text-transform: uppercase; text-decoration: underline; display: block; margin-bottom: 5px; height: 18px; }
.prev-sig-box { height: 40px; margin: 2px auto; width: 80%; display: flex; align-items: center; justify-content: center; position: relative; }
.prev-sig-box img { max-height: 35px; }
.prev-sig-val { font-weight: bold; margin-top: 4px; font-size: 7.5px; }
.prev-id-box { border: 0.5px solid #333; padding: 6px 8px; width: 50%; vertical-align: top; font-size: 7.5px; overflow: hidden; }
.prev-id-lbl { color: #1F3864; font-weight: bold; text-decoration: underline; font-size: 7.5px; text-transform: uppercase; margin-bottom: 3px; display: block; }
.prev-id-name { font-weight: bold; font-size: 9px; margin: 3px 0; display: block; color: #000; word-break: break-word; overflow-wrap: break-word; }
.prev-id-row { font-size: 7.5px; margin: 4px 0; word-break: break-word; overflow-wrap: break-word; }
.prev-id-note { font-style: italic; font-size: 7px; margin-top: 6px; border-top: 0.5px solid #ccc; padding-top: 3px; word-break: break-word; }

/* Styles pour le sélecteur de couleur */
.cachet-label { font-size: 0.76rem; font-weight: 600; color: #555; margin-bottom: 6px; }
.cachet-color { width: 26px; height: 26px; border-radius: 50%; border: 3px solid transparent; cursor: pointer; transition: transform 0.15s, border-color 0.15s; }
.cachet-color:hover { transform: scale(1.15); }
.cachet-color.active { border-color: #333; transform: scale(1.1); }

/* Style pills */
.seal-style-pill { padding: 8px; border: 1px solid #ddd; border-radius: 8px; text-align: center; font-size: 0.85rem; font-weight: 600; background: #fff; cursor: pointer; transition: all 0.2s; }
input[type="radio"]:checked + .seal-style-pill { background: #1e3a5f; color: #fff; border-color: #1e3a5f; }

/* Seal canvas layout */
.prev-seal-canvas-styled {
    position: absolute;
    pointer-events: none;
    z-index: 4;
}

@media (max-width: 900px) {
    .cp-grid { grid-template-columns: 1fr; }
    .cp-card--preview-sticky { position: static; top: auto; z-index: auto; }
    .cp-row2 { grid-template-columns: 1fr; }
    .cp-wrapper { padding: 0; }
    .cp-card { border-radius: 0; border-left: none; border-right: none; }
    .cp-info-card { border-radius: 0; }
    .cp-card__body { padding: 14px 12px; }
    .cp-btn-generate { font-size: 0.88rem; padding: 12px; border-radius: 10px; }
}

@media (max-width: 600px) {
    .cp-row2 { grid-template-columns: 1fr; }
    .cp-card__head { font-size: 1rem; padding: 12px 16px; }
    .cp-field label { font-size: 0.95rem; }
    .cp-field input, .cp-field select { font-size: 0.95rem; padding: 11px 12px; }
    .cp-info-card { margin-bottom: 16px; }
    .cp-grid { gap: 0; max-width: 100%; overflow: hidden; }
    .cp-col { gap: 0; max-width: 100%; overflow: hidden; }
    .cp-col--preview {
        max-width: 100vw !important;
        overflow: hidden;
        margin-left: -12px !important;
        margin-right: -12px !important;
        width: calc(100% + 24px) !important;
    }
    .cp-col--preview .cp-card {
        border: none !important;
        border-radius: 0 !important;
        margin: 0 !important;
        box-shadow: none !important;
        width: 100% !important;
    }
    .cp-col--preview .cp-card__head {
        border-radius: 0 !important;
        border-left: none !important;
        border-right: none !important;
    }
    .cp-wrapper { padding: 0; max-width: 100vw; overflow: hidden; }
    .cp-preview {
        padding: 10px 0;
        overflow-x: auto;
        max-width: 100% !important;
        width: 100% !important;
        box-sizing: border-box;
        -webkit-overflow-scrolling: touch;
        border-radius: 0 !important;
    }
    .cp-preview__doc { min-width: 580px; width: 580px; }
    .prev-container { padding: 20px 26px 35px; }
    /* Boîtes identification empilées sur mobile */
    .prev-id-table, .prev-id-table tbody, .prev-id-table tr { display: block; width: 100%; }
    .prev-id-box { display: block; width: 100% !important; box-sizing: border-box; margin-bottom: 6px; font-size: 12px !important; }
    .prev-id-lbl { font-size: 11px !important; }
    .prev-id-name { font-size: 14px !important; }
    .prev-id-row { font-size: 12px !important; margin: 6px 0 !important; }
    .prev-id-note { font-size: 10px !important; }
}
.cp-btn-reset { padding: 7px 14px; background: #f3f4f6; color: #374151; border: 1px solid #d1d5db; border-radius: 7px; font-size: 0.82rem; cursor: pointer; display: flex; align-items: center; gap: 6px; }
.cp-btn-reset:hover { background: #e5e7eb; }
.art-item { border: 1px solid #e5e7eb; border-radius: 8px; margin-bottom: 7px; overflow: hidden; transition: opacity 0.2s; }
.art-item__hd { display: flex; align-items: center; gap: 8px; padding: 9px 12px; background: #f9fafb; cursor: pointer; }
.art-item__badge { background: #1e3a5f; color: #fff; border-radius: 50%; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; font-size: 0.73rem; font-weight: bold; flex-shrink: 0; }
.art-item .art-chev { margin-left: auto; font-size: 0.75rem; color: #888; transition: transform 0.2s; }
.art-item.open .art-chev { transform: rotate(180deg); }
.art-item__bd { padding: 0 12px 12px; background: #fff; }
.art-corps-inp { width: 100%; border: 1px solid #ddd; border-radius: 6px; padding: 9px; font-size: 0.82rem; line-height: 1.6; color: #333; resize: vertical; font-family: 'Times New Roman', serif; box-sizing: border-box; margin-top: 8px; }
.art-corps-inp:focus { outline: none; border-color: #1a7a2e; }
.para-hint { font-size: 0.75rem; color: #888; margin-top: 4px; font-style: italic; }
</style>

<script>
const allTranslations = @json($translations);
const currencySymbols = @json(array_map(fn($c) => $c['symbol'], $currencies));
const flagsMap = {
    'fr': '/images/contract/marianne-flag.png',
    'es': '/images/images%20ent%C3%AAte%20don/image%20copy%206.png',
    'it': '/images/images%20ent%C3%AAte%20don/image%20copy%205.png',
    'de': '/images/images%20ent%C3%AAte%20don/image%20copy%204.png',
    'pt': '/images/armoiries-portugal.png',
    'us': '/images/images%20ent%C3%AAte%20don/image%20copy%208.png',
    'gb': '/images/images%20ent%C3%AAte%20don/image%20copy%207.png',
    'be': '/images/images%20ent%C3%AAte%20don/image%20copy%209.png'
};
const officialFlagsMap = {
    'fr': '/images/contract/marianne-flag.png',
    'es': '/images/images%20ent%C3%AAte%20don/Drapeau%20espagne.jpeg',
    'it': '/images/images%20ent%C3%AAte%20don/drapeau%20italie.png',
    'de': '/images/images%20ent%C3%AAte%20don/drapeau%20allemand.png',
    'pt': '/images/images%20ent%C3%AAte%20don/drapeau%20portugais.png',
    'us': '/images/images%20ent%C3%AAte%20don/drapeau%20USA.png',
    'gb': '/images/images%20ent%C3%AAte%20don/drapeau%20Royaume%20unis.png',
    'be': '/images/images%20ent%C3%AAte%20don/image%20copy%2012.png'
};

document.addEventListener('DOMContentLoaded', () => {
    function updatePreview() {
        const montant   = parseFloat(document.getElementById('montant').value) || 0;
        const devise    = document.getElementById('devise').value;
        const sym       = currencySymbols[devise] || '€';
        
        const donNom    = document.getElementById('donateur_nom').value      || '—';
        const donPre    = document.getElementById('donateur_prenom').value   || '—';
        const donPay    = document.getElementById('donateur_pays').value     || '—';
        const donAdr    = document.getElementById('donateur_adresse').value  || '—';
        const donBan    = '';
        
        const benNom    = document.getElementById('donataire_nom').value     || '—';
        const benPay    = document.getElementById('donataire_pays').value    || '—';
        const benAdr    = document.getElementById('donataire_adresse')?.value || '—';
        
        const lang      = document.getElementById('lang-select').value;
        const t         = allTranslations[lang] || allTranslations['fr'];
        const ville     = document.getElementById('ville-tribunal')?.value || 'Nantes';
        const repName   = document.getElementById('nom-republique')?.value || t.republica_fr;
        const adrNotaire = document.getElementById('adresse-notaire').value || 'domicilié en France à Boulogne-Billancourt';

        // Page 1 Header
        document.getElementById('prev-rep-fr').textContent   = repName;
        document.getElementById('prev-min-jus').textContent  = t.ministerio;
        document.getElementById('prev-human').textContent    = t.derechos;
        document.getElementById('prev-tribunal').textContent = t.tribunal_local.replace(':ville', ville);
        document.getElementById('prev-greffier').textContent = t.secretario;
        document.getElementById('prev-no-lbl').textContent   = t.contrat_no;
        // Générer un numéro simulé pour l'aperçu
        const r = (min, max) => Math.floor(Math.random() * (max - min + 1)) + min;
        if (!document.getElementById('prev-dossier-val').dataset.generated) {
            document.getElementById('prev-dossier-val').textContent =
                r(10,99) + ' ' + r(100,999) + ' - ' + r(100,999) + ' MJLDH / TPIC / EMMQ';
            document.getElementById('prev-dossier-val').dataset.generated = '1';
        }

        // Page 2 Header
        document.getElementById('prev-rep-fr-2').textContent   = repName;
        document.getElementById('prev-min-jus-2').textContent  = t.ministerio;
        document.getElementById('prev-human-2').textContent    = t.derechos;
        document.getElementById('prev-tribunal-2').textContent = t.tribunal_local.replace(':ville', ville);

        // Header logo text
        const logoTextEl = document.getElementById('prev-notaire-logo-text');
        if (logoTextEl) {
            logoTextEl.textContent = t.notario.charAt(0).toUpperCase() + t.notario.slice(1).toLowerCase();
        }

        // Title & Sections
        document.getElementById('prev-titre').textContent    = t.titre_certif;
        document.getElementById('prev-titre-2').textContent  = t.titre_testament;
        document.getElementById('prev-id-don').textContent   = t.donneur;
        document.getElementById('prev-id-ben').textContent   = t.beneficiaire;

        // Labels
        document.querySelectorAll('.prev-lbl-pay').forEach(el => el.textContent = t.pays);
        document.querySelectorAll('.prev-lbl-adr').forEach(el => el.textContent = t.adresse);

        // Notes boxes
        const elAsDon = document.getElementById('prev-as-don'); if (elAsDon) elAsDon.textContent = t.as_donneur;
        const elAsBen = document.getElementById('prev-as-ben'); if (elAsBen) elAsBen.textContent = t.as_beneficiaire;

        // Values
        const donateurFull = (donPre + ' ' + donNom).toUpperCase();
        const donataireFull = benNom.toUpperCase();
        const formattedMontant = montant ? montant.toLocaleString('fr-FR') : '—';
        const sealNotaireVal = (document.getElementById('seal_notaire').value || 'MARIE AIMÉE PEYRON').toUpperCase();

        document.getElementById('prev-val-don-fullname').textContent = donateurFull;
        document.getElementById('prev-val-don-pay').textContent = donPay.toUpperCase();
        document.getElementById('prev-val-don-adr').textContent = donAdr.toUpperCase();
        document.getElementById('prev-val-ben-nom').textContent = donataireFull;
        document.getElementById('prev-val-ben-pay').textContent = benPay.toUpperCase();
        document.getElementById('prev-val-ben-adr').textContent = benAdr.toUpperCase();

        // Flags update on Page 2
        const paysNotaireVal = document.getElementById('pays-notaire-select').value;
        const emblemSrc    = flagsMap[paysNotaireVal] || flagsMap['fr'];
        const officialSrc  = officialFlagsMap[paysNotaireVal] || emblemSrc;
        const leftLogo  = document.getElementById('prev-flag-logo-left');
        const rightLogo = document.getElementById('prev-flag-logo-right');
        leftLogo.src  = officialSrc;
        rightLogo.src = emblemSrc;
        // Pour la France, les deux logos sont identiques → même taille
        if (paysNotaireVal === 'fr') {
            leftLogo.style.maxHeight  = '55px';
            leftLogo.style.maxWidth   = '90px';
            rightLogo.style.maxHeight = '55px';
            rightLogo.style.maxWidth  = '90px';
        } else {
            leftLogo.style.maxHeight  = '42px';
            leftLogo.style.maxWidth   = '60px';
            rightLogo.style.maxHeight = '42px';
            rightLogo.style.maxWidth  = '60px';
        }

        // Signatures Upload Update
        const sigNotUploadData = document.getElementById('sig_image_data')?.value;
        const sigNotSrc = sigNotUploadData || '/images/images entête don/image copy 11.png';
        document.getElementById('prev-sig-notaire-img-1').src = sigNotSrc;
        document.getElementById('prev-sig-notaire-img-2').src = sigNotSrc;

        const sigDonUploadData = document.getElementById('sig_don_image_data')?.value;
        const sigDonSrc = sigDonUploadData || '/images/images entête don/image copy 10.png';
        document.getElementById('prev-sig-donateur-img-1').src = sigDonSrc;
        document.getElementById('prev-sig-donateur-img-2').src = sigDonSrc;

        // Clause Page 1
        let clause = t.clause_sum;
        clause = clause.replace(':montant', formattedMontant);
        clause = clause.replace(':devise', devise);
        clause = clause.replace(':donneur', donateurFull);
        clause = clause.replace(':banque', donBan.toUpperCase());
        document.getElementById('prev-clause-text').textContent = clause;

        // Signature Page 1 Labels & Names
        document.getElementById('prev-sig-lbl-don').textContent = t.donateur;
        document.getElementById('prev-sig-lbl-not').textContent = t.notario;
        document.getElementById('prev-sig-lbl-ben').textContent = t.beneficiaire;
        document.getElementById('prev-sig-val-don').textContent = donateurFull;
        document.getElementById('prev-sig-val-not').textContent = sealNotaireVal;
        document.getElementById('prev-sig-val-ben').textContent = donataireFull;

        // Page 2 - Translations and Replacements
        const terrMap = {
            'fr': { 'fr': 'français', 'es': 'espagnol', 'it': 'italien', 'de': 'allemand', 'pt': 'portugais', 'us': 'américain', 'gb': 'britannique', 'be': 'belge' },
            'en': { 'fr': 'French', 'es': 'Spanish', 'it': 'Italian', 'de': 'German', 'pt': 'Portuguese', 'us': 'American', 'gb': 'British', 'be': 'Belgian' },
            'es': { 'fr': 'francés', 'es': 'español', 'it': 'italiano', 'de': 'alemán', 'pt': 'portugués', 'us': 'estadounidense', 'gb': 'británico', 'be': 'belga' },
            'pt': { 'fr': 'francês', 'es': 'espanhol', 'it': 'italiano', 'de': 'alemão', 'pt': 'português', 'us': 'americano', 'gb': 'britânico', 'be': 'belga' },
            'de': { 'fr': 'französischen', 'es': 'spanischen', 'it': 'italienischen', 'de': 'deutschen', 'pt': 'portugiesischen', 'us': 'amerikanischen', 'gb': 'britischen', 'be': 'belgischen' },
            'it': { 'fr': 'francese', 'es': 'spagnolo', 'it': 'italiano', 'de': 'tedesco', 'pt': 'portoghese', 'us': 'americano', 'gb': 'britannico', 'be': 'belga' },
            'no': { 'fr': 'franske', 'es': 'spanske', 'it': 'italienske', 'de': 'tyske', 'pt': 'portugisiske', 'us': 'amerikanske', 'gb': 'britiske', 'be': 'belgiske' }
        };
        const terr = terrMap[lang]?.[paysNotaireVal] || terrMap['fr']?.[paysNotaireVal] || 'français';

        // Paragraph 1
        let p2Para1 = t.p2_para1 || 'Le dénommé :donneur cède, de façon gratuite...';
        p2Para1 = p2Para1.replace(':donneur', `<strong>${donateurFull}</strong>`);
        p2Para1 = p2Para1.replace(':montant', `<strong>${formattedMontant}</strong>`);
        p2Para1 = p2Para1.replace(':devise', `<strong>${devise}</strong>`);
        p2Para1 = p2Para1.replace(':donataire', `<strong>${donataireFull}</strong>`);
        document.getElementById('prev-p2-para1').innerHTML = p2Para1;

        // Declarations
        document.getElementById('prev-p2-donateur-declare').textContent = t.p2_donateur_declare;
        document.getElementById('prev-p2-bullet1').textContent = t.p2_bullet1;
        document.getElementById('prev-p2-bullet2').textContent = t.p2_bullet2;
        document.getElementById('prev-p2-bullet3').textContent = t.p2_bullet3;

        // Beneficiary acceptances
        document.getElementById('prev-p2-senor').textContent = t.p2_senor;
        document.getElementById('prev-p2-donataire-name-bold').textContent = donataireFull;
        
        let p2Accept1 = t.p2_accept1;
        p2Accept1 = p2Accept1.replace(/(77-995|18\/12\/77|[Aa]rticle\s+4|[Aa]rt[íi]culo\s+4|[Aa]rtigo\s+4)/, '<strong>$1</strong>');
        document.getElementById('prev-p2-accept1').innerHTML = p2Accept1;
        document.getElementById('prev-p2-accept2').textContent = t.p2_accept2;

        // Notary certification
        let p2NotaireCert = t.p2_notaire_certifie || t.p2_legal1;
        p2NotaireCert = p2NotaireCert.replace(':notaire', `<strong>${sealNotaireVal}</strong>`);
        p2NotaireCert = p2NotaireCert.replace(':territoire', terr);
        p2NotaireCert = p2NotaireCert.replace(':adresse', adrNotaire);
        document.getElementById('prev-p2-notaire-certifie').innerHTML = p2NotaireCert;

        // Legal 2 & 3
        document.getElementById('prev-p2-legal2').textContent = t.p2_legal2;
        
        let p2Legal3 = t.p2_legal3;
        p2Legal3 = p2Legal3.replace(':donataire', `<strong>${donataireFull}</strong>`);
        document.getElementById('prev-p2-legal3').innerHTML = p2Legal3;

        // Signature Page 2 Names
        document.getElementById('prev-sig-val-don-2').textContent = donateurFull;
        document.getElementById('prev-sig-val-not-2').textContent = sealNotaireVal;
        document.getElementById('prev-sig-val-ben-2').textContent = donataireFull;
    }

    ['donataire_nom','donataire_pays','donataire_adresse','donateur_nom','donateur_prenom','donateur_pays','donateur_adresse','montant','devise','lang-select','pays-notaire-select',
     'ville-tribunal','nom-republique','seal_label', 'seal_notaire', 'seal_phone', 'seal_title', 'seal_city','adresse-notaire']
        .forEach(id => {
            const el = document.getElementById(id);
            if(el) el.addEventListener('input', updatePreview);
            if(el) el.addEventListener('change', updatePreview);
        });

    // === Signature Donateur ===
    window.previewUploadedSigDon = function(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('sig_don_image_data').value = e.target.result;
                const preview = document.getElementById('sig-don-preview');
                if (preview) preview.src = e.target.result;
                updatePreview();
            };
            reader.readAsDataURL(input.files[0]);
        }
    };

    window.previewUploadedSig = function(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('sig_image_data').value = e.target.result;
                const preview = document.getElementById('sig-not-preview');
                if (preview) preview.src = e.target.result;
                updatePreview();
            };
            reader.readAsDataURL(input.files[0]);
        }
    };

    if (document.getElementById('sig_text')) {
        document.getElementById('sig_text').addEventListener('input', updatePreview);
    }

    updatePreview();

    // Auto-fill champs notaire quand le pays ou la langue change
    const republicNamesAll   = @json($republicNamesAll);
    const capitalCities      = @json($capitalCities);
    const notaireAdressesAll = @json($notaireAdressesAll);
    const paysSelect         = document.getElementById('pays-notaire-select');
    const langSelect         = document.getElementById('lang-select');
    const nomRepInput        = document.getElementById('nom-republique');
    const villeTribInput     = document.getElementById('ville-tribunal');
    const adresseNotInput    = document.getElementById('adresse-notaire');

    function updateNotaireFields() {
        const pays    = paysSelect ? paysSelect.value : 'fr';
        const lang    = langSelect ? langSelect.value : 'fr';
        const names   = republicNamesAll[lang]   || republicNamesAll['fr'];
        const adrs    = notaireAdressesAll[lang] || notaireAdressesAll['fr'];
        if (nomRepInput && names[pays])
            nomRepInput.value = names[pays];
        if (villeTribInput && capitalCities[pays])
            villeTribInput.value = capitalCities[pays];
        if (adresseNotInput && adrs[pays])
            adresseNotInput.value = adrs[pays];
        updatePreview();
    }

    if (paysSelect) paysSelect.addEventListener('change', updateNotaireFields);
    if (langSelect) langSelect.addEventListener('change', updateNotaireFields);

    // --- LOGIQUE DE GÉNÉRATION DU CACHET EN JS POUR L'APERÇU ---
    let currentSealColor = '#1a5ea8';

    window.setSealColor = function(color, btn) {
        currentSealColor = color;
        document.getElementById('seal_color').value = color;
        document.querySelectorAll('.cachet-color').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        generateSealPreview();
    };

    function generateSealPreview() {
        const style = document.querySelector('input[name="seal_style"]:checked').value;
        const canvases = [document.getElementById('seal-canvas'), document.getElementById('prev-seal-canvas')];
        
        // Dynamically style the preview canvas element
        const prevCanvas = document.getElementById('prev-seal-canvas');
        if (prevCanvas) {
            if (style === 'round') {
                prevCanvas.style.width = '42px';
                prevCanvas.style.height = '42px';
                prevCanvas.style.bottom = '12px';
                prevCanvas.style.left = '42px';
                prevCanvas.style.top = 'auto';
            } else {
                prevCanvas.style.width = '71px';
                prevCanvas.style.height = '40px';
                prevCanvas.style.bottom = 'auto';
                prevCanvas.style.left = '8px';
                prevCanvas.style.top = '0px';
            }
        }

        const info = {
            label:   (document.getElementById('seal_label').value || 'CABINET NOTARIAL').toUpperCase(),
            notaire: (document.getElementById('seal_notaire').value || 'MARIE AIMÉE PEYRON').toUpperCase(),
            phone:   document.getElementById('seal_phone').value || '+44 20 7946 0123',
            title:   (document.getElementById('seal_title').value || 'AVOCAT À LA COUR SUPRÊME').toUpperCase(),
            city:    document.getElementById('seal_city').value || 'Londres'
        };

        canvases.forEach(cvs => {
            if (!cvs) return;
            
            if (style === 'round') {
                cvs.width = cvs.height = 180;
            } else {
                cvs.width = 180; cvs.height = 101;
            }

            const ctx = cvs.getContext('2d');
            const info = {
                label:   (document.getElementById('seal_label').value || 'CABINET NOTARIAL').toUpperCase(),
                notaire: (document.getElementById('seal_notaire').value || 'MARIE AIMÉE PEYRON').toUpperCase(),
                phone:   document.getElementById('seal_phone').value || '+44 20 7946 0123',
                title:   (document.getElementById('seal_title').value || 'AVOCAT À LA COUR SUPRÊME').toUpperCase(),
                city:    document.getElementById('seal_city').value || 'Londres'
            };

            const stampUrl = (style === 'round') 
                ? generateRoundStampData(info, currentSealColor)
                : generateRectStampData(info, currentSealColor);

            const img = new Image();
            img.onload = () => {
                ctx.clearRect(0, 0, cvs.width, cvs.height);
                ctx.drawImage(img, 0, 0, cvs.width, cvs.height);
            };
            img.src = stampUrl;
        });
    }

    function generateRoundStampData(info, color) {
        const S = 800, cx = 400, cy = 400;
        const tempCvs = document.createElement('canvas');
        tempCvs.width = tempCvs.height = S;
        const tCtx = tempCvs.getContext('2d');

        tCtx.clearRect(0, 0, S, S);
        tCtx.strokeStyle = color; tCtx.fillStyle = color;

        // Borders
        tCtx.lineWidth = 15;
        tCtx.beginPath(); tCtx.arc(cx, cy, 385, 0, Math.PI * 2); tCtx.stroke();
        tCtx.lineWidth = 6;
        tCtx.beginPath(); tCtx.arc(cx, cy, 370, 0, Math.PI * 2); tCtx.stroke();

        // Side dots
        tCtx.beginPath(); tCtx.arc(60, cy, 9, 0, Math.PI * 2); tCtx.fill();
        tCtx.beginPath(); tCtx.arc(740, cy, 9, 0, Math.PI * 2); tCtx.fill();

        // Icons
        drawPremiumFlourish(tCtx, cx, 65, color, false);
        drawPremiumFlourish(tCtx, cx, 675, color, true);
        drawDetailedScales(tCtx, cx, 225, color);
        drawLaurelWreath(tCtx, cx, 240, color);

        // Texts
        tCtx.textAlign = 'center';
        tCtx.font = 'bold 32px "Times New Roman", serif';
        tCtx.fillText(info.label, cx, 410);
        tCtx.font = 'bold 36px "Times New Roman", serif';
        tCtx.fillText(info.notaire, cx, 470);
        
        tCtx.lineWidth = 2;
        tCtx.beginPath(); tCtx.moveTo(cx - 150, 515); tCtx.lineTo(cx - 20, 515); tCtx.stroke();
        tCtx.beginPath(); tCtx.moveTo(cx + 20, 515); tCtx.lineTo(cx + 150, 515); tCtx.stroke();
        drawDiamond(tCtx, cx, 515, 10, color);

        tCtx.font = '22px "Times New Roman", serif';
        tCtx.fillText(info.title, cx, 565);
        tCtx.font = '26px "Times New Roman", serif';
        tCtx.fillText(info.city, cx, 615);

        drawArcText(tCtx, info.phone, cx, cy, 335, Math.PI * 0.7, Math.PI * 0.3, true);

        return tempCvs.toDataURL('image/png');
    }

    function generateRectStampData(info, color) {
        const W = 800, H = 450;
        const tempCvs = document.createElement('canvas');
        tempCvs.width = W; tempCvs.height = H;
        const tCtx = tempCvs.getContext('2d');

        tCtx.clearRect(0, 0, W, H);
        tCtx.strokeStyle = color; tCtx.fillStyle = color;

        // Borders
        const m = 20;
        tCtx.lineWidth = 12; tCtx.strokeRect(m, m, W - m*2, H - m*2);
        tCtx.lineWidth = 4;  tCtx.strokeRect(m + 18, m + 18, W - (m + 18)*2, H - (m + 18)*2);

        // Corners
        drawCornerOrnament(tCtx, m + 35, m + 35, 0, color);
        drawCornerOrnament(tCtx, W - m - 35, m + 35, Math.PI / 2, color);
        drawCornerOrnament(tCtx, m + 35, H - m - 35, -Math.PI / 2, color);
        drawCornerOrnament(tCtx, W - m - 35, H - m - 35, Math.PI, color);

        // Icons - Removed for rectangular style

        // Texts
        tCtx.textAlign = 'center'; tCtx.textBaseline = 'middle';
        tCtx.font = 'bold 22px "Arial Black", sans-serif';
        tCtx.fillText(info.label, W / 2, m + 60);

        tCtx.font = 'bold 34px "Times New Roman", serif';
        tCtx.fillText(info.notaire, W / 2, H / 2 - 45);

        tCtx.lineWidth = 3;
        tCtx.strokeStyle = color;
        tCtx.beginPath(); tCtx.moveTo(W / 2 - 200, H / 2 + 30); tCtx.lineTo(W / 2 - 30, H / 2 + 30); tCtx.stroke();
        tCtx.beginPath(); tCtx.moveTo(W / 2 + 30, H / 2 + 30); tCtx.lineTo(W / 2 + 200, H / 2 + 30); tCtx.stroke();
        drawDiamond(tCtx, W / 2, H / 2 + 30, 12, color);

        tCtx.font = 'bold 20px Arial';
        tCtx.fillText(info.title, W / 2, H / 2 + 75);
        tCtx.font = 'bold 20px Arial';
        tCtx.fillText(info.city, W / 2, H / 2 + 110);
        tCtx.fillText(info.phone, W / 2, H / 2 + 145);

        return tempCvs.toDataURL('image/png');
    }

    function drawArcText(ctx, text, cx, cy, radius, startAngle, endAngle, standOnArc = false) {
        const chars = text.split('');
        const step = (endAngle - startAngle) / (chars.length - 1);
        ctx.save();
        ctx.font = 'bold 28px Arial';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        chars.forEach((c, i) => {
            const ang = startAngle + (i * step);
            const x = cx + radius * Math.cos(ang);
            const y = cy + radius * Math.sin(ang);
            ctx.save();
            ctx.translate(x, y);
            ctx.rotate(ang + (standOnArc ? -Math.PI / 2 : Math.PI / 2));
            ctx.fillText(c, 0, 0);
            ctx.restore();
        });
        ctx.restore();
    }

    function drawDetailedScales(ctx, x, y, color, scale = 1) {
        ctx.save();
        ctx.translate(x, y);
        ctx.scale(scale, scale);
        ctx.strokeStyle = color; ctx.fillStyle = color;
        ctx.lineWidth = 6;
        ctx.beginPath(); ctx.moveTo(0, 0); ctx.lineTo(0, 100); ctx.stroke();
        ctx.beginPath(); ctx.moveTo(-30, 100); ctx.lineTo(30, 100); ctx.stroke();
        ctx.beginPath(); ctx.moveTo(-100, 20); ctx.lineTo(100, 20); ctx.stroke();
        const drawPan = (px) => {
            ctx.lineWidth = 3;
            ctx.beginPath(); ctx.moveTo(px, 20); ctx.lineTo(px - 40, 80); ctx.stroke();
            ctx.beginPath(); ctx.moveTo(px, 20); ctx.lineTo(px + 40, 80); ctx.stroke();
            ctx.beginPath(); ctx.arc(px, 80, 40, 0, Math.PI, false); ctx.fill();
        };
        drawPan(-100);
        drawPan(100);
        ctx.restore();
    }

    function drawLaurelWreath(ctx, x, y, color, scale = 1) {
        ctx.save();
        ctx.translate(x, y);
        ctx.scale(scale, scale);
        ctx.fillStyle = color;
        const radius = 155;
        const numLeaves = 15;
        for (let i = 0; i < numLeaves; i++) {
            // Left side: from bottom (90) towards top-left (255)
            const angL = (90 + (i * 11)) * (Math.PI / 180);
            const lx = radius * Math.cos(angL);
            const ly = (radius * 0.75) * Math.sin(angL);
            ctx.save();
            ctx.translate(lx, ly);
            ctx.rotate(angL + Math.PI / 2);
            drawLeaf(ctx, color);
            ctx.restore();
            
            // Right side: from bottom (90) towards top-right (-75)
            const angR = (90 - (i * 11)) * (Math.PI / 180);
            const rx = radius * Math.cos(angR);
            const ry = (radius * 0.75) * Math.sin(angR);
            ctx.save();
            ctx.translate(rx, ry);
            ctx.rotate(angR - Math.PI / 2);
            drawLeaf(ctx, color);
            ctx.restore();
        }
        ctx.restore();
    }

    function drawLeaf(ctx, color) {
        const size = 22;
        ctx.beginPath();
        ctx.moveTo(size, 0);
        ctx.lineTo(0, size/2);
        ctx.lineTo(-size/4, 0);
        ctx.lineTo(0, -size/2);
        ctx.closePath();
        ctx.fill();
    }

    function drawPremiumFlourish(ctx, x, y, color, flipped = false) {
        ctx.save();
        ctx.translate(x, y);
        if (flipped) ctx.scale(1, -1);
        ctx.strokeStyle = color; ctx.lineWidth = 4;
        ctx.beginPath(); ctx.moveTo(-120, 0); ctx.bezierCurveTo(-60, -40, 60, -40, 120, 0); ctx.stroke();
        drawDiamond(ctx, 0, -35, 8, color);
        ctx.restore();
    }

    function drawDiamond(ctx, x, y, size, color) {
        ctx.save();
        ctx.translate(x, y);
        ctx.fillStyle = color;
        ctx.beginPath();
        ctx.moveTo(0, -size); ctx.lineTo(size, 0); ctx.lineTo(0, size); ctx.lineTo(-size, 0);
        ctx.closePath(); ctx.fill();
        ctx.restore();
    }

    function drawCornerOrnament(ctx, x, y, rotation, color) {
        ctx.save();
        ctx.translate(x, y);
        ctx.rotate(rotation);
        ctx.strokeStyle = color; ctx.lineWidth = 4;
        ctx.beginPath();
        ctx.moveTo(0, 40); ctx.lineTo(0, 0); ctx.lineTo(40, 0);
        ctx.stroke();
        ctx.beginPath(); ctx.arc(15, 15, 8, 0, Math.PI * 2); ctx.stroke();
        ctx.restore();
    }

    // Update on any seal input
    ['seal_label', 'seal_notaire', 'seal_phone', 'seal_title', 'seal_city'].forEach(id => {
        document.getElementById(id).addEventListener('input', generateSealPreview);
    });
    document.querySelectorAll('input[name="seal_style"]').forEach(el => {
        el.addEventListener('change', generateSealPreview);
    });

    generateSealPreview();
    if (typeof updatePreview === 'function') updatePreview();
});

// ---- Fonctions paragraphes personnalisables ----
const paraKeys = {
    'clause':      'clause_sum',
    'p2para1':     'p2_para1',
    'bullet1':     'p2_bullet1',
    'bullet2':     'p2_bullet2',
    'bullet3':     'p2_bullet3',
    'accept1':     'p2_accept1',
    'accept2':     'p2_accept2',
    'notcertifie': 'p2_notaire_certifie',
    'legal2':      'p2_legal2',
    'legal3':      'p2_legal3',
};

function toggleParasSection() {
    const sec  = document.getElementById('paras-section');
    const chev = document.getElementById('paras-chev');
    const open = sec.style.display === 'none';
    sec.style.display  = open ? 'block' : 'none';
    chev.style.transform = open ? 'rotate(180deg)' : '';
}

function togglePara(key) {
    const bd   = document.getElementById('para-bd-' + key);
    const item = document.getElementById('para-item-' + key);
    const open = bd.style.display === 'none';
    bd.style.display = open ? 'block' : 'none';
    item.classList.toggle('open', open);
}

function resetParagraphs() {
    const lang = document.getElementById('lang-select').value;
    const t    = allTranslations[lang] || allTranslations['fr'];
    Object.entries(paraKeys).forEach(([key, tKey]) => {
        const el = document.getElementById('para-' + key);
        if (el) el.value = t[tKey] || '';
    });
    if (typeof updatePreview === 'function') updatePreview();
}

// Remplir les textareas au chargement et au changement de langue
document.addEventListener('DOMContentLoaded', () => {
    resetParagraphs();
    document.getElementById('lang-select').addEventListener('change', resetParagraphs);
});
</script>

{{-- Historique des certificats de don --}}
@include('tools.partials.contract-history', [
    'contractHistory' => $contractHistory,
    'historyLabel'    => 'certificats de don',
])

@endsection
