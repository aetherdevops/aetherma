@php($analytics = config('site.analytics'))
@if (app()->isProduction())
    @if ($analytics['plausible_domain'])
        {{-- Cookieless, so it needs no consent. --}}
        <script defer data-domain="{{ $analytics['plausible_domain'] }}" src="https://plausible.io/js/script.js"></script>
    @endif
    @if ($analytics['ga4_id'])
        {{-- Loaded by resources/js/app.js only after the visitor accepts cookies. --}}
        <meta name="ga4-id" content="{{ $analytics['ga4_id'] }}">
    @endif
@endif
