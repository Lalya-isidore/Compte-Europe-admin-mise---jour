<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\PaymentClaim;
use App\Models\ToolPageVisit;
use App\Models\PayoutConfig;
use App\Models\PayoutMethod;
use App\Models\UserPaymentLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentClaimController extends Controller
{
    const CURRENCIES = ['XOF', 'XAF', 'EUR', 'USD', 'CDF', 'GNF', 'GMD'];

    public function index()
    {
        ToolPageVisit::record('payment-claims');

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

    public function destroyLink(string $currency)
    {
        UserPaymentLink::where('user_id', Auth::id())
            ->where('currency', $currency)
            ->delete();

        return back()->with('success', "Lien {$currency} supprimé.");
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'transaction_id'   => ['required', 'string', 'max:100'],
            'amount'           => ['required', 'numeric', 'min:1'],
            'currency'         => ['required', 'string', 'in:' . implode(',', self::CURRENCIES)],
            'screenshot'       => ['required', 'image', 'max:5120'],
            'payout_method_id' => ['nullable', 'integer'],
        ]);

        // Résoudre les infos de payout : payout_method prioritaire, sinon PayoutConfig
        $network = $phone = $holder = null;
        if (!empty($data['payout_method_id'])) {
            $method = PayoutMethod::where('id', $data['payout_method_id'])
                                  ->where('user_id', Auth::id())
                                  ->first();
            if ($method) {
                $network = $method->operator;
                $phone   = $method->phone_number;
                $holder  = $method->holder_name;
            }
        }
        if (!$network) {
            $config = PayoutConfig::where('user_id', Auth::id())->first();
            if (!$config) {
                return back()->withErrors(['config' => 'Configurez d\'abord un moyen de réception mobile money.'])->withInput();
            }
            $network = $config->network;
            $phone   = $config->phone_number;
            $holder  = $config->holder_name;
        }

        $path = $request->file('screenshot')->store('payment-proofs', 'public');

        PaymentClaim::create([
            'user_id'        => Auth::id(),
            'transaction_id' => $data['transaction_id'],
            'amount'         => $data['amount'],
            'currency'       => $data['currency'],
            'screenshot_path'=> $path,
            'payout_network' => $network,
            'payout_phone'   => $phone,
            'payout_holder'  => $holder,
            'status'         => 'pending',
        ]);

        return back()->with('success', 'Votre capture d\'écran a été soumise. L\'admin la vérifiera sous 24h.');
    }
}
