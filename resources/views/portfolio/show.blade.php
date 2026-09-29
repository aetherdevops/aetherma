@extends('layouts.public')

@section('title', $project->title.' — '.config('site.name'))
@section('description', $project->excerpt ?: Str::limit(strip_tags((string) $project->body), 155) ?: $project->title.' — a project by '.config('site.name').'.')
@section('og_type', 'article')
@if ($project->coverUrl())
    @section('og_image', $project->coverUrl())
@endif

@push('head')
    <script type="application/ld+json">{!! json_encode(array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'CreativeWork',
        'name' => $project->title,
        'description' => $project->excerpt,
        'image' => $project->coverUrl(),
        'url' => route('portfolio.show', $project),
        'dateCreated' => $project->completed_at?->toDateString(),
        'creator' => ['@id' => url('/').'#organization'],
        'sourceOrganization' => $project->client_name ? ['@type' => 'Organization', 'name' => $project->client_name] : null,
    ]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
@endpush

@section('content')
<article class="pt-28">
    <div class="container-narrow section-pad !pt-8 !pb-10">
        <a href="{{ route('home') }}#clients" class="text-sm font-semibold uppercase tracking-wide text-aether-accent hover:text-aether-primary">&larr; Back to portfolio</a>
        <h1 class="mt-6 text-4xl md:text-5xl">{{ $project->title }}</h1>
        <dl class="mt-4 flex flex-wrap gap-x-8 gap-y-2 text-sm text-aether-accent">
            @if ($project->client_name)
                <div class="flex gap-2"><dt class="font-semibold">Client</dt><dd>{{ $project->client_name }}</dd></div>
            @endif
            @if ($project->completed_at)
                <div class="flex gap-2"><dt class="font-semibold">Completed</dt><dd>{{ $project->completed_at->format('F Y') }}</dd></div>
            @endif
        </dl>
        @if ($project->excerpt)
            <p class="mt-5 max-w-2xl text-lg text-aether-accent">{{ $project->excerpt }}</p>
        @endif
    </div>

    @if ($project->coverUrl())
        <div class="container-narrow px-6 md:px-10 lg:px-16">
            <img src="{{ $project->coverUrl() }}" alt="{{ $project->title }} — project cover" fetchpriority="high" class="max-h-[560px] w-full rounded-2xl object-cover shadow-lg">
        </div>
    @endif

    @if ($project->body)
        <div class="container-narrow section-pad !pb-10">
            <div class="prose prose-aether mx-auto max-w-3xl">
                {!! \App\Support\RichText::sanitize($project->body) !!}
            </div>
        </div>
    @endif

    @if ($project->media->isNotEmpty())
        <section class="container-narrow px-6 pb-16 md:px-10 lg:px-16" aria-labelledby="gallery-title">
            <h2 id="gallery-title" class="text-2xl">Gallery</h2>
            <div class="mt-6 columns-1 gap-6 sm:columns-2 [&>*]:mb-6">
                @foreach ($project->media as $media)
                    <figure class="break-inside-avoid overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-aether-line/60">
                        @if ($media->isVideo())
                            <video src="{{ $media->url() }}" @if ($media->posterUrl()) poster="{{ $media->posterUrl() }}" @endif
                                   controls playsinline preload="none" class="w-full bg-aether-ink"></video>
                        @else
                            <a href="{{ $media->url() }}" target="_blank" rel="noopener" class="block">
                                <img src="{{ $media->url() }}" alt="{{ $media->caption ?: $project->title.' — gallery image '.$loop->iteration }}"
                                     loading="lazy" decoding="async" class="w-full">
                            </a>
                        @endif
                        @if ($media->caption)
                            <figcaption class="px-4 py-3 text-sm text-aether-accent">{{ $media->caption }}</figcaption>
                        @endif
                    </figure>
                @endforeach
            </div>
        </section>
    @endif

    <section class="bg-aether-mist">
        <div class="container-narrow section-pad !py-14 text-center">
            <h2 class="text-2xl md:text-3xl">Want results like these for your brand?</h2>
            <a href="{{ route('home') }}#contact" class="btn-primary mt-6">Let's talk</a>
        </div>
    </section>

    @if ($previous || $next)
        <nav class="border-t border-aether-line/60 bg-white" aria-label="More projects">
            <div class="container-narrow grid gap-4 px-6 py-8 sm:grid-cols-2 md:px-10 lg:px-16">
                <div>
                    @if ($previous)
                        <a href="{{ route('portfolio.show', $previous) }}" class="group block rounded-xl p-4 hover:bg-aether-mist">
                            <span class="text-xs font-semibold uppercase tracking-[0.18em] text-aether-accent">&larr; Previous project</span>
                            <span class="mt-1 block font-display text-xl font-bold text-aether-ink group-hover:text-aether-primary">{{ $previous->title }}</span>
                        </a>
                    @endif
                </div>
                <div class="sm:text-right">
                    @if ($next)
                        <a href="{{ route('portfolio.show', $next) }}" class="group block rounded-xl p-4 hover:bg-aether-mist">
                            <span class="text-xs font-semibold uppercase tracking-[0.18em] text-aether-accent">Next project &rarr;</span>
                            <span class="mt-1 block font-display text-xl font-bold text-aether-ink group-hover:text-aether-primary">{{ $next->title }}</span>
                        </a>
                    @endif
                </div>
            </div>
        </nav>
    @endif
</article>
@endsection
