<?php

namespace App\Http\Controllers;

use App\Models\PayoutConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayoutConfigController extends Controller
{
    public function edit()
    {
        $config = PayoutConfig::where('user_id', Auth::id())->first();
        return view('payout-config.edit', compact('config'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'network'      => ['required', 'in:MTN,MOOV,CELTIS'],
            'phone_number' => ['required', 'string', 'max:20'],
            'holder_name'  => ['nullable', 'string', 'max:100'],
        ]);

        PayoutConfig::updateOrCreate(
            ['user_id' => Auth::id()],
            $data
        );

        return back()->with('success', 'Configuration sauvegardée.');
    }
}
