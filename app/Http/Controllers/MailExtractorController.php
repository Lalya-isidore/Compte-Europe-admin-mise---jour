<?php

namespace App\Http\Controllers;

use App\Models\EmailExtractorHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MailExtractorController extends Controller
{
    private const SEPARATORS = [
        'line_break' => ["label" => 'Retour à la ligne', 'output' => "\r\n"],
        'comma' => ["label" => 'Virgule ","', 'output' => ', '],
        'semicolon' => ["label" => 'Point-virgule ";"', 'output' => '; '],
        'space' => ["label" => 'Espace', 'output' => ' '],
        'pipe' => ["label" => 'Barre verticale "|"', 'output' => ' | '],
    ];

    public function index()
    {
        $history = EmailExtractorHistory::where('user_id', Auth::id())
            ->latest()
            ->limit(20)
            ->get();

        return view('tools.mail-extractor', [
            'history' => $history,
            'separators' => self::SEPARATORS,
            'latestResult' => session('mailExtractorResult'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'separator' => ['required', 'in:' . implode(',', array_keys(self::SEPARATORS))],
            'text' => ['required', 'string', 'min:5'],
        ], [
            'separator.required' => 'Veuillez choisir un séparateur.',
            'separator.in' => 'Séparateur inconnu.',
            'text.required' => 'Merci de coller un texte à analyser.',
            'text.min' => 'Le texte doit contenir au moins :min caractères.',
        ]);

        $matches = [];
        preg_match_all('/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}/i', $validated['text'], $matches);
        $emails = array_unique(array_map('strtolower', $matches[0] ?? []));
        sort($emails);

        if (empty($emails)) {
            return back()->withErrors([
                'text' => "Aucun e-mail n'a été détecté dans votre texte."
            ])->withInput();
        }

        $separatorKey = $validated['separator'];
        $separator = self::SEPARATORS[$separatorKey]['output'];

        $resultString = implode($separator, $emails);

        $record = EmailExtractorHistory::create([
            'user_id' => Auth::id(),
            'separator' => $separatorKey,
            'result_count' => count($emails),
            'emails' => implode("\n", $emails),
            'source_preview' => Str::limit($validated['text'], 400),
        ]);

        return back()->with('mailExtractorResult', [
            'emails' => $emails,
            'result_string' => $resultString,
            'separator_label' => self::SEPARATORS[$separatorKey]['label'],
            'count' => count($emails),
            'created_at' => $record->created_at,
        ]);
    }

    public function destroy()
    {
        EmailExtractorHistory::where('user_id', Auth::id())->delete();

        return back()->with('mailExtractorResult', null);
    }
}
