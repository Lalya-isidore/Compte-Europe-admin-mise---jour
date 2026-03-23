<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TarifsController extends Controller
{
    public function index()
    {
        $paidTools = [
            [
                'title' => 'SMS Pro',
                'items' => [
                    'Tarif Standard (70 Caractères => 1 SMS) : 500 Crédits',
                    'Tarif Double (140 Caractères => 2 SMS) : 1000 Crédits',
                    'Tarif triple (210 Caractères => 3 SMS) : 2000 Crédits',
                    'Etc...'
                ]
            ],
            [
                'title' => 'Mail Flash Pro',
                'items' => [
                    'Tarif Standard (Caractères illimités) : 1000 Crédits',
                    "Tarif Standard avec ajout d'un fichier image, word ou pdf joint : 2000 Crédits"
                ]
            ],
            [
                'title' => 'Mail Pro Privé',
                'items' => [
                    "Tarif défini par rapport à l'extension du nom de domaine ciblé"
                ]
            ],
            [
                'title' => 'Flash Compte Pro V1',
                'items' => [
                    'Tarif Standard : 4000 Crédits',
                    'Ajout des alertes par e-mail : Gratuit',
                    'Ajout des alertes par sms : 1000 Crédits'
                ]
            ]
        ];

        $freeTools = [
            ['label' => 'Mail extractor', 'badge' => 'Outil Gratuit'],
            [
                'label' => "Vérification d'un site web",
                'badge' => 'Outil Gratuit'
            ],
            ['label' => "Raccourcissement d'URL", 'badge' => 'Outil Gratuit'],
            ['label' => 'Vente de Crypto USDT', 'badge' => 'Accès Libre'],
            ['label' => 'Numéros virtuels', 'badge' => 'Accès Libre']
        ];

        return view('tarifs.index', compact('paidTools', 'freeTools'));
    }
}

