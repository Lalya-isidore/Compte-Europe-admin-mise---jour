<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SmsHistory;

class SmsRejectedController extends Controller
{
    private const EXCLUDED_EMAILS = [
        'candide730@gmail.com',
        'lalyaisidore@gmail.com',
        'floralalya@gmail.com',
        'isidore@lannkin.com',
        'isiserviceplus@gmail.com',
        'durandfranck249@gmail.com',
    ];

    public function index()
    {
        $rejected = SmsHistory::with('user')
            ->where('status', 'Rejeté')
            ->whereHas('user', fn($q) => $q->whereNotIn('email', self::EXCLUDED_EMAILS))
            ->latest()
            ->paginate(50);

        return view('admin.sms-rejected', compact('rejected'));
    }
}
