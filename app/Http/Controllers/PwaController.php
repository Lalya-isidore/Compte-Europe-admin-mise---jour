<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PwaController extends Controller
{
    public function markInstalled(Request $request)
    {
        $user = Auth::user();
        if ($user && !$user->pwa_installed_at) {
            $user->update(['pwa_installed_at' => now()]);
        }
        return response()->json(['ok' => true]);
    }
}
