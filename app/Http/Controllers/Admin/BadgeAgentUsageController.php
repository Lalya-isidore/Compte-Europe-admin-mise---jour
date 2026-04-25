<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BadgeAgentUsage;

class BadgeAgentUsageController extends Controller
{
    public function index()
    {
        $usages = BadgeAgentUsage::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.badge-agent-usages', compact('usages'));
    }
}
