{{-- Only needed when a cookie-setting tracker (GA4) is configured. Essential session cookies need no consent. --}}
@if (app()->isProduction() && config('site.analytics.ga4_id'))
    <div x-data="cookieConsent" x-show="visible" x-cloak x-transition.opacity
         class="fixed inset-x-4 bottom-4 z-50 mx-auto max-w-xl rounded-xl bg-aether-ink p-5 text-sm text-aether-cream shadow-2xl ring-1 ring-white/10"
         role="dialog" aria-live="polite" aria-label="Cookie consent">
        <p>We use analytics cookies to understand how visitors use this site, only if you allow it.
            <a href="{{ route('privacy') }}#cookies" class="underline hover:text-white">Learn more</a>.</p>
        <div class="mt-4 flex flex-wrap gap-3">
            <button type="button" @click="accept()" class="btn-primary !bg-aether-soft !px-4 !py-2 text-xs hover:!bg-aether-primary">Accept analytics</button>
            <button type="button" @click="decline()" class="btn-ghost !px-4 !py-2 text-xs">Only essential</button>
        </div>
    </div>
@endif
