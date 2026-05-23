<?php

namespace App\Http\Controllers;

use App\Models\PhoneVerification;
use App\Services\NumverifyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PhoneVerifyController extends Controller
{
    protected const CREDITS_PER_LOOKUP = 500;

    public function index()
    {
        $user = Auth::user();
        $creditsDisponibles = $user->credit_user ?? 0;
        $history = PhoneVerification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return view('tools.phone-verify', [
            'creditsDisponibles' => $creditsDisponibles,
            'history' => $history,
            'result' => session('phoneVerifyResult'),
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'pays' => 'required|string',
            'numero' => 'required|string|min:4|max:20',
        ], [
            'pays.required' => 'Sélectionnez l\'indicatif du pays.',
            'numero.required' => 'Saisissez le numéro de téléphone.',
            'numero.min' => 'Le numéro est trop court.',
        ]);

        $user = Auth::user();

        if ($user->credit_user < self::CREDITS_PER_LOOKUP) {
            return back()->withInput()->withErrors([
                'credits' => 'Crédits insuffisants. Vous avez ' . $user->credit_user . ' crédit(s), il faut ' . self::CREDITS_PER_LOOKUP . ' crédits.',
            ]);
        }

        // Nettoyer le numéro
        $countryCode = $request->pays;
        $numero = preg_replace('/[\s\-\.]/', '', $request->numero);
        $cleanCode = ltrim($countryCode, '+');

        if (str_starts_with($numero, $countryCode)) {
            $numero = substr($numero, strlen($countryCode));
        } elseif (str_starts_with($numero, '+' . $cleanCode)) {
            $numero = substr($numero, strlen('+' . $cleanCode));
        } elseif (str_starts_with($numero, '00' . $cleanCode)) {
            $numero = substr($numero, strlen('00' . $cleanCode));
        }

        $fullNumber = $countryCode . $numero;

        DB::beginTransaction();

        try {
            // Déduire les crédits
            DB::table('users')
                ->where('id', $user->id)
                ->update(['credit_user' => DB::raw('credit_user - ' . self::CREDITS_PER_LOOKUP)]);

            // Appeler l'API Numverify Number Lookup
            $numverify = app(NumverifyService::class);
            $lookup = $numverify->numberLookup($fullNumber);

            if (!$lookup['success']) {
                // Rembourser en cas d'échec API
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['credit_user' => DB::raw('credit_user + ' . self::CREDITS_PER_LOOKUP)]);

                PhoneVerification::create([
                    'user_id' => $user->id,
                    'phone_number' => $fullNumber,
                    'is_valid' => false,
                    'credits_used' => 0,
                    'error_message' => $lookup['error'] ?? 'Erreur inconnue',
                ]);

                DB::commit();

                return back()->withInput()->with('phoneVerifyResult', [
                    'success' => false,
                    'phone_number' => $fullNumber,
                    'error' => $lookup['error'] ?? 'Erreur lors de la vérification',
                ]);
            }

            // Sauvegarder le résultat
            PhoneVerification::create([
                'user_id' => $user->id,
                'phone_number' => $fullNumber,
                'is_valid' => $lookup['is_valid'],
                'country_name' => $lookup['country_name'],
                'country_code' => $lookup['country_code'],
                'network_name' => $lookup['network_name'],
                'network_type' => $lookup['network_type'],
                'is_reachable' => $lookup['is_reachable'],
                'lookup_data' => $lookup['raw'],
                'credits_used' => self::CREDITS_PER_LOOKUP,
            ]);

            DB::commit();

            return back()->withInput()->with('phoneVerifyResult', [
                'success' => true,
                'phone_number' => $fullNumber,
                'is_valid' => $lookup['is_valid'],
                'country_name' => $lookup['country_name'],
                'country_code' => $lookup['country_code'],
                'network_name' => $lookup['network_name'],
                'network_type' => $lookup['network_type'],
                'is_reachable' => $lookup['is_reachable'],
                'ported' => $lookup['ported'],
                'roaming' => $lookup['roaming'],
                'status' => $lookup['status'],
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Erreur vérification téléphone', [
                'error' => $e->getMessage(),
                'user_id' => $user->id,
            ]);

            return back()->withInput()->withErrors([
                'numero' => 'Erreur lors de la vérification: ' . $e->getMessage(),
            ]);
        }
    }

    public function destroy($id)
    {
        PhoneVerification::where('user_id', Auth::id())->where('id', $id)->delete();
        return back();
    }

    public function clear()
    {
        PhoneVerification::where('user_id', Auth::id())->delete();
        return back();
    }
}
