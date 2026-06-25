<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\PaymentClaimApprovedMail;
use App\Mail\PaymentClaimPaidMail;
use App\Mail\PaymentClaimRejectedMail;
use App\Models\PaymentClaim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PaymentClaimController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'pending');
        $claims = PaymentClaim::with('user')
            ->when($status !== 'all', fn($q) => $q->where('status', $status))
            ->orderByDesc('created_at')
            ->paginate(20);

        $counts = [
            'pending'  => PaymentClaim::where('status', 'pending')->count(),
            'approved' => PaymentClaim::where('status', 'approved')->count(),
            'paid'     => PaymentClaim::where('status', 'paid')->count(),
            'rejected' => PaymentClaim::where('status', 'rejected')->count(),
        ];

        return view('admin.payment-claims.index', compact('claims', 'status', 'counts'));
    }

    public function approve(Request $request, PaymentClaim $paymentClaim)
    {
        if (!$paymentClaim->isPending()) {
            return back()->with('error', 'Cette demande ne peut plus être approuvée.');
        }

        $data = $request->validate([
            'admin_note' => ['nullable', 'string', 'max:500'],
            'net_amount' => ['required', 'numeric', 'min:1'],
        ]);

        $rate = $paymentClaim->commissionRate();
        $paymentClaim->update([
            'status'          => 'approved',
            'admin_note'      => $data['admin_note'] ?? null,
            'approved_at'     => now(),
            'net_amount'      => $data['net_amount'],
            'commission_rate' => $rate,
        ]);

        try {
            Mail::to($paymentClaim->user->email)->send(new PaymentClaimApprovedMail($paymentClaim));
        } catch (\Throwable $e) {}

        return back()->with('success', 'Demande approuvée. Effectuez le virement mobile money.');
    }

    public function markPaid(Request $request, PaymentClaim $paymentClaim)
    {
        if (!$paymentClaim->isApproved()) {
            return back()->with('error', 'La demande doit être approuvée avant d\'être marquée payée.');
        }

        $paymentClaim->update([
            'status'  => 'paid',
            'paid_at' => now(),
        ]);

        try {
            Mail::to($paymentClaim->user->email)->send(new PaymentClaimPaidMail($paymentClaim));
        } catch (\Throwable $e) {}

        return back()->with('success', 'Demande marquée comme payée.');
    }

    public function reject(Request $request, PaymentClaim $paymentClaim)
    {
        if (!$paymentClaim->isPending()) {
            return back()->with('error', 'Cette demande ne peut plus être rejetée.');
        }

        $data = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:500'],
        ]);

        $paymentClaim->update([
            'status'           => 'rejected',
            'rejection_reason' => $data['rejection_reason'],
        ]);

        try {
            Mail::to($paymentClaim->user->email)->send(new PaymentClaimRejectedMail($paymentClaim));
        } catch (\Throwable $e) {}

        return back()->with('success', 'Demande rejetée.');
    }
}
