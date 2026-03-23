@props(['label' => 'Retour à la page précédente', 'fallback' => route('dashboard')])

@php
    $previousUrl = url()->previous();
    $currentUrl = url()->full();
    $normalizedPrevious = $previousUrl ? rtrim($previousUrl, '/') : null;
    $normalizedCurrent = rtrim($currentUrl, '/');
    $resolvedHref = (!$normalizedPrevious || $normalizedPrevious === $normalizedCurrent)
        ? ($fallback ?? route('dashboard'))
        : $previousUrl;
@endphp

<div class="tool-back-wrapper mb-3">
    <a href="{{ $resolvedHref }}" class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-2 tool-back-link">
        <i class="fas fa-arrow-left"></i>
        <span>{{ $label }}</span>
    </a>
</div>

@once
    <style>
        .tool-back-wrapper {
            display: flex;
            justify-content: flex-start;
        }
        .tool-back-link {
            font-weight: 600;
            letter-spacing: 0.02em;
            text-transform: none;
        }
        .tool-back-link i {
            font-size: 0.85rem;
        }
    </style>
    <script>
        document.addEventListener('click', function (event) {
            const backLink = event.target.closest('.tool-back-link');
            if (!backLink) {
                return;
            }

            if (window.history.length > 1) {
                event.preventDefault();
                window.history.back();
            }
        });
    </script>
@endonce
