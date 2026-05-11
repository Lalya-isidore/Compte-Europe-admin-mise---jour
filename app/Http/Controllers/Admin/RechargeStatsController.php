<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RechargeTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RechargeStatsController extends Controller
{
    public function index()
    {
        $byDay = $this->statsByDay();
        $byWeek = $this->statsByWeek();
        $byMonth = $this->statsByMonth();
        $byYear = $this->statsByYear();

        $totals = [
            'transactions' => RechargeTransaction::where('status', 'completed')->count(),
            'amount'       => RechargeTransaction::where('status', 'completed')->sum('amount'),
            'credits'      => RechargeTransaction::where('status', 'completed')->sum('credits_earned'),
            'users'        => RechargeTransaction::where('status', 'completed')->distinct('user_id')->count('user_id'),
        ];

        return view('admin.recharge-stats', compact('byDay', 'byWeek', 'byMonth', 'byYear', 'totals'));
    }

    private function statsByDay()
    {
        return RechargeTransaction::where('status', 'completed')
            ->where('completed_at', '>=', Carbon::now()->subDays(30))
            ->select(
                DB::raw('DATE(completed_at) as periode'),
                DB::raw('COUNT(*) as nb_depots'),
                DB::raw('SUM(amount) as montant_total'),
                DB::raw('SUM(credits_earned) as credits_total'),
                DB::raw('COUNT(DISTINCT user_id) as nb_utilisateurs')
            )
            ->groupBy('periode')
            ->orderByDesc('periode')
            ->get();
    }

    private function statsByWeek()
    {
        return RechargeTransaction::where('status', 'completed')
            ->where('completed_at', '>=', Carbon::now()->subWeeks(12))
            ->select(
                DB::raw('YEAR(completed_at) as annee'),
                DB::raw('WEEK(completed_at, 1) as semaine'),
                DB::raw('MIN(DATE(completed_at)) as debut_semaine'),
                DB::raw('MAX(DATE(completed_at)) as fin_semaine'),
                DB::raw('COUNT(*) as nb_depots'),
                DB::raw('SUM(amount) as montant_total'),
                DB::raw('SUM(credits_earned) as credits_total'),
                DB::raw('COUNT(DISTINCT user_id) as nb_utilisateurs')
            )
            ->groupBy('annee', 'semaine')
            ->orderByDesc('annee')
            ->orderByDesc('semaine')
            ->get();
    }

    private function statsByMonth()
    {
        return RechargeTransaction::where('status', 'completed')
            ->where('completed_at', '>=', Carbon::now()->subMonths(12))
            ->select(
                DB::raw('YEAR(completed_at) as annee'),
                DB::raw('MONTH(completed_at) as mois'),
                DB::raw('COUNT(*) as nb_depots'),
                DB::raw('SUM(amount) as montant_total'),
                DB::raw('SUM(credits_earned) as credits_total'),
                DB::raw('COUNT(DISTINCT user_id) as nb_utilisateurs')
            )
            ->groupBy('annee', 'mois')
            ->orderByDesc('annee')
            ->orderByDesc('mois')
            ->get();
    }

    private function statsByYear()
    {
        return RechargeTransaction::where('status', 'completed')
            ->select(
                DB::raw('YEAR(completed_at) as annee'),
                DB::raw('COUNT(*) as nb_depots'),
                DB::raw('SUM(amount) as montant_total'),
                DB::raw('SUM(credits_earned) as credits_total'),
                DB::raw('COUNT(DISTINCT user_id) as nb_utilisateurs')
            )
            ->groupBy('annee')
            ->orderByDesc('annee')
            ->get();
    }
}
