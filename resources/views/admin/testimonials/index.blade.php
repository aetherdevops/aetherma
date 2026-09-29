@extends('layouts.admin')

@section('title', 'Testimonials')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-4">
    <div>
        <h1 class="font-display text-3xl font-bold text-aether-ink">Testimonials</h1>
        <p class="mt-1 text-sm text-slate-500">The homepage section appears once at least one testimonial is published.</p>
    </div>
    <a href="{{ route('admin.testimonials.create') }}" class="btn-primary">Add testimonial</a>
</div>

<div class="mt-8 space-y-4">
    @forelse ($testimonials as $testimonial)
        <div class="rounded-xl bg-white p-5 shadow-sm">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div class="min-w-0 flex-1">
                    <p class="text-slate-700">“{{ \Illuminate\Support\Str::limit($testimonial->quote, 200) }}”</p>
                    <p class="mt-2 text-sm font-semibold">{{ $testimonial->author_name }}
                        @if ($testimonial->attribution())<span class="font-normal text-slate-500"> — {{ $testimonial->attribution() }}</span>@endif
                    </p>
                </div>
                <div class="flex items-center gap-3 text-sm">
                    <span class="rounded-full px-2 py-0.5 text-xs {{ $testimonial->is_published ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                        {{ $testimonial->is_published ? 'Published' : 'Hidden' }}
                    </span>
                    <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="text-aether-primary hover:underline">Edit</a>
                    <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" onsubmit="return confirm('Delete this testimonial?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 hover:underline">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p class="text-slate-500">No testimonials yet. Ask a happy client for two or three sentences — it's the strongest trust signal on the site.</p>
    @endforelse
</div>

<div class="mt-6">{{ $testimonials->links() }}</div>
@endsection
