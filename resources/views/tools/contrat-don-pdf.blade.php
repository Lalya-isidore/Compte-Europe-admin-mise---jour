<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $lang === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <title>{{ $t['titre_certif'] }}</title>
    <style>
        /* PDF Global Settings */
        @page {
            margin: 0.5cm;
            size: A4 portrait;
        }

        body {
            margin: 0;
            padding: 0;
            background: #fff;
            color: #000;
            font-family: "Times New Roman", "DejaVu Serif", serif;
            font-size: 10.5pt;
            line-height: 1.3;
        }

        body * { box-sizing: border-box; }

        /* Stable Star Border System */
        .border-fixed {
            position: fixed;
            z-index: 9999;
            color: #000;
            font-size: 12pt;
            line-height: 1;
            font-family: 'DejaVu Sans', sans-serif;
            pointer-events: none;
        }
        .b-top    { top: 0; left: 0; right: 0; text-align: center; padding: 2px 10px; }
        .b-bottom { bottom: 0; left: 0; right: 0; text-align: center; padding: 2px 10px; }
        .b-left   { top: 15px; bottom: 15px; left: 5px; width: 20px; text-align: center; word-wrap: break-word; overflow: hidden; }
        .b-right  { top: 15px; bottom: 15px; right: 5px; width: 20px; text-align: center; word-wrap: break-word; overflow: hidden; }

        /* Content Container */
        .page-content {
            padding: 0.8cm 1cm;
            position: relative;
            z-index: 10;
        }

        /* Scales Watermark */
        .watermark {
            position: fixed;
            top: 28%;
            left: 50%;
            transform: translateX(-50%);
            width: 75%;
            opacity: 0.06;
            z-index: 0;
        }

        /* Absolute Seals (Edges) for Page 1 */
        .abs-seal-left { position: absolute; top: 1.6cm; left: 1.0cm; z-index: 20; }
        .abs-seal-right { position: absolute; top: 1.6cm; right: 1.0cm; z-index: 20; }
        .abs-seal img { height: 150px; }

        /* Header Layout */
        .header-table { width: 100%; margin-top: 1cm; margin-bottom: 5px; border-collapse: collapse; }
        .side-logo { width: 25%; text-align: center; vertical-align: middle; }
        .side-logo img { height: 85px; max-width: 100%; }
        .center-logo { width: 50%; text-align: center; vertical-align: middle; }
        .center-logo img { height: 100px; max-width: 100%; }
        
        .header-text { text-align: center; width: 100%; margin-top: 5px; }
        .rep-title { color: #1565b5; font-size: 19pt; font-weight: bold; text-decoration: underline; margin-bottom: 3px; display: inline-block; }
        .rep-sub { font-size: 11pt; font-weight: bold; margin-bottom: 1px; color: #000; }
        .rep-dash { font-weight: bold; margin: 2px 0; color: #000; }
        .deed-no { font-size: 11pt; font-weight: bold; margin: 4px 0; border: 1pt solid #000; display: inline-block; padding: 2px 15px; color: #000; }

        .doc-title {
            text-align: center;
            color: #c00000;
            font-size: 17pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            margin: 15px 0 10px;
        }

        /* Identification Cards */
        .id-grid { width: 100%; margin: 10px 0; border-collapse: separate; border-spacing: 15px 0; }
        .id-box { 
            border: 0.8pt solid #333; 
            padding: 10px 12px; 
            vertical-align: top;
            width: 50%;
        }
        .box-lbl { color: #1F3864; font-weight: bold; text-decoration: underline; font-size: 10pt; text-transform: uppercase; }
        .box-name { font-weight: bold; font-size: 12pt; margin: 6px 0 8px; display: block; color: #000; }
        .box-row { font-size: 9.5pt; margin: 7px 0; }
        .box-key { font-weight: bold; width: 120px; display: inline-block; vertical-align: top; }
        .box-note { font-style: italic; font-size: 8.5pt; margin-top: 10px; border-top: 0.5pt solid #ccc; padding-top: 4px; }

        /* Main Clause */
        .main-clause {
            font-size: 11pt;
            font-weight: bold;
            text-align: justify;
            margin: 15px 0;
            line-height: 1.6;
        }

        .current-date { text-align: right; font-weight: bold; margin: 10px 0; font-size: 11pt; }

        /* Signatures */
        .sig-table { width: 100%; margin-top: 25px; table-layout: fixed; }
        .sig-cell { text-align: center; vertical-align: top; width: 33.33%; padding: 0 5px; }
        .sig-title { color: #c00000; font-size: 10.5pt; font-weight: bold; text-transform: uppercase; text-decoration: underline; display: block; margin-bottom: 10px; height: 30px; }
        .sig-img { height: 50px; }
        .sig-name { font-weight: bold; font-size: 10pt; margin-top: 8px; }

        /* Cachet rectangulaire notaire — même design que contrat de prêt */
        .cachet-outer {
            display: inline-block;
            border: 3pt solid #003090;
            padding: 4px;
            text-align: center;
        }
        .cachet-inner {
            border: 2pt solid #003090;
            padding: 10px 16px;
            color: #003090;
            min-width: 170px;
        }
        .cachet-inner .cr-header {
            font-weight: bold; font-size: 12pt;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        .cachet-inner .cr-name  { font-weight: bold; font-size: 10pt; text-transform: uppercase; margin: 3px 0; }
        .cachet-inner .cr-title { font-size: 8.5pt; margin: 2px 0; }
        .cachet-inner .cr-city  { font-size: 8.5pt; margin: 2px 0; }
        .cachet-inner .cr-date  { font-weight: bold; font-size: 9pt; margin-top: 4px; }

        .page-break { page-break-after: always; }

        /* Legal Clauses Page 2 */
        .legal-para { text-align: justify; font-size: 10pt; line-height: 1.32; margin-bottom: 2px; font-weight: bold; }
        .legal-bullet { text-align: justify; font-size: 10pt; line-height: 1.32; margin-left: 15px; margin-bottom: 1px; font-weight: bold; }
        .notaire-box { text-align: center; font-size: 8pt; font-weight: bold; color: #c00000; margin-top: 2px; }

        /* Extra-bold for key data (names, amounts, law refs) */
        strong { font-weight: 900; }
        /* Color only for names and amounts */
        .key-red { color: #c00000; }
    </style>
</head>
<body>

@php
    $hStars = str_repeat('★ ', 45);
    $vStars = str_repeat('★', 65);
    $vStarArray = preg_split('//u', $vStars, -1, PREG_SPLIT_NO_EMPTY);
@endphp

<div class="border-fixed b-top">{{ $hStars }}</div>
<div class="border-fixed b-bottom">{{ $hStars }}</div>
<div class="border-fixed b-left">@foreach($vStarArray as $s) {{ $s }}<br> @endforeach</div>
<div class="border-fixed b-right">@foreach($vStarArray as $s) {{ $s }}<br> @endforeach</div>

{{-- PAGE 1 --}}
<div class="page-content">
    <img src="{{ public_path('images/contract/justice-scales.svg') }}" class="watermark">

    <table class="header-table" style="margin-top:12px;">
        <tr>
            <td class="side-logo">
                <img src="{{ public_path('images/images entête don/image.png') }}">
            </td>
            <td class="center-logo">
                <img src="{{ public_path('images/images entête don/image copy 3.png') }}" style="height: 110px; max-width: 100%;">
                <div style="text-align: center; font-family: 'DejaVu Sans', sans-serif; font-size: 12pt; color: #1a3a5c; font-style: italic; font-weight: bold; margin-top: -52px;">{{ ucfirst(strtolower($t['notario'])) }}</div>
            </td>
            <td class="side-logo">
                <img src="{{ public_path('images/images entête don/image copy 2.png') }}">
            </td>
        </tr>
    </table>

    <div class="header-text">
        <div class="rep-title">{{ $nomRepublique }}</div>
        <div class="rep-sub">{{ $ministereNom }}</div>
        <div class="rep-sub">{{ $t['derechos'] }}</div>
        <div class="rep-dash">------------------</div>
        <div class="rep-sub">{{ str_replace(':ville', $villeTribunal, $t['tribunal_local']) }}</div>
        <div class="rep-dash">------------------</div>
        <div class="rep-sub">{{ $t['secretario'] }}</div>
        <div class="rep-dash">------------------</div>
        <div class="deed-no">{{ $deedNo }}</div>
    </div>

    <div class="doc-title">{{ $t['titre_certif'] }}</div>

    <table class="id-grid">
        <tr>
            <td class="id-box">
                <span class="box-lbl">{{ $t['donneur'] }}</span>
                <span class="box-name">{{ strtoupper($donateurPrenom . ' ' . $donateurNom) }}</span>
                <div style="font-size:9.5pt; margin:5px 0;"><strong style="text-decoration:underline;">{{ $t['pays'] }}</strong> {{ strtoupper($donateurPays) }}</div>
                <div style="font-size:9.5pt; margin:5px 0;"><strong style="text-decoration:underline;">{{ $t['adresse'] }}</strong> {{ strtoupper($donateurAdresse) }}</div>
                <div class="box-note">{{ $t['as_donneur'] }}</div>
            </td>
            <td class="id-box">
                <span class="box-lbl">{{ $t['beneficiaire'] }}</span>
                <span class="box-name">{{ strtoupper($donataireNom) }}</span>
                <div style="font-size:9.5pt; margin:5px 0;"><strong style="text-decoration:underline;">{{ $t['pays'] }}</strong> {{ strtoupper($donatairePays) }}</div>
                <div style="font-size:9.5pt; margin:5px 0;"><strong style="text-decoration:underline;">{{ $t['adresse'] }}</strong> {{ strtoupper($donataire_adresse) }}</div>
                <div class="box-note">{{ $t['as_beneficiaire'] }}</div>
            </td>
        </tr>
    </table>

    <div class="main-clause">
        {!! str_replace(
            [':donneur', ':montant', ':devise'],
            ['<strong>' . strtoupper($donateurPrenom . ' ' . $donateurNom) . '</strong>',
             '<strong>' . number_format($montant, 0, ',', '.') . '</strong>',
             '<strong>' . $devise . '</strong>'],
            $t['certifie_que']
        ) !!}
    </div>

    <div class="current-date" style="margin-top: 20px;">{{ date('d/m/Y') }}</div>

    <table class="sig-table">
        <tr>
            <td class="sig-cell">
                <span class="sig-title">{{ $t['donateur'] }}</span>
                <div style="height: 105px; text-align: center;">
                    <img src="{{ $signatureDonateur }}" style="height: 70px;">
                </div>
                <div class="sig-name">{{ strtoupper($donateurPrenom . ' ' . $donateurNom) }}</div>
            </td>
            <td class="sig-cell">
                <span class="sig-title">{{ $t['notario'] }}</span>
                <div style="height: 105px; text-align: center;">
                    <img src="{{ $signatureNotaire }}" style="height: 95px; width: auto; opacity: 0.92;">
                </div>
                <div class="sig-name">{{ strtoupper($sealNotaire) }}</div>
            </td>
            <td class="sig-cell">
                <span class="sig-title">{{ $t['beneficiaire'] }}</span>
                <div style="height: 105px;"></div>
                <div class="sig-name">{{ strtoupper($donataireNom) }}</div>
            </td>
        </tr>
    </table>
</div>

<div class="page-break"></div>

{{-- PAGE 2 --}}
<div class="page-content" style="padding-top: 0.3cm;">
    @php
        $logoHeight = ($paysNotaire === 'fr') ? '55px' : '42px';
        $logoWidth  = ($paysNotaire === 'fr') ? '90px' : '60px';
        $logoMargin = ($paysNotaire === 'fr') ? '10px' : '18px';
    @endphp
    <table class="header-table" style="margin-top: 0;">
        <tr>
            <td class="side-logo" style="width: 25%; text-align: left; vertical-align: middle;">
                <img src="{{ public_path($officialFlagPath) }}" style="height:{{ $logoHeight }} !important; max-height:{{ $logoHeight }}; max-width:{{ $logoWidth }}; width:auto; margin-top:{{ $logoMargin }}; display: block;">
            </td>
            <td class="center-logo" style="width:50%; text-align:center; vertical-align:middle;"></td>
            <td class="side-logo" style="width: 25%; text-align: right; vertical-align: middle;">
                <img src="{{ public_path($flagPath) }}" style="height:{{ $logoHeight }} !important; max-height:{{ $logoHeight }}; max-width:{{ $logoWidth }}; width:auto; margin-top:{{ $logoMargin }}; display: block; margin-left: auto;">
            </td>
        </tr>
    </table>

    <div class="header-text" style="margin-top: 10px;">
        <div class="rep-title" style="font-size:16pt; margin-bottom: 2px;">{{ $nomRepublique }}</div>
        <div class="rep-sub" style="margin-bottom: 1px;">{{ $ministereNom }}</div>
        <div class="rep-sub" style="margin-bottom: 1px;">{{ $t['derechos'] }}</div>
        <div class="rep-dash" style="margin: 3px 0;">------------------</div>
        <div class="rep-sub" style="margin-bottom: 1px;">{{ str_replace(':ville', $villeTribunal, $t['tribunal_local']) }}</div>
        <div class="rep-dash" style="margin: 3px 0;">------------------</div>
    </div>

    <div class="doc-title" style="font-size:14pt; margin: 5px 0 8px;">{{ $t['titre_testament'] }}</div>

    <div class="legal-para" style="margin-top:10px;">
        {!! str_replace(
            [':donneur', ':montant', ':devise', ':donataire'],
            ['<strong>' . strtoupper($donateurPrenom . ' ' . $donateurNom) . '</strong>',
             '<strong>' . number_format($montant, 0, ',', '.') . '</strong>',
             '<strong>' . $devise . '</strong>',
             '<strong>' . strtoupper($donataireNom) . '</strong>'],
            $t['p2_para1']
        ) !!}
    </div>

    <div class="legal-para">{{ $t['p2_donateur_declare'] }}</div>
    <div class="legal-bullet">{{ $t['p2_bullet1'] }}</div>
    <div class="legal-bullet">{{ $t['p2_bullet2'] }}</div>
    <div class="legal-bullet">{{ $t['p2_bullet3'] }}</div>

    <div class="legal-para">{{ $t['p2_senor'] }} <strong>{{ strtoupper($donataireNom) }}</strong> :</div>
    <div class="legal-bullet">{!! preg_replace('/(77-995|18\/12\/77|[Aa]rticle\s+4|[Aa]rt[íi]culo\s+4|[Aa]rtigo\s+4)/', '<strong>$1</strong>', $t['p2_accept1']) !!}</div>
    <div class="legal-bullet">{{ $t['p2_accept2'] }}</div>

    <div class="legal-para">
        {!! str_replace([':notaire', ':territoire', ':adresse'],
            ['<strong>' . strtoupper($sealNotaire) . '</strong>',
             $territoire,
             $adresseNotaire],
            $t['p2_notaire_certifie']) !!}
    </div>
    <div class="legal-para">{{ $t['p2_legal2'] }}</div>
    <div class="legal-para">{!! str_replace(':donataire', '<strong>' . strtoupper($donataireNom) . '</strong>', $t['p2_legal3']) !!}</div>

    <table class="sig-table" style="margin-top:6px;">
        <tr>
            <td class="sig-cell">
                <span class="sig-title">{{ $t['donateur'] }}</span>
                <div style="height: 65px; text-align: center;">
                    <img src="{{ $signatureDonateur }}" style="height: 55px;">
                </div>
                <div class="sig-name">{{ strtoupper($donateurPrenom . ' ' . $donateurNom) }}</div>
            </td>
            <td class="sig-cell">
                <span class="sig-title">{{ $t['notario'] }}</span>
                <div style="padding-top: 2px; text-align: center;">
                    <div style="position: relative; display: inline-block; width: 155px; height: 68px;">
                        <img src="{{ $timbrePath }}" style="position: absolute; bottom: 10px; left: 18px; height: 38px; width: auto; z-index: 1; opacity: 0.85;">
                        <img src="{{ $signatureNotaire }}" style="position: absolute; bottom: -8px; left: -5px; width: 120px; height: auto; z-index: 2; opacity: 0.92;">
                        <img src="{{ $cachetPath }}" style="position: absolute; top: 0; left: 0; height: 58px; width: auto; z-index: 4;">
                    </div>
                </div>
                <div class="sig-name">{{ strtoupper($sealNotaire) }}</div>
            </td>
            <td class="sig-cell">
                <span class="sig-title">{{ $t['beneficiaire'] }}</span>
                <div style="height: 65px;"></div>
                <div class="sig-name">{{ strtoupper($donataireNom) }}</div>
            </td>
        </tr>
    </table>
</div>

</body>
</html>