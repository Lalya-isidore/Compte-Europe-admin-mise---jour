<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlatformVisit;
use Illuminate\Support\Facades\DB;

class PlatformVisitController extends Controller
{
    public function index()
    {
        $today       = now()->startOfDay();
        $startWeek   = now()->startOfWeek();
        $startMonth  = now()->startOfMonth();

        $visitToday  = PlatformVisit::where('created_at', '>=', $today)->count();
        $visitWeek   = PlatformVisit::where('created_at', '>=', $startWeek)->count();
        $visitMonth  = PlatformVisit::where('created_at', '>=', $startMonth)->count();

        // Visites par jour sur les 30 derniers jours
        $dailyStats = PlatformVisit::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total'),
                DB::raw('COUNT(DISTINCT user_id) as unique_users')
            )
            ->where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->groupBy('date')
            ->orderByDesc('date')
            ->get();

        // Dernières visites
        $recentVisits = PlatformVisit::with('user')
            ->latest()
            ->take(20)
            ->get();

        return view('admin.platform-visits', compact(
            'visitToday', 'visitWeek', 'visitMonth',
            'dailyStats', 'recentVisits'
        ));
    }
}
