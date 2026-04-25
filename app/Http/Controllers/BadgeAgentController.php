<?php

namespace App\Http\Controllers;

use App\Models\BadgeAgentUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BadgeAgentController extends Controller
{
    public function index(Request $request)
    {
        BadgeAgentUsage::create([
            'user_id'    => Auth::id(),
            'ip_address' => $request->ip(),
        ]);

        return view('tools.badge-agent');
    }
}
