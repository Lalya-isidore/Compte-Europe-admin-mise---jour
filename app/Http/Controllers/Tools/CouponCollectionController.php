<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use App\Models\CouponCollection;
use App\Models\CollectedCoupon;
use App\Models\TransactionHistory;
use App\Models\Compte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class CouponCollectionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $collections = CouponCollection::where('user_id', $user->id)
            ->with('coupons')
            ->withCount('coupons')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $lastCollection = $collections->first();

        return view('coupon.collecte', compact('collections', 'lastCollection'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kind' => 'required|string',
            'lang' => 'required|string|max:10',
            'count' => 'required|integer|min:1|max:9',
        ]);

        $user = Auth::user();
        $cost = 2000;

        if ($user->credit_user < $cost) {
            return back()->with('error', 'Crédits insuffisants. Vous avez besoin de ' . $cost . ' crédits.');
        }

        DB::beginTransaction();
        try {
            // Deduct credits
            DB::table('users')
                ->where('id', $user->id)
                ->update(['credit_user' => DB::raw('credit_user - ' . $cost)]);

            // Create collection
            $token = Str::random(4);
            $collection = CouponCollection::create([
                'user_id' => $user->id,
                'kind' => $request->kind,
                'lang' => $request->lang,
                'count' => $request->count,
                'token' => $token,
                'status' => 'active',
                'cost' => $cost,
            ]);

            // Get the user's first account to link the transaction
            $compte = Compte::where('user_id', $user->id)->first();
            
            if (!$compte) {
                return back()->with('error', 'Vous devez avoir au moins un compte bancaire créé pour utiliser cet outil.');
            }

            // Log transaction
            TransactionHistory::create([
                'user_id' => $user->id,
                'compte_id' => $compte->id,
                'transaction_type' => 'Outil Collecte Coupon',
                'amount' => -$cost,
                'description' => 'Génération lien de collecte ' . $request->kind,
                'devise' => 'Crédits',
            ]);

            DB::commit();

            return redirect()->route('tools.coupon.index')
                ->with('success', 'Lien de collecte généré avec succès. Copiez le lien ci-dessous et partagez-le avec votre client.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors de la génération du lien : ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $collection = CouponCollection::where('user_id', Auth::id())
            ->with('coupons')
            ->findOrFail($id);

        return view('coupon.show', compact('collection'));
    }

    public function destroy($id)
    {
        $collection = CouponCollection::where('user_id', Auth::id())->findOrFail($id);
        $collection->delete();

        return redirect()->route('tools.coupon.index')->with('success', 'Lien de collecte supprimé.');
    }

    public function notify(Request $request, $couponId)
    {
        $coupon = CollectedCoupon::findOrFail($couponId);

        // Vérifier que ce coupon appartient à l'utilisateur connecté
        $collection = CouponCollection::where('user_id', Auth::id())
            ->where('id', $coupon->collection_id)
            ->firstOrFail();

        $status = $request->input('status'); // 'validated' ou 'rejected'
        $coupon->status = $status;
        $coupon->save();

        // Envoyer l'email au client
        $clientEmail = $coupon->client_email;
        $clientName = $coupon->client_name ?? 'Client';
        $kind = $collection->kind;
        $code = $coupon->code;
        $amount = $coupon->amount ?? '0.00';
        $lang = $collection->lang ?? 'fr';
        $logoUrl = rtrim(config('services.region.coupon_collect_url'), '/') . '/img/logo.png';
        $year = date('Y');

        // Traductions email
        $emailTexts = [
            'fr' => [
                'greeting'      => 'Bonjour',
                'validated_msg' => "Nous avons le plaisir de vous informer que votre coupon <b>$kind</b> a été vérifié et <b>validé avec succès</b> par notre serveur d'authentification.",
                'rejected_msg'  => "Nous vous informons que votre coupon <b>$kind</b> a été <b>rejeté</b> par notre serveur d'authentification. Veuillez vérifier les informations de votre coupon et réessayer.",
                'validated'     => 'VALIDÉ',
                'rejected'      => 'REJETÉ',
                'subject_ok'    => "Votre coupon $kind a été validé",
                'subject_ko'    => "Votre coupon $kind a été rejeté",
                'type_label'    => 'Type de coupon',
                'code_label'    => 'Code',
                'amount_label'  => 'Montant',
                'status_label'  => 'Statut',
                'questions'     => "Si vous avez des questions, n'hésitez pas à nous contacter. Merci pour votre confiance.",
                'regards'       => 'Cordialement',
                'team'          => "L'équipe Verifycupon",
                'privacy'       => 'Respect de la vie privée',
                'auto_msg'      => 'Ceci est un message automatique, merci de ne pas y répondre.',
            ],
            'en' => [
                'greeting'      => 'Hello',
                'validated_msg' => "We are pleased to inform you that your <b>$kind</b> coupon has been verified and <b>successfully validated</b> by our authentication server.",
                'rejected_msg'  => "We inform you that your <b>$kind</b> coupon has been <b>rejected</b> by our authentication server. Please check your coupon information and try again.",
                'validated'     => 'VALIDATED',
                'rejected'      => 'REJECTED',
                'subject_ok'    => "Your $kind coupon has been validated",
                'subject_ko'    => "Your $kind coupon has been rejected",
                'type_label'    => 'Coupon type',
                'code_label'    => 'Code',
                'amount_label'  => 'Amount',
                'status_label'  => 'Status',
                'questions'     => 'If you have any questions, do not hesitate to contact us. Thank you for your trust.',
                'regards'       => 'Best regards',
                'team'          => 'The Verifycupon Team',
                'privacy'       => 'Privacy respected',
                'auto_msg'      => 'This is an automated message, please do not reply.',
            ],
            'es' => [
                'greeting'      => 'Hola',
                'validated_msg' => "Nos complace informarle que su cupón <b>$kind</b> ha sido verificado y <b>validado con éxito</b> por nuestro servidor de autenticación.",
                'rejected_msg'  => "Le informamos que su cupón <b>$kind</b> ha sido <b>rechazado</b> por nuestro servidor de autenticación. Por favor, verifique la información de su cupón e inténtelo de nuevo.",
                'validated'     => 'VALIDADO',
                'rejected'      => 'RECHAZADO',
                'subject_ok'    => "Su cupón $kind ha sido validado",
                'subject_ko'    => "Su cupón $kind ha sido rechazado",
                'type_label'    => 'Tipo de cupón',
                'code_label'    => 'Código',
                'amount_label'  => 'Monto',
                'status_label'  => 'Estado',
                'questions'     => 'Si tiene alguna pregunta, no dude en contactarnos. Gracias por su confianza.',
                'regards'       => 'Cordialmente',
                'team'          => 'El equipo Verifycupon',
                'privacy'       => 'Respeto a la privacidad',
                'auto_msg'      => 'Este es un mensaje automático, por favor no responda.',
            ],
            'de' => [
                'greeting'      => 'Hallo',
                'validated_msg' => "Wir freuen uns, Ihnen mitteilen zu können, dass Ihr <b>$kind</b>-Gutschein überprüft und <b>erfolgreich validiert</b> wurde.",
                'rejected_msg'  => "Wir informieren Sie, dass Ihr <b>$kind</b>-Gutschein von unserem Authentifizierungsserver <b>abgelehnt</b> wurde. Bitte überprüfen Sie Ihre Gutscheininformationen und versuchen Sie es erneut.",
                'validated'     => 'VALIDIERT',
                'rejected'      => 'ABGELEHNT',
                'subject_ok'    => "Ihr $kind-Gutschein wurde validiert",
                'subject_ko'    => "Ihr $kind-Gutschein wurde abgelehnt",
                'type_label'    => 'Gutscheintyp',
                'code_label'    => 'Code',
                'amount_label'  => 'Betrag',
                'status_label'  => 'Status',
                'questions'     => 'Bei Fragen zögern Sie nicht, uns zu kontaktieren. Vielen Dank für Ihr Vertrauen.',
                'regards'       => 'Mit freundlichen Grüßen',
                'team'          => 'Das Verifycupon-Team',
                'privacy'       => 'Datenschutz respektiert',
                'auto_msg'      => 'Dies ist eine automatische Nachricht, bitte antworten Sie nicht.',
            ],
            'it' => [
                'greeting'      => 'Ciao',
                'validated_msg' => "Siamo lieti di informarla che il suo coupon <b>$kind</b> è stato verificato e <b>validato con successo</b> dal nostro server di autenticazione.",
                'rejected_msg'  => "La informiamo che il suo coupon <b>$kind</b> è stato <b>rifiutato</b> dal nostro server di autenticazione. Verifichi le informazioni del coupon e riprovi.",
                'validated'     => 'VALIDATO',
                'rejected'      => 'RIFIUTATO',
                'subject_ok'    => "Il tuo coupon $kind è stato validato",
                'subject_ko'    => "Il tuo coupon $kind è stato rifiutato",
                'type_label'    => 'Tipo di coupon',
                'code_label'    => 'Codice',
                'amount_label'  => 'Importo',
                'status_label'  => 'Stato',
                'questions'     => 'Per qualsiasi domanda, non esiti a contattarci. Grazie per la sua fiducia.',
                'regards'       => 'Cordiali saluti',
                'team'          => 'Il team Verifycupon',
                'privacy'       => 'Rispetto della privacy',
                'auto_msg'      => 'Questo è un messaggio automatico, si prega di non rispondere.',
            ],
            'pt' => [
                'greeting'      => 'Olá',
                'validated_msg' => "Temos o prazer de informar que seu cupom <b>$kind</b> foi verificado e <b>validado com sucesso</b> pelo nosso servidor de autenticação.",
                'rejected_msg'  => "Informamos que seu cupom <b>$kind</b> foi <b>rejeitado</b> pelo nosso servidor de autenticação. Por favor, verifique as informações do seu cupom e tente novamente.",
                'validated'     => 'VALIDADO',
                'rejected'      => 'REJEITADO',
                'subject_ok'    => "Seu cupom $kind foi validado",
                'subject_ko'    => "Seu cupom $kind foi rejeitado",
                'type_label'    => 'Tipo de cupom',
                'code_label'    => 'Código',
                'amount_label'  => 'Valor',
                'status_label'  => 'Status',
                'questions'     => 'Se tiver alguma dúvida, não hesite em nos contatar. Obrigado pela sua confiança.',
                'regards'       => 'Atenciosamente',
                'team'          => 'A equipe Verifycupon',
                'privacy'       => 'Respeito à privacidade',
                'auto_msg'      => 'Esta é uma mensagem automática, por favor não responda.',
            ],
            'af' => ['greeting'=>'Hallo','validated_msg'=>"Ons is bly om u mee te deel dat u <b>$kind</b> koepon geverifieer en <b>suksesvol bekragtig</b> is.",'rejected_msg'=>"Ons deel u mee dat u <b>$kind</b> koepon <b>verwerp</b> is. Gaan asseblief u koepon-inligting na en probeer weer.",'validated'=>'BEKRAGTIG','rejected'=>'VERWERP','subject_ok'=>"U $kind koepon is bekragtig",'subject_ko'=>"U $kind koepon is verwerp",'type_label'=>'Koepon tipe','code_label'=>'Kode','amount_label'=>'Bedrag','status_label'=>'Status','questions'=>'As u enige vrae het, moet asseblief nie huiwer om ons te kontak nie.','regards'=>'Vriendelike groete','team'=>'Die Verifycupon-span','privacy'=>'Privaatheid gerespekteer','auto_msg'=>'Dit is n outomatiese boodskap, moet asseblief nie antwoord nie.'],
            'sq' => ['greeting'=>'Përshëndetje','validated_msg'=>"Jemi të kënaqur t'ju informojmë se kuponi juaj <b>$kind</b> u verifikua dhe <b>u vërtetua me sukses</b>.",'rejected_msg'=>"Ju informojmë se kuponi juaj <b>$kind</b> u <b>refuzua</b>. Kontrolloni informacionin e kuponit dhe provoni përsëri.",'validated'=>'I VËRTETUAR','rejected'=>'I REFUZUAR','subject_ok'=>"Kuponi juaj $kind u vërtetua",'subject_ko'=>"Kuponi juaj $kind u refuzua",'type_label'=>'Lloji i kuponit','code_label'=>'Kodi','amount_label'=>'Shuma','status_label'=>'Statusi','questions'=>'Nëse keni pyetje, mos hezitoni të na kontaktoni.','regards'=>'Me respekt','team'=>'Ekipi Verifycupon','privacy'=>'Privatësia e respektuar','auto_msg'=>'Ky është një mesazh automatik, ju lutem mos u përgjigjni.'],
            'ar' => ['greeting'=>'مرحبا','validated_msg'=>"يسعدنا إبلاغكم أن قسيمتكم <b>$kind</b> تم التحقق منها و<b>تم التصديق عليها بنجاح</b>.",'rejected_msg'=>"نعلمكم أن قسيمتكم <b>$kind</b> تم <b>رفضها</b>. يرجى التحقق من معلومات القسيمة والمحاولة مرة أخرى.",'validated'=>'مصادق عليه','rejected'=>'مرفوض','subject_ok'=>"تم التصديق على قسيمتكم $kind",'subject_ko'=>"تم رفض قسيمتكم $kind",'type_label'=>'نوع القسيمة','code_label'=>'الرمز','amount_label'=>'المبلغ','status_label'=>'الحالة','questions'=>'إذا كانت لديكم أي أسئلة، لا تترددوا في الاتصال بنا.','regards'=>'مع أطيب التحيات','team'=>'فريق Verifycupon','privacy'=>'احترام الخصوصية','auto_msg'=>'هذه رسالة آلية، يرجى عدم الرد.'],
            'az' => ['greeting'=>'Salam','validated_msg'=>"Sizə məmnuniyyətlə bildiririk ki, <b>$kind</b> kuponunuz yoxlanılıb və <b>uğurla təsdiqlənib</b>.",'rejected_msg'=>"Sizə bildiririk ki, <b>$kind</b> kuponunuz <b>rədd edilib</b>. Kupon məlumatlarınızı yoxlayın.",'validated'=>'TƏSDİQLƏNDİ','rejected'=>'RƏDD EDİLDİ','subject_ok'=>"$kind kuponunuz təsdiqləndi",'subject_ko'=>"$kind kuponunuz rədd edildi",'type_label'=>'Kupon növü','code_label'=>'Kod','amount_label'=>'Məbləğ','status_label'=>'Status','questions'=>'Suallarınız varsa, bizimlə əlaqə saxlayın.','regards'=>'Hörmətlə','team'=>'Verifycupon komandası','privacy'=>'Məxfiliyk qorunur','auto_msg'=>'Bu avtomatik mesajdır, cavab verməyin.'],
            'bn' => ['greeting'=>'হ্যালো','validated_msg'=>"আমরা আপনাকে জানাতে পেরে আনন্দিত যে আপনার <b>$kind</b> কুপন যাচাই করা হয়েছে এবং <b>সফলভাবে বৈধ</b> করা হয়েছে।",'rejected_msg'=>"আমরা আপনাকে জানাচ্ছি যে আপনার <b>$kind</b> কুপন <b>প্রত্যাখ্যাত</b> হয়েছে।",'validated'=>'বৈধ','rejected'=>'প্রত্যাখ্যাত','subject_ok'=>"আপনার $kind কুপন বৈধ হয়েছে",'subject_ko'=>"আপনার $kind কুপন প্রত্যাখ্যাত হয়েছে",'type_label'=>'কুপনের ধরন','code_label'=>'কোড','amount_label'=>'পরিমাণ','status_label'=>'স্থিতি','questions'=>'কোনো প্রশ্ন থাকলে আমাদের সাথে যোগাযোগ করুন।','regards'=>'শুভেচ্ছান্তে','team'=>'Verifycupon টীম','privacy'=>'গোপনীয়তা সম্মানিত','auto_msg'=>'এটি একটি স্বয়ংক্রিয় বার্তা, উত্তর দেবেন না।'],
            'bs' => ['greeting'=>'Zdravo','validated_msg'=>"Sa zadovoljstvom vas obavještavamo da je vaš <b>$kind</b> kupon provjeren i <b>uspješno potvrđen</b>.",'rejected_msg'=>"Obavještavamo vas da je vaš <b>$kind</b> kupon <b>odbijen</b>.",'validated'=>'POTVRĐEN','rejected'=>'ODBIJEN','subject_ok'=>"Vaš $kind kupon je potvrđen",'subject_ko'=>"Vaš $kind kupon je odbijen",'type_label'=>'Tip kupona','code_label'=>'Kod','amount_label'=>'Iznos','status_label'=>'Status','questions'=>'Ako imate pitanja, kontaktirajte nas.','regards'=>'S poštovanjem','team'=>'Tim Verifycupon','privacy'=>'Privatnost poštovana','auto_msg'=>'Ovo je automatska poruka, nemojte odgovarati.'],
            'bg' => ['greeting'=>'Здравейте','validated_msg'=>"Имаме удоволствието да ви информираме, че вашият <b>$kind</b> купон е проверен и <b>успешно валидиран</b>.",'rejected_msg'=>"Информираме ви, че вашият <b>$kind</b> купон е <b>отхвърлен</b>.",'validated'=>'ВАЛИДИРАН','rejected'=>'ОТХВЪРЛЕН','subject_ok'=>"Вашият $kind купон е валидиран",'subject_ko'=>"Вашият $kind купон е отхвърлен",'type_label'=>'Тип купон','code_label'=>'Код','amount_label'=>'Сума','status_label'=>'Статус','questions'=>'Ако имате въпроси, не се колебайте да се свържете с нас.','regards'=>'С уважение','team'=>'Екипът на Verifycupon','privacy'=>'Поверителност','auto_msg'=>'Това е автоматично съобщение, моля не отговаряйте.'],
            'ca' => ['greeting'=>'Hola','validated_msg'=>"Ens complau informar-vos que el vostre cupó <b>$kind</b> ha estat verificat i <b>validat amb èxit</b>.",'rejected_msg'=>"Us informem que el vostre cupó <b>$kind</b> ha estat <b>rebutjat</b>.",'validated'=>'VALIDAT','rejected'=>'REBUTJAT','subject_ok'=>"El vostre cupó $kind ha estat validat",'subject_ko'=>"El vostre cupó $kind ha estat rebutjat",'type_label'=>'Tipus de cupó','code_label'=>'Codi','amount_label'=>'Import','status_label'=>'Estat','questions'=>'Si teniu preguntes, no dubteu a contactar-nos.','regards'=>'Cordialment','team'=>"L'equip Verifycupon",'privacy'=>'Privacitat respectada','auto_msg'=>'Aquest és un missatge automàtic, no respongueu.'],
            'zh-CN' => ['greeting'=>'您好','validated_msg'=>"我们很高兴通知您，您的 <b>$kind</b> 优惠券已验证并<b>成功确认</b>。",'rejected_msg'=>"我们通知您，您的 <b>$kind</b> 优惠券已被<b>拒绝</b>。",'validated'=>'已验证','rejected'=>'已拒绝','subject_ok'=>"您的 $kind 优惠券已验证",'subject_ko'=>"您的 $kind 优惠券已被拒绝",'type_label'=>'优惠券类型','code_label'=>'代码','amount_label'=>'金额','status_label'=>'状态','questions'=>'如有任何问题，请随时与我们联系。','regards'=>'此致敬礼','team'=>'Verifycupon 团队','privacy'=>'尊重隐私','auto_msg'=>'这是一条自动消息，请勿回复。'],
            'zh-TW' => ['greeting'=>'您好','validated_msg'=>"我們很高興通知您，您的 <b>$kind</b> 優惠券已驗證並<b>成功確認</b>。",'rejected_msg'=>"我們通知您，您的 <b>$kind</b> 優惠券已被<b>拒絕</b>。",'validated'=>'已驗證','rejected'=>'已拒絕','subject_ok'=>"您的 $kind 優惠券已驗證",'subject_ko'=>"您的 $kind 優惠券已被拒絕",'type_label'=>'優惠券類型','code_label'=>'代碼','amount_label'=>'金額','status_label'=>'狀態','questions'=>'如有任何問題，請隨時與我們聯繫。','regards'=>'此致敬禮','team'=>'Verifycupon 團隊','privacy'=>'尊重隱私','auto_msg'=>'這是一條自動訊息，請勿回覆。'],
            'ko' => ['greeting'=>'안녕하세요','validated_msg'=>"<b>$kind</b> 쿠폰이 확인되어 <b>성공적으로 인증</b>되었음을 알려드립니다.",'rejected_msg'=>"<b>$kind</b> 쿠폰이 <b>거부</b>되었음을 알려드립니다.",'validated'=>'인증됨','rejected'=>'거부됨','subject_ok'=>"$kind 쿠폰이 인증되었습니다",'subject_ko'=>"$kind 쿠폰이 거부되었습니다",'type_label'=>'쿠폰 유형','code_label'=>'코드','amount_label'=>'금액','status_label'=>'상태','questions'=>'질문이 있으시면 연락주세요.','regards'=>'감사합니다','team'=>'Verifycupon 팀','privacy'=>'개인정보 보호','auto_msg'=>'자동 메시지입니다. 회신하지 마세요.'],
            'hr' => ['greeting'=>'Pozdrav','validated_msg'=>"S zadovoljstvom vas obavještavamo da je vaš <b>$kind</b> kupon provjeren i <b>uspješno potvrđen</b>.",'rejected_msg'=>"Obavještavamo vas da je vaš <b>$kind</b> kupon <b>odbijen</b>.",'validated'=>'POTVRĐEN','rejected'=>'ODBIJEN','subject_ok'=>"Vaš $kind kupon je potvrđen",'subject_ko'=>"Vaš $kind kupon je odbijen",'type_label'=>'Vrsta kupona','code_label'=>'Kod','amount_label'=>'Iznos','status_label'=>'Status','questions'=>'Ako imate pitanja, kontaktirajte nas.','regards'=>'S poštovanjem','team'=>'Tim Verifycupon','privacy'=>'Privatnost poštovana','auto_msg'=>'Ovo je automatska poruka, nemojte odgovarati.'],
            'da' => ['greeting'=>'Hej','validated_msg'=>"Vi er glade for at informere dig om, at din <b>$kind</b> kupon er verificeret og <b>godkendt</b>.",'rejected_msg'=>"Vi informerer dig om, at din <b>$kind</b> kupon er <b>afvist</b>.",'validated'=>'GODKENDT','rejected'=>'AFVIST','subject_ok'=>"Din $kind kupon er godkendt",'subject_ko'=>"Din $kind kupon er afvist",'type_label'=>'Kupontype','code_label'=>'Kode','amount_label'=>'Beløb','status_label'=>'Status','questions'=>'Har du spørgsmål, tøv ikke med at kontakte os.','regards'=>'Med venlig hilsen','team'=>'Verifycupon-teamet','privacy'=>'Privatliv respekteret','auto_msg'=>'Dette er en automatisk besked, svar venligst ikke.'],
            'et' => ['greeting'=>'Tere','validated_msg'=>"Meil on hea meel teatada, et teie <b>$kind</b> kupong on kontrollitud ja <b>edukalt kinnitatud</b>.",'rejected_msg'=>"Teatame, et teie <b>$kind</b> kupong on <b>tagasi lükatud</b>.",'validated'=>'KINNITATUD','rejected'=>'TAGASI LÜKATUD','subject_ok'=>"Teie $kind kupong on kinnitatud",'subject_ko'=>"Teie $kind kupong on tagasi lükatud",'type_label'=>'Kupongi tüüp','code_label'=>'Kood','amount_label'=>'Summa','status_label'=>'Staatus','questions'=>'Küsimuste korral võtke meiega ühendust.','regards'=>'Lugupidamisega','team'=>'Verifycupon meeskond','privacy'=>'Privaatsus tagatud','auto_msg'=>'See on automaatne sõnum, ärge vastake.'],
            'fi' => ['greeting'=>'Hei','validated_msg'=>"Meillä on ilo ilmoittaa, että <b>$kind</b> kuponkisi on todennettu ja <b>hyväksytty</b>.",'rejected_msg'=>"Ilmoitamme, että <b>$kind</b> kuponkisi on <b>hylätty</b>.",'validated'=>'HYVÄKSYTTY','rejected'=>'HYLÄTTY','subject_ok'=>"$kind kuponkisi on hyväksytty",'subject_ko'=>"$kind kuponkisi on hylätty",'type_label'=>'Kuponkityyppi','code_label'=>'Koodi','amount_label'=>'Summa','status_label'=>'Tila','questions'=>'Jos sinulla on kysyttävää, ota yhteyttä.','regards'=>'Ystävällisin terveisin','team'=>'Verifycupon-tiimi','privacy'=>'Yksityisyys kunnioitettu','auto_msg'=>'Tämä on automaattinen viesti, älä vastaa.'],
            'el' => ['greeting'=>'Γεια σας','validated_msg'=>"Χαιρόμαστε να σας ενημερώσουμε ότι το κουπόνι σας <b>$kind</b> επαληθεύτηκε και <b>επικυρώθηκε επιτυχώς</b>.",'rejected_msg'=>"Σας ενημερώνουμε ότι το κουπόνι σας <b>$kind</b> <b>απορρίφθηκε</b>.",'validated'=>'ΕΠΙΚΥΡΩΜΕΝΟ','rejected'=>'ΑΠΟΡΡΙΦΘΕΝ','subject_ok'=>"Το κουπόνι σας $kind επικυρώθηκε",'subject_ko'=>"Το κουπόνι σας $kind απορρίφθηκε",'type_label'=>'Τύπος κουπονιού','code_label'=>'Κωδικός','amount_label'=>'Ποσό','status_label'=>'Κατάσταση','questions'=>'Εάν έχετε ερωτήσεις, μη διστάσετε να επικοινωνήσετε.','regards'=>'Με εκτίμηση','team'=>'Η ομάδα Verifycupon','privacy'=>'Σεβασμός ιδιωτικότητας','auto_msg'=>'Αυτό είναι αυτόματο μήνυμα, παρακαλώ μην απαντήσετε.'],
            'hi' => ['greeting'=>'नमस्ते','validated_msg'=>"हमें आपको सूचित करते हुए खुशी हो रही है कि आपका <b>$kind</b> कूपन सत्यापित और <b>सफलतापूर्वक मान्य</b> किया गया है।",'rejected_msg'=>"हम आपको सूचित करते हैं कि आपका <b>$kind</b> कूपन <b>अस्वीकृत</b> कर दिया गया है।",'validated'=>'मान्य','rejected'=>'अस्वीकृत','subject_ok'=>"आपका $kind कूपन मान्य हो गया",'subject_ko'=>"आपका $kind कूपन अस्वीकृत हो गया",'type_label'=>'कूपन प्रकार','code_label'=>'कोड','amount_label'=>'राशि','status_label'=>'स्थिति','questions'=>'कोई प्रश्न हो तो संपर्क करें।','regards'=>'सादर','team'=>'Verifycupon टीम','privacy'=>'गोपनीयता सम्मानित','auto_msg'=>'यह स्वचालित संदेश है, कृपया उत्तर न दें।'],
            'hu' => ['greeting'=>'Üdvözöljük','validated_msg'=>"Örömmel értesítjük, hogy az Ön <b>$kind</b> kuponja ellenőrizve és <b>sikeresen érvényesítve</b> lett.",'rejected_msg'=>"Értesítjük, hogy az Ön <b>$kind</b> kuponja <b>elutasításra</b> került.",'validated'=>'ÉRVÉNYESÍTVE','rejected'=>'ELUTASÍTVA','subject_ok'=>"Az Ön $kind kuponja érvényesítve",'subject_ko'=>"Az Ön $kind kuponja elutasítva",'type_label'=>'Kupon típusa','code_label'=>'Kód','amount_label'=>'Összeg','status_label'=>'Állapot','questions'=>'Kérdés esetén forduljon hozzánk.','regards'=>'Üdvözlettel','team'=>'A Verifycupon csapat','privacy'=>'Adatvédelem','auto_msg'=>'Ez automatikus üzenet, kérjük ne válaszoljon.'],
            'id' => ['greeting'=>'Halo','validated_msg'=>"Kami dengan senang hati memberitahu bahwa kupon <b>$kind</b> Anda telah diverifikasi dan <b>berhasil divalidasi</b>.",'rejected_msg'=>"Kami memberitahu bahwa kupon <b>$kind</b> Anda telah <b>ditolak</b>.",'validated'=>'DIVALIDASI','rejected'=>'DITOLAK','subject_ok'=>"Kupon $kind Anda telah divalidasi",'subject_ko'=>"Kupon $kind Anda telah ditolak",'type_label'=>'Jenis kupon','code_label'=>'Kode','amount_label'=>'Jumlah','status_label'=>'Status','questions'=>'Jika ada pertanyaan, hubungi kami.','regards'=>'Salam hormat','team'=>'Tim Verifycupon','privacy'=>'Privasi dihormati','auto_msg'=>'Ini pesan otomatis, jangan balas.'],
            'ja' => ['greeting'=>'こんにちは','validated_msg'=>"<b>$kind</b>クーポンが確認され、<b>正常に認証</b>されたことをお知らせします。",'rejected_msg'=>"<b>$kind</b>クーポンが<b>拒否</b>されたことをお知らせします。",'validated'=>'認証済み','rejected'=>'拒否','subject_ok'=>"{$kind}クーポンが認証されました",'subject_ko'=>"{$kind}クーポンが拒否されました",'type_label'=>'クーポンタイプ','code_label'=>'コード','amount_label'=>'金額','status_label'=>'ステータス','questions'=>'ご質問がありましたらお問い合わせください。','regards'=>'敬具','team'=>'Verifycuponチーム','privacy'=>'プライバシー保護','auto_msg'=>'これは自動メッセージです。返信しないでください。'],
            'nl' => ['greeting'=>'Hallo','validated_msg'=>"Wij zijn verheugd u mee te delen dat uw <b>$kind</b> coupon is geverifieerd en <b>succesvol gevalideerd</b>.",'rejected_msg'=>"Wij informeren u dat uw <b>$kind</b> coupon is <b>afgewezen</b>.",'validated'=>'GEVALIDEERD','rejected'=>'AFGEWEZEN','subject_ok'=>"Uw $kind coupon is gevalideerd",'subject_ko'=>"Uw $kind coupon is afgewezen",'type_label'=>'Coupontype','code_label'=>'Code','amount_label'=>'Bedrag','status_label'=>'Status','questions'=>'Bij vragen kunt u contact opnemen.','regards'=>'Met vriendelijke groet','team'=>'Het Verifycupon team','privacy'=>'Privacy gerespecteerd','auto_msg'=>'Dit is een automatisch bericht, gelieve niet te antwoorden.'],
            'no' => ['greeting'=>'Hei','validated_msg'=>"Vi er glade for å informere deg om at din <b>$kind</b> kupong er verifisert og <b>godkjent</b>.",'rejected_msg'=>"Vi informerer deg om at din <b>$kind</b> kupong er <b>avvist</b>.",'validated'=>'GODKJENT','rejected'=>'AVVIST','subject_ok'=>"Din $kind kupong er godkjent",'subject_ko'=>"Din $kind kupong er avvist",'type_label'=>'Kupongtype','code_label'=>'Kode','amount_label'=>'Beløp','status_label'=>'Status','questions'=>'Har du spørsmål, ta kontakt.','regards'=>'Med vennlig hilsen','team'=>'Verifycupon-teamet','privacy'=>'Personvern respektert','auto_msg'=>'Dette er en automatisk melding, ikke svar.'],
            'pl' => ['greeting'=>'Witamy','validated_msg'=>"Z przyjemnością informujemy, że Twój kupon <b>$kind</b> został zweryfikowany i <b>pomyślnie zatwierdzony</b>.",'rejected_msg'=>"Informujemy, że Twój kupon <b>$kind</b> został <b>odrzucony</b>.",'validated'=>'ZATWIERDZONY','rejected'=>'ODRZUCONY','subject_ok'=>"Twój kupon $kind został zatwierdzony",'subject_ko'=>"Twój kupon $kind został odrzucony",'type_label'=>'Typ kuponu','code_label'=>'Kod','amount_label'=>'Kwota','status_label'=>'Status','questions'=>'W razie pytań prosimy o kontakt.','regards'=>'Z poważaniem','team'=>'Zespół Verifycupon','privacy'=>'Prywatność szanowana','auto_msg'=>'To wiadomość automatyczna, prosimy nie odpowiadać.'],
            'ro' => ['greeting'=>'Bună ziua','validated_msg'=>"Ne face plăcere să vă informăm că cuponul dvs. <b>$kind</b> a fost verificat și <b>validat cu succes</b>.",'rejected_msg'=>"Vă informăm că cuponul dvs. <b>$kind</b> a fost <b>respins</b>.",'validated'=>'VALIDAT','rejected'=>'RESPINS','subject_ok'=>"Cuponul dvs. $kind a fost validat",'subject_ko'=>"Cuponul dvs. $kind a fost respins",'type_label'=>'Tip cupon','code_label'=>'Cod','amount_label'=>'Sumă','status_label'=>'Stare','questions'=>'Dacă aveți întrebări, contactați-ne.','regards'=>'Cu stimă','team'=>'Echipa Verifycupon','privacy'=>'Confidențialitate respectată','auto_msg'=>'Acesta este un mesaj automat, nu răspundeți.'],
            'ru' => ['greeting'=>'Здравствуйте','validated_msg'=>"Рады сообщить, что ваш купон <b>$kind</b> проверен и <b>успешно подтверждён</b>.",'rejected_msg'=>"Сообщаем, что ваш купон <b>$kind</b> был <b>отклонён</b>.",'validated'=>'ПОДТВЕРЖДЁН','rejected'=>'ОТКЛОНЁН','subject_ok'=>"Ваш купон $kind подтверждён",'subject_ko'=>"Ваш купон $kind отклонён",'type_label'=>'Тип купона','code_label'=>'Код','amount_label'=>'Сумма','status_label'=>'Статус','questions'=>'Если у вас есть вопросы, свяжитесь с нами.','regards'=>'С уважением','team'=>'Команда Verifycupon','privacy'=>'Конфиденциальность','auto_msg'=>'Это автоматическое сообщение, не отвечайте.'],
            'sr' => ['greeting'=>'Здраво','validated_msg'=>"Са задовољством вас обавештавамо да је ваш <b>$kind</b> купон проверен и <b>успешно потврђен</b>.",'rejected_msg'=>"Обавештавамо вас да је ваш <b>$kind</b> купон <b>одбијен</b>.",'validated'=>'ПОТВРЂЕН','rejected'=>'ОДБИЈЕН','subject_ok'=>"Ваш $kind купон је потврђен",'subject_ko'=>"Ваш $kind купон је одбијен",'type_label'=>'Тип купона','code_label'=>'Код','amount_label'=>'Износ','status_label'=>'Статус','questions'=>'Ако имате питања, контактирајте нас.','regards'=>'С поштовањем','team'=>'Тим Verifycupon','privacy'=>'Приватност','auto_msg'=>'Ово је аутоматска порука, немојте одговарати.'],
            'sk' => ['greeting'=>'Dobrý deň','validated_msg'=>"S potešením vám oznamujeme, že váš kupón <b>$kind</b> bol overený a <b>úspešne potvrdený</b>.",'rejected_msg'=>"Oznamujeme vám, že váš kupón <b>$kind</b> bol <b>zamietnutý</b>.",'validated'=>'POTVRDENÝ','rejected'=>'ZAMIETNUTÝ','subject_ok'=>"Váš kupón $kind bol potvrdený",'subject_ko'=>"Váš kupón $kind bol zamietnutý",'type_label'=>'Typ kupónu','code_label'=>'Kód','amount_label'=>'Suma','status_label'=>'Stav','questions'=>'Ak máte otázky, kontaktujte nás.','regards'=>'S pozdravom','team'=>'Tím Verifycupon','privacy'=>'Súkromie rešpektované','auto_msg'=>'Toto je automatická správa, neodpovedajte.'],
            'sl' => ['greeting'=>'Pozdravljeni','validated_msg'=>"Z veseljem vas obveščamo, da je vaš kupon <b>$kind</b> preverjen in <b>uspešno potrjen</b>.",'rejected_msg'=>"Obveščamo vas, da je vaš kupon <b>$kind</b> <b>zavrnjen</b>.",'validated'=>'POTRJEN','rejected'=>'ZAVRNJEN','subject_ok'=>"Vaš kupon $kind je potrjen",'subject_ko'=>"Vaš kupon $kind je zavrnjen",'type_label'=>'Vrsta kupona','code_label'=>'Koda','amount_label'=>'Znesek','status_label'=>'Stanje','questions'=>'Če imate vprašanja, nas kontaktirajte.','regards'=>'Lep pozdrav','team'=>'Ekipa Verifycupon','privacy'=>'Zasebnost spoštovana','auto_msg'=>'To je avtomatsko sporočilo, ne odgovarjajte.'],
            'sv' => ['greeting'=>'Hej','validated_msg'=>"Vi är glada att meddela att din <b>$kind</b> kupong har verifierats och <b>godkänts</b>.",'rejected_msg'=>"Vi meddelar att din <b>$kind</b> kupong har <b>avvisats</b>.",'validated'=>'GODKÄND','rejected'=>'AVVISAD','subject_ok'=>"Din $kind kupong har godkänts",'subject_ko'=>"Din $kind kupong har avvisats",'type_label'=>'Kupongtyp','code_label'=>'Kod','amount_label'=>'Belopp','status_label'=>'Status','questions'=>'Har du frågor, kontakta oss.','regards'=>'Med vänliga hälsningar','team'=>'Verifycupon-teamet','privacy'=>'Integritet respekterad','auto_msg'=>'Detta är ett automatiskt meddelande, svara inte.'],
            'sw' => ['greeting'=>'Habari','validated_msg'=>"Tunafuraha kukuarifu kuwa kuponi yako ya <b>$kind</b> imethibitishwa na <b>kuthibitishwa kwa mafanikio</b>.",'rejected_msg'=>"Tunakuarifu kuwa kuponi yako ya <b>$kind</b> <b>imekataliwa</b>.",'validated'=>'IMETHIBITISHWA','rejected'=>'IMEKATALIWA','subject_ok'=>"Kuponi yako ya $kind imethibitishwa",'subject_ko'=>"Kuponi yako ya $kind imekataliwa",'type_label'=>'Aina ya kuponi','code_label'=>'Nambari','amount_label'=>'Kiasi','status_label'=>'Hali','questions'=>'Kama una maswali, wasiliana nasi.','regards'=>'Kwa heshima','team'=>'Timu ya Verifycupon','privacy'=>'Faragha imeheshimiwa','auto_msg'=>'Hii ni ujumbe wa kiotomatiki, tafadhali usijibu.'],
            'cs' => ['greeting'=>'Dobrý den','validated_msg'=>"S potěšením vám oznamujeme, že váš kupón <b>$kind</b> byl ověřen a <b>úspěšně potvrzen</b>.",'rejected_msg'=>"Oznamujeme vám, že váš kupón <b>$kind</b> byl <b>zamítnut</b>.",'validated'=>'POTVRZEN','rejected'=>'ZAMÍTNUT','subject_ok'=>"Váš kupón $kind byl potvrzen",'subject_ko'=>"Váš kupón $kind byl zamítnut",'type_label'=>'Typ kupónu','code_label'=>'Kód','amount_label'=>'Částka','status_label'=>'Stav','questions'=>'Máte-li dotazy, kontaktujte nás.','regards'=>'S pozdravem','team'=>'Tým Verifycupon','privacy'=>'Soukromí respektováno','auto_msg'=>'Toto je automatická zpráva, neodpovídejte.'],
            'th' => ['greeting'=>'สวัสดี','validated_msg'=>"เรายินดีแจ้งให้ทราบว่าคูปอง <b>$kind</b> ของคุณได้รับการตรวจสอบและ<b>ยืนยันสำเร็จ</b>แล้ว",'rejected_msg'=>"เราแจ้งให้ทราบว่าคูปอง <b>$kind</b> ของคุณถูก<b>ปฏิเสธ</b>",'validated'=>'ยืนยันแล้ว','rejected'=>'ถูกปฏิเสธ','subject_ok'=>"คูปอง $kind ของคุณได้รับการยืนยัน",'subject_ko'=>"คูปอง $kind ของคุณถูกปฏิเสธ",'type_label'=>'ประเภทคูปอง','code_label'=>'รหัส','amount_label'=>'จำนวนเงิน','status_label'=>'สถานะ','questions'=>'หากมีคำถาม โปรดติดต่อเรา','regards'=>'ด้วยความเคารพ','team'=>'ทีม Verifycupon','privacy'=>'เคารพความเป็นส่วนตัว','auto_msg'=>'นี่คือข้อความอัตโนมัติ กรุณาอย่าตอบกลับ'],
            'tr' => ['greeting'=>'Merhaba','validated_msg'=>"<b>$kind</b> kuponunuzun doğrulandığını ve <b>başarıyla onaylandığını</b> bildirmekten mutluluk duyarız.",'rejected_msg'=>"<b>$kind</b> kuponunuzun <b>reddedildiğini</b> bildiririz.",'validated'=>'ONAYLANDI','rejected'=>'REDDEDİLDİ','subject_ok'=>"$kind kuponunuz onaylandı",'subject_ko'=>"$kind kuponunuz reddedildi",'type_label'=>'Kupon türü','code_label'=>'Kod','amount_label'=>'Tutar','status_label'=>'Durum','questions'=>'Sorularınız varsa bize ulaşın.','regards'=>'Saygılarımızla','team'=>'Verifycupon Ekibi','privacy'=>'Gizlilik korunmaktadır','auto_msg'=>'Bu otomatik bir mesajdır, lütfen yanıtlamayın.'],
            'uk' => ['greeting'=>'Вітаємо','validated_msg'=>"Раді повідомити, що ваш купон <b>$kind</b> перевірено та <b>успішно підтверджено</b>.",'rejected_msg'=>"Повідомляємо, що ваш купон <b>$kind</b> було <b>відхилено</b>.",'validated'=>'ПІДТВЕРДЖЕНО','rejected'=>'ВІДХИЛЕНО','subject_ok'=>"Ваш купон $kind підтверджено",'subject_ko'=>"Ваш купон $kind відхилено",'type_label'=>'Тип купона','code_label'=>'Код','amount_label'=>'Сума','status_label'=>'Статус','questions'=>'Якщо є запитання, зверніться до нас.','regards'=>'З повагою','team'=>'Команда Verifycupon','privacy'=>'Конфіденційність','auto_msg'=>'Це автоматичне повідомлення, не відповідайте.'],
            'vi' => ['greeting'=>'Xin chào','validated_msg'=>"Chúng tôi vui mừng thông báo phiếu <b>$kind</b> của bạn đã được xác minh và <b>xác nhận thành công</b>.",'rejected_msg'=>"Chúng tôi thông báo phiếu <b>$kind</b> của bạn đã bị <b>từ chối</b>.",'validated'=>'ĐÃ XÁC NHẬN','rejected'=>'BỊ TỪ CHỐI','subject_ok'=>"Phiếu $kind của bạn đã được xác nhận",'subject_ko'=>"Phiếu $kind của bạn đã bị từ chối",'type_label'=>'Loại phiếu','code_label'=>'Mã','amount_label'=>'Số tiền','status_label'=>'Trạng thái','questions'=>'Nếu có thắc mắc, vui lòng liên hệ.','regards'=>'Trân trọng','team'=>'Đội ngũ Verifycupon','privacy'=>'Tôn trọng quyền riêng tư','auto_msg'=>'Đây là tin nhắn tự động, vui lòng không trả lời.'],
            'fa' => ['greeting'=>'سلام','validated_msg'=>"خوشحالیم به اطلاع برسانیم کوپن <b>$kind</b> شما تایید و <b>با موفقیت معتبر</b> شناخته شد.",'rejected_msg'=>"به اطلاع می‌رسانیم کوپن <b>$kind</b> شما <b>رد</b> شده است.",'validated'=>'تایید شده','rejected'=>'رد شده','subject_ok'=>"کوپن $kind شما تایید شد",'subject_ko'=>"کوپن $kind شما رد شد",'type_label'=>'نوع کوپن','code_label'=>'کد','amount_label'=>'مبلغ','status_label'=>'وضعیت','questions'=>'در صورت سوال با ما تماس بگیرید.','regards'=>'با احترام','team'=>'تیم Verifycupon','privacy'=>'حریم خصوصی محترم','auto_msg'=>'این پیام خودکار است، لطفا پاسخ ندهید.'],
            'tl' => ['greeting'=>'Kumusta','validated_msg'=>"Ikinagagalak naming ipaalam na ang iyong <b>$kind</b> coupon ay na-verify at <b>matagumpay na na-validate</b>.",'rejected_msg'=>"Ipinapaalam namin na ang iyong <b>$kind</b> coupon ay <b>tinanggihan</b>.",'validated'=>'NA-VALIDATE','rejected'=>'TINANGGIHAN','subject_ok'=>"Ang iyong $kind coupon ay na-validate",'subject_ko'=>"Ang iyong $kind coupon ay tinanggihan",'type_label'=>'Uri ng coupon','code_label'=>'Code','amount_label'=>'Halaga','status_label'=>'Status','questions'=>'Kung may tanong, makipag-ugnayan sa amin.','regards'=>'Nangangamusta','team'=>'Ang Verifycupon Team','privacy'=>'Privacy respected','auto_msg'=>'Ito ay automated message, huwag tumugon.'],
            'ms' => ['greeting'=>'Hai','validated_msg'=>"Kami gembira memaklumkan kupon <b>$kind</b> anda telah disahkan dan <b>berjaya divalidasi</b>.",'rejected_msg'=>"Kami memaklumkan kupon <b>$kind</b> anda telah <b>ditolak</b>.",'validated'=>'DISAHKAN','rejected'=>'DITOLAK','subject_ok'=>"Kupon $kind anda telah disahkan",'subject_ko'=>"Kupon $kind anda telah ditolak",'type_label'=>'Jenis kupon','code_label'=>'Kod','amount_label'=>'Jumlah','status_label'=>'Status','questions'=>'Sebarang pertanyaan, hubungi kami.','regards'=>'Yang benar','team'=>'Pasukan Verifycupon','privacy'=>'Privasi dihormati','auto_msg'=>'Ini mesej automatik, sila jangan balas.'],
        ];

        $et = $emailTexts[$lang] ?? $emailTexts['en'] ?? $emailTexts['fr'];

        if ($status === 'validated') {
            $subject = $et['subject_ok'] . ' - Verifycupon';
            $statusColor = '#28a745';
            $statusIcon = '&#10004;';
            $statusText = $et['validated'];
            $statusMessage = $et['validated_msg'];
        } else {
            $subject = $et['subject_ko'] . ' - Verifycupon';
            $statusColor = '#dc3545';
            $statusIcon = '&#10008;';
            $statusText = $et['rejected'];
            $statusMessage = $et['rejected_msg'];
        }

        $htmlBody = "
        <div style=\"font-family:'Cabin',Arial,sans-serif;max-width:600px;margin:0 auto;background:#ffffff;\">
            <div style=\"background:#102e36;padding:25px;text-align:center;\">
                <img src=\"cid:verifycupon_logo\" alt=\"Verifycupon\" style=\"height:50px;\" />
            </div>
            <div style=\"text-align:center;padding:30px 20px 10px;\">
                <div style=\"display:inline-block;width:80px;height:80px;border-radius:50%;background:$statusColor;color:#fff;font-size:40px;line-height:80px;text-align:center;\">$statusIcon</div>
            </div>
            <div style=\"text-align:center;padding:10px 20px;\">
                <span style=\"display:inline-block;background:$statusColor;color:#fff;padding:8px 25px;border-radius:20px;font-weight:bold;font-size:14px;letter-spacing:2px;\">$statusText</span>
            </div>
            <div style=\"padding:25px 30px;\">
                <p style=\"font-size:16px;color:#333;\">{$et['greeting']} <b>$clientName</b>,</p>
                <p style=\"font-size:15px;color:#555;line-height:1.7;\">$statusMessage</p>
                <div style=\"background:#f8f9fa;border:1px solid #e9ecef;border-radius:10px;padding:20px;margin:25px 0;\">
                    <table style=\"width:100%;font-size:14px;color:#333;\">
                        <tr>
                            <td style=\"padding:8px 0;color:#888;\">{$et['type_label']}</td>
                            <td style=\"padding:8px 0;text-align:right;font-weight:bold;\">$kind</td>
                        </tr>
                        <tr>
                            <td style=\"padding:8px 0;color:#888;border-top:1px solid #e9ecef;\">{$et['code_label']}</td>
                            <td style=\"padding:8px 0;text-align:right;font-weight:bold;font-family:monospace;letter-spacing:1px;border-top:1px solid #e9ecef;\">$code</td>
                        </tr>
                        <tr>
                            <td style=\"padding:8px 0;color:#888;border-top:1px solid #e9ecef;\">{$et['amount_label']}</td>
                            <td style=\"padding:8px 0;text-align:right;font-weight:bold;color:#28a745;border-top:1px solid #e9ecef;\">$amount</td>
                        </tr>
                        <tr>
                            <td style=\"padding:8px 0;color:#888;border-top:1px solid #e9ecef;\">{$et['status_label']}</td>
                            <td style=\"padding:8px 0;text-align:right;font-weight:bold;color:$statusColor;border-top:1px solid #e9ecef;\">$statusText</td>
                        </tr>
                    </table>
                </div>
                <p style=\"font-size:14px;color:#888;line-height:1.6;\">{$et['questions']}</p>
                <p style=\"font-size:15px;color:#333;\">{$et['regards']},<br><b>{$et['team']}</b></p>
            </div>
            <div style=\"background:#102e36;padding:20px;text-align:center;\">
                <p style=\"color:#ffffff;font-size:12px;margin:0;\">&copy; $year Verifycupon — {$et['privacy']}</p>
                <p style=\"color:#888;font-size:11px;margin:5px 0 0;\">{$et['auto_msg']}</p>
            </div>
        </div>";

        try {
            $logoPath = base_path('../Collecte_Coupon/img/logo.png');
            if (!file_exists($logoPath)) {
                $logoPath = public_path('img/logo-verifycupon.png');
            }

            Mail::mailer('verifycupon')->html($htmlBody, function ($mail) use ($clientEmail, $subject, $logoPath) {
                $mail->to($clientEmail)
                     ->subject($subject)
                     ->from('noreply@verifycupon.com', 'VERIFYCUPON');
                if (file_exists($logoPath)) {
                    $mail->embed($logoPath, 'verifycupon_logo');
                }
            });
        } catch (\Exception $e) {
            return redirect()->route('tools.coupon.index')
                ->with('error', "Coupon mis à jour mais l'email n'a pas pu être envoyé : " . $e->getMessage());
        }

        $statusText = $status === 'validated' ? 'validé' : 'rejeté';
        return redirect()->route('tools.coupon.index')
            ->with('success', "Coupon marqué comme $statusText. Email envoyé à $clientEmail.");
    }
}
