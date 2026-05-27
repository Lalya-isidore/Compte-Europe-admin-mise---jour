<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use App\Models\ContractHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContractHistoryController extends Controller
{
    public function download(int $id)
    {
        $user = Auth::user();
        $record = ContractHistory::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        if ($record->isExpired()) {
            $record->deleteFile();
            $record->delete();
            return back()->withErrors(['history' => 'Ce document a expiré et a été supprimé.']);
        }

        $path = $record->storagePath();
        if (!Storage::disk('local')->exists($path)) {
            $record->delete();
            return back()->withErrors(['history' => 'Fichier introuvable — il a peut-être été supprimé.']);
        }

        return response()->streamDownload(
            fn () => print(Storage::disk('local')->get($path)),
            $record->display_name,
            ['Content-Type' => 'application/pdf']
        );
    }

    public function destroy(int $id)
    {
        $user = Auth::user();
        $record = ContractHistory::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $record->deleteFile();
        $record->delete();

        return back()->with('success', 'Document supprimé de l\'historique.');
    }
}
