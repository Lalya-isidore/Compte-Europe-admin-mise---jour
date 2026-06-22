<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;

class AppSettingsController extends Controller
{
    const CURRENCIES = ['XOF', 'XAF', 'EUR', 'USD', 'CDF', 'GNF', 'GMD'];

    public function index()
    {
        $sebpayLinks = [];
        foreach (self::CURRENCIES as $currency) {
            $sebpayLinks[$currency] = AppSetting::get("sebpay_url_{$currency}", '');
        }
        return view('admin.settings.index', compact('sebpayLinks'));
    }

    public function update(Request $request)
    {
        $rules = [];
        foreach (self::CURRENCIES as $currency) {
            $rules["sebpay_url_{$currency}"] = ['nullable', 'url', 'max:500'];
        }
        $data = $request->validate($rules);

        foreach (self::CURRENCIES as $currency) {
            $key = "sebpay_url_{$currency}";
            $url = $data[$key] ?? null;
            if ($url) {
                AppSetting::set($key, $url);
            } else {
                AppSetting::where('key', $key)->delete();
            }
        }

        return back()->with('success', 'Paramètres sauvegardés.');
    }
}
