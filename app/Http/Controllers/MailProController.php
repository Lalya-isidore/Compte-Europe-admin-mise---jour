<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\MailHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MailProController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $creditsDisponibles = $user->credit_user ?? 0;
        $history = MailHistory::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return view('mail.flash-pro', compact('creditsDisponibles', 'history'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'expediteur' => 'required|string|max:255',
            'destinataire' => 'required|email',
            'objet' => 'required|string|max:500',
            'contenu' => 'required|string',
            'adresse_reponse' => 'nullable|email',
            'fichier' => 'nullable|file|max:2048|mimes:pdf,doc,docx,jpg,jpeg,png'
        ]);

        $user = Auth::user();
        $hasAttachment = $request->hasFile('fichier');
        $creditsNeeded = $hasAttachment ? 2000 : 1000;
        $messageId = 'MAIL_' . Str::uuid()->toString();

        // Vérifier les crédits
        if ($user->credit_user < $creditsNeeded) {
            return response()->json([
                'success' => false,
                'message' => 'Crédits insuffisants. Vous avez ' . $user->credit_user . ' crédit(s), mais ' . $creditsNeeded . ' crédit(s) sont nécessaires.'
            ]);
        }

        DB::beginTransaction();

        try {
            // Déduire les crédits immédiatement
            DB::table('users')
                ->where('id', $user->id)
                ->update(['credit_user' => DB::raw('credit_user - ' . $creditsNeeded)]);

            // Gérer le fichier joint
            $fichierPath = null;
            if ($request->hasFile('fichier')) {
                $fichierPath = $request->file('fichier')->store('mail_attachments', 'public');
            }

            // Envoyer l'email
            $status = 'Rejeté';
            $errorMessage = 'Service d\'envoi d\'email non configuré';

            // Vérifier si le service d'email est configuré
            $trackingPixel = '<img src="' . route('mail.flash.pro.open', ['messageId' => $messageId]) . '" alt="" width="1" height="1" style="display:none;" />';
            $emailBody = $request->contenu . $trackingPixel;

            try {
                Mail::send([], [], function ($message) use ($request, $fichierPath, $emailBody) {
                    $message->from(config('mail.from.address'), $request->expediteur)
                        ->to($request->destinataire)
                        ->subject($request->objet)
                        ->html($emailBody);

                    if ($request->adresse_reponse) {
                        $message->replyTo($request->adresse_reponse);
                    }

                    if ($fichierPath) {
                        $message->attach(storage_path('app/public/' . $fichierPath));
                    }
                });

                $status = 'Envoyé';
                $errorMessage = null;

                Log::info('Email envoyé avec succès', [
                    'to' => $request->destinataire,
                    'from' => $request->expediteur
                ]);

            } catch (\Exception $e) {
                $status = 'Rejeté';
                $errorMessage = 'Erreur envoi email: ' . $e->getMessage();

                Log::error('Erreur envoi email', [
                    'error' => $e->getMessage(),
                    'to' => $request->destinataire
                ]);
            }

            // Si l'email est rejeté, rembourser les crédits
            if ($status === 'Rejeté') {
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['credit_user' => DB::raw('credit_user + ' . $creditsNeeded)]);
            }

            // Sauvegarder dans l'historique
            MailHistory::create([
                'user_id' => $user->id,
                'expediteur' => $request->expediteur,
                'destinataire' => $request->destinataire,
                'objet' => $request->objet,
                'contenu' => $request->contenu,
                'adresse_reponse' => $request->adresse_reponse,
                'fichier_joint' => $fichierPath,
                'credits_used' => $status === 'Envoyé' ? $creditsNeeded : 0,
                'status' => $status,
                'message_id' => $messageId,
                'error_message' => $errorMessage
            ]);

            DB::commit();

            // Récupérer les crédits à jour
            $finalCredits = DB::table('users')
                ->where('id', $user->id)
                ->value('credit_user');

            return response()->json([
                'success' => true,
                'message' => $status === 'Envoyé' ? 'Email envoyé avec succès !' : 'Erreur lors de l\'envoi de l\'email',
                'status' => $status,
                'credits_restants' => $finalCredits
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Erreur traitement email pro', [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue : ' . $e->getMessage()
            ], 500);
        }
    }

    public function details($id)
    {
        $user = Auth::user();
        $mail = MailHistory::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'mail' => $mail
        ]);
    }

    public function deleteHistory()
    {
        $user = Auth::user();
        MailHistory::where('user_id', $user->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Historique supprimé avec succès'
        ]);
    }

    public function trackOpen(Request $request, string $messageId)
    {
        $mail = MailHistory::where('message_id', $messageId)->first();

        if ($mail) {
            $updates = [
                'open_count' => DB::raw('COALESCE(open_count, 0) + 1'),
            ];

            if (! $mail->opened_at) {
                $updates['opened_at'] = now();
            }

            if ($mail->status !== 'Ouvert') {
                $updates['status'] = 'Ouvert';
            }

            MailHistory::where('id', $mail->id)->update($updates);
        }

        $transparentPixel = base64_decode('R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==');

        return response($transparentPixel, 200)
            ->header('Content-Type', 'image/gif')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}
