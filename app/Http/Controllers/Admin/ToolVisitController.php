<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ToolPageVisit;

class ToolVisitController extends Controller
{
    private const TOOL_NAMES = [
        'simulateur-credit' => 'Simulateur de Crédit',
        'phone-verify'      => 'Vérification Téléphone',
        'iban-check'        => 'Vérification IBAN',
        'flash-compte-pro'       => 'Flash Compte Pro',
        'flash-compte-pro-video' => 'Vidéo Flash Compte Pro',
        'coupon'            => 'Collecte de Coupon',
        'qr-generator'      => 'Générateur QR Code',
        'url-check'         => 'Vérification URL',
        'url-shortener'     => 'Raccourcisseur URL',
        'mail-extractor'    => 'Extracteur d\'E-mails',
        'recharge'          => 'Page de Recharge',
        'sms-pro'           => 'SMS Pro',
        'payment-claims'    => 'Demande de Paiement',
    ];

    private const EXCLUDED_EMAILS = [
        'candide730@gmail.com',
        'lalyaisidore@gmail.com',
        'floralalya@gmail.com',
        'isidore@lannkin.com',
        'isiserviceplus@gmail.com',
        'durandfranck249@gmail.com',
    ];

    public function show(string $tool)
    {
        abort_unless(array_key_exists($tool, self::TOOL_NAMES), 404);

        $visits = ToolPageVisit::with('user')
            ->where('tool_slug', $tool)
            ->where(function ($q) {
                $q->whereNull('user_id')
                  ->orWhereHas('user', fn($q2) => $q2->whereNotIn('email', self::EXCLUDED_EMAILS));
            })
            ->latest()
            ->take(100)
            ->get();

        return view('admin.tool-visits', [
            'visits'   => $visits,
            'toolSlug' => $tool,
            'toolName' => self::TOOL_NAMES[$tool],
        ]);
    }
}
