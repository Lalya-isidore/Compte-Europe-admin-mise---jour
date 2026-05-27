<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use App\Models\ContratDonUsage;
use App\Models\ContractHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ContratDonController extends Controller
{
    private array $translations = [
        'fr' => [
            'republica_fr'    => 'République Française',
            'ministerio'      => 'Ministère de la Justice et de la Législation',
            'derechos'        => 'droits de l\'homme',
            'tribunal_local'  => 'Tribunal de Grande Instance de :ville',
            'secretario'      => 'Greffier en Chef',
            'titre_certif'    => 'CERTIFICAT D\'ENREGISTREMENT DE DONATION',
            'titre_testament' => 'CERTIFICAT D\'ENREGISTREMENT DE TESTAMENT',
            'id_donante'      => 'IDENTIFICATION DU DONATEUR :',
            'id_beneficiario' => 'IDENTIFICATION DU BÉNÉFICIAIRE :',
            'nom'             => 'NOM :',
            'prenom'          => 'PRÉNOM :',
            'nom_complet'     => 'NOM ET PRÉNOMS :',
            'pays'            => 'PAYS :',
            'adresse'         => 'ADRESSE :',
            'clause_sum'      => 'LA SOMME DE :montant :devise EST TRANSFÉRABLE DU COMPTE BANCAIRE DE M. :donneur DOMICILIÉ À LA BANQUE :banque VERS LE COMPTE BANCAIRE AU CHOIX DU BÉNÉFICIAIRE.',
            'donateur'        => 'DONATEUR',
            'notario'         => 'NOTAIRE',
            'beneficiaire'    => 'BÉNÉFICIAIRE',
            'donneur'         => 'LE DONATEUR',
            'as_donneur'      => 'Ci-après dénommé "Le Donateur"',
            'as_beneficiaire' => 'Ci-après dénommé "Le Bénéficiaire"',
            'certifie_que'    => 'JE CERTIFIE QUE LA SOMME DE :montant :devise EST TRANSFÉRABLE DU COMPTE BANCAIRE DE M. :donneur VERS LE COMPTE BANCAIRE AU CHOIX DU BÉNÉFICIAIRE.',
            'contrat_no'      => 'N°',
            // Page 2 - Legal clauses
            'p2_para1'        => 'Le dénommé :donneur cède, de façon gratuite, absolue, irrévocable et inconditionnelle, la somme de :montant :devise, et cède tous ses droits et titularité à :donataire.',
            'p2_donateur_declare' => 'Le Donateur déclare et certifie que :',
            'p2_bullet1'      => '• Il est l\'unique propriétaire des fonds,',
            'p2_bullet2'      => '• Il a le droit, le pouvoir et l\'autorité pour donner son consentement à cette donation pour son compte ;',
            'p2_bullet3'      => '• Selon les informations dont il dispose, les fonds sont dans une banque locale et sont transférables à tout moment vers le compte bancaire du bénéficiaire.',
            'p2_senor'        => 'M./Mme',
            'p2_accept1'      => '• Accepte la donation des FONDS et en assume la garde totale, et l\'utilisation conformément aux politiques et Lois 77-995 de l\'article 4 du 18/12/77 optant pour les cas de Donation ;',
            'p2_accept2'      => '• S\'engage à utiliser les fonds correctement et à dépenser l\'argent légalement.',
            'p2_legal1'       => 'L\'acte de donation est régi et interprété conformément aux lois en vigueur sur le territoire français et sous la supervision judiciaire de Maître :notaire, notaire privé et accrédité, domicilié en France à :ville.',
            'p2_legal2'       => 'La donation entre en vigueur à compter de la date de signature par les parties.',
            'p2_legal3'       => ':donataire reconnaît avoir bénéficié des fonds faisant partie de cet acte de donation.',
            'p2_notaire_certifie' => 'L\'acte de donation est régi et interprété conformément aux lois en vigueur sur le territoire :territoire et sous la supervision judiciaire de Maître :notaire, notaire privé et accrédité, :adresse.',
            'p2_notaire_name' => 'Maître Marie Aimée PEYRON',
            'p2_notaire_lawyer' => 'AVOCAT À LA COUR SUPRÊME',
            'p2_notaire_addr' => 'Boulogne-Billancourt, France',
            'p2_date_label'   => 'Date',
        ],

        'en' => [
            'republica_fr'    => 'French Republic',
            'ministerio'      => 'Ministry of Justice and Legislation',
            'derechos'        => 'human rights',
            'tribunal_local'  => 'District Court of :ville',
            'secretario'      => 'Chief Clerk',
            'titre_certif'    => 'GIFT REGISTRATION CERTIFICATE',
            'titre_testament' => 'WILL REGISTRATION CERTIFICATE',
            'id_donante'      => 'DONOR IDENTIFICATION:',
            'id_beneficiario' => 'BENEFICIARY IDENTIFICATION:',
            'nom'             => 'LAST NAME:',
            'prenom'          => 'FIRST NAME:',
            'nom_complet'     => 'FULL NAME:',
            'pays'            => 'COUNTRY:',
            'adresse'         => 'ADDRESS:',
            'clause_sum'      => 'THE SUM OF :montant :devise IS TRANSFERABLE FROM THE BANK ACCOUNT OF MR. :donneur DOMICILED AT :banque BANK TO THE BANK ACCOUNT AT THE BENEFICIARY\'S CHOICE.',
            'donateur'        => 'DONOR',
            'notario'         => 'NOTARY',
            'beneficiaire'    => 'BENEFICIARY',
            'donneur'         => 'THE DONOR',
            'as_donneur'      => 'Hereinafter referred to as "The Donor"',
            'as_beneficiaire' => 'Hereinafter referred to as "The Beneficiary"',
            'certifie_que'    => 'I HEREBY CERTIFY THAT THE SUM OF :montant :devise IS TRANSFERABLE FROM THE BANK ACCOUNT OF MR. :donneur TO THE BANK ACCOUNT AT THE BENEFICIARY\'S CHOICE.',
            'contrat_no'      => 'NO.',
            // Page 2 - Legal clauses
            'p2_para1'        => 'The said :donneur hereby donates, freely, absolutely, irrevocably and unconditionally, the sum of :montant :devise, and assigns all rights and ownership thereof to :donataire.',
            'p2_donateur_declare' => 'The Donor hereby declares and warrants that:',
            'p2_bullet1'      => '• He/She is the sole owner of the funds,',
            'p2_bullet2'      => '• He/She has the right, power and authority to consent to this donation on his/her own behalf;',
            'p2_bullet3'      => '• According to the information available, the funds are in a local bank and are transferable at any time to the beneficiary\'s bank account.',
            'p2_senor'        => 'Mr./Mrs.',
            'p2_accept1'      => '• Accepts the donation of the FUNDS and assumes full custody, and use in accordance with policies and Laws 77-995 of Article 4 of 18/12/77 opting for Donation cases;',
            'p2_accept2'      => '• Undertakes to use the funds properly and to spend the money legally.',
            'p2_legal1'       => 'The deed of donation is governed and interpreted in accordance with the laws in force in French territory and under the judicial supervision of Maître :notaire, private and accredited notary, domiciled in France at :ville.',
            'p2_legal2'       => 'The donation comes into effect from the date of signature by the parties.',
            'p2_legal3'       => ':donataire acknowledges having benefited from the funds forming part of this deed of donation.',
            'p2_notaire_certifie' => 'The deed of donation is governed and interpreted in accordance with the laws in force in :territoire territory and under the judicial supervision of Maître :notaire, private and accredited notary, :adresse.',
            'p2_notaire_name' => 'Maître Marie Aimée PEYRON',
            'p2_notaire_lawyer' => 'LAWYER AT THE SUPREME COURT',
            'p2_notaire_addr' => 'Boulogne-Billancourt, France',
            'p2_date_label'   => 'Date',
        ],

        'es' => [
            'republica_fr'    => 'República Francesa',
            'ministerio'      => 'Ministerio de Justicia y Legislación',
            'derechos'        => 'derechos humanos',
            'tribunal_local'  => 'Tribunal de Primera Instancia de :ville',
            'secretario'      => 'Secretario Jefe',
            'titre_certif'    => 'CERTIFICADO DE REGISTRO DE DONACIÓN',
            'titre_testament' => 'CERTIFICADO DE REGISTRO DE TESTAMENTO',
            'id_donante'      => 'IDENTIFICACIÓN DEL DONANTE:',
            'id_beneficiario' => 'IDENTIFICACIÓN DEL BENEFICIARIO:',
            'nom'             => 'APELLIDO:',
            'prenom'          => 'PRIMER NOMBRE:',
            'nom_complet'     => 'NOMBRE Y APELLIDOS:',
            'pays'            => 'PAÍS:',
            'adresse'         => 'DIRECCIÓN:',
            'clause_sum'      => 'LA SUMA DE :montant :devise ES TRANSFERIBLE DE LA CUENTA BANCARIA DEL SR. :donneur DOMICILADO EN EL BANCO :banque A LA CUENTA BANCARIA A ELECCIÓN DEL BENEFICIARIO.',
            'donateur'        => 'DONANTE',
            'notario'         => 'NOTARIO',
            'beneficiaire'    => 'BENEFICIARIO',
            'donneur'         => 'EL DONANTE',
            'as_donneur'      => 'En lo sucesivo denominado "El Donante"',
            'as_beneficiaire' => 'En lo sucesivo denominado "El Beneficiario"',
            'certifie_que'    => 'CERTIFICO QUE LA SUMA DE :montant :devise ES TRANSFERIBLE DE LA CUENTA BANCARIA DEL SR. :donneur A LA CUENTA BANCARIA A ELECCIÓN DEL BENEFICIARIO.',
            'contrat_no'      => 'N°',
            // Page 2 - Legal clauses
            'p2_para1'        => 'El denominado :donneur cede, de forma gratuita, absoluta, irrevocable e incondicional, la suma de :montant :devise, y cede todos sus derechos y titularidad a :donataire.',
            'p2_donateur_declare' => 'El Donante declara y garantiza que :',
            'p2_bullet1'      => '• Es el único propietario de los fondos,',
            'p2_bullet2'      => '• Tiene el derecho, el poder y la autoridad para dar su consentimiento a esta donación por su cuenta ;',
            'p2_bullet3'      => '• Según la información que tiene, los fondos están en un banco local y son transferibles en cualquier momento a la cuenta bancaria del beneficiario.',
            'p2_senor'        => 'señor',
            'p2_accept1'      => '• Acepta la donación de los FONDOS y asume la custodia total, y uso de acuerdo con las políticas y Leyes 77-995 del artículo 4 del 18/12/77 optant por casos de Donación;',
            'p2_accept2'      => '• Se compromete a utilizar los fondos correctamente y a gastar el dinero legalmente.',
            'p2_legal1'       => 'La escritura de donación se rige e interpreta de acuerdo con las leyes vigentes en el territorio francés y bajo la supervisión judicial de Maître :notaire, notaria privada y acreditada, con domicilio en Francia en :ville.',
            'p2_legal2'       => 'La donación entra en vigor a partir de la fecha de la firma por las partes.',
            'p2_legal3'       => ':donataire reconoce haberse beneficiado de los fondos que forman parte de esta escritura de donación.',
            'p2_notaire_certifie' => 'La escritura de donación se rige e interpreta de acuerdo con las leyes vigentes en el territorio :territoire y bajo la supervisión judicial de Maître :notaire, notaria privada y acreditada, :adresse.',
            'p2_notaire_name' => 'Maître Marie Aimée PEYRON',
            'p2_notaire_lawyer' => 'AVOCAT À LA COUR SUPRÊME',
            'p2_notaire_addr' => 'Boulogne-Billancourt, France',
            'p2_date_label'   => 'Date',
        ],

        'pt' => [
            'republica_fr'    => 'República Francesa',
            'ministerio'      => 'Ministério da Justiça e Legislação',
            'derechos'        => 'direitos humanos',
            'tribunal_local'  => 'Tribunal de Grande Instância de :ville',
            'secretario'      => 'Escrivão-Chefe',
            'titre_certif'    => 'CERTIFICADO DE REGISTRO DE DOAÇÃO',
            'titre_testament' => 'CERTIFICADO DE REGISTRO DE TESTAMENTO',
            'id_donante'      => 'IDENTIFICAÇÃO DO DOADOR:',
            'id_beneficiario' => 'IDENTIFICAÇÃO DO BENEFICIÁRIO:',
            'nom'             => 'SOBRENOME:',
            'prenom'          => 'PRIMEIRO NOME:',
            'nom_complet'     => 'NOME E SOBRENOMES:',
            'pays'            => 'PAÍS:',
            'adresse'         => 'ENDEREÇO:',
            'clause_sum'      => 'A SOMA DE :montant :devise É TRANSFERÍVEL DA CONTA BANCÁRIA DO SR. :donneur DOMICILIADO NO BANCO :banque PARA A CONTA BANCÁRIA À ESCOLHA DO BENEFICIÁRIO.',
            'donateur'        => 'DOADOR',
            'notario'         => 'NOTÁRIO',
            'beneficiaire'    => 'BENEFICIÁRIO',
            'donneur'         => 'O DOADOR',
            'as_donneur'      => 'Daqui em diante denominado "O Doador"',
            'as_beneficiaire' => 'Daqui em diante denominado "O Beneficiário"',
            'certifie_que'    => 'CERTIFICO QUE A SOMA DE :montant :devise É TRANSFERÍVEL DA CONTA BANCÁRIA DO SR. :donneur PARA A CONTA BANCÁRIA À ESCOLHA DO BENEFICIÁRIO.',
            'contrat_no'      => 'N°',
            // Page 2 - Legal clauses
            'p2_para1'        => 'O denominado :donneur cede, de forma gratuita, absoluta, irrevogável e incondicional, a soma de :montant :devise, e cede todos os seus direitos e titularidade a :donataire.',
            'p2_donateur_declare' => 'O Doador declara e garante que:',
            'p2_bullet1'      => '• É o único proprietário dos fundos,',
            'p2_bullet2'      => '• Tem o direito, o poder e a autoridade para dar o seu consentimento a esta doação por sua conta;',
            'p2_bullet3'      => '• Segundo as informações de que dispõe, os fundos estão num banco local e são transferíveis a qualquer momento para a conta bancária do beneficiário.',
            'p2_senor'        => 'Sr./Sra.',
            'p2_accept1'      => '• Aceita a doação dos FUNDOS e assume a custódia total, e uso de acordo com as políticas e Leis 77-995 do artigo 4 de 18/12/77 optando por casos de Donação;',
            'p2_accept2'      => '• Compromete-se a utilizar os fundos corretamente e a gastar o dinheiro legalmente.',
            'p2_legal1'       => 'A escritura de doação é regida e interpretada de acordo com as leis vigentes no território francês e sob a supervisão judicial de Maître :notaire, notária privada e credenciada, com domicílio em França em :ville.',
            'p2_legal2'       => 'A doação entra em vigor a partir da data de assinatura pelas partes.',
            'p2_legal3'       => ':donataire reconhece ter beneficiado dos fundos que fazem partie desta escritura de doação.',
            'p2_notaire_certifie' => 'A escritura de doação é regida e interpretada de acordo com as leis vigentes no território :territoire e sob a supervisão judicial de Maître :notaire, notária privada e credenciada, :adresse.',
            'p2_notaire_name' => 'Maître Marie Aimée PEYRON',
            'p2_notaire_lawyer' => 'ADVOGADO NO TRIBUNAL SUPREMO',
            'p2_notaire_addr' => 'Boulogne-Billancourt, France',
            'p2_date_label'   => 'Data',
        ],

        'de' => [
            'republica_fr'    => 'Französische Republik',
            'ministerio'      => 'Ministerium für Justiz und Gesetzgebung',
            'derechos'        => 'Menschenrechte',
            'tribunal_local'  => 'Bezirksgericht von :ville',
            'secretario'      => 'Haupturkundsbeamter',
            'titre_certif'    => 'SCHENKUNGSREGISTRIERUNGSZERTIFIKAT',
            'titre_testament' => 'TESTAMENTSREGISTRIERUNGSZERTIFIKAT',
            'id_donante'      => 'IDENTIFIKATION DES SCHENKERS:',
            'id_beneficiario' => 'IDENTIFIKATION DES BEGÜNSTIGTEN:',
            'nom'             => 'NACHNAME:',
            'prenom'          => 'VORNAME:',
            'nom_complet'     => 'VOR- UND NACHNAME:',
            'pays'            => 'LAND:',
            'adresse'         => 'ADRESSE:',
            'clause_sum'      => 'DER BETRAG VON :montant :devise IST VOM BANKKONTO VON HERRN :donneur DOMIZILIERT BEI DER BANK :banque AUF DAS BANKKONTO NACH WAHL DES BEGÜNSTIGTEN ÜBERTRAGBAR.',
            'donateur'        => 'SCHENKER',
            'notario'         => 'NOTAR',
            'beneficiaire'    => 'BEGÜNSTIGTER',
            'donneur'         => 'DER SCHENKER',
            'as_donneur'      => 'Nachfolgend als "Der Schenker" bezeichnet',
            'as_beneficiaire' => 'Nachfolgend als "Der Begünstigte" bezeichnet',
            'certifie_que'    => 'ICH BESTÄTIGE HIERMIT, DASS DER BETRAG VON :montant :devise VOM BANKKONTO VON HERRN :donneur AUF DAS BANKKONTO NACH WAHL DES BEGÜNSTIGTEN ÜBERTRAGBAR IST.',
            'contrat_no'      => 'Nr.',
            'p2_para1'        => 'Der Genannte :donneur überträgt freiwillig, absolut, unwiderruflich und bedingungslos den Betrag von :montant :devise und überträgt alle seine Rechte und Ansprüche an :donataire.',
            'p2_donateur_declare' => 'Der Schenker erklärt und versichert, dass:',
            'p2_bullet1'      => '• Er der alleinige Eigentümer der Gelder ist,',
            'p2_bullet2'      => '• Er das Recht, die Befugnis und die Vollmacht hat, in diese Schenkung in seinem Namen einzuwilligen;',
            'p2_bullet3'      => '• Nach den ihm vorliegenden Informationen befinden sich die Gelder in einer Lokalbank und können jederzeit auf das Bankkonto des Begünstigten überwiesen werden.',
            'p2_senor'        => 'Herr/Frau',
            'p2_accept1'      => '• Nimmt die Schenkung der GELDER an und übernimmt die volle Verwahrung und Nutzung gemäß den Richtlinien und Gesetzen 77-995 von Artikel 4 vom 18/12/77 in Bezug auf Schenkungsfälle;',
            'p2_accept2'      => '• Verpflichtet sich, die Gelder ordnungsgemäß zu verwenden und das Geld legal auszugeben.',
            'p2_legal1'       => 'Die Schenkungsurkunde wird gemäß den auf dem französischen Staatsgebiet geltenden Gesetzen und unter der gerichtlichen Aufsicht von Maître :notaire, privatem und akkreditiertem Notar, domiziliert in Frankreich in :ville, geregelt und ausgelegt.',
            'p2_legal2'       => 'Die Schenkung tritt mit dem Datum der Unterzeichnung durch die Parteien in Kraft.',
            'p2_legal3'       => ':donataire bestätigt, von den Geldern, die Teil dieser Schenkungsurkunde sind, profitiert zu haben.',
            'p2_notaire_certifie' => 'Die Schenkungsurkunde wird gemäß den auf dem :territoire Staatsgebiet geltenden Gesetzen und unter der gerichtlichen Aufsicht von Maître :notaire, privatem und akkreditiertem Notar, :adresse, geregelt und ausgelegt.',
            'p2_notaire_name' => 'Maître Marie Aimée PEYRON',
            'p2_notaire_lawyer' => 'RECHTSANWALT AM OBERSTEN GERICHTSHOF',
            'p2_notaire_addr' => 'Boulogne-Billancourt, Frankreich',
            'p2_date_label'   => 'Datum',
        ],

        'it' => [
            'republica_fr'    => 'Repubblica Francese',
            'ministerio'      => 'Ministero della Giustizia e della Legislazione',
            'derechos'        => 'diritti umani',
            'tribunal_local'  => 'Tribunale di Prima Istanza di :ville',
            'secretario'      => 'Cancelliere Capo',
            'titre_certif'    => 'CERTIFICATO DI REGISTRAZIONE DI DONAZIONE',
            'titre_testament' => 'CERTIFICATO DI REGISTRAZIONE DI TESTAMENTO',
            'id_donante'      => 'IDENTIFICAZIONE DEL DONANTE:',
            'id_beneficiario' => 'IDENTIFICAZIONE DEL BENEFICIARIO:',
            'nom'             => 'COGNOME:',
            'prenom'          => 'NOME:',
            'nom_complet'     => 'NOME E COGNOME:',
            'pays'            => 'PAESE:',
            'adresse'         => 'INDIRIZZO:',
            'clause_sum'      => 'LA SOMMA DI :montant :devise È TRASFERIBILE DAL CONTO BANCARIO DEL SIG. :donneur DOMICILIATO PRESSO LA BANCA :banque AL CONTO BANCARIO A SCELTA DEL BENEFICIARIO.',
            'donateur'        => 'DONANTE',
            'notario'         => 'NOTAIO',
            'beneficiaire'    => 'BENEFICIARIO',
            'donneur'         => 'IL DONANTE',
            'as_donneur'      => 'Di seguito denominato "Il Donante"',
            'as_beneficiaire' => 'Di seguito denominato "Il Beneficiario"',
            'certifie_que'    => 'CERTIFICO CHE LA SOMMA DI :montant :devise È TRASFERIBILE DAL CONTO BANCARIO DEL SIG. :donneur AL CONTO BANCARIO A SCELTA DEL BENEFICIARIO.',
            'contrat_no'      => 'N°',
            'p2_para1'        => 'Il suddetto :donneur cede, in modo gratuito, assoluto, irrevocabile e incondizionato, la somma di :montant :devise, e cede tutti i suoi diritti e la sua titolarità a :donataire.',
            'p2_donateur_declare' => 'Il Donante dichiara e garantisce che:',
            'p2_bullet1'      => '• È il solo proprietario dei fondi,',
            'p2_bullet2'      => '• Ha il diritto, il potere e l\'autorità di acconsentire a questa donazione per proprio conto;',
            'p2_bullet3'      => '• Secondo le informazioni di cui dispone, i fondi si trovano in una banca locale e sono trasferibili in qualsiasi momento sul conto bancario del beneficiario.',
            'p2_senor'        => 'Sig./Sig.ra',
            'p2_accept1'      => '• Accetta la donazione dei FONDI e ne assume la custodia totale e l\'utilizzo in conformità alle politiche e alle Leggi 77-995 dell\'articolo 4 del 18/12/77 per i casi di Donazione;',
            'p2_accept2'      => '• Si impegna a utilizzare i fondi correttamente e a spendere il denaro legalmente.',
            'p2_legal1'       => 'L\'atto di donazione è regolato e interpretato in conformità alle leggi vigenti nel territorio francese e sotto la supervisione giudiziaria del Maître :notaire, notaio privato e accreditato, domiciliato in Francia a :ville.',
            'p2_legal2'       => 'La donazione entra in vigore dalla data di firma delle parti.',
            'p2_legal3'       => ':donataire riconosce di aver beneficiato dei fondi che fanno parte di questo atto di donazione.',
            'p2_notaire_certifie' => 'L\'atto di donazione è regolato e interpretato in conformità alle leggi vigenti nel territorio :territoire e sotto la supervisione giudiziaria del Maître :notaire, notaio privato e accreditato, :adresse.',
            'p2_notaire_name' => 'Maître Marie Aimée PEYRON',
            'p2_notaire_lawyer' => 'AVVOCATO ALLA CORTE SUPREMA',
            'p2_notaire_addr' => 'Boulogne-Billancourt, Italia',
            'p2_date_label'   => 'Data',
        ],

        'ru' => [
            'republica_fr'    => 'Французская Республика',
            'ministerio'      => 'Министерство юстиции и законодательства',
            'derechos'        => 'права человека',
            'tribunal_local'  => 'Суд первой инстанции :ville',
            'secretario'      => 'Главный секретарь суда',
            'titre_certif'    => 'СВИДЕТЕЛЬСТВО О РЕГИСТРАЦИИ ДАРЕНИЯ',
            'titre_testament' => 'СВИДЕТЕЛЬСТВО О РЕГИСТРАЦИИ ЗАВЕЩАНИЯ',
            'id_donante'      => 'ИДЕНТИФИКАЦИЯ ДАРИТЕЛЯ:',
            'id_beneficiario' => 'ИДЕНТИФИКАЦИЯ ПОЛУЧАТЕЛЯ:',
            'nom'             => 'ФАМИЛИЯ:',
            'prenom'          => 'ИМЯ:',
            'nom_complet'     => 'ФИО:',
            'pays'            => 'СТРАНА:',
            'adresse'         => 'АДРЕС:',
            'clause_sum'      => 'СУММА В РАЗМЕРЕ :montant :devise МОЖЕТ БЫТЬ ПЕРЕВЕДЕНА С БАНКОВСКОГО СЧЁТА ГОСПОДИНА :donneur ОБСЛУЖИВАЕМОГО В БАНКЕ :banque НА БАНКОВСКИЙ СЧЁТ ПО ВЫБОРУ ПОЛУЧАТЕЛЯ.',
            'donateur'        => 'ДАРИТЕЛЬ',
            'notario'         => 'НОТАРИУС',
            'beneficiaire'    => 'ПОЛУЧАТЕЛЬ',
            'donneur'         => 'ДАРИТЕЛЬ',
            'as_donneur'      => 'Именуемый в дальнейшем «Даритель»',
            'as_beneficiaire' => 'Именуемый в дальнейшем «Получатель»',
            'certifie_que'    => 'НАСТОЯЩИМ УДОСТОВЕРЯЮ, ЧТО СУММА В РАЗМЕРЕ :montant :devise МОЖЕТ БЫТЬ ПЕРЕВЕДЕНА С БАНКОВСКОГО СЧЁТА ГОСПОДИНА :donneur НА БАНКОВСКИЙ СЧЁТ ПО ВЫБОРУ ПОЛУЧАТЕЛЯ.',
            'contrat_no'      => '№',
            'p2_para1'        => 'Указанный :donneur безвозмездно, абсолютно, безотзывно и безусловно передаёт сумму в размере :montant :devise и уступает все свои права и право собственности в пользу :donataire.',
            'p2_donateur_declare' => 'Даритель заявляет и гарантирует, что:',
            'p2_bullet1'      => '• Является единственным владельцем средств,',
            'p2_bullet2'      => '• Имеет право, полномочия и власть дать согласие на это дарение от своего имени;',
            'p2_bullet3'      => '• По имеющимся сведениям, средства находятся в местном банке и могут быть в любое время переведены на банковский счёт получателя.',
            'p2_senor'        => 'Г-н/Г-жа',
            'p2_accept1'      => '• Принимает дарение СРЕДСТВ и берёт на себя полную ответственность за их хранение и использование в соответствии с политиками и Законами 77-995 статьи 4 от 18/12/77 по делам о дарении;',
            'p2_accept2'      => '• Обязуется использовать средства надлежащим образом и расходовать деньги на законные цели.',
            'p2_legal1'       => 'Акт дарения регулируется и трактуется в соответствии с действующим законодательством на территории Франции и под судебным надзором Мэтра :notaire, частного и аккредитованного нотариуса, проживающего во Франции в :ville.',
            'p2_legal2'       => 'Дарение вступает в силу с даты подписания сторонами.',
            'p2_legal3'       => ':donataire подтверждает, что воспользовался средствами, являющимися частью данного акта дарения.',
            'p2_notaire_certifie' => 'Акт дарения регулируется и трактуется в соответствии с действующим законодательством на :territoire территории и под судебным надзором Мэтра :notaire, частного и аккредитованного нотариуса, :adresse.',
            'p2_notaire_name' => 'Maître Marie Aimée PEYRON',
            'p2_notaire_lawyer' => 'АДВОКАТ ВЕРХОВНОГО СУДА',
            'p2_notaire_addr' => 'Булонь-Бийанкур, Франция',
            'p2_date_label'   => 'Дата',
        ],

        'ar' => [
            'republica_fr'    => 'الجمهورية الفرنسية',
            'ministerio'      => 'وزارة العدل والتشريع',
            'derechos'        => 'حقوق الإنسان',
            'tribunal_local'  => 'محكمة الدرجة الأولى في :ville',
            'secretario'      => 'رئيس الكتابة',
            'titre_certif'    => 'شهادة تسجيل الهبة',
            'titre_testament' => 'شهادة تسجيل الوصية',
            'id_donante'      => 'هوية الواهب:',
            'id_beneficiario' => 'هوية المستفيد:',
            'nom'             => 'اللقب:',
            'prenom'          => 'الاسم:',
            'nom_complet'     => 'الاسم الكامل:',
            'pays'            => 'البلد:',
            'adresse'         => 'العنوان:',
            'clause_sum'      => 'مبلغ :montant :devise قابل للتحويل من الحساب المصرفي للسيد :donneur المقيم في بنك :banque إلى الحساب المصرفي الذي يختاره المستفيد.',
            'donateur'        => 'الواهب',
            'notario'         => 'كاتب العدل',
            'beneficiaire'    => 'المستفيد',
            'donneur'         => 'الواهب',
            'as_donneur'      => 'المشار إليه فيما بعد بـ"الواهب"',
            'as_beneficiaire' => 'المشار إليه فيما بعد بـ"المستفيد"',
            'certifie_que'    => 'أشهد بموجب هذه الوثيقة أن مبلغ :montant :devise قابل للتحويل من الحساب المصرفي للسيد :donneur إلى الحساب المصرفي الذي يختاره المستفيد.',
            'contrat_no'      => 'رقم',
            'p2_para1'        => 'المدعو :donneur يتنازل بصورة مجانية ومطلقة وغير قابلة للنقض وغير مشروطة عن مبلغ :montant :devise، ويتنازل عن جميع حقوقه وملكيته لـ:donataire.',
            'p2_donateur_declare' => 'يُصرّح الواهب ويضمن ما يلي:',
            'p2_bullet1'      => '• أنه المالك الوحيد للأموال،',
            'p2_bullet2'      => '• أن لديه الحق والصلاحية والسلطة للموافقة على هذه الهبة باسمه الشخصي؛',
            'p2_bullet3'      => '• وفقاً للمعلومات المتوفرة لديه، فإن الأموال موجودة في بنك محلي وقابلة للتحويل في أي وقت إلى الحساب المصرفي للمستفيد.',
            'p2_senor'        => 'السيد/السيدة',
            'p2_accept1'      => '• يقبل هبة الأموال ويتحمل مسؤولية حفظها الكاملة واستخدامها وفقاً للسياسات والقوانين 77-995 في المادة 4 بتاريخ 18/12/77 المتعلقة بحالات الهبة؛',
            'p2_accept2'      => '• يلتزم باستخدام الأموال بشكل صحيح وإنفاق المال بطريقة قانونية.',
            'p2_legal1'       => 'يخضع سند الهبة ويُفسَّر وفقاً للقوانين السارية على الأراضي الفرنسية وتحت الإشراف القضائي للمعلم :notaire، كاتب عدل خاص ومعتمد، مقيم في فرنسا في :ville.',
            'p2_legal2'       => 'تدخل الهبة حيز التنفيذ اعتباراً من تاريخ التوقيع من قِبل الأطراف.',
            'p2_legal3'       => 'يُقرّ :donataire بأنه استفاد من الأموال المكونة لهذا سند الهبة.',
            'p2_notaire_certifie' => 'يخضع سند الهبة ويُفسَّر وفقاً للقوانين السارية على الأراضي :territoire وتحت الإشراف القضائي للمعلم :notaire، كاتب عدل خاص ومعتمد، :adresse.',
            'p2_notaire_name' => 'Maître Marie Aimée PEYRON',
            'p2_notaire_lawyer' => 'محامٍ لدى المحكمة العليا',
            'p2_notaire_addr' => 'بولون-بيانكور، فرنسا',
            'p2_date_label'   => 'التاريخ',
        ],

        'zh' => [
            'republica_fr'    => '法兰西共和国',
            'ministerio'      => '司法与立法部',
            'derechos'        => '人权',
            'tribunal_local'  => ':ville 初级法院',
            'secretario'      => '首席书记员',
            'titre_certif'    => '捐赠登记证书',
            'titre_testament' => '遗嘱登记证书',
            'id_donante'      => '捐赠人信息:',
            'id_beneficiario' => '受益人信息:',
            'nom'             => '姓:',
            'prenom'          => '名:',
            'nom_complet'     => '姓名:',
            'pays'            => '国家:',
            'adresse'         => '地址:',
            'clause_sum'      => ':donneur 先生在 :banque 银行的账户中的 :montant :devise 款项可转至受益人选择的银行账户。',
            'donateur'        => '捐赠人',
            'notario'         => '公证人',
            'beneficiaire'    => '受益人',
            'donneur'         => '捐赠人',
            'as_donneur'      => '以下简称"捐赠人"',
            'as_beneficiaire' => '以下简称"受益人"',
            'certifie_que'    => '本人特此证明，:donneur 先生银行账户中的 :montant :devise 款项可转至受益人选择的银行账户。',
            'contrat_no'      => '编号',
            'p2_para1'        => ':donneur 以无偿、绝对、不可撤销且无条件的方式，将 :montant :devise 的款项赠予 :donataire，并转让其全部权利和所有权。',
            'p2_donateur_declare' => '捐赠人声明并保证：',
            'p2_bullet1'      => '• 其为上述资金的唯一所有者，',
            'p2_bullet2'      => '• 其有权利、权力和授权代表自己同意本次捐赠；',
            'p2_bullet3'      => '• 据其所知，上述资金存放于当地银行，可随时转至受益人的银行账户。',
            'p2_senor'        => '先生/女士',
            'p2_accept1'      => '• 接受上述资金的赠予，并依照1977年12月18日第77-995号法律第4条关于捐赠案例的政策和规定，承担全部保管责任及使用责任；',
            'p2_accept2'      => '• 承诺妥善使用资金并合法支出。',
            'p2_legal1'       => '本捐赠契约依据法国领土现行法律受理和解释，并在公证人 Maître :notaire 的司法监督下执行，该公证人为私人认证公证人，居住于法国 :ville。',
            'p2_legal2'       => '本捐赠自各方签署之日起生效。',
            'p2_legal3'       => ':donataire 确认已从本捐赠契约中的资金中受益。',
            'p2_notaire_certifie' => '本捐赠契约依据 :territoire 领土现行法律受理和解释，并在 Maître :notaire 公证人的司法监督下执行，:adresse。',
            'p2_notaire_name' => 'Maître Marie Aimée PEYRON',
            'p2_notaire_lawyer' => '最高法院律师',
            'p2_notaire_addr' => '法国布洛涅-比扬古',
            'p2_date_label'   => '日期',
        ],

        'tr' => [
            'republica_fr'    => 'Fransız Cumhuriyeti',
            'ministerio'      => 'Adalet ve Mevzuat Bakanlığı',
            'derechos'        => 'insan hakları',
            'tribunal_local'  => ':ville İlk Derece Mahkemesi',
            'secretario'      => 'Baş Zabıt Kâtibi',
            'titre_certif'    => 'BAĞIŞ KAYIT SERTİFİKASI',
            'titre_testament' => 'VASİYETNAME KAYIT SERTİFİKASI',
            'id_donante'      => 'BAĞIŞÇI KİMLİĞİ:',
            'id_beneficiario' => 'YARARLANAN KİMLİĞİ:',
            'nom'             => 'SOYADI:',
            'prenom'          => 'ADI:',
            'nom_complet'     => 'AD VE SOYAD:',
            'pays'            => 'ÜLKE:',
            'adresse'         => 'ADRES:',
            'clause_sum'      => ':banque Bankasında yerleşik Bay :donneur\'nün banka hesabından :montant :devise tutarı, lehtarın seçeceği banka hesabına transfer edilebilir.',
            'donateur'        => 'BAĞIŞÇI',
            'notario'         => 'NOTER',
            'beneficiaire'    => 'YARARLANAN',
            'donneur'         => 'BAĞIŞÇI',
            'as_donneur'      => 'Bundan böyle "Bağışçı" olarak anılacaktır',
            'as_beneficiaire' => 'Bundan böyle "Yararlanan" olarak anılacaktır',
            'certifie_que'    => 'BAY :donneur\'NÜN BANKA HESABINDAN :montant :devise TUTARININ YARARLANANCIN SEÇECEĞİ BANKA HESABINA TRANSFERİNİ ONAYLIYORUM.',
            'contrat_no'      => 'No.',
            'p2_para1'        => 'Adı geçen :donneur, :montant :devise tutarını karşılıksız, mutlak, geri alınamaz ve koşulsuz olarak devretmekte ve tüm hak ve mülkiyetini :donataire\'ye devretmektedir.',
            'p2_donateur_declare' => 'Bağışçı aşağıdakileri beyan eder ve taahhüt eder:',
            'p2_bullet1'      => '• Fonların tek sahibi olduğunu,',
            'p2_bullet2'      => '• Bu bağışa kendi adına onay verme hakkına, yetkisine ve otoritesine sahip olduğunu;',
            'p2_bullet3'      => '• Bildiği kadarıyla, fonların yerel bir bankada bulunduğunu ve lehtarın banka hesabına herhangi bir zamanda transfer edilebildiğini.',
            'p2_senor'        => 'Bay/Bayan',
            'p2_accept1'      => '• FONLARI bağış olarak kabul etmekte ve Bağış davalarına ilişkin 18/12/77 tarihli 77-995 Sayılı Kanunun 4. Maddesi politika ve yasalarına uygun olarak bunların tam gözetimi ve kullanımını üstlenmektedir;',
            'p2_accept2'      => '• Fonları usulüne uygun kullanmayı ve parayı yasal olarak harcamayı taahhüt etmektedir.',
            'p2_legal1'       => 'Bağış senedi, Fransa topraklarında yürürlükteki yasalara ve Maître :notaire\'nin yargı denetimine göre yönetilmekte ve yorumlanmakta olup söz konusu noter, Fransa\'da :ville\'de ikamet eden özel ve akredite bir noterdir.',
            'p2_legal2'       => 'Bağış, taraflarca imzalanma tarihinden itibaren yürürlüğe girmektedir.',
            'p2_legal3'       => ':donataire, bu bağış senedinin bir parçasını oluşturan fonlardan yararlandığını kabul etmektedir.',
            'p2_notaire_certifie' => 'Bağış senedi, :territoire topraklarında yürürlükteki yasalara ve Maître :notaire\'nin yargı denetimine göre yönetilmekte ve yorumlanmakta olup söz konusu noter, :adresse ikamet eden özel ve akredite bir noterdir.',
            'p2_notaire_name' => 'Maître Marie Aimée PEYRON',
            'p2_notaire_lawyer' => 'YÜKSEK MAHKEME AVUKATI',
            'p2_notaire_addr' => 'Boulogne-Billancourt, Fransa',
            'p2_date_label'   => 'Tarih',
        ],
    ];

    private array $republicNames = [
        'fr' => [
            'fr' => 'République Française',
            'es' => 'République d\'Espagne',
            'it' => 'République Italienne',
            'de' => 'République Fédérale d\'Allemagne',
            'pt' => 'République Portugaise',
            'us' => 'États-Unis d\'Amérique',
            'gb' => 'Royaume-Uni',
            'be' => 'République de Belgique',
        ],
        'en' => [
            'fr' => 'French Republic',
            'es' => 'Republic of Spain',
            'it' => 'Italian Republic',
            'de' => 'Federal Republic of Germany',
            'pt' => 'Portuguese Republic',
            'us' => 'United States of America',
            'gb' => 'United Kingdom',
            'be' => 'Republic of Belgium',
        ],
        'es' => [
            'fr' => 'República Francesa',
            'es' => 'República de España',
            'it' => 'República Italiana',
            'de' => 'República Federal de Alemania',
            'pt' => 'República Portuguesa',
            'us' => 'Estados Unidos de América',
            'gb' => 'Reino Unido',
            'be' => 'República de Bélgica',
        ],
        'pt' => [
            'fr' => 'República Francesa',
            'es' => 'República de Espanha',
            'it' => 'República Italiana',
            'de' => 'República Federal da Alemanha',
            'pt' => 'República Portuguesa',
            'us' => 'Estados Unidos da América',
            'gb' => 'Reino Unido',
            'be' => 'República da Bélgica',
        ],
        'de' => [
            'fr' => 'Französische Republik', 'es' => 'Republik Spanien', 'it' => 'Italienische Republik',
            'de' => 'Bundesrepublik Deutschland', 'pt' => 'Portugiesische Republik',
            'us' => 'Vereinigte Staaten von Amerika', 'gb' => 'Vereinigtes Königreich', 'be' => 'Republik Belgien',
        ],
        'it' => [
            'fr' => 'Repubblica Francese', 'es' => 'Repubblica di Spagna', 'it' => 'Repubblica Italiana',
            'de' => 'Repubblica Federale di Germania', 'pt' => 'Repubblica Portoghese',
            'us' => "Stati Uniti d'America", 'gb' => 'Regno Unito', 'be' => 'Repubblica del Belgio',
        ],
        'ru' => [
            'fr' => 'Французская Республика', 'es' => 'Республика Испания', 'it' => 'Итальянская Республика',
            'de' => 'Федеративная Республика Германия', 'pt' => 'Португальская Республика',
            'us' => 'Соединённые Штаты Америки', 'gb' => 'Соединённое Королевство', 'be' => 'Республика Бельгия',
        ],
        'ar' => [
            'fr' => 'الجمهورية الفرنسية', 'es' => 'جمهورية إسبانيا', 'it' => 'الجمهورية الإيطالية',
            'de' => 'جمهورية ألمانيا الفيدرالية', 'pt' => 'الجمهورية البرتغالية',
            'us' => 'الولايات المتحدة الأمريكية', 'gb' => 'المملكة المتحدة', 'be' => 'جمهورية بلجيكا',
        ],
        'zh' => [
            'fr' => '法兰西共和国', 'es' => '西班牙共和国', 'it' => '意大利共和国',
            'de' => '德意志联邦共和国', 'pt' => '葡萄牙共和国',
            'us' => '美利坚合众国', 'gb' => '英国', 'be' => '比利时共和国',
        ],
        'tr' => [
            'fr' => 'Fransız Cumhuriyeti', 'es' => 'İspanya Cumhuriyeti', 'it' => 'İtalya Cumhuriyeti',
            'de' => 'Almanya Federal Cumhuriyeti', 'pt' => 'Portekiz Cumhuriyeti',
            'us' => 'Amerika Birleşik Devletleri', 'gb' => 'Birleşik Krallık', 'be' => 'Belçika Cumhuriyeti',
        ],
    ];

    private array $capitalCities = [
        'fr' => 'Nantes',
        'es' => 'Madrid',
        'it' => 'Rome',
        'de' => 'Berlin',
        'pt' => 'Lisbonne',
        'us' => 'Washington',
        'gb' => 'Londres',
        'be' => 'Bruxelles',
    ];

    private array $territoireAdj = [
        'fr' => ['fr' => 'français',     'es' => 'espagnol',     'it' => 'italien',    'de' => 'allemand',    'pt' => 'portugais',   'us' => 'américain',        'gb' => 'britannique', 'be' => 'belge'],
        'en' => ['fr' => 'French',       'es' => 'Spanish',      'it' => 'Italian',    'de' => 'German',      'pt' => 'Portuguese',  'us' => 'American',         'gb' => 'British',     'be' => 'Belgian'],
        'es' => ['fr' => 'francés',      'es' => 'español',      'it' => 'italiano',   'de' => 'alemán',      'pt' => 'portugués',   'us' => 'estadounidense',   'gb' => 'británico',   'be' => 'belga'],
        'pt' => ['fr' => 'francês',      'es' => 'espanhol',     'it' => 'italiano',   'de' => 'alemão',      'pt' => 'português',   'us' => 'americano',        'gb' => 'britânico',   'be' => 'belga'],
        'de' => ['fr' => 'französischen', 'es' => 'spanischen', 'it' => 'italienischen', 'de' => 'deutschen', 'pt' => 'portugiesischen', 'us' => 'amerikanischen', 'gb' => 'britischen', 'be' => 'belgischen'],
        'it' => ['fr' => 'francese', 'es' => 'spagnolo', 'it' => 'italiano', 'de' => 'tedesco', 'pt' => 'portoghese', 'us' => 'americano', 'gb' => 'britannico', 'be' => 'belga'],
        'ru' => ['fr' => 'французской', 'es' => 'испанской', 'it' => 'итальянской', 'de' => 'немецкой', 'pt' => 'португальской', 'us' => 'американской', 'gb' => 'британской', 'be' => 'бельгийской'],
        'ar' => ['fr' => 'الفرنسية', 'es' => 'الإسبانية', 'it' => 'الإيطالية', 'de' => 'الألمانية', 'pt' => 'البرتغالية', 'us' => 'الأمريكية', 'gb' => 'البريطانية', 'be' => 'البلجيكية'],
        'zh' => ['fr' => '法国', 'es' => '西班牙', 'it' => '意大利', 'de' => '德国', 'pt' => '葡萄牙', 'us' => '美国', 'gb' => '英国', 'be' => '比利时'],
        'tr' => ['fr' => 'Fransız', 'es' => 'İspanyol', 'it' => 'İtalyan', 'de' => 'Alman', 'pt' => 'Portekiz', 'us' => 'Amerikan', 'gb' => 'İngiliz', 'be' => 'Belçika'],
    ];

    private array $notaireAdresses = [
        'fr' => [
            'fr' => 'domicilié en France à Boulogne-Billancourt',
            'es' => 'domicilié en Espagne à Madrid',
            'it' => 'domicilié en Italie à Rome',
            'de' => 'domicilié en Allemagne à Berlin',
            'pt' => 'domicilié au Portugal à Lisbonne',
            'us' => 'domicilié aux États-Unis à Washington',
            'gb' => 'domicilié au Royaume-Uni à Londres',
            'be' => 'domicilié en Belgique à Bruxelles',
        ],
        'en' => [
            'fr' => 'domiciled in France in Boulogne-Billancourt',
            'es' => 'domiciled in Spain in Madrid',
            'it' => 'domiciled in Italy in Rome',
            'de' => 'domiciled in Germany in Berlin',
            'pt' => 'domiciled in Portugal in Lisbon',
            'us' => 'domiciled in the United States in Washington',
            'gb' => 'domiciled in the United Kingdom in London',
            'be' => 'domiciled in Belgium in Brussels',
        ],
        'es' => [
            'fr' => 'domiciliado en Francia en Boulogne-Billancourt',
            'es' => 'domiciliado en España en Madrid',
            'it' => 'domiciliado en Italia en Roma',
            'de' => 'domiciliado en Alemania en Berlín',
            'pt' => 'domiciliado en Portugal en Lisboa',
            'us' => 'domiciliado en los Estados Unidos en Washington',
            'gb' => 'domiciliado en el Reino Unido en Londres',
            'be' => 'domiciliado en Bélgica en Bruselas',
        ],
        'pt' => [
            'fr' => 'domiciliado na França em Boulogne-Billancourt',
            'es' => 'domiciliado na Espanha em Madrid',
            'it' => 'domiciliado na Itália em Roma',
            'de' => 'domiciliado na Alemanha em Berlim',
            'pt' => 'domiciliado em Portugal em Lisboa',
            'us' => 'domiciliado nos Estados Unidos em Washington',
            'gb' => 'domiciliado no Reino Unido em Londres',
            'be' => 'domiciliado na Bélgica em Bruxelas',
        ],
        'de' => [
            'fr' => 'mit Wohnsitz in Frankreich in Boulogne-Billancourt',
            'es' => 'mit Wohnsitz in Spanien in Madrid',
            'it' => 'mit Wohnsitz in Italien in Rom',
            'de' => 'mit Wohnsitz in Deutschland in Berlin',
            'pt' => 'mit Wohnsitz in Portugal in Lissabon',
            'us' => 'mit Wohnsitz in den Vereinigten Staaten in Washington',
            'gb' => 'mit Wohnsitz im Vereinigten Königreich in London',
            'be' => 'mit Wohnsitz in Belgien in Brüssel',
        ],
        'it' => [
            'fr' => 'domiciliato in Francia a Boulogne-Billancourt',
            'es' => 'domiciliato in Spagna a Madrid',
            'it' => 'domiciliato in Italia a Roma',
            'de' => 'domiciliato in Germania a Berlino',
            'pt' => 'domiciliato in Portogallo a Lisbona',
            'us' => 'domiciliato negli Stati Uniti a Washington',
            'gb' => 'domiciliato nel Regno Unito a Londra',
            'be' => 'domiciliato in Belgio a Bruxelles',
        ],
        'ru' => [
            'fr' => 'проживающего во Франции в Булонь-Бийанкуре',
            'es' => 'проживающего в Испании в Мадриде',
            'it' => 'проживающего в Италии в Риме',
            'de' => 'проживающего в Германии в Берлине',
            'pt' => 'проживающего в Португалии в Лиссабоне',
            'us' => 'проживающего в США в Вашингтоне',
            'gb' => 'проживающего в Великобритании в Лондоне',
            'be' => 'проживающего в Бельгии в Брюсселе',
        ],
        'ar' => [
            'fr' => 'مقيم في فرنسا في بولون-بيانكور',
            'es' => 'مقيم في إسبانيا في مدريد',
            'it' => 'مقيم في إيطاليا في روما',
            'de' => 'مقيم في ألمانيا في برلين',
            'pt' => 'مقيم في البرتغال في لشبونة',
            'us' => 'مقيم في الولايات المتحدة في واشنطن',
            'gb' => 'مقيم في المملكة المتحدة في لندن',
            'be' => 'مقيم في بلجيكا في بروكسل',
        ],
        'zh' => [
            'fr' => '在法国布洛涅-比扬古居住',
            'es' => '在西班牙马德里居住',
            'it' => '在意大利罗马居住',
            'de' => '在德国柏林居住',
            'pt' => '在葡萄牙里斯本居住',
            'us' => '在美国华盛顿居住',
            'gb' => '在英国伦敦居住',
            'be' => '在比利时布鲁塞尔居住',
        ],
        'tr' => [
            'fr' => "Fransa'da Boulogne-Billancourt'da ikamet eden",
            'es' => "İspanya'da Madrid'de ikamet eden",
            'it' => "İtalya'da Roma'da ikamet eden",
            'de' => "Almanya'da Berlin'de ikamet eden",
            'pt' => "Portekiz'de Lizbon'da ikamet eden",
            'us' => "ABD'de Washington'da ikamet eden",
            'gb' => "Birleşik Krallık'ta Londra'da ikamet eden",
            'be' => "Belçika'da Brüksel'de ikamet eden",
        ],
    ];

    private array $ministereNoms = [
        'fr' => [
            'fr' => 'Ministère de la Justice et de la Législation',
            'es' => 'Ministère de la Justice',
            'it' => 'Ministère de la Justice',
            'de' => 'Ministère Fédéral de la Justice',
            'pt' => 'Ministère de la Justice',
            'us' => 'Département de la Justice',
            'gb' => 'Ministère de la Justice',
            'be' => 'Service Public Fédéral Justice',
        ],
        'en' => [
            'fr' => 'Ministry of Justice and Legislation',
            'es' => 'Ministry of Justice',
            'it' => 'Ministry of Justice',
            'de' => 'Federal Ministry of Justice',
            'pt' => 'Ministry of Justice',
            'us' => 'Department of Justice',
            'gb' => 'Ministry of Justice',
            'be' => 'Federal Public Service Justice',
        ],
        'es' => [
            'fr' => 'Ministerio de Justicia y Legislación',
            'es' => 'Ministerio de Justicia',
            'it' => 'Ministerio de Justicia',
            'de' => 'Ministerio Federal de Justicia',
            'pt' => 'Ministerio de Justicia',
            'us' => 'Departamento de Justicia',
            'gb' => 'Ministerio de Justicia',
            'be' => 'Servicio Público Federal de Justicia',
        ],
        'pt' => [
            'fr' => 'Ministério da Justiça e Legislação',
            'es' => 'Ministério da Justiça',
            'it' => 'Ministério da Justiça',
            'de' => 'Ministério Federal da Justiça',
            'pt' => 'Ministério da Justiça',
            'us' => 'Departamento de Justiça',
            'gb' => 'Ministério da Justiça',
            'be' => 'Serviço Público Federal de Justiça',
        ],
        'de' => [
            'fr' => 'Ministerium für Justiz und Gesetzgebung', 'es' => 'Justizministerium',
            'it' => 'Justizministerium', 'de' => 'Bundesministerium der Justiz',
            'pt' => 'Justizministerium', 'us' => 'Justizministerium',
            'gb' => 'Justizministerium', 'be' => 'Bundesjustizministerium',
        ],
        'it' => [
            'fr' => 'Ministero della Giustizia e della Legislazione', 'es' => 'Ministero della Giustizia',
            'it' => 'Ministero della Giustizia', 'de' => 'Ministero Federale della Giustizia',
            'pt' => 'Ministero della Giustizia', 'us' => 'Dipartimento di Giustizia',
            'gb' => 'Ministero della Giustizia', 'be' => 'Servizio Pubblico Federale di Giustizia',
        ],
        'ru' => [
            'fr' => 'Министерство юстиции и законодательства', 'es' => 'Министерство юстиции',
            'it' => 'Министерство юстиции', 'de' => 'Федеральное министерство юстиции',
            'pt' => 'Министерство юстиции', 'us' => 'Министерство юстиции',
            'gb' => 'Министерство юстиции', 'be' => 'Федеральное министерство юстиции',
        ],
        'ar' => [
            'fr' => 'وزارة العدل والتشريع', 'es' => 'وزارة العدل',
            'it' => 'وزارة العدل', 'de' => 'وزارة العدل الاتحادية',
            'pt' => 'وزارة العدل', 'us' => 'وزارة العدل',
            'gb' => 'وزارة العدل', 'be' => 'وزارة العدل الفيدرالية',
        ],
        'zh' => [
            'fr' => '司法与立法部', 'es' => '司法部',
            'it' => '司法部', 'de' => '联邦司法部',
            'pt' => '司法部', 'us' => '司法部',
            'gb' => '司法部', 'be' => '联邦司法部',
        ],
        'tr' => [
            'fr' => 'Adalet ve Mevzuat Bakanlığı', 'es' => 'Adalet Bakanlığı',
            'it' => 'Adalet Bakanlığı', 'de' => 'Federal Adalet Bakanlığı',
            'pt' => 'Adalet Bakanlığı', 'us' => 'Adalet Bakanlığı',
            'gb' => 'Adalet Bakanlığı', 'be' => 'Federal Adalet Bakanlığı',
        ],
    ];

    private array $flagsMap = [
        'fr' => 'images/contract/marianne-flag.png',
        'es' => 'images/images entête don/image copy 6.png',
        'it' => 'images/images entête don/image copy 5.png',
        'de' => 'images/images entête don/image copy 4.png',
        'pt' => 'images/armoiries-portugal.png',
        'us' => 'images/images entête don/image copy 8.png',
        'gb' => 'images/images entête don/image copy 7.png',
        'be' => 'images/images entête don/image copy 9.png',
    ];

    // Drapeaux tricolores officiels (pour remplacer un côté page 2)
    private array $officialFlagsMap = [
        'fr' => 'images/contract/marianne-flag.png',
        'es' => 'images/images entête don/Drapeau espagne.jpeg',
        'it' => 'images/images entête don/drapeau italie.png',
        'de' => 'images/images entête don/drapeau allemand.png',
        'pt' => 'images/images entête don/drapeau portugais.png',
        'us' => 'images/images entête don/drapeau USA.png',
        'gb' => 'images/images entête don/drapeau Royaume unis.png',
        'be' => 'images/images entête don/image copy 12.png',
    ];

    private array $flagsLabels = [
        'fr' => '🇫🇷 France',
        'es' => '🇪🇸 Espagne',
        'it' => '🇮🇹 Italie',
        'de' => '🇩🇪 Allemagne',
        'pt' => '🇵🇹 Portugal',
        'us' => '🇺🇸 États-Unis',
        'gb' => '🇬🇧 Royaume-Uni',
        'be' => '🇧🇪 Belgique',
    ];

    private array $currencies = [
        // Principales devises mondiales
        'EUR' => ['symbol' => '€',      'name' => 'Euro'],
        'USD' => ['symbol' => '$',      'name' => 'Dollar américain'],
        'GBP' => ['symbol' => '£',      'name' => 'Livre sterling'],
        'CHF' => ['symbol' => 'Fr',     'name' => 'Franc suisse'],
        'JPY' => ['symbol' => '¥',      'name' => 'Yen japonais'],
        'CNY' => ['symbol' => '¥',      'name' => 'Yuan chinois (Renminbi)'],
        'CAD' => ['symbol' => 'CA$',    'name' => 'Dollar canadien'],
        'AUD' => ['symbol' => 'A$',     'name' => 'Dollar australien'],
        'NZD' => ['symbol' => 'NZ$',    'name' => 'Dollar néo-zélandais'],
        'SGD' => ['symbol' => 'S$',     'name' => 'Dollar de Singapour'],
        'HKD' => ['symbol' => 'HK$',    'name' => 'Dollar de Hong Kong'],
        // Europe
        'NOK' => ['symbol' => 'kr',     'name' => 'Couronne norvégienne'],
        'SEK' => ['symbol' => 'kr',     'name' => 'Couronne suédoise'],
        'DKK' => ['symbol' => 'kr',     'name' => 'Couronne danoise'],
        'CZK' => ['symbol' => 'Kč',     'name' => 'Couronne tchèque'],
        'PLN' => ['symbol' => 'zł',     'name' => 'Zloty polonais'],
        'HUF' => ['symbol' => 'Ft',     'name' => 'Forint hongrois'],
        'RON' => ['symbol' => 'lei',    'name' => 'Leu roumain'],
        'BGN' => ['symbol' => 'лв',     'name' => 'Lev bulgare'],
        'RSD' => ['symbol' => 'din',    'name' => 'Dinar serbe'],
        'RUB' => ['symbol' => '₽',      'name' => 'Rouble russe'],
        'TRY' => ['symbol' => '₺',      'name' => 'Livre turque'],
        'UAH' => ['symbol' => '₴',      'name' => 'Hryvnia ukrainienne'],
        // Asie
        'INR' => ['symbol' => '₹',      'name' => 'Roupie indienne'],
        'PKR' => ['symbol' => '₨',      'name' => 'Roupie pakistanaise'],
        'BDT' => ['symbol' => '৳',      'name' => 'Taka bangladais'],
        'IDR' => ['symbol' => 'Rp',     'name' => 'Roupie indonésienne'],
        'MYR' => ['symbol' => 'RM',     'name' => 'Ringgit malaisien'],
        'THB' => ['symbol' => '฿',      'name' => 'Baht thaïlandais'],
        'VND' => ['symbol' => '₫',      'name' => 'Dong vietnamien'],
        'PHP' => ['symbol' => '₱',      'name' => 'Peso philippin'],
        'KRW' => ['symbol' => '₩',      'name' => 'Won sud-coréen'],
        'TWD' => ['symbol' => 'NT$',    'name' => 'Dollar taïwanais'],
        'LKR' => ['symbol' => '₨',      'name' => 'Roupie srilankaise'],
        'MMK' => ['symbol' => 'K',      'name' => 'Kyat birman'],
        'KHR' => ['symbol' => '៛',      'name' => 'Riel cambodgien'],
        'MNT' => ['symbol' => '₮',      'name' => 'Tögrög mongol'],
        // Moyen-Orient
        'SAR' => ['symbol' => 'SR',     'name' => 'Riyal saoudien'],
        'AED' => ['symbol' => 'د.إ',    'name' => 'Dirham des Émirats arabes unis'],
        'QAR' => ['symbol' => 'QR',     'name' => 'Riyal qatari'],
        'KWD' => ['symbol' => 'KD',     'name' => 'Dinar koweïtien'],
        'BHD' => ['symbol' => 'BD',     'name' => 'Dinar bahreïni'],
        'OMR' => ['symbol' => 'OR',     'name' => 'Riyal omanais'],
        'ILS' => ['symbol' => '₪',      'name' => 'Shekel israélien'],
        'JOD' => ['symbol' => 'JD',     'name' => 'Dinar jordanien'],
        'IQD' => ['symbol' => 'IQD',    'name' => 'Dinar irakien'],
        'IRR' => ['symbol' => '﷼',      'name' => 'Rial iranien'],
        // Afrique
        'XOF' => ['symbol' => 'F',      'name' => 'Franc CFA Ouest (UEMOA)'],
        'XAF' => ['symbol' => 'F',      'name' => 'Franc CFA Centre (CEMAC)'],
        'NGN' => ['symbol' => '₦',      'name' => 'Naira nigérian'],
        'ZAR' => ['symbol' => 'R',      'name' => 'Rand sud-africain'],
        'KES' => ['symbol' => 'KSh',    'name' => 'Shilling kényan'],
        'GHS' => ['symbol' => '₵',      'name' => 'Cedi ghanéen'],
        'EGP' => ['symbol' => '£',      'name' => 'Livre égyptienne'],
        'MAD' => ['symbol' => 'DH',     'name' => 'Dirham marocain'],
        'DZD' => ['symbol' => 'DA',     'name' => 'Dinar algérien'],
        'TND' => ['symbol' => 'DT',     'name' => 'Dinar tunisien'],
        'ETB' => ['symbol' => 'Br',     'name' => 'Birr éthiopien'],
        'UGX' => ['symbol' => 'USh',    'name' => 'Shilling ougandais'],
        'TZS' => ['symbol' => 'TSh',    'name' => 'Shilling tanzanien'],
        'RWF' => ['symbol' => 'RF',     'name' => 'Franc rwandais'],
        'MGA' => ['symbol' => 'Ar',     'name' => 'Ariary malgache'],
        'XCD' => ['symbol' => 'EC$',    'name' => 'Dollar des Caraïbes orientales'],
        'MUR' => ['symbol' => '₨',      'name' => 'Roupie mauricienne'],
        'CDF' => ['symbol' => 'FC',     'name' => 'Franc congolais'],
        'SOS' => ['symbol' => 'Sh',     'name' => 'Shilling somalien'],
        'SDG' => ['symbol' => 'SDG',    'name' => 'Livre soudanaise'],
        // Amériques
        'BRL' => ['symbol' => 'R$',     'name' => 'Real brésilien'],
        'MXN' => ['symbol' => '$',      'name' => 'Peso mexicain'],
        'COP' => ['symbol' => '$',      'name' => 'Peso colombien'],
        'ARS' => ['symbol' => '$',      'name' => 'Peso argentin'],
        'CLP' => ['symbol' => '$',      'name' => 'Peso chilien'],
        'PEN' => ['symbol' => 'S/.',    'name' => 'Sol péruvien'],
        'UYU' => ['symbol' => '$U',     'name' => 'Peso uruguayen'],
        'PYG' => ['symbol' => '₲',      'name' => 'Guaraní paraguayen'],
        'BOB' => ['symbol' => 'Bs',     'name' => 'Boliviano bolivien'],
        'VES' => ['symbol' => 'Bs.',    'name' => 'Bolívar vénézuélien'],
        'GTQ' => ['symbol' => 'Q',      'name' => 'Quetzal guatémaltèque'],
        'DOP' => ['symbol' => 'RD$',    'name' => 'Peso dominicain'],
        'CRC' => ['symbol' => '₡',      'name' => 'Colón costaricain'],
        'HTG' => ['symbol' => 'G',      'name' => 'Gourde haïtienne'],
        'JMD' => ['symbol' => 'J$',     'name' => 'Dollar jamaïquain'],
        'TTD' => ['symbol' => 'TT$',    'name' => 'Dollar de Trinité-et-Tobago'],
        'BBD' => ['symbol' => 'Bds$',   'name' => 'Dollar de la Barbade'],
        'PAB' => ['symbol' => 'B/.',    'name' => 'Balboa panaméen'],
        'HNL' => ['symbol' => 'L',      'name' => 'Lempira hondurien'],
        'NIO' => ['symbol' => 'C$',     'name' => 'Córdoba nicaraguayen'],
        'SVC' => ['symbol' => '₡',      'name' => 'Colón salvadorien'],
        // Océanie
        'FJD' => ['symbol' => 'FJ$',    'name' => 'Dollar fidjien'],
        'PGK' => ['symbol' => 'K',      'name' => 'Kina papouasien'],
        'WST' => ['symbol' => 'T',      'name' => 'Tālā samoan'],
    ];

    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            ContratDonUsage::create([
                'user_id'    => $user->id,
                'ip_address' => $request->ip(),
            ]);
        }

        $contractHistory = $user
            ? ContractHistory::where('user_id', $user->id)
                ->where('type', 'don')
                ->where('expires_at', '>', now())
                ->latest()
                ->get()
            : collect();

        return view('tools.contrat-don', [
            'currencies'      => $this->currencies,
            'translations'    => $this->translations,
            'flags'           => $this->flagsLabels,
            'republicNames'    => $this->republicNames['fr'],
            'republicNamesAll' => $this->republicNames,
            'capitalCities'    => $this->capitalCities,
            'notaireAdresses'    => $this->notaireAdresses['fr'],
            'notaireAdressesAll' => $this->notaireAdresses,
            'freeUsed'        => $user ? (bool) $user->contrat_don_free_used : false,
            'userCredits'     => $user ? (int) $user->credit_user : 0,
            'contractHistory' => $contractHistory,
        ]);
    }

    public function generate(Request $request)
    {
        $request->validate([
            'donataire_nom'    => 'required|string|max:100',
            'donataire_pays'   => 'required|string|max:60',
            'donataire_adresse' => 'required|string|max:200',
            'donateur_nom'     => 'required|string|max:100',
            'donateur_prenom'  => 'required|string|max:100',
            'donateur_pays'    => 'required|string|max:60',
            'donateur_adresse' => 'required|string|max:200',
            'montant'          => 'required|numeric|min:1',
            'devise'           => 'required|string',
            'lang'             => 'required|string|in:fr,en,es,pt,de,it,ru,ar,zh,tr',
            'pays_notaire'     => 'nullable|string|in:fr,es,it,de,pt,us,gb,be',
            'nom_republique'   => 'nullable|string|max:100',
            'ville_tribunal'   => 'nullable|string|max:100',
            'adresse_notaire'  => 'nullable|string|max:200',
            // Seal customization
            'seal_label'       => 'nullable|string|max:100',
            'seal_notaire'     => 'required|string|max:100',
            'seal_title'       => 'required|string|max:100',
            'seal_city'        => 'required|string|max:100',
            'seal_phone'       => 'required|string|max:40',
            'seal_color'       => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
            'seal_style'       => 'nullable|string|in:round,rect',
        ]);

        $user = Auth::user();
        $sealColor     = $request->input('seal_color', '#1a5ea8');
        $cost = 1000;
        $isTestGeneration = false;

        if (!$user->contrat_don_free_used) {
            $isTestGeneration = true;
        } elseif ($user->credit_user < $cost) {
            return back()->withErrors([
                'credits' => 'Crédits insuffisants. Il vous faut au moins ' . number_format($cost, 0, ',', ' ') . ' crédits pour générer ce document. Votre solde actuel : ' . number_format($user->credit_user, 0, ',', ' ') . ' crédits.',
            ])->withInput();
        }

        $lang          = $request->lang;
        $devise        = $request->devise;
        $t             = $this->translations[$lang] ?? $this->translations['fr'];
        $deviseSymbole = $this->currencies[$devise]['symbol'] ?? '€';

        // Override paragraphes avec les valeurs personnalisées si soumises
        $paraOverrides = [
            'clause_sum'         => $request->input('para_clause'),
            'p2_para1'           => $request->input('para_p2_para1'),
            'p2_bullet1'         => $request->input('para_bullet1'),
            'p2_bullet2'         => $request->input('para_bullet2'),
            'p2_bullet3'         => $request->input('para_bullet3'),
            'p2_accept1'         => $request->input('para_accept1'),
            'p2_accept2'         => $request->input('para_accept2'),
            'p2_notaire_certifie'=> $request->input('para_notcertifie'),
            'p2_legal2'          => $request->input('para_legal2'),
            'p2_legal3'          => $request->input('para_legal3'),
        ];
        foreach ($paraOverrides as $key => $val) {
            if (!empty($val)) $t[$key] = $val;
        }
        $paysNotaire    = $request->get('pays_notaire', 'fr');
        $flagPath         = $this->flagsMap[$paysNotaire] ?? $this->flagsMap['fr'];
        $officialFlagPath = $this->officialFlagsMap[$paysNotaire] ?? $flagPath;
        $nomRepublique  = $request->get('nom_republique') ?: ($this->republicNames[$lang][$paysNotaire] ?? $this->republicNames['fr']['fr']);
        $villeTribunal  = $request->get('ville_tribunal') ?: 'Nantes';
        $territoire     = $this->territoireAdj[$lang][$paysNotaire] ?? $this->territoireAdj['fr']['fr'];
        $adresseNotaire = $request->get('adresse_notaire') ?: ($this->notaireAdresses[$lang][$paysNotaire] ?? $this->notaireAdresses['fr']['fr']);
        $ministereNom   = $this->ministereNoms[$lang][$paysNotaire] ?? $t['ministerio'];

        $deedNo = rand(10, 99) . ' ' . rand(100, 999) . ' - ' . rand(100, 999) . ' MJLDH / TPIC / EMMQ';

        $cabinetLabels = [
            'fr' => 'CABINET NOTARIAL', 'en' => 'NOTARIAL OFFICE',
            'es' => 'NOTARÍA OFICIAL', 'pt' => 'CARTÓRIO NOTARIAL',
            'de' => 'NOTARIELLE KANZLEI', 'it' => 'STUDIO NOTARILE',
            'ru' => 'НОТАРИАЛЬНАЯ КОНТОРА', 'ar' => 'مكتب كاتب العدل',
            'zh' => '公证处', 'tr' => 'NOTERLİK OFİSİ',
        ];

        $sealLabel   = $request->get('seal_label') ?: ($cabinetLabels[$lang] ?? 'CABINET NOTARIAL');
        $sealNotaire = $request->get('seal_notaire') ?: preg_replace('/^Ma[îi]tre\s+/ui', '', $t['p2_notaire_name']);
        $sealTitle   = $request->get('seal_title') ?: $t['p2_notaire_lawyer'];
        $sealCity    = $request->get('seal_city') ?: $villeTribunal;
        $sealPhone   = $request->get('seal_phone') ?: '+44 20 7946 0123';
        $sealStyle   = $request->get('seal_style', 'rect');
        $sealColor   = $request->get('seal_color', '#1a5ea8');

        $cachetPath = $this->generateCachet($sealLabel, $sealNotaire, $sealTitle, $sealCity, $sealPhone, $sealColor, $sealStyle);
        $timbrePath = public_path('images/images entête don/timbre.png');

        // Notary Signature — default image, replaced if user uploads their own
        $signatureNotaire = $request->get('sig_image_data') ?: public_path('images/images entête don/image copy 11.png');

        // Donor Signature — default image, replaced if user uploads their own
        $signatureDonateur = $request->get('sig_don_image_data') ?: public_path('images/images entête don/image copy 10.png');

        $signaturePreteur = null;
        $preteurData = $request->input('signature_preteur_data', '');
        if (!empty($preteurData) && str_starts_with($preteurData, 'data:image/')) {
            $signaturePreteur = $preteurData;
        }

        $pdf = Pdf::loadView('tools.contrat-don-pdf', [
            'lang'                => $lang,
            't'                   => $t,
            'deedNo'              => $deedNo,
            'donataireNom'        => $request->donataire_nom,
            'donatairePays'       => $request->donataire_pays,
            'donataire_adresse'   => $request->donataire_adresse,
            'donateurNom'         => $request->donateur_nom,
            'donateurPrenom'      => $request->donateur_prenom,
            'donateurPays'        => $request->donateur_pays,
            'donateurAdresse'     => $request->donateur_adresse,
            'montant'             => (float) $request->montant,
            'devise'              => $devise,
            'deviseSymbole'       => $deviseSymbole,
            'signaturePreteur'    => $signaturePreteur,
            'isTestGeneration'    => $isTestGeneration,
            'flagPath'            => $flagPath,
            'officialFlagPath'    => $officialFlagPath,
            'paysNotaire'         => $paysNotaire,
            'nomRepublique'       => $nomRepublique,
            'villeTribunal'       => $villeTribunal,
            'territoire'          => $territoire,
            'adresseNotaire'      => $adresseNotaire,
            'ministereNom'        => $ministereNom,
            'cabinetLabels'       => $cabinetLabels,
            'cachetPath'          => $cachetPath,
            'timbrePath'          => $timbrePath,
            'sealNotaire'         => $sealNotaire,
            'signatureNotaire'    => $signatureNotaire,
            'signatureDonateur'   => $signatureDonateur,
        ])->setPaper('a4', 'portrait');

        $filename = 'acte-donation-'
            . strtolower(str_replace(' ', '-', $request->donataire_nom))
            . '-' . date('Ymd') . '.pdf';

        if ($isTestGeneration) {
            DB::table('users')->where('id', $user->id)->update(['contrat_don_free_used' => true]);
        } else {
            DB::table('users')->where('id', $user->id)->decrement('credit_user', $cost);
        }

        // Sauvegarder dans l'historique
        try {
            ContractHistory::saveContract(
                userId:      $user->id,
                type:        'don',
                pdfContent:  $pdf->output(),
                displayName: $filename,
                metadata:    [
                    'donateur'   => ($request->donateur_prenom ?? '') . ' ' . ($request->donateur_nom ?? ''),
                    'donataire'  => $request->donataire_nom,
                    'montant'    => (float) $request->montant,
                    'devise'     => $devise,
                    'lang'       => $lang,
                    'deed_no'    => $deedNo ?? '',
                ],
                isTest:      $isTestGeneration,
            );
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Échec sauvegarde historique contrat-don', ['error' => $e->getMessage()]);
        }

        $response = $pdf->download($filename);
        @unlink($cachetPath);
        return $response;
    }

    private function generateCachet(string $label, string $notaire, string $title, string $city, string $phone, string $hexColor = '#1a5ea8', string $style = 'round'): string
    {
        if ($style === 'rect') {
            return $this->generateRectCachet($label, $notaire, $title, $city, $phone, $hexColor);
        }
        return $this->generateRoundCachet($label, $notaire, $title, $city, $phone, $hexColor);
    }

    private function generateRoundCachet(string $label, string $notaire, string $title, string $city, string $phone, string $hexColor): string
    {
        $size = 800; // Increased size for better definition
        $cx = $cy = 400;
        $fontBold  = base_path('vendor/dompdf/dompdf/lib/fonts/DejaVuSerif-Bold.ttf');
        $fontReg   = base_path('vendor/dompdf/dompdf/lib/fonts/DejaVuSerif.ttf');
        $fontSans  = base_path('vendor/dompdf/dompdf/lib/fonts/DejaVuSans-Bold.ttf');

        $img   = imagecreatetruecolor($size, $size);
        imagealphablending($img, false);
        imagesavealpha($img, true);

        $transparent = imagecolorallocatealpha($img, 255, 255, 255, 127);
        imagefill($img, 0, 0, $transparent);
        imagealphablending($img, true);

        $rgb = $this->hexToRgb($hexColor);
        $color = imagecolorallocate($img, $rgb['r'], $rgb['g'], $rgb['b']);

        // --- 0. TIMBRE (BACKGROUND) ---
        $timbrePath = public_path('images/images entête don/timbre.png');
        if (file_exists($timbrePath)) {
            $timbre = @imagecreatefrompng($timbrePath);
            if ($timbre) {
                $tw = imagesx($timbre); $th = imagesy($timbre);
                $targetW = 400; $targetH = ($th / $tw) * $targetW;
                imagecopyresampled($img, $timbre, (int)($cx - $targetW / 2), (int)($cy - $targetH / 2) + 60, 0, 0, (int)$targetW, (int)$targetH, $tw, $th);
                imagedestroy($timbre);
            }
        }

        // === 1. THICK DOUBLE BORDERS ===
        imagesetthickness($img, 15);
        imagearc($img, $cx, $cy, 770, 770, 0, 360, $color); // Outer very thick
        imagesetthickness($img, 6);
        imagearc($img, $cx, $cy, 740, 740, 0, 360, $color); // Inner thick

        // === 2. SIDE DOTS (Moved away from center to avoid text collision) ===
        imagefilledellipse($img, 60, $cy, 18, 18, $color);
        imagefilledellipse($img, 740, $cy, 18, 18, $color);

        // === 3. TOP/BOTTOM FLOURISHES ===
        $this->drawPremiumFlourish($img, $cx, 65, $color, false);
        $this->drawPremiumFlourish($img, $cx, 675, $color, true);

        // === 4. CENTER ICON: BALANCE & WREATH ===
        $this->drawDetailedScales($img, $cx, 225, $color);
        $this->drawLaurelWreath($img, $cx, 240, $color);

        // === 5. MAIN TEXTS ===
        // Label (CABINET NOTARIAL)
        $txtLabel = strtoupper($label);
        $this->drawCenteredText($img, $txtLabel, $cx, 410, 32, $fontBold, $color);

        // Notaire (NAME)
        $txtNot = strtoupper($notaire);
        $this->drawCenteredText($img, $txtNot, $cx, 470, 36, $fontBold, $color);

        // Separator line with diamond
        imagesetthickness($img, 2);
        imageline($img, $cx - 150, 515, $cx - 20, 515, $color);
        imageline($img, $cx + 20, 515, $cx + 150, 515, $color);
        $this->drawDiamond($img, $cx, 515, 10, $color);

        // Title (AVOCAT...)
        $txtTitle = strtoupper($title);
        $this->drawCenteredText($img, $txtTitle, $cx, 565, 22, $fontReg, $color);

        // City (Londres)
        $txtCity = $city;
        $this->drawCenteredText($img, $txtCity, $cx, 615, 26, $fontReg, $color);

        // === 6. PHONE ===

        // Phone (Curved at the bottom, following the curve like a smile)
        // 135deg (bottom-left) to 45deg (bottom-right)
        $this->drawArcText($img, $phone, $cx, $cy, 335, 140, 40, $color, $fontSans, 28);

        // === SAVE ===
        $dir = storage_path('app/temp');
        if (!is_dir($dir)) mkdir($dir, 0775, true);
        $path = $dir . '/cachet_don_' . uniqid() . '.png';
        imagepng($img, $path);
        imagedestroy($img);

        return $path;
    }

    private function generateRectCachet(string $label, string $notaire, string $title, string $city, string $phone, string $hexColor): string
    {
        $w = 800; $h = 450;
        $img = imagecreatetruecolor($w, $h);

        imagealphablending($img, false);
        imagesavealpha($img, true);
        $transparent = imagecolorallocatealpha($img, 0, 0, 0, 127);
        imagefill($img, 0, 0, $transparent);
        imagealphablending($img, true);

        $rgb = $this->hexToRgb($hexColor);
        $color = imagecolorallocate($img, $rgb['r'], $rgb['g'], $rgb['b']);

        $fontBold  = base_path('vendor/dompdf/dompdf/lib/fonts/DejaVuSerif-Bold.ttf');
        $fontReg   = base_path('vendor/dompdf/dompdf/lib/fonts/DejaVuSerif.ttf');
        $fontSans  = base_path('vendor/dompdf/dompdf/lib/fonts/DejaVuSans-Bold.ttf');

        // --- 1. BORDURES ---
        $m = 20;
        imagesetthickness($img, 12);
        imagerectangle($img, $m, $m, $w - $m, $h - $m, $color);
        imagesetthickness($img, 4);
        imagerectangle($img, $m + 18, $m + 18, $w - ($m + 18), $h - ($m + 18), $color);

        // --- 2. ORNEMENTS DE COINS ---
        $this->drawCornerOrnament($img, $m + 35, $m + 35, 0, $color);
        $this->drawCornerOrnament($img, $w - $m - 35, $m + 35, 90, $color);
        $this->drawCornerOrnament($img, $m + 35, $h - $m - 35, -90, $color);
        $this->drawCornerOrnament($img, $w - $m - 35, $h - $m - 35, 180, $color);

        // --- 3. ICONES - Supprimées pour le style rectangulaire selon la demande

        // --- 4. TEXTES ---
        $this->drawCenteredText($img, strtoupper($label), $w / 2, $m + 70, 22, $fontBold, $color);
        $this->drawCenteredText($img, strtoupper($notaire), $w / 2, $h / 2 - 45, 34, $fontBold, $color);
        
        // Separator
        imagesetthickness($img, 2);
        imageline($img, $w / 2 - 200, $h / 2 + 30, $w / 2 - 30, $h / 2 + 30, $color);
        imageline($img, $w / 2 + 30, $h / 2 + 30, $w / 2 + 200, $h / 2 + 30, $color);
        $this->drawDiamond($img, $w / 2, $h / 2 + 30, 12, $color);

        $this->drawCenteredText($img, strtoupper($title), $w / 2, $h / 2 + 75, 20, $fontReg, $color);
        $this->drawCenteredText($img, $city, $w / 2, $h / 2 + 110, 20, $fontSans, $color);
        $this->drawCenteredText($img, $phone, $w / 2, $h / 2 + 145, 20, $fontSans, $color);

        // === SAVE ===
        $dir = storage_path('app/temp');
        if (!is_dir($dir)) mkdir($dir, 0775, true);
        $path = $dir . '/cachet_don_rect_' . uniqid() . '.png';
        imagepng($img, $path);
        imagedestroy($img);

        return $path;
    }

    private function drawCenteredText($img, $text, $cx, $y, $size, $font, $color)
    {
        $bbox = imagettfbbox($size, 0, $font, $text);
        $tw = $bbox[2] - $bbox[0];
        imagettftext($img, $size, 0, (int)($cx - $tw / 2), $y, $color, $font, $text);
    }

    private function drawPremiumFlourish($img, $cx, $cy, $color, $flipped = false)
    {
        imagesetthickness($img, 3); // Increased "ink" from 2 to 3
        $mult = $flipped ? -1 : 1;
        
        // Main curve
        imagearc($img, $cx - 60, $cy + (15 * $mult), 120, 40, $flipped ? 0 : 180, $flipped ? 90 : 270, $color);
        imagearc($img, $cx + 60, $cy + (15 * $mult), 120, 40, $flipped ? 90 : 270, $flipped ? 180 : 360, $color);
        
        // Center accent
        $this->drawDiamond($img, $cx, $cy + (15 * $mult), 6, $color);
        
        // Small decorative arcs
        imagearc($img, $cx - 30, $cy - (5 * $mult), 40, 20, $flipped ? 180 : 0, $flipped ? 360 : 180, $color);
        imagearc($img, $cx + 30, $cy - (5 * $mult), 40, 20, $flipped ? 180 : 0, $flipped ? 360 : 180, $color);
    }

    private function drawDetailedScales($img, $cx, $cy, $color)
    {
        imagesetthickness($img, 6); // Increased "ink" from 4 to 6
        // Vertical post
        imageline($img, $cx, $cy - 60, $cx, $cy + 60, $color);
        // Crossbar
        imageline($img, $cx - 80, $cy - 35, $cx + 80, $cy - 35, $color);
        // Base
        imageline($img, $cx - 30, $cy + 60, $cx + 30, $cy + 60, $color);
        imageline($img, $cx - 45, $cy + 68, $cx + 45, $cy + 68, $color);
        
        // Plates
        imagesetthickness($img, 3); // Increased from 2 to 3
        // Left
        imageline($img, $cx - 80, $cy - 35, $cx - 105, $cy + 25, $color);
        imageline($img, $cx - 80, $cy - 35, $cx - 55, $cy + 25, $color);
        imagearc($img, $cx - 80, $cy + 25, 60, 25, 0, 180, $color);
        imageline($img, $cx - 110, $cy + 25, $cx - 50, $cy + 25, $color);
        
        // Right
        imageline($img, $cx + 80, $cy - 35, $cx + 105, $cy + 25, $color);
        imageline($img, $cx + 80, $cy - 35, $cx + 55, $cy + 25, $color);
        imagearc($img, $cx + 80, $cy + 25, 60, 25, 0, 180, $color);
        imageline($img, $cx + 110, $cy + 25, $cx + 50, $cy + 25, $color);
    }

    private function drawLaurelWreath($img, $cx, $cy, $color)
    {
        imagesetthickness($img, 3);
        $radius = 155;
        $numLeaves = 15;
        
        for ($i = 0; $i < $numLeaves; $i++) {
            // Left side: from 90 (bottom) to 255
            $angleL = 90 + ($i * 11);
            $radL = deg2rad($angleL);
            $lx = $cx + $radius * cos($radL);
            $ly = $cy + ($radius * 0.75) * sin($radL);
            $this->drawLeaf($img, (int)$lx, (int)$ly, $angleL + 90, $color);
            
            // Right side: from 90 (bottom) to -75
            $angleR = 90 - ($i * 11);
            $radR = deg2rad($angleR);
            $rx = $cx + $radius * cos($radR);
            $ry = $cy + ($radius * 0.75) * sin($radR);
            $this->drawLeaf($img, (int)$rx, (int)$ry, $angleR - 90, $color);
        }
    }

    private function drawLeaf($img, $x, $y, $angle, $color)
    {
        $size = 22; // Increased "ink" from 18 to 22
        $rad = deg2rad($angle);
        $cos = cos($rad);
        $sin = sin($rad);
        
        $points = [
            $x + (int)($size * $cos), $y + (int)($size * $sin),
            $x + (int)($size/2 * cos($rad + M_PI/2)), $y + (int)($size/2 * sin($rad + M_PI/2)),
            $x - (int)($size/4 * $cos), $y - (int)($size/4 * $sin),
            $x + (int)($size/2 * cos($rad - M_PI/2)), $y + (int)($size/2 * sin($rad - M_PI/2)),
        ];
        imagefilledpolygon($img, $points, 4, $color);
    }

    private function drawDiamond($img, $cx, $cy, $size, $color)
    {
        $points = [
            $cx, $cy - $size,
            $cx + $size, $cy,
            $cx, $cy + $size,
            $cx - $size, $cy
        ];
        imagefilledpolygon($img, $points, 4, $color);
    }

    private function drawArcText($img, string $text, float $cx, float $cy, float $r, float $startDeg, float $endDeg, $color, string $font, int $fontSize): void
    {
        $chars = preg_split('//u', $text, -1, PREG_SPLIT_NO_EMPTY);
        $n = count($chars);
        if ($n < 1) return;
        
        $step = ($n > 1) ? ($endDeg - $startDeg) / ($n - 1) : 0;

        foreach ($chars as $i => $char) {
            $deg = $startDeg + ($i * $step);
            $rad = deg2rad($deg);
            
            // Position
            $x = $cx + $r * cos($rad);
            $y = $cy + $r * sin($rad);
            
            // Rotation: make letters upright relative to the viewer
            // For a bottom arc, the letters follow the curve.
            // Angle 90 (6 o'clock) should be 0 rotation (upright)
            $rot = -($deg - 90); 
            
            imagettftext($img, $fontSize, (int)$rot, (int)$x, (int)$y, $color, $font, $char);
        }
    }

    private function drawCornerOrnament($img, $x, $y, $rotation, $color)
    {
        // For GD, we simulate rotation by calculating points or using a simpler logic.
        // For simplicity and speed, let's draw a fixed L-shape based on rotation.
        imagesetthickness($img, 4);
        if ($rotation == 0) { // Top Left
            imageline($img, $x, $y, $x + 40, $y, $color);
            imageline($img, $x, $y, $x, $y + 40, $color);
            imagearc($img, $x + 15, $y + 15, 16, 16, 0, 360, $color);
        } elseif ($rotation == 90) { // Top Right
            imageline($img, $x, $y, $x - 40, $y, $color);
            imageline($img, $x, $y, $x, $y + 40, $color);
            imagearc($img, $x - 15, $y + 15, 16, 16, 0, 360, $color);
        } elseif ($rotation == -90) { // Bottom Left
            imageline($img, $x, $y, $x + 40, $y, $color);
            imageline($img, $x, $y, $x, $y - 40, $color);
            imagearc($img, $x + 15, $y - 15, 16, 16, 0, 360, $color);
        } elseif ($rotation == 180) { // Bottom Right
            imageline($img, $x, $y, $x - 40, $y, $color);
            imageline($img, $x, $y, $x, $y - 40, $color);
            imagearc($img, $x - 15, $y - 15, 16, 16, 0, 360, $color);
        }
    }

    private function hexToRgb(string $hex): array
    {
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        return ['r' => $r, 'g' => $g, 'b' => $b];
    }
}
