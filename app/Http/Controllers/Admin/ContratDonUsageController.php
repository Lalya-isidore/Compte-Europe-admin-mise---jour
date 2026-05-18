<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContratDonUsage;

class ContratDonUsageController extends Controller
{
    private const EXCLUDED_EMAILS = [
        'candide730@gmail.com',
        'lalyaisidore@gmail.com',
        'floralalya@gmail.com',
        'isidore@lannkin.com',
        'isiserviceplus@gmail.com',
        'durandfranck249@gmail.com',
    ];

    public function index()
    {
        $usages = ContratDonUsage::with('user')
            ->whereHas('user', fn($q) => $q->whereNotIn('email', self::EXCLUDED_EMAILS))
            ->latest()
            ->take(50)
            ->get();

        return view('admin.contrat-don-usages', compact('usages'));
    }
}
