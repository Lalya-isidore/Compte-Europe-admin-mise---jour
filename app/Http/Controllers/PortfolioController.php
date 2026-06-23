<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\PaymentClaim;
use App\Models\PayoutMethod;
use App\Models\UserPaymentLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortfolioController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $claims = PaymentClaim::where('user_id', $userId)->get();
        $pendingBalance   = $claims->where('status', 'pending')->sum('amount');
        $withdrawnBalance = $claims->where('status', 'paid')->sum('amount');

        $history = PaymentClaim::where('user_id', $userId)
                    ->orderByDesc('created_at')
                    ->paginate(15);

        $payoutMethods = PayoutMethod::where('user_id', $userId)->get();

        // Devises disponibles pour ce user (liens créés)
        $userLinks = UserPaymentLink::where('user_id', $userId)->pluck('currency')->toArray();
        $sebpayLinks = [];
        foreach ($userLinks as $currency) {
            $url = AppSetting::get("sebpay_url_{$currency}");
            if ($url) $sebpayLinks[$currency] = $url;
        }

        return view('portfolio.index', compact(
            'pendingBalance', 'withdrawnBalance',
            'history', 'payoutMethods', 'sebpayLinks'
        ));
    }

    public function addMethod(Request $request)
    {
        $data = $request->validate([
            'operator'     => ['required', 'string', 'in:' . implode(',', PayoutMethod::OPERATORS)],
            'holder_name'  => ['required', 'string', 'max:150'],
            'phone_number' => ['required', 'string', 'max:30'],
        ]);

        PayoutMethod::create([...$data, 'user_id' => Auth::id()]);

        return back()->with('success', 'Moyen de paiement ajouté.');
    }

    public function deleteMethod(PayoutMethod $method)
    {
        if ($method->user_id !== Auth::id()) abort(403);
        $method->delete();
        return back()->with('success', 'Moyen de paiement supprimé.');
    }
}
