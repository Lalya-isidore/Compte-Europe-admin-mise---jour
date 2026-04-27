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

        .summary { background: #f0f7ff; border: 1px solid #c0d8f5; border-radius: 6px; padding: 16px 20px; margin-bottom: 24px; }
        .summary table { width: 100%; border-collapse: collapse; }
        .summary td { padding: 5px 10px; font-size: 11pt; }
        .summary td:first-child { font-weight: bold; color: #1e3a5f; width: 55%; }
        .summary td:last-child { text-align: right; color: #1a202c; }
        .summary .highlight td { background: #1e3a5f; color: #fff; border-radius: 4px; }
        .summary .highlight td:first-child { font-weight: bold; }

        h2 { color: #1e3a5f; font-size: 13pt; border-bottom: 1px solid #cbd5e0; padding-bottom: 5px; margin: 20px 0 12px; }

        table.amort { width: 100%; border-collapse: collapse; font-size: 9pt; }
        table.amort th { background: #1e3a5f; color: #fff; padding: 7px 8px; text-align: center; }
        table.amort td { padding: 5px 8px; text-align: right; border-bottom: 1px solid #e2e8f0; }
        table.amort td:first-child { text-align: center; font-weight: bold; color: #1e3a5f; }
        table.amort tr:nth-child(even) { background: #f8fafc; }
        table.amort tr:last-child td { font-weight: bold; background: #edf2f7; }

        .footer { margin-top: 28px; padding-top: 12px; border-top: 1px solid #e2e8f0; font-size: 8.5pt; color: #888; text-align: center; }
    </style>
</head>
<body>
<div class="frame"></div>
<div class="frame-inner"></div>

@php $nomClientStr = trim((string)($nomClient ?? '')); @endphp

<div class="header">
    <h1>SIMULATION DE CRÉDIT / PRÊT BANCAIRE</h1>
    <p class="sub">Établie pour : <strong><?php echo $nomClientStr !== '' ? strtoupper($nomClientStr) : '—'; ?></strong></p>
    <p class="date">Fait le {{ $dateGeneration }}</p>
</div>

<div class="summary">
    <table>
        <tr>
            <td>Client</td>
            <td><?php echo $nomClientStr !== '' ? strtoupper($nomClientStr) : '—'; ?></td>
        </tr>
        <tr>
            <td>Montant emprunté</td>
            <td>{{ number_format($montant, 2, ',', ' ') }} {{ $devise }}</td>
        </tr>
        <tr>
            <td>Taux d'intérêt annuel</td>
            <td>{{ $tauxAnn }} %</td>
        </tr>
        <tr>
            <td>Durée du prêt</td>
            <td>{{ $duree }} mois ({{ round($duree / 12, 1) }} an(s))</td>
        </tr>
        <tr>
            <td>Mensualité constante</td>
            <td>{{ number_format($mensualite, 2, ',', ' ') }} {{ $devise }}</td>
        </tr>
        <tr>
            <td>Total des intérêts</td>
            <td>{{ number_format($totalInterets, 2, ',', ' ') }} {{ $devise }}</td>
        </tr>
        <tr class="highlight">
            <td>Total à rembourser</td>
            <td>{{ number_format($totalPaye, 2, ',', ' ') }} {{ $devise }}</td>
        </tr>
    </table>
</div>

<h2>Tableau d'amortissement</h2>

<table class="amort">
    <thead>
        <tr>
            <th>Mois</th>
            <th>Échéance ({{ $devise }})</th>
            <th>Capital ({{ $devise }})</th>
            <th>Intérêts ({{ $devise }})</th>
            <th>Restant dû ({{ $devise }})</th>
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
