<?php
$langDir = 'c:/xampp/htdocs/Banque_en_Ligne/lang/';

// Clé art9_p1 correcte (avec créditée)
$art9Key = "Il est expressément convenu que le Prêteur ou l'institution bancaire partenaire peut exiger de l'Emprunteur le versement anticipé d'une somme équivalente à une (1) jusqu'à trois (3) mensualités du prêt. Ce versement est destiné à servir de garantie d'activation technique des flux de transfert externes et de preuve d'engagement de bonne foi de l'Emprunteur. Cette somme sera intégralement créditée au bénéfice de l'Emprunteur et déduite des échéances futures du prêt, réduisant ainsi le nombre total de mensualités restant dues.";

$mapping = [
    'UNION EUROPÉENNE'                    => 'union_eu',
    'SERVICE DE JUSTICE ET DROITS HUMAINS' => 'service_justice',
    'TRIBUNAL EUROPÉEN DE PREMIÈRE INSTANCE' => 'tribunal',
    'CONTRAT DE PRÊT'                     => 'titre',
    'REGISTRE DU TRIBUNAL'                => 'registre',
    'Service de coordination judiciaire'  => 'coordination',
    'CONTRAT N°'                          => 'contrat_no',
    'ENTRE LES SOUSSIGNÉS'                => 'soussignes',
    'LE PRÊTEUR'                          => 'le_preteur',
    'LE BÉNÉFICIAIRE'                     => 'beneficiaire',
    'Adresse :'                           => 'adresse',
    'Capacité :'                          => 'capacite',
    'Client ID:'                          => 'client_id',
    'Ci-après dénommé "Le Prêteur"'       => 'denom_preteur',
    'Ci-après dénommé "L\'Emprunteur"'    => 'denom_empr',
    'Il a été expressément convenu et arrêté ce qui suit :' => 'convenu',
    'ARTICLE 1 : OBJET DU PRÊT'           => 'art1_titre',
    'Le Prêteur consent à l\'Emprunteur, qui accepte, un prêt d\'un montant principal de' => 'art1_p1a',
    'Ce prêt est régi par les dispositions légales internationales ainsi que par les présentes conditions générales et particulières.' => 'art1_p1b',
    'L\'Emprunteur reconnaît avoir reçu toutes les informations précontractuelles nécessaires et accepte que les fonds soient destinés à un usage personnel ou professionnel légitime dans son pays de résidence :' => 'art1_p2a',
    'ARTICLE 2 : MODALITÉS DE REMBOURSEMENT' => 'art2_titre',
    'Ce prêt est consenti pour une durée de' => 'art2_intro',
    'mois'                                => 'mois',
    'ans'                                 => 'ans',
    'Le remboursement s\'effectuera par mensualités constantes selon les modalités suivantes :' => 'art2_suite',
    'Montant principal du prêt'           => 'montant_p',
    'Taux d\'intérêt annuel (fixe)'       => 'taux_label',
    'Nombre d\'échéances mensuelles'      => 'nb_echeances',
    'Montant de l\'échéance mensuelle'    => 'mensualite',
    'ARTICLE 3 : CONDITIONS DE CRÉDIT'    => 'art3_titre',
    'Le prêt sera débité automatiquement du compte bancaire de l\'Emprunteur selon le mandat SEPA joint. L\'Emprunteur peut également choisir de payer par virement bancaire mensuel ou par tout autre moyen de paiement légalement admissible, en appliquant le même mode de paiement de manière cohérente.' => 'art3_p1',
    'ARTICLE 4 : OBSERVATION ET UTILISATION DES CARTES' => 'art4_titre',
    'Observation :'                       => 'observation',
    'L\'Emprunteur s\'interdit d\'utiliser des cartes de crédit de quelque nature que ce soit (Article 1.513 du Code Civil).' => 'art4_p1',
    'Les Parties conviennent que le délai de notification pour chaque Débit Direct est de 5 jours ouvrables avant l\'échéance du Débit Direct concerné. Ce délai de notification ne peut être modifié que moyennant accord préalable de l\'Emprunteur et du Créancier, dans le cadre d\'un modèle spécial d\'amortissement.' => 'art4_p2',
    'La valeur des intérêts, la valeur des échéances et la durée des mensualités sont indiqués dans le tableau d\'amortissement. L\'Emprunteur doit payer les intérêts et le capital selon les modalités indiquées. Cet échéancier d\'intérêts ne peut être modifié que moyennant accord préalable spécial entre les parties.' => 'art4_p3',
    'ARTICLE 5 : PAIEMENT ANTICIPÉ'       => 'art5_titre',
    'Toutes les sommes dues par l\'Emprunteur, en principal, intérêts et accessoires, seront payables sans aucune déduction pour quelque motif que ce soit.' => 'art5_p1',
    'Sans préjudice de toute action en justice par l\'Emprunteur pour non-respect de quelque engagement que ce soit par le Créancier, celui-ci pourra exiger le paiement intégral du capital restant dû en cas de :' => 'art5_p2',
    'Non-respect par l\'Emprunteur de l\'une quelconque de ses obligations (notamment en cas de défaillance, suspension de paiements, ou tout autre événement pouvant affecter le patrimoine de l\'Emprunteur),' => 'art5_li1',
    'Refus, aliénation ou toute autre disposition du Créancier susceptible d\'anticiper ou d\'empêcher le remboursement du prêt,' => 'art5_li2',
    'Tentative de l\'Emprunteur d\'obtenir ou d\'exécuter le contrat par quelque moyen illégal, comme la cession, la sous-location ou autre.' => 'art5_li3',
    'ARTICLE 6 : ATTRIBUTION DES RESPONSABILITÉS ET JURIDICTION' => 'art6_titre',
    'Le présent contrat est régi par les principes du droit international des contrats et les conventions européennes applicables en matière de crédit. Les parties reconnaissent la nature internationale de cette transaction financière.' => 'art6_p1',
    'En cas de litige relatif à la validité, l\'interprétation ou l\'exécution du présent contrat, les parties conviennent de privilégier en premier lieu la médiation et la conciliation amiable.' => 'art6_p2',
    'À défaut d\'accord amiable, tout différend sera soumis à la juridiction compétente du pays de résidence de l\'Emprunteur, conformément aux règles de compétence territoriale en vigueur. L\'Emprunteur bénéficie ainsi de la protection juridictionnelle de son domicile légal.' => 'art6_p3',
    'ARTICLE 7 : REMBOURSEMENT ANTICIPÉ'  => 'art7_titre',
    'Les paiements seront effectués mensuellement. Les Mensualités de remboursement calculées à tout moment, total ou partiel, ne peuvent être remboursées avant l\'échéance.' => 'art7_p1',
    'En cas de remboursement anticipé, l\'Emprunteur doit rembourser au Créancier exactement les dépenses occasionnées par ce désistement.' => 'art7_p2',
    'Remboursement anticipé partiel :'    => 'art7_partiel',
    'Les Mensualités de remboursement et le solde devront être recalculés à 5% de la valeur du prêt, sauf en cas de solde débiteur. Dans ce cas, la garantie sera également réduite en conséquence, sans que le montant restant dû ne puisse excéder 0,2 points de pourcentage du capital restant dû avant le remboursement.' => 'art7_p3',
    'ARTICLE 8 : RETARDS DE PAIEMENT'    => 'art8_titre',
    'En cas de non-respect du principal, des intérêts et des accessoires ou d\'une fraction des amortissements non remboursés à temps, l\'Emprunteur sera tenu de payer une pénalité de 0,2 points de pourcentage du capital du prêt, augmentée de 0,2 points de pourcentage, sans préjudice.' => 'art8_p1',
    'Cette pénalité augmentée sera également appliquée aux intérêts, lorsque des intérêts débiteurs sont exigibles conformément aux termes de l\'Article 1.108 du Code Civil. Cette stipulation d\'intérêts ne peut préjudicier au Créancier qui pourra anticiper le remboursement conformément aux conditions prévues dans le présent document et, en conséquence, exiger le remboursement de la totalité du capital restant dû.' => 'art8_p2',
    'La première échéance du prêt mensuel sera payée trois mois après réception des fonds sur le compte bancaire, entre les 5 et 7 de chaque mois.' => 'art8_p3',
    'En tout état de cause, l\'Emprunteur doit rembourser au Créancier le montant total ou partiel des paiements effectués à 5% de la valeur du prêt, excluant le cas du solde débiteur. Dans ces cas, les paiements couvriront une taxe compensatoire qui sera égale aux intérêts du capital restant dû avant le remboursement.' => 'art8_p4',
    'ARTICLE 9 : GARANTIE D\'ACTIVATION ET ENGAGEMENT' => 'art9_titre',
    'ARTICLE 10 : DÉCLARATION ET SIGNATURE' => 'art10_titre',
    'En signant ci-dessous et en haut de chaque page, les parties de l\'accord s\'engagent à respecter et à atteindre les termes et les termes de cet accord.' => 'art10_p1',
    'Les parties de l\'accord reconnaissent avoir reçu et lu cet Accord. Les parties déclarent avoir reçu et lu le présent contrat, soumettant les annexes qui en font partie.' => 'art10_p2',
    'L\'Emprunteur :'                     => 'l_emprunteur',
    'Bénéficiaire légal du prêt'          => 'benef_legal',
    'Le Prêteur représenté par :'         => 'preteur_rep',
    'IMPORTANT : CE CONTRAT DOIT ÊTRE IMPRIMÉ, DATÉ ET SIGNÉ PAR L\'EMPRUNTEUR AFIN DE DÉCLENCHER LE VIREMENT DES FONDS SUR LE COMPTE BANCAIRE DÉSIGNÉ.' => 'important',
];

// Valeurs manuelles pour les clés absentes de Banque_en_ligne
$manual = [
    'pl' => [
        'pays'     => 'Kraj:',
        'civilite' => 'Pan/Pani',
        'fait_a'   => 'Sporządzono w',
        'le'       => 'dnia',
    ],
    'hr' => [
        'pays'     => 'Zemlja:',
        'civilite' => 'G./Gđa',
        'fait_a'   => 'Sastavljeno u',
        'le'       => 'dana',
        // art8_p4 absent dans hr.json — fallback EN
        'art8_p4'  => 'In any case, the Borrower must reimburse the Creditor the total or partial amount of payments made at 5% of the loan value, excluding the case of debit balance. In these cases, payments will cover a compensatory tax equal to the interest on the outstanding capital before repayment.',
    ],
    'ru' => [
        'pays'     => 'Страна:',
        'civilite' => 'Г-н/Г-жа',
        'fait_a'   => 'Составлено в',
        'le'       => 'от',
    ],
];

foreach (['pl', 'hr', 'ru'] as $lang) {
    $data = json_decode(file_get_contents($langDir . $lang . '.json'), true);
    $arr = [];

    // Clés depuis Banque_en_ligne
    foreach ($mapping as $frKey => $internalKey) {
        $val = $data[$frKey] ?? null;
        if ($val && $val !== $frKey) {
            $arr[$internalKey] = $val;
        }
    }

    // art9_p1 avec la bonne clé
    $v9 = $data[$art9Key] ?? null;
    if ($v9) $arr['art9_p1'] = $v9;

    // Clés manuelles
    foreach ($manual[$lang] as $k => $v) {
        if (!isset($arr[$k]) || str_starts_with($arr[$k] ?? '', 'MANQUANT')) {
            $arr[$k] = $v;
        }
    }

    // Générer le code PHP
    echo "\n        '$lang' => [\n";
    $orderedKeys = [
        'union_eu','service_justice','tribunal','titre','registre','coordination','contrat_no',
        'soussignes','le_preteur','beneficiaire','pays','adresse','capacite','client_id',
        'civilite','denom_preteur','denom_empr','convenu',
        'art1_titre','art1_p1a','art1_p1b','art1_p2a',
        'art2_titre','art2_intro','mois','ans','art2_suite',
        'montant_p','taux_label','nb_echeances','mensualite',
        'art3_titre','art3_p1',
        'art4_titre','observation','art4_p1','art4_p2','art4_p3',
        'art5_titre','art5_p1','art5_p2','art5_li1','art5_li2','art5_li3',
        'art6_titre','art6_p1','art6_p2','art6_p3',
        'art7_titre','art7_p1','art7_p2','art7_partiel','art7_p3',
        'art8_titre','art8_p1','art8_p2','art8_p3','art8_p4',
        'art9_titre','art9_p1',
        'art10_titre','art10_p1','art10_p2',
        'l_emprunteur','benef_legal','fait_a','le','preteur_rep','important',
    ];
    foreach ($orderedKeys as $k) {
        $v = $arr[$k] ?? '???';
        $escaped = str_replace("'", "\\'", $v);
        echo "            '" . str_pad($k, 16) . "' => '" . $escaped . "',\n";
    }
    echo "        ],\n";
}
