<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;

class AppSettingsController extends Controller
{
    public function index()
    {
        $sebpayUrl = AppSetting::get('sebpay_payment_url', '');
        return view('admin.settings.index', compact('sebpayUrl'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'sebpay_payment_url' => ['nullable', 'url', 'max:500'],
        ]);

        AppSetting::set('sebpay_payment_url', $data['sebpay_payment_url'] ?? null);

        return back()->with('success', 'Paramètres sauvegardés.');
    }
}
