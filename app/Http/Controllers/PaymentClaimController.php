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
    public function index()
    {
        $claims     = PaymentClaim::where('user_id', Auth::id())
                        ->orderByDesc('created_at')
                        ->paginate(15);
        $config     = PayoutConfig::where('user_id', Auth::id())->first();
        $sebpayUrl  = AppSetting::get('sebpay_payment_url');

        return view('payment-claims.index', compact('claims', 'config', 'sebpayUrl'));
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
            'screenshot'     => ['required', 'image', 'max:5120'],
        ]);

        $path = $request->file('screenshot')->store('payment-proofs', 'public');

        PaymentClaim::create([
            'user_id'        => Auth::id(),
            'transaction_id' => $data['transaction_id'],
            'amount'         => $data['amount'],
            'currency'       => 'XOF',
            'screenshot_path'=> $path,
            'payout_network' => $config->network,
            'payout_phone'   => $config->phone_number,
            'payout_holder'  => $config->holder_name,
            'status'         => 'pending',
        ]);

        return back()->with('success', 'Votre demande a été soumise. L\'admin la vérifiera sous 24h.');
    }
}
