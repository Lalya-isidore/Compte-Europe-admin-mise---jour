<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class SimulateurCreditController extends Controller
{
    private const COST = 300;

    private array $translations = [
        'fr' => [
            'titre'           => 'SIMULATION DE CRÉDIT / PRÊT BANCAIRE',
            'etablie_pour'    => 'Établie pour',
            'fait_le'         => 'Fait le',
            'client'          => 'Client',
            'montant_emprunte'=> 'Montant emprunté',
            'taux_annuel'     => "Taux d'intérêt annuel",
            'duree_pret'      => 'Durée du prêt',
            'mois'            => 'mois',
            'ans'             => 'an(s)',
            'mensualite'      => 'Mensualité constante',
            'total_interets'  => 'Total des intérêts',
            'total_rembourser'=> 'Total à rembourser',
            'tableau_amort'   => "Tableau d'amortissement",
            'col_mois'        => 'Mois',
            'col_echeance'    => 'Échéance',
            'col_capital'     => 'Capital',
            'col_interets'    => 'Intérêts',
            'col_restant'     => 'Restant dû',
        ],
        'en' => [
            'titre'           => 'CREDIT SIMULATION / BANK LOAN',
            'etablie_pour'    => 'Prepared for',
            'fait_le'         => 'Date',
            'client'          => 'Client',
            'montant_emprunte'=> 'Loan amount',
            'taux_annuel'     => 'Annual interest rate',
            'duree_pret'      => 'Loan term',
            'mois'            => 'months',
            'ans'             => 'year(s)',
            'mensualite'      => 'Monthly payment',
            'total_interets'  => 'Total interest',
            'total_rembourser'=> 'Total to repay',
            'tableau_amort'   => 'Amortization schedule',
            'col_mois'        => 'Month',
            'col_echeance'    => 'Payment',
            'col_capital'     => 'Principal',
            'col_interets'    => 'Interest',
            'col_restant'     => 'Balance',
        ],
        'es' => [
            'titre'           => 'SIMULACIÓN DE CRÉDITO / PRÉSTAMO BANCARIO',
            'etablie_pour'    => 'Elaborado para',
            'fait_le'         => 'Fecha',
            'client'          => 'Cliente',
            'montant_emprunte'=> 'Importe del préstamo',
            'taux_annuel'     => 'Tasa de interés anual',
            'duree_pret'      => 'Plazo del préstamo',
            'mois'            => 'meses',
            'ans'             => 'año(s)',
            'mensualite'      => 'Cuota mensual',
            'total_interets'  => 'Total de intereses',
            'total_rembourser'=> 'Total a reembolsar',
            'tableau_amort'   => 'Tabla de amortización',
            'col_mois'        => 'Mes',
            'col_echeance'    => 'Cuota',
            'col_capital'     => 'Capital',
            'col_interets'    => 'Intereses',
            'col_restant'     => 'Saldo restante',
        ],
        'pt' => [
            'titre'           => 'SIMULAÇÃO DE CRÉDITO / EMPRÉSTIMO BANCÁRIO',
            'etablie_pour'    => 'Elaborado para',
            'fait_le'         => 'Data',
            'client'          => 'Cliente',
            'montant_emprunte'=> 'Valor do empréstimo',
            'taux_annuel'     => 'Taxa de juro anual',
            'duree_pret'      => 'Prazo do empréstimo',
            'mois'            => 'meses',
            'ans'             => 'ano(s)',
            'mensualite'      => 'Prestação mensal',
            'total_interets'  => 'Total de juros',
            'total_rembourser'=> 'Total a reembolsar',
            'tableau_amort'   => 'Plano de amortização',
            'col_mois'        => 'Mês',
            'col_echeance'    => 'Prestação',
            'col_capital'     => 'Capital',
            'col_interets'    => 'Juros',
            'col_restant'     => 'Saldo restante',
        ],
        'de' => [
            'titre'           => 'KREDITBERECHNUNG / BANKDARLEHEN',
            'etablie_pour'    => 'Erstellt für',
            'fait_le'         => 'Datum',
            'client'          => 'Kunde',
            'montant_emprunte'=> 'Darlehensbetrag',
            'taux_annuel'     => 'Jährlicher Zinssatz',
            'duree_pret'      => 'Darlehenslaufzeit',
            'mois'            => 'Monate',
            'ans'             => 'Jahr(e)',
            'mensualite'      => 'Monatliche Rate',
            'total_interets'  => 'Gesamtzinsen',
            'total_rembourser'=> 'Gesamtrückzahlung',
            'tableau_amort'   => 'Tilgungsplan',
            'col_mois'        => 'Monat',
            'col_echeance'    => 'Rate',
            'col_capital'     => 'Kapital',
            'col_interets'    => 'Zinsen',
            'col_restant'     => 'Restschuld',
        ],
        'it' => [
            'titre'           => 'SIMULAZIONE DI CREDITO / PRESTITO BANCARIO',
            'etablie_pour'    => 'Elaborato per',
            'fait_le'         => 'Data',
            'client'          => 'Cliente',
            'montant_emprunte'=> 'Importo del prestito',
            'taux_annuel'     => 'Tasso di interesse annuo',
            'duree_pret'      => 'Durata del prestito',
            'mois'            => 'mesi',
            'ans'             => 'anno/i',
            'mensualite'      => 'Rata mensile',
            'total_interets'  => 'Totale interessi',
            'total_rembourser'=> 'Totale da rimborsare',
            'tableau_amort'   => 'Piano di ammortamento',
            'col_mois'        => 'Mese',
            'col_echeance'    => 'Rata',
            'col_capital'     => 'Capitale',
            'col_interets'    => 'Interessi',
            'col_restant'     => 'Residuo',
        ],
        'nl' => [
            'titre'           => 'KREDIETBEREKENING / BANKLENING',
            'etablie_pour'    => 'Opgesteld voor',
            'fait_le'         => 'Datum',
            'client'          => 'Klant',
            'montant_emprunte'=> 'Leningbedrag',
            'taux_annuel'     => 'Jaarlijkse rentevoet',
            'duree_pret'      => 'Looptijd van de lening',
            'mois'            => 'maanden',
            'ans'             => 'jaar',
            'mensualite'      => 'Maandelijkse aflossing',
            'total_interets'  => 'Totale rente',
            'total_rembourser'=> 'Totaal terug te betalen',
            'tableau_amort'   => 'Aflossingstabel',
            'col_mois'        => 'Maand',
            'col_echeance'    => 'Termijn',
            'col_capital'     => 'Kapitaal',
            'col_interets'    => 'Rente',
            'col_restant'     => 'Resterend saldo',
        ],
        'pl' => [
            'titre'           => 'SYMULACJA KREDYTU / POŻYCZKI BANKOWEJ',
            'etablie_pour'    => 'Przygotowane dla',
            'fait_le'         => 'Data',
            'client'          => 'Klient',
            'montant_emprunte'=> 'Kwota pożyczki',
            'taux_annuel'     => 'Roczna stopa procentowa',
            'duree_pret'      => 'Okres kredytowania',
            'mois'            => 'miesięcy',
            'ans'             => 'rok/lat',
            'mensualite'      => 'Miesięczna rata',
            'total_interets'  => 'Łączne odsetki',
            'total_rembourser'=> 'Całkowita spłata',
            'tableau_amort'   => 'Harmonogram spłat',
            'col_mois'        => 'Miesiąc',
            'col_echeance'    => 'Rata',
            'col_capital'     => 'Kapitał',
            'col_interets'    => 'Odsetki',
            'col_restant'     => 'Pozostałe saldo',
        ],
        'hr' => [
            'titre'           => 'SIMULACIJA KREDITA / BANKOVNOG ZAJMA',
            'etablie_pour'    => 'Pripremljeno za',
            'fait_le'         => 'Datum',
            'client'          => 'Klijent',
            'montant_emprunte'=> 'Iznos zajma',
            'taux_annuel'     => 'Godišnja kamatna stopa',
            'duree_pret'      => 'Rok zajma',
            'mois'            => 'mjeseci',
            'ans'             => 'godina',
            'mensualite'      => 'Mjesečni obrok',
            'total_interets'  => 'Ukupne kamate',
            'total_rembourser'=> 'Ukupno za otplatu',
            'tableau_amort'   => 'Plan otplate',
            'col_mois'        => 'Mjesec',
            'col_echeance'    => 'Obrok',
            'col_capital'     => 'Kapital',
            'col_interets'    => 'Kamate',
            'col_restant'     => 'Preostalo',
        ],
        'ru' => [
            'titre'           => 'РАСЧЁТ КРЕДИТА / БАНКОВСКОГО ЗАЙМА',
            'etablie_pour'    => 'Составлено для',
            'fait_le'         => 'Дата',
            'client'          => 'Клиент',
            'montant_emprunte'=> 'Сумма кредита',
            'taux_annuel'     => 'Годовая процентная ставка',
            'duree_pret'      => 'Срок кредита',
            'mois'            => 'месяцев',
            'ans'             => 'год(лет)',
            'mensualite'      => 'Ежемесячный платёж',
            'total_interets'  => 'Общая сумма процентов',
            'total_rembourser'=> 'Итого к выплате',
            'tableau_amort'   => 'График погашения',
            'col_mois'        => 'Месяц',
            'col_echeance'    => 'Платёж',
            'col_capital'     => 'Основной долг',
            'col_interets'    => 'Проценты',
            'col_restant'     => 'Остаток долга',
        ],
    ];

    private array $currencies = [
        'EUR'=>'€ — Euro','GBP'=>'£ — Livre sterling','CHF'=>'Fr — Franc suisse',
        'USD'=>'$ — Dollar américain','CAD'=>'CA$ — Dollar canadien',
        'AUD'=>'A$ — Dollar australien','NZD'=>'NZ$ — Dollar néo-zélandais',
        'XOF'=>'F — Franc CFA Ouest','XAF'=>'F — Franc CFA Centre',
        'MAD'=>'DH — Dirham marocain','DZD'=>'DA — Dinar algérien','TND'=>'DT — Dinar tunisien',
        'EGP'=>'£ — Livre égyptienne','NGN'=>'₦ — Naira nigérian','GHS'=>'₵ — Cedi ghanéen',
        'ZAR'=>'R — Rand sud-africain','KES'=>'Ksh — Shilling kényan','GNF'=>'Fr — Franc guinéen',
        'XPF'=>'Fr — Franc CFP','SAR'=>'﷼ — Riyal saoudien','AED'=>'د.إ — Dirham UAE',
        'QAR'=>'﷼ — Riyal qatarien','KWD'=>'KD — Dinar koweïtien','BHD'=>'BD — Dinar bahreïni',
        'TRY'=>'₺ — Livre turque','INR'=>'₹ — Roupie indienne','CNY'=>'¥ — Yuan chinois',
        'JPY'=>'¥ — Yen japonais','KRW'=>'₩ — Won coréen','BRL'=>'R$ — Real brésilien',
        'MXN'=>'$ — Peso mexicain','ARS'=>'$ — Peso argentin','CLP'=>'$ — Peso chilien',
        'COP'=>'$ — Peso colombien','RUB'=>'₽ — Rouble russe','PLN'=>'zł — Zloty polonais',
        'SEK'=>'kr — Couronne suédoise','NOK'=>'kr — Couronne norvégienne','DKK'=>'kr — Couronne danoise',
        'CZK'=>'Kč — Couronne tchèque','HUF'=>'Ft — Forint hongrois','RON'=>'lei — Leu roumain',
        'HKD'=>'HK$ — Dollar Hong Kong','SGD'=>'$ — Dollar Singapour','MYR'=>'RM — Ringgit malaisien',
        'THB'=>'฿ — Baht thaïlandais','PHP'=>'₱ — Peso philippin','IDR'=>'Rp — Roupiah indonésien',
        'PKR'=>'₨ — Roupie pakistanaise','BDT'=>'৳ — Taka bangladais',
    ];

    public function index()
    {
        $user = Auth::user();
        return view('tools.simulateur-credit', [
            'userCredits' => $user ? (int) $user->credit_user : 0,
            'currencies'  => $this->currencies,
        ]);
    }

    public function generate(Request $request)
    {
        $data = $request->validate([
            'montant' => 'required|numeric|min:1',
            'taux'    => 'required|numeric|min:0|max:100',
            'duree'   => 'required|integer|min:1|max:600',
            'devise'  => 'required|string|in:' . implode(',', array_keys($this->currencies)),
            'lang'    => 'nullable|string|in:fr,en,es,pt,de,it,nl,pl,hr,ru',
        ]);

        $user = Auth::user();

        if ($user->credit_user < self::COST) {
            return back()
                ->withErrors(['credits' => 'Crédits insuffisants. Il vous faut ' . self::COST . ' crédits pour générer ce rapport.'])
                ->withInput();
        }

        $montant      = (float) $data['montant'];
        $tauxAnn      = (float) $data['taux'];
        $duree        = (int)   $data['duree'];
        $deviseCode   = $data['devise'];
        $deviseSymbol = explode(' — ', $this->currencies[$deviseCode])[0];
        $nomClient    = trim((string) ($_POST['nom_client'] ?? ''));
        $lang         = $data['lang'] ?? 'fr';
        $t            = $this->translations[$lang] ?? $this->translations['fr'];

        $tableau = $this->buildAmortissement($montant, $tauxAnn, $duree);

        $mensualite   = $tableau[0]['echeance'] ?? 0;
        $totalPaye    = array_sum(array_column($tableau, 'echeance'));
        $totalInterets = array_sum(array_column($tableau, 'interet'));

        $pctCapital   = $totalPaye > 0 ? round($montant / $totalPaye * 100, 1) : 100;
        $pctInterets  = $totalPaye > 0 ? round($totalInterets / $totalPaye * 100, 1) : 0;

        DB::table('users')->where('id', $user->id)->decrement('credit_user', self::COST);

        $pdf = Pdf::loadView('tools.simulateur-credit-pdf', [
            'montant'       => $montant,
            'tauxAnn'       => $tauxAnn,
            'duree'         => $duree,
            'devise'        => $deviseSymbol,
            'nomClient'     => $nomClient,
            'mensualite'    => $mensualite,
            'totalPaye'     => $totalPaye,
            'totalInterets' => $totalInterets,
            'tableau'       => $tableau,
            'dateGeneration' => now()->format('d/m/Y'),
            'pctCapital'    => $pctCapital,
            'pctInterets'   => $pctInterets,
            't'             => $t,
        ])->setPaper('a4', 'portrait');

        $filename = 'simulation-credit-' . now()->format('Ymd-His') . '.pdf';

        return $pdf->download($filename);
    }

    private function buildAmortissement(float $montant, float $tauxAnn, int $duree): array
    {
        if ($tauxAnn == 0) {
            $mensualite = $montant / $duree;
            $tableau = [];
            $restant = $montant;
            for ($i = 1; $i <= $duree; $i++) {
                $capital  = round($mensualite, 2);
                $restant  = round($restant - $capital, 2);
                $tableau[] = [
                    'mois'         => $i,
                    'echeance'     => round($mensualite, 2),
                    'capital'      => $capital,
                    'interet'      => 0,
                    'restant'      => max(0, $restant),
                ];
            }
            return $tableau;
        }

        $tauxMens = $tauxAnn / 100 / 12;
        $mensualite = $montant * ($tauxMens * pow(1 + $tauxMens, $duree)) / (pow(1 + $tauxMens, $duree) - 1);

        $tableau = [];
        $restant = $montant;

        for ($i = 1; $i <= $duree; $i++) {
            $interet  = round($restant * $tauxMens, 2);
            $capital  = round($mensualite - $interet, 2);
            $restant  = round($restant - $capital, 2);
            $tableau[] = [
                'mois'     => $i,
                'echeance' => round($mensualite, 2),
                'capital'  => $capital,
                'interet'  => $interet,
                'restant'  => max(0, $restant),
            ];
        }

        return $tableau;
    }
}
