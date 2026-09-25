@extends('layouts.public')

@section('title', $project->title.' — Æther')
@section('description', $project->excerpt)

@section('content')
<article class="pt-28">
    <div class="container-narrow section-pad !pt-8">
        <a href="{{ route('home') }}#clients" class="text-sm font-semibold uppercase tracking-wide text-aether-accent hover:text-aether-primary">&larr; Back to portfolio</a>
        <h1 class="mt-6 text-4xl md:text-5xl">{{ $project->title }}</h1>
        @if ($project->client_name)
            <p class="mt-3 text-aether-accent">Client: {{ $project->client_name }}</p>
        @endif
        @if ($project->excerpt)
            <p class="mt-4 max-w-2xl text-lg text-aether-accent">{{ $project->excerpt }}</p>
        @endif
    </div>

    @if ($project->coverUrl())
        <div class="container-narrow px-6 md:px-10 lg:px-16">
            <img src="{{ $project->coverUrl() }}" alt="{{ $project->title }}" class="max-h-[520px] w-full rounded-2xl object-cover shadow-lg">
        </div>
    @endif

    <div class="container-narrow section-pad prose prose-aether max-w-3xl">
        {!! $project->body !!}
    </div>
</article>
@endsection
