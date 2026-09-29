@extends('layouts.admin')

@section('title', $testimonial->exists ? 'Edit testimonial' : 'Add testimonial')

@section('content')
<h1 class="font-display text-3xl font-bold text-aether-ink">{{ $testimonial->exists ? 'Edit testimonial' : 'Add testimonial' }}</h1>

<form method="POST"
      action="{{ $testimonial->exists ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}"
      class="mt-8 max-w-3xl space-y-5 rounded-xl bg-white p-6 shadow-sm">
    @csrf
    @if ($testimonial->exists)
        @method('PUT')
    @endif

    <div>
        <label class="mb-1 block text-sm font-semibold" for="quote">Quote</label>
        <textarea id="quote" name="quote" rows="4" required class="w-full rounded-md border-slate-300">{{ old('quote', $testimonial->quote) }}</textarea>
        @error('quote') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="grid gap-4 sm:grid-cols-3">
        <div>
            <label class="mb-1 block text-sm font-semibold" for="author_name">Name</label>
            <input id="author_name" name="author_name" value="{{ old('author_name', $testimonial->author_name) }}" required class="w-full rounded-md border-slate-300">
            @error('author_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="mb-1 block text-sm font-semibold" for="author_role">Role (optional)</label>
            <input id="author_role" name="author_role" value="{{ old('author_role', $testimonial->author_role) }}" class="w-full rounded-md border-slate-300">
        </div>
        <div>
            <label class="mb-1 block text-sm font-semibold" for="company">Company (optional)</label>
            <input id="company" name="company" value="{{ old('company', $testimonial->company) }}" class="w-full rounded-md border-slate-300">
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label class="mb-1 block text-sm font-semibold" for="sort_order">Sort order</label>
            <input id="sort_order" type="number" min="0" name="sort_order" value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}" class="w-full rounded-md border-slate-300">
        </div>
        <label class="flex items-center gap-2 self-end pb-2 text-sm">
            <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $testimonial->is_published))>
            Show on public site
        </label>
    </div>

    <div class="flex gap-3 pt-2">
        <button type="submit" class="btn-primary">{{ $testimonial->exists ? 'Save changes' : 'Add testimonial' }}</button>
        <a href="{{ route('admin.testimonials.index') }}" class="rounded-md px-4 py-3 text-sm text-slate-600 hover:bg-slate-100">Cancel</a>
    </div>
</form>
@endsection
