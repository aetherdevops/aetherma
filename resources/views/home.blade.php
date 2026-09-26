@extends('layouts.public')

@section('title', 'Æther Marketing Agency')

@section('content')
<section id="top" class="relative flex min-h-[92vh] items-end overflow-hidden bg-aether-ink pt-24 text-white">
    {{-- Sources are attached by resources/js/app.js only on larger screens without reduced-motion/data-saver; otherwise the poster stays. --}}
    <video class="absolute inset-0 h-full w-full object-cover opacity-50" muted loop playsinline preload="none" aria-hidden="true"
           poster="{{ asset('media/hero-poster.webp') }}" data-hero-video>
        <source data-src="{{ asset('media/hero.webm') }}" type="video/webm">
        <source data-src="{{ asset('media/hero.mp4') }}" type="video/mp4">
    </video>
    <div class="absolute inset-0 bg-gradient-to-t from-aether-ink via-aether-ink/70 to-aether-primary/40"></div>
    <div class="container-narrow relative section-pad !pt-0">
        <p class="mb-4 text-sm font-semibold uppercase tracking-[0.2em] text-aether-cream/80">Æther Marketing Agency</p>
        <h1 class="max-w-3xl text-4xl leading-tight text-white md:text-6xl">
            making your business profitable for today &amp; tomorrow
        </h1>
        <p class="mt-6 max-w-xl text-lg text-white/85">Let your brand's story spark across digital aether</p>
        <div class="mt-10 flex flex-wrap gap-4">
            <a href="#contact" class="btn-primary">Contact us</a>
            <a href="#clients" class="btn-ghost">See portfolio</a>
        </div>
    </div>
</section>

<section class="section-pad bg-white">
    <div class="container-narrow grid gap-8 md:grid-cols-3">
        @foreach ([
            ['Experienced team', 'Strategic thinkers with years of experience'],
            ['Strategic Expertise', 'Tailored approach to success'],
            ['Customer-Centric Approach', 'Your success is our priority'],
        ] as [$title, $text])
            <div class="border-t-2 border-aether-primary pt-6">
                <h3 class="text-xl text-aether-primary">{{ $title }}</h3>
                <p class="mt-3 text-aether-accent">{{ $text }}</p>
            </div>
        @endforeach
    </div>
</section>

<section id="services" class="section-pad bg-aether-mist">
    <div class="container-narrow grid items-center gap-12 lg:grid-cols-2">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-aether-accent">Measurable Impact</p>
            <h2 class="mt-3 text-3xl md:text-4xl">Avoid the Marketing Maze</h2>
            <p class="mt-5 text-aether-accent leading-relaxed">
                Trying to do it all can leave you running in circles, lost in a maze of channels, trends, and tech jargon.
                Don't let your business become a burden. Here is where we can help:
            </p>
            <p class="mt-6 font-display text-lg font-semibold text-aether-primary">Professional — Passionate — Proficient</p>
            <a href="#contact" class="btn-primary mt-8">Navigate to Success</a>
        </div>
        @php
            // Icon paths are 24×24 outline glyphs (Heroicons, MIT).
            $services = [
                ['Brand strategy & positioning', 'Find the story only you can tell, then a name, look and voice that make it stick.',
                    'M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 1-2.4 2.245 4.5 4.5 0 0 0 8.4-2.245c0-.399-.078-.78-.22-1.128Zm0 0a15.998 15.998 0 0 0 3.388-1.62m-5.043-.025a15.994 15.994 0 0 1 1.622-3.395m3.42 3.42a15.995 15.995 0 0 0 4.764-4.648l3.876-5.814a1.151 1.151 0 0 0-1.597-1.597L14.146 6.32a15.996 15.996 0 0 0-4.649 4.763m3.42 3.42a6.776 6.776 0 0 0-3.42-3.42'],
                ['Web design & landing pages', 'Fast, mobile-first sites and landing pages built to turn visitors into enquiries.',
                    'M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25'],
                ['Social media storytelling', 'Feeds, reels and campaigns with a consistent voice that keep your brand top of mind.',
                    'M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z'],
                ['Campaigns with measurable impact', 'Paid and organic campaigns with clear goals, tracking and honest reporting.',
                    'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z'],
            ];
        @endphp
        <div class="grid gap-4 sm:grid-cols-2">
            @foreach ($services as [$title, $text, $icon])
                <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-aether-line/60">
                    <span class="inline-flex h-11 w-11 items-center justify-center rounded-lg bg-aether-cream text-aether-primary">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/></svg>
                    </span>
                    <h3 class="mt-4 text-base text-aether-ink">{{ $title }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-aether-accent">{{ $text }}</p>
                </div>
            @endforeach
        </div>
        </div>
    </div>
</section>

<section id="about" class="section-pad bg-white">
    <div class="container-narrow grid items-center gap-12 lg:grid-cols-2">
        <img src="{{ asset('media/about.webp') }}" alt="The Æther team planning a campaign around a table" width="988" height="988" loading="lazy" decoding="async" class="w-full rounded-2xl object-cover shadow-lg">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-aether-accent">Why Choose</p>
            <h2 class="mt-3 text-3xl md:text-4xl">Æther Marketing Agency</h2>
            <p class="mt-5 leading-relaxed text-aether-accent">
                Æther is a brainchild of passionate visionaries with over 15 years of combined experience in the marketing cosmos.
                Our journey began with a simple, yet powerful idea: creating a marketing agency that wholeheartedly puts clients at its epicenter.
                The cosmic æther, an unseen energy believed to bind the universe, inspired our name and mission.
            </p>
            <p class="mt-4 leading-relaxed text-aether-accent">
                With us, your marketing becomes a beacon, attracting the right audience and growing your business.
                Leave the complexities to us and focus on what you do best — running your business.
            </p>
            <p class="mt-6 font-display text-xl text-aether-primary">Let us guide you to success.</p>
        </div>
    </div>
</section>

<section id="clients" class="section-pad bg-aether-primary text-white">
    <div class="container-narrow">
        <div class="max-w-2xl">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-aether-cream/80">Portfolio</p>
            <h2 class="mt-3 text-3xl text-white md:text-4xl">Projects we've guided to success</h2>
            <p class="mt-4 text-white/80">
                Every client has a unique story, and we're here to help write yours.
                Learn about the brands we've guided to success, turning obstacles into stepping stones on their journey to the top.
            </p>
        </div>

        <div class="mt-12 grid gap-6 md:grid-cols-3">
            @forelse ($projects as $project)
                <a href="{{ route('portfolio.show', $project) }}" class="group overflow-hidden rounded-2xl bg-white/5 ring-1 ring-white/10 transition hover:-translate-y-1 hover:bg-white/10">
                    @if ($project->coverUrl())
                        <img src="{{ $project->coverUrl() }}" alt="{{ $project->title }}" loading="lazy" decoding="async" class="aspect-[5/4] w-full object-cover transition duration-500 group-hover:scale-105">
                    @endif
                    <div class="p-5">
                        <h3 class="text-xl text-white">{{ $project->title }}</h3>
                        <p class="mt-2 text-sm text-white/70">{{ $project->excerpt }}</p>
                    </div>
                </a>
            @empty
                <p class="text-white/70">Portfolio projects coming soon.</p>
            @endforelse
        </div>
    </div>
</section>

@if ($testimonials->isNotEmpty())
<section id="testimonials" class="section-pad bg-white" aria-labelledby="testimonials-title">
    <div class="container-narrow">
        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-aether-accent">Kind words</p>
        <h2 id="testimonials-title" class="mt-3 text-3xl md:text-4xl">What our clients say</h2>
        <div @class([
            'mt-10 grid gap-6',
            'md:grid-cols-2' => $testimonials->count() === 2,
            'md:grid-cols-3' => $testimonials->count() >= 3,
            'max-w-3xl' => $testimonials->count() === 1,
        ])>
            @foreach ($testimonials as $testimonial)
                <figure class="flex flex-col rounded-2xl bg-aether-mist p-6 ring-1 ring-aether-line/60">
                    <svg class="h-8 w-8 text-aether-soft" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true"><path d="M9.3 25C5.7 25 3 22.2 3 18.3 3 12.6 7.2 7.8 13 7l.8 2.4c-3.4 1-5.5 3.5-5.8 6.2h.7c3 0 5.2 2.1 5.2 4.8 0 2.7-2 4.6-4.6 4.6Zm15 0c-3.6 0-6.3-2.8-6.3-6.7 0-5.7 4.2-10.5 10-11.3l.8 2.4c-3.4 1-5.5 3.5-5.8 6.2h.7c3 0 5.2 2.1 5.2 4.8 0 2.7-2 4.6-4.6 4.6Z"/></svg>
                    <blockquote class="mt-4 flex-1 leading-relaxed text-aether-ink">{{ $testimonial->quote }}</blockquote>
                    <figcaption class="mt-6 text-sm">
                        <span class="font-semibold text-aether-primary">{{ $testimonial->author_name }}</span>
                        @if ($testimonial->attribution())<span class="block text-aether-accent">{{ $testimonial->attribution() }}</span>@endif
                    </figcaption>
                </figure>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="bg-aether-ink px-6 py-16 text-white md:px-10 lg:px-16">
    <div class="container-narrow flex flex-col items-start justify-between gap-8 md:flex-row md:items-center">
        <div class="max-w-2xl">
            <h2 class="text-3xl text-white md:text-4xl">Ready to find your way out of the marketing maze?</h2>
            <p class="mt-3 text-white/75">Tell us where you want your business to be. We'll come back with a clear, no-obligation plan to get there.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            @if (config('site.contact.booking_url'))
                <a href="{{ config('site.contact.booking_url') }}" class="btn-primary !bg-aether-soft hover:!bg-aether-primary" target="_blank" rel="noopener">Book a free call</a>
                <a href="#contact" class="btn-ghost">Send a message</a>
            @else
                <a href="#contact" class="btn-primary !bg-aether-soft hover:!bg-aether-primary">Start the conversation</a>
            @endif
        </div>
    </div>
</section>

<section id="contact" class="section-pad bg-aether-mist">
    <div class="container-narrow grid gap-10 lg:grid-cols-2">
        <div>
            <h2 class="text-3xl md:text-4xl">Contact us</h2>
            <p class="mt-4 text-aether-accent">Tell us about your goals — we'll help your brand spark across digital aether. We usually reply within one working day.</p>
            @php($contact = config('site.contact'))
            @if ($contact['email'] || $contact['phone'] || $contact['location'] || $contact['booking_url'])
                <dl class="mt-8 space-y-5">
                    @if ($contact['email'])
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-[0.18em] text-aether-accent">Email</dt>
                            <dd class="mt-1"><a href="mailto:{{ $contact['email'] }}" class="font-semibold text-aether-primary hover:underline">{{ $contact['email'] }}</a></dd>
                        </div>
                    @endif
                    @if ($contact['phone'])
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-[0.18em] text-aether-accent">Phone</dt>
                            <dd class="mt-1"><a href="tel:{{ preg_replace('/[^\d+]/', '', $contact['phone']) }}" class="font-semibold text-aether-primary hover:underline">{{ $contact['phone'] }}</a></dd>
                        </div>
                    @endif
                    @if ($contact['location'])
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-[0.18em] text-aether-accent">Where we are</dt>
                            <dd class="mt-1 text-aether-ink">
                                @if ($contact['map_url'])
                                    <a href="{{ $contact['map_url'] }}" class="hover:underline" target="_blank" rel="noopener">{{ $contact['location'] }}</a>
                                @else
                                    {{ $contact['location'] }}
                                @endif
                            </dd>
                        </div>
                    @endif
                    @if ($contact['booking_url'])
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-[0.18em] text-aether-accent">Prefer to talk?</dt>
                            <dd class="mt-1"><a href="{{ $contact['booking_url'] }}" class="font-semibold text-aether-primary hover:underline" target="_blank" rel="noopener">Book a free 30-minute call &rarr;</a></dd>
                        </div>
                    @endif
                </dl>
            @endif
            @if (session('contact_success'))
                <p class="mt-6 rounded-lg bg-aether-cream px-4 py-3 text-sm text-aether-primary">{{ session('contact_success') }}</p>
            @endif
        </div>
        <form method="POST" action="{{ route('contact.store') }}" class="space-y-4 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-aether-line/70 md:p-8">
            @csrf
            <div class="absolute -left-[9999px] h-px w-px overflow-hidden" aria-hidden="true">
                <label for="website">Leave this field empty</label>
                <input id="website" type="text" name="website" tabindex="-1" autocomplete="off">
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold" for="name">Name</label>
                <input id="name" name="name" autocomplete="name" value="{{ old('name') }}" required class="w-full rounded-md border-aether-line focus:border-aether-primary focus:ring-aether-primary">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold" for="email">Email</label>
                <input id="email" type="email" name="email" autocomplete="email" value="{{ old('email') }}" required class="w-full rounded-md border-aether-line focus:border-aether-primary focus:ring-aether-primary">
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold" for="message">Message</label>
                <textarea id="message" name="message" rows="5" required class="w-full rounded-md border-aether-line focus:border-aether-primary focus:ring-aether-primary">{{ old('message') }}</textarea>
                @error('message') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <p class="text-xs text-aether-accent">We only use your details to reply to you. See our <a href="{{ route('privacy') }}" class="underline hover:text-aether-primary">privacy policy</a>.</p>
            <button type="submit" class="btn-primary w-full md:w-auto">Send message</button>
        </form>
    </div>
</section>
@endsection
