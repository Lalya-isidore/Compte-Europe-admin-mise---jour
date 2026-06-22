<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\PaymentClaim;
use App\Models\PayoutConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentClaimController extends Controller
{
    const CURRENCIES = ['XOF', 'XAF', 'EUR', 'USD', 'CDF', 'GNF', 'GMD'];

    public function index()
    {
        $claims = PaymentClaim::where('user_id', Auth::id())
                    ->orderByDesc('created_at')
                    ->paginate(15);
        $config = PayoutConfig::where('user_id', Auth::id())->first();

        $sebpayLinks = [];
        foreach (self::CURRENCIES as $currency) {
            $url = AppSetting::get("sebpay_url_{$currency}");
            if ($url) {
                $sebpayLinks[$currency] = $url;
            }
        }

        return view('payment-claims.index', compact('claims', 'config', 'sebpayLinks'));
    }

    public function store(Request $request)
    {
        $config = PayoutConfig::where('user_id', Auth::id())->first();

        if (!$config) {
            return back()->withErrors(['config' => 'Veuillez d\'abord configurer votre numéro de réception mobile money.'])->withInput();
        }

        $data = $request->validate([
            'transaction_id' => ['required', 'string', 'max:100'],
            'amount'         => ['required', 'numeric', 'min:1'],
            'currency'       => ['required', 'string', 'in:' . implode(',', self::CURRENCIES)],
            'screenshot'     => ['required', 'image', 'max:5120'],
        ]);

        $path = $request->file('screenshot')->store('payment-proofs', 'public');

        PaymentClaim::create([
            'user_id'        => Auth::id(),
            'transaction_id' => $data['transaction_id'],
            'amount'         => $data['amount'],
            'currency'       => $data['currency'],
            'screenshot_path'=> $path,
            'payout_network' => $config->network,
            'payout_phone'   => $config->phone_number,
            'payout_holder'  => $config->holder_name,
            'status'         => 'pending',
        ]);

        return back()->with('success', 'Votre demande a été soumise. L\'admin la vérifiera sous 24h.');
    }
}
