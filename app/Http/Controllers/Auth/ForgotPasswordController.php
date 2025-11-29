<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Show the form to request a password reset link.
     */
    public function showLinkRequestForm()
    {
        // Use a simple view under resources/views/auth/passwords/email.blade.php
        // If you have a custom view, update the path accordingly.
        return view('auth.passwords.email');
    }

    /**
     * Handle an incoming password reset link request.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        if ($request->wantsJson() || $request->ajax() || $request->isJson()) {
            if ($status === Password::RESET_LINK_SENT) {
                return response()->json(['status' => __($status)], 200);
            }
            return response()->json(['error' => __($status)], 422);
        }

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
}