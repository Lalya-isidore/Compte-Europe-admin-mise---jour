@extends('layouts.admin')

@section('title', 'Générateur de Contrat de Prêt')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Outils</a></li>
    <li class="breadcrumb-item active">Contrat de Prêt</li>
@endsection

@section('content')
<div class="cp-wrapper">

    {{-- En-tête --}}
    <div class="cp-header">
        <div class="cp-header__icon">
            <i class="fas fa-file-contract"></i>
        </div>
        <div>
            <h1 class="cp-header__title">Générateur de Contrat de Prêt</h1>
            <p class="cp-header__sub">Remplissez les informations ci-dessous pour générer un contrat PDF professionnel</p>
        </div>
    </div>

    <form action="{{ route('tools.contrat-pret.generate') }}" method="POST" id="cp-form" enctype="multipart/form-data">
        @csrf
        <div class="cp-grid">

            {{-- ======== COLONNE GAUCHE : Formulaire ======== --}}
            <div class="cp-col">

                {{-- Langue --}}
                <div class="cp-card">
                    <div class="cp-card__head"><i class="fas fa-language"></i> Langue du contrat</div>
                    <div class="cp-card__body">
                        <div class="lang-pills">
                            @foreach(['fr' => '🇫🇷 Français', 'en' => '🇬🇧 Anglais', 'es' => '🇪🇸 Espagnol', 'pt' => '🇵🇹 Portugais', 'de' => '🇩🇪 Allemand', 'it' => '🇮🇹 Italien', 'nl' => '🇳🇱 Néerlandais', 'pl' => '🇵🇱 Polonais', 'hr' => '🇭🇷 Croate', 'ru' => '🇷🇺 Russe'] as $code => $label)
                                <label class="lang-pill {{ $code === 'fr' ? 'active' : '' }}">
                                    <input type="radio" name="lang" value="{{ $code }}" {{ $code === 'fr' ? 'checked' : '' }}>
                                    {{ $label }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Emprunteur --}}
                <div class="cp-card">
                    <div class="cp-card__head"><i class="fas fa-user"></i> L'Emprunteur (Bénéficiaire)</div>
                    <div class="cp-card__body">
                        <div class="cp-row2">
                            <div class="cp-field">
                                <label>Nom complet <span class="req">*</span></label>
                                <input type="text" name="emprunteur_nom" id="emprunteur_nom" placeholder="Ex: Jean Dupont" required>
                            </div>
                            <div class="cp-field">
                                <label>Pays de résidence <span class="req">*</span></label>
                                <input type="text" name="emprunteur_pays" id="emprunteur_pays" placeholder="Ex: France" required>
                            </div>
                        </div>
                        <div class="cp-row2" style="margin-top: 14px;">
                            <div class="cp-field">
                                <label>Identifiant / Numéro de client <small>(optionnel)</small></label>
                                <input type="text" name="emprunteur_id" id="emprunteur_id" placeholder="Ex: CLI-00142">
                            </div>
                            <div class="cp-field">
                                <label>Numéro du contrat <small>(optionnel — auto si vide)</small></label>
                                <input type="text" name="contract_no" id="contract_no" placeholder="Ex: LAL-2026-1234">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Prêteur --}}
                <div class="cp-card">
                    <div class="cp-card__head"><i class="fas fa-building"></i> Le Prêteur</div>
                    <div class="cp-card__body">
                        <div class="cp-row2">
                            <div class="cp-field">
                                <label>Nom / Raison sociale <span class="req">*</span></label>
                                <input type="text" name="preteur_nom" id="preteur_nom" placeholder="Ex: Marcelo Rodriguez" value="Marcelo Rodriguez" required>
                            </div>
                            <div class="cp-field">
                                <label>Pays <span class="req">*</span></label>
                                <input type="text" name="preteur_pays" id="preteur_pays" placeholder="Ex: Espagne" value="Espagne" required>
                            </div>
                        </div>
                        <div class="cp-field" style="margin-top: 14px;">
                            <label>Adresse complète <span class="req">*</span></label>
                            <input type="text" name="preteur_adresse" id="preteur_adresse" placeholder="Ex: Calle de la Princesa, 25, 28008 Madrid" value="Calle de la Princesa, 25, 28008 Madrid" required>
                        </div>
                        <div class="cp-row2" style="margin-top: 14px;">
                            <div class="cp-field">
                                <label>Référence / ID <span class="req">*</span></label>
                                <input type="text" name="preteur_id" id="preteur_id" placeholder="Ex: CIF: B87654321" value="CIF: B87654321" required>
                            </div>
                            <div class="cp-field">
                                <label>Capacité / Titre <span class="req">*</span></label>
                                <input type="text" name="preteur_capacite" id="preteur_capacite" placeholder="Ex: Investisseur Privé" value="Investisseur Privé" required>
                            </div>
                        </div>
                        <div class="cp-field" style="margin-top: 14px;">
                            <label>Signature / Cachet du prêteur <small>(optionnel — image PNG/JPG)</small></label>
                            <input type="file" name="signature_preteur" id="signature_preteur" accept="image/png,image/jpeg,image/jpg" style="padding: 6px;">
                            <input type="hidden" name="signature_preteur_data" id="signature_preteur_data">
                            <div id="sig-pre-wrap" style="display:none; margin-top:8px;">
                                <img id="sig-pre-img" src="" alt="Signature prêteur" style="max-height:70px; max-width:200px; border-radius:4px; padding:4px; background: repeating-conic-gradient(#ccc 0% 25%, #fff 0% 50%) 0 0 / 12px 12px;">
                                <div style="font-size:10px; color:#666; margin-top:4px;"><i class="fas fa-magic"></i> Fond blanc supprimé automatiquement</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Conditions du prêt --}}
                <div class="cp-card">
                    <div class="cp-card__head"><i class="fas fa-euro-sign"></i> Conditions du prêt</div>
                    <div class="cp-card__body">
                        <div class="cp-row2">
                            <div class="cp-field">
                                <label>Montant du prêt <span class="req">*</span></label>
                                <input type="number" name="montant" id="montant" placeholder="Ex: 15000" min="1" step="0.01" required>
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
                        <div class="cp-row2" style="margin-top: 14px;">
                            <div class="cp-field">
                                <label>Taux d'intérêt annuel (%) <span class="req">*</span></label>
                                <input type="number" name="taux" id="taux" placeholder="Ex: 5.5" min="0" max="100" step="0.01" value="5.5" required>
                            </div>
                            <div class="cp-field">
                                <label>Durée (mois) <span class="req">*</span></label>
                                <input type="number" name="duree" id="duree" placeholder="Ex: 24" min="1" max="360" step="1" value="24" required>
                            </div>
                        </div>

                        {{-- Calcul automatique --}}
                        <div class="cp-calc" id="cp-calc" style="display:none;">
                            <div class="cp-calc__item">
                                <span>Mensualité estimée</span>
                                <strong id="calc-mensualite">—</strong>
                            </div>
                            <div class="cp-calc__item">
                                <span>Total à rembourser</span>
                                <strong id="calc-total">—</strong>
                            </div>
                            <div class="cp-calc__item">
                                <span>Coût du crédit</span>
                                <strong id="calc-cout">—</strong>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Articles personnalisables --}}
                <div class="cp-card">
                    <div class="cp-card__head cp-card__head--toggle" onclick="toggleArtsSection()">
                        <i class="fas fa-edit"></i> Articles du contrat
                        <small style="font-weight:normal; margin-left:8px; opacity:0.7;">Modifiez ou supprimez des articles</small>
                        <i class="fas fa-chevron-down" id="arts-chev" style="margin-left:auto; transition:transform 0.2s;"></i>
                    </div>
                    <div id="arts-section" style="display:none;">
                        <div class="cp-card__body" style="padding-top:10px;">
                            <button type="button" onclick="resetArticles()" class="cp-btn-reset">
                                <i class="fas fa-sync-alt"></i> Réinitialiser depuis la langue sélectionnée
                            </button>
                            <div id="arts-container" style="margin-top:12px;">
                                @foreach(range(1,10) as $n)
                                <div class="art-item" id="art-item-{{ $n }}">
                                    <div class="art-item__hd" onclick="toggleArt({{ $n }})">
                                        <span class="art-item__badge">{{ $n }}</span>
                                        <input type="text" name="articles[{{ $n }}][titre]" id="art-{{ $n }}-titre"
                                               class="art-titre-inp" placeholder="Titre article {{ $n }}"
                                               onclick="event.stopPropagation()">
                                        <button type="button" class="art-del-btn" title="Supprimer cet article"
                                                onclick="deleteArticle({{ $n }}); event.stopPropagation();">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <i class="fas fa-chevron-down art-chev" id="art-chev-{{ $n }}"></i>
                                    </div>
                                    <div class="art-item__bd" id="art-bd-{{ $n }}" style="display:none;">
                                        <textarea name="articles[{{ $n }}][corps]" id="art-{{ $n }}-corps"
                                                  class="art-corps-inp" rows="5"
                                                  placeholder="Contenu de l'article..."></textarea>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="cp-btn-generate">
                    <i class="fas fa-file-pdf"></i>
                    Générer et Télécharger le Contrat PDF
                </button>

            </div>

            {{-- ======== COLONNE DROITE : Aperçu ======== --}}
            <div class="cp-col cp-col--preview">
                <div class="cp-card">
                    <div class="cp-card__head"><i class="fas fa-eye"></i> Aperçu du contrat</div>
                    <div class="cp-preview">
                        <div class="cp-preview__doc">
                            {{-- En-tête 3 colonnes identique au PDF --}}
                            <table class="prev-hdr-table">
                                <tr>
                                    <td class="prev-hdr-left">
                                        <img src="/images/contract/logo-ue.png" class="prev-hdr-img">
                                        <div id="prev-union-eu" class="prev-hdr-txt-blue">UNION EUROPÉENNE</div>
                                        <span class="prev-hdr-sep">_._._._._._</span>
                                        <div id="prev-service-justice" class="prev-hdr-txt-blue" style="font-size:7px;">SERVICE DE JUSTICE ET DROITS HUMAINS</div>
                                        <span class="prev-hdr-sep">_._._</span>
                                        <div id="prev-tribunal" class="prev-hdr-txt-blue" style="font-size:7px;">TRIBUNAL EUROPÉEN DE PREMIÈRE INSTANCE</div>
                                    </td>
                                    <td class="prev-hdr-center">
                                        <div class="prev-title-wrap">
                                            <div class="prev-title" id="prev-titre">CONTRAT DE PRÊT</div>
                                        </div>
                                    </td>
                                    <td class="prev-hdr-right">
                                        <img src="/images/contract/logo-justice.jpg" class="prev-hdr-img">
                                        <div id="prev-registre" class="prev-hdr-txt-red">REGISTRE DU TRIBUNAL</div>
                                        <div id="prev-coordination" class="prev-hdr-txt-navy">Service de coordination judiciaire</div>
                                        <span class="prev-hdr-sep">_o_o_o_o_o_</span>
                                        <div class="prev-contract-no" id="prev-no">CONTRAT N° —/{{ date('Y') }}</div>
                                    </td>
                                </tr>
                            </table>

                            <div class="prev-subtitle" id="prev-soussignes">— ENTRE LES SOUSSIGNÉS —</div>

                            <div class="prev-parties">
                                <div class="prev-party">
                                    <div class="prev-party__label" id="prev-label-preteur">LE PRÊTEUR</div>
                                    <div class="prev-party__name" id="prev-preteur-nom">—</div>
                                    <table class="prev-party__tbl">
                                        <tr><td class="prev-party__key" id="prev-lbl-pays-p">Pays :</td><td id="prev-preteur-pays">—</td></tr>
                                        <tr><td class="prev-party__key" id="prev-lbl-adresse">Adresse :</td><td id="prev-preteur-adresse">—</td></tr>
                                        <tr><td class="prev-party__key">ID :</td><td id="prev-preteur-id">—</td></tr>
                                        <tr><td class="prev-party__key" id="prev-lbl-capacite">Capacité :</td><td id="prev-preteur-capacite">—</td></tr>
                                    </table>
                                    <div class="prev-party__denom" id="prev-denom-preteur">Ci-après dénommé "Le Prêteur"</div>
                                </div>
                                <div class="prev-party">
                                    <div class="prev-party__label" id="prev-label-benef">LE BÉNÉFICIAIRE</div>
                                    <div class="prev-party__name" id="prev-emprunteur-nom">—</div>
                                    <table class="prev-party__tbl">
                                        <tr><td class="prev-party__key" id="prev-lbl-pays-e">Pays :</td><td id="prev-emprunteur-pays">—</td></tr>
                                        <tr id="prev-emp-id-row" style="display:none;"><td class="prev-party__key" id="prev-lbl-cid">Client ID :</td><td id="prev-emprunteur-id">—</td></tr>
                                    </table>
                                    <div class="prev-party__denom" id="prev-denom-empr">Ci-après dénommé "L'Emprunteur"</div>
                                </div>
                            </div>

                            <div class="prev-articles" id="prev-articles">
                                @foreach(range(1,10) as $n)
                                <div class="prev-article">
                                    <div class="prev-art-title" id="prev-art{{ $n }}-titre">—</div>
                                    <div class="prev-art-body"  id="prev-art{{ $n }}-body">—</div>
                                    @if($n === 2)
                                    <div class="prev-table" style="margin-top: 8px;">
                                        <table>
                                            <tr><td id="prev-lbl-montant-p">Montant principal</td><td id="prev-montant">—</td></tr>
                                            <tr><td id="prev-lbl-taux">Taux d'intérêt</td><td id="prev-taux">—</td></tr>
                                            <tr><td id="prev-lbl-duree">Durée</td><td id="prev-duree">—</td></tr>
                                            <tr class="highlight"><td id="prev-lbl-mensualite">Mensualité</td><td id="prev-mensualite">—</td></tr>
                                        </table>
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>

                            <div class="prev-sig">
                                <div class="prev-sig__left">
                                    <div class="prev-sig__label" id="prev-lbl-emprunteur">L'Emprunteur :</div>
                                    <div class="prev-sig__img-wrap">
                                        <img id="prev-sig-emp-img" src="" alt="" style="display:none; max-height:55px; max-width:150px;">
                                    </div>
                                    <div class="prev-sig__line"></div>
                                    <div class="prev-sig__name" id="prev-sig-emprunteur">—</div>
                                    <div class="prev-sig__title" id="prev-lbl-benef-legal">Bénéficiaire légal du prêt</div>
                                </div>
                                <div class="prev-sig__mid"></div>
                                <div class="prev-sig__right">
                                    <div class="prev-sig__date" id="prev-sig-date">Fait à —, le {{ date('d/m/Y') }}</div>
                                    <div class="prev-sig__label" id="prev-lbl-preteur-rep">Le Prêteur représenté par :</div>
                                    <div class="prev-sig__img-wrap" style="text-align:right;">
                                        <img id="prev-sig-pre-img" src="/images/contract/cachet-signature.jpg" alt="Cachet" style="max-height:70px; max-width:170px; margin-left:auto; display:block;">
                                    </div>
                                    <div class="prev-sig__line"></div>
                                    <div class="prev-sig__name" id="prev-sig-preteur">—</div>
                                    <div class="prev-sig__title" id="prev-sig-preteur-cap">—</div>
                                </div>
                            </div>

                            <div class="prev-important" id="prev-important-txt">
                                IMPORTANT : CE CONTRAT DOIT ÊTRE IMPRIMÉ, DATÉ ET SIGNÉ PAR L'EMPRUNTEUR AFIN DE DÉCLENCHER LE VIREMENT DES FONDS SUR LE COMPTE BANCAIRE DÉSIGNÉ.
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Info langues disponibles --}}
                <div class="cp-info-box">
                    <i class="fas fa-info-circle"></i>
                    <div>
                        <strong>10 langues disponibles :</strong> Français, Anglais, Espagnol, Portugais, Allemand, Italien, Néerlandais, Polonais, Croate, Russe.
                        Le contrat PDF sera généré intégralement dans la langue choisie.
                    </div>
                </div>

                {{-- Contenu du contrat --}}
                <div class="cp-info-box cp-info-box--blue">
                    <i class="fas fa-file-alt"></i>
                    <div>
                        <strong>10 articles inclus :</strong> Objet, Remboursement, Conditions crédit, Cartes, Paiement anticipé, Juridiction, Remboursement anticipé, Retards, Garantie, Signature.
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<style>
.cp-wrapper { max-width: 1200px; margin: 0 auto; }
.cp-header { display: flex; align-items: center; gap: 18px; margin-bottom: 28px; padding: 20px 24px; background: linear-gradient(135deg, #1e3a5f 0%, #2d5986 100%); border-radius: 14px; color: #fff; }
.cp-header__icon { width: 52px; height: 52px; background: rgba(255,255,255,0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0; }
.cp-header__title { font-size: 1.25rem; font-weight: 700; margin: 0; }
.cp-header__sub { font-size: 0.82rem; opacity: 0.75; margin: 4px 0 0; }

.cp-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; align-items: start; }
.cp-col { display: flex; flex-direction: column; gap: 18px; }

.cp-card { background: #fff; border: 1px solid #e8e8e8; border-radius: 12px; overflow: hidden; }
.cp-card__head { padding: 13px 18px; background: #f8f9fb; border-bottom: 1px solid #eee; font-size: 0.88rem; font-weight: 600; color: #334; display: flex; align-items: center; gap: 8px; }
.cp-card__head i { color: #1e3a5f; }
.cp-card__body { padding: 18px; }

.lang-pills { display: flex; flex-wrap: wrap; gap: 8px; }
.lang-pill { display: flex; align-items: center; gap: 6px; padding: 7px 14px; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; font-size: 0.83rem; font-weight: 500; color: #555; transition: all 0.2s; }
.lang-pill:hover { border-color: #1e3a5f; color: #1e3a5f; }
.lang-pill.active { border-color: #1e3a5f; background: #1e3a5f; color: #fff; }
.lang-pill input { display: none; }

.cp-row2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.cp-field { display: flex; flex-direction: column; gap: 5px; }
.cp-field label { font-size: 0.8rem; font-weight: 600; color: #555; }
.cp-field input, .cp-field select { border: 1px solid #ddd; border-radius: 8px; padding: 9px 12px; font-size: 0.88rem; color: #333; outline: none; transition: border-color 0.2s; background: #fff; }
.cp-field input:focus, .cp-field select:focus { border-color: #1e3a5f; box-shadow: 0 0 0 3px rgba(30,58,95,0.08); }
.req { color: #e53e3e; }
.cp-field small { color: #999; font-size: 0.72rem; }

.cp-calc { margin-top: 16px; background: #f0f7ff; border: 1px solid #c0d8f5; border-radius: 10px; padding: 14px; display: flex; gap: 12px; }
.cp-calc__item { flex: 1; text-align: center; }
.cp-calc__item span { font-size: 0.72rem; color: #666; display: block; margin-bottom: 4px; }
.cp-calc__item strong { font-size: 0.95rem; color: #1e3a5f; font-weight: 700; }

.cp-card__head--toggle { cursor: pointer; user-select: none; }
.cp-btn-reset { padding: 7px 14px; background: #f3f4f6; color: #374151; border: 1px solid #d1d5db; border-radius: 7px; font-size: 0.82rem; cursor: pointer; display: flex; align-items: center; gap: 6px; }
.cp-btn-reset:hover { background: #e5e7eb; }
.art-item { border: 1px solid #e5e7eb; border-radius: 8px; margin-bottom: 7px; overflow: hidden; transition: opacity 0.2s; }
.art-item.deleted { display: none; }
.art-item__hd { display: flex; align-items: center; gap: 8px; padding: 9px 12px; background: #f9fafb; cursor: pointer; }
.art-item__badge { background: #1e3a5f; color: #fff; border-radius: 50%; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; font-size: 0.73rem; font-weight: bold; flex-shrink: 0; }
.art-titre-inp { flex: 1; border: 1px solid #ddd; border-radius: 6px; padding: 5px 9px; font-size: 0.83rem; font-weight: 600; color: #1e3a5f; min-width: 0; }
.art-titre-inp:focus { outline: none; border-color: #4B0082; }
.art-del-btn { background: #fee2e2; color: #dc2626; border: none; border-radius: 6px; width: 28px; height: 28px; cursor: pointer; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 0.75rem; }
.art-del-btn:hover { background: #fca5a5; }
.art-chev { color: #aaa; font-size: 0.72rem; flex-shrink: 0; transition: transform 0.2s; }
.art-item.open .art-chev { transform: rotate(180deg); }
.art-item__bd { padding: 0 12px 12px; background: #fff; }
.art-corps-inp { width: 100%; border: 1px solid #ddd; border-radius: 6px; padding: 9px; font-size: 0.82rem; line-height: 1.6; color: #333; resize: vertical; font-family: 'Times New Roman', serif; box-sizing: border-box; margin-top: 8px; }
.art-corps-inp:focus { outline: none; border-color: #4B0082; }

.cp-btn-generate { width: 100%; padding: 14px; background: linear-gradient(135deg, #1e3a5f, #2d5986); color: #fff; border: none; border-radius: 10px; font-size: 0.95rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; transition: all 0.2s; }
.cp-btn-generate:hover { background: linear-gradient(135deg, #162e4d, #244a72); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(30,58,95,0.3); }
.cp-btn-generate i { font-size: 1.1rem; }

/* Aperçu */
.cp-col--preview .cp-card { position: sticky; top: 80px; }
.cp-preview { padding: 16px; background: #f5f5f5; }
.cp-preview__doc { background: #fff; border: 1px solid #ddd; border-radius: 6px; padding: 24px; font-family: 'Times New Roman', serif; font-size: 14px; color: #222; box-shadow: 0 2px 8px rgba(0,0,0,0.08); min-height: 400px; }

.prev-hdr-table { width: 100%; border-collapse: collapse; border-bottom: 2px double #002B5B; margin-bottom: 12px; }
.prev-hdr-table td { vertical-align: top; padding-bottom: 10px; }
.prev-hdr-left { width: 25%; text-align: center; }
.prev-hdr-center { width: 50%; text-align: center; vertical-align: middle !important; padding-top: 4px; }
.prev-hdr-right { width: 25%; text-align: center; }
.prev-hdr-img { height: 38px; width: auto; display: block; margin: 0 auto 4px; }
.prev-hdr-img-c { height: 32px; width: auto; display: block; margin: 0 auto 8px; }
.prev-hdr-txt-blue { font-size: 8px; font-weight: bold; color: #003399; line-height: 1.3; }
.prev-hdr-txt-red { font-size: 8px; font-weight: bold; color: #8B0000; line-height: 1.3; }
.prev-hdr-txt-navy { font-size: 7px; font-weight: bold; color: #002B5B; }
.prev-hdr-sep { font-size: 6px; color: #999; display: block; line-height: 1.2; }
.prev-title-wrap { border: 2px solid #4B0082; display: inline-block; padding: 5px 12px; border-radius: 6px; background: rgba(75,0,130,0.03); }
.prev-title { font-size: 15px; font-weight: bold; color: #4B0082; white-space: nowrap; }
.prev-contract-no { font-size: 9px; color: #d00; font-weight: bold; margin-top: 3px; }

.prev-subtitle { text-align: center; font-size: 13px; font-style: italic; font-weight: bold; text-decoration: underline; margin: 10px 0 14px; }

.prev-parties { display: flex; gap: 10px; margin-bottom: 14px; }
.prev-party { flex: 1; border: 1px solid #e2e8f0; border-radius: 4px; padding: 10px; background: #f8fafc; }
.prev-party__label { font-size: 11px; font-weight: bold; color: #002B5B; text-decoration: underline; margin-bottom: 6px; }
.prev-party__name { font-size: 13px; font-weight: bold; margin-bottom: 6px; }
.prev-party__tbl { width: 100%; border-collapse: collapse; }
.prev-party__tbl td { border: none; padding: 1px 0; font-size: 10px; vertical-align: top; }
.prev-party__key { font-weight: bold; color: #4a5568; padding-right: 5px; white-space: nowrap; width: 65px; }
.prev-party__denom { font-style: italic; font-size: 10px; color: #555; margin-top: 6px; }

.prev-table { margin-bottom: 14px; }
.prev-table__title { font-size: 12px; font-weight: bold; color: #002B5B; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 7px; }
.prev-table table { width: 100%; border-collapse: collapse; font-size: 12px; }
.prev-table td { padding: 5px 8px; border: 1px solid #e0e0e0; }
.prev-table tr td:first-child { font-weight: 500; color: #444; }
.prev-table tr td:last-child { text-align: right; font-weight: bold; color: #1e3a5f; }
.prev-table tr.highlight td { background: #edf2f7; color: #002B5B; font-weight: bold; }

.prev-articles { margin-bottom: 14px; }
.prev-article { border-bottom: 1px solid #e8e8e8; padding: 6px 0; }
.prev-art-title { font-size: 12px; color: #002B5B; font-weight: bold; margin-bottom: 3px; }
.prev-art-body { font-size: 11px; color: #444; line-height: 1.5; }

.prev-sig { display: flex; gap: 10px; margin-bottom: 10px; padding-top: 10px; border-top: 1px solid #eee; }
.prev-sig__left { flex: 0 0 38%; }
.prev-sig__mid  { flex: 1; }
.prev-sig__right { flex: 0 0 38%; text-align: right; }
.prev-sig__label { font-size: 10px; color: #555; margin-bottom: 4px; }
.prev-sig__img-wrap { min-height: 55px; display: flex; align-items: flex-end; margin-bottom: 2px; }
.prev-sig__date  { font-size: 9px; color: #333; margin-bottom: 4px; text-align: right; }
.prev-sig__line  { height: 28px; border-bottom: 1px solid #333; margin-bottom: 4px; }
.prev-sig__name  { font-size: 11px; font-weight: bold; }
.prev-sig__title { font-style: italic; font-size: 9px; color: #666; margin-top: 2px; }

.prev-important { font-size: 11px; font-weight: bold; color: #003399; border: 1px dashed #003399; background: #f0f7ff; padding: 8px; border-radius: 4px; text-align: center; }

.cp-info-box { display: flex; align-items: flex-start; gap: 12px; padding: 14px 16px; background: #f0fdf4; border: 1px solid #86efac; border-radius: 10px; font-size: 0.82rem; color: #166534; }
.cp-info-box i { margin-top: 2px; flex-shrink: 0; }
.cp-info-box--blue { background: #eff6ff; border-color: #93c5fd; color: #1e40af; }

@media (max-width: 900px) {
    .cp-grid { grid-template-columns: 1fr; }
    .cp-col--preview .cp-card { position: static; }
    .cp-row2 { grid-template-columns: 1fr; }
}
</style>

<script>
const allTranslations = @json($translations);

document.addEventListener('DOMContentLoaded', () => {
    const langTitles = { fr: 'CONTRAT DE PRÊT', en: 'LOAN CONTRACT', es: 'CONTRATO DE PRÉSTAMO', pt: 'CONTRATO DE EMPRÉSTIMO', de: 'DARLEHENSVERTRAG', it: 'CONTRATTO DI PRESTITO', nl: 'LENINGSOVEREENKOMST', pl: 'UMOWA POŻYCZKI', hr: 'UGOVOR O ZAJMU', ru: 'КРЕДИТНЫЙ ДОГОВОР' };
    const currencySymbols = {
        EUR: '€', USD: '$', GBP: '£', CHF: 'Fr', CAD: 'CA$', XOF: 'F CFA', MAD: 'د.م.', TND: 'DT', DZD: 'DA'
    };

    const articleBodies = [
        (t, montant, sym, duree) => t.art1_p1a + ' ' + (montant > 0 ? montant.toLocaleString('fr-FR') + ' ' + sym : '—') + '. ' + (t.art1_p1b || ''),
        (t, montant, sym, duree) => t.art2_intro + ' ' + (duree > 0 ? duree + ' ' + t.mois : '—') + '. ' + (t.art2_suite || ''),
        (t) => t.art3_p1 || '',
        (t) => (t.observation || '') + ' ' + (t.art4_p1 || ''),
        (t) => t.art5_p1 || '',
        (t) => t.art6_p1 || '',
        (t) => t.art7_p1 || '',
        (t) => t.art8_p1 || '',
        (t) => t.art9_p1 || '',
        (t) => t.art10_p1 || '',
    ];

    function fmt(n, sym) {
        return new Intl.NumberFormat('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(n) + ' ' + sym;
    }

    function updatePreview() {
        const montant   = parseFloat(document.getElementById('montant').value) || 0;
        const taux      = parseFloat(document.getElementById('taux').value)    || 0;
        const duree     = parseInt(document.getElementById('duree').value)     || 0;
        const devise    = document.getElementById('devise').value;
        const sym       = currencySymbols[devise] || '€';
        const empNom    = document.getElementById('emprunteur_nom').value    || '—';
        const empPays   = document.getElementById('emprunteur_pays').value   || '—';
        const empId     = document.getElementById('emprunteur_id').value     || '';
        const preNom    = document.getElementById('preteur_nom').value       || '—';
        const prePays   = document.getElementById('preteur_pays').value      || '—';
        const preAdr    = document.getElementById('preteur_adresse').value   || '—';
        const preId     = document.getElementById('preteur_id').value        || '—';
        const preCap    = document.getElementById('preteur_capacite').value  || '—';
        const lang       = document.querySelector('input[name="lang"]:checked')?.value || 'fr';
        const contractNo = document.getElementById('contract_no').value.trim();
        const t          = allTranslations[lang] || allTranslations['fr'];

        // Numéro de contrat
        document.getElementById('prev-no').textContent = (t.contrat_no || 'CONTRAT N°') + ' ' + (contractNo || '—') + '/{{ date("Y") }}';

        // En-tête
        document.getElementById('prev-titre').textContent         = langTitles[lang] || langTitles.fr;
        document.getElementById('prev-union-eu').textContent      = t.union_eu       || 'UNION EUROPÉENNE';
        document.getElementById('prev-service-justice').textContent = t.service_justice || 'SERVICE DE JUSTICE ET DROITS HUMAINS';
        document.getElementById('prev-tribunal').textContent      = t.tribunal       || 'TRIBUNAL EUROPÉEN DE PREMIÈRE INSTANCE';
        document.getElementById('prev-registre').textContent      = t.registre       || 'REGISTRE DU TRIBUNAL';
        document.getElementById('prev-coordination').textContent  = t.coordination   || 'Service de coordination judiciaire';
        document.getElementById('prev-soussignes').textContent    = '— ' + (t.soussignes || 'ENTRE LES SOUSSIGNÉS') + ' —';

        // Labels tableau article 2
        document.getElementById('prev-lbl-montant-p').textContent  = t.montant_p    || 'Montant principal';
        document.getElementById('prev-lbl-taux').textContent       = t.taux_label   || 'Taux d\'intérêt';
        document.getElementById('prev-lbl-duree').textContent      = t.nb_echeances || 'Durée';
        document.getElementById('prev-lbl-mensualite').textContent = t.mensualite   || 'Mensualité';

        // Labels parties
        document.getElementById('prev-label-preteur').textContent = t.le_preteur     || 'LE PRÊTEUR';
        document.getElementById('prev-label-benef').textContent   = t.beneficiaire   || 'LE BÉNÉFICIAIRE';
        document.getElementById('prev-lbl-pays-p').textContent    = t.pays           || 'Pays :';
        document.getElementById('prev-lbl-adresse').textContent   = t.adresse        || 'Adresse :';
        document.getElementById('prev-lbl-capacite').textContent  = t.capacite       || 'Capacité :';
        document.getElementById('prev-lbl-pays-e').textContent    = t.pays           || 'Pays :';
        document.getElementById('prev-denom-preteur').textContent = t.denom_preteur  || 'Ci-après dénommé "Le Prêteur"';
        document.getElementById('prev-denom-empr').textContent    = t.denom_empr     || 'Ci-après dénommé "L\'Emprunteur"';

        // Données prêteur
        document.getElementById('prev-preteur-nom').textContent      = preNom.toUpperCase();
        document.getElementById('prev-preteur-pays').textContent     = prePays;
        document.getElementById('prev-preteur-adresse').textContent  = preAdr;
        document.getElementById('prev-preteur-id').textContent       = preId;
        document.getElementById('prev-preteur-capacite').textContent = preCap;

        // Données emprunteur
        document.getElementById('prev-emprunteur-nom').textContent  = empNom.toUpperCase();
        document.getElementById('prev-emprunteur-pays').textContent = empPays;
        const empIdRow = document.getElementById('prev-emp-id-row');
        if (empId) {
            document.getElementById('prev-emprunteur-id').textContent = empId;
            document.getElementById('prev-lbl-cid').textContent = t.client_id || 'Client ID :';
            empIdRow.style.display = '';
        } else {
            empIdRow.style.display = 'none';
        }

        // Signatures
        document.getElementById('prev-lbl-emprunteur').textContent  = t.l_emprunteur  || 'L\'Emprunteur :';
        document.getElementById('prev-lbl-benef-legal').textContent = t.benef_legal   || 'Bénéficiaire légal du prêt';
        document.getElementById('prev-lbl-preteur-rep').textContent = t.preteur_rep   || 'Le Prêteur représenté par :';
        document.getElementById('prev-sig-date').textContent        = (t.fait_a || 'Fait à') + ' ' + prePays + ', ' + (t.le || 'le') + ' {{ date("d/m/Y") }}';
        document.getElementById('prev-sig-emprunteur').textContent  = empNom !== '—' ? (t.civilite || 'M./Mme') + ' ' + empNom.toUpperCase() : '—';
        document.getElementById('prev-sig-preteur').textContent     = preNom.toUpperCase();
        document.getElementById('prev-sig-preteur-cap').textContent = preCap;
        document.getElementById('prev-important-txt').textContent   = t.important || 'IMPORTANT : CE CONTRAT DOIT ÊTRE IMPRIMÉ, DATÉ ET SIGNÉ PAR L\'EMPRUNTEUR AFIN DE DÉCLENCHER LE VIREMENT DES FONDS SUR LE COMPTE BANCAIRE DÉSIGNÉ.';

        // Contenu des articles (custom ou défaut)
        const artTitleKeys = ['art1_titre','art2_titre','art3_titre','art4_titre','art5_titre','art6_titre','art7_titre','art8_titre','art9_titre','art10_titre'];
        for (let i = 0; i < 10; i++) {
            const n       = i + 1;
            const artItem = document.getElementById('art-item-' + n);
            const prevArt = document.getElementById('prev-art' + n + '-titre')?.closest('.prev-article');
            const titleEl = document.getElementById('prev-art' + n + '-titre');
            const bodyEl  = document.getElementById('prev-art' + n + '-body');
            if (artItem && artItem.classList.contains('deleted')) {
                if (prevArt) prevArt.style.display = 'none';
                continue;
            }
            if (prevArt) prevArt.style.display = '';
            const custTitre = document.getElementById('art-' + n + '-titre')?.value.trim() || '';
            const custCorps = document.getElementById('art-' + n + '-corps')?.value.trim() || '';
            if (titleEl) titleEl.textContent = custTitre || t[artTitleKeys[i]] || '—';
            if (bodyEl) {
                const full = custCorps || articleBodies[i](t, montant, sym, duree);
                bodyEl.textContent = full;
            }
        }

        // Calculs
        if (montant > 0 && duree > 0) {
            const mensualite = (montant + (montant * (taux / 100) * (duree / 12))) / duree;
            const total      = mensualite * duree;
            const cout       = total - montant;

            document.getElementById('prev-montant').textContent   = fmt(montant, sym);
            document.getElementById('prev-taux').textContent      = taux + '%';
            document.getElementById('prev-duree').textContent     = duree + ' mois';
            document.getElementById('prev-mensualite').textContent = fmt(mensualite, sym);

            const calc = document.getElementById('cp-calc');
            calc.style.display = 'flex';
            document.getElementById('calc-mensualite').textContent = fmt(mensualite, sym);
            document.getElementById('calc-total').textContent      = fmt(total, sym);
            document.getElementById('calc-cout').textContent       = fmt(cout, sym);
        } else {
            document.getElementById('prev-montant').textContent   = '—';
            document.getElementById('prev-taux').textContent      = taux ? taux + '%' : '—';
            document.getElementById('prev-duree').textContent     = duree ? duree + ' mois' : '—';
            document.getElementById('prev-mensualite').textContent = '—';
        }
    }

    // Langue pills
    document.querySelectorAll('.lang-pill').forEach(pill => {
        pill.addEventListener('click', () => {
            document.querySelectorAll('.lang-pill').forEach(p => p.classList.remove('active'));
            pill.classList.add('active');
            // Si des articles ont déjà été remplis, les recalculer dans la nouvelle langue
            const artsFilled = document.getElementById('art-1-titre')?.value.trim();
            if (artsFilled) resetArticles();
            else updatePreview();
        });
    });

    // Tous les champs
    ['emprunteur_nom','emprunteur_pays','emprunteur_id','contract_no','preteur_nom','preteur_pays','preteur_adresse','preteur_id','preteur_capacite','montant','taux','duree','devise']
        .forEach(id => document.getElementById(id)?.addEventListener('input', updatePreview));

    for (let n = 1; n <= 10; n++) {
        document.getElementById('art-' + n + '-titre')?.addEventListener('input', updatePreview);
        document.getElementById('art-' + n + '-corps')?.addEventListener('input', updatePreview);
    }

    // Exposer updatePreview globalement pour les fonctions externes (deleteArticle, resetArticles)
    window.updatePreview = updatePreview;

    updatePreview();

    // Suppression fond blanc via Canvas
    function removeWhiteBackground(dataUrl, callback) {
        const tmpImg = new Image();
        tmpImg.onload = function () {
            const canvas = document.createElement('canvas');
            canvas.width  = tmpImg.width;
            canvas.height = tmpImg.height;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(tmpImg, 0, 0);
            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            const d = imageData.data;
            for (let i = 0; i < d.length; i += 4) {
                const r = d[i], g = d[i + 1], b = d[i + 2];
                // Pixels blancs ou quasi-blancs → transparents
                if (r > 210 && g > 210 && b > 210) {
                    d[i + 3] = 0;
                }
            }
            ctx.putImageData(imageData, 0, 0);
            callback(canvas.toDataURL('image/png'));
        };
        tmpImg.src = dataUrl;
    }

    // Prévisualisation de la signature du prêteur
    document.getElementById('signature_preteur')?.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            removeWhiteBackground(e.target.result, function (processed) {
                const wrap = document.getElementById('sig-pre-wrap');
                const img  = document.getElementById('sig-pre-img');
                img.src = processed;
                wrap.style.display = 'block';
                // Stocker le résultat traité pour l'envoi au serveur
                document.getElementById('signature_preteur_data').value = processed;
                // Remplacer le cachet dans l'aperçu
                const prevImg = document.getElementById('prev-sig-pre-img');
                if (prevImg) prevImg.src = processed;
            });
        };
        reader.readAsDataURL(file);
    });
});

// ---- Fonctions globales éditeur d'articles ----
function buildArticleFullText(n, t, montant, sym, duree, empPays) {
    const fmtN = (v) => v > 0 ? new Intl.NumberFormat('fr-FR',{minimumFractionDigits:2}).format(v)+' '+sym : '—';
    const j = (arr) => arr.filter(s => s && s.trim()).join('\n\n');
    switch(n) {
        case 1:  return j([(t.art1_p1a||'')+' '+fmtN(montant)+'. '+(t.art1_p1b||''), (t.art1_p2a||'')+' '+empPays+'.']);
        case 2:  return (t.art2_intro||'')+' '+(duree>0?duree+' '+(t.mois||'mois'):'—')+'. '+(t.art2_suite||'');
        case 3:  return t.art3_p1 || '';
        case 4:  return j([(t.observation||'')+' '+(t.art4_p1||''), t.art4_p2||'', t.art4_p3||'']);
        case 5:  return j([t.art5_p1||'', t.art5_p2||'', '- '+(t.art5_li1||'')+'\n- '+(t.art5_li2||'')+'\n- '+(t.art5_li3||'')]);
        case 6:  return j([t.art6_p1||'', t.art6_p2||'', t.art6_p3||'']);
        case 7:  return j([t.art7_p1||'', t.art7_p2||'', (t.art7_partiel||'')+' '+(t.art7_p3||'')]);
        case 8:  return j([t.art8_p1||'', t.art8_p2||'', t.art8_p3||'', t.art8_p4||'']);
        case 9:  return t.art9_p1 || '';
        case 10: return j([t.art10_p1||'', t.art10_p2||'']);
    }
    return '';
}

function toggleArtsSection() {
    const sec  = document.getElementById('arts-section');
    const chev = document.getElementById('arts-chev');
    const open = sec.style.display !== 'none';
    sec.style.display    = open ? 'none' : 'block';
    chev.style.transform = open ? '' : 'rotate(180deg)';
    // Auto-remplir à la première ouverture si les inputs sont vides
    if (!open && !document.getElementById('art-1-titre')?.value.trim()) {
        resetArticles();
    }
}

function toggleArt(n) {
    const item = document.getElementById('art-item-' + n);
    const bd   = document.getElementById('art-bd-' + n);
    const open = item.classList.toggle('open');
    bd.style.display = open ? 'block' : 'none';
}

function deleteArticle(n) {
    const item = document.getElementById('art-item-' + n);
    item.classList.add('deleted');
    item.querySelectorAll('input, textarea').forEach(el => el.disabled = true);
    if (typeof updatePreview === 'function') updatePreview();
}

function resetArticles() {
    const lang    = document.querySelector('input[name="lang"]:checked')?.value || 'fr';
    const t       = allTranslations[lang] || allTranslations['fr'];
    const montant = parseFloat(document.getElementById('montant').value) || 0;
    const duree   = parseInt(document.getElementById('duree').value) || 0;
    const sym     = {EUR:'€',USD:'$',GBP:'£',CHF:'Fr',CAD:'CA$',XOF:'F CFA',MAD:'د.م.',TND:'DT',DZD:'DA'}[document.getElementById('devise').value] || '€';
    const empPays = document.getElementById('emprunteur_pays').value || '—';
    const titleKeys = ['art1_titre','art2_titre','art3_titre','art4_titre','art5_titre','art6_titre','art7_titre','art8_titre','art9_titre','art10_titre'];
    for (let n = 1; n <= 10; n++) {
        const item = document.getElementById('art-item-' + n);
        if (!item) continue;
        item.classList.remove('deleted');
        item.querySelectorAll('input, textarea').forEach(el => el.disabled = false);
        const titreEl = document.getElementById('art-' + n + '-titre');
        const corpsEl = document.getElementById('art-' + n + '-corps');
        if (titreEl) titreEl.value = t[titleKeys[n-1]] || '';
        if (corpsEl) corpsEl.value = buildArticleFullText(n, t, montant, sym, duree, empPays);
    }
    if (typeof updatePreview === 'function') updatePreview();
}
</script>
@endsection
