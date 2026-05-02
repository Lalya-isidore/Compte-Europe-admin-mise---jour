<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class PwaInstallController extends Controller
{
    public function index()
    {
        $users = User::whereNotNull('pwa_installed_at')
            ->orderByDesc('pwa_installed_at')
            ->get();

        $total = $users->count();

        return view('admin.pwa-installs', compact('users', 'total'));
    }
}
