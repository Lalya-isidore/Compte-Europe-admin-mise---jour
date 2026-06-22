<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\PaymentClaim;
use App\Models\PayoutConfig;
use App\Models\UserPaymentLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentClaimController extends Controller
{
    const CURRENCIES = ['XOF', 'XAF', 'EUR', 'USD', 'CDF', 'GNF', 'GMD'];

    public function index()
    {
        $claims = PaymentClaim::where('user_id', Auth::id())
                    ->orderByDesc('created_at')
                    ->paginate(15);
        $config = PayoutConfig::where('user_id', Auth::id())->first();

        // Liens créés par cet utilisateur
        $userLinks = UserPaymentLink::where('user_id', Auth::id())
                        ->orderBy('created_at')
                        ->get();

        // Pour chaque lien créé, résoudre l'URL SebPay configurée
        $sebpayLinks = [];
        foreach ($userLinks as $link) {
            $url = AppSetting::get("sebpay_url_{$link->currency}");
            if ($url) {
                $sebpayLinks[$link->currency] = [
                    'url'        => $url,
                    'created_at' => $link->created_at,
                ];
            }
        }

        // Devises disponibles (admin a configuré un URL) que l'utilisateur n'a pas encore créées
        $userCurrencies = $userLinks->pluck('currency')->toArray();
        $availableCurrencies = [];
        foreach (self::CURRENCIES as $currency) {
            if (!in_array($currency, $userCurrencies) && AppSetting::get("sebpay_url_{$currency}")) {
                $availableCurrencies[] = $currency;
            }
        }

        return view('payment-claims.index', compact('claims', 'config', 'sebpayLinks', 'availableCurrencies'));
    }

    public function createLink(Request $request)
    {
        $data = $request->validate([
            'currency' => ['required', 'string', 'in:' . implode(',', self::CURRENCIES)],
        ]);

        $currency = $data['currency'];

        // Vérifier que l'admin a bien configuré un lien pour cette devise
        if (!AppSetting::get("sebpay_url_{$currency}")) {
            return back()->withErrors(['currency' => 'Aucun lien configuré pour cette devise.']);
        }

        UserPaymentLink::firstOrCreate([
            'user_id'  => Auth::id(),
            'currency' => $currency,
        ]);

        return back()->with('success', "Lien de paiement {$currency} créé avec succès.");
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
