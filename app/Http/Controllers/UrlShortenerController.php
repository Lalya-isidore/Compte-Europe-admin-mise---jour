<?php

namespace App\Http\Controllers;

use App\Models\UrlShortener;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class UrlShortenerController extends Controller
{
    public function index()
    {
        $history = UrlShortener::where('user_id', Auth::id())
            ->latest()
            ->limit(20)
            ->get();

        return view('tools.url-shortener', compact('history'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'url' => ['required', 'url']
        ], [
            'url.required' => "L'adresse URL est requise.",
            'url.url' => "L'adresse fournie n'est pas un lien valide."
        ]);

        $normalized = $this->normalizeUrl($validated['url']);

        try {
            $response = Http::timeout(10)
                ->get('https://is.gd/create.php', [
                    'format' => 'simple',
                    'url' => $normalized,
                ]);

            if ($response->failed()) {
                throw new \RuntimeException('Service indisponible pour le moment.');
            }

            $shortUrl = trim($response->body());

            if (! Str::startsWith($shortUrl, 'http')) {
                throw new \RuntimeException($shortUrl ?: 'Impossible de générer le raccourci.');
            }

            $record = UrlShortener::create([
                'user_id' => Auth::id(),
                'original_url' => $normalized,
                'short_url' => $shortUrl,
                'provider' => 'is.gd',
            ]);

            return back()->with('shortResult', [
                'short_url' => $record->short_url,
                'original_url' => $record->original_url,
                'created_at' => $record->created_at,
            ]);
        } catch (\Throwable $e) {
            return back()->withErrors([
                'url' => $e->getMessage()
            ])->withInput();
        }
    }

    public function destroy()
    {
        UrlShortener::where('user_id', Auth::id())->delete();

        return back()->with('shortResult', null);
    }

    private function normalizeUrl(string $url): string
    {
        $trimmed = trim($url);

        if ($trimmed === '') {
            return $trimmed;
        }

        if (! Str::startsWith($trimmed, ['http://', 'https://'])) {
            $trimmed = 'https://' . ltrim($trimmed, '/');
        }

        return $trimmed;
    }
}
