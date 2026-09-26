@php($site = config('site'))
<footer class="bg-aether-ink text-aether-cream">
    <div class="container-narrow section-pad !py-14">
        <div class="grid gap-10 md:grid-cols-[1.4fr_1fr_1fr]">
            <div>
                <p class="font-display text-xl font-bold">{{ $site['name'] }}</p>
                <p class="mt-2 max-w-sm text-sm text-aether-cream/70">{{ $site['tagline'] }}</p>
                @if ($site['social'])
                    <ul class="mt-5 flex flex-wrap gap-x-5 gap-y-2 text-sm">
                        @foreach ($site['social'] as $network => $url)
                            <li><a href="{{ $url }}" class="text-aether-cream/80 hover:text-white" target="_blank" rel="noopener">{{ $network }}</a></li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <nav aria-label="Footer">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-aether-cream/50">Explore</p>
                <ul class="mt-4 space-y-2 text-sm">
                    <li><a href="{{ route('home') }}#services" class="hover:text-white">Services</a></li>
                    <li><a href="{{ route('home') }}#about" class="hover:text-white">Our Story</a></li>
                    <li><a href="{{ route('home') }}#clients" class="hover:text-white">Portfolio</a></li>
                    <li><a href="{{ route('home') }}#contact" class="hover:text-white">Contact</a></li>
                </ul>
            </nav>
            @if ($site['contact']['email'] || $site['contact']['phone'] || $site['contact']['location'])
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-aether-cream/50">Get in touch</p>
                    <ul class="mt-4 space-y-2 text-sm">
                        @if ($site['contact']['email'])
                            <li><a href="mailto:{{ $site['contact']['email'] }}" class="hover:text-white">{{ $site['contact']['email'] }}</a></li>
                        @endif
                        @if ($site['contact']['phone'])
                            <li><a href="tel:{{ preg_replace('/[^\d+]/', '', $site['contact']['phone']) }}" class="hover:text-white">{{ $site['contact']['phone'] }}</a></li>
                        @endif
                        @if ($site['contact']['location'])
                            <li class="text-aether-cream/80">{{ $site['contact']['location'] }}</li>
                        @endif
                    </ul>
                </div>
            @endif
        </div>
        <div class="mt-10 flex flex-col gap-3 border-t border-white/10 pt-6 text-xs text-aether-cream/50 sm:flex-row sm:justify-between">
            <p>&copy; {{ date('Y') }} {{ $site['name'] }}</p>
            <p><a href="{{ route('privacy') }}" class="hover:text-white">Privacy &amp; cookies</a></p>
        </div>
    </div>
</footer>
