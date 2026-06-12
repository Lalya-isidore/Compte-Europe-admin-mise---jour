<!DOCTYPE html>
<html lang="{{ $lang }}">
<head>
    <meta charset="utf-8">
    <title>Contrat de Prêt</title>
    <style>
        @page { margin: 2cm 1.8cm; }
        body { font-family: {{ $lang === 'ro' ? "'DejaVu Serif'" : "'Times New Roman'" }}, serif; font-size: 12pt; line-height: 1.75; color: #2c3e50; }
        .container { width: 100%; position: relative; }
        .frame { position: fixed; top: 0; left: 0; right: 0; bottom: 0; border: 2px solid #002B5B; margin: -1.2cm; z-index: -2; }
        .frame-inner { position: fixed; top: 0; left: 0; right: 0; bottom: 0; border: 1px solid #002B5B; margin: -1.1cm; z-index: -2; }
        .watermark { position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 500px; height: 500px; opacity: 0.05; z-index: -1; background-image: url("{{ public_path('images/contract/logo-justice.jpg') }}"); background-repeat: no-repeat; background-position: center; background-size: contain; }
        .header-table { width: 100%; border-bottom: 3px double #002B5B; margin-bottom: 18px; padding-bottom: 18px; }
        h1 { color: #4B0082; font-size: 21pt; font-weight: bold; margin: 0; letter-spacing: 1px; white-space: nowrap; }
        .subtitle { text-align: center; font-size: 13pt; font-weight: bold; margin-bottom: 24px; font-style: italic; text-decoration: underline; }
        .party-box { width: 42%; display: inline-block; vertical-align: top; }
        .party-box.left { margin-right: 12%; }
        .party-title { font-weight: bold; text-decoration: underline; margin-bottom: 8px; color: #002B5B; font-size: 12pt; }
        .party-info { background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 14px; font-size: 11pt; border-radius: 4px; min-height: 120px; }
        .label { font-weight: bold; color: #4a5568; padding-right: 10px; white-space: nowrap; vertical-align: top; }
        .value { color: #1a202c; vertical-align: top; }
        .content { text-align: justify; margin-bottom: 16px; }
        .article-title { color: #002B5B; font-weight: bold; font-size: 13pt; border-bottom: 1px solid #cbd5e0; margin-top: 22px; margin-bottom: 12px; padding-bottom: 5px; }
        .sig-table { width: 100%; border-collapse: collapse; margin-top: 36px; border-top: 1px solid #eee; }
        .sig-cell { vertical-align: top; padding: 20px 5px; text-align: center; }
        .sig-name { font-weight: bold; margin-top: 50px; }
        .sig-title { font-style: italic; font-size: 9pt; color: #666; margin-top: 6px; }
        @if($isTestGeneration)
        .test-watermark { position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 999; pointer-events: none; display: flex; align-items: center; justify-content: center; }
        .test-watermark-text { font-size: 72pt; font-weight: 900; color: rgba(200,0,0,0.08); white-space: nowrap; transform: rotate(-35deg); letter-spacing: 6px; font-family: Arial, sans-serif; }
        .test-banner { position: fixed; bottom: 0; left: 0; right: 0; background: #c0392b; color: #fff; font-size: 8.5pt; font-weight: bold; text-align: center; padding: 6px 10px; z-index: 1000; letter-spacing: 0.3px; }
        @endif
    </style>
</head>
<body>
<div class="frame"></div>
<div class="frame-inner"></div>
<div class="watermark"></div>
@if($isTestGeneration)
<div class="test-watermark"><div class="test-watermark-text">FLASH BILAN</div></div>
<div class="test-banner">⚠ Ceci est une génération de test. La prochaine fois, générez avec des crédits pour obtenir un contrat officiel sans filigrane Flash Bilan.</div>
@endif

<div class="container">
    <table class="header-table" style="border: none; margin-bottom: 20px;">
        <tr>
            <td style="width: 25%; text-align: center; vertical-align: top; padding-top: 10px;">
                <img src="{{ public_path('images/contract/logo-ue.png') }}" alt="UE" style="height: 65px; width: auto; display: block; margin: 0 auto 5px auto;">
                <div style="font-size: 8pt; font-weight: bold; color: #003399; line-height: 1.2;">
                    {{ $t['union_eu'] }}<br>
                    <span style="font-size: 6pt; font-weight: normal; color: #333;">_._._._._._._._</span><br>
                    <span style="font-size: 6.5pt;">{{ $t['service_justice'] }}</span><br>
                    <span style="font-size: 5pt; color: #333;">_._._._._</span><br>
                    <span style="font-size: 6.5pt;">{{ $t['tribunal'] }}</span>
                </div>
            </td>
            <td style="width: 50%; text-align: center; vertical-align: middle; padding-top: 20px;">
                <div style="border: 3px solid #4B0082; margin-top: 15px; padding: 12px 25px; display: inline-block; border-radius: 8px; background: linear-gradient(135deg, rgba(75,0,130,0.05), rgba(75,0,130,0.02));">
                    <h1>{{ $t['titre'] }}</h1>
                </div>
            </td>
            <td style="width: 25%; text-align: center; vertical-align: top; padding-top: 10px;">
                <img src="{{ public_path('images/contract/logo-justice.jpg') }}" alt="Justice" style="height: 75px; width: auto; display: block; margin: 0 auto 5px auto;">
                <div style="font-size: 8pt; font-weight: bold; color: #8B0000; line-height: 1.2;">
                    {{ $t['registre'] }}<br>
                    <span style="font-size: 7pt; font-weight: bold; color: #002B5B;">{{ $t['coordination'] }}</span><br>
                    <span style="font-size: 6pt; color: #333;">_o_o_o_o_o_o_o_o_o_</span><br>
                    <span style="font-size: 8.5pt; color: #d00;">{{ $t['contrat_no'] }} {{ $contractNo }}</span>
                </div>
            </td>
        </tr>
    </table>

    <div class="subtitle">{{ $t['soussignes'] }}</div>

    <div style="margin-bottom: 40px;">
        <div class="party-box left">
            <div class="party-title">{{ $t['le_preteur'] }}</div>
            <div class="party-info">
                <strong>{{ strtoupper($preteurNom) }}</strong><br><br>
                <table style="width: 100%; border: none;">
                    <tr>
                        <td class="label" style="width: 100px; border: none; padding: 2px 0;">{{ $t['pays'] }}</td>
                        <td class="value" style="border: none; padding: 2px 0;">{{ $preteurPays }}</td>
                    </tr>
                    <tr>
                        <td class="label" style="width: 100px; border: none; padding: 2px 0;">{{ $t['adresse'] }}</td>
                        <td class="value" style="border: none; padding: 2px 0;">{{ $preteurAdresse }}</td>
                    </tr>
                    <tr>
                        <td class="label" style="width: 100px; border: none; padding: 2px 0;">ID :</td>
                        <td class="value" style="border: none; padding: 2px 0;">{{ $preteurId }}</td>
                    </tr>
                    <tr>
                        <td class="label" style="width: 100px; border: none; padding: 2px 0;">{{ $t['capacite'] }}</td>
                        <td class="value" style="border: none; padding: 2px 0;">{{ $preteurCapacite }}</td>
                    </tr>
                </table>
                <br><em>{{ $t['denom_preteur'] }}</em>
            </div>
        </div>

        <div class="party-box">
            <div class="party-title">{{ $t['beneficiaire'] }}</div>
            <div class="party-info">
                <strong>{{ $t['civilite'] }} {{ strtoupper($emprunteurNom) }}</strong><br><br>
                <table style="width: 100%; border: none;">
                    <tr>
                        <td class="label" style="width: 100px; border: none; padding: 2px 0;">{{ $t['pays'] }}</td>
                        <td class="value" style="border: none; padding: 2px 0;">{{ $emprunteurPays }}</td>
                    </tr>
                    @if($emprunteurId)
                    <tr>
                        <td class="label" style="width: 100px; border: none; padding: 2px 0;">{{ $t['client_id'] }}</td>
                        <td class="value" style="border: none; padding: 2px 0;">{{ $emprunteurId }}</td>
                    </tr>
                    @endif
                </table>
                <br><em>{{ $t['denom_empr'] }}</em>
            </div>
        </div>
    </div>

    <p class="content">{{ $t['convenu'] }}</p>

    @php
        $artDefaults = [
            1 => ['titre' => $t['art1_titre'], 'corps' => implode("\n\n", array_filter([
                    $t['art1_p1a'].' '.number_format($montant,2,',',' ').' '.$deviseSymbole.' ('.$devise.'). '.$t['art1_p1b'],
                    $t['art1_p2a'].' '.$emprunteurPays.'.'
                  ]))],
            2 => ['titre' => $t['art2_titre'], 'corps' => $t['art2_intro'].' '.$duree.' '.$t['mois'].' ('.round($duree/12,1).' '.$t['ans'].'). '.$t['art2_suite']],
            3 => ['titre' => $t['art3_titre'], 'corps' => $t['art3_p1']],
            4 => ['titre' => $t['art4_titre'], 'corps' => implode("\n\n", [$t['observation'].' '.$t['art4_p1'], $t['art4_p2'], $t['art4_p3']])],
            5 => ['titre' => $t['art5_titre'], 'corps' => implode("\n\n", [$t['art5_p1'], $t['art5_p2'], '- '.$t['art5_li1']."\n- ".$t['art5_li2']."\n- ".$t['art5_li3']])],
            6 => ['titre' => $t['art6_titre'], 'corps' => implode("\n\n", [$t['art6_p1'], $t['art6_p2'], $t['art6_p3']])],
            7 => ['titre' => $t['art7_titre'], 'corps' => implode("\n\n", [$t['art7_p1'], $t['art7_p2'], $t['art7_partiel'].' '.preg_replace('/5\s*%/', $taux.'%', $t['art7_p3'])])],
            8 => ['titre' => $t['art8_titre'], 'corps' => implode("\n\n", [$t['art8_p1'], $t['art8_p2'], $t['art8_p3'], $t['art8_p4']])],
            9 => ['titre' => $t['art9_titre'], 'corps' => $t['art9_p1']],
            10 => ['titre' => $t['art10_titre'], 'corps' => implode("\n\n", [$t['art10_p1'], $t['art10_p2']])],
        ];
    @endphp

    @for($n = 1; $n <= 10; $n++)
        @php
            $ca = $customArticles[$n] ?? null;
            $titre = ($ca && !empty($ca['titre'])) ? $ca['titre'] : ($artDefaults[$n]['titre'] ?? '');
            $corps = ($ca && !empty($ca['corps'])) ? $ca['corps'] : ($artDefaults[$n]['corps'] ?? '');
        @endphp
        <div class="article-title">{{ $titre }}</div>
        @foreach(array_filter(array_map('trim', explode("\n\n", $corps))) as $para)
            <p class="content">{{ $para }}</p>
        @endforeach
        @if($n === 2)
        <table style="width: 100%; margin: 16px 0; border-collapse: collapse; background-color: #f8fafc; border: 1px solid #e2e8f0;">
            <tr><td style="padding: 10px; border: 1px solid #e2e8f0; font-weight: bold; width: 50%;">{{ $t['montant_p'] }}</td><td style="padding: 10px; border: 1px solid #e2e8f0; text-align: right;">{{ number_format($montant, 2, ',', ' ') }} {{ $deviseSymbole }}</td></tr>
            <tr><td style="padding: 10px; border: 1px solid #e2e8f0; font-weight: bold;">{{ $t['taux_label'] }}</td><td style="padding: 10px; border: 1px solid #e2e8f0; text-align: right;">{{ $taux }}%</td></tr>
            <tr><td style="padding: 10px; border: 1px solid #e2e8f0; font-weight: bold;">{{ $t['nb_echeances'] }}</td><td style="padding: 10px; border: 1px solid #e2e8f0; text-align: right;">{{ $duree }} {{ $t['mois'] }}</td></tr>
            <tr style="background-color:#edf2f7;"><td style="padding: 10px; border: 1px solid #e2e8f0; font-weight: bold; color: #002B5B;">{{ $t['mensualite'] }}</td><td style="padding: 10px; border: 1px solid #e2e8f0; text-align: right; font-weight: bold; color: #002B5B;">{{ number_format(($montant+($montant*($taux/100)*($duree/12)))/$duree, 2, ',', ' ') }} {{ $deviseSymbole }}</td></tr>
        </table>
        @endif
    @endfor

    <table class="sig-table">
        <tr>
            <td class="sig-cell" style="width: 35%;">
                <div style="font-size: 9pt; color: #333;">{{ $t['l_emprunteur'] }}</div>
                @if($signatureEmprunteur)
                <div style="margin-top: 10px; margin-bottom: 6px;">
                    <img src="{{ $signatureEmprunteur }}" alt="Signature emprunteur" style="height: 60px; width: auto; max-width: 160px;">
                </div>
                @else
                <div style="height: 60px;"></div>
                @endif
                <div class="sig-name">{{ $t['civilite'] }} {{ strtoupper($emprunteurNom) }}</div>
                <div class="sig-title">{{ $t['benef_legal'] }}</div>
            </td>
            <td class="sig-cell" style="width: 30%; vertical-align: middle;"></td>
            <td class="sig-cell" style="width: 35%;">
                <div style="font-size: 9pt; color: #333; text-align: right;">{{ $t['fait_a'] }} {{ $preteurPays }}, {{ $t['le'] }} {{ date('d/m/Y') }}</div>
                <div style="font-size: 9pt; color: #333; margin-top: 5px;">{{ $t['preteur_rep'] }}</div>
                <div style="position: relative; margin-top: 10px; text-align: right;">
                    <img src="{{ $signaturePreteur ?? public_path('images/contract/cachet-signature.jpg') }}" alt="Signature" style="height: 110px; width: auto; display: block; margin: 0 0 0 auto;">
                    <div style="font-weight: bold; font-size: 12pt; margin-top: -18px; position: relative; z-index: 2; text-align: right;">{{ strtoupper($preteurNom) }}</div>
                </div>
                <div class="sig-title" style="text-align: right;">{{ $preteurCapacite }}</div>
            </td>
        </tr>
    </table>

    <div style="margin-top: 30px; border: 2px dashed #003399; background-color: #f0f7ff; padding: 20px; text-align: center; font-size: 10pt; color: #003399; font-weight: bold; border-radius: 8px; line-height: 1.5;">
        {{ $t['important'] }}
    </div>
</div>
</body>
</html>
