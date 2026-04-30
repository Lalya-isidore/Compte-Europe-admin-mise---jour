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
        $adminEmails = ['isiserviceplus@gmail.com', 'lalyaisidore@gmail.com', 'floralalya4@gmail.com', 'floralalya@gmail.com'];

        $baseQuery = fn() => PlatformVisit::whereHas('user', fn($q) => $q->whereNotIn('email', $adminEmails));

        $visitToday  = $baseQuery()->where('created_at', '>=', $today)->count();
        $visitWeek   = $baseQuery()->where('created_at', '>=', $startWeek)->count();
        $visitMonth  = $baseQuery()->where('created_at', '>=', $startMonth)->count();

        // Visites par jour sur les 30 derniers jours
        $dailyStats = $baseQuery()
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total'),
                DB::raw('COUNT(DISTINCT user_id) as unique_users')
            )
            ->where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->groupBy('date')
            ->orderByDesc('date')
            ->get();

        // Dernières visites (exclure l'admin)
        $recentVisits = $baseQuery()
            ->with('user')
            ->latest()
            ->take(20)
            ->get();

        return view('admin.platform-visits', compact(
            'visitToday', 'visitWeek', 'visitMonth',
            'dailyStats', 'recentVisits'
        ));
    }
}
