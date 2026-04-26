<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContratPretUsage;

class ContratPretUsageController extends Controller
{
    public function index()
    {
        $usages = ContratPretUsage::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.contrat-pret-usages', compact('usages'));
    }
}
