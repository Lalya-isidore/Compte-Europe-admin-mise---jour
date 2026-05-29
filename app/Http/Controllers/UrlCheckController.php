<?php

namespace App\Http\Controllers;

use App\Models\ToolPageVisit;
use GuzzleHttp\TransferStats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class UrlCheckController extends Controller
{
    public function index()
    {
        ToolPageVisit::record('url-check');
        return view('tools.url-check', [
            'result' => session('urlCheckResult')
        ]);
    }

    public function check(Request $request)
    {
        $validated = $request->validate([
            'url' => ['required', 'string', 'min:4', 'max:255']
        ], [
            'url.required' => 'Saisissez l\'URL à analyser.',
            'url.min' => 'L\'URL semble trop courte.',
            'url.max' => 'L\'URL est trop longue.'
        ]);

        $normalizedUrl = $this->normalizeUrl($validated['url']);

        if (! filter_var($normalizedUrl, FILTER_VALIDATE_URL)) {
            return back()
                ->withErrors(['url' => 'Le format de l\'URL est invalide.'])
                ->withInput();
        }

        $result = [
            'input' => $validated['url'],
            'normalized_url' => $normalizedUrl,
            'ssl' => Str::startsWith($normalizedUrl, 'https://'),
            'ip' => $this->resolveIp($normalizedUrl),
        ];

        try {
            $effectiveUrl = null;
            $transferTime = null;

            $response = Http::timeout(10)
                ->withHeaders([
                    'User-Agent' => 'FlashBilan URL Checker/1.0',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'
                ])
                ->withOptions([
                    'allow_redirects' => true,
                    'on_stats' => function (TransferStats $stats) use (&$effectiveUrl, &$transferTime) {
                        $effectiveUrl = (string) $stats->getEffectiveUri();
                        $transferTime = $stats->getTransferTime();
                    },
                ])
                ->get($normalizedUrl);

            $result['status_code'] = $response->status();
            $result['status_text'] = $response->reason();
            $result['reachable'] = $response->successful();
            $result['final_url'] = $effectiveUrl ?: $normalizedUrl;
            $result['response_time'] = $transferTime ? round($transferTime * 1000) : null;
            $result['headers'] = collect($response->headers())
                ->map(fn ($values, $name) => [
                    'name' => $name,
                    'value' => implode(', ', $values)
                ])
                ->take(6)
                ->values()
                ->all();
            $result['body_snippet'] = Str::limit(trim(strip_tags($response->body())), 200);
        } catch (\Throwable $e) {
            $result['reachable'] = false;
            $result['error'] = $e->getMessage();
        }

        return back()->withInput()->with('urlCheckResult', $result);
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

    private function resolveIp(string $url): ?string
    {
        $host = parse_url($url, PHP_URL_HOST);

        if (! $host) {
            return null;
        }

        $ip = gethostbyname($host);

        return $ip && $ip !== $host ? $ip : null;
    }
}

