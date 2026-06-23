<?php

namespace App\Http\Controllers;

use App\Models\PaymentClaim;
use App\Models\PayoutMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortfolioController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $claims = PaymentClaim::where('user_id', $userId)->get();

        $totalBalance    = $claims->whereIn('status', ['approved', 'paid'])->sum('amount');
        $availableBalance = $claims->where('status', 'approved')->sum('amount');
        $pendingBalance  = $claims->where('status', 'pending')->sum('amount');
        $withdrawnBalance = $claims->where('status', 'paid')->sum('amount');

        $history = PaymentClaim::where('user_id', $userId)
                    ->orderByDesc('created_at')
                    ->paginate(15);

        $payoutMethods = PayoutMethod::where('user_id', $userId)->get();

        return view('portfolio.index', compact(
            'totalBalance', 'availableBalance', 'pendingBalance', 'withdrawnBalance',
            'history', 'payoutMethods'
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
