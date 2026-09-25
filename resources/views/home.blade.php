@extends('layouts.public')

@section('title', 'Æther Marketing Agency')

@section('content')
<section id="top" class="relative flex min-h-[92vh] items-end overflow-hidden bg-aether-ink pt-24 text-white">
    <video class="absolute inset-0 h-full w-full object-cover opacity-50" autoplay muted loop playsinline poster="{{ asset('media/about.png') }}">
        <source src="{{ asset('media/hero.mp4') }}" type="video/mp4">
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
        <div class="grid gap-4 sm:grid-cols-2">
            @foreach ([
                'Brand strategy & positioning',
                'Web design & landing pages',
                'Social media storytelling',
                'Campaigns with measurable impact',
            ] as $item)
                <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-aether-line/60">
                    <p class="font-semibold text-aether-ink">{{ $item }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section id="about" class="section-pad bg-white">
    <div class="container-narrow grid items-center gap-12 lg:grid-cols-2">
        <img src="{{ asset('media/about.png') }}" alt="About Æther" class="w-full rounded-2xl object-cover shadow-lg">
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
                        <img src="{{ $project->coverUrl() }}" alt="{{ $project->title }}" class="aspect-[5/4] w-full object-cover transition duration-500 group-hover:scale-105">
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

<section id="contact" class="section-pad bg-aether-mist">
    <div class="container-narrow grid gap-10 lg:grid-cols-2">
        <div>
            <h2 class="text-3xl md:text-4xl">Contact us</h2>
            <p class="mt-4 text-aether-accent">Tell us about your goals — we'll help your brand spark across digital aether.</p>
            @if (session('contact_success'))
                <p class="mt-6 rounded-lg bg-aether-cream px-4 py-3 text-sm text-aether-primary">{{ session('contact_success') }}</p>
            @endif
        </div>
        <form method="POST" action="{{ route('contact.store') }}" class="space-y-4 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-aether-line/70 md:p-8">
            @csrf
            <div>
                <label class="mb-1 block text-sm font-semibold" for="name">Name</label>
                <input id="name" name="name" value="{{ old('name') }}" required class="w-full rounded-md border-aether-line focus:border-aether-primary focus:ring-aether-primary">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold" for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-md border-aether-line focus:border-aether-primary focus:ring-aether-primary">
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold" for="message">Message</label>
                <textarea id="message" name="message" rows="5" required class="w-full rounded-md border-aether-line focus:border-aether-primary focus:ring-aether-primary">{{ old('message') }}</textarea>
                @error('message') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="btn-primary w-full md:w-auto">Send message</button>
        </form>
    </div>
</section>
@endsection
