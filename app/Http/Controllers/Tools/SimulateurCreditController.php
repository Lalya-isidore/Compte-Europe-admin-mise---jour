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

    public function index()
    {
        $user = Auth::user();
        return view('tools.simulateur-credit', [
            'userCredits' => $user ? (int) $user->credit_user : 0,
        ]);
    }

    public function generate(Request $request)
    {
        $data = $request->validate([
            'montant'    => 'required|numeric|min:1',
            'taux'       => 'required|numeric|min:0|max:100',
            'duree'      => 'required|integer|min:1|max:600',
            'nom_client' => 'nullable|string|max:100',
            'devise'     => 'required|string|max:10',
        ]);

        $user = Auth::user();

        if ($user->credit_user < self::COST) {
            return back()
                ->withErrors(['credits' => 'Crédits insuffisants. Il vous faut ' . self::COST . ' crédits pour générer ce rapport.'])
                ->withInput();
        }

        $montant   = (float) $data['montant'];
        $tauxAnn   = (float) $data['taux'];
        $duree     = (int)   $data['duree'];
        $devise    = $data['devise'];
        $nomClient = trim((string) $request->post('nom_client', ''));

        $tableau = $this->buildAmortissement($montant, $tauxAnn, $duree);

        $mensualite   = $tableau[0]['echeance'] ?? 0;
        $totalPaye    = array_sum(array_column($tableau, 'echeance'));
        $totalInterets = array_sum(array_column($tableau, 'interet'));

        DB::table('users')->where('id', $user->id)->decrement('credit_user', self::COST);

        $pdf = Pdf::loadView('tools.simulateur-credit-pdf', [
            'montant'       => $montant,
            'tauxAnn'       => $tauxAnn,
            'duree'         => $duree,
            'devise'        => $devise,
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
