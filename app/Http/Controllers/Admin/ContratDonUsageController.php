<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContratDonUsage;

class ContratDonUsageController extends Controller
{
    public function index()
    {
        $usages = ContratDonUsage::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.contrat-don-usages', compact('usages'));
    }
}
