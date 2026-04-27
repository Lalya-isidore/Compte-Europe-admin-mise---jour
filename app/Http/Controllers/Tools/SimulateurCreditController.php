<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class SimulateurCreditController extends Controller
{
    private const COST = 500;

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

        $tableau = $this->buildAmortissement($montant, $tauxAnn, $duree);

        $mensualite   = $tableau[0]['echeance'] ?? 0;
        $totalPaye    = array_sum(array_column($tableau, 'echeance'));
        $totalInterets = array_sum(array_column($tableau, 'interet'));

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
