<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Simulation de Crédit</title>
    <style>
        @page { margin: 2cm 1.5cm; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11pt; color: #1a202c; line-height: 1.5; }
        .frame { position: fixed; top: -1.2cm; left: -1cm; right: -1cm; bottom: -1.2cm; border: 2px solid #1e3a5f; z-index: -1; }
        .frame-inner { position: fixed; top: -1.1cm; left: -0.9cm; right: -0.9cm; bottom: -1.1cm; border: 1px solid #1e3a5f; z-index: -1; }

        .header { text-align: center; margin-bottom: 28px; border-bottom: 2px solid #1e3a5f; padding-bottom: 16px; }
        .header h1 { color: #1e3a5f; font-size: 20pt; font-weight: bold; margin: 0 0 4px; letter-spacing: 1px; }
        .header .sub { color: #555; font-size: 10pt; margin: 0; }
        .header .date { color: #888; font-size: 9pt; margin-top: 6px; }

        .summary { background: #f0f7ff; border: 1px solid #c0d8f5; border-radius: 6px; padding: 16px 20px; margin-bottom: 18px; }
        .summary table { width: 100%; border-collapse: collapse; }
        .summary td { padding: 5px 10px; font-size: 11pt; }
        .summary td:first-child { font-weight: bold; color: #1e3a5f; width: 55%; }
        .summary td:last-child { text-align: right; color: #1a202c; }
        .summary .highlight td { background: #1e3a5f; color: #fff; border-radius: 4px; }
        .summary .highlight td:first-child { font-weight: bold; }

        /* Bloc répartition */
        .repartition { margin-bottom: 24px; background: #fff; border: 1px solid #e2e8f0; border-radius: 6px; padding: 14px 20px; }
        .recap-grid { display: table; width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        .recap-cell { display: table-cell; width: 50%; padding: 8px 10px; vertical-align: middle; }
        .recap-cell-inner { background: #f8fafc; border: 1px solid #eee; border-radius: 8px; padding: 10px 14px; }
        .recap-label { font-size: 8.5pt; color: #888; margin-bottom: 3px; }
        .recap-value { font-size: 12pt; font-weight: bold; color: #1a202c; }
        .recap-value--red { color: #e53e3e; }
        .bar-section { margin-top: 4px; }
        .bar-labels { width: 100%; border-collapse: collapse; margin-bottom: 5px; }
        .bar-labels td { font-size: 8.5pt; color: #555; padding: 0; }
        .bar-labels td:last-child { text-align: right; }
        .dot-blue { display: inline-block; width: 9px; height: 9px; border-radius: 50%; background: #1e3a5f; margin-right: 4px; vertical-align: middle; }
        .dot-red  { display: inline-block; width: 9px; height: 9px; border-radius: 50%; background: #e53e3e; margin-right: 4px; vertical-align: middle; }
        .bar-outer { width: 100%; height: 12px; border-radius: 6px; background: #edf2f7; overflow: hidden; }
        .bar-blue  { height: 12px; background: #1e3a5f; float: left; border-radius: 6px 0 0 6px; }
        .bar-red   { height: 12px; background: #e53e3e; float: left; border-radius: 0 6px 6px 0; }

        h2 { color: #1e3a5f; font-size: 13pt; border-bottom: 1px solid #cbd5e0; padding-bottom: 5px; margin: 20px 0 12px; }

        table.amort { width: 100%; border-collapse: collapse; font-size: 9pt; }
        table.amort th { background: #1e3a5f; color: #fff; padding: 7px 8px; text-align: center; }
        table.amort td { padding: 5px 8px; text-align: right; border-bottom: 1px solid #e2e8f0; }
        table.amort td:first-child { text-align: center; font-weight: bold; color: #1e3a5f; }
        table.amort tr:nth-child(even) { background: #f8fafc; }
        table.amort tr:last-child td { font-weight: bold; background: #edf2f7; }
    </style>
</head>
<body>
<div class="frame"></div>
<div class="frame-inner"></div>

@php
    $nomClientStr = trim((string)($nomClient ?? ''));
    $tl = $t ?? ['titre'=>'SIMULATION DE CRÉDIT / PRÊT BANCAIRE','etablie_pour'=>'Établie pour','fait_le'=>'Fait le','client'=>'Client','montant_emprunte'=>'Montant emprunté','taux_annuel'=>"Taux d'intérêt annuel",'duree_pret'=>'Durée du prêt','mois'=>'mois','ans'=>'an(s)','mensualite'=>'Mensualité constante','total_interets'=>'Total des intérêts','total_rembourser'=>'Total à rembourser','tableau_amort'=>"Tableau d'amortissement",'col_mois'=>'Mois','col_echeance'=>'Échéance','col_capital'=>'Capital','col_interets'=>'Intérêts','col_restant'=>'Restant dû'];
@endphp

<div class="header">
    <h1><?php echo htmlspecialchars($tl['titre']); ?></h1>
    <p class="sub"><?php echo htmlspecialchars($tl['etablie_pour']); ?> : <strong><?php echo $nomClientStr !== '' ? strtoupper($nomClientStr) : '—'; ?></strong></p>
    <p class="date"><?php echo htmlspecialchars($tl['fait_le']); ?> {{ $dateGeneration }}</p>
</div>

<div class="summary">
    <table>
        <tr>
            <td><?php echo htmlspecialchars($tl['client']); ?></td>
            <td><?php echo $nomClientStr !== '' ? strtoupper($nomClientStr) : '—'; ?></td>
        </tr>
        <tr>
            <td><?php echo htmlspecialchars($tl['montant_emprunte']); ?></td>
            <td>{{ number_format($montant, 2, ',', ' ') }} {{ $devise }}</td>
        </tr>
        <tr>
            <td><?php echo htmlspecialchars($tl['taux_annuel']); ?></td>
            <td>{{ $tauxAnn }} %</td>
        </tr>
        <tr>
            <td><?php echo htmlspecialchars($tl['duree_pret']); ?></td>
            <td>{{ $duree }} <?php echo htmlspecialchars($tl['mois']); ?> ({{ round($duree / 12, 1) }} <?php echo htmlspecialchars($tl['ans']); ?>)</td>
        </tr>
        <tr>
            <td><?php echo htmlspecialchars($tl['mensualite']); ?></td>
            <td>{{ number_format($mensualite, 2, ',', ' ') }} {{ $devise }}</td>
        </tr>
        <tr>
            <td><?php echo htmlspecialchars($tl['total_interets']); ?></td>
            <td>{{ number_format($totalInterets, 2, ',', ' ') }} {{ $devise }}</td>
        </tr>
        <tr class="highlight">
            <td><?php echo htmlspecialchars($tl['total_rembourser']); ?></td>
            <td>{{ number_format($totalPaye, 2, ',', ' ') }} {{ $devise }}</td>
        </tr>
    </table>
</div>

{{-- Répartition capital / intérêts --}}
<div class="repartition">
    <table class="recap-grid">
        <tr>
            <td style="width:50%;padding:0 8px 0 0;vertical-align:top;">
                <div class="recap-cell-inner">
                    <div class="recap-label"><?php echo htmlspecialchars($tl['total_interets']); ?></div>
                    <div class="recap-value recap-value--red">{{ number_format($totalInterets, 2, ',', ' ') }} {{ $devise }}</div>
                </div>
            </td>
            <td style="width:50%;padding:0 0 0 8px;vertical-align:top;">
                <div class="recap-cell-inner">
                    <div class="recap-label"><?php echo htmlspecialchars($tl['taux_annuel']); ?></div>
                    <div class="recap-value">{{ $tauxAnn }} % / <?php echo htmlspecialchars($tl['ans']); ?></div>
                </div>
            </td>
        </tr>
    </table>
    <div class="bar-section">
        <table class="bar-labels" style="width:100%;border-collapse:collapse;margin-bottom:5px;">
            <tr>
                <td><span class="dot-blue"></span><b><?php echo htmlspecialchars($tl['col_capital']); ?> : {{ $pctCapital }}%</b></td>
                <td style="text-align:right;"><span class="dot-red"></span><b><?php echo htmlspecialchars($tl['col_interets']); ?> : {{ $pctInterets }}%</b></td>
            </tr>
        </table>
        <div class="bar-outer">
            <div class="bar-blue" style="width:{{ $pctCapital }}%;"></div><div class="bar-red" style="width:{{ $pctInterets }}%;"></div>
        </div>
    </div>
</div>

<h2><?php echo htmlspecialchars($tl['tableau_amort']); ?></h2>

<table class="amort">
    <thead>
        <tr>
            <th><?php echo htmlspecialchars($tl['col_mois']); ?></th>
            <th><?php echo htmlspecialchars($tl['col_echeance']); ?> ({{ $devise }})</th>
            <th><?php echo htmlspecialchars($tl['col_capital']); ?> ({{ $devise }})</th>
            <th><?php echo htmlspecialchars($tl['col_interets']); ?> ({{ $devise }})</th>
            <th><?php echo htmlspecialchars($tl['col_restant']); ?> ({{ $devise }})</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tableau as $row)
        <tr>
            <td>{{ $row['mois'] }}</td>
            <td>{{ number_format($row['echeance'], 2, ',', ' ') }}</td>
            <td>{{ number_format($row['capital'], 2, ',', ' ') }}</td>
            <td>{{ number_format($row['interet'], 2, ',', ' ') }}</td>
            <td>{{ number_format($row['restant'], 2, ',', ' ') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
