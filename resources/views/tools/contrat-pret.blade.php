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

    <form action="{{ route('tools.contrat-pret.generate') }}" method="POST" id="cp-form">
        @csrf
        <div class="cp-grid">

            {{-- ======== COLONNE GAUCHE : Formulaire ======== --}}
            <div class="cp-col">

                {{-- Langue --}}
                <div class="cp-card">
                    <div class="cp-card__head"><i class="fas fa-language"></i> Langue du contrat</div>
                    <div class="cp-card__body">
                        <div class="lang-pills">
                            @foreach(['fr' => '🇫🇷 Français', 'en' => '🇬🇧 English', 'es' => '🇪🇸 Español', 'pt' => '🇵🇹 Português', 'de' => '🇩🇪 Deutsch', 'it' => '🇮🇹 Italiano', 'nl' => '🇳🇱 Nederlands', 'pl' => '🇵🇱 Polski', 'hr' => '🇭🇷 Hrvatski', 'ru' => '🇷🇺 Русский'] as $code => $label)
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
                        <div class="cp-field" style="margin-top: 14px;">
                            <label>Identifiant / Numéro de client <small>(optionnel)</small></label>
                            <input type="text" name="emprunteur_id" id="emprunteur_id" placeholder="Ex: CLI-00142">
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
                            <div class="prev-header">
                                <div class="prev-logos">
                                    <div class="prev-logo-box">🇪🇺</div>
                                    <div class="prev-title-box">
                                        <div class="prev-title" id="prev-titre">CONTRAT DE PRÊT</div>
                                    </div>
                                    <div class="prev-logo-box">⚖️</div>
                                </div>
                                <div class="prev-contract-no" id="prev-no">N° <span>—</span>/{{ date('Y') }}</div>
                            </div>

                            <div class="prev-subtitle">— ENTRE LES SOUSSIGNÉS —</div>

                            <div class="prev-parties">
                                <div class="prev-party">
                                    <div class="prev-party__label">PRÊTEUR</div>
                                    <div class="prev-party__name" id="prev-preteur-nom">—</div>
                                    <div class="prev-party__info" id="prev-preteur-pays">Pays: —</div>
                                    <div class="prev-party__info" id="prev-preteur-capacite">Capacité: —</div>
                                </div>
                                <div class="prev-party">
                                    <div class="prev-party__label">BÉNÉFICIAIRE</div>
                                    <div class="prev-party__name" id="prev-emprunteur-nom">—</div>
                                    <div class="prev-party__info" id="prev-emprunteur-pays">Pays: —</div>
                                </div>
                            </div>

                            <div class="prev-table">
                                <div class="prev-table__title">RÉSUMÉ DU PRÊT</div>
                                <table>
                                    <tr><td>Montant principal</td><td id="prev-montant">—</td></tr>
                                    <tr><td>Taux d'intérêt</td><td id="prev-taux">—</td></tr>
                                    <tr><td>Durée</td><td id="prev-duree">—</td></tr>
                                    <tr class="highlight"><td>Mensualité</td><td id="prev-mensualite">—</td></tr>
                                </table>
                            </div>

                            <div class="prev-articles" id="prev-articles">
                                @foreach(range(1,10) as $n)
                                <div class="prev-article">
                                    <div class="prev-art-title" id="prev-art{{ $n }}-titre">—</div>
                                    <div class="prev-art-body"  id="prev-art{{ $n }}-body">—</div>
                                </div>
                                @endforeach
                            </div>

                            <div class="prev-sig">
                                <div class="prev-sig__block">
                                    <div class="prev-sig__line"></div>
                                    <div class="prev-sig__name" id="prev-sig-emprunteur">L'Emprunteur</div>
                                </div>
                                <div class="prev-sig__block">
                                    <div class="prev-sig__line"></div>
                                    <div class="prev-sig__name" id="prev-sig-preteur">Le Prêteur</div>
                                </div>
                            </div>

                            <div class="prev-important">
                                ⚠️ CE CONTRAT DOIT ÊTRE IMPRIMÉ ET SIGNÉ
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

.cp-btn-generate { width: 100%; padding: 14px; background: linear-gradient(135deg, #1e3a5f, #2d5986); color: #fff; border: none; border-radius: 10px; font-size: 0.95rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; transition: all 0.2s; }
.cp-btn-generate:hover { background: linear-gradient(135deg, #162e4d, #244a72); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(30,58,95,0.3); }
.cp-btn-generate i { font-size: 1.1rem; }

/* Aperçu */
.cp-col--preview .cp-card { position: sticky; top: 80px; }
.cp-preview { padding: 16px; background: #f5f5f5; }
.cp-preview__doc { background: #fff; border: 1px solid #ddd; border-radius: 6px; padding: 24px; font-family: 'Times New Roman', serif; font-size: 14px; color: #222; box-shadow: 0 2px 8px rgba(0,0,0,0.08); min-height: 400px; }

.prev-header { border-bottom: 2px double #002B5B; padding-bottom: 12px; margin-bottom: 12px; }
.prev-logos { display: flex; align-items: center; justify-content: space-between; gap: 8px; }
.prev-logo-box { font-size: 1.4rem; flex-shrink: 0; }
.prev-title-box { flex: 1; text-align: center; }
.prev-title { font-size: 17px; font-weight: bold; color: #4B0082; border: 2px solid #4B0082; display: inline-block; padding: 5px 12px; border-radius: 4px; }
.prev-contract-no { text-align: right; font-size: 12px; color: #8B0000; font-weight: bold; margin-top: 4px; }

.prev-subtitle { text-align: center; font-size: 13px; font-style: italic; font-weight: bold; text-decoration: underline; margin: 10px 0; }

.prev-parties { display: flex; gap: 10px; margin-bottom: 14px; }
.prev-party { flex: 1; border: 1px solid #e0e0e0; border-radius: 4px; padding: 10px; background: #fafafa; }
.prev-party__label { font-size: 11px; font-weight: bold; color: #002B5B; text-decoration: underline; margin-bottom: 5px; }
.prev-party__name { font-size: 13px; font-weight: bold; margin-bottom: 4px; }
.prev-party__info { font-size: 11px; color: #555; }

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

.prev-sig { display: flex; gap: 20px; margin-bottom: 10px; padding-top: 10px; border-top: 1px solid #eee; }
.prev-sig__block { flex: 1; text-align: center; }
.prev-sig__line { height: 30px; border-bottom: 1px solid #333; margin-bottom: 4px; }
.prev-sig__name { font-size: 11px; font-weight: bold; }

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
        const empNom    = document.getElementById('emprunteur_nom').value   || '—';
        const empPays   = document.getElementById('emprunteur_pays').value  || '—';
        const preNom    = document.getElementById('preteur_nom').value      || '—';
        const prePays   = document.getElementById('preteur_pays').value     || '—';
        const preCap    = document.getElementById('preteur_capacite').value || '—';
        const lang      = document.querySelector('input[name="lang"]:checked')?.value || 'fr';

        // Titre selon langue
        document.getElementById('prev-titre').textContent = langTitles[lang] || langTitles.fr;

        // Contenu des articles
        const t = allTranslations[lang] || allTranslations['fr'];
        const artTitles = ['art1_titre','art2_titre','art3_titre','art4_titre','art5_titre','art6_titre','art7_titre','art8_titre','art9_titre','art10_titre'];
        artTitles.forEach((key, i) => {
            const n = i + 1;
            const titleEl = document.getElementById('prev-art' + n + '-titre');
            const bodyEl  = document.getElementById('prev-art' + n + '-body');
            if (titleEl) titleEl.textContent = t[key] || '—';
            if (bodyEl) {
                const full = articleBodies[i](t, montant, sym, duree);
                bodyEl.textContent = full.length > 160 ? full.substring(0, 160) + '…' : full;
            }
        });

        // Parties
        document.getElementById('prev-preteur-nom').textContent  = preNom.toUpperCase();
        document.getElementById('prev-preteur-pays').textContent = 'Pays: ' + prePays;
        document.getElementById('prev-preteur-capacite').textContent = preCap;
        document.getElementById('prev-emprunteur-nom').textContent  = empNom.toUpperCase();
        document.getElementById('prev-emprunteur-pays').textContent = 'Pays: ' + empPays;
        document.getElementById('prev-sig-emprunteur').textContent  = empNom;
        document.getElementById('prev-sig-preteur').textContent     = preNom;

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
            updatePreview();
        });
    });

    // Tous les champs
    ['emprunteur_nom','emprunteur_pays','preteur_nom','preteur_pays','preteur_capacite','montant','taux','duree','devise']
        .forEach(id => document.getElementById(id)?.addEventListener('input', updatePreview));

    updatePreview();
});
</script>
@endsection
