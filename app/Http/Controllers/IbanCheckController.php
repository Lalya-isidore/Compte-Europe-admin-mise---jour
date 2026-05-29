<?php

namespace App\Http\Controllers;

use App\Models\IbanVerification;
use App\Models\ToolPageVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IbanCheckController extends Controller
{
    protected const CREDITS_PER_CHECK = 500;

    public function index()
    {
        ToolPageVisit::record('iban-check');
        $user = Auth::user();
        $history = IbanVerification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return view('tools.iban-check', [
            'creditsDisponibles' => $user->credit_user ?? 0,
            'history' => $history,
            'result' => session('ibanCheckResult'),
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'type' => 'required|in:iban,cb',
            'numero' => 'required|string|min:8|max:50',
        ], [
            'type.required' => 'Sélectionnez le type de vérification.',
            'numero.required' => 'Saisissez le numéro à vérifier.',
            'numero.min' => 'Le numéro est trop court.',
        ]);

        $user = Auth::user();

        if ($user->credit_user < self::CREDITS_PER_CHECK) {
            return back()->withInput()->withErrors([
                'credits' => 'Crédits insuffisants. Vous avez ' . $user->credit_user . ' crédit(s), il faut ' . self::CREDITS_PER_CHECK . ' crédits.',
            ]);
        }

        $type = $request->type;
        $numero = strtoupper(preg_replace('/[\s\-]/', '', $request->numero));

        DB::beginTransaction();

        try {
            // Déduire les crédits
            DB::table('users')
                ->where('id', $user->id)
                ->update(['credit_user' => DB::raw('credit_user - ' . self::CREDITS_PER_CHECK)]);

            if ($type === 'iban') {
                $result = $this->verifyIban($numero);
            } else {
                $result = $this->verifyCb($numero);
            }

            // Masquer le numéro pour l'historique
            $masked = $this->maskNumber($numero, $type);

            IbanVerification::create([
                'user_id' => $user->id,
                'type' => $type,
                'number_masked' => $masked,
                'is_valid' => $result['is_valid'],
                'country' => $result['country'] ?? null,
                'bank_name' => $result['bank_name'] ?? null,
                'bic_code' => $result['bic_code'] ?? null,
                'card_brand' => $result['card_brand'] ?? null,
                'card_type' => $result['card_type'] ?? null,
                'lookup_data' => $result['raw'] ?? null,
                'credits_used' => self::CREDITS_PER_CHECK,
            ]);

            DB::commit();

            return back()->withInput()->with('ibanCheckResult', array_merge($result, [
                'type' => $type,
                'number_masked' => $masked,
            ]));

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Erreur vérification IBAN/CB', [
                'error' => $e->getMessage(),
                'user_id' => $user->id,
            ]);

            return back()->withInput()->withErrors([
                'numero' => 'Erreur lors de la vérification: ' . $e->getMessage(),
            ]);
        }
    }

    private function verifyIban(string $iban): array
    {
        // Pays IBAN avec leurs longueurs attendues
        $ibanLengths = [
            'AL' => 28, 'AD' => 24, 'AT' => 20, 'AZ' => 28, 'BH' => 22, 'BY' => 28,
            'BE' => 16, 'BA' => 20, 'BR' => 29, 'BG' => 22, 'CR' => 22, 'HR' => 21,
            'CY' => 28, 'CZ' => 24, 'DK' => 18, 'DO' => 28, 'TL' => 23, 'EE' => 20,
            'FO' => 18, 'FI' => 18, 'FR' => 27, 'GE' => 22, 'DE' => 22, 'GI' => 23,
            'GR' => 27, 'GL' => 18, 'GT' => 28, 'HU' => 28, 'IS' => 26, 'IE' => 22,
            'IL' => 23, 'IT' => 27, 'JO' => 30, 'KZ' => 20, 'XK' => 20, 'KW' => 30,
            'LV' => 21, 'LB' => 28, 'LI' => 21, 'LT' => 20, 'LU' => 20, 'MK' => 19,
            'MT' => 31, 'MR' => 27, 'MU' => 30, 'MC' => 27, 'MD' => 24, 'ME' => 22,
            'NL' => 18, 'NO' => 15, 'PK' => 24, 'PS' => 29, 'PL' => 28, 'PT' => 25,
            'QA' => 29, 'RO' => 24, 'SM' => 27, 'SA' => 24, 'RS' => 22, 'SK' => 24,
            'SI' => 19, 'ES' => 24, 'SE' => 24, 'CH' => 21, 'TN' => 24, 'TR' => 26,
            'AE' => 23, 'GB' => 22, 'VA' => 22, 'VG' => 24, 'UA' => 29,
        ];

        $countryNames = [
            'FR' => 'France', 'DE' => 'Allemagne', 'GB' => 'Royaume-Uni', 'ES' => 'Espagne',
            'IT' => 'Italie', 'BE' => 'Belgique', 'NL' => 'Pays-Bas', 'PT' => 'Portugal',
            'CH' => 'Suisse', 'AT' => 'Autriche', 'LU' => 'Luxembourg', 'IE' => 'Irlande',
            'PL' => 'Pologne', 'CZ' => 'Tchéquie', 'SE' => 'Suède', 'DK' => 'Danemark',
            'NO' => 'Norvège', 'FI' => 'Finlande', 'GR' => 'Grèce', 'RO' => 'Roumanie',
            'BG' => 'Bulgarie', 'HR' => 'Croatie', 'HU' => 'Hongrie', 'SK' => 'Slovaquie',
            'SI' => 'Slovénie', 'EE' => 'Estonie', 'LV' => 'Lettonie', 'LT' => 'Lituanie',
            'MT' => 'Malte', 'CY' => 'Chypre', 'MC' => 'Monaco', 'SM' => 'Saint-Marin',
            'TR' => 'Turquie', 'MA' => 'Maroc', 'TN' => 'Tunisie', 'SN' => 'Sénégal',
            'CI' => 'Côte d\'Ivoire', 'BJ' => 'Bénin', 'BF' => 'Burkina Faso',
            'CM' => 'Cameroun', 'GA' => 'Gabon', 'CG' => 'Congo', 'TD' => 'Tchad',
            'ML' => 'Mali', 'NE' => 'Niger', 'TG' => 'Togo',
        ];

        if (strlen($iban) < 15 || strlen($iban) > 34) {
            return ['is_valid' => false, 'country' => null, 'bank_name' => null, 'bic_code' => null, 'error' => 'Longueur invalide'];
        }

        if (!preg_match('/^[A-Z]{2}[0-9]{2}[A-Z0-9]+$/', $iban)) {
            return ['is_valid' => false, 'country' => null, 'bank_name' => null, 'bic_code' => null, 'error' => 'Format invalide'];
        }

        $countryCode = substr($iban, 0, 2);

        // Vérifier la longueur spécifique au pays
        if (isset($ibanLengths[$countryCode]) && strlen($iban) !== $ibanLengths[$countryCode]) {
            return [
                'is_valid' => false,
                'country' => $countryNames[$countryCode] ?? $countryCode,
                'bank_name' => null, 'bic_code' => null,
                'error' => 'Longueur incorrecte pour ' . ($countryNames[$countryCode] ?? $countryCode),
            ];
        }

        // Algorithme mod 97
        $rearranged = substr($iban, 4) . substr($iban, 0, 4);
        $numeric = '';
        for ($i = 0; $i < strlen($rearranged); $i++) {
            $char = $rearranged[$i];
            if (ctype_alpha($char)) {
                $numeric .= (ord($char) - 55);
            } else {
                $numeric .= $char;
            }
        }

        // Calcul mod 97 sur grand nombre
        $remainder = '';
        for ($i = 0; $i < strlen($numeric); $i++) {
            $remainder .= $numeric[$i];
            $remainder = (string)(intval($remainder) % 97);
        }

        $isValid = intval($remainder) === 1;
        $country = $countryNames[$countryCode] ?? $countryCode;
        $bankCode = substr($iban, 4, 5);

        return [
            'is_valid' => $isValid,
            'country' => $country,
            'country_code' => $countryCode,
            'bank_name' => null, // Pas de base de données de banques par code
            'bic_code' => null,
            'bank_code' => $bankCode,
            'raw' => ['iban' => $this->maskNumber($iban, 'iban'), 'country_code' => $countryCode, 'bank_code' => $bankCode],
        ];
    }

    private function verifyCb(string $number): array
    {
        $digits = preg_replace('/[^0-9]/', '', $number);

        if (strlen($digits) < 13 || strlen($digits) > 19) {
            return ['is_valid' => false, 'card_brand' => null, 'card_type' => null, 'country' => null, 'bank_name' => null];
        }

        // Algorithme de Luhn
        $sum = 0;
        $alt = false;
        for ($i = strlen($digits) - 1; $i >= 0; $i--) {
            $n = intval($digits[$i]);
            if ($alt) {
                $n *= 2;
                if ($n > 9) $n -= 9;
            }
            $sum += $n;
            $alt = !$alt;
        }
        $isValid = ($sum % 10) === 0;

        // Détection de la marque par les premiers chiffres
        $cardBrand = $this->detectCardBrand($digits);

        // BIN Lookup (6 premiers chiffres)
        $binData = $this->binLookup(substr($digits, 0, 6));

        return [
            'is_valid' => $isValid,
            'card_brand' => $binData['scheme'] ?? $cardBrand,
            'card_type' => $binData['type'] ?? null,
            'country' => $binData['country'] ?? null,
            'bank_name' => $binData['bank'] ?? null,
            'bic_code' => null,
            'raw' => $binData,
        ];
    }

    private function detectCardBrand(string $digits): string
    {
        if (preg_match('/^4/', $digits)) return 'Visa';
        if (preg_match('/^5[1-5]/', $digits)) return 'Mastercard';
        if (preg_match('/^3[47]/', $digits)) return 'American Express';
        if (preg_match('/^6(?:011|5)/', $digits)) return 'Discover';
        if (preg_match('/^3(?:0[0-5]|[68])/', $digits)) return 'Diners Club';
        if (preg_match('/^35/', $digits)) return 'JCB';
        return 'Inconnu';
    }

    private function binLookup(string $bin): array
    {
        try {
            $response = Http::withoutVerifying()
                ->timeout(5)
                ->withHeaders(['Accept-Version' => '3'])
                ->get("https://lookup.binlist.net/{$bin}");

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'scheme' => ucfirst($data['scheme'] ?? ''),
                    'type' => ucfirst($data['type'] ?? ''),
                    'brand' => $data['brand'] ?? null,
                    'country' => $data['country']['name'] ?? null,
                    'country_emoji' => $data['country']['emoji'] ?? null,
                    'bank' => $data['bank']['name'] ?? null,
                    'bank_url' => $data['bank']['url'] ?? null,
                    'prepaid' => $data['prepaid'] ?? null,
                ];
            }
        } catch (\Exception $e) {
            Log::warning('BIN Lookup failed', ['bin' => $bin, 'error' => $e->getMessage()]);
        }

        return [];
    }

    private function maskNumber(string $number, string $type): string
    {
        if ($type === 'iban') {
            if (strlen($number) > 8) {
                return substr($number, 0, 4) . str_repeat('*', strlen($number) - 8) . substr($number, -4);
            }
            return $number;
        }

        // CB
        $digits = preg_replace('/[^0-9]/', '', $number);
        if (strlen($digits) > 8) {
            return substr($digits, 0, 4) . ' **** **** ' . substr($digits, -4);
        }
        return $digits;
    }

    public function destroy($id)
    {
        IbanVerification::where('user_id', Auth::id())->where('id', $id)->delete();
        return back();
    }

    public function clear()
    {
        IbanVerification::where('user_id', Auth::id())->delete();
        return back();
    }
}
